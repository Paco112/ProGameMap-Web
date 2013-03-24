<body {$Body}>
<input id="sa" name="sa" type="hidden" title="{$Tlink}" value="{$Secu_Ajax}">
<div style="visibility: hidden; opacity: 0; display: block;" id="bck"></div>
<div style="visibility: hidden; opacity: 0; display: block;" class="generic_dialog" id="fb-modal">
  <div class="generic_dialog_popup" style="top: 200px;">
    <table class="pop_dialog_table" id="pop_dialog_table" style="width: 532px;">
      <tbody>
        <tr>
          <td class="pop_topleft"></td>
          <td class="pop_border pop_top"></td>
          <td class="pop_topright"></td>
        </tr>
        <tr>
          <td class="pop_border pop_side"></td>
          <td id="pop_content" class="pop_content"><div class="dialog_content">
              <div class="dialog_summary"></div>
              <div class="dialog_body">
                <div class="ubersearch search_profile">
                  <div class="result clearfix" id="titlebox">
                    <div class="clear" style="clear: both;"></div>
                  </div>
                </div>
              </div>
              <div class="dialog_buttons" id="infosbox">
                <input value="Close" name="close" class="inputsubmit" id="fb-close" type="hidden" />
              </div>
            </div></td>
          <td class="pop_border pop_side"></td>
        </tr>
        <tr>
          <td class="pop_bottomleft"></td>
          <td class="pop_border pop_bottom"></td>
          <td class="pop_bottomright"></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!--logo Start-->
<table width="985" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div style="position:absolute; top:0;">
        <ul id="navMenuTop">
        	{$MenuTop}
        </ul>
      </div></td>
  </tr>
  <tr>
    <td width="243px"><div style="margin:40px 0 0 0;"><a href="http://www.progamemap.com/"><img src="{$Tlink}public/images/logo.png" alt="ProGameMap.com" border="0" /></a></div></td>
    <td><div style="margin:40px 0 0 10px;">
    <div id="advertContainer"></div>
    <!--<img src="{$Tlink}public/images/Ad.jpg" alt="ProGameMap.com" style="border:1px solid #999" /></div>-->
    </td>
    <!--<td valign="middle" align="center">
            <div class="load_pub" style="display:block;">
                <img src="{$Tlink}public/images/pub-loader.gif" width="56" height="21">
            </div>
            <div class="pub" style="width:468px; height:60px; display:none;">
                {$PUB}
            </div>
        </td>-->
  </tr>
  <tr>
    <td colspan="2"><table border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;" >
        <tr>
          <td width="13px"></td>
          <td width="973" style="background:url({$Tlink}public/images/FilArianneBG.jpg) repeat-x;" align="left">
          	<ul id="FilArianne">
              {$FilArianne}
            </ul>
            <div id="loginLink">{$loginLink}</div>
              <!-- LOGIN BOX -->
              <div style="position:absolute; margin:30px 0 0 580px; z-index:999; display:none" id="LoginBox">
                <div class='frame'>
                  <div class='frame_top'>
                    <div class='corners_left'></div>
                    <div class='inner'>
                      <h2>Connexion</h2>
                    </div>
                    <div class='corners_right'></div>
                  </div>
                  <div class='frame_content'>
                    <div class="flash_boxes" id="flash_boxes">
                        <div id="usernameCheck"></div>
                        <div id="passwordCheck"></div>
                        <div id="loginCheck"></div>
					</div>
                    <form action="" class="onboard_form" method="post">
                      <div class='field text_field'>
                        <label for="log-username">Username</label>
                        <input name="log-username" type="text" class="autotab behavior log_" id="log-username" />
                      </div>
                      <div class='field text_field'>
                        <label for="log-password">{$#PASSWORD}</label>
                        <input name="log-password" type="password" class="log_" id="log-password" />
                      </div>
                      <div class='actions' style="float:right">
                        <div class="right gistsubmit">
                          <input class="log_" name="log-submit" id="log-submit" type="submit"  value="Login" />
                          <span></span></div>
                        <div class="clear"></div>
                      </div>
                    </form>
                    <br />
                    <br />
                    <div class='onboard_actions' style="position:absolute;">
                      <table border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="185"><a href="" class="left">Mot de passe oublié ?</a></td>
                          <td align="right"><div class='right'> Avez-vous un compte ?<a href="">Inscription</a></div></td>
                        </tr>
                      </table>
                    </div>
                    <br />
                  </div>
                  <div class='frame_bottom'>
                    <div class='corners_left'></div>
                    <div class='inner'></div>
                    <div class='corners_right'></div>
                  </div>
                </div>
              </div>
              <!-- LOGIN BOX END -->
            <!--<div id="prettysearch">
                        <input id="prettysearch" type="text" value="Rechercher" onFocus="if(this.value=='Rechercher')this.value=''" onblur="if(this.value=='')this.value='Rechercher'"/>
                      </div>-->
            &nbsp;&nbsp;&nbsp;</td>
          <td width="10px" style="background:url({$Tlink}public/images/FilArianneEnd.png) no-repeat left;"></td>
        </tr>
      </table></td>
  </tr>
</table>
<!--logo End-->
