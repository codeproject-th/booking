<?php
//หน้าแสดงรายละเอียดห้อง
Template::render('./template/header.php');
$id = db::str($_GET['id']);
$rows = db::select('room_type',array('room_type_id'=>$id));//รายละเอียดห้อง ดึงจาก id

?>
<div class="row">
	<div class="col-md-8">
		<img src="./uploads/room-type/<?=$rows[0]['room_type_img1']?>" id="ImageMain" class="img-responsive">
		<div style="">
			<div class="row">
			<? for($i=1;$i<=5;$i++){ ?>
				<div class="col-sm-2">
					<? if($rows[0]['room_type_img'.$i]!=''){ ?>
					<a href="javascript:img_view('./uploads/room-type/<?=$rows[0]['room_type_img'.$i]?>')"><img src="./uploads/room-type/<?=$rows[0]['room_type_img'.$i]?>" class="img-responsive" style="margin-top: 10px;"></a>
					<? } ?>
				</div>
			<? } ?>
			</div>
		</div>
		<div class="braklink"></div>
		<h3 style="padding: 0px; margin: 0px; margin-top: 10px; margin-bottom: 10px;"><?=$rows[0]['room_type_name']?></h3>
		<p><?=$rows[0]['room_type_detail']?></p>
	</div>
	<div class="col-md-4">
		<? Template::render('booking.php',array('id'=>$id)); ?>
	</div>
</div>

<style>
.braklink{
	border-bottom-style: solid;
	border-bottom-width: 1px;
	border-bottom-color: #dddddd;
	height: 10px;
	margin-bottom: 5px;
}
</style>
<script>
function img_view(img_name){
	$("#ImageMain").attr('src',img_name);
}
</script>
<?
Template::render('./template/footer.php');
?>