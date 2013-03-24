<?php

//********************************************************************************************
//********************************************************************************************
// Template
// Gestion templates du site.
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
//
// 1.0.1 - Paco112 :
//
//      - Supression des template menu et arianne
//      - Modification de la fonction ConstructPage qui n'a plus besoin de paramètre lorsque l'on veut le type de page par default
//
// 1.0 - Flousedid : Creation
//
//********************************************************************************************
//********************************************************************************************

// Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (stristr("template.php", $_SERVER['PHP_SELF'])) {
      include($_SERVER['DOCUMENT_ROOT']."error.php");
	  die();
}

//********************************************************************************************
//********************************************************************************************
    
