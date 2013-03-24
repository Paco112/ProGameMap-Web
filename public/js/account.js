	//<![CDATA[
	reg_error_no_name        = "You must enter a name longer than 3 characters and shorter than 26";
	reg_error_no_pass        = "The password section is incomplete";
	reg_error_pass_nm        = "The passwords do not match";
	reg_error_chars          = "The display name contains one or more of these illegal characters: [ ] | ; ,  &#036; &#92; &lt; &gt; &quot;";
	reg_error_captcha        = "The captcha is wrong";
	reg_error_taken          = "The display name is already in use by another member";
	reg_error_username_taken = "The username is already taken by another member";
	reg_error_username_none  = "The username must be between 3 and 26 characters";
	reg_error_email_missing  = "The email address section is not complete";
	reg_error_email_nm       = "The email addresses do not match";
	reg_error_email_taken    = "The email address is already in use by another member";
	reg_error_email_ban      = "The email address you used is not accepted by this board.  Please select a different email address.";
	reg_error_email_invalid  = "The email address you entered is invalid (ex: name@domain.com)<br /> or contains illegal characters: [ ] ; # &amp; ! * ' &quot; &lt; &gt; % ( ) { } ? &#092;";
	reg_error_dchars_only = "The display name can only contain these characters:  ";
	reg_error_uchars_only = "The username can only contain these characters:  ";
	//]]>
	
