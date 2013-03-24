<?php
/*
require_once($_SERVER['DOCUMENT_ROOT']."include/class/sbox.php");
$_SESSION['conf_sbox']['timer']     = false;
$_SESSION['conf_sbox']['debug']     = false;
$_SESSION['conf_sbox']['debug_max'] = false;

$serial = $_POST['sa'];
$game = $_POST['game'];

if($serial == md5($_SESSION['sbox_function']['secu_ajax'][1].$_SESSION['sbox_function']['secu_ajax'][2]))
{
    //echo "\n\nSERIAL VALIDE ! ".$game;
   
    //variable de stokage
    $_SESSION['listing_maps'] = array();   
   
    // on liste toute les maps
    $maps = $sbox->select_multi(array('table'=>'`maps_'.$game.'`','select'=>'id,name,type,mode,images,stats_dl,note'));
    
    // on reserve la première case du listing maps pour le nom du jeux
    $_SESSION['listing_maps'][0]['name'] = $game;
    
    $i=1;
    foreach($maps as $map)
    {
        //echo "\n\n".$map['name']." - ".$map['images']."\n\n";
        
        // on prend la première images seulement
        $images = array();
        $images = explode(';',$map['images'],2);
        
        $_SESSION['listing_maps'][$i]['id'] = $map['id'];
        $_SESSION['listing_maps'][$i]['name'] = $map['name'];
        $_SESSION['listing_maps'][$i]['type'] = $map['type'];
        $_SESSION['listing_maps'][$i]['mode'] = $map['mode'];
        $_SESSION['listing_maps'][$i]['image'] = $images[0];
        $_SESSION['listing_maps'][$i]['stats_dl'] = $map['stats_dl'];
        $_SESSION['listing_maps'][$i]['note'] = $map['note'];
        //print_r($_SESSION['listing_maps']);
        $i++;
    }
}
else
{
    echo "ERREUR SERIAL ! ".$game;
}
*/
?>
