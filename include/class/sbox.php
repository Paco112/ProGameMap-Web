<?php                                                   
//********************************************************************************************
//********************************************************************************************
// SECUBOX
// Gestion Securité, MySQL, Timer.
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
$sid_pass = "jghhks89675o:i4er2n:2qsdI6YI4OQZDH.jhu45za";

if (isset($_SESSION['HTTP_USER_AGENT']))
{
    if ($_SESSION['HTTP_USER_AGENT'] != sha1($_SERVER['HTTP_USER_AGENT'].$sid_pass))
    {
        // on regénére un id de session et efface l'ancienne session
        //if(session_regenerate_id(true) == true)
        //{
            // et on detruit tous repartir a neuf
            if(session_destroy() == true)
            {
                // donc retour au site si session toute neuve et personne na rien vu
                header("location: ./index.php");
            }
        //}
        // si la session ne peut etre détruite et regénéré pour X raison on reste bloqué ici
        exit;
        exit();
        exit(0);
    }
	else
	{
    	$_SESSION['visits']++;
	}
}
else
{
    if(session_regenerate_id(true) == true)
	{
		$_SESSION['HTTP_USER_AGENT'] = sha1($_SERVER['HTTP_USER_AGENT'].$sid_pass);
	    $_SESSION['visits'] = 1;
	}
}

// Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (preg_match("/sbox.php/i", $_SERVER['PHP_SELF'])) {
      exit(0);
}

//********************************************************************************************
//********************************************************************************************

class sbox 
{	
    public function __construct()
    {   
		if($_SESSION['conf_sbox'])
		{
			sbox_debug::add("conf_sbox","Session conf_sbox déja existante");
		}
		
		/*
		$_SESSION['GESTION_SESSIONS'] = array();
		
		sbox_function::auto_session('sbox','OUT');
		sbox_function::auto_session('conf_sbox','OUT');
		sbox_function::auto_session('sbox_debug','OUT');
		sbox_function::auto_session('sbox_timer','OUT');
		sbox_function::auto_session('sbox_temp','OUT');
		sbox_function::auto_session('sbox_ajax','OUT');
		
		if(isset($_SESSION['GESTION_SESSIONS']))
		{
			foreach($_SESSION['GESTION_SESSIONS'] as $name => $val)
			{
				foreach($_SESSION['GESTION_SESSIONS'][$name] as $page => $val2)
				{
					foreach($_SESSION['GESTION_SESSIONS'][$name][$page] as $declenche => $action)
					{
						if($page == "ALL" && $declenche == "IN" && $action == "1")
						{
							$_SESSION[$name] = "";
						}
					}					
				}
			}
		}
		*/
		
		
		$_SESSION['i_sbox'] = array();
		$_SESSION['sbox_ip'] = array();
        $_SESSION['conf_sbox'] = array();
        $_SESSION['sbox_debug'] = array();
        $_SESSION['sbox_timer'] = array();
        $_SESSION['sbox_temp'] = array();
		$_SESSION['sbox_ajax'] = 0;
		$_SESSION['sbox_link'] = "";
		
		
        // declenche le timer de stats et inject les config mysql et  de la class
        sbox_timer::start('PHP','PHP','0');
        $this->inject("include/config/config.php");  
    }
    
    public function destruct() 
	{
        
        sbox_timer::stop('0');
		$_SESSION['sbox_timer']['TOTAL'] = sbox_timer::getTime('0');
		$_SESSION['sbox_temp']['php_mem_utiliser'] = round((memory_get_usage()/1024),2);
		$_SESSION['sbox_temp']['php_mem_allouer'] = round((memory_get_usage(true)/1024),2);

		if($_SESSION['sbox_ajax'] != '1')
		{			
			if( ($_SESSION['conf_sbox']['debug'] == true) || ($_SESSION['conf_sbox']['timer'] == true) )
			{
				// injection CSS
				echo '<style>.button{color:#FFF;clear:both;display:block;font-size:13px;font-weight:bold;height:0px;line-height:0px;width:200px;}a.button{text-decoration:none;}.v-menu{border:solid1px#7F9FBF;width:100%;clear:both;background-color:#000;}ul.v-menu,.v-menuli{padding:0;margin:0;list-style:none;background:#272727;color:#FFF;font-family:sans-serif;font-size:13px;}ul.v-menu{clear:both;margin-top:0px;}.v-menulia{color:#555555;font-weight:bold;display:block;border-top:solid1px#DEDEDE;padding:4px;text-decoration:none;}.v-menulia:hover{color:#999999;}</style>';			
				// injection HTML
				echo '<div id="sbox_c" class="sbox_c" name="sbox_c" style="position:absolute; top:0px; z-index:9999; display:block; color:#FFF; cursor:pointer;">
						<table width="200px" border="0" cellspacing="0" cellpadding="0" bgcolor="#272727" style="padding-top:2px; padding-bottom:2px; padding-left:10px;">
     					 <tr>
        					<td nowrap="nowrap" style="text-align:left;"><strong style="color:#FFF;">SECU</strong><strong style="color:#F00">BOX</strong></td>
        					<td id="sbox_c_error" nowrap="nowrap" style="color:#F00; font-size:14px; font-weight:bold;">';
							if($_SESSION['sbox_temp']['STOP'] == 1){ echo "ERREUR CRITIQUE"; } 
							else if($_SESSION['sbox_temp']['ERREUR'] != NULL) { echo $_SESSION['sbox_temp']['ERREUR']." ERREURE(S)";}
                echo '</td></tr></table></div>'
				   . '<div id="debug_bar" name="debug_bar" class="null" style="position:absolute; width:99%; top:0px; z-index:9998; display:none;">'
				   . '<a href="#" class="button" id="toggle"></a>'
				   . '<ul id="v-menu" class="v-menu" style="text-align:left; color:#FFF; padding-top:30px;"></ul>'
				   . '</div>';
					 
				// injection JS
				echo '<input id="inc_sbox_debug" name="inc_sbox_debug" type="hidden" value="http://www.progamemap.com/include/class/sbox_view.php" />';
				echo '<script type="text/javascript" src="http://www.progamemap.com/public/js/sbox_debug.js"></script>';
					
			}
		}
		
		
		//print_r($_SESSION['conf_sbox']);
        
        // fonction declenché lors de la destruction de la class c'est elle qui va créer l'affichge du debug
		/*
		if($_SESSION['sbox_ajax'] != '1')
		{
			if( ($_SESSION['conf_sbox']['debug'] == true) || ($_SESSION['conf_sbox']['timer'] == true) )
			{            
				include_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox_view.php");            
			}
			
			$_SESSION['sbox_ajax'] = 0;
			$_SESSION['i_sbox'] = array();
			$_SESSION['conf_sbox'] = array();
			$_SESSION['sbox_debug'] = array();
			$_SESSION['sbox_timer'] = array();
			$_SESSION['sbox_temp'] = array();
			
		}
		*/
		
		//print_r($_SERVER);
		
		//$_SESSION['GESTION_SESSIONS'][$name][$page][$declenche] = $action
/*
		print_r($_SESSION['GESTION_SESSIONS']);
		
		if(isset($_SESSION['GESTION_SESSIONS']))
		{
			foreach($_SESSION['GESTION_SESSIONS'] as $name => $val)
			{
				foreach($_SESSION['GESTION_SESSIONS'][$name] as $page => $val2)
				{
					foreach($_SESSION['GESTION_SESSIONS'][$name][$page] as $declenche => $action)
					{
						if($page == "ALL" && $declenche == "OUT" && $action == "1")
						{
							$_SESSION[$name] = "";
							print_r($name."<br />");
						}
					}					
				}
			}
		}
		*/
       
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
        
        if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            sbox_debug::add("Pile PHP",sbox_debug::Linecall());
        }
        
