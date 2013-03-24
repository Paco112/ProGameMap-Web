<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
$_SESSION['sbox_ajax'] = 1;

sbox_function::check_ajax(false);

$mail 		= trim($_POST['mail']);
$object 	= trim($_POST['object']);
$message 	= trim($_POST['message']);
$userIP 	= trim($_POST['userIP']);

function isEmail($email){
  	$pattern = '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
  	return (preg_match($pattern,$email)) ? true : false;
}

if(isEmail($mail) == false){
	$return .= "FalseMail|";
}

if(empty($mail)){
	$return .= "EmptyMail|";
}

if(empty($object)){
	$return .= "EmptyObject|";
}

if(empty($message)){
	$return .= "EmptyMsg|";
}

if(!empty($mail) && !empty($object) && !empty($message)){
	$ticketInfos   = array();
	$ticketInfos[] = array(
		'mail' 		=> $mail,
		'objet' 	=> $object,
		'message'	=> $message,
		'ip' 		=> $userIP,
		'time' 		=> time(),
	);
	
	$insert_ticket = $sbox->insert(array('table'=>'site_ticket','set'=>$ticketInfos));
	
	if($insert_ticket != false){
		$return = "InsertTrue";
	} else {
		$return = "InsertFalse";
	}
}

echo $return;

?>