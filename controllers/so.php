<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pyro Simple Order Controller
 * admin.php
 *
 * @author 		Hendri Lubis
 * @package 	PyroCMS
 * @subpackage 	PyroSimpleOrder Module
**/


class So extends Public_Controller {

	public function __construct() {
		parent::__construct();
		$this->template->append_css('module::jquery.steps.css');
		$this->template->append_js('module::kampret.js');
		$this->template->append_js('module::jquery.cookie-1.4.0.js');
		$this->load->model('order_m');
		$this->load->helper('string');
		$this->load->helper('url');
		// $this->template->append_js('module::jquery.steps.min.js');
	}


	public function index() {
				$params = array(
				'stream'		=> 'product',
				'namespace'		=> 'product',
				'paginate' 		=> 'yes',
				'limit'			=> 10,
				'page_segment' 	=> 4
				);
		$entries = $this->streams->entries->get_entries($params);
		$entries['wilayah'] = $this->order_m->get_shipping();

		$this->template->build('index', $entries);
	}

	public function simpanPesan(){
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
									'sekolah' => $data['datadiri']->sekolah,
									'provinsi' => $data['datadiri']->provinsi,
									'alamat_sekolah' => $data['datadiri']->alamatSekolah,
									);
			$userId = $this->ion_auth->register($username, $pwprimer, $data['datadiri']->emailPrimer, null, $additional_data, 'user');

			// nonaktifkan dulu sampai si customer bayar
			$this->ion_auth->deactivate($userId);

			// perhitungan harga

			$produk = array();
			$total = 0;

			/* Logic untuk menghitung total biaya */
			foreach ($data['dataproduk'] as $value) {
				$subtotal = 0;

				// hitung yang dipesan saja
				if($value->product_qty > 0){
					$dataProduk = $this->order_m->get_product($value->product_id);
					$tglSekarang = date('Y-m-d');
					$tglPromo = date('Y-m-d', strtotime($dataProduk->deadline_promo));
					
					// cek apakah mesti pake harga kolektif, promo, atau harga biasa
					if($value->product_qty > 5){ 
						$harga = $dataProduk->harga_kolektif;
					}elseif($tglSekarang <= $tglPromo){
						$harga = $dataProduk->harga_promo;
					}else{
						$harga = $dataProduk->harga;
					}

					// cek jika product typenya fisik maka harus ditambahkan biaya						
					if($value->product_type == "fisik"){
						$harga += $data['datadiri']->wilayah;
					}

					$subtotal = $harga * $value->product_qty;					

					$produk[] = array(
						'produk_id' => $value->product_id,
						'harga' => $harga,
						'qty' => $value->product_qty,
						'sub_total' => $subtotal
						);

					$total += $subtotal;
				}
			}

			// menyusun data dr data yg telah dilempar dari ajax kedalam array order
			$order = array(
				'status' => "pending",
				'alamat_kirim' => $data['datadiri']->alamat,
				'user_id' => $userId,
				'harga' => $total
				);
			$order_id = $this->streams->entries->insert_entry($order, 'order', 'order');

			// sisipkan order_id di setiap daftar produk buat dimasukin ke tabel product_order
			$produk_order = array();
			foreach ($produk as $value) {
				$produk_order = $value + array('order_id' => $order_id);
				$this->streams->entries->insert_entry($produk_order, 'product_order', 'product_order');
			}

			print_r($produk_order);

			foreach($data['dataemail'] as $email){

				if($email->email != $data['datadiri']->emailPrimer){
					// daftarkan email pesanan produk menjadi user register
					$username = str_replace("@", "-", $email->email);
					$password = random_string("alnum", 11);
					$additional_data = array(
						'display_name' => "Nama Anda",
						'first_name' => "Nama",
						'last_name' => "Anda"
						);
					$uid = $this->ion_auth->register($username, $password, $email->email, null, $additional_data, 'user');

					// nonaktifkan dulu sampai si customer bayar
					$this->ion_auth->deactivate($uid);

					$akun = array(
						'user_id' => $uid,
						'produk_id' => $email->type,
						'order_id' => $order_id,
						'email'=> $email->email,
						'generated_key' => $password
						);
					
				} else {
					$akun = array(
						'user_id' => $userId,
						'produk_id' => $email->type,
						'order_id' => $order_id,
						'email'=> $email->email,
						'generated_key' => $pwprimer
						);
				};
			
				// simpan data akun tryout di tabel to_order
				$this->streams->entries->insert_entry($akun, 'to_order', 'to_order');
			}
			// echo site_url();
			echo 'sukses';
		}

	}
}