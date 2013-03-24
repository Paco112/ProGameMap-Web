function MsgBox(title, msg, type, funct, no_grise, no_end)
{
	if($('fb-modal'))
	{
		var type_txt="";
		var type_img="";
		var type_funct="";
		
		if(no_end != true)
		{
			no_end = "EndMsgBox();";
		}
		
		$('titlebox').innerHTML = '<strong>'+title+'</strong>';
		
		if(funct!=null)
		{
			type_funct = ""+funct+"('ok');";
		}
			
		switch(type)
		{
			default:
				type_txt = '<table border="0" cellspacing="0" cellpadding="0" align="center"><tr><td><div class="right gistsubmit"><input type="submit" name="btn_ok" id="btn_ok" value="  OK  " onClick="'+type_funct+no_end+'" /><span></span></div></td></tr></table>';
				type_img = '<img src="'+$('sa').title+'public/images/msgbox_warning.png" width="96" height="96" />';
				break;
			case "yesno":
				type_txt = '<table border="0" cellspacing="0" cellpadding="0" align="center"><tr><td><div class="right gistsubmit"><input type="submit" name="btn_yes" id="btn_yes" value="  Yes  " onClick="'+funct+'(\'yes\');'+no_end+'" /><span></span></div><div class="right gistsubmit" style="margin-left:10px;"><input type="submit" name="btn_no" id="btn_no" value="  No  " onClick="'+funct+'(\'no\');'+no_end+'" /><span></span></div></td></tr></table>';
				type_img = '<img src="'+$('sa').title+'public/images/msgbox_yesno.png" width="96" height="96" />';
				break;
			case "nobtn":
				type_img = '<img src="'+$('sa').title+'public/images/msgbox_warning.png" width="96" height="96" />';
				break;
			case "up":
				//type_txt = '<table border="0" cellspacing="0" cellpadding="0" align="center"><tr><td><div class="right gistsubmit"><input type="submit" name="btn_cancel" id="btn_cancel" value="  Annuler  " onClick="'+type_funct+no_end+'" /><span></span></div></td></tr></table>';
				type_img = '<img src="'+$('sa').title+'public/images/msgbox_up.png" width="96" height="96" />';
				break;
		}
		
		$('MsgBox_Img').innerHTML = type_img;
		$('MsgBox_Msg').innerHTML = msg;
		$('MsgBox_Btn').innerHTML = type_txt;		
		
		if(!no_grise)
		{
			$('bck').setStyle('opacity',0.3);
		}		
		$('fb-modal').fade('in');
		
		return true;
		
	}
	else
	{
		return false;
	}
}
/*
function MsgBox_Actu(msg,type)
{
	switch(type)
	{
		default:
			
	}
}
*/

function EndMsgBox()
{
	$('fb-modal').fade('out');
	//alert($('bck').getStyle('opacity'));
	if($('bck').getStyle('opacity') == '0.3')
	{
		$('bck').fade('out');
	}
}
