<?php
// Send Email panel
// This sheet is diplayed when the admin wants to send an e-mail to registered users
// Credit for it goes to Christian Hacker <c.hacker@dreamer-chat.de>

if ($_SESSION["adminlogged"] != "1") exit(); // added by Bob Dickow for security.

// The admin has required an action to be done
if (isset($FORM_SEND) && $FORM_SEND == 4)
{
	// Sending the mails when at least an user has been selected and subject and message have been filled
	if (count($SendTo) == 0) $SendTo = array();
	$SendToExtra = array();
	if (isset($emails) && $emails != "") $SendToExtra = explode(",",$emails);
	if ($emails != "") $SendTo = array_merge($SendTo,$SendToExtra);
	if (count($SendTo) > 0 && trim($subject) != "" && trim($message) != "")
	{
		if ($sign) $message .= "\n\n".$signature;
		include('mail4admin.lib.php');
		for (reset($SendTo); $mailTo=current($SendTo); next($SendTo))
		{
			$Send = send_email_admin($mailTo,$subject,$message);
			if (!$Send) break;
		};
		$Success = "<span style='background-color:white'><table border=1 width=70%><tr><td width=1%><b>".A_SHEET4_2."</b></td><td>".implode("; ",$SendTo)."</td></tr><tr><td width=1%><b>".A_SHEET4_4."</b></td><td>".$subject."</td></tr><tr><td width=1%><b>".A_SHEET4_5."</b></td><td>".str_replace("\n","<br />",$message)."</td></tr></table></span>";
		$Message = ($Send ? A_SHEET4_7.$Success : A_SHEET4_8);
		$MsgStyle = ($Send ? "success" : "error");
	}
	else
	{
		$Message = A_SHEET4_9;
		$MsgStyle = "error";
	};
};
?>

<P CLASS=title><?php echo(A_SHEET4_1); ?></P>

<?php
if (isset($Message) && $Message != "") echo("<P CLASS=\"$MsgStyle\">$Message</P><br />\n");
?>

<TABLE ALIGN=CENTER CLASS=table>

<?php
// Display an error message if the administrator doesn't complete required variables in 'mail4admin.lib.php'
if (isset($ReqVar) && $ReqVar == "1")
{
	?>
	<TR>
		<TD ALIGN=CENTER CLASS=error><?php echo(A_SHEET4_0); ?></TD>
	</TR>

	<?php
}
else
{
/*	// Ensure at least one registered user exist (except the administrator) before displaying the mail form
	$DbLink->query("SELECT COUNT(*) FROM ".C_REG_TBL." WHERE perms != 'admin' LIMIT 1");
	list($count_RegUsers) = $DbLink->next_record();
	$DbLink->clean_results();
	if ($count_RegUsers != 0)
	{*/
	?>
	<!-- Mail form -->
	<TR>
		<TD ALIGN=CENTER>
			<FORM ACTION="<?php echo("$From?$URLQueryBody"); ?>" METHOD="POST" AUTOCOMPLETE="" NAME="MailForm">
			<INPUT TYPE=hidden NAME="From" value="<?php echo($From); ?>">
			<INPUT TYPE=hidden NAME="pmc_username" value="<?php echo(htmlspecialchars(stripslashes($pmc_username))); ?>">
			<INPUT TYPE=hidden NAME="pmc_password" value="<?php echo($pmc_password); ?>">
			<INPUT TYPE=hidden NAME="FORM_SEND" value="4">
			<TABLE BORDER=0 CELLSPACING=2 WIDTH=100%>
			<TR>

				<!-- Addressees list -->
				<TD VALIGN=TOP>
				<TABLE BORDER=0 WIDTH=100%>
				<TR>
					<TD ALIGN=CENTER><?php echo(A_SHEET4_2); ?></TD>
				</TR>
				<TR>
					<TD ALIGN=CENTER>
						<SELECT NAME="SendTo[]" MULTIPLE SIZE=15>
						<?php
						$DbLink->query("SELECT username,email FROM ".C_REG_TBL." WHERE email != 'bot@bot.com' AND email != 'quote@quote.com' AND email != '' ORDER BY username");
						while (list($U,$EMail) = $DbLink->next_record())
						{
							echo("<OPTION VALUE=\"$EMail\">".$U." (".$EMail.")</OPTION>");
						}
						$DbLink->clean_results();
						?>
					</TD>
				</TR>
				<TR><TD>&nbsp;</TD></TR>
				<TR>
					<TD ALIGN=CENTER>
						<INPUT TYPE=button VALUE="<?php echo(A_SHEET4_3); ?>" onClick="for (var i = 0; i < document.forms['MailForm'].elements['SendTo[]'].options.length; i++) {document.forms['MailForm'].elements['SendTo[]'].options[i].selected=true;}">
						&nbsp;<INPUT TYPE=button VALUE="<?php echo(A_SHEET4_12); ?>" onClick="for (var i = 0; i < document.forms['MailForm'].elements['SendTo[]'].options.length; i++) {document.forms['MailForm'].elements['SendTo[]'].options[i].selected=false;}">
						</SELECT><br /><br /><?php echo(A_SHEET4_10); ?><br />
						<INPUT TYPE="text" NAME="emails" SIZE="45" MAXLENGTH="500" VALUE="">
					</TD>
				</TR>
				</TABLE>
				</TD>

				<TD></TD>

				<!-- Subject and message -->
				<TD>
				<TABLE BORDER=0 WIDTH=100%>
				<TR>
					<TD VALIGN=MIDDLE ALIGN="<?php echo($CellAlign); ?>"><?php echo(A_SHEET4_4); ?></TD>
					<TD VALIGN=MIDDLE ALIGN="<?php echo($CellAlign); ?>" COLSPAN=2>
						<INPUT TYPE="text" NAME="subject" SIZE="53" VALUE="<?php echo("[".((C_CHAT_NAME != "") ? C_CHAT_NAME : APP_NAME)."] - in the news"); ?>">
					</TD>
				</TR>
				<TR>
					<TD VALIGN=TOP ALIGN="<?php echo($CellAlign); ?>"><?php echo(A_SHEET4_5); ?></TD>
					<TD VALIGN=MIDDLE ALIGN=CENTER COLSPAN=2>
						<TEXTAREA NAME="message" WRAP="on" COLS="55" ROWS="14"></TEXTAREA>
					</TD>
				</TR>
				<TR><TD>&nbsp;</TD></TR>
				<TR>
					<TD VALIGN=MIDDLE ALIGN="<?php echo($InvCellAlign); ?>"><?php echo(A_SHEET4_11); ?>
				<input type="checkbox" name="sign" value="1" checked></TD>
				<TD VALIGN=MIDDLE ALIGN="<?php echo($CellAlign); ?>"><TEXTAREA NAME="signature" WRAP="on" COLS="35" ROWS="4"><?php echo("Best regards,\n".C_ADMIN_NAME."\n".C_CHAT_URL.""); ?></TEXTAREA>
					</TD>
					<TD VALIGN=BOTTOM ALIGN="<?php echo($InvCellAlign); ?>">
						<INPUT style="color:#ff0000; font-weight:800" TYPE="submit" NAME="submit_type" VALUE="<?php echo(A_SHEET4_6); ?>">
					</TD>
				</TR>
				</TABLE>
				</TD>
			</TR>
			</TABLE>
			</FORM>
		</TD>
	</TR>

	<?php
/*	}
	else
	{
	?>

	<TR>
		<TD ALIGN=CENTER CLASS=error><?php echo(A_SHEET1_8); ?></TD>
	</TR>

	<?php
	};*/
};
?>

</TABLE>

<?php
?>