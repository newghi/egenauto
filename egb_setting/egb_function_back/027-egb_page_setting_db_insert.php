<?php

function egb_page_setting_db_insert($setting_uniq_id, $setting_header_use = '미사용', $setting_footer_use = '미사용', $setting_comment_use = '미사용', $setting_access_level = '0'){

$query = "INSERT INTO egb_setting (setting_uniq_id, setting_header_use, setting_footer_use, setting_comment_use, setting_access_level) VALUES (:setting_uniq_id, :setting_header_use, :setting_footer_use, :setting_comment_use, :setting_access_level)";
$param = [
	
	':setting_uniq_id' => $setting_uniq_id,
	':setting_header_use' => $setting_header_use,
	':setting_footer_use' => $setting_footer_use,
	':setting_comment_use' => $setting_comment_use,
	':setting_access_level' => $setting_access_level
	
	];

$binding = binding_sql(2, $query, $param);
$sql = egb_sql($binding);


return $sql[0];

}

?>
