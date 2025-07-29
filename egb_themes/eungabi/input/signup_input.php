


<?php

    // 필수 필드 설정 조회 및 검증 함수
    function checkRequiredField($group_code, $error_code) {
        $group_code_query = "
            SELECT group_required 
            FROM egb_option_group 
            WHERE group_code = :group_code 
            AND deleted_at IS NULL 
            LIMIT 1
        ";
        $binding = binding_sql(1, $group_code_query, [':group_code' => $group_code]);
        $group = egb_sql($binding);
        $required = isset($group[0]['group_required']) ? $group[0]['group_required'] : '0';
        
        // 필드 값 가져오기
        $value = egb($group_code);
        
        // group_required 값에 따른 처리
        switch($required) {
            case 2: // 필수 필드
                if (!isset($value) || trim($value) === '') {
                    echo json_encode(['success' => false, 'failureCode' => $error_code]);
                    exit;
                }
                return $value;
                
            case 1: // 선택 필드
                return isset($value) && trim($value) !== '' ? $value : null;
                
            case 0: // 미사용
            default:
                return null;
        }
    }

     $shopping_mall_user_type = checkRequiredField('shopping_mall_user_type', 1);

     $shopping_mall_user_type_business = '';
     $user_company_name = '';
     $user_company_name2 = '';
     $user_company_registration_number = '';

     if($shopping_mall_user_type) {
         // 쇼핑몰 회원 구분이 기업회원인지 확인
         $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id AND deleted_at IS NULL";
         $binding = binding_sql(1, $query, [':uniq_id' => $shopping_mall_user_type]);
         $result = egb_sql($binding);
         
         if (!isset($result[0]) || $result[0]['option_label'] !== '기업회원') {
             // 기업회원이 아닌 경우 사업자구분 값을 null로 설정
             $shopping_mall_user_type_business = null;
             $user_company_name = null;
             $user_company_name2 = null;
             $user_company_registration_number = null;
         }else{

            $shopping_mall_user_type_business = checkRequiredField('shopping_mall_user_type_business', 2);

            // 사업자 구분 값 조회
            $query = "SELECT option_label FROM egb_option WHERE uniq_id = :uniq_id AND deleted_at IS NULL";
            $binding = binding_sql(1, $query, [':uniq_id' => egb('shopping_mall_user_type_business')]);
            $result = egb_sql($binding);

            // 개인사업자/법인사업자 구분에 따른 처리
            if (isset($result[0])) {
                if ($result[0]['option_label'] === '개인사업자') {
                    // 개인사업자인 경우 법인사업자 관련 필드는 null로 설정
                    $user_company_name2 = null;
                    $user_company_name = checkRequiredField('user_company_name', 3);
                } else if ($result[0]['option_label'] === '법인사업자') {
                    // 법인사업자인 경우 개인사업자 관련 필드는 null로 설정  
                    $user_company_name = null;
                    $user_company_name2 = checkRequiredField('user_company_name2', 4);
                }
            }

            $user_company_registration_number = checkRequiredField('user_company_registration_number', 5);   
         }
     } else {
         $shopping_mall_user_type_business = null;
         $user_company_name = null;
         $user_company_name2 = null;
         $user_company_registration_number = null;
     }

     $community_user_grade = checkRequiredField('community_user_grade', 6);
     $user_mentor_id = '';
     $is_status = 1; // 기본 상태값 설정
     
     if ($community_user_grade) {
         // 커뮤니티 회원등급 값 조회
         $query = "SELECT o.option_label, o.option_is_active 
                  FROM egb_option o 
                  WHERE o.uniq_id = :uniq_id 
                  AND o.deleted_at IS NULL";
         $binding = binding_sql(1, $query, [':uniq_id' => $community_user_grade]);
         $result = egb_sql($binding);

         if (isset($result[0])) {
             // 제한된 등급인 경우 is_status를 3으로 설정
             if ($result[0]['option_is_active'] == 0) {
                 $is_status = 3;
             }
             
             if ($result[0]['option_label'] == '멘티') {
                $user_mentor_id = checkRequiredField('user_mentor_id', 7);
                
                // 멘토 등급의 uniq_id 조회
                $group_query = "SELECT uniq_id FROM egb_option_group 
                              WHERE group_code = 'community_user_grade' 
                              AND deleted_at IS NULL";
                $group_binding = binding_sql(1, $group_query, []);
                $group_result = egb_sql($group_binding);

                if (isset($group_result[0])) {
                    $mentor_grade_query = "SELECT uniq_id FROM egb_option 
                                         WHERE option_label = '멘토'
                                         AND option_group_uniq_id = :group_uniq_id
                                         AND deleted_at IS NULL";
                    $mentor_grade_binding = binding_sql(1, $mentor_grade_query, [
                        ':group_uniq_id' => $group_result[0]['uniq_id']
                    ]);
                    $mentor_grade_result = egb_sql($mentor_grade_binding);
                }

                if (isset($mentor_grade_result[0]['uniq_id'])) {
                    $mentor_grade_id = $mentor_grade_result[0]['uniq_id'];
                    
                    // 멘토 아이디 존재 여부 확인 (멘토 등급인 회원만)
                    $mentor_check_query = "SELECT user_id FROM egb_user 
                                         WHERE user_id = :mentor_id 
                                         AND community_user_grade = :mentor_grade_id
                                         AND deleted_at IS NULL";
                    $mentor_binding = binding_sql(1, $mentor_check_query, [
                        ':mentor_id' => $user_mentor_id,
                        ':mentor_grade_id' => $mentor_grade_id
                    ]);
                    $mentor_result = egb_sql($mentor_binding);

                    if (!isset($mentor_result[0]['user_id'])) {
                        echo json_encode(['success' => false, 'failureCode' => 8]);
                        exit;
                    }
                } else {
                    echo json_encode(['success' => false, 'failureCode' => 8]);
                    exit;
                }
             } else {
                $user_mentor_id = null;
             }
         }
     }
        
     $user_id = checkRequiredField('user_id', 9);
        
     if ($user_id) {
         // 아이디 유효성 검사
         if (!preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]{6,}$/', $user_id)) {
             echo json_encode(['success' => false, 'failureCode' => 10]); 
             exit;
         }

         // 가입불가 아이디 체크
         $query = "SELECT group_description FROM egb_option_group WHERE group_code = 'signup_deny_keyword' AND is_status = 1";
         $binding = binding_sql(1, $query, []);
         $result = egb_sql($binding);
         
         if (isset($result[0]['group_description'])) {
             $deny_keywords = explode(',', $result[0]['group_description']);
             foreach ($deny_keywords as $keyword) {
                 $keyword = trim($keyword);
                 if (stripos($user_id, $keyword) !== false) {
                     echo json_encode(['success' => false, 'failureCode' => 10.1]);
                     exit;
                 }
             }
         }

         // 아이디 중복 체크
         $query = "SELECT user_id FROM egb_user WHERE user_id = :user_id LIMIT 1";
         $binding = binding_sql(1, $query, [':user_id' => $user_id]);
         $result = egb_sql($binding);

         if (isset($result[0]['user_id'])) {
             echo json_encode(['success' => false, 'failureCode' => 11]);
             exit;
         }
     }

     $user_password = checkRequiredField('user_password', 12);
     
     if ($user_password) {
         // 비밀번호 유효성 검사 - 영문, 숫자를 포함한 8자 이상
     if (!preg_match('/^(?=.*[a-zA-Z])(?=.*[0-9]).{8,}$/', $user_password)) {
         echo json_encode(['success' => false, 'failureCode' => 13]);
             exit;
         }
     }

     $user_password_check = checkRequiredField('user_password_check', 14);
     if ($user_password_check) {
         // 비밀번호 확인 유효성 검사 - 비밀번호와 일치 여부 확인
     if ($user_password !== $user_password_check) {
             echo json_encode(['success' => false, 'failureCode' => 15]);
             exit;
         }
     }

     if ($user_password && $user_password_check) {
         $user_password = password_hash($user_password, PASSWORD_DEFAULT);
     }
     
     $user_name = checkRequiredField('user_name', 16);
     if ($user_name) {
         // 이름에 특수문자나 숫자가 포함되어 있는지 검사
         if (!preg_match('/^[가-힣a-zA-Z\s]+$/', $user_name)) {
             echo json_encode(['success' => false, 'failureCode' => 16]);
             exit;
         }
     }

     $user_nick_name = checkRequiredField('user_nick_name', 17);
     if ($user_nick_name) {
         // 닉네임에 한글, 영문, 숫자 사용 가능하도록 검사
         if (!preg_match('/^[가-힣a-zA-Z0-9\s]+$/', $user_nick_name)) {
             echo json_encode(['success' => false, 'failureCode' => 17]);
             exit;
         }
     }

     // 우편번호, 주소, 상세주소 필드 검증
     $user_zipcode = checkRequiredField('user_zipcode', 18);
     if ($user_zipcode) {
         if (strlen($user_zipcode) !== 5) {
             echo json_encode(['success' => false, 'failureCode' => 18]);
             exit;
         }
     }

     $user_address = checkRequiredField('user_address', 19);
     if ($user_address) {
         if (trim($user_address) === '') {
             echo json_encode(['success' => false, 'failureCode' => 19]);
             exit;
         }
     }

     $user_address_detail = checkRequiredField('user_address_detail', 20);
     if ($user_address_detail) {
         if (trim($user_address_detail) === '') {
             echo json_encode(['success' => false, 'failureCode' => 20]);
             exit;
         }
     }

     $phone_number1 = checkRequiredField('phone_number1', 21);
     if ($phone_number1) {
         if (strlen($phone_number1) !== 11) {
             $phone_number1 = '';
             echo json_encode(['success' => false, 'failureCode' => 21]);
             exit;
         }
     }
     
     $phone_number2 = checkRequiredField('phone_number2', 22);
     if ($phone_number2) {
         if (strlen($phone_number2) !== 11) {
             $phone_number2 = '';
             echo json_encode(['success' => false, 'failureCode' => 22]);
             exit;
         }
     }
     
     $user_email1 = checkRequiredField('user_email', 23);
     if ($user_email1) {
         if ($user_email1 === '@선택해주세요.' || strpos($user_email1, '@') === 0 || strpos($user_email1, '@email_custom_value') !== false || strpos($user_email1, '@') === strlen($user_email1)-1) {
             echo json_encode(['success' => false, 'failureCode' => 23]);
             exit;
         }
     }

     $user_gender = checkRequiredField('user_gender', 24);
     $user_homepage = checkRequiredField('user_homepage', 25);
     $user_registration_purpose = checkRequiredField('user_registration_purpose', 26);
     $user_funnel_source = checkRequiredField('user_funnel_source', 27);

     $user_birthday = checkRequiredField('user_birthday', 28);
     if ($user_birthday) {
         if ($user_birthday === '--' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $user_birthday)) {
             echo json_encode(['success' => false, 'failureCode' => 28]);
             exit;
         }

         // 가입연령 제한 설정 조회
         $age_limit_query = "
             SELECT group_required, group_description 
             FROM egb_option_group 
             WHERE group_code = 'user_age_limit_setting' 
             AND is_status = 1
         ";
         $binding = binding_sql(1, $age_limit_query, []);
         $result = egb_sql($binding);

         if (!empty($result)) {
             $age_limit_enabled = $result[0]['group_required'];
             $min_age = intval($result[0]['group_description']);

             if (!$age_limit_enabled) { // 연령 제한이 활성화된 경우
                 $birth_date = new DateTime($user_birthday);
                 $today = new DateTime();
                 $age = $today->diff($birth_date)->y;

                 if ($age < $min_age) {
                     echo json_encode(['success' => false, 'failureCode' => 28.1]);
                     exit;
                 }
             }
         }
     }   
     $user_custom_day = checkRequiredField('user_custom_day', 29);
     if ($user_custom_day) {
         if ($user_custom_day === '--' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $user_custom_day)) {
             echo json_encode(['success' => false, 'failureCode' => 29]); 
             exit;
         }
     }

     $user_bank_alias = checkRequiredField('user_bank_alias', 30);
     $user_bank_account = checkRequiredField('user_bank_account', 31);
     $user_bank_holder = checkRequiredField('user_bank_holder', 32);
     $user_job = checkRequiredField('user_job', 33);
     $user_company_name3 = checkRequiredField('user_company_name3', 34);
     $user_department = checkRequiredField('user_department', 35);
     $user_position = checkRequiredField('user_position', 36);
     $user_work_phone = checkRequiredField('user_work_phone', 37);
     $user_work_fax = checkRequiredField('user_work_fax', 38);
     $user_work_address = checkRequiredField('user_work_address', 39);
     $user_activity_area = checkRequiredField('user_activity_area', 40);

     $user_car_cc = checkRequiredField('user_car_cc', 41);
     if ($user_car_cc) {
         if ($user_car_cc === '선택') {
             echo json_encode(['success' => false, 'failureCode' => 41]);
             exit;
         }   
     }
     $user_region = checkRequiredField('user_region', 42);
     if ($user_region) {
         if ($user_region === '선택') {
             echo json_encode(['success' => false, 'failureCode' => 42]);
             exit;
         }
     }

