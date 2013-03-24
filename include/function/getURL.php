<?php                                                   
//********************************************************************************************
//********************************************************************************************
// getURL
// Gestion des paramètres url
// Fonction de decryptage et validation des paramètres URL
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 14/07/2009
// Modification Date : 15/07/2009
// -------------------------------------------------------------------------------------------
// Historique
//
// 1.0 - Paco112 : Creation
//
//********************************************************************************************
//********************************************************************************************


function getURL()
{ 
	global $sbox;
	
	$_SESSION['URL_OK'] = true;
	
	// Liste des paramètres url valide :
	$p_liste  = ":fr:en:account:compte:new:nouveau:setup:installation:cod4:cod5:mohaa:mode:ffa:tdm:rb:obj:filtre:type:dmw:big:moy:mini";
	$p_liste .= ":page:favoris:favorites:panier:cart:admin:permissions:modifier:sitemap:ajouter:setup.exe:profil:user:forum:status";
	$p_liste .= ":gestion:displayname:email:password:motdepasse:matchs:communaute:community:addmap:ajoutermap:search:mypack:packs";
	$p_liste .= ":dm:war:sab:dom:sd:koth:ctf:mods:hosting:hebergement:logiciel:order:commande:starter:basic:medium:premium:trie:sort";
	$p_liste .= ":utilisateur:contact:mohsh:team:admin:infos:news:creation:edit:supprimer:delete:switch:bf2:multi:";
	
	// include des fichiers langues
	include_once("include/language/fr/default.php");
	include_once("include/language/en/default.php");
	
	
/*	// On ajoute dans les paramètres la liste des noms des permissions pour le pannel admin
	$getPerm2 = $sbox->select_multi(array('table' => 'site_permissions', 'select' => 'id,name,perm'));
	if($getPerm2 != false){
		foreach($getPerm2 as $Perm){
			// On prend le nom présent dans la bdd, on supprime les espaces et on met tout en minuscule. Et on ajoute la valeur a la liste.
			$p_liste = $p_liste.str_replace(CHR(32),"",strtolower($Perm['name'])).':';
		}
	} */
	
	// On ajoute dans les paramètres la liste des noms des utilisateurs 
	/*
	$getUserDisplayname = $sbox->select_multi(array('table' => 'site_users', 'select' => 'displayname'));
	if($getUserDisplayname != false){
		foreach($getUserDisplayname as $UserDisplayname){
			// On prend le nom présent dans la bdd, on supprime les espaces et on met tout en minuscule. Et on ajoute la valeur a la liste.
			$p_liste = $p_liste.str_replace(CHR(32),"",strtolower($UserDisplayname['displayname'])).':';
		}
	}
	*/
	
	if(preg_match_all('/\/\//i',$_SERVER['REQUEST_URI'],$temp_d))
	{
		// CHANGEMENT DE l'URL
		$url = "http://www.progamemap.com";
		$p_url = preg_replace('/\/\//i','/',$_SERVER['REQUEST_URI']);
		header("location: ".$url.$p_url);
		exit();
		
	}
	$decoup = explode('/', $_SERVER['REQUEST_URI']);
			
	//$decoup = split('/'.$value[$i],$_SERVER['REQUEST_URI']);
	
	if($decoup)
	{
		$i=0;
		$nb_modif=0;
		$array = array();
		
        foreach($decoup as $key => $value)
        {
			$k_temp = "";
			// authorisation spécial pour les valeur du param "search"
			if($i == 1)
			{
				/**
				 * Gestion des fichiers langues.
				 * En fonction du premier paraèmtre (fr, en), on attribue un fichier langue.
				 **/
				switch($value)
				{
					default:
						if($_SESSION['LANGUE'] != "")
						{
							$array[1] = $_SESSION['LANGUE'];
						}
						else
						{
							include_once("include/function/autoSelectLanguage.php");
							$array[1] = autoSelectLanguage();
						}
						$i++;
						break;
					case 'fr':
						$array[1] = 'fr';
						break;
					case 'en':
						$array[1] = 'en';
						break;
				}
				
				$_SESSION['LANGUE'] = $array[1];
			}
			
			if($array[1] != "false" && $array[2] == "mypack" &&  $array[3] != "false" && ( $i == 4 || $i == 5) )
			{
				//authorisation spécial pour les valeur mypack
				$array[$i] = strtolower($value);							
			}
			elseif( ( $k_temp = array_keys($array,"search") ) && ( ($k_temp[0]+1) == $i ) )
			{
				//authorisation spécial pour les valeur de "search"
				$array[$i] = strtolower($value);							
			}
			elseif( ( ( $k_temp = array_keys($array,"trie") ) || ( $k_temp = array_keys($array,"sort") ) ) && ( ($k_temp[0]+1) == $i ) )
			{
				//authorisation spécial pour les valeur de "search"
				$array[$i] = strtolower($value);							
			}
			elseif($array[1] != "false" && $array[2] == "profil" &&  ( $array[3] == "user" || $array[3] == "utilisateur" )  && $i == 4)
			{
				//authorisation spécial pour les pseudo des utilisateur dans l'url
				$array[$i] = strtolower($value);
			}
			elseif($array[1] != "false" && $array[2] == "profil" &&  $array[3] == "team" && $i == 4)
			{
				//authorisation spécial pour les pseudo des utilisateur dans l'url
				$array[$i] = strtolower($value);
			}
			elseif($array[1] != "false" && $array[2] == "profil" &&  $array[3] == "team" &&  $array[5] == "admin" &&  $array[6] == "news" && $i == 8)
			{
				//authorisation spécial pour les pseudo des utilisateur dans l'url
				$array[$i] = strtolower($value);
			}
			elseif( ($i > 1) && (count(array_keys($array,$value)) == 0) )
			{			
				if((strpos($value,'.php') === false) && (strpos($value,'.htm') === false) && (strpos($value,'.html') === false) && ($value != ""))
				{
					// les value contenant '_' ne sont pas filtré étant donné que ce sont des multi paramètre
					if( (strpos($p_liste,':'.strtolower($value).':') === false) && (!is_numeric($value)) && (strpos($value,'_') === false) )
					{
							sbox_debug::add('param',"Le Paramètre URL suivant est inconnue : ".strtolower($value),$p_liste);
							// on attribue tous de meme une valeur pour evité les bug si on stop pas
							$array[$i] = "false";
							$_SESSION['URL_OK'] = false;

					} 
					else 
					{
						if( (strpos($value,'_')) && (strpos($value,'.')) )
						{
							$array[$i] = "false";
							$_SESSION['URL_OK'] = false;
						}
						elseif(strtolower($value) == "search")
						{
							//authorisation spécial pour le mot "search" qui ne doit pas etre traduit
							$array[$i] = strtolower($value);
						}
						else
						{
							$key_fr = "";
							$key_en = "";
							
							$key_fr = array_search(strtolower($value),$lang_fr);
							$key_en = array_search(strtolower($value),$lang_en);
							
					
							if( $key_fr == false && $key_en != false && $array[1] == 'fr')
							{
								//on remplace la veleur EN en FR
								$array[$i] = $lang_fr[$key_en];
								$nb_modif++;
							}
							elseif( $key_en == false && $key_fr != false && $array[1] == 'en')
							{
								//on remplace la veleur FR en EN
								$array[$i] = $lang_en[$key_fr];
								$nb_modif++;
							}
							else
							{
								$array[$i] = strtolower($value);
							}							
						}
					}
				}
			}
            $i++;
		}
		
		if($nb_modif > 0)
		{
			// CHANGEMENT DE l'URL
			$url = "http://www.progamemap.com/";
			foreach($array as $k => $p)
			{
				$url .= $p."/";
			}
			header("location: ".$url);
			exit();
		}
		
		// CHARGEMENT DE LA LANGUE EN CONSTANTE
		if($_SESSION['conf_sbox']['apc']) 
		{
			$test = apc_load_constants('lang_'.$array[1]);
		}
		else
		{
			$test = false;
		}
		
		if(!$test)
		{
			if($array[1] == 'fr')
			{
				if($_SESSION['conf_sbox']['apc']) 
				{
					apc_define_constants('lang_fr', $lang_fr);
				}
				else
				{
					foreach($lang_fr as $lang_key => $lang_value)
					{
						define($lang_key,$lang_value);
					}
				}
			}
			else
			{
				if($_SESSION['conf_sbox']['apc']) 
				{
					apc_define_constants('lang_en', $lang_en);
				}
				else
				{
					foreach($lang_en as $lang_key => $lang_value)
					{
						define($lang_key,$lang_value);
					}
				}
			}
		}
		
		return $array;
		
	} 
	else 
	{
		return true;
	}
}

// recupère les paramètre par nom ( doit etre appelé apres getURL )
function getURL_name($p)
{   
    if(is_array($p))
    {
        foreach($p as $key => $value)
        {
            $array[$value] = $key; 
        }
        
        return $array;
    }
    else
    {
        return false;
    } 
}


?>
