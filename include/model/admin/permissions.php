<?php

//********************************************************************************************
//********************************************************************************************
// Persmissions
// Administration du site.
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 03/09/2008
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
if (eregi("permissions.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

// Choix du type de la page (ici type par default)
$tpl->ConstructPage();

$tpl->GetTpl('admin/permissions');

$tpl->ConstructEndPage();

?>