        if(file_exists($_SERVER['DOCUMENT_ROOT']."/".$file)) 
        {              
            if(!@include($_SERVER['DOCUMENT_ROOT']."/".$file))
            {
                sbox_debug::add("include", $_SERVER['DOCUMENT_ROOT']."/".$file,"",$stop);
            }
            else
            {
                sbox_debug::add("include", $_SERVER['DOCUMENT_ROOT']."/".$file,0,0);   
            }
        }
        else
        {
            sbox_debug::add("include", $_SERVER['DOCUMENT_ROOT']."/".$file,"",$stop);
        } 
		
		// activation de la resctriction ip
		if($_SESSION['conf_sbox']['ip_only'] == true)
		{
			if(array_search($_SERVER['REMOTE_ADDR'],$_SESSION['sbox_ip']) === false)
			{
				$_SESSION['conf_sbox']['timer'] 		= false;
				$_SESSION['conf_sbox']['debug'] 		= false; 
				$_SESSION['conf_sbox']['debug_max'] 	= false;
				$_SESSION['conf_sbox']['exec_exit'] 	= true;
			}
		}
    }
	
    function auto_connect($id_base=0,$force_new=0) 
    {    
		// Connection automatique a la base    via info config 
        $tfc = sbox_timer::start('FUNCTION','auto_connect');
        
        if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            sbox_debug::add("Pile PHP",sbox_debug::Linecall());
        }
        
        if($id_base == NULL)
        {
            $id_base=0;
        }
                
        if(!@$_SESSION['sbox_link']->thread_id || $force_new==1)
        {           
            if($_SESSION['conf_sbox']['debug'] == true)
            {
				sbox_debug::add("<br>INFO", "<br>Aucune Connection MySQL Active !","Connection MySQL ID[".$id_base."] : '".$_SESSION['i_sbox'][$id_base]['ip']." @ ".$_SESSION['i_sbox'][$id_base]['login']."' ...");
            }

            $_SESSION['sbox_temp']['id_timer_connect'] = sbox_timer::start('MYSQL','Connection');    
            $mysqli = new mysqli($_SESSION['i_sbox'][$id_base]['ip'],$_SESSION['i_sbox'][$id_base]['login'],$_SESSION['i_sbox'][$id_base]['password'],$_SESSION['i_sbox'][$id_base]['base']);
            
            if(mysqli_connect_errno())
            {
                sbox_debug::add("mysql", "Connection MySQL ID[".$id_base."] : '".$_SESSION['i_sbox'][$id_base]['base']."' (ID_ERREUR : ".mysqli_connect_errno().")", mysqli_connect_error(),1);   
            }
            else
            {                                                                                                 
                if($_SESSION['conf_sbox']['debug'] == true)
                {
                    sbox_debug::add("mysql", "Connection MySQL ID[".$id_base."] : '".$_SESSION['i_sbox'][$id_base]['ip']." @ ".$_SESSION['i_sbox'][$id_base]['login']."'");
                }
                
                //if(mysqli_select_db($link,$_SESSION['i_sbox'][$id_base]['base']))
                //{
                    sbox_timer::stop($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL');
                    
                    if($_SESSION['conf_sbox']['debug'] == true)
                    {
                        sbox_debug::add("mysql", "Ouverture de la Base : '".$_SESSION['i_sbox'][$id_base]['base']."'");
                        sbox_debug::add("text", "Temps de Connection MYSQL : ".sbox_timer::getTime($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL')."<br><br>");
                    }
                    
                    sbox_timer::stop($tfc,'FUNCTION');
                    sbox_timer::getTime($tfc,'FUNCTION');
					$_SESSION['sbox_link'] = $mysqli;
                    return $mysqli;
               /*
			   	}
                else
                {
                    sbox_timer::stop($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL');
                    sbox_debug::add("mysql", "Erreur d'ouverture de la Base : '".$_SESSION['i_sbox'][$id_base]['base']."' (ID_ERREUR : ".mysqli_errno($link).")", mysqli_error($link),1);
                    sbox_debug::add("text", "Temps de Connection MYSQL : ".sbox_timer::getTime($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL')."<br><br>");
                    sbox_timer::stop($tfc,'FUNCTION');
                    sbox_timer::getTime($tfc,'FUNCTION');
					$_SESSION['sbox_link'] = '';
                    return false;
                }
				*/
            }
            
        }
        else
        {
            $_SESSION['sbox_temp']['id_timer_ping'] = "1";
            return $_SESSION['sbox_link'];
        }
    }
    
    function syntaxe_option($arg, $mod)
    {
        $return = FALSE;
		$new_option = array();
		
		if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            sbox_debug::add("Pile PHP",sbox_debug::Linecall());
        }
		
        // on commence par verifier que les paramètres passées sont conforme au model
		if(is_array($arg))
        {
            foreach($mod as $key => $value)
            {
				
				if(($value == 1) && (($arg[$key] == NULL) || ($arg[$key] == "")))
                {
                	sbox_debug::add("param", sbox_debug::array_to_list($arg,1)."<br><br>Le Paramètre : ".$key." est OBLIGATOIRE !<br><br>", sbox_debug::array_to_list($mod,1),1); 
                }
				else if( ($value == "array") && ( (!is_array($arg['set'])) && (isset($arg['set'])) ) )
				{
					sbox_debug::add("param", sbox_debug::array_to_list($arg,1)."<br><br>Le Paramètre : ".$key." est OBLIGATOIRE ( celui-ci doit etre de type Array ) !<br><br>", sbox_debug::array_to_list($mod,1),1);
				}				
            }
			
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
                                    /*if(function_exists('mysqli_real_escape_string')) 
                                    {
                                        $new_option['set'][$key3][$key4] = mysqli_real_escape_string($_SESSION['sbox_link'],$value4);
                                        $return = TRUE;
                                    } 
                                    elseif(function_exists('mysqli_escape_string')) 
                                    {
                                        $new_option['set'][$key3][$key4] = mysqli_escape_string($value4);
                                        $return = TRUE;
                                    } 
                                    else 
                                    {*/
                                        $new_option['set'][$key3][$key4] = addslashes($value4);
                                        $return = TRUE;
                                    //}
							    }	
						    }
					    }
				    }
				    elseif(($value2 != NULL) && ($value2 != ""))
				    {
                        /*
                        if(function_exists('mysqli_real_escape_string')) 
                        {
                            $new_option[$key2] = mysqli_real_escape_string($_SESSION['sbox_link'],$value2);
                            $return = TRUE;
                        } 
                        elseif(function_exists('mysqli_escape_string')) 
                        {
                            $new_option[$key2] = mysqli_escape_string($value2);
                            $return = TRUE;
                        } 
                        else 
                        {*/
                            $new_option[$key2] = addslashes($value2);
                            $return = TRUE;
                        //}
				    }
                }
                else
                {
                    sbox_debug::add("param", sbox_debug::array_to_list($arg,1)."<br><br>Le Paramètre : ".$key2." est Incorrect !<br><br>", sbox_debug::array_to_list($mod,1),1);
                }			
			}			
						
        }
        else
        {
            sbox_debug::add("param", sbox_debug::array_to_list($arg,1)."<br><br>Type Options invalide !<br><br>", sbox_debug::array_to_list($mod,1),1); 
        }
		
        //$new_option = str_replace("/","'",$new_option);
        
        if($return == TRUE)
		{
            return $new_option;
		}
		else
		{
			sbox_debug::add("param", sbox_debug::array_to_list($arg,1)."<br><br>ERREUR CRITIQUE !<br><br>", sbox_debug::array_to_list($mod,1),1);
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
        $t_read = sbox_timer::start('FUNCTION','select');
        $return = FALSE;
		$object = NULL;
        
        // affiche la pile php
        if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            sbox_debug::add("Pile PHP",sbox_debug::Linecall());
        }
        
        $model['table']=1;
		$model['select']=1;
        $model['where']=0;
        $model['order by']=0;
        $model['mode']=0;          
        $model['id_base']=0;
        $model['key']=0;
                  
		// on verifie si une connection est deja active sinon on tente une connection
		$mysqli = $this->auto_connect($option['id_base']);
		
        $t_traitement = sbox_timer::start();
        
        // Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
		$option = $this->syntaxe_option($option, $model);
        
        //echo "ID: ".array_search('Connection',$_SESSION['sbox_timer']);
        
        $sql = "SELECT ".$option['select']." FROM ".$option['table'];

        if($option['where'])
        {
         $sql .= " WHERE ".$option['where'];
		 // marquage des guillemets
		 $sql = str_replace("/","'",$sql);
        }

        if($option['order by'])
        {
         $sql .= " ORDER BY ".$option['order by'];
        }
		
		// marquage des guillemets
		$sql = preg_replace('/([a-zA-Z0-9_-])=\/(.*)\//','${1}=\'${2}\'',$sql);
		
		//$sql = preg_replace('/([a-zA-Z0-9_-])=\/(.*)\//','${1}=\'${2}\'',$sql);
		//$sql = preg_replace('/([a-zA-Z0-9_-])=\'(.*)\/(\s+)/','${1}=\'${2}\' ',$sql);
		//$sql = preg_replace('/=\/(.*)\/(\s)/','=\'${1}\' ',$sql);
		//$sql = preg_replace('/=\/(.*)\/(\s)/','=\'${1}\' ',$sql);
		
        
        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("mysql", "Requete MySQL : ".$sql);
        }

        sbox_timer::stop($t_traitement);
        $time_traitement = sbox_timer::getTime($t_traitement);
        
        $t_req = sbox_timer::start("MYSQL");
        $result = $mysqli->query($sql);
        sbox_timer::stop($t_req,"MYSQL");
        $time_sql = sbox_timer::getTime($t_req,"MYSQL");

        $t_traitement2 = sbox_timer::start();
        
        if(!$result)
        {
            sbox_debug::add("mysql", "Echec de la Requete (ID_ERREUR : ".$mysqli->errno.")", $mysqli->error);
			return FALSE;
        }
        else
        {
         
            $object = $result->fetch_object();
			$result->close();
			//if(is_object($object))
			//{
				$return = TRUE;
			//}
        }
        
        sbox_timer::stop($t_traitement2);
        $time_traitement2 = sbox_timer::getTime($t_traitement2);      
                  
        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("Reponse MySQL", sbox_debug::mysqli_object_to_list($object)."<br>Execution MySQL : ".$time_sql."s");
        }
        
        if($_SESSION['conf_sbox']['timer'] == true)
        {
            if(!$_SESSION['sbox_temp']['id_timer_ping'])
            {
                $t_connect = sbox_timer::getTime($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL');
            }
            else
            {
                $t_connect = 0;
            }
            sbox_timer::stop($t_read,'FUNCTION');
            sbox_debug::add("STATS","select() :           Traitement PHP : ".($time_traitement+$time_traitement2)."s          Time MySQL : ".($time_sql+$t_connect)."s          Time Debug : ".(sbox_timer::getTime($t_read,'FUNCTION')-$time_sql-$t_connect-$time_traitement-$time_traitement2)."s          Time Total : ".sbox_timer::getTime($t_read,'FUNCTION')."s");
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
        if($_SESSION['conf_sbox']['timer'] == true)
		{
			$t_read = sbox_timer::start('FUNCTION','select_multi');
		}
		
		$t_connect = NULL;
		$apc_read = 0;
		$return = FALSE; 
        
        // affiche la pile php
        if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            sbox_debug::add("Pile PHP",sbox_debug::Linecall());
        }
        
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
			$mysqli = sbox::auto_connect($option['id_base']);
			
			// declenche le premier timer de traitement php
			$t_traitement = sbox_timer::start();
			
			// Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
			$option = sbox::syntaxe_option($option, $model);
			
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
				// marquage des guillemets
		 		$sql = str_replace("/","'",$sql);
			}
	
			if($option['order by'])
			{
				$sql .= " ORDER BY ".$option['order by'];
			}
			
			if($option['limit'])
			{
				$sql .= " LIMIT ".$option['limit'];
			}
			
			// marquage des guillemets
			$sql = preg_replace('/([a-zA-Z0-9_-])=\/(.*)\//','${1}=\'${2}\'',$sql);
			
			sbox_timer::stop($t_traitement);
			$time_traitement = sbox_timer::getTime($t_traitement);    
			
			if($_SESSION['conf_sbox']['debug'] == true)
			{
				sbox_debug::add("mysql", "Requete MySQL : ".$sql);
			}
	
			$t_req = sbox_timer::start("MYSQL");
			$result = $mysqli->query($sql);
			sbox_timer::stop($t_req,"MYSQL");
			$time_sql = sbox_timer::getTime($t_req,"MYSQL");
			
			if(!$result)
			{
				sbox_debug::add("mysql", "Echec de la Requete (ID_ERREUR : ".$mysqli->errno.")", $mysqli->error);
				return FALSE;
			}
			else
			{
			 
				$t_traitement2 = sbox_timer::start();
				
				if(!$option['mode'] || $option['mode'] == "assoc")
				{
					$key_type = 0;
					
					while($row = $result->fetch_assoc())
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
					
					while($row = $result->fetch_row())
					{
						$array[] = $row;
					} 
				}
				if(is_array($array))
				{
					$return = TRUE;
				}
				
				$result->close();
				
				sbox_timer::stop($t_traitement2);
				$time_traitement = sbox_timer::getTime($t_traitement2);
			}
					  
			if($_SESSION['conf_sbox']['debug'] == true)
			{
				if(is_array($array))
				{
					sbox_debug::add("Reponse MySQL", sbox_debug::mysqli_to_list($array, $cle)."<br>Execution MySQL : ".$time_sql."s");
				}
				else
				{
					sbox_debug::add("Reponse MySQL", "Reponse VIDE<br>Execution MySQL : ".$time_sql."s - Traitement PHP : ".$time_traitement."s");
				}
			}
		        
			if($_SESSION['conf_sbox']['timer'] == true)
			{
				if(!$_SESSION['sbox_temp']['id_timer_ping'])
				{
					$t_connect = sbox_timer::getTime($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL'); 
				}
				else
				{
					$t_connect = 0;
				}
				sbox_timer::stop($t_read,'FUNCTION');
				sbox_debug::add("STATS","select_multi() :  Traitement PHP : ".($time_traitement+$time_traitement2)."s          Time MySQL : ".($time_sql+$t_connect)."s          Time Debug : ".(sbox_timer::getTime($t_read,'FUNCTION')-$time_sql-$t_connect-$time_traitement-$time_traitement2)."s          Time Total : ".sbox_timer::getTime($t_read,'FUNCTION')."s");
			}
			
			if($option['apc'] != '' && $return == TRUE)
			{
					sbox_cache::add($option['apc'],$array,$option['apc_ttl']);
			}
		}
		
		if($apc_read == 1)
		{
			if($_SESSION['conf_sbox']['debug'] == true)
			{
				sbox_debug::add("Reponse MySQL", sbox_debug::mysqli_to_list($array));	
			}
			if($_SESSION['conf_sbox']['timer'] == true)
			{
				sbox_timer::stop($t_read,'FUNCTION');
				sbox_debug::add("STATS","select_multi() :  Traitement PHP : ".($time_traitement+$time_traitement2)."s          Time MySQL : ".($time_sql+$t_connect)."s          Time Debug : ".(sbox_timer::getTime($t_read,'FUNCTION')-$time_sql-$t_connect-$time_traitement-$time_traitement2)."s          Time Total : ".sbox_timer::getTime($t_read,'FUNCTION')."s");
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
        // declenche le timer stats de la fonction
        $t_update = sbox_timer::start('FUNCTION','update');
                
        $set_string = NULL;
		$result = FALSE;
		        
        // info de la pile php
        if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            sbox_debug::add("Pile PHP",sbox_debug::Linecall());
        }
        
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
		$model['limit']=0;
         
		// on verifie si une connection est deja active sinon on tente une connection
		$mysqli = $this->auto_connect($option['id_base']);
		
        // declenche le timer de traitement php
        $t_traitement = sbox_timer::start();
        
        // Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
		$option = $this->syntaxe_option($option, $model);
        
		// transforme l'array de l'option set en une ligne de commande mysql
		foreach($option['set'] as $key => $value)
		{
			foreach($value as $key2 => $value2)
			{
				// on verifie si la valeur doit etre executer ( donc sans guillement )
				if(preg_match('/^\!\#\{(.*)\}$/',$value2,$tab_v))
				{
					$new_val = $tab_v[1];
				}
				else
				{
					$new_val = '"'.$value2.'"';
				}			
				
				if($set_string == NULL)
				{
					$set_string = $key2."=".$new_val." ";
				}
				else
				{
					$set_string .= ", ".$key2."=".$new_val." ";
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
		 // marquage des guillemets
		 $sql = str_replace("/","'",$sql);
        }

        if($option['order by'])
        {
         $sql .= " ORDER BY ".$option['order by'];
        }
		
        if($option['limit'] == "")
		{
			$sql .= " LIMIT 1";
		}
		elseif($option['limit'] != "0")
		{
			$sql .= " LIMIT ".$option['limit'];
		}
		
		// marquage des guillemets
		$sql = preg_replace('/([a-zA-Z0-9_-])=\/(.*)\//','${1}=\'${2}\'',$sql);
        
		sbox_timer::stop($t_traitement);
        $time_traitement = sbox_timer::getTime($t_traitement);
        
        // affiche la requete créer dans le debugger
        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("mysql", "Requete MySQL : ".$sql);
        }

        // lance la requete et les timers qui vont avec
		$t_req = sbox_timer::start("MYSQL");
        $result = $mysqli->query($sql);
        sbox_timer::stop($t_req,"MYSQL");
        $time_sql = sbox_timer::getTime($t_req,"MYSQL");
       
        // test la réponse si erreur
		if($result == FALSE)
        {
            sbox_debug::add("mysql", "Echec de la Requete (ID_ERREUR : ".$mysqli->errno.")", $mysqli->error);
			return FALSE;
        }     
                  
        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("Reponse MySQL", "OK - Execution MySQL : ".$time_sql."s");
        }

        if($_SESSION['conf_sbox']['timer'] == true)
        {
            if(!$_SESSION['sbox_temp']['id_timer_ping'])
            {
                $t_connect = sbox_timer::getTime($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL'); 
            }
            else
            {
                $t_connect = 0;
            }
            sbox_timer::stop($t_update,'FUNCTION');
            sbox_debug::add("STATS","update() :         Traitement PHP : ".$time_traitement."s          Time MySQL : ".($time_sql+$t_connect)."s          Time Debug : ".(sbox_timer::getTime($t_update,'FUNCTION')-$time_sql-$t_connect-$time_traitement)."s          Time Total : ".sbox_timer::getTime($t_update,'FUNCTION')."s");
        }
        
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
        // declenche le timer stats de la fonction
        $t_insert = sbox_timer::start('FUNCTION','insert');
		$set_string = NULL;
		$result = FALSE;
		
        
		// info de la pile php
        if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            sbox_debug::add("Pile PHP",sbox_debug::Linecall());
        }
        
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
		$mysqli = $this->auto_connect($option['id_base']);
		
        // declenche le timer de traitement PHP
        $t_traitement = sbox_timer::start();
        
        // Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
		$option = $this->syntaxe_option($option, $model);
        
		// transforme l'array de l'option set en une ligne de commande mysql
		foreach($option['set'] as $key => $value)
		{
			foreach($value as $key2 => $value2)
			{
				if($set_string == NULL)
				{
					$set_string = $key2."='".$value2."' ";
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
		
		// marquage des guillemets
		$sql = preg_replace('/([a-zA-Z0-9_-])=\/(.*)\//','${1}=\'${2}\'',$sql);

		
        // stop le timer de traitement php et recupère le score
		sbox_timer::stop($t_traitement);        
        $time_traitement = sbox_timer::getTime($t_traitement);
                
		// affiche la requete créer dans le debugger
        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("mysql", "Requete MySQL : ".$sql);
        }
                
        // lance la requete et les timers qui vont avec
		$t_req = sbox_timer::start("MYSQL");
        $result = $mysqli->query($sql);
        sbox_timer::stop($t_req,"MYSQL");
        $time_sql = sbox_timer::getTime($t_req,"MYSQL");
              
        // test la réponse si erreur
		if($result == FALSE)
        {
            sbox_debug::add("mysql", "Echec de la Requete (ID_ERREUR : ".$mysqli->errno.")", $mysqli->error);
			return FALSE;
        }

        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("Reponse MySQL", "OK - Execution MySQL : ".$time_sql."s");
        }
        
        if($_SESSION['conf_sbox']['timer'] == true)
        {            
            if(!$_SESSION['sbox_temp']['id_timer_ping'])
            {
                $t_connect = sbox_timer::getTime($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL'); 
            }
            else
            {
                $t_connect = 0;
            }
            
            sbox_timer::stop($t_insert,'FUNCTION');
            sbox_debug::add("STATS","insert() :           Traitement PHP : ".$time_traitement."s          Time MySQL : ".($time_sql+$t_connect)."s          Time Debug : ".(sbox_timer::getTime($t_insert,'FUNCTION')-$time_sql-$t_connect-$time_traitement)."s          Time Total : ".sbox_timer::getTime($t_insert,'FUNCTION')."s");
        }
        
        return $result;
    }
	
	function custom($option)
    {
        // declenche le timer stats de la fonction
        $t_insert = sbox_timer::start('FUNCTION','custom');
		$set_string = NULL;
		$result = FALSE;
		
        
		// info de la pile php
        if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            sbox_debug::add("Pile PHP",sbox_debug::Linecall());
        }
        
		// modeles de syntaxe
		$model['query']=1;
         
		// on verifie si une connection est deja active sinon on tente une connection
		$mysqli = $this->auto_connect($option['id_base']);
		
        // declenche le timer de traitement PHP
        $t_traitement = sbox_timer::start();
        
        // Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
		$option = $this->syntaxe_option($option, $model);
		
        // stop le timer de traitement php et recupère le score
		sbox_timer::stop($t_traitement);        
        $time_traitement = sbox_timer::getTime($t_traitement);
                
		// affiche la requete créer dans le debugger
        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("mysql", "Requete MySQL : ".$option['query']);
        }
                
        // lance la requete et les timers qui vont avec
		$t_req = sbox_timer::start("MYSQL");
        $result = $mysqli->query($option['query']);
        sbox_timer::stop($t_req,"MYSQL");
        $time_sql = sbox_timer::getTime($t_req,"MYSQL");
              
        // test la réponse si erreur
		if($result == FALSE)
        {
            sbox_debug::add("mysql", "Echec de la Requete (ID_ERREUR : ".$mysqli->errno.")", $mysqli->error);
			return FALSE;
        }

        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("Reponse MySQL", "OK - Execution MySQL : ".$time_sql."s");
        }
        
        if($_SESSION['conf_sbox']['timer'] == true)
        {            
            if(!$_SESSION['sbox_temp']['id_timer_ping'])
            {
                $t_connect = sbox_timer::getTime($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL'); 
            }
            else
            {
                $t_connect = 0;
            }
            
            sbox_timer::stop($t_insert,'FUNCTION');
            sbox_debug::add("STATS","custom() :           Traitement PHP : ".$time_traitement."s          Time MySQL : ".($time_sql+$t_connect)."s          Time Debug : ".(sbox_timer::getTime($t_insert,'FUNCTION')-$time_sql-$t_connect-$time_traitement)."s          Time Total : ".sbox_timer::getTime($t_insert,'FUNCTION')."s");
        }
        
        return $result;
    }
	
	function delete($option)
    {
        $t_read = sbox_timer::start('FUNCTION','delete');
        $return = FALSE;
        
        // affiche la pile php
        if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            sbox_debug::add("Pile PHP",sbox_debug::Linecall());
        }
        
        $model['table']=1;
        $model['where']=0;
        $model['id_base']=0;
                  
		// on verifie si une connection est deja active sinon on tente une connection
		$mysqli = $this->auto_connect($option['id_base']);
		
        $t_traitement = sbox_timer::start();
        
        // Verifie la syntaxe des options afin d'un bon fonctionement de la fonction et securise la requete MySQL ( la connection doit etre péalablement établie )
		$option = $this->syntaxe_option($option, $model);
        
        //echo "ID: ".array_search('Connection',$_SESSION['sbox_timer']);
        
        $sql = "DELETE FROM ".$option['table'];

        if($option['where'])
        {
         $sql .= " WHERE ".$option['where'];
		 // marquage des guillemets
		 $sql = str_replace("/","'",$sql);
        }
		
		// marquage des guillemets
		$sql = preg_replace('/([a-zA-Z0-9_-])=\/(.*)\//','${1}=\'${2}\'',$sql);
		
		// limitation a 1 supreesion par requete
		$sql .= " LIMIT 1";		
        
        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("mysql", "Requete MySQL : ".$sql);
        }

        sbox_timer::stop($t_traitement);
        $time_traitement = sbox_timer::getTime($t_traitement);
        
        $t_req = sbox_timer::start("MYSQL");
        $result = $mysqli->query($sql);
        sbox_timer::stop($t_req,"MYSQL");
        $time_sql = sbox_timer::getTime($t_req,"MYSQL");

        $t_traitement2 = sbox_timer::start();
        
        if(!$result)
        {
            sbox_debug::add("mysql", "Echec de la Requete (ID_ERREUR : ".$mysqli->errno.")", $mysqli->error);
			return FALSE;
        }
        else
        {
         	$return = TRUE;
        }
        
        sbox_timer::stop($t_traitement2);
        $time_traitement2 = sbox_timer::getTime($t_traitement2);      
                  
        if($_SESSION['conf_sbox']['debug'] == true)
        {
            sbox_debug::add("Reponse MySQL", sbox_debug::mysqli_object_to_list($object)."<br>Execution MySQL : ".$time_sql."s");
        }
        
        if($_SESSION['conf_sbox']['timer'] == true)
        {
            if(!$_SESSION['sbox_temp']['id_timer_ping'])
            {
                $t_connect = sbox_timer::getTime($_SESSION['sbox_temp']['id_timer_connect'],'MYSQL');
            }
            else
            {
                $t_connect = 0;
            }
            sbox_timer::stop($t_read,'FUNCTION');
            sbox_debug::add("STATS","delete() :           Traitement PHP : ".($time_traitement+$time_traitement2)."s          Time MySQL : ".($time_sql+$t_connect)."s          Time Debug : ".(sbox_timer::getTime($t_read,'FUNCTION')-$time_sql-$t_connect-$time_traitement-$time_traitement2)."s          Time Total : ".sbox_timer::getTime($t_read,'FUNCTION')."s");
        }
        
        if($return == TRUE)
		{
			return $result;
		}
		else
		{
			return FALSE;
		}
    }
	   
}


