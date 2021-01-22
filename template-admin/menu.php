<div class="menu">
	<ul>
		
		<? if($_SESSION['admin_type']=="1"){ ?><li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=user">ผู้ใช้</a></li><? } ?>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=customer-list">ลูกค้า</a></li>
		<? if($_SESSION['admin_type']=="1"){ ?><li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=room-type">ประเภทห้องพัก</a></li><? } ?>
		<? if($_SESSION['admin_type']=="1"){ ?><li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=room">ห้องพัก</a></li><? } ?>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=room-check-status">ตรวจสอบสถานะห้อง</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=booking">การจอง</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=confirm-payment">แจ้งชำระเงิน</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=slider">สไลค์</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=report">รายงานการเข้าพัก</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=content-booking-step">ขั้นตอนการจอง</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=ch-pass">เปลี่ยนรหัสผ่าน</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=logout">ออกจากระบบ</a></li>
	</ul>
</div>