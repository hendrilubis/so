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


class Module_So extends Module
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
                    'uri' => 'admin/so',
                ),
                'product' => array(
                    'name' => 'Product List',
                    'uri' => 'so/admin_product',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'simple_order:new',
                            'uri' => 'so/admin_product/create',
                            'class' => 'add'
                            )
                        )
                ),
                'area' => array(
                    'name' => 'Area',
                    'uri' => 'admin/so/area',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'simple_order:new_area',
                            'uri' => 'admin/so/area/create',
                            'class' => 'add'
                            )
                        )
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
        $namespace = 'product';
        // Create stream
        $extra = array('title_column' => 'product_code', 'view_options' => array("created_by","product_code","type","harga","harga_promo"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('product', 'product', $namespace, 'so_', 'stream untuk kumpulan produk', $extra) ) return FALSE; 

        // Get stream data
        $product = $this->streams->streams->get_stream('product', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'product');

        $fields[] = array('name'=>'Product Code', 'slug'=>'product_code', 'type'=>'text', 'required' => false, 'unique' => true, 'instructions' => '', 'extra'=>array("max_length"=>"", "default_value"=>""));
        $fields[] = array('name'=>'type', 'slug'=>'type', 'type'=>'choice', 'required' => true, 'unique' => false, 'instructions' => 'Pilih type product', 'extra'=>array("choice_data"=>"digital : Digital\nfisik : Fisik\ntryout  : Tryout", "choice_type"=>"dropdown", "default_value"=>"", "min_choices"=>"", "max_choices"=>""));
        $fields[] = array('name'=>'Harga', 'slug'=>'harga', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'Isi Harga Product', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'Harga Promo', 'slug'=>'harga_promo', 'type'=>'integer', 'required' => false, 'unique' => false, 'instructions' => 'Isi harga promo', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'Deadline Promo', 'slug'=>'deadline_promo', 'type'=>'datetime', 'required' => false, 'unique' => false, 'instructions' => '', 'extra'=>array("use_time"=>"yes", "start_date"=>"", "end_date"=>"", "storage"=>"datetime", "input_type"=>"datepicker"));
        $fields[] = array('name'=>'description', 'slug'=>'description', 'type'=>'textarea', 'required' => false, 'unique' => false, 'instructions' => '', 'extra'=>array("default_text"=>"", "allow_tags"=>"n", "content_type"=>"text"));
        $fields[] = array('name'=>'Harga Kolektif', 'slug'=>'harga_kolektif', 'type'=>'integer', 'required' => false, 'unique' => false, 'instructions' => '', 'extra'=>array("max_length"=>"20", "default_value"=>"0"));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);


        /* ORDER STREAM */
        $namespace = 'order';
        // Create stream
        $extra = array('title_column' => '', 'view_options' => array("created","status","harga"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('order', 'order', $namespace, 'so_', 'stream untuk pemesanan produk', $extra) ) return FALSE; 

        // Get stream data
        $order = $this->streams->streams->get_stream('order', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'order');

        $fields[] = array('name'=>'user', 'slug'=>'user_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => '', 'extra'=>array("choose_stream"=>"3", "link_uri"=>null));
        $fields[] = array('name'=>'status', 'slug'=>'status', 'type'=>'choice', 'required' => true, 'unique' => false, 'instructions' => 'Pilih Status Pengiriman Product', 'extra'=>array("choice_data"=>"pending : Belum Bayar\npaid : Sudah Bayar\nsent : Terkirim\ncancel : Batal", "choice_type"=>"dropdown", "default_value"=>"pending", "min_choices"=>"", "max_choices"=>""));
        $fields[] = array('name'=>'Alamat Kirim', 'slug'=>'alamat_kirim', 'type'=>'text', 'required' => false, 'unique' => false, 'instructions' => 'Isikan alamat untuk buku dikirimkan', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'Harga', 'slug'=>'harga', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'Total Harga', 'extra'=>array("max_length"=>"255", "default_value"=>""));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);


        /* PRODUCT ORDER STREAM ====================== */
        $namespace = 'product_order';
        // Create stream
        $extra = array('title_column' => '', 'view_options' => array("created","order_id","produk_id","harga","qty","sub_total"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('Product Order', 'product_order', $namespace, 'so_', 'Daftar produk yang dipesan di setiap order', $extra) ) return FALSE; 

        // Get stream data
        $product_order = $this->streams->streams->get_stream('product_order', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'product_order');

        $fields[] = array('name'=>'Order ID', 'slug'=>'order_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => '', 'extra'=>array("choose_stream"=>$order->id, "link_uri"=>null));
        $fields[] = array('name'=>'Produk Id', 'slug'=>'produk_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => '', 'extra'=>array("choose_stream"=>$product->id, "link_uri"=>null));
        $fields[] = array('name'=>'Harga', 'slug'=>'harga', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'Harga produk pada saat dipesan', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'Quantity', 'slug'=>'qty', 'type'=>'integer', 'required' => false, 'unique' => false, 'instructions' => '', 'extra'=>array("max_length"=>"", "default_value"=>"0"));
        $fields[] = array('name'=>'Sub Total', 'slug'=>'sub_total', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'harga produk saat dipesan dikali kuantiti', 'extra'=>array("max_length"=>"", "default_value"=>"0"));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);


        /* SHIPPING STREAM */
        $namespace = 'shipping';
        // Create stream
        $extra = array('title_column' => 'tujuan', 'view_options' => array("tujuan","harga"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('Shipping', 'shipping', $namespace, 'so_', 'shipping', $extra) ) return FALSE; 

        // Get stream data
        $shipping = $this->streams->streams->get_stream('shipping', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'shipping');

        $fields[] = array('name'=>'Kota Tujuan', 'slug'=>'tujuan', 'type'=>'text', 'required' => true, 'unique' => true, 'instructions' => 'Kota/area tujuan pengiriman', 'extra'=>array("max_length"=>"255", "default_value"=>""));
        $fields[] = array('name'=>'Harga', 'slug'=>'harga', 'type'=>'integer', 'required' => true, 'unique' => false, 'instructions' => 'Biaya tambahan pengiriman', 'extra'=>array("max_length"=>"255", "default_value"=>""));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);


        /* TRYOUT_ORDER STREAM */
        $namespace = 'to_order';
        // Create stream
        $extra = array('title_column' => 'produk_id', 'view_options' => array("created","produk_id","order_id","email","generated_key"), 'sorting' => 'title', 'menu_path' => '', 'is_hidden' => 'no');
        if( !$this->streams->streams->add_stream('TO Order', 'to_order', $namespace, 'so_', 'Stream yang menyimpan data order tryout untuk setiap pemesan paket try out. Satu baris untuk satu order try out', $extra) ) return FALSE; 

        // Get stream data
        $to_order = $this->streams->streams->get_stream('to_order', $namespace);

        // Add fields
        $fields   = array();
        $template = array('namespace' => $namespace, 'assign' => 'to_order');

        $fields[] = array('name'=>'User ID', 'slug'=>'user_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => '', 'extra'=>array("choose_stream"=>"3", "link_uri"=>null));
        $fields[] = array('name'=>'Produk ID', 'slug'=>'produk_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => 'Produk bertipe try out', 'extra'=>array("choose_stream"=>$product->id, "link_uri"=>null));
        $fields[] = array('name'=>'Order ID', 'slug'=>'order_id', 'type'=>'relationship', 'required' => true, 'unique' => false, 'instructions' => 'Id pesanan', 'extra'=>array("choose_stream"=>$order->id, "link_uri"=>null));
        $fields[] = array('name'=>'Email', 'slug'=>'email', 'type'=>'email', 'required' => true, 'unique' => true, 'instructions' => 'Email user yang memesan untuk nantinya diregistrasikan sebagai user setelah bayar pemesanan', 'extra'=>false);
        $fields[] = array('name'=>'Generated Key', 'slug'=>'generated_key', 'type'=>'text', 'required' => true, 'unique' => true, 'instructions' => 'Kode yang digenerate buat password user try out', 'extra'=>array("max_length"=>"20", "default_value"=>""));

        // Combine
        foreach ($fields AS &$field) { $field = array_merge($template, $field); }

        // Add fields to stream
        $this->streams->fields->add_fields($fields);
        
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
        $namespace = 'product';
        $this->streams->streams->delete_stream('product', $namespace);

        $this->streams->fields->delete_field('product_code', $namespace);
        $this->streams->fields->delete_field('type', $namespace);
        $this->streams->fields->delete_field('harga', $namespace);
        $this->streams->fields->delete_field('harga_promo', $namespace);
        $this->streams->fields->delete_field('deadline_promo', $namespace);
        $this->streams->fields->delete_field('description', $namespace);
        $this->streams->fields->delete_field('harga_kolektif', $namespace);

        // ORDER STREAM
        $namespace = 'order';
        $this->streams->streams->delete_stream('order', $namespace);

        $this->streams->fields->delete_field('user_id', $namespace);
        $this->streams->fields->delete_field('status', $namespace);
        $this->streams->fields->delete_field('alamat_kirim', $namespace);
        $this->streams->fields->delete_field('harga', $namespace);

        // PRODUCT ORDER STREAM
        $namespace = 'product_order';
        $this->streams->streams->delete_stream('product_order', $namespace);

        $this->streams->fields->delete_field('order_id', $namespace);
        $this->streams->fields->delete_field('produk_id', $namespace);
        $this->streams->fields->delete_field('harga', $namespace);
        $this->streams->fields->delete_field('qty', $namespace);
        $this->streams->fields->delete_field('sub_total', $namespace);

        // SHIPPING STREAM
        $namespace = 'shipping';
        $this->streams->streams->delete_stream('shipping', $namespace);

        $this->streams->fields->delete_field('tujuan', $namespace);
        $this->streams->fields->delete_field('harga', $namespace);

        // TRYOUT ORDER STREAM
        $namespace = 'to_order';
        $this->streams->streams->delete_stream('to_order', $namespace);

        $this->streams->fields->delete_field('user_id', $namespace);
        $this->streams->fields->delete_field('produk_id', $namespace);
        $this->streams->fields->delete_field('order_id', $namespace);
        $this->streams->fields->delete_field('email', $namespace);
        $this->streams->fields->delete_field('generated_key', $namespace);

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