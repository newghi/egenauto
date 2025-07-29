<?php
function egb_db_check(PDO $pdo, $database){
	$isolationQuery = '';
	if ($database === 'mysql') {
		// MySQL의 격리 수준 설정
		$isolationQuery = 'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE';
	} else if ($database === 'pgsql') {
		// PostgreSQL의 격리 수준 설정
		$isolationQuery = 'SET SESSION CHARACTERISTICS AS TRANSACTION ISOLATION LEVEL SERIALIZABLE';
	} else if ($database === 'oci') {
		// Oracle의 격리 수준 설정
		$isolationQuery = 'ALTER SESSION SET ISOLATION_LEVEL = SERIALIZABLE';
	} else if ($database === 'sqlsrv') {
		// SQL Server의 격리 수준 설정
		$isolationQuery = 'SET TRANSACTION ISOLATION LEVEL SERIALIZABLE';
	}
	if (!empty($isolationQuery)) {
		$pdo->exec($isolationQuery);
	}
}

?>
