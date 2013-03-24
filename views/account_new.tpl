<form action="" method="post">
  <input type="hidden" name="smoothbox" class="smoothbox" id="smoothbox" value="" />
  <div class="row2" style="margin:10px 8px 0 0">
    <div id="menuCompte">
      <div class="warningBox" style="margin-bottom:-30px"> <span><strong>Fonctionnement du syst&egrave;me de compte</strong></span>
        <p style="text-align:justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ici sur ProGameMap, un seul formulaire d'inscription. Une fois votre compte cr&eacute;er, il sera actif sur le site, le logiciel, le forum, etc. Vous serez connu de la comunnaut&eacute; sous un seul et m&ecirc;me pseudo. Votre page de profil regroupera ainsi toute votre activit&eacute; au sein du projet, que ce soit les informations concernant votre team, vos derniers topic cr&eacute;er sur le forum, ou bien vos r&eacute;centes activit&eacute;s sur le wiki. De la même mani&egrave;re, un seul formulaire de login sera n&eacute;cessaire : une fois connect&eacute;, vous aurez acc&egrave;s &agrave; tous les modules sans avoir &agrave; remplir d'autre formulaires.</p>
      </div>
    </div>
    <table class='ipbtable' cellspacing="0">
      <tr>
        <td width="49%" valign='top'><div id="menuCompte">
            <fieldset class="row3">
              <legend><b>Username:</b></legend>
              <div class='input-warn-content' id='box-name'>
                <div id='msg-name'></div>
              </div>
              <table class='ipbtable' cellspacing="0">
                <tr>
                  <td>Enter your desired <strong>log in</strong> username &nbsp;<span>(<a class="regHelp" href="#" style="cursor: help;" title="This is the name you'll use to log in. [3 and 26 characters long]">?</a>)</span></td>
                </tr>
                <tr>
                  <td><input class="reg_" type="text" size="50" maxlength="26" value="" id='reg-name' name="reg-name" />
                    <img id='img-name' src="{$Tlink}public/images/spacer.gif" alt="" width='12' height='12' /></td>
                </tr>
              </table>
              <div class='input-warn-content' id='box-dname'>
                <div id='msg-dname'></div>
              </div>
              <table class='ipbtable' cellspacing="0">
                <tr>
                  <td>Enter your desired <strong>display</strong> name &nbsp;<span>(<a class="regHelp" href="#" style="cursor: help;" title="This is the name shown with all your topics and posts. Between 3 and 26 chars. Illegal chars: [ ] | ; ,  &#036; &#92; &lt; &gt; &quot;">?</a>)</span></td>
                </tr>
                <tr>
                  <td><input class="reg_" type="text" size="50" maxlength="26" value="" id='reg-dname' name="reg-dname" />
                    <img id='img-dname' src="{$Tlink}public/images/spacer.gif" alt="" width='12' height='12' /></td>
                </tr>
              </table>
            </fieldset>
            <br />
            <fieldset class="row3">
              <div class='input-warn-content' id='box-password'>
                <div id='msg-password'></div>
              </div>
              <legend><b>Password:</b></legend>
              <table class='ipbtable' cellspacing="0">
                <tr>
                  <td width="1%" nowrap="nowrap">Enter your password &nbsp;<span>(<a class="regHelp" href="#" style="cursor: help;" title="Passwords must be between 3 and 32 characters long">?</a>)</span></td>
                  <td width="100%">Confirm Password &nbsp;<span>(<a class="regHelp" href="#" style="cursor: help;" title="Please re-enter your password: It must match exactly">?</a>)</span></td>
                </tr>
                <tr>
                  <td><input class="reg_" type="password" size="25" maxlength="32" value="" id='reg-password' name="reg-password" /></td>
                  <td><input class="reg_" type="password" size="25" maxlength="32" value=""  id='reg-password-check' name="reg-password-check" /></td>
                  <td width='12'><img id='img-password' src="{$Tlink}public/images/spacer.gif" alt="" width='12' height='12' /></td>
                </tr>
              </table>
            </fieldset>
            <br />
            <fieldset class="row3">
              <div class='input-warn-content' id='box-emailaddress'>
                <div id='msg-emailaddress'></div>
              </div>
              <legend><b>Email Address:</b></legend>
              <table class='ipbtable' cellspacing="0">
                <tr>
                  <td width="1%" nowrap="nowrap">Enter your Email Address &nbsp;<span>(<a class="regHelp" href="#" style="cursor: help;" title="Enter a valid email address. Illegal characters: [ ] ; # &amp; ! * ' &quot; &lt; &gt; % ( ) { } ? &#092;">?</a>)</span></td>
                  <td width="100%">Confirm Email Address &nbsp;<span>(<a class="regHelp" href="#" style="cursor: help;" title="Please re-enter your email address: It must match exactly">?</a>)</span></td>
                </tr>
                <tr>
                  <td><input class="reg_" type="text" size="25" maxlength="150" value=""  id='reg-emailaddress' name="reg-emailaddress" /></td>
                  <td><input class="reg_" type="text" size="25" maxlength="150"  value="" id='reg-emailaddress-two' name="reg-emailaddress-two" /></td>
                  <td width='12'><img id='img-emailaddress' src="{$Tlink}public/images/spacer.gif" alt="" width='12' height='12' /></td>
                </tr>
              </table>
            </fieldset>
            <br />
            <!--{REQUIRED.FIELDS}-->
            <!--{SUBS.MANAGER}-->
            <fieldset class="row3">
              <div class='input-warn-content' id='box-captcha'>
                <div id='msg-captcha'></div>
              </div>
              <legend><b>Captcha:</b></legend>
              <table class='ipbtable' cellspacing="0" height="50">
                <tr>
                  <td align="center" valign="top"><table>
                      <tr>
                        <td width="150"><img id='cryptogram' src='{$Tlink}include/crypt/cryptographp.php?cfg=0&'></td>
                        <td><a title='' style="cursor:pointer" onclick="javascript:document.images.cryptogram.src='{$Tlink}include/crypt/cryptographp.php?cfg=0&&'+Math.round(Math.random(0)*1000)+1"><img src="{$Tlink}include/crypt/images/reload.png"></a></td>
                      </tr>
                    </table></td>
                  <td align="center" valign="top"><table>
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;Recopier le code (?)</td>
                      </tr>
                      <tr>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="text" name="reg-captcha" id="reg-captcha"></td>
                      </tr>
                    </table></td>
                  <td width="35" valign="bottom">&nbsp;</td>
                  <td width='12'><img id='img-captcha' src="{$Tlink}public/images/spacer.gif" alt="" width='12' height='12' /></td>
                </tr>
              </table>
            </fieldset>
            <br />
          </div></td>
        <td width="49%" valign="top"><div id="menuCompte">
            <div> <b>Optional Information</b><br />
              <br />
              <table class='ipbtable' cellspacing="0">
                <tr>
                  <td><fieldset>
                      <legend>Receiving Email</legend>
                      <div class="desc">Now and again, the administrators and other members might wish to contact you via email through this board.</div>
                      <br />
                      <!--<input class="reg_" type="checkbox" name="allow_newsletter" value="1" class="checkbox" checked="checked" />-->
                      <input class="reg_" type="checkbox" name="allow_newsletter" value="1" checked="checked" />
                      Receive newsletters from administrators<br />
                    </fieldset>
                    <br />
                    <fieldset>
                      <legend>Time Zone Settings</legend>
                      <div class="desc">You can adjust the default time zone setting below</div>
                      <br />
                      <select name='time_offset' class='forminput'>
                        <option value='-12'>(GMT - 12:00 hours) Enewetak, Kwajalein</option>
                        <option value='-11'>(GMT - 11:00 hours) Midway Island, Samoa</option>
                        <option value='-10'>(GMT - 10:00 hours) Hawaii</option>
                        <option value='-9.5'>(GMT - 9:30 hours) French Polynesia</option>
                        <option value='-9'>(GMT - 9:00 hours) Alaska</option>
                        <option value='-8'>(GMT - 8:00 hours) Pacific Time (US &amp; Canada)</option>
                        <option value='-7'>(GMT - 7:00 hours) Mountain Time (US &amp; Canada)</option>
                        <option value='-6'>(GMT - 6:00 hours) Central Time (US &amp; Canada), Mexico City</option>
                        <option value='-5'>(GMT - 5:00 hours) Eastern Time (US &amp; Canada), Bogota, Lima</option>
                        <option value='-4'>(GMT - 4:00 hours) Atlantic Time (Canada), Caracas, La Paz</option>
                        <option value='-3.5'>(GMT - 3:30 hours) Newfoundland</option>
                        <option value='-3'>(GMT - 3:00 hours) Brazil, Buenos Aires, Falkland Is.</option>
                        <option value='-2'>(GMT - 2:00 hours) Mid-Atlantic, Ascention Is., St Helena</option>
                        <option value='-1'>(GMT - 1:00 hours) Azores, Cape Verde Islands</option>
                        <option value='0'>(GMT) Casablanca, Dublin, London, Lisbon, Monrovia</option>
                        <option value='1' selected='selected'>(GMT + 1:00 hours) Brussels, Copenhagen, Madrid, Paris</option>
                        <option value='2'>(GMT + 2:00 hours) Kaliningrad, South Africa</option>
                        <option value='3'>(GMT + 3:00 hours) Baghdad, Riyadh, Moscow, Nairobi</option>
                        <option value='3.5'>(GMT + 3:30 hours) Tehran</option>
                        <option value='4'>(GMT + 4:00 hours) Abu Dhabi, Baku, Muscat, Tbilisi</option>
                        <option value='4.5'>(GMT + 4:30 hours) Kabul</option>
                        <option value='5'>(GMT + 5:00 hours) Ekaterinburg, Karachi, Tashkent</option>
                        <option value='5.5'>(GMT + 5:30 hours) Bombay, Calcutta, Madras, New Delhi</option>
                        <option value='5.75'>(GMT + 5:45 hours) Kathmandu</option>
                        <option value='6'>(GMT + 6:00 hours) Almaty, Colombo, Dhaka</option>
                        <option value='6.5'>(GMT + 6:30 hours) Yangon, Naypyidaw, Bantam</option>
                        <option value='7'>(GMT + 7:00 hours) Bangkok, Hanoi, Jakarta</option>
                        <option value='8'>(GMT + 8:00 hours) Hong Kong, Perth, Singapore, Taipei</option>
                        <option value='8.75'>(GMT + 8:45 hours) Caiguna, Eucla</option>
                        <option value='9'>(GMT + 9:00 hours) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
                        <option value='9.5'>(GMT + 9:30 hours) Adelaide, Darwin</option>
                        <option value='10'>(GMT + 10:00 hours) Melbourne, Papua New Guinea, Sydney</option>
                        <option value='10.5'>(GMT + 10:30 hours) Lord Howe Island</option>
                        <option value='11'>(GMT + 11:00 hours) Magadan, New Caledonia, Solomon Is.</option>
                        <option value='11.5'>(GMT + 11:30 hours) Burnt Pine, Kingston</option>
                        <option value='12'>(GMT + 12:00 hours) Auckland, Fiji, Marshall Island</option>
                        <option value='12.75'>(GMT + 12:45 hours) Chatham Islands</option>
                        <option value='13'>(GMT + 13:00 hours) Kamchatka, Anadyr</option>
                        <option value='14'>(GMT + 14:00 hours) Kiritimati</option>
                      </select>
                      <br />
                      <br />
                      <!--<input class="reg_" type="checkbox" name="dst" value="1" class="checkbox"  /> Observing Daylight Saving Time?<br />-->
                    </fieldset>
                    <br />
                    <!--{OPTIONAL.FIELDS}--></td>
                </tr>
              </table>
            </div>
          </div>
          <br />
          <br />
          <center>
            <div class="desc">I agree to the terms of this registration and wish to proceed.</div>
            <br />
            <table width="200px">
              <tr>
                <td><div class="right gistsubmit">
                    <!--<input class="reg_" class='button' type="submit" value="Submit my registration" name="reg-submit" id="reg-submit" />-->
                    <input class="reg_" type="submit" value="Submit my registration" name="reg-submit" id="reg-submit" />
                    <span></span></div></td>
              </tr>
            </table>
          </center></td>
      </tr>
    </table>
  </div>
  </div>
</form>
