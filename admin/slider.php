<?php
//สไลค์
Template::render('./../template-admin/header.php');

//function save รูป
function upload_img($i=''){
	$rows = db::fetch('select * from slider WHERE slider_no="'.$i.'"');//ดึงข้อมูลรูปตามลำดับที่รับค่ามา
	$data = $rows[0];
	//ถ้ามีการแนบรูปถึงทำ
	if($_FILES['img'.$i]['name']!=''){
		$file_type_arr = explode('.',$_FILES['img'.$i]['name']);//แยกนามสกุลไฟล์ออกมาในรูปแบบ array
		$file_type = end($file_type_arr);//หา array จัวสุดท้าย
		$file_type = strtolower($file_type);//เปลี่ยนนามสกุลเป็นตัวเล็ก
		//ตรวจสอบว่าเป็นนามสกุลที่ต้องการใหม ถูกต้องจุงupload
		if($file_type=='jpg' or $file_type=='jepg' or $file_type=='png'){
			$img_name = str_pad($i,5,'0',STR_PAD_LEFT).".".$file_type;//สร้างชื่อไฟล์ใหม่
			$upload = move_uploaded_file($_FILES['img'.$i]["tmp_name"],"../uploads/slider/".$img_name);//บันทึกไฟล์
		}
	}else{
		$img_name = $data['slider_img'];
	}
	
	//กรณีลบไฟล์
	if($_POST['del'.$i]=='1'){
		@unlink("../uploads/slider/".$img_name);
		$img_name = '';
	}
	
	return $img_name;
}

$id = $_GET['id'];
$txt = "เพิ่มห้องพัก";
if($id!=''){
	$txt = "แก้ไขห้องพัก";
}
if($_POST){
	for($i=1;$i<=20;$i++){
		$img = upload_img($i);//เรียกใช้ function u[load]
		$chk = db::fetch('select COUNT(*) AS n from slider WHERE slider_no="'.$i.'"'); //ตรวจสอบว่ามีข้อมูลหรือยังยังไม่มีให้ insert มีแล้วให้ update
		if($chk[0]['n']=='0'){
			db::insert('slider',array('slider_no'=>$i,'slider_img'=>$img));
		}else{
			db::update('slider',array('slider_img'=>$img),array('slider_no'=>$i));
		}
	}
	$save = true;
}

$rows = db::fetch('select * from slider ORDER BY slider_no');//ดึงข้อมูลสไลด์
if(count($rows)>0){
	foreach($rows as $index => $val){
		$img_arr[$index+1] = $val['slider_img'];//เก็บค่าลงarrayไว้แสดง
	}
}

?>
<ol class="breadcrumb">
  <li class="breadcrumb-item">สไลค์</li>
</ol>
<? if($save==true){ ?>
<div class="alert alert-success">
  <strong>บันทึกข้อมูลเรียบร้อย</strong>
</div>
<? } ?>
<form method="post" class="form-horizontal" enctype="multipart/form-data">
	<? for($i=1;$i<=20;$i++){ ?>
  	<div class="form-group">
    	<label class="control-label col-sm-2">รูป <?=$i?> :</label>
    	<div class="col-sm-7">
    		<? if($img_arr[$i]!=''){ ?>
    		<img src="../uploads/slider/<?=$img_arr[$i]?>?r=<?=date('YmdHis')?>" width="100%"><br>
    		<input type="checkbox" name="del<?=$i?>" value="1"/> ลบ
    		<? } ?>
      		<input type="file" name="img<?=$i?>" value="" class="">
    	</div>
  	</div>
  	<? } ?>
  	<div class="form-group">
    	<label class="control-label col-sm-2"></label>
    	<div class="col-sm-7">
      		<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก</button>
    	</div>
  	</div>
  	<input type="hidden" name="id" value="0"/>
</form>
<?
Template::render('./../template-admin/footer.php');
?>