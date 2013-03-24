window.addEvent('domready',function() {
	
	function TLink()
	{
		return $('sa').title;
	}
	
	var error1 = 0;
	var error2 = 0;
	var error3 = 0;
		
	var status = {
		'true'  : 'close',
		'false' : 'open'
	};		
	
	var insideBox = 1;
	
	if($('loginLinkBox')){
		$('LoginBox').setStyles({
			opacity:0,
			display:'block'
		});
		
		$(document.body).addEvent('click',function(e) {
			if($('LoginBox').get('opacity') == 1 && insideBox == 1) {
			   $('LoginBox').fade('out');
			   $('log-username').set('value', '');
			   $('log-password').set('value', '');
			   $('usernameCheck').set('html', '');
			   $('loginCheck').set('html', '');
			   $('passwordCheck').set('html', '');
			   $('flash_boxes').setStyles({
					display:'none'
			   });
			}
		});
		
		$('LoginBox').addEvent('mouseover',function(e) {
			insideBox = 0;
		});
		
		$('LoginBox').addEvent('mouseout',function(e) {
			insideBox = 1;
		});
		
		$('loginLinkBox').addEvent('click',function(e) {
			e.stop();										
			$('LoginBox').fade('in');
		});
	}
	
	$('log-submit').addEvent('click', function(e){
				e.stop();
				
				new Request({
					method : 'post',
					url    : 'http://www.progamemap.com/include/model/login_verif.php',
					data   : { 'input' : 'log-submit',
							   'name'  : $('log-username').value, 
							   'pass'  : $('log-password').value,
							   'sa'   : $('sa').value},
							   
					onRequest : function() { 
						$('log-submit').disabled = true;
						$('log-submit').set('value', 'Loading..');
					},
					
					onComplete: function(res) {
						
						$('log-submit').disabled = false;
						$('log-submit').set('value', '   Login   ');
						
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
							location.reload();
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
				
			});	
	/*
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
	*/
});
