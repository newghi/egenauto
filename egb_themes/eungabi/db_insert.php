<?php
//테마 시작시 등록될 데이터베이스 정보
//옵션 정보

//옵션 그룹 삽임 함수
// egb_option_group_insert($group_code, $group_name);

//옵션 삽입 함수
// egb_option_insert($option_group_uniq_id, $option_key, $option_value, $option_parent_uniq_id = null);

$option_group_uniq_id_1 = egb_option_group_insert('shopping_mall_user_type', '쇼핑몰 회원 구분');
$option_uniq_id_1 = egb_option_insert($option_group_uniq_id_1, '일반회원', null);
$option_uniq_id_2 = egb_option_insert($option_group_uniq_id_1, '기업회원', null);

$option_group_uniq_id_2 = egb_option_group_insert('shopping_mall_user_type_business', '사업자 구분');
$option_uniq_id_3 = egb_option_insert($option_group_uniq_id_2, '개인사업자', null);
$option_uniq_id_4 = egb_option_insert($option_group_uniq_id_2, '법인사업자', null);

$option_group_uniq_id_3 = egb_option_group_insert('user_company_name', '사업자명');
$option_group_uniq_id_4 = egb_option_group_insert('user_company_name2', '법인명');

$option_group_uniq_id_5 = egb_option_group_insert('user_company_registration_number', '사업자번호');


$data = [
    'user_count' => '0',
    'is_auto_promotion' => '1',
    'benefit_type' => 'rate',
    'benefit_data' => '무료배송 + 5% 할인',
    'payment_amount' => '1000'
];

$json = json_encode($data, JSON_UNESCAPED_UNICODE);


$option_group_uniq_id_6 = egb_option_group_insert('community_user_grade', '커뮤니티 회원 등급');
$option_uniq_id_5 = egb_option_insert($option_group_uniq_id_6, '일반회원', $json);
$option_uniq_id_6 = egb_option_insert($option_group_uniq_id_6, '멘티', $json);
$option_uniq_id_7 = egb_option_insert($option_group_uniq_id_6, '멘토', $json);
$option_uniq_id_8 = egb_option_insert($option_group_uniq_id_6, '파트너', $json);
$option_uniq_id_9 = egb_option_insert($option_group_uniq_id_6, '가맹점', $json);
$option_uniq_id_10 = egb_option_insert($option_group_uniq_id_6, '사업자', $json);
$option_uniq_id_11 = egb_option_insert($option_group_uniq_id_6, '스텝', $json);

$option_group_uniq_id_7 = egb_option_group_insert('shopping_mall_user_grade', '쇼핑몰 회원 등급');
$option_uniq_id_12 = egb_option_insert($option_group_uniq_id_7, '일반회원', $json);
$option_uniq_id_13 = egb_option_insert($option_group_uniq_id_7, '이젠회원', $json);
$option_uniq_id_14 = egb_option_insert($option_group_uniq_id_7, '페친회원', $json);
$option_uniq_id_15 = egb_option_insert($option_group_uniq_id_7, 'B2B사업자회원', $json);
$option_uniq_id_16 = egb_option_insert($option_group_uniq_id_7, 'VIP회원_50', $json);
$option_uniq_id_17 = egb_option_insert($option_group_uniq_id_7, '파트너회원', $json);
$option_uniq_id_18 = egb_option_insert($option_group_uniq_id_7, '플래티넘파트너회원', $json);
$option_uniq_id_19 = egb_option_insert($option_group_uniq_id_7, '다이아회원', $json);


$option_group_uniq_id_8 = egb_option_group_insert('user_mentor_id', '멘토아이디');
$option_uniq_id_20 = egb_option_insert($option_group_uniq_id_8, 'egenauto21', null);


$option_group_uniq_id_9 = egb_option_group_insert('user_id', '아이디');
$option_group_uniq_id_10 = egb_option_group_insert('user_password', '비밀번호');
$option_group_uniq_id_11 = egb_option_group_insert('user_password_check', '비밀번호 확인');
$option_group_uniq_id_12 = egb_option_group_insert('user_name', '이름');
$option_group_uniq_id_13 = egb_option_group_insert('user_nick_name', '별명');
$option_group_uniq_id_14 = egb_option_group_insert('user_zipcode', '우편번호');
$option_group_uniq_id_15 = egb_option_group_insert('user_address', '기본주소');
$option_group_uniq_id_16 = egb_option_group_insert('user_address_detail', '상세주소');

$option_group_uniq_id_17 = egb_option_group_insert('phone_number', '지역번호');
$option_uniq_id_20 = egb_option_insert($option_group_uniq_id_17, '010', null);
$option_uniq_id_21 = egb_option_insert($option_group_uniq_id_17, '011', null);
$option_uniq_id_22 = egb_option_insert($option_group_uniq_id_17, '016', null);
$option_uniq_id_23 = egb_option_insert($option_group_uniq_id_17, '017', null);
$option_uniq_id_24 = egb_option_insert($option_group_uniq_id_17, '018', null);
$option_uniq_id_25 = egb_option_insert($option_group_uniq_id_17, '019', null);

$option_group_uniq_id_18 = egb_option_group_insert('phone_number1', '휴대전화');
$option_group_uniq_id_19 = egb_option_group_insert('phone_number2', '기타연락처');

$option_group_uniq_id_20 = egb_option_group_insert('user_email', '이메일');

$option_group_uniq_id_21 = egb_option_group_insert('user_email1', '이메일1');
$option_group_uniq_id_22 = egb_option_group_insert('user_email2', '이메일2');
$option_uniq_id_26 = egb_option_insert($option_group_uniq_id_22, 'naver.com', null);
$option_uniq_id_27 = egb_option_insert($option_group_uniq_id_22, 'hanmail.net', null);
$option_uniq_id_28 = egb_option_insert($option_group_uniq_id_22, 'daum.net', null);
$option_uniq_id_29 = egb_option_insert($option_group_uniq_id_22, 'kakao.com', null);
$option_uniq_id_30 = egb_option_insert($option_group_uniq_id_22, 'nate.com', null);
$option_uniq_id_31 = egb_option_insert($option_group_uniq_id_22, 'gmail.com', null);
$option_uniq_id_32 = egb_option_insert($option_group_uniq_id_22, 'hotmail.com', null);
$option_uniq_id_33 = egb_option_insert($option_group_uniq_id_22, 'icloud.com', null);

$option_group_uniq_id_23 = egb_option_group_insert('user_gender', '성별');
$option_uniq_id_34 = egb_option_insert($option_group_uniq_id_23, '남성', null);
$option_uniq_id_35 = egb_option_insert($option_group_uniq_id_23, '여성', null);

$option_group_uniq_id_24 = egb_option_group_insert('user_homepage', '홈페이지');
$option_group_uniq_id_25 = egb_option_group_insert('user_registration_purpose', '가입목적');
$option_group_uniq_id_26 = egb_option_group_insert('user_funnel_source', '유입경로');
$option_group_uniq_id_27 = egb_option_group_insert('user_birthday', '생일');

$option_group_uniq_id_28 = egb_option_group_insert('year', '년도');
$option_group_uniq_id_29 = egb_option_group_insert('month', '월'); 
$option_group_uniq_id_30 = egb_option_group_insert('day', '일');

// 년도 1900-2025
for($year = 1900; $year <= 2025; $year++) {
    egb_option_insert($option_group_uniq_id_28, $year, null);
}

// 월 01-12 
for($month = 1; $month <= 12; $month++) {
    $month_val = str_pad($month, 2, '0', STR_PAD_LEFT);
    egb_option_insert($option_group_uniq_id_29, $month_val, null);
}

// 일 01-31
for($day = 1; $day <= 31; $day++) {
    $day_val = str_pad($day, 2, '0', STR_PAD_LEFT);
    egb_option_insert($option_group_uniq_id_30, $day_val, null);
}

$option_group_uniq_id_31 = egb_option_group_insert('user_custom_day', '기념일');
$option_group_uniq_id_32 = egb_option_group_insert('user_bank_alias', '계좌별칭');
$option_group_uniq_id_33 = egb_option_group_insert('user_bank_account', '계좌번호');
$option_group_uniq_id_34 = egb_option_group_insert('user_bank_holder', '예금주');
$option_group_uniq_id_35 = egb_option_group_insert('user_job', '직업');
$option_group_uniq_id_36 = egb_option_group_insert('user_company_name3', '회사명');
$option_group_uniq_id_37 = egb_option_group_insert('user_department', '회사부서');
$option_group_uniq_id_38 = egb_option_group_insert('user_position', '직책');
$option_group_uniq_id_39 = egb_option_group_insert('user_work_phone', '직장전화');
$option_group_uniq_id_40 = egb_option_group_insert('user_work_fax', '직장팩스');
$option_group_uniq_id_41 = egb_option_group_insert('user_work_address', '직장주소');
$option_group_uniq_id_42 = egb_option_group_insert('user_activity_area', '활동지역');

$option_group_uniq_id_43 = egb_option_group_insert('user_car_cc', '자동차');
$option_uniq_id_36 = egb_option_insert($option_group_uniq_id_43, '1000cc 이하', null);
$option_uniq_id_37 = egb_option_insert($option_group_uniq_id_43, '1000cc ~ 1500cc', null);
$option_uniq_id_38 = egb_option_insert($option_group_uniq_id_43, '1500cc ~ 2000cc', null);
$option_uniq_id_39 = egb_option_insert($option_group_uniq_id_43, '2000cc ~ 3000cc', null);
$option_uniq_id_40 = egb_option_insert($option_group_uniq_id_43, '3000cc ~ 4000cc', null);
$option_uniq_id_41 = egb_option_insert($option_group_uniq_id_43, '4000cc 이상', null);

