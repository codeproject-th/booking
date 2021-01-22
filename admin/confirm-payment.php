<?php
//รายการยืนยันการำระเงิน
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
function search(){
	$booking_id = $_GET['booking_id'];
	$date = $_GET['date'];
	$room_type_id = $_GET['room_type_id'];
	$member_id = $_GET['member_id'];
	
	$date_ex = explode('-',$date);
	$start_day = DateDB(trim($date_ex[0]));
	$end_day = DateDB(trim($date_ex[1]));
	
	$where = ' 1=1 ';
	//ดึงข้อมูลตามวันที่
	if($start_day!='' and $end_day!=''){
		$data['booking_in_date'] = $start_day.' 12:00:00';
		$data['booking_out_date'] = $end_day.' 11:00:00';
		$where .= ' AND booking.booking_in_date>="'.$data['booking_in_date'].'" AND booking.booking_in_date<="'.$data['booking_out_date'].'" ';
	}
	
	//ดึงช้อมูลตามประเภท
	if($room_type_id!=''){
		$where .= ' AND booking.room_type_id="'.$room_type_id.'"';
	}
	
	//ตามidสมาชิก
	if($member_id!=''){
		$where .= ' AND booking.member_id="'.$room_type_id.'"';
	}
	
	//ดึงตามหมายเลขการจอง
	if($booking_id!=''){
		$booking_id = str_replace(',','',number_format($booking_id));
		$where .= ' AND booking.booking_id="'.$booking_id.'"';
	}
	
	//คำสั่sql
	$sql = "SELECT booking.* , member.member_full_name , confirm_payment.confirm_payment_date , confirm_payment.confirm_payment_id FROM confirm_payment
		LEFT JOIN booking ON confirm_payment.booking_id = booking.booking_id
		LEFT JOIN member ON booking.member_id=member.member_id
		WHERE ".$where."
		ORDER BY booking.booking_date DESC
		";
	return $sql;
}

$sql = "SELECT booking.* , member.member_full_name FROM booking 
		LEFT JOIN member ON booking.member_id=member.member_id
		ORDER BY booking.booking_date DESC
		";
$rows = db::fetch(search());
$status = status_booking();

$type = db::select('room_type');
$member = db::fetch('SELECT * FROM member ORDER BY member_full_name');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">แจ้งชำระเงิน</li>
</ol>
<form method="get">
	<div class="form-group">
    	<label for="pwd">หมายเลขการจอง :</label>
    	<input type="text" name="booking_id" value="<?=$_GET['booking_id']?>" class="form-control">
  	</div>
  	<button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
  	<input type="hidden" name="f" value="confirm-payment"/>
</form>
<br><br>
<table class="table table-bordered">
    <thead>
      <tr>
        <th width="5%" style="text-align: center;">No</th>
        <th width="17%" style="text-align: center;">หมายเลขการจอง</th>
        <th width="20%" style="text-align: center;">ผู้จอง</th>
        <th width="22%" style="text-align: center;">วันที่เข้าพัก</th>
        <th width="22%" style="text-align: center;">วันที่แจ้งชำระเงิน</th>
        <th width="20%" style="text-align: center;">สถานะ</th>
        <th width="10%" style="text-align: center;">ดู/ลบ</th>
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
    		<td style="text-align: center;"><?=str_pad($val['booking_id'],7,'0',STR_PAD_LEFT)?></td>
    		<td><?=$val['member_full_name']?></td>
    		<td style="text-align: center;"><?=DateTimeTH($val['booking_in_date'])?> - <?=DateTimeTH($val['booking_out_date'])?></td>
    		<td style="text-align: center;"><?=FullDateTimeTH($val['confirm_payment_date'])?></td>
    		<td style="text-align: center;"><?=$status[$val['booking_status']]?></td>
    		<td style="text-align: center;">
    			<a href="javascript:open_model('<?=$val['confirm_payment_id']?>')"><i class="fa fa-search" aria-hidden="true"></i></a> 
    			<a href="index.php?f=confirm-payment-delete&id=<?=$val['confirm_payment_id']?>" onclick="return confirm('ลบข้อมูล')"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>
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
        <h4 class="modal-title" id="myModalLabel">แจ้งชำระเงิน</h4>
      </div>
      <div class="modal-body">
         <div id="confirm-data"></div>
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
	//alert(id);
	$('#myModal').modal('show');
	$.ajax({
		type: "POST",
		url: "index.php?f=confirm-payment-view",
		cache: false,
		data: "id="+id,
		success: function(msg){
				$('#confirm-data').html(msg);
			}
		});
	
}

</script>


<?
Template::render('./../template-admin/footer.php');
?>