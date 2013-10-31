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

	public function get_wilayah(){

		$data = $this->db->distinct()->select('id, tujuan')->get('so_shipping')->result();
		$wilayah = array();
		foreach ($data as $value) {
			$wilayah[$value->id] = $value->tujuan;
		}
		
		return $wilayah;

	}

	public function get_shipping(){

		$data = $this->db->distinct()->select('id, destination, shipping_cost')->get('so_shipping')->result();
			$wilayah = array();
				foreach ($data as $value) {
					$wilayah[$value->shipping_cost] = $value->destination;
				}
				
			return $wilayah;

	}

	public function get_product($id_product){

		return $this->db->select('price, promo_deadline, promo_price, collective_price')
						->from('so_product')
						->where('id', $id_product)
						->get()->row();

	}

	public function getOrderProduct($id_order, $where = array()){

		$this->db->select('so_order_product.*')
				->select('so_product.*')
				->from('so_order_product')
				->join('so_product', 'so_order_product.product_id = so_product.id')
				->where('so_order_product.row_id', $id_order);
		
		if(!empty($where))
			$this->db->where($where);

		return $this->db->get()->result();
	}

	public function insertOrderProduk($order){

		if(is_array($order) && !empty($order)) {
            $this->db->insert('so_product_order',$order);
        }

	}

	function get_paket_id($product_id)
	{
		return $paket = $this->db->select('id')
				->from('to_paket')
				->where('produk_id', $product_id)
				->get()->result();
	}
}