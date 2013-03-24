<?
// juste ce petit include et tous est pret
// pas de connection prealable ou autre declaration
include_once("include/class/sbox.php");
$_SESSION['conf_sbox']['timer']       = true;
$_SESSION['conf_sbox']['debug'] 		= true; // Default: false
$_SESSION['conf_sbox']['debug_max'] 	= true; // Default: false
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ProGameMap</title>
<script type="text/javascript" src="/public/js/mootools.js"></script>
<script type="text/javascript" src="/public/js/mysql_debug.js"></script>
<link rel="stylesheet" type="text/css" href="/public/css/mysql_debug.css">
</head>
<body style="padding-top:50px;">
<div style="text-align:center;">
<?
print_r($_SERVER);


 echo "#############################################################################################################<br>"
	. "											METHODE UPDATE MONO LIGNE											<br>"
	. "#############################################################################################################<br>";

?>
<textarea name="" cols="175" rows="10" readonly="readonly">
$info_update['name'] = "test2";
$info_update['info'] = "bla bla";
$test1 = $sbox->update(array('table'=>'TABLE_TEST','set'=>array($info_update),'where'=>'id=1','low_priority'=>'1'));

if ($test1 == true)
{
	echo "UPDATE OK <br>";
}
</textarea><br />
<?
$info_update['name'] = "test''2";
$info_update['info'] = "TABLE_TES.bla bla";
$test1 = $sbox->update(array('table'=>'TABLE_TEST','set'=>array($info_update),'where'=>'id=1','low_priority'=>'1'));

if ($test1 == true)
{
	echo "UPDATE OK <br>";
}

 echo "<br>#############################################################################################################<br>"
	. "											METHODE INSERT MONO LIGNE											<br>"
	. "#############################################################################################################<br>";

?>
<textarea name="" cols="175" rows="10" readonly="readonly">
$info_insert['name'] = "test3";
$info_insert['info'] = "bla bla 3";
$test2 = $sbox->insert(array('table'=>'TABLE_TEST','set'=>array($info_insert),'delayed'=>'1'));

if ($test2 == true)
{
	echo "INSERT OK <br>";
}
</textarea><br />
<?
$info_insert['name'] = "test3";
$info_insert['info'] = "bla bla 3";
$test2 = $sbox->insert(array('table'=>'TABLE_TEST','set'=>array($info_insert),'delayed'=>'1'));

if ($test2 == true)
{
	echo "INSERT OK <br>";
}

 echo "<br>#############################################################################################################<br>"
	. "											METHODE SELECT MONO LIGNE											<br>"
	. "#############################################################################################################<br>";

?>
<textarea name="" cols="175" rows="15" readonly="readonly">
$test3 = $sbox->select(array('table'=>'TABLE_TEST','select'=>'*','where'=>'id=1'));

if($test3)
{
	echo $test3->id."<br>";
	echo $test3->name."<br>";
}
else
{
	echo "Erreur voir debbuger";
}
</textarea><br />
<?
$test3 = $sbox->select(array('table'=>'TABLE_TEST','select'=>'*','where'=>'id=1'));

if($test3)
{
	echo $test3->id."<br>";
	echo $test3->name."<br>";
}
else
{
	echo "Erreur voir debbuger";
}

 echo "<br>#############################################################################################################<br>"
	. "											METHODE SELECT MULTI LIGNES											<br>"
	. "#############################################################################################################<br>";

?>
<textarea name="" cols="175" rows="20" readonly="readonly">
$test4 = $sbox->select_multi(array('table'=>'TABLE_TEST','select'=>'*','limit'=>'300','cache'=>'1','high_priority'=>'1','buffer'=>'0'));

if($test4)
{
	foreach($test4 as $array)
	{
		echo "<br>";
		foreach($array as $key => $value)
		{
			echo "[".$key."] => '".$value."'<br>";
		}		
	}
}
else
{
	echo "Erreur voir debbuger";
}
</textarea><br />
<?
$test4 = $sbox->select_multi(array('table'=>'TABLE_TEST','select'=>'*','limit'=>'300','cache'=>'1','high_priority'=>'1','buffer'=>'0'));

if($test4)
{
	foreach($test4 as $array)
	{
		echo "<br>";
		foreach($array as $key => $value)
		{
			echo "[".$key."] => '".$value."'<br>";
		}		
	}
}
else
{
	echo "Erreur voir debbuger";
}

//$test5 = $sbox->select_multi(1);
?>
</div>
</body>
</html>
