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
						$idProduk = $value->product_id;
						$get_dataP = $this->order_m->get_product($idProduk);
						$produk[] = $value;
						$tglSekarang = date('Y-m-d');
						$tglPromo = date('Y-m-d', strtotime($get_dataP->deadline_promo));
						$price = 0;

						// cek jika tanggal sekarang apakah ada promo
						if($tglSekarang <= $tglPromo){
								if($value->product_type == "fisik"){
									$price = $get_dataP->harga_promo;
									$qty = $value->product_qty;
									$total += $qty * ($price + $data['datadiri']->wilayah);
								}
						}
						else{
							if($value->product_type == "fisik"){
									$price = $get_dataP->harga;
									$qty = $value->product_qty;
									$total += $qty * ($price + $data['datadiri']->wilayah);
								}
						}
						// cek jika product typenya fisik maka harus ditambahkan biaya						
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


			// foreach ($produk as $value){
			// 		$price = $value->
					
			// }

			$orderProduk = array(
								'row_id' => $order_id,
								'order_id' => 8,
								'product_id' => $idProduk,
								'current_price' => $price,
								'qty' => $qty,
								'sub_total' => $total
								);

			$this->order_m->insertOrderProduk($orderProduk);
			
			$tahik = $data['datadiri']->namaDepan;
				
				foreach($data['dataemail'] as $email){
					// daftarkan email pesanan produk menjadi user register
					print_r($email); echo "hendri";
				}

			// print_r($userId);

			// $dump($datadiri);
		}

	}
}