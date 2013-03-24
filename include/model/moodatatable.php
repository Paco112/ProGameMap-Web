<?php
require_once($_SERVER['DOCUMENT_ROOT']."/include/class/sbox.php");
$_SESSION['sbox_ajax'] = 1;

sbox_function::check_ajax(false);

$entriesCount = $sbox->custom("SELECT COUNT(*) FROM `site_users`");
$counta = mysql_fetch_row($entriesCount);
$count = $counta[0];
$page = $_POST['page'];
$perPage = $_POST['perPage'];
$sort = $_POST['sort'];
$sortOrder = $_POST['sortOrder'];
$start = ($page * $perPage) - ($perPage);


$entries = $sbox->custom("SELECT * FROM `site_users`");

$result = "{\"total\": $count,
\"page\": $page,
\"rows\": [
";

foreach($entry as $entries) {
	$result = $result . "[\"$entry[id]\", \"$entry[name]\", \"$entry[email]\"],\n";
}

$result = substr($result, 0, strlen($result)-2);

$result = $result."\n]}";

echo $result;