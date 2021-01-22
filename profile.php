<?php
//ข้อมูลสมาชิก
Template::render('./template/header.php');

//ตรวจสอบค่า post ถ้ามีค่าแสดงว่าบันทึกข้อมูล
if($_POST){
	$data['member_full_name'] = $_POST['member_full_name'];//ชื่อ-นามสกุล
	$data['member_tel'] = $_POST['member_tel'];//เบอร์โทร
	$data['member_password'] = $_POST['member_password'];//รหัสผ่าน
	$data['member_email'] = $_POST['member_email'];//อีเมล์
	$data['id_card'] = $_POST['id_card'];//หมายเลขบัตร
	$data['address'] = $_POST['address'];//mujvp^j
	$data['tel'] = $_POST['tel'];
	$data['province'] = $_POST['province'];//จังหวัด'
	db::update('member',$data,array('member_id'=>$_SESSION['member_login_id']));
	$error = '<script> alert("แก้ไขข้อมูลเรียบร้อย"); </script>';
	
}
echo $error;
$rows = db::select('member',array('member_id'=>$_SESSION['member_login_id']));//ดึงข้อมูลสมาชิก
?>
<div class="container body-content">
	<div class="row">
		<div class="col-xs-12">
  			<ul class="breadcrumb">
      			<li class="active">ข้อมูลส่วนตัว</li>
    		</ul>
  		</div>
   	</div>
	<div class="row" style="">
  		<div class="col-sm-3"><? include('menu-member.php'); ?></div>
  		<div class="col-sm-6">
  			<div class="box-login" style="">
  				<form method="post" style="padding: 15px;" enctype="multipart/form-data" onsubmit="return chkFrom()">
  					<div class="form-group">
	    				<label>ชื่อ-นามสกุล</label>
	    				<input type="text" name="member_full_name" value="<?=$rows[0]['member_full_name']?>" class="form-control" required >
	  				</div>
	  				<div class="form-group">
   						<label>หมายเลขบัตรประชาชน :</label>
	      				<input type="text" name="id_card" id="id_card" maxlength="13" value="<?=$rows[0]['id_card']?>" class="form-control"  required>
	    			</div>
	    			<div class="form-group">
   						<label>ที่อยู่ :</label>
	      				<textarea class="form-control" name="address"><?=$rows[0]['address']?></textarea>
  					</div>
  					<div class="form-group">
   						<label>จังหวัด :</label>
	    				<div>
	      					<input type="text" name="province" value="<?=$rows[0]['province']?>" class="form-control"  required>
	    				</div>
  					</div>
  					<div class="form-group">
  						<label>หมายเลขโทรศัพท์ :</label>
	      				<input type="text" name="tel" id="tel" maxlength="10" value="<?=$rows[0]['tel']?>" class="form-control"  required>
  					</div>
  					
  					<div style="border-bottom-style: solid; border-bottom-width: 1px; margin-bottom: 20px; margin-top: 35px; border-bottom-color: #d9d9d9;">
  						
  					</div>
	  				<div class="form-group">
	    				<label>อีเมล์</label>
	    				<input type="text" name="member_email" value="<?=$rows[0]['member_email']?>" class="form-control" required readonly >
	  				</div>
	  				<div class="form-group">
	    				<label>รหัสผ่าน</label>
	    				<input type="password" name="member_password" id="member_password" value="<?=$rows[0]['member_password']?>" class="form-control" required >
	  				</div>
	  				<div class="form-group">
	    				<label>ยืนยันรหัสผ่าน</label>
	    				<input type="password" name="member_password_cofirm" id="member_password_cofirm" value="<?=$rows[0]['member_password']?>" class="form-control" required >
	  				</div>
	  				<button type="submit" class="btn btn-primary but_color1">บันทึก</button>
				</form>
			</div>
		</div>
		<div class="col-xs-1 col-sm-3"></div>
	</div>
</div>
<script>
//เช็ต form
function chkFrom(){
	c = $("#id_card").val();
	c_id = checkID(c);
	
	p = $("#tel").val();
	c_p = isPhoneNo(p);
	//alert(c_id);
	if($("#member_password").val()!=$("#member_password_cofirm").val()){
		alert("ยืนยันรหัสผ่านไม่ถูกต้อง");
		return false;
	}else if(!c_id){
		alert("หมายเลขบัตรประชาชนไม่ถูกต้อง");
		return false;
	}else if(!c_p){
		alert("รูปแบบเบอร์โทรไม่ถูกต้อง");
		return false;
	}
	
}

//เช็คหมายเลขบัตร
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
<style>
    .img-circle {
        border-radius: 50%;
    }
</style>
<?php
Template::render('./template/footer.php');
?>