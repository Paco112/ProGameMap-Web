<?php                                                   
//********************************************************************************************
//********************************************************************************************
// SECUBOX AJAX
// Gestion MySQL.
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0.2
// Creation Date : 18/04/2009
// Modification Date : 12/06/2009
// -------------------------------------------------------------------------------------------
// Historique
//
// 1.0.3 - Paco112 :
//
//      - Séparation de la fonction Arianne dans un fiché séparé
//      - Séparation de la fonction getURL dans un fiché séparé
//      - Modification de l'affichage plus clair
//
// 1.0.2 - Paco112 :
//
//      - Changement la class sqlbox() devient sbox() : SECUBOX
//      - Ajout de securité suplementaire dans les requetes mysql                              
//      - Optimisation du traitement des lignes de debugage
//      - Optimisation général du debugger
//      - Ajout du timer 'FONCTION' permettant de deduire le temps de debugage
//      - Correction des timers erronés
//      - Securisation des variables SESSION
//      - Ajout de nouveau temps dans la bar de debugage
//      - Ajout d'une verification de l'existance physique des fichiés injectés
//      - Separation de mootools et css dans sbox_view.php
//      - Correction du scintillement à l'affichage du debugger
//
// 1.0.1 - Paco112 : Reprise pour le projet ProGrameMap
//
//      - Changement : read() devient select() et retourne sous forme d'objet       
//      - Ajout de la fonction select_multi() retour sous forme Array
//      - Ajout de la fonction update()
//      - Ajout de la fonction insert()
//      - Securisation des requetes mysql
//      - Affichage via slider Mootools
//
// 1.0 - Paco112 : Creation
//
//********************************************************************************************
//********************************************************************************************

// Activation et Securisation de la session
session_start();

// ATTENTION LA MODIFICATION FORCERA LA DESTRUCTION ET REGENERATION DES SESSIONS EXISTANTES
$sid_pass = "jghks867dfo:i4ern:qsdIYOI456OQZDH.jhu45za";

if (isset($_SESSION['HTTP_USER_AGENT']))
{
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'].$sid_pass))
    {
        // on regénére un id de session et efface l'ancienne session
        if(session_regenerate_id(true) == true)
        {
            // et on detruit tous repartir a neuf
            if(session_destroy() == true)
            {
                // donc retour au site si session toute neuve et personne na rien vu
                header("location: ./index.php");
            }
        }
        // si la session ne peut etre détruite et regénéré pour X raison on reste bloqué ici
        exit;
        exit();
        exit(0);
    }
    $_SESSION['visits']++;
}
else
{
    $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT'].$sid_pass);
    $_SESSION['visits'] = 1;
}

// Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (stristr("sbox_ajax.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

//********************************************************************************************
//********************************************************************************************

class sbox 
{
	function __construct()
    {   
        $this->inject("include/config/config.php");  
    }
    
    function __destruct() 
    {
        $_SESSION['conf_sbox'] = array();
    }        
	
    function inject($file,$stop=0)
    {
        // cette fonction verifie la présence des fichiées injecté
        
        if($stop == '1')
        {
            $stop = '0';
        }
        else
        {
            $stop = '1';
        }
                
        if(file_exists($_SERVER['DOCUMENT_ROOT']."/".$file)) 
        {              
            include($_SERVER['DOCUMENT_ROOT']."/".$file);
        }
    }
    
    function auto_connect($id_base=0,$force_new=0) 
    {            
        if($id_base == NULL)
        {
            $id_base=0;
        }
                
        if(!@mysql_thread_id() || $force_new==1)
        {            
            $link = @mysql_connect($_SESSION['sbox'][$id_base]['ip'],$_SESSION['sbox'][$id_base]['login'],$_SESSION['sbox'][$id_base]['password']);
            
            if($link == false)
            {
            }
            else
            {                                                                                                                 
                if(@mysql_select_db($_SESSION['sbox'][$id_base]['base'],$link))
                {                         
                    return $link;
                }
                else
                {
                    return false;
                }
            }
            
        }
        else
        {
            $_SESSION['sbox_temp']['id_timer_ping'] = "1";
            return true;
        }
    }
    
