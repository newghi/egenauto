<?php
function egb_ip_blocking($targetString) {
    // 클라이언트 IP 가져오기
    $client_ip = egb_ip();

    // IP 차단 여부 확인 쿼리
    $query_check = "
    SELECT COUNT(*) AS count
    FROM egb_blocked_ips 
    WHERE ip_address = :ip_address 
    AND (end_time IS NULL OR end_time > NOW())
    ";
    $params_check = [
        ':ip_address' => $client_ip
    ];
    $binding_check = binding_sql(1, $query_check, $params_check);
    $sql_check = egb_sql($binding_check);

    // 이미 차단된 IP인지 확인
    if (isset($sql_check[0]['count']) && $sql_check[0]['count'] > 0) {
		header('HTTP/1.1 403 Forbidden');
		echo '접근차단';
		echo '<br><br>보안이 작동하는 페이지에 접속을 시도 하여 IP가 영구 차단 되었습니다.';
		echo '<br>만약 의도하지 않은 이유로 해당 페이지를 방문 하였다면 아래 이메일로 소명하여 해제를 요구하세요.';
		echo '<br><br>ibik@ibik.kr';
		exit;
    }

    // 특정 문자열 포함 여부 확인
    if (strpos(URL, $targetString) !== false) {
        // 차단 여부 재확인
        if (isset($sql_check[0]['count']) && $sql_check[0]['count'] > 0) {
			header('HTTP/1.1 403 Forbidden');
			echo '접근차단';
			echo '<br><br>보안이 작동하는 페이지에 접속을 시도 하여 IP가 영구 차단 되었습니다.';
			echo '<br>만약 의도하지 않은 이유로 해당 페이지를 방문 하였다면 아래 이메일로 소명하여 해제를 요구하세요.';
			echo '<br><br>ibik@ibik.kr';
			exit;
        } else {
            // 새로운 차단 추가
            $query_insert = "
            INSERT INTO egb_blocked_ips (ip_address, reason, start_time, end_time)
            VALUES (:ip_address, :reason, NOW(), NULL)
            ";
            $params_insert = [
                ':ip_address' => $client_ip,
                ':reason' => $targetString . ' 관련 접속'
            ];
            $binding_insert = binding_sql(2, $query_insert, $params_insert);
            $sql_insert = egb_sql($binding_insert);

            if (isset($sql_insert[0])) {
				header('HTTP/1.1 403 Forbidden');
				echo '접근차단';
				echo '<br><br>보안이 작동하는 페이지에 접속을 시도 하여 IP가 영구 차단 되었습니다.';
				echo '<br>만약 의도하지 않은 이유로 해당 페이지를 방문 하였다면 아래 이메일로 소명하여 해제를 요구하세요.';
				echo '<br><br>ibik@ibik.kr';
				exit;
            } else {
                // 차단 실패 처리
                header('HTTP/1.1 500 Internal Server Error');
                echo 'Error while processing the request.';
                exit;
            }
        }
    }
}
?>