<?php

$reservation_group_uniq_id = egb('reservation_group_uniq_id', 157);
$reservation_store_uniq_id = egb('reservation_user_product', 161);
$reservation_date = egb('reservation_date_day', 162);
$reservation_time = egb('reservation_date_time_info_edit', 163);
$reservation_car_model = egb('reservation_car_model_info_edit', 164);
$reservation_estimated_time = (int)egb('reservation_estimated_time_info_edit', 165);
$reservation_manager_note = egb('reservation_internal_memo_info_edit', 166);

// 예약 유지보수 항목 파싱 처리
$raw_items = egb('reservation_car_maintenance_items_info_edit', 167);
$raw_items = htmlspecialchars_decode($raw_items);
$reservation_maintenance_items = json_decode($raw_items, true);
if (!is_array($reservation_maintenance_items)) {
    $reservation_maintenance_items = [];
}

// 요일 구하기
$reservation_weekday = ['일','월','화','수','목','금','토'][date('w', strtotime($reservation_date))];

// 예약 목록 조회
$select_query = "
    SELECT uniq_id, reservation_data, reservation_user_uniq_id
    FROM egb_reservation 
    WHERE reservation_group_uniq_id = :group_uniq_id 
      AND reservation_status = 1 
      AND deleted_at IS NULL
    ORDER BY reservation_time ASC
";
$select_params = [':group_uniq_id' => $reservation_group_uniq_id];
$binding1 = binding_sql(0, $select_query, $select_params);
$result = egb_sql($binding1);

if (!$result || empty($result[0])) {
    echo json_encode(['success' => false, 'failureCode' => 168]);
    exit;
}

$reservations = $result[0];
$reservation_user_uniq_id = $reservations[0]['reservation_user_uniq_id'];

// 🛡️ 유효성 검증 시작 (시간대 예약 가능 여부 확인)
$start_time = DateTime::createFromFormat('H:i', $reservation_time);

// 스토어 스케줄 조회
$schedule_query = "SELECT store_schedule FROM egb_store WHERE uniq_id = :store_uniq_id";
$schedule_binding = binding_sql(1, $schedule_query, [':store_uniq_id' => $reservation_store_uniq_id]);
$schedule_result = egb_sql($schedule_binding);
$schedule = [];
$holidays = [];

if (isset($schedule_result[0]['store_schedule'])) {
    $store_schedule_data = json_decode($schedule_result[0]['store_schedule'], true);
    $schedule = $store_schedule_data;
    $holidays = $store_schedule_data['holidays'] ?? [];
}
$holiday_dates = array_column($holidays, 'date');

$check_time = clone $start_time;
$check_errors = [];

for ($i = 0; $i < $reservation_estimated_time; $i++) {
    $hour = (int)$check_time->format('H');
    $date_key = $reservation_date;
    $day_name = ['일', '월', '화', '수', '목', '금', '토'][date('w', strtotime($reservation_date))];
    $store_day_schedule = $schedule[$day_name] ?? null;

    if (in_array($date_key, $holiday_dates) || !$store_day_schedule || $store_day_schedule['status'] == 0) {
        $check_errors[] = "{$hour}시: 휴무";
    } else {
        $found_slot = null;
        foreach ($store_day_schedule['slots'] as $slot) {
            if ((int)explode(':', $slot['time'])[0] == $hour) {
                $found_slot = $slot;
                break;
            }
        }
        if (!$found_slot || $found_slot['status'] == 0) {
            $check_errors[] = "{$hour}시: 쉬는 시간";
        } else {
            $reservation_count_query = "
                SELECT COUNT(*) as cnt 
                FROM egb_reservation 
                WHERE reservation_store_uniq_id = :store_uniq_id
                  AND reservation_date = :date
                  AND HOUR(reservation_time) = :hour
                  AND reservation_status = 1
                  AND deleted_at IS NULL
            ";
            $reservation_count_params = [
                ':store_uniq_id' => $reservation_store_uniq_id,
                ':date' => $reservation_date,
                ':hour' => $hour
            ];
            $reservation_count_binding = binding_sql(1, $reservation_count_query, $reservation_count_params);
            $reservation_count_result = egb_sql($reservation_count_binding);
            $reserved_count = (int)($reservation_count_result[0]['cnt'] ?? 0);

            if ($reserved_count >= (int)$found_slot['count']) {
                $check_errors[] = "{$hour}시: 마감";
            }
        }
    }
    $check_time->modify('+1 hour');
}

