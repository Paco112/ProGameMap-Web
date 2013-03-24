<?php
//ob_start("ob_gzhandler");
//********************************************************************************************
//********************************************************************************************
// Index
// Page principale du site.
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 07/07/2008
// Modification Date :
// -------------------------------------------------------------------------------------------
// Historique
// 1.0 - Flousedid : Creation
//
//********************************************************************************************
//********************************************************************************************

/*** Gestion Erreur 404 ( ANTI BOUCLE index.php ) ***/
/*
if(preg_match("/\./",$_SERVER['REQUEST_URI']) && !preg_match("/\.(php|exe)/",$_SERVER['REQUEST_URI']))
{
	exit();
}
*/

/*** Gestion securité, mysql et timer ***/
include_once("include/class/sbox.php");

if($_SESSION['user']['username'] != "" && $_COOKIE['ProGameMap'] == "")
{
	setcookie('ProGameMap', $_SESSION['user']['username'].'_'.sha1($_SESSION['user']['username'].$_SESSION['user']['password']), (time() + 31536000));
}
elseif($_SESSION['logout'] == true)
{
	setcookie('ProGameMap','',1);
}

/*** Gestion template ***/
require('include/class/template.php');

//********************************************************************************************
//********************************************************************************************

/*** Création du template ***/
$tpl = new Template();

/*** Fichier contenant les includes de toutes les sous fonctions du site ***/
require('include.php');

/**
 * Fonction de décryptage et de traitement de l'url
 **/
