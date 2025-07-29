<?php
function egb_page($type, $page){
	if ($type === "html"){echo $page;}
	if ($type === "php"){eval ($page);}
	if ($type === "path"){egb_file_load($page);}
}
?>