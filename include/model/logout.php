<?php
//********************************************************************************************
//********************************************************************************************
// Logout
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 11/09/2008
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
if (stristr("logout.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

/***************************************************************************/

$_SESSION['user'] = array();

//header('Location: http://progamemap.com/fr/');

?>
	