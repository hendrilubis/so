<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pyro Simple Order Controller
 * admin.php
 *
 * @author 		Hendri Lubis
 * @package 	PyroCMS
 * @subpackage 	PyroSimpleOrder Module
**/


class Admin_area extends Admin_Controller {

	protected $section = 'area';

	public function __construct() {
		parent::__construct();

		$this->load->driver('Streams');
		$this->lang->load('order');
	}

	public function index()
	{
		$extra = array();
        $extra['title'] = 'Shipping Area';
        $extra['buttons'] = array(
            array(
                'label' => lang('global:edit'),
                'url' => 'admin/order/area/edit/-entry_id-'
            ),
            array(
                'label' => lang('global:delete'),
                'url' => 'admin/order/area/delete/-entry_id-',
                'confirm' => true
            )
            
        );
        $this->streams->cp->entries_table('shipping', 'streams', 5, 'admin/order/area', true, $extra);
	}

	public function create()
	{
		$extra = array(
            'return' => 'admin/order/area',
            'success_message' => lang('simple_order:success_create'),
            'failure_message' => lang('simple_order:failure_create'),
            'title' => lang('simple_order:new_area'),
         );

        $this->streams->cp->entry_form('shipping', 'streams', 'new', null, true, $extra);
	}

	public function edit($id = 0)
    {
        $extra = array(
            'return' => 'admin/order/area',
            'success_message' => lang('simple_order:success_create'),
            'failure_message' => lang('simple_order:failure_create'),
            'title' => 'lang:simple_order:edit_area',
         );

        $this->streams->cp->entry_form('shipping', 'streams', 'edit', $id, true, $extra);
    }

    public function delete($id = false)
    {
    	$this->streams->entries->delete_entry($id, 'shipping', 'streams');
    	$this->session->set_flashdata('success', lang('simple_order:delete_success'));
    	redirect('admin/order/area');
    }

}