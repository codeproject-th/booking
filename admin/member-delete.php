<?php
//ลบสมาชิกโดยอ้าง id
Template::render('./../template-admin/header.php');
db::delete('member',array('member_id'=>$_GET['id']));
?>
<script>
	alert('ลบข้อมูลเรียบร้อย');
	window.history.back();
</script>
<?
Template::render('./../template-admin/footer.php');
?>