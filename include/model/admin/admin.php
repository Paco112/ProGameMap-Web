<?php

//********************************************************************************************
//********************************************************************************************
// Admin
// Administration du site.
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 03/09/2008
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
if (eregi("admin.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

$tpl->ConstructPage(3);

/**
 * On regarde le 3eme paramètre Url, après /admin/
 **/
switch($param[3]){

	/**
	 * Partie gestion des set de permissions
	 **/
	case PERMISSIONS:
	
		switch($param[4]){ // Différents paraèmtres, dont notemment modification, supression, etc...
			
			default:
			
				$tpl->GetTpl('admin/permissions');
				
				// Récupération de la liste des permissions, prochainement mise sous cache
				$getPerm = $sbox->select_multi(array('table'=>'site_permissions','select'=>'*','high_priority'=>'1'));
		
				$i = 1;
			
				if(is_array($getPerm)){ // On vérifie que le résultat de la requête est bien un tableau afin de ne pas provoquer d'erreur sur le foreach
					
					$NewPerm = '<tr>
					<td class="tablerow1"><strong>Base this permission set on which existing set...</strong></td>
					<td class="tablerow2"><select name="new_perm_copy" class="dropdown">';
					
					foreach($getPerm as $Perm){
					
						$PermContent .= '
						<tr>
							<td class="tablerow2"><strong>'.$Perm['name'].'</strong></td>
							<td class="tablerow1">· '.getGroup($Perm['groups']).'<br></td>
							<td class="tablerow1" align="center">'.$Perm['users'].'</td>															
							<td class="tablerow1" align="center"><img class="popup ipd" name="menu'.$i.'" style="cursor: pointer;" id="menu'.$i.'" src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/filebrowser_action.gif" alt="Options" border="0" />
							<div class="popupmenu" id="menu'.$i.'_menu" style="position: absolute; z-index: 100; margin-top:-2px; opacity:0">
								<div class="menusep">
								<img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/icons_menu/view.gif" alt="V" class="ipd" border="0">&nbsp; <a href="" title="See what this group can see..">Preview...</a>
								</div>
								
								<div class="menuseplast">
								<img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/icons_menu/edit.gif" alt="V" class="ipd" border="0">&nbsp; <a href="http://www.progamemap.com/fr/admin/permissions/modifier/'.str_replace(CHR(32),"",strtolower($Perm['name'])).'/">Edit...</a>
								</div>
							</div>
							</td>
						</tr>';
						
						$NewPerm .= '<option value="'.$i.'">'.$Perm['name'].'</option>';
						
						$i++;
					}
					
					$NewPerm .= '</select></td></tr>';
					
				} else {
					$PermContent = '';
					$NewPerm = '';
				}
				
				$tpl->assign(array('PermContent' 	=> $PermContent,
								   'NewPerm'		=> $NewPerm));
				
				break;
		
			case 'modifier':
			
				$tpl->GetTpl('admin/permissions_edit');
				
				// On met la liste des permissions sous forme de chaine.
				$getPerm = $sbox->select_multi(array('table'=>'site_permissions','select'=>'*','high_priority'=>'1'));
				foreach($getPerm as $Perm){
					/**
					 * On supprime les espaces et met la chaîne en minuscule.
					 **/
					$ListePerm .= str_replace(CHR(32),"",strtolower($Perm['name'])).',';
				}
				
				break;
		}
		
		break;
	
	/**
	* Partie de gestion du sitemap
	**/
	case SITEMAP:
	
		$tpl->GetTpl('admin/sitemap');
		
		if($param[4] == 'ajouter'){
			if($_POST['new_page_name'] != '' && $_POST['new_page_key'] != '' && $_POST['new_page_descri'] != ''){
				$PageInfos   = array();
				$PageInfos[] = array(
					'name'   => $_POST['new_page_name'],
					'key' 	 => $_POST['new_page_key'],
					'descri' => $_POST['new_page_descri']);
				
				$sbox->insert(array('table'=>'site_sitemap','set'=>$PageInfos));
				header('location: http://www.progamemap.com/fr/admin/sitemap/');
			} else {
				header('location: http://www.progamemap.com/fr/admin/sitemap/');
			}
		}
		
		if($param[4] == 'supprimer'){
			
		}
		
		$getPage = $sbox->select_multi(array('table'=>'site_sitemap','select'=>'*','high_priority'=>'1'));
		
		$i = 1;

		if($getPage != false){			
			foreach($getPage as $Page){
			
				$PageContent .= '
				<tr>
					<input type="hidden" id="id" value="'.$Page['id'].'">
					<td class="tablerow2 editable" id="name">'.$Page['name'].'</td>
					<td class="tablerow1 editable" style="font-size:10px;" id="url">'.$Page['key'].'<br></td>
					<td class="tablerow1 editable" style="font-size:10px;" id="url">'.$Page['description'].'<br></td>
					<td class="tablerow1" align="center"><img class="popup ipd" name="menu'.$i.'" style="cursor: pointer;" id="menu'.$i.'" src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/filebrowser_action.gif" alt="Options" border="0" />
					<div class="popupmenu" id="menu'.$i.'_menu" style="position: absolute; z-index: 100; margin-top:-2px; opacity:0">
						<div class="menuseplast">
						<img src="http://board.xnova-ng.org/skin_acp/IPB2_Standard/images/icons_menu/delete.gif" alt="V" class="ipd" border="0">&nbsp; <a href="http://www.progamemap.com/fr/admin/sitemap/supprimer/'.$Page['id'].'/">Delete</a>
						</div>
					</div>
					</td>
				</tr>';				
				$i++;
			}
						
		} else {
			$PageContent = '';
		}
		
		$tpl->assign(array('PageContent' 	=> $PageContent));
	
		break;
	
	default:
		
		$tpl->GetTpl('admin/admin');
		
		break;
}

$tpl->ConstructEndPage(3);

?>