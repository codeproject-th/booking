<?php

class Template {
	
 	public static function render($script="",$vars="",$display=true) {
        ob_start();
		if(is_array($vars)){
			extract($vars);
		}
		
		
        $scriptStr = file_get_contents ( $script );    
        include $script;
        $html = ob_get_clean();
        if($display==false){
        	return $html; 
        }else if($display==true){
			echo $html;
		}
 	}
	
	
}
    
?>