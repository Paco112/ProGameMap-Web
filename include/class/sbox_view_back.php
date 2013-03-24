<?php
            //sbox_debug::add("text",sbox_debug::Linecall());
            
			$t_total = sbox_timer::getTime('0');
			
            if(isset($_SESSION['sbox_timer']['MYSQL']))
            {
                $t_mysql = 0;
                foreach($_SESSION['sbox_timer']['MYSQL'] as $key)
                {
                    $t_mysql = $t_mysql + $key['time'];
                }
            }
            
            if(isset($_SESSION['sbox_timer']['PHP']))
            {
                $t_php = 0;
                foreach($_SESSION['sbox_timer']['PHP'] as $key)
                {
                    $t_php = $t_php + $key['time'];               
                }
                $t_php = ($t_php-$t_total);    
            }
            
            if(isset($_SESSION['sbox_timer']['FUNCTION']))
            {
                $t_function = 0;
                foreach($_SESSION['sbox_timer']['FUNCTION'] as $key)
                {   
                    $t_function = $t_function + $key['time'];
                }
                
                $t_debug = ($t_function - ($t_mysql+$t_php));
            }
if(!$_SESSION['sbox_debug']['ajax'])
{
?>
<style>
                       /* MYSQL DEBUGER */
                        
/* BUTTON                                                    */
.button{
    background-color:#000;
    color:#FFF;
    clear:both;
    display:block;
    font-size:13px;
    font-weight:bold;
    height:20px;
    line-height:20px;
    width:99.9%;
}
    a.button {
        text-decoration:none;
    }
    .button span {
        color:#FFF;
        display:block;
        height:20px;
        line-height:20px;
        padding-left:10px;
        padding-right:8px;
    }
/* -------------------------------------------------------- */
/* MENU                                                        */
.v-menu{
    border:solid 1px #7F9FBF;
    width:100%;
    clear:both;
    background-color:#000;
}
    ul.v-menu, .v-menu li{
        padding:0; 
        margin:0;
        list-style:none;
        background:#272727;
        color:#FFF;
        font-family: sans-serif;
        font-size: 13px;
    }
    ul.v-menu{
        clear:both;
        margin-top:6px;
    }
        .v-menu li a{
            color:#555555;
            font-weight:bold;
            display:block;
            border-top:solid 1px #DEDEDE;
            padding:4px;
            text-decoration:none;
        }
        .v-menu li a:hover{
            color:#999999;
        }
</style>
<a href="#" id="cache_sbox" name="cache_sbox" style="position:absolute; top:14px; color:#FFF; left:15px;">VOIR</a>
<div id="debug_bar" name="debug_bar" class="null" style="position:absolute; width:99.9%; top:-2px; z-index:9999; display:none;">
    <a href="#" class="button" id="toggle">
    	<span>
            <table width="100%" border="0" cellspacing="0" style="color:#FFF;">
              <tr>
                <td nowrap="nowrap" style="text-align:left;"><strong style="color:#FFF;">SECU</strong><strong style="color:#F00">BOX</strong></td>
                <td nowrap="nowrap" style="color:#F00; font-size:14px; font-weight:bold;"><? if($_SESSION['sbox_temp']['STOP'] == 1){ echo "ERREUR CRITIQUE"; } else if($_SESSION['sbox_temp']['ERREUR'] != NULL) { echo $_SESSION['sbox_temp']['ERREUR']." ERREURE(S)";} ?></td>
                <td nowrap="nowrap">MySQL : <? echo $t_mysql; ?>s</td>
                <td nowrap="nowrap">Traitement PHP : <? echo $t_php; ?>s</td>
                <td nowrap="nowrap">MySQL+PHP : <? echo ($t_php+$t_mysql); ?>s</td>
                <td nowrap="nowrap">Debug : <? echo $t_debug; ?>s</td>
                <td nowrap="nowrap">T-Debug : <? echo ($t_total-$t_debug); ?>s</td>
                <td nowrap="nowrap">Total : <? echo $t_total; ?>s</td>
                <td nowrap="nowrap">Memoire Utilise : <? echo round((memory_get_usage()/1024),2); ?> Ko</td>
                <td nowrap="nowrap">Memoire Alloue : <? echo round((memory_get_usage(true)/1024),2); ?> Ko</td>
              </tr>
            </table>
        </span>
    </a>
    <ul id="v-menu" class="v-menu" style="text-align:left; color:#FFF;">
         <?php
            if($_SESSION['sbox_debug'])
			{
				echo "<table width=\"100%\" cellspacing=\"0\">";
				foreach($_SESSION['sbox_debug']['list'] as $key => $value)
				{
					  foreach($value as $key2 => $value2)
					  {
						  switch($key2)
						  {
							  default:
									$color = "style=\"color:#FFF\"";
									break;
							  case "PARAMETRE INCORRECT":
									$color = "style=\"background-color:#F00;color:#FFF;\"";
									break;
							  case "PARAMETRE POSSIBLE":
									$color = "style=\"background-color:#FF9999;color:#FFF;\"";
									break;
							  case "ERREUR":
									$color = "style=\"background-color:#F00;color:#FFF;\"";
									break;
							  case "RETOUR MYSQL":
									$color = "style=\"background-color:#FF9999;color:#FFF;\"";
									break;
							  case "Reponse MySQL":
									$color = "style=\"background-color:#00C;color:#FFF;\"";
									break;
							  case "Action MySQL":
									$color = "style=\"background-color:#009900;color:#FFF;\"";
									break;	
						  }
						  
						  echo "<tr valign=\"top\" ".$color.">"
								. "<td nowrap=\"nowrap\" style=\"padding-right:10px; padding-left:5px;\">".$key2."</td>"
								. "<td>".$value2."</td>"
						  . "</tr>";
					  }
				}
				
            	echo "</table>";
			}
         ?>
    </ul>
</div>
<?php
}
else
{
	if($_SESSION['sbox_temp']['STOP'] == 1)
	{
		echo "ERREUR CRITIQUE\n"; 
	} 
	else if($_SESSION['sbox_temp']['ERREUR'] != NULL) 
	{ 
		echo $_SESSION['sbox_temp']['ERREUR']." ERREURE(S)\n";
	}
 
	if($_SESSION['sbox_debug'])
	{
		foreach($_SESSION['sbox_debug']['list'] as $key => $value)
		{
			  foreach($value as $key2 => $value2)
			  {
				  echo $key2." => '".$value2."'\n\n";
			  }
		}
	}
}
?>                  
