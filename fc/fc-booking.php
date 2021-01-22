<?php

function check_room_availability($start_date='',$end_date='',$room_type=''){
	$sql = 'SELECT * FROM room WHERE 
			room_id NOT IN(
						SELECT booking_room.room_id FROM booking_room 
							INNER JOIN room ON booking_room.room_id = room.room_id
							WHERE booking_room.booking_room_start_date>="'.$start_date.'" AND booking_room.booking_room_end_date<="'.$end_date.'" 
							AND booking_room.booking_room_status !="2" AND room.room_type_id="'.$room_type.'"
						) 
			AND room_type_id="'.$room_type.'"';
	
	return db::fetch($sql);			
}

function status_booking(){
	$arr = array(
					0 => 'รอดำเนินการ',
					1 => 'การจองเรียบร้อย',
					2 => 'ยกเลิก'
				);
	return $arr;
}



?>