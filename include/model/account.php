<?php

//********************************************************************************************
//********************************************************************************************
// Home
// Accueil du site.
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 07/07/2008
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
if (preg_match("/account.php/i", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

/*** include function ***/
include_once('./include/function/alphaNumeric.php');
include_once('./include/function/validEmail.php');


//********************************************************************************************
//********************************************************************************************

$lien = Tlink($param);

$Arianne = array(1 => array('titre' => 'Compte',
			   				'lien'  => $lien.Plink($param,2,1,ACCOUNT)));

switch ($param[3]){

	/*
	 * Nouveau Compte
	 */
	case NEW2 :
	
		if ($_SESSION['user']['permPage']['ACCOUNTNEW']['show'] == 'true' || $_SESSION['user']['permPage']['ACCOUNT']['show'] == 'true'){
	
			$tpl->ConstructPage(2);
			
			// Définition du fil d'arrianne
			$Arianne[] = array('titre' => 'Nouveau compte',
							   'lien'  => '');
			
			$tpl -> GetTpl('account_new');
						
			$tpl->assign(array(
				'Titre' => 'Nouveau compte',
				'REDIRECTION' => $lien.Plink($param,2,1,ACCOUNT).GESTION
			));
			
			$tpl->ConstructEndPage(2);
		} else {
			include_once("include/model/401.php");
		}

		break;
	
	/*
	 * Gestion du compte
	 */
	case GESTION :
	
		if ($_SESSION['user']['permPage']['ACCOUNT']['show'] == 'true'){
	
			$tpl->ConstructPage(2);
			
			// Définition du fil d'arrianne
			$Arianne[] = array('titre' => 'Gestion de mon compte',
							   'lien'  => $lien.Plink($param,3,1,GESTION));
			
			$tpl -> GetTpl('account_gestion');
	
			
			switch ($param[4])
			{
				
				case DNAME :
					if($_SESSION['user']['changeDName'] == "") {
						$nbrChangements = "Vous n'avez pas fait le changement de nom d'affichage autoris&eacute; pour cette p&eacute;riode.";
						
						if($_POST){
							if($_POST["displayname"] != "" && $_POST["displaypassword"] != ""){
								$postDName = $_POST["displayname"];
								$postPass = $_POST["displaypassword"];
								include_once('./include/function/codePassw.php');
								$pass = codePassw($_SESSION['user']['username'], $postPass);
								if($pass == $_SESSION['user']['password']){
									if(strlen($postDName) >= 26 || !preg_match("/[a-z0-9]/i",$postDName)){
										// Erreur de dName
										$error  = '<div class="input-warn-content" id="dname-warnbox" style="display:block;">';
										$error .= '<div style="color:red"><strong>Les erreurs suivantes ont &eacute;t&eacute; trouv&eacute;&nbsp;:</strong></div>';
										$error .= '<div id="dname-warnbox-content"> - Le champ nom d\'affichage est soit vide, soit il ne contient pas que des caract&egrave;res alphanum&eacute;riques.</div></div><br />';
									} else {
										$UserInfos = array();
										$UserInfos[]['displayname'] = $postDName;
										$UserInfos[]['changeDName'] = date("d.m.Y").";".time();
										
										$UserInfos2 = array();
										$UserInfos2[]['username'] = $postDName;
										$UserInfos2[]['username_clean'] = strtolower($postDName);
										
										$infos = array();
										$infos[]['topic_first_poster_name'] = $postDName;
										
										$infos2 = array();
										$infos2[]['topic_last_poster_name'] = $postDName;
										
										$infos3 = array();
										$infos3[]['forum_last_poster_name'] = $postDName;
										
										$insert_user  = $sbox->update(array('table'=>'phpbb_topics','set'=>$infos,'where'=>'topic_first_poster_name=/'.$_SESSION['user']['dname'].'/', 'limit'=>'0'));
										$insert_user2 = $sbox->update(array('table'=>'phpbb_topics','set'=>$infos2,'where'=>'topic_last_poster_name=/'.$_SESSION['user']['dname'].'/', 'limit'=>'0'));
										$insert_user3 = $sbox->update(array('table'=>'site_users','set'=>$UserInfos,'where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
										$insert_user4 = $sbox->update(array('table'=>'phpbb_users','set'=>$UserInfos2,'where'=>'user_id=/'.$_SESSION['user']['uid'].'/'));
										$insert_user5  = $sbox->update(array('table'=>'phpbb_forums','set'=>$infos3,'where'=>'forum_last_poster_name=/'.$_SESSION['user']['dname'].'/', 'limit'=>'0'));
										
										if($insert_user && $insert_user2 && $insert_user3 && $insert_user4 && $insert_user5){
											$_SESSION['user']['changeDName'] = date("d.m.Y").";".time();
											$_SESSION['user']['dname'] = $postDName;
											$lien = $lien.Plink($param,4,1,DNAME);
											header("Location: $lien");
										}
									}
								} else {
									// Erreur de mot de passe.
									$error  = '<div class="input-warn-content" id="dname-warnbox" style="display:block;">';
									$error .= '<div style="color:red"><strong>Les erreurs suivantes ont &eacute;t&eacute; trouv&eacute;&nbsp;:</strong></div>';
									$error .= '<div id="dname-warnbox-content"> - Mot de passe incorrecte.</div></div><br />';
								}
							}
						}
					} else {
						
						$ch1   = explode(";", $_SESSION['user']['changeDName']); // Sépare par changements
						$nbrCh = count($ch1); // Compte le nombre de changements enregistrés
						$mois  = 30 * 24 * 60 * 60;
												
						if($ch1[1] > (time() - $mois)){ // Si le changement date de moins d'un mois
							
							$reste = round((($ch1[1] + $mois) - time()) / (24 * 60 * 60));
							$nbrChangements  = "<strong>Vous avez d&eacute;j&agrave; effectu&eacute; un changement de nom d'affichage le $ch1[0].</strong>";
							$nbrChangements .= "<br />Il vous reste $reste jours avant le prochain changement.";
							
							$disabled1 = ' disabled="disabled"';
							$disabled2 = ' disabled="disabled"';
						}
					}
					
					$assign = array('nbrChangementsFaits' => $nbrChangements,
									'disabled1' => $disabled1,
									'disabled2' => $disabled2,
									'linkForm' => $lien.Plink($param,4,1,DNAME),
									'error' => $error);
					
					$content = $tpl->InjectTpl('account_gestion_dname', $assign);
					
					
					$Arianne[] = array('titre' => 'Modifier mon nom d\'affichage',
									   'lien'  => $lien.Plink($param,4,1,DNAME));
					break;
					
				case EMAIL :
					
					if($_POST){
						include_once('./include/function/codePassw.php');
						if($_POST['in_email_1'] == "" || $_POST['in_email_2'] == "" || $_POST['password'] == ""){
							$error  = '<div style="color:red"><strong>Les erreurs suivantes ont &eacute;t&eacute; trouv&eacute;&nbsp;:</strong></div>';
							$error .= '<div id="dname-warnbox-content"> - Un ou plusieurs des champs sont vide.</div><br />';
						} elseif ($_POST['in_email_1'] != $_POST['in_email_2']){
							$error  = '<div style="color:red"><strong>Les erreurs suivantes ont &eacute;t&eacute; trouv&eacute;&nbsp;:</strong></div>';
							$error .= '<div id="dname-warnbox-content"> - Les deux adresses eMail ne correspondent pas.</div><br />';
						} elseif (!filter_var($_POST['in_email_1'], FILTER_VALIDATE_EMAIL)){
							$error  = '<div style="color:red"><strong>Les erreurs suivantes ont &eacute;t&eacute; trouv&eacute;&nbsp;:</strong></div>';
							$error .= '<div id="dname-warnbox-content"> - L\'adresse eMail est invalide.</div><br />';
						} elseif (codePassw($_SESSION['user']['username'], $_POST['password']) != $_SESSION['user']['password']){
							$error  = '<div style="color:red"><strong>Les erreurs suivantes ont &eacute;t&eacute; trouv&eacute;&nbsp;:</strong></div>';
							$error .= '<div id="dname-warnbox-content"> - Le mot de passe est incorrecte.</div><br />';
						} else {
							$UserInfos = array();
							$UserInfos[]['email'] = $_POST['in_email_1'];							
							$insert_user = $sbox->update(array('table'=>'site_users','set'=>$UserInfos,'where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
							
							$UserInfos2 = array();
							$UserInfos2[]['user_email'] = $_POST['in_email_1'];							
							$insert_user2 = $sbox->update(array('table'=>'phpbb_users','set'=>$UserInfos2,'where'=>'user_id=/'.$_SESSION['user']['uid'].'/'));
							
							if($insert_user && $insert_user2){
								$_SESSION['user']['email'] = $_POST['in_email_1'];	
								$lien = $lien.Plink($param,4,1,EMAIL);
								header("Location: $lien");
							}
						}
					}
				
					$assign = array('linkForm' => $lien.Plink($param,4,1,EMAIL),
									'email' => $_SESSION['user']['email'],
									'error' => $error);
					
					$content = $tpl->InjectTpl('account_gestion_mail', $assign);
					
					$Arianne[] = array('titre' => 'Modifier mon adresse eMail',
									   'lien'  => $lien.Plink($param,4,1,EMAIL));
					break;
				
				case PASSWD :
					if($_POST){
						include_once('./include/function/codePassw.php');
						if($_POST['current_pass'] == "" || $_POST['new_pass_1'] == "" || $_POST['new_pass_2'] == ""){
							$error  = '<div style="color:red"><strong>Les erreurs suivantes ont &eacute;t&eacute; trouv&eacute;&nbsp;:</strong></div>';
							$error .= '<div id="dname-warnbox-content"> - Un ou plusieurs des champs sont vide.</div><br />';
						} elseif ($_POST['new_pass_1'] != $_POST['new_pass_2']){
							$error  = '<div style="color:red"><strong>Les erreurs suivantes ont &eacute;t&eacute; trouv&eacute;&nbsp;:</strong></div>';
							$error .= '<div id="dname-warnbox-content"> - Les deux nouveaux mot de passe ne correspondent pas.</div><br />';
						} elseif (codePassw($_SESSION['user']['username'], $_POST['current_pass']) != $_SESSION['user']['password']){
							$error  = '<div style="color:red"><strong>Les erreurs suivantes ont &eacute;t&eacute; trouv&eacute;&nbsp;:</strong></div>';
							$error .= '<div id="dname-warnbox-content"> - Le mot de passe actuel est incorrecte.</div><br />';
						} else {
							$newPass = codePassw($_SESSION['user']['username'], $_POST['new_pass_1']);
							$UserInfos = array();
							$UserInfos[]['passw'] = $newPass;							
							$insert_user = $sbox->update(array('table'=>'site_users','set'=>$UserInfos,'where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
							
							include_once($_SERVER['DOCUMENT_ROOT'].'/include/function/forum.php');
							
							
							$UserInfos2 = array();
							$UserInfos2[]['user_password'] = phpbb_hash($pass);	
							$UserInfos2[]['user_passchg'] = time();	
							$insert_user2 = $sbox->update(array('table'=>'phpbb_users','set'=>$UserInfos2,'where'=>'user_id=/'.$_SESSION['user']['uid'].'/'));
							
							if($insert_user && $insert_user2){
								$_SESSION['user']['password'] = $newPass;
								$lien = $lien.Plink($param,4,1,PASSWD);
								header("Location: $lien");
							}
						}
					}
					$assign = array('linkForm' => $lien.Plink($param,4,1,PASSWD),
									'error' => $error);
					
					$content = $tpl->InjectTpl('account_gestion_passwd', $assign);
					$Arianne[] = array('titre' => 'Modifier mon mot de passe',
									   'lien'  => $lien.Plink($param,4,1,PASSWD));
					break;
				
				/*
				 * Case PROFIL et default sont les mêmes
				 */
				case PROFIL :
				default :
					if ($_POST){
						
						if($_POST['day'] != "--" && $_POST['month'] != "--" && $_POST['year'] != "--")
						{
							$birthday 	= $_POST['day']."-".$_POST['month']."-".$_POST['year'];
						}
						
						$genre 		= $_POST['gender'];
						$site 		= $_POST['WebSite'];
						$icq 		= $_POST['ICQNumber'];
						$msn 		= $_POST['MSNName'];
						$localite 	= $_POST['Location'];
						$interet 	= $_POST['Interests'];
																	
						if ($interet == "") $interet = " ";
						if ($site == "") $site = " ";
						if ($icq == "") $icq = " ";
						if ($msn == "") $msn = " ";
						if ($localite == "") $localite = " ";
						
						$profilInfos = array();
						$profilInfos[]['presentation'] 	= $interet;
						$profilInfos[]['birthday'] 		= $birthday;
						$profilInfos[]['sexe'] 			= $genre;
						$profilInfos[]['localisation'] 	= $localite;
						$profilInfos[]['contact_icq'] 	= $icq;
						$profilInfos[]['contact_msn'] 	= $msn;
						$profilInfos[]['url'] 			= $site;
						
						$sbox->update(array('table'=>'site_profil','set'=>$profilInfos,'where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
					}
					
					$SelectProfil = $sbox->select_multi(array('table'=>'site_profil','select'=>'*','where'=>'uid=/'.$_SESSION['user']['uid'].'/'));
					if($SelectProfil)
					{
						foreach($SelectProfil as $profil){
							$valurl = $profil['url'];
							$valicq = $profil['contact_icq'];
							$valmsn = $profil['contact_msn'];
							$valloc = $profil['localisation'];
							$valpre = $profil['presentation'];
							$valgen = $profil['sexe'];
							$valbir = $profil['birthday'];
						}
					}
					
					if($valgen == "male") $selectedMasculin = " selected='selected'";
					if($valgen == "female") $selectedFeminin = " selected='selected'";
					if($valgen == "mystery" || $valgen == "") $selectedNondefini = " selected='selected'";
					
					$birthday = explode ("-", $valbir);
					for($i = 0; $i <= 31; $i++){
						if($i == 0){
							if($birthday[0] == '--') $optionsDay .= "<option value='--' selected='selected'>--</option>";
							else $optionsDay .= "<option value='--'>--</option>";
						}
						elseif($birthday[0] == $i) $optionsDay .= "<option value='$i' selected='selected'>$i</option>";
						else $optionsDay .= "<option value='$i'>$i</option>";
					}
					
					if($birthday[1] == '--') $selectedMois0 = " selected='selected'";
					if($birthday[1] == 1) $selectedMois1 = " selected='selected'";
					if($birthday[1] == 2) $selectedMois2 = " selected='selected'";
					if($birthday[1] == 3) $selectedMois3 = " selected='selected'";
					if($birthday[1] == 4) $selectedMois4 = " selected='selected'";
					if($birthday[1] == 5) $selectedMois5 = " selected='selected'";
					if($birthday[1] == 6) $selectedMois6 = " selected='selected'";
					if($birthday[1] == 7) $selectedMois7 = " selected='selected'";
					if($birthday[1] == 8) $selectedMois8 = " selected='selected'";
					if($birthday[1] == 9) $selectedMois9 = " selected='selected'";
					if($birthday[1] == 10) $selectedMois10 = " selected='selected'";
					if($birthday[1] == 11) $selectedMois11 = " selected='selected'";
					if($birthday[1] == 12) $selectedMois12 = " selected='selected'";
					
					if($birthday[2] == '--') $optionsYear = "<option value='--' selected='selected'>--</option>";
					else $optionsYear = "<option value='--'>--</option>";
					for($i = 1910; $i <= 2008; $i++){
						if($birthday[2] == $i) $optionsYear .= "<option value='$i' selected='selected'>$i</option>";
						else $optionsYear .= "<option value='$i'>$i</option>";
					}
					
					$assignInject = array(
						'linkForm' => $lien.Plink($param,4,1,PROFIL),
						'valUrl' => $valurl,
						'valICQ' => $valicq,
						'valMSN' => $valmsn,
						'valLocation' => $valloc,
						'valInter' => $valpre,
						'selectedMasculin' => $selectedMasculin,
						'selectedFeminin' => $selectedFeminin,
						'selectedNondefini' => $selectedNondefini,
						'optionsDay' => $optionsDay,
						'optionsYear' => $optionsYear,
						'selectedMois0' => $selectedMois0,
						'selectedMois1' => $selectedMois1,
						'selectedMois2' => $selectedMois2,
						'selectedMois3' => $selectedMois3,
						'selectedMois4' => $selectedMois4,
						'selectedMois5' => $selectedMois5,
						'selectedMois6' => $selectedMois6,
						'selectedMois7' => $selectedMois7,
						'selectedMois8' => $selectedMois8,
						'selectedMois9' => $selectedMois9,
						'selectedMois10' => $selectedMois10,
						'selectedMois11' => $selectedMois11,
						'selectedMois12' => $selectedMois12,
					);
					
					$content = $tpl->InjectTpl('account_gestion_profil', $assignInject);
					
					$Arianne[] = array('titre' => 'Modifier mon Profil',
									   'lien'  => $lien.Plink($param,4,1,PROFIL));
					
					break;
					
				case HOSTING:
					$SelectHosting = $sbox->select_multi(array('table'=>'site_hosting','select'=>'*','where'=>'uid=/'.$_SESSION['user']['uid'].'/'));

					if($SelectHosting == false){
						$content = $tpl->InjectTpl('account_gestion_hosting_null', $assignInject);
					} else {
						$content = $tpl->InjectTpl('account_gestion_hosting', $assignInject);
					}
					
					$Arianne[] = array('titre' => 'G&eacute;rer mes plans d\'h&eacute;bergement',
									   'lien'  => $lien.Plink($param,4,1,HOSTING));
			}
					
			$tpl->assign(array(
				'Titre' => 'Mon compte',
				'accountContent' => $content,
				'link1' => $lien.Plink($param,4,1,PROFIL),
				'link2' => $lien.Plink($param,4,1,DNAME),
				'link4' => $lien.Plink($param,4,1,EMAIL),
				'link5' => $lien.Plink($param,4,1,PASSWD),
				'link6' => $lien.Plink($param,4,1,HOSTING)
			));
			
			$tpl->ConstructEndPage(2);
		} else {
			include_once("include/model/401.php");
		}
		
		break;
	
	default :
	
		//header('Location: http://www.progamemap.com/fr/compte/nouveau');

		break;
	
}

$script_account = "<script type=\"text/javascript\" src=\"".$lien."public/js/account.js\"></script>\n"
				. "<script type=\"text/javascript\" src=\"".$lien."public/js/bulle.js\"></script>\n";

$tpl->assign(array(
	'Scripts' => $script_account.'{$Scripts}',
	'FilArianne' => DisplayArianne($Arianne)
));


?>