<?php
require("./config/config.lib.php");
require("./lib/release.lib.php");

if (isset($_GET["L"])) $L = $_GET["L"];
if (!isset($L))
{
	$L = "";
}
// Fix a security hole
else if (!is_dir("./localization/".$L))
{
	exit();
}
if ($L == "" || !file_exists("./localization/${L}/localized.tutorial.php"))
{
if ($L != "" && file_exists("./localization/${L}/localized.chat.php")) include ("./localization/${L}/localized.chat.php");
elseif (file_exists("./localization/english/localized.chat.php")) include ("./localization/english/localized.chat.php");
elseif (file_exists("./localization/".C_LANGUAGE."/localized.chat.php")) include ("./localization/".C_LANGUAGE."/localized.chat.php");
	if ($L!="turkish") $NoTranslation = "<CENTER><P CLASS='RedText'>We are sorry but this tutorial has not been translated into the ".ucwords(str_replace("_"," ",$L))." language yet.<br />If you would like to contribute with your own translation, please contact <a href=mailto:ciprianmp@yahoo.com?subject=phpMyChat%20Plus%20translation onMouseOver=\"window.status='".sprintf(L_CLICK,L_LINKS_6,L_AUTHOR).".'; return true;\" title=\"".sprintf(L_CLICK,L_LINKS_6,L_AUTHOR)."\" target=_blank>Ciprian Murariu</a>.</P></CENTER>";
	else $NoTranslation = "<CENTER><P CLASS='RedText'>We are sorry but this tutorial has not been translated into the ".ucwords(str_replace("_"," ",$L))." language yet.<br />If you would like to contribute with your own translation, please contact <a href=mailto:ciprianmp@yahoo.com?subject=phpMyChat%20Plus%20translation onMouseOver=\"window.status='".sprintf(L_CLICK,L_AUTHOR,L_LINKS_6).".'; return true;\" title=\"".sprintf(L_CLICK,L_AUTHOR,L_LINKS_6)."\" target=_blank>Ciprian Murariu</a>.</P></CENTER>";
	unset($L);
	include("./localization/tutorial.lib.php");
};
require("./localization/${L}/localized.tutorial.php");
?>