<?php
//เพิ่ม user
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
if($_POST){
	$chk = db::select('users',array('users_name'=>$_POST['users_name']));//ดึงข้อมูล user เพื่อตรวจสอบว่ามีในระบบยัง
	$data['users_name'] = $_POST['users_name'];//username
	$data['users_pass'] = $_POST['users_pass'];//password
	$data['users_firstname'] = $_POST['users_firstname'];//ชิ้อ
	$data['users_lastname'] = $_POST['users_lastname'];//นามสกุล
	$data['users_type'] = $_POST['users_type'];//ประเภทuser
	
	if(count($chk)=='0' and $_GET['id']==''){
		if($_GET['id']==''){
			db::insert('users',$data);//insert user
		}
		$error = '<script> alert("บันทึกข้อมูลเรียบร้อย"); </script>';
	}else if($_GET['id']!=''){
		db::update('users',$data,array('users_id'=>$_GET['id']));//update ข้อมูล
		$error = '<script> alert("บันทึกข้อมูลเรียบร้อย"); </script>';
	}
	
	if(count($chk)>'0' and $_GET['id']==''){
		$error = '<script> alert("อีเมล์ซ้ำไม่สามารถสมัครได้อีก"); </script>';
	}
	echo $error;
}

$id = $_GET['id'];
$title = "เพิ่มข้อมูลผู้ใช้งาน";
if($id!=''){
	$title = "แก้ไขข้อมูลผู้ใช้งาน";
	$users_data = db::select('users',array('users_id'=>$id));//ดึงข้อมูลผู้ใช้งาน
	//print_r($member_data);
}
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
	    		<label>ชื่อ</label>
	    		<input type="text" name="users_firstname" value="<?=$users_data[0]['users_firstname']?>" class="form-control" required >
	  		</div>
	  		<div class="form-group">
	    		<label>นามสกุล</label>
	    		<input type="text" name="users_lastname" value="<?=$users_data[0]['users_lastname']?>" class="form-control" required >
	  		</div>
	  		<div class="form-group">
   				<label>สถานะ :</label>
   				<select name="users_type" class="form-control" required>
   					<option value="">เลือก</option>
   					<option value="1" <? if($users_data[0]['users_type']=="1"){ ?>selected<? } ?> >ผู้ดูแลระบบ</option>
   					<option value="2" <? if($users_data[0]['users_type']=="2"){ ?>selected<? } ?>>พนักงาน</option>
   				</select>
	    	</div>
	    	<div class="form-group">
   				<label>Username :</label>
	      		<textarea class="form-control" name="users_name" required><?=$users_data[0]['users_name']?></textarea>
  			</div>
  			<div class="form-group">
   				<label>Password :</label>
	    		<div>
	      			<input type="text" name="users_pass" value="<?=$users_data[0]['users_pass']?>" class="form-control"  required>
	    		</div>
  			</div>
	  		<button type="submit" class="btn btn-primary but_color1">บันทึก</button>
		</form>
	</div>
<!---------------------->
</div>
<div class="col-xs-3">

</div>
<?
Template::render('./../template-admin/footer.php');
?>