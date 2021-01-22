<?php
//รายละเอียดการจองของสมาชิกที่ login
Template::render('./template/header.php');
include('./fc/fc-booking.php');//เรียกรวมไฟล์ function
function search(){
	//function การค้นหา
	$booking_id = $_GET['booking_id'];//หมายเลขการจอง
	$date = $_GET['date'];//วันท่
	$room_type_id = $_GET['room_type_id'];//id ประเภทห้อง
	$member_id = $_GET['member_id'];//id สมาชิก 
	
	$date_ex = explode('-',$date);//จัดรูปแบบวันที่
	$start_day = DateDB(trim($date_ex[0]));//จัดรูปแบบวันที่
	$end_day = DateDB(trim($date_ex[1]));//จัดรูปแบบวันที่
	
	$where = ' 1=1 ';
	$where .= ' AND booking.member_id="'.$_SESSION['member_login_id'].'"';
	
	$sql = "SELECT booking.* , member.member_full_name FROM booking 
		LEFT JOIN member ON booking.member_id=member.member_id
		WHERE ".$where."
		ORDER BY booking.booking_date DESC
		"; //ตำสั้ง sql ดึงข้อมูล
	return $sql;
}
$status = status_booking();

$rows = db::fetch(search());
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
  		<div class="col-sm-3"><? include('menu-member.php'); //เรียกใช้ไฟล์menuสมาชิก ?></div>
  		<div class="col-sm-9">
<!------------------------------------------->
<table class="table table-bordered">
    <thead>
      <tr>
        <th width="5%" style="text-align: center;">No</th>
        <th width="17%" style="text-align: center;">หมายเลขการจอง</th>
        <th width="20%" style="text-align: center;">ผู้จอง</th>
        <th width="10%" style="text-align: center;">จำนวนห้อง</th>
        <th width="22%" style="text-align: center;">วันที่เข้าพัก</th>
        <th width="20%" style="text-align: center;">สถานะ</th>
        
      </tr>
    </thead>
    <tbody>
    <? if(count($rows)>0){ 
    	$n = 0;
    	foreach($rows as $val){
    		$n++;
    ?>
    	<tr>
    		<td style="text-align: center;"><?=$n?></td>
    		<td style="text-align: center;"><a href="index.php?f=history-booking-view&id=<?=$val['booking_id']?>"><?=str_pad($val['booking_id'],7,'0',STR_PAD_LEFT)?></a></td>
    		<td><?=$val['member_full_name']?></td>
    		<td style="text-align: center;"><?=$val['booking_room_number']?></td>
    		<td style="text-align: center;"><?=DateTimeTH($val['booking_in_date'])?> - <?=DateTimeTH($val['booking_out_date'])?></td>
    		<td style="text-align: center;"><?=$status[$val['booking_status']]?></td>
    	</tr>
    <? 
    	}
    } ?>
    </tbody>
</table>
<!------------------------------------------->  			
		</div>
		
	</div>
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