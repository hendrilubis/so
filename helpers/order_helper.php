<?php

function get_user_email($uid){
	$ci = &get_instance();
	$u = $ci->db->select('email')
			->from('users')
			->where('id', $uid)
			->get()->row();

	if($u)
		return $u->email;

	return false;
}