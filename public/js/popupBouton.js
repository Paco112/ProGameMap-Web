window.addEvent('domready',function() {
	
	$$('img.popup').each(function(element) {
		
		var name = element.name;
		
		$(name+'_menu').setStyles({
			opacity:0,
			display:'block'
		});
		
		$(document.body).addEvent('click',function(e) {
			if($(name+'_menu').get('opacity') == 1 && !e.target.getParent('.menu1')) {
			   $(name+'_menu').fade('out');
			}
		});
		
		$(name).addEvent('click',function() {
			$(name+'_menu').fade('in');
		});
	});
});