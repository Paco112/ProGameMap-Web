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
if (stristr("setup.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

/*/ mise a zero des session
$_SESSION['listing_maps'] = array();
$_SESSION['listing_mode'] = array();
$_SESSION['listing_type'] = array();
*/
// taille des images maps
$bmap_height = 115;
$bmap_width = 155;

// Choix du type de la page (ici type par default)
$tpl->ConstructPage(2);

// Tlink pour images
$lien = Tlink($param);

// serial de securisation de la connection ajax
$serial_ajax = sbox_function::secu_ajax();

                ///////////////////////////////////////////////////////////////////////////////////
                //                        			SELECT GAME				                	 //
                ///////////////////////////////////////////////////////////////////////////////////
				
if(!$param[3])
{						
	// on verifie si le listing n'est pas deja present en cache sinon on check la base de donné
	$listing_games = $sbox->select_multi(array('table'=>'games','select'=>'*','where'=>'`actif`=/1/','order by'=>'name_plus ASC','apc'=>'listing_games','apc_ttl'=>'3600'));
	
	$i_game = '1';
	
	// on affiche tous les jeux en assigant au template setup
	foreach($listing_games as $game)
	{
	/*
		$liste_games    .= "<div id=\"d_".$game['name']."\" name=\"d_".$game['name']."\" >"
						. "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
						. "<tr nowrap valign=\"middle\">"
						. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
						. "<td width=\"5\">&nbsp;</td>"
						. "<td height=\"25\"><a id=\"".$game['name']."\" name=\"".$game['name']."\" class=\"g_\" href=\"".$lien.Plink($param,3,1,strtolower($game['name']))."\" style=\"text-decoration: none;\">".$game['name_plus']." (".$game['nb_maps'].")</a></td>"
						. "<td width=\"16\"><div class=\"load_mini\" id=\"load_".$game['name']."\" name=\"load_".$game['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" /></div></td>"
						. "</tr>"
						. "</table>"
						. "</div>";*/
		
		if($i_game == '1')
		{
			$liste_games .= '<option value="'.strtolower($game['name']).'" selected>'.$game['name_plus'].'</option>';
			$i_game++;
		}
		else
		{
			$liste_games .= '<option value="'.strtolower($game['name']).'">'.$game['name_plus'].'</option>';
		}
			//\'http://www.progamemap.com/'.$param[1].'/'.$param[2].'/'.$game['name'].'/
			$img_games .= '<div>';
			$img_games .= '<img border="0" src="'.$lien.'public/images/game_box/'.strtolower($game['name']).'.jpg" title="'.$game['name_plus'].'"></div>';
		
	}
	
	$tpl -> GetTpl('setup_game');
	
	$Arianne = array(1 => array('titre' => 'Logiciel',
			   					'lien'  => $lien.Plink($param,3,1,$param[3])),
					 2 => array('titre' => 'S&eacute;lectionnez un jeu'));

	$tpl -> assign(array(
		'ListeGames'    => $liste_games,
		'Img_Games'     => $img_games,
		'Titre'         => ucfirst(SETUP))
	);
	
}
else
{
	
	// attribution du jeux selectionné
	$game_select = strtoupper($param[3]);

					///////////////////////////////////////////////////////////////////////////////////
					//                        CHOIX DE LA PAGE ( et création ONGLET)               	 //
					///////////////////////////////////////////////////////////////////////////////////
	
	// création du menu onglet
	switch($param[4])
	{
		default:
			$onglet = '<span class="onglet onglet-actif">'.MAP_LIST.'</span>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,FAVORITES).'">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,CART).'"><div id="cart" name="cart">'.ucfirst(MY).' '.ucfirst(CART).'</div></a>'
					. '<div class="spacer"></div>';
			break;
		case FAVORITES:
			$onglet = '<a class="onglet" href="'.$lien.Plink($param,3,1,strtolower($game['name'])).'">'.MAP_LIST.'</a>'
					. '<span class="onglet onglet-actif">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</span>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,CART).'"><div id="cart" name="cart">'.ucfirst(MY).' '.ucfirst(CART).'</div></a>'
					. '<div class="spacer"></div>';
			break;
		case CART:
			$onglet = '<a class="onglet" href="'.$lien.Plink($param,3,1,strtolower($game['name'])).'">'.MAP_LIST.'</a>'
					. '<a class="onglet" href="'.$lien.Plink($param,4,1,FAVORITES).'">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</a>'
					. '<span class="onglet onglet-actif">'.ucfirst(MY).' '.ucfirst(CART).'</span>'
					. '<div class="spacer"></div>';
			break;
	
	}
	
	// definie le nombre de maps par page
	$map_by_page = 36;
	
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
					 3 => array('titre' => 'S&eacute;lectionnez vos maps',
								'lien'	=> ''));
	
	
	// choix de la page en fonction de l'onglet demander ( default = listing des maps)
	switch($param[4])
	{
	default:
			
			
			// stokage du jeux actif pour le JAVASCRIPT
			$liste_games .= '<input id="actif_game" name="actif_game" type="hidden" value="'.$game_select.'" />';
			
			
							///////////////////////////////////////////////////////////////////////////////////
							//                            LISTING DES MODES (Filtre)                         //
							///////////////////////////////////////////////////////////////////////////////////
							
			
			// on verifie si le listing des mode n'est pas deja present en cache sinon on check la base de donné
			$listing_mode = $sbox->select_multi(array('table'=>'mode_maps','select'=>'*','order by'=>'name_plus ASC','apc'=>'listing_mode','apc_ttl'=>'3600'));
			
			// on affiche tous les mode en assigant au template setup et on attribue le filtrage au passage si demandé
			$liste_modes    .= "<div id=\"f_ALL\" name=\"f_ALL\" >"
							. "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
							. "<tr nowrap valign=\"middle\">"
							//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
							. "<td width=\"25\">&nbsp;</td>"
							. "<td height=\"25\"><a id=\"ALL\" name=\"ALL\" class=\"f_\" href=\"".$lien.Plink_name($param_name,'mode','-1')."\" style=\"text-decoration: none;\">Tous les Modes</a></td>"
							. "<td width=\"16\"></td>"
							. "</tr>"
							. "</table>"
							. "</div>";
								
			foreach($listing_mode as $mode)
			{
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
				}
				else
				{
					$display = 'none';
				}
				
				$liste_modes    .= "<div id=\"f_".$mode['name']."\" name=\"f_".$mode['name']."\" >"
								. "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
								. "<tr nowrap valign=\"middle\">"
								//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
								. "<td width=\"25\">&nbsp;</td>"
								. "<td  height=\"25\"><a id=\"".$mode['name']."\" name=\"".$mode['name']."\" class=\"f_\" href=\"".$lien.Plink_name($param_name,'mode',$mode['name'])."\" style=\"text-decoration: none;\">".$mode['name_plus']."</a></td>"
								. "<td width=\"16\"><div class=\"load_mini\" id=\"load_".$mode['name']."\" name=\"load_".$mode['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" /></div></td>"
								. "</tr>"
								. "</table>"
								. "</div>";
				
			}
			
							
							///////////////////////////////////////////////////////////////////////////////////
							//                                LISTING DES TYPES                              //
							///////////////////////////////////////////////////////////////////////////////////
							
			// on verifie si le listing des mode n'est pas deja present en cache sinon on check la base de donné
			$listing_type = $sbox->select_multi(array('table'=>'type_maps','select'=>'*','order by'=>'name_plus ASC','apc'=>'listing_type','apc_ttl'=>'3600'));
								
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
					$check = "checked=\"checked\"";
					$display = 'none';    
				}
				elseif($type_liste_name[$type['name']] == 1)
				{
					$check = "checked=\"checked\"";
					$f_type[$type['id']] = $type['name'];
					// affiche les mini loaders si mode existe
					//$display = 'block';
					$display = 'none';
				}
				else
				{
					$check = "";
					$display = 'none';
				}
				
				$liste_types    .= "<div id=\"t_".$type['name']."\" name=\"t_".$type['name']."\" >"
								. "<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
								. "<tr nowrap valign=\"middle\">"
								. "<td width=\"25\">&nbsp;</td>"
								. "<td  height=\"25\"><label><input class=\"t_f\" name=\"".$type['name']."\" id=\"".$type['name']."\" type=\"checkbox\" value=\"".$type['name']."\" ".$check."\" />".$type['name_plus']."</label></td>"
								. "<td width=\"16\"><div class=\"load_mini\" id=\"load_".$type['name']."\" name=\"load_".$type['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" /></div></td>"
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
			
			$tab_types = '<table border="0" cellspacing="0" cellpadding="0">'
						. '<tr>'
						. '<td><label><input name="type_mode" type="radio" id="or" value="or" '.$display_or.' />OU</label><label><input class="t_f" name="type_mode" type="radio" id="and" value="and" '.$display_and.' />ET</label></td>'
						. '<td>'.$liste_types.'</td>'
						. '</tr>'
						. '<tr>'
						. '<td colspan="2">'
						. '<div style="text-align:center"><br><br><input id="types_filtre" name="types_filtre" type="button" value="Filtrer"></div>'
						. '<input type="hidden" name="link_t" id="link_t" value="http://'.$_SERVER['HTTP_HOST'].'/'.Plink_name($param_name,'type','-1').'" />'
						. '</td>'
						. '</tr>'
						. '</table>';		
			
							///////////////////////////////////////////////////////////////////////////////////
							//                                LISTING DES MAPS                               //
							///////////////////////////////////////////////////////////////////////////////////
							
			
			//on liste les maps si listing maps dispo ou demandé
			if(sbox_cache::get('listing_maps_'.$game_select.'') == false)
			{
				// on liste toute les maps
				$maps = $sbox->select_multi(array('table'=>'`maps_'.$game_select.'`','select'=>'id,file_key,name,type,mode,images,file,file_ext,stats_dl,note'));
				
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
					$listing_maps[$map['id']]['file'] = $map['file'];
					$listing_maps[$map['id']]['file_ext'] = $map['file_ext'];
					$listing_maps[$map['id']]['stats_dl'] = $map['stats_dl'];
					$listing_maps[$map['id']]['note'] = $map['note'];
					$i++;
				}
				
				//sauvegarde en cache
				sbox_cache::add('listing_maps_'.$game_select.'',$listing_maps,3600);
			}
			else
			{
				$listing_maps = sbox_cache::get('listing_maps_'.$game_select.'');
			}
			
			if($listing_maps)
			{
				// si listing_maps dispo
				$map = array();
				$i=0;
				$compteur_map=0;
				$liste_maps = ''; 
				$lock_view = 'no';
				$nb_mode=0;
				$nb_type=0;
				
				// pagination
				$page = $param[$param_name['page']+1]-1;
				if($page == -1)
				{
					$page = 0;
				}
				
				$nb_panier = 0;
				
				if($_SESSION[$game_select]['Panier'])
				{
					foreach($_SESSION[$game_select]['Panier'] as $id => $val)
					{
						if($val == '1')
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
						$p_view = "Enlever";
						
						if($_SESSION[$game_select]['Panier'][$map['id']] == '1')
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
						if( ($i>=($page*$map_by_page)) && ( ($i<(($page*$map_by_page)+$map_by_page)) || ($compteur_map < $map_by_page) ) )
						{						
							$p_class = "p_add";
							$p_view = "Ajouter";
							
							//print_r($_SESSION['pagging_setup'][$page-1]."-");
							//print_r($map['id']."<br>");
							
							if($nb_panier > 0)
							{		
								if(($page > 0) && ($_SESSION['pagging_setup'][$page-1] != ""))
								{
									if($lock_view == 'no')
									{
										$lock_view = 'yes';
									}
									
									if( ($_SESSION['pagging_setup'][$page-1] == $map['id']) && ($lock_view == 'yes') )
									{
										$lock_view = false;
										$affiche = 0;
									}
								}
								
								if($lock_view == 'yes')
								{
									$affiche = 0;
								}
							}
							
							// on enlève les maps présente dans le panier
							if($_SESSION[$game_select]['Panier'][$map['id']] == '1')
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
									foreach($map_types as $k => $v)
									{
										if( ($f_type[$v] == null) && ($v != "") )
										{
											$affiche = 0;
											$nb_type++;
											break;    
										}
									}
								}
								
							}
						}
						else
						{
							$affiche = 0;
							//break;
						}
					}
					
						
					// afficage de la maps si autorisé par le filtre, si pas de filtre tous est autorisé
					if($affiche == 1)
					{
						$class="class=\"high_load\" style=\"display:block;\"";
		
						$liste_maps .= "<div class=\"box_maps\" id=\"m_".$map['id']."\" name=\"m_".$map['id']."\" style=\"float:left; padding-top:10px; width:".($bmap_width+6)."px;\">"
									. "<div ".$div_s.">"
									. "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
									. "<tr>"
									. "<td colspan=\"2\"><img id=\"m_".$map['name']."\" name=\"m_".$map['name']."\" src=\"http://dog.fpsbanana.com/ss/maps/thm_20450.jpg\" width=\"".$bmap_width."\" height=\"".$bmap_height."\" alt=\"".$map['name']."\" /></td>"
									. "</tr>"
									. "<tr>"
									. "<td>".$map['name']."</td>"
									. "<td>".$map['stats_dl']."</td>"
									. "</tr>"
									. "<tr>"
									. "<td>etoile1</td>"
									. "<td>etoile2</td>"
									. "</tr>"
									. "<tr>"
									. "<td colspan=\"2\" style=\"text-align:center;\"><a id=\"".$map['id']."\" name=\"".$map['id']."\" class=\"".$p_class."\" href=\"".$lien.Plink($param,3,1,strtolower($game['name']))."\" style=\"text-decoration: none;\">".$p_view."</a></td>"
									. "</tr>"
									. "</table>"
									. "</div>"
									. "</div>";
						
						$compteur_map++;
						
						//stock l'id de la dernière map visible sur la page
						if( ($compteur_map == $map_by_page) && ($nb_panier > 0) )
						{
							$_SESSION['pagging_setup'][$page] = $map['id'];
						}
						else
						{
							$_SESSION['pagging_setup'][$page] = "";
						}
					}
					
					$i++;
					
				}
			}
			
			//stock l'id de la dernière map visible sur la page ( 2eme controlle dans le cas ou la page n'est pas pleine )
			if( ($compteur_map < $map_by_page) && ($nb_panier > 0) )
			{
				$_SESSION['pagging_setup'][$page] = $map['id'];
			}
			
				
			// si il y a aucune map a afficher
			if($compteur_map == 0)
			{
				$liste_maps .= "<div id=\"no_map\" name=\"no_map\" style=\"text-align:center;\">Aucune Map !</div>";
			}
			else
			{
			
				if($param[4] != CART)
				{
					// affichage de la pagination
					$n_map = count($listing_maps)-($nb_panier+$nb_mode+$nb_type);
					$n_page = ceil($n_map / $map_by_page);
					if(!isset($param_name['page']))
					{
						$n_prec = 1;
						$n_suiv = 2;
					}
					else
					{
						$n_prec = $param[$param_name['page']+1]-1;
						$n_suiv = $param[$param_name['page']+1]+1;    
					}
					
					if($n_page > 1)
					{
						for($n=1;$n<=$n_page;$n++)
						{
							if($n == 1)
							{
								$view_page .= "<a href=\"".$lien.Plink_name($param_name,'page',$n)."\">".$n."</a>";
							}
							else
							{
								$view_page .= " - <a href=\"".$lien.Plink_name($param_name,'page',$n)."\">".$n."</a>";
							}
						}
						
						$paging .= '<td width="50"><a href="'.$lien.Plink_name($param_name,'page',$n_prec).'"><img src="'.$lien.'public/images/fleche_g.png" width="19" height="18" alt="" border="0" /></a></td>'
								. '<td nowrap>'.$view_page.'</td>'
								. '<td width="50"><a href="'.$lien.Plink_name($param_name,'page',$n_suiv).'"><img src="'.$lien.'public/images/fleche_d.png" width="19" height="18" alt="" border="0" /></a></td>';
					}
					else
					{
						$paging = '<td colspan="3" width="120"></td>';
					}
				}
			}
			
			$tpl -> GetTpl('setup');
	
			$tpl -> assign(array(
						'ListeGames'    => $liste_games,
						'ListeModes'    => $liste_modes,
						'ListeTypes'    => $tab_types,
						'MenuOnglet'    => $onglet,
						'ListeMaps'     => $liste_maps,
						'Paging'        => $paging,
						'PUB2'          => Pub(160,600),
						'SerialAjax'    => $serial_ajax,
						'Scripts' 		=> '<script type="text/javascript" src="'.$lien.'public/js/setup.js"></script>',
						'FilArianne'    => DisplayArianne($Arianne),
						'Titre'         => ucfirst(SETUP))
					);
		
		// fin de la page listing des maps
		break;
	
	case 'setup.exe':
		
		$tpl -> GetTpl('setup');
		if($cache_tpl)
		{
			$tpl -> assign(array(
						'ListeMaps'     => '<a href="'.$lien.'setup/ProGameMap.application?id=123456789&pid=1&sid=2">Valider</a>',
						'PUB2'          => Pub(160,600),
						'SerialAjax'    => $serial_ajax,
						'Scripts' 		=> '<script type="text/javascript" src="'.$lien.'public/js/setup.js"></script>',
						'FilArianne'    => $cache_tpl['FilArianne'],
						'Titre'         => $cache_tpl['Titre'])
					);
		}
		else
		{
			$tpl -> assign(array(
						'ListeMaps'     => '<a href="'.$lien.'setup/ProGameMap.application?id=123456789&pid=1&sid=2">Valider</a>',
						'PUB2'          => Pub(160,600),
						'SerialAjax'    => $serial_ajax,
						'Scripts' 		=> '<script type="text/javascript" src="'.$lien.'public/js/setup.js"></script>',
						'FilArianne'    => DisplayArianne($Arianne),
						'Titre'         => ucfirst(SETUP))
					);
		}
		
		// fin de la page setup.exe
		break;
	}
	
}

$tpl->ConstructEndPage(2);

if(!$param[3])
{
	$mooflow = "<script type='text/javascript' src='".$lien."public/js/MooFlow.js'></script>
				<script type='text/javascript'>
				var myMooFlowPage = { start: function(){ var mf = new MooFlow($('MooFlow'), {
							startIndex: 1,
							bgColor: 'transparent',
							useAutoPlay: false,
							useCaption: true,
							useMouseWheel: true,
							useKeyInput: true,
							'onClickView': function(e){
								alert(e.title);
							}
						});
					}
				
				};
				window.addEvent('domready', myMooFlowPage.start);
				</script>";
}

$tpl -> assign(array('Scripts' => '</script><script type="text/javascript" src="'.$lien.'public/js/setup.js"></script>'.$mooflow.'{$Scripts}',
					 'FilArianne' => DisplayArianne($Arianne)));

// on efface la variable listing maps
//$_SESSION['listing_maps'] = array();
?>