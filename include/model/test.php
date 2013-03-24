<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox_ajax.php");

$SelectUser = $sbox->select_multi(array('table'=>'site_users','select'=>'*','where'=>'displayname=/test/'));

foreach($SelectUser as $user){
	echo $user['passw'];
}

?>