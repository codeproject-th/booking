<?php
//เพิ่มข้อมูลการจอง
Template::render('./../template-admin/header.php');
include('./../fc/fc-booking.php');
//function save ข้อมูล
function save(){
	$content_data = $_POST['content_data'];
	db::query('UPDATE content SET content_data="'.$content_data.'" ');
	
	return $error;
}

if($_POST){
	$error = save();
}

$data = db::fetch('SELECT * FROM content');
?>
<script src="../js/ckeditor/ckeditor.js"></script>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">ขึ้นตอนการจอง</li>
</ol>
<div class="col-xs-12">
 <?php if($error!='' and $_POST){ ?>
    <div class="alert alert-danger">
  		<strong><?=$error?></strong>
	</div>
	<?php }else if($error=='' and $_POST){ ?>
	<div class="alert alert-success">
  		<strong>บันทึกข้อมูลเรียบร้อย</strong>
	</div>
	<? } ?>
<!----------->
<form method="post">
  <div class="form-group">
    <label>รายละเอียด :</label>
    <textarea class="form-control" id="ckeditor" name="content_data" required><?=$data[0]['content_data']?></textarea>
    <script>
    	 CKEDITOR.replace('ckeditor');
    </script>
  </div>
  <button type="submit" class="btn btn-primary">บันทึก</button>
</form> 
<!--------->
</div>
<?
Template::render('./../template-admin/footer.php');
?>