<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
$_SESSION['sbox_ajax'] = 1;

sbox_function::check_ajax(false);
	
$mode = $_POST['mode'];

if($mode == 'logout'){
	$_SESSION['user'] = array();
	$_SESSION['Panier'] = array();
	$_SESSION['favoris'] = array();
	$_SESSION['Panier_Count'] = array();
	$_SESSION['log_votes'] = array();
	$_SESSION['temp_setup'] = array();
	$_SESSION['logout'] = true;
	
	if($_POST['lo'] != ""){
		$return = "LogoutForumOK";
	} else {
		$return = "LogoutOK";
	}
} else {

	if( $_SESSION['user']['username'] == ""){

		$_SESSION['user'] = array();
		
		$input = $_POST['input'];
		$name  = $_POST['name'];
		$pass  = $_POST['pass'];
		$remember_me = $_POST['remember_me'];
		
		if ( $input == 'log-submit' ){
			$input = 'log-username;log-password';
			$onSubmit = 1;
		}
		
		if ( eregi('log-username', $input) ){
			if($name == ""){
				$return .= "UsernameEmpty;";
			} else {
				$return .= "UsernameOk;";
			}
		}
		
		if ( eregi('log-password', $input) ){
			if($pass == ""){
				$return .= "PassEmpty;";
			} else {
				$return .= "PassOk;";
			}
		}
		
		if ( $onSubmit == 1 && $return == "UsernameOk;PassOk;" )
		{
			include($_SERVER['DOCUMENT_ROOT']."/include/function/login.php");
			$return = login($name,$pass);
		}
	} else {
		$return = 'LoginOk';
	}
}

echo $return;

?>