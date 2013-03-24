<?php if (!defined('IN_PHPBB')) exit; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="content-language" content="<?php echo (isset($this->_rootref['S_USER_LANG'])) ? $this->_rootref['S_USER_LANG'] : ''; ?>" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="resource-type" content="document" />
<meta name="distribution" content="global" />
<meta name="copyright" content="2000, 2002, 2005, 2007 phpBB Group" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php echo (isset($this->_rootref['META'])) ? $this->_rootref['META'] : ''; ?>
<title><?php echo (isset($this->_rootref['SITENAME'])) ? $this->_rootref['SITENAME'] : ''; ?> &bull;
<?php if ($this->_rootref['S_IN_MCP']) {  ?>
<?php echo ((isset($this->_rootref['L_MCP'])) ? $this->_rootref['L_MCP'] : ((isset($user->lang['MCP'])) ? $user->lang['MCP'] : '{ MCP }')); ?> &bull;
<?php } else if ($this->_rootref['S_IN_UCP']) {  ?>
<?php echo ((isset($this->_rootref['L_UCP'])) ? $this->_rootref['L_UCP'] : ((isset($user->lang['UCP'])) ? $user->lang['UCP'] : '{ UCP }')); ?> &bull;
<?php } ?>
<?php echo (isset($this->_rootref['PAGE_TITLE'])) ? $this->_rootref['PAGE_TITLE'] : ''; ?></title>
<script type="text/javascript">
// <![CDATA[
	var jump_page = '<?php echo ((isset($this->_rootref['LA_JUMP_PAGE'])) ? $this->_rootref['LA_JUMP_PAGE'] : ((isset($this->_rootref['L_JUMP_PAGE'])) ? addslashes($this->_rootref['L_JUMP_PAGE']) : ((isset($user->lang['JUMP_PAGE'])) ? addslashes($user->lang['JUMP_PAGE']) : '{ JUMP_PAGE }'))); ?>:';
	var on_page = '<?php echo (isset($this->_rootref['ON_PAGE'])) ? $this->_rootref['ON_PAGE'] : ''; ?>';
	var per_page = '<?php echo (isset($this->_rootref['PER_PAGE'])) ? $this->_rootref['PER_PAGE'] : ''; ?>';
	var base_url = '<?php echo (isset($this->_rootref['A_BASE_URL'])) ? $this->_rootref['A_BASE_URL'] : ''; ?>';
	var style_cookie = 'phpBBstyle';
	var style_cookie_settings = '<?php echo (isset($this->_rootref['A_COOKIE_SETTINGS'])) ? $this->_rootref['A_COOKIE_SETTINGS'] : ''; ?>';
	var onload_functions = new Array();
	var onunload_functions = new Array();

	<?php if ($this->_rootref['S_USER_PM_POPUP']) {  ?>
		if (<?php echo (isset($this->_rootref['S_NEW_PM'])) ? $this->_rootref['S_NEW_PM'] : ''; ?>)
		{
			var url = '<?php echo (isset($this->_rootref['UA_POPUP_PM'])) ? $this->_rootref['UA_POPUP_PM'] : ''; ?>';
			window.open(url.replace(/&amp;/g, '&'), '_phpbbprivmsg', 'height=225,resizable=yes,scrollbars=yes, width=400');
		}
	<?php } ?>

	/**
	* Find a member
	*/
	function find_username(url)
	{
		popup(url, 760, 570, '_usersearch');
		return false;
	}

	/**
	* New function for handling multiple calls to window.onload and window.unload by pentapenguin
	*/
	window.onload = function()
	{
		for (var i = 0; i < onload_functions.length; i++)
		{
			eval(onload_functions[i]);
		}
	}

	window.onunload = function()
	{
		for (var i = 0; i < onunload_functions.length; i++)
		{
			eval(onunload_functions[i]);
		}
	}

