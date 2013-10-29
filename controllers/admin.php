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
				'namespace'		=> 'order',
				'paginate' 		=> 'yes',
				'limit'			=> 10,
				'page_segment' 	=> 4
				);
		$entries = $this->streams->entries->get_entries($params);

		$order['dataorder'] = $this->load->view('admin/order', array('entries'=>$entries), true);

		$this->template->build('admin/index', $order);
	}


	public function order() {

		$where = '';

		if($this->input->post('status')){
			$where .= SITE_REF."_so_order.status= '".$this->input->post('status')."' ";
		}

		$params = array(
				'stream'		=> 'order',
				'namespace'		=> 'order',
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
            'return' => 'admin/so',
            'success_message' => lang('simple_order:success_message'),
            'failure_message' => lang('simple_order:failure_message'),
            'title' => anchor('admin/so/edit/'.$id, 'Order').' &raquo; '.lang('simple_order:edit')
        );

        $skips = array();
        $hidden = array( 'user_id', 'harga', 'product_id', 'alamat_kirim');

        $order['form'] = $this->streams->cp->entry_form('order', 'order', 'edit', $id, false, $extra, $skips, false, $hidden);

		$order['data'] = $this->streams->entries->get_entry($id, 'order', 'order', true);

		$order['profile'] = $this->ion_auth->get_user($order['data']->user_id);

		$params = array(
				'stream' => 'product_order',
				'namespace' => 'product_order',
				'where' => "order_id = $id"
			);
		$order['orderproduct'] = $this->streams->entries->get_entries($params);

		$this->template->build('admin/form_edit', $order);

	}

	// public function update($id, $update){
	// 	$entry_data = array(
 //        	'status'    => $update
 //   		);
		
	// 	$this->streams->entries->update_entry($id, $entry_data, 'order', 'streams');
	// 	redirect('admin/so');

	// }
}