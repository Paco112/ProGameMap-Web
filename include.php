<?php

//********************************************************************************************
//********************************************************************************************
// Include
// Inclut toutes les fonctions du dossier Functions.
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 09/07/2008
// Modification Date :
// -------------------------------------------------------------------------------------------
// Historique
// 1.0 - Flousedid : Creation
//
//********************************************************************************************
//********************************************************************************************

// Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (stristr("include.php", $_SERVER['PHP_SELF'])) {
      exit(0404);
}

//********************************************************************************************
//********************************************************************************************

//include_once('include/function/Secu.php'); // Fonction de sécurisation
include('include/function/Pub.php'); // Fonction de gestion des pub
include('include/function/getURL.php'); // Fonction de traitment des paramètres url
include('include/function/Tlink.php'); // Fontion de transformation des liens statique
include('include/function/Plink.php'); // Fontion de cr�ation de lien perso
include('include/function/DisplayArianne.php'); // Fonction d'affichage du fil d'arianne
include('include/function/authController.php');

?>