// Class de gestion du debuggage et de la mise en forme ( pas la présentation JS )
class sbox_debug extends sbox
{    
    
    public static function add($type,$info,$res=0,$stop=0)
    {        
        if(($_SESSION['conf_sbox']['debug'] == true) && ($type != "Pile PHP") && ($type != "STATS"))
        {
            if(is_array($info))
            {            
                $info = sbox_debug::array_to_list($info);
            }
            
            $i = count($_SESSION['sbox_debug']['list'])+1;
            
            switch($type)
            {
                default:
                    $_SESSION['sbox_debug']['list'][$i][$type] = $info;
                    break;
                case "text":
                    $_SESSION['sbox_debug']['list'][$i]['INFO'] = $info;
                    $i++;
                    if($res != "0")
                    {
                        $_SESSION['sbox_debug']['list'][$i]['ACTION'] = $res;
                    }
                    break;
                case "param":
                    $_SESSION['sbox_debug']['list'][$i]['PARAMETRE INCORRECT'] = $info;
                    $i++;
                    $_SESSION['sbox_temp']['ERREUR']++;
                    if($res != "0")
                    {
                        $_SESSION['sbox_debug']['list'][$i]['PARAMETRE POSSIBLE'] = $res;
                    }
                    break;
                case "syntaxe":
                    $_SESSION['sbox_debug']['list'][$i]['ERREUR DE SYNTAXE'] = $info;
                    $i++;
                    $_SESSION['sbox_temp']['ERREUR']++;
                    if($res != "0")
                    {
                        $_SESSION['sbox_debug']['list'][$i]['CORRECTION'] = $res;
                    }
                    break;
                case "template":
                    if($res != "0")
                    {
                        $_SESSION['sbox_debug']['list'][$i]['ERREUR'] = "Une erreur c'est produite lors du chargement du template : ".$info;
                        $i++;
                        $_SESSION['sbox_debug']['list'][$i]['RESOLUTION POSSIBLE'] = $res;
                        $_SESSION['sbox_temp']['ERREUR']++;
                    }
                    else
                    {
                        $_SESSION['sbox_debug']['list'][$i]['Template'] = "Template chargé avec succès : ".$info;
                        $stop=0;
                    }
                    break;                
                case "include":
                    if($res != "0")
                    {
                        $_SESSION['sbox_debug']['list'][$i]['ERREUR'] = "Une erreur c'est produite lors de l'injection du fichier : ".$info;
                        $i++;
                        $_SESSION['sbox_debug']['list'][$i]['RESOLUTION POSSIBLE'] = "Emplacement du fichier demandé : ".$res;
                        $_SESSION['sbox_temp']['ERREUR']++;
                    }
                    else
                    {
                        $_SESSION['sbox_debug']['list'][$i]['INCLUDE'] = $info." OK<br><br>";
                        $stop=0;
                    }
                    break;
                case "mysql":
                    if($res != "0")
                    {
                        $_SESSION['sbox_debug']['list'][$i]['ERREUR'] = $info;
                        $i++;
                        $_SESSION['sbox_debug']['list'][$i]['RETOUR MYSQL'] = $res;
                        $_SESSION['sbox_temp']['ERREUR']++;
                    }
                    else
                    {
                        $_SESSION['sbox_debug']['list'][$i]['Action MySQL'] = $info." OK";
                        $stop=0;
                    }
                    break;
            }
                        
        }
		elseif( ($_SESSION['conf_sbox']['timer'] == true) && ($type == "STATS") )
        {
			
            $i = count($_SESSION['sbox_debug']['list'])+1;
            $_SESSION['sbox_debug']['list'][$i][$type] = $info."<br><br>";
		}
        elseif(($_SESSION['conf_sbox']['debug_max'] == true) && ($type == "Pile PHP"))
        {
            $i = count($_SESSION['sbox_debug']['list'])+1;
            $_SESSION['sbox_debug']['list'][$i][$type] = $info."<br><br>";
        }
        
        if($stop==1)
        {
            if($_SESSION['conf_sbox']['exec_exit'] != false || $_SESSION['conf_sbox']['exec_exit'] == true)
            {
                //print('STOP ERREUR<br><br>');
                $_SESSION['sbox_temp']['STOP'] = "1";
                exit();
            }
        }       

    }
    
