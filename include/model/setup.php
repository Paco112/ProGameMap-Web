<?php
//********************************************************************************************
//********************************************************************************************
// SETUP
// Gère la selection du jeux et maps
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

// Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (preg_match("/setup.php/i", $_SERVER['PHP_SELF'])) {
	  exit(0);
}
/*/ mise a zero des session
$_SESSION['listing_maps'] = array();
$_SESSION['listing_mode'] = array();
$_SESSION['listing_type'] = array();
*/
// taille des images maps
$bmap_height = 110;
$bmap_width = 180;

// taille des vignettes maps de la page setup.exe
$width_vignette = 100;
$height_vignette = 70;
// nombre maxi de vignette en largeur ( chiffre pair obligatoirement )
$nb_larg_vignette = 6;

// nombre maxi de vignette en largeur lorsque le nombre de map est superieure a $nb_vignette_big
$nb_vignette_big = 30;
$nb_larg_vignette_big = 8;


// definie le nombre de maps par page
$map_by_page = 24;

// Choix du type de la page (ici type par default)
$tpl->ConstructPage(2);

// Tlink pour images
$lien = Tlink($param);

				///////////////////////////////////////////////////////////////////////////////////
				//             			Function de Listing des Map			                   //
				///////////////////////////////////////////////////////////////////////////////////
		  			
include($_SERVER['DOCUMENT_ROOT']."/include/function/listing_maps.php");

                ///////////////////////////////////////////////////////////////////////////////////
                //                        			SELECT GAME				                	 //
                ///////////////////////////////////////////////////////////////////////////////////
				
