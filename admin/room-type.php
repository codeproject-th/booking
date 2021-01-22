<?php
//ประเภทห้อง
Template::render('./../template-admin/header.php');
$rows = db::select('room_type');
?>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">ประเภทห้องพัก</li>
</ol>
<a href="index.php?f=room-type-form"><button type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> เพิ่ม</button></a>
<br><br>
<table class="table table-bordered">
    <thead>
      <tr>
        <th width="10%" style="text-align: center;">No</th>
        <th width="75%" style="text-align: center;">ประเภท</th>
        <th width="15%" style="text-align: center;">แก้ไข/ลบ</th>
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
    		<td><?=$val['room_type_name']?></td>
    		<td style="text-align: center;">
    			<a href="index.php?f=room-type-form&id=<?=$val['room_type_id']?>"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i></a>
    			<a href="index.php?f=room-type-delete&id=<?=$val['room_type_id']?>" onclick="return confirm('ลบข้อมูล')"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>
    		</td>
    	</tr>
    <? 
    	}
    } ?>
    </tbody>
</table>

<?
Template::render('./../template-admin/footer.php');
?>