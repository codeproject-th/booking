<?php
//ผู้ใช้งาน
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
//function ดึงข้อมูลผู้ใช้งาน คิอค่าเป็นคำสั่ง sql
function search(){
	$sql = "SELECT * FROM users ";
	return $sql;
}

$rows = db::fetch(search());
$type = db::select('room_type');
$member = db::fetch('SELECT * FROM member ORDER BY member_full_name');
$type = array('1'=>'ผู้ดูแลระบบ','2'=>'พนักงาน');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">ผู้ใช้งาน</li>
</ol>
<a href="index.php?f=user-add"><button type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม</button></a>
<br><br>
<table class="table table-bordered">
    <thead>
      <tr>
        <th width="5%" style="text-align: center;">No</th>
        <th width="17%" style="text-align: center;">ชื่อ-นามสุล</th>
        <th width="20%" style="text-align: center;">Username</th>
        <th width="20%" style="text-align: center;">ประเภท</th>
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
    		<td style="text-align: left;"><?=$val['users_firstname']?> <?=$val['users_lastname']?></td>
    		<td><?=$val['users_name']?></td>
    		<td style="text-align: center;"><?=$type[$val['users_type']]?></td>
    		<td style="text-align: center;">
    			<a href="index.php?f=user-add&id=<?=$val['users_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
    			<a href="index.php?f=user-delete&id=<?=$val['users_id']?>" onclick="return confirm('ลบข้อมูล')"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>
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