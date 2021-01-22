<?php
Template::render('./template/header.php');
include('./fc/fc-booking.php');
$date = $_POST['daterange'];
$room_number = $_POST['room_number'];
$room_type_id = $_POST['room_type_id'];

$date_ex = explode('-',$date);
$start_day = DateDB(trim($date_ex[0]));
$end_day = DateDB(trim($date_ex[1]));

$data['room_type_id'] = $room_type_id;
$data['member_id'] = $_SESSION['member_login_id'];
$data['booking_in_date'] = $start_day.' 12:00:00';
$data['booking_out_date'] = $end_day.' 11:00:00';
$data['booking_room_number'] = $room_number;
$data['booking_amount'] = '';
$data['booking_cash_pledge'] = '';
$data['booking_status'] = '0';
$data['booking_date'] = date('Y-m-d H:i:s');

$rows = check_room_availability($data['booking_in_date'],$data['booking_out_date'],$room_type_id);
$error = '';
if(count($rows)<$room_number){
	$error = 'ไม่สามารถจองได้ เนื่องจากวันที่ '.$start_day.' - '.$end_day.' ไม่มีห้องว่่าง';
}

$room_type = db::select('room_type',array('room_type_id'=>$data['room_type_id']));
$member = db::select('member',array('member_id'=>$_SESSION['member_login_id']));

$night = DateDiff($data['booking_in_date'],$data['booking_out_date']);
?>
<div class="col-xs-3"></div>
<div class="col-xs-6">
	<ul class="breadcrumb">
      	<li class="active">Booking</li>
    </ul>
    <!-------------->
    <?php if($error!=''){ ?>
    <div class="alert alert-danger">
  		<strong><?=$error?></strong>
	</div>
	<?php } ?>
    <table class="table table-bordered">
    	<tbody>
    		<tr>
    			<td width="50%">วันที่เข้าพัก</td>
    			<td><?=$date?></td>
    		</tr>
    		<tr>
    			<td width="50%">จำนวน</td>
    			<td><?=DateDiff($data['booking_in_date'],$data['booking_out_date'])?> คืน</td>
    		</tr>
    		<tr>
    			<td width="50%">ประเภทห้องพัก</td>
    			<td><?=$room_type[0]['room_type_name']?></td>
    		</tr>
    		<tr>
    			<td>จำนวนห้อง</td>
    			<td><?=$data['booking_room_number']?> ห้อง</td>
    		</tr>
    		<tr>
    			<td>จำนวนคนที่สามารถเข้าพักได้</td>
    			<td><?=$room_type[0]['room_type_people']?> คน/ห้อง</td>
    		</tr>
    		<tr>
    			<td>ค่าใช้จ่ายทั้งหมด</td>
    			<td><?=number_format(($room_type[0]['room_type_price']*$data['booking_room_number'])*$night)?> บาท</td>
    		</tr>
    		<tr>
    			<td>จำนวนเงินที่ต้องชำระ(ค่ามันจำ)</td>
    			<td><?=number_format($room_type[0]['room_type_deposit']*$data['booking_room_number'])?> บาท</td>
    		</tr>
    	</tbody>
  	</table>
  	<ul class="breadcrumb">
      	<li class="active">ข้อมูลสมาชิก</li>
    </ul>
    <table class="table table-bordered">
    	<tbody>
    		<tr>
    			<td width="50%">ขื่อ-นามสกุล</td>
    			<td><?=$member[0]['member_full_name']?></td>
    		</tr>
    		<tr>
    			<td>ที่อยู่</td>
    			<td><?=$member[0]['address']?></td>
    		</tr>
    		<tr>
    			<td>จังหวัด</td>
    			<td><?=$member[0]['province']?></td>
    		</tr>
    		<tr>
    			<td>เบอร์โทร</td>
    			<td><?=$member[0]['tel']?></td>
    		</tr>
    		<tr>
    			<td>อีเมล์</td>
    			<td><?=$member[0]['member_email']?></td>
    		</tr>
    	</tbody>
  	</table>
    <!-------------->
    <div style="text-align: center;">
    	<? if($error==''){ ?>
    	<form method="post" action="index.php?f=booking-save">
    		<input type="hidden" name="room_type_id" value="<?=$data['room_type_id']?>"/>
    		<input type="hidden" name="date" value="<?=$date?>"/>
    		<input type="hidden" name="booking_room_number" value="<?=$data['booking_room_number']?>"/>
    		<button type="submit" class="btn btn-primary">บันทึกการจอง</button>
    	</form>
    	<br><br>
    	<? } ?>
    </div>
</div>
<div class="col-xs-3"></div>
<?php
Template::render('./template/footer.php');
?>