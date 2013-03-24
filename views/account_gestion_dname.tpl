<div id="menuCompte" style="margin-right:10px"><fieldset>
	<legend>Changer le nom d'affichage</legend>
<p>{$nbrChangementsFaits}<br>Vous &ecirc;tes autoris&eacute; &agrave; faire 1 changement par p&eacute;riode de 30 jours.<br><br>Changer votre nom d'affichage <strong>n'affectera pas</strong> votre nom d'utilisateur utilis&eacute; pour vous connecter.</p>
{$error}
<form action="{$linkForm}" method="post">
<table class="ipbtable" cellspacing="0">
	<tbody><tr>

		<td><strong>Saisissez un nouveau nom d'affichage</strong><div class="desc">C'est le nom d'affichage que vous souhaitez utiliser maintenant.<br>Caract&egrave;res alphanum&eacute;riques uniquement.<br>
		
		Nb. de caract&egrave;res max.&nbsp;: 26</div></td>
        <td width="50px">&nbsp;</td>
		<td align="right"><input name="displayname"{$disabled1} id="displayname" maxlength="26" value="" type="text"></td>
	</tr>
    <tr><td>&nbsp;</td></tr>
	<tr>

		<td><strong>Saisissez votre mot de passe courant</strong><div class="desc">Afin d'assurer la s&eacute;curit&eacute; de votre compte.</div></td>
		<td width="50px">&nbsp;</td>
        <td align="right"><input name="displaypassword"{$disabled2} id="displaypassword" value="" type="password"></td>
	</tr>
</tbody></table>
<br /><br />
<div class="right gistsubmit">
<input type="submit"  value="Modifier" />
<span></span></div>
</form>
</fieldset>
</div>
