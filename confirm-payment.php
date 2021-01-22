<?php
//ยืนยันการชำระเงิน
Template::render('./template/header.php');

//seave รูป
function save_img($id=''){
	$img['name'] = $_FILES['img']['name'];//เก็บชื่อรูปที่upload
	$id_m = $id;
	
	if($img['name']!=""){
		$ex = explode('.',$img['name']);
		$file_type = end($ex);
		$new_file = $id.'.'.$file_type;
		if(move_uploaded_file($_FILES['img']['tmp_name'],"./uploads/images-confirm/".$new_file)){
			return $new_file;
		}
	}
}
if($_POST){
	$code_reg = number_format($_POST['code_reg']);//id การจอง
	$code_reg = str_replace(',','',$code_reg);
	$reg_data = db::select('booking',array('booking_id'=>$code_reg));//ดึงข้อมูลการจอง
	if(count($reg_data)>0 and $_FILES['img']['name']!=''){
		$reg_id = $reg_data[0]['booking_id'];
		$insert_data = array(
						'booking_id' => $reg_id,//id การจอง
						'price' => $_POST['price'],//จำนวนเงิน
						'bank' => $_POST['bank'],//ธนาคาร
						'time' => $_POST['time'],//เวลา
						'date' => $_POST['date'],//วันที่
						'bank_id' => $_POST['bank_id'],//ธนาคารที่โอนเข้า
						'confirm_payment_date' => date('Y-m-d H:i:s'),//วันที่โอน
						'img' => save_img(date('YmdHis'))//รูป
						);
		db::insert('confirm_payment',$insert_data);
		echo '<script> window.location = "index.php?f=confirm-payment-success&id='.$reg_id.'"; </script>';
		$save = true;
	}else{
		if(count($reg_data)==0){
			$error = "ไม่พบหมายเลขลงทะเบียน";
		}else if($_FILES['img']['name']==''){
			$error = "กรุณาแนบไฟล์";
		}
	}
}

$sql = 'SELECT * FROM booking WHERE member_id="'.$_SESSION['member_login_id'].'" ORDER BY booking_date DESC';//ดึงข้อมูลประวัติที่ลูกค้าจอง
$reg_data = db::fetch($sql);

$sql = 'SELECT * FROM bank ';//ดึงธนาคาร
$bank_data = db::fetch($sql);
?>
<div class="col-xs-3"></div>
<div class="col-xs-6">
<!-------------------------------------------------------------------------->
		<ul class="breadcrumb">
      		<li class="active">แจ้งการชำระเงิน</li>
    	</ul>
		<form  method="post" enctype="multipart/form-data" class="">
			<div class="form-group">
	   			<label>หมายเลขลงการจอง * :</label>
	   			<? if($_SESSION['member_login_id']!=''){ ?>
		      	<select name="code_reg" class="form-control"  required>
		      	<option value="">เลือก</option>
		      	<? if(count($reg_data)>0){ 
		      		foreach($reg_data as $val){
		      	?>
					<option value="<?=$val['booking_id']?>"  <? if($_GET['id']==$reg_data[0]['booking_id']){ ?>selected<? } ?>><?=str_pad($val['booking_id'],7,'0',STR_PAD_LEFT)?></option>
				<? 
					}
				} ?>
				</select>
				<? }else{?>
				<input type="text" name="code_reg" class="form-control" required>	
				<? } ?>
		    </div>
		    <div class="form-group">
	   			<label>ธนาคารที่โอนเข้า * :</label>
		      	<select name="bank_id" class="form-control"  required>
		      		<option value="">เลือก</option>
		      		<? foreach($bank_data as $val){ ?>
		      		<option value="<?=$val['bank_id']?>"><?=$val['bank_name']?></option>
		      		<? } ?>
		      	</select>
  			</div>
		    <div class="form-group">
	   			<label>ธนาคารต้นทาง * :</label>
		      	<input type="text" name="bank" class="form-control" required>
  			</div>
		    <div class="form-group">
	   			<label>จำนวนเงิน * :</label>
		      	<input type="number" name="price" class="form-control" required>
  			</div>
  			<div class="form-group" style="">
	   			<label>เวลา * :</label>
		      	<input type="text" name="time" class="form-control" required>
		    </div>
		    <div class="form-group" style="">
	   			<label>วันที่ * :</label>
		      	<input type="text" name="date" class="form-control" required>
  			</div>
  			<div class="form-group">
	   			<label>ไฟล์แนบ * :</label>
		      	<input type="file" name="img" required/>
  			</div>
  			<div class="form-group">
	   			<label></label>
		      	<button class="btn btn-primary cus-btn" type="submit">แจ้งชำระเงิน</button>
  			</div>
		</form>	
<!-------------------------------------------------------------------------->	
</div>
<div class="col-xs-3"></div>
<?php
Template::render('./template/footer.php');
?>