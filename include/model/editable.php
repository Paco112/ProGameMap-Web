<?php
//********************************************************************************************
//********************************************************************************************
// SETUP PANIER
// Gère le panier de selection des maps
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 29/07/2009
// Modification Date :
// -------------------------------------------------------------------------------------------
// Historique
//
// 1.0 - Paco112 : Creation
//
//********************************************************************************************
//********************************************************************************************
session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
$_SESSION['sbox_ajax'] = 1;

sbox_function::check_ajax();

$id   = $_POST['id'];
$name = $_POST['name'];
$url  = $_POST['url'];

if($name != ""){
	if($url != ""){
		
		$Infos   = array();
		$Infos = array('id'   => $id,
						 'name' => $name,
						 'url'  => $url);
		
		$getPage = $sbox->update(array('table'=>'site_sitemap','set'=>$Infos,'where'=>'id=/'.$id.'/'));
	}
}
		
?>
