//once the dom is ready
window.addEvent('domready', function() {
	//find the editable areas
	$$('.editable').each(function(el) {
		//add double-click and blur events
		el.addEvent('dblclick',function() {
			//store "before" message
			var before = el.get('html').trim();
			//erase current
			el.set('html','');
			//replace current text/content with input or textarea element
			if(el.hasClass('textarea'))
			{
				var input = new Element('textarea', { 'class':'box', 'text':before });
			}
			else
			{
				var input = new Element('input', { 'class':'box', 'value':before });
				//blur input when they press "Enter"
				input.addEvent('keydown', function(e) { if(e.key == 'enter') { this.fireEvent('blur'); } });
			}
			input.inject(el).select();
			//add blur event to input
			input.addEvent('blur', function() {
				//get value, place it in original element
				val = input.get('value').trim();
				el.set('text',val).addClass(val != '' ? '' : 'editable-empty');
				
				//save respective record
				var request = new Request({
					url    : 'http://www.progamemap.com/include/model/editable.php',
					data   : { 'id'    : $('id').value,
							   'name'  : $('name').value, 
							   'url'   : $('url').value},
					method:'post',
					onRequest: function() {
						
					}
				}).send();
			});
		});
	});
});