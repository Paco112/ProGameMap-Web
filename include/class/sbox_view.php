<?php
session_start();
            
if($_GET['view'] == '1')
{
	if($_SESSION['sbox_temp']['STOP'] == 1)
	{ 
		echo "ERREUR CRITIQUE";
	}
	else if($_SESSION['sbox_temp']['ERREUR'] != NULL) 
	{ 
		if($_SESSION['sbox_temp']['ERREUR'] == '1')
		{
			echo $_SESSION['sbox_temp']['ERREUR']." ERREURE";
		}
		else
		{
			echo $_SESSION['sbox_temp']['ERREUR']." ERREURE(S)";
		}
	} 
}
elseif($_GET['view'] == '2')
{	
	if($_SESSION['sbox_debug'])
	{	
		$t_total = $_SESSION['sbox_timer']['TOTAL'];
		
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
		?>
            <div style="padding:5px 5px 5px 5px;">
            <table width="100%" border="0" cellspacing="0" style="color:#FFF;">
              <tr>
                <td nowrap="nowrap">MySQL : <? echo $t_mysql; ?>s</td>
                <td nowrap="nowrap">Traitement PHP : <? echo $t_php; ?>s</td>
                <td nowrap="nowrap">MySQL+PHP : <? echo ($t_php+$t_mysql); ?>s</td>
                <td nowrap="nowrap">Debug : <? echo $t_debug; ?>s</td>
                <td nowrap="nowrap">T-Debug : <? echo ($t_total-$t_debug); ?>s</td>
                <td nowrap="nowrap">Total : <? echo $t_total; ?>s</td>
                <td nowrap="nowrap">Memoire Utilise : <? echo $_SESSION['sbox_temp']['php_mem_utiliser']; ?> Ko</td>
                <td nowrap="nowrap">Memoire Alloue : <? echo $_SESSION['sbox_temp']['php_mem_allouer']; ?> Ko</td>
              </tr>
            </table><br />
            </div>
        <?php
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
}
?>
