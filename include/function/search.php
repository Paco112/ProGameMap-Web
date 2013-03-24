<?php
//********************************************************************************************
//********************************************************************************************
// Fonction SEARCH
//
// Fonction de recherche pour tableau à 3 dimension construit de cette manière :
// 
//		$TAB[0]['name'] = valeur
//		$TAB[0]['desc'] = valeur
//
//		$TAB[1]['name'] = valeur2
//		$TAB[1]['desc'] = valeur
//		...
//
// Cette fonction retourne le tableau d'entré avec uniquement les lignes corespondant à la valeur recherchée
// exemple ici si on cherche "valeur2" dans la case 'name' de $TAB le retour sera :
//
//		$TAB[1]['name'] = valeur2
//		$TAB[1]['desc'] = valeur
//
// Si on cherche "valeur" dans toute les cases le retour sera :
//
//		$TAB[0]['name'] = valeur
//		$TAB[0]['desc'] = valeur
//
//		$TAB[1]['name'] = valeur2
//		$TAB[1]['desc'] = valeur
//
// PARAMETRES :
//
//		1 : $tab_start  : Array  : 		  : le tableau a 3 dimenssion d'entréer
//		2 : $val_search : String :        : la valeur recherchée
//		3 : $case		: String : OPTION : la case dans la quelle la recherche doit etre ciblé sinon recherche dans toute les cases
//		4 : $stricte	: Bool   : OPTION : indique si la recherche doit etre stricte par default elle ne l'est pas
//
// RETOUR :
//
// 		$tab_end : si resultat trouvé
//  	False    : si aucun resultat
//
// MODE NON STRICTE ( Default ) :
// les accents, la ponctuation, les espaces ne sont pas pris en compte.
// les appréviations sont prises en compte exemple : "st" <--> "saint"
// 
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 02/11/2009
// Modification Date : 02/11/2009
// -------------------------------------------------------------------------------------------
//
// 1.0 - Paco112 : Creation
//
//********************************************************************************************
//********************************************************************************************

function search($tab_start, $val_search, $case="", $stricte=false)
{
	//compteur
	$nb_found = 0;
	$nb_boucle = 0;
	$nb_search = 0;
	
	$val_search = str_replace("%20"," ",$val_search);
	
	// si case est defini on essai de seprerer sur les point virgules
	if($case != "")
	{
		$tab_case = explode(";",$case);
	}
	
	// met tous en minuscule
	$val_search = strtolower($val_search);
	
	// paramétrage du mode stricte
	if($stricte)
	{
		$tab_search[0] = $val_search;
		$boucle_max = 1;
	}
	else
	{
		// on commence par decouper chaque mot de $val_search
		$temp_search = explode(" ",$val_search,10);
		$tab_search = array();
		
		foreach($temp_search as $key => $val)
		{
			// on ne prend pas en compte la dernière value de l'explose car explose limité
			if($key == 9)
			{
				break;
			}
			
			if( (count(array_keys($temp_search,$val)) > 1) && (array_search($val,$tab_search) === false) )
			{
				$tab_search[] = $val;
				$nb_search++;
			}
			elseif(count(array_keys($temp_search,$val)) == 1)
			{
				$tab_search[] = $val;
				$nb_search++;
			}
			
			$nb_boucle++;
			
			if($nb_search == 5)
			{
				break;
			}
		}
		
		// on cherche des abreviations
		$tab_abrev = abrev($tab_search);
		
		//print_r($tab_abrev);
		//print_r($tab_search);
	}
	
	
		
	// on lance la recherche sur tout $tab_start
	foreach($tab_start as $id => $v)
	{
		$found = false;
		
		// defnition de tab_temp pour le foreach suivant
		if($case != "")
		{
			$tab_temp = $tab_case;
		}
		else
		{
			$tab_temp = $tab_start[$id];
		}
		
		// ce foreach utilise sois $tab_start[$id] sois $tab_case si $case est defini
		// pour cela variable $tab_temp est dynamique et remplace sois l'un sois l'autre
		foreach($tab_temp as $name => $value)
		{			
			if($case != "")
			{
				//print_r($value."<br />");
				
				// si dans ce cas alors $name est l'id de $tab_case et $value sa valeur
				$value = $tab_start[$id][$value];
			}
			
			// variable permettant de sauter des boucle si valeur trouvé
			$found = false;
			
			// met tous en minuscule
			$value = strtolower($value);
			
			// première methode mot à mot ( limite 4 mot )
			$temp_value = explode(" ",$value);
			foreach($tab_search as $indice => $mot)
			{
				//on limite a 4 mot
				if($indice == 4)
				{
					break;
				}
				
				//print_r($indice." => ".$mot."<br />");
				if(!(array_search($mot, $temp_value) === false))
				{
					$tab_end[$id] = $tab_start[$id];
					$found = true;
					break;
				}
				elseif($tab_abrev[$mot] != "")
				{
					// on essaye de remplacer l'abreviation
					if(!(array_search($tab_abrev[$mot], $temp_value) === false))
					{
						$tab_end[$id] = $tab_start[$id];
						$found = true;
						break;
					}
				}
				
				// si toujours rien trouvé :
				// 2eme methode on colle tous le texte et on recherche des parti de chaine de plus de 2 caractères
				if(!$found)
				{
					$temp_value2 = str_replace(" ","",$value);
											
					if((preg_match("/".$mot."/",$temp_value2)) && (strlen($mot) > 2))
					{
						$tab_end[$id] = $tab_start[$id];
						$found = true;
						break;
					}
					elseif(($tab_abrev[$mot] != "") && (strlen($tab_abrev[$mot]) > 2))
					{
						// essai en remplacent les abreviation
						if(preg_match("/".$tab_abrev[$mot]."/",$temp_value2))
						{
							$tab_end[$id] = $tab_start[$id];
							$found = true;
							break;
						}
					}
				}
				$nb_boucle++;
			}
			
			if($found)
			{
				$nb_found++;
				break;
			}
			$nb_boucle++;
		}
		$nb_boucle++;
	}
	
	//print_r("<br /><br />Nombres de Boucle : ".$nb_boucle."<br /><br />");
	
	// Reponse
	if($nb_found)
	{
		return $tab_end;
	}
	else
	{
		return false;
	}
		
}

function abrev($tab_search_abrev)
{
	// liste des abreviations
	$liste_abrev['st'] = "saint";
	
	foreach($liste_abrev as $abv => $mot_entier)
	{
		//print_r(array_search($abv, $tab_search_abrev));
		//print_r(array_search($mot_entier, $tab_search_abrev));
		if(!(array_search($abv, $tab_search_abrev) === false))
		{
			$tab_return[$abv] = $mot_entier;
		}
		elseif(!(array_search($mot_entier, $tab_search_abrev) === false))
		{
			$tab_return[$mot_entier] = $abv;
		}
		//print_r("<br />".$abv."-".$mot_entier."<br />");
	}
	
	return $tab_return;
}

// test
/*
	
	include_once("../class/sbox.php");
	
	$game_select = "MOHAA";
	//on liste les maps si listing maps dispo ou demandé
			if(sbox_cache::get('listing_maps_'.$game_select.'') == false)
			{
				// on liste toute les maps
				$maps = $sbox->select_multi(array('table'=>'`maps_'.$game_select.'`','select'=>'*'));
				
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
				$listing_maps = sbox_cache::get('listing_maps_'.$game_select.'');
			}
			
	//print_r($_GET['val_search']."<br />");
	print_r(search($listing_maps,$_GET['val_search'],"name;file"));
*/