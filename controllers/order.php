<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pyro Simple Order Controller
 * admin.php
 *
 * @author 		Hendri Lubis
 * @package 	PyroCMS
 * @subpackage 	PyroSimpleOrder Module
**/


class Order extends Public_Controller {

	public function __construct() {
		parent::__construct();
		
		$this->template->append_css('module::jquery.stepy.css');
		$this->template->append_js('module::jquery.cookie-1.4.0.js');
		$this->template->append_js('module::jquery.validate.min.js');
		$this->template->append_js('module::jquery.stepy.js');

		$this->load->model('order_m');
		$this->load->helper('string');
		$this->load->helper('url');
	}


	public function index() {
				$params = array(
				'stream'		=> 'product',
				'namespace'		=> 'streams',
				'paginate' 		=> 'yes',
				'limit'			=> 10,
				'page_segment' 	=> 4
				);
		$entries = $this->streams->entries->get_entries($params);
		$entries['wilayah'] = $this->order_m->get_shipping();

		$this->template->build('index', $entries);
	}

	public function simpanPesan(){
		$this->load->library('email');
		if('$_POST'){
			//Menangkap data yang dilempar oleh ajax
			$data['datadiri'] = json_decode($this->input->post('ddata'));
			$data['dataproduk'] = json_decode($this->input->post('pdata'));
			$data['dataemail'] = json_decode($this->input->post('edata'));


			//meregistrasikan email user
			$username = str_replace("@", "-", $data['datadiri']->emailPrimer);
			$pwprimer = random_string("alnum", 11);
			$additional_data = array(
				'first_name' => $data['datadiri']->namaDepan,
				'last_name' => $data['datadiri']->namaBelakang,
				'display_name' => $data['datadiri']->namaDepan.' '.$data['datadiri']->namaBelakang,
									// tambahan field
				'alamat' => $data['datadiri']->alamat,
				'phone' => $data['datadiri']->telepon,
				'sekolah' => $data['datadiri']->sekolah,
				'provinsi' => $data['datadiri']->provinsi,
				'alamat_sekolah' => $data['datadiri']->alamatSekolah,
				'lang' => 'en'
			);

			// jika user belum terdaftar
			if(! $user = $this->ion_auth->get_user_by_email($data['datadiri']->emailPrimer)){
				$userId = $this->ion_auth->register($username, $pwprimer, $data['datadiri']->emailPrimer, null, $additional_data, 'user');

				// nonaktifkan dulu sampai si customer bayar
				$this->ion_auth->deactivate($userId);

			} else {
				$userId = $user->id;
				$this->ion_auth->update_user($userId, array('password'=>$pwprimer), $additional_data);
			}

			// perhitungan harga

			$produk = array();
			$emailed_produk = array();
			$total = 0;

			/* Logic untuk menghitung total biaya */
			foreach ($data['dataproduk'] as $value) {
				$subtotal = 0;

				// hitung yang dipesan saja
				if($value->product_qty > 0){
					$dataProduk = $this->order_m->get_product($value->product_id);
					$tglSekarang = date('Y-m-d');
					$tglPromo = date('Y-m-d', strtotime($dataProduk->promo_deadline));
					
					// cek apakah mesti pake harga kolektif, promo, atau harga biasa
					if($value->product_qty >= 5){ 
						$harga = $dataProduk->collective_price;
					}elseif($tglSekarang <= $tglPromo){
						$harga = $dataProduk->promo_price;
					}else{
						$harga = $dataProduk->price;
					}

					// cek jika product typenya fisik maka harus ditambahkan biaya						
					if($value->product_type == "fisik"){
						$harga += $data['datadiri']->wilayah;
					}

					$subtotal = $harga * $value->product_qty;					

					$produk[] = array(
						'product_name' => $value->product_name,
						'product_id' => $value->product_id,
						'product_price' => $harga,
						'qty' => $value->product_qty,
						'sub_total' => $subtotal
					);

					$total += $subtotal;
				}
			}

			// menyusun data dr data yg telah dilempar dari ajax kedalam array order
			$order = array(
				'order_status' => "pending",
				'shipping_address' => $data['datadiri']->alamat,
				'phone' => $data['datadiri']->telepon,
				'province' => $data['datadiri']->provinsi,
				'user_id' => $userId,
				'order_total' => $total + intval(substr($data['datadiri']->telepon, -3))
				);
			$order['order_id'] = $this->streams->entries->insert_entry($order, 'order', 'streams');

			$this->session->set_userdata('total', $order['order_total']);

			// sisipkan order_id di setiap daftar produk buat dimasukin ke tabel product_order
			$produk_order = array();
			foreach ($produk as $value) {
				$produk_order = $value + array('order_id' => $order['order_id']);
				unset($produk_order['product_name']);
				$this->streams->entries->insert_entry($produk_order, 'product_order', 'streams');
			}

			// ambil data order settings
			$settings = $this->streams->entries->get_entry(1, 'order_settings', 'streams');

			// // Kirim email invoice pemesanan
			// $sendemail['subject']    = $this->settings->site_name . ' - Invoice Pemesanan';
			// $sendemail['slug']       = 'invoice-pemesanan';
			// $sendemail['to']         = $data['datadiri']->emailPrimer;
			// $sendemail['from']       = $this->settings->server_email;
			// $sendemail['name']       = $this->settings->site_name;
			// $sendemail['reply-to']   = $this->settings->contact_email;
   //      	// Add in some extra details
			// $sendemail['address']	= $order['shipping_address'];
			// $sendemail['total']		= $order['order_total'];
			// $sendemail['produk'] 	= $emailed_produk;
			// $sendemail['bank']		= $settings->bank;
			// $sendemail['no_rekening'] = $settings->no_rekening;
			// $sendemail['owner_rek'] = $settings->owner_rek;
			// $sendemail['telepon_konfirmasi'] = $settings->telepon_konfirmasi;
   //      	// send the email using the template event found in system/cms/templates/
			// Events::trigger('email', $sendemail, 'array');


			foreach($data['dataemail'] as $email){

				if($email->email != $data['datadiri']->emailPrimer){

					$username = str_replace("@", "-", $email->email);
					$password = random_string("alnum", 11);

					// jika user belum terdaftar
					if(! $user = $this->ion_auth->get_user_by_email($email->email)){
						$additional = array(
						'display_name' => "Nama Anda",
						'first_name' => "Nama",
						'last_name' => "Anda",
						'lang' => 'en'
						);

						// daftarkan email pesanan produk menjadi user register
						$uid = $this->ion_auth->register($username, $password, $email->email, null, $additional, 'user');

						// nonaktifkan dulu sampai si customer bayar
						$this->ion_auth->deactivate($uid);

					} else {
						$uid = $user->id;
						$additional = array(
							'display_name' => $user->display_name,
							'first_name' => $user->first_name,
							'last_name' => $user->last_name,
							'lang' => $user->lang,
							'alamat' => $user->alamat,
							'phone' => $user->phone,
							'sekolah' => $user->sekolah,
							'provinsi' => $user->provinsi,
							'alamat_sekolah' => $user->alamat_sekolah,
						);
						$this->ion_auth->update_user($uid, array('password'=>$password), $additional);
					}


					$akun = array(
						'user_id' => $uid,
						'product_id' => $email->type,
						'order_id' => $order['order_id'],
						'user_email'=> $email->email,
						'generated_key' => $password
						);
					
				} else {
					$akun = array(
						'user_id' => $userId,
						'product_id' => $email->type,
						'order_id' => $order['order_id'],
						'user_email'=> $email->email,
						'generated_key' => $pwprimer
						);
				};
			
				// simpan data akun tryout di tabel to_order
				$this->streams->entries->insert_entry($akun, 'to_order', 'streams');
			}

			echo 'sukses';

		} else
			redirect('order');
	}

	function selesai(){
		$total = $this->session->userdata('total');
		// $total = 453346;
		if($total){
			$messages = $this->streams->entries->get_entry(1, 'order_settings', 'streams');
			$order = array(
				'bank' => $messages->bank,
				'no_rekening' => $messages->no_rekening,
				'owner_rek' => $messages->owner_rek,
				'telepon_konfirmasi' => $messages->telepon_konfirmasi,
				'total' => $this->settings->currency.' '.number_format($total, 2, ",",".")
				);
			$message = str_replace(array("[[","]]"), array("{{", "}}"), $messages->closing_message);

			$this->session->unset_userdata('total');
			$this->template
			->set('closing_message', $this->parser->parse_string($message, $order, true))
			->build('selesai');

		} else
		redirect('order');
	}
}