    public static function Linecall() 
    { 
        if($_SESSION['conf_sbox']['debug_max'] == true)
        {
            $trace = debug_backtrace();
            
            for ($id = count($trace) - 1; $id > 0; $id--) {
                $item = $trace[$id];
                if(isset($item['file']))
                {
                    $path = pathinfo($item['file']);
                    $file = $path['filename'].".".$path['extension']." => ligne(".$item['line'].")";
                }
                else
                {
                    $file = 'eval()';
                }
                if(isset($item['class']))
                {
                    $func = "<br>ACTION : ".$item['class'] . '->' . $item['function'];
                }
                else
                {
                    $func = "<br>ACTION : ".$item['function'];
                }
                if(isset($item['args']))
                {
                     $arg = sbox_debug::array_to_list($item['args'],1);
                }
                //$rep .= $file."<br>".$func."(".$arg.")";
                $rep .= sprintf("%s %s(%s)<br><br>", $file, $func, $arg);

            }
            
            return $rep;
        }
    } 
    
    public static function array_to_list($array,$no_print=0,$coup=",",$key_numeric=0)
    {
        if( ($_SESSION['conf_sbox']['debug'] == true) || ($_SESSION['conf_sbox']['timer'] == true) )
        {
            if(is_array($array) && $array != null)
            {
                $i = count($_SESSION['sbox_debug']['list'])+1;
                
                foreach($array as $key => $value)
                {
                    $key_f = sbox_debug::array_to_list($key,$no_print);
                    $val_f = sbox_debug::array_to_list($value,$no_print);
                    
                    if(!is_numeric($key))
                    {
                        $list[] = "[".$key_f."] = '".$val_f."'";
                    }
                    else
                    {
                        $list[] = "{".$val_f."}";
                    }
                    
                    if(!is_numeric($key) && $no_print == 0 && $value != "")
                    {
                        $_SESSION['sbox_debug']['list'][$i][$key] = $value;
                        $i++;
                    }
                }
                

                foreach($list as $key => $value)
                {
                    if($coup != ",")
                    {
                        if($key == 0)
                        {
                            $rep .= ($key+1).". ".$value;
                        }
                        else
                        {
                            $rep .= $coup.($key+1).". ".$value;
                        }
                    }
                    else
                    {
                        if($key == 0)
                        {
                            $rep .= $value;
                        }
                        else
                        {
                            $rep .= $coup.$value;
                        } 
                    }
                }
                    
                return $rep;
            }
            else
            {
                return $array;
            }
        }
    }
    
