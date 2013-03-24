<?php
//********************************************************************************************
//********************************************************************************************
// MYPACK
// Affichage public des packs
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 1/06/2009
// Modification Date :
// -------------------------------------------------------------------------------------------
// Historique
//
// 1.0 - Paco112 : Creation
//
//********************************************************************************************
//********************************************************************************************

// taille des vignettes maps
$width_vignette = 100;
$height_vignette = 70;


$tpl->ConstructPage();

// Tlink pour images
$lien = Tlink($param);

$Arianne = array(1 => array('titre' => 'Bienvenue sur ProGameMap',
			   				'lien'  => ''));

$game = strtoupper($param[3]);
$game_bd = $game;
if($game == "MOHSH")
{
	$game_bd = "MOHAA";
}

$auteur = $param[4];
$pack_name = str_replace('_',' ',$param[5]);

// on recupère l'uid du pseudo de l'url
$info_auteur = $sbox->select(array('table'=>'site_users','select'=>'uid','where'=>'displayname=/'.$auteur.'/'));

// on commence par verrifier l'existance du pack
$pack = $sbox->select(array('table'=>'packs_'.strtolower($game),'select'=>'*','where'=>'name=/'.$pack_name.'/ AND uid=/'.$info_auteur->uid.'/ AND type=/PUBLIC/'));

if($pack)
{
	$id_pack = $pack->id;
	$note_val = $pack->note_val;
	$note_nb = $pack->note_nb;
	$stats_dl = $pack->stats_dl;
		
	// formatage de la date en fonction de la langue
	$datetime = date_create($pack->date);

	if($_SESSION['LANGUE'] == 'fr')
	{
		$date = date_format($datetime, 'd/m/Y');
	}
	else
	{
		$date = date_format($datetime, 'Y/m/j');
	}
	
	// création des etoiles de notation de ce pack
	
	if($note_nb > 0)
	{
		$note = round(($note_val / $note_nb));
	}
	else
	{
		$note = 0;
	}
	
	// on recupere le log des votes
	if( (count($_SESSION['log_votes'][$game]['pack']) == 0) && ($_SESSION['user']['uid'] != "") )
	{
		$liste_votes = $sbox->select_multi(array('table'=>'log_votes','select'=>'id_pack,note','where'=>'uid=/'.$_SESSION['user']['uid'].'/ AND game=/'.$game.'/'));
		if($liste_votes)
		{
			foreach($liste_votes as $vote)
			{
				$_SESSION['log_votes'][$game]['pack'][$vote['id_pack']] = $vote['note'];
			}
		}
	}
	
	if($_SESSION['log_votes'][$game]['pack'][$id_pack] != "")
	{
		$no_vote = "1";
	}
	else
	{
		$no_vote = "0";
	}
					
	$etoile = '<input id="NOVOTE_'.$id_pack.'" name="NOVOTE_'.$id_pack.'" type="hidden" value="'.$no_vote.'" />'
			  . '<input id="VAL_'.$id_pack.'" name="VAL_'.$id_pack.'" type="hidden" value="'.$note_val.'" />'
			  . '<input id="NB_'.$id_pack.'" name="NB_'.$id_pack.'" type="hidden" value="'.$note_nb.'" />'
			  . '<div id="G_'.$id_pack.'" name="G_'.$id_pack.'" class="g_etoile">';
							
	for($ii=1;$ii<=5;$ii++)
	{
		if($ii <= $note)
		{
			$etoile .= '<img id="e_'.$id_pack.'_'.$ii.'" name="e_'.$id_pack.'_'.$ii.'" class="n_etoile" src="'.$lien.'public/images/Etoile_ON.png">';
		}
		else
		{
			$etoile .= '<img id="e_'.$id_pack.'_'.$ii.'" name="e_'.$id_pack.'_'.$ii.'" class="n_etoile" src="'.$lien.'public/images/Etoile_OFF.png">';
		}
	}
							
	$etoile .= '</div>';
	
	// on récupère la liste complètes des maps
	if(sbox_cache::get('listing_maps_'.$game_bd.'') == false)
	{
		// on liste toute les maps
		$maps = $sbox->select_multi(array('table'=>'`maps_'.strtolower($game_bd).'`','select'=>'id,file_key,name,type,mode,images,folder,file,file_ext,stats_dl,note_val,note_nb'));
		
		if($maps)
		{
			foreach($maps as $map)
			{        
				// on prend la première images seulement
				$images = array();
				$images = explode(';',$map['images'],2);
				
				$listing_maps[$map['id']]['id'] = $map['id'];
				$listing_maps[$map['id']]['file_key'] = $map['file_key'];
				$listing_maps[$map['id']]['name'] = $map['name'];
				$listing_maps[$map['id']]['type'] = $map['type'];
				$listing_maps[$map['id']]['mode'] = $map['mode'];
				$listing_maps[$map['id']]['image'] = $images[0];
				$listing_maps[$map['id']]['folder'] = $map['folder'];
				$listing_maps[$map['id']]['file'] = $map['file'];
				$listing_maps[$map['id']]['file_ext'] = $map['file_ext'];
				$listing_maps[$map['id']]['stats_dl'] = $map['stats_dl'];
				$listing_maps[$map['id']]['note_val'] = $map['note_val'];
				$listing_maps[$map['id']]['note_nb'] = $map['note_nb'];
				$i++;
			}
			
			//sauvegarde en cache
			sbox_cache::add('listing_maps_'.$game_select.'',$listing_maps,3600);
		}
		else
		{
			$listing_maps = false;
		}
	}
	else
	{
		$listing_maps = sbox_cache::get('listing_maps_'.$game_bd.'');
	}
	
	$pack_maps = unserialize($pack->liste_maps);
	$listing = "";
	
	$i = 0;
	foreach($pack_maps as $id => $v)
	{
		$listing .= '<div style="float:left;"><table border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td style="background-color:#7e7e7e;color:#FFF;font-size:9px; padding-left:5px;">'.$listing_maps[$id]['name'].'</td>
									  </tr>
									  <tr>
										<td width="'.$width_vignette.'" height="'.($height_vignette+5).'"><img src="'.$lien.'public/images/maps/'.strtolower($game_bd).'/'.$listing_maps[$id]['image'].'" width="'.$width_vignette.'" height="'.$height_vignette.'" /></td>
									  </tr>
									</table>
									</div>';
		$i++;
	}
	
	if($note_nb > 1)
	{
		$vote = "<div id=\"V_".$id_pack."\" name=\"V_".$id_pack."\">".$note_nb." Votes</div>";
	}
	else
	{
		$vote = "<div id=\"V_".$id_pack."\" name=\"V_".$id_pack."\">".$note_nb." Vote</div>";
	}
	
}
else
{
	// PACK INEXISTANT
	echo "pack inconnu !";
}

