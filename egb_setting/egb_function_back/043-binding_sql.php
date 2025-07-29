<?php
function binding_sql($fetch, $sql, $params = []) {
	return [
		'fetch' => $fetch,
		'sql' => $sql,
		'params' => $params
	];
}
?>