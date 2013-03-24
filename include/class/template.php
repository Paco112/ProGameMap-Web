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


class Template
{
	/***************************************************************************/
	/*                            Fonctionnement                               */
	/***************************************************************************/
	/**
	* Le layout principale (trame du site) est appelé automatiquement lors de 
	* l'init de la class. Il est possible de modifier le dossier de ce Layout 
	* grâce a la variable $layoutDir. Les extensions des templates, par défault 
	* 'tpl', sont modifiable grâce à la variable $ext.
	*
	*/

	/***************************************************************************/
	/*                               Propriétés                                */
	/***************************************************************************/
	
	/**
	* code template
	*
	* @var unknown_type
	*/
	var $tpl;
		
	/**
	* error
	*
	* @var bolean
	*/
	var $error;
	
	
	/***************************************************************************/
	/*                              Configuration                              */
	/***************************************************************************/
	
	var $templateDir 	= './views/';
	var $ext			= '.tpl';
	
	
	/***************************************************************************/
	/*                                 Méthodes                                */
	/***************************************************************************/
	
	
	/**
	* Construc
	*
	* @return void
	*/
	function Template()
	{
		$this->tpl = '';
		$this->error = array();
        $this->scripts = '';
	}
	
	
	/**
	* Récupère le template a utiliser
	*
	* @param unknown_type $file
	* @return void
	*/
	function GetTpl($file)
	{
		$this->tplName = $file.$this->ext;
		
		// on verifie si deja en cache ou non
		if( (sbox_cache::get($this->templateDir.$file.$this->ext) == false)  )
		{		
			
			if (!$temp = file_get_contents($this->templateDir.$file.$this->ext))
			{
				$info = 'Erreur lors de l\'ouverture du template : '.$file.$this->ext;
				sbox_debug::add('Template',$info);
			}
			else
			{
				// reduit le code html sur 1 ligne
				if($_SESSION['conf_template']['mini'])
				{
					$temp = preg_replace('/(\n|\t|\r)+/','',$temp);
					$temp = preg_replace('/>(\s+)/','>',$temp);
				}
				
				$this->tpl .= $temp;
				sbox_cache::add($this->templateDir.$file.$this->ext,$temp,3600);
				$info = 'Template chargé avec succès : '.$file.$this->ext;
		  		sbox_debug::add('Template',$info);
			}
		}
		else
		{
			if (!$this->tpl .= sbox_cache::get($this->templateDir.$file.$this->ext))
			{
				$info = 'Erreur lors de l\'ouverture du template : '.$file.$this->ext;
				sbox_debug::add('Template (APC CACHE)',$info);
			}
			else
			{
				$info = 'Template chargé avec succès : '.$file.$this->ext;
		  		sbox_debug::add('Template (APC CACHE)',$info);
			}
		}
	}
	
