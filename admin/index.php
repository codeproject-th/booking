<?php
session_start();
include("../config.php");
include("../libs/db.php");
include("../libs/date.php");
include("../libs/template.php");

db::open();

if($_SESSION['admin_id']==''){
	echo '<script> window.location = "login.php"; </script>';
	exit;
}

$f = $_GET['f'];
if($f==""){
	$f = "main";
}
$f = str_replace(array('.','/','\\'),'',$f);
include($f.".php");
?>