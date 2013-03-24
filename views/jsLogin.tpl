<script type="text/javascript">
	window.addEvent('domready',function() {
										
	var error1 = 0;
	var error2 = 0;
	var error3 = 0;
		
	var status = {
		'true'  : 'close',
		'false' : 'open'
	};
		
	
	var AjaxRequest = function(element){
			
		new Request({
			method : 'post',
			url    : '{$Tlink}include/model/login_verif.php',
			data   : { 'input' : element.name,
					   'name'  : $('log-username').value, 
					   'pass'  : $('log-password').value,
					   'sa'   : $('sa').value},
			
			onComplete: function(res) {
				
				if (res.match('UsernameEmpty')){
					$('usernameCheck').set('html', '<div class="noticeLog">Username manquant</div>');
					$('loginCheck').set('html', '');
					error1 = 1;
				}
				
				if (res.match('PassEmpty')){
					$('passwordCheck').set('html', '<div class="noticeLog">Password manquant</div>');
					$('loginCheck').set('html', '');
					error2 = 1;
				}
				
				if (res.match('UsernameOk')){
					$('usernameCheck').set('html', '');
					$('loginCheck').set('html', '');
					error1 = 0;
				}
				
				if (res.match('PassOk')){
					$('passwordCheck').set('html', '');
					$('loginCheck').set('html', '');
					error2 = 0;
				}
				
				if (res.match('LoginFalse')){
					$('loginCheck').set('html', '<div class="noticeLog">Informations erron&eacute;es</div>');
					error3 = 1;
				}
				
				if (res.match('LoginOk')){
					location.reload(true);
					error3 = 0;
				}
				
				if(error1 == 1 || error2 == 1 || error3 == 1){
					$('flash_boxes').setStyles({
						display:'block'
					});
				} else {
					$('flash_boxes').setStyles({
						display:'none'
					});
				}
			}
		}).send();
	}
	
	$$('input.log_').each(function(element) {
														   
		if (element.name == 'log-submit'){
			element.addEvent('click', function(e){
				e.stop();
				AjaxRequest(element);
			});	
		}
								   
		element.addEvent('blur', function(){
			//AjaxRequest(element);
		});									   
	});

	if($('alreadyLog')){
		$('logoutLink').addEvent('click', function(e){
												   
			e.stop();
			
			new Request({
				method : 'post',
				url    : '{$Tlink}include/model/login_verif.php',
				data   : { 'mode' : 'logout',
						   'sa'  : $('sa').value},
				
				onComplete: function(res) { 
					
					if (res.match('LogoutOK')){
						location.reload(true);
					}
				}
			}).send();
		});
	}
});
</script>
{$Scripts}