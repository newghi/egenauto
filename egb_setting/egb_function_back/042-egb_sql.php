<?php
/*
$queries = [
    [
        "sql" => "SELECT * FROM table1",
        "params" => [],
    ],
    [
        "sql" => "SELECT * FROM table2 WHERE id = :id",
        "params" => [":id" => $id],
    ],
];

$results = egb_sql($queries);
*/

function egb_sql(...$queries) {
	// PDO 객체 생성
	$pdo = egb_get('db');
	try {
		// 오류 및 예외에 대한 모드 설정
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// PDO 트랜잭션 시작
		if ($queries[0]['fetch'] != 3){
			// 동시성에 대한 트랜지션 격리성을 최고로 설정
			$database = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
			egb_db_check($pdo, $database);
			$pdo->beginTransaction();
		}
		$results = [];
		foreach ($queries as $query) {
			// 인자가 배열인지 확인
			if (!is_array($query)) {
				continue;
			}
			// 셀렉트문인 경우 모든 행을 리턴 받으려면 0
			if ($query['fetch'] === 0){$fetchType = 0;}
			// 셀렉트문인 경우 1개의 행을 리턴 받으려면 1
			if ($query['fetch'] === 1){$fetchType = 1;}
			// 인서트, 딜리트, 업데이트문읜 경우에는 성공 여부를 리턴
			if ($query['fetch'] === 2){$fetchType = 2;}
			// 데이터베이스 생성 및 테이블 생성과 같은 작업시 성공 여부를 리턴 및 트랙잭션 미사용.
			// 3번을 사용 할 경우에는 1개의 쿼리만 사용 해야 한다.
			if ($query['fetch'] === 3){$fetchType = 3;}
			$sql = $query['sql'];
			$params = $query['params'];
			// 준비된 문 생성
			$stmt = $pdo->prepare($sql);
			// 파라미터 바인딩
			foreach ($params as $key => $value) {
				$stmt->bindValue($key, $value);
			}
			// 쿼리 실행
			$query_result = $stmt->execute();
			// 결과 반환
			if (strtolower(substr(trim($sql), 0, 6)) === 'select') {
				if ($fetchType === 0) {
					$results[] = $stmt->fetchAll(PDO::FETCH_ASSOC);
				} else if ($fetchType === 1) {
					$results[] = $stmt->fetch(PDO::FETCH_ASSOC);
				}
			} else {
				
				if ($fetchType === 2 or $fetchType === 3){$results[] = $query_result;}else{}
			}
		}
		// 모든 쿼리가 정상적인 경우 커밋
		if ($queries[0]['fetch'] != 3){$pdo->commit();}
		// 연결 종료
		$pdo = null;
		return $results;
	} catch (PDOException $e) {
		// 문제가 발생한 경우 롤백
		if ($queries[0]['fetch'] != 3){$pdo->rollBack();}
		//echo "Error: " . $e->getMessage();
		return false;
	} catch (InvalidArgumentException $e) {
		//echo $e->getMessage();
		return false;
	}
}



?>