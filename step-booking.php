<?
Template::render('./template/header.php');
$data = db::fetch('SELECT * FROM content');
?>
<div class="col-xs-12">
	<ul class="breadcrumb">
      	<li class="active">ขั้นตอนการจอง</li>
    </ul>
    <div style="padding: 10px;"><?=$data[0]['content_data']?></div>
</div>
<?
Template::render('./template/footer.php');
?>