$option_group_uniq_id_44 = egb_option_group_insert('user_region', '지역');
$option_uniq_id_42 = egb_option_insert($option_group_uniq_id_44, '경기', null);
$option_uniq_id_43 = egb_option_insert($option_group_uniq_id_44, '서울', null);
$option_uniq_id_44 = egb_option_insert($option_group_uniq_id_44, '인천', null);
$option_uniq_id_45 = egb_option_insert($option_group_uniq_id_44, '강원', null);
$option_uniq_id_46 = egb_option_insert($option_group_uniq_id_44, '충남', null);
$option_uniq_id_47 = egb_option_insert($option_group_uniq_id_44, '충북', null);
$option_uniq_id_48 = egb_option_insert($option_group_uniq_id_44, '대전', null);
$option_uniq_id_49 = egb_option_insert($option_group_uniq_id_44, '경북', null);
$option_uniq_id_50 = egb_option_insert($option_group_uniq_id_44, '경남', null);
$option_uniq_id_51 = egb_option_insert($option_group_uniq_id_44, '대구', null);
$option_uniq_id_52 = egb_option_insert($option_group_uniq_id_44, '부산', null);
$option_uniq_id_53 = egb_option_insert($option_group_uniq_id_44, '울산', null);
$option_uniq_id_54 = egb_option_insert($option_group_uniq_id_44, '전북', null);
$option_uniq_id_55 = egb_option_insert($option_group_uniq_id_44, '전남', null);
$option_uniq_id_56 = egb_option_insert($option_group_uniq_id_44, '광주', null);
$option_uniq_id_57 = egb_option_insert($option_group_uniq_id_44, '세종', null);
$option_uniq_id_58 = egb_option_insert($option_group_uniq_id_44, '제주', null);
$option_uniq_id_59 = egb_option_insert($option_group_uniq_id_44, '해외', null);

$option_group_uniq_id_45 = egb_option_group_insert('user_shopping_mall_type', '쇼핑몰구분');
$option_uniq_id_60 = egb_option_insert($option_group_uniq_id_45, '이젠오토몰', null);
$option_uniq_id_61 = egb_option_insert($option_group_uniq_id_45, '이젠몰', null);
$option_uniq_id_62 = egb_option_insert($option_group_uniq_id_45, '쿠팡', null);
$option_uniq_id_63 = egb_option_insert($option_group_uniq_id_45, '스마트스토어', null);
$option_uniq_id_64 = egb_option_insert($option_group_uniq_id_45, '11번가', null);

//셀케어 사용이력
$option_group_uniq_id_46 = egb_option_group_insert('user_selfcare_history', '셀케어 사용이력');
$option_uniq_id_65 = egb_option_insert($option_group_uniq_id_46, '사용', null);
$option_uniq_id_66 = egb_option_insert($option_group_uniq_id_46, '미사용', null);

//셀프정비소 방문이력
$option_group_uniq_id_47 = egb_option_group_insert('user_selfrepair_visit', '셀프정비소 방문이력');
$option_uniq_id_67 = egb_option_insert($option_group_uniq_id_47, '사용', null);
$option_uniq_id_68 = egb_option_insert($option_group_uniq_id_47, '미사용', null);

//관리자 상담이력
$option_group_uniq_id_48 = egb_option_group_insert('user_admin_consulting_history', '관리자 상담이력');
$option_uniq_id_69 = egb_option_insert($option_group_uniq_id_48, '사용', null);
$option_uniq_id_70 = egb_option_insert($option_group_uniq_id_48, '미사용', null);

//가입시 디바이스
$option_group_uniq_id_49 = egb_option_group_insert('user_device', '가입시 디바이스');
$option_uniq_id_71 = egb_option_insert($option_group_uniq_id_49, '모바일', null);
$option_uniq_id_72 = egb_option_insert($option_group_uniq_id_49, '데스크탑', null);
$option_uniq_id_73 = egb_option_insert($option_group_uniq_id_49, '태블릿', null);
$option_uniq_id_74 = egb_option_insert($option_group_uniq_id_49, '기타', null);

$option_group_uniq_id_50 = egb_option_group_insert('user_age_limit_setting', '가입연령 제한 설정', '14');
$option_group_uniq_id_51 = egb_option_group_insert('easy_login_default_setting', '본인인증 제외설정');
$option_group_uniq_id_52 = egb_option_group_insert('re_join_setting', '재가입 기간제한', '1');
$option_group_uniq_id_53 = egb_option_group_insert('signup_deny_keyword', '가입불가 키워드', 'admin,administration,administrator,master,webmaster,manage,manager,godo,godomall,test');

//엑셀일괄등록 옵션
$option_group_uniq_id_54 = egb_option_group_insert('excel_shopping_mall_membership_classification', '쇼핑몰회원구분');
$option_group_uniq_id_55 = egb_option_group_insert('excel_community_member_classification', '커뮤니티회원구분');

//휴면회원
$option_group_uniq_id_56 = egb_option_group_insert('dormant_mode', '휴면회원 사용 설정');
$option_group_uniq_id_57 = egb_option_group_insert('inactive_member_how_to_convert', '휴면회원 전환방법');
$option_group_uniq_id_58 = egb_option_group_insert('inactive_member_reset_membership_level', '회원등급 초기화');
$option_group_uniq_id_59 = egb_option_group_insert('inactive_member_subscription_member_dormancy_conversion', '구독회원 휴면전환');
$option_group_uniq_id_60 = egb_option_group_insert('inactive_member_mileage_expiration_settings', '마일리지 소멸 설정');

//등급관리
$option_group_uniq_id_61 = egb_option_group_insert('community_coupon_issuance_timing', '커뮤니티 쿠폰 발급 시점 설정');
$option_group_uniq_id_62 = egb_option_group_insert('shopping_mall_coupon_issuance_timing', '쇼핑몰 쿠폰 발급 시점 설정');

$option_group_uniq_id_63 = egb_option_group_insert('shopping_grading_method', '쇼핑몰 등급평가방식');
$option_group_uniq_id_64 = egb_option_group_insert('shopping_whether_to_use_downgrade', '하향평가 사용여부');
$option_group_uniq_id_65 = egb_option_group_insert('shopping_performance_numerical_system', '실적 수치제');

$data = [
    'value1' => '1',
    'value2' => '1'
];

$json = json_encode($data, JSON_UNESCAPED_UNICODE);

$option_group_uniq_id_66 = egb_option_group_insert('shopping_performance_point_system', '실적 점수제');
$option_uniq_id_75 = egb_option_insert($option_group_uniq_id_66, '주문금액', $json);
$option_uniq_id_76 = egb_option_insert($option_group_uniq_id_66, '상품주문건수', $json);
$option_uniq_id_77 = egb_option_insert($option_group_uniq_id_66, '주문상품후기', $json);
$option_uniq_id_78 = egb_option_insert($option_group_uniq_id_66, '로그인횟수', $json);

$option_group_uniq_id_67 = egb_option_group_insert('event_category', '이벤트 카테고리');
$option_uniq_id_79 = egb_option_insert($option_group_uniq_id_67, '회원가입', null);
$option_uniq_id_80 = egb_option_insert($option_group_uniq_id_67, '회원정보', null);
$option_uniq_id_81 = egb_option_insert($option_group_uniq_id_67, '구독료할인', null);

$option_group_uniq_id_68 = egb_option_group_insert('manual_category', '정비 카테고리');
$option_uniq_id_82 = egb_option_insert($option_group_uniq_id_68, '도장', null);
$option_uniq_id_83 = egb_option_insert($option_group_uniq_id_68, '헤드라이트', null);
$option_uniq_id_84 = egb_option_insert($option_group_uniq_id_68, '와이퍼', null);
$option_uniq_id_85 = egb_option_insert($option_group_uniq_id_68, '광택', null);
$option_uniq_id_86 = egb_option_insert($option_group_uniq_id_68, '발수', null);
$option_uniq_id_87 = egb_option_insert($option_group_uniq_id_68, '타이어', null);
$option_uniq_id_88 = egb_option_insert($option_group_uniq_id_68, '배터리', null);
$option_uniq_id_89 = egb_option_insert($option_group_uniq_id_68, '브레이크 패드', null);
$option_uniq_id_90 = egb_option_insert($option_group_uniq_id_68, '램프 및 전구', null);
$option_uniq_id_91 = egb_option_insert($option_group_uniq_id_68, '필터', null);
$option_uniq_id_92 = egb_option_insert($option_group_uniq_id_68, '워셔액', null);
$option_uniq_id_93 = egb_option_insert($option_group_uniq_id_68, '냉각수', null);
$option_uniq_id_94 = egb_option_insert($option_group_uniq_id_68, '부동액', null);
$option_uniq_id_95 = egb_option_insert($option_group_uniq_id_68, '벨트', null);
$option_uniq_id_96 = egb_option_insert($option_group_uniq_id_68, '기타 부품', null);

$option_group_uniq_id_69 = egb_option_group_insert('manual_worker', '작업인원');
$option_uniq_id_97 = egb_option_insert($option_group_uniq_id_69, '1인', null);
$option_uniq_id_98 = egb_option_insert($option_group_uniq_id_69, '2인', null);
$option_uniq_id_99 = egb_option_insert($option_group_uniq_id_69, '3인', null);
$option_uniq_id_100 = egb_option_insert($option_group_uniq_id_69, '4인', null);
$option_uniq_id_101 = egb_option_insert($option_group_uniq_id_69, '5인', null);

$option_group_uniq_id_70 = egb_option_group_insert('manual_self_repair_shop', '셀프정비소');
$option_group_uniq_id_71 = egb_option_group_insert('manual_worker_time', '작업기간');
$option_group_uniq_id_72 = egb_option_group_insert('manual_worker_budget_part', '작업예산-부품');
$option_group_uniq_id_73 = egb_option_group_insert('manual_worker_budget_consumable', '작업예산-소모품');

$option_group_uniq_id_74 = egb_option_group_insert('manual_worker_type', '작업유형');
$option_uniq_id_102 = egb_option_insert($option_group_uniq_id_74, '국산', null);
$option_uniq_id_103 = egb_option_insert($option_group_uniq_id_74, '수입', null);

$option_group_uniq_id_75 = egb_option_group_insert('manual_brand_domestic', '제조사-국산');
$option_uniq_id_104 = egb_option_insert($option_group_uniq_id_75, '현대', null);
$option_uniq_id_105 = egb_option_insert($option_group_uniq_id_75, '제네시스', null);
$option_uniq_id_106 = egb_option_insert($option_group_uniq_id_75, '기아', null);
$option_uniq_id_107 = egb_option_insert($option_group_uniq_id_75, '쉐보레(GM대우)', null);
$option_uniq_id_108 = egb_option_insert($option_group_uniq_id_75, '르노코리아(삼성)', null);
$option_uniq_id_109 = egb_option_insert($option_group_uniq_id_75, 'KG모빌리티(쌍용)', null);
$option_uniq_id_110 = egb_option_insert($option_group_uniq_id_75, '대우버스', null);
$option_uniq_id_111 = egb_option_insert($option_group_uniq_id_75, '기타 제조사', null);

