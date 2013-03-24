<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox_ajax.php");

/*** add user 
 $UserInfos   = array();
 $UserInfos[] = array(
	'uid' 				=> '10',
	'username' 			=> 'test',
	'displayname' 		=> 'test',
	'passw' 			=> 'test',
	'email' 			=> 'test',
	'registration_date' => 'test',
	'registration_time' => 'test',
	'registration_ip' 	=> 'test',
	'valid_email' 		=> 'test',
	'activation_string' => 'test',
	'authlevel' 		=> '0',
	'newsletter' 		=> '0');

 $insert_user = $sbox->insert(array('table'=>'site_users','set'=>$UserInfos));***/
 
 
 $LastID = $sbox->select(array('table'=>'site_users','select'=>'*','order by'=>'uid ASC'));
	 $UserID = $LastID['uid'] + 1;
 
	 echo $UserID;
	 
?>