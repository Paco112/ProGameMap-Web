<div id="menuCompte" style="margin-right:10px"><fieldset>
	<legend>Changer votre adresse de courriel enregistr&eacute;e</legend>
<p>
	<strong>Votre adresse de courriel actuelle&nbsp;:</strong> {$email}
</p>
{$error}
<form action="{$linkForm}" method="post">
<table class="ipbtable" cellspacing="0">
	<tbody><tr>
		<td width="400px"><b>Saisissez votre nouvelle adresse de courriel</b></td>

		<td><input name="in_email_1" value="" type="text"></td>
	</tr>
	<tr>
		<td><b>Saisissez votre nouvelle adresse de courriel</b></td>
		<td><input name="in_email_2" value="" type="text"></td>
	</tr>
	<tr>
		<td><b>Votre mot de passe actuel</b></td>

		<td><input name="password" value="" type="password"></td>
	</tr>
</tbody></table><br /><br />
<div class="right gistsubmit">
<input type="submit"  value="Continuer" />
<span></span></div>
</form>
</fieldset></div>