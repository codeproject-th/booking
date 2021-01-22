<?php
$menu_rows = db::select('content',array('content_code'=>'0'),'*','ORDER BY content_no');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="./js/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/web/web.css">
  <link rel="stylesheet" href="./css/font-awesome/css/font-awesome.min.css">
  
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
  <script type="text/javascript" src="./js/daterangepicker/moment.min.js"></script>
  <!-- Include Date Range Picker -->
  <script type="text/javascript" src="./js/daterangepicker/daterangepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="./js/daterangepicker/daterangepicker.css" />
</head>
<body>
<div class="">
	<div class="container">
		<div class="row">
			<div class="col-xs-2" style="">
				<img src="./images/hotel-logo.png" class="img-responsive" width="100">
			</div>
			<div class="col-xs-3">
				<div style="font-size: 20px; margin-top: 20px;">
					เว็บจองห้องพักบนอินเตอร์เน็ต
					<br>
					<font style="font-size: 18px;">Online Hotel Booking System</font>
				</div>
			</div>
			<div class="col-xs-7">
				<div class="header-menu">
					<ul>
						<li><a href="index.php">หน้าแรก</a></li>
						<li><a href="index.php?f=confirm-payment">แจ้งการชำระเงิน</a></li>
						<li><a href="index.php?f=step-booking">วิธีการจอง</a></li>
						<? if($_SESSION['member_login_id']==''){?>
						<li><a href="index.php?f=register">สมัครสมาชิก</a></li>
						<li><a href="index.php?f=login">เข้าสู่ระบบ</a></li>
						<? }else{ ?>
						<li><a href="index.php?f=profile">ข้อมูลส่วนตัว</a></li>
						<li><a href="index.php?f=logout">ออกจากระบบ</a></li>
						<? } ?>
						<li><a href="index.php">จองห้อง</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div>
	<div style="background-color: #f3f3f3; padding: 0px;">
		&nbsp;
	</div>
</div>
<div class="container">
	<div class="row">
  		<div class="col-xs-12 " style="min-height: 600px; padding-top: 20px;">
  
	