<?php

//********************************************************************************************
//********************************************************************************************
// DisplayArianne
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
if (stristr("DisplayArianne.php", $_SERVER['PHP_SELF'])) {
      include("../error.php");
	  die();
}

//********************************************************************************************
//********************************************************************************************


/**
 *	$Arianne = array (
 *   	1 => array (
 *			"titre" => "test",
 *			"lien"  => "test.php"),
 *		2 => array (
 *			"titre" => "test2",
 *			"lien"  => "test2.php"),
 *	);
 *
 *	A écrire dans l'ordre chronologique. Le dernier étant la page courante.
 */

/**
 * DisplayArianne
 *
 * @param  $Fil 
 * @return $DisplayFil
 */
function DisplayArianne($Fil)
{
	$NbFil = count($Fil);
	
	$DisplayFil = '<li id="liFilArianneBoutonDEBUT"></li><li id="FAB_1" class="liFilArianneBouton"><a id="FAB_1_A" href="http://www.progamemap.com/"><img src="http://www.progamemap.com/public/images/home.png" alt="home" style="padding-top:6px" />&nbsp;&nbsp;&nbsp;&nbsp;</a></li><li id="liFilArianneBoutonFLECHE1" class="liFilArianneBoutonFLECHE"></li>';
	
	for($i = 1; $i <= $NbFil; $i++){
		
		$Fil[$i]["lien"] = !$Fil[$i]["lien"] ? "#" : $Fil[$i]["lien"];
		$i2 = $i + 1;
		
		if($i != $NbFil){
			$DisplayFil .= '<li id="FAB_'. $i2 .'" class="liFilArianneBouton"><a id="FAB_'. $i2 .'_A" href="'.$Fil[$i]["lien"].'">'.$Fil[$i]["titre"].'&nbsp;&nbsp;&nbsp;</a></li> <li id="liFilArianneBoutonFLECHE'. $i2 .'" class="liFilArianneBoutonFLECHE"></li>';
		} else {
			$DisplayFil .= '<li><span class="arianneSpan">'.$Fil[$i]["titre"].'</span></li>';
		}
	}
	
	return $DisplayFil;
}

/**
function DisplayArianne($Fil)
{

	$NbFil = count($Fil);
	
	$DisplayFil = '<li><a style="padding-left:-10px" href="http://www.progamemap.com/"><div id="ArianneBegin">&nbsp;</div><img src="http://www.progamemap.com/public/images/home.png" alt="home" border="0" style="padding-top:6px" />&nbsp;&nbsp;&nbsp;&nbsp;<div class="FilArianneBoutonEND"></div></a></li>';
	
	for($i = 1; $i != $NbFil + 1; $i++){
		
		if($i != $NbFil){
			$DisplayFil .= '<li><a href="'.$Fil[$i]["lien"].'"><div class="FilArianneBoutonDEB"></div>'.$Fil[$i]["titre"].'&nbsp;&nbsp;&nbsp;<div class="FilArianneBoutonEND"></div></a></li>';
		} else {
			$DisplayFil .= '<li><span>'.$Fil[$i]["titre"].'</span></li>';
		}
	}
	
	return $DisplayFil;
}
**/

?>