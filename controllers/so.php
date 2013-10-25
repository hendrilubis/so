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
		// $this->template->append_js('module::jquery.steps.min.js');
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
		if('$_POST'){
			//Menangkap data yang dilempar oleh ajax
			$data['datadiri'] = json_decode($this->input->post('ddata'));
			$data['dataproduk'] = json_decode($this->input->post('pdata'));
			$data['dataemail'] = json_decode($this->input->post('edata'));

			// ambil data user id yang sedang login
			$userId = $this->current_user->id;
			// perhitungan harga

			$produk = array();
			$total = 0;

			/* Logic untuk menghitung total biaya */
			foreach ($data['dataproduk'] as $value) {
					if($value->product_qty > 0){
						$get_dataP = $this->order_m->get_product($value->product_id);
						$produk[] = $value;
						$tglSekarang = date('Y-m-d');
						$tglPromo = date('Y-m-d', strtotime($get_dataP->deadline_promo));
						$price = 0;

						// cek jika tanggal sekarang apakah ada promo
						if($tglSekarang <= $tglPromo){
							// cek jika product typenya fisik maka harus ditambahkan biaya						
								if($value->product_type == "fisik"){
									$total += $value->product_qty * ($get_dataP->harga_promo + $data['datadiri']->wilayah);
								}else{
									$total += $value->product_qty * $get_dataP->harga_promo;
								}
						}
						else{
							// cek jika product typenya fisik maka harus ditambahkan biaya
								if($value->product_type == "fisik"){
									$total += $value->product_qty * ($get_dataP->harga + $data['datadiri']->wilayah);
								}else{
									$total += $value->product_qty * $get_dataP->harga;
								}
						}
					}
			}

			// menyusun data dr data yg telah dilempar dari ajax kedalam array order
			$order = array(
						'status' => "pending",
						'alamat_kirim' => $data['datadiri']->alamat,
						'user_id' => $userId,
						'harga' => $total
						);

			$order_id = $this->streams->entries->insert_entry($order, 'order', 'streams');


			foreach ($produk as $items){
				$getdataproduct = $this->order_m->get_product($items->product_id);
				$tglSekarang = date('Y-m-d');
				$tglPromo = date('Y-m-d', strtotime($getdataproduct->deadline_promo));
				$currentPrice = 0;

					if($tglSekarang <= $tglPromo){
						$currentPrice = $getdataproduct->harga_promo;
					}else{
						$currentPrice = $getdataproduct->harga;
					}

					$subTotal = $currentPrice * $items->product_qty;


					$orderProduk = array(
									'row_id' => $order_id,
									'order_id' => 8,
									'product_id' => $items->product_id,
									'current_price' => $currentPrice,
									'qty' => $items->product_qty,
									'sub_total' => $subTotal
								);

					$this->order_m->insertOrderProduk($orderProduk);
			}
				
				foreach($data['dataemail'] as $email){
					// daftarkan email pesanan produk menjadi user register
					print_r($email); echo "hendri";
				}

			// print_r($userId);

			// $dump($datadiri);
		}

	}
}