    public static function mysqli_to_list($array, $k=0)
    {
        //$l=1;
        foreach($array as $key)
        {
            $temp .= "Ligne ".$key[$k]." : ";
            $i=0;
            foreach($key as $key2 => $val2)
            {
                //echo "Ligne ".$key." : [".$key['id']."]=>".$key['name']."<br>";
                if($key2 == '0' ||$i == '0')
                {
                    $temp .= "[".$key2."]=>'".$val2."'";
                }
                else
                {
                    $temp .= ", [".$key2."]=>'".$val2."'";
                }
                $i++;
            }
            $temp .= "<br>";
            //$l++;
        }
        return $temp;
    }
    
    public static function mysqli_object_to_list($obj)
    {
        if($_SESSION['conf_sbox']['debug'] == true)
        {
            $list ="";
			if($obj != "")
			{
				foreach( $obj as $id => $val ) 
				{
					$list .= $id." = '".$val."'<br>"; // Re-assign the variable to point to the real object   
				}
			}
				return $list;
        }
    }
}

// Class de gestion des Chronos
class sbox_timer extends sbox
{ 
  
  public static function start($type=0,$name=0,$id=0) 
  {
      if(!$type)
      {
          $type = "PHP";
      }
      if(!$id)
      {
          $id = count($_SESSION['sbox_timer'][$type]);
      }      
      if($name)
      {
          $_SESSION['sbox_timer'][$type][$id]['name'] = $name;
      }
      
      $_SESSION['sbox_timer'][$type][$id]['start'] = microtime();
      
      return $id;
  }
  
