<?php
//สมัครสมาชิก
Template::render('./template/header.php');
if($_POST){
	$chk = db::select('member',array('member_email'=>$_POST['member_email']));//ตรวจสอบอีเมล์ซ้ำ
	$max = db::select('member',array(),' MAX(member_id) AS m');
	//ถ่า $chk มีค่าเป็น 0 แสดงว่ายังไม่มีอีเมล์ในระบบ
	if(count($chk)=='0'){
		$data['member_full_name'] = $_POST['member_full_name'];//ชื่อนามสกุล
		$data['member_tel'] = $_POST['member_tel'];//เบอร์โทร
		$data['member_password'] = $_POST['member_password'];//รหัสผ่าน
		$data['member_email'] = $_POST['member_email'];//อีเมล์
		$data['id_card'] = $_POST['id_card'];//บัตรประชาชน]
		$data['address'] = $_POST['address'];//ที่อยู่
		$data['tel'] = $_POST['tel'];
		$data['province'] = $_POST['province'];
		db::insert('member',$data);
		$error = '<script> alert("สมัครสมาชิกเรียบร้อย"); window.location = "index.php?f=login"; </script>';//ไปหน่าlogin
	}else{
		$error = '<script> alert("email มีอยู่ในระบบแล้วไม่สามารถใช้ได้อีก"); </script>';
	}
	echo $error;
}
?>
<div class="col-xs-3">

</div>
<div class="col-xs-6">
<!---------------------->
	<div class="box-login" style="margin-bottom: 50px;">
		<ul class="breadcrumb">
      		<li class="active">สมัครสมาชิก</li>
    	</ul>
		<form method="post" style="padding: 15px;" enctype="multipart/form-data" onsubmit="return chkFrom()">
			<div class="form-group">
	    		<label>ชื่อ-นามสกุล</label>
	    		<input type="text" name="member_full_name" class="form-control" required >
	  		</div>
	  		<div class="form-group">
   				<label>หมายเลขบัตรประชาชน :</label>
	      		<input type="text" name="id_card" id="id_card" class="form-control"  maxlength="13"  required>
	    	</div>
	    	<div class="form-group">
   				<label>ที่อยู่ :</label>
	      		<textarea class="form-control" name="address" required></textarea>
  			</div>
  			<div class="form-group">
   				<label>จังหวัด :</label>
	    		<div>
	      			<input type="text" name="province" class="form-control" required>
	    		</div>
  			</div>
  			<div class="form-group">
  				<label>หมายเลขโทรศัพท์ :</label>
	      		<input type="text" name="tel" id="tel" class="form-control"  maxlength="10" required>
  			</div>
  			<div style="border-bottom-style: solid; border-bottom-width: 1px; margin-bottom: 20px; margin-top: 35px; border-bottom-color: #d9d9d9;">
  			</div>
	  		<div class="form-group">
	    		<label>อีเมล์</label>
	    		<input type="email" name="member_email" class="form-control" required >
	  		</div>
	  		<div class="form-group">
	    		<label>รหัสผ่าน</label>
	    		<input type="password" name="member_password" id="member_password" class="form-control" required >
	  		</div>
	  		<div class="form-group">
	    		<label>ยืนยันรหัสผ่าน</label>
	    		<input type="password" name="member_password_cofirm" id="member_password_cofirm" class="form-control" required >
	  		</div>
	  		
	  		<button type="submit" class="btn btn-primary but_color1">สมัครสมาชิก</button>
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

//ตรวจสอบเบอร์โทร
function isPhoneNo(input){
	var regExp = /^0[0-9]{8,9}$/i;
	return regExp.test(input);
}

</script>
<?
Template::render('./template/footer.php');
?>