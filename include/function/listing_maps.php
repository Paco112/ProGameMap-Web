<?php
function Trie_Maps($order_actif=0,$order_sens=0)
{
	if($order_actif != "" && $order_sens != "")
	{
		$order = explode("_",$order_sens);
		$order[0] = str_replace("dl","stats_dl",$order[0]);
		$order[0] = str_replace("vote","note_nb",$order[0]);
	}
	
	if($order[0] != "name" && $order[0] != "stats_dl" && $order[0] != "note" && $order[0] != "note_nb")
	{
		$order[0] = "name";
	}
	
	if($order[1] != "asc" && $order[1] != "desc")
	{
		$order[1] = "asc";
	}
	
	return $order;
}

function Maps_listing($game,$order_actif=0,$order_sens=0)
{
	global $sbox;
	
	// trie du tableau
	$order = Trie_Maps($order_actif,$order_sens);
	
	//on liste les maps si listing maps dispo ou demandé
	if(sbox_cache::get('listing_maps_'.$game.'_'.$order[0].'_'.$order[1]) == false)
	{
		// on liste toute les maps
		$maps = $sbox->select_multi(array('table'=>'`maps_'.$game.'`','select'=>'id,file_key,name,type,mode,images,folder,file,file_ext,setup_control,stats_dl,note_val,note_nb,(note_val/note_nb) as note','order by'=>$order[0].' '.$order[1]));
		
		if($maps)
		{
			foreach($maps as $map)
			{        
				// on prend la première images seulement
				$images = array();
				$images = explode(';',$map['images'],2);
				
				$listing_maps[$map['id']]['id'] = $map['id'];
				$listing_maps[$map['id']]['file_key'] = $map['file_key'];
				$listing_maps[$map['id']]['name'] = $map['name'];
				$listing_maps[$map['id']]['type'] = $map['type'];
				$listing_maps[$map['id']]['mode'] = $map['mode'];
				$listing_maps[$map['id']]['image'] = $images[0];
				$listing_maps[$map['id']]['folder'] = $map['folder'];
				$listing_maps[$map['id']]['file'] = $map['file'];
				$listing_maps[$map['id']]['file_ext'] = $map['file_ext'];
				$listing_maps[$map['id']]['setup_control'] = $map['setup_control'];
				$listing_maps[$map['id']]['stats_dl'] = $map['stats_dl'];
				$listing_maps[$map['id']]['note_val'] = $map['note_val'];
				$listing_maps[$map['id']]['note_nb'] = $map['note_nb'];
				$i++;
			}
			
			//sauvegarde en cache
			sbox_cache::add('listing_maps_'.$game.'_'.$order[0].'_'.$order[1],$listing_maps,600);
		}
		else
		{
			$listing_maps = false;
		}
	}
	else
	{
		$listing_maps = sbox_cache::get('listing_maps_'.$game.'_'.$order[0].'_'.$order[1]);
	}
	
	return $listing_maps;
}
?>