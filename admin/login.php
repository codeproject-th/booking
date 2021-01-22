<?php
//เข้าสู่ระบบ
session_start();
include("../config.php");
include("../libs/db.php");
include("../libs/date.php");
include("../libs/template.php");
db::open();
if($_POST){
	$rows = db::select('users',array('users_name'=>db::str($_POST['username']),'users_pass'=>db::str($_POST['username'])));//ดึงข้อมูลadmin อ้างอิง usernameและpassword
	if(count($rows)=='0'){
		$error = 'ชื่อผู้ใช้หรือ รหัสผ่านไม่ถูกต้อง';
	}else{
		$_SESSION['admin_id'] = $rows[0]['users_id'];
		$_SESSION['admin_type'] = $rows[0]['users_type'];
		echo '<script> window.location = "index.php?f=main"; </script>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../js/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/admin/login.css">
</head>
<body>
<div class="container">
	<div class="row">
  		<div class="col-sm-4">
  		
  		</div>
  		<div class="col-sm-4">
  		<!------------------------>
  			<div class="box">
  			<div style="text-align: center;">
  				<img src="../images/user.png" width="80">
  				<div class="admin-login">
  					ADMIN LOGIN
  				</div>
  			</div>
	  			<form method="post">
	  				<label>Username :</label>
					<div class="form-group has-feedback">
				        <input type="text" name="username" class="form-control" placeholder="ชื่อผู้ใช้">     
				    </div>
				    <label>Password :</label>
				    <div class="form-group has-feedback">
				    	<input type="password" name="password" class="form-control" placeholder="รหัสผ่าน">  
				    </div>
		          	<button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
			        <div style="text-align: center; color: #ff0000; margin-top: 10px;">
			        	<?=$error?>
			        </div>
		    	</form>
	    	</div>
  		<!------------------------>
  		</div>
  		<div class="col-sm-4">
  		
  		</div>
	</div>
</div>
</body>
</html>
