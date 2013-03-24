<?php
//********************************************************************************************
//
//      LANGUAGE : FRENCH , FR
//      les constantes french sont les models des autres langues
//      les constantes sont toujours en majuscule et senssible a la case
//      les valeur sont toujour intégralement en minuscule
//      
//      utilisé la commande ucfirst(CONSTANTE) pour passer la première lettre en majuscule
//
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 12/06/2009
// Modification Date : 12/06/2009
// -------------------------------------------------------------------------------------------
// Historique
//
// 1.0 - Paco112 : Creation
//
//********************************************************************************************
//******************************************************************************************** 

// a voir si il faudra séparé en fonction de la page affiché

//define('BIENVENUE','bienvenue');
//define('BONJOUR','bonjour');
$lang_fr['HOME'] = 'accueil';
$lang_fr['SETUP'] = 'installation'; 
$lang_fr['NEW2'] = 'nouveau';
$lang_fr['ACCOUNT'] = 'compte';

apc_define_constants('fr', $lang_fr);
?>