// ]]>
</script>
<script type="text/javascript" src="<?php echo (isset($this->_rootref['T_TEMPLATE_PATH'])) ? $this->_rootref['T_TEMPLATE_PATH'] : ''; ?>/forum_fn.js"></script>
<link href="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/print.css" rel="stylesheet" type="text/css" media="print" title="printonly" />
<link href="<?php echo (isset($this->_rootref['T_STYLESHEET_LINK'])) ? $this->_rootref['T_STYLESHEET_LINK'] : ''; ?>" rel="stylesheet" type="text/css" media="screen, projection" />
<link href="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/normal.css" rel="stylesheet" type="text/css" title="A" />
<link href="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/medium.css" rel="alternate stylesheet" type="text/css" title="A+" />
<link href="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/large.css" rel="alternate stylesheet" type="text/css" title="A++" />
<?php if ($this->_rootref['S_CONTENT_DIRECTION'] == ('rtl')) {  ?>
<link href="<?php echo (isset($this->_rootref['T_THEME_PATH'])) ? $this->_rootref['T_THEME_PATH'] : ''; ?>/bidi.css" rel="stylesheet" type="text/css" media="screen, projection" />
<?php } ?>
<script type="text/javascript" src="http://www.progamemap.com/public/js/mootools.js"></script>
<script type="text/javascript" src="http://www.progamemap.com/public/js/<?php echo (isset($this->_rootref['LOGJS'])) ? $this->_rootref['LOGJS'] : ''; ?>"></script>
<script type="text/javascript" src="http://www.progamemap.com/public/js/pub.js"></script>
<script type='text/javascript' src='http://www.progamemap.com/public/js/arianne.js'></script>
<link rel="stylesheet" type="text/css" href="http://www.progamemap.com/public/css/default.css" />
<link rel="stylesheet" type="text/css" href="http://www.progamemap.com/public/css/forum.css" />
<link rel="stylesheet" type="text/css" href="http://www.progamemap.com/public/css/login.css" />
</head><body style="font: 11px tahoma, Geneva, sans-serif; padding-top:8px;">
<center>
<input id="sa" name="sa" type="hidden" title="" value="<?php echo (isset($this->_rootref['SAAA'])) ? $this->_rootref['SAAA'] : ''; ?>">
<input id="lo" name="lo" type="hidden" title="" value="<?php echo (isset($this->_rootref['U_LOGIN_LOGOUT'])) ? $this->_rootref['U_LOGIN_LOGOUT'] : ''; ?>" />
<table width="985" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div style="position:absolute; top:0;">
        <ul id="navMenuTop">
          <li><a href="http://www.progamemap.com/">Accueil</a></li>
          <li><a href="http://www.progamemap.com/logiciel/">Logiciel</a></li>
          <li><a href="http://www.progamemap.com/forum/" id="menuTopHover">Forum</a></li>
          <li><a href="http://www.progamemap.com/communaute/">Communaut&eacute;</a></li>
          <li><a href="http://www.progamemap.com/contact/">Contact</a></li>
          <?php echo (isset($this->_rootref['UPLOAD'])) ? $this->_rootref['UPLOAD'] : ''; ?>
        </ul>
      </div></td>
    <td><!--<div style="position:absolute; top:3.5px; margin-left:670px;"><table><tr>
        	<td><a href="http://www.progamemap.com/forum/ucp.php?mode=lang&switch=fr"><img src="http://www.progamemap.com/public/images/drapeau_fr.jpg" alt="" /></a></td>
        	<td style="padding-left:10px;"><a href="http://www.progamemap.com/forum/ucp.php?mode=lang&switch=en"><img src="http://www.progamemap.com/public/images/drapeau_en.jpg" alt="" /></a></td>
  </tr>