$param = getURL();
/*
if( (count($param) > 0) && ($param[count($param)] == "false") )
{
	//print_r("Param&egrave;tres incorrectes");
	//exit();
}
else
{
	*/
	$param_name = getURL_name($param);
	
	/**
	 * Permet la création de chemin d'accès valide aux ressources
	 **/
	$lien = Tlink($param);
	
	/**
	 * Fonction de Login
	 **/
	login();
	
	/**
	 * Fonction de gestion de l'authentification
	 **/
	authController();
		
	/**
	 * Partie Routage
	 * Include de la page concerné en fonction du deuxieme parametre de l'url.
	 * Si le paramètre est inconnu, on renvoie vers l'accueil du site.
	 **/
	
	$SCRIPT .= "<script type='text/javascript' src='".$lien."public/js/arianne.js'></script>\n";
	 
	switch($param[2])
	{
		/**
		 * Page par défault : l'index !
		 **/
		default:
		
			if($_SESSION['user']['permPage']['INDEX']['show'] == 'true'){
				include_once("include/model/home.php");
			} else {
				include_once("include/model/401.php");
			}
			$SCRIPT .= "<script type=\"text/javascript\" src=\"".$lien."public/js/pub.js\"></script>\n";
			break;
		
		/**
		 * Partie compte, gestion de son compte, création de compte.
		 **/
		case ACCOUNT:
		
			if($_SESSION['user']['permPage']['ACCOUNT']['show'] == 'true' || $_SESSION['user']['permPage']['ACCOUNTNEW']['show'] == 'true'){
				include_once("include/model/account.php");
			} else {
				include_once("include/model/401.php");
			}
			
			break;
		
		/**
		 * Visualisation des maps disponible, couplé au logiciel
		 **/
		case SETUP:
		
			if($_SESSION['user']['permPage']['SETUP']['show'] == 'true'){
				include_once("include/model/setup.php");
			} else {
				include_once("include/model/401.php");
			}
			
			break;
		
		/**
		 * Pannel admin
		 **/
		case ADMIN:
		
			if($_SESSION['user']['permPage']['ADMIN']['show'] == 'true'){
				include_once("include/model/admin/admin.php");
			} else {
				include_once("include/model/401.php");
			}
			
			break;
		
		/**
		 * Gestion de son profil, affichage du profil d'un autre utilisateur
		 **/
		case PROFIL:
		case COMMUNITY:
		
			if($_SESSION['user']['permPage']['PROFIL']['show'] == 'true'){
				include_once("include/model/profil.php");
				$CSS = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$lien."public/css/profil.css\" />\n";
			} else {
				include_once("include/model/401.php");
			}
			
			break;
			
		/**
		 * Matches
		 **/
		case MATCHS:
		
			if($_SESSION['user']['permPage']['MATCHS']['show'] == 'true'){
				include_once("include/model/matchs.php");
			} else {
				include_once("include/model/401.php");
			}
			
			break;
			
		/**
		 * Ajout de maps
		 **/
		case ADDMAP:
		
			if($_SESSION['user']['permPage']['ADDMAP']['show'] == 'true'){
				include_once("include/model/addmap.php");
			} else {
				include_once("include/model/401.php");
			}
			$SCRIPT .= "<script type=\"text/javascript\" src=\"".$lien."public/js/pub.js\"></script>\n";
			break;
			
		/**
		 * Hebergement
		 **/
		case HOSTING:
		
			if($_SESSION['user']['permPage']['HOSTING']['show'] == 'true' || $_SESSION['user']['permPage']['HOSTINGORDER']['show'] == 'true'){
				include_once("include/model/hosting.php");				
				$CSS  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$lien."public/css/hosting.css\" />\n";
			} else {
				include_once("include/model/401.php");
			}
			
			break;
			
		/**
		 * Contact
		 **/
		case CONTACT:
		
			if($_SESSION['user']['permPage']['CONTACT']['show'] == 'true'){
				include_once("include/model/contact.php");				
			} else {
				include_once("include/model/401.php");
			}
			$SCRIPT .= "<script type=\"text/javascript\" src=\"".$lien."public/js/pub.js\"></script>\n";
			break;

		/**
		 * Ajout de maps
		 **/
		case "mypack":
		
			if($_SESSION['user']['permPage']['MYPACK']['show'] == 'true'){
				include_once("include/model/mypack.php");
			} else {
				include_once("include/model/401.php");
			}
			
			break;
	}
	
	/**
	 * Menu Membre
	 */
	if( $_SESSION['user']['username'] != ""){
		// Si utilisateur connecté
		$loginLink  = ucfirst(WELCOME).' <strong><a href="'.$lien.$_SESSION['LANGUE'].'/'.PROFIL.'/'.USER.'/'.$_SESSION['user']['dname'].'/">'.$_SESSION['user']['dname'].'</a></strong> ! - ';
		$loginLink .= '<a href="'.$lien.Plink($param,2,1,ACCOUNT).GESTION.'/">'.ucfirst(MY).' '.ACCOUNT.'</a> - ';
		$loginLink .= '<input type="hidden" id="alreadyLog" /><a href="#" id="logoutLink">'.ucfirst(LOGOUT).'</a>';
		$SCRIPT .= "<script type=\"text/javascript\" src=\"".$lien."public/js/logout.js\"></script>\n";
		$firstVisite = "";
	} else {
		// Si visiteurs non loggé
		$loginLink  = '<input type="hidden" id="notLog" name="notLog" /><a href="'.$lien.Plink($param,2,1,ACCOUNT).NEW2.'/">'.ucfirst(CREATE_ACCOUNT).'</a> - ';
		$loginLink .= '<a href="#" id="loginLinkBox">Connexion</a>';
		$CSS .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$lien."public/css/login.css\" />\n";
		$SCRIPT .= "<script type=\"text/javascript\" src=\"".$lien."public/js/login.js\"></script>\n";
 		if($_SESSION['user']['firstVisite'] != 1){
			$firstVisite = '0';
		} else {
			$firstVisite = '1';
			$_SESSION['user']['firstVisite'] = 1;
		}
	}
					
	/**
	 * MENU TOP
	 */
	$menu_top = '<li><a href="http://www.progamemap.com/"{$hover1}>'.ucfirst(HOME).'</a></li>'
          	  . '<li><a href="'.$lien.Plink($param,2,1,SETUP).'"{$hover2}>'.ucfirst(SETUP).'</a></li>'
          	  . '<li><a href="'.$lien.Plink($param,1,1,FORUM).'"{$hover3}>'.ucfirst(FORUM).'</a></li>'
              . '<li><a href="'.$lien.Plink($param,2,1,COMMUNITY).'"{$hover4}>'.ucfirst(COMMUNITY2).'</a></li>'
              . '<li><a href="'.$lien.Plink($param,2,1,CONTACT).'"{$hover5}>'.ucfirst(CONTACT).'</a></li>';
			  //. '<li><a href="'.$lien.Plink($param,2,1,HOSTING).'"{$hover4}>'.ucfirst(HOSTING2).'</a></li>'
              //. '<li><a href="#">Contact</a></li>';
			  
	if( $_SESSION['user']['username'] != ""){
		$menu_top .= '<li><a href="'.$lien.Plink($param,2,1,ADDMAP).'"{$hover6}>'.ucfirst(ADDMAP2).'</a></li>';
	}
	
	// Browser detection
	/*$SCRIPT .= "<script type='text/javascript' src='".$lien."public/js/browser.js'></script>";*/
	$SCRIPT .= "<script type='text/javascript' src='".$lien."public/js/msgbox.js'></script>\n";
	$CSS .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$lien."public/css/box.css\" />\n";
		
	// Affichage du message d'incompatibiliter du navigateur
	if($_SESSION['checkNav'] == "")
	{
		include_once("include/function/checkNav.php");
		$_SESSION['checkNav'] = checkNav();
		if($_SESSION['checkNav'] != "MSIE 8" && $_SESSION['checkNav'] != "Firefox" && $_SESSION['checkNav'] != "Safari")
		{
			$SCRIPT .= "<script type='text/javascript'>window.addEvent('domready',function() { MsgBox('Navigateur Incompatible !','Pour une meilleur exp&eacute;rience, veuillez utiliser les navigateurs : Firefox (recommand&eacute;) ou Internet Explorer 8');});</script>\n";
		}
	}
	
	/**
	 * BLOGBANG PUB
	 */
	 
	 $file_b = "http://www.blogbang.com/d.php?id=43d06fe6f9";
	 
	 $SCRIPT .= "<script type='text/javascript'>window.onload = function() {"
				. "var e=document.createElement('SCRIPT');"
				. "e.src=\"".$file_b."\";"
				. "e.setAttribute('type', 'text/javascript');"
				. "document.getElementById('advertContainer').appendChild(e);"
				. "}</script>";
	
	
	if($_SESSION['URL_OK'])
	{
		$secu_ajax = sbox_function::secu_ajax();
	}
			 
	$tpl -> assign(array(
		'CSS'			=> $CSS.'{$CSS}',
		'Scripts'		=> $SCRIPT.'{$Scripts}',
		'Tlink' 		=> $lien, 
		'MenuTop'		=> $menu_top,
		'Secu_Ajax' 	=> $secu_ajax,
		'PUB' 			=> Pub(468,60),
		'loginLink'  	=> $loginLink,
		'Name'		 	=> $_SESSION['user']['dname'],
		'hover1'		=> $hover1,
		'hover2'		=> $hover2,
		'hover3'		=> $hover3,
		'hover4'		=> $hover4,
		'hover5'		=> $hover5,
		'hover6'		=> $hover6,
		'changeFr'		=> $lien.Plink($param,1,0,'fr'),
		'changeEn'		=> $lien.Plink($param,1,0,'en'),
	));
	
	/*** Génère la page ***/
	$tpl->view();
		
//}

$sbox->destruct();
?>