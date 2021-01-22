<?php
//เพิ่มข้อมูลการจอง
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
//function save ข้อมูล
function save(){
	$date = $_POST['date'];//วันที่
	$room_number = $_POST['booking_room_number'];//หมายเลขห้อง
	$room_type_id = $_POST['room_type_id'];//ประเภทห้อง
	$member_id = $_POST['member_id'];//สมาชิก
	
	$date_ex = explode('-',$date);//จัดรูปแบบวันท่
	$start_day = DateDB(trim($date_ex[0]));
	$end_day = DateDB(trim($date_ex[1]));

	$data['room_type_id'] = $room_type_id;
	$data['member_id'] = $member_id;
	$data['booking_in_date'] = $start_day.' 12:00:00';
	$data['booking_out_date'] = $end_day.' 11:00:00';
	$data['booking_room_number'] = $room_number;
	$data['booking_amount'] = '';
	$data['booking_cash_pledge'] = '';
	$data['booking_status'] = '1';
	$data['booking_date'] = date('Y-m-d H:i:s');
	$rows = check_room_availability($data['booking_in_date'],$data['booking_out_date'],$room_type_id);//ตรวจสอบสถานะห้อง
	$error = '';
	
	//ถ้าจำนวนห้องที่จองนว่างน้องกว่าห้องจึงขึ้นแจ้งเตื่อน
	if(count($rows)<$room_number){
		$error = 'ไม่สามารถจองได้ เนื่องจากวันที่ '.$start_day.' - '.$end_day.' ไม่มีห้องว่่าง';
	}

	$room_type = db::select('room_type',array('room_type_id'=>$data['room_type_id']));
	$member = db::select('member',array('member_id'=>$_SESSION['member_login_id']));

	$data['booking_amount'] = $room_type[0]['room_type_price']*$room_number;
	$data['booking_cash_pledge'] = $room_type[0]['room_type_deposit']*$room_number;
	
	//error เท่ากับค่าว่างจึง insert
	if($error==''){
		db::insert('booking',$data);
		$sql = 'SELECT MAX(booking_id) AS m FROM booking';
		$dbarr = db::fetch($sql);
		$m_id = $dbarr[0]['m'];
		$order_id =  str_pad($dbarr[0]['m'],7,'0',STR_PAD_LEFT);
		for($i=0;$i<=($room_number-1);$i++){
		//echo $rows[$i]['room_id'];
			db::insert('booking_room',array(
									'booking_id' => $m_id,
									'room_id' => $rows[$i]['room_id'],
									'booking_room_start_date' => $data['booking_in_date'],
									'booking_room_end_date' => $data['booking_out_date'],
									'booking_room_status' => '1'
								));
		}
	}
	
	return $error;
}

if($_POST){
	$error = save();
}

$type = db::select('room_type');
$member = db::fetch('SELECT * FROM member ORDER BY member_full_name');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Booking</li>
</ol>
<div class="col-xs-1"></div>
<div class="col-xs-6">
 <?php if($error!='' and $_POST){ ?>
    <div class="alert alert-danger">
  		<strong><?=$error?></strong>
	</div>
	<?php }else if($error=='' and $_POST){ ?>
	<div class="alert alert-success">
  		<strong>บันทึกการจองของคุณเรียบร้อย หมายเลขการจอง : <?=$order_id?></strong>
	</div>
	<? } ?>
<!----------->
<form method="post">
  <div class="form-group">
    <label for="pwd">สมาชิก :</label>
    <select name="member_id" class="form-control" required>
    	<option value="">เลือก</option>
    <?
    if(count($member)>0){
		foreach($member as $val){
	?>
		<option value="<?=$val['member_id']?>" ><?=$val['member_full_name']?></option>
	<?		
		}
	}
    ?>
    </select>
  </div>
  <div class="form-group">
    <label for="email">ประเภทห้องพัก :</label>
    <select name="room_type_id" class="form-control" required>
    	<option value="">เลือก</option>
    <?
    if(count($type)>0){
		foreach($type as $val){
	?>
		<option value="<?=$val['room_type_id']?>" <? if($id==$val['room_type_id']){ ?>selected<? } ?> ><?=$val['room_type_name']?></option>
	<?		
		}
	}
    ?>
    </select>
  </div>
  <div class="form-group">
    <label for="pwd">วันที่เข้าพัก :</label>
    <input type="text" name="date" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="pwd">จำนวนห้อง :</label>
    <input type="number" name="booking_room_number" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-default">Booking</button>
</form> 
<!--------->
</div>
<div class="col-xs-3"></div>
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