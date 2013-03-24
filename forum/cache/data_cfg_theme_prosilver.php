<?php
if (!defined('IN_PHPBB')) exit;
$expired = (time() > 1286377357) ? true : false;
if ($expired) { return; }

$data =  unserialize('a:5:{s:4:"name";s:9:"prosilver";s:9:"copyright";s:24:"&copy; phpBB Group, 2007";s:7:"version";s:5:"3.0.5";s:14:"parse_css_file";b:1;s:8:"filetime";i:1254832879;}');

?>