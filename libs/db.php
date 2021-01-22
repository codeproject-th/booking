<?php

class db{
	
	public static $link;
	
	public static function open($mysql_host=MYSQL_HOST,$mysql_user=MYSQL_USERNAME,$mysql_pass=MYSQL_PASSWORD,$mysql_db=MYSQL_DATABASE){
		db::$link = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db) or die('NOT CONNECT DATABASE SERVER');
		mysqli_set_charset(db::$link,"utf8");
	}
	
	public static function close(){
		mysqli_close(db::$link);
	}
	
	public static function insert($table="", $insert_values=array()) {
		foreach($insert_values as $key=>$value) {
    		$keys[] = $key;
        	$insertvalues[] = '\''.$value.'\'';
    	}
    	$keys = implode(',', $keys);
    	$insertvalues = implode(',', $insertvalues);
    	$sql = "INSERT INTO $table ($keys) VALUES ($insertvalues)";
		return db::sqlordie($sql);
	}

	public static function insert_id() {
		return mysqli_insert_id(db::$link);
	}

	public static function update($table="",$update_values="",$where=array()) {
   		foreach($update_values as $key => $value) {
       		$sets[] = $key.'=\''.$value.'\'';
    	}
   		 $sets = implode(',', $sets);
		foreach($where as $key => $value){
       		$sets_w .= " AND ".$key.'=\''.$value.'\'';
   		}
	
   		$sql = "UPDATE $table SET $sets WHERE 1=1 ".$sets_w;
   		return db::sqlordie($sql);
	}

	public static function select($table = "",$where_values = array(),$fields="*",$order_by = ""){
    	if(count($where_values)>0){
			foreach($where_values as $key => $value){
        		$sets .= " AND ".$key.'=\''.mysqli_escape_string(db::$link,$value).'\'';
       		}
		}
    	$sql = "SELECT $fields FROM $table WHERE 1=1 ".$sets." ".$order_by;
		$result = db::sqlordie($sql);
		if($result){	
			while($row = mysqli_fetch_assoc($result)) {
	    		$records[] = $row;
	   		}
   		}
    	return $records;
	}

	public static function delete($table = "",$where_values = array()){
   		foreach($where_values as $key => $value){
    		$sets .= " AND ".$key.'=\''.$value.'\'';
   		}
    	$sql = "DELETE FROM $table WHERE 1=1 ".$sets." ".$order_by;
    	$result = db::sqlordie($sql);
    	return $result;
	}
	
	public static function fetch($sql=""){
		//echo $sql;
		$result = mysqli_query(db::$link,$sql);
    	while($row = mysqli_fetch_assoc($result)) {
			$records[] = $row;
    	}
   	 	return $records;
	}
	
	public static function query($sql) {
		$return_result = mysqli_query(db::$link,$sql);
		return $return_result;
 	}
 
	public static function pagination($sql="",$page=1,$r=30){
		if($page==""){
			$page = 1;
		}
		$rows = db::fetch($sql);
		$count_page = ceil(count($rows)/$r);
		$start = ($page*$r)-$r;
		$sql = $sql." LIMIT $start , $r";
		$data = db::fetch($sql);
		
		$no = $start;
		return array(
				"data" => $data,
				"pages" => $count_page,
				"no" => $no
			);
	}

	public static function str($str=""){
		return mysqli_escape_string(db::$link,$str);
	}

	public static function sqlordie($sql) {
    	$return_result = mysqli_query(db::$link,$sql);
    	if($return_result) {
     		return $return_result;
    	}else {
    		db::db_error($sql);
    	}
	}

	public static function db_error($sql) {
		return mysqli_error(db::$link).'<br>'.$sql;
	}
	
	public static function db_date($date='',$type='date'){
		$return = '';
		switch($type){
			case 'date': 
				if($date!=''){
					$date_ex = explode('/',$date);
					$return = $date_ex[2].'-'.$date_ex[1].'-'.$date_ex[0];
				}
			break;
		}
		return $return;
	}
	
	public static function search($table = "",$where_values = array(),$fields="*",$order_by = ""){
    	if(count($where_values)>0){
			foreach($where_values as $key => $value){
				if($value!=''){ 
        			$sets .= 'AND '.$key.' LIKE \'%'.mysqli_escape_string(db::$link,$value).'%\'';
        		}
       		}
		}
    	$sql = "SELECT $fields FROM $table WHERE 1=1 ".$sets." ".$order_by;
    	return $sql;
	}
}

?>