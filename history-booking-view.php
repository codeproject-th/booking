<?php
//ประวีติการจอง
Template::render('./template/header.php');
include('./fc/fc-booking.php');//เรียกใช้ไฟล์ function

$sql = 'SELECT * FROM booking WHERE booking_id="'.db::str($_GET['id']).'" '; //ดึงข้อมูลตาราง booking
$rows_data = db::fetch($sql);//ดึงข้อมูล

$data['room_type_id'] = $room_type_id;//id ประเภทห้อง
$data['member_id'] = $rows_data[0]['member_id'];//id สมาชิก
$data['booking_in_date'] = $rows_data[0]['booking_in_date'];// วันที่เข้าพัก
$data['booking_out_date'] = $rows_data[0]['booking_out_date'];//วันที่ออก
$data['booking_room_number'] = $rows_data[0]['booking_room_number'];//หมายเลขห้อง
$data['booking_amount'] = '';
$data['booking_cash_pledge'] = '';
$data['booking_status'] = '0';
$data['booking_date'] = date('Y-m-d H:i:s');//วันที่บันทึก

$room_type = db::select('room_type',array('room_type_id'=>$rows_data[0]['room_type_id']));//ดึงประเภทห้อง'
$member = db::select('member',array('member_id'=>$rows_data[0]['member_id']));//ดึงสมาชิก

$data['booking_amount'] = $rows_data[0]['booking_amount'];//ค่าใช้จ่าย
$data['booking_cash_pledge'] = $rows_data[0]['booking_cash_pledge'];//ค่ามัดจำ
$order_id = str_pad($rows_data[0]['booking_id'],7,'0',STR_PAD_LEFT);//ใส่เลข0ข้างหน้า id การจอง

$status = status_booking();//สถานะการจองคืนค่าเป็น array
?>
<div class="col-xs-3"></div>
<div class="col-xs-6">
	<ul class="breadcrumb">
      	<li class="active">การจอง</li>
    </ul>
    <!-------------->
    <table class="table table-bordered">
    	<tbody>
    		<tr>
    			<td width="50%">สถานะ</td>
    			<td><div style=""><?=$status[$rows_data[0]['booking_status']]?></div></td>
    		</tr>
    		<tr>
    			<td width="50%">หมายเลขการจอง</td>
    			<td><div style=""><?=$order_id?></div></td>
    		</tr>
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
    			<td><?=number_format($room_type[0]['room_type_price']*$data['booking_room_number'])?> บาท</td>
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