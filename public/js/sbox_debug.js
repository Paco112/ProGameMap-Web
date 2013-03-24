try
{
	var mv = MooTools['version'];
	
window.addEvent('domready', function(){
if($('debug_bar'))
{
    var myMenu = new Fx.Slide('v-menu');

	myMenu.hide();
	
	$('debug_bar').setStyle('display','block');
	
    $('sbox_c').addEvent('click', function(e){
    	e = new Event(e);
		/*
		if($('sbox_plus').getStyle('display') == 'block')
		{
			$('sbox_plus').setStyle('display','none');
		}
		else
		{
			$('sbox_plus').setStyle('display','block');
		}
		*/
    	myMenu.toggle();
    	e.stop();
    });
    
    var el = $$('.v-menu li'),
        color_back = el.getStyle('backgroundColor');
        color_text = el.getStyle('color');
        
    // We are setting the opacity of the element to 0.5 and adding two events
    $$('.v-menu li').set('opacity', 0.7).addEvents({
        mouseenter: function(){
            // This morphes the opacity and backgroundColor
            this.morph({
                'opacity': 0.8,
                'background-color': '#FC3',
                'color': '#FFF',
                'font-weight': 'bold'
            });
        },
        mouseleave: function(){
            // Morphes back to the original style
            this.morph({
                'opacity': 0.7,
                'background-color': color_back,
                'color': color_text,
                'font-weight': 'normal'
            });
        }
    });
}
});

function sbox_view(rep_ajax)
{
	// recuperation de l'emplacement de la page console
	var lien = "";
	try
	{
		lien = document.getElementById('inc_sbox_debug').value;
	}
	catch(ex)
	{
		alert("Veuillez verifier la presence des balises html necessaire a la console sbox");
	}	
	
	if(lien == "")
	{
		alert("le lien (inc_sbox_debug) de la console sbox  est incorrect !");
	}
	else
	{
		try
		{
			if(rep_ajax)
			{
				document.getElementById('v-menu').innerHTML = '<br /><table style="color:#F00; padding-left:5px;" width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>Reponse AJAX :</td><td>'+rep_ajax+'</td></tr></table><br />';
			}
			
			var req = new Request({
					method: 'get',
					url: lien,
					data: 'view=1',
					onRequest: function() { 
						document.getElementById('sbox_c_error').innerHTML += '<div style="color:#FFF; font-size:12px;">Loading ...</div>';
					},
					onComplete: function(rep)
					{									
						document.getElementById('sbox_c_error').innerHTML = rep;
					}
			}).send();
			
			var req = new Request({
					method: 'get',
					url: lien,
					data: 'view=2',
					onRequest: function() { 
						document.getElementById('v-menu').innerHTML += "Loading ...";
					},
					failure : function(rep2) {
						alert("Echec de la requete de mise a jour de la console sbox !");
					},
					onComplete: function(rep2)
					{									
						document.getElementById('v-menu').innerHTML += rep2;
					}
			}).send();
			
		}
		catch(ex)
		{
			alert("Une erreur inattendue c'est produite durant la requete ajax de la console sbox !");
		}
	}
	
}

sbox_view();

}
catch(ex)
{
	alert("ERREUR CONSOLE SBOX : \n\n"+ex);
}