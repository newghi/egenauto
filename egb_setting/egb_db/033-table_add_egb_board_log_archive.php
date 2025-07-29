<?php
function table_add_egb_board_log_archive() {
	$query_db = "
CREATE TABLE IF NOT EXISTS egb_board_log_archive LIKE egb_board_log;
";

	return $query_db;
}
?>
