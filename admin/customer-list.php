<?php
//ราบชื่อสมาชิก
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
//ค้นหาสมาชิก
function search(){
	
	$where = ' 1=1 ';
	if($_GET['member_name']){
		$where .= ' AND member_full_name LIKE "%'.$_GET['member_name'].'%" ';
	}
	
	$sql = "SELECT * FROM member WHERE ".$where." ";
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
  <li class="breadcrumb-item active">ข้อมูลลูกค้า</li>
</ol>
<form method="get">
  <label for="pwd">ชื่อ-นามสกุล :</label>
  <input type="text" name="member_name" value="<?=$_GET['member_name']?>" class="form-control">
  <br>
  <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> ค้นหา</button>
  <br><br><br>
  <input type="hidden" name="f" value="customer-list"/>
</form>
<a href="index.php?f=member-add"><button type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม</button></a>
<br><br>
<table class="table table-bordered">
    <thead>
      <tr>
        <th width="5%" style="text-align: center;">No</th>
        <th width="17%" style="text-align: center;">ชื่อ-นามสุล</th>
        <th width="20%" style="text-align: center;">อีเมล์</th>
        <th width="10%" style="text-align: center;">แก้ไข/ลบ</th>
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
    		<td style="text-align: left;"><?=$val['member_full_name']?></td>
    		<td><?=$val['member_email']?></td>
    		<td style="text-align: center;">
    			<a href="index.php?f=member-add&id=<?=$val['member_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
    			<a href="index.php?f=member-delete&id=<?=$val['member_id']?>" onclick="return confirm('ลบข้อมูล')"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>
    		</td>
    	</tr>
    <? 
    	}
    } ?>
    </tbody>
</table>
<script>
$('input[name="date"]').daterangepicker({
    opens: "center",
    drops: "up",
    locale: {
           format: 'DD/MM/YYYY'
	}
});
</script>
<?
Template::render('./../template-admin/footer.php');
?>