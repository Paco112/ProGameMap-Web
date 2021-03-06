<?php
// Connections Panel (lurking&online) by Ciprian Murariu <ciprianmp@yahoo.com>.
// This sheet is diplayed when the admin wants to watch what is currently going on in the chat

if ($_SESSION["adminlogged"] != "1") exit(); // added by Bob Dickow for security.
require("localization/".$L."/localized.chat.php");

// HTML link to launch the chat (used by constants below)
$ShowPrivate = "1";     // 1 to display users even if they are in a private room,
						// 0 else

$DisplayUsers = "1";    // 0 to display only the number of connected users
                        // 1 to display a list of users

function special_char($str,$lang)
{
	return ($lang ? htmlentities(stripslashes($str)) : htmlspecialchars(stripslashes($str)));
}

function display_connected($Private,$Full,$String1,$String2)
{
	$List = "";

	if ($Private)
	{
		$query = "SELECT DISTINCT username, latin1, room, r_time, ip FROM ".C_USR_TBL;
	}
	else
	{
		if ($sort_order == "1")	$ordquery = "username";
		else $ordquery = "r_time";
		$query = "SELECT DISTINCT u.username, u.latin1, u.room, u.r_time, u.ip FROM ".C_USR_TBL." u, ".C_MSG_TBL." m WHERE u.room = m.room AND m.type = 1 ORDER BY ".$ordquery."";
	}

	$DbLink = new DB;
	$DbLink->query($query);
	$NbUsers = $DbLink->num_rows();

	if ($NbUsers == 1)
	{
		if ($Full)
		{
			echo($String1."<br />");
			while(list($User,$Latin1,$Room,$RTime,$IP) = $DbLink->next_record())
			{
				if ($Latin1) $User = htmlentities($User);
				$RTime = date("d-M, H:i:s", $RTime + C_TMZ_OFFSET*60*60);
				$List .= ($List == "" ? "<tr><td>".$User."</td><td>".$Room."</td><td>".L_LURKING_4." ".$RTime."</td><td>".$IP."": "<tr><td>".$User."</td><td>".$Room."</td><td>".L_LURKING_4." ".$RTime."</td><td>".$IP."");
			}
			echo($List);
		}
		else
		{
			echo($NbUsers." ".$String1);
		}
	}
	elseif ($NbUsers > 1)
	{
		if ($Full)
		{
			echo($NbUsers." ".NB_USERS_IN."<br />");
			while(list($User,$Latin1,$Room,$RTime,$IP) = $DbLink->next_record())
			{
				if ($Latin1) $User = htmlentities($User);
				$RTime = date("d-M, H:i:s", $RTime + C_TMZ_OFFSET*60*60);
				$List .= ($List == "" ? "<tr><td>".$User."</td><td>".$Room."</td><td>".L_LURKING_4." ".$RTime."</td><td>".$IP."": "<tr><td>".$User."</td><td>".$Room."</td><td>".L_LURKING_4." ".$RTime."</td><td>".$IP."");
			}
			echo($List);
		}
		else
		{
			echo($NbUsers." ".$String1);
		}
	}
	else
	{
		echo($String2);
	}

	$DbLink->clean_results();
}

// ** Get messages **

// Define the SQL query (depends on values for ignored users list and on whether to display
// notification messages or not

$CondForQuery	= "(address = ' *' OR (room = '*' AND username NOT LIKE 'SYS %') OR (username NOT LIKE 'SYS %' AND username != '".C_QUOTE_NAME."') OR (address != '' AND (username = 'SYS room' OR username = 'SYS image' OR username LIKE 'SYS top%' OR username = 'SYS dice1' OR username = 'SYS dice2' OR username = 'SYS dice3')))";

$DbLink = new DB;
$DbLink->query("SELECT m_time, room, username, latin1, address, message FROM ".C_MSG_TBL." WHERE ".$CondForQuery." ORDER BY m_time DESC");

