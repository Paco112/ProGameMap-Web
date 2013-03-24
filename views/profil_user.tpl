<table cellspacing='4' cellpadding='0' width='100%'  border='0'>
  <tr>
    <td style='width:210px' valign='top'><div class="borderwrap">
      <div id="menuCompte" width="100%" style="padding:3px 0 0 0">
        <div class="pp-header2" style="border-top: 0pt none;">{$#PHOTOPERSO}</div>
        <table width="100%" cellpadding="1" cellspacing="0">
          <tbody>
            <tr>
              <td class="row1" style="padding: 3px; margin-bottom: 0px;" valign="middle" width="60%" align="center"><!-- Personal Photo -->
                <center>
                  <img id="pp-main-photo" src="http://www.progamemap.com/public/images/pp-blank-large.png" alt="" width="150" height="150">
                </center>
                <div style="margin-top: 10px; margin-bottom: 6px;" align="center">
                <div id="pp-friend-wrap">
                  <!--<img src="http://www.progamemap.com/public/images/friend_add_small.png" id="pp-friend-img" alt="" border="0"><a href="#" id="pp-friend-text">Ajouter à mes amis</a></div>-->
                  <!--<img src="http://www.progamemap.com/public/images/send_pm_small.png" alt="" border="0"><a href="">Envoyer un message</a>-->
                </div>
                <!-- / Personal Photo -->
                <!-- Quick contact -->
                <!-- / Quick contact --></td>
            </tr>
          </tbody>
        </table>
        <!-- Options -->
        <!--<div class="pp-header2">Options</div>
        <div class="row1" style="padding: 6px 6px 6px 10px; margin-bottom: 1px; text-align: center;">
          <div style="cursor: pointer;" class="popmenubutton-new" id="profile-options">Options</div>
          <div class="popupmenu" id="profile-options_menu" style="display: none; z-index: 100; position: absolute; left: 0px; top: 0px;">
            <div class="popupmenu-item"> <img src="http://www.progamemap.com/public/images/profile_item.gif" border="0"> <a href="#" onclick="return profile_dname_history(1565)">Historique du nom d'affichage du membre</a> </div>
            <div class="popupmenu-item"> <img src="http://www.progamemap.com/public/images/profile_item.gif" border="0"> <a href="">Trouver tous les messages de ce membre</a> </div>
            <div class="popupmenu-item-last"> <img src="http://www.progamemap.com/public/images/profile_item.gif" border="0"> <a href="">Trouver tous les sujets de ce membre</a> </div>
          </div>
        </div>-->
        <!-- / Options -->
        <!-- Personal Statement -->
        <div class="pp-header2">{$#PRESENTATIONPERSO}</div>
        <div class="row1" style="padding: 6px 6px 6px 10px; margin-bottom: 1px;" id="pp-personal_statement"> <em>{$presentation}</em> </div>
        <!-- / Personal Statement -->
        <!-- Statistics -->
        <div class="pp-header2">{$#STATS}</div>
        <div class="row1" style="padding: 6px 6px 6px 10px; margin-bottom: 1px;">{$#INSCRIT} : {$register}</div>
        <!--<div class="row1" style="padding: 6px 6px 6px 10px; margin-bottom: 1px;">Profil vu 1237 fois<span class="pp-tiny-text">*</span></div>-->
        <div class="row1" style="padding: 6px 6px 6px 10px; margin-bottom: 1px;">{$#DERNIEREVISITE} : Hier, 10H37 </div>
        <!-- / Statistics -->
        <!-- Contact Information -->
        <div class="pp-header2">{$#CONTACT}</div>
        <div class="row1" style="padding: 6px 6px 6px 10px; margin-bottom: 1px;">
          <div id="pp-entry-contact-wrap-icq"> <img src="http://www.progamemap.com/public/images/profile_icq.gif" alt="ICQ" border="0"> <span id="pp-entry-contact-entry-icq"><em>{$#AUCUNEINFO}</em></span> </div>
        </div>
        <div class="row1" style="padding: 6px 6px 6px 10px; margin-bottom: 1px;">
          <div id="pp-entry-contact-wrap-msn"> <img src="http://www.progamemap.com/public/images/profile_msn.gif" alt="MSN" border="0"> <span id="pp-entry-contact-entry-msn"><em>{$#AUCUNEINFO}</em></span> </div>
        </div>
        <!--<div class="row1" style="padding: 6px 6px 6px 10px; margin-bottom: 1px;"> <img src="http://www.progamemap.com/public/images/icon_msg_nonew.gif" alt="Contact" border="0"> <a href="">Envoyer un message</a> </div>
        <div class="row1" style="padding: 6px 6px 6px 10px;"> <img src="http://www.progamemap.com/public/images/icon_msg_nonew.gif" alt="Contact" border="0"> <em>Privé</em> </div>-->
        <!-- / Contact Information -->
      </div>
      <!--<div style="font-size:10px; margin:0 0 10px 10px">* Le compteur est mis à jour chaque heure</div></div></td>-->
    <td valign='top'><!-- MAIN TABLE -->
      <div id="menuCompte" width="100%">
        <div class='pp-name2' style="margin-bottom:-20px">
          <table cellpadding='0' cellspacing='0' width='100%'>
            <tr>
              <td width='1%'></td>
              <td width='98%' style='padding-left:10px'><h3>{$displayNameUser}</h3>
                {$userGroup} </td>
            </tr>
          </table>
        </div>
        <br />
      </div>
      <!-- My Stuff -->
      <div style="margin-left:10px;" id="aboutMe">
        <div class='pp-tabwrap2'>
          <div class='pp-tabon2' id='pp-content-tab-infos2'>{$#INFOS}</div>
          <div class='pp-taboff2' id='clickPack' style="cursor:pointer">{$#PACK}</div>
        </div>
        <div class="pp-tabclear2">{$#ABOUTME}</div>
        <div class="borderwrap2">
          <div style="padding: 6px; height: auto;" id="pp-main-tab-content2" class="pp-contentbox-back2">
            <div>
              <div class="pp-contentbox-entry-noheight2">
                <table>
                  <tr>
                    <td>{$#SEXE} :</td>
                    <td>{$sexe}</td>
                  </tr>
                  <tr>
                    <td>{$#BIRTHDAY} :</td>
                    <td>{$anniversaire}</td>
                  </tr>
                  <tr>
                    <td>{$#ORIGINAIRE} :</td>
                    <td>{$originaire}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div></div>
        <!-- / My Stuff -->
        <!-- pack -->
        <div style="margin-left:10px;display:none;" id="myPack">
          <div class='pp-tabwrap2'>
            <div class='pp-taboff2' id='clickAbout' style="cursor:pointer">{$#INFOS}</div>
            <div class='pp-tabon2' id='pp-content-tab-comments2'>{$#PACK}</div>
          </div>
          <div class="pp-tabclear2">{$#PACK}</div>
          <div class="borderwrap2">
            <div style="padding: 6px; height: auto;" id="pp-main-tab-content2" class="pp-contentbox-back2">
              <div>
                <div class="pp-contentbox-entry-noheight2"> {$MY_PACK} </div>
              </div>
            </div>
          </div>
          <!-- / My Stuff -->
        </div>
      <!-- / MAIN TABLE --></td>
    <td style='width:210px;' valign='top'><div id="menuCompte" width="100%" style="margin-right:9px;padding:3px 0 0 0">
        <!-- RIGHT TABLE -->
        <!-- Recent Visitors -->
        <div class="borderwrap2">
          <div class="pp-header2" style="border-top: 0pt none;">{$#LASTVISOTORS}</div>
          {$LassstVisitor} </div>
        <!-- / Recent Visitors -->
        <br />
        <!-- sssh.. ugly hack to stop IE collapsing this column under short widths -->
        <img src='http://board.xnova-ng.org/style_images/web2englis1245311880/blank.gif' width='210' height='1' alt='' />
        <!-- / RIGHT TABLE -->
      </div></td>
  </tr>
</table>
