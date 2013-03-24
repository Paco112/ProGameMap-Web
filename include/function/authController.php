<?php                                                   
//********************************************************************************************
//********************************************************************************************
// authController
// Gestion de l'authentification
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 10/09/2009
// Modification Date : 
// -------------------------------------------------------------------------------------------
// Historique
//
// 1.0 - Flousedid : Creation
//
//********************************************************************************************
//********************************************************************************************
 
/** 
 * - On récupère les ID des sets de permissions attribué a l'utilisateur lors du Login, stocké en session.
 * 		La table _permissions est construite de la manière suivante :
 *			- ID
 *			- name
 *			- show (nom des pages pouvant être vu grâce à ce set)
 *			- download (pages sur lesquelles ils est possible de télécharger)
 *			- moderate (pages sur lesquelles les options de modération sont présentes)
 *
 *	Par convention, on écrira le nom des pages de la même manière que pour les constantes de langues.
 *	Exemple : INDEX;ACCOUNT
 *	En majuscule, et séparé par un point virgule.
 *
 * - Ensuite on récupère les infos des permissions correspondant a leurs id.
 * - On analyse quelles pages sont présentes dans les catégories SHOW, DOWNLOAD et MODERATE.
 * - Si une page est présente dans la page SHOW (par exemple, la page INDEX), alors la variable $permPage['INDEX']['show'] = 'true';
 * - Si cette même page INDEX est également présente dans DOWNLOAD, alors $permPage['INDEX']['download'] = 'true';
 *
 * Cette méthode permet d'attribuer autant de set que l'on veux a une personne.
 **/
function authController()
{ 
	global $sbox;
	
		/** 
		 * Si aucune permission défini, c'est qu'on est pas passé par la case login. 
		 * On attribue donc le set de permission par défault (Guest) 
		**/
	
	if( $_SESSION['user']['permPage'] == "" )
	{
		if($_SESSION['user']['group']['principal'] == ""){
			$_SESSION['user']['group']['principal'] = '2;';
		}
						
		// On récupère tous les id de permissions de chaque groupes
		$getGroup  = $sbox->select_multi(array('table' => 'site_groups', 'select' => 'permissionsID'));
		
		foreach($getGroup as $dataGroup){
			$groupID = $dataGroup['permissionsID'];
		}
		
		// On récupère tous les groupes de l'utilisateur
		$userGroup = $_SESSION['user']['group']['principal'].$_SESSION['user']['group']['secondaires'];
		$userGroup = explode(";", $userGroup);
			
		foreach($userGroup as $g){
			$allPerms .= $getGroup[$g]['permissionsID'];
		}
	
		// On ajoute les permissions propre au groupes à celle de l'utilisateur
		$allPerms = $allPerms.$_SESSION['user']['permissions'];
		$userPermID = explode(";", $allPerms);
		
		$getPerm = $sbox->select_multi(array('table' => 'site_permissions', 'select' => 'id,name,perm'));
		
		if($getPerm)
		{
			
			foreach($getPerm as $perm)
			{
				if(!(array_search($perm['id'],$userPermID) === false))
				{	
					$type_perm = explode(";", $perm['perm']);	
					
					foreach($type_perm as $key => $value)
					{
						$temp_perm = explode(".",$value);
						$_SESSION['user']['permPage'][$temp_perm['0']][$temp_perm['1']] = 'true';
						$temp_perm = array();
					}
				}
			}
		}
		else
		{
			return false;		
		}
	}
		
	/*
	foreach($userPermID as $PermID){
		
		$getPerm = $sbox->select_multi(array('table' => 'site_permissions', 'select' => '*', 'where' => 'id=/'.$PermID.'/'));
		
		if(is_array($getPerm)){
			foreach($getPerm as $key => $perm){
				$permShow 	  = $perm['show'];
				$permDownload = $perm['download'];
				$permModerate = $perm['moderate'];
			}
		}
		
		if($permShow != ''){
			$pageShow = explode(';', $permShow);
			foreach($pageShow as $Perm){
				$permPage[$Perm]['show'] = 'true';
			}
		}
		
		if($permDownload != ''){
			$pageDownload = explode(';', $permDownload);
			foreach($pageDownload as $Perm){
				$permPage[$Perm]['download'] = 'true';
			}
		}
		
		if($permModerate != ''){
			$pageModerate = explode(';', $permModerate);
			foreach($pageModerate as $Perm){
				$permPage[$Perm]['moderate'] = 'true';
			}
		}
	}
	
	
	return $permPage;
	
	*/
}

?>