// Format and display new messages
if($DbLink->num_rows() > 0)
{
	$MessagesString = "";
	while(list($Time, $Room, $User, $Latin1, $Dest, $Message) = $DbLink->next_record())
	{
		$Message = stripslashes($Message);
		if ($Room == '*') $Room = L_ROOM_ALL;
		if ($L!="turkish") $Message = eregi_replace('target="_blank"></a>','title="'.sprintf(L_CLICKS,L_LINKS_15,L_LINKS_1).'" onMouseOver="window.status=\''.sprintf(L_CLICKS,L_LINKS_15,L_LINKS_1).'.\'; return true" target="_blank">'.sprintf(L_CLICKS,L_LINKS_15,L_LINKS_1).'</a>',$Message);
		else $Message = eregi_replace('target="_blank"></a>','title="'.sprintf(L_CLICKS,L_LINKS_1,L_LINKS_15).'" onMouseOver="window.status=\''.sprintf(L_CLICKS,L_LINKS_1,L_LINKS_15).'.\'; return true" target="_blank">'.sprintf(L_CLICKS,L_LINKS_1,L_LINKS_15).'</a>',$Message);
		$Message = eregi_replace('alt="Send email">','title="'.sprintf(L_CLICK,L_EMAIL_1).'" onMouseOver="window.status=\''.sprintf(L_CLICK,L_EMAIL_1).'.\'; return true">',$Message);
		$NewMsg = "<tr align=texttop valign=top>";
		$NewMsg .= "<td width=1% nowrap=\"nowrap\">".date("d-M, H:i:s", $Time + C_TMZ_OFFSET*60*60)."</td><td width=1% nowrap=\"nowrap\">&nbsp;".$Room."</td>";
		if ($Dest != " *" && $User != "SYS room" && $User != "SYS image" && $User != "SYS topic" && $User != "SYS topic reset" && substr($User,0,8) != "SYS dice")
		{
			$User = special_char($User,$Latin1);
			if ($Dest != "") $Dest = "]>[".htmlspecialchars(stripslashes($Dest));
			$NewMsg .= "<td width=1% nowrap=\"nowrap\"><B>[${User}${Dest}]</B></td><td>$Message</td>";
		}
		if ($User == "SYS image")
		{
      $NewMsg .= "<td width=1% nowrap=\"nowrap\"><B>[${Dest}]</B></td><td><FONT class=\"notify\">".L_PIC."</FONT> <A href=".$Message." onMouseOver=\"window.status='".sprintf(L_CLICK,L_FULLSIZE_PIC).".'; return true\" title=\"".sprintf(L_CLICK,L_FULLSIZE_PIC)."\" target=_blank>".$Message."</A></td>";
		}
		if ($User == "SYS announce")
		{
			if ($Message == 'L_RELOAD_CHAT') $Message = L_RELOAD_CHAT;
			$NewMsg .= "<td colspan=2><SPAN CLASS=\"notify2\">[".L_ANNOUNCE."] $Message</SPAN></td>";
		}
		if ($User == "SYS room")
		{
 			$NewMsg .= "<td  width=1% nowrap=\"nowrap\"><B>[${Dest}]</B></td><td><FONT class=\"notify2\"><I>".ROOM_SAYS."<FONT class=\"notify\">".$Message."</FONT></FONT></I></td>";
    }
		if ($User == "SYS topic")
		{
 			$NewMsg .= "<td colspan=2><FONT class=\"notify\">".$Dest." ".L_TOPIC." ".$Message."</FONT></td>";
		}
		if ($User == "SYS topic reset")
		{
 			$NewMsg .= "<td colspan=2><FONT class=\"notify\">".$Dest." ".L_TOPIC_RESET." ".$Message."</FONT></td>";
		}
		if (substr($User,0,8) == "SYS dice")
		{
 			$NewMsg .= "<td colspan=2 valign=\"top\"><FONT class=\"notify\">".$Dest." ".DICE_RESULTS."</FONT> ".$Message."</td>";
		}

		// Separator between messages sent before today and other ones
		if (!isset($day_separator) && date("j", $Time +  C_TMZ_OFFSET*60*60) != date("j", time() +  C_TMZ_OFFSET*60*60))
		{
			$day_separator = "<td colspan=4 align=center style=\"background-color:yellow;\"><SPAN CLASS=\"notify\">--------- ".(!$O ? L_TODAY_UP : L_TODAY_DWN)." ---------</SPAN></td>";
		};

			$MessagesString .= ((isset($day_separator) && $day_separator != "") ? $day_separator."" : "").$NewMsg."</tr>";
			if (isset($day_separator)) $day_separator = "";		// Today separator already printed
	};
}
else
{
	$MessagesString = "<td colspan=4 align=center style=\"background-color:yellow;\"><SPAN CLASS=\"notify\">".L_NO_MSG."</SPAN></td>";
};