$option_group_uniq_id_76 = egb_option_group_insert('manual_brand_import', '제조사-수입');
$option_uniq_id_112 = egb_option_insert($option_group_uniq_id_76, '벤츠', null);
$option_uniq_id_113 = egb_option_insert($option_group_uniq_id_76, 'BMW', null);
$option_uniq_id_114 = egb_option_insert($option_group_uniq_id_76, '아우디', null);
$option_uniq_id_115 = egb_option_insert($option_group_uniq_id_76, '폭스바겐', null);
$option_uniq_id_116 = egb_option_insert($option_group_uniq_id_76, '미니', null);
$option_uniq_id_117 = egb_option_insert($option_group_uniq_id_76, '볼바', null);
$option_uniq_id_118 = egb_option_insert($option_group_uniq_id_76, '풀스타', null);
$option_uniq_id_119 = egb_option_insert($option_group_uniq_id_76, '포르쉐', null);
$option_uniq_id_120 = egb_option_insert($option_group_uniq_id_76, '람보르기니', null);
$option_uniq_id_121 = egb_option_insert($option_group_uniq_id_76, '페라리', null);
$option_uniq_id_122 = egb_option_insert($option_group_uniq_id_76, '렉서스', null);
$option_uniq_id_123 = egb_option_insert($option_group_uniq_id_76, '도요타', null);
$option_uniq_id_124 = egb_option_insert($option_group_uniq_id_76, '인피니티', null);
$option_uniq_id_125 = egb_option_insert($option_group_uniq_id_76, '혼다', null);    
$option_uniq_id_126 = egb_option_insert($option_group_uniq_id_76, '닛산', null);
$option_uniq_id_127 = egb_option_insert($option_group_uniq_id_76, '테슬라', null);
$option_uniq_id_128 = egb_option_insert($option_group_uniq_id_76, '포드', null);
$option_uniq_id_129 = egb_option_insert($option_group_uniq_id_76, '지프', null);
$option_uniq_id_130 = egb_option_insert($option_group_uniq_id_76, '크라이슬러', null);
$option_uniq_id_131 = egb_option_insert($option_group_uniq_id_76, '링컨', null);
$option_uniq_id_132 = egb_option_insert($option_group_uniq_id_76, '마세라티', null);
$option_uniq_id_133 = egb_option_insert($option_group_uniq_id_76, '재규어', null);
$option_uniq_id_134 = egb_option_insert($option_group_uniq_id_76, '랜드로버', null);
$option_uniq_id_135 = egb_option_insert($option_group_uniq_id_76, '푸조', null);
$option_uniq_id_136 = egb_option_insert($option_group_uniq_id_76, '기타 제조사', null);

$option_group_uniq_id_77 = egb_option_group_insert('manual_car_model', '차종');
$option_uniq_id_137 = egb_option_insert($option_group_uniq_id_77, '경형', null);
$option_uniq_id_138 = egb_option_insert($option_group_uniq_id_77, '소형', null);
$option_uniq_id_139 = egb_option_insert($option_group_uniq_id_77, '준중형', null);
$option_uniq_id_140 = egb_option_insert($option_group_uniq_id_77, '중형', null);
$option_uniq_id_141 = egb_option_insert($option_group_uniq_id_77, '준대형', null);
$option_uniq_id_142 = egb_option_insert($option_group_uniq_id_77, '대형', null);
$option_uniq_id_143 = egb_option_insert($option_group_uniq_id_77, '스포츠카', null);

$option_group_uniq_id_78 = egb_option_group_insert('manual_car_exterior', '외형');
$option_uniq_id_144 = egb_option_insert($option_group_uniq_id_78, '세단', null);
$option_uniq_id_145 = egb_option_insert($option_group_uniq_id_78, '해치백', null);
$option_uniq_id_146 = egb_option_insert($option_group_uniq_id_78, '컨버터블', null);
$option_uniq_id_147 = egb_option_insert($option_group_uniq_id_78, 'SUV', null);
$option_uniq_id_148 = egb_option_insert($option_group_uniq_id_78, '쿠페', null);
$option_uniq_id_149 = egb_option_insert($option_group_uniq_id_78, '왜건', null);
$option_uniq_id_150 = egb_option_insert($option_group_uniq_id_78, 'RV', null);
$option_uniq_id_151 = egb_option_insert($option_group_uniq_id_78, '밴', null);
$option_uniq_id_152 = egb_option_insert($option_group_uniq_id_78, '트럭', null);

$option_group_uniq_id_79 = egb_option_group_insert('manual_car_model_name', '모델명');

$option_group_uniq_id_80 = egb_option_group_insert('manual_car_fuel', '유종');
$option_uniq_id_153 = egb_option_insert($option_group_uniq_id_80, '가솔린', null);
$option_uniq_id_154 = egb_option_insert($option_group_uniq_id_80, '디젤', null);
$option_uniq_id_155 = egb_option_insert($option_group_uniq_id_80, '전기', null);
$option_uniq_id_156 = egb_option_insert($option_group_uniq_id_80, '하이브리드', null);
$option_uniq_id_157 = egb_option_insert($option_group_uniq_id_80, '수소', null);
$option_uniq_id_158 = egb_option_insert($option_group_uniq_id_80, 'LPG', null);

$option_group_uniq_id_81 = egb_option_group_insert('manual_car_year', '연식');

// 년도 1990-2025
for($year = 1990; $year <= 2025; $year++) {
    egb_option_insert($option_group_uniq_id_81, $year, null);
}

$option_group_uniq_id_82 = egb_option_group_insert('reservation_manual_item', '예약 정비 항목');
$option_uniq_id_159 = egb_option_insert($option_group_uniq_id_82, '타이어 위치교환', null);
$option_uniq_id_160 = egb_option_insert($option_group_uniq_id_82, '디스크교환', null);
$option_uniq_id_161 = egb_option_insert($option_group_uniq_id_82, '등속조인트', null);
$option_uniq_id_162 = egb_option_insert($option_group_uniq_id_82, '디퍼런셜 오일', null);
$option_uniq_id_163 = egb_option_insert($option_group_uniq_id_82, '라이트전구교환', null);
$option_uniq_id_164 = egb_option_insert($option_group_uniq_id_82, '기타정비(상세내용기입)', null);

$option_region_group_uniq_id_1 = egb_option_group_insert('egb_region', '지역');
    egb_option_insert($option_region_group_uniq_id_1, '서울특별시', null);
    egb_option_insert($option_region_group_uniq_id_1, '부산광역시', null);
    egb_option_insert($option_region_group_uniq_id_1, '대구광역시', null);
    egb_option_insert($option_region_group_uniq_id_1, '인천광역시', null);
    egb_option_insert($option_region_group_uniq_id_1, '광주광역시', null);
    egb_option_insert($option_region_group_uniq_id_1, '대전광역시', null);
    egb_option_insert($option_region_group_uniq_id_1, '울산광역시', null);
    egb_option_insert($option_region_group_uniq_id_1, '세종특별자치시', null);
    egb_option_insert($option_region_group_uniq_id_1, '경기도', null);
    egb_option_insert($option_region_group_uniq_id_1, '강원특별자치도', null);
    egb_option_insert($option_region_group_uniq_id_1, '충청북도', null);
    egb_option_insert($option_region_group_uniq_id_1, '충청남도', null);
    egb_option_insert($option_region_group_uniq_id_1, '전북특별자치도', null);
    egb_option_insert($option_region_group_uniq_id_1, '전라남도', null);
    egb_option_insert($option_region_group_uniq_id_1, '경상북도', null);
    egb_option_insert($option_region_group_uniq_id_1, '경상남도', null);
    egb_option_insert($option_region_group_uniq_id_1, '제주특별자치도', null);

$option_region_group_uniq_id_2 = egb_option_group_insert('egb_region_seoul', '서울특별시');
    egb_option_insert($option_region_group_uniq_id_2, '강남구', null);
    egb_option_insert($option_region_group_uniq_id_2, '강동구', null);
    egb_option_insert($option_region_group_uniq_id_2, '강북구', null);
    egb_option_insert($option_region_group_uniq_id_2, '강서구', null);
    egb_option_insert($option_region_group_uniq_id_2, '관악구', null);
    egb_option_insert($option_region_group_uniq_id_2, '광진구', null);
    egb_option_insert($option_region_group_uniq_id_2, '구로구', null);
    egb_option_insert($option_region_group_uniq_id_2, '금천구', null);
    egb_option_insert($option_region_group_uniq_id_2, '노원구', null);
    egb_option_insert($option_region_group_uniq_id_2, '도봉구', null);
    egb_option_insert($option_region_group_uniq_id_2, '동대문구', null);
    egb_option_insert($option_region_group_uniq_id_2, '동작구', null);
    egb_option_insert($option_region_group_uniq_id_2, '마포구', null);
    egb_option_insert($option_region_group_uniq_id_2, '서대문구', null);
    egb_option_insert($option_region_group_uniq_id_2, '서초구', null);
    egb_option_insert($option_region_group_uniq_id_2, '성동구', null);
    egb_option_insert($option_region_group_uniq_id_2, '성북구', null);
    egb_option_insert($option_region_group_uniq_id_2, '송파구', null);
    egb_option_insert($option_region_group_uniq_id_2, '양천구', null);
    egb_option_insert($option_region_group_uniq_id_2, '영등포구', null);
    egb_option_insert($option_region_group_uniq_id_2, '용산구', null);
    egb_option_insert($option_region_group_uniq_id_2, '은평구', null);
    egb_option_insert($option_region_group_uniq_id_2, '종로구', null);
    egb_option_insert($option_region_group_uniq_id_2, '중구', null);
    egb_option_insert($option_region_group_uniq_id_2, '중랑구', null);

$option_region_group_uniq_id_3 = egb_option_group_insert('egb_region_busan', '부산광역시');
    egb_option_insert($option_region_group_uniq_id_3, '강서구', null);
    egb_option_insert($option_region_group_uniq_id_3, '금정구', null);
    egb_option_insert($option_region_group_uniq_id_3, '기장군', null);
    egb_option_insert($option_region_group_uniq_id_3, '남구', null);
    egb_option_insert($option_region_group_uniq_id_3, '동구', null);
    egb_option_insert($option_region_group_uniq_id_3, '동래구', null);
    egb_option_insert($option_region_group_uniq_id_3, '부산진구', null);
    egb_option_insert($option_region_group_uniq_id_3, '북구', null);
    egb_option_insert($option_region_group_uniq_id_3, '사상구', null);
    egb_option_insert($option_region_group_uniq_id_3, '사하구', null);
    egb_option_insert($option_region_group_uniq_id_3, '서구', null);
    egb_option_insert($option_region_group_uniq_id_3, '수영구', null);
    egb_option_insert($option_region_group_uniq_id_3, '연제구', null);
    egb_option_insert($option_region_group_uniq_id_3, '영도구', null);
    egb_option_insert($option_region_group_uniq_id_3, '중구', null);
    egb_option_insert($option_region_group_uniq_id_3, '해운대구', null);

