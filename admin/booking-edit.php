<?php
//แก้ไขห้องที่จอง
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
function save(){
	$sql = 'SELECT * FROM booking WHERE booking_id="'.db::str($_POST['booking_id']).'" ';
	$booking_data = db::fetch($sql);
	$date = $_POST['date'];
	$room_number = $_POST['booking_room_number'];
	$room_type_id = $_POST['room_type_id'];
	$date_ex = explode('-',$date);
	$start_day = DateDB(trim($date_ex[0]));
	$end_day = DateDB(trim($date_ex[1]));
	
	if($booking_data[0]['booking_in_date']!=$start_day or $booking_data[0]['booking_out_date']!=$end_day or $booking_data[0]['booking_room_number']!=$room_number or $booking_data[0]['room_type_id']!=$data['room_type_id']){
		$sql = 'DELETE FROM booking_room WHERE  booking_id="'.$booking_data[0]['booking_id'].'"';
		db::query($sql);
	}
	
	$data['room_type_id'] = $room_type_id;
	//$data['member_id'] = $_SESSION['member_login_id'];
	$data['booking_in_date'] = $start_day.' 12:00:00';
	$data['booking_out_date'] = $end_day.' 11:00:00';
	$data['booking_room_number'] = $room_number;
	$data['booking_amount'] = '';
	$data['booking_cash_pledge'] = '';
	$data['booking_date'] = date('Y-m-d H:i:s');
	$error = '';
	if($booking_data[0]['booking_in_date']!=$start_day or $booking_data[0]['booking_out_date']!=$end_day or $booking_data[0]['booking_room_number']!=$room_number or $booking_data[0]['room_type_id']!=$data['room_type_id']){
		$rows = check_room_availability($data['booking_in_date'],$data['booking_out_date'],$room_type_id);
		if(count($rows)<$room_number){
			$error = 'ไม่สามารถจองได้ เนื่องจากวันที่ '.$start_day.' - '.$end_day.' ไม่มีห้องว่่าง';
		}
	}
	$room_type = db::select('room_type',array('room_type_id'=>$data['room_type_id']));
	$member = db::select('member',array('member_id'=>$_SESSION['member_login_id']));

	$data['booking_amount'] = $room_type[0]['room_type_price']*$room_number;
	$data['booking_cash_pledge'] = $room_type[0]['room_type_deposit']*$room_number;
	$data['booking_status'] = $_POST['booking_status'];
	if($error==''){
		db::update('booking',$data,array('booking_id'=>$booking_data[0]['booking_id']));
		if($booking_data[0]['booking_in_date']!=$start_day or $booking_data[0]['booking_out_date']!=$end_day or $booking_data[0]['booking_room_number']!=$room_number or $booking_data[0]['room_type_id']!=$data['room_type_id']){
			for($i=0;$i<=($room_number-1);$i++){
				db::insert('booking_room',array(
											'booking_id' => $booking_data[0]['booking_id'],
											'room_id' => $rows[$i]['room_id'],
											'booking_room_start_date' => $data['booking_in_date'],
											'booking_room_end_date' => $data['booking_out_date'],
											'booking_room_status' => $data['booking_status']
										));
			}
		}else{
			db::update('booking_room',array('booking_room_status' => $data['booking_status']),array('booking_id' => $booking_data[0]['booking_id']));
		}
	}
	
	return $error;
}

if($_POST){
	$error = save();
}

$sql = 'SELECT * FROM booking WHERE booking_id="'.db::str($_GET['id']).'" ';
$rows_data = db::fetch($sql);

$data['room_type_id'] = $room_type_id;
$data['member_id'] = $rows_data[0]['member_id'];
$data['booking_in_date'] = $rows_data[0]['booking_in_date'];
$data['booking_out_date'] = $rows_data[0]['booking_out_date'];
$data['booking_room_number'] = $rows_data[0]['booking_room_number'];
$data['booking_amount'] = '';
$data['booking_cash_pledge'] = '';
$data['booking_status'] = '0';
$data['booking_date'] = date('Y-m-d H:i:s');

$room_type = db::select('room_type',array('room_type_id'=>$rows_data[0]['room_type_id']));
$member = db::select('member',array('member_id'=>$rows_data[0]['member_id']));

