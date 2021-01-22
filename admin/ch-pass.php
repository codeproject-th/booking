<?php
//เปลี่ยนรหัสผ่าน
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
if($_POST){
	db::update('users',array('users_pass'=>$_POST['users_pass1']),array('users_id'=>$_SESSION['admin_id']));
	$error = '<script> alert("บันทึกข้อมูลเรียบร้อย"); </script>';
	echo $error;
}

$id = $_GET['id'];
$title = "เปลี่ยนรหัสผ่าน";
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active"><?=$title?></li>
</ol>
<div class="col-xs-1">

</div>
<div class="col-xs-6">
<!---------------------->
	<div class="box-login" style="margin-bottom: 50px;">
		<form method="post" style="padding: 15px;" enctype="multipart/form-data" onsubmit="return chkFrom()">
  			<div class="form-group">
   				<label>รหัสผ่านใหม่ :</label>
	    		<div>
	      			<input type="password" name="users_pass1" class="form-control"  required>
	    		</div>
  			</div>
  			<div class="form-group">
   				<label>ยืนยันรหัสผ่านใหม่ :</label>
	    		<div>
	      			<input type="password" name="users_pass2" class="form-control"  required>
	    		</div>
  			</div>
	  		<button type="submit" class="btn btn-primary but_color1">บันทึก</button>
		</form>
	</div>
<!---------------------->
</div>
<div class="col-xs-3">

</div>
<script>
function chkFrom(){
	if($("input[name=users_pass1]").val()!=$("input[name=users_pass2]").val()){
		alert('ยืนยันรหัสผ่านไม่ถูกต้อง');
		return false;
	}
}
</script>
<?
Template::render('./../template-admin/footer.php');
?>