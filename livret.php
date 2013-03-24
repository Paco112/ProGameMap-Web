<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Document sans titre</title>
</head>

<body>
<?
if( ($_GET['l1_a'] != "") && ($_GET['l1_t'] != "") && ($_GET['anne'] != "") )
{
	echo "<br><br>Periode : ".$_GET['anne']." ans<br><br>";
    
    $l1_a = $_GET['l1_a'];
	$l1_t = $_GET['l1_t'];
	$anne = $_GET['anne'];
	$l1 = 0;
	$l1_p = $l1_a;
	for($i=1;$i<=$anne;$i++)
	{
		$l1 = (($l1_a * $l1_t)/100) + $l1_a;
		echo "<br>Année ".$i." : ".$l1." €  (Gain : ".($l1-$l1_p)." €)  (Gain Cummulé : ".($l1-$_GET['l1_a'])." €)";
        $l1_a = $l1;
        $l1_p = $l1;
	}
	
	echo "<br>Total Livret 1 : ".$l1." €<br><br>";
}
if( ($_GET['l2_a'] != "") && ($_GET['l2_t'] != "") && ($_GET['anne'] != "") )
{
    $l2_a = $_GET['l2_a'];
    $l2_t = $_GET['l2_t'];
    $anne = $_GET['anne'];
    $l2 = 0;
    $l2_p = $l2_a;
    for($i=1;$i<=$anne;$i++)
    {
        $l2 = (($l2_a * $l2_t)/100) + $l2_a;
        echo "<br>Année ".$i." : ".$l2." €  (Gain : ".($l2-$l2_p)." €)  (Gain Cummulé : ".($l2-$_GET['l2_a'])." €)";
        $l2_a = $l2;
        $l2_p = $l2;
    }
    
    echo "<br>Total Livret 2 : ".$l2." € <br><br>";
}
if(($l1 != 0) && ($l2 != 0))
{
    $total = ($l1+$l2);
    $g_total = $total-($_GET['l1_a']+$_GET['l2_a']);
    $g_anne = ($g_total/$anne);
    echo "<br><br>Total : ".$total." € ( Depart : ".($_GET['l1_a']+$_GET['l2_a'])." € )";
    echo "<br><br>Gain Total : ".$g_total." €";
    echo "<br><br>Gain Moyen / ans : ".$g_anne." €";
}

?>
<form id="form1" name="form1" method="get" action="livret.php">
  <table width="537" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="110" valign="bottom"><p>&nbsp;</p>
      <p>Depot Livret 1</p></td>
      <td width="169" valign="bottom"><input type="text" name="l1_a" id="l1_a" /></td>
      <td width="65" valign="bottom">Taux</td>
      <td width="193" valign="bottom"><input type="text" name="l1_t" id="l1_t" /></td>
    </tr>
    <tr>
      <td valign="bottom"><p>&nbsp;</p>
      <p>Depot Livret 2</p></td>
      <td valign="bottom"><input type="text" name="l2_a" id="l2_a" /></td>
      <td valign="bottom">Taux</td>
      <td valign="bottom"><input type="text" name="l2_t" id="l2_t" /></td>
    </tr>
    <tr>
      <td valign="bottom"><p>&nbsp;</p>
      <p>Année</p></td>
      <td colspan="3" align="center" valign="bottom"><input type="text" name="anne" id="anne" /></td>
    </tr>
    <tr>
      <td colspan="4" align="center" valign="bottom"><p>&nbsp;
        </p>
        <p>
          <input type="submit" name="button" id="button" value="Envoyer" />
      </p></td>
    </tr>
  </table>
</form>
</body>
</html>