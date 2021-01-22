<?php
session_start();
//นำไฟล์อื่นมารรวมเพิ่อใช้งาน
include("config.php");
include("libs/db.php");
include("libs/date.php");
include("libs/template.php");

//function ตรวจสอบเวลาเกินกำหนดชำระเงิน
function delete_booking_auto(){
	$today = date('Y-m-d');
	$sql = 'SELECT * FROM booking WHERE booking_status="0"';//ดึงข้อมูลตาราง booking
	$rows = db::fetch($sql);
	if(count($rows)>0){
		foreach($rows as $val){
			//loop ช้อมูล
			$add_date = add_date($today,-1).' 17:00:00'; //เอาวันที่ปัจจุบันลบ 1 วัน
			//echo strtotime($val['booking_date']).'>'.strtotime($add_date).'<br>';
			$date_ex = explode(' ',$val['booking_date']);//แยกเวลา ออกจากวันที่
			$data_d = $date_ex[0].' 17:00:00';
			//เปรียบเทียบวันที่ว่าเวลาเกินที่กำหนดหรือเปล่า
			if(strtotime($data_d)<strtotime($add_date)){
				//echo strtotime($val['booking_date']).'>'.strtotime($add_date).'<br>';
				//ถ้าวันที่น้องกวา่าให้ลบข้อมูลการจอง
				db::delete('booking',array('booking_id'=>$val['booking_id']));
			}
		}
	}
}

db::open();//เปิดการเชื่อมต่อฐานข้อมูล
delete_booking_auto();

$f = $_GET['f'];//รับค่า get การทำงานข้อเว็บทั้งหมดจะเรียกมาที่ไฟล์นี้ แล่วใช้ การ include ไฟล์เขามาใช้โดยอ้างอิงจาก ตัวแปร f
if($f==""){
	//ถ้าค่า f ว่าง ให้ เก็บ home
	$f = "home";
	
}
$f = str_replace(array('.','/','\\'),'',$f);
include($f.".php");//เรียกใช้ ไฟล์ f มาต่อบ .php รวใกันจะเป็นชื่อไฟล์ เช่น home.php
?>