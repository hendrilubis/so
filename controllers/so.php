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
}