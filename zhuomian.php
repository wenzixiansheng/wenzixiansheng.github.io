<?php
header('Content-type: text/html; charset=gbk');
require "configs/define.php";
$_17mb_sitename = constant("JIEQI_SITE_NAME");
$_17mb_url = "http://".$_SERVER['HTTP_HOST']."/";
$Shortcut = "[InternetShortcut]
URL=".$_17mb_url."
IDList=
[{000214A0-0000-0000-C000-000000000046}]
Prop3=19,2";
Header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$_17mb_sitename.".url;");
echo $Shortcut;
?>