$DbLink->clean_results();
$DbLink->close();
$CleanUsrTbl = 1;

?>
<P CLASS=title><?php echo(APP_NAME."  ".A_LURKING_1) ; ?></P>
</CENTER>
<?
if (!C_CHAT_LURKING)
{
?>
<P CLASS=mainframe><A NAME="full"><?php echo (A_LURKING_2) ; ?></P>
</CENTER>
<?
}
?>
<META HTTP-EQUIV="Refresh" CONTENT="30">
<hr />
<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=1 CLASS="table">
<TR>
	<TD ALIGN=CENTER colspan=4>
		<?php
		display_connected($ShowPrivate,$DisplayUsers,($DisplayUsers ? USERS_LOGIN : NB_USERS_IN),NO_USER);
		?>
	</TD>
</TR>
</TABLE>
<?php
if (C_CHAT_LURKING)
{
//Declaration of Parameters
$time = time();
$ip = getenv(REMOTE_ADDR);
$browser = getenv(HTTP_USER_AGENT);

//Timeout to delete Users in Seconds
$closetime = $time-15;

//Database-Connect
$handler = @mysql_connect(C_DB_HOST,C_DB_USER,C_DB_PASS);
@mysql_select_db(C_DB_NAME,$handler);

//Database-Commands
$delete = @mysql_query("DELETE FROM ".C_LRK_TBL." WHERE time<'$closetime'",$handler);
$result = @mysql_query("SELECT DISTINCT ip,browser,username FROM ".C_LRK_TBL." ORDER BY ip ASC",$handler);
$online_users = @mysql_numrows($result);
@mysql_close();
?>
<hr /><table border=1 cellspacing=1 cellpadding=1 class="table">
<tr>
	<td><?php echo(L_CUR_5)?></td>
	<td align="center" style="vertical-align:middle">
	<font size="4" color="#6666ff"><b>&nbsp <?php echo($online_users); ?> &nbsp</font></b></td>
	</tr></table>
<table border=1 width=98% cellspacing=0 cellpadding=1 class="table">
<?php
while($data = @mysql_fetch_array($result))
{
	if ($data[username] == "Guest") $data[username] = L_LURKING_5;
	echo("<tr><td>".$data[username]."</td>");
	echo("<td>".$data[ip]."</td>");
	echo("<td>".$data[browser]."</td></tr>");
}
?>
</table>
<?php
}
	echo("<center><hr />");
	echo("<table ALIGN=CENTER BORDER=1 WIDTH=98% CELLSPACING=0 CELLPADDING=1 CLASS=table>");
	echo("<tr>
<td VALIGN=CENTER ALIGN=CENTER><b>".A_POST_TIME."</b></td>
<td VALIGN=CENTER ALIGN=CENTER><b>".A_CHTEX_ROOM."</b></td>
<td VALIGN=CENTER ALIGN=CENTER><b>".A_FROM_TO."</b></td>
<td VALIGN=CENTER ALIGN=CENTER><b>".A_CHTEX_MSG."</b></td>
</tr>");
	echo($MessagesString."</table><br />");
	unset($MessagesString);
?>