<?php
// Get the names and values for vars sent to index.lib.php
if (isset($_GET))
{
	while(list($name,$value) = each($_GET))
	{
		$$name = $value;
	};
};
// Fix a security hole
if (isset($L) && !is_dir("./localization/".$L)) exit();
if (ereg("SELECT|UNION|INSERT|UPDATE",$_SERVER["QUERY_STRING"])) exit();  //added by Bob Dickow for extra security NB Kludge

if (isset($_COOKIE["CookieStatus"])) $statusu = $_COOKIE["CookieStatus"];
if (isset($_COOKIE["CookieRoom"]) && !isset($R)) $R = urldecode($_COOKIE["CookieRoom"]);
if (!isset($R)) $skin == "style1";

require("config/config.lib.php");
if (!isset($L) || $L == "") $L = C_LANGUAGE;
require("localization/".$L."/localized.chat.php");
include("localization/".$L."/localized.admin.php");
require("lib/release.lib.php");
include("lib/preg_find.php");

if (C_CHAT_LOGS && (C_SHOW_LOGS_USR || $statusu == "a" || $statusu == "t"))
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML dir="<?php echo(($Align == "right") ? "RTL" : "LTR"); ?>">
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; CHARSET=<?php echo($Charset); ?>">
<TITLE><?php echo(((C_CHAT_NAME != "") ? C_CHAT_NAME : APP_NAME)." - ".A_CHAT_LOGS_17) ; ?></TITLE>
<LINK REL="stylesheet" HREF="<?php echo($skin.".css.php?Charset=${Charset}&medium=${FontSize}&FontName=".urlencode($FontName)); ?>" TYPE="text/css">
</HEAD>

