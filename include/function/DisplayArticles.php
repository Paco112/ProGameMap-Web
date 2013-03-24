<?php

//********************************************************************************************
//********************************************************************************************
// DisplayArticles
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 09/07/2008
// Modification Date :
// -------------------------------------------------------------------------------------------
// Historique
// 1.0 - Flousedid : Creation
//
//********************************************************************************************
//********************************************************************************************

// Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (stristr("DisplayArticles.php", $_SERVER['PHP_SELF'])) {
      include($_SERVER['DOCUMENT_ROOT']."error.php");
	  die();
}

//********************************************************************************************
//********************************************************************************************


/**
 * Secu
 *
 * @param  $Fil 
 * @return $DisplayFil
 */
function DisplayArticles($Titre, $Message, $Auteur, $Date)
{

	$tpl->file('DisplayArticles.tpl');
	
	$tpl->assign(array(
		'TitleArticles'  => $Titre,
		'DateArticles' 	 => $Date,
		'ContentText' 	 => $Message,
		'AuteurArticles' => $Auteur
	));
	
}

?>