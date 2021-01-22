<div class="menu">
	<ul>
		<? if($_SESSION['login_type']=='1'){ ?><li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=users-list">ผู้ใช้งาน</a></li><? } ?>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=person-list">เจ้าหน้าที่</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=department-list">หน่วยงาน</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=patient-list">ผู้ป่วย</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=schedule-list">ตารางนัด</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=calendar">ปฏิทิน</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=ch-pass">เปลี่ยนรหัสผ่าน</a></li>
		<li><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="index.php?f=logout">ออกจากระบบ</a></li>
	</ul>
</div>