<?php
//********************************************************************************************
//********************************************************************************************
// SETUP
// Gère la selection du jeux et maps
//
//********************************************************************************************
// Ce fichier est une partie du projet ProGameMap
// http://progamemap.com
//
// -------------------------------------------------------------------------------------------
// Version 1.0
// Creation Date : 1/06/2009
// Modification Date :
// -------------------------------------------------------------------------------------------
// Historique
//
// 1.0 - Paco112 : Creation
//
//********************************************************************************************
//********************************************************************************************  

// Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (stristr("home.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}

// Choix du type de la page (ici type par default)
$tpl->ConstructPage(2);

// Définition du fil d'arrianne
$Arianne = array(1 => array('titre' => ucfirst(HOME),
                                'lien'  => 'index.php'),
                 2 => array('titre' => ucfirst(SETUP),
                                'lien'  => 'index.php'));

// on recupère les jeux et on les stocks en session si il n'y sont pas deja
if(count($_SESSION['listing_games']) == '0')
{
    $_SESSION['listing_games'] = $sbox->select_multi(array('table'=>'games','select'=>'*','where'=>'`actif`=/1/','order by'=>'name_plus ASC','high_priority'=>'1'));
}

// Tlink pour images
$lien = Tlink($param);

// si le jeux voulue est definie dans l'url et et différent de la session on force l'url
if($param[3] != "" )
{
    if($param[3] != strtolower($_SESSION['listing_maps'][0]['name']))
    {
        // on l'efface entièrement et on attribue le niuveau nom du jeux
        $_SESSION['listing_maps'] = array();
        $_SESSION['listing_maps'][0]['name'] = strtoupper($param[3]);
    }
}

// on affiche tous les jeux en assigant au template setup
foreach($_SESSION['listing_games'] as $game)
{
    // affiche les loaders si listing_map existe et correspond au jeux en cours
    if($_SESSION['listing_maps'][0]['name'] == $game['name'])
    {
        $display = 'block';
    }
    else
    {
        $display = 'none';
    }

    $liste_games .= "<div id=\"d_".$game['name']."\" name=\"d_".$game['name']."\" style=\"width:250px;\">"
                    . "<table width=\"250\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
                    . "<tr nowrap valign=\"middle\">"
                    . "<td width=\"20\" height=\"20\"><img name=\"\" src=\"".$lien."public/images/games/".$game['name']."/icon_".$game['image']."\" width=\"20\" height=\"20\" alt=\"".$game['name_plus']."\" /></td>"
                    . "<td width=\"5\">&nbsp;</td>"
                    . "<td width=\"209\" height=\"25\"><a id=\"".$game['name']."\" name=\"".$game['name']."\" class=\"g_\" href=\"../../".$param[1]."/".$param[2]."/".strtolower($game['name'])."\" style=\"text-decoration: none;\">".$game['name_plus']." (".$game['nb_maps'].")</a></td>"
                    . "<td width=\"16\"><div class=\"load_mini\" id=\"load_".$game['name']."\" name=\"load_".$game['name']."\" style=\"display:".$display.";\"><img src=\"".$lien."public/images/ajax-loader-mini.gif\" width=\"16\" height=\"16\" /></div></td>"
                    . "</tr>"
                    . "</table>"
                    . "</div>";
    
}

//on liste les maps si listing maps dispo ou demandé
if((count($_SESSION['listing_maps'])-1) <= 0)
{
    // si demandé via url
    
    // MEME CHOSE QUE setup_maps.php en gros
    
    // on liste toute les maps
    $maps = $sbox->select_multi(array('table'=>'`maps_'.$_SESSION['listing_maps'][0]['name'].'`','select'=>'id,name,mode,images,stats_dl'));
    
    $i=1;
    foreach($maps as $map)
    {        
        // on prend la première images seulement
        $images = array();
        $images = explode(';',$map['images'],2);
        
        $_SESSION['listing_maps'][$i]['id'] = $map['id'];
        $_SESSION['listing_maps'][$i]['name'] = $map['name'];
        $_SESSION['listing_maps'][$i]['mode'] = $map['mode'];
        $_SESSION['listing_maps'][$i]['image'] = $images[0];
        $_SESSION['listing_maps'][$i]['stats_dl'] = $map['stats_dl'];
        $i++;
    }   
}

if((count($_SESSION['listing_maps'])-1) > 0)
{
    // si listing_maps dispo
    $map = array();
    $i=0;
    $liste_maps = '';
    foreach($_SESSION['listing_maps'] as $map)
    {
        // on saute la première clé qui est le nom du jeux
        if($i>0)
        {
            $liste_maps .= "<div id=\"m_\" name=\"m_\" style=\"float:left;\">"
                        . "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">"
                        . "<tr>"
                        . "<td colspan=\"2\">".$map['image']."</td>"
                        . "</tr>"
                        . "<tr>"
                        . "<td>".$map['name']."</td>"
                        . "<td>".$map['stats_dl']."</td>"
                        . "</tr>"
                        . "<tr>"
                        . "<td>etoile1</td>"
                        . "<td>etoile2</td>"
                        . "</tr>"
                        . "</table>"
                        . "</div>";        
        }
        $i++;
    }
}
else
{
    // on remplie le listing maps
    
}

// serial de securisation de la connection ajax
$serial_ajax = sbox_function::secu_ajax();

$Array = array(
                'ListeGames'    => $liste_games,
                'ListeMaps'     => $liste_maps,
                'PUB'           => Pub(160,600),
                'SerialAjax'    => $serial_ajax
            );
            
$Content = $tpl -> InjectTpl('setup', $Array);
                                
// Assigne le script js
$tpl->assign(array('Scripts' => '<script type="text/javascript" src="'.$lien.'public/js/setup.js"></script>'));
                                
// Assignement des valeur au template
$tpl->assign(array(
    'Content'       => $Content,
    'FilArianne'    => DisplayArianne($Arianne),
    'Titre'         => ucfirst(SETUP))
);                                

// on efface la variable listing maps
//$_SESSION['listing_maps'] = array();
?>
