// taille de la barre de progression en px
var W_BAR = 385;
var EVENT;
var progress_t = new Element('div', {id: 'progress_t'});
var progress_c = new Element('div', {id: 'progress_c'});
var progress_bar = new Element('div', {id: 'progress_bar'});
var progress_i = new Element('div', {id: 'progress_i'});

function CheckForm() {	
	if( ( ($('game').value == "other" && $('game_other').value != "") || ($('game').value != "other") ) && $('name').value != "" && $('file').value != "" && (  $('size_map_0').checked || $('size_map_1').checked || $('size_map_2').checked) )
	{
		// on verifie l'extension du fichier
		if($('file').value.search(/\.zip$/i) == -1)
		{
			MsgBox('Erreur','Veuillez choisir un fichier au format ZIP !');
		}
		else
		{
			MsgBox('Upload','Voulez vous debuter l\'envoie de votre fichier ?<br /><br />Veuillez ne pas quitter cette page durant cette etape qui peut durer plusieurs minutes !','yesno','onProgessUp',false,true);
		}
	}
	else
	{
		MsgBox('Erreur','Veuillez remplir tous les champs obligatoire !');
	}
}

function onProgessUp(btn)
{
	if(btn == "yes")
	{
		$('form_upload').submit();
		// on lance une requete ajax dui check regulièrement la taille
		MsgBox('Veuillez Patienter','','up','',false,true);
		
		progress_t.set('html','Upload en cours ...');		
		progress_c.setStyles({'background-image':'url(\''+$('sa').title+'/public/images/vistabg.gif\')',
							'width' : '385px',
							'height' : '22px'});		
		progress_bar.setStyles({'background-image':'url(\''+$('sa').title+'/public/images/vista.gif\')',
							'width' : '0px',
							'height' : '22px',
							'float' : 'left'});
		progress_i.set('html','Temps restant : ');
				
		$('MsgBox_Msg').adopt(progress_t,progress_c,progress_i);
		progress_c.adopt(progress_bar);
		
		var objRep; var b_width; var time; var time_type; var f_size; var f_size_up; var f_size_type; var speed; var speed_type;
		
		var req = new Request.JSON({
			method: 'get',
			url: 'http://www.progamemap.com/include/model/addmap_get.php?id='+$('id_progress').value,
			//data: { 'id' : $('id_progress').value },
			initialDelay: 1000,
			delay: 1000,
			//limit: 15000,
			onComplete: function(objRep)
			{									
					//objRep=eval("("+rep+")");
					
				if(objRep.status == '1')
				{
					b_width = (objRep.bytes_uploaded/objRep.bytes_total) * W_BAR;
					time = objRep.est_sec;
					f_size = objRep.bytes_total;
					f_size_up = objRep.bytes_uploaded;
					speed = objRep.speed_average;
					
					if(time >= 60)
					{
						time = Math.round(time/60);
						time_type = " minutes";
					}
					else
					{
						time_type = " secondes";
					}
					
					if(f_size >= 1048576)
					{
						f_size = Math.round((f_size/1048576)*100) / 100;
						f_size_up = Math.round((f_size_up/1048576)*100) / 100;
						f_size_type = " Mo"
					}
					else
					{
						f_size = Math.round((f_size/1024)*100) / 100;
						f_size_up = Math.round((f_size_up/1024)*100) / 100;
						f_size_type = " Ko"
					}
					
					if(speed >= 1048576)
					{
						speed = Math.round((speed/1048576)*10) / 10;
						speed_type = " Mo/s"
					}
					else
					{
						speed = Math.round((speed/1024)*10) / 10;
						speed_type = " Ko/s"
					}
					
					//progress_bar.setStyle('width',b_width+'px');
					progress_bar.tween('width', b_width);
					progress_i.set('html','Temps restant : '+time+time_type+' - '+f_size_up+' sur '+f_size+f_size_type+' ('+speed+speed_type+')');
				}
				else
				{
					req.stopTimer();
					progress_t.set('html','Verification ...');
					progress_i.set('html',' ');
					setTimeout(CheckUpload,500);
				}
					
			}
		}).startTimer();
	}
	else
	{
		EndMsgBox();
	}
}

function CheckUpload()
{
	if($('uploadFrame').contentWindow.document.body.innerHTML != "")
	{
		UpRep=eval("("+$('uploadFrame').contentWindow.document.body.innerHTML+")");
		
		if(UpRep.error == '0')
		{
			progress_bar.tween('width', W_BAR);
			progress_t.set('html','Upload Terminee');
			location = document.location;
		}
		else
		{
			$('id_progress').value = $('id_progress').value + $('id_progress').value;
			sbox_view($('uploadFrame').contentWindow.document.body.innerHTML);
			MsgBox('Erreur !',UpRep.error);
		}
	}
	else
	{
		setTimeout('CheckUpload',500);
	}
}


window.addEvent('domready', function() { 
									 
	$('game_other').disabled = true;
	
	$('game').addEvent('change',function(){
		if(this.value == "other")
		{
			$('game_other').disabled = false;
			$('game_other').fade('in');
		}
		else
		{
			if(!$('game_other').disabled)
			{
				$('game_other').disabled = true;
				$('game_other').fade('out');
			}
		}
	});
	
	$('form_upload').addEvent('submit', function(e) {							 
		e.stop();
		EVENT = e;
		CheckForm();		
	});	
	//MsgBox('Veuillez Patientez','test');
});

