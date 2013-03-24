<?php
  // Tlink
  // Transforme les liens des css, images, et autre suivant les params de getURL();
  
function Tlink($p)
{
  $nb_param = count($p);
  
  if($nb_param != 0)
  {
      for($i=1;$nb_param >= $i;$i++)
      {
          $link .= "../"; 
      }    
  }
  else
  {
        $link = "./";
  }
  
  return $link;
}
?>
