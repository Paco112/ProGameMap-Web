<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
$_SESSION['sbox_ajax'] = 1;

sbox_function::check_ajax();

$type = $_POST['type'];
$val  = $_POST['val'];

if($type == "profil")
{
	$tab = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';

	$getProfil = $sbox->select_multi(array('table' => 'site_users', 'select' => 'displayname,teamID,teamRank', 'where' => 'displayname LIKE /%'.$val.'%/'));
	
	foreach($getProfil as $profil)
	{
		$tab .= '<tr>
				  <td>'.$profil['displayname'].'</td>
				  <td>'.$profil['teamID'].'</td>
				  <td>'.$profil['teamRank'].'</td>
				</tr>';
	}
	
	$tab .= "</table>";
	$_SESSION['temp_profil'] = $tab;
	
	echo ":ok:";
}
elseif($type == "team")
{
	$tab = '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
	
	$getTeam = $sbox->select_multi(array('table' => 'site_team', 'select' => 'name,tag,website', 'where' => 'name LIKE /%'.$val.'%/ OR tag LIKE /%'.$val.'%/'));
	
	foreach($getTeam as $team)
	{
		$tab .= '<tr>
				  <td>'.$team['tag'].'</td>
				  <td>'.$team['name'].'</td>
				  <td>'.$team['website'].'</td>
				</tr>';
	}
	
	$tab .= "</table>";
	$_SESSION['temp_profil'] = $tab;
	
	echo ":ok:";

	
}
?>