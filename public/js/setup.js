var IE;
var maps_by_page = 21; 
var count_add = 0;
var compt_fx = 0;

	//Effet FX
	
	function fxgo()
	{
		if( $$('body').getStyle('background-color') == '#d2d1d0' )
		{
			$$('body').setStyle('background-color', 'rgb(126,126,126)');
		}
		else
		{
			$$('body').setStyle('background-color', '#d2d1d0');
		}
		compt_fx++;
		if(compt_fx < 5)
		{
			setTimeout('fxgo()',125);
		}
		//document.body.bgColor = '#7e7e7e7e';
	}


window.addEvent('domready',function() {
    
    // détection du navigateur
    if(navigator.userAgent.indexOf("MSIE 8") != -1)
    IE = true;
    if(navigator.userAgent.indexOf("MSIE 7") != -1)
    IE = true;
    else if(navigator.userAgent.indexOf("MSIE 6") != -1)
    IE = true;
    else if(navigator.userAgent.indexOf("Firefox/2") != -1)
    FIREFOX2 = true;
    else if(navigator.userAgent.indexOf("Firefox") != -1)
    FIREFOX = true;
    else if(navigator.userAgent.indexOf("Netscape/7") != -1)
    NETSCAPE7 = true;
    else if(navigator.userAgent.indexOf("Netscape") != -1)
    NETSCAPE = true;
    else if(navigator.userAgent.indexOf("Opera/9") != -1)
    OPERA9 = true;
    else if(navigator.userAgent.indexOf("Opera") != -1)
    OPERA = true;
    else
    AUTRE = true;
	
	// Plugin FF
	if($('plug_ff'))
	{
		$('plug_ff').addEvent('click', function(){
			$('help_ext').setStyles({
				'opacity' : '0',
				'display' : 'block'
			});
			$('help_ext').fade('in');			
		});
		
		$('help_ext_close').addEvent('click', function(e){
			e.stop();
			$('help_ext').fade('out');			
		});
	}
		
	// Sauvegarde PACKS
	if($('packs_sauve'))
	{
		$('packs_sauve').addEvent('click', function(e){
			e.stop();
			if($('packs_name').value != "")
			{
				var req = new Request({
						// choix de la methode get ou post
						method: 'post',
						// url de la requete
						url: 'http://www.progamemap.com/include/model/setup_panier.php',
						// les paramètre post :
						data: { 'game' : $('actif_game').value, 'sav' : '1', 'name' : $('packs_name').value, 'pub' : $('packs_type').checked, 'sa' : $('sa').value },
						// pendant la requete on affiche le mini loader
						onRequest: function() { 
							//$('s_packs').innerHTML = "Sauvegarde en cours ...";
						},
						// lorsque l'on reçoi la réponse on change l'adresse du navigateur
						onComplete: function(rep)
									{									
										//try { sbox_view(rep); } catch(ex) {}						

										if(rep.match(" !"))
										{
											alert(rep);
										}
										else
										{
											$('s_packs').innerHTML = rep;
										}
									}
					}).send();
			}
		});
	}
	  
    // Bouton Recherche
	if($('go_search'))
	{
		$('go_search').addEvent('click', function(e){
			e.stop();
			var lien = $('search_link').value;
			
			if($('search').value != "")
			{
				//alert(TLink()+"search/"+$('search').value);
				var val = $('search').value;
				//val.replace(new RegExp('\W', "g"), '');
				
				window.location.replace(lien+"search/"+val+"/");
			}
			else
			{
				window.location.replace(lien);
			}
		});
	}
	
	// gestion du multi filtre
	if($('types_filtre'))
	{
		$('types_filtre').addEvent('click', function(){
			
			link = $('link_t').value+"type/";
			// boucle sur tous les element filtrant
			i=1;
			and = 0;
			no_check=0;
			$$('input.t_f').each(function(input) {           
			   if(input.checked)
			   {
				   if(i==1)
				   {
						link += input.id;
						if(input.id == "and")
						{
							and = 1;
						}
				   }
				   else
				   {
						link += "_"+input.id;
						and =  0;
				   }
				   i=i+1;
			   }
			   else
			   {
				   no_check = no_check + 1;
			   }
			});
			
			/*
			if( (i>1) && (no_check != 0) && (and != 1) )
			{
				window.location.replace(link);
			}
			elseif( (i>1) && (and != 1) ) 
			{
			
				window.location.replace($('link_t').value);
			}
			else
			{
				alert("Vous devez cocher au moins 1 case pour lancer un filtrage !")
			}
			*/
			window.location.replace(link);
		});
	}
    
    // Gestion Ajout au Panier ( Page listing maps )
    $$('div.p_add').each(function(element2) {
        // créer un évènement 'click' sur 'element' qui est un des <a class="g_"></a>
        element2.addEvent('click', function(e2){
            // On stope le navigateur pour ne pas recharger la page
            e2.stop();
			element2.removeEvent('click');			
			$(element2.id).setStyle('display','none');
			
			var id = element2.id.split("_");
            // requete ajax
            var req = new Request({
                // choix de la methode get ou post
                method: 'post',
                // url de la requete
                url: 'http://www.progamemap.com/include/model/setup_panier.php',
                // les paramètre post :
                data: { 'game' : $('actif_game').value, 'add' : id[1], 'sa' : $('sa').value },
                // pendant la requete on affiche le mini loader
                onRequest: function() {  },
                // lorsque l'on reçoi la réponse on change l'adresse du navigateur
                onComplete: function(rep)
							{ 	
								//alert(rep);
								//$('cart').highlight('#ff7f2a');
								if (rep.match(':OK:'))
								{
								
									var nb_cart = rep.split(':');
									
									$('m_'+id[1]).setStyle('opacity', '0');
									
									var myFx = new Fx.Morph('m_'+id[1], {duration: '200'});
									
									myFx.start({
										'width': '0px'
									}).chain( function(){ 
										$('m_'+id[1]).setStyle('display', 'none');
										$('cart').innerHTML = $('cart').innerHTML.replace(/[0-9]+/, nb_cart[2]);

										//$('cart').highlight('#98c163');
									});
									
									count_add++;									
									if(count_add == maps_by_page)
									{
										window.location.reload(false);
									}

									
								}
								else
								{
									$(element2.id).setStyle('display','block');
								}
							}
            }).send();
    
        });        

    });
	
    // Gestion Ajout au Panier ( Page FAVORIS )
    $$('div.p_add_f').each(function(element21) {
        // créer un évènement 'click' sur 'element' qui est un des <a class="g_"></a>
        element21.addEvent('click', function(e21){
            // On stope le navigateur pour ne pas recharger la page
            e21.stop();
			if($(element21.id).getStyle('color') != 'gray')
			{			
				$(element21.id).setStyle('color','gray');
				
				var id = element21.id.split("_");
				
				// requete ajax
				var req = new Request({
					// choix de la methode get ou post
					method: 'post',
					// url de la requete
					url: 'http://www.progamemap.com/include/model/setup_panier.php',
					// les paramètre post :
					data: { 'game' : $('actif_game').value, 'add' : id[1], 'sa' : $('sa').value },
					// lorsque l'on reçoi la réponse on change l'adresse du navigateur
					onComplete: function(rep)
								{ 
									if (rep.match(':OK:'))
									{
										var nb_cart = rep.split(':');										
										$('cart').innerHTML = $('cart').innerHTML.replace(/[0-9]+/, nb_cart[2]);
										//$('cart').highlight('#98c163');
									}
									else
									{
										$(element21.id).setStyle('color','white');
									}
	
								}
				}).send();
			}
        });        

    });
	
	// vider tous le panier
	if($('del_all'))
	{
		$('del_all').addEvent('click', function(e){
			e.stop();
			//$('del_all').removeEvent('click');
			var req = new Request({
					// choix de la methode get ou post
					method: 'post',
					// url de la requete
					url: 'http://www.progamemap.com/include/model/setup_panier.php',
					// les paramètre post :
					data: { 'game' : $('actif_game').value, 'del' : 'all', 'sa' : $('sa').value },
					// pendant la requete on affiche le mini loader
					onRequest: function() {  },
					// lorsque l'on reçoi la réponse on change l'adresse du navigateur
					onComplete: function(rep) 
								{ 
									if (rep.match(':OK:'))
									{
										window.location.reload(false);
									}
								}
				}).send();		
		});
	}
	
	// Gestion Enlever au Panier
    $$('div.p_del').each(function(element3) {
        // créer un évènement 'click' sur 'element' qui est un des <a class="g_"></a>
        element3.addEvent('click', function(e3){
            e3.stop();
			element3.removeEvent('click');
			$(element3.id).setStyle('display','none');
			
			var id = element3.id.split("_");
			
            // requete ajax
            var req = new Request({
                method: 'post',
                url: 'http://www.progamemap.com/include/model/setup_panier.php',
                data: { 'game' : $('actif_game').value, 'del' : id[1], 'sa' : $('sa').value },
                onComplete: function(rep) 
							{ 
								//alert(rep);
								//try { sbox_view(rep); } catch(ex) {}
								if (rep.match(':OK:'))
								{								
									var nb_cart = rep.split(':');
									$('m_'+id[1]).setStyle('opacity', '0');
									
									if(nb_cart[2] == "0")
									{
										window.location.reload(false);
									}
									else
									{									
										var myFx2 = new Fx.Morph('m_'+id[1], {duration: '200'});
										
										myFx2.start({
											'width': '0px'
										}).chain( function(){ 
											$('m_'+id[1]).setStyle('display', 'none');
											$('cart').innerHTML = $('cart').innerHTML.replace(/[0-9]+/, nb_cart[2]);
											$('cart').highlight('#FFB9B9');
										});
									}
								}
								else
								{
									$(element3.id).setStyle('display','block');
								}
							}
            }).send();
    
        });        

    });
    	
	// fx coeur favoris
    $$('div.fav_c').each(function(element6) {
        element6.addEvent('mouseover',function(){
					
				var chaine=element6.getStyle('background');
				var reg=new RegExp("-16px", "g");
				if(reg.test(chaine))
				{
					//alert(chaine.replace(reg,"0px"));
					element6.setStyle('background',chaine.replace(reg,"-1px"));	
				}
				
		});
		element6.addEvent('mouseout',function(){
				var id = element6.id.split("fav_");											   
								
				var value = $('fav_val_'+id[1]).value;
				
				var chaine=element6.getStyle('background');
				var reg=new RegExp("-16px", "g");
				
				
				if(value == 1)
				{
					element6.setStyle('background',chaine.replace(reg,"-1px"));
				}
				else
				{
					var reg2=new RegExp("-1px", "g");
					if(reg2.test(chaine))
					{								 
						element6.setStyle('background',chaine.replace(reg2,"-16px"));
					}
				}
		});
		
		element6.addEvent('click',function(){
				var type = "";
				var id = element6.id.split("fav_");											   
								
				var value = $('fav_val_'+id[1]).value;
				
				var chaine=element6.getStyle('background');
				var reg=new RegExp("-16px", "g");				
				
				if(value == 1)
				{
					// desactivation
					type = "del";
					$('fav_val_'+id[1]).value = 0;
					var reg2=new RegExp("-1px", "g");
					if(reg2.test(chaine))
					{								 
						element6.setStyle('background',chaine.replace(reg2,"-16px"));
					}
					
					var req = new Request({
					// choix de la methode get ou post
					method: 'post',
					// url de la requete
					url: 'http://www.progamemap.com/include/model/setup_panier.php',
					// les paramètre post :
					data: { 'game' : $('actif_game').value, 'fav' : '1','del' : id[1], 'sa' : $('sa').value },
					
					onComplete: function(rep) 
							{ 
								if(rep.match("Please Login !"))
								{
									alert(rep);
								}
								else
								{
									if($('page_actif').value == 'favorites')
									{
										
										$('m_'+id[1]).setStyle('opacity', '0');										
										
										var myFx = new Fx.Morph('m_'+id[1], {duration: '300'});
									
										myFx.start({
											'width': '0px'
										}).chain( function(){ 
											$('m_'+id[1]).setStyle('display', 'none'); 
										});
									}
								}
							}
					}).send();
				}
				else
				{
					//activation
					
					var req = new Request({
					// choix de la methode get ou post
					method: 'post',
					// url de la requete
					url: 'http://www.progamemap.com/include/model/setup_panier.php',
					// les paramètre post :
					data: { 'game' : $('actif_game').value, 'fav' : '1','add' : id[1], 'sa' : $('sa').value },
					
					onComplete: function(rep) 
							{ 
								if(rep.match("Please Login !"))
								{
									alert(rep);
								}
								else
								{
									type = "add";
									$('fav_val_'+id[1]).value = 1;
									element6.setStyle('background',chaine.replace(reg,"-1px"));
								}
							}
					
					}).send();
				}
		});
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
				var pack = 0;
				
				if($('actif_pack'))
				{
					pack = 1;
				}
							
				var req = new Request({
				// choix de la methode get ou post
				method: 'post',
				// url de la requete
				url: 'http://www.progamemap.com/include/model/setup_panier.php',
				// les paramètre post :
				data: { 'game' : $('actif_game').value, 'note' : id[2], 'add' : id[1], 'sa' : $('sa').value , 'pack' : pack},
				
				onComplete: function(rep) 
							{ 
								//sbox_view(rep);
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
	
	$$('div.maps').each(function(element) {
		element.addEvent('mouseover',function() {
			$('img_map').src = element.id;
		});
	});


});

/*
function val_dl()
{
	var req = new Request({
		// choix de la methode get ou post
		method: 'post',
		// url de la requete
		url: 'http://www.progamemap.com/include/model/setup_panier.php',
		// les paramètre post :
		data: { 'game' : $('actif_game').value, 'val' : '1', 'sa' : $('sa').value },
		// pendant la requete on affiche le mini loader
		onRequest: function() { 
			$('box_setup').setStyle('display','none');
			$('loader').setStyle('display','block');
		},
		// lorsque l'on reçoi la réponse on change l'adresse du navigateur
		onComplete: function(rep) 
					{ 
						if($('p_validate'))
						{
							$('box_setup').innerHTML = rep;
						}
					}
	}).send();
}
*/

//fonction de validation de pack
function s_pack(pack)
{				
	if(pack != "")
	{
		var req = new Request({
			method: 'post',
			url: 'http://www.progamemap.com/include/model/setup_panier.php',
			data: { 'game' : $('actif_game').value, 'val' : '1', 'pack' : pack, 'sa' : $('sa').value },
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
function d_pack(pack)
{				
	if(pack != "")
	{
		if(confirm ("Etes vous sur de vouloir supprimer ce pack ?"))
		{
			var req = new Request({
				method: 'post',
				url: 'http://www.progamemap.com/include/model/setup_panier.php',
				data: { 'game' : $('actif_game').value, 'del' : 'pack', 'pack' : pack, 'sa' : $('sa').value },
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

function ext_ff()
{
	$('p_check').setStyle('display','none');
	$('box_setup').setStyle('display','block');
	//$('p_validate').innerHTML = '<input id="p_val" name="p_val" onClick="val_dl()" type="submit" value="  Installer  " /><span></span>';
}

<!--
var dotNETRuntimeVersion = "3.5.0.0";

function check_net(lang)
{
  if (HasRuntimeVersion(dotNETRuntimeVersion))
  {
		$('p_check').setStyle('display','none');
		$('box_setup').setStyle('display','block');
  } 
}

//
// Retrieve the version from the user agent string and 
// compare with the specified version.
//
function HasRuntimeVersion(versionToCheck)
{
  var userAgentString = 
	navigator.userAgent.match(/.NET CLR [0-9.]+/g);

  if (userAgentString != null)
  {
	var i;

	for (i = 0; i < userAgentString.length; ++i)
	{
	  if (CompareVersions(GetVersion(versionToCheck), 
		GetVersion(userAgentString[i])) <= 0)
		return true;
	}
  }

  return false;
}

//
// Extract the numeric part of the version string.
//
function GetVersion(versionString)
{
  var numericString = 
	versionString.match(/([0-9]+)\.([0-9]+)\.([0-9]+)/i);
  return numericString.slice(1);
}

//
// Compare the 2 version strings by converting them to numeric format.
//
function CompareVersions(version1, version2)
{
  for (i = 0; i < version1.length; ++i)
  {
	var number1 = new Number(version1[i]);
	var number2 = new Number(version2[i]);

	if (number1 < number2)
	  return -1;

	if (number1 > number2)
	  return 1;
  }

  return 0;
}
-->
