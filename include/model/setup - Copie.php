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

// Choix du type de la page (ici type par default)
$tpl->ConstructPage(2);

// Tlink pour images
$lien = Tlink($param);

// serial de securisation de la connection ajax
$serial_ajax = sbox_function::secu_ajax();


                ///////////////////////////////////////////////////////////////////////////////////
                //                        CHOIX DE LA PAGE ( et création ONGLET)               	 //
                ///////////////////////////////////////////////////////////////////////////////////

// création du menu onglet
switch($param[4])
{
	default:
		$onglet = '<span class="onglet onglet-actif">'.MAP_LIST.'</span>'
				. '<a class="onglet" href="'.$lien.Plink($param,4,1,FAVORITES).'">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</a>'
				. '<a class="onglet" href="'.$lien.Plink($param,4,1,CART).'">'.ucfirst(MY).' '.ucfirst(CART).'</a>'
				. '<div class="spacer"></div>';
		break;
	case FAVORITES:
		$onglet = '<a class="onglet" href="'.$lien.Plink($param,3,1,strtolower($game['name'])).'">'.MAP_LIST.'</a>'
				. '<span class="onglet onglet-actif">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</span>'
				. '<a class="onglet" href="'.$lien.Plink($param,4,1,CART).'">'.ucfirst(MY).' '.ucfirst(CART).'</a>'
				. '<div class="spacer"></div>';
		break;
	case CART:
		$onglet = '<a class="onglet" href="'.$lien.Plink($param,3,1,strtolower($game['name'])).'">'.MAP_LIST.'</a>'
				. '<a class="onglet" href="'.$lien.Plink($param,4,1,FAVORITES).'">'.ucfirst(MYs).' '.ucfirst(FAVORITES).'</a>'
				. '<span class="onglet onglet-actif">'.ucfirst(MY).' '.ucfirst(CART).'</span>'
				. '<div class="spacer"></div>';
		break;

}