  public static function stop($id,$type=0) 
  {
      $temp_stop = microtime();
      
      if(!$type)
      {
          $type = "PHP";
      }
      
      $_SESSION['sbox_timer'][$type][$id]['stop'] = $temp_stop;
  }
  
  public static function getTime($id,$type=0) 
  {
      if(!$type)
      {
          $type = "PHP";
      }
      list($uSecondeA, $SecondeA) = explode(' ',$_SESSION['sbox_timer'][$type][$id]['start']);
      list($uSecondeB, $SecondeB) = explode(' ',$_SESSION['sbox_timer'][$type][$id]['stop']);
      $total = ($SecondeA - $SecondeB) + ($uSecondeA - $uSecondeB);
      $_SESSION['sbox_timer'][$type][$id]['time'] = number_format(abs($total),6);
      return $_SESSION['sbox_timer'][$type][$id]['time'];
  }
  
}

// Class commumn de securité
class sbox_function extends sbox
{
    // securise une transaction ajax via 3 clée de cryptage dont 1 est public
    public static function secu_ajax()
    {
        
		$key_public = rand().microtime();
		$key_public = str_replace("0.","",$key_public);
		$key_public = str_replace(" ","",$key_public);
		
		$key_prive2 = sha1(rand());
		
		// on vide les donnée qui pourai existé
            $_SESSION['sbox_function']['secu_ajax'] = array();
			$_SESSION['sbox_function']['secu_ajax']['2'] = $key_prive2;
			$_SESSION['sbox_function']['secu_ajax']['1'] = sha1($key_prive2.$key_public.$key_prive2);
	   
            sbox_debug::add('AJAX SECU','Key Private 1 : '.$_SESSION['sbox_function']['secu_ajax']['1']);
            sbox_debug::add('AJAX SECU','Key Private 2 : '.$_SESSION['sbox_function']['secu_ajax']['2']);
            sbox_debug::add('AJAX SECU','Key Public : '.$key_public."<br><br>");	
		
        return $key_public;
    }
	
