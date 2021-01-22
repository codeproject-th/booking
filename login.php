<?php
//เข้าสู่ระบบ
if($_POST){
	$rows = db::select('member',array('member_email'=>$_POST['email'],'member_password'=>$_POST['password']));//ค้าหาข้อมูล email และ password
	//rows มากกว่า 0 แสดงว่าlogin ถูกต้อง
	if($rows>0){
		$_SESSION['member_login_id'] = $rows[0]['member_id'];//เก็บ id สมาชิกลง session
		echo '<meta http-equiv="refresh" content="0; url=index.php" />';
	}else{
		$error = 'ชื่อผู้ใช้ หรือรหัสผ่านไม่ถูกต้อง';
	}
}

Template::render('./template/header.php');

?>
<div class="col-xs-3"></div>
<div class="col-xs-6">
	<ul class="breadcrumb">
      	<li class="active">เข้าสู่ระบบ</li>
    </ul>
	<form class="form-horizontal" method="post" style="padding-top: 20p;x">
		<div class="form-group">
			<label class="control-label col-sm-2" for="email">Email:</label>
			<div class="col-sm-10">
			    <input type="email" name="email" class="form-control" id="email" placeholder="Enter email">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="pwd">Password:</label>
			<div class="col-sm-10">
			     <input type="password" name="password" class="form-control" id="pwd" placeholder="Enter password">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			     <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
			</div>
		</div>
	</form>
	<div style="color: #ff0000; text-align: center;"><?=$error;?></div>
	<div style="border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color:#e5e5e5; margin-bottom: 20px;">&nbsp;</div>
	<div style="text-align: center;">
		<a href="index.php?f=register">สมัครสมาชิก</a>
	</div>
 </div>
<div class="col-xs-3"></div>  		

<?
Template::render('./template/footer.php');
?>