    function syntaxe_option($arg, $mod)
    {
        $return = FALSE;
		$new_option = array();
				
        // on commence par verifier que les paramètres passées sont conforme au model
		if(is_array($arg))
        {			
			// Puis on securise les paramètres pour mysql ( on accède ici si pas d'erreur à l'étape précédente )
            // on verifie aussi que le param existe en model
			foreach($arg as $key2 => $value2)
			{
				$return = FALSE;
                
				if(isset($mod[$key2]))
                {
                    if(is_array($value2))
				    {
					    foreach($value2 as $key3 => $value3)
					    {
                            foreach($value3 as $key4 => $value4)
						    {
							    if(($value4 != NULL) && ($value4 != ""))
							    {   
                                    if(function_exists('mysql_real_escape_string')) 
                                    {
                                        $new_option['set'][$key3][$key4] = mysql_real_escape_string($value4);
                                        $return = TRUE;
                                    } 
                                    elseif(function_exists('mysql_escape_string')) 
                                    {
                                        $new_option['set'][$key3][$key4] = mysql_escape_string($value4);
                                        $return = TRUE;
                                    } 
                                    else 
                                    {
                                        $new_option['set'][$key3][$key4] = addslashes($value4);
                                        $return = TRUE;
                                    }
							    }	
						    }
					    }
				    }
				    elseif(($value2 != NULL) && ($value2 != ""))
				    {
                        
                        if(function_exists('mysql_real_escape_string')) 
                        {
                            $new_option[$key2] = mysql_real_escape_string($value2);
                            $return = TRUE;
                        } 
                        elseif(function_exists('mysql_escape_string')) 
                        {
                            $new_option[$key2] = mysql_escape_string($value2);
                            $return = TRUE;
                        } 
                        else 
                        {
                            $new_option[$key2] = addslashes($value2);
                            $return = TRUE;
                        }
				    }
                }
			}			
						
        }
		
        // on remplace les / par '
        $new_option = str_replace("/","'",$new_option);
        
        if($return == TRUE)
		{
            return $new_option;
		}
    }
    
	/*#############################################################################################################
												FONCTIONS 	SELECT
												
						tous n'est pas encore fonctionelle et ne le sera pas, trie prochainement
												
	  SELECT [STRAIGHT_JOIN]
      [SQL_SMALL_RESULT] [SQL_BIG_RESULT] [SQL_BUFFER_RESULT]
      [SQL_CACHE | SQL_NO_CACHE] [SQL_CALC_FOUND_ROWS] [HIGH_PRIORITY]
      [DISTINCT | DISTINCTROW | ALL]
	  select_expression,...
	  [INTO {OUTFILE | DUMPFILE} 'nom_fichier' export_options]
	  [FROM table_references
      [WHERE where_definition]
      [GROUP BY {unsigned_integer | nom_de_colonne | formula} [ASC | DESC], ...
      [HAVING where_definition]
      [ORDER BY {unsigned_integer | nom_de_colonne | formula} [ASC | DESC] ,...]
      [LIMIT [offset,] lignes]
      [PROCEDURE procedure_name(argument_list)]
      [FOR UPDATE | LOCK IN SHARE MODE]]

	##############################################################################################################*/
	
	function select($option)
    {
        $return = FALSE;
		$object = NULL;
                
        $model['table']=1;
		$model['select']=1;
        $model['where']=0;
        $model['order by']=0;
        $model['mode']=0;          
        $model['id_base']=0;
        $model['key']=0;
                  
		// on verifie si une connection est deja active sinon on tente une connection
		$this->auto_connect($option['id_base']);
		        
        // Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
		$option = $this->syntaxe_option($option, $model);
        
        //echo "ID: ".array_search('Connection',$_SESSION['sbox_timer']);
        
        $sql = "SELECT ".$option['select']." FROM ".$option['table'];

        if($option['where'])
        {
         $sql .= " WHERE ".$option['where'];
        }

        if($option['order by'])
        {
         $sql .= " ORDER BY ".$option['order by'];
        }
                
        $result = @mysql_query($sql);
        
        if(!$result)
        {
        }
        else
        {
         
            $object = @mysql_fetch_object($result);
			//if(is_object($object))
			//{
				$return = TRUE;
			//}
        }
                                  
        if($return == TRUE)
		{
			return $object;
		}
		else
		{
			return FALSE;
		}
    }
    
