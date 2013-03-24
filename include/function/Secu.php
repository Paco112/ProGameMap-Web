<?php

//********************************************************************************************
//********************************************************************************************
// Secu
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
if (eregi("Secu.php", $_SERVER['PHP_SELF'])) {
      include("../error.php");
	  die();
}

//********************************************************************************************
//********************************************************************************************


/**
 * Secu
 *
 * @param  $untrusted => Variable a analyser 
 * @return $untrusted
 */
function Secu($untrusted, $type = vartype::STRING)
{
	if ($untrusted != ""){
		$untrusted = mysql_real_escape_string($untrusted);
	}
	
	/*if(!ctype_print($untrusted))
	{
	   // throw new UnexpectedValueException('Bad character.');
	}*/
	
	//doesn't work properly !!!
	/*switch($type)
	{
	case vartype::STRING:
		return strval($untrusted);
		break;
	
	case vartype::INTEGER:
		return intval($untrusted);
		break;
		
	case vartype::FLOAT:
		return floatval($untrusted);
		break;
	
	case vartype::SERIALIZED:
		//to do
		break;  
					   
	case vartype::ISARRAY:
		//to do
		break;
		  
	case vartype::OBJECT:
		if(($trusted = unserialize($untrusted)) === false)
		{
			throw new UnexpectedValueException('Serilized data expected.');
		}
		return $trusted;
		break;
	
	default:
		throw new InvalidArgumentException('No such filtering option');
		break;
	} */
	
	return $untrusted;
}

?>