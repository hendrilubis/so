<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pyro Simple Order Controller
 * admin.php
 *
 * @author 		Hendri Lubis
 * @package 	PyroCMS
 * @subpackage 	PyroSimpleOrder Module
**/

class Admin_product extends Admin_Controller{
	// This will set the active section product
	protected $section = 'product';

	public function __construct(){
		parent::__construct();

        $this->lang->load('order');
		$this->load->driver('Streams');
		$this->template->append_css('module::admin/products.css');

	}

	public function index(){

        $extra = array();

        $extra['title'] = lang('simple_order:product_list');
        
        // We can customize the buttons that appear
        // for each row. They point to our own functions
        // elsewhere in this controller. -entry_id- will
        // be replaced by the entry id of the row.
        $extra['buttons'] = array(
            array(
                'label' => lang('global:edit'),
                'url' => 'admin/order/product/edit/-entry_id-'
            ),
            array(
                'label' => lang('global:delete'),
                'url' => 'admin/order/product/delete/-entry_id-',
                'confirm' => true
            )
        );

        // In this example, we are setting the 5th parameter to true. This
        // signals the function to use the template library to build the page
        // so we don't have to. If we had that set to false, the function
        // would return a string with just the form.
        $this->streams->cp->entries_table('product', 'streams', 10, 'admin/order/product/index', true, $extra);
    }

    public function create(){

    	$extra = array(
            'return' => 'admin/order/product/index',
            'success_message' => lang('simple_order:success_create'),
            'failure_message' => lang('simple_order:failure_create'),
            'title' => lang('simple_order:new'),
         );



        $this->streams->cp->entry_form('product', 'streams', 'new', null, true, $extra);

    }

    public function edit($id = 0){

    	 $extra = array(
            'return' => 'admin/order/product/index/',
            'success_message' => lang('simple_order:success_message'),
            'failure_message' => lang('simple_order:failure_message'),
            'title' => lang('simple_order:product_edit')
        );

        $this->streams->cp->entry_form('product', 'streams', 'edit', $id, true, $extra);
    }

    public function delete($id = 0){
        $this->streams->entries->delete_entry($id, 'product', 'streams');
        $this->session->set_flashdata('success', lang('simple_order:product_delete'));
 
        redirect('admin/order/product/index');
    }

}