    function select_multi($option)
    {		
		$t_connect = NULL;
		$apc_read = 0;
		$return = FALSE; 
                
		if($option['apc'] != '' && sbox_cache::get($option['apc']) != false)
		{
			$array = sbox_cache::get($option['apc']);
			$apc_read = 1;
			$return = TRUE;
		}
        else
		{
			$model['table']=1;
			$model['select']=1;
			$model['where']=0;
			$model['order by']=0;
			$model['limit']=0;
			$model['buffer']=0;
			$model['cache']=0;
			$model['high_priority']=0;
			$model['mode']=0;          
			$model['id_base']=0;
			$model['key']=0;
			$model['apc']=0;
			$model['apc_ttl']=0;
		
			// on verifie si une connection est deja active sinon on tente une connection
			$this->auto_connect($option['id_base']);
						
			// Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
			$option = $this->syntaxe_option($option, $model);
			
			if(!$option['id_base'])
			{
				$option['id_base'] = '0';
			}
			
			if(!$option['key'])
			{
				$cle = "id";
			}
			else
			{
				$cle =  $option['key'];
			}
					
			//echo "ID: ".array_search('Connection',$_SESSION['sbox_timer']);
			$sql = "SELECT ";
			
			if($option['buffer'])
			{
				$sql .= "SQL_BUFFER_RESULT ";
			}
			
			if($option['cache'])
			{
				$sql .= "SQL_CACHE ";
			}
			
			if($option['high_priority'])
			{
				$sql .= "HIGH_PRIORITY ";
			}
			
			$sql .= $option['select']." FROM ".$option['table'];
	
			if($option['where'])
			{
				$sql .= " WHERE ".$option['where'];
			}
	
			if($option['order by'])
			{
				$sql .= " ORDER BY ".$option['order by'];
			}
			
			if($option['limit'])
			{
				$sql .= " LIMIT ".$option['limit'];
			}
				
			$result = @mysql_query($sql);
			
			if(!$result)
			{
			}
			else
			{				
				if(!$option['mode'] || $option['mode'] == "assoc")
				{
					$key_type = 0;
					
					while($row = @mysql_fetch_assoc($result))
					{
						if ($row[$cle]) 
						{ 
							$array[ $row[$cle] ] = $row; 
						}
						else 
						{
							$array[] = $row;
						}
					}  
				}
				elseif($option['mode'] == "row")
				{
					
					$key_type = 1;
					
					while($row = @mysql_fetch_row($result))
					{
						$array[] = $row;
					} 
				}
				if(is_array($array))
				{
					$return = TRUE;
				}
			}
					  		        
			
			if($option['apc'] != '' && $return == TRUE)
			{
					sbox_cache::add($option['apc'],$array,$option['apc_ttl']);
			}
		}
		        
		if($return == TRUE)
		{
			return $array;
		}
		else
		{
			return FALSE;
		}
    }
	
	/*#############################################################################################################
												FONCTIONS 	UPDATE
												
	UPDATE [LOW_PRIORITY] [IGNORE] tbl_name SET col_name1=expr1 [, col_name2=expr2 ...]
    [WHERE where_definition]
    [ORDER BY ...]
    [LIMIT row_count]
	
	* Si vous spécifiez le mot clef LOW_PRIORITY, l'exécution de l'UPDATE sera repoussé jusqu'à ce que aucun client ne lise plus de la table.
    
	* Si vous spécifiez le mot clef IGNORE, la mise à jour ne s'interrompra pas même si on rencontre des problèmes d'unicité de clefs durant l'opération. 
	  Les enregistrements posant problèmes ne seront pas mis à jour.

	##############################################################################################################*/
	
	function update($option)
    {                
        $set_string = NULL;
		$result = FALSE;
		                
		// modeles de syntaxe
        $model['table']=1;
		$model['set']="array";
        $model['where']=1;
        $model['order by']=0;
		$model['low_priority']=0;
		$model['ignore']=0;
        $model['mode']=0;          
        $model['id_base']=0;
        $model['key']=0;
         
		// on verifie si une connection est deja active sinon on tente une connection
		$this->auto_connect($option['id_base']);
		        
        // Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
		$option = $this->syntaxe_option($option, $model);
        
		// transforme l'array de l'option set en une ligne de commande mysql
		foreach($option['set'] as $key => $value)
		{
			foreach($value as $key2 => $value2)
			{
				$val_up = explode("+",$value2);
				if(!$val_up)
				{
					$val_up = explode("-",$value2);
				}
				
				if($set_string == NULL)
				{
					if($val_up)
					{
						$set_string .= $key2."=".$value2." ";
					}
					else
					{
						$set_string .= $key2."='".$value2."' ";
					}
				}
				else
				{
					if($val_up)
					{
						$set_string .= ", ".$key2."=".$value2." ";
					}
					else
					{
						$set_string .= ", ".$key2."='".$value2."' ";
					}
				}
			}
		}
     
		// création de la requete MySQL
		$sql = "UPDATE ";
		
		if($option['low_priority'] == 1)
		{
			$sql .= "LOW_PRIORITY ";
		}
		
		if($option['ignore'] == 1)
		{
			$sql .= "IGNORE ";
		}
		
		$sql .= $option['table']." SET ".$set_string;

        if($option['where'])
        {
         $sql .= " WHERE ".$option['where'];
        }

        if($option['order by'])
        {
         $sql .= " ORDER BY ".$option['order by'];
        }
		
        $sql .= " LIMIT 1";
        
        // lance la requete 
        $result = @mysql_query($sql);
        
        return $result;
    }

