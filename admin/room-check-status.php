<?php
//ตรวจสอบการของ
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
//function เช็คสถานะการจอง
function chk_status($room_id=''){
	//เอาidห้องมาตรวจสอบ
	$date = $_GET['date'];
	$date_ex = explode('-',$date);
	$start_day = DateDB(trim($date_ex[0]));
	$end_day = DateDB(trim($date_ex[1]));
	
	if($date==''){
		$start_day = date('Y-m-d');
		$end_day = add_date($start_day,1);
	}
	
	$where = ' room_id="'.$room_id.'"';
	//ถ้าวันไม่เท่ากับค่าว่าให้เพิ่มเง่อนไขการค้นหาตามเวลา
	if($start_day!='' and $end_day!=''){
		$data['booking_in_date'] = $start_day.' 12:00:00';
		$data['booking_out_date'] = $end_day.' 11:00:00';
		$where .= ' AND booking_room.booking_room_start_date>="'.$data['booking_in_date'].'" 
					AND booking_room.booking_room_start_date<="'.$data['booking_out_date'].'" ';
	}
	
	$sql = "SELECT booking_room.* FROM booking_room WHERE ".$where." AND  booking_room.booking_room_status!=2";
	$rows = db::fetch($sql);
	$txt = "";
	if(count($rows)>0){
		$txt = "ไม่ว่าง";
	}else{
		$txt = "ว่าง";
	}
	return $txt;
}


$date = $_GET['date'];
$room_type_id = $_GET['room_type_id'];
$date_ex = explode('-',$date);
$start_day = DateDB(trim($date_ex[0]));
$end_day = DateDB(trim($date_ex[1]));

//ตรวจสอบค่าว่าง	
if($date==''){
	//ถ้ามีให้จัดรูปแบบวันที่
	$start_day = date('Y-m-d');
	$end_day = add_date($start_day,1);
}
	
if($start_day!='' and $end_day!=''){
	$data['booking_in_date'] = $start_day.' 12:00:00';
	$data['booking_out_date'] = $end_day.' 11:00:00';
}
	
$date_to = $data['booking_in_date'].' - '.$data['booking_out_date'];

$where = ' 1=1 ';
if($room_type_id!=''){
	$where .= ' AND room_type.room_type_id="'.$room_type_id.'"';
}

$sql = "SELECT room.*,room_type.room_type_name FROM room
		LEFT JOIN room_type ON room_type.room_type_id = room.room_type_id 
		WHERE ".$where."
		";//คำสั่งsql ดึงข้อมูล
$rows = db::fetch($sql);

$type = db::select('room_type');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">ตรวสอบสถานะห้อง</li>
</ol>
<form method="get">
	<div class="form-group">
    <label for="email">ประเภทห้องพัก :</label>
    <select name="room_type_id" class="form-control">
    	<option value="">เลือก</option>
    <?
    if(count($type)>0){
		foreach($type as $val){
	?>
		<option value="<?=$val['room_type_id']?>" <? if($_GET['room_type_id']==$val['room_type_id']){ ?>selected<? } ?> ><?=$val['room_type_name']?></option>
	<?		
		}
	}
    ?>
    </select>
  </div>
  <div class="form-group">
    <label for="pwd">วันที่เข้าพัก :</label>
    <input type="text" name="date" value="<?=$_GET['date']?>" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
  <br><br><br>
  <input type="hidden" name="f" value="room-check-status"/>
</form>
<table class="table table-bordered">
    <thead>
      <tr>
        <th width="5%" style="text-align: center;">No</th>
        <th width="20%" style="text-align: center;">ประเภท</th>
        <th style="text-align: center;">หมายเลขห้อง</th>
        <th width="13%" style="text-align: center;">สถานะ</th>
        <th width="10%" style="text-align: center;">รายละเอียด</th>
      </tr>
    </thead>
    <tbody>
    <? if(count($rows)>0){ 
    	$n = 0;
    	foreach($rows as $val){
    		$n++;
    ?>
    	<tr>
    		<td style="text-align: center;"><?=$n?></td>
    		<td style="text-align: center;"><?=$val['room_type_name']?></td>
    		<td style="text-align: center;"><?=$val['room_code']?></td>
    		<td align="center"><?=chk_status($val['room_id'])?></td>
    		<td style="text-align: center;">
    			<a href="javascript:open_model('<?=$val['room_id']?>')"><i class="fa fa-search" aria-hidden="true"></i></a>
    		</td>
    	</tr>
    <? 
    	}
    } ?>
    </tbody>
</table>


<!-- Modal -->
<form method="post">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">การจอง</h4>
      </div>
      <div class="modal-body">
         <div id="table_list"></div>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="h-id" value=""/>
</form>


<script>
$('input[name="date"]').daterangepicker({
    opens: "center",
    drops: "up",
    locale: {
           format: 'DD/MM/YYYY'
	}
});


function open_model(id){
	$('#myModal').modal('show');
	$.ajax({
		type: "POST",
		url: "index.php?f=booking-room-check-ajax",
		cache: false,
		data: "date=<?=$date?>&room_id="+id,
		success: function(msg){
				$("#table_list").html(msg);
			}
		});
}

</script>

<?php
Template::render('./../template-admin/footer.php');
?>