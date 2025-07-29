<?php

if (!isset($_SESSION['user_uniq_id'])) {
    echo json_encode(['success' => false, 'failureCode' => 104]); // 로그인 필요
    exit;
}
$user_uniq_id = $_SESSION['user_uniq_id'];

// 파라미터 수집
$store_uniq_id = egb('store_uniq_id', 139);
$reservation_year = egb('reservation_year', 140);
$reservation_month = egb('reservation_month', 141);
$reservation_day = egb('reservation_day', 142);
$reservation_times = egb('reservation_times', 143);
$reservation_user_name = egb('reservation_user_name', 144);
$reservation_user_phone_number = egb('reservation_user_phone_number', 145);
$reservation_car_model = egb('reservation_car_model', 146);
$reservation_car_model_year = egb('reservation_car_model_year', 147);
$reservation_car_number = egb('reservation_car_number', 148);
$reservation_car_mileage = egb('reservation_car_mileage', 149);
$reservation_car_type = egb('reservation_car_type', 150);
$reservation_car_product_check = egb('reservation_car_product_check', 151);
$reservation_car_maintenance_items = egb('reservation_car_maintenance_items[]', 152);
$reservation_title = egb('reservation_title', 153);
$reservation_contents = egb('reservation_contents', 154);


// 전화번호 유효성 검사
if (!preg_match('/^01[016789]\d{8}$/', $reservation_user_phone_number) && 
    !preg_match('/^01[016789]-\d{4}-\d{4}$/', $reservation_user_phone_number)) {
    echo json_encode(['success' => false, 'failureCode' => 179]);
    exit;
}

// 차량 모델명에 특수문자가 포함되어 있는지 검사
if (preg_match('/[^가-힣a-zA-Z0-9\s]/', $reservation_car_model)) {
    echo json_encode(['success' => false, 'failureCode' => 180]); // 차량 모델명에 특수문자를 사용할 수 없습니다
    exit;
}

// 차량 모델 연식에 특수문자가 포함되어 있는지 검사
if (preg_match('/[^가-힣a-zA-Z0-9]/', $reservation_car_model_year)) {
    echo json_encode(['success' => false, 'failureCode' => 181]); // 차량 모델 연식에 특수문자를 사용할 수 없습니다
    exit;
}

// 차량 번호에 특수문자가 포함되어 있는지 검사
if (preg_match('/[^가-힣a-zA-Z0-9]/', $reservation_car_number)) {
    echo json_encode(['success' => false, 'failureCode' => 182]); // 차량 번호에 특수문자를 사용할 수 없습니다
    exit;
}

// 차량 주행거리에 특수문자가 포함되어 있는지 검사
if (preg_match('/[^가-힣a-zA-Z0-9]/', $reservation_car_mileage)) {
    echo json_encode(['success' => false, 'failureCode' => 183]); // 차량 주행거리에 특수문자를 사용할 수 없습니다
    exit;
}


// 하이픈 제거
$reservation_user_phone_number = preg_replace('/[^0-9]/', '', $reservation_user_phone_number);
// 시간 데이터 디코딩
$reservation_times = html_entity_decode($reservation_times);
$reservation_times = json_decode($reservation_times, true);
if (!is_array($reservation_times) || empty($reservation_times)) {
    echo json_encode(['success' => false, 'failureCode' => 143]); // 예약 시간을 선택해주세요
    exit;
}

// 예약 그룹 ID
$reservation_group_uniq_id = uniqid();
$reservation_length = count($reservation_times);
$transaction_queries = [];

// 스토어 스케줄 불러오기
$schedule_query = "SELECT store_schedule FROM egb_store WHERE uniq_id = :store_uniq_id";
$schedule_params = [':store_uniq_id' => $store_uniq_id];
$schedule_binding = binding_sql(1, $schedule_query, $schedule_params);
$schedule_result = egb_sql($schedule_binding);

$schedule = [];
if (!empty($schedule_result[0]['store_schedule'])) {
    $schedule = json_decode($schedule_result[0]['store_schedule'], true);
}