window.addEvent('domready',function() {
									
	function TLink()
	{
		return $('sa').title;
	}
									
	/* hide using opacity on page load 
	$('fb-modal').setStyles({
		opacity:0,
		display:'block'
	});
	
	$('bck').setStyles({
		opacity:0,
		display:'block'
	});
	
	$('fb-close').addEvent('click',function(e) { 
		$('fb-modal').fade('out'); 
		$('bck').setStyles({opacity:0});
	});
	
	window.addEvent('keypress',function(e) { 
		if(e.key == 'esc') { 
			$('fb-modal').fade('out'); 
			$('bck').setStyles({opacity:0});
		} 
	});
	
	$(document.body).addEvent('click',function(e) { 
		if($('fb-modal').get('opacity') == 1 && !e.target.getParent('.generic_dialog')) { 
			$('fb-modal').fade('out'); 
			$('bck').setStyles({opacity:0});
		} 
	});
	
	$('fb-trigger').addEvent('click',function() {
		
		$('bck').setStyles({
			opacity:0.3
		});
		
		$('fb-modal').fade('in');
	});*/
	
	/**$$('input.reg_').each(function(element) {
								   						   
		if (element.name == 'reg-submit'){
			element.addEvent('click', function(e){
				e.stop();
				new AjaxRequest(element);
			});	
		}
								   
		element.addEvent('blur', function(){
			new AjaxRequest(element);
		});									   
	});**/
	if($('reg-submit'))
	{
		$('reg-submit').addEvent('click', function(e){
			
			e.stop();
			$('reg-submit').disabled = true;
			//$('reg-submit').removeEvent();
			
			new Request({
				method : 'post',
				async: false,
				url    : TLink()+'include/model/account_verif.php',
				data   : { 'input'   : 'reg-submit',
						   'name'    : $('reg-name').value, 
						   'dname'   : $('reg-dname').value,
						   'pass'    : $('reg-password').value,
						   'pass2'   : $('reg-password-check').value,
						   'mail'    : $('reg-emailaddress').value,
						   'mail2'   : $('reg-emailaddress-two').value,
						   'captcha' : $('reg-captcha').value,
						   'sa'      : $('sa').value},
						   
				onComplete: function(res) { 
					
					//sbox_view(res);
					
					if (res == 'InsertTrue'){
						
						MsgBox('Inscription Terminé !','<br /><br />Redirection vers la zone membre en cours..<br /><br /><img src="./../../public/images/loading.gif" alt="" /><br /><br /><br />','nobtn');
						
						$('reg-name').set('value', ''); 
						$('reg-dname').set('value', '');
						$('reg-password').set('value', '');
						$('reg-password-check').set('value', '');
						$('reg-emailaddress').set('value', '');
						$('reg-emailaddress-two').set('value', '');
						
						$('img-name').set('src', '');
						$('img-dname').set('src', '');
						$('img-password').set('src', '');
						$('img-emailaddress').set('src', '');
						
						$('reg-name').setStyle('border', '1px solid #9b9b9b');
						$('reg-dname').setStyle('border', '1px solid #9b9b9b');
						$('reg-password').setStyle('border', '1px solid #9b9b9b');
						$('reg-password-check').setStyle('border', '1px solid #9b9b9b');
						$('reg-emailaddress').setStyle('border', '1px solid #9b9b9b');
						$('reg-emailaddress-two').setStyle('border', '1px solid #9b9b9b');
												
						function Redirect(){
							window.location=TLink();
						}
						
						Redirect.delay(1500);
	
					}
					else
					{

						if (res.match('NameEmpty')){
							$('reg-name').setStyle('border', '1px solid #c00');
							$('msg-name').set('html', reg_error_username_none);
							$('box-name').setStyle('display','block');
							$('img-name').set('src', TLink()+'public/images/aff_cross.gif');
						}
							
						if (res.match('NameOK')){
							$('reg-name').setStyle('border', '1px solid #0c0');
							$('msg-name').set('html', '');
							$('box-name').setStyle('display','none');
							$('img-name').set('src', TLink()+'public/images/aff_tick.gif');						
						}
							
						if (res.match('NameTaken')){
							$('reg-name').setStyle('border', '1px solid #c00');
							$('msg-name').set('html', reg_error_username_taken);
							$('box-name').setStyle('display','block');
							$('img-name').set('src', TLink()+'public/images/aff_cross.gif');						
						}
							
						if (res.match('DName2Empty')){
							$('reg-dname').setStyle('border', '1px solid #c00');
							$('msg-dname').set('html', reg_error_no_name);
							$('box-dname').setStyle('display','block');
							$('img-dname').set('src', TLink()+'public/images/aff_cross.gif');						
						}
							
						if (res.match('DName2OK')){
							$('reg-dname').setStyle('border', '1px solid #0c0');
							$('msg-dname').set('html', '');
							$('box-dname').setStyle('display','none');
							$('img-dname').set('src', TLink()+'public/images/aff_tick.gif');						
						}
							
						if (res.match('DName2Taken')){
							$('reg-dname').setStyle('border', '1px solid #c00');
							$('msg-dname').set('html', reg_error_taken);
							$('box-dname').setStyle('display','block');
							$('img-dname').set('src', TLink()+'public/images/aff_cross.gif');						
						}
							
						if (res.match('PassEmpty')){
							$('reg-password').setStyle('border', '1px solid #c00');
							$('reg-password-check').setStyle('border', '1px solid #c00');
							$('msg-password').set('html', reg_error_no_pass);
							$('box-password').setStyle('display','block');
							$('img-password').set('src', TLink()+'public/images/aff_cross.gif');						
						}
							
						if (res.match('PassNegal')){
							$('reg-password').setStyle('border', '1px solid #c00');
							$('reg-password-check').setStyle('border', '1px solid #c00');
							$('msg-password').set('html', reg_error_pass_nm);
							$('box-password').setStyle('display','block');
							$('img-password').set('src', TLink()+'public/images/aff_cross.gif');						
						}
							
						if (res.match('PassOK')){
							$('reg-password').setStyle('border', '1px solid #0c0');
							$('reg-password-check').setStyle('border', '1px solid #0c0');
							$('msg-password').set('html', '');
							$('box-password').setStyle('display','none');
							$('img-password').set('src', TLink()+'public/images/aff_tick.gif');						
						}
							
						if (res.match('MailEmpty')){
							$('reg-emailaddress').setStyle('border', '1px solid #c00');
							$('reg-emailaddress-two').setStyle('border', '1px solid #c00');
							$('msg-emailaddress').set('html', reg_error_email_missing);
							$('box-emailaddress').setStyle('display','block');
							$('img-emailaddress').set('src', TLink()+'public/images/aff_cross.gif');						
						}
							
						if (res.match('MailNegal')){
							$('reg-emailaddress').setStyle('border', '1px solid #c00');
							$('reg-emailaddress-two').setStyle('border', '1px solid #c00');
							$('msg-emailaddress').set('html', reg_error_email_nm);
							$('box-emailaddress').setStyle('display','block');
							$('img-emailaddress').set('src', TLink()+'public/images/aff_cross.gif');						
						}
							
						if (res.match('MailTaken')){
							$('reg-emailaddress').setStyle('border', '1px solid #c00');
							$('reg-emailaddress-two').setStyle('border', '1px solid #c00');
							$('msg-emailaddress').set('html', reg_error_email_taken);
							$('box-emailaddress').setStyle('display','block');
							$('img-emailaddress').set('src', TLink()+'public/images/aff_cross.gif');						
						}
							
						if (res.match('MailOK')){
							$('reg-emailaddress').setStyle('border', '1px solid #0c0');
							$('reg-emailaddress-two').setStyle('border', '1px solid #0c0');
							$('msg-emailaddress').set('html', '');
							$('box-emailaddress').setStyle('display','none');
							$('img-emailaddress').set('src', TLink()+'public/images/aff_tick.gif');						
						}
						
						if (res.match('CaptchaFalse')){
							$('reg-captcha').setStyle('border', '1px solid #c00');
							$('msg-captcha').set('html', reg_error_captcha);
							$('box-captcha').setStyle('display','block');
							$('img-captcha').set('src', TLink()+'public/images/aff_cross.gif');						
						}
						
						if (res.match('CaptchaOK')){
							$('reg-captcha').setStyle('border', '1px solid #0c0');
							$('msg-captcha').set('html', '');
							$('box-captcha').setStyle('display','none');
							$('img-captcha').set('src', TLink()+'public/images/aff_tick.gif');						
						}
						
						function ReArm()
						{
							$('reg-submit').disabled = false;
						}
						
						ReArm.delay(1000);						
					}
				}
			}).send();
			
		});
	}
});