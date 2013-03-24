<?php
if (function_exists("uploadprogress_get_info") && $_GET['id'] != "") 
{
	$info = uploadprogress_get_info($_GET['id']);
	
	if($info == null)
	{
		$info['status'] = 0;
	}
	else
	{
		$info['status'] = 1;
	}
	
	echo json_encode($info);
} 


?> 