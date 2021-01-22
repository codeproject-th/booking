<?php
$type = db::select('room_type');
?>
 <div style="font-size: 26px; border-bottom-style: solid; border-bottom-width:1px; border-bottom-color:#dddddd; margin-bottom: 20px;">
 	Booking
 </div>
 <form method="post" action="index.php?f=booking-check">
  <div class="form-group">
    <label for="email">ประเภทห้องพัก :</label>
    <select name="room_type_id" class="form-control" onchange="review()">
    	<option value="">เลือก</option>
    <?
    if(count($type)>0){
		foreach($type as $val){
	?>
		<option value="<?=$val['room_type_id']?>" <? if($id==$val['room_type_id']){ ?>selected<? } ?> ><?=$val['room_type_name']?></option>
	<?		
		}
	}
    ?>
    </select>
  </div>
  <div class="form-group">
    <label for="pwd">วันที่เข้าพัก :</label>
    <input type="text" name="daterange" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="pwd">จำนวนห้อง :</label>
    <input type="number" name="room_number" class="form-control" required>
  </div>
  <? if($_SESSION['member_login_id']!=''){ ?>
  <button type="submit" class="btn btn-primary">Booking</button>
  <? }else{ ?>
  	<div style="color: #ff0000;">กรุณาเข้าสู่ระบบเพื่อทำการจอง</div>
  <? } ?>
</form> 

<script>
var start = moment().subtract(0, 'days');
var end = moment().add(1, 'days');
$('input[name="daterange"]').daterangepicker({
    opens: "center",
    drops: "up",
    startDate: start,
	endDate: end,
    minDate: moment().subtract(0,'days'), // Yesterday at 10:21 AM
    locale: {
           format: 'DD/MM/YYYY'
	}
});

function review(){
	//alert('zz');
	window.location = 'index.php?f=room-view&id='+$("select[name=room_type_id]").val();
}
</script>