$tpl -> GetTpl('mypack');

$tpl->assign(array(
	'FilArianne' 	=> DisplayArianne($Arianne),
	'CSS'			=> '<link rel="stylesheet" type="text/css" href="'.$lien.'public/css/setup.css" />{$CSS}',
	'Titre' 		=> 'Pack Maps '.$game.' :: '.ucfirst($pack_name),
	'Scripts' 		=> '<script type="text/javascript" src="'.$lien.'public/js/setup.js"></script>{$Scripts}',
	'PackName'		=> ucfirst($pack_name),
	'Game'			=> $game,
	'Auteur'		=> ucfirst($auteur),
	'Date'			=> $date,
	'Stats_dl'		=> $stats_dl,
	'Etoile'		=> $etoile,
	'Vote'			=> $vote,
	'Maps_liste'	=> $listing,
	'Actif'			=> '<input id="actif_game" name="actif_game" type="hidden" value="'.$game.'" /><input id="actif_pack" name="actif_pack" type="hidden" value="'.$id_pack.'" />',
	'Btn_Setup'		=> '<div class="right gistsubmit" id="p_validate" name="p_validate"><input onclick="s_pack('.$id_pack.')" type="submit" value="  '.ucfirst(TO_SETUP).'  " /><span></span></div>'
	));


$tpl->ConstructEndPage();

?>