<BODY onLoad="window.status='Welcome to the Archive Page. These are only the public messages stored.';">
<CENTER>
<P CLASS=title><?php echo(((C_CHAT_NAME != "") ? C_CHAT_NAME : APP_NAME)." - ".A_CHAT_LOGS_17) ; ?></P>
</CENTER>
<?php
// Credit for this goes to Ciprian Murariu <ciprianmp@yahoo.com>.
$yu='./logs'; #define which year you want to read
$yrsu = preg_find('/./', $yu, PREG_FIND_DIRONLY|PREG_FIND_SORTKEYS|PREG_FIND_SORTDESC);
foreach($yrsu as $yru)
{
		$yeardiru = eregi_replace($yu."/",'',$yru);
		echo("<table BORDER=1 CELLSPACING=0 CELLPADDING=0 class=table><tr>");
		echo ("<td valign=top align=center nowrap=\"nowrap\" colspan=6><font size=4 color=red><b>$yeardiru</b></font></td>"); #print name of each file found
		$mu=$yu."/".$yeardiru; #define which month you want to read
		$mtsu = preg_find('/./', $mu, PREG_FIND_DIRONLY|PREG_FIND_RETURNASSOC|PREG_FIND_SORTMODIFIED|PREG_FIND_SORTKEYS|PREG_FIND_SORTDESC);
		foreach($mtsu as $mtu => $stats)
		{
			$monthdiru = eregi_replace($mu."/",'',$mtu);
				switch ($monthdiru)
				{
					case 'Jan':
					{
						$MONTHU = L_JAN;
					}
					break;
					case 'Feb':
					{
						$MONTHU = L_FEB;
					}
					break;
					case 'Mar':
					{
						$MONTHU = L_MAR;
					}
					break;
					case 'Apr':
					{
						$MONTHU = L_APR;
					}
					break;
					case 'May':
					{
						$MONTHU = L_MAY;
					}
					break;
					case 'Jun':
					{
						$MONTHU = L_JUN;
					}
					break;
					case 'Jul':
					{
						$MONTHU = L_JUL;
					}
					break;
					case 'Aug':
					{
						$MONTHU = L_AUG;
					}
					break;
					case 'Sep':
					{
						$MONTHU = L_SEP;
					}
					break;
					case 'Oct':
					{
						$MONTHU = L_OCT;
					}
					break;
					case 'Nov':
					{
						$MONTHU = L_NOV;
					}
					break;
					case 'Dec':
					{
						$MONTHU = L_DEC;
					}
					break;
				}
				$MONTHU .= " ".$yeardiru;
					echo("<tr>");
					echo ("<td valign=top align=left nowrap=\"nowrap\" colspan=6><font size=4 color=green><b>$MONTHU</b></font></td>"); #print name of each file found
					echo ("<tr><td valign=top align=left nowrap=\"nowrap\">");
			$du=$yru."/".$monthdiru; #define which month you want to read
			$dayu = opendir($du); #open directory
			while (false !== ($dyu = readdir($dayu)))
			{
				if (!eregi("\.html",$dyu) && $dyu!=='.' && $dyu!=='..')
				{
					$dayarrayu[]=$dyu;
		 		}
		 	}
			closedir($dayu);
		  if ($dayarrayu)
		  {
				sort($dayarrayu);
				$j=1;
				echo("<ul>");
			  foreach ($dayarrayu as $dyu)
			  {
					if (eregi(".\htm",$dyu)) $dyhtmu=str_replace(".htm","",$dyu);
					else $dyhtmu=str_replace(".php","",$dyu);
					$dyhtmu=str_replace($yeardiru.$monthdiru,"",$dyhtmu);
					echo ("<li>&nbsp;&middot;&nbsp;<a href=$du/$dyu?L=$L onMouseOver=\"window.status='".sprintf(A_CHAT_LOGS_16,$dyhtmu." ".$MONTHU)."'; return true;\" title='".sprintf(A_CHAT_LOGS_16,$dyhtmu." ".$MONTHU)."'>$dyhtmu</a> (".filesize($du."/".$dyu)." bytes)<br />\n"); #print name of each file found
					if ($j==5 || $j==10 || $j==15 || $j==20 || $j==25) echo ("</ul><td valign=top align=left nowrap=\"nowrap\"><ul>");
					$j++;
				}
				echo("<ul>");
			}
			unset($dayarrayu);
			echo("</tr>");
			}
		echo("</td></tr></table><br />");
}
?>
<P align="right"><div align="right"><span dir="LTR" style="font-weight: 600; color:#FFD700; font-size: 7pt">
&copy; 2005-<?php echo(date(Y)); ?> - by <a href="mailto:ciprianmp@yahoo.com?subject=phpMychat%20Plus%20feedback" onMouseOver="window.status='<?php echo (($L!="turkish") ? sprintf(L_CLICKS,L_LINKS_6,L_AUTHOR) : sprintf(L_CLICKS,L_AUTHOR,L_LINKS_6)); ?>.'; return true;" title="<?php echo (($L!="turkish") ? sprintf(L_CLICKS,L_LINKS_6,L_AUTHOR) : sprintf(L_CLICKS,L_AUTHOR,L_LINKS_6)); ?>" target=_blank>Ciprian Murariu</a></span></div></P>
</BODY>
</HTML>
<?php
exit();
}
else
{
?>
<html>
<head>
<title>Invalid address - Logging feature disabled</title>
<meta http-equiv="Content-Type" content="text/html; charset=${Charset}">
<LINK REL="stylesheet" HREF="<?php echo($skin.".css.php?Charset=${Charset}&medium=${FontSize}&FontName=".urlencode($FontName)); ?>" TYPE="text/css">
</head>

<body class="frame">
<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><center><font size="+2"><b>You don't have access to this file.<br />Logging feature has been disabled<br />Press <a href=./>here</a> to go to the index page or just wait...</b><font>
<br /><br /><br /><br />Hacking attempt! Redirection to the index page in 5 seconds.</center>
<meta http-equiv="refresh" content="5; url=./">
</body>
</html>
<?php
exit();
}
?>