<?php
//รายละเอียดการยืนยันการชำระเงิน
include('./../fc/fc-booking.php');
$id = $_POST['id'];
$data = db::select('confirm_payment',array('confirm_payment_id'=>$id));//ดึงข้อมูลการชำระเงิน
$bank = db::select('bank',array('bank_id'=>$data[0]['bank_id']));//ดึงข้อมูลธนาคาร
?>
<table class="table table-bordered">
	<tbody>
    	<tr>
    		<td width="50%">หมายเลขการจอง</td>
    		<td><?=str_pad($data[0]['booking_id'],7,'0',STR_PAD_LEFT)?></td>
    	</tr>
    	<tr>
    		<td>จำนวนเงิน</td>
    		<td><?=number_format($data[0]['price'])?> บาท</td>
    	</tr>
    	<tr>
    		<td>ธนาารที่ที่โอนเข้า</td>
    		<td><?=$bank[0]['bank_name']?></td>
    	</tr>
    	<tr>
    		<td>เวลา</td>
    		<td><?=$data[0]['time']?> <?=$data[0]['date']?></td>
    	</tr>
    	<tr>
    		<td>ไฟล์</td>
    		<td><a href="./../uploads/images-confirm/<?=$data[0]['img']?>">Download</a></td>
    	</tr>
    </tbody>
</table>