if (!empty($check_errors)) {
    echo json_encode(['success' => false, 'failureCode' => 170]);
    exit;
}

// ✅ 본격 예약 수정 및 추가
$update_queries = [];
$index = 0;
$start_time = DateTime::createFromFormat('H:i', $reservation_time);

foreach ($reservations as $row) {
    if ($index >= $reservation_estimated_time) {
        $delete_query = "
            UPDATE egb_reservation
            SET 
                deleted_at = NOW(),
                deleted_by = :deleted_by,
                is_status = 0
            WHERE uniq_id = :uniq_id
        ";
        $delete_params = [
            ':deleted_by' => 'system',
            ':uniq_id' => $row['uniq_id']
        ];
        $update_queries[] = binding_sql(2, $delete_query, $delete_params);
        continue;
    }

    $uniq_id = $row['uniq_id'];
    $current_time = clone $start_time;
    $current_time->modify("+{$index} hour");
    $formatted_time = $current_time->format('H:i:00');

    $old_data = json_decode($row['reservation_data'] ?? '{}', true);
    if (!is_array($old_data)) {
        $old_data = [];
    }

    $old_data['car_model'] = $reservation_car_model;
    $old_data['estimated_time'] = $reservation_estimated_time;
    $old_data['car_maintenance_items'] = $reservation_maintenance_items;

    $update_query = "
        UPDATE egb_reservation
        SET 
            reservation_store_uniq_id = :store_uniq_id,
            reservation_date = :reservation_date,
            reservation_time = :reservation_time,
            reservation_weekday = :reservation_weekday,
            reservation_data = :reservation_data,
            reservation_manager_note = :reservation_manager_note,
            updated_by = :updated_by,
            updated_at = NOW()
        WHERE uniq_id = :uniq_id
    ";

    $update_params = [
        ':store_uniq_id' => $reservation_store_uniq_id,
        ':reservation_date' => $reservation_date,
        ':reservation_time' => $formatted_time,
        ':reservation_weekday' => $reservation_weekday,
        ':reservation_data' => json_encode($old_data),
        ':reservation_manager_note' => $reservation_manager_note,
        ':updated_by' => 'system',
        ':uniq_id' => $uniq_id
    ];

    $update_queries[] = binding_sql(2, $update_query, $update_params);
    $index++;
}

// 부족한 만큼 INSERT
$missing = $reservation_estimated_time - $index;
if ($missing > 0) {
    $base_data = json_decode($reservations[0]['reservation_data'] ?? '{}', true);
    if (!is_array($base_data)) {
        $base_data = [];
    }
    $base_data['car_model'] = $reservation_car_model;
    $base_data['estimated_time'] = $reservation_estimated_time;
    $base_data['car_maintenance_items'] = $reservation_maintenance_items;

    for ($i = 0; $i < $missing; $i++) {
        $new_time = clone $start_time;
        $new_time->modify("+{$index} hour");
        $formatted_time = $new_time->format('H:i:00');

        $uniq_id = uniqid();

        $insert_query = "
            INSERT INTO egb_reservation (
                uniq_id, is_status, display_order,
                reservation_group_uniq_id, reservation_date, reservation_time, reservation_weekday,
                reservation_store_uniq_id, reservation_user_uniq_id, reservation_applied_at,
                reservation_status, reservation_data,
                reservation_manager_note, created_by, created_at, updated_at
            ) VALUES (
                :uniq_id, 1, 0,
                :group_uniq_id, :reservation_date, :reservation_time, :reservation_weekday,
                :store_uniq_id, :user_uniq_id, NOW(),
                1, :reservation_data,
                :manager_note, :created_by, NOW(), NOW()
            )
        ";

        $insert_params = [
            ':uniq_id' => $uniq_id,
            ':group_uniq_id' => $reservation_group_uniq_id,
            ':reservation_date' => $reservation_date,
            ':reservation_time' => $formatted_time,
            ':reservation_weekday' => $reservation_weekday,
            ':store_uniq_id' => $reservation_store_uniq_id,
            ':user_uniq_id' => $reservation_user_uniq_id,
            ':reservation_data' => json_encode($base_data),
            ':manager_note' => $reservation_manager_note,
            ':created_by' => 'system'
        ];

        $update_queries[] = binding_sql(2, $insert_query, $insert_params);
        $index++;
    }
}

