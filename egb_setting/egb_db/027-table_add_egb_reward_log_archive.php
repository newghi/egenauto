<?php
function table_add_egb_reward_log_archive() {
	$query_db = "
CREATE TABLE IF NOT EXISTS egb_reward_log_archive LIKE egb_reward_log;
";

	return $query_db;
}
?>