	/**
	* Injecte le template a utiliser
	*
	* @param unknown_type $file
	* @return void
	*/
	function InjectTpl($file, $tag_array = '')
	{
		$this->TplName = $file.$this->ext;
		
		if (!$template .= file_get_contents($this->templateDir.$file.$this->ext)){
		  	$info = 'Erreur lors de l\'ouverture du template : '.$file.$this->ext;
		  	sbox_debug::add('Template', $info, 'Vérifier le chemin d\'accès au template');
		} else {
			$info = 'Template chargé avec succès : '.$file.$this->ext;
		  	sbox_debug::add('Template',$info);
		}
		
		if ($tag_array != ''){
			foreach( $tag_array as $key => $value ){
				$template = str_replace('{$'.$key.'}',str_replace('$','$',$value),$template);
			}
		}
		
		return $template;
	}
	
	
	/**
	* Remplace les variables du templates
	*
	* @param array $tag_array
	* @return void
	*/
	function assign($tag_array)
	{
		foreach( $tag_array as $key => $value ){
            $this->tpl = str_replace('{$'.$key.'}',str_replace('$','$',$value),$this->tpl);
		}
	}
	
	
	/**
	* Supprime les balises inutilisé du template
	*
	* @return void
	*/
	function clearTag()
	{
		$tag = '[a-zA-Z0-9_]{1,}';
		$id  = '[a-zA-Z0-9_]{1,}';
		
		//remplace les balises LANGUE
		if(preg_match_all('/\{\$#'.$tag.'\}/i',$this->tpl,$temp_lang))
		{
			foreach($temp_lang[0] as $key2 => $value2)
			{
				$new_value2 ="";
				$new_value2 = preg_replace('/\{\$#|\}/','',$value2);
				$this->tpl = str_replace($value2,ucfirst(constant($new_value2)),$this->tpl);
			}
		}
		
		// Supprime les balises simples
		$this->tpl = preg_replace('/\{\$'.$tag.'\}/i','',$this->tpl);
		// Supprime les balises dynamiques
		$this->tpl = preg_replace('/(\{'.$tag.' id=)('.$id.')(})(.*?)(\{\/'.$tag.'})/ism','',$this->tpl);
		$this->tpl = preg_replace('/(\{'.$tag.' id=)('.$id.')(})/ism','',$this->tpl);
		$this->tpl = preg_replace('/(\{'.$tag.' id=)('.$id.') (file=(.*?)})/ism','',$this->tpl);
		
		// reduit le code html sur 1 ligne
		if($_SESSION['conf_template']['mini'])
		{
			$this->tpl = preg_replace('/(\n|\t|\r)+/','',$this->tpl);
			$this->tpl = preg_replace('/>(\s+)/','>',$this->tpl);
		}
    }
	
	
	/**
	* Construit le début d'une page en assemblant différents templates
	*
	* @param unknown_type $type
	* @param unknown_type $color
	* @return void
	*/
	function ConstructPage($type = 1, $color = 1)
	{
		switch ($type){
			
			default :
				$this->GetTpl('head');
				$this->GetTpl('logo');
				$this->GetTpl('content_begin');
				break;
			
			case 2 :
				$this->GetTpl('head');
				$this->GetTpl('logo');
				$this->GetTpl('content_large_begin');
				break;
				
			case 3 :
				$this->GetTpl('head');
				$this->GetTpl('logo');
				$this->GetTpl('content_large_begin');
				$this->GetTpl('admin/menu');
				break;
		}
		
		/**switch ($color){	
			default :
				$this->assign(array('CSS' => '<link rel="stylesheet" type="text/css" href="{$Tlink}public/css/stylev2.css" />
{$CSS}'));
			break;
			
			case 'bleu' :
				$this->assign(array('CSS' => '<link rel="stylesheet" type="text/css" href="{$Tlink}public/css/stylev1.css" />
{$CSS}'));
			break;
		}**/
	}
	
	/**
	* Construit la fin d'une page en assemblant différents templates
	*
	* @param unknown_type $type
	* @return void
	*/
	function ConstructEndPage($type = 1)
	{
		switch ($type){
			
			default :
				$this->GetTpl('content_end');
				$this->GetTpl('menu_right');
				$this->GetTpl('footer');					
				
				break;
			
			case 2 :
				$this->GetTpl('content_large_end');
				$this->GetTpl('footer_large');
				
				$dName = $_SESSION['user']['dname'];
				$dName = ($dName == "") ? "Guest" : $dName;
				
				break;
			
			case 3 :
				$this->GetTpl('admin/content_large_end');
				$this->GetTpl('footer');
				break;
		}
	}
	
	/**
	* Rendu final
	*
	* @return le template avec les modifications
	*/
	function view()
	{
		// Décalage du body si le debugger est affiché
		/*
		if($_SESSION['conf_sbox']['timer'] == true){
			$this->assign(array('Body' => 'style="margin-top:20px;"',
								'Scripts' => "<script type='text/javascript' src='http://www.progamemap.com/public/js/mysql_debug.js'></script>\n{$Scripts}"));
		}
		*/
		
		if($_SESSION['conf_javascript']['mini'] == true){
			$this->tpl = preg_replace("/\/([a-z]+)\.js/i",'/${1}-min.js',$this->tpl);
		}
		
		if($_SESSION['conf_css']['mini'] == true){
			$this->tpl = preg_replace("/\/([a-z]+)\.css/i",'/${1}-min.css',$this->tpl);
		}
		
		// On supprime les tag inutilisés
		$this->clearTag();
		
		// met tous le code html sur 1 ligne
		//$this->tpl = preg_replace('/(\n|\t|\r)*/','',$this->tpl);
		//$this->tpl = preg_replace('/>(\s*)/','>',$this->tpl);
		//$this->tpl = preg_replace('/(\s\s\s)/','',$this->tpl);
		//$this->tpl = preg_replace('/(\s\s)/',' ',$this->tpl);
		
		echo $this->tpl;
	}
	
	function __destruct()
	{
		$this->tpl = '';
		$this->error = array();
		$this->templateDir = '';
		$this->ext = '';
	}
}

?>