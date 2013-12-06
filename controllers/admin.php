<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pyro Simple Order Controller
 * admin.php
 *
 * @author 		Hendri Lubis
 * @package 	PyroCMS
 * @subpackage 	PyroSimpleOrder Module
**/


class Admin extends Admin_Controller {
	protected $section = 'order_product';

	public function __construct() {
		parent::__construct();

        $this->lang->load('order');
		$this->load->driver('Streams');
		$this->load->helper('order');
		$this->load->helper('url');
		$this->load->model('order_m');
		$this->template->append_css('module::admin/products.css');
	}


	public function index() {
		$params = array(
				'stream'		=> 'order',
				'namespace'		=> 'streams',
				'paginate' 		=> 'yes',
				'limit'			=> 10,
				'page_segment' 	=> 4,
				'where' 		=> SITE_REF."_so_order.order_status = 'pending' "
				);
		$entries = $this->streams->entries->get_entries($params);

		$order['wilayah'] = $this->order_m->get_wilayah();

		$order['dataorder'] = $this->load->view('admin/order', array('entries'=>$entries), true);

		$this->template->build('admin/index', $order);
	}


	public function order() {
		$where = '';

		if($this->input->post('status')){
			$where .= SITE_REF."_so_order.order_status = '".$this->input->post('status')."' ";
		} 

		if($this->input->post('provinsi') != "all"){
			$where .= "AND ".SITE_REF."_so_order.province = '".$this->input->post('provinsi')."' ";
		}

		if($this->input->post('nama') && trim($this->input->post('nama')) != ''){
			$name = $this->order_m->search_name($this->input->post('nama'));
			if($name == '') $name = '0';
			$where .= "AND ".SITE_REF."_so_order.user_id IN (".$name.") ";
		}

		$params = array(
				'stream'		=> 'order',
				'namespace'		=> 'streams',
				'paginate' 		=> 'yes',
				'limit'			=> 10,
				'page_segment' 	=> 4,
				'where'			=> $where,

				);
		$entries = $this->streams->entries->get_entries($params);
		echo $order['dataorder'] = $this->load->view('admin/order', array('entries'=>$entries), true);

	}

	public function edit($id = 0) {

		$extra = array(
            'return' => 'admin/order',
            'success_message' => lang('simple_order:success_message'),
            'failure_message' => lang('simple_order:failure_message'),
            'title' => anchor('admin/order/edit/'.$id, 'Order').' &raquo; '.lang('simple_order:edit')
        );

        $skips = array();
        $hidden = array( 'user_id', 'order_total', 'product_id', 'shipping_address', 'province', 'phone');

        $order['form'] = $this->streams->cp->entry_form('order', 'streams', 'edit', $id, false, $extra, $skips, false, $hidden);

		$order['data'] = $this->streams->entries->get_entry($id, 'order', 'streams', true);

		$order['profile'] = $this->ion_auth->get_user($order['data']->user_id);

		$order['to_user'] = $this->db
								->join('so_product', 'so_product.id = so_to_order.product_id')
								->where('order_id', $id)
								->get('so_to_order')->result();

		$params = array(
				'stream' => 'product_order',
				'namespace' => 'streams',
				'where' => "order_id = $id"
			);
		$order['orderproduct'] = $this->streams->entries->get_entries($params);

		$this->template->build('admin/form_edit', $order);

	}

	function delete_order($order_id){
		// hapus data order
		$this->db->delete('so_order', array('id' => $order_id));

		// hapus data product ordernya
		$this->db->delete('so_product_order', array('order_id' => $order_id));

		// hapus data to order
		$this->db->delete('so_to_order', array('order_id' => $order_id));


		$this->session->set_flashdata('success', 'Data order berhasil dihapus.');
		redirect('admin/order');
	}

	// public function update($id, $update){
	// 	$entry_data = array(
 //        	'status'    => $update
 //   		);
		
	// 	$this->streams->entries->update_entry($id, $entry_data, 'order', 'streams');
	// 	redirect('admin/order');

	// }
}