if(!$param[3])
{						
	// on verifie si le listing n'est pas deja present en cache sinon on check la base de donné
	$listing_games = $sbox->select_multi(array('table'=>'games','select'=>'*','order by'=>'position ASC','apc'=>'listing_games','apc_ttl'=>'3600'));
	
	$i_game = '1';
	$link_games = "";
	$title_games = "";
	// on affiche tous les jeux en assigant au template setup
	foreach($listing_games as $game)
	{
		if($game['actif'] == 1 || $_SESSION['user']['permPage']['SETUP']['inactif'] == 'true')
		{
			$img_games .= '<div style="cursor:pointer"><img alt="'.strtolower($game['name']).'" src="'.$lien.'public/images/game_box/'.strtolower($game['image']).'" title="'.$game['name_plus'].'" /></div>';
			
			if($link_games == "")
			{
				$link_games = '<a title="'.$game['name_plus'].'" href="'.$lien.Plink($param,3,1,strtolower($game['name'])).'">'.$game['name'].' </a>';
			}
			else
			{
				$link_games .= '- <a title="'.$game['name_plus'].'" href="'.$lien.Plink($param,3,1,strtolower($game['name'])).'">'.$game['name'].' </a>';
			}
			
			$title_games .= " - ".$game['name'];
		}
	}
	
	$tpl -> GetTpl('setup_game');
	
	$Arianne = array(1 => array('titre' => ucfirst(SETUP),
			   					'lien'  => $lien.Plink($param,3,1,$param[3])),
					 2 => array('titre' => ucfirst(SELECT_GAME)));

	$tpl -> assign(array(
		//'ListeGames'    => $liste_games,
		'Moo_Link'		=> $param[1]."/".$param[2],
		'Img_Games'     => $img_games,
		'Link_Games'     => $link_games,
		'Titre'         => ucfirst(SETUP).$title_games)
	);
	
}
else
{
	
	// attribution du jeux selectionné
	$game_select = strtoupper($param[3]);
	$game_select_bd = $game_select;
	
	if($game_select == "MOHSH")
	{
		$game_select_bd = "MOHAA";
	}

					///////////////////////////////////////////////////////////////////////////////////
					//                        CHOIX DE LA PAGE ( et création ONGLET)               	 //
					///////////////////////////////////////////////////////////////////////////////////
	
	if($_SESSION['Panier_Count'][$game_select] == "")
	{
		$_SESSION['Panier_Count'][$game_select] = 0;
	}
	
	if($_SESSION['setup']['url_prec'] == "")
	{
		$u_prec = Plink($param,3,1,strtolower($game['name']));
	}
	else
	{
		$u_prec = $_SESSION['LANGUE']."/".$_SESSION['setup']['url_prec'];
	}
	// création du menu onglet
	switch($param[4])
	{
		default:
			$onglet = '<span class="onglet onglet-actif">Maps</span>'
					//. '<a class="onglet" href="'.$lien.Plink($param,4,1,'mods').'">Mods</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,FAVORITES).'">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,"packs").'">'.ucfirst(MYs).' Packs</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,CART).'" id="cart">'.ucfirst(MY).' '.ucfirst(CART).' ('.$_SESSION['Panier_Count'][$game_select].')</a>';
					//. '<div class="spacer"></div>';<input id="actif_game" name="actif_game" type="hidden" value="'.$game_select.'" />
			if($param[4] != "setup.exe")
			{
				$_SESSION['setup']['url_prec'] = Plink_name($param_name,$_SESSION['LANGUE'],'-1');
			}
			break;
		case 'mods':
			$onglet = '<a class="onglet" href="'.$lien.$u_prec.'">Maps</a>'
					. '<span class="onglet onglet-actif">Mods</span>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,FAVORITES).'">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,"packs").'">'.ucfirst(MYs).' Packs</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,CART).'" id="cart">'.ucfirst(MY).' '.ucfirst(CART).' ('.$_SESSION['Panier_Count'][$game_select].')</a>';
					//. '<div class="spacer"></div>';
			break;
		case FAVORITES:
			$onglet = '<a class="onglet" href="'.$lien.$u_prec.'">Maps</a>'
					//. '<a class="onglet" href="'.$lien.Plink($param,4,1,'mods').'">Mods</a>'
					. '<span class="onglet onglet-actif">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</span>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,"packs").'">'.ucfirst(MYs).' Packs</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,CART).'" id="cart">'.ucfirst(MY).' '.ucfirst(CART).' ('.$_SESSION['Panier_Count'][$game_select].')</a>';
					//. '<div class="spacer"></div>';
			break;
		case "packs":
			$onglet = '<a class="onglet" href="'.$lien.$u_prec.'">Maps</a>'
					//. '<a class="onglet" href="'.$lien.Plink($param,4,1,'mods').'">Mods</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,FAVORITES).'">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</a>'
					. '<span class="onglet onglet-actif">'.ucfirst(MYs).' Packs</span>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,CART).'" id="cart">'.ucfirst(MY).' '.ucfirst(CART).' ('.$_SESSION['Panier_Count'][$game_select].')</a>';
					//. '<div class="spacer"></div>';
			break;
		case CART:
			$onglet = '<a class="onglet" href="'.$lien.$u_prec.'">Maps</a>'
					//. '<a class="onglet" href="'.$lien.Plink($param,4,1,'mods').'">Mods</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,FAVORITES).'">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,"packs").'">'.ucfirst(MYs).' Packs</a>'
					. '<span class="onglet onglet-actif" id="cart">'.ucfirst(MY).' '.ucfirst(CART).' ('.$_SESSION['Panier_Count'][$game_select].')</span>';
					//. '<div class="spacer"></div>';
			break;
	
	}
	
	// initialisation des filtres d'affichage
	$filtre = NULL;
	$filtre_id = NULL;
	$type_liste_name = array();
	$f_type = array();
	$listing_maps = array();
	
	// Définition du fil d'arrianne
	$Arianne = array(1 => array('titre' => ucfirst(SETUP),
								'lien'  => $lien.Plink($param,2,1)),
					 2 => array('titre' => ucfirst($param[3]),
								'lien'  => $lien.Plink($param,3,1,$param[3])),
					 3 => array('titre' => ucfirst(SELECT_MAPS),
								'lien'	=> ''));
	
	// recuperation des favoris si inexistante
	if(count($_SESSION['favoris']) == 0 && $_SESSION['user']['uid'] != "")
	{
		$fav = $sbox->select(array('table'=>'site_users','select'=>'favID','where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
		$_SESSION['favoris'] = unserialize($fav->favID);
		//print_r($_SESSION['favoris']);
	}
	
	// choix de la page en fonction de l'onglet demander ( default = listing des maps)
	switch($param[4])
	{
	default:
						
			// stokage du jeux actif pour le JAVASCRIPT
			$liste_games .= '<input id="actif_game" type="hidden" value="'.$game_select.'" />';
			
			// informe la page actif au js
			switch($param[4])
			{
				default:
					$liste_games .= '<input id="page_actif" type="hidden" value="default" />';
					break;
				case FAVORITES:
					$liste_games .= '<input id="page_actif" type="hidden" value="favorites" />';
					break;
				case CART:
					$liste_games .= '<input id="page_actif" type="hidden" value="cart" />';
					break;
			}			
							///////////////////////////////////////////////////////////////////////////////////
							//                            LISTING DES MODES (Filtre)                         //
							///////////////////////////////////////////////////////////////////////////////////
			
			//on elève les cfiffres du nom de jeux exemple COD4 devient COD
			$game_general = preg_replace('/[0-9]/','',$game_select_bd);
			
			// on verifie si le listing des mode n'est pas deja present en cache sinon on check la base de donné
			$listing_mode = $sbox->select_multi(array('table'=>'mode_maps','select'=>'id,name,name_plus','where'=>'game=/'.$game_general.'/','apc'=>'listing_mode_'.$game_general,'apc_ttl'=>'3600'));
			
			if($param_name['mode'] == "")
			{
				$cssp = "font-weight:bold;";
			}
			
			// on affiche tous les mode en assigant au template setup et on attribue le filtrage au passage si demandé
			$liste_modes    .= "<div id=\"f_ALL\" >"
							. "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
							. "<tr valign=\"middle\">"
							//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
							. "<td style=\"width:25px\">&nbsp;</td>"
							. "<td style=\"height:25px\"><a id=\"ALL\" class=\"f_\" href=\"".$lien.Plink_name($param_name,'mode','-1')."\" style=\"text-decoration: none; ".$cssp."\">".ucfirst(ALL_MODE)."</a></td>"
							. "<td style=\"width:16px\"></td>"
							. "</tr>"
							. "</table>"
							. "</div>";
								
			foreach($listing_mode as $mode)
			{
				// stockage du type pour l'affichage sur chaque map
				$mode_maps[$mode['id']] = $mode['name'];
				
				// si un filtre est definie dans l'url on verifie qu'il existe et on l'applique
				if($param_name['mode'] != NULL && $param[$param_name['mode']+1] != "" ) 
				{
					if($mode['name'] == $param[$param_name['mode']+1])
					{
					   $filtre = $param[$param_name['mode']+1];
					   $filtre_id = $mode['id'];
					}
				}
				
				// affiche les loaders si mode existe
				if($filtre_id == $mode['id'])
				{
					//$display = 'block';
					$display = 'none';
					$cssp = "font-weight:bold;";
				}
				else
				{
					$display = 'none';
					$cssp = "";
				}
				
				$liste_modes    .= "<div id=\"f_".$mode['name']."\">"
								. "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
								. "<tr valign=\"middle\">"
								//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
								. "<td style=\"width:25px\">&nbsp;</td>"
								. "<td style=\"height:25px\"><a id=\"".$mode['name']."\" class=\"f_\" href=\"".$lien.Plink_name($param_name,'mode',$mode['name'])."\" style=\"text-decoration: none; ".$cssp."\">".$mode['name_plus']."</a></td>"
								. "<td style=\"width:16px\"><div class=\"load_mini\" id=\"load_".$mode['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" alt=\"#\" /></div></td>"
								. "</tr>"
								. "</table>"
								. "</div>";
								
				// variable d'affichage des mode 
				
			}
			
							
							///////////////////////////////////////////////////////////////////////////////////
							//                                LISTING DES TYPES                              //
							///////////////////////////////////////////////////////////////////////////////////
							
			if($game_select != "BF2")
			{
							
				// on verifie si le listing des mode n'est pas deja present en cache sinon on check la base de donné
				$listing_type = $sbox->select_multi(array('table'=>'type_maps','select'=>'*','order by'=>'name_plus_'.$_SESSION['LANGUE'].' ASC','apc'=>'listing_type','apc_ttl'=>'3600'));
									
				// si un multi ou mono filtre est definie dans l'url on le traite
				if($param_name['type'] != NULL && $param[$param_name['type']+1] != "" ) 
				{
					// on explose le filtre type si multi-filtre
					if(strpos($param[$param_name['type']+1],'_') === false)
					{
						$type_liste_name[$param[$param_name['type']+1]] = 1;
						$nb_type++;
					}
					else
					{
						$type_liste = explode('_',$param[$param_name['type']+1]);
						foreach($type_liste as $key => $value)
						{
							// différncie la value ET comme un param
							if($value == "and")
							{
								$type_mode = "and";
							}
							else
							{
								$type_liste_name[$value] = 1;
								$nb_type++;
							}
						}
					} 
				}
								   
				foreach($listing_type as $type)
				{				
					// pre-application du filtre type si existe
					if($nb_type == 0)
					{
						//$check = "checked=\"checked\"";
						$display = 'none';    
					}
					elseif($type_liste_name[$type['name']] == 1)
					{
						$check = "checked=\"checked\"";
						$f_type[$type['id']] = $type['name'];
						// affiche les mini loaders si mode existe
						//$display = 'block';
						$bold_t = "font-weight:bold;";
						$display = 'none';
					}
					else
					{
						$check = "";
						$bold_t = "";
						$display = 'none';
					}
					
					$liste_types    .= "<div id=\"t_".$type['name']."\" >"
									. "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
									. "<tr valign=\"middle\">"
									. "<td style=\"width:20px\">&nbsp;</td>"
									. "<td style=\"height:30px\"><input class=\"t_f\" id=\"".$type['name']."\" type=\"checkbox\" value=\"".$type['name']."\" ".$check." /></td>"
									. "<td style=\"color:#000; ".$bold_t."\">".$type['name_plus_'.$_SESSION['LANGUE']]."</td>"
									. "<td style=\"width:16px\"><div class=\"load_mini\" id=\"load_".$type['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" alt=\"#\" /></div></td>"
									. "</tr>"
									. "</table>"
									. "</div>";
					
				}
				
				if($type_mode == "and")
				{
					$display_or = '';
					$display_and = 'checked="checked"';
				}
				else
				{
					$display_or = 'checked="checked"';
					$display_and = '';
				}
				
				$tab_types = '<table width="100%" border="0" cellspacing="0" cellpadding="0">'
							. '<tr>'
							. '<td>'.$liste_types.'</td>'
							. '</tr>'
							. '<tr>'
							//. '<td><div style="text-align:center"><label><input name="type_mode" type="radio" id="or" value="or" '.$display_or.' />OU</label><label><input class="t_f" name="type_mode" type="radio" id="and" value="and" '.$display_and.' />ET</label></div></td>'
							. '<td></td>'
							. '</tr>'
							. '<tr>'
							. '<td>'
							. '<table border="0" cellpadding="0" cellspacing="0" style="margin:auto;">'
							. '<tr>'
							. '<td><div class="right gistsubmit"><input id="types_filtre" type="button" value="Filtrer" /><span></span></div></td>'
							. '</tr>'
							. '</table>'
							. '<input type="hidden" id="link_t" value="http://'.$_SERVER['HTTP_HOST'].'/'.Plink_name($param_name,'type','-1').'" />'
							. '</td>'
							. '</tr>'
							. '</table>';
							
				// BOX FILTRE BY TYPE
				
				$Box_by_type = '<table class="boxMenu">
								  <tr>
									<td class="topMenu" colspan="3"><strong>'.FILTER_BY_TYPE.'</strong></td>
								  </tr>
								  <tr>
									<td style="width:1px;"></td>
									<td valign="top" style="background:#FFF;"><div style="width:100%; padding:10px 0px 10px 0px;">'.$tab_types.'</div></td>
									<td style="width:1px;"></td>
								  </tr>
								  <tr>
									<td class="Footer" colspan="3"></td>
								  </tr>
								</table>';
			
			}
			
							///////////////////////////////////////////////////////////////////////////////////
							//                                LISTING DES MAPS                               //
							///////////////////////////////////////////////////////////////////////////////////
							
			
			$listing_maps = Maps_listing($game_select_bd,$param_name[SORT],$param[$param_name[SORT]+1]);
						 
			// on recupere le log des votes
			if( (count($_SESSION['log_votes'][$game_select]['map']) == 0) && ($_SESSION['user']['uid'] != "") )
			{
				$liste_votes = $sbox->select_multi(array('table'=>'log_votes','select'=>'id_map,note','where'=>'uid=/'.$_SESSION['user']['uid'].'/ AND game=/'.$game_select.'/'));
				if($liste_votes)
				{
					foreach($liste_votes as $vote)
					{
						$_SESSION['log_votes'][$game_select]['map'][$vote['id_map']] = $vote['note'];
					}
				}
			}
			
			if($param_name['search'] && $param[$param_name['search']+1])
			{
				include_once("include/function/search.php");
				$listing_maps = search($listing_maps,$param[$param_name['search']+1],"name;file");
			}
			
			if($listing_maps)
			{
				// si listing_maps dispo
				$map = array();
				$i=0;
				$compteur_map=0;
				$lock_view = 'no';
				$liste_maps = ''; 
				$t_view=0;
				$nb_mode=0;
				$nb_type=0;
				
				// pagination
				$page = $param[$param_name['page']+1]-1;
				if( ($page == -1) || ($page == "") )
				{
					$page = 0;
				}
				
				$nb_panier = 0;
				
				if($_SESSION['Panier'][$game_select])
				{
					foreach($_SESSION['Panier'][$game_select] as $id => $val)
					{
						if($val != "")
						{
							$nb_panier++;
						}
					}
				}
				
				foreach($listing_maps as $map)
				{
					$affiche = 1;
					
					if($param[4] == CART)
					{
						$p_class = "p_del";
						$p_view = ucfirst(REMOVE);
						
						if($_SESSION['Panier'][$game_select][$map['id']] != "")
						{
							$affiche = 1;
						}
						else
						{
							$affiche = 0;
						}
					}
					else
					{										
						if($param[4] == FAVORITES)
						{
							$p_class = "p_add_f";
						}
						else
						{
							$p_class = "p_add";
						}
						
						$p_view = ucfirst(ADD);
						
						//print_r($_SESSION['pagging_setup'][$page-1]."-");
						//print_r($map['id']."<br>");
						
						// on enlève les maps présente dans le panier
						if( ($_SESSION['Panier'][$game_select][$map['id']] != "") && ($param[4] != FAVORITES) )
						{
							$affiche = 0;
						}
						
						// application du filtre mode si demandé
						if( ($filtre_id != NULL) && ($affiche == 1) )
						{
							if(strpos($map['mode'],$filtre_id.";") === FALSE)
							{
								$affiche = 0;
								$nb_mode++;
							}
							else
							{
								$affiche = 1;
							}
						}
						
						// application du filtre type si demandé
						if( (count($f_type) > 0) && ($affiche == 1) )
						{
							// liste des types de la map
							$map_types = explode(";",$map['type']);
							
							if($type_mode == "and")
							{
								// on verifie que la map correspond au filtre demandé
								foreach($f_type as $k => $v)
								{
									if(count(array_keys($map_types, $k)) == 0)
									{
										$affiche = 0;
										$nb_type++;
										break;    
									}
								}
							}
							
							// on apllique un filtre exclusif si $affiche encore egal à 1
							if($affiche == 1)
							{
								if( ($f_type[1] != "") && (!in_array('1', $map_types)) )
								{
									// force a supprimer les map dmw only ( parme 1 ONLY )
									$affiche = 0;
								}
								else
								{
									foreach($map_types as $k => $v)
									{
	
										if( ($f_type[$v] == null) && ($v != "") && ($v != "1") )
										{
											$affiche = 0;
											$nb_type++;
											break;    
										}
									}
								}
							}
							
							
						}
						
						// si on est dans la page favoris on enlève toutes les maps qui ne sont pas dans les favoris du client
						if($param[4] == FAVORITES)
						{
							if($_SESSION['favoris'][$game_select][$map['id']] != '1')
							{
								$affiche = 0;
							}
						}
						
						
						if( ($lock_view == 'yes') && ($affiche == 1) )
						{
								$lock_view = false;
								$t_view = $map['id'];
								//print_r("<br /><br /><br />");
								//print_r($map);
								//$affiche = 1;
						}
						
						//print_r($_SESSION['pagging_setup'][Plink_name($param_name,'page','-1')][$page-1]);
						
						if( ($nb_panier > 0) && ($affiche == 1) && ($page > 0) && ($_SESSION['pagging_setup'][Plink_name($param_name,'page','-1')][$page-1] == $map['id']) && ($lock_view == 'no') )
						{		
							$lock_view = 'yes';
							//print_r("<br /><br /><br />");
							//print_r($map);
						}					
												
						$i++;
					}
					
					// FIN DU FILTRAGE ENREGISTREMENT DES MAP AFFICHABLE
					if($affiche == 1)
					{
						$map_on[$map['id']] = $map['id'];
					}
				}
				
				/////////
				
				if($param[4] == CART)
				{
					$map_by_page = '9999999';
				}
				
				$i=0;
				if(count($map_on) > 0)
				{
					foreach($map_on as $id)
					{
						//print_r("<br /><br /><br />");
						//print_r($i."<br />".$page."<br />".$map_by_page."<br />".$compteur_map);
						if( ( ($i>=($page*$map_by_page)) && ( ($i<(($page*$map_by_page)+$map_by_page)) || ($compteur_map < $map_by_page) ) ) || ($id == $t_view) )
						{
							if($id == $t_view)
							{
								$i++;
							}
							
							//affichage court du mode de la map
							
							// affiche coeur favoris
							if($_SESSION['favoris'][$game_select][$listing_maps[$id]['id']] == '1')
							{
								$p_back = '1';
							}
							else
							{
								$p_back = '16';
							}
							
							if( ($_SESSION['Panier'][$game_select][$id] != "") && ($param[4] == FAVORITES) )
							{
								$p_style = "color:gray";
							}
							else
							{
								$p_style = "cursor:pointer";
							}

							
							if($listing_maps[$id]['note_nb'] > 0)
							{
								$note = round(($listing_maps[$id]['note_val'] / $listing_maps[$id]['note_nb']));
							}
							else
							{
								$note = 0;
							}
							
							if($_SESSION['log_votes'][$game_select]['map'][$listing_maps[$id]['id']] != "")
							{
								$no_vote = "1";
							}
							else
							{
								$no_vote = "0";
							}
							
							$etoile = '<input id="NOVOTE_'.$listing_maps[$id]['id'].'" type="hidden" value="'.$no_vote.'" />'
									. '<input id="VAL_'.$listing_maps[$id]['id'].'" type="hidden" value="'.$listing_maps[$id]['note_val'].'" />'
									. '<input id="NB_'.$listing_maps[$id]['id'].'" type="hidden" value="'.$listing_maps[$id]['note_nb'].'" />'
									. '<div id="G_'.$listing_maps[$id]['id'].'" class="g_etoile">';
							
							for($ii=1;$ii<=5;$ii++)
							{
								if($ii <= $note)
								{
									$etoile .= '<img id="e_'.$listing_maps[$id]['id'].'_'.$ii.'" alt="#" class="n_etoile" src="'.$lien.'public/images/Etoile_ON.png" />';
								}
								else
								{
									$etoile .= '<img id="e_'.$listing_maps[$id]['id'].'_'.$ii.'" alt="#" class="n_etoile" src="'.$lien.'public/images/Etoile_OFF.png" />';
								}
							}
							
							$etoile .= '</div>';
							
							if($listing_maps[$id]['note_nb'] > 1)
							{
								$pluriel = "s";
							}
							else
							{
								$pluriel = "";
							}
							
							$class="class=\"high_load\" style=\"display:block;\"";
							
							//$lien_image = "";
							//if($listing_maps[$id]['image'] != "")
							//{
								$lien_image = $lien."public/images/maps/".strtolower($game_select_bd)."/".$listing_maps[$id]['image'];
							//}
							
							// affichage court du type de map
							$all_mode = explode(";",$listing_maps[$id]['mode']);
							$view_mode = "";
							$nb_mode=0;
							if(count($all_mode) > 0)
							{
								foreach($all_mode as $key_m => $val_m)
								{
									if($nb_mode == 5)
									{
										if((count($all_mode)-1) > 5)
										{
											$view_mode .= "...";
										}
										break;
									}
									if($val_m != "")
									{
										if($view_mode == "")
										{
											$view_mode = $mode_maps[$val_m];
										}
										else
										{
											$view_mode .= "|".$mode_maps[$val_m];
										}
										$nb_mode++;
									}
								}
							}
			
							$liste_maps .= "<div class=\"box_maps\" id=\"m_".$listing_maps[$id]['id']."\" style=\"float:left; padding-top:5px; height:212px; width:194px; background-image:url('".$lien."public/images/box_opacity2.png'); background-repeat:no-repeat; color:#FFF;\">"
										. "<div ".$div_s.">"
										. "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:".($bmap_width+8)."px\">"
										. "<tr>"
										. "<td colspan=\"2\">"
										. "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
										. "<tr>"
										. "<td style=\"padding-left:8px; width:146px; font-size:12px;\"><strong>".$listing_maps[$id]['name']."</strong></td>"
										. "<td style=\"padding-left:2px;\"><div class=\"fav_c\" id=\"fav_".$listing_maps[$id]['id']."\" style=\"cursor:pointer; width:19px; height:16px; background:url('".$lien."public/images/fav_coeur.png') 0 -".$p_back."px no-repeat;\"></div><input id=\"fav_val_".$listing_maps[$id]['id']."\" type=\"hidden\" value=\"".$_SESSION['favoris'][$game_select][$listing_maps[$id]['id']]."\" /></td>"
										. "</tr>"
										. "</table>"
										. "</td>"
										. "</tr>"
										. "<tr>"
										. "<td colspan=\"2\" style=\"height:".$bmap_height."px; text-align:center; padding-left:8px; padding-top:4px; padding-bottom:4px;\"><div style=\"height:".$bmap_height."px\"><img src=\"".$lien_image."\" width=\"".$bmap_width."\" height=\"".$bmap_height."\" alt=\"".$listing_maps[$id]['name']."\" /></div></td>"
										. "</tr>"
										. "<tr style=\"font-size:11px; height:15px;\">"
										. "<td style=\"padding-left:10px;\">".$etoile."</td>"
										. "<td style=\"text-align:right;\"><div id=\"V_".$listing_maps[$id]['id']."\">".$listing_maps[$id]['note_nb']." Vote".$pluriel."</div></td>"
										. "</tr>"
										. "<tr>"
										. "<td style=\"padding-left:10px; font-size:11px; height:11px;\">".strtoupper($view_mode)."</td>"
										. "<td style=\"text-align:right; font-size:11px; height:11px;\">".$listing_maps[$id]['stats_dl']."</td>"
										. "</tr>"
										. "<tr>"
										. "<td colspan=\"2\" style=\"padding-left:45px; padding-top:6px;\">"
										. "<div id=\"p_".$listing_maps[$id]['id']."\" class=\"".$p_class."\" style=\"width:109px; height:21px; ".$p_style."\">"
										. "<table style=\"width:109px\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
										. "<tr>"
										. "<td valign=\"middle\"><div style=\"width:16px; height:16px; margin-left:5px; background-image:url('".$lien."public/images/".$p_class.".png');\"></div></td>"
										. "<td><strong>".$p_view."</strong></td>"
										. "</tr>"
										. "</table>"
										. "</div>"
										. "</td>"
										. "</tr>"
										. "</table>"
										. "</div>"
										. "</div>";									
							
							$compteur_map++;
							
							//stock l'id de la dernière map visible sur la page
							/*
							if( ($compteur_map == $map_by_page) && ($nb_panier > 0) )
							{
								$_SESSION['pagging_setup'][Plink_name($param_name,'page','-1')][$page] = $listing_maps[$id]['id'];
							}
							else
							{
								$_SESSION['pagging_setup'][Plink_name($param_name,'page','-1')][$page] = "";
							}
							*/
							$_SESSION['pagging_setup'][Plink_name($param_name,'page','-1')][$page] = $listing_maps[$id]['id'];
						}
						
						$i++;
					}
				}
			}
			
			//stock l'id de la dernière map visible sur la page ( 2eme controlle dans le cas ou la page n'est pas pleine )
			//if( ($compteur_map < $map_by_page) && ($nb_panier > 0) )
			//{
				
			//}
			
				
			// si il y a aucune map a afficher
			if($compteur_map == 0)
			{
				if( ($_SESSION['user']['uid'] == "") && ($param[4] == FAVORITES) )
				{
					$liste_maps .= "<br /><br /><div id=\"no_map\" style=\"text-align:center;\">Veuillez vous connecter pour accéder à vos favoris !</div>";
				}
				elseif($param[4] == FAVORITES)
				{
					$liste_maps .= "<br /><br /><div id=\"no_map\" style=\"text-align:center;\">Vous n'avez aucune maps en favoris !<br /><br />Utilisez le bouton en forme de coeur dans la liste des maps pour ajouter la map que vous désirez dans vos favoris.</div>";
				}
				elseif($param_name['search'])
				{
					$liste_maps .= "<br /><br /><div id=\"no_map\" style=\"text-align:center;\">Aucune Map Trouvée !<br /><br /><a href=\"".$lien.Plink_name($param_name,'search','-1')."\">Cliquez ICI pour annuler la recherche</a></div>";
				}
				else
				{
					if($param[$param_name['page']+1] <= 1)
					{
						$liste_maps .= "<br /><br /><div id=\"no_map\" style=\"text-align:center;\">Aucune Map !</div>";
					}
					else
					{
						$liste_maps .= "<br /><br /><div id=\"no_map\"style=\"text-align:center;\">Aucune Map !</div><script type=\"text/javascript\">window.location.replace('".$lien.Plink_name($param_name,'page',ceil(count($map_on) / $map_by_page))."');</script>";
					}
				}
			}
			elseif($param[4] != CART && (count($map_on) > $map_by_page) )
			{				
					// affichage de la pagination
					if($param[4] == FAVORITES)
					{
						$n_map = count($_SESSION['favoris'][$game_select]);	
					}
					else
					{
						$n_map = count($map_on);
					}
					
					$n_page = ceil($n_map / $map_by_page);
					
					if(!isset($param_name['page']))
					{
						$n_current = 1;
						$n_suiv = 2;
					}
					else
					{
						$n_current = $param[$param_name['page']+1];
						$n_prec = $param[$param_name['page']+1]-1;
						$n_suiv = $param[$param_name['page']+1]+1;    
					}
										
					if($n_page > 1)
					{	
					
						if($n_current == 1)
						{
							$view_page .= "<li class='navPage'><img src='".$lien."public/images/prev_off.jpg' alt='' /></li>";
						}
						else
						{
							$view_page .= "<li class='navPage'><a href=\"".$lien.Plink_name($param_name,'page',$n_prec)."\"><img src='".$lien."public/images/prev_on.jpg' alt='#' /></a></li>";
						}						
					
						for($n=1;$n<=$n_page;$n++)
						{
							if($n == $n_current)
							{
								$view_page .= "<li><a class='numPage hover' href=\"".$lien.Plink_name($param_name,'page',$n)."\">".$n."</a></li>";
							}
							else
							{
								$view_page .= "<li><a class='numPage' href=\"".$lien.Plink_name($param_name,'page',$n)."\">".$n."</a></li>";
							}
						}
						
						if($n_current == $n_page)
						{
							$view_page .= "<li class='navPage'><img src='".$lien."public/images/next_off.jpg' alt='#' /></li>";
						}
						else
						{
							$view_page .= "<li class='navPage'><a href=\"".$lien.Plink_name($param_name,'page',$n_suiv)."\"><img src='".$lien."public/images/next_on.jpg' alt='#' /></a></li>";
						}	
													   
						$paging = $view_page;
						
					}
					else
					{
						$paging = '<td colspan="3" style="width:120px"></td>';
					}
			}
			elseif($param[4] == CART)
			{
				// on remplace la pagination par le bouton de validation du panier
				$paging = '<div class="right gistsubmit" style="margin-top:-7px;"><a id="del_all" href="#">TOUS SUPPRIMER</a><span></span></div><div class="right gistsubmit" style="margin-top:-7px; margin-right:20px; "><a href="'.$lien.Plink($param,4,1,"setup.exe").'">  '.ucfirst(TO_SETUP).'  </a><span></span></div>';
				$paging2 = '<div class="right gistsubmit" style="margin-top:-7px; margin-right:20px; "><a href="'.$lien.Plink($param,4,1,"setup.exe").'">  '.ucfirst(TO_SETUP).'  </a><span></span></div>';
			}
			
			if($paging != "")
			{
				$paging = '<ul class="pagination">'.$paging.'</ul>';
			}
			
			if($paging2 == "")
			{
				$paging2 = $paging;
			}
			
			if($param_name['search'])
			{
				$search_val = $param[$param_name['search']+1];
			}
			
			if($param[4] == CART)
			{
				$tpl -> GetTpl('setup_cart');
			}
			else
			{
				$tpl -> GetTpl('setup');
			}
			
			// Gestion de l'affichage Trie
			$order = Trie_Maps($param_name[SORT],$param[$param_name[SORT]+1]);
			
			// trie par default 
			$lien_order['name'] = "asc";
			$lien_order['note'] = "desc";
			$lien_order['note_nb'] = "desc";
			$lien_order['stats_dl'] = "desc";
			
			if($order[1] == "asc")
			{
				$lien_order[$order[0]] = "desc";
				$img_order[$order[0]] = '<img src="'.$lien.'public/images/ascinfo.gif" width="9" height="5" alt="" />';
			}
			else
			{
				$lien_order[$order[0]] = "asc";
				$img_order[$order[0]] = '<img src="'.$lien.'public/images/descinfo.gif" width="9" height="5" alt="" />';
			}
			
			$order_actif[$order[0]] = "font-weight:bold;";
			
			$liste_sort = '<table border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td style="width:110px"><a style="text-decoration: none; '.$order_actif['name'].'" href="'.$lien.Plink_name($param_name,SORT,'name_'.$lien_order['name']).'">'.ucfirst(NAME).'</a></td>
							  <td>'.$img_order['name'].'</td>
							</tr>
							<tr>
							  <td><a style="text-decoration: none; '.$order_actif['note'].'" href="'.$lien.Plink_name($param_name,SORT,'note_'.$lien_order['note']).'">Note</a></td>
							  <td>'.$img_order['note'].'</td>
							</tr>
							<tr>
							  <td><a style="text-decoration: none; '.$order_actif['note_nb'].'" href="'.$lien.Plink_name($param_name,SORT,'vote_'.$lien_order['note_nb']).'">Vote</a></td>
							  <td>'.$img_order['note_nb'].'</td>
							</tr>
							<tr>
							  <td><a style="text-decoration: none; '.$order_actif['stats_dl'].'" href="'.$lien.Plink_name($param_name,SORT,'dl_'.$lien_order['stats_dl']).'">'.ucfirst(DOWNLOADED).'</a></td>
							  <td>'.$img_order['stats_dl'].'</td>
							</tr>
						  </table>';
	
			$tpl -> assign(array(
						'Search_Val'	=> $search_val,
						'Search_Link' 	=> "http://www.progamemap.com/".Plink_name($param_name,'search','-1'),
						'ListeSort'		=> $liste_sort,
						'ListeGames'    => $liste_games,
						'ListeModes'    => $liste_modes,
						'ListeTypes'    => $Box_by_type,
						'MenuOnglet'    => $onglet,
						'ListeMaps'     => $liste_maps,
						'Paging'        => $paging,
						'Paging2'        => $paging2,
						'PUB2'          => Pub(160,600),
						'FilArianne'    => DisplayArianne($Arianne),
						'Titre'         => ucfirst(SETUP).' - '.$game_select)
					);
		
		// fin de la page listing des maps
		break;
	case 'packs':

		// stokage du jeux actif pour le JAVASCRIPT
		$liste_games .= '<input id="actif_game" type="hidden" value="'.$game_select.'" /><input id="actif_pack" type="hidden" title="'.$lien.SETUP.'/'.$game_select.'/setup.exe" />';
		
		if($_SESSION['user']['uid'] == "")
		{
			$liste_packs .= "<br /><br /><div id=\"no_packs\" style=\"text-align:center;\">Veuillez vous connecter pour accéder à vos Packs !</div>";
			
		}
		else
		{
			
			$listing_maps = Maps_listing($game_select_bd,$param_name[SORT],$param[$param_name[SORT]+1]);
			
			// on recupere le log des votes
			if( (count($_SESSION['log_votes'][$game_select]['pack']) == 0) && ($_SESSION['user']['uid'] != "") )
			{
				$liste_votes = $sbox->select_multi(array('table'=>'log_votes','select'=>'id_pack,note','where'=>'uid=/'.$_SESSION['user']['uid'].'/ AND game=/'.$game_select.'/'));
				if($liste_votes)
				{
					foreach($liste_votes as $vote)
					{
						$_SESSION['log_votes'][$game_select]['pack'][$vote['id_pack']] = $vote['note'];
					}
				}
			}
			
			
			// on récupère la liste des packs
			$packs = $sbox->select_multi(array('table'=>'`packs_'.$game_select.'`','select'=>'*','where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
			
			if($packs)
			{
				if(count($packs) > 0)
				{
					foreach($packs as $pack)
					{
						/*
						$listing_packs[$pack['id']]['id'] = $pack['id'];
						$listing_packs[$pack['id']]['name'] = $pack['name'];
						$listing_packs[$pack['id']]['liste_maps'] = $pack['liste_maps'];
						$listing_packs[$pack['id']]['stats_dl'] = $pack['stats_dl'];
						$listing_packs[$pack['id']]['note_val'] = $pack['note_val'];
						$listing_packs[$pack['id']]['note_nb'] = $pack['note_nb'];
						$listing_packs[$pack['id']]['type'] = $pack['type'];
						$listing_packs[$pack['id']]['date'] = $pack['date'];
						*/
						
						if($pack['note_nb'] > 0)
						{
							$note = round(($pack['note_val'] / $pack['note_nb']));
						}
						else
						{
							$note = 0;
						}
						
						if($_SESSION['log_votes'][$game_select]['pack'][$pack['id']] != "")
						{
							$no_vote = "1";
						}
						else
						{
							$no_vote = "0";
						}
						
						$etoile = '<input id="NOVOTE_'.$pack['id'].'" type="hidden" value="'.$no_vote.'" />'
								  . '<input id="VAL_'.$pack['id'].'" type="hidden" value="'.$pack['note_val'].'" />'
								  . '<input id="NB_'.$pack['id'].'" type="hidden" value="'.$pack['note_nb'].'" />'
								  . '<div style="float:left; padding-right:10px;" id="G_'.$pack['id'].'" class="g_etoile">';
												
						for($ii=1;$ii<=5;$ii++)
						{
							if($ii <= $note)
							{
								$etoile .= '<img id="e_'.$pack['id'].'_'.$ii.'" class="n_etoile" src="'.$lien.'public/images/Etoile_ON.png" />';
							}
							else
							{
								$etoile .= '<img id="e_'.$pack['id'].'_'.$ii.'" class="n_etoile" src="'.$lien.'public/images/Etoile_OFF.png" />';
							}
						}
												
						$etoile .= '</div>';
						
						if($pack['note_nb'] > 1)
						{
							$vote = "<div id=\"V_".$pack['id']."\">".$pack['note_nb']." Votes</div>";
						}
						else
						{
							$vote = "<div id=\"V_".$pack['id']."\">".$pack['note_nb']." Vote</div>";
						}
		
						
						$pack['liste_maps'] = unserialize($pack['liste_maps']);
						
						$liste_maps = "";
						$i_map = 1;
						foreach($pack['liste_maps'] as $id_map => $valeur)
						{
							if($i_map == 1)
							{
								$liste_maps .= $listing_maps[$id_map]['name'];
							}
							else
							{
								$liste_maps .= " - ".$listing_maps[$id_map]['name'];
							}
							$i_map++;
						}
						
						// formatage de la date en fonction de la langue
						$datetime = date_create($pack['date']);
					
						if($_SESSION['LANGUE'] == 'fr')
						{
							$date = date_format($datetime, 'd/m/Y');
						}
						else
						{
							$date = date_format($datetime, 'Y/m/j');
						}
						
						if($pack['type'] == "PUBLIC")
						{
							$name_pack = $pack['name'];
							$name_pack = str_replace("%20","_",$name_pack);
							$name_pack = str_replace(" ","_",$name_pack);
							$link_direct = '<tr><td colspan="6" style="padding-top:10px;">Lien Direct : <input type="text" value="http://www.progamemap.com/mypack/'.strtolower($game_select).'/'.strtolower($_SESSION['user']['dname']).'/'.strtolower($name_pack).'/" size="108" readonly="true" /></td></tr>';
						}
						else
						{
							$link_direct = "";
						}
	
										
					$liste_packs .=	'<div style="margin-top:10px;">
									<table class="boxPack border="0" cellspacing="0" cellpadding="0"">
									  <tr>
										<td class="topLeftPack"></td>
										<td class="topMiddlePack">
											<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
											  <tr>
												<td><strong style="padding-left:15px;">'.$pack['name'].'</strong></td>
												<td align="right">
													<table align="right" border="0" cellspacing="0" cellpadding="0">
													  <tr>
														<td style="width:80px">'.$date.'</td>
													  </tr>
													</table>
												</td>
											  </tr>
											</table>
										</td>
										<td class="topRightPack"></td>
									  </tr>
									  <tr>
										<td width="1"></td>
										<td style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; padding:5px 5px 5px 5px;" valign="top">
											<table style="width:750px" border="0" cellspacing="0" cellpadding="0">
											  <tr>
												<td colspan="6" style="padding-top:5px;">'.$liste_maps.'</td>
											  </tr>
											  '.$link_direct.'
											  <tr valign="middle">
												<td style="width:100px">'.$etoile.'</td>
												<td style="width:75px">'.$vote.'</td>
												<td align="center">Téléchargé : '.$pack['stats_dl'].' fois</td>
												<td align="center">Type : '.ucfirst(strtolower($pack['type'])).'</td>
												<td colspan="2" align="right"><table align="right" border="0" cellspacing="0" cellpadding="0"><tr>
												<td><div class="right gistsubmit" id="p_validate"><input onclick="d_pack('.$pack['id'].')" type="submit" value="  '.ucfirst(DEL).'  " /><span></span></div></td><td><div class="right gistsubmit" id="p_validate"><input onclick="s_pack('.$pack['id'].')" type="submit" value="  '.ucfirst(TO_SETUP).'  " /><span></span></div></td></tr></table></td>    								
											  </tr>
											</table>
										</td>
										<td style="width:1px"></td>
									  </tr>
									  <tr>
										<td class="footerLeftPack"></td>
										<td class="footerMiddlePack"></td>
										<td class="footerRightPack"></td>
									  </tr>
									</table>
									</div>';				
					}
				}
			}
			else
			{
				$liste_packs = '<div style="text-align:center; padding-top:35px;">Vous n\'avez créé aucun pack de map !<br /><br />Pour créer un pack utilisé le bouton sauvegarder dans votre Panier.<div>';
			}
		}		

		$tpl -> GetTpl('setup_pack');

		$tpl -> assign(array(
					'MenuOnglet'    => $onglet,
					'ListeGames'    => $liste_games,
					'ListeMaps'     => $liste_packs,
					'PUB2'          => Pub(160,600),
					'FilArianne'    => DisplayArianne($Arianne),
					'Titre'         => ucfirst(SETUP).' - '.$game_select)
				);
		
		break;
	case 'setup.exe':
				
		if(!$_SESSION['Panier'][$game_select])
		{
			$list = '<script type="text/javascript">window.location.replace("'.$lien.Plink($param,4,1,CART).'");</script>';
		}
		else
		{		
			// Detection du navigateur
			if (preg_match("/MSIE/",$_SERVER['HTTP_USER_AGENT']))
			{
			  $nav = "MSIE";
			}
			elseif (preg_match("/Firefox/",$_SERVER['HTTP_USER_AGENT']))
			{
			  $nav = "Firefox";
			}
			
			$nav_ok = 0;
			
			if ($nav == "Firefox")
			{
				// detection du plugin pgm via l'icone
			
				$ext_detect = '<div id="p_check"><table border="0" cellspacing="0" cellpadding="0" align="center">'
							. '<tr>'
							. '<td><img src="chrome://ProGameMap/skin/pgm.png" onload="ext_ff()" style="visibility:hidden">Veuillez installer le plugin Firefox afin de pouvoir utiliser le logiciel ProGameMap.<br /></td>'
							. '</tr>'
							. '<tr>'
							. '<td>'
							. '<table border="0" cellspacing="0" cellpadding="0" style="text-align:center; margin:auto;">'
							. '<tr>'
							. '<td><br /><br /><div id="plug_ff" class="right gistsubmit"><a href="http://www.progamemap.com/setup/ext/pgm.xpi"/> INSTALLER LE PLUGIN </a><span></span></div></td>'
							. '</tr>'
							. '</table>'
							. '</td>'
							. '</tr>'
							. '</table></div>'
							. '<br />';
				$nav_ok = 1;
			}
			elseif($nav == "MSIE")
			{
				$ext_detect = '<div id="p_check"><table border="0" cellspacing="0" cellpadding="0" style="text-align:center; margin:auto;">'
							. '<tr>'
							. '<td>Veuillez installer le logiciel Microsoft .NET Framework 3.5 afin de pouvoir utiliser le logiciel ProGameMap</br></br><a style="text-align:center" href="http://www.microsoft.com/downloads/details.aspx?FamilyId=333325FD-AE52-4E35-B531-508D977D32A6&displaylang='.$param[1].'">INSTALLER Microsoft .NET Framework 3.5</a></td>'
							. '</tr>'
							. '<tr>'
							. '<td>'
							. '<table border="0" cellspacing="0" cellpadding="0" tyle="text-align:center; margin:auto;">'
							. '<tr>'
							. '<td><br /><br /></td>'
							. '</tr>'
							. '</table>'
							. '</td>'
							. '</tr>'
							. '</table></div>'
							. '<br />';
				$ext_detect .= '<script type="text/javascript">check_net(\''.$param[1].'\');</script>';
				$nav_ok = 1;
			}
			else
			{
				$ext_detect = '<br/><br/>Votre navigateur n\'est pas pris en charge veuillez utiliser Firefox (recommandé) ou Internet Explorer 8<br/><br/>';
				$nav_ok = 0;
			}
			
			$listing_maps = Maps_listing($game_select_bd);
			
			$i=0;
			$list = "";
			
			// recapitulatif des maps à installer
			if($nav_ok == 1)
			{
				
				$btn_setup = "";
								   
				$_SESSION['DOWNLOAD'] = NULL;
				
				// pass de securiter des limites de téléchargement
				$sqldate = date("y").'-'.date("m").'-'.date("d");
				if($_SESSION['user']['uid'] == "")
				{
					$log_dl = $sbox->select_multi(array('table'=>'log_dl','select'=>'id','where'=>'( ip=/'.$_SERVER['REMOTE_ADDR'].'/ ) AND ( date LIKE /%'.$sqldate.'%/ )'));
				}
				else
				{
					$log_dl = $sbox->select_multi(array('table'=>'log_dl','select'=>'id','where'=>'( ip=/'.$_SERVER['REMOTE_ADDR'].'/ OR uid=/'.$_SESSION['user']['uid'].'/ ) AND ( date LIKE /%'.$sqldate.'%/ )'));				
				}
				
				if($log_dl)
				{
					
					if(count($log_dl) > 20)
					{
						$btn_setup = "<strong style='color:#F00'>Vous ne pouvez pas télécharger plus de 20 Packs par 24h !</strong>";
					}
				}
				
				if($btn_setup == "")
				{
					
					if(!$_SESSION['user']['group']['principal'])
					{
						$_SESSION['user']['group']['principal'] = '1';
					}
					
					// listing des serveurs de telechargement possible
					$server = $sbox->select(array('select'=>'*', 'table'=>'ip_servers', 'where'=>'((auth=/ALL/ OR auth=/'.$_SESSION['user']['group']['principal'].'/) AND game=/'.$game_select_bd.'/ AND actif=/Y/)', 'order by'=>'nb_dl ASC'));
					
					if(!$server)
					{
						$btn_setup = "<strong style='color:#F00'>Aucun serveur n'est disponnible pour votre demande ! <br /><br /> Veuillez rééssayer plus tard !</strong>";
						//exit();
					}
					else
					{
						//echo "Un des serveurs est pret a executer la commande !";	
						
						// on ferme la connection a la base de donné progamemap pour se consacrer a la base de donné setup_pgm
						mysqli_close($_SESSION['sbox_link']);
						
						// test si table du mois existante
						if(!$sbox->select(array('select' => '*', 'table' => 'M_'.date('n').'_'.date('Y'), 'id_base' => '1', 'where'=>'id=/1/')))
						{
							// creation d'une nouvelle table du mois
							if(!@mysqli_query($_SESSION['sbox_link'],"CREATE TABLE IF NOT EXISTS `M_".date('n')."_".date('Y')."` (
											`id` int( 11 ) NOT NULL AUTO_INCREMENT ,
											`sid` int( 11 ) NOT NULL ,
											`cid` int( 11 ) NOT NULL ,
											`ctype` enum( 'N', 'G', 'P', 'S' ) NOT NULL DEFAULT 'G',
											`game` text NOT NULL ,
											`list_maps` longtext NOT NULL ,
											`setup_control` longtext,
											`url` text NOT NULL ,
											`close_date` date NOT NULL ,
											`close` enum( 'N', 'Y' ) NOT NULL DEFAULT 'N',
											`stats_dl` int( 11 ) NOT NULL DEFAULT '0',
											PRIMARY KEY ( `id` ) ,
											KEY `sid` ( `sid` ) ,
											KEY `cid` ( `cid` )
											) ENGINE = MYISAM DEFAULT CHARSET = latin1;"))
							{
								$btn_setup = "<strong style='color:#F00'>Impossible d'enregistrer votre commande !</strong>";
							}
						}
						
						// traitrement du panier a mettre dans la table setup_pgm
						$compt_maps=0;
						$setup_control = "";
						foreach($_SESSION['Panier'][$game_select] as $id => $actif)
						{
							if($actif != "")
							{
								$compt_maps++;
								
								if($compt_maps == 1)
								{
									$list_maps = $listing_maps[$id]['name']."=".$listing_maps[$id]['folder']."\/".$listing_maps[$id]['file'].".".$listing_maps[$id]['file_ext']."=".sha1($server->key_files.$listing_maps[$id]['file_key']).".zip";
								}
								else
								{
									// limitation a 2 maps pour les non logué
									if( ($compt_maps > 2) && ($_SESSION['user']['uid'] == "") )
									{
										$list_maps .= ";".$listing_maps[$id]['name']."=NO=NO";
									}
									else
									{
										$list_maps .= ";".$listing_maps[$id]['name']."=".$listing_maps[$id]['folder']."\/".$listing_maps[$id]['file'].".".$listing_maps[$id]['file_ext']."=".sha1($server->key_files.$listing_maps[$id]['file_key']).".zip";
									}
								}
								
								// ajouts de l'installtuion personalisé si dispo
								if($listing_maps[$id]['setup_control'] != "")
								{
									$setup_control .= str_replace("[zip]",sha1($server->key_files.$listing_maps[$id]['file_key']).".zip",$listing_maps[$id]['setup_control'])."
";
								}
							}
						}
						
						
						// ajouts du panier traité a la table setup_pgm
						if($compt_maps > '0')
						{
							$set[0]['sid'] = rand(1,999999);
							$set[0]['cid'] = rand(99,999999);
							
							if($_SESSION['user']['uid'] == "")
							{
								$set[0]['ctype'] = 'N';
							}
							else
							{
								$set[0]['ctype'] = 'G';
							}
							
							$set[0]['game'] = $game_select;
							$set[0]['list_maps'] = $list_maps;
							$set[0]['setup_control'] = $setup_control;
							
							if( ($server->login == "") || ($server->password == "") )
							{
								$set[0]['url'] = 'http://'.$server->ip.$server->folder;
							}
							else
							{
								$set[0]['url'] = 'ftp://'.$server->login.':'.$server->password.'@'.$server->ip.$server->folder;
							}
							
							//$demain = mktime(date("H")+24, date("i"), date("s"), date("m"), date("d"), date("y")); 
							//$set[0]['close_date'] = date("Y-m-d H:i:s",$demain);
							$demain = mktime(0, 0, 0, date("m"), date("d")+2, date("y"));
							$table = 'M_'.date('n').'_'.date('Y');
							$set[0]['close_date'] = date("Y-m-d",$demain);
							
							if($sbox->insert(array('table'=>$table, 'set'=>$set, 'id_base'=>'1')))
							{
								// on stock l'id créer dans la base de donné
								$id_dl = mysqli_insert_id($_SESSION['sbox_link']);
								
								mysqli_close($_SESSION['sbox_link']);
								
								//mise a jour du nombre de téléchargement de chaque map
								$nb_maps = 0;
								foreach($_SESSION['Panier'][$game_select] as $id => $actif)
								{
									if($actif != "")
									{
										$nb_maps++;
										// limitation a 2 maps pour les non logué
										if( ($nb_maps > 2) && ($_SESSION['user']['uid'] == "") )
										{
											
										}
										else
										{
											$up_dl = array();
											$up_dl[0]['stats_dl'] = '!#{stats_dl+1}';
											$sbox->update(array('table'=>'maps_'.$game_select_bd,'set'=>$up_dl,'where'=>'id=/'.$id.'/','id_base'=>'0'));
										}
									}
								}
													
								// on log ces info dans la base de donné du site
								$set2[0]['id_dl'] = $id_dl;
								$set2[0]['uid'] = $_SESSION['user']['uid'];
								$set2[0]['ip'] = $_SERVER['REMOTE_ADDR'];
								$set2[0]['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
								$set2[0]['table_dl'] = $table;
								$set2[0]['nb_dl'] = $compt_maps;
								
								if($sbox->insert(array('table'=>'log_dl', 'set'=>$set2, 'id_base'=>'0')))
								{
									function lettre()
									{
										$len = rand(4,9);
										$r = '';
										for($i=0; $i<$len; $i++)
										{
											$r .= chr(rand(0, 25) + ord('a'));
										}
										return strtoupper($r);
									}
			
									//on créer le lien de téléchargement que l'on stock en session
									//$_SESSION['DOWNLOAD'] = 'http://www.progamemap.com/setup/ProGameMap.application?id='.$set[0]['cid'].'&pid='.$id_dl.'&sid='.$set[0]['sid'];
									$_SESSION['DOWNLOAD'] = 'http://www.progamemap.com/setup/ProGameMap?'.lettre().$id_dl.lettre().$set[0]['sid'].lettre().$set[0]['cid'].lettre();					
									$btn_setup = '<div class="right gistsubmit"><a href="'.$lien.Plink($param,4,1,CART).'">  '.ucfirst(EDIT).'  </a><span></span></div><div class="right gistsubmit"><a href="'.$_SESSION['DOWNLOAD'].'">  '.ucfirst(TO_SETUP).'  </a><span></span></div>';
									//echo '<IFRAME src="'.$_SESSION['DOWNLOAD'].'" width=0 height=0 scrolling=no frameborder=0 style="display:none"></IFRAME>';
									//echo $_SESSION['DOWNLOAD'];
									
									if( ($_SESSION['user']['uid'] == "") && ($compt_maps > 2) )
									{
										$no_connect = "<strong style='color:#F00'>Veuillez vous connecter pour installer plus de 2 Maps</strong><br /><br />";
									}

								}						
								
							}
							else
							{
								$btn_setup = "<strong style='color:#F00'>Impossible d'enregistrer votre commande !</strong>";
							}
							mysqli_close;
						}
						else
						{
							$btn_setup = "<strong style='color:#F00'>Veuillez selectionner au moins une map !</strong>";
						}
										
					}
				}
													
				foreach($_SESSION['Panier'][$game_select] as $id => $val)
				{
					if($val != "")
					{
						$list_map .= '<div style="float:left;"><table border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td style="background-color:#7e7e7e;color:#FFF;font-size:9px; padding-left:5px;">'.$listing_maps[$id]['name'].'</td>
									  </tr>
									  <tr>
										<td width="'.$width_vignette.'" height="'.($height_vignette+5).'"><img src="'.$lien.'public/images/maps/'.strtolower($game_select_bd).'/'.$listing_maps[$id]['image'].'" width="'.$width_vignette.'" height="'.$height_vignette.'" /></td>
									  </tr>
									</table>
									</div>';
							
						$i++;
					}
				}

				// on cherche une taille permettant presenter sous forme de carré
				$n = $i;
				
				if($n > $nb_vignette_big)
				{
					$nb_larg_vignette = $nb_larg_vignette_big;
				}
				
				if($n <= 3)
				{
					$width = $n * $width_vignette;
				}
				else
				{
					if($n%2 != 0)
					{
						if($n%3 != 0)
						{
							$n = $n - 1; 
						}
					}
					if($n <= $nb_larg_vignette)
					{
						$n = $n / 2;
					}
					for($x=$nb_larg_vignette;$x>=1;$x=$x-1)
					{
						if($n%$x == 0)
						{
							$width = $x * $width_vignette;
							break;
						}
					}
					if(($x*$x) < $n)
					{
						$width = $nb_larg_vignette * $width_vignette;
					}
				}
				
				$list .= '<div id="box_setup" style="display:none; text-align:center">
						  '.$no_connect.'
						  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr align="center">
								<td align="center">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td>
										<table width="'.$width.'" border="0" align="center" cellpadding="0" cellspacing="0">
										  <tr>
											<td align="center">'.$list_map.'</td>
										  </tr>
										  <tr>
											<td></td>
										  </tr>
										</table>
									  </td>
									</tr>
									<tr>
									  <td align="center">
									  	<div style="text-align:center; padding-top:20px;">
											<table border="0" cellspacing="0" cellpadding="0" align="center">
											  <tr>
												<td align="center">'.$btn_setup.'</td>
											  </tr>
											</table>
										</div>
									  </td>
									</tr>
								  </table>
								</td>
							  </tr>
							</table>
						</div>';
	
			}
			
			if($i == 0 && $nav_ok == 1)
			{
				$list = '<script type="text/javascript">window.location.replace("'.$lien.Plink($param,4,1,CART).'");</script>';
				$ext_detect = "";
			}
		}
		

		
		$tpl -> GetTpl('setup_recap');

		$tpl -> assign(array(
					'ListeMaps'     => '<input id="actif_game" type="hidden" value="'.$game_select.'" />'.$list.$ext_detect.'<div id="loader" style="display:none"><img src="'.$lien.'public/images/ajax-loader.gif" alt="" /></div>',
					'PUB2'          => Pub(160,600),
					'FilArianne'    => DisplayArianne($Arianne),
					'Titre'         => ucfirst(SETUP))
				);

		
		// fin de la page setup.exe
		break;
	}
	
}

if(!$param[3])
{
	$setup_css = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$lien."public/css/MooFlow.css\" />\n";
	$setup_script = "<script type=\"text/javascript\" src=\"".$lien."public/js/MooFlow.js\"></script>\n";
}
else
{
	$setup_css = "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$lien."public/css/onglet.css\" />\n";
	$setup_script = "<script type=\"text/javascript\" src=\"".$lien."public/js/setup.js\"></script>\n";
}

$tpl -> assign(array('CSS' => $setup_css.'{$CSS}',
					 'Scripts' => $setup_script.'{$Scripts}',
					 'FilArianne' => DisplayArianne($Arianne)));

$tpl->ConstructEndPage(2);

$hover1 = ""; $hover2 = " id=\"menuTopHover\""; $hover3 = ""; $hover4 = "";

// on efface la variable listing maps
//$_SESSION['listing_maps'] = array();
//print_r('<br /><br />');
//print_r($_SESSION['pagging_setup']);
?>