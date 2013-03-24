<?php
  // fonction de gestion des lien paramétré
  

// a utilisé avec $param pour $p  
function Plink($p,$id_r=0,$f=0,$name=0)
{
    $string = '';
    
    // on créer le param demandé si il existe pas sinon on le remplace
    if($name != "")
    {
        $p[$id_r] = $name;
    }
    
    foreach($p as $key => $value)
    {        
        
		$string .= $value."/";    
        
        // on arrete si fin demandé
        if($f==1 && $key==$id_r && $id_r != "")
        {
            break;
        }                
    }
    return $string;
}

// a utilisé avec $param_name pour $p
function Plink_name($p_name,$name,$val,$f=0)
{
    $string = '';
    $i=1;
    $saut = 0;
    
    if($val != '-1')
    {
        if($p_name[$name] == "")
        {
            $p_name[$name] = "N";
        }
        
        if($p_name[$val] == "")
        {
            $p_name[$val] = "N";
        }
    }
    
    // on boucle et lorsque l'on tombe sur $id_r on ajoute $name derrière    
    foreach($p_name as $key => $value)
    {        
        if(($saut == 0) && ($key != $val))
        {
            if( ($key == $name && $val == '-1') || ($key == "page" && $name != "page") || ($key == "page" && $name == "page" && $val == "1") )
            {
                // ce cas permet de supprimer $name et sa valeur du lien ou de supprimer le paramètre page si il n'est pas explicitemetndemandé dans $name ou si il demande la page 1
                if($_SESSION['LANGUE'] != $key)
				{
					$saut = 1;    
				}
            }
            else
            {
                $string .= $key."/";    
                
                if($key == $name)
                {
                    $string .= $val."/";
                    // permettra de sauter le prochain bouclage car on vien de renplacer cette valeur plus ci-dessu
                    $saut = 1;           
                }
                
                // on arrete si fin demandé
                if($f==1 && $key==$name)
                {
                    break;
                }
            }
        }
        else
        {
            $saut = 0;    
        }        
        $i++;        
    }
    return $string;
}
?>
