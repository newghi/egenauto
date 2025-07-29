<?php
//로그 함수
function log_end() {
	// 클라이언트 IP 주소 가져오기
	$client_ip = egb_get('ip');
	
	// User-Agent 가져오기
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	
	// VPN 여부 확인
	$vpn_status = '';
	
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		
		$client_ip = $_SERVER['HTTP_CLIENT_IP'];
		$vpn_status = 'VPN detected';
		
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		
		$client_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		$vpn_status = 'VPN detected';
		
	}
	
	// 국가 감지
	$country = file_get_contents('http://ipinfo.io/'.$client_ip.'/country');
	
	// 현재 경로 가져오기
	$current_path = $_SERVER['REQUEST_URI'];
	
	// 이전 페이지 가져오기
	if (!empty($_SERVER['HTTP_REFERER'])){$prev_page = $_SERVER['HTTP_REFERER'];}else{$prev_page = '';}
	
	// 일자별 로그 기록
	$log_data = date('Y-m-d H:i:s') . ' | ' . $client_ip . ' | ' . $country . ' | ' . $user_agent . ' | ' . $current_path . ' | ' . $prev_page;
	
	// VPN 여부 확인 및 로그 남기기
	if ($vpn_status !== '') {
		$log_data .= ' | ' . $vpn_status;
		
	}
	
	// 요청 시간
	$request_time = REQUEST_TIME;
	
	// 응답 시간 및 처리 소요 시간
	$response_time = microtime(true);
	$processing_time = $response_time - $request_time;
	$log_data .= ' | ' . number_format($processing_time, 4) . 's';
	
	// 로그 기록
	$log_dir = 'egb_logs';
	
	if (!is_dir($log_dir)) {
		
		mkdir($log_dir, 0777, true);
		
	}
	
	file_put_contents($log_dir . '/' . date('Y-m-d') . '.log', $log_data . "\n", FILE_APPEND | LOCK_EX);
	
	// 일주일 전 로그 파일 삭제
	$old_logs = strtotime("-1 week");
	$old_logs_dir = date('Y/m/d', $old_logs);
	
	if (is_dir('egb_logs/' . $old_logs_dir)) {
		array_map('unlink', glob('egb_logs/' . $old_logs_dir . '/*.log'));
		rmdir('egb_logs/' . $old_logs_dir);
		
	}
	
}
	
?>