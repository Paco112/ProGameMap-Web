<?php

//********************************************************************************************
//********************************************************************************************
// getGroup
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 04/09/2009
// Modification Date :
// -------------------------------------------------------------------------------------------
// Historique
//
// 1.0 - Flousedid : Creation
//
//********************************************************************************************
//********************************************************************************************


function getGroup($Group)
{
    switch($Group){
		case 1 :
			return GUEST;
			break;
		case 2 :
			return MEMBER;
			break;
		case 3 : 
			return CUSTOMER;
			break;
		case 4 : 
			return MODERATOR;
			break;
		case 5 : 
			return ADMINISTRATOR;
			break;
	}
}


?>