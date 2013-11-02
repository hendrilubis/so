<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Pyro Simple Order Module
 *
 *
 *
 * @author          : Hendri Lubis
 * @package         : PyroCMS
 * @subpackage      : PyroSimpleOrder Module
 *
 *
**/


class Module_Order extends Module
{
    public $version = '1.0.0';

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Simple Order'
            ),
            'description' => array(
                'en' => 'Just Simple Order'
            ),
            'frontend' => true,
            'backend' => true,
            // 'menu' => 'content',
            'sections' => array(
                'order_product' => array(
                    'name' => 'Product Order',
                    'uri' => 'admin/order',
                ),
                'product' => array(
                    'name' => 'Product List',
                    'uri' => 'admin/order/product',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'simple_order:new',
                            'uri' => 'admin/order/product/create',
                            'class' => 'add'
                            )
                        )
                ),
                'area' => array(
                    'name' => 'Area',
                    'uri' => 'admin/order/area',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'simple_order:new_area',
                            'uri' => 'admin/order/area/create',
                            'class' => 'add'
                            )
                        )
                ),
                'settings' => array(
                    'name' => 'Settings',
                    'uri' => 'admin/order/settings'
                )

            )
        );
    }

    /**
     * Install
     *
     * This function will set up our
     * FAQ/Category streams.
     */
    public function install()
    {
        $this->load->driver('Streams');

        /* PRODUCT STREAM =============================== */
        $namespace = 'streams';
        // Create stream
        $extra = array('title_column' => 'product_code', 'view_options' => array("created_by","product_code","product_type","price","promo_price","promo_deadline","collective_price"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('Product', 'product', $namespace, 'so_', 'stream untuk kumpulan produk', $extra) ) return FALSE; 

        // Get stream data
        $product = $this->streams->streams->get_stream('product', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'product');

        $fields[] = array('name'=>'Product Code', 'slug'=>'product_code', 'type'=>'text', 'required' => false, 'unique' => true, 'instructions' => '', 'extra'=>array("max_length"=>"", "default_value"=>""));
        $fields[] = array('name'=>'Product Type', 'slug'=>'product_type', 'type'=>'choice', 'required' => true, 'unique' => false, 'instructions' => 'Pilih type product', 'extra'=>array("choice_data"=>"digital : Digital\nfisik : Fisik\ntryout  : Tryout", "choice_type"=>"dropdown", "default_value"=>"", "min_choices"=>"", "max_choices"=>""));
        $fields[] = array('name'=>'Price', 'slug'=>'price', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'Isi Harga Product', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'Promo Price', 'slug'=>'promo_price', 'type'=>'integer', 'required' => false, 'unique' => false, 'instructions' => 'Isi harga promo', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'Promo Deadline', 'slug'=>'promo_deadline', 'type'=>'datetime', 'required' => false, 'unique' => false, 'instructions' => '', 'extra'=>array("use_time"=>"yes", "start_date"=>"", "end_date"=>"", "storage"=>"datetime", "input_type"=>"datepicker"));
        $fields[] = array('name'=>'description', 'slug'=>'description', 'type'=>'textarea', 'required' => false, 'unique' => false, 'instructions' => '', 'extra'=>array("default_text"=>"", "allow_tags"=>"n", "content_type"=>"text"));
        $fields[] = array('name'=>'Collective Price', 'slug'=>'collective_price', 'type'=>'integer', 'required' => false, 'unique' => false, 'instructions' => '', 'extra'=>array("max_length"=>"20", "default_value"=>"0"));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);


        /* ORDER STREAM */
        $namespace = 'streams';
        // Create stream
        $extra = array('title_column' => '', 'view_options' => array("product_code","product_type","price","promo_price","promo_deadline","collective_price"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('Order', 'order', $namespace, 'so_', 'stream untuk pemesanan produk', $extra) ) return FALSE; 

        // Get stream data
        $order = $this->streams->streams->get_stream('order', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'order');

        $fields[] = array('name'=>'User ID', 'slug'=>'user_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => '', 'extra'=>array("choose_stream"=>"3", "link_uri"=>null));
        $fields[] = array('name'=>'Order Status', 'slug'=>'order_status', 'type'=>'choice', 'required' => true, 'unique' => false, 'instructions' => 'Pilih Status Pengiriman Product', 'extra'=>array("choice_data"=>"pending : Belum Bayar\npaid : Sudah Bayar\nsent : Terkirim\ncancel : Batal", "choice_type"=>"dropdown", "default_value"=>"pending", "min_choices"=>"", "max_choices"=>""));
        $fields[] = array('name'=>'Shipping Address', 'slug'=>'shipping_address', 'type'=>'text', 'required' => false, 'unique' => false, 'instructions' => 'Isikan alamat untuk buku dikirimkan', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'No Telepon', 'slug'=>'phone', 'type'=>'text', 'required' => true, 'unique' => false, 'instructions' => 'Nomor telepon/hp yang dapat dihubungi', 'extra'=>array("max_length"=>"15", "default_value"=>"000"));
        $fields[] = array('name'=>'Province', 'slug'=>'province', 'type'=>'text', 'required' => false, 'unique' => false, 'instructions' => '', 'extra'=>array("max_length"=>"50", "default_value"=>""));
        $fields[] = array('name'=>'Order Total', 'slug'=>'order_total', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'Total Harga', 'extra'=>array("max_length"=>"255", "default_value"=>""));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);


        /* PRODUCT ORDER STREAM ====================== */
        $namespace = 'streams';
        // Create stream
        $extra = array('title_column' => '', 'view_options' => array("created","order_id","product_id","product_price","qty","sub_total"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('Product Order', 'product_order', $namespace, 'so_', 'Daftar produk yang dipesan di setiap order', $extra) ) return FALSE; 

        // Get stream data
        $product_order = $this->streams->streams->get_stream('product_order', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'product_order');

        $fields[] = array('name'=>'Order ID', 'slug'=>'order_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => '', 'extra'=>array("choose_stream"=>$order->id, "link_uri"=>null));
        $fields[] = array('name'=>'Product ID', 'slug'=>'product_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => '', 'extra'=>array("choose_stream"=>$product->id, "link_uri"=>null));
        $fields[] = array('name'=>'Product Price', 'slug'=>'product_price', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'Harga produk pada saat dipesan', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'Quantity', 'slug'=>'qty', 'type'=>'integer', 'required' => false, 'unique' => false, 'instructions' => '', 'extra'=>array("max_length"=>"", "default_value"=>"0"));
        $fields[] = array('name'=>'Sub Total', 'slug'=>'sub_total', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'harga produk saat dipesan dikali kuantiti', 'extra'=>array("max_length"=>"", "default_value"=>"0"));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);


        /* SHIPPING STREAM */
        $namespace = 'streams';
        // Create stream
        $extra = array('title_column' => 'tujuan', 'view_options' => array("destination","shipping_cost"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('Shipping', 'shipping', $namespace, 'so_', 'shipping', $extra) ) return FALSE; 

        // Get stream data
        $shipping = $this->streams->streams->get_stream('shipping', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'shipping');

        $fields[] = array('name'=>'Destination', 'slug'=>'destination', 'type'=>'text', 'required' => true, 'unique' => true, 'instructions' => 'Kota/area tujuan pengiriman', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'Shipping Cost', 'slug'=>'shipping_cost', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'Biaya tambahan pengiriman', 'extra'=>array("max_length"=>"255", "default_value"=>""));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);

        // insert sample area
        $message = array('destination' => 'Jabodetabek','shipping_cost' => 0);
        $this->streams->entries->insert_entry($message, 'shipping', 'streams');
        $message = array('destination' => 'Luar Jabodetabek','shipping_cost' => 10000);
        $this->streams->entries->insert_entry($message, 'shipping', 'streams');


        /* TRYOUT_ORDER STREAM */
        $namespace = 'streams';
        // Create stream
        $extra = array('title_column' => 'product_id', 'view_options' => array("created","product_id","order_id","user_email","generated_key"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('Tryout Order', 'to_order', $namespace, 'so_', 'Stream yang menyimpan data order tryout untuk setiap pemesan paket try out. Satu baris untuk satu order try out', $extra) ) return FALSE; 

        // Get stream data
        $to_order = $this->streams->streams->get_stream('to_order', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'to_order');

        // $fields[] = array('name'=>'Tryout User', 'slug'=>'user_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => '', 'extra'=>array("choose_stream"=>"3", "link_uri"=>null));
        // $fields[] = array('name'=>'Product ID', 'slug'=>'product_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => 'Produk bertipe try out', 'extra'=>array("choose_stream"=>$product->id, "link_uri"=>null));
        // $fields[] = array('name'=>'Order ID', 'slug'=>'order_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => 'Id pesanan', 'extra'=>array("choose_stream"=>$order->id, "link_uri"=>null));
        $fields[] = array('name'=>'User Email', 'slug'=>'user_email', 'type'=>'email', 'required' => true, 'unique' => true, 'instructions' => 'Email user yang memesan untuk nantinya diregistrasikan sebagai user setelah bayar pemesanan', 'extra'=>false);
        $fields[] = array('name'=>'Generated Key', 'slug'=>'generated_key', 'type'=>'text', 'required' => true, 'unique' => true, 'instructions' => 'Kode yang digenerate buat password user try out', 'extra'=>array("max_length"=>"20", "default_value"=>""));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);

        // assign available fields
        $this->streams->fields->assign_field($namespace, 'to_order', 'user_id', array('required' => true, 'unique' => false));
        $this->streams->fields->assign_field($namespace, 'to_order', 'product_id', array('required' => true, 'unique' => false, 'instructions' => 'Produk bertipe try out'));
        $this->streams->fields->assign_field($namespace, 'to_order', 'order_id', array('required' => true, 'unique' => false, 'instructions' => 'Id pesanan'));
        

        // ORDER MESSAGE STREAM
        $namespace = 'streams';
        // Create stream
        $extra = array('title_column' => '', 'view_options' => array("closing_message"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('Order Settings', 'order_settings', $namespace, 'so_', '', $extra) ) return FALSE; 

        // Get stream data
        $order_messages = $this->streams->streams->get_stream('order_settings', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'order_settings');

        $fields[] = array('name'=>'Bank', 'slug'=>'bank', 'type'=>'text', 'required' => true, 'unique' => false, 'instructions' => 'Bank tujuan transfer', 'extra'=>array("max_length"=>"20", "default_value"=>""));
        $fields[] = array('name'=>'No. Rekening', 'slug'=>'no_rekening', 'type'=>'text', 'required' => true, 'unique' => false, 'instructions' => 'Nomor rekening tujuan transfer', 'extra'=>array("max_length"=>"20", "default_value"=>""));
        $fields[] = array('name'=>'Pemilik Rekening', 'slug'=>'owner_rek', 'type'=>'text', 'required' => true, 'unique' => false, 'instructions' => '', 'extra'=>array("max_length"=>"30", "default_value"=>""));
        $fields[] = array('name'=>'Telepon Konfirmasi', 'slug'=>'telepon_konfirmasi', 'type'=>'text', 'required' => true, 'unique' => false, 'instructions' => 'Nomor telepon tujuan konfirmasi', 'extra'=>array("max_length"=>"15", "default_value"=>""));
        $fields[] = array('name'=>'Closing Message', 'slug'=>'closing_message', 'type'=>'wysiwyg', 'required' => true, 'unique' => false, 'instructions' => 'Pesan yang ditampilkan ketika proses pemesanan selesai', 'extra'=>array("editor_type"=>"advanced", "allow_tags"=>"y"));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);

        // insert default content
        $message = array(
            'bank' => 'Bank Mandiri',
            'no_rekening' => '126000 622 5006',
            'owner_rek' => 'Rizka Agustina',
            'telepon_konfirmasi' => '0896 672 454 64',
            'closing_message' => "<p>Terima kasih telah melakukan pemesanan.</p>\n<p>Silakan kirim sms ke <strong>[[ telepon_konfirmasi ]]</strong>, dengan format:</p>\n<blockquote>\n<p><strong>Daftar, [Nama], [SMA]</strong><br />\ncontoh: Daftar, Safitri, SMA 1 Pekanbaru</p>\n</blockquote>\n<p>Selanjutnya, silakan Anda mentransfer sejumlah <strong>[[ total ]]</strong>&nbsp;ke:<br />\n<b>[[ bank ]]</b><br />\nNo. rekening: <b>[[ no_rekening ]]</b><br />\na.n. <strong>[[ owner_rek ]]</strong></p>\n<p>Jika telah mentrasfer, konfirmasi dengan cara sms ke panitia ([[ telepon_konfirmasi ]]) dengan format:</p>\n<blockquote>\n<p><strong>Sudah transfer sejumlah....., ke Bank Mandiri, tgl transfer....., nama saya.....</strong><br />\ncontoh: sudah transfer sejumlah Rp50.321, ke bank Mandiri, tgl transfer 1 Oktober 2013, nama saya Dita Perdana.</p>\n</blockquote>\n<p>Selanjunya kami akan melakukan pengecekan apakah transfer Anda telah kami terima. Dalam waktu 1x24 jam, Anda akan mendapatkan sms konfirmasi dari panitia terkait transfer yang Anda lakukan. Jika transfer Anda sudah kami terima, buku akan kami kirimkan ke alamat Anda / password software akan kami kirimkan ke email Anda / tryout akan kami aktifkan sehingga Anda bisa mengerjakan pada waktu yang telah kami jadwalkan dengan menggunakan username dan password yang telah kami kirim. Informasi ini secara otomatis telah kami kirimkan ke alamat email Anda. Anda bisa melihat informasi ini kembali melalui email Anda.</p>");
        $this->streams->entries->insert_entry($message, 'order_settings', 'streams');

        // email template
        $email = array(
            array(
                'slug' => 'invoice-pemesanan',
                'name' => 'Invoice Pemesanan',
                'description' => 'Email yang dikirim kepada user setelah memesan produk',
                'subject' => '{{ settings:site_name }} - Invoice Pemesanan',
                'body' => "<p>Terima kasih telah melakukan pemesanan.<br />\nBerikut adalah daftar produk yang Anda pesan: ​</p>\n<table border=\"1\" style=\"width: 500px;\">\n<tbody>\n<tr>\n<th>Nama Produk</th>\n<th>Harga</th><th>Qty</th>\n<th>Subtotal</th>\n</tr>\n[[ produk ]]\n<tr>\n<td>[[ product_name ]]</td>\n<td>[[ product_price ]]</td>\n<td>[[ qty ]]</td>\n<td>[[ sub_total ]]</td>\n</tr>\n[[ /produk ]]\n<tr>\n<td colspan=\"3\">Total</td>\n<td>[[ total ]]</td>\n</tr>\n</tbody>\n</table>\n<p>Silakan kirim sms ke <strong>[[ telepon_konfirmasi ]]</strong>, dengan format:</p>\n<blockquote>\n<p><strong>Daftar, [Nama], [SMA]</strong><br />\ncontoh: Daftar, Safitri, SMA 1 Pekanbaru</p>\n</blockquote>\n<p>Selanjutnya, silakan Anda mentransfer sejumlah <strong>[[ total ]]</strong>&nbsp;ke:<br />\n<b>[[ bank ]]</b><br />\nNo. rekening: <b>[[ no_rekening ]]</b><br />\na.n. <strong>[[ owner_rek ]]</strong></p>\n<p>Jika telah mentrasfer, konfirmasi dengan cara sms ke panitia ([[ telepon_konfirmasi ]]) dengan format:</p>\n<blockquote>\n<p><strong>Sudah transfer sejumlah....., ke Bank Mandiri, tgl transfer....., nama saya.....</strong><br />\ncontoh: sudah transfer sejumlah Rp50.321, ke bank Mandiri, tgl transfer 1 Oktober 2013, nama saya Dita Perdana.</p>\n</blockquote>\n<p>Selanjunya kami akan melakukan pengecekan apakah transfer Anda telah kami terima. Dalam waktu 1x24 jam, Anda akan mendapatkan sms konfirmasi dari panitia terkait transfer yang Anda lakukan. Jika transfer Anda sudah kami terima, buku akan kami kirimkan ke alamat Anda / password software akan kami kirimkan ke email Anda / tryout akan kami aktifkan sehingga Anda bisa mengerjakan pada waktu yang telah kami jadwalkan dengan menggunakan username dan password yang telah kami kirim. Informasi ini secara otomatis telah kami kirimkan ke alamat email Anda. Anda bisa melihat informasi ini kembali melalui email Anda.</p>",
                'lang' => 'en',
                'is_default' => 0,
                'module' => 'order'
            )
        );
        
        $this->db->insert_batch('email_templates', $email);

        return true;
    }

    /**
     * Uninstall
     *
     * Uninstall our module - this should tear down
     * all information associated with it.
     */
    public function uninstall()
    {
        $this->load->driver('Streams');

        // PRODUCT STREAM
        $namespace = 'streams';
        $this->streams->streams->delete_stream('product', $namespace);

        $this->streams->fields->delete_field('product_code', $namespace);
        $this->streams->fields->delete_field('product_type', $namespace);
        $this->streams->fields->delete_field('price', $namespace);
        $this->streams->fields->delete_field('promo_price', $namespace);
        $this->streams->fields->delete_field('promo_deadline', $namespace);
        $this->streams->fields->delete_field('description', $namespace);
        $this->streams->fields->delete_field('collective_price', $namespace);

        // ORDER STREAM
        $namespace = 'streams';
        $this->streams->streams->delete_stream('order', $namespace);

        $this->streams->fields->delete_field('user_id', $namespace);
        $this->streams->fields->delete_field('order_status', $namespace);
        $this->streams->fields->delete_field('shipping_address', $namespace);
        $this->streams->fields->delete_field('phone', $namespace);
        $this->streams->fields->delete_field('province', $namespace);
        $this->streams->fields->delete_field('order_total', $namespace);

        // PRODUCT ORDER STREAM
        $namespace = 'streams';
        $this->streams->streams->delete_stream('product_order', $namespace);

        $this->streams->fields->delete_field('order_id', $namespace);
        $this->streams->fields->delete_field('product_id', $namespace);
        $this->streams->fields->delete_field('product_price', $namespace);
        $this->streams->fields->delete_field('qty', $namespace);
        $this->streams->fields->delete_field('sub_total', $namespace);

        // SHIPPING STREAM
        $namespace = 'streams';
        $this->streams->streams->delete_stream('shipping', $namespace);

        $this->streams->fields->delete_field('destination', $namespace);
        $this->streams->fields->delete_field('shipping_cost', $namespace);

        // TRYOUT ORDER STREAM
        $namespace = 'streams';
        $this->streams->streams->delete_stream('to_order', $namespace);

        $this->streams->fields->delete_field('user_email', $namespace);
        $this->streams->fields->delete_field('generated_key', $namespace);

        // ORDER MESSAGE STREAM
        $namespace = 'streams';

        $this->streams->streams->delete_stream('order_settings', $namespace);

        $this->streams->fields->delete_field('bank', $namespace);
        $this->streams->fields->delete_field('no_rekening', $namespace);
        $this->streams->fields->delete_field('owner_rek', $namespace);
        $this->streams->fields->delete_field('telepon_konfirmasi', $namespace);
        $this->streams->fields->delete_field('closing_message', $namespace);

        $this->db->delete('email_templates', array('module'=>'order'));

        return true;
    }

    public function upgrade($old_version)
    {

        return true;
    }

    public function help()
    {
        // Return a string containing help info
        // You could include a file and return it here.
        return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
    }

}