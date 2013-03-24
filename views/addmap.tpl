<script type="text/javascript">
	window.addEvent('domready', function(){
		// Use defaults: no limit, use default element name suffix, don't remove path from file name
		new MultiUpload( $( 'main_form' ).defaults );
		// Max 3 files, use '[{id}]' as element name suffix, remove path from file name, remove extra elemen
		new MultiUpload( $( 'main_form' ).use_settings, 3, '[{id}]', true, true );
	});
</script>
<div id="menuCompte" style="margin-right:10px">
<fieldset>
<legend>Formulaire d'ajout de Map</legend>
<form action="{$linkForm}" method="post"  enctype="multipart/form-data" id="form-demo">
<table width="100%" cellpadding="0" cellspacing="1">
  <tbody>
    <tr>
      <td class="row1" style="padding: 6px;" width="30%">Nom de la map</td>
      <td class="row2" style="padding: 6px;" width="70%"><input size="40" maxlength="1200" name="name" type="text"></td>
    </tr>
    <tr>
      <td class="row1" style="padding: 6px;" width="30%">Auteur</td>
      <td class="row2" style="padding: 6px;" width="70%"><input size="40" maxlength="1200" name="auteur" type="text"></td>
    </tr>
    <tr>
      <td class="row1" style="padding: 6px;" width="30%" valign="top">Description</td>
      <td class="row2" style="padding: 6px;" width="70%"><textarea cols="60" rows="10" wrap="soft" name="description"></textarea></td>
    </tr>
    <tr>
      <td class="row1" style="padding: 6px;" width="30%" valign="top">Screens</td>
      <td class="row2" style="padding: 6px;" width="70%">
 
	<fieldset id="demo-fallback">
		<legend>File Upload</legend>
		<p>
			This form is just an example fallback for the unobtrusive behaviour of FancyUpload.
			If this part is not changed, something must be wrong with your code.
		</p>
		<label for="demo-photoupload">
			Upload a Photo:
			<input type="file" name="Filedata" />

		</label>
	</fieldset>
 
	<div id="demo-status" class="hide">
		<p>
			<a href="#" id="demo-browse">Browse Files</a> |
			<a href="#" id="demo-clear">Clear List</a> |
			<a href="#" id="demo-upload">Start Upload</a>

		</p>
		<div>
			<strong class="overall-title"></strong><br />
			<img src="assets/progress-bar/bar.gif" class="progress overall-progress" />
		</div>
		<div>
			<strong class="current-title"></strong><br />
			<img src="assets/progress-bar/bar.gif" class="progress current-progress" />
		</div>

		<div class="current-text"></div>
	</div>
 
	<ul id="demo-list"></ul>
	</td>
    </tr>
    <tr>
      <td class="row1" style="padding: 6px;" width="30%" valign="top">Archive</td>
      <td class="row2" style="padding: 6px;" width="70%"><input type="file" name="defaults">
        <br clear="all"/>
        <br/></td>
    </tr>
    <tr>
      <td class="formbuttonrow" colspan="2" align="center"><div class="right gistsubmit">
          <input type="submit"  value="Soumettre" />
          <span></span></div></td>
    </tr>
  </tbody>
</table>
</fieldset>
</div>
