<?php
		
		/*
		if($_POST){
			if($_POST['dname'] != ""){
				//$getProfil = $sbox->select_multi(array('table' => 'site_profil', 'select' => '*', 'where' => 'displayname=/'.$_POST['dname'].'/'));
				//if(count($getProfil) != 0){
					$link = $lien.Plink($param,3,1,USER).$_POST['dname'].'/';
					// remplacer : $lien.Plink_name($param,"user","albert",1)
					// supprimer : $lien.Plink_name($param,"user",-1, 1)
					header ("Location: $link");
				//}
			}
		}*/
		if($_SESSION['temp_profil'] != "")
		{
			$liste_profil = $_SESSION['temp_profil'];
			$_SESSION['temp_profil'] = "";
		}
		
		// limite de profil / page
		$limit_page = 25;
		if($param_name['page'] != "")
		{
			$page = $param[$param_name['page']+1];
		}
		else
		{
			$page = 1;
		}
		$page = $page - 1;
		
		$getProfil 	 = $sbox->select_multi(array('table' => 'site_users', 'select' => 'uid,displayname,teamID,teamRank', 'order by' => 'registration_date DESC', 'key' => 'uid', 'apc' =>'AllProfiles', 'apc_ttl'=>'600'));
		$getTeam 	 = $sbox->select_multi(array('table' => 'site_team', 'select' => 'id,name,tag,website', 'apc' =>'AllTeams', 'apc_ttl'=>'600'));
		$getTeamRank = $sbox->select_multi(array('table' => 'site_team_rank', 'select' => '*', 'apc' =>'site_team_rank', 'apc_ttl'=>'3600'));
		
		$nb_profil = count($getProfil);
		$nb_page = ($nb_profil/$limit_page);
		
		$count_profil = 0;
		$other_page_count = 0;
		$active_pagination = false;
		$Profil_Search = "";
		$Team_Search = "";
		
		$tab = '<table border="0" cellspacing="0" cellpadding="0" style="width:100%">
				<tr style="height:25px" valign="top">
					<td><strong>Team Tag</strong></td>
					  <td style="padding-left:20px;"><strong>Pseudo</strong></td>
					  <td style="padding-left:20px;"><strong>Team Name</strong></td>
				  	  <td style="padding-left:20px;"><strong>Team Rank</strong></td>
					</tr>';

		$i=0;
		if($param_name['search'] != "" && $param[$param_name['search']+1] != "")
		{
			if(preg_match('/^team\.(.*)/i',$param[$param_name['search']+1]))
			{
				$type = "team";
				$decoup = explode(".",$param[$param_name['search']+1],2);
				$search = $decoup[1];
				$Team_Search = $search;

			}
			else
			{
				$type = "user";
				$search = $param[$param_name['search']+1];
				$Profil_Search = $search;
			}
			$active_search = true;
		}
		else
		{
			$active_search = false;
		}
				
		foreach($getProfil as $profil)
		{
			// elimination des profil qui ne correspond pas a la recherhe
			if($active_search)
			{
				$view_profil = 0;
				
				if($type == "user")
				{
					if(preg_match('/'.$search.'/i',$profil['displayname']))
					{
						$view_profil = 1;
					}
				}
				elseif($type == "team")
				{
					if( (preg_match('/'.$search.'/i',$getTeam[$profil['teamID']]['tag'])) || (preg_match('/'.$search.'/i',$getTeam[$profil['teamID']]['name'])) )
					{
						$view_profil = 1;
					}
				}
			}
			else
			{
				$view_profil = 1;
			}
			
			if( ( ($i>=($page*$limit_page)) && ( ($i<(($page*$limit_page)+$limit_page)) || ($count_profil < $limit_page) ) ) && $view_profil == '1' )
			{
				// switch color
				if($count_profil%2)
				{
					$bgcolor = "#F0F0F0";
				}
				else
				{
					$bgcolor = "#FFF";
				}
				
				if($profil['teamRank'] != "")
				{
					$teamrank = constant($getTeamRank[$profil['teamRank']]['name']);
				}
				else
				{
					$teamrank = "";
				}
				
				$tab .= '<tr style="background-color:'.$bgcolor.'">
						  <td>'.$getTeam[$profil['teamID']]['tag'].'</td>
						  <td style="padding-left:20px;"><a href="'.$lien.$_SESSION['LANGUE'].'/'.PROFIL.'/'.USER.'/'.$profil['displayname'].'/">'.$profil['displayname'].'</a></td>
						  <td style="padding-left:20px;">'.$getTeam[$profil['teamID']]['name'].'</td>
						  <td style="padding-left:20px;">'.ucfirst($teamrank).'</td>
						</tr>';
				$count_profil++;
				if($count_profil >= $limit_page)
				{
					$active_pagination = true;
					break;
				}
			}
			elseif($view_profil == '1')
			{
				$other_page_count++;
			}
			
			
			$i++;
		}
		
		$tab .= "</table>";
		
		if($active_search)
		{
			$Stats_Liste = 'Résultat de la recherche : '.($count_profil+$other_page_count).' / '.$nb_profil.' Membres - <a href="'.$lien.Plink_name($param_name,'search','-1').'">Annuler la Recherche</a>';
		}
		else
		{
			$Stats_Liste = 'Il y a actuellement '.$nb_profil.' Membres.';
		}
		
		$liste_profil = $tab;
		
		/* PAGINATION */
		
		if($active_pagination || $page > 0 )
		{
		
			$n_page = ceil($nb_profil / $limit_page);
			
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
		
		if($paging != "")
		{
			$paging = '<ul class="pagination">'.$paging.'</ul>';
		}
		
		$scripts .= "<script type=\"text/javascript\" src=\"".$lien."public/js/pub.js\"></script>\n";
		$scripts .= "<script type=\"text/javascript\" src=\"".$lien."public/js/profil_search.js\"></script>\n";
		$tpl->assign(array('linkForm' 		=> $lien.Plink($param,3,1,"search"),
						   'ProfilSearch'	=> $Profil_Search,
						   'TeamSearch'		=> $Team_Search,
						   'StatsListe'		=> $Stats_Liste,
						   'ListeProfil'	=> $liste_profil,
						   'Paging'			=> $paging
		));
		
		
?>