// choix de la page en fonction de l'onglet demander ( default = listing des maps)
switch($param[4])
{
default:	
	
					///////////////////////////////////////////////////////////////////////////////////
					//                                CACHE PAGE (APC VAR)                           //
					///////////////////////////////////////////////////////////////////////////////////		
	
	if(sbox_cache::get(Plink($param)) == false)
	{
		// definie le nombre de maps par page
		$map_by_page = 36;
		
		// initialisation des filtres d'affichage
		$filtre = NULL;
		$filtre_id = NULL;
		$type_liste_name = array();
		$f_type = array();
		$listing_maps = array();
		
		// Définition du fil d'arrianne
		$Arianne = array(1 => array('titre' => ucfirst(HOME),
								'lien'  => $lien.'index.php'),
					 	 2 => array('titre' => ucfirst(SETUP),
								'lien'  => $lien.Plink($param,2,1)),
 					 	 3 => array('titre' => ucfirst($param[3]),
								'lien'  => $lien.Plink($param,3,1,$param[3])));


		
						///////////////////////////////////////////////////////////////////////////////////
						//                                LISTING DES JEUX                               //
						///////////////////////////////////////////////////////////////////////////////////
						
		// on verifie si le listing n'est pas deja present en cache sinon on check la base de donné
		if(sbox_cache::get('listing_games') == false)
		{
			$temp_games = $sbox->select_multi(array('table'=>'games','select'=>'*','where'=>'`actif`=/1/','order by'=>'name_plus ASC','high_priority'=>'1'));
			sbox_cache::add('listing_games',$temp_games,3600);
		}
		$listing_games = sbox_cache::get('listing_games');
		
		/*
		// on recupère les jeux et on les stocks en session si il n'y sont pas deja
		if(count($_SESSION['listing_games']) == '0'){
			$_SESSION['listing_games'] = $sbox->select_multi(array('table'=>'games','select'=>'*','where'=>'`actif`=/1/','order by'=>'name_plus ASC','high_priority'=>'1'));
		}
		*/
						
		// si le jeux voulue est definie dans l'url et et différent de la session on force l'url
		if($param[3] != "" )
		{
			/*
			if($param[3] != strtolower($_SESSION['listing_maps'][0]['name']))
			{
				// on l'efface entièrement et on attribue le nouveau nom du jeux
				$_SESSION['listing_maps'] = array();
				$_SESSION['listing_maps'][0]['name'] = strtoupper($param[3]);
			}
			*/
			$listing_maps[0]['name'] = strtoupper($param[3]);
		}
		
		// on affiche tous les jeux en assigant au template setup
		foreach($listing_games as $game)
		{
			// affiche les loaders si listing_map existe et correspond au jeux en cours
			if($listing_maps[0]['name'] == $game['name'])
			{
				$display = 'block';
			}
			else
			{
				$display = 'none';
			}
		
			$liste_games    .= "<div id=\"d_".$game['name']."\" name=\"d_".$game['name']."\" style=\"width:250px;\">"
							. "<table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
							. "<tr nowrap valign=\"middle\">"
							. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
							. "<td width=\"5\">&nbsp;</td>"
							. "<td width=\"209\" height=\"25\"><a id=\"".$game['name']."\" name=\"".$game['name']."\" class=\"g_\" href=\"".$lien.Plink($param,3,1,strtolower($game['name']))."\" style=\"text-decoration: none;\">".$game['name_plus']." (".$game['nb_maps'].")</a></td>"
							. "<td width=\"16\"><div class=\"load_mini\" id=\"load_".$game['name']."\" name=\"load_".$game['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" /></div></td>"
							. "</tr>"
							. "</table>"
							. "</div>";
			
		}
		
		
						///////////////////////////////////////////////////////////////////////////////////
						//                            LISTING DES MODES (Filtre)                         //
						///////////////////////////////////////////////////////////////////////////////////
						
		
		/*				
		// on recupère les mode de jeux et on les stocks en session si il n'y sont pas deja
		if(count($_SESSION['listing_mode']) == '0'){
			$_SESSION['listing_mode'] = $sbox->select_multi(array('table'=>'mode_maps','select'=>'*','order by'=>'name_plus ASC','high_priority'=>'1'));
		}
		*/
		// on verifie si le listing des mode n'est pas deja present en cache sinon on check la base de donné
		if(sbox_cache::get('listing_mode') == false)
		{
			$temp_modes = $sbox->select_multi(array('table'=>'mode_maps','select'=>'*','order by'=>'name_plus ASC','high_priority'=>'1'));
			sbox_cache::add('listing_mode',$temp_modes,3600);
			$temp_modes=NULL;
		}
		$listing_mode = sbox_cache::get('listing_mode');
		
		// on affiche tous les mode en assigant au template setup et on attribue le filtrage au passage si demandé
		$liste_modes    .= "<div id=\"f_ALL\" name=\"f_ALL\" style=\"width:250px;\">"
						. "<table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
						. "<tr nowrap valign=\"middle\">"
						//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
						. "<td width=\"25\">&nbsp;</td>"
						. "<td width=\"209\" height=\"25\"><a id=\"ALL\" name=\"ALL\" class=\"f_\" href=\"".$lien.Plink_name($param_name,'mode','-1')."\" style=\"text-decoration: none;\">Tous les Modes</a></td>"
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
				$display = 'block';
			}
			else
			{
				$display = 'none';
			}
			
			$liste_modes    .= "<div id=\"f_".$mode['name']."\" name=\"f_".$mode['name']."\" style=\"width:250px;\">"
							. "<table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
							. "<tr nowrap valign=\"middle\">"
							//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
							. "<td width=\"25\">&nbsp;</td>"
							. "<td width=\"209\" height=\"25\"><a id=\"".$mode['name']."\" name=\"".$mode['name']."\" class=\"f_\" href=\"".$lien.Plink_name($param_name,'mode',$mode['name'])."\" style=\"text-decoration: none;\">".$mode['name_plus']."</a></td>"
							. "<td width=\"16\"><div class=\"load_mini\" id=\"load_".$mode['name']."\" name=\"load_".$mode['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" /></div></td>"
							. "</tr>"
							. "</table>"
							. "</div>";
			
		}
		
						
						///////////////////////////////////////////////////////////////////////////////////
						//                                LISTING DES TYPES                              //
						///////////////////////////////////////////////////////////////////////////////////
						
		/*				
		// on recupère les types de maps et on les stocks en session si il n'y sont pas deja
		if(count($_SESSION['listing_type']) == '0'){
			$_SESSION['listing_type'] = $sbox->select_multi(array('table'=>'type_maps','select'=>'*','order by'=>'name_plus ASC','high_priority'=>'1'));
		}
		*/
			// on verifie si le listing des mode n'est pas deja present en cache sinon on check la base de donné
		if(sbox_cache::get('listing_type') == false)
		{
			$temp_type = $sbox->select_multi(array('table'=>'type_maps','select'=>'*','order by'=>'name_plus ASC','high_priority'=>'1'));
			sbox_cache::add('listing_type',$temp_type,3600);
			$temp_type=NULL;
		}
		$listing_type = sbox_cache::get('listing_type');
							
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
				$display = 'block';    
			}
			else
			{
				$check = "";
				$display = 'none';
			}
			
			$liste_types    .= "<div id=\"t_".$type['name']."\" name=\"t_".$type['name']."\" style=\"width:250px;\">"
							. "<table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
							. "<tr nowrap valign=\"middle\">"
							//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
							. "<td width=\"25\">&nbsp;</td>"
							. "<td width=\"209\" height=\"25\"><label><input class=\"t_f\" name=\"".$type['name']."\" id=\"".$type['name']."\" type=\"checkbox\" value=\"".$type['name']."\" ".$check."\" />".$type['name_plus']."</label></td>"
							//<a id=\"".$type['name']."\" name=\"".$type['name']."\" class=\"t_\" href=\"".$lien.Plink_name($param_name,'type',$type['name'])."\" style=\"text-decoration: none;\">".$type['name_plus']."</a>
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
		
		//$liste_types .= "<div style=\"text-align:center\"><br><br><input id=\"types_filtre\" name=\"types_filtre\" type=\"button\" value=\"Filtrer\"></div>"
		  //              . "<input type=\"hidden\" name=\"link_t\" id=\"link_t\" value=\"http://".$_SERVER['HTTP_HOST']."/".Plink_name($param_name,'type','-1')."\" />";
		
		
						///////////////////////////////////////////////////////////////////////////////////
						//                                LISTING DES MAPS                               //
						///////////////////////////////////////////////////////////////////////////////////
						
		
		//on liste les maps si listing maps dispo ou demandé
		//if( ((count($_SESSION['listing_maps'])-1) <= 0) && ($param[3] != "") )
		if(sbox_cache::get('listing_maps_'.$listing_maps[0]['name'].'') == false)
		{
			// si demandé via url
			
			// MEME CHOSE QUE setup_maps.php en gros
			
			// on liste toute les maps
			$maps = $sbox->select_multi(array('table'=>'`maps_'.$listing_maps[0]['name'].'`','select'=>'id,name,type,mode,images,stats_dl,note'));
			
			$i=1;
			foreach($maps as $map)
			{        
				// on prend la première images seulement
				$images = array();
				$images = explode(';',$map['images'],2);
				
				$listing_maps[$i]['id'] = $map['id'];
				$listing_maps[$i]['name'] = $map['name'];
				$listing_maps[$i]['type'] = $map['type'];
				$listing_maps[$i]['mode'] = $map['mode'];
				$listing_maps[$i]['image'] = $images[0];
				$listing_maps[$i]['stats_dl'] = $map['stats_dl'];
				$listing_maps[$i]['note'] = $map['note'];
				$i++;
			}
			
			//sauvegarde en cache
			sbox_cache::add('listing_maps_'.$listing_maps[0]['name'].'',$listing_maps,3600);
		}
		else
		{
			$listing_maps = sbox_cache::get('listing_maps_'.$listing_maps[0]['name'].'');
		}
		
		if((count($listing_maps)-1) > 0)
		{
			// si listing_maps dispo
			$map = array();
			$i=0;
			$compteur_map=0;
			$liste_maps = '';    
			
			// pagination
			$page = $param[$param_name['page']+1]-1;
			if($page == -1)
			{
				$page = 0;
			}
			
			// autorise l'affichage de la maps ( reference au filtre )
			$affiche = 1;
			
			foreach($listing_maps as $map)
			{
				// on saute la première clé qui est le nom du jeux et on affiche que 36 maps par page
				$affiche = 1;
				if( ($i>0) && ($i>=($page*$map_by_page)) && ( ($i<(($page*$map_by_page)+$map_by_page)) || ($compteur_map < $map_by_page) ) )
				{
					// application du filtre mode si demandé
					if($filtre_id != NULL) 
					{
						if(strpos($map['mode'],$filtre_id.";") === FALSE)
						{
							$affiche = 0;
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
									break;    
								}
							}
						}
						
					}           
					
					// afficage de la maps si autorisé par le filtre, si pas de filtre tous est autorisé
					if($affiche == 1)
					{
						$class="class=\"high_load\" style=\"display:block;\"";
		
						$liste_maps .= "<div id=\"m_".$map['name']."\" name=\"m_".$map['name']."\" style=\"float:left; width:170px; float:left; padding-top:10px;\">"
									. "<div ".$div_s.">"
									. "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"170\">"
									. "<tr>"
									//. "<td width=\"160\" height=\"120\" colspan=\"2\"><iframe scrolling=\"no\" frameborder=\"0\" marginwidth=\"0\" src=\"".$lien."public/img_view.php?img=".$_SESSION['listing_maps'][0]['name']."/".$map['image']."\" width=\"160\" height=\"120\"></iframe></td>"
									. "<td width=\"160\" height=\"120\" colspan=\"2\"><iframe ".$class." id=\"m_".$map['name']."\" name=\"m_".$map['name']."\" src=\"http://www.progamemap.com/public/img_view.php?img=http://dog.fpsbanana.com/ss/maps/thm_20450.jpg\" scrolling=\"no\" frameborder=\"0\" marginwidth=\"0\" width=\"160\" height=\"120\"></iframe></td>"
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
									. "<td colspan=\"2\" style=\"text-align:center;\"><a id=\"".$map['id']."\" name=\"".$map['id']."\" class=\"p_add\" href=\"".$lien.Plink($param,3,1,strtolower($game['name']))."\" style=\"text-decoration: none;\">Ajouter</a></td>"
									. "</tr>"
									. "</table>"
									. "</div>"
									. "</div>";
						
						$compteur_map++;
					}        
				}
				$i++;
			}
			
			// si il y a aucune map a afficher
			if($compteur_map == 0)
			{
				$liste_maps .= "<div id=\"no_map\" name=\"no_map\" style=\"text-align:center;\">Aucune Map !</div>";
			}    
		}
		
		// affichage de la pagination
		$n_map = count($listing_maps)-1;
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
				$view_page .= "<a href=\"".$lien.Plink_name($param_name,'page',$n)."\">".$n."</a> - ";
			}
			
			$paging .= '<td width="50"><a href="'.$lien.Plink_name($param_name,'page',$n_prec).'"><img src="'.$lien.'public/images/fleche_g.png" width="19" height="18" alt="" border="0" /></a></td>'
					. '<td nowrap>'.$view_page.'</td>'
					. '<td width="50"><a href="'.$lien.Plink_name($param_name,'page',$n_suiv).'"><img src="'.$lien.'public/images/fleche_d.png" width="19" height="18" alt="" border="0" /></a></td>';
		}
		else
		{
			$paging = '<td colspan="3" width="120"></td>';
		}
		
		// SAUVEGARDE CACHE
		sbox_cache::add(Plink($param),array(
									'ListeGames'    => $liste_games,
									'ListeModes'    => $liste_modes,
									'ListeTypes'    => $tab_types,
									'ListeMaps'     => $liste_maps,
									'Paging'        => $paging,
									'FilArianne'    => DisplayArianne($Arianne),
									'Titre'         => ucfirst(SETUP)),900);
	}
	
	// recuperation des donnée en cache
	$cache_tpl = sbox_cache::get(Plink($param));
						
	$tpl -> GetTpl('setup');
	$tpl -> assign(array(
				'ListeGames'    => $cache_tpl['ListeGames'],
				'ListeModes'    => $cache_tpl['ListeModes'],
				'ListeTypes'    => $cache_tpl['ListeTypes'],
				'MenuOnglet'     => $onglet,
				'ListeMaps'     => $cache_tpl['ListeMaps'],
				'Paging'        => $cache_tpl['Paging'],
				'PUB2'          => Pub(160,600),
				'SerialAjax'    => $serial_ajax,
				'Scripts' 		=> '<script type="text/javascript" src="'.$lien.'public/js/setup.js"></script>',
				'FilArianne'    => $cache_tpl['FilArianne'],
				'Titre'         => $cache_tpl['Titre'])
			);
	
	// fin de la page listing des maps
	break;

