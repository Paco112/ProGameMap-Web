<?php
set_time_limit(0);
include_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
$_SESSION['sbox_ajax'] = 1;

$return = array();

if(isset($_FILES['file']))
{
	$dossier = $_SERVER['DOCUMENT_ROOT'].'\\uploads\\';
	
	$file_info = pathinfo($_FILES['file']['name']);		
	$fichier = $file_info['filename'];
	$ext = $file_info['extension'];
	
	if($ext == "zip")
	{
		
		// sécurité du nom du fichier
		$fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
		
		while(file_exists($dossier.$fichier.'.'.$ext))
		{
			$fichier = $fichier."-".rand();
		}
		
		if(move_uploaded_file($_FILES['file']['tmp_name'], $dossier.$fichier.'.'.$ext))
		{
			// on enregistre les info dans la base de donnée
			$set[0]['name'] = $_POST['name'];
			$set[0]['author'] = $_POST['auteur'];
			$set[0]['size_map'] = $_POST['size_map'];
			$set[0]['desc_map'] = $_POST['description'];
			$set[0]['desc_setup'] = $_POST['description_setup'];
			$set[0]['archive'] = $dossier.$fichier.'.'.$ext;
			if($_POST['game'] == "other")
			{
				$set[0]['game'] = $_POST['game_other'];
			}
			else
			{
				$set[0]['game'] = $_POST['game'];
			}
			
			if($sbox->insert(array('table'=>'site_uploads','set'=>$set)))
			{		
				$_SESSION['temp_upload'] = 1;
				$return['error'] = 0;
			}
			else
			{
				$return['error'] = "Erreur d'enregistrement !";
			}
		}
		else
		{
			$return['error'] = "Echec de l'upload !";
		}
	}
	else
	{
		$return['error'] = "Format du fichier incorrect, veuillez choisir un fichier au format ZIP";
	}		
	
}
else
{
	$return['error'] = "Erreur !";
}

@unlink($_FILES['file']['tmp_name']);

echo json_encode($return);
?> 