<?php

function sumRoom($room_type='',$start_date='',$end_date=''){
	$sql = 'SELECT COUNT(*) AS n FROM booking_room 
			INNER JOIN room ON booking_room.room_id = room.room_id
			WHERE booking_room.booking_room_start_date>="'.$start_date.'" AND booking_room.booking_room_end_date<="'.$end_date.'" 
			AND booking_room.booking_room_status !="2" AND room.room_type_id="'.$room_type.'" ';
	//echo $sql.'<br>';
	$rows = db::fetch($sql);
	return $rows[0]['n'];
}

Template::render('./../template-admin/header.php');

if($_GET['date']!=''){
	$date_ex = explode('-',$_GET['date']);
	$start_date = DateDB(trim($date_ex[0]));
	$end_date = DateDB(trim($date_ex[1]));
}

if($start_date==''){
	$start_date = date('Y-m-d');
}

if($end_date==''){
	$end_date = date('Y-m-d');
}


$sql = 'SELECT * FROM room_type';
$rows = db::fetch($sql);
if(count($rows)>0){
	foreach($rows as $val){
		$labels[] = $val['room_type_name'];
		$data[] = sumRoom($val['room_type_id'],$start_date,$end_date);
	}
}



?>
<script src="../js/ChartJS/dist/Chart.bundle.min.js"></script>
<ol class="breadcrumb">
  <li class="breadcrumb-item active">รายงานการเข้าพัก</li>
</ol>
<div class="col-xs-12" style="height: 650px;">
	<form method="get"  style="">
		<div class="col-xs-6">
	  		<div class="form-group">
	  			<label for="pwd">วันที่ :</label>
	    		<input type="text" name="date" class="form-control" required>
	  		</div>
  		</div>
  		<div class="col-xs-2">
  			<div class="form-group">
	  			<label for="pwd">&nbsp;</label>
  				<button type="submit" class="btn btn-primary" style="margin-top: 25px;"> ค้นหา</button>
  			</div>
  		</div>
  		<input type="hidden" name="f" value="report"/>
  	</form>
  	<br><br>
	<div style="height: 200px; margin-top: 30px;">
		<br><br>
		<canvas id="myChart" width="400" height="200"></canvas>
	</div>
</div>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?=json_encode($labels)?>,
        datasets: [{
            label: 'จำนวนผู้เข้าพัก <?=DateTH($start_date)?> - <?=DateTH($end_date)?>',
            data: <?=json_encode($data)?>,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});	


$('input[name="date"]').daterangepicker({
    opens: "center",
    locale: {
           format: 'DD/MM/YYYY'
	}
});

</script>
<?
Template::render('./../template-admin/footer.php');
?>