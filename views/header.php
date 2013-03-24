<?
 // Si le nom du fichier apparait dans l'URL, on affiche un message d'erreur.
if (stristr("header.php", $_SERVER['PHP_SELF'])) {
      exit(1);
      exit(0404);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ProGameMap - {$Titre}</title>
<script type="text/javascript" src="/public/js/mootools.js"></script> 
<script type="text/javascript" src="/public/js/mysql_debug.js"></script> 
<script type="text/javascript" src="/public/js/global.js"></script>
<script type="text/javascript" src="/public/js/overlay3.js"></script>
<script type="text/javascript" src="/public/js/rating.js"></script>
<link rel="stylesheet" type="text/css" href="/public/css/rating.css">
<link rel="stylesheet" type="text/css" href="/public/css/stylev2.css">
<link rel="stylesheet" type="text/css" href="/public/css/mysql_debug.css">
<style type="text/css">
<!--
.calque {
	opacity:.80;
	color: #FFFFFF;
	position: fixed;
	top: 0px;
	visibility : hidden;
	padding: 0px;
	font-family: Courrier;
	align: center;
	font-size: 8pt;
	background-color: #000000;
	opacity : .75;
	filter : alpha(opacity=75);
	width: 100%;
	height : 100%;
top : expression(document.body.scrollTop + this.offsetHeight - this.offsetHeight);
	position : expression("absolute");
	width : expression("100%");
	left : expression("0px");
	left : 0;
}
.image_calque {
	height: 100%;
}
.window {
	color: #FFFFFF;
	position: fixed;
	top: 30px;
	visibility : hidden;
	padding: 0px;
	font-family: Courrier;
	align: center;
	font-size: 8pt;
	background-color: #FFFFFF;
	width: 100%;
	height : 100%;
top : expression(document.body.scrollTop + this.offsetHeight - this.offsetHeight + 30);
	position : expression("absolute");
	width : expression("508px");
left : expression(this.offsetHeight/2-280);
	left : 0;
	z-index: 1000;
}
.contemp_window {
	width: 100%;
	height : 100%;
	border : 0;
}
-->
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!--Header Start-->
<table width="985" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
        <td width="470"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/logo2.jpg" alt="" width="470" height="110" border="0"></td>
        <td align="right">&nbsp;</td>
    </tr>
</table>
<!--Header End-->

<!--Head Bar Start-->
<table width="985" border="0" align="center" cellpadding="0" cellspacing="0" background="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_12.jpg">
    <tr> 
        <td width="511">
            <a href="" title=""><img alt="Vid&eacute;os et DVD" width="144" height="30" border="0"></a>
        </td>
        <td align="right"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_14.jpg" width="18" height="30" alt=""></td>
        <td width="260"><img src="http://<? echo $_SERVER['HTTP_HOST']; ?>/public/images/videos_15.jpg" width="260" height="30" alt="Espace membre"></td>
    </tr>
</table>
<!--Head Bar End-->