case FAVORITES:
					///////////////////////////////////////////////////////////////////////////////////
					//                                CACHE PAGE (APC VAR)                           //
					///////////////////////////////////////////////////////////////////////////////////		
	
	if(sbox_cache::get(Plink($param)) == false)
	{
		// definie le nombre de maps par page
		$map_by_page = 36;
		
		// initialisation des filtres d'affichage
		$filtre = NULL;
		$filtre_id = NULL;
		$type_liste_name = array();
		$f_type = array();
		$listing_maps = array();
		
		// Définition du fil d'arrianne
		$Arianne = array(1 => array('titre' => ucfirst(HOME),
								'lien'  => $lien.'index.php'),
					 	 2 => array('titre' => ucfirst(SETUP),
								'lien'  => $lien.Plink($param,2,1)),
 					 	 3 => array('titre' => ucfirst($param[3]),
								'lien'  => $lien.Plink($param,3,1,$param[3])),
 					 	 4 => array('titre' => ucfirst(MYs).' '.ucfirst(FAVORITES),
								'lien'  => $lien.Plink($param,4,1,FAVORITES)));

		
						///////////////////////////////////////////////////////////////////////////////////
						//                                LISTING DES JEUX                               //
						///////////////////////////////////////////////////////////////////////////////////
						
		// on verifie si le listing n'est pas deja present en cache sinon on check la base de donné
		if(sbox_cache::get('listing_games') == false)
		{
			$temp_games = $sbox->select_multi(array('table'=>'games','select'=>'*','where'=>'`actif`=/1/','order by'=>'name_plus ASC','high_priority'=>'1'));
			sbox_cache::add('listing_games',$temp_games,3600);
		}
		$listing_games = sbox_cache::get('listing_games');
		
		/*
		// on recupère les jeux et on les stocks en session si il n'y sont pas deja
		if(count($_SESSION['listing_games']) == '0'){
			$_SESSION['listing_games'] = $sbox->select_multi(array('table'=>'games','select'=>'*','where'=>'`actif`=/1/','order by'=>'name_plus ASC','high_priority'=>'1'));
		}
		*/
						
		// si le jeux voulue est definie dans l'url et et différent de la session on force l'url
		if($param[3] != "" )
		{
			/*
			if($param[3] != strtolower($_SESSION['listing_maps'][0]['name']))
			{
				// on l'efface entièrement et on attribue le nouveau nom du jeux
				$_SESSION['listing_maps'] = array();
				$_SESSION['listing_maps'][0]['name'] = strtoupper($param[3]);
			}
			*/
			$listing_maps[0]['name'] = strtoupper($param[3]);
		}
		
		// on affiche tous les jeux en assigant au template setup
		foreach($listing_games as $game)
		{
			// affiche les loaders si listing_map existe et correspond au jeux en cours
			if($listing_maps[0]['name'] == $game['name'])
			{
				$display = 'block';
			}
			else
			{
				$display = 'none';
			}
		
			$liste_games    .= "<div id=\"d_".$game['name']."\" name=\"d_".$game['name']."\" style=\"width:250px;\">"
							. "<table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
							. "<tr nowrap valign=\"middle\">"
							. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
							. "<td width=\"5\">&nbsp;</td>"
							. "<td width=\"209\" height=\"25\"><a id=\"".$game['name']."\" name=\"".$game['name']."\" class=\"g_\" href=\"".$lien.Plink($param,3,1,strtolower($game['name']))."\" style=\"text-decoration: none;\">".$game['name_plus']." (".$game['nb_maps'].")</a></td>"
							. "<td width=\"16\"><div class=\"load_mini\" id=\"load_".$game['name']."\" name=\"load_".$game['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" /></div></td>"
							. "</tr>"
							. "</table>"
							. "</div>";
			
		}
		
		
						///////////////////////////////////////////////////////////////////////////////////
						//                            LISTING DES MODES (Filtre)                         //
						///////////////////////////////////////////////////////////////////////////////////
						
		
		/*				
		// on recupère les mode de jeux et on les stocks en session si il n'y sont pas deja
		if(count($_SESSION['listing_mode']) == '0'){
			$_SESSION['listing_mode'] = $sbox->select_multi(array('table'=>'mode_maps','select'=>'*','order by'=>'name_plus ASC','high_priority'=>'1'));
		}
		*/
		// on verifie si le listing des mode n'est pas deja present en cache sinon on check la base de donné
		if(sbox_cache::get('listing_mode') == false)
		{
			$temp_modes = $sbox->select_multi(array('table'=>'mode_maps','select'=>'*','order by'=>'name_plus ASC','high_priority'=>'1'));
			sbox_cache::add('listing_mode',$temp_modes,3600);
			$temp_modes=NULL;
		}
		$listing_mode = sbox_cache::get('listing_mode');
		
		// on affiche tous les mode en assigant au template setup et on attribue le filtrage au passage si demandé
		$liste_modes    .= "<div id=\"f_ALL\" name=\"f_ALL\" style=\"width:250px;\">"
						. "<table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
						. "<tr nowrap valign=\"middle\">"
						//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
						. "<td width=\"25\">&nbsp;</td>"
						. "<td width=\"209\" height=\"25\"><a id=\"ALL\" name=\"ALL\" class=\"f_\" href=\"".$lien.Plink_name($param_name,'mode','-1')."\" style=\"text-decoration: none;\">Tous les Modes</a></td>"
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
				$display = 'block';
			}
			else
			{
				$display = 'none';
			}
			
			$liste_modes    .= "<div id=\"f_".$mode['name']."\" name=\"f_".$mode['name']."\" style=\"width:250px;\">"
							. "<table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
							. "<tr nowrap valign=\"middle\">"
							//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
							. "<td width=\"25\">&nbsp;</td>"
							. "<td width=\"209\" height=\"25\"><a id=\"".$mode['name']."\" name=\"".$mode['name']."\" class=\"f_\" href=\"".$lien.Plink_name($param_name,'mode',$mode['name'])."\" style=\"text-decoration: none;\">".$mode['name_plus']."</a></td>"
							. "<td width=\"16\"><div class=\"load_mini\" id=\"load_".$mode['name']."\" name=\"load_".$mode['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" /></div></td>"
							. "</tr>"
							. "</table>"
							. "</div>";
			
		}
		
						
						///////////////////////////////////////////////////////////////////////////////////
						//                                LISTING DES TYPES                              //
						///////////////////////////////////////////////////////////////////////////////////
						
		/*				
		// on recupère les types de maps et on les stocks en session si il n'y sont pas deja
		if(count($_SESSION['listing_type']) == '0'){
			$_SESSION['listing_type'] = $sbox->select_multi(array('table'=>'type_maps','select'=>'*','order by'=>'name_plus ASC','high_priority'=>'1'));
		}
		*/
			// on verifie si le listing des mode n'est pas deja present en cache sinon on check la base de donné
		if(sbox_cache::get('listing_type') == false)
		{
			$temp_type = $sbox->select_multi(array('table'=>'type_maps','select'=>'*','order by'=>'name_plus ASC','high_priority'=>'1'));
			sbox_cache::add('listing_type',$temp_type,3600);
			$temp_type=NULL;
		}
		$listing_type = sbox_cache::get('listing_type');
							
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
				$display = 'block';    
			}
			else
			{
				$check = "";
				$display = 'none';
			}
			
			$liste_types    .= "<div id=\"t_".$type['name']."\" name=\"t_".$type['name']."\" style=\"width:250px;\">"
							. "<table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
							. "<tr nowrap valign=\"middle\">"
							//. "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
							. "<td width=\"25\">&nbsp;</td>"
							. "<td width=\"209\" height=\"25\"><label><input class=\"t_f\" name=\"".$type['name']."\" id=\"".$type['name']."\" type=\"checkbox\" value=\"".$type['name']."\" ".$check."\" />".$type['name_plus']."</label></td>"
							//<a id=\"".$type['name']."\" name=\"".$type['name']."\" class=\"t_\" href=\"".$lien.Plink_name($param_name,'type',$type['name'])."\" style=\"text-decoration: none;\">".$type['name_plus']."</a>
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
		
		//$liste_types .= "<div style=\"text-align:center\"><br><br><input id=\"types_filtre\" name=\"types_filtre\" type=\"button\" value=\"Filtrer\"></div>"
		  //              . "<input type=\"hidden\" name=\"link_t\" id=\"link_t\" value=\"http://".$_SERVER['HTTP_HOST']."/".Plink_name($param_name,'type','-1')."\" />";
		
		
						///////////////////////////////////////////////////////////////////////////////////
						//                                LISTING DES MAPS                               //
						///////////////////////////////////////////////////////////////////////////////////
						
		
		//on liste les maps si listing maps dispo ou demandé
		//if( ((count($_SESSION['listing_maps'])-1) <= 0) && ($param[3] != "") )
		if(sbox_cache::get('listing_maps_'.$listing_maps[0]['name'].'') == false)
		{
			// si demandé via url
			
			// MEME CHOSE QUE setup_maps.php en gros
			
			// on liste toute les maps
			$maps = $sbox->select_multi(array('table'=>'`maps_'.$listing_maps[0]['name'].'`','select'=>'id,name,type,mode,images,stats_dl,note'));
			
			$i=1;
			foreach($maps as $map)
			{        
				// on prend la première images seulement
				$images = array();
				$images = explode(';',$map['images'],2);
				
				$listing_maps[$i]['id'] = $map['id'];
				$listing_maps[$i]['name'] = $map['name'];
				$listing_maps[$i]['type'] = $map['type'];
				$listing_maps[$i]['mode'] = $map['mode'];
				$listing_maps[$i]['image'] = $images[0];
				$listing_maps[$i]['stats_dl'] = $map['stats_dl'];
				$listing_maps[$i]['note'] = $map['note'];
				$i++;
			}
			
			//sauvegarde en cache
			sbox_cache::add('listing_maps_'.$listing_maps[0]['name'].'',$listing_maps,3600);
		}
		else
		{
			$listing_maps = sbox_cache::get('listing_maps_'.$listing_maps[0]['name'].'');
		}
		
		if((count($listing_maps)-1) > 0)
		{
			// si listing_maps dispo
			$map = array();
			$i=0;
			$compteur_map=0;
			$liste_maps = '';    
			
			// pagination
			$page = $param[$param_name['page']+1]-1;
			if($page == -1)
			{
				$page = 0;
			}
			
			// autorise l'affichage de la maps ( reference au filtre )
			$affiche = 1;
			
			foreach($listing_maps as $map)
			{
				// on saute la première clé qui est le nom du jeux et on affiche que 36 maps par page
				$affiche = 1;
				if( ($i>0) && ($i>=($page*$map_by_page)) && ( ($i<(($page*$map_by_page)+$map_by_page)) || ($compteur_map < $map_by_page) ) )
				{
					// application du filtre mode si demandé
					if($filtre_id != NULL) 
					{
						if(strpos($map['mode'],$filtre_id.";") === FALSE)
						{
							$affiche = 0;
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
									break;    
								}
							}
						}
						
					}           
					
					// afficage de la maps si autorisé par le filtre, si pas de filtre tous est autorisé
					if($affiche == 1)
					{
						$class="class=\"high_load\" style=\"display:block;\"";
		
						$liste_maps .= "<div id=\"m_".$map['name']."\" name=\"m_".$map['name']."\" style=\"float:left; width:170px; float:left; padding-top:10px;\">"
									. "<div ".$div_s.">"
									. "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"170\">"
									. "<tr>"
									//. "<td width=\"160\" height=\"120\" colspan=\"2\"><iframe scrolling=\"no\" frameborder=\"0\" marginwidth=\"0\" src=\"".$lien."public/img_view.php?img=".$_SESSION['listing_maps'][0]['name']."/".$map['image']."\" width=\"160\" height=\"120\"></iframe></td>"
									. "<td width=\"160\" height=\"120\" colspan=\"2\"><iframe ".$class." id=\"m_".$map['name']."\" name=\"m_".$map['name']."\" src=\"http://www.progamemap.com/public/img_view.php?img=http://dog.fpsbanana.com/ss/maps/thm_20450.jpg\" scrolling=\"no\" frameborder=\"0\" marginwidth=\"0\" width=\"160\" height=\"120\"></iframe></td>"
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
									. "<td colspan=\"2\" style=\"text-align:center;\"><a id=\"".$map['id']."\" name=\"".$map['id']."\" class=\"p_add\" href=\"".$lien.Plink($param,3,1,strtolower($game['name']))."\" style=\"text-decoration: none;\">Ajouter</a></td>"
									. "</tr>"
									. "</table>"
									. "</div>"
									. "</div>";
						
						$compteur_map++;
					}        
				}
				$i++;
			}
			
			// si il y a aucune map a afficher
			if($compteur_map == 0)
			{
				$liste_maps .= "<div id=\"no_map\" name=\"no_map\" style=\"text-align:center;\">Aucune Map !</div>";
			}    
		}
		
		// affichage de la pagination
		$n_map = count($listing_maps)-1;
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
				$view_page .= "<a href=\"".$lien.Plink_name($param_name,'page',$n)."\">".$n."</a> - ";
			}
			
			$paging .= '<td width="50"><a href="'.$lien.Plink_name($param_name,'page',$n_prec).'"><img src="'.$lien.'public/images/fleche_g.png" width="19" height="18" alt="" border="0" /></a></td>'
					. '<td nowrap>'.$view_page.'</td>'
					. '<td width="50"><a href="'.$lien.Plink_name($param_name,'page',$n_suiv).'"><img src="'.$lien.'public/images/fleche_d.png" width="19" height="18" alt="" border="0" /></a></td>';
		}
		else
		{
			$paging = '<td colspan="3" width="120"></td>';
		}
		
		// SAUVEGARDE CACHE
		sbox_cache::add(Plink($param),array(
									'ListeGames'    => $liste_games,
									'ListeModes'    => $liste_modes,
									'ListeTypes'    => $tab_types,
									'ListeMaps'     => $liste_maps,
									'Paging'        => $paging,
									'FilArianne'    => DisplayArianne($Arianne),
									'Titre'         => ucfirst(SETUP)),900);
	}
	
	// recuperation des donnée en cache
	$cache_tpl = sbox_cache::get(Plink($param));
						
	$tpl -> GetTpl('setup');
	$tpl -> assign(array(
				'ListeGames'    => $cache_tpl['ListeGames'],
				'ListeModes'    => $cache_tpl['ListeModes'],
				'ListeTypes'    => $cache_tpl['ListeTypes'],
				'MenuOnglet'    => $onglet,
				'ListeMaps'     => $cache_tpl['ListeMaps'],
				'Paging'        => $cache_tpl['Paging'],
				'PUB2'          => Pub(160,600),
				'SerialAjax'    => $serial_ajax,
				'FilArianne'    => $cache_tpl['FilArianne'],
				'Titre'         => $cache_tpl['Titre'])
			);
	
	// fin de la page listing des maps
	break;
case CART:
	break;
}
$tpl->ConstructEndPage(2);

$tpl -> assign(array(
			'Scripts' 		=> '<script type="text/javascript" src="'.$lien.'public/js/setup.js"></script>{$Scripts}'));

// on efface la variable listing maps
//$_SESSION['listing_maps'] = array();
?>
