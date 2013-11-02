<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pyro Simple Order Controller
 * admin.php
 *
 * @author 		Hendri Lubis
 * @package 	PyroCMS
 * @subpackage 	PyroSimpleOrder Module
**/


class Admin_settings extends Admin_Controller {

	protected $section = 'settings';

	public function __construct() {
		parent::__construct();

		$this->load->driver('Streams');
		$this->lang->load('order');
	}

	public function index()
    {
        $data['settings'] = $this->streams->entries->get_entry(1, 'order_settings', 'streams');

        $this->template
            ->build('admin/settings', $data);
    }
    
    public function edit()
	{
		$extra = array(
            'return' => 'admin/order/settings',
            'success_message' => lang('simple_order:success_create'),
            'failure_message' => lang('simple_order:failure_create'),
            'title' => lang('simple_order:edit_settings'),
         );

        $this->streams->cp->entry_form('order_settings', 'streams', 'edit', 1, true, $extra);
	}

}