	// fonction de verification du serial secu_ajax
	public static function check_ajax($raz = true)
	{
		$key_public = $_POST['sa'];
		$key_prive1 = $_SESSION['sbox_function']['secu_ajax']['1'];
		$key_prive2 = $_SESSION['sbox_function']['secu_ajax']['2'];
		
		$key_check = sha1($key_prive2.$key_public.$key_prive2);

		
		if($key_check != $key_prive1)
		{
			$_SESSION['sbox_function']['secu_ajax'] = array();
			$_POST['sa'] = "";
			sbox_debug::add('AJAX SECU','KEY INCORRECT !');
			//exit();
			//exit();
		}
		
		if($raz == true)
		{
			$_SESSION['sbox_function']['secu_ajax'] = array();
			$_POST['sa'] = "";
			sbox_debug::add('AJAX SECU','RAZ DES KEYS');
		}
		
	}
	
	// fonction de gestion des session
	public static function auto_session($name,$declenche=0,$page="ALL",$action=1)
	{
		// Nom de la session : $name 
		// Si $start = 1 on initialise la variable seulement si elle n'existe pas
		// si $action = 1 on supprime pas la variable en fonction du declencheur et de la page choisi
		
		if(!isset($_SESSION['GESTION_SESSIONS']))
		{
			$_SESSION['GESTION_SESSIONS'] = array();
		}
		
		$_SESSION['GESTION_SESSIONS'][$name][$page][$declenche] = $action;
		// $_SESSION['GESTION_SESSIONS']		
	}
}

