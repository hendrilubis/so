<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Sample Events Class
*
* @package PyroCMS
* @subpackage Sample Module
* @category events
* @author PyroCMS Dev Team
*/
class Events_Order{

	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();

		Events::register('streams_post_update_entry', array($this, 'update'));
	}

	public function update($data)
	{	
		// untuk update stream order
		if($data['stream']->stream_slug == 'order')
		{
			// kalo order sudah dibayar
			if($data['update_data']['order_status'] == 'paid')
			{
				$this->ci->load->driver('Streams');
				$this->ci->load->model('order_m');
				
				// ambil produk tryout apa saja yang dipesan
				$params = array(
						'stream' => 'to_order',
						'namespace' => 'streams',
						'where' => "order_id = {$data['entry_id']}"
						);
				$to_order = $this->ci->streams->entries->get_entries($params);
				// dump($to_order);

				if($to_order['total'] > 0)
				{
					$pernah_aktif = true;
					foreach ($to_order['entries'] as $order)
					{
						// aktivasi user tryout, #sukses
						$this->ci->ion_auth->activate($order['user_id']['id']);

						// ambil paket_id untuk setiap produk try out
						$paket = $this->ci->order_m->get_paket_id($order['product_id']['id']);

						// lalu simpan data ke tabel to_user #belumsukses
						foreach ($paket as $pkt)
						{
							if(! $this->ci->order_m->cek_to_user($pkt->id, $order['user_id']['id']))
							{	
								$to = array(
									'user_id' => $order['user_id']['id'],
									'status_pengerjaan' => 'belum',
									'nilai' => 0,
									'paket_id' => $pkt->id
									);
								$skips = array('jam_mulai', 'jam_selesai');
								$this->ci->streams->entries->insert_entry($to, 'to_user', 'streams', $skips);
								$pernah_aktif = false;
							}
						}
					}

					// kalo baru diaktifkan pertama kali
					if(! $pernah_aktif){
						$this->ci->load->library('email');

						// // Kirim email invoice pemesanan
						$sendemail['subject']    = $this->ci->settings->site_name . ' - Aktivasi Tryout';
						$sendemail['slug']       = 'aktivasi-tryout';
						$sendemail['to']         = $to_order['entries'][0]['user_email']['email_address'];
						$sendemail['from']       = $this->ci->settings->server_email;
						$sendemail['name']       = $this->ci->settings->site_name;
						$sendemail['reply-to']   = $this->ci->settings->contact_email;
        				// Add in some extra details
						$sendemail['generated_key']	= $to_order['entries'][0]['generated_key'];
        				// send the email using the template event found in system/cms/templates/
						Events::trigger('email', $sendemail, 'array');
					}
				}
			}
		}

	}
}
/* End of file events.php */	