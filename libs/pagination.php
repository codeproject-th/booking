<?php

class pagination{
	public static function pages($all_page=1){
		
		$url = '';
		if(count($_GET)>0){
			foreach($_GET as $key => $val){
				if($key!='page' AND $key!='mod' AND $key!='f' AND $key!='delete_id'){
					$url .= "&".$key."=".$val;
				}
			}
		}
		
		$p_page = '1';
		if($_GET['page']){
			$p_page = $_GET['page'];
		}
		if($all_page>1){
			for($i=1;$i<=$all_page;$i++){
				$p = $i;
				if($i==$p_page){
					$p = "<u>".$i."</u>";
				}
				$html .= '<a href="index.php?mod='.$_GET['mod'].'&f='.$_GET['f'].$url.'&page='.$i.'">'.$p.'</a> &nbsp;'; 
			}
		}
		
		return '<div class="pagination">'.$html.'</div>';
	}
}

?>