<?php

//********************************************************************************************
//********************************************************************************************
// addmap.php
// Ajout de maps.
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 27/01/2009
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
if (preg_match("/contact.php/i", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

$lien = Tlink($param);

$Arianne = array(1 => array('titre' => 'Contact',
			   				'lien'  => $lien.Plink($param,2,1,CONTACT)),
				 2 => array('titre' => 'Formulaire de mise en relation avec l\'&eacute;quipe',
			   				'lien'  => ''));

$tpl->ConstructPage(1);

$script_contact = "<script type='text/javascript' src='".$lien."public/js/contact.js'></script>\n";
			
$tpl->GetTpl('contact');
			
$tpl->assign(array(
	'Titre' => 'Contact',
	'FilArianne' => DisplayArianne($Arianne),
	'Scripts'	=> $script_contact.'{$Scripts}',
	'userMail' => $_SESSION['user']['email'],
	'userIP' => $_SERVER["REMOTE_ADDR"],
	'linkForm' => $lien.Plink($param,2,1,CONTACT),
));

$tpl->ConstructEndPage(1);

$hover1 = ""; $hover2 = ""; $hover3 = ""; $hover4 = ""; $hover5 = " id=\"menuTopHover\""; $hover6 = "";


?>