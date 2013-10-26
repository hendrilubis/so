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

		Events::register('streams_post_update_entry', array($this, 'update'));
	}

	public function update($data)
	{	
		// untuk update stream order
		if($data['stream']->stream_slug == 'order'){

			// kalo order sudah dibayar
			if($data['update_data']['status'] == 'paid'){

				// ambil produk trryout apa saja yang dipesan
				$this->ci->db->load->model('order_m');
				$tos = $this->ci->order_m->getOrderProduct($data['entry_id'], array('type'=>'tryout'));

				// tambah row di stream to_user
				$to = array(
					'user_id' => $data['update_data']['user_id'],
					'status_pengerjaan' => 'belum',
					'nilai' => 0,
					'paket_id'
				);
			}
		}
// 				if($data['entry_data']['status'] == 'paid'){
// 					$this->ci->load->driver('Streams');
// 					dump($data);
// 				}
// 			}
// 		}
// 				us	if($data){

// 					}
// cek dulu si user order produk to ga
// 				kalau ternyata order, dicek lagi ngambil paket yang mana
// mengambil paket yang id produknya yg sama dengan update ini. pake get_entries paket berdasarkan id produk yg dipesan
// 				(loop) simpan paket 3 paket to ke to_user


// 				$params = array(

// 				);
// 				$this->ci->streams->entries->insert_entry($params, 'to_user', $data['streams']->stream_namespace);
// 			}
// 		}
	}
}
/* End of file events.php */	