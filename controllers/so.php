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

			print_r($data['datadiri']);
			print_r($data['dataproduk']);
			print_r($data['dataemail']);


			// //meregistrasikan email user
			// $username = str_replace("@", "-", $data['datadiri']->emailPrimer);
			// $password = random_string("alnum", 11);
			// $additional_data = array(
			// 						'first_name' => $data['datadiri']->namaDepan,
			// 						'last_name' => $data['datadiri']->namaBelakang,
			// 						'display_name' => $data['datadiri']->namaDepan.' '.$data['datadiri']->namaBelakang,
			// 						// tambahan field
			// 						'alamat' => $data['datadiri']->alamat,
			// 						'wilayah' => $data['datadiri']->wil,
			// 						'sekolah' => $data['datadiri']->sekolah,
			// 						'provinsi' => $data['datadiri']->provinsi,
			// 						'alamat_sekolah' => $data['datadiri']->alamatSekolah,
			// 						);
			// $userId = $this->ion_auth->register($username, $password, $data['datadiri']->emailPrimer, null, $additional_data, 'user');

			// // perhitungan harga

			// $produk = array();
			// $total = 0;

			// /* Logic untuk menghitung total biaya */
			// foreach ($data['dataproduk'] as $value) {
			// 		if($value->product_qty > 0){
			// 			$get_dataP = $this->order_m->get_product($value->product_id);
			// 			$produk[] = $value;
			// 			$tglSekarang = date('Y-m-d');
			// 			$tglPromo = date('Y-m-d', strtotime($get_dataP->deadline_promo));
			// 			$price = 0;

			// 			// cek jika tanggal sekarang apakah ada promo
			// 			if($tglSekarang <= $tglPromo){
			// 				// cek jika product typenya fisik maka harus ditambahkan biaya						
			// 					if($value->product_type == "fisik"){
			// 						$total += $value->product_qty * ($get_dataP->harga_promo + $data['datadiri']->wilayah);
			// 					}else{
			// 						$total += $value->product_qty * $get_dataP->harga_promo;
			// 					}
			// 			}
			// 			else{
			// 				// cek jika product typenya fisik maka harus ditambahkan biaya
			// 					if($value->product_type == "fisik"){
			// 						$total += $value->product_qty * ($get_dataP->harga + $data['datadiri']->wilayah);
			// 					}else{
			// 						$total += $value->product_qty * $get_dataP->harga;
			// 					}
			// 			}
			// 		}
			// }

			// // // menyusun data dr data yg telah dilempar dari ajax kedalam array order
			// $order = array(
			// 			'status' => "pending",
			// 			'alamat_kirim' => $data['datadiri']->alamat,
			// 			'user_id' => $userId,
			// 			'harga' => $total
			// 			);

			// $order_id = $this->streams->entries->insert_entry($order, 'order', 'streams');

			

			// foreach($data['dataemail'] as $email){
			// 		// daftarkan email pesanan produk menjadi user register
			// 		if($email != $data['datadiri']->emailPrimer){
			// 			$username = str_replace("@", "-", $email);
			// 			$password = random_string("alnum", 11);
			// 			$additional_data = array(
			// 									'display_name' => "Nama Anda",
			// 									'first_name' => "Nama",
			// 									'last_name' => "Anda"
			// 									);
			// 			$this->ion_auth->register($username, $password, $email, null, $additional_data, 'user');
			// 		}
			// 	}


			// foreach ($produk as $items){
			// 	$getdataproduct = $this->order_m->get_product($items->product_id);
			// 	$tglSekarang = date('Y-m-d');
			// 	$tglPromo = date('Y-m-d', strtotime($getdataproduct->deadline_promo));
			// 	$currentPrice = 0;

			// 		if($tglSekarang <= $tglPromo){
			// 			if($items->product_type == 'fisik'){
			// 				$currentPrice = $items->product_qty * ($getdataproduct->harga_promo + $data['datadiri']->wilayah);
			// 			}else{
			// 				$currentPrice = $items->product_qty * $getdataproduct->harga_promo;
			// 			}
			// 		}else{
			// 			if($items->product_type == 'fisik'){
			// 				$currentPrice = $items->product_qty * ($getdataproduct->harga + $data['datadiri']->wilayah) ;
			// 			}else{
			// 				$currentPrice = $items->product_qty * $getdataproduct->harga;
			// 			}
			// 		}

			// 		$subTotal = $currentPrice * $items->product_qty;

			// 		$orderProduk = array(
			// 						'order_id' => $order_id,
			// 						'produk_id' => $items->product_id,
			// 						'harga' => $currentPrice,
			// 						'qty' => $items->product_qty,
			// 						'sub_total' => $subTotal
			// 					);
			// 		$this->streams->entries->insert_entry($orderProduk, 'product_order', 'streams');
			// }

			// // print_r($userId);

			// // $dump($datadiri);
		}

	}
}