$exec = egb_sql(...$update_queries);
if ($exec) {
    // 업데이트된 예약 정보 조회
    $query = "
        SELECT r.*, 
               GROUP_CONCAT(r.reservation_time ORDER BY r.reservation_time ASC) as reservation_times,
               MIN(r.reservation_date) as start_date,
               MAX(r.reservation_date) as end_date,
               MAX(r.reservation_completed_at) as reservation_completed_at
        FROM egb_reservation r
        WHERE r.reservation_group_uniq_id = :reservation_group_uniq_id 
        AND r.deleted_at IS NULL
        GROUP BY r.reservation_group_uniq_id
    ";

    $params = [':reservation_group_uniq_id' => $reservation_group_uniq_id];
    $binding = binding_sql(1, $query, $params);
    $reservation = egb_sql($binding);

    // 스토어 정보 조회
    $store_query = "
        SELECT uniq_id, store_name 
        FROM egb_store
        WHERE uniq_id = :store_uniq_id
    ";
    $store_params = [':store_uniq_id' => $reservation[0]['reservation_store_uniq_id']];
    $store_binding = binding_sql(1, $store_query, $store_params);
    $store = egb_sql($store_binding);

    // 사용자 정보 조회
    $user_query = "
        SELECT uniq_id, user_name, user_phone1, user_phone2, user_email
        FROM egb_user
        WHERE uniq_id = :user_uniq_id
    ";
    $user_params = [':user_uniq_id' => $reservation[0]['reservation_user_uniq_id']];
    $user_binding = binding_sql(1, $user_query, $user_params);
    $user = egb_sql($user_binding);

    // 처리자 정보 조회
    $admin_uniq_ids = array_filter([
        $reservation[0]['reservation_confirmed_by'],
        $reservation[0]['reservation_canceled_by'],
        $reservation[0]['reservation_no_show_by'],
        $reservation[0]['reservation_completed_by']
    ]);

    $admin_names = [];
    if (!empty($admin_uniq_ids)) {
        $admin_query = "
            SELECT uniq_id, user_name
            FROM egb_user 
            WHERE uniq_id IN ('" . implode("','", $admin_uniq_ids) . "')
        ";
        $admin_binding = binding_sql(0, $admin_query);
        $admin_result = egb_sql($admin_binding);
        
        foreach ($admin_result[0] as $admin) {
            $admin_names[$admin['uniq_id']] = $admin['user_name'];
        }
    }

    $reservation_data = json_decode($reservation[0]['reservation_data'], true);

    // 시작 시간과 종료 시간 계산
    $times = explode(',', $reservation[0]['reservation_times']);
    $start_time = substr($times[0], 0, 5);
    $end_time = date('H:i', strtotime(end($times) . ' +1 hour'));

    // 총 소요 시간 계산
    $start = strtotime($times[0]);
    $end = strtotime(end($times)) + 3600; // 마지막 시간에 1시간 추가
    $duration = ($end - $start) / 3600; // 시간 단위로 변환

    // 정비 항목 라벨 조회
    $maintenance_items = [];
    if (!empty($reservation_data['car_maintenance_items'])) {
        $items_query = "
            SELECT option_label
            FROM egb_option 
            WHERE uniq_id IN ('" . implode("','", $reservation_data['car_maintenance_items']) . "')
        ";
        $items_binding = binding_sql(0, $items_query);
        $items_result = egb_sql($items_binding);
        
        foreach ($items_result[0] as $item) {
            $maintenance_items[] = $item['option_label'];
        }
    }

    $result = [
        'uniq_id' => $reservation[0]['uniq_id'],
        'reservation_group_uniq_id' => $reservation_group_uniq_id,
        'store_name' => $store[0]['store_name'] ?? '',
        'reservation_date' => $reservation[0]['start_date'],
        'reservation_time' => $start_time . ' ~ ' . $end_time . ' (' . $duration . '시간)',
        'reservation_weekday' => $reservation[0]['reservation_weekday'],
        'reservation_status' => $reservation[0]['reservation_status'],
        'user_name' => $user[0]['user_name'] ?? '',
        'user_phone_number' => $user[0]['user_phone1'] ?? $user[0]['user_phone2'] ?? '',
        'user_email' => $user[0]['user_email'] ?? '',
        'car_model' => $reservation_data['car_model'] ?? '',
        'car_model_year' => $reservation_data['car_model_year'] ?? '',
        'car_number' => $reservation_data['car_number'] ?? '',
        'car_mileage' => $reservation_data['car_mileage'] ?? '',
        'car_type' => $reservation_data['car_type'] ?? '',
        'car_product_check' => $reservation_data['car_product_check'] ?? '',
        'car_maintenance_items' => $maintenance_items,
        'title' => $reservation_data['title'] ?? '',
        'contents' => $reservation_data['contents'] ?? '',
        'estimated_time' => $duration,
        'request_date' => $reservation[0]['reservation_applied_at'],
        'confirm_date' => $reservation[0]['reservation_confirmed_at'],
        'complete_date' => $reservation[0]['reservation_completed_at'],
        'cancel_date' => $reservation[0]['reservation_canceled_at'],
        'noshow_date' => $reservation[0]['reservation_no_show_at'],
        'confirm_admin' => $admin_names[$reservation[0]['reservation_confirmed_by']] ?? '',
        'complete_admin' => $admin_names[$reservation[0]['reservation_completed_by']] ?? '',
        'cancel_admin' => $admin_names[$reservation[0]['reservation_canceled_by']] ?? '',
        'noshow_admin' => $admin_names[$reservation[0]['reservation_no_show_by']] ?? '',
        'manager_note' => $reservation_manager_note,
        'canceled_note' => $reservation[0]['reservation_canceled_note'] ?? '',
        'noshow_note' => $reservation[0]['reservation_no_show_note'] ?? ''
    ];

    // 예약 변경 알림 처리
    $user_uniq_id = $reservation[0]['reservation_user_uniq_id'];
    $store_name = $store[0]['store_name'] ?? '매장';
    $reservation_date = $reservation[0]['start_date'];
    $formatted_date = date('Y년 m월 d일', strtotime($reservation_date));
    $formatted_time = $start_time . ' ~ ' . $end_time;

    // 사용자에게 예약 변경 알림 전송
    $message = "{$store_name}의 {$formatted_date} {$formatted_time} 예약이 변경되었습니다.";
    $view_path = "";

    // 알림 데이터베이스에 저장
    egb_alarm_insert(
        $user_uniq_id,
        '예약 변경 알림',
        $message,
        $view_path,
        'reservation_change'
    );

    // 푸시 알림 전송
    egb_send_push_event(
        "public-user-{$user_uniq_id}",
        'reservation-changed',
        [
            'uniq_id' => $user_uniq_id,
            'user_nick_name' => $user[0]['user_name'] ?? '',
            'board_type' => '',
            'board_uniq_id' => '',
            'like_target_table' => '',
            'like_user_uniq_id' => '',
            'message' => $message,
            'view_path' => $view_path,
            'created_at' => date('Y-m-d H:i:s')
        ]
    );

    echo json_encode(['success' => true, 'successCode' => 24, 'data' => $result]);
} else {
    echo json_encode(['success' => false, 'failureCode' => 169]);
}

?>
