<?php
//********************************************************************************************
//********************************************************************************************
// SETUP PANIER
// Gère le panier de selection des maps
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 29/07/2009
// Modification Date :
// -------------------------------------------------------------------------------------------
// Historique
//
// 1.0 - Paco112 : Creation
//
//********************************************************************************************
//********************************************************************************************
//session_start();
require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
$_SESSION['sbox_ajax'] = 1;

if($_POST['val'])
{
	sbox_function::check_ajax(true);
}
else
{
	sbox_function::check_ajax(false);
}

$game = strtoupper($_POST['game']);
$game_bd = $game;

if($game == "MOHSH")
{
	$game_bd = "MOHAA";
}

$add = $_POST['add'];
$del = $_POST['del'];
$val = $_POST['val'];
$sav = $_POST['sav'];
$name = $_POST['name'];
$public = $_POST['pub'];
$fav = $_POST['fav'];
$note = $_POST['note'];
$pack = $_POST['pack'];
$go_pgm = $_POST['go_pgm'];

// controlle de securiter ajax
//if($serial == md5($_SESSION['sbox_function']['secu_ajax'][1].$_SESSION['sbox_function']['secu_ajax'][2]))
//{
if($game != "")
{
	if( ($note != "") && ($add != "") )
	{
		if($_SESSION['user']['uid'] != "")
		{
			if($pack)
			{
				$type = "pack";
			}
			else
			{
				$type = "map";
			}
			
			if($_SESSION['log_votes'][$game][$type][$add] == "")
			{			
				$set = array();
				$set_log = array();
				
				$set[0]['note_val'] = '!#{note_val+'.$note.'}';
				$set[0]['note_nb'] = '!#{note_nb+1}';
				if($pack)
				{
					$vote_up = $sbox->update(array('table'=>'packs_'.strtolower($game), 'set'=>$set, 'where'=>'id=/'.$add.'/'));
					$set_log[0]['id_pack'] = $add;
				}
				else
				{
					$vote_up = $sbox->update(array('table'=>'maps_'.strtolower($game_bd), 'set'=>$set, 'where'=>'id=/'.$add.'/'));
					$set_log[0]['id_map'] = $add;
				}
				
				// sauvegarde du vote dans la table log_vote
				if($vote_up)
				{
					$set_log[0]['uid'] = $_SESSION['user']['uid'];
					$set_log[0]['game'] = $game;
					$set_log[0]['note'] = $note;
					if($sbox->insert(array('table'=>'log_votes', 'set'=>$set_log)))
					{
						//on ajoute a la session log_votes
						$_SESSION['log_votes'][$game][$type][$add] = $note;
						echo ":OK:";
					}
				}
			}
		}
		else
		{
			echo "Please Login !";
		}
	}
	elseif($fav == '1')
	{		
		if($_SESSION['user']['uid'] != "")
		{
			if($add != "")
			{
				$_SESSION['favoris'][$game][$add] = 1;			
			}
			elseif($del != "")
			{
				$_SESSION['favoris'][$game][$del] = 0;
			}
			
			$set = array();			
			$set[0]['favID'] = serialize($_SESSION['favoris']);
		
			$sbox->update(array('table'=>'site_users', 'set'=>$set, 'where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
		}
		else
		{
			echo "Please Login !";
		}
	}
	elseif( ($sav == '1') && ($name != "") )
	{
		if($_SESSION['user']['uid'] != "")	
		{
			$compt_maps=0;
			$pack = array();
			
			include($_SERVER['DOCUMENT_ROOT']."/include/function/listing_maps.php");
			
			$listing_maps = Maps_listing($game_bd);
			
			foreach($_SESSION['Panier'][$game] as $id => $actif)
			{
				if($actif != "")
				{
					$pack[$id] = $listing_maps[$id]['name'];
				}
			}
			
			//on serialise le tableau et on le sauvegarde dans la base de donnée
			if(count($pack) > 0)
			{
				// on verifie que le nom du pack n'existe pas
				$check_name = $sbox->select(array('table'=>'packs_'.strtolower($game),'select'=>'id','where'=>'name=/'.$name.'/ AND uid=/'.$_SESSION['user']['uid'].'/'));				
				$check_nb = $sbox->select_multi(array('table'=>'packs_'.strtolower($game),'select'=>'id','where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
				if($check_name->id != "")
				{
					echo "Le nom de ce Pack existe deja, veuillez choisir un autre nom !";
				}
				elseif(count($check_nb) >= 20)
				{
					echo "Vous ne pouvez pas sauvegarder plus de 20 Packs !";
				}
				else
				{				
					$set_pack[0]['uid'] = $_SESSION['user']['uid'];
					$set_pack[0]['name'] = $name;
					$set_pack[0]['liste_maps'] = serialize($pack);
					
					if($public == 'true')
					{
						$set_pack[0]['type'] = "PUBLIC";
					}
					
					if($sbox->insert(array('table'=>'packs_'.strtolower($game),'set'=>$set_pack)))
					{
						echo "Votre Pack est maintenant disponible dans \"Mes Packs\"";
						if($public == 'true')
						{
							echo "<br /><br />Lien direct :<br />";
							$name = str_replace("%20","_",$name);
							$name = str_replace(" ","_",$name);					
							echo "<input name=\"\" type=\"text\" readonly=\"true\" value=\"http://www.progamemap.com/mypack/".strtolower($game)."/".strtolower($_SESSION['user']['dname'])."/".strtolower($name)."/\" />";
						}
					}
				}
			}
			else
			{
				echo "Veuillez ajouter au moins 1 map dans votre panier !";
			}
		}
		else
		{
			echo "Please Login !";
		}
	}
	elseif(($val == '1') && ($pack != "") )
	{
		// Gestion Valider Pack
		$up_dl = array();
		$up_dl[0]['stats_dl'] = '!#{stats_dl+1}';
		$sbox->update(array('table'=>'packs_'.strtolower($game),'set'=>$up_dl,'where'=>'id=/'.$pack.'/'));
		
		// on remplace le panier de map par celle du pack
		$pack_list = $sbox->select(array('table'=>'packs_'.strtolower($game),'select'=>'*','where'=>'id=/'.$pack.'/'));
		$_SESSION['Panier'][$game] = array();
		$_SESSION['Panier'][$game] = unserialize($pack_list->liste_maps);
		
		if(count($_SESSION['Panier'][$game]) > 0)
		{
			$_SESSION['Panier_Count'][$game] = count($_SESSION['Panier'][$game]);
			
			if($_SESSION['LANGUE'] == 'fr')
			{
				echo "fr/logiciel/".strtolower($game)."/setup.exe/";
			}
			else
			{
				echo "en/setup/".strtolower($game)."/setup.exe/";
			}
		}
	}
	elseif(($del == 'pack') && ($pack != "") )
	{
		// suppression d'un pack
		if($sbox->delete(array('table'=>'packs_'.strtolower($game),'where'=>'id=/'.$pack.'/')))
		{
			echo ":OK:";
		}
	}
	else
	{
		// ajout ou suppresion du panier
		if($del != "")
		{
			if($del == "all")
			{
				$_SESSION['Panier'][$game] = array();
				$_SESSION['Panier_Count'][$game] = 0;
				echo ":OK:";
			}
			elseif(is_numeric($del))
			{
				$_SESSION['Panier'][$game][$del] = "";
				$_SESSION['Panier_Count'][$game] = $_SESSION['Panier_Count'][$game] - 1;
				echo ":OK:".$_SESSION['Panier_Count'][$game];
			}
		}
		elseif( (is_numeric($add)) && ($add != "") )
		{
			$_SESSION['Panier'][$game][$add] = 1;
			$_SESSION['Panier_Count'][$game]++;
			echo ":OK:".$_SESSION['Panier_Count'][$game];
		}
	}
}
	
	//print_r($_SESSION['Panier'][$game]);  

//}

//print_r($_POST);
?>
