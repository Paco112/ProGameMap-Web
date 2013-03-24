<?php

//********************************************************************************************
//********************************************************************************************
// Home
// Accueil du site.
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

/***************************************************************************/
/*                                Routines                                 */
/***************************************************************************/
 
// Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (preg_match("/codePassw.php/i", $_SERVER['PHP_SELF'])) {
      exit(0);
}

//********************************************************************************************
//********************************************************************************************

function codePassw($username, $cpass) 
{
	global $code_passw_salt;
	
	// 1 on compte le nbr de caractaire
	$nbr_username 		= strlen($username);
	$nbr_cpass  		= strlen($cpass);
	
	// valeur de pi
	$pi = pi();
	
	// 2 on créer une clé 1 sur le calcul suivant
	$key = ( $pi * ( $nbr_username * (53 * $nbr_cpass) ) + $nbr_username + ( 97 * $nbr_cpass ) );
	
	// 3 on créer une clé 2 sur le calcul suivant
	$key2 = ( ($key * $key * $nbr_cpass * $nbr_username) / $pi );
	
	// 4 on crypte tous en SHA1
	$username = sha1($username);
	$cpass 	= md5 ($cpass);
	$key 	= sha1($key);
	$key2 	= md5 ($key2);
	
	$crypt_pass = sha1(md5($username.$key.$code_passw_salt.$username.$key.$cpass.$key2));
	
	return $crypt_pass;
}

?>