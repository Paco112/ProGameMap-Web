window.addEvent('domready',function() {
	$$('a.share').each(function(a){
		//containers
		var storyList = a.getParent();
		var shareHover = storyList.getElements('div.share-hover')[0];
		shareHover.set('opacity',0);
		//show/hide
		a.addEvent('mouseenter',function() {
				shareHover.setStyle('display','block').fade('in');
		});
		shareHover.addEvent('mouseleave',function(){
			shareHover.fade('out');
		});
		storyList.addEvent('mouseleave',function() {
			shareHover.fade('out');
		});
	});
});