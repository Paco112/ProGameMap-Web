window.addEvent('domready',function() {
	var disabled = 1;
	$('checkMail').addEvent('click', function(e){
		if(disabled == 1){
			$('userMail').disabled = false;
			disabled = 0;
		} else {
			$('userMail').disabled = true;
			disabled = 1;
		}
	});
	
	$('btnSubmit').addEvent('click', function(e){
			e.stop();
			
			new Request({
				method : 'post',
				url    : 'http://www.progamemap.com/include/model/contact_verif.php',
				data   : { 'mail'  		: $('userMail').value, 
						   'object'  	: $('object').value,
						   'message'  	: $('message').value,
						   'sa'   		: $('sa').value,
						   'userIP'		: $('userIP').value},
						   
				onRequest : function() { 
					$('btnSubmit').disabled = true;
				},
				
				onComplete: function(res) {
										
					if (res == "InsertTrue")
					{
						MsgBox('Termin&eacute;', 'Votre message a bien &eacute;t&eacute; envoy&eacute;', 'nobtn');
										
						function Redirect(){
							<!--
							window.location="http://www.progamemap.com/";
							//-->
						}
						
						Redirect.delay(2000);
					}					
					else if (res == "InsertFalse")
					{
						MsgBox('Erreur', "Erreur durant l'envoi.");
						$('btnSubmit').disabled = false;
					}
					else 
					{
						if (res.match('FalseMail') || res.match('EmptyMail'))
						{
							$('userMail').setStyle('border', '1px solid #c00');
						}
						else
						{
							$('userMail').setStyle('border', '');
						}
						
						
						if (res.match('EmptyObject'))
						{
							$('object').setStyle('border', '1px solid #c00');
						}
						else
						{
							$('object').setStyle('border', '');
						}
						
						if (res.match('EmptyMsg'))
						{
							$('message').setStyle('border', '1px solid #c00');
						}
						else
						{
							$('message').setStyle('border', '');
						}
						$('btnSubmit').disabled = false;
					}
				}
			}).send();
			
		});	
});
