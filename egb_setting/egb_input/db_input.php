<?php
//넘어온 값들이 있는지 체크
if (egb('db_host') && egb('db_user') && egb('db_password') && egb('db_name')){
	//db-setting으로 부터 받은 post값을 변수에 할당
	$db_host = egb('db_host');
	$db_user = egb('db_user');
	$db_password = egb('db_password');
	$db_name = egb('db_name');
	
	//db_connect 상수 선언
	//db host 를 입력 보통 localhost 또는 ip주소
	define("DB_HOST", $db_host);
	//db user id 를 입력
	define("DB_USER", $db_user);
	//db 접속 비밀번호를 입력
	define("DB_PASSWORD", $db_password);
	//접속할 db의 이름
	define("DB_NAME", $db_name);
	
	try {
		$db_connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);
		
		if (!$db_connect) {
			throw new Exception("MySQL 연결 실패: " . mysqli_connect_error());
		}
		
		// 데이터베이스가 이미 존재하는지 확인
		$check_db_query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . mysqli_real_escape_string($db_connect, $db_name) . "'";
		$result = mysqli_query($db_connect, $check_db_query);
		
		if ($result == false) {
			throw new Exception("데이터베이스 조회 실패: " . mysqli_error($db_connect));
		}
		
		if (mysqli_num_rows($result) == 0) {
			// 데이터베이스가 존재하지 않으므로 생성
			$query_db = "CREATE DATABASE " . mysqli_real_escape_string($db_connect, $db_name) . " CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
			if (!mysqli_query($db_connect, $query_db)) {
				throw new Exception("데이터베이스 생성 실패: " . mysqli_error($db_connect));
			}
			//echo "데이터베이스 " . htmlspecialchars($db_name) . " 생성 성공!";
		}
		
		//데이터베이스 선택
		$db_connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (!$db_connect) {
			throw new Exception("데이터베이스 선택 실패: " . mysqli_connect_error());
		}

		// 레코드 수 테이블 생성
		$query_db = table_egb_record_count();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("레코드 수 테이블 생성 실패: " . mysqli_error($db_connect));
		}
		
		// 테이블 칼럼 테이블 생성
		$query_db = table_egb_table_column_config();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("테이블 칼럼 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_table_column_config');
		}
		
		// 웹 접근 로그 테이블 생성
		$query_db = table_add_egb_log();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("웹 접근 로그 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_log');
			egb_table_column_config_insert('egb_log');
		}
		
		// 관리자 정보 테이블
		$query_db = table_egb_admin();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("관리자 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_admin');
			egb_table_column_config_insert('egb_admin');
		}

		// 일반 페이지 경로 테이블 생성
		$query_db = table_add_egb_page();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("페이지 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_page');
			egb_table_column_config_insert('egb_page');
		}

		// 관리자 페이지 경로 테이블 생성
		$query_db = table_add_egb_admin_page();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("관리자 페이지 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_admin_page');
			egb_table_column_config_insert('egb_admin_page');
		}

		// 일반 인풋 페이지 경로 테이블 생성
		$query_db = table_add_egb_input_page();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("인풋 페이지 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_input_page');
			egb_table_column_config_insert('egb_input_page');
		}

		// 리소스 경로 테이블 생성  
		$query_db = table_add_egb_resource_map();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("리소스 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_resource_map');
			egb_table_column_config_insert('egb_resource_map');
		}

		// 다운로드 테이블 생성
		$query_db = table_add_egb_download();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("다운로드 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_download');
			egb_table_column_config_insert('egb_download');
		}

		// 옵션 그룹 테이블 생성
		$query_db = table_add_egb_option_group();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("옵션 그룹 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_option_group');
			egb_table_column_config_insert('egb_option_group');
		}

		// 옵션 테이블 생성
		$query_db = table_add_egb_option();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("옵션 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_option');	
			egb_table_column_config_insert('egb_option');
		}

		// 메뉴 그룹 테이블 생성
		$query_db = table_add_egb_menu_group();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("메뉴 그룹 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_menu_group');
			egb_table_column_config_insert('egb_menu_group');
		}

		// 메뉴 테이블 생성
		$query_db = table_add_egb_menu();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("메뉴 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_menu');
			egb_table_column_config_insert('egb_menu');
		}

		// 회원 테이블 생성
		$query_db = table_add_egb_user();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("회원 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_user');
			egb_table_column_config_insert('egb_user');
		}

		// 통합 데이터 테이블 생성
		$query_db = table_add_egb_integrated_data();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("통합 데이터 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_integrated_data');
			egb_table_column_config_insert('egb_integrated_data');
		}

		// 이벤트 테이블 생성
		$query_db = table_add_egb_event();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("이벤트 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_event');
			egb_table_column_config_insert('egb_event');
		}

		// 예치금 테이블 생성
		$query_db = table_add_egb_deposit();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("예치금 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_deposit');
			egb_table_column_config_insert('egb_deposit');
		}

		// 적립금 테이블 생성
		$query_db = table_add_egb_point();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("적립금 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_point');
			egb_table_column_config_insert('egb_point');
		}

		// 마일리지 테이블 생성
		$query_db = table_add_egb_mileage();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("마일리지 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_mileage');
			egb_table_column_config_insert('egb_mileage');
		}

		// 리워드 테이블 생성
		$query_db = table_add_egb_reward();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("리워드 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_reward');
			egb_table_column_config_insert('egb_reward');
		}

		// 리워드 로그 테이블 생성
		$query_db = table_add_egb_reward_log();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("리워드 로그 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_reward_log');
			egb_table_column_config_insert('egb_reward_log');
		}

		// 리워드 로그 아카이브 테이블 생성
		$query_db = table_add_egb_reward_log_archive();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("리워드 로그 아카이브 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_reward_log_archive');
			egb_table_column_config_insert('egb_reward_log_archive');
		}

		$query_db = table_add_egb_board_management();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("게시판 관리 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_management_board');
			egb_table_column_config_insert('egb_management_board');
		}

		// 좋아요 로그 테이블 생성
		$query_db = table_add_egb_like_log();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("좋아요 로그 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_like_log');
			egb_table_column_config_insert('egb_like_log');
		}

		// 스크랩 로그 테이블 생성
		$query_db = table_add_egb_scrap_log();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("스크랩 로그 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_scrap_log');
			egb_table_column_config_insert('egb_scrap_log');
		}

		// 공유 로그 테이블 생성
		$query_db = table_add_egb_share_log();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("공유 로그 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_share_log');
			egb_table_column_config_insert('egb_share_log');
		}

		// 스토어 테이블 생성
		$query_db = table_add_egb_store();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("스토어 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_store');
			egb_table_column_config_insert('egb_store');
		}

		// 예약 테이블 생성
		$query_db = table_add_egb_reservation();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("예약 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_reservation');
			egb_table_column_config_insert('egb_reservation');
		}

		// 알림 로그 테이블 생성
		$query_db = table_add_egb_alarm_log();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("알림 로그 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_alarm_log');
			egb_table_column_config_insert('egb_alarm_log');
		}

		// 알림 로그 아카이브 테이블 생성
		$query_db = table_add_egb_alarm_log_archive();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("알림 로그 아카이브 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_alarm_log_archive');
			egb_table_column_config_insert('egb_alarm_log_archive');
		}

		// API 관리 테이블 생성
		$query_db = table_add_egb_api_management();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("API 관리 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_api_management');
			egb_table_column_config_insert('egb_api_management');
		}

		// 이메일 로그 테이블 생성
		$query_db = table_add_egb_email_log();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("이메일 로그 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_email_log');
			egb_table_column_config_insert('egb_email_log');
		}

		// 게시판 로그 테이블 생성
		$query_db = table_add_egb_board_log();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("게시판 로그 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_board_log');
			egb_table_column_config_insert('egb_board_log');
		}

		// 게시판 로그 아카이브 테이블 생성
		$query_db = table_add_egb_board_log_archive();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("게시판 로그 아카이브 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_board_log_archive');
			egb_table_column_config_insert('egb_board_log_archive');
		}

		// 댓글 로그 테이블 생성
		$query_db = table_add_egb_comment_log();
		if (!mysqli_query($db_connect, $query_db)) {
			throw new Exception("댓글 로그 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_comment_log');	
			egb_table_column_config_insert('egb_comment_log');
		}

		// 댓글 로그 아카이브 테이블 생성
		$query_db = table_add_egb_comment_log_archive();
		if (!mysqli_query($db_connect, $query_db)) {	
			throw new Exception("댓글 로그 아카이브 테이블 생성 실패: " . mysqli_error($db_connect));
		} else {
			egb_record_count_table_insert('egb_comment_log_archive');
			egb_table_column_config_insert('egb_comment_log_archive');
		}

		// 관리자 페이지 경로 추가
		egb_db_admin_page_insert('관리자 페이지', 'page', DS . 'egb_admin' . DS . 'page' . DS . 'page.php', 'path');
		egb_db_page_insert('관리자 칼럼 인쇄 페이지', 'egb_admin_column_print', DS . 'egb_admin' . DS . 'page' . DS . 'egb_admin_column_print.php', 'path');

		//관리자 인풋 페이지 경로 추가
		egb_db_input_page_insert('관리자 로그인 인풋 페이지', 'egb_admin_login_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_admin_login_input.php');
		egb_db_input_page_insert('페이지 스타일 인풋 페이지', 'page_style_input', DS . 'egb_setting' . DS  . 'egb_input' . DS . 'page_style_input.php');

		egb_db_input_page_insert('컬럼 설정 업데이트 인풋 페이지', 'egb_column_config_update', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_column_config_update.php');
		egb_db_input_page_insert('상태 업데이트 인풋 페이지', 'egb_is_status_update', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_is_status_update.php');
		egb_db_input_page_insert('엑셀 양식 다운로드 인풋 페이지', 'egb_excel_format_download', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_excel_format_download.php');
		egb_db_input_page_insert('엑셀 데이터 다운로드 인풋 페이지', 'egb_excel_download', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_excel_download.php');
		egb_db_input_page_insert('엑셀 데이터 업로드 인풋 페이지', 'egb_excel_upload', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_excel_upload.php');
		egb_db_input_page_insert('삭제 인풋 페이지', 'egb_delete_form_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_delete_form_input.php');
	
		egb_db_input_page_insert('페이지 추가 인풋 페이지', 'egb_page_add_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_page_add_input.php');
		egb_db_input_page_insert('페이지 수정 인풋 페이지', 'egb_page_edit_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_page_edit_input.php');

		egb_db_input_page_insert('옵션 그룹 추가 인풋 페이지', 'egb_option_group_add_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_option_group_add_input.php');
		egb_db_input_page_insert('옵션 그룹 수정 인풋 페이지', 'egb_option_group_edit_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_option_group_edit_input.php');

		egb_db_input_page_insert('옵션 그룹 검색 인풋 페이지', 'egb_option_group_search_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_option_group_search_input.php');
		egb_db_input_page_insert('옵션 부모 검색 인풋 페이지', 'egb_option_parent_search_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_option_parent_search_input.php');
		
		egb_db_input_page_insert('옵션 추가 인풋 페이지', 'egb_option_add_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_option_add_input.php');
		egb_db_input_page_insert('옵션 수정 인풋 페이지', 'egb_option_edit_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_option_edit_input.php');


		egb_db_input_page_insert('개인사업전 번호 조회 인풋 페이지', 'business_authenticity_verification_form_input', DS . 'egb_api' . DS  . 'public_data_portal' . DS . 'business_authenticity_verification_form_input.php');
		egb_db_input_page_insert('법인사업자 번호 조회 인풋 페이지', 'corporation_authenticity_verification_form_input', DS . 'egb_api' . DS  . 'public_data_portal' . DS . 'corporation_authenticity_verification_form_input.php');

		egb_db_input_page_insert('이벤트 추가 인풋 페이지', 'egb_event_add_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_event_add_input.php');
		egb_db_input_page_insert('이벤트 수정 인풋 페이지', 'egb_event_edit_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_event_edit_input.php');

		egb_db_input_page_insert('예치금 추가 인풋 페이지', 'egb_deposit_add_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_deposit_add_input.php');
		egb_db_input_page_insert('예치금 검색 인풋 페이지', 'egb_deposit_user_search_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_deposit_user_search_input.php');

		egb_db_input_page_insert('적립금 추가 인풋 페이지', 'egb_point_add_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_point_add_input.php');
		egb_db_input_page_insert('적립금 검색 인풋 페이지', 'egb_point_user_search_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_point_user_search_input.php');

		egb_db_input_page_insert('마일리지 추가 인풋 페이지', 'egb_mileage_add_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_mileage_add_input.php');
		egb_db_input_page_insert('마일리지 검색 인풋 페이지', 'egb_mileage_user_search_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_mileage_user_search_input.php');

		egb_db_input_page_insert('리워드 수정 인풋 페이지', 'egb_reward_edit_input', DS . 'egb_admin' . DS  . 'input' . DS . 'egb_reward_edit_input.php');

		//공용 인풋
		egb_db_input_page_insert('스토어 요일 토글 인풋 페이지', 'egb_store_toggle_weekday_status_input', DS . 'egb_setting' . DS  . 'egb_input' . DS . 'egb_store_toggle_weekday_status_input.php');
		egb_db_input_page_insert('스토어 시간 토글 인풋 페이지', 'egb_store_toggle_slot_status_input', DS . 'egb_setting' . DS  . 'egb_input' . DS . 'egb_store_toggle_slot_status_input.php');
		egb_db_input_page_insert('스토어 카운트 업데이트 인풋 페이지', 'egb_store_update_slot_count_input', DS . 'egb_setting' . DS  . 'egb_input' . DS . 'egb_store_update_slot_count_input.php');
		egb_db_input_page_insert('스토어 휴일 추가 인풋 페이지', 'egb_store_add_holiday_input', DS . 'egb_setting' . DS  . 'egb_input' . DS . 'egb_store_add_holiday_input.php');
		egb_db_input_page_insert('스토어 휴일 삭제 인풋 페이지', 'egb_store_delete_holiday_input', DS . 'egb_setting' . DS  . 'egb_input' . DS . 'egb_store_delete_holiday_input.php');

		egb_db_input_page_insert('스토어 시간 조회 인풋 페이지', 'egb_get_store_schedule_time_input', DS . 'egb_setting' . DS  . 'egb_input' . DS . 'egb_get_store_schedule_time_input.php');

		egb_db_input_page_insert('알림 읽음 처리 인풋 페이지', 'egb_alarm_read_input', DS . 'egb_setting' . DS  . 'egb_input' . DS . 'egb_alarm_read_input.php');


		//크론 인풋
		egb_db_input_page_insert('코어 크론 인풋 페이지', 'egb_core_cron_input', DS . 'egb_setting' . DS  . 'egb_cron' . DS . 'index.php');
		egb_db_input_page_insert('관리자 크론 인풋 페이지', 'egb_admin_cron_input', DS . 'egb_admin' . DS  . 'cron' . DS . 'index.php');
		egb_db_input_page_insert('테마 크론 인풋 페이지', 'egb_theme_cron_input', DS . 'egb_themes' . DS  . 'eungabi' . DS . 'cron' . DS . 'index.php');
		egb_db_input_page_insert('사이트맵 크론 인풋 페이지', 'egb_cron_sitemap_delete', DS . 'egb_setting' . DS  . 'egb_cron' . DS . 'cron_list' . DS . 'egb_cron_sitemap_delete.php');

		//테마 페이지 경로 추가
		$themes_path = ROOT . DS . 'egb_themes';
		
		// 테마 폴더 목록 가져오기
		foreach (glob($themes_path . DS . '*', GLOB_ONLYDIR) as $theme_path) {
		    $theme_name = basename($theme_path);
		    $page_path = $theme_path . DS . 'page';
		    
		    // 각 테마의 page 폴더 내 PHP 파일들을 순회
		    if (is_dir($page_path)) {
		        foreach (glob($page_path . DS . '*.php') as $filepath) {
		            $filename = basename($filepath, '.php');
		            $relative_path = DS . 'egb_themes' . DS . $theme_name . DS . 'page' . DS . $filename . '.php';
		            
		            // 등록 함수 호출 - theme_name을 5번째 인자로 전달
		            egb_db_page_insert('테마 페이지: ' . $filename, $filename, $relative_path, 'path', $theme_name);
		        }
		    }

			//사이트맵 생성
			$file_list = [
				'main'
			];
	
			egb_index_sitemap($file_list);
					
		    // db_insert.php 파일이 있는지 확인하고 실행
		    $db_insert_file = $theme_path . DS . 'db_insert.php';
		    if (file_exists($db_insert_file)) {
		        require_once $db_insert_file;
		    }
		}

		
		//상수 생성
		if (CMS_TYPE === 'egb') {
			$db_constant_file_path = DS . "egb_setting" . DS . "egb_constant_2" . DS;
			$db_constant_file_name = "001-egb_db_constant.php";
			$db_constant_file_contents = "<?php
			
// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset(\$_SERVER['HTTPS']) and \$_SERVER['HTTPS'] == 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo \"<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='\". PROTOCOL.\$_SERVER['HTTP_HOST'].\"'; </script>\";exit;}

//db_connect 상수 선언
//db host 를 입력 보통 localhost 또는 ip주소
if (!defined('DB_HOST')) {define('DB_HOST', '$db_host');}

//db user id 를 입력
if (!defined('DB_USER')) {define('DB_USER', '$db_user');}

//db 접속 비밀번호를 입력
if (!defined('DB_PASSWORD')) {define('DB_PASSWORD', '$db_password');}

//접속할 db의 이름
if (!defined('DB_NAME')) {define('DB_NAME', '$db_name');}

?>";

			// db-constant.php 파일 생성
			egb_upload($db_constant_file_path, $db_constant_file_name, $db_constant_file_contents);
		}

		$site_check_file_path = DS;
		$site_check_file_name = "egb_site-check.php";
		$site_check_file_contents = '<?php define(\'SITE_CHECK\', \'2\'); ?>'; 
		
		// site-check.php 파일 내용 2로 수정
		egb_upload($site_check_file_path, $site_check_file_name, $site_check_file_contents);
		
		//DB연결 종료
		mysqli_close($db_connect);
		
		//DB 데이터베이스 생성 후 새로고침
		redirect(DOMAIN);
		
		exit;
		
	} catch (Exception $e) {
		die($e->getMessage());
	}
	
}else{}

?>
