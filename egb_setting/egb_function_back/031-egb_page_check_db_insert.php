<?php

function egb_page_check_db_insert($check_uniq_id, $check_formatted_time, $check_scroll_position, $check_window_width, $check_user_agent, $check_device_info, $check_is_crawler, $check_bot_name, $check_referrer){

$query = "INSERT INTO egb_check (check_uniq_id, check_formatted_time, check_scroll_position, check_window_width, check_user_agent, check_device_info, check_is_crawler, check_bot_name, check_referrer) VALUES (:check_uniq_id, :check_formatted_time, :check_scroll_position, :check_window_width, :check_user_agent, :check_device_info, :check_is_crawler, :check_bot_name, :check_referrer)";
$param = [
	
	':check_uniq_id' => $check_uniq_id,
	':check_formatted_time' => $check_formatted_time,
	':check_scroll_position' => $check_scroll_position,
	':check_window_width' => $check_window_width,
	':check_user_agent' => $check_user_agent,
	':check_device_info' => $check_device_info,
	':check_is_crawler' => $check_is_crawler,
	':check_bot_name' => $check_bot_name,
	':check_referrer' => $check_referrer
	
	];

$binding = binding_sql(2, $query, $param);
$sql = egb_sql($binding);


return $sql[0];

}

?>
