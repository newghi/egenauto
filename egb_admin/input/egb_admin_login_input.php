<?php

// 관리자 로그인 페이지에서 변수값 받기
$admin_id = egb('admin_id');
$admin_password = egb('admin_password');

// SQL 쿼리 준비
$query = "SELECT * FROM egb_admin WHERE admin_id = :admin_id";
$param = [':admin_id' => $admin_id];
$binding = binding_sql(1, $query, $param);

// SQL 실행
$sql = egb_sql($binding);

// 비밀번호 검증
if (password_verify($admin_password, $sql[0]['admin_password'])) {
    $_SESSION['admin_login'] = 1;
}

// 리디렉션
redirect(BACK_URL); exit;

?>
