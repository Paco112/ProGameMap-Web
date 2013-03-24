window.addEvent('domready',function() {
		
	if($('alreadyLog')){
		$('logoutLink').addEvent('click', function(e){
												   
			e.stop();
			
			new Request({
				method : 'post',
				url    : 'http://www.progamemap.com/include/model/login_verif.php',
				data   : { 'mode' : 'logout', 'sa' : $('sa').value},
				onComplete: function(res) { 
										
					if (res.match('LogoutOK')){
						location.reload();
					}
					
					if (res.match('LogoutForumOK')){
						window.location='http://www.progamemap.com/forum/'+$('lo').value;
					}
				}
			}).send();
		});
	} else {
		$('logoutLink').addEvent('click', function(e){
												   
			e.stop();
			
			new Request({
				method : 'post',
				url    : 'http://www.progamemap.com/include/model/login_verif.php',
				data   : { 'mode' : 'logout', 'sa' : $('sa').value, 'lo' : $('lo').value},
				onComplete: function(res) { 
					
					$('lo').value.replace("amp;", "");
					
					if (res.match('LogoutForumOK')){
						window.location='http://www.progamemap.com/forum/'+$('lo').value;
					}
				}
			}).send();
		});
	}
	
});
