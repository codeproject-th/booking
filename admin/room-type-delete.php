<?php
//ลบประเภทห้อง
Template::render('./../template-admin/header.php');
$rows = db::select('room_type',array('room_type_id'=>$_GET['id']));

for($i=1;$i<=5;$i++){
	@unlink("../uploads/room-type/".$rows[0]['room_type_img'.$i]);
}

db::delete('room_type',array('room_type_id'=>$_GET['id']));//ลบรูป
?>
<script>
	alert('ลบข้อมูลเรียบร้อย');
	window.history.back();
</script>
<?
Template::render('./../template-admin/footer.php');
?>