// Class commumn de cache ( APC Extension )
class sbox_cache extends sbox
{
	public static function get($key)
	{
		if($_SESSION['conf_sbox']['apc'])
		{
			return apc_fetch($key);
		}
		elseif($_SESSION['conf_sbox']['xcache'])
		{
			return xcache_get($key);
		}
		else
		{
			return false;
		}
	}
	
	public static function add($key,$var,$ttl=0)
	{
		if($_SESSION['conf_sbox']['apc'])
		{
			return apc_add($key,$var,$ttl);
		}
		elseif($_SESSION['conf_sbox']['xcache'])
		{
			return xcache_set($key,$var,$ttl);
		}
		else
		{
			return false;
		}
	}
	
	public static function del($key)
	{
		if($_SESSION['conf_sbox']['apc'])
		{
			return apc_delete($key);
		}
		elseif($_SESSION['conf_sbox']['xcache'])
		{
			return xcache_unset($key);
		}
		else
		{
			return false;
		}
	}
}

$sbox = new sbox();

if($_SESSION['visits'] == 1)
{
    sbox_debug::add('SESSION','Nouvelle SESSION !<br>AGENT:'.$_SERVER['HTTP_USER_AGENT'].'<br>SID:'.session_id()."<br><br>");
}
else
{
    sbox_debug::add('SESSION','SESSION EXISTANTE ! ( site vu '.$_SESSION['visits'].' fois )<br>AGENT:'.$_SERVER['HTTP_USER_AGENT'].'<br>SID:'.session_id()."<br><br>");
}

?>