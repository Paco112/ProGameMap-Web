<div id="menuCompte" style="margin-right:10px"><fieldset>
	<legend>Votre profil personnel, ces informations sont optionnelles</legend>
	<form action="{$linkForm}" method="post">
    <table width="100%" cellpadding="0" cellspacing="1">
		<tbody><tr>
			<td class="row1" style="padding: 6px;" width="30%">Votre date de naissance</td>
			<td class="row2" style="padding: 6px;" width="70%">
				<select name="day">
					{$optionsDay}
				</select> 
                <select name="month">
					<option value="0"{$selectedMois0}>--</option><option value="1"{$selectedMois1}>Janvier</option><option value="2"{$selectedMois2}>F&eacute;vrier</option><option value="3"{$selectedMois3}>Mars</option><option value="4"{$selectedMois4}>Avril</option><option value="5"{$selectedMois5}>Mai</option><option value="6"{$selectedMois6}>Juin</option><option value="7"{$selectedMois7}>Juillet</option><option value="8"{$selectedMois8}>Ao&ucirc;t</option><option value="9"{$selectedMois9}>Septembre</option><option value="10"{$selectedMois10}>Octobre</option><option value="11"{$selectedMois11}>Novembre</option><option value="12"{$selectedMois12}>D&eacute;cembre</option>

				</select>			
				<select name="year">
					{$optionsYear}
				</select>
			</td>
		</tr>
	
	<tr>
		<td class="row1" style="padding: 6px;" width="30%">Genre</td>
		<td class="row2" style="padding: 6px;" width="70%"><select class="select" name="gender">
			<option value="male"{$selectedMasculin}>Masculin</option>
			<option value="female"{$selectedFeminin}>F&eacute;minin</option>
			<option value="mystery"{$selectedNondefini}>Non d&eacute;fini</option>
			</select>
		</td>
	</tr>  
	<tr>
		<td class="row1" style="padding: 6px;" width="30%">Votre site Internet</td>
		<td class="row2" style="padding: 6px;" width="70%"><input size="40" maxlength="1200" name="WebSite" value="{$valUrl}" type="text"></td>
	</tr>  
	<tr>

		<td class="row1" style="padding: 6px;" width="30%">Votre num&eacute;ro d'ICQ</td>
		<td class="row2" style="padding: 6px;" width="70%"><input size="40" maxlength="20" name="ICQNumber" value="{$valICQ}" type="text"></td>
	</tr>
	<tr>
		<td class="row1" style="padding: 6px;" width="30%">Votre identit&eacute; MSN</td>
		<td class="row2" style="padding: 6px;" width="70%"><input size="40" maxlength="200" name="MSNName" value="{$valMSN}" type="text"></td>
	</tr>
	<tr>

		<td class="row1" style="padding: 6px;" width="30%">Votre localit&eacute;<br></td>
		<td class="row2" style="padding: 6px;" width="70%"><input size="40" name="Location" value="{$valLocation}" type="text"></td>
	</tr>
	<tr>
		<td class="row1" style="padding: 6px;" width="30%" valign="top">Vos centres d'int&eacute;r&ecirc;t<br></td>

		<td class="row2" style="padding: 6px;" width="70%"><textarea cols="60" rows="10" wrap="soft" name="Interests">{$valInter}</textarea></td>
	</tr>
	
	<tr>
		<td class="formbuttonrow" colspan="2" align="center"><div class="right gistsubmit">
<input type="submit"  value="Modifier" />
<span></span></div></td>
	</tr>
	</tbody></table>
    </form>
</fieldset></div>