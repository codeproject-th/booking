<?php
//ประเภทห้อง
Template::render('./../template-admin/header.php');

//function ัพโหลดรูป
function upload_img($id='',$i=''){
	$rows = db::fetch('select * from room_type WHERE room_type_id="'.$id.'"');
	$data = $rows[0];
	if($_FILES['img'.$i]['name']!=''){
		$file_type_arr = explode('.',$_FILES['img'.$i]['name']);
		$file_type = end($file_type_arr);
		$file_type = strtolower($file_type);
		if($file_type=='jpg' or $file_type=='jepg' or $file_type=='png'){
			if($id==''){
				$rows = db::fetch('select MAX(room_type_id) as m from room_type');
				$id = $rows[0]['m']+1;
			}
			$img_name = str_pad($id,5,'0',STR_PAD_LEFT)."-".$i.".".$file_type;
			$upload = move_uploaded_file($_FILES['img'.$i]["tmp_name"],"../uploads/room-type/".$img_name);
		}
	}else{
		$img_name = $data['room_type_img'.$i];
	}
	
	if($_POST['del'.$i]=='1'){
		@unlink("../uploads/room-type/".$img_name);
		$img_name = '';
	}
	
	return $img_name;
}

$id = $_GET['id'];
$txt = "เพิ่มประเภทห้องพัก";
if($id!=''){
	$txt = "แก้ไขประเภทห้องพัก";
}
if($_POST){
	$insert['room_type_name	'] = $_POST['room_type_name'];//ชื่อห้อง
	$insert['room_type_detail'] = $_POST['room_type_detail'];//รายละเอียดประเภทห้อง
	$insert['room_type_people'] = $_POST['room_type_people'];//จำนวนผู้เข้าพัก
	$insert['room_type_price'] = $_POST['room_type_price'];//ราตา
	$insert['room_type_deposit'] = $_POST['room_type_deposit'];//ค่ามัดจำ
	$insert['room_type_img1'] = upload_img($id,'1');
	$insert['room_type_img2'] = upload_img($id,'2');
	$insert['room_type_img3'] = upload_img($id,'3');
	$insert['room_type_img4'] = upload_img($id,'4');
	$insert['room_type_img5'] = upload_img($id,'5');
	
	if($id==''){
		db::insert('room_type',$insert);//เพิ่ม
	}else{
		db::update('room_type',$insert,array('room_type_id'=>$id));//แก้ไข
	}
	$save = true;
}

if($id!=''){
	$data = db::select('room_type',array('room_type_id'=>$id));//ดึงข้อมูลห้อง
}

?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">ประเภทห้องพัก</li>
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
      		<input type="text" name="room_type_name" value="<?=$data[0]['room_type_name']?>" class="form-control">
    	</div>
  	</div>
  	<div class="form-group">
    	<label class="control-label col-sm-2">รายละเอียด :</label>
    	<div class="col-sm-7">
      		<textarea rows="5" name="room_type_detail" class="form-control"><?=$data[0]['room_type_detail']?></textarea>
    	</div>
  	</div>
  	<div class="form-group">
    	<label class="control-label col-sm-2">จำนวนคน :</label>
    	<div class="col-sm-3">
      		<input type="number" name="room_type_people" value="<?=$data[0]['room_type_people']?>" class="form-control">
    	</div>
  	</div>
  	<div class="form-group">
    	<label class="control-label col-sm-2">ราคา :</label>
    	<div class="col-sm-3">
      		<input type="number" name="room_type_price" value="<?=$data[0]['room_type_price']?>" class="form-control">
    	</div>
  	</div>
  	<div class="form-group">
    	<label class="control-label col-sm-2">ค่ามัดจำ :</label>
    	<div class="col-sm-3">
      		<input type="number" name="room_type_deposit" value="<?=$data[0]['room_type_deposit']?>" class="form-control">
    	</div>
  	</div>
  	<? for($i=1;$i<=5;$i++){ ?>
  	<div class="form-group">
    	<label class="control-label col-sm-2">รูป<?=$i?> :</label>
    	<div class="col-sm-7">
    		<? if($data[0]['room_type_img'.$i]!=''){ ?>
    		<img src="../uploads/room-type/<?=$data[0]['room_type_img'.$i]?>?r=<?=date('YmdHis')?>" class="img-responsive">
    		<input type="checkbox" name="del<?=$i?>" value="1"/> ลบ
    		<br><br>
    		<? } ?>
      		<input type="file" name="img<?=$i?>"/>
    	</div>
  	</div>
  	<? } ?>
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