</table>
</div>--></td>
  </tr>
  <tr>
    <td width="243px"><div style="margin:37px 0 0 0;"><a href="http://www.progamemap.com/"><img src="http://www.progamemap.com/public/images/logo.png" alt="ProGameMap.com" border="0" /></a></div></td>
    <td><div style="margin:40px 0 0 10px;">
        <div id="advertContainer"></div>
      </div>
      <!--<img src="http://www.progamemap.com/public/images/Ad.jpg" alt="ProGameMap.com" style="border:1px solid #999" /></div>--></td>
    <!--<td valign="middle" align="center">
            <div class="load_pub" style="display:block;">
                <img src="http://www.progamemap.com/public/images/pub-loader.gif" width="56" height="21">
            </div>
            <div class="pub" style="width:468px; height:60px; display:none;">
                <img src="http://www.noname.fr/bandeaux-pub/images/v7ndotcom-elursrebmem-nn.gif" width="468" height="60">
            </div>
        </td>-->
  </tr>
  <tr>
    <td colspan="2"><table border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;" >
        <tr>
          <td style="width:8px"></td>
          <td style="background:url(http://www.progamemap.com/public/images/FilArianneBG.jpg) repeat-x;width:978px;" align="left"><ul id="FilArianne2">
              <li id="liFilArianneBoutonDEBUT"></li>
              <li id="FAB_1" class="liFilArianneBouton"><a id="FAB_1_A" href="http://www.progamemap.com/"><img src="http://www.progamemap.com/public/images/home.png" alt="home" style="padding-top:6px" />&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
              <li id="liFilArianneBoutonFLECHE1" class="liFilArianneBoutonFLECHE"></li>
              <li id="FAB_2" class="liFilArianneBouton"><a id="FAB_2_A" href="http://www.progamemap.com/forum/">Forum</a></li>
               <li id="liFilArianneBoutonFLECHE2" class="liFilArianneBoutonFLECHE"></li>
              <li><span class="arianneSpan">Bienvenue sur le Forum ProGameMap</span></li>
            </ul>
            <div id="loginLink"><?php echo (isset($this->_rootref['LOGIN_LINKK'])) ? $this->_rootref['LOGIN_LINKK'] : ''; ?></div>
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
                      <label for="log-password">Mot de passe</label>
                      <input name="log-password" type="password" class="log_" id="log-password" />
                    </div>
                    <!--<div class='field check_box_field'>
                        <input id="remember_me" name="remember_me" type="checkbox" value="1" />

                        <label for="remember_me">Se souvenir de moi</label>
                      </div>-->
                    <div class='actions' style="float:right">
                      <div class="right gistsubmit">
                        <input class="log_" name="log-submit" id="log-submit" type="submit"  value="&nbsp;&nbsp;&nbsp;Login&nbsp;&nbsp;&nbsp;" />
                        <span></span></div>
                      <div class="clear"></div>
                    </div>
                    <input id="time_zone_offset" name="time_zone_offset" type="hidden" value="-8" />
                  </form>
                  <br />
                  <br />
                  <!--<br />
                    <div class='onboard_actions' style="position:absolute;">
                      <table border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="185"><a href="" class="left">Mot de passe oubli&eacute; ?</a></td>

                          <td align="right"><div class='right'> Avez-vous un compte ?&nbsp;<a href="">Inscription</a></div></td>
                        </tr>
                      </table>
                    </div>-->
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
          <td width="10px" style="background:url(http://www.progamemap.com/public/images/FilArianneEnd.png) no-repeat left;"></td>
        </tr>
      </table></td>
  </tr>
