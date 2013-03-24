<?php

//********************************************************************************************
//********************************************************************************************
// Hosting
// Système d'hébergement.
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 04/01/2010
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
if (eregi("hosting.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

//********************************************************************************************
//********************************************************************************************

$lien = Tlink($param);

$Arianne = array(1 => array('titre' => ucfirst(HOSTING2),
			   				'lien'  => $lien.Plink($param,2,1,HOSTING)));

switch ($param[3]){
	
	default:

		$tpl->ConstructPage(2);
		
		$tpl->GetTpl('hosting_overview');
								
		$tpl->assign(array(
			'LinkOrderStarter' => $lien.Plink($param,3,1,ORDER).STARTER.'/',
			'LinkOrderBasic' => $lien.Plink($param,3,1,ORDER).BASIC.'/',
			'LinkOrderMedium' => $lien.Plink($param,3,1,ORDER).MEDIUM.'/',
			'LinkOrderPremium' => $lien.Plink($param,3,1,ORDER).PREMIUM.'/'
		));
		
		$tpl->ConstructEndPage(2);
		
		break;
		
	case ORDER:
	
		$Arianne[] = array('titre' => ucfirst(ORDER),
						   'lien'  => $lien.Plink($param,2,1,HOSTING));
		
		if($_SESSION['user']['permPage']['HOSTINGORDER']['show'] == 'true'){

			switch($param[4]){
			
				case STARTER:
				
					$Arianne[] = array('titre' => ucfirst(STARTER),
						   			   'lien'  => $lien.Plink($param,3,1,ORDER).STARTER.'/');
				
					$tpl->ConstructPage(2);
				
					$tpl->GetTpl('hosting_starter_order');
											
					/*$tpl->assign(array(
						'' => ,
					));*/
					
					$tpl->ConstructEndPage(2);
					
					break;
					
				case BASIC:
				
					$Arianne[] = array('titre' => ucfirst(BASIC),
						   			   'lien'  => $lien.Plink($param,3,1,ORDER).BASIC.'/');
				
					$tpl->ConstructPage(2);
				
					$tpl->GetTpl('hosting_basic_order');
											
					/*$tpl->assign(array(
						'' => ,
					));*/
					
					$tpl->ConstructEndPage(2);
					
					break;
					
				case MEDIUM:
				
					$Arianne[] = array('titre' => ucfirst(MEDIUM),
						   			   'lien'  => $lien.Plink($param,3,1,ORDER).MEDIUM.'/');
				
					$tpl->ConstructPage(2);
				
					$tpl->GetTpl('hosting_medium_order');
											
					/*$tpl->assign(array(
						'' => ,
					));*/
					
					$tpl->ConstructEndPage(2);
					
					break;
					
				case PREMIUM:
				
					$Arianne[] = array('titre' => ucfirst(PREMIUM),
						   			   'lien'  => $lien.Plink($param,3,1,ORDER).PREMIUM.'/');
				
					$tpl->ConstructPage(2);
				
					$tpl->GetTpl('hosting_premium_order');
											
					/*$tpl->assign(array(
						'' => ,
					));*/
					
					$tpl->ConstructEndPage(2);
					
					break;
				
			}
			
		} else {
			include_once("include/model/401.php");
		}
		
		break;

}

$tpl->assign(array(
	//'Scripts' => '{$Scripts}',
	'dName' => $_SESSION['user']['displayname'],
	'Titre' => HOSTING,
	'FilArianne' => DisplayArianne($Arianne),
	'Tlink' => Tlink($param)
));

?>