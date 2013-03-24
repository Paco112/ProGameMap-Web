<?php

$_SESSION['conf_sbox']['debug'] = true;
$_SESSION['conf_sbox']['debug_max'] = true;
$_SESSION['conf_sbox']['timer'] = true;

include("include/class/sbox.php");

$_SESSION['conf_sbox']['debug'] = true;
$_SESSION['conf_sbox']['debug_max'] = true;
$_SESSION['conf_sbox']['timer'] = true;

$set[]['test1'] = 1;
$set[]['test2'] = 2;

echo $sbox->update(array("table"=>"test","set"=>$set,'where'=>'id=/id1/'));

?>