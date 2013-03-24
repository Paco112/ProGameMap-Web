<?
 // Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (stristr("right.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}
?>  
<!-- MENU DROITE START -->
                    <td width="260" valign="top" bgcolor="#b9b9b9"> 
                          <table width="260" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                                  <td height="22" align="center" background="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_18.jpg"><strong>Vous &ecirc;tes membre - Connectez vous !</strong></td>
                            </tr>
                            <tr> 
                                  <td height="96" background="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_27.jpg">
                                    <form action="" method="post" name="login" id="login" style="display:inline">
                                          <table width="233" border="0" align="center" cellpadding="3" cellspacing="0">
                                            <tr> 
                                                <td width="78" align="left" class="grisc">Mail:</td>
                                                <td width="92"><input name="mail" type="text" class="champ" id="mail" size="23"></td>
                                                <td width="45"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_36.jpg" width="11" height="17" alt=""></td>
                                            </tr>
                                            <tr> 
                                                <td align="left" nowrap class="grisc">Password:</td>
                                                <td><input name="password" type="password" class="champ" id="password" size="23"></td>
                                                <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_36.jpg" width="11" height="17" alt=""></td>
                                            </tr>
                                            <tr> 
                                                <td colspan="2">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="92%"><a href="#_" class="lienmenu" OnClick="affiche_overlay_window('','508','423');">Devenir membre gratuitement</a></td>
                                                            <td width="8%"><input name="image2" type="image" src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_50.jpg" width="26" height="19" alt="Se connecter"></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>
                                    </form>
                                </td>
                            </tr>
                            <tr> 
                                <td height="44" background="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_55.jpg">
                                    <table width="240" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr> 
                                            <td width="14"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_63.jpg" width="10" height="10" alt=""></td>
                                            <td width="102"><a href="#_" class="lienmenu" OnClick="affiche_overlay_window('','508','423');">Devenir membre</a></td>
                                            <td width="13"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_63.jpg" width="10" height="10" alt=""></td>
                                            <td width="103"><a href="" class="lienmenu">Password perdu</a></td>
                                        </tr>
                                        <tr> 
                                            <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_63.jpg" width="10" height="10" alt=""></td>
                                            <td nowrap><a href="" class="lienmenu">Se connecter</a></td>
                                            <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_63.jpg" width="10" height="10" alt=""></td>
                                            <td><a href="" class="lienmenu">Nous contacter</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                          </table>
                          <table width="260" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                                <td height="44" background="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_68.jpg">
                                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="260" height="45">
                                        <param name="movie" value="public/images/bloc_menud_video.swf">
                                        <param name="quality" value="high">
                                        <embed src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/bloc_menud_video.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="260" height="45"></embed>
                                    </object>
                                </td>
                            </tr>
                            <tr> 
                                 <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_69.jpg" width="260" height="31" alt=""></td>
                            </tr>
                            <tr> 
                                <td bgcolor="#96020f">
                                    <br>
                                    <table width="239" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr> 
                                            <td>
                                                <table width="239" border="0" cellspacing="0" cellpadding="0">
                                                    <tr> 
                                                        <td width="18"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_72.jpg" width="13" height="13" alt=""></td>
                                                        <td width="221" class="menutitre">Les vid&eacute;os par pays:</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_76.jpg" width="239" height="9" alt=""></td>
                                        </tr>
                                        <tr> 
                                            <td bgcolor="#540005">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                                    <tr> 
                                                        <td>
                                                            <table width="224" border="0" align="center" cellpadding="3" cellspacing="0">
                                                                <tr> 
                                                                    <td width="14"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/video_80.jpg" width="18" height="12" alt=""></td>
                                                                    <td width="102"><a href="#">COD 4</a></td>
                                                                    <td width="13"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/video_82.jpg" width="18" height="12" alt=""></td>
                                                                    <td width="103"><a href="#">COD 5</a></td>
                                                                </tr>
                                                                <tr> 
                                                                    <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/video_86.jpg" width="18" height="12" alt=""></td>
                                                                    <td nowrap><a href="#">MOHAA</a></td>
                                                                    <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/spacer.gif" width="18" height="12" alt=""></td>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_90.jpg" width="239" height="10" alt=""></td>
                                        </tr>
                                    </table>
                                    <table width="239" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr> 
                                            <td>
                                                <table width="239" border="0" cellspacing="0" cellpadding="0">
                                                    <tr> 
                                                        <td width="18"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_72.jpg" width="13" height="13" alt=""></td>
                                                        <td width="221" class="menutitre">Les vid&eacute;os par cat&eacute;gories:</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_76.jpg" width="239" height="9" alt=""></td>
                                        </tr>
                                        <tr> 
                                            <td bgcolor="#540005">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="10">
                                                    <tr valign="top">
                                                        <td width="55%"><a href="#">COD 5</a><br><a href="#">COD 4</a><br></td>
                                                        <td width="45%"><a href="#">MOHAA</a><br></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_90.jpg" width="239" height="10" alt=""></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                          </table>
                        <table width="260" border="0" cellpadding="0" cellspacing="0" bgcolor="#b9b9b9">
                            <tr>
                                <td align="center"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_102.gif" width="260" height="55" alt=""></td>
                            </tr>
                            <tr> 
                                  <td align="center">
                                    <br> 
                                    <table width="221" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#b9b9b9">
                                        <tr> 
                                              <td bgcolor="#FFFFFF">
                                                <table width="211" border="0" align="center" cellpadding="5" cellspacing="0">
                                                    <tr>
                                                        <td><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/white.gif" width="211" height="159" border="0"></td>
                                                      </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                              <td height="43" background="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_134.gif">
                                                <table width="214" border="0" align="center" cellpadding="5" cellspacing="0">
                                                    <tr>
                                                        <td width="18" valign="top"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/spacer.gif" width="1" height="2" alt=""><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/video_80.jpg" width="18" height="12" border="0"></td>
                                                        <td width="192" class="petit">&nbsp;</td>
                                                      </tr>
                                                </table>
                                            </td>
                                        </tr>
                                      </table>
                                      <br><br><br>
                                </td>
                            </tr>
                            <tr> 
                                <td align="center">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
<!-- MENU DROITE END -->
