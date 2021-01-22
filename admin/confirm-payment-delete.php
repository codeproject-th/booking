<?php
//ลบการจอง
Template::render('./../template-admin/header.php');
$id = $_GET['id'];
$sql = "DELETE FROM confirm_payment WHERE confirm_payment_id='".$id ."'";//ลบการจอง
db::query($sql);
?>
<script>
alert('ลบข้อมูลเรียบร้อย');
window.history.back();
</script>
<?
Template::render('./../template-admin/footer.php');
?>