$data['booking_amount'] = $rows_data[0]['booking_amount'];
$data['booking_cash_pledge'] = $rows_data[0]['booking_cash_pledge'];
$order_id = str_pad($rows_data[0]['booking_id'],7,'0',STR_PAD_LEFT);
$sql = "SELECT  booking_room.* , room.room_code FROM booking_room LEFT JOIN room ON booking_room.room_id=room.room_id 
WHERE booking_id='".$rows_data[0]['booking_id']."'";
$room_list = db::fetch($sql);
$status = status_booking();
$type = db::select('room_type');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">Booking</li>
</ol>
<? if($_POST){ ?>
 <?php if($error!=''){ ?>
    <div class="alert alert-danger">
  		<strong><?=$error?></strong>
	</div>
	<?php }else{ ?>
	<div class="alert alert-success">
  		<strong>บันทึกการจองของคุณเรียบร้อย </strong>
	</div>
<? } ?>
<? } ?>
<form method="post">
 	<table class="table table-bordered">
    	<tbody>
    		<tr>
    			<td width="50%">สถานะการจอง</td>
    			<td>
    				 <select name="booking_status" class="form-control">
    					<option value="">เลือก</option>
					    <?
					    if(count($status)>0){
							foreach($status as $index => $val){
						?>
						<option value="<?=$index?>" <? if($rows_data[0]['booking_status']==$index){ ?>selected<? } ?> ><?=$val?></option>
						<?		
							}
						}
    					?>
    				</select>			
    			</td>
    		</tr>
    		<tr>
    			<td width="50%">หมายเลขการจอง</td>
    			<td><div style="color: #ff0000;"><?=$order_id?></div></td>
    		</tr>
    		<tr>
    			<td width="50%">วันที่เข้าพัก</td>
    			<td>
    				<input type="text" name="date" class="form-control" value="<?=date('d/m/Y',strtotime($data['booking_in_date']))?> - <?=date('d/m/Y',strtotime($data['booking_out_date']))?>" required>
    			</td>
    		</tr>
    		<tr>
    			<td width="50%">จำนวน</td>
    			<td><?=DateDiff($data['booking_in_date'],$data['booking_out_date'])?> คืน</td>
    		</tr>
    		<tr>
    			<td width="50%">ประเภทห้องพัก</td>
    			<td>
    				 <select name="room_type_id" class="form-control">
    					<option value="">เลือก</option>
					    <?
					    if(count($type)>0){
							foreach($type as $val){
						?>
						<option value="<?=$val['room_type_id']?>" <? if($room_type[0]['room_type_id']==$val['room_type_id']){ ?>selected<? } ?> ><?=$val['room_type_name']?></option>
						<?		
						}
					}
    			?>
    				</select>				
    			</td>
    		</tr>
    		<tr>
    			<td>จำนวนห้อง</td>
    			<td>
    				<input type="text" name="booking_room_number" class="form-control" value="<?=$data['booking_room_number']?>" required>
    			</td>
    		</tr>
    		<tr>
    			<td>จำนวนคนที่สามารถเข้าพักได้</td>
    			<td><?=$room_type[0]['room_type_people']?> คน/ห้อง</td>
    		</tr>
    		<tr>
    			<td>ค่าใช้จ่ายทั้งหมด</td>
    			<td><?=number_format($room_type[0]['room_type_price']*$data['booking_room_number'])?> บาท</td>
    		</tr>
    		<tr>
    			<td>จำนวนเงินที่ต้องชำระ(ค่ามันจำ)</td>
    			<td><?=number_format($room_type[0]['room_type_deposit']*$data['booking_room_number'])?> บาท</td>
    		</tr>
    	</tbody>
  	</table>
  	<ul class="breadcrumb">
      	<li class="active">หมายเลขห้อง</li>
    </ul>
    <? if(count($room_list)>0){ ?>
    <table class="table table-bordered">
    	<tr>
    		<td width="10%" style="text-align: center;">No</td>
    		<td style="text-align: center;">หมายเลขห้อง</td>
    		<td style="text-align: center;" width="10%">แก้ไข</td>
    	</tr>
    	<?
    	$no = 0;
    	foreach($room_list as $val){
    		$no++;
    	?>
    	<tr>
    		<td width="5%" style="text-align: center;"><?=$no?></td>
    		<td><?=$val['room_code']?></td>
    		<td style="text-align: center;"><a href="javascript:open_model('<?=$val['booking_room_id']?>')"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a></td>
    	</tr>
    	<? } ?>
    </table>
    <? } ?>
  	<ul class="breadcrumb">
      	<li class="active">ข้อมูลสมาชิก</li>
    </ul>
    <table class="table table-bordered">
    	<tbody>
    		<tr>
    			<td width="50%">ขื่อ-นามสกุล</td>
    			<td><?=$member[0]['member_full_name']?></td>
    		</tr>
    		<tr>
    			<td>ที่อยู่</td>
    			<td><?=$member[0]['address']?></td>
    		</tr>
    		<tr>
    			<td>จังหวัด</td>
    			<td><?=$member[0]['province']?></td>
    		</tr>
    		<tr>
    			<td>เบอร์โทร</td>
    			<td><?=$member[0]['tel']?></td>
    		</tr>
    		<tr>
    			<td>อีเมล์</td>
    			<td><?=$member[0]['member_email']?></td>
    		</tr>
    	</tbody>
  	</table>
  	<div style="text-align: center;">
  		<button type="submit" class="btn btn-primary">บันทึก</button>
  	</div>
  	<input type="hidden" name="booking_id" value="<?=$rows_data[0]['booking_id']?>"/>
</form>


<!-- Modal -->
<form method="post">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">แก้ไขห้อง</h4>
      </div>
      <div class="modal-body">
         <div class="form-group">
         	<label for="email">หมายเลขห้อง :</label>
         	<div id="return_ajax">
         		<select id="room_id_edit" class="form-control">
    				<option value="">เลือก</option>
    			</select>
    		</div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="save_room();">บันทึก</button>
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
	$('#h-id').val(id);
	$('#myModal').modal('show');
	$('#room_id_edit option').remove();
	$.ajax({
		type: "POST",
		url: "index.php?f=booking-edit-room",
		cache: false,
		data: "booking_room_id="+id,
		success: function(msg){
				$('#room_id_edit').append(msg);
			}
		});
	
}

function save_room(){
	
	$.ajax({
		type: "POST",
		url: "index.php?f=booking-edit-room-save",
		cache: false,
		data: "booking_room_id="+$('#h-id').val()+"&room_id="+$('#room_id_edit').val(),
		success: function(msg){
				//alert(msg);
				alert("บันทึกข้อมูลเรียบร้อย");
				window.location.reload();
			}
		});
}

</script>
<?
Template::render('./../template-admin/footer.php');
?>