// 예약 처리 반복
foreach ($reservation_times as $reservation_hour) {
    $date = sprintf('%04d-%02d-%02d', $reservation_year, $reservation_month, $reservation_day);
    $weekday_map = ['일', '월', '화', '수', '목', '금', '토'];
    $weekday = $weekday_map[date('w', strtotime($date))];

    $day_schedule = $schedule[$weekday] ?? null;
    if (!$day_schedule || !isset($day_schedule['slots'])) {
        echo json_encode(['success' => false, 'failureCode' => 155]); // 예약 불가능한 시간
        exit;
    }

    // 시간 비교용 포맷으로 변환
    $target_time = sprintf('%02d:00', (int)$reservation_hour);

    $slot = null;
    foreach ($day_schedule['slots'] as $time_slot) {
        if (isset($time_slot['time']) && $time_slot['time'] === $target_time) {
            $slot = $time_slot;
            break;
        }
    }

    if (!$slot || !isset($slot['count'])) {
        echo json_encode(['success' => false, 'failureCode' => 156]); // 예약 불가능한 시간
        exit;
    }

    // 예약 수량 체크
    $reservation_date = sprintf('%04d-%02d-%02d', $reservation_year, $reservation_month, $reservation_day);
    $reservation_time = $target_time . ':00'; // 예: 11:00:00

    $count_query = "
        SELECT COUNT(*) as cnt 
        FROM egb_reservation 
        WHERE reservation_store_uniq_id = :store_uniq_id
        AND reservation_date = :reservation_date
        AND reservation_time = :reservation_time
        AND reservation_status = 1
        AND deleted_at IS NULL
    ";
    $count_params = [
        ':store_uniq_id' => $store_uniq_id,
        ':reservation_date' => $reservation_date,
        ':reservation_time' => $reservation_time
    ];
    $count_binding = binding_sql(1, $count_query, $count_params);
    $count_result = egb_sql($count_binding);

    $available_slots = $slot['count'] - ($count_result[0]['cnt'] ?? 0);
    if ($available_slots <= 0) {
        echo json_encode(['success' => false, 'failureCode' => 155]); // 예약 불가능
        exit;
    }

    // 예약 정보 구성
    $reservation_data = [
        'uniq_id' => uniqid(),
        'is_status' => 1,
        'display_order' => 0,
        'reservation_group_uniq_id' => $reservation_group_uniq_id,
        'reservation_date' => $reservation_date,
        'reservation_time' => $reservation_time,
        'reservation_weekday' => $weekday,
        'reservation_store_uniq_id' => $store_uniq_id,
        'reservation_user_uniq_id' => $user_uniq_id,
        'reservation_applied_at' => date('Y-m-d H:i:s'),
        'reservation_confirmed_at' => null,
        'reservation_canceled_at' => null,
        'reservation_no_show_at' => null,
        'reservation_status' => 1,
        'reservation_confirmed_by' => null,
        'reservation_canceled_by' => null,
        'reservation_no_show_by' => null,
        'reservation_manager_note' => null,
        'reservation_canceled_note' => null,
        'reservation_no_show_note' => null,
        'reservation_data' => json_encode([
            'user_name' => $reservation_user_name,
            'user_phone_number' => $reservation_user_phone_number,
            'car_model' => $reservation_car_model,
            'car_model_year' => $reservation_car_model_year,
            'car_number' => $reservation_car_number,
            'car_mileage' => $reservation_car_mileage,
            'car_type' => $reservation_car_type,
            'car_product_check' => $reservation_car_product_check,
            'car_maintenance_items' => $reservation_car_maintenance_items,
            'title' => $reservation_title,
            'contents' => $reservation_contents,
            'estimated_time' => $reservation_length
        ]),
        'created_by' => $user_uniq_id,
        'updated_by' => null,
        'deleted_by' => null,
        'created_at' => date('Y-m-d H:i:s'),
        'deleted_at' => null,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $columns = implode(', ', array_keys($reservation_data));
    $values = ':' . implode(', :', array_keys($reservation_data));
    $insert_query = "INSERT INTO egb_reservation ($columns) VALUES ($values)";
    $binding_params = array_combine(
        array_map(fn($k) => ':' . $k, array_keys($reservation_data)),
        array_values($reservation_data)
    );
    $binding_insert = binding_sql(2, $insert_query, $binding_params);
    $transaction_queries[] = $binding_insert;
}

// 트랜잭션 실행
$result = egb_sql(...$transaction_queries);
if ($result) {

    increase_record_total_count('egb_reservation');
    increase_record_active_count('egb_reservation');

    egb_reward_dispatch($user_uniq_id, 'reward_selfcare_reservation', 'point', 0, 'auto_grade_check');

    echo json_encode(['success' => true, 'successCode' => 17, 'url' => DOMAIN . '/page/reservation_store']);
} else {
    echo json_encode(['success' => false, 'failureCode' => 156]); // 등록 실패
}
?>
