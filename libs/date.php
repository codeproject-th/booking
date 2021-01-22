<?	
function DateThai($strDate){
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
}
	
function age($bday=""){
	if($bday!=''){
		$birthday = $bday;      
		$today = date("Y-m-d");  
	
		list($byear, $bmonth, $bday)= explode("-",$birthday);
		list($tyear, $tmonth, $tday)= explode("-",$today);
		
		$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
		$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
		$mage = ($mnow - $mbirthday);
	
		$u_y=date("Y", $mage)-1970;
		$u_m=date("m",$mage)-1;
		$u_d=date("d",$mage)-1;
		return $u_y." ปี ".$u_m." เดือน";
	}
}


function DateTH($date=""){
	if($date!=""){
		$date_ex = explode("-",$date);
		return $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
	}
}

function DateYearTH($date=""){
	if($date!=''){
		$date_ex = explode("-",$date);
		return $date_ex[2]."/".$date_ex[1]."/".($date_ex[0]+543);
	}
}

function DateTimeTH($date=""){
	$date_ = explode(' ',$date);
	$date_ex = explode("-",$date_[0]);
	return $date_ex[2]."/".$date_ex[1]."/".$date_ex[0];
}

function FullDateTimeTH($date=""){
	if($date!="" and $date!="0000-00-00"){
		$date_ = explode(' ',$date);
		$date_ex = explode("-",$date_[0]);
		return $date_ex[2]."/".$date_ex[1]."/".$date_ex[0]." ".$date_[1];
	}
}


function DateDB($date=""){
	if($date!=""){
		$date = explode("/",$date);
		return $date[2]."-".$date[1]."-".$date[0];
	}
}

function FullDateThai($date=""){
	if($date!=""){
		$strMonth = Array(
								"01" => "มกราคม",
								"02" => "กุมภาพันธ์",
								"03" => "มีนาคม",
								"04" => "เมษายน",
								"05" => "พฤษภาคม",
								"06" => "มิถุนายน",
								"07" => "กรกฎาคม",
								"08" => "สิงหาคม",
								"09" => "กันยายน",
								"10" => "ตุลาคม",
								"11" => "พฤศจิกายน",
								"12" => "ธันวาคม"
							);
		$date_ex = explode("-",$date);
		return $date_ex[2]." ".$strMonth[$date_ex[1]]." ".($date_ex[0]+543);
	}
}

function DateThaiToDB($date=''){
	if($date!=''){
		$date_ex = explode('/',$date);
		return ($date_ex[2]-543)."-".$date_ex[1]."-".$date_ex[0];
	}
}

function add_date($givendate,$day=0,$mth=0,$yr=0) {
	$cd = strtotime($givendate);
	$newdate = date('Y-m-d', mktime(date('h',$cd),
	date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
	date('d',$cd)+$day, date('Y',$cd)+$yr));
	return $newdate;
}

function DateDiff($strDate1,$strDate2){
	$bday = $strDate1;
	$birthday = $bday;
	if($bday!=''){
		//$birthday = '2015-02-01';       
		$today = $strDate2;  
	
		list($byear, $bmonth, $bday)= explode("-",$birthday);       //จุดต้องเปลี่ยน
		list($tyear, $tmonth, $tday)= explode("-",$today);                //จุดต้องเปลี่ยน
		
		$mbirthday = mktime(0, 0, 0, $bmonth, $bday, $byear); 
		$mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear );
		$mage = ($mnow - $mbirthday);
	
		$u_y=date("Y", $mage)-1970;
		$u_m=date("m",$mage)-1;
		$u_d=date("d",$mage)-1;
	
		return $u_d;
	}
}

function time_format($time=''){
	if($time!=''){
		$ex = explode(':',$time);
		return $ex[0].':'.$ex[1];
	}
	
}

?>
