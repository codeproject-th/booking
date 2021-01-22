<?php
//หน้าแรก
Template::render('./template/header.php'); //เรีนกใช้ไฟล์ header.php
$rows = db::select('room_type'); //ดึงข้อมูลประเภทห้อง
$img = db::fetch('select * from slider ORDER BY slider_no');//ดึงข้อมูลสไลด์
?>
<script src="./js/jquery.bxslider/jquery.bxslider.min.js"></script>
<link href="./js/jquery.bxslider/jquery.bxslider.css" rel="stylesheet" />

<ul class="bxslider" style="background: #000000;">
<? if(count($img)>0){ 
	foreach($img as $val){
		if($val['slider_img']!=''){
?>
		<li><img src="./uploads/slider/<?=$val['slider_img']?>" width="100%" style="max-height: 350px;"></li>
<? 
		}
	}
} ?>
</ul>

<div class="row">
<?
if(count($rows)>0){
	//วน loop เพื่อแสดงข้อฒุล
	foreach($rows as $val){
?>
	<div class="col-12 col-sm-4 ">
		<div style="background-color: #f3f3f3; padding-bottom: 5px;">
			<img src="./uploads/room-type/<?=$val['room_type_img1']?>?r=<?=date('YmdHis')?>" class="img-responsive">
			<div style="padding: 5px;">
				<h3 style="padding: 0px; margin: 0px;"><?=$val['room_type_name']?></h3>
				<div class="braklink"></div>
				<p><?=$val['room_type_detail']?></p>
			</div>
			<div class="row" style="padding: 5px;">
				<div class="col-xs-6" style="text-align: left;">
					<h3 style="padding: 0px; margin: 0px; margin-top:5px; color: #487bbf;">THB <?=number_format($val['room_type_price'])?></h3>
				</div>
				<div class="col-xs-6" style="text-align: right;">
					<a href="index.php?f=room-view&id=<?=$val['room_type_id']?>"><button type="button" class="btn btn-primary"><i class="fa fa-book" aria-hidden="true"></i> Booking</button></a>
				</div>
			</div>
		</div>
	</div>
<?		
	}
}
?>
</div>
<script>
$(document).ready(function(){
  $('.bxslider').bxSlider({
  	auto: true
  });
});
</script>
<style>
.braklink{
	border-bottom-style: solid;
	border-bottom-width: 1px;
	border-bottom-color: #dfdfdf;
	height: 10px;
	margin-bottom: 5px;
}
</style>
<?
Template::render('./template/footer.php');//เรียกใช้ไฟล์ footer.php
?>