$option_region_group_uniq_id_4 = egb_option_group_insert('egb_region_daegu', '대구광역시');
    egb_option_insert($option_region_group_uniq_id_4, '군위군', null);
    egb_option_insert($option_region_group_uniq_id_4, '남구', null);
    egb_option_insert($option_region_group_uniq_id_4, '달서구', null);
    egb_option_insert($option_region_group_uniq_id_4, '달성군', null);
    egb_option_insert($option_region_group_uniq_id_4, '동구', null);
    egb_option_insert($option_region_group_uniq_id_4, '북구', null);
    egb_option_insert($option_region_group_uniq_id_4, '서구', null);
    egb_option_insert($option_region_group_uniq_id_4, '수성구', null);
    egb_option_insert($option_region_group_uniq_id_4, '중구', null);


$option_region_group_uniq_id_5 = egb_option_group_insert('egb_region_incheon', '인천광역시');
    egb_option_insert($option_region_group_uniq_id_5, '강화군', null);
    egb_option_insert($option_region_group_uniq_id_5, '계양구', null);
    egb_option_insert($option_region_group_uniq_id_5, '남동구', null);
    egb_option_insert($option_region_group_uniq_id_5, '동구', null);
    egb_option_insert($option_region_group_uniq_id_5, '미추홀구', null);
    egb_option_insert($option_region_group_uniq_id_5, '부평구', null);
    egb_option_insert($option_region_group_uniq_id_5, '서구', null);
    egb_option_insert($option_region_group_uniq_id_5, '연수구', null);
    egb_option_insert($option_region_group_uniq_id_5, '옹진군', null);
    egb_option_insert($option_region_group_uniq_id_5, '중구', null);

$option_region_group_uniq_id_6 = egb_option_group_insert('egb_region_gwangju', '광주광역시');
    egb_option_insert($option_region_group_uniq_id_6, '광산구', null);
    egb_option_insert($option_region_group_uniq_id_6, '남구', null);
    egb_option_insert($option_region_group_uniq_id_6, '동구', null);
    egb_option_insert($option_region_group_uniq_id_6, '북구', null);
    egb_option_insert($option_region_group_uniq_id_6, '서구', null);

$option_region_group_uniq_id_7 = egb_option_group_insert('egb_region_daejeon', '대전광역시');
    egb_option_insert($option_region_group_uniq_id_7, '대덕구', null);
    egb_option_insert($option_region_group_uniq_id_7, '동구', null);
    egb_option_insert($option_region_group_uniq_id_7, '서구', null);
    egb_option_insert($option_region_group_uniq_id_7, '유성구', null);
    egb_option_insert($option_region_group_uniq_id_7, '중구', null);

$option_region_group_uniq_id_8 = egb_option_group_insert('egb_region_ulsan', '울산광역시');
    egb_option_insert($option_region_group_uniq_id_8, '남구', null);
    egb_option_insert($option_region_group_uniq_id_8, '동구', null);
    egb_option_insert($option_region_group_uniq_id_8, '북구', null);
    egb_option_insert($option_region_group_uniq_id_8, '울주군', null);
    egb_option_insert($option_region_group_uniq_id_8, '중구', null);

$option_region_group_uniq_id_9 = egb_option_group_insert('egb_region_sejong', '세종특별자치시');
    egb_option_insert($option_region_group_uniq_id_9, '세종시', null);

$option_region_group_uniq_id_10 = egb_option_group_insert('egb_region_gyeonggi', '경기도');
    egb_option_insert($option_region_group_uniq_id_10, '가평군', null);
    egb_option_insert($option_region_group_uniq_id_10, '고양시', null);
    egb_option_insert($option_region_group_uniq_id_10, '과천시', null);
    egb_option_insert($option_region_group_uniq_id_10, '광명시', null);
    egb_option_insert($option_region_group_uniq_id_10, '광주시', null);
    egb_option_insert($option_region_group_uniq_id_10, '구리시', null);
    egb_option_insert($option_region_group_uniq_id_10, '군포시', null);
    egb_option_insert($option_region_group_uniq_id_10, '김포시', null);
    egb_option_insert($option_region_group_uniq_id_10, '남양주시', null);
    egb_option_insert($option_region_group_uniq_id_10, '동두천시', null);
    egb_option_insert($option_region_group_uniq_id_10, '부천시', null);
    egb_option_insert($option_region_group_uniq_id_10, '성남시', null);
    egb_option_insert($option_region_group_uniq_id_10, '수원시', null);
    egb_option_insert($option_region_group_uniq_id_10, '시흥시', null);
    egb_option_insert($option_region_group_uniq_id_10, '안산시', null);
    egb_option_insert($option_region_group_uniq_id_10, '안성시', null);
    egb_option_insert($option_region_group_uniq_id_10, '안양시', null);
    egb_option_insert($option_region_group_uniq_id_10, '양주시', null);
    egb_option_insert($option_region_group_uniq_id_10, '양평군', null);
    egb_option_insert($option_region_group_uniq_id_10, '여주시', null);
    egb_option_insert($option_region_group_uniq_id_10, '연천군', null);
    egb_option_insert($option_region_group_uniq_id_10, '오산시', null);
    egb_option_insert($option_region_group_uniq_id_10, '용인시', null);
    egb_option_insert($option_region_group_uniq_id_10, '의왕시', null);
    egb_option_insert($option_region_group_uniq_id_10, '의정부시', null);
    egb_option_insert($option_region_group_uniq_id_10, '이천시', null);
    egb_option_insert($option_region_group_uniq_id_10, '파주시', null);
    egb_option_insert($option_region_group_uniq_id_10, '평택시', null);
    egb_option_insert($option_region_group_uniq_id_10, '포천시', null);
    egb_option_insert($option_region_group_uniq_id_10, '하남시', null);
    egb_option_insert($option_region_group_uniq_id_10, '화성시', null);

$option_region_group_uniq_id_11 = egb_option_group_insert('egb_region_gangwon', '강원특별자치도');
    egb_option_insert($option_region_group_uniq_id_11, '강릉시', null);
    egb_option_insert($option_region_group_uniq_id_11, '고성군', null);
    egb_option_insert($option_region_group_uniq_id_11, '동해시', null);
    egb_option_insert($option_region_group_uniq_id_11, '삼척시', null);
    egb_option_insert($option_region_group_uniq_id_11, '속초시', null);
    egb_option_insert($option_region_group_uniq_id_11, '양구군', null);
    egb_option_insert($option_region_group_uniq_id_11, '양양군', null);
    egb_option_insert($option_region_group_uniq_id_11, '영월군', null);
    egb_option_insert($option_region_group_uniq_id_11, '원주시', null);
    egb_option_insert($option_region_group_uniq_id_11, '인제군', null);
    egb_option_insert($option_region_group_uniq_id_11, '정선군', null);
    egb_option_insert($option_region_group_uniq_id_11, '철원군', null);
    egb_option_insert($option_region_group_uniq_id_11, '춘천시', null);
    egb_option_insert($option_region_group_uniq_id_11, '태백시', null);
    egb_option_insert($option_region_group_uniq_id_11, '평창군', null);
    egb_option_insert($option_region_group_uniq_id_11, '홍천군', null);
    egb_option_insert($option_region_group_uniq_id_11, '화천군', null);
    egb_option_insert($option_region_group_uniq_id_11, '횡성군', null);

$option_region_group_uniq_id_12 = egb_option_group_insert('egb_region_chungbuk', '충청북도');
    egb_option_insert($option_region_group_uniq_id_12, '괴산군', null);
    egb_option_insert($option_region_group_uniq_id_12, '단양군', null);
    egb_option_insert($option_region_group_uniq_id_12, '보은군', null);
    egb_option_insert($option_region_group_uniq_id_12, '영동군', null);
    egb_option_insert($option_region_group_uniq_id_12, '옥천군', null);
    egb_option_insert($option_region_group_uniq_id_12, '음성군', null);
    egb_option_insert($option_region_group_uniq_id_12, '제천시', null);
    egb_option_insert($option_region_group_uniq_id_12, '증평군', null);
    egb_option_insert($option_region_group_uniq_id_12, '진천군', null);
    egb_option_insert($option_region_group_uniq_id_12, '청주시', null);
    egb_option_insert($option_region_group_uniq_id_12, '충주시', null);

$option_region_group_uniq_id_13 = egb_option_group_insert('egb_region_chungnam', '충청남도');
    egb_option_insert($option_region_group_uniq_id_13, '계룡시', null);
    egb_option_insert($option_region_group_uniq_id_13, '공주시', null);
    egb_option_insert($option_region_group_uniq_id_13, '금산군', null);
    egb_option_insert($option_region_group_uniq_id_13, '논산시', null);
    egb_option_insert($option_region_group_uniq_id_13, '당진시', null);
    egb_option_insert($option_region_group_uniq_id_13, '보령시', null);
    egb_option_insert($option_region_group_uniq_id_13, '부여군', null);
    egb_option_insert($option_region_group_uniq_id_13, '서산시', null);
    egb_option_insert($option_region_group_uniq_id_13, '서천군', null);
    egb_option_insert($option_region_group_uniq_id_13, '아산시', null);
    egb_option_insert($option_region_group_uniq_id_13, '예산군', null);
    egb_option_insert($option_region_group_uniq_id_13, '천안시', null);
    egb_option_insert($option_region_group_uniq_id_13, '청양군', null);
    egb_option_insert($option_region_group_uniq_id_13, '태안군', null);
    egb_option_insert($option_region_group_uniq_id_13, '홍성군', null);

$option_region_group_uniq_id_14 = egb_option_group_insert('egb_region_jeonbuk', '전북특별자치도');
    egb_option_insert($option_region_group_uniq_id_14, '고창군', null);
    egb_option_insert($option_region_group_uniq_id_14, '군산시', null);
    egb_option_insert($option_region_group_uniq_id_14, '김제시', null);
    egb_option_insert($option_region_group_uniq_id_14, '남원시', null);
    egb_option_insert($option_region_group_uniq_id_14, '무주군', null);
    egb_option_insert($option_region_group_uniq_id_14, '부안군', null);
    egb_option_insert($option_region_group_uniq_id_14, '순창군', null);
    egb_option_insert($option_region_group_uniq_id_14, '완주군', null);
    egb_option_insert($option_region_group_uniq_id_14, '익산시', null);
    egb_option_insert($option_region_group_uniq_id_14, '임실군', null);
    egb_option_insert($option_region_group_uniq_id_14, '장수군', null);
    egb_option_insert($option_region_group_uniq_id_14, '전주시', null);
    egb_option_insert($option_region_group_uniq_id_14, '정읍시', null);
    egb_option_insert($option_region_group_uniq_id_14, '진안군', null);

