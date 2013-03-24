<?php

//********************************************************************************************
//********************************************************************************************
// Config
// Configuration du site.
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

// Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (eregi("config.php", $_SERVER['PHP_SELF'])) {
      //exit(1);
      //exit(0404);
}

//********************************************************************************************
//********************************************************************************************

//************************** 
//   Paramètres généraux  //
//************************** 

/*** Salt coding password ***/
$code_passw_salt = "54sd654"; 

/*** Inscription avec vérification eMail ou non ***/ 
//0 => Pas de vérification, 1 => vérification
$site_registration_mail = 0;

/*** Durée d'une session ***/
$session_time = 3600; //en secondes

/*** Désactivation magic quote  ***/
//set_magic_quotes_runtime(0);

//************************** 
//       Class MYSQL      //
//************************** 

// switch rapide de mode pour l'affichage du debuger a supprimer en mode production
$_SESSION['conf_template']['mini'] 		= true;

$_SESSION['conf_javascript']['mini'] 	= false;
$_SESSION['conf_css']['mini'] 			= false;

$_SESSION['conf_sbox']['timer'] 		= true;
$_SESSION['conf_sbox']['debug'] 		= true; 
$_SESSION['conf_sbox']['debug_max'] 	= true;

// Cache APC OU XCACHE
$_SESSION['conf_sbox']['apc'] 			= false;
$_SESSION['conf_sbox']['xcache'] 		= true;

$_SESSION['conf_sbox']['exec_exit'] 	= true; // Default: true
$_SESSION['conf_sbox']['ip_only'] 		= true;

/*** IP AUTORISE SBOX ***/

$_SESSION['sbox_ip'][] = "88.185.208.14"; // Paco
$_SESSION['sbox_ip'][] = "89.2.24.207";   // Flousedid
//$_SESSION['sbox_ip'][] = "91.207.209.33"; // Supinfo

/*** Infos de connection ***/
$_SESSION['i_sbox'][0]['auto_connect'] 	= true;
$_SESSION['i_sbox'][0]['ip'] 		   	= "127.0.0.1";
$_SESSION['i_sbox'][0]['base'] 	 	   	= "progamemap";
$_SESSION['i_sbox'][0]['login'] 	   	= "progamemap";
$_SESSION['i_sbox'][0]['password'] 	   	= "";

/*** Infos avancées ***/
$_SESSION['i_sbox'][0]['pseudo'] 		= "Tbase";

/*** Infos sécurité ***/
$_SESSION['i_sbox'][0]['mode'] 			= "ssl";

/*** Infos de connection ***/
$_SESSION['i_sbox'][1]['auto_connect'] 	= true;
$_SESSION['i_sbox'][1]['ip'] 		   	= "127.0.0.1";
$_SESSION['i_sbox'][1]['base'] 	 	   	= "setup_pgm";
$_SESSION['i_sbox'][1]['login'] 	   	= "progamemap";
$_SESSION['i_sbox'][1]['password'] 	   	= "";


?>