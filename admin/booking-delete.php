<?php
//ลบการจอง
Template::render('./../template-admin/header.php');
$id = $_GET['id'];
$sql = "DELETE FROM booking WHERE booking_id='".$id ."'";//ลบการจอง
db::query($sql);
$sql = "DELETE FROM booking_room WHERE booking_id='".$id ."'";//ลบห้องที่จอง
db::query($sql);
?>
<script>
alert('ลบข้อมูลเรียบร้อย');
window.history.back();
</script>
<?
Template::render('./../template-admin/footer.php');
?>