//회원정보 삽입
$uniq_id = uniqid();

$insert_query = "
INSERT INTO egb_user (
    uniq_id,
    user_id,
    user_password,
    user_name,
    user_nick_name,
    user_email,
    user_phone1,
    user_phone2,
    user_zipcode,
    user_address,
    user_address_detail,
    shopping_mall_user_type,
    shopping_mall_user_type_business,
    user_company_name,
    user_company_name2,
    community_user_grade,
    user_mentor_id,
    user_gender,
    user_homepage,
    user_registration_purpose,
    user_birthday,
    user_custom_day,
    user_bank_alias,
    user_bank_holder,
    user_job,
    user_department,
    user_position,
    user_work_phone,
    user_work_fax,
    user_work_address,
    user_activity_area,
    user_car_cc,
    user_region,
    created_by,
    is_status
) VALUES (
    :uniq_id,
    :user_id,
    :user_password,
    :user_name,
    :user_nick_name,
    :user_email,
    :user_phone1,
    :user_phone2,
    :user_zipcode,
    :user_address,
    :user_address_detail,
    :shopping_mall_user_type,
    :shopping_mall_user_type_business,
    :user_company_name,
    :user_company_name2,
    :community_user_grade,
    :user_mentor_id,
    :user_gender,
    :user_homepage,
    :user_registration_purpose,
    :user_birthday,
    :user_custom_day,
    :user_bank_alias,
    :user_bank_holder,
    :user_job,
    :user_department,
    :user_position,
    :user_work_phone,
    :user_work_fax,
    :user_work_address,
    :user_activity_area,
    :user_car_cc,
    :user_region,
    :created_by,
    :is_status
)";

