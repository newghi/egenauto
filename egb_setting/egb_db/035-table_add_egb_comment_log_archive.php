<?php
function table_add_egb_comment_log_archive() {
	$query_db = "
CREATE TABLE IF NOT EXISTS egb_comment_log_archive LIKE egb_comment_log;
";

	return $query_db;
}
?>
