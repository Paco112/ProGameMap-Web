<?php

//********************************************************************************************
//********************************************************************************************
// Profil
// Affichage du profil des utilisateurs
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 11/09/2008
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
if (preg_match("/profil.php/i", $_SERVER['PHP_SELF'])) {
      exit(0);
}

$Arianne = array(1 => array('titre' => 'Profil',
			   				'lien'  => $lien.Plink($param,2,1,PROFIL)));

switch ($param[3]){
	
	case USER :
		if($param[4] != ''){
			// On récupère la ligne relative à l'utilisateur, dans la table site_users.
			$getUser = $sbox->select_multi(array('table' => 'site_users', 'select' => '*', 'where' => 'displayname=/'.$param[4].'/'));
			
			foreach($getUser as $utilisateur){
				$uid = $utilisateur['uid'];
				$displaynamee = $utilisateur['displayname'];
				$register = $utilisateur['registration_date'];
				$pGroup = $utilisateur['primaryGroupID'];
			}
			
			$pGroup2 = explode(";", $pGroup);
			$pGroup = $pGroup2[0];
			
			// Si on a effectivement un retour, on continue..
			if($getUser != false){
				// .. et on récupère le profil correspondant.
				$getProfil = $sbox->select_multi(array('table' => 'site_profil', 'select' => '*', 'where' => 'uid=/'.$uid.'/', 'limit'=>'1'));
				
				foreach($getProfil as $profil){
					$presentation = trim($profil['presentation']);
					$sexe = $profil['sexe'];
					$birthday = $profil['birthday'];
					$originaire = $profil['localisation'];
					$lastVisitors = $profil['lastVisitors'];
					$contact_icq = $profil['contact_icq'];
					$contact_msn = $profil['contact_msn'];
					$site = trim($profil['url']);
				}
				
				$getGroup = $sbox->select_multi(array('table' => 'site_groups', 'select' => 'id, name, style', 'where' => 'id=/'.$pGroup.'/'));
				foreach($getGroup as $group){
					$gName  = $group['name'];
					$gStyle = $group['style'];
				}

				$utilisateurGroup = "<span style='$gStyle'>".ucfirst(constant($gName))."</span>";
				
				/**
				 * Il est possible de faire un test avec une structure beaucoup moins lourde grâce à la structure suivante, appelée opérateur ternaire :
				 * (condition) ? instruction si vrai : instruction si faux
				 * Google ==> "opérateur ternaire"
				 **/
				
				$presentation = ($presentation == '') ? $displaynamee.' n\'a pas de présentation personnelle pour le moment.' : $presentation;
				
				$visitors = explode(';', $lastVisitors);
				
				// Si la personne est loggé, et qu'elle ne regarde pas son propre profil :
				if($_SESSION['user']['dname'] != "" && $_SESSION['user']['dname'] != $displaynamee){
					// Mois en français
					$mois = array("Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Dec");
					// Mise en forme de la date sous la forme : 7 Sep 2009 - 11:05
					$dateNow = date("j").(date("j")==1 ? "er":" ").$mois[date("n")-1]." ".date("Y")." - ".date("G").":".date("i");
					// Mise en forme de l'enregistrement de la visite sous la forme : "Displayname|7 Sep 2009 - 11:05;"
					$lastVisitor = $_SESSION['user']['dname'].'|'.$dateNow;
					
					/************************************************************
					 * Manipulation du tableau de récap des 5 dernières visites *
					 ************************************************************/
					
					// Etape 1 : On vérifie que l'utilisateur n'est pas déja présent dans la liste
					// Si oui, on supprime son ancienne visite et met à jours la liste.
					for($i = 0; $i <= 4; $i++){
						$visiteur = explode('|', $visitors[$i]);
						if($visiteur[0] == $_SESSION['user']['dname']){
							$dejaPresentID = $i; // On isole l'id du tableau dans lequel est présent l'utilisateur
							$dejaPresent = 1;
						}
					}
					
					$nbrVisitors = count($visitors)-1;
					
					if($dejaPresent == 1){ // Si l'utilisateur était déja présent dans la liste...
						// ... On reconstruit un nouveau tableau, avec les valeurs a jours :
						for($i = 0; $i <= $nbrVisitors-1; $i++){
							if($dejaPresentID > $i){
								$newArrayVisitors[$i] = $visitors[$i];
							} elseif($dejaPresentID <= $i){
								$newArrayVisitors[$i] = $visitors[$i+1]; // La ligne ou l'utilisateur était présent est sautée
							}
						}
						
						$newArrayVisitors[$nbrVisitors-1] = $lastVisitor; // On ajoute en dernier l'utilisateur courant.
						$visitors = $newArrayVisitors;
					} else {
						if($nbrVisitors == 5){ // Si la liste est pleine
							$visitors[0] = $visitors[1];
							$visitors[1] = $visitors[2];
							$visitors[2] = $visitors[3];
							$visitors[3] = $visitors[4];
							$visitors[4] = $lastVisitor;
						} else {
							$visitors[$nbrVisitors] = $lastVisitor;
						}
					}
					
					$visitors[0] = ($visitors[0] != "") ? $visitors[0].';' : $visitors[0];
					$visitors[1] = ($visitors[1] != "") ? $visitors[1].';' : $visitors[1];
					$visitors[2] = ($visitors[2] != "") ? $visitors[2].';' : $visitors[2];
					$visitors[3] = ($visitors[3] != "") ? $visitors[3].';' : $visitors[3];
					$visitors[4] = ($visitors[4] != "") ? $visitors[4].';' : $visitors[4];
					
					$set[0]['lastVisitors'] = $visitors[0].$visitors[1].$visitors[2].$visitors[3].$visitors[4];
					$sbox->update(array('table'=>'site_profil', 'set'=>$set, 'where'=>'uid=/'.$uid.'/'));
				}
				
				$visitors = explode(';', $lastVisitors);
				for($i = 4; $i >= 0; $i--){
					$visiteurr = explode('|', $visitors[$i]);
					if($visiteurr[0] != ""){
						$lassstvisitor .= "<div class='pp-mini-content-entry2'>
					  <div class='pp-image-thumb-wrap-floatright2'><img src='http://board.xnova-ng.org/style_images/web2englis1245311880/folder_profile_portal/pp-blank-thumb.png' width='50' height='50' alt='' /></div>
					  <div style='position:absolute;z-index:2;'> <img src='http://board.xnova-ng.org/style_images/web2englis1245311880/folder_profile_portal/gender_male.png' id='pp-entry-gender-img-21' style='vertical-align:top' alt='' border='0' /> <strong><a href='".$lien.$_SESSION['LANGUE'].'/'.PROFIL.'/'.USER.'/'.$visiteurr[0]."/'>".$visiteurr[0]."</a></strong> </div>
					  <br />
					  <br />
					  <div class='pp-tiny-text2'> <img src='http://board.xnova-ng.org/style_images/web2englis1245311880/folder_profile_portal/user-online.png' alt='' border='0' />".$visiteurr[1]."</div>
					</div>";
					}
				}
				
				if(count($visitors) == 1){
					$lassstvisitor = "<div style='padding-top:5px'><center><i>".AUCUNVISITEUR."</i></center></div>";
				}
				
				/******************************
				 * Affichage des packs public *
				 ******************************/
				 
				$getGames = $sbox->select_multi(array('table'=>'games','select'=>'*','order by'=>'position ASC','apc'=>'listing_games','apc_ttl'=>'3600'));

				for($i = 1; $i <= count($getGames); $i++){
					if($i != count($getGames)){
						$constructQuery .= "SELECT * FROM packs_".strtolower($getGames[$i]['name'])." WHERE uid=".$uid." UNION ";
					} else {
						$constructQuery .= "SELECT * FROM packs_".strtolower($getGames[$i]['name'])." WHERE uid=".$uid;
					}
				}
				
				foreach ($getGames as $Games) $games[$Games['id']] = $Games['name'];
				
				$getPacks = $sbox->custom(array('query' => $constructQuery));
				
				while($pack = $getPacks->fetch_assoc()) {
					
					
					if($pack['note_nb'] > 0)
					{
						$note = round(($pack['note_val'] / $pack['note_nb']));
					}
					else
					{
						$note = 0;
					}
					
					$game_select = $games[$pack['id_game']];
					
					if($_SESSION['log_votes'][$game_select]['pack'][$pack['id']] != "")
					{
						$no_vote = "1";
					}
					else
					{
						$no_vote = "0";
					}
					
					$etoile = '<input id="GAME_'.$pack['id'].'" name="GAME_'.$pack['id'].'" type="hidden" value="'.$game_select.'" />'
							  . '<input id="NOVOTE_'.$pack['id'].'" name="NOVOTE_'.$pack['id'].'" type="hidden" value="'.$no_vote.'" />'
							  . '<input id="VAL_'.$pack['id'].'" name="VAL_'.$pack['id'].'" type="hidden" value="'.$pack['note_val'].'" />'
							  . '<input id="NB_'.$pack['id'].'" name="NB_'.$pack['id'].'" type="hidden" value="'.$pack['note_nb'].'" />'
							  . '<div style="float:left; padding-right:10px;" id="G_'.$pack['id'].'" name="G_'.$pack['id'].'" class="g_etoile">';
											
					for($ii=1;$ii<=5;$ii++)
					{
						if($ii <= $note)
						{
							$etoile .= '<img id="e_'.$pack['id'].'_'.$ii.'" name="e_'.$pack['id'].'_'.$ii.'" class="n_etoile" src="'.$lien.'public/images/Etoile_ON.png">';
						}
						else
						{
							$etoile .= '<img id="e_'.$pack['id'].'_'.$ii.'" name="e_'.$pack['id'].'_'.$ii.'" class="n_etoile" src="'.$lien.'public/images/Etoile_OFF.png">';
						}
					}
											
					$etoile .= '</div>';
					
					if($pack['note_nb'] > 1)
					{
						$vote = "<div id=\"V_".$pack['id']."\" name=\"V_".$pack['id']."\">".$pack['note_nb']." Votes</div>";
					}
					else
					{
						$vote = "<div id=\"V_".$pack['id']."\" name=\"V_".$pack['id']."\">".$pack['note_nb']." Vote</div>";
					}
	
					
					$pack['liste_maps'] = unserialize($pack['liste_maps']);
					$liste_maps = "";
					$i_map = 1;
					foreach($pack['liste_maps'] as $id_map => $map_name)
					{
						if($i_map == 1)
						{
							$liste_maps .= $map_name;
						}
						else
						{
							$liste_maps .= " - ".$map_name;
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
						$link_direct = '<tr><td colspan="6" style="padding-top:10px;">Lien Direct : <input name="" type="text" value="http://www.progamemap.com/mypack/'.strtolower($game_select).'/'.strtolower($_SESSION['user']['dname']).'/'.strtolower($name_pack).'/" size="108" readonly="true" /></td></tr>';
					}
					else
					{
						$link_direct = "";
					}
					
					if($_SESSION['user']['dname'] == $displaynamee)
					{
						$btn_del = '<td><div class="right gistsubmit" id="p_validate" name="p_validate"><input onclick="d_pack(\''.$game_select.'\','.$pack['id'].')" type="submit" value="'.ucfirst(DEL).'" /><span></span></div></td>';
						
					}
					else
					{
						$btn_del = "";
					}
					
					if( ( ($pack['type'] == "PUBLIC") && ($_SESSION['user']['dname'] != $displaynamee) ) || ($_SESSION['user']['dname'] == $displaynamee) )
					{
						$packList .= '<div style="margin-top:10px;border-bottom:1px solid grey;">
							<table class="boxPack border="0" cellspacing="0" cellpadding="0"">
							  <tr>
								<td class="topLeftPack"></td>
	
								<td class="topMiddlePack">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td><strong style="padding-left:15px;">['.$game_select.'] '.$name_pack.'</strong></td>
										<td align="right">
											<table align="right" border="0" cellspacing="0" cellpadding="0">
											  <tr>
												<td width="80">'.$date.'</td>
	
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
									<table width="490" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td colspan="6" style="padding-top:5px;">'.$liste_maps.'</td>
									  </tr>
									  <tr valign="middle">
	
										<td width="100">'.$etoile.'</td>
										<td width="75"><div id="38_V" name="38_V">'.$vote.'</div></td>
										<td align="center">'.ucfirst(DOWNLOADED).' : '.$pack['stats_dl'].' fois</td>
										<td colspan="2" align="right"><table align="right" border="0" cellspacing="0" cellpadding="0"><tr>
										'.$btn_del.'
										<td><div class="right gistsubmit" id="p_validate" name="p_validate"><input onclick="s_pack(\''.$game_select.'\','.$pack['id'].')" type="submit" value="'.ucfirst(TO_SETUP).'" /><span></span></div></td></tr></table></td>   								
									  </tr>
									</table>
	
								</td>
								<td width="1"></td>
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
				
				$getAvatar = $sbox->select_multi(array('table'=>'phpbb_users','select'=>'user_avatar','where'=>'user_id=/'.$uid.'/'));
				foreach($getAvatar as $Avatar) $AvatarSRC = $Avatar['user_avatar'];
				if ($AvatarSRC == ""){
					$AvatarSRC = 'http://www.progamemap.com/public/images/pp-blank-large.png';
				} else {
					if(preg_match('/\//', $AvatarSRC) == 0){
						$AvatarSRC = "http://www.progamemap.com/forum/download/file.php?avatar=".$AvatarSRC;
					}
				}
				
				if($contact_icq == "" || $contact_icq == " ") 
				{
					$contact_icq = AUCUNEINFO;					
				}
				if($contact_msn == "" || $contact_msn == " ") 
				{
					$contact_msn = AUCUNEINFO;
				}
								
				$tpl->ConstructPage(2);
	
				$tpl->GetTpl('profil_user');
								
				$Arianne[] = array('titre' => ucfirst(USER),
			   					   'lien'  => $lien.Plink($param,2,1,PROFIL));
				$Arianne[] = array('titre' => $displaynamee,
			   					   'lien'  => '');
							
				$tpl->assign(array('presentation' => $presentation,
								   'displayNameUser' => $displaynamee,
								   'sexe' => $sexe,
								   'anniversaire' => $birthday,
								   'originaire' => $originaire,
								   'register' => $register,
								   'userGroup' => $utilisateurGroup,
								   'LassstVisitor' => $lassstvisitor,
								   'MY_PACK' => $packList,
								   'contact_icq' => $contact_icq,
								   'contact_msn' => $contact_msn,
								   'AvatarSRC' => $AvatarSRC,
								   'website' => '<a href="http://'.$site.'">'.$site.'</a>'));
				
				$tpl->ConstructEndPage(2);
			} 
		}
		
		$scripts = '<script type="text/javascript" src="'.$lien.'public/js/profil.js"></script>{$Scripts}';
		
		break;
		
	case TEAM :
		if($_SESSION['user']['permPage']['TEAM']['show'] == 'true'){
			if($param[4] != ''){
				if($param[5] != 'admin'){
					// On récupère la ligne relative à l'utilisateur, dans la table site_users.
					$getTeam = $sbox->select_multi(array('table' => 'site_team', 'select' => '*', 'where' => 'name=/'.$param[4].'/'));
					
					foreach($getTeam as $team){
						$tid = $team['id'];
						$name = $team['name'];
						$tag = $team['tag'];
						$creation = $team['creation'];
						$logo = $team['logo'];
						$slogan = $team['slogan'];
						$lastVisitors = $team['lastVisitors'];
						$ipserv = $team['ipserv'];
						$ipts = $team['ipts'];
					}
					
					$visitors = explode(';', $lastVisitors);
					
					// Mois en français
					$mois = array("Jan", "Fev", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Dec");
					// Mise en forme de la date sous la forme : 7 Sep 2009 - 11:05
					$dateNow = date("j").(date("j")==1 ? "er":" ").$mois[date("n")-1]." ".date("Y")." - ".date("G").":".date("i");
					// Mise en forme de l'enregistrement de la visite sous la forme : "Displayname|7 Sep 2009 - 11:05;"
					$lastVisitor = $_SESSION['user']['dname'].'|'.$dateNow;
					
					/************************************************************
					 * Manipulation du tableau de récap des 5 dernières visites *
					 ************************************************************/
					
					// Etape 1 : On vérifie que l'utilisateur n'est pas déja présent dans la liste
					// Si oui, on supprime son ancienne visite et met à jours la liste.
					for($i = 0; $i <= 4; $i++){
						$visiteur = explode('|', $visitors[$i]);
						if($visiteur[0] == $_SESSION['user']['dname']){
							$dejaPresentID = $i; // On isole l'id du tableau dans lequel est présent l'utilisateur
							$dejaPresent = 1;
						}
					}
					
					$nbrVisitors = count($visitors)-1;
					
					if($dejaPresent == 1){ // Si l'utilisateur était déja présent dans la liste...
						// ... On reconstruit un nouveau tableau, avec les valeurs a jours :
						for($i = 0; $i <= $nbrVisitors-1; $i++){
							if($dejaPresentID > $i){
								$newArrayVisitors[$i] = $visitors[$i];
							} elseif($dejaPresentID <= $i){
								$newArrayVisitors[$i] = $visitors[$i+1]; // La ligne ou l'utilisateur était présent est sautée
							}
						}
						
						$newArrayVisitors[$nbrVisitors-1] = $lastVisitor; // On ajoute en dernier l'utilisateur courant.
						$visitors = $newArrayVisitors;
					} else {
						if($nbrVisitors == 5){ // Si la liste est pleine
							$visitors[0] = $visitors[1];
							$visitors[1] = $visitors[2];
							$visitors[2] = $visitors[3];
							$visitors[3] = $visitors[4];
							$visitors[4] = $lastVisitor;
						} else {
							$visitors[$nbrVisitors] = $lastVisitor;
						}
					}
					
					$visitors[0] = ($visitors[0] != "") ? $visitors[0].';' : $visitors[0];
					$visitors[1] = ($visitors[1] != "") ? $visitors[1].';' : $visitors[1];
					$visitors[2] = ($visitors[2] != "") ? $visitors[2].';' : $visitors[2];
					$visitors[3] = ($visitors[3] != "") ? $visitors[3].';' : $visitors[3];
					$visitors[4] = ($visitors[4] != "") ? $visitors[4].';' : $visitors[4];
					
					$set[0]['lastVisitors'] = $visitors[0].$visitors[1].$visitors[2].$visitors[3].$visitors[4];
					$sbox->update(array('table'=>'site_team', 'set'=>$set, 'where'=>'id=/'.$tid.'/'));
					
					$visitors = explode(';', $lastVisitors);
					for($i = 4; $i >= 0; $i--){
						$visiteurr = explode('|', $visitors[$i]);
						if($visiteurr[0] != ""){
							$lassstvisitor .= "<div class='pp-mini-content-entry2'>
						  <div class='pp-image-thumb-wrap-floatright2'><img src='http://board.xnova-ng.org/style_images/web2englis1245311880/folder_profile_portal/pp-blank-thumb.png' width='50' height='50' alt='' /></div>
						  <div style='position:absolute;z-index:2;'> <img src='http://board.xnova-ng.org/style_images/web2englis1245311880/folder_profile_portal/gender_male.png' id='pp-entry-gender-img-21' style='vertical-align:top' alt='' border='0' /> <strong><a href='".$lien.$_SESSION['LANGUE'].'/'.PROFIL.'/'.USER.'/'.$visiteurr[0]."/'>".$visiteurr[0]."</a></strong> </div>
						  <br />
						  <br />
						  <div class='pp-tiny-text2'> <img src='http://board.xnova-ng.org/style_images/web2englis1245311880/folder_profile_portal/user-online.png' alt='' border='0' />".$visiteurr[1]."</div>
						</div>";
						}
					}
					
					if(count($visitors) == 1){
						$lassstvisitor = "<div style='padding-top:5px'><center><i>".AUCUNVISITEUR."</i></center></div>";
					}
					
					/** News **/
					$getNews = $sbox->select_multi(array('table' => 'site_team_news', 'select' => '*', 'where' => 'tid=/'.$tid.'/ AND active=1'));
					
					foreach($getNews as $news){
						$newss .= "<strong>".$news['title']."</strong>&nbsp;-&nbsp;&Eacute;crit par ".$news['auteur']." le ".$news['date']."<br />".$news['content']."<br /><br />";
					}
					
					/** Membres **/
					$getMembres = $sbox->select_multi(array('table' => 'site_users', 'select' => '*', 'where' => 'teamID=/'.$tid.'/'));
					
					foreach($getMembres as $membre){
						$membress .= "<strong><a href='http://www.progamemap.com/fr/profil/utilisateur/".$membre['displayname']."/'>".$membre['displayname']."</a></strong><br /><br />";
					}
					
					/** Adm Link **/
					if($_SESSION['user']['teamID'] == $tid){
						if($_SESSION['user']['teamRank'] == "2" || $_SESSION['user']['teamRank'] == "1"){
							$admLink = '<a href="./admin/">Administration</a>';
						}
					}
					
					$scripts = '<script type="text/javascript" src="'.$lien.'public/js/profil.js"></script>{$Scripts}';
			
					$tpl->ConstructPage(2);
		
					$tpl->GetTpl('profil_team');
					
					$Arianne[] = array('titre' => ucfirst(TEAM),
									   'lien'  => $lien.Plink($param,2,1,PROFIL));
					$Arianne[] = array('titre' => $name,
									   'lien'  => '');
								
					$tpl->assign(array('nameTeam' => $name,
									   'tagTeam' => $tag,
									   'creation' => $creation,
									   'slogan' => "<i>".$slogan."</i>",
									   'logoSRC' => $logo,
									   'LassstVisitor' => $lassstvisitor,
									   'newss' => $newss,
									   'membress' => $membress,
									   'nbrmembre' => count($getMembres),
									   'ipts' => $ipts,
									   'ipserv' => $ipserv,
									   'admLink' => $admLink));
					
					$tpl->ConstructEndPage(2);
				} else {
					/** Administration **/
					// On récupère la ligne relative à l'utilisateur, dans la table site_users.
					$getTeam = $sbox->select_multi(array('table' => 'site_team', 'select' => '*', 'where' => 'name=/'.$param[4].'/'));
					
					foreach($getTeam as $team){
						$tid = $team['id'];
						$name = $team['name'];
						$tag = $team['tag'];
						$website = $team['website'];
						$creation = $team['creation'];
						$logo = $team['logo'];
						$slogan = $team['slogan'];
						$lastVisitors = $team['lastVisitors'];
						$ipserv = $team['ipserv'];
						$ipts = $team['ipts'];
					}
					
					$tpl->ConstructPage(2);
		
					$tpl->GetTpl('profil_team_admin');
					
					$Arianne[] = array('titre' => ucfirst(TEAM),
									   'lien'  => $lien.Plink($param,2,1,PROFIL));
					$Arianne[] = array('titre' => $name,
									   'lien'  => $lien.Plink($param,4,1,$name));
					$Arianne[] = array('titre' => "Administration",
									   'lien'  => "");
					
					switch ($param[6])
					{
						case "infos" :
							if ($_POST){
								$valname   = trim($_POST['name']);
								$valtag    = trim($_POST['tag']);
								$valurl    = trim($_POST['url']);
								$vallogo   = trim($_POST['logo']);
								$valslogan = trim($_POST['slogan']);
								$valipserv = trim($_POST['ipserv']);
								$valipts   = trim($_POST['ipts']);
								
								if ($valname   == "") $valname   = " ";
								if ($valtag    == "") $valtag    = " ";
								if ($valurl    == "") $valurl    = " ";
								if ($vallogo   == "") $vallogo   = " ";
								if ($valslogan == "") $valslogan = " ";
								if ($valipserv == "") $valipserv = " ";
								if ($valipts   == "") $valipts   = " ";
								
								$teamInfos = array();
								$teamInfos[]['name'] 		= $valname;
								$teamInfos[]['tag'] 		= $valtag;
								$teamInfos[]['logo'] 		= $vallogo;
								$teamInfos[]['slogan'] 		= $valslogan;
								$teamInfos[]['website'] 	= $valurl;
								$teamInfos[]['ipserv'] 		= $valipserv;
								$teamInfos[]['ipts'] 		= $valipts;
								
								$sbox->update(array('table'=>'site_team','set'=>$teamInfos,'where'=>'id=/'.$tid.'/'));
								header('Location: '.$lien.Plink($param,5,1,'admin'));
							}
						
							$assign = array('valname'   => $name,
											'valtag'    => $tag,
											'valurl'    => $website,
											'vallogo'   => $logo,
											'valslogan' => $slogan,
											'valipserv' => $ipserv,
											'valipts'   => $ipts,);
					
							$content = $tpl->InjectTpl('profil_team_admin_infos', $assign);
							
							break;
						
						default :
						case "news":
						
							$Arianne[] = array( 'titre' => "News",
									   			'lien'  => $lien.Plink($param,6,1,'news'));
						
							switch($param[7]){
								
								case ADD:
								
									if($_POST){
										$valtitre   = trim($_POST['titre']);
										$valauteur  = trim($_POST['auteur']);
										$valcontent = trim($_POST['content']);
										
										if ($valtitre   == "") {
											$styleValtitre   = " style='border-color:red;'";
											$title = "";
										}
										if ($valauteur  == "") {
											$styleValauteur  = " style='border-color:red;'";
											$auteur = "";
										}
										if ($valcontent == "") {
											$styleValcontent = " style='border-color:red;'";
											$content = "";
										}
										
										if($valtitre != "" && $valauteur != "" && $valcontent != ""){
											$newsInfos = array();
											$newsInfos[]['tid'] 	= $tid;
											$newsInfos[]['title'] 	= $valtitre;
											$newsInfos[]['auteur'] 	= $valauteur;
											$newsInfos[]['content'] = $valcontent;
											$newsInfos[]['date'] = date("d/m/Y");
											
											$insertNews = $sbox->insert(array('table'=>'site_team_news','set'=>$newsInfos));
											if($insertNews){
												header('Location: '.$lien.Plink($param,6,1,'news'));
											}
										}
									}
									
									$assign = array('valtitre' => $title,
													'valauteur' => $auteur,
													'valcontent' => $content,
													'styleValtitre' => $styleValtitre,
													'styleValauteur' => $styleValauteur,
													'styleValcontent' => styleValcontent);
									
									$content = $tpl->InjectTpl('profil_team_admin_news_edit', $assign);
									
									$Arianne[] = array( 'titre' => ucfirst(ADD),
									   					'lien'  => '');
								
									break;
								
								case DELETE:
									
									if($param[8] != ""){
										
										$getNews = $sbox->select_multi(array('table' => 'site_team_news', 'select' => '*', 'where' => 'id=/'.$param[8].'/'));
										
										foreach($getNews as $news){
											$news_tid = $news['tid'];
										}
										
										if($tid != $news_tid){
											header('Location: '.$lien.Plink($param,6,1,"news"));
										} else {
											$deleteNews = $sbox->delete(array('table' => 'site_team_news', 'where' => 'id=/'.$param[8].'/'));
											if($deleteNews){
												header('Location: '.$lien.Plink($param,6,1,"news"));
											}
										}
									}
								
									break;
								
								case "switch":
									
									if($param[8] != ""){
										
										$getNews = $sbox->select_multi(array('table' => 'site_team_news', 'select' => '*', 'where' => 'id=/'.$param[8].'/'));
										
										foreach($getNews as $news){
											$news_tid = $news['tid'];
											$active = $news['active'];
										}
										
										if($tid != $news_tid){
											header('Location: '.$lien.Plink($param,6,1,"news"));
										} else {
											if($active == "1"){
												$newsInfos = array();
												$newsInfos[]['active'] = "0";
												$updateNews = $sbox->update(array('table'=>'site_team_news','set'=>$newsInfos,'where'=>'id=/'.$param[8].'/'));
											} elseif($active == "0"){
												$newsInfos = array();
												$newsInfos[]['active'] = "1";
												$updateNews = $sbox->update(array('table'=>'site_team_news','set'=>$newsInfos,'where'=>'id=/'.$param[8].'/'));
											}
											
											header('Location: '.$lien.Plink($param,6,1,"news"));
										}
									}
								
									break;
								
								case EDIT:
								
									if($param[8] != ""){
										
										$getNews = $sbox->select_multi(array('table' => 'site_team_news', 'select' => '*', 'where' => 'id=/'.$param[8].'/'));
										
										foreach($getNews as $news){
											$news_tid = $news['tid'];
											$title = $news['title'];
											$content = $news['content'];
											$auteur = $news['auteur'];
										}
										
										if($tid != $news_tid){
											header('Location: '.$lien.Plink($param,6,1,"news"));
										} else {
										
											if($_POST){
												$valtitre   = trim($_POST['titre']);
												$valauteur  = trim($_POST['auteur']);
												$valcontent = trim($_POST['content']);
												
												if ($valtitre   == "") {
													$styleValtitre   = " style='border-color:red;'";
													$title = "";
												}
												if ($valauteur  == "") {
													$styleValauteur  = " style='border-color:red;'";
													$auteur = "";
												}
												if ($valcontent == "") {
													$styleValcontent = " style='border-color:red;'";
													$content = "";
												}
												
												if($valtitre != "" && $valauteur != "" && $valcontent != ""){
													$newsInfos = array();
													$newsInfos[]['title'] 	= $valtitre;
													$newsInfos[]['auteur'] 	= $valauteur;
													$newsInfos[]['content'] = $valcontent;
													
													$updateNews = $sbox->update(array('table'=>'site_team_news','set'=>$newsInfos,'where'=>'id=/'.$param[8].'/'));
													if($updateNews){
														header('Location: '.$lien.Plink($param,7,1,EDIT).$param[8]);
													}
												}
											}
										
											$assign = array('valtitre' => $title,
															'valauteur' => $auteur,
															'valcontent' => $content,
															'styleValtitre' => $styleValtitre,
															'styleValauteur' => $styleValauteur,
															'styleValcontent' => styleValcontent);
											
											$content = $tpl->InjectTpl('profil_team_admin_news_edit', $assign);
										}
									}
									
									$Arianne[] = array( 'titre' => ucfirst(EDIT),
									   					'lien'  => '');
								
									break;
								
								default:
						
									$getNews = $sbox->select_multi(array('table' => 'site_team_news', 'select' => '*', 'where' => 'tid=/'.$tid.'/'));
									
									foreach($getNews as $news){
										if($news['active'] == 1){
											$newsActive = '<a href="'.$lien.Plink($param,7,1,"switch").$news['id'].'"><img src="'.$lien.'public/images/tick_vert.png" alt="" /></a>';
										} else {
											$newsActive = '<a href="'.$lien.Plink($param,7,1,"switch").$news['id'].'"><img src="'.$lien.'public/images/cross.png" alt="" /></a>';
										}
										$displayNews .= "<tr><td>".$news['title']."</td><td>".$news['auteur']."</td><td>".$news['date']."</td><td>".$newsActive."</td>";
										$displayNews .= "<td><a href='".$lien.Plink($param,7,1,EDIT).$news['id']."' title='Éditer'>";
										$displayNews .= "<img src='".$lien."public/images/icon_post_edit.gif' alt='' /></a>&nbsp;&nbsp;&nbsp;";
										$displayNews .= "<a href='".$lien.Plink($param,7,1,DELETE).$news['id']."' title='Supprimer'>";
										$displayNews .= "<img src='".$lien."public/images/icon_post_delete.gif' alt='' /></a></td></tr>";
									}
								
									$assign = array('displayNews' => $displayNews);
							
									$content = $tpl->InjectTpl('profil_team_admin_news', $assign);
								
									$SCRIPT .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$lien."public/css/sortableTable.css\" />\n";
									$SCRIPT .= "<script type=\"text/javascript\" src=\"".$lien."public/js/sortableTable.js\"></script>\n";
																		
									break;
							}
							break;
					}
						
					$tpl->assign(array( 'teamContent' => $content,
									    'link1' => $lien.Plink($param,6,1,'infos'),
										'link2' => $lien.Plink($param,6,1,'news'),
										'link3' => $lien.Plink($param,6,1,'news').ADD,
										'link4' => $lien.Plink($param,6,1,''),
										'link5' => $lien.Plink($param,6,1,'')));
					
					$tpl->ConstructEndPage(2);
				}
			}
		} else {
			include_once("include/model/401.php");
		}
		break;
		
	case "creation" :
		if($param[4] == "team"){
			if($_SESSION['user']['permPage']['TEAM']['create'] == 'true'){
				
				$tpl->ConstructPage(1);
				
				if($_SESSION['user']['teamID'] != ""){
					$tpl->GetTpl('profil_team_create_error');
				} else {
		
					$tpl->GetTpl('profil_team_create');
					
					if ($_POST){
						$valname   = trim($_POST['name']);
						$valtag    = trim($_POST['tag']);
						$valurl    = trim($_POST['url']);
						$vallogo   = trim($_POST['logo']);
						$valslogan = trim($_POST['slogan']);
						$valipserv = trim($_POST['ipserv']);
						$valipts   = trim($_POST['ipts']);
						
						if ($valname == "") $styleValname = " style='border-color:red;'";
						if ($valtag  == "") $styleValtag  = " style='border-color:red;'";
						
						if ($styleValname == "" && $styleValtag == ""){
							$isTeam = $sbox->select_multi(array('table'=>'site_team','select'=>'name','where'=>'name=/'.$valname.'/'));
							$isTag = $sbox->select_multi(array('table'=>'site_team','select'=>'tag','where'=>'tag=/'.$valtag.'/'));
							if (count($isTeam) != 0){
								$styleValname = " style='border-color:red;'";
							}
							if (count($isTag) != 0){
								$styleValtag  = " style='border-color:red;'";
							} else {
								if ($valname   == "") $valname   = " ";
								if ($valtag    == "") $valtag    = " ";
								if ($valurl    == "") $valurl    = " ";
								if ($vallogo   == "") $vallogo   = " ";
								if ($valslogan == "") $valslogan = " ";
								if ($valipserv == "") $valipserv = " ";
								if ($valipts   == "") $valipts   = " ";
								
								$LastID = $sbox->select_multi(array('table'=>'site_team','select'=>'id','order by'=>'id DESC LIMIT 1'));
								foreach($LastID as $team) $TeamID = $team['id']+1;
								
								$teamInfos = array();
								$teamInfos[]['id'] 			= $TeamID;
								$teamInfos[]['name'] 		= $valname;
								$teamInfos[]['tag'] 		= $valtag;
								$teamInfos[]['logo'] 		= $vallogo;
								$teamInfos[]['slogan'] 		= $valslogan;
								$teamInfos[]['website'] 	= $valurl;
								$teamInfos[]['ipserv'] 		= $valipserv;
								$teamInfos[]['ipts'] 		= $valipts;
								$teamInfos[]['creation'] 	= date("d/m/Y");
								
								$userInfos = array();
								$userInfos[]['teamID'] 		= $TeamID;
								$userInfos[]['teamRank'] 	= 2;
								
								$ForumID = $sbox->select_multi(array('table'=>'phpbb_forums','select'=>'forum_id,left_id,right_id','order by'=>'forum_id DESC LIMIT 1','where'=>'parent_id=13'));
								foreach($ForumID as $forum){ 
									$ForumIDcurrent = $forum['forum_id']+1; 
									$left_ID = $forum['left_id']+2; 
									$right_ID = $forum['right_id']+2; 
								}
								
								$forumInfos = array();
								$forumInfos[]['parent_id'] 	= 13;
								$forumInfos[]['forum_id'] 	= $ForumIDcurrent;
								$forumInfos[]['left_id'] 	= $left_ID;
								$forumInfos[]['right_id'] 	= $right_ID;
								$forumInfos[]['forum_type'] = 1;
								$forumInfos[]['prune_freq'] = 0;
								$forumInfos[]['forum_name'] = $valname;
								$forumInfos[]['forum_desc'] = "Forum priv&eacute; de la team ".$valtag;
								
								$forumInfos2 = array();
								$forumInfos2[]['right_id'] 	= $right_ID+1;
								
								$grpID = $sbox->select_multi(array('table'=>'phpbb_groups','select'=>'group_id','order by'=>'group_id DESC LIMIT 1'));
								foreach($grpID as $grp) $grpID = $grp['group_id']+1;
								
								$forumGrpInfos = array();
								$forumGrpInfos[]['group_id'] 	= $grpID;
								$forumGrpInfos[]['group_type'] 	= 2;
								$forumGrpInfos[]['group_name'] 	= $valname;
								
								$forumGrpAclInfos = array();
								$forumGrpAclInfos[]['group_id'] 	= $grpID;
								$forumGrpAclInfos[]['forum_id'] 	= $ForumIDcurrent;
								$forumGrpAclInfos[]['auth_role_id'] = 21;
								
								$forumGrpAclInfos2 = array();
								$forumGrpAclInfos2[]['group_id'] 	 = $grpID;
								$forumGrpAclInfos2[]['forum_id'] 	 = 13;
								$forumGrpAclInfos2[]['auth_role_id'] = 21;
								
								$forumGrpMbrInfos = array();
								$forumGrpMbrInfos[]['group_id'] 	= $grpID;
								$forumGrpMbrInfos[]['user_id'] 		= $_SESSION['user']['uid'];
								
								$insertTeam = $sbox->insert(array('table'=>'site_team','set'=>$teamInfos));
								$updateUser = $sbox->update(array('table'=>'site_users','set'=>$userInfos,'where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
								
								$insertForum = $sbox->insert(array('table'=>'phpbb_forums','set'=>$forumInfos));
								$insertForum2 = $sbox->update(array('table'=>'phpbb_forums','set'=>$forumInfos2,'where'=>'forum_id=13'));
								$insertGrpForum = $sbox->insert(array('table'=>'phpbb_groups','set'=>$forumGrpInfos));
								$insertGrpAclForum = $sbox->insert(array('table'=>'phpbb_acl_groups','set'=>$forumGrpAclInfos));
								$insertGrpAclForum2 = $sbox->insert(array('table'=>'phpbb_acl_groups','set'=>$forumGrpAclInfos2));
								$insertGrpMbrForum = $sbox->insert(array('table'=>'phpbb_user_group','set'=>$forumGrpMbrInfos));
								
								if($insertTeam && $updateUser){
									$_SESSION['user']['teamID'] = $TeamID;
									$_SESSION['user']['teamRank'] = "2";
									header('Location: '.$lien.Plink($param,3,1,'team').$valname);
								}
							}
						}
						
						$tpl->assign(array( 'styleValname' => $styleValname,
											'styleValtag' => $styleValtag));
					}
				}
				
				$tpl->ConstructEndPage(1);
			} else {
				include_once("include/model/401.php");
			}
		}
		
		$Arianne[] = array('titre' => 'Cr&eacute;ation de Team',
						   'lien'  => '');
				
		break;
	
	// Par défault on affiche un forumlaire de recherche d'ustilisateur et de team (entre autre)
	default :
	
		$tpl->ConstructPage(1);
		
		$tpl->GetTpl('profil');
		
		include($_SERVER['DOCUMENT_ROOT']."/include/model/profil_temp.php");
		
		$tpl->ConstructEndPage(1);
		
		break;
}

$hover1 = ""; $hover2 = ""; $hover3 = ""; $hover4 = " id=\"menuTopHover\"";

$titre_p = "";
if($param[4])
{
	$titre_p = ' - '.ucfirst($param[4]);
}

$tpl->assign(array(
	'FilArianne' => DisplayArianne($Arianne),
	'Tlink' => Tlink($param),
	'Scripts' => $scripts.'{$Scripts}',
	'Titre' => ucfirst(PROFIL).$titre_p
));

?>