$insert_params = [
    ':uniq_id' => $uniq_id,
    ':user_id' => $user_id,
    ':user_password' => $user_password,
    ':user_name' => $user_name,
    ':user_nick_name' => $user_nick_name,
    ':user_email' => $user_email1,
    ':user_phone1' => $phone_number1,
    ':user_phone2' => $phone_number2,
    ':user_zipcode' => $user_zipcode,
    ':user_address' => $user_address,
    ':user_address_detail' => $user_address_detail,
    ':shopping_mall_user_type' => $shopping_mall_user_type,
    ':shopping_mall_user_type_business' => $shopping_mall_user_type_business,
    ':user_company_name' => $user_company_name,
    ':user_company_name2' => $user_company_name2,
    ':community_user_grade' => $community_user_grade,
    ':user_mentor_id' => $user_mentor_id,
    ':user_gender' => $user_gender,
    ':user_homepage' => $user_homepage,
    ':user_registration_purpose' => $user_registration_purpose,
    ':user_birthday' => $user_birthday,
    ':user_custom_day' => $user_custom_day,
    ':user_bank_alias' => $user_bank_alias,
    ':user_bank_holder' => $user_bank_holder,
    ':user_job' => $user_job,
    ':user_department' => $user_department,
    ':user_position' => $user_position,
    ':user_work_phone' => $user_work_phone,
    ':user_work_fax' => $user_work_fax,
    ':user_work_address' => $user_work_address,
    ':user_activity_area' => $user_activity_area,
    ':user_car_cc' => $user_car_cc,
    ':user_region' => $user_region,
    ':created_by' => 'system',
    ':is_status' => $is_status
];

