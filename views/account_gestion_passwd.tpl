<div id="menuCompte" style="margin-right:10px"><fieldset>
	<legend>Votre mot de passe</legend>
<p>Vous pouvez changer votre mot de passe ici.<br><br>Nous tenterons de mettre &agrave; jour votre session actuelle une fois votre changement de mot de passe r&eacute;ussi. Si, toutefois, vous rencontrez des difficult&eacute;s, veuillez vous d&eacute;connecter puis vous reconnecter avant de contacter un membre de l'&eacute;quipe pour vous aider &agrave; r&eacute;soudre le probl&egrave;me.</p>
{$error}
<form action="{$linkForm}" method="post">
<table class="ipbtable" cellspacing="0">
	<tbody><tr>
		<td width="400px"><b>Saisissez votre mot de passe ACTUEL</b></td>
		<td><input name="current_pass" value="" type="password"></td>
	</tr>

	<tr>
		<td><b>Saisissez votre NOUVEAU mot de passe</b></td>
		<td><input name="new_pass_1" value="" type="password"></td>
	</tr>
	<tr>
		<td><b>Merci de confirmer votre NOUVEAU mot de passe</b></td>
		<td><input name="new_pass_2" value="" type="password"></td>
	</tr>

	<tr>
		<td class="formbuttonrow" colspan="2"><br /><div class="right gistsubmit">
<input type="submit"  value="Continuer" />
<span></span></div></td>
	</tr>
</tbody></table>
</form>
</fieldset></div>