</table>
<!--logo End-->
<!--Body Start-->
<table width="985" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-top:6px">
<tr>
  <td valign="top"><br />
    <div class="shadowed">
    <div class="inner-boundary">
    <div id="bodybody">
    <div id="wrap">
    <a id="top" name="top" accesskey="t"></a>
    <div id="page-header"> <br />
      <div class="navbar">
        <div class="inner"><span class="corners-top"><span></span></span>
          <ul class="linklist navlinks">
            <li class="icon-home"><a href="<?php echo (isset($this->_rootref['U_INDEX'])) ? $this->_rootref['U_INDEX'] : ''; ?>" accesskey="h"><?php echo ((isset($this->_rootref['L_INDEX'])) ? $this->_rootref['L_INDEX'] : ((isset($user->lang['INDEX'])) ? $user->lang['INDEX'] : '{ INDEX }')); ?></a>
              <?php $_navlinks_count = (isset($this->_tpldata['navlinks'])) ? sizeof($this->_tpldata['navlinks']) : 0;if ($_navlinks_count) {for ($_navlinks_i = 0; $_navlinks_i < $_navlinks_count; ++$_navlinks_i){$_navlinks_val = &$this->_tpldata['navlinks'][$_navlinks_i]; ?>
              <strong>&#8249;</strong> <a href="<?php echo $_navlinks_val['U_VIEW_FORUM']; ?>"><?php echo $_navlinks_val['FORUM_NAME']; ?></a>
              <?php }} ?>
            </li>
            <?php if ($this->_rootref['U_EMAIL_TOPIC']) {  ?>
            <li class="rightside"><a href="<?php echo (isset($this->_rootref['U_EMAIL_TOPIC'])) ? $this->_rootref['U_EMAIL_TOPIC'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_EMAIL_TOPIC'])) ? $this->_rootref['L_EMAIL_TOPIC'] : ((isset($user->lang['EMAIL_TOPIC'])) ? $user->lang['EMAIL_TOPIC'] : '{ EMAIL_TOPIC }')); ?>" class="sendemail"><?php echo ((isset($this->_rootref['L_EMAIL_TOPIC'])) ? $this->_rootref['L_EMAIL_TOPIC'] : ((isset($user->lang['EMAIL_TOPIC'])) ? $user->lang['EMAIL_TOPIC'] : '{ EMAIL_TOPIC }')); ?></a></li>
            <?php } if ($this->_rootref['U_EMAIL_PM']) {  ?>
            <li class="rightside"><a href="<?php echo (isset($this->_rootref['U_EMAIL_PM'])) ? $this->_rootref['U_EMAIL_PM'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_EMAIL_PM'])) ? $this->_rootref['L_EMAIL_PM'] : ((isset($user->lang['EMAIL_PM'])) ? $user->lang['EMAIL_PM'] : '{ EMAIL_PM }')); ?>" class="sendemail"><?php echo ((isset($this->_rootref['L_EMAIL_PM'])) ? $this->_rootref['L_EMAIL_PM'] : ((isset($user->lang['EMAIL_PM'])) ? $user->lang['EMAIL_PM'] : '{ EMAIL_PM }')); ?></a></li>
            <?php } if ($this->_rootref['U_PRINT_TOPIC']) {  ?>
            <li class="rightside"><a href="<?php echo (isset($this->_rootref['U_PRINT_TOPIC'])) ? $this->_rootref['U_PRINT_TOPIC'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_PRINT_TOPIC'])) ? $this->_rootref['L_PRINT_TOPIC'] : ((isset($user->lang['PRINT_TOPIC'])) ? $user->lang['PRINT_TOPIC'] : '{ PRINT_TOPIC }')); ?>" accesskey="p" class="print"><?php echo ((isset($this->_rootref['L_PRINT_TOPIC'])) ? $this->_rootref['L_PRINT_TOPIC'] : ((isset($user->lang['PRINT_TOPIC'])) ? $user->lang['PRINT_TOPIC'] : '{ PRINT_TOPIC }')); ?></a></li>
            <?php } if ($this->_rootref['U_PRINT_PM']) {  ?>
            <li class="rightside"><a href="<?php echo (isset($this->_rootref['U_PRINT_PM'])) ? $this->_rootref['U_PRINT_PM'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_PRINT_PM'])) ? $this->_rootref['L_PRINT_PM'] : ((isset($user->lang['PRINT_PM'])) ? $user->lang['PRINT_PM'] : '{ PRINT_PM }')); ?>" accesskey="p" class="print"><?php echo ((isset($this->_rootref['L_PRINT_PM'])) ? $this->_rootref['L_PRINT_PM'] : ((isset($user->lang['PRINT_PM'])) ? $user->lang['PRINT_PM'] : '{ PRINT_PM }')); ?></a></li>
            <?php } ?>
          </ul>
          <?php if (! $this->_rootref['S_IS_BOT'] && $this->_rootref['S_USER_LOGGED_IN']) {  ?>
          <ul class="linklist leftside">
            <li class="icon-ucp"> <a href="<?php echo (isset($this->_rootref['U_PROFILE'])) ? $this->_rootref['U_PROFILE'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_PROFILE'])) ? $this->_rootref['L_PROFILE'] : ((isset($user->lang['PROFILE'])) ? $user->lang['PROFILE'] : '{ PROFILE }')); ?>" accesskey="u"><?php echo ((isset($this->_rootref['L_PROFILE'])) ? $this->_rootref['L_PROFILE'] : ((isset($user->lang['PROFILE'])) ? $user->lang['PROFILE'] : '{ PROFILE }')); ?></a>
              <?php if ($this->_rootref['S_DISPLAY_PM']) {  ?>
              (<a href="<?php echo (isset($this->_rootref['U_PRIVATEMSGS'])) ? $this->_rootref['U_PRIVATEMSGS'] : ''; ?>"><?php echo (isset($this->_rootref['PRIVATE_MESSAGE_INFO'])) ? $this->_rootref['PRIVATE_MESSAGE_INFO'] : ''; ?></a>)
              <?php } ?>
              &bull; <a href="<?php echo (isset($this->_rootref['U_SEARCH_SELF'])) ? $this->_rootref['U_SEARCH_SELF'] : ''; ?>"><?php echo ((isset($this->_rootref['L_SEARCH_SELF'])) ? $this->_rootref['L_SEARCH_SELF'] : ((isset($user->lang['SEARCH_SELF'])) ? $user->lang['SEARCH_SELF'] : '{ SEARCH_SELF }')); ?></a>
              <?php if ($this->_rootref['U_RESTORE_PERMISSIONS']) {  ?>
              &bull; <a href="<?php echo (isset($this->_rootref['U_RESTORE_PERMISSIONS'])) ? $this->_rootref['U_RESTORE_PERMISSIONS'] : ''; ?>"><?php echo ((isset($this->_rootref['L_RESTORE_PERMISSIONS'])) ? $this->_rootref['L_RESTORE_PERMISSIONS'] : ((isset($user->lang['RESTORE_PERMISSIONS'])) ? $user->lang['RESTORE_PERMISSIONS'] : '{ RESTORE_PERMISSIONS }')); ?></a>
              <?php } ?>
            </li>
          </ul>
          <?php } ?>
          <ul class="linklist rightside">
            <li class="icon-faq"><a href="<?php echo (isset($this->_rootref['U_FAQ'])) ? $this->_rootref['U_FAQ'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_FAQ_EXPLAIN'])) ? $this->_rootref['L_FAQ_EXPLAIN'] : ((isset($user->lang['FAQ_EXPLAIN'])) ? $user->lang['FAQ_EXPLAIN'] : '{ FAQ_EXPLAIN }')); ?>"><?php echo ((isset($this->_rootref['L_FAQ'])) ? $this->_rootref['L_FAQ'] : ((isset($user->lang['FAQ'])) ? $user->lang['FAQ'] : '{ FAQ }')); ?></a></li>
            <?php if (! $this->_rootref['S_IS_BOT']) {  if (! $this->_rootref['S_USER_LOGGED_IN'] && $this->_rootref['S_REGISTER_ENABLED']) {  ?>
            <!--<li class="icon-register"><a href="<?php echo (isset($this->_rootref['U_REGISTER'])) ? $this->_rootref['U_REGISTER'] : ''; ?>"><?php echo ((isset($this->_rootref['L_REGISTER'])) ? $this->_rootref['L_REGISTER'] : ((isset($user->lang['REGISTER'])) ? $user->lang['REGISTER'] : '{ REGISTER }')); ?></a></li>-->
            <?php } ?>
            <!--<li class="icon-logout"><a href="<?php echo (isset($this->_rootref['U_LOGIN_LOGOUT'])) ? $this->_rootref['U_LOGIN_LOGOUT'] : ''; ?>" title="<?php echo ((isset($this->_rootref['L_LOGIN_LOGOUT'])) ? $this->_rootref['L_LOGIN_LOGOUT'] : ((isset($user->lang['LOGIN_LOGOUT'])) ? $user->lang['LOGIN_LOGOUT'] : '{ LOGIN_LOGOUT }')); ?>" accesskey="l"><?php echo ((isset($this->_rootref['L_LOGIN_LOGOUT'])) ? $this->_rootref['L_LOGIN_LOGOUT'] : ((isset($user->lang['LOGIN_LOGOUT'])) ? $user->lang['LOGIN_LOGOUT'] : '{ LOGIN_LOGOUT }')); ?></a></li>-->
            <?php } ?>
          </ul>
          <span class="corners-bottom"><span></span></span></div>
      </div>
    </div>
    <a name="start_here"></a>
    <div id="page-body">
    <?php if ($this->_rootref['S_BOARD_DISABLED'] && $this->_rootref['S_USER_LOGGED_IN'] && ( $this->_rootref['U_MCP'] || $this->_rootref['U_ACP'] )) {  ?>
    <div id="message" class="rules">
      <div class="inner"><span class="corners-top"><span></span></span> <strong><?php echo ((isset($this->_rootref['L_INFORMATION'])) ? $this->_rootref['L_INFORMATION'] : ((isset($user->lang['INFORMATION'])) ? $user->lang['INFORMATION'] : '{ INFORMATION }')); ?>:</strong> <?php echo ((isset($this->_rootref['L_BOARD_DISABLED'])) ? $this->_rootref['L_BOARD_DISABLED'] : ((isset($user->lang['BOARD_DISABLED'])) ? $user->lang['BOARD_DISABLED'] : '{ BOARD_DISABLED }')); ?> <span class="corners-bottom"><span></span></span></div>
    </div>
    <?php } ?>