<?php
Template::render('./template/header.php');
include('./fc/fc-booking.php');

$sql = 'SELECT * FROM booking WHERE booking_id="'.db::str($_GET['id']).'" '; //ดึงข้อมูล การจอง
$rows_data = db::fetch($sql);

$data['room_type_id'] = $room_type_id;
$data['member_id'] = $rows_data[0]['member_id'];//สมาชิก
$data['booking_in_date'] = $rows_data[0]['booking_in_date'];//วันที่จอง
$data['booking_out_date'] = $rows_data[0]['booking_out_date'];//;วันที่สิ้นสุดการจอง
$data['booking_room_number'] = $rows_data[0]['booking_room_number'];//หมายเลขห้อง
$data['booking_amount'] = '';
$data['booking_cash_pledge'] = '';
$data['booking_status'] = '0';
$data['booking_date'] = date('Y-m-d H:i:s');

$room_type = db::select('room_type',array('room_type_id'=>$rows_data[0]['room_type_id']));
$member = db::select('member',array('member_id'=>$rows_data[0]['member_id']));

$data['booking_amount'] = $rows_data[0]['booking_amount'];//จำนวนเงิน
$data['booking_cash_pledge'] = $rows_data[0]['booking_cash_pledge'];//มัดจำ
$order_id = str_pad($rows_data[0]['booking_id'],7,'0',STR_PAD_LEFT);

$night = DateDiff($data['booking_in_date'],$data['booking_out_date']);
?>
<div class="col-xs-3"></div>
<div class="col-xs-6">
	<ul class="breadcrumb">
      	<li class="active">แจ้งชำระเงิน</li>
    </ul>
    <!-------------->
    <?php if($error!=''){ ?>
    <div class="alert alert-danger">
  		<strong><?=$error?></strong>
	</div>
	<?php }else{ ?>
	<div class="alert alert-success">
  		<strong>บันทึกการแจ้งชำระเงินของคุณเรียบร้อย</strong>
	</div>
	<? } ?>
    <table class="table table-bordered">
    	<tbody>
    		<?php if($error==''){ ?>
    		<tr>
    			<td width="50%">หมายเลขการจอง</td>
    			<td><div style="color: #ff0000;"><?=$order_id?></div></td>
    		</tr>
    		<? } ?>
    		<tr>
    			<td width="50%">วันที่เข้าพัก</td>
    			<td><?=date('d/m/Y',strtotime($data['booking_in_date']))?> - <?=date('d/m/Y',strtotime($data['booking_out_date']))?></td>
    		</tr>
    		<tr>
    			<td width="50%">จำนวน</td>
    			<td><?=DateDiff(date('Y-m-d',strtotime($data['booking_in_date'])),date('Y-m-d',strtotime($data['booking_out_date'])))?> คืน</td>
    		</tr>
    		<tr>
    			<td width="50%">ประเภทห้องพัก</td>
    			<td><?=$room_type[0]['room_type_name']?></td>
    		</tr>
    		<tr>
    			<td>จำนวนห้อง</td>
    			<td><?=$data['booking_room_number']?> ห้อง</td>
    		</tr>
    		<tr>
    			<td>จำนวนคนที่สามารถเข้าพักได้</td>
    			<td><?=$room_type[0]['room_type_people']?> คน/ห้อง</td>
    		</tr>
    		<tr>
    			<td>ค่าใช้จ่ายทั้งหมด</td>
    			<td><?=number_format(($room_type[0]['room_type_price']*$data['booking_room_number'])*$night)?> บาท</td>
    		</tr>
    		<tr>
    			<td>จำนวนเงินที่ต้องชำระ(ค่ามันจำ)</td>
    			<td><?=number_format($room_type[0]['room_type_deposit']*$data['booking_room_number'])?> บาท</td>
    		</tr>
    	</tbody>
  	</table>
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
    <!-------------->
    <div style="text-align: center;">
    	
    </div>
</div>
<div class="col-xs-3"></div>
<?php
Template::render('./template/footer.php');
?>