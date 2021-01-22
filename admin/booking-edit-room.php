<?php
include('./../fc/fc-booking.php');
$booking_room_id = $_POST['booking_room_id'];
$sql = 'SELECT booking_room.* , room.room_type_id , room.room_code  FROM booking_room
		LEFT JOIN room ON booking_room.room_id=room.room_id
		WHERE booking_room.booking_room_id="'.$booking_room_id.'"';
//echo $sql;
$data = db::fetch($sql);
$rows = check_room_availability($data[0]['booking_room_start_date'],$data[0]['booking_room_end_date'],$data[0]['room_type_id']);
//print_r($rows);
?>

    <option value="<?=$data[0]['room_id']?>"><?=$data[0]['room_code']?></option>
    <? if(count($rows)>0){ 
    	foreach($rows as $val){
	
	?>
	  <option value="<?=$val['room_id']?>"><?=$val['room_code']?></option>		
    <? 
    	}
    } ?>
