<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *
 * Pyro Simple Order Module
 *
 *
 *
 * @author          : Hendri Lubis
 * @package         : PyroCMS
 * @subpackage      : PyroSimpleOrder Module
 *
 *
**/


class Module_So extends Module
{
    public $version = '1.2';

    public function info()
    {
        return array(
            'name' => array(
                'en' => 'Simple Order'
            ),
            'description' => array(
                'en' => 'Just Simple Order'
            ),
            'frontend' => true,
            'backend' => true,
            'menu' => 'content',
            'sections' => array(
                'order_product' => array(
                    'name' => 'Product Order',
                    'uri' => 'admin/so',
                ),
                'order_to' => array(
                    'name' => 'Try Out Order',
                    'uri' => 'so/admin_orderto',
                ),
                'product' => array(
                    'name' => 'Product List',
                    'uri' => 'so/admin_product',
                    'shortcuts' => array(
                        'create' => array(
                            'name' => 'simple_order:new',
                            'uri' => 'so/admin_product/create',
                            'class' => 'add'
                            )
                        )
                )

            )
        );
    }

    /**
     * Install
     *
     * This function will set up our
     * FAQ/Category streams.
     */
    public function install()
    {
        
        return true;
    }

    /**
     * Uninstall
     *
     * Uninstall our module - this should tear down
     * all information associated with it.
     */
    public function uninstall()
    {
        // $this->load->driver('Streams');

        // For this teardown we are using the simple remove_namespace
        // utility in the Streams API Utilties driver.
        // $this->streams->utilities->remove_namespace('faq');

        return true;
    }

    public function upgrade($old_version)
    {

        return true;
    }

    public function help()
    {
        // Return a string containing help info
        // You could include a file and return it here.
        return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
    }

}