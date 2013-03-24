window.addEvent('domready',function() {
	
	$('clickPack').addEvent('click', function(e){
		$('aboutMe').setStyle('display', 'none');
		$('myPack').setStyle('display', 'block');
	});
	
	$('clickAbout').addEvent('click', function(e){
		$('aboutMe').setStyle('display', 'block');
		$('myPack').setStyle('display', 'none');
	});
	
	$$('img.n_etoile').each(function(element7) {
        element7.addEvent('mouseover',function(){
			var id = element7.id.split('_');
					
			if($('NOVOTE_'+id[1]).value != '1')
			{
				for(i=1;i<=5;i++)
				{
					if(i <= id[2])
					{
						$('e_'+id[1]+'_'+i).src = "http://www.progamemap.com/public/images/Etoile_ON.png";
					}
					else
					{
						$('e_'+id[1]+'_'+i).src = "http://www.progamemap.com/public/images/Etoile_OFF.png";
					}
					
				}
			}
		});
		element7.addEvent('click',function(){
			
			var id = element7.id.split('_');
			
			if($('NOVOTE_'+id[1]).value != '1')
			{
				var pack = 1;
											
				var req = new Request({
				// choix de la methode get ou post
				method: 'post',
				// url de la requete
				url: 'http://www.progamemap.com/include/model/setup_panier.php',
				// les paramètre post :
				data: { 'game' : $('GAME_'+id[1]).value, 'note' : id[2], 'add' : id[1], 'sa' : $('sa').value , 'pack' : pack},
				
				onComplete: function(rep) 
							{ 
								sbox_view(rep);
								if(rep.match("Please Login !"))
								{
									alert(rep);
									element7.disabled = false;
								}
								else if(rep.match(":OK:"))
								{
									$('NOVOTE_'+id[1]).value = '1';
									$('NB_'+id[1]).value++;
									$('VAL_'+id[1]).value = parseInt($('VAL_'+id[1]).value) + parseInt(id[2]);
									var note = Math.round(parseInt($('VAL_'+id[1]).value) / parseInt($('NB_'+id[1]).value));
									//alert(note);
												
									for(i=1;i<=5;i++)
									{
										if(i <= note)
										{
											$('e_'+id[1]+'_'+i).src = "http://www.progamemap.com/public/images/Etoile_ON.png";
										}
										else
										{
											$('e_'+id[1]+'_'+i).src = "http://www.progamemap.com/public/images/Etoile_OFF.png";
										}
										
									}
									
									if($('NB_'+id[1]).value > 1)
									{
										$('V_'+id[1]).innerHTML = $('NB_'+id[1]).value+" Votes";
									}
									else
									{
										$('V_'+id[1]).innerHTML = $('NB_'+id[1]).value+" Vote";
									}
								}
							}
				
				}).send();
			}
		});
	});
	
	$$('div.g_etoile').each(function(element8) {
        element8.addEvent('mouseout',function(){
			var id = element8.id.split('_');
			
			if($('NOVOTE_'+id[1]).value != '1')
			{
				var note = Math.round(parseInt($('VAL_'+id[1]).value) / parseInt($('NB_'+id[1]).value));
							
				for(i=1;i<=5;i++)
				{
					if(i <= note)
					{
						$('e_'+id[1]+'_'+i).src = "http://www.progamemap.com/public/images/Etoile_ON.png";
					}
					else
					{
						$('e_'+id[1]+'_'+i).src = "http://www.progamemap.com/public/images/Etoile_OFF.png";
					}
					
				}
			}
		});
	});
});

//fonction de validation de pack
function s_pack(game,pack)
{				
	if(pack != "")
	{
		var req = new Request({
			method: 'post',
			url: 'http://www.progamemap.com/include/model/setup_panier.php',
			data: { 'game' : game, 'val' : '1', 'pack' : pack, 'sa' : $('sa').value },
			onComplete: function(rep) 
						{ 							
							if(rep.match("setup.exe"))
							{
								window.location.href = "http://www.progamemap.com/"+rep;
							}									
						}
		}).send();
	}
}

//fonction de suppression de pack
function d_pack(game,pack)
{				
	if(pack != "")
	{
		if(confirm ("Etes vous sur de vouloir supprimer ce pack ?"))
		{
			var req = new Request({
				method: 'post',
				url: 'http://www.progamemap.com/include/model/setup_panier.php',
				data: { 'game' : game, 'del' : 'pack', 'pack' : pack, 'sa' : $('sa').value },
				onComplete: function(rep) 
							{ 							
								if(rep.match(":OK:"))
								{
									window.location.reload(false);
								}									
							}
			}).send();
		}
	}
}

