<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 *
 *
 * @author 		Hendri Lubis
 * @package 	PyroCMS
 * @subpackage 	SimpleOrder
 */

class Order_m extends My_Model{

	public function __construct(){
		parent::__construct();
	}

	public function get_paket(){

		$data = $this->db->distinct()->select('id, judul')->get('to_paket')->result();
			$paket = array();
				foreach ($data as $value) {
					$paket[$value->id] = $value->judul;
				}
				
			return $paket;

	}

		public function get_shipping(){

		$data = $this->db->distinct()->select('id, tujuan, harga')->get('so_shipping')->result();
			$wilayah = array();
				foreach ($data as $value) {
					$wilayah[$value->harga] = $value->tujuan;
				}
				
			return $wilayah;

	}



	public function getOrderProduct($id_order){

		return $this->db->select('so_order_product.*')
						->select('so_product.*')
						->from('so_order_product')
						->join('so_product', 'so_order_product.product_id = so_product.id')
						->where('so_order_product.row_id', $id_order)
						->get()->result();
	}
}