$option_region_group_uniq_id_15 = egb_option_group_insert('egb_region_jeonnam', '전라남도');
    egb_option_insert($option_region_group_uniq_id_15, '강진군', null);
    egb_option_insert($option_region_group_uniq_id_15, '고흥군', null);
    egb_option_insert($option_region_group_uniq_id_15, '곡성군', null);
    egb_option_insert($option_region_group_uniq_id_15, '광양시', null);
    egb_option_insert($option_region_group_uniq_id_15, '구례군', null);
    egb_option_insert($option_region_group_uniq_id_15, '나주시', null);
    egb_option_insert($option_region_group_uniq_id_15, '담양군', null);
    egb_option_insert($option_region_group_uniq_id_15, '목포시', null);
    egb_option_insert($option_region_group_uniq_id_15, '무안군', null);
    egb_option_insert($option_region_group_uniq_id_15, '보성군', null);
    egb_option_insert($option_region_group_uniq_id_15, '순천시', null);
    egb_option_insert($option_region_group_uniq_id_15, '신안군', null);
    egb_option_insert($option_region_group_uniq_id_15, '여수시', null);
    egb_option_insert($option_region_group_uniq_id_15, '영광군', null);
    egb_option_insert($option_region_group_uniq_id_15, '영암군', null);
    egb_option_insert($option_region_group_uniq_id_15, '완도군', null);
    egb_option_insert($option_region_group_uniq_id_15, '장성군', null);
    egb_option_insert($option_region_group_uniq_id_15, '장흥군', null);
    egb_option_insert($option_region_group_uniq_id_15, '진도군', null);
    egb_option_insert($option_region_group_uniq_id_15, '함평군', null);
    egb_option_insert($option_region_group_uniq_id_15, '해남군', null);
    egb_option_insert($option_region_group_uniq_id_15, '화순군', null);

$option_region_group_uniq_id_16 = egb_option_group_insert('egb_region_gyeongbuk', '경상북도');
    egb_option_insert($option_region_group_uniq_id_16, '경산시', null);
    egb_option_insert($option_region_group_uniq_id_16, '경주시', null);
    egb_option_insert($option_region_group_uniq_id_16, '고령군', null);
    egb_option_insert($option_region_group_uniq_id_16, '구미시', null);
    egb_option_insert($option_region_group_uniq_id_16, '군위군', null);
    egb_option_insert($option_region_group_uniq_id_16, '김천시', null);
    egb_option_insert($option_region_group_uniq_id_16, '문경시', null);
    egb_option_insert($option_region_group_uniq_id_16, '봉화군', null);
    egb_option_insert($option_region_group_uniq_id_16, '상주시', null);
    egb_option_insert($option_region_group_uniq_id_16, '성주군', null);
    egb_option_insert($option_region_group_uniq_id_16, '안동시', null);
    egb_option_insert($option_region_group_uniq_id_16, '영덕군', null);
    egb_option_insert($option_region_group_uniq_id_16, '영양군', null);
    egb_option_insert($option_region_group_uniq_id_16, '영주시', null);
    egb_option_insert($option_region_group_uniq_id_16, '영천시', null);
    egb_option_insert($option_region_group_uniq_id_16, '예천군', null);
    egb_option_insert($option_region_group_uniq_id_16, '울릉군', null);
    egb_option_insert($option_region_group_uniq_id_16, '울진군', null);
    egb_option_insert($option_region_group_uniq_id_16, '의성군', null);
    egb_option_insert($option_region_group_uniq_id_16, '청도군', null);
    egb_option_insert($option_region_group_uniq_id_16, '청송군', null);
    egb_option_insert($option_region_group_uniq_id_16, '칠곡군', null);
    egb_option_insert($option_region_group_uniq_id_16, '포항시', null);

$option_region_group_uniq_id_17 = egb_option_group_insert('egb_region_gyeongnam', '경상남도');
    egb_option_insert($option_region_group_uniq_id_17, '거제시', null);
    egb_option_insert($option_region_group_uniq_id_17, '거창군', null);
    egb_option_insert($option_region_group_uniq_id_17, '고성군', null);
    egb_option_insert($option_region_group_uniq_id_17, '김해시', null);
    egb_option_insert($option_region_group_uniq_id_17, '남해군', null);
    egb_option_insert($option_region_group_uniq_id_17, '밀양시', null);
    egb_option_insert($option_region_group_uniq_id_17, '사천시', null);
    egb_option_insert($option_region_group_uniq_id_17, '산청군', null);
    egb_option_insert($option_region_group_uniq_id_17, '양산시', null);
    egb_option_insert($option_region_group_uniq_id_17, '의령군', null);
    egb_option_insert($option_region_group_uniq_id_17, '진주시', null);
    egb_option_insert($option_region_group_uniq_id_17, '창녕군', null);
    egb_option_insert($option_region_group_uniq_id_17, '창원시', null);
    egb_option_insert($option_region_group_uniq_id_17, '통영시', null);
    egb_option_insert($option_region_group_uniq_id_17, '하동군', null);
    egb_option_insert($option_region_group_uniq_id_17, '함안군', null);
    egb_option_insert($option_region_group_uniq_id_17, '함양군', null);
    egb_option_insert($option_region_group_uniq_id_17, '합천군', null);

$option_region_group_uniq_id_18 = egb_option_group_insert('egb_region_jeju', '제주특별자치도');
    egb_option_insert($option_region_group_uniq_id_18, '서귀포시', null);
    egb_option_insert($option_region_group_uniq_id_18, '제주시', null);

$option_region_group_uniq_id_19 = egb_option_group_insert('egb_region_board_filter', '게시판 지역 필터');
    egb_option_insert($option_region_group_uniq_id_19, '전체', null);
    egb_option_insert($option_region_group_uniq_id_19, '경기', null);
    egb_option_insert($option_region_group_uniq_id_19, '서울', null);
    egb_option_insert($option_region_group_uniq_id_19, '인천', null);
    egb_option_insert($option_region_group_uniq_id_19, '강원', null);
    egb_option_insert($option_region_group_uniq_id_19, '충남', null);
    egb_option_insert($option_region_group_uniq_id_19, '충북', null);
    egb_option_insert($option_region_group_uniq_id_19, '대전', null);
    egb_option_insert($option_region_group_uniq_id_19, '경북', null);
    egb_option_insert($option_region_group_uniq_id_19, '경남', null);
    egb_option_insert($option_region_group_uniq_id_19, '대구', null);
    egb_option_insert($option_region_group_uniq_id_19, '부산', null);
    egb_option_insert($option_region_group_uniq_id_19, '울산', null);
    egb_option_insert($option_region_group_uniq_id_19, '전북', null);
    egb_option_insert($option_region_group_uniq_id_19, '전남', null);
    egb_option_insert($option_region_group_uniq_id_19, '광주', null);
    egb_option_insert($option_region_group_uniq_id_19, '세종', null);
    egb_option_insert($option_region_group_uniq_id_19, '제주', null);
    egb_option_insert($option_region_group_uniq_id_19, '해외', null);




