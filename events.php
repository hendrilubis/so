<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Sample Events Class
*
* @package PyroCMS
* @subpackage Sample Module
* @category events
* @author PyroCMS Dev Team
*/
class Events_so{

	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
		// register the public_controller event when this file is autoloaded
		Events::register('streams_post_update_entry', array($this, 'run'));
	}

		// this will be triggered by the Events::trigger('public_controller') code in Public_Controller.php
	public function run($data)
	{
		// $data = array(
		// 	['entry_id'][]
		// 	['streams']->
		// 	['entry_data'][]
		// );
	
		// if($data['streams']->stream_slug == 'order'){
		// 	if($data['entry_data']['view_options']->product_id == ){
		// 		if($data['entry_data']['status'] == 'paid'){
		// 			$this->ci->load->driver('Streams');
		// 			dump($data);
		// 		}
		// 	}
		// }
					// if($data){

					// }
// cek dulu si user order produk to ga
				// kalau ternyata order, dicek lagi ngambil paket yang mana
// mengambil paket yang id produknya yg sama dengan update ini. pake get_entries paket berdasarkan id produk yg dipesan
				// (loop) simpan paket 3 paket to ke to_user


		// 		$params = array(

		// 		);
		// 		$this->ci->streams->entries->insert_entry($params, 'to_user', $data['streams']->stream_namespace);
		// 	}
		// }
	}
}
/* End of file events.php */	