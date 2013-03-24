<?php

//********************************************************************************************
//********************************************************************************************
// ROUTER
// Gère le template et les langue en fonction des param url
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 15/06/2009
// Modification Date :
// -------------------------------------------------------------------------------------------
// Historique
// 1.0 - Paco112 : Creation
//
//********************************************************************************************
//********************************************************************************************  


/**
 * Fonction de décryptage et de traitement de l'url
 **/

$param = getURL();
$param_name = getURL_name($param);

/**
 * Fonction de gestion de l'authentification
 **/
$auth = authController($_SESSION['user']);
$auth['SETUP']['show'] = 'true';
/**
 * Recupère les paramètre sous form de nom comme $_GET ( inversse key et value dans $param )
 **/


/**
 * Gestion des fichiers langues.
 * En fonction du premier paraèmtre (fr, en), on attribue un fichier langue.
 **/
switch($param[1])
{
	default:
		$param[1] = 'fr';
        include_once("include/language/".$param[1]."/default.php");
		break;
	case 'en':
		$param[1] = 'en';
        include_once("include/language/".$param[1]."/default.php");
		break;
}

/**
 * Partie Routage
 * Include de la page concerné en fonction du deuxieme parametre de l'url.
 * Si le paramètre est inconnu, on renvoie vers l'accueil du site.
 **/
switch($param[2])
{
	/**
	 * Page par défault : l'index !
	 **/
	default:
	
		if($auth['INDEX']['show'] == 'true'){
			include_once("include/model/home.php");
		} else {
			include_once("include/model/401.php");
		}
		
		break;
	
	/**
	 * Partie compte, gestion de son compte, création de compte.
	 **/
	case ACCOUNT:
	
		if($auth['ACCOUNT']['show'] == 'true'){
			if($param[3] == NEW2) $Mode = 'new';
			include_once("include/model/account.php");
		} else {
			include_once("include/model/401.php");
		}
		
		break;
	
	/**
	 * Visualisation des maps disponible, couplé au logiciel
	 **/
	case SETUP:
	
		if($auth['SETUP']['show'] == 'true'){
			include_once("include/model/setup.php");
		} else {
			include_once("include/model/401.php");
		}
		
		break;
	
	/**
	 * Pannel admin
	 **/
	case ADMIN:
	
		if($auth['ADMIN']['show'] == 'true'){
			include_once("include/model/admin/admin.php");
		} else {
			include_once("include/model/401.php");
		}
		
		break;
	
	/**
	 * Gestion de son profil, affichage du profil d'un autre utilisateur
	 **/
	case PROFIL:
	
		if($auth['PROFIL']['show'] == 'true'){
			include_once("include/model/profil.php");
		} else {
			include_once("include/model/401.php");
		}
		
		break;
		
	/**
	 * Forum
	 **/
	case FORUM:
	echo 1;
		include_once("include/model/forum.php");
		
		break;
		
}

/**
 * Permet la création de chemin d'accès valide aux ressources
 **/
$lien = Tlink($param);
$tpl -> assign(array('Tlink' => $lien));

?>
