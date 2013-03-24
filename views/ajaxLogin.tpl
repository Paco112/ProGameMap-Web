<script type='text/javascript'>
window.addEvent('domready',function() {
	
	var status = {
		'true'  : 'close',
		'false' : 'open'
	};
	
	//$('log_error1').slide('hide');
	//$('log_error2').slide('hide');
	//$('log_error3').slide('hide');
	//$('log_error4').slide('hide');
	
	/**var IsSession = new Class({
							
		initialize: function(){
		
			new Request({
				method : 'post',
				url    : 'http://www.progamemap.com/include/model/login_verif.php',
				data   : { 'ajax' : 'login',
						   'mode' : 'testSession' },
				
				onComplete: function(res) { 
					$('zonemembreinfos').set('html', res);
				}
			}).send();
		}
	});
	
	new IsSession();**/
	
	var error = false;
	var error2 = false;
	var error3 = false;

	var AjaxRequest = new Class({
							
		  initialize: function(element){
			
			new Request({
				method : 'post',
				url    : 'http://www.progamemap.com/include/model/login_verif.php',
				data   : { 'input' : element.name,
						   'name'  : $('log-username').value, 
						   'pass'  : $('log-password').value},
				
				onComplete: function(res) { 
					
					if (res.match('UsernameEmpty')){
						$('log_error1').slide('in');
						error = true;
						error2 = false;
						error3 = false;
					}
					
					if (res.match('PassEmpty')){
						$('log_error2').slide('in');
						error = true;
						error2 = false;
						error3 = false;
					}
					
					if (res.match('UsernameOk')){
						$('log_error1').slide('out');
						error2 = true;
					}
					
					if (res.match('PassOk')){
						$('log_error2').slide('out');
						error3 = true;
					}
					
					if (res.match('LoginFalse')){
						$('log_error3').slide('in');
						error = true;
						error2 = false;
						error3 = false;
					}
					
					if (res.match('LoginOk')){
						$('log_error1').slide('out');
						$('log_error2').slide('out');
						$('log_error3').slide('out');
						error = false;
						
						var myFx = new Fx.Slide('zonemembreinfos', {
							mode: 'horizontal',
							//Due to inheritance, all the [Fx][] options are available.
							onComplete: function(){
								$('zonemembreinfos').set('html', '$showMembre');
								$('zonemembreinfos').slide('in');
							}
						//The mode argument provided to slideOut overrides the option set.
						}).slideOut('vertical');

						/**new Request({
							url    : 'http://www.progamemap.com/include/model/display_zoneMembre.php',
							onProcess: $('zonemembreinfos').set('html', res),
							onComplete: function(res) {
								$('zonemembreinfos').slide('in');
							}
						});**/
						
					}
					
					if (error == true){
						$('log_error4').slide('in');
					} else {
						$('log_error4').slide('out');
					}
					
					if(error2 == true){
						if(error3 == true){
							$('log_error4').slide('out');
						}
					}
					
				}
			}).send();
		}
	});
	
	$$('input.log_').each(function(element) {
														   
		if (element.name == 'log-submit'){
			element.addEvent('click', function(e){
				e.stop();
				new AjaxRequest(element);
			});	
		}
								   
		element.addEvent('blur', function(){
			new AjaxRequest(element);
		});									   
	});
	
	if($('log-logout'))
	{
		$('log-logout').addEvent('click', function(e){
			e.stop();
			
			new Request({
				method : 'post',
				url    : 'http://www.progamemap.com/include/model/login_verif.php',
				data   : { 'mode' : 'logout' },
				
				onComplete: function() { 
					location.reload(true);
				}
			}).send();
		});
	}
	
});
</script>
{$Scripts}