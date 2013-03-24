window.addEvent('domready',function() {
	
	$$('li.liFilArianneBouton').each(function(element){
		element.addEvent('mouseover', function(){
			var tab_btn = element.id.split("_");
			var i = parseInt(tab_btn[1]);
			var i2 = i-1;			
			$('FAB_'+i+'_A').setStyle('background', 'url(http://www.progamemap.com/public/images/FilArianneBoutonBG.jpg) 0 -27px repeat-x');
			$('liFilArianneBoutonFLECHE'+i).setStyle('background', 'url(http://www.progamemap.com/public/images/FilArianneBoutonend.jpg) 0 -27px no-repeat');
			if(i2!=0)
			{
				$('liFilArianneBoutonFLECHE'+i2).setStyle('background', 'url(http://www.progamemap.com/public/images/FilArianneBoutonend.jpg) 0 -54px no-repeat');
			}
			else
			{
				$('liFilArianneBoutonDEBUT').setStyle('background', 'url(http://www.progamemap.com/public/images/FilArianneBegin.png) 0 -27px no-repeat');
			}

		});
		
		element.addEvent('mouseout', function(){
			var tab_btn = element.id.split("_");
			var i = parseInt(tab_btn[1]);
			var i2 = i-1;
			$('FAB_'+i+'_A').setStyle('background', 'url(http://www.progamemap.com/public/images/FilArianneBoutonBG.jpg) 0 0px repeat-x');
			$('liFilArianneBoutonFLECHE'+i).setStyle('background', 'url(http://www.progamemap.com/public/images/FilArianneBoutonend.jpg) 0 0px no-repeat');
			if(i2!=0)
			{
				$('liFilArianneBoutonFLECHE'+i2).setStyle('background', 'url(http://www.progamemap.com/public/images/FilArianneBoutonend.jpg) 0 0px no-repeat');
			}
			else
			{
				$('liFilArianneBoutonDEBUT').setStyle('background', 'url(http://www.progamemap.com/public/images/FilArianneBegin.png) 0 0px no-repeat');
			}
		});
	});
});
