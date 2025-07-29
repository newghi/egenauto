
<?php

// 캐시 방지 헤더 설정
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// 입력된 데이터 가져오기
$user_id = egb('user_id', 44);
$user_password = egb('user_password', 45);

// 사용자 조회 쿼리 (해시된 비밀번호와 상태 포함)
$query = "SELECT uniq_id, user_password, is_status FROM egb_user WHERE user_id = :user_id";
$params = [
	':user_id' => $user_id
];
$binding = binding_sql(1, $query, $params);
$result = egb_sql($binding);

// 로그인 성공 여부 확인
if ($result && isset($result[0]['user_password'])) {
	$hashed_password = $result[0]['user_password'];
	$is_status = $result[0]['is_status'];

	// 계정 상태 확인
	if ($is_status != 1) {
		echo json_encode(['success' => false, 'failureCode' => 138, 'is_status' => $is_status]); // 계정 상태 오류 코드
		exit;
	}

	// 비밀번호 검증
	if (password_verify($user_password, $hashed_password)) {
		// 세션에 사용자 인증 정보 저장
		$_SESSION['user_uniq_id'] = $result[0]['uniq_id'];
		$_SESSION['user_id'] = $user_id;
		$_SESSION['user_login'] = 1;
		$_SESSION['logged_in'] = true;

		// 응답 전에 캐시 방지 헤더 재설정
		header('Cache-Control: no-cache, no-store, must-revalidate');
		header('Pragma: no-cache');
		header('Expires: 0');

		echo json_encode(['success' => true, 'successCode' => 2, 'url' => DOMAIN]);
	} else {
		echo json_encode(['success' => false, 'failureCode' => 46]); // 비밀번호 불일치 오류 코드
	}
} else {
	echo json_encode(['success' => false, 'failureCode' => 47]); // 아이디가 존재하지 않는 오류 코드
}

?>
