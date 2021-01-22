<?php
$menu_rows = db::select('content',array('content_code'=>'0'),'*','ORDER BY content_no');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../js/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/admin/admin.css">
  <link rel="stylesheet" href="./../css/font-awesome/css/font-awesome.min.css">
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
  <script type="text/javascript" src="./../js/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="./../js/daterangepicker/moment.min.js"></script>
  <!-- Include Date Range Picker -->
  <script type="text/javascript" src="./../js/daterangepicker/daterangepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="./../js/daterangepicker/daterangepicker.css" />
</head>
<body>
<div class="container">
	<div class="row" style="background-color: #293339; padding-top: 20px;  padding-bottom: 20px;">
		<div class="col-xs-2">
			<img src="./../images/logo-u.png" class="img-responsive" width="120">
		</div>
		<div class="col-md-10">
			<div style="font-size: 20px; margin-top: 20px; color: #ffffff;">
				เว็บจองห้องพักบนอินเตอร์เน็ต
				<br>
				Online Hotel Booking System 
			</div>
		</div>
	</div>
	<div class="row" style=" background-color: #ffffff;">
		<div class="col-md-2" style="background-color: #ffffff; padding: 0px;" id="MenuLeft">
			<?php include('menu.php') ?>
		</div>
  		<div class="col-md-10 page-right" id="content-left" style="min-height: 600px;">