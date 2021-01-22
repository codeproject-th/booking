<?php
//ลบ user
Template::render('./../template-admin/header.php');
db::delete('users',array('users_id'=>$_GET['id']));
?>
<script>
	alert('ลบข้อมูลเรียบร้อย');
	window.history.back();
</script>
<?
Template::render('./../template-admin/footer.php');
?>