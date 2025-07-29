<?php
function binding_sql($fetch, $sql, $params = []) {
	foreach ($params as $key => $value) {
		if (is_array($value) || is_object($value)) {
			$params[$key] = json_encode($value, JSON_UNESCAPED_UNICODE);
		}
	}
	return [
		'fetch' => $fetch,
		'sql' => $sql,
		'params' => $params
	];
}

?>
