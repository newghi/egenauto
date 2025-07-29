<?php

function themes_path(){
	
	if (file_exists(ROOT . DS . 'egb_themes-path.php')) {
		
		require_once ROOT . DS . 'egb_themes-path.php';
		
	} else {
		
	}
}

?>