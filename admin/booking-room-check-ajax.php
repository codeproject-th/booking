<?php
//ajax เช็คข้อมูลการจอง
include('./../fc/fc-booking.php');
	
$date = $_POST['date'];
$room_id = $_POST['room_id'];	
$date_ex = explode('-',$date);
$start_day = DateDB(trim($date_ex[0]));
$end_day = DateDB(trim($date_ex[1]));
	
$where = ' booking_room.room_id="'.$room_id.'"';
if($start_day!='' and $end_day!=''){
	$data['booking_in_date'] = $start_day.' 12:00:00';
	$data['booking_out_date'] = $end_day.' 11:00:00';
	$where .= ' AND booking_room.booking_room_start_date>="'.$data['booking_in_date'].'" AND booking_room.booking_room_end_date<="'.$data['booking_out_date'].'" ';
}

$sql = "SELECT booking_room.* , room.room_code , member.member_id , member.member_full_name FROM booking_room 
		LEFT JOIN room ON room.room_id = booking_room.room_id
		LEFT JOIN booking ON booking.booking_id = booking_room.booking_id
		LEFT JOIN member ON booking.member_id = member.member_id
		WHERE ".$where." AND booking_room.booking_room_status!=2";
$rows = db::fetch($sql);
if(count($rows)>0){
	echo '<table class="table table-bordered">';
	echo '<tr>
			<td style="text-align: center;">หมายเลขห้อง</td>
			<td style="text-align: center;">รหัสจอง</td>
			<td style="text-align: center;">ผู้จอง</td>
			<td></td>
		</tr>';
	foreach($rows as $val){
?>
	<tr>
		<td style="text-align: center;"><?=$val['room_code']?></td>
		<td style="text-align: center;"><?=str_pad($val['booking_id'],7,'0',STR_PAD_LEFT)?></td>
		<td style="text-align: center;"><?=$val['member_full_name']?></td>
		<td style="text-align: center;"><a href="index.php?f=booking-edit&id=<?=$val['booking_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a></td>
	</tr>
<?		
	}
	echo '</table>';
}
?>