$insert_binding = binding_sql(3, $insert_query, $insert_params);
$result = egb_sql($insert_binding);

if ($result) {
    // 전체 등록 수 증가
    increase_record_total_count('egb_user');
    
    // 활성화 수 증가 
    if($is_status == 1) {
        increase_record_active_count('egb_user');
    } else {
        increase_record_inactive_count('egb_user'); 
    }

    //리워드 지급
    egb_reward_dispatch($uniq_id, 'reward_signup', 'point', 0, 'auto_grade_check');

    // 멘티가 멘토를 등록한 경우 멘토에게 알림 처리
    if ($user_mentor_id) {
        // 멘토 정보 조회
        $mentor_query = "
            SELECT u.uniq_id, u.user_name, u.user_nick_name
            FROM egb_user u
            WHERE u.user_id = :mentor_id
            AND u.deleted_at IS NULL
            AND u.is_status = 1
        ";
        $mentor_binding = binding_sql(1, $mentor_query, [':mentor_id' => $user_mentor_id]);
        $mentor_result = egb_sql($mentor_binding);

        if (isset($mentor_result[0])) {
            $mentor_uniq_id = $mentor_result[0]['uniq_id'];
            $mentee_name = $user_nick_name ?: $user_name;
            
            // 멘토에게 새로운 멘티 등록 알림 전송
            $message = "새로운 멘티 '{$mentee_name}'님이 등록되었습니다.";
            $view_path = "";

            // 알림 데이터베이스에 저장
            egb_alarm_insert(
                $mentor_uniq_id,
                '새로운 멘티 등록 알림',
                $message,
                $view_path,
                'new_mentee'
            );

            // 푸시 알림 전송
            egb_send_push_event(
                "public-user-{$mentor_uniq_id}",
                'new-mentee',
                [
                    'uniq_id' => $uniq_id,
                    'user_nick_name' => $mentee_name,
                    'board_type' => '',
                    'board_uniq_id' => '',
                    'like_target_table' => '',
                    'like_user_uniq_id' => '',
                    'message' => $message,
                    'view_path' => $view_path,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
        }
    }

    echo json_encode(['success' => true, 'successCode' => 1]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 43]);
}

?>