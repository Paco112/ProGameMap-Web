window.addEvent('domready',function() {
									
	var strChUserAgent = navigator.userAgent;
	var intSplitStart  = strChUserAgent.indexOf("(",0);
	var intSplitEnd    = strChUserAgent.indexOf(")",0);
	var strChStart 	   = strChUserAgent.substring(0,intSplitStart);
	var strChMid 	   = strChUserAgent.substring(intSplitStart, intSplitEnd);
	var strChEnd       = strChUserAgent.substring(strChEnd);
	var browserComp    = 0;
	
	// compatible : 1  |  incompatible : 0
	if(strChMid.indexOf("MSIE 7") != -1)
		browserComp = 1;
	else if(strChEnd.indexOf("MSIE 8") != -1)
		browserComp = 1;
	else if(strChMid.indexOf("MSIE 6") != -1)
		browserComp = 1;
	else if(strChEnd.indexOf("Firefox/3") != -1)
		browserComp = 1;
	else if(strChEnd.indexOf("Firefox/2") != -1)
		browserComp = 1;
	else if(strChEnd.indexOf("Firefox") != -1)
		browserComp = 1;
	else if(strChStart.indexOf("Opera") != -1)
		browserComp = 0;
	else if(strChStart.indexOf("Opera/9") != -1)
		browserComp = 0;
	else if(strChEnd.indexOf("Netscape/7") != -1)
		browserComp = 0;
	else if(strChEnd.indexOf("Netscape") != -1)
		browserComp = 0;
	else
		browserComp = 0; // Dans le doute on dit que c'est incompatible ?
	
	
	
	if($('firstVisite').value != 1){
		if(browserComp == 1){
			//MsgBox("Incompatibilit&eacute; du navigateur", "Pour une meilleur expérience, veuillez utiliser les navigateur suivant :<br />Firefox (recommandé)<br />Internet Explorer 8+");
		}
	}
});