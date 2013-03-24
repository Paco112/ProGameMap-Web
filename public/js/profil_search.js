function profil_search(type,lien)
{	
	if(type == "profil" || type == "team")
	{
		var val = "";
		$('search_'+type).disabled = true;
		
		if(type == "profil")
		{
			if($('dname').value.length > 1)
			{
				val = $('dname').value+"/";
			}
		}
		else
		{
			if($('name').value.length > 1)
			{
				val = "team."+$('name').value+"/";
			}
		}
		if(val != "")
		{
			window.location = lien+val;	
		}
		else
		{
			$('search_'+type).disabled = false;
		}
	}
}