	/*#############################################################################################################
												FONCTIONS 	UPDATE	MULTI
	##############################################################################################################*/
	
	
	/*#############################################################################################################
													FONCTIONS 	INSERT
												
	INSERT [LOW_PRIORITY | DELAYED]
    [INTO] tbl_name
    SET col_name={expr | DEFAULT}, ...
    [ ON DUPLICATE KEY UPDATE col_name=expr, ... ]
	
	* Si vous spécifiez l'option DELAYED, le serveur met la ligne ou les lignes à insérer dans un tampon, et le client qui a émis la commande INSERT DELAYED est immédiatement libéré. Si la table est occupée, le serveur conserve les lignes. Lorsque la table se libère, il va insérer les lignes, tout en vérifiant périodiquement s'il n'y a pas de lectures dans la table. Si une lecture arrive, l'insertion est suspendue jusqu'à la prochaine libération.
	
	* Si on spécifie le mot LOW_PRIORITY, l'exécution de INSERT sera retardé jusqu'à ce qu'il n'y ait plus de clients qui lisent la table. Dans ce cas le client doit attendre jusqu'à la fin de l'opération d'insertion, ce qui peut prendre beaucoup de temps si la table est fréquemment accédée. C'est la grande différence avec INSERT DELAYED, qui laisse le client continuer tout de suite.
	
	* Si vous spécifiez la clause ON DUPLICATE KEY UPDATE (nouveau en MySQL 4.1.0), et qu'une ligne insérée engendre un doublon pour une clé PRIMARY ou UNIQUE, une commande UPDATE sera faite à la place de l'insertion.
	
	##############################################################################################################*/
	
	function insert($option)
    {
		$set_string = NULL;
		$result = FALSE;
		        
		// modeles de syntaxe
        $model['table']=1;
		$model['set']="array";
		$model['low_priority']=0;
		$model['delayed']=0;
		$model['dup_key']=0; // ON DUPLICATE KEY UPDATE
        $model['mode']=0;          
        $model['id_base']=0;
        $model['key']=0;
         
		// on verifie si une connection est deja active sinon on tente une connection
		$this->auto_connect($option['id_base']);
		        
        // Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
		$option = $this->syntaxe_option($option, $model);
        
		// transforme l'array de l'option set en une ligne de commande mysql
		foreach($option['set'] as $key => $value)
		{
			foreach($value as $key2 => $value2)
			{
				if($set_string == NULL)
				{
					$set_string .= $key2."='".$value2."' ";
				}
				else
				{
					$set_string .= ", ".$key2."='".$value2."' ";		
				}
			}
		}
		              
		// création de la requete MySQL
		$sql = "INSERT ";
		
		if($option['low_priority'] == 1)
		{
			$sql .= "LOW_PRIORITY ";
		}
		elseif($option['delayed'] == 1)
		{
			$sql .= "DELAYED ";
		}
				
		$sql .= $option['table']." SET ".$set_string;
		
		if($option['dub_key'])
        {
        	$sql .= " ON DUPLICATE KEY UPDATE ".$option['dub_key'];
        }
		                
        // lance la requete et les timers qui vont avec
        $result = @mysql_query($sql);
        
        return $result;
    }
	   
}

// Class commumn de securité
class sbox_function extends sbox
{
    // securise une transaction ajax via 3 clée de cryptage dont 1 est public
    function secu_ajax()
    {
        // on vide les donnée qui pourai existé
            $_SESSION['sbox_function']['secu_ajax'] = array();
        // on génére une 1 ère clée aléatore privé
            $_SESSION['sbox_function']['secu_ajax'][1] = substr("no3:pqrst5uvw9.xy6z", rand(-10,-1), rand(1,9)).substr("ab.7cde1!fghij2!klm8", rand(1,9), rand(-10,-1));
        // on génère une 2 ère clée aléatoire privé
            $_SESSION['sbox_function']['secu_ajax'][2] = rand();
        // on génére une 2 eme clée aléatore public
            $serial = md5($_SESSION['sbox_function']['secu_ajax'][1].$_SESSION['sbox_function']['secu_ajax'][2]);
                    
        return $serial;
    }
}

// Class commumn de cache ( APC Extension )
class sbox_cache extends sbox
{
	function get($key)
	{
		return apc_fetch($key);	
	}
	
	function add($key,$var,$ttl=0)
	{
		return apc_add($key,$var,$ttl);
	}
	
	function del($key)
	{
		return apc_delete($key);
	}
}

$sbox = new sbox();
?>