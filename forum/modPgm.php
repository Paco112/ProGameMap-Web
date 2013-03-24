<?php

if($_SESSION['user']['dname'] == ""){
	$user->session_kill();
	if (!preg_match("/Firefox/",$_SERVER['HTTP_USER_AGENT'])){
		$loginLink = '<input type="hidden" id="notLog" name="notLog" /><a href="../../compte/nouveau/">Cr&eacute;er un compte</a> - <a href="http://www.progamemap.com/forum/ucp.php?mode=login">Connexion</a>';
	} else {
		$loginLink = '<input type="hidden" id="notLog" name="notLog" /><a href="../../compte/nouveau/">Cr&eacute;er un compte</a> - <a href="" id="loginLinkBox">Connexion</a>';
		$logjs = 'login.js';
	}
	$upload = "";
} else {
	if($_SESSION['user']['group']['principal'] == "1"){
		$result = $user->session_create($_SESSION['user']['uid'], true);
		print_r($_SESSION);
	} else {
		$result = $user->session_create($_SESSION['user']['uid']);
	}
	$loginLink = 'Bienvenue <strong><a href="../profil/user/'.$_SESSION['user']['dname'].'/">'.$_SESSION['user']['dname'].'</a></strong> ! - <a href="../compte/gestion/">Mon compte</a> - <a href="" id="logoutLink">D&eacute;connexion</a>';
	$logjs = 'logout.js';
	$upload = '<li><a href="http://www.progamemap.com/ajoutermap/">Upload</a></li>';
}

$template->assign_vars(array(
	'SAAA'			=> sbox_function::secu_ajax(),
	'LOGIN_LINKK'	=> $loginLink,
	'LOGJS'			=> $logjs,
	'UPLOAD'		=> $upload
));

?>