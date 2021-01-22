<?php
//บันทึกห้องที่จอง
$booking_room_id = $_POST['booking_room_id'];
$room_id = $_POST['room_id'];
$sql = 'UPDATE booking_room SET room_id="'.$room_id.'" WHERE booking_room_id="'.$booking_room_id.'"';
//echo $sql;
db::query($sql);
?>