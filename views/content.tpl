<!--Body Start-->
<table width="985" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
    	<td valign="top" bgcolor="#e4e4e4">
        	<table width="725" border="0" cellspacing="0" cellpadding="0">
        		<tr> 
          			<td bgcolor="#dddddd">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="5">
              				<tr> 
                				<td width="1">&nbsp;</td>
                				{$FilArianne}                
                                <td width="90%" nowrap>&nbsp;</td>
							</tr>
            			</table>
					</td>
				</tr>
        		<tr> 
          			<td height="32" align="right" bgcolor="#ebebeb">
		  				<form name="recherche" method="get" action="" style="display:inline">
              				<table width="100%" border="0" cellspacing="0" cellpadding="3">
                				<tr> 
                                    <td width="63"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Affichage:</strong></td>
                                    <td width="28"><a href="javascript:changer_aff('videos','1','/videos.php');"><img src="{$Tlink}public/images/tube_05.jpg" alt="" width="25" height="24" border="0"></a></td>
                                    <td width="28"><a href="javascript:changer_aff('videos','2','/videos.php');"><img src="{$Tlink}public/images/tube_03.jpg" alt="" width="25" height="24" border="0"></a></td>
                                    <td width="193"><a href="javascript:changer_aff('videos','3','/videos.php');"><img src="{$Tlink}public/images/tube_07.jpg" alt="" width="25" height="24" border="0"></a></td>
                                    <td width="15"><img src="{$Tlink}public/images/videos_29.jpg" width="15" height="15" alt=""></td>
                                    <td width="67"><strong>Rechercher</strong></td>
                                    <td width="250"><input name="q" type="text" value="" size="50" class="q"></td>
                                    <td width="33"><input name="image2" type="image" src="{$Tlink}public/images/videos_31.jpg" width="26" height="19" alt="Rechercher parmis nos vidéos, dvd, studios et actrices"></td>
                				</tr>
              				</table>
            			</form>
					</td>
				</tr>
        		<tr>
          			<td height="36" background="{$Tlink}public/images/videos_38.jpg" bgcolor="#d2d2d2">
                    	<table width="725" border="0" cellspacing="0" cellpadding="0">
              				<tr>
                				<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
      		<table width="725" border="0" cellspacing="0" cellpadding="8">
        		<tr> 
          			<td align="center" bgcolor="#e4e4e4">
                    	<div>
<!--Content Start-->                        
                            {$Content}
<!--Content End-->                            
                        </div>
                    	<br><br><br><br><br><br>
					</td>
				</tr>
			</table>
      	</td>
