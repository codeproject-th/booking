<?php
//เพิ่มห้อง
Template::render('./../template-admin/header.php');

$id = $_GET['id'];
$txt = "เพิ่มห้องพัก";
if($id!=''){
	$txt = "แก้ไขห้องพัก";
}
if($_POST){
	$insert['room_type_id'] = $_POST['room_type_id'];
	$insert['room_name'] = $_POST['room_name'];
	$insert['room_code'] = $_POST['room_code'];
	$insert['room_detail'] = $_POST['room_detail'];
	if($id==''){
		db::insert('room',$insert);
	}else{
		db::update('room',$insert,array('room_id'=>$id));
	}
	$save = true;
}

$room_type = db::select('room_type');
if($id!=''){
	$data = db::select('room',array('room_id'=>$id));
}

?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">ห้องพัก</li>
  <li class="breadcrumb-item active"><?=$txt?></li>
</ol>
<? if($save==true){ ?>
<div class="alert alert-success">
  <strong>บันทึกข้อมูลเรียบร้อย</strong>
</div>
<? } ?>
<form method="post" class="form-horizontal" enctype="multipart/form-data">
	<div class="form-group">
    	<label class="control-label col-sm-2">ประเภทห้องพัก :</label>
    	<div class="col-sm-7">
      		<select name="room_type_id" class="form-control">
      			<option value="">เลือก</option>
      			<? 
      			if(count($room_type)>0){
      				foreach($room_type as $val){
      			?>
      			<option value="<?=$val['room_type_id']?>" <? if($val['room_type_id']==$data[0]['room_type_id']){ ?>selected<? } ?>><?=$val['room_type_name']?></option>
      			<? 
      				}
      			}
      			?>
      		</select>
    	</div>
  	</div>
  	<div class="form-group">
    	<label class="control-label col-sm-2">ชื่อห้องพัก :</label>
    	<div class="col-sm-7">
      		<input type="text" name="room_name" value="<?=$data[0]['room_name']?>" class="form-control">
    	</div>
  	</div>
  	<div class="form-group">
    	<label class="control-label col-sm-2">หมายเลขห้องพัก :</label>
    	<div class="col-sm-7">
      		<input type="text" name="room_code" value="<?=$data[0]['room_code']?>" class="form-control">
    	</div>
  	</div>
  	<div class="form-group">
    	<label class="control-label col-sm-2">รายละเอียด :</label>
    	<div class="col-sm-7">
      		<textarea rows="5" name="room_detail" class="form-control"><?=$data[0]['room_detail']?></textarea>
    	</div>
  	</div>
  	<div class="form-group">
    	<label class="control-label col-sm-2"></label>
    	<div class="col-sm-7">
      		<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก</button>
    	</div>
  	</div>
  	<input type="hidden" name="id" value="<?=$id?>"/>
</form>
<?
Template::render('./../template-admin/footer.php');
?>