egb_db_input_page_insert('오토 회원가입 인풋', 'signup_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'signup_input.php');
egb_db_input_page_insert('로그인 인풋', 'login_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'login_input.php');
egb_db_input_page_insert('로그아웃 인풋', 'logout_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'logout_input.php');
egb_db_input_page_insert('등급 승인 설정 인풋', 'egb_grade_approval_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'egb_grade_approval_form_input.php');
egb_db_input_page_insert('그룹 옵션 설정 업데이트 인풋', 'egb_group_option_setting_update_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'egb_group_option_setting_update_form_input.php');
egb_db_input_page_insert('회원등급 노출이름 변경 인풋', 'egb_grade_name_edit_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'egb_grade_name_edit_form_input.php');
egb_db_input_page_insert('리워드 항목 설정 인풋', 'egb_crm_reward_edit_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'egb_crm_reward_edit_input.php');

egb_db_input_page_insert('인스타그램 게시글 인풋', 'instagram_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'instagram_form_input.php');
egb_db_input_page_insert('댓글 인풋', 'comment_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'comment_form_input.php');
egb_db_input_page_insert('댓글 대댓글 보기 인풋', 'auto_comment_view_replies_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'auto_comment_view_replies_form_input.php');
egb_db_input_page_insert('댓글 스크롤 업데이트 인풋', 'auto_comment_scroll_update_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'auto_comment_scroll_update_form_input.php');

egb_db_input_page_insert('좋아요 인풋', 'side_heart_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'side_heart_input.php');
egb_db_input_page_insert('스크랩 인풋', 'side_scrap_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'side_scrap_input.php');
egb_db_input_page_insert('공유 인풋', 'side_share_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'side_share_input.php');

egb_db_input_page_insert('블로그 게시글 인풋', 'blog_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'blog_form_input.php');
egb_db_input_page_insert('유튜브 게시글 인풋', 'youtube_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'youtube_form_input.php');
egb_db_input_page_insert('숏츠 게시글 인풋', 'shorts_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'shorts_form_input.php');
egb_db_input_page_insert('매뉴얼 게시글 인풋', 'manual_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'manual_form_input.php');

egb_db_input_page_insert('멘토링 비공개 1:1 상담 인풋', 'mentoring_private_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'mentoring_private_form_input.php');
egb_db_input_page_insert('멘토링 공개 게시글 인풋', 'mentoring_release_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'mentoring_release_form_input.php');

egb_db_input_page_insert('지역별 스터디 인풋', 'region_regional_studies_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'region_regional_studies_form_input.php');

egb_db_input_page_insert('예약 폼 인풋 페이지', 'reservation_form_input', DS . 'egb_themes' . DS  . 'eungabi' . DS . 'input' . DS . 'reservation_form_input.php');

egb_db_input_page_insert('예약 상세 정보 인풋', 'reservation_details_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_details_form_input.php');
egb_db_input_page_insert('예약 확정 인풋', 'reservation_confirm_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_confirm_form_input.php');
egb_db_input_page_insert('예약 변경 날짜 인풋', 'reservation_change_date_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_change_date_form_input.php');
egb_db_input_page_insert('예약 취소 인풋', 'reservation_cancel_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_cancel_form_input.php');
egb_db_input_page_insert('예약 노쇼 인풋', 'reservation_noshow_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_noshow_form_input.php');
egb_db_input_page_insert('예약 변경 인풋', 'reservation_change_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_change_form_input.php');
egb_db_input_page_insert('예약 완료 인풋', 'reservation_complete_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_complete_form_input.php');
egb_db_input_page_insert('예약 검색 인풋', 'reservation_search_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_search_form_input.php');
egb_db_input_page_insert('예약 현황 업데이트 인풋', 'reservation_scroll_update_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_scroll_update_form_input.php');
egb_db_input_page_insert('예약 엑셀 다운로드 인풋', 'reservation_excel_download_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'reservation_excel_download_form_input.php');

egb_db_input_page_insert('리워드 적립금 소멸 인풋', 'reward_point_check', DS .'egb_themes' . DS . 'eungabi' . DS . 'cron' . DS . 'reward_point_check.php');

egb_db_input_page_insert('알림 실시간 처리 인풋', 'auto_get_alarm_list_form_input', DS .'egb_themes' . DS . 'eungabi' . DS . 'input' . DS . 'auto_get_alarm_list_form_input.php');

//메뉴 그룹 추가
$egb_menu_group_uniq_id = egb_menu_group_insert('egb_menu', 'egb 메뉴');



$menu_group_uniq_id_1 = egb_menu_group_insert('crm_main_menu', 'CRM 메인 메뉴', $egb_menu_group_uniq_id);

    $menu_group_uniq_id_2 = egb_menu_group_insert('crm_member_check', '회원조회', $menu_group_uniq_id_1);
        $menu_uniq_id_1 = egb_menu_insert($menu_group_uniq_id_2, '회원정보조회', '/page/crm_member_check_1');
        $menu_uniq_id_2 = egb_menu_insert($menu_group_uniq_id_2, '주문현황조회', '/page/crm_member_check_2');
        $menu_uniq_id_3 = egb_menu_insert($menu_group_uniq_id_2, '예약현황조회', '/page/crm_member_check_3');
        $menu_uniq_id_4 = egb_menu_insert($menu_group_uniq_id_2, '상위매출회원조회', '/page/crm_member_check_4');
        $menu_uniq_id_5 = egb_menu_insert($menu_group_uniq_id_2, '멘토회원관리', '/page/crm_member_check_5');

    $menu_group_uniq_id_3 = egb_menu_group_insert('crm_member_management', '회원관리', $menu_group_uniq_id_1);
        $menu_group_uniq_id_4 = egb_menu_group_insert('crm_member_register', '회원등록', $menu_group_uniq_id_3);
            $menu_uniq_id_6 = egb_menu_insert($menu_group_uniq_id_4, '회원가입설정', '/page/crm_member_management_1');
            $menu_uniq_id_7 = egb_menu_insert($menu_group_uniq_id_4, '회원가입항목', '/page/crm_member_management_2');
            $menu_uniq_id_8 = egb_menu_insert($menu_group_uniq_id_4, '엑셀일괄등록', '/page/crm_member_management_3');

        $menu_group_uniq_id_5 = egb_menu_group_insert('crm_member_sleep', '휴면회원', $menu_group_uniq_id_3);
            $menu_uniq_id_9 = egb_menu_insert($menu_group_uniq_id_5, '휴면회원정책', '/page/crm_member_management_4');
            $menu_uniq_id_10 = egb_menu_insert($menu_group_uniq_id_5, '휴면회원관리', '/page/crm_member_management_5'); 

        $menu_group_uniq_id_6 = egb_menu_group_insert('crm_member_withdraw', '탈퇴회원', $menu_group_uniq_id_3);
            $menu_uniq_id_11 = egb_menu_insert($menu_group_uniq_id_6, '탈퇴회원관리', '/page/crm_member_management_6');

        $menu_group_uniq_id_7 = egb_menu_group_insert('crm_member_connection', '접속관리', $menu_group_uniq_id_3);
            $menu_uniq_id_12 = egb_menu_insert($menu_group_uniq_id_7, '회원로그인기록', '/page/crm_member_management_7');
            $menu_uniq_id_13 = egb_menu_insert($menu_group_uniq_id_7, '부정의심로그인관리', '/page/crm_member_management_8');

    $menu_group_uniq_id_8 = egb_menu_group_insert('crm_member_level', '등급관리', $menu_group_uniq_id_1);
        $menu_group_uniq_id_9 = egb_menu_group_insert('crm_member_shopping_mall_level', '쇼핑몰', $menu_group_uniq_id_8);
            $menu_uniq_id_14 = egb_menu_insert($menu_group_uniq_id_9, '등급관리', '/page/crm_member_level_1');
            $menu_uniq_id_15 = egb_menu_insert($menu_group_uniq_id_9, '등급평가설정', '/page/crm_member_level_2');
            $menu_uniq_id_16 = egb_menu_insert($menu_group_uniq_id_9, '등급별회원관리', '/page/crm_member_level_3');

        $menu_group_uniq_id_10 = egb_menu_group_insert('crm_member_community_level', '커뮤니티', $menu_group_uniq_id_8);
            $menu_uniq_id_17 = egb_menu_insert($menu_group_uniq_id_10, '등급관리', '/page/crm_member_level_4');
            $menu_uniq_id_18 = egb_menu_insert($menu_group_uniq_id_10, '등급별결제관리', '/page/crm_member_level_5');
            $menu_uniq_id_19 = egb_menu_insert($menu_group_uniq_id_10, '등급별회원관리', '/page/crm_member_level_6');

    $menu_group_uniq_id_11 = egb_menu_group_insert('crm_member_event', '이벤트', $menu_group_uniq_id_1);
        $menu_uniq_id_20 = egb_menu_insert($menu_group_uniq_id_11, '회원정보 이벤트', '/page/crm_member_event_1');
        $menu_uniq_id_21 = egb_menu_insert($menu_group_uniq_id_11, '회원가입 이벤트', '/page/crm_member_event_2');
        $menu_uniq_id_22 = egb_menu_insert($menu_group_uniq_id_11, '구독료할인 이벤트', '/page/crm_member_event_3');

    $menu_group_uniq_id_12 = egb_menu_group_insert('crm_member_reward', '리워드', $menu_group_uniq_id_1);
        $menu_group_uniq_id_13 = egb_menu_group_insert('crm_member_deposit', '예치금', $menu_group_uniq_id_12);
            $menu_uniq_id_23 = egb_menu_insert($menu_group_uniq_id_13, '예치금관리', '/page/crm_member_reward_1');
        $menu_group_uniq_id_14 = egb_menu_group_insert('crm_member_point', '적립금', $menu_group_uniq_id_12);
            $menu_uniq_id_24 = egb_menu_insert($menu_group_uniq_id_14, '적립금관리', '/page/crm_member_reward_2');
            $menu_uniq_id_25 = egb_menu_insert($menu_group_uniq_id_14, '적립금소멸', '/page/crm_member_reward_3');
        $menu_group_uniq_id_15 = egb_menu_group_insert('crm_member_mentee_mileage', '멘티마일리지', $menu_group_uniq_id_12);
            $menu_uniq_id_26 = egb_menu_insert($menu_group_uniq_id_15, '멘티마일리지관리', '/page/crm_member_reward_4');
            $menu_uniq_id_27 = egb_menu_insert($menu_group_uniq_id_15, '멘티마일리지소멸', '/page/crm_member_reward_5');
        $menu_group_uniq_id_16 = egb_menu_group_insert('crm_member_reward_setting', '리워드 항목 설정', $menu_group_uniq_id_12);
            $menu_uniq_id_28 = egb_menu_insert($menu_group_uniq_id_16, '리워드 항목 설정', '/page/crm_member_reward_6');

    $menu_group_uniq_id_17 = egb_menu_group_insert('crm_member_reservation', '예약설정', $menu_group_uniq_id_1);
        $menu_uniq_id_29 = egb_menu_insert($menu_group_uniq_id_17, '1호기 예약설정', '/page/crm_member_reservation_1');
        $menu_uniq_id_30 = egb_menu_insert($menu_group_uniq_id_17, '2호기 예약설정', '/page/crm_member_reservation_1_2');
        $menu_uniq_id_31 = egb_menu_insert($menu_group_uniq_id_17, '예약현황확인', '/page/crm_member_reservation_2');




$menu_group_uniq_id_18 = egb_menu_group_insert('home_main_menu', '홈페이지 메인 메뉴', $egb_menu_group_uniq_id);
    $menu_group_uniq_id_19 = egb_menu_group_insert('community_main_menu', '커뮤니티', $menu_group_uniq_id_18);
        $menu_group_uniq_id_20 = egb_menu_group_insert('community_home', '홈', $menu_group_uniq_id_19);
            $menu_uniq_id_33 = egb_menu_insert($menu_group_uniq_id_20, '홈', '/');

        $menu_group_uniq_id_21 = egb_menu_group_insert('community_self_repair_content', '셀프정비 콘텐츠', $menu_group_uniq_id_19);
            $menu_uniq_id_34 = egb_menu_insert($menu_group_uniq_id_21, '인스타', '/page/instagram_board_list');
            $menu_uniq_id_35 = egb_menu_insert($menu_group_uniq_id_21, '블로그', '/page/blog_board_list');
            $menu_uniq_id_36 = egb_menu_insert($menu_group_uniq_id_21, '유튜브', '/page/youtube_board_list');
            $menu_uniq_id_37 = egb_menu_insert($menu_group_uniq_id_21, '숏츠', '/page/shorts_board_list');
            $menu_uniq_id_38 = egb_menu_insert($menu_group_uniq_id_21, '정비매뉴얼', '/page/manual_board_list');

            /*
        $menu_group_uniq_id_22 = egb_menu_group_insert('community_self_repair', '내 셀프 정비', $menu_group_uniq_id_19);
            $menu_uniq_id_39 = egb_menu_insert($menu_group_uniq_id_22, '구매내역', '/');
            $menu_uniq_id_40 = egb_menu_insert($menu_group_uniq_id_22, '활동내역', '/');
            $menu_uniq_id_41 = egb_menu_insert($menu_group_uniq_id_22, '리워드', '/');
            $menu_uniq_id_42 = egb_menu_insert($menu_group_uniq_id_22, '멘토링', '/');
            */
            /*
        $menu_group_uniq_id_23 = egb_menu_group_insert('community_self_repair_shop', '내 가맹점', $menu_group_uniq_id_19);
            $menu_uniq_id_43 = egb_menu_insert($menu_group_uniq_id_23, '지역별(시,군구)', '/');
            $menu_uniq_id_44 = egb_menu_insert($menu_group_uniq_id_23, '규모별(크기,인원)', '/');

            */
        $menu_group_uniq_id_24 = egb_menu_group_insert('community_qna', 'Q&A', $menu_group_uniq_id_19);
            $menu_uniq_id_45 = egb_menu_insert($menu_group_uniq_id_24, 'Q&A', '/page/qna');

        $menu_group_uniq_id_25 = egb_menu_group_insert('community_local_meeting', '지역모임', $menu_group_uniq_id_19);
            $menu_uniq_id_46 = egb_menu_insert($menu_group_uniq_id_25, '지역별 스터디', '/page/region_regional_studies_list');
            $menu_uniq_id_47 = egb_menu_insert($menu_group_uniq_id_25, '정기모임', '/page/region_regular_meeting_list');
            $menu_uniq_id_48 = egb_menu_insert($menu_group_uniq_id_25, '정비/튜닝 모임', '/page/region_maintenance_meeting_list');

        $menu_group_uniq_id_26 = egb_menu_group_insert('community_club', '동호회', $menu_group_uniq_id_19);
            $menu_uniq_id_49 = egb_menu_insert($menu_group_uniq_id_26, '지역별 스터디', '/page/club_regional_studies_list');
            $menu_uniq_id_50 = egb_menu_insert($menu_group_uniq_id_26, '정기모임', '/page/club_regular_meeting_list');
            $menu_uniq_id_51 = egb_menu_insert($menu_group_uniq_id_26, '정비/튜닝 모임', '/page/club_maintenance_meeting_list');

            /*
        $menu_group_uniq_id_27 = egb_menu_group_insert('community_foreign_car', '외제차', $menu_group_uniq_id_19);
            $menu_uniq_id_52 = egb_menu_insert($menu_group_uniq_id_27, '검색', '/');
            $menu_uniq_id_53 = egb_menu_insert($menu_group_uniq_id_27, '튜닝: 정보,부품', '/');
            $menu_uniq_id_54 = egb_menu_insert($menu_group_uniq_id_27, '정비: 정보,정비소 추천', '/');
            $menu_uniq_id_55 = egb_menu_insert($menu_group_uniq_id_27, '보험: 보험료 비교', '/');
            $menu_uniq_id_56 = egb_menu_insert($menu_group_uniq_id_27, '중고차: 시세, 매물정보', '/');
            */

        $menu_group_uniq_id_28 = egb_menu_group_insert('community_mentoring', '멘토링', $menu_group_uniq_id_19);
            $menu_uniq_id_57 = egb_menu_insert($menu_group_uniq_id_28, '멘토LIST', '/page/mentoring_mentor_list');
            $menu_uniq_id_58 = egb_menu_insert($menu_group_uniq_id_28, '공개상담', '/page/mentoring_release_list');
            $menu_uniq_id_59 = egb_menu_insert($menu_group_uniq_id_28, '비공개 1:1 상담', '/page/mentoring_private_list');

    $menu_group_uniq_id_29 = egb_menu_group_insert('self_repair_shop_main_menu', '셀프정비소', $menu_group_uniq_id_18);
        $menu_uniq_id_60 = egb_menu_insert($menu_group_uniq_id_29, '홈', '/');
        $menu_uniq_id_61 = egb_menu_insert($menu_group_uniq_id_29, '예약', '/page/reservation_store');
        $menu_uniq_id_62 = egb_menu_insert($menu_group_uniq_id_29, '네이버예약', '/');
        $menu_uniq_id_63 = egb_menu_insert($menu_group_uniq_id_29, '카카오예약', '/');

    $menu_group_uniq_id_30 = egb_menu_group_insert('shopping_main_menu', '쇼핑', $menu_group_uniq_id_18);
        $menu_uniq_id_64 = egb_menu_insert($menu_group_uniq_id_30, '홈', '/');
        $menu_uniq_id_65 = egb_menu_insert($menu_group_uniq_id_30, '쇼핑', '/');

    $menu_group_uniq_id_31 = egb_menu_group_insert('crm_admin', 'CRM', $menu_group_uniq_id_18);
        $menu_uniq_id_66 = egb_menu_insert($menu_group_uniq_id_31, '홈', '/');
        $menu_uniq_id_67 = egb_menu_insert($menu_group_uniq_id_31, '회원조회', '/page/crm_member_check_1');
        $menu_uniq_id_68 = egb_menu_insert($menu_group_uniq_id_31, '회원관리', '/page/crm_member_management_1');
        $menu_uniq_id_69 = egb_menu_insert($menu_group_uniq_id_31, '등급관리', '/page/crm_member_level_1');
        $menu_uniq_id_70 = egb_menu_insert($menu_group_uniq_id_31, '이벤트', '/page/crm_member_event_1');
        $menu_uniq_id_71 = egb_menu_insert($menu_group_uniq_id_31, '리워드', '/page/crm_member_reward_1');
        $menu_uniq_id_72 = egb_menu_insert($menu_group_uniq_id_31, '예약설정', '/page/crm_member_reservation_1');
$menu_group_uniq_id_32 = egb_menu_group_insert('mypage_main_menu', '마이페이지 메인 메뉴', $egb_menu_group_uniq_id);
    $menu_uniq_id_73 = egb_menu_insert($menu_group_uniq_id_32, '프로필', '/page/mypage_profile');
    $menu_uniq_id_74 = egb_menu_insert($menu_group_uniq_id_32, '나의 예약', '/page/mypage_reservation_details');
    $menu_uniq_id_75 = egb_menu_insert($menu_group_uniq_id_32, '나의 멘토링', '/page/mypage_mentoring');
    $menu_uniq_id_76 = egb_menu_insert($menu_group_uniq_id_32, '나의 리워드', '/page/mypage_reward');
    $menu_uniq_id_77 = egb_menu_insert($menu_group_uniq_id_32, '나의 모임', '/page/mypage_local_meeting');
    $menu_uniq_id_78 = egb_menu_insert($menu_group_uniq_id_32, '설정', '/page/mypage_setting_user_info_edit');

    $menu_group_uniq_id_33 = egb_menu_group_insert('mypage_profile_menu', '프로필', $menu_group_uniq_id_32);
        $menu_uniq_id_79 = egb_menu_insert($menu_group_uniq_id_33, '홈', '/page/mypage_profile');
        $menu_uniq_id_80 = egb_menu_insert($menu_group_uniq_id_33, '나의 게시글', '/page/mypage_board');
        $menu_uniq_id_81 = egb_menu_insert($menu_group_uniq_id_33, '스크랩 게시글', '/page/mypage_saved');
        $menu_uniq_id_82 = egb_menu_insert($menu_group_uniq_id_33, '좋아요 게시글', '/page/mypage_liked');
        $menu_uniq_id_83 = egb_menu_insert($menu_group_uniq_id_33, '나의 댓글', '/page/mypage_comments');

    $menu_group_uniq_id_34 = egb_menu_group_insert('mypage_reservation_details_menu', '나의 예약', $menu_group_uniq_id_32);
        $menu_uniq_id_84 = egb_menu_insert($menu_group_uniq_id_34, '예약 상세 내역', '/page/mypage_reservation_details');
        
    $menu_group_uniq_id_35 = egb_menu_group_insert('mypage_mentoring_menu', '나의 멘토링', $menu_group_uniq_id_32);
        $menu_uniq_id_85 = egb_menu_insert($menu_group_uniq_id_35, '나의 멘토', '/page/mypage_mentor');
        $menu_uniq_id_86 = egb_menu_insert($menu_group_uniq_id_35, '나의 멘티', '/page/mypage_mentee');
        
    $menu_group_uniq_id_36 = egb_menu_group_insert('mypage_reward_menu', '나의 리워드', $menu_group_uniq_id_32);
        $menu_uniq_id_87 = egb_menu_insert($menu_group_uniq_id_36, '홈', '/page/mypage_reward');
        $menu_uniq_id_88 = egb_menu_insert($menu_group_uniq_id_36, '나의 예치금', '/page/mypage_deposit');
        $menu_uniq_id_89 = egb_menu_insert($menu_group_uniq_id_36, '나의 적립금', '/page/mypage_points');
        $menu_uniq_id_90 = egb_menu_insert($menu_group_uniq_id_36, '나의 멘티 마일리지', '/page/mypage_mileage');

    $menu_group_uniq_id_37 = egb_menu_group_insert('mypage_local_meeting_menu', '나의 모임', $menu_group_uniq_id_32);
        $menu_uniq_id_91 = egb_menu_insert($menu_group_uniq_id_37, '나의 지역모임', '/page/mypage_local_meeting');
        $menu_uniq_id_92 = egb_menu_insert($menu_group_uniq_id_37, '나의 동호회', '/page/mypage_club');
    
    $menu_group_uniq_id_38 = egb_menu_group_insert('mypage_setting_user_info_edit_menu', '설정', $menu_group_uniq_id_32);
        $menu_uniq_id_93 = egb_menu_insert($menu_group_uniq_id_38, '회원정보 수정', '/page/mypage_setting_user_info_edit');
        $menu_uniq_id_94 = egb_menu_insert($menu_group_uniq_id_38, '비밀번호 변경', '/page/mypage_setting_user_password_edit');

        // 쇼핑몰 회원 구분 칼럼 추가
egb_table_column_add('egb_user', 'shopping_mall_user_type', 'VARCHAR(50)', '쇼핑몰 사용자 유형', 'user_address_detail');
// 사업자 구분 칼럼 추가
egb_table_column_add('egb_user', 'shopping_mall_user_type_business', 'VARCHAR(50)', '사업자 구분', 'shopping_mall_user_type');
// 사업자명 칼럼 추가
egb_table_column_add('egb_user', 'user_company_name', 'VARCHAR(255)', '사업자명', 'shopping_mall_user_type_business');
// 사업자명2 칼럼 추가
egb_table_column_add('egb_user', 'user_company_name2', 'VARCHAR(255)', '사업자명2', 'user_company_name');
// 커뮤니티 회원 등급 칼럼 추가
egb_table_column_add('egb_user', 'community_user_grade', 'VARCHAR(50)', '커뮤니티 회원 등급', 'user_company_name2');
// 멘토아이디 칼럼 추가
egb_table_column_add('egb_user', 'user_mentor_id', 'VARCHAR(50)', '멘토아이디', 'community_user_grade');
// 성별 칼럼 추가
egb_table_column_add('egb_user', 'user_gender', 'VARCHAR(50)', '성별', 'user_mentor_id');
// 홈페이지 칼럼 추가
egb_table_column_add('egb_user', 'user_homepage', 'VARCHAR(255)', '홈페이지', 'user_gender');
// 가입목적 칼럼 추가
egb_table_column_add('egb_user', 'user_registration_purpose', 'VARCHAR(255)', '가입목적', 'user_homepage');
// 생일 칼럼 추가
egb_table_column_add('egb_user', 'user_birthday', 'VARCHAR(255)', '생일', 'user_registration_purpose');
// 기념일 칼럼 추가
egb_table_column_add('egb_user', 'user_custom_day', 'VARCHAR(255)', '기념일', 'user_birthday');
// 계좌별칭 칼럼 추가
egb_table_column_add('egb_user', 'user_bank_alias', 'VARCHAR(255)', '계좌별칭', 'user_custom_day');
// 예금주 칼럼 추가
egb_table_column_add('egb_user', 'user_bank_holder', 'VARCHAR(255)', '예금주', 'user_bank_alias');
// 직업 칼럼 추가
egb_table_column_add('egb_user', 'user_job', 'VARCHAR(255)', '직업', 'user_bank_holder');
// 회사명 칼럼 추가
egb_table_column_add('egb_user', 'user_company_name', 'VARCHAR(255)', '회사명', 'user_job');
// 부서 칼럼 추가
egb_table_column_add('egb_user', 'user_department', 'VARCHAR(255)', '부서', 'user_company_name');
// 직책 칼럼 추가
egb_table_column_add('egb_user', 'user_position', 'VARCHAR(255)', '직책', 'user_department');
// 직장전화 칼럼 추가
egb_table_column_add('egb_user', 'user_work_phone', 'VARCHAR(255)', '직장전화', 'user_position');
// 직장팩스 칼럼 추가
egb_table_column_add('egb_user', 'user_work_fax', 'VARCHAR(255)', '직장팩스', 'user_work_phone');
// 직장주소 칼럼 추가
egb_table_column_add('egb_user', 'user_work_address', 'VARCHAR(255)', '직장주소', 'user_work_fax');
// 활동지역 칼럼 추가
egb_table_column_add('egb_user', 'user_activity_area', 'VARCHAR(255)', '활동지역', 'user_work_address');
// 차량cc 칼럼 추가
egb_table_column_add('egb_user', 'user_car_cc', 'VARCHAR(255)', '차량cc', 'user_activity_area');
// 지역 칼럼 추가
egb_table_column_add('egb_user', 'user_region', 'VARCHAR(255)', '지역', 'user_car_cc');
// 쇼핑몰구분 칼럼 추가
egb_table_column_add('egb_user', 'user_shopping_mall_type', 'VARCHAR(255)', '쇼핑몰구분', 'user_region');
// 셀프정비소 방문이력 여부 칼럼 추가
egb_table_column_add('egb_user', 'user_selfcare_history', 'TINYINT(1)', '셀프정비소 방문이력 여부', 'user_shopping_mall_type', '0');
// 관리자 상담이력 여부 칼럼 추가
egb_table_column_add('egb_user', 'user_admin_consulting_history', 'TINYINT(1)', '관리자 상담이력 여부', 'user_selfcare_history', '0');
// 프로필 이미지 칼럼 추가
egb_table_column_add('egb_user', 'user_profile_image', 'VARCHAR(255)', '프로필 이미지', 'user_admin_consulting_history');

//리워드 항목 추가
egb_reward_insert('reward_signup', '회원가입', '회원가입 시 적립금 지급');
egb_reward_insert('reward_community_blog_upload', '커뮤니티-블로그', '커뮤니티-블로그 게시글 업로드시 적립금 지급');
egb_reward_insert('reward_community_instagram_upload', '커뮤니티-인스타그램', '커뮤니티-인스타그램 업로드시 적립금 지급');
egb_reward_insert('reward_community_youtube_long_upload', '커뮤니티-유튜브(롱폼)', '커뮤니티-유튜브(롱폼) 업로드시 적립금 지급');
egb_reward_insert('reward_community_youtube_short_upload', '커뮤니티-유튜브(숏폼)', '커뮤니티-유튜브(숏폼) 업로드시 적립금 지급');
egb_reward_insert('reward_selfcare_manual_upload', '커뮤니티', '설프 정비 매뉴얼 업로드시 적립금 지급');
egb_reward_insert('reward_selfcare_reservation', '셀프정비소', '셀프정비소 예약 시 적립금 지급');
egb_reward_insert('reward_shopping_mall_first_purchase', '쇼핑몰', '쇼핑몰 첫 구매시 적립금 지급');
egb_reward_insert('reward_mentoring_first_connection', '멘토링 첫 연결시', '멘토링 첫 연결시 적립금 지급');

//crm 헤더랑 푸터 처리
egb_page_header_footer_use_update('crm_member_check_1');
egb_page_header_footer_use_update('crm_member_check_2');
egb_page_header_footer_use_update('crm_member_check_3');
egb_page_header_footer_use_update('crm_member_check_4');
egb_page_header_footer_use_update('crm_member_check_5');
egb_page_header_footer_use_update('crm_member_check_5_plus');

egb_page_header_footer_use_update('crm_member_event_1');
egb_page_header_footer_use_update('crm_member_event_2');
egb_page_header_footer_use_update('crm_member_event_3');

egb_page_header_footer_use_update('crm_member_level_1');
egb_page_header_footer_use_update('crm_member_level_2');
egb_page_header_footer_use_update('crm_member_level_3');
egb_page_header_footer_use_update('crm_member_level_4');
egb_page_header_footer_use_update('crm_member_level_5');
egb_page_header_footer_use_update('crm_member_level_6');

egb_page_header_footer_use_update('crm_member_management_1');
egb_page_header_footer_use_update('crm_member_management_2');
egb_page_header_footer_use_update('crm_member_management_3');
egb_page_header_footer_use_update('crm_member_management_4');
egb_page_header_footer_use_update('crm_member_management_5');
egb_page_header_footer_use_update('crm_member_management_6');
egb_page_header_footer_use_update('crm_member_management_7');
egb_page_header_footer_use_update('crm_member_management_8');

egb_page_header_footer_use_update('crm_member_reservation_1');
egb_page_header_footer_use_update('crm_member_reservation_1_2');
egb_page_header_footer_use_update('crm_member_reservation_2');
egb_page_header_footer_use_update('crm_member_reservation_holiday');

egb_page_header_footer_use_update('crm_member_reward_1');
egb_page_header_footer_use_update('crm_member_reward_2');
egb_page_header_footer_use_update('crm_member_reward_3');
egb_page_header_footer_use_update('crm_member_reward_4');
egb_page_header_footer_use_update('crm_member_reward_5');
egb_page_header_footer_use_update('crm_member_reward_6');

egb_page_header_footer_use_update('board_write');

egb_page_header_footer_use_update('login');
egb_page_header_footer_use_update('signup');
egb_page_header_footer_use_update('signup_step2');
egb_page_header_footer_use_update('signup_complete');
egb_page_header_footer_use_update('blog_board_write');
egb_page_header_footer_use_update('manual_write');
egb_page_header_footer_use_update('find_id');
egb_page_header_footer_use_update('find_pw');
egb_page_header_footer_use_update('mentoring_private_write');
egb_page_header_footer_use_update('mentoring_release_write');
egb_page_header_footer_use_update('region_regional_studies_write');
egb_page_header_footer_use_update('region_maintenance_meeting_write');
egb_page_header_footer_use_update('region_regular_meeting_write');
egb_page_header_footer_use_update('club_regional_studies_write');
egb_page_header_footer_use_update('club_maintenance_meeting_write');
egb_page_header_footer_use_update('club_regular_meeting_write');

//게시판 관리 테이블 생성

table_egb_board_management_insert('instagram');
table_egb_board_management_insert('blog');
table_egb_board_management_insert('youtube');
table_egb_board_management_insert('shorts');
table_egb_board_management_insert('manual');
table_egb_board_management_insert('mentoring_private');
table_egb_board_management_insert('mentoring_release');

//지역 게시판 필터 칼럼 추가
table_egb_board_management_insert('region_regional_studies');
egb_table_column_add('egb_board_region_regional_studies', 'board_filter_region', 'VARCHAR(255)', '게시판 필터 - 지역', 'board_contents');
table_egb_board_management_insert('region_maintenance_meeting');
egb_table_column_add('egb_board_region_maintenance_meeting', 'board_filter_region', 'VARCHAR(255)', '게시판 필터 - 지역', 'board_contents');
table_egb_board_management_insert('region_regular_meeting');
egb_table_column_add('egb_board_region_regular_meeting', 'board_filter_region', 'VARCHAR(255)', '게시판 필터 - 지역', 'board_contents');
table_egb_board_management_insert('club_regional_studies');
egb_table_column_add('egb_board_club_regional_studies', 'board_filter_region', 'VARCHAR(255)', '게시판 필터 - 지역', 'board_contents');
table_egb_board_management_insert('club_maintenance_meeting');
egb_table_column_add('egb_board_club_maintenance_meeting', 'board_filter_region', 'VARCHAR(255)', '게시판 필터 - 지역', 'board_contents');
table_egb_board_management_insert('club_regular_meeting');
egb_table_column_add('egb_board_club_regular_meeting', 'board_filter_region', 'VARCHAR(255)', '게시판 필터 - 지역', 'board_contents');




//스토어 테이블 생성
$store_uniq_id_1 = egb_store_insert('안산[산단점] 1호기');
$store_uniq_id_2 = egb_store_insert('안산[산단점] 2호기');



$metadata = [
    'api_key' => 'SsULZg.gSNlVg:obaU7WUU5IKZSJOwyYWjbE1uf6Q2mFbQNmIIrfAKloE',
];

// Ably는 시간당 500건 제한 (무료 플랜 기준)
egb_api_management_insert('ably', 'Ably 실시간 서비스', 'push', $metadata);

//API 관리 테이블 생성 
$app_id  = "2015782";
$key     = "278be27a1f4c3bac0d09"; 
$secret  = "1bf69a15a5a60e8b5096";
$cluster = "ap3";

$metadata = [
    'app_id'  => $app_id,
    'key'     => $key,
    'secret'  => $secret,
    'cluster' => $cluster,
];

// API 관리 테이블 생성
egb_api_management_insert('pusher', 'WebSocket 대안 서비스', 'push', $metadata);


?>