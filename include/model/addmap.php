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
// Creation Date : 30/11/2009
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

if (preg_match("/addmap.php/i", $_SERVER['PHP_SELF'])) {
      exit(0);
}

$lien = Tlink($param);

$Arianne = array(1 => array('titre' => 'Envoyer une Map',
			   				'lien'  => $lien.Plink($param,2,1,ADDMAP)),
				 2 => array('titre' => 'Soumettez ici une nouvelle map &agrave; nos mod&eacute;rateurs',
			   				'lien'  => ''));

$tpl->ConstructPage(1);

if($_SESSION['temp_upload'] == 1)
{
	// un upload c'est terminé
	$_SESSION['temp_upload'] = "";
	
	$tpl->GetTpl('addmap_val');
				
	$tpl->assign(array(
		'Titre' 		=> 'Envoi Terminé',
		'FilArianne' 	=> DisplayArianne($Arianne),
	));
}
else
{
	$id_apc = uniqid();
	
	$listing_games = $sbox->select_multi(array('table'=>'games','select'=>'*','order by'=>'position ASC','apc'=>'listing_games','apc_ttl'=>'3600'));
	
	foreach($listing_games as $game)
	{
		$ListeGame .= '<option value="'.$game['name'].'">'.$game['name_plus'].'</option>';
	}
				
	$tpl->GetTpl('addmap');
				
	$tpl->assign(array(
		'Titre' 		=> 'Envoyer une map',
		'FilArianne' 	=> DisplayArianne($Arianne),
		'ListeGame' 	=> $ListeGame,
		'ID_APC'		=> $id_apc,
		'Scripts' 		=> '<script type="text/javascript" src="'.$lien.'public/js/addmap.js"></script>{$Scripts}'
	));
}

$tpl->ConstructEndPage(1);

$hover1 = ""; $hover2 = ""; $hover3 = ""; $hover4 = ""; $hover5 = ""; $hover6 = " id=\"menuTopHover\"";


?>