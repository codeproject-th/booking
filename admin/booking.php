<?php
//การจอง
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
//function ค้นหาการจอง
function search(){
	$booking_id = $_GET['booking_id'];//id การจอง
	$date = $_GET['date'];//วันที่
	$room_type_id = $_GET['room_type_id'];//ประเภทห้อง
	$member_id = $_GET['member_id'];//id สมาชิก
	
	$date_ex = explode('-',$date);
	$start_day = DateDB(trim($date_ex[0]));
	$end_day = DateDB(trim($date_ex[1]));
	
	$where = ' 1=1 ';
	//ถ้าวันที่ไม่ว่างให้เติมเงื่อนไขค้นหสตามเวลา
	if($start_day!='' and $end_day!=''){
		$data['booking_in_date'] = $start_day.' 12:00:00';
		$data['booking_out_date'] = $end_day.' 11:00:00';
		$where .= ' AND booking.booking_in_date>="'.$data['booking_in_date'].'" AND booking.booking_in_date<="'.$data['booking_out_date'].'" ';
	}
	
	//เพิ่มเงื่อนไขการค้นหาตามประเภทห้อง
	if($room_type_id!=''){
		$where .= ' AND booking.room_type_id="'.$room_type_id.'"';
	}
	//เพิ่มเงื่อนไขการค้นหาตามสมาชิก
	if($member_id!=''){
		$where .= ' AND booking.member_id="'.$member_id.'"';
	}
	//เพิ่มเงื่อนไขการค้นหาหมายเลขการจอง
	if($booking_id!=''){
		$booking_id = str_replace(',','',number_format($booking_id));
		$where .= ' AND booking.booking_id="'.$booking_id.'"';
	}
	
	
	//จัดคำสั่งค้นหา
	$sql = "SELECT booking.* , member.member_full_name FROM booking 
		LEFT JOIN member ON booking.member_id=member.member_id
		WHERE ".$where."
		ORDER BY booking.booking_date DESC
		";
	return $sql;
}

$sql = "SELECT booking.* , member.member_full_name FROM booking 
		LEFT JOIN member ON booking.member_id=member.member_id
		ORDER BY booking.booking_date DESC
		";
$rows = db::fetch(search());//ค้นหาการจอง
$status = status_booking();

$type = db::select('room_type');//ดึงประเภทห้อง
$member = db::fetch('SELECT * FROM member ORDER BY member_full_name');//ดึงสมาชิก
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Booking</li>
</ol>
<form method="get">
	<div class="form-group">
    	<label for="pwd">หมายเลขการจอง :</label>
    	<input type="text" name="booking_id" value="<?=$_GET['booking_id']?>" class="form-control">
  	</div>
	<div class="form-group">
    <label for="pwd">สมาชิก :</label>
    <select name="member_id" class="form-control">
    	<option value="">เลือก</option>
    <?
    if(count($member)>0){
		foreach($member as $val){
	?>
		<option value="<?=$val['member_id']?>" <? if($_GET['member']==$val['member_id']){ ?>selected<? } ?> ><?=$val['member_full_name']?></option>
	<?		
		}
	}
    ?>
    </select>
  	</div>
	<div class="form-group">
    <label for="email">ประเภทห้องพัก :</label>
    <select name="room_type_id" class="form-control">
    	<option value="">เลือก</option>
    <?
    if(count($type)>0){
		foreach($type as $val){
	?>
		<option value="<?=$val['room_type_id']?>" <? if($_GET['room_type_id']==$val['room_type_id']){ ?>selected<? } ?> ><?=$val['room_type_name']?></option>
	<?		
		}
	}
    ?>
    </select>
  </div>
  <div class="form-group">
    <label for="pwd">วันที่เข้าพัก :</label>
    <input type="text" name="date" value="<?=$_GET['date']?>" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
  <br><br><br>
  <input type="hidden" name="f" value="booking"/>
</form>
<a href="index.php?f=booking-add"><button type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม</button></a>
<br><br>
<table class="table table-bordered">
    <thead>
      <tr>
        <th width="5%" style="text-align: center;">No</th>
        <th width="17%" style="text-align: center;">หมายเลขการจอง</th>
        <th width="20%" style="text-align: center;">ผู้จอง</th>
        <th width="10%" style="text-align: center;">จำนวนห้อง</th>
        <th width="22%" style="text-align: center;">วันที่เข้าพัก</th>
        <th width="20%" style="text-align: center;">สถานะ</th>
        <th width="10%" style="text-align: center;">แก้ไข/ลบ</th>
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
    		<td style="text-align: center;"><?=str_pad($val['booking_id'],7,'0',STR_PAD_LEFT)?></td>
    		<td><?=$val['member_full_name']?></td>
    		<td style="text-align: center;"><?=$val['booking_room_number']?></td>
    		<td style="text-align: center;"><?=DateTimeTH($val['booking_in_date'])?> - <?=DateTimeTH($val['booking_out_date'])?></td>
    		<td style="text-align: center;"><?=$status[$val['booking_status']]?></td>
    		<td style="text-align: center;">
    			<a href="index.php?f=booking-edit&id=<?=$val['booking_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
    			<a href="index.php?f=booking-delete&id=<?=$val['booking_id']?>" onclick="return confirm('ลบข้อมูล')"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>
    		</td>
    	</tr>
    <? 
    	}
    } ?>
    </tbody>
</table>
<script>
$('input[name="date"]').daterangepicker({
    opens: "center",
    drops: "up",
    locale: {
           format: 'DD/MM/YYYY'
	}
});
</script>
<?
Template::render('./../template-admin/footer.php');
?>