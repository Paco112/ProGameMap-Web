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
if (stristr("home.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

// Choix du type de la page (ici type par default)
$tpl->ConstructPage();

// Définition du fil d'arrianne
$Arianne = array(1 => array('titre' => ucfirst(WELCOME_TO).' ProGameMap',
			   				'lien'  => ''));

//********************************************************************************************
//******************************************************************************************** 

//$tpl -> GetTpl('home');


// On récupère toutes les news actives
$site_news = $sbox->select_multi(array('table'=>'site_news_'.$_SESSION['LANGUE'],'select'=>'*','where'=>'active=1','high_priority'=>'1','order by'=>'date desc','apc'=>'site_news_'.$_SESSION['LANGUE'],'apc_ttl'=>'900'));

// On affiche les news une par une en utilisant le template DisplayArticles
foreach($site_news as $news){
	
	$datetime = date_create($news['date']);
	
	if($_SESSION['LANGUE'] == 'fr')
	{
		setlocale(LC_TIME, 'french');
		
		// version sans majuscule
		//$date = strftime("%A %d %B %Y", mktime(0, 0, 0, date_format($datetime, 'm'), date_format($datetime, 'd'), date_format($datetime, 'Y')));
		
		// version avec majuscule
		$mktime = mktime(0, 0, 0, date_format($datetime, 'm'), date_format($datetime, 'd'), date_format($datetime, 'Y'));
		$date = ucfirst(strftime("%A %d",$mktime))." ".ucfirst(strftime("%B %Y",$mktime));
								 
		
	}
	else
	{
		$date = date_format($datetime, 'l d F Y');
	}

	// On stock ce template en vue de l'intégrer a la case $Content de la page
	$tpl->GetTpl('DisplayArticles');
	$tpl->assign(array(
		'TitleArticles'  => $news['title'],
		'DateArticles'   => $date,
		'ContentText'    => $news['content'],
		'AuteurArticles' => $news['auteur'])
	);
}


$tpl->assign(array(
	'FilArianne' 	=> DisplayArianne($Arianne),
	'Titre' 		=> "Installation Automatique de Maps Custom pour Jeux Video - MOHAA - MOHSH - COD4 - BF2 - DMW",
	'homeLogo'		=> '<a href="http://www.progamemap.com/fr/compte/nouveau/"><img src="{$Tlink}public/images/BETA.jpg" alt="" border="0" /></a><br /><br />'));


$tpl->ConstructEndPage();

$hover1 = " id=\"menuTopHover\""; $hover2 = ""; $hover3 = ""; $hover4 = "";

?>
