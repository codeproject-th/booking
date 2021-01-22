<?php
//เพิ่มสทาชิก
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
if($_POST){
	$chk = db::select('member',array('member_email'=>$_POST['member_email']));//ตรวจสอบอีเมล์
	$max = db::select('member',array(),' MAX(member_id) AS m');
	
	$data['member_full_name'] = $_POST['member_full_name'];//ชื่อ
	$data['member_tel'] = $_POST['member_tel'];//เบอร์โทร
	$data['member_password'] = $_POST['member_password'];//รหัสผ่าน
	$data['member_email'] = $_POST['member_email'];//อีเมล์
	$data['id_card'] = $_POST['id_card'];//บัตรประชาชน
	$data['address'] = $_POST['address'];//ที่อยู่
	$data['tel'] = $_POST['tel'];
	$data['province'] = $_POST['province'];
	
	if(count($chk)=='0' and $_GET['id']==''){
		if($_GET['id']==''){
			db::insert('member',$data);//เพิ่มข้อมูลสมาชิก
		}
		$error = '<script> alert("บันทึกข้อมูลเรียบร้อย"); </script>';
	}else if($_GET['id']!=''){
		db::update('member',$data,array('member_id'=>$_GET['id']));//update ข้อมูลสมาชิก
		$error = '<script> alert("บันทึกข้อมูลเรียบร้อย"); </script>';
	}
	
	if(count($chk)>'0' and $_GET['id']==''){
		$error = '<script> alert("อีเมล์ซ้ำไม่สามารถสมัครได้อีก"); </script>';
	}
	echo $error;
}

$id = $_GET['id'];
$title = "เพิ่มข้อมูลลูกค้า";
if($id!=''){
	$title = "แก้ไขข้อมูลลูกค้า";
	$member_data = db::select('member',array('member_id'=>$id));//ดึงข้อมูลลูกค้า
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
	    		<label>ชื่อ-นามสกุล</label>
	    		<input type="text" name="member_full_name" value="<?=$member_data[0]['member_full_name']?>" class="form-control" required >
	  		</div>
	  		<div class="form-group">
   				<label>หมายเลขบัตรประชาชน :</label>
	      		<input type="text" name="id_card" id="id_card" maxlength="13" value="<?=$member_data[0]['id_card']?>" class="form-control"  required>
	    	</div>
	    	<div class="form-group">
   				<label>ที่อยู่ :</label>
	      		<textarea class="form-control" name="address" required><?=$member_data[0]['address']?></textarea>
  			</div>
  			<div class="form-group">
   				<label>จังหวัด :</label>
	    		<div>
	      			<input type="text" name="province" value="<?=$member_data[0]['province']?>" class="form-control"  required>
	    		</div>
  			</div>
  			<div class="form-group">
  				<label>หมายเลขโทรศัพท์ :</label>
	      		<input type="text" name="tel" id="tel" maxlength="10" value="<?=$member_data[0]['tel']?>" class="form-control"  required>
  			</div>
  			<div style="border-bottom-style: solid; border-bottom-width: 1px; margin-bottom: 20px; margin-top: 35px; border-bottom-color: #d9d9d9;">
  			</div>
	  		<div class="form-group">
	    		<label>อีเมล์</label>
	    		<input type="text" name="member_email" value="<?=$member_data[0]['member_email']?>" class="form-control" required >
	  		</div>
	  		<div class="form-group">
	    		<label>รหัสผ่าน</label>
	    		<input type="password" name="member_password" value="<?=$member_data[0]['member_password']?>" id="member_password" class="form-control" required >
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
	c = $("#id_card").val();
	c_id = checkID(c);
	
	p = $("#tel").val();
	c_p = isPhoneNo(p);
	//alert(c_id);
	if(!c_id){
		alert("หมายเลขบัตรประชาชนไม่ถูกต้อง");
		return false;
	}else if(!c_p){
		alert("รูปแบบเบอร์โทรไม่ถูกต้อง");
		return false;
	}
	
}

function checkID(id){
	var pid = id;
        pid = pid.toString().replace(/\D/g,'');
        if(pid.length == 13){
            var sum = 0;
            for(var i = 0; i < pid.length-1; i++){
            	sum += Number(pid.charAt(i))*(pid.length-i);
            }
            var last_digit = (11 - sum % 11) % 10;
           	if(pid.charAt(12) == last_digit){
				return true
			}
            return false;
       }else{
            return false;
      }
}

function isPhoneNo(input){
	var regExp = /^0[0-9]{8,9}$/i;
	return regExp.test(input);
}

</script>
<?
Template::render('./../template-admin/footer.php');
?>