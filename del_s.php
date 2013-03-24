<?php
session_start();
$_SESSION = array();
unset($_SESSION);
echo "<br /><br />SESSION DETRUITE !";
echo "<br /><br />SESSION DETRUITE !";
?>