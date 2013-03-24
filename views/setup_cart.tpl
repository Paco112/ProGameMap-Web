<div style="width:970px;">
<table border="0" cellspacing="0" cellpadding="0" width="970">
  <tr style="vertical-align:top;">
    <td>
        <div name="left_setup" id="left_setup" style="margin-top:5px; margin-left:10px;">
            <table name="left_setup_table" id="left_setup_table" border="0" cellspacing="0" cellpadding="0" width="180">
              <tr height="3">
              	<td></td>
              </tr><tr>
                <td>
                	<table class="boxMenu">
                    	<tr>
                        	<td class="topMenu" colspan="3"><strong>{$#SAVE}</strong></td>
                        </tr><tr>
                        	<td width="1"></td>
                            <td valign="top" style="background:#FFF;">
                            	<div id="s_games" name="s_games">
                                    {$ListeGames}
                                </div>
                                <div id="s_packs" name="s_packs" style="width:100%; padding:10px 5px 10px 0px;">
                                    <form method="post">
                                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                                          <tr>
                                              <td>Nom du Pack : <br /><input id="packs_name" name="packs_name" type="text" /> </td>
                                          </tr>
                                          <tr>
                                              <td align="center" valign="bottom"><div align="center" style="padding-top:10px"><input id="packs_type" name="packs_type" type="checkbox" value="1" checked="checked" /> Public</div></td>
                                          </tr>
                                          <tr>
                                              <td align="center"><div align="center" style="padding-top:10px"><input id="packs_sauve" name="packs_sauve" type="submit" value="{$#SAVE}" /></div></td>
                                          </tr>
                                        </table>                            	
                                  </form>
                              </div>
                            </td>
                            <td width="1"></td>
                        </tr><tr>
                        	<td class="Footer" colspan="3"></td>
                        </tr>
                    </table>
                 </td>
              </tr><tr height="10">
              	<td></td>
              </tr><tr height="10">
              	<td></td>
              </tr><tr height="30">  
                <td></td>
              </tr><tr>
                <!--<td valign="top" align="center">
                    <div class="load_pub" style="height:600px; display:block;">
                        <img src="{$Tlink}public/images/pub-loader.gif" width="56" height="21">
                    </div>
                    <div class="pub" style="height:600px; display:none; padding:20px;">
                        {$PUB2}
                    </div>
                 </td>-->
                 <td style="padding-left:5px;"><img src="http://www.progamemap.com/public/images/160x600.gif" alt="" /></td>
              </tr>
            </table>
        </div>
    </td>
    <td>
        <div name="right_setup" id="right_setup" style="width:100%">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr valign="top">
                    <td height="30" colspan="5" width="100%" style="background:url(http://www.progamemap.com/public/images/setupBorderLeft.png) no-repeat top left;">
                      <div class="menu_onglet" style="display:block;"> <!-- début de la boite contenant les onglets -->
                          <div style="float:left">{$MenuOnglet}</div>
                          <div style="position:relative; display:block; margin:-32px 0 0 510px; float:right;"><ul id="pagination">{$Paging}</ul></div>
                          <div class="spacer"></div>                          
                      </div>
                      <div id="s_maps" name="s_maps" style="width:100%;">
                          <div id="l_maps" name="l_maps" style="width:100%; display:block; padding:5px;">
                          	{$ListeMaps}
                          </div>
                      </div>        
                    </td>
                    </tr>
                    <tr>
                    	<td>
                            <div style="width:100%; position:relative; display:block;"><br />
                                <table border="0" cellspacing="0" cellpadding="0" align="center">
                                  <tr>
                                    <td><ul id="pagination">{$Paging2}</ul></td>
                                  </tr>
                                </table><br />
                            </div>
                        </td>
                    </tr>
            </table>
        </div>
    </td>
  </tr>
</table>
</div>