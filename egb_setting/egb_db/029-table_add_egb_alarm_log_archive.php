<?php
function table_add_egb_alarm_log_archive() {
	$query_db = "
CREATE TABLE IF NOT EXISTS egb_alarm_log_archive LIKE egb_alarm_log;
";

	return $query_db;
}
?>
