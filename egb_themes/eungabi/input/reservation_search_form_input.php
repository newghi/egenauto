


<?php

// 검색 파라미터 가져오기
$search_type = egb('search_type');
$search_keyword = egb('search_keyword');
$date_type = egb('reservation_date_type');
$start_date = egb('reservation_start_date');
$end_date = egb('reservation_end_date');
$status = egb('reservation_status');
$store_id = egb('store_id');
$per_page = egb('per_page');

// 기본 쿼리 작성
$sql = "
    SELECT 
        r.uniq_id,
        r.reservation_user_uniq_id,
        r.reservation_status AS status,
        r.reservation_date,
        r.reservation_time,
        r.reservation_applied_at,
        r.reservation_confirmed_at,
        r.reservation_canceled_at,
        r.reservation_no_show_at,
        r.reservation_completed_at,
        r.reservation_data,
        r.reservation_store_uniq_id,
        r.reservation_group_uniq_id,
        u.user_name,
        u.user_phone1 as user_phone,
        u.user_email,
        s.store_name
    FROM egb_reservation r
    LEFT JOIN egb_user u ON r.reservation_user_uniq_id = u.uniq_id
    LEFT JOIN egb_store s ON r.reservation_store_uniq_id = s.uniq_id 
    WHERE r.is_status = 1
";

$params = [];

// 검색어 조건 추가
if (isset($search_keyword) && $search_keyword !== '') {
    switch($search_type) {
        case 'reserver_name':
            $sql .= " AND u.user_name LIKE :keyword";
            $params[':keyword'] = '%' . $search_keyword . '%';
            break;
        case 'reserver_phone':
            $sql .= " AND u.user_phone1 LIKE :keyword";
            $params[':keyword'] = '%' . $search_keyword . '%';
            break;
        case 'reservation_id':
            $sql .= " AND r.uniq_id = :keyword";
            $params[':keyword'] = $search_keyword;
            break;
    }
}

// 날짜 조건 추가
if (isset($start_date) && $start_date !== '' && isset($end_date) && $end_date !== '') {
    if ($date_type == 'use_date') {
        $sql .= " AND DATE(r.reservation_date) BETWEEN :start_date AND :end_date";
    } else if ($date_type == 'request_date') {
        $sql .= " AND DATE(r.reservation_applied_at) BETWEEN :start_date AND :end_date";
    }
    $params[':start_date'] = $start_date;
    $params[':end_date'] = $end_date;
}

// 예약 상태 조건 추가
if (isset($status) && $status !== '' && $status != 'all') {
    $sql .= " AND r.reservation_status = :status";
    $params[':status'] = $status;
}

// 정비소 조건 추가
if (isset($store_id) && $store_id !== '' && $store_id != 'all') {
    $sql .= " AND r.reservation_store_uniq_id = :store_id";
    $params[':store_id'] = $store_id;
}

// 정렬 조건 추가
$sql .= " ORDER BY r.created_at DESC";

// 페이지당 표시 개수 제한
if (isset($per_page) && $per_page !== '') {
    $sql .= " LIMIT :per_page";
    $params[':per_page'] = (int)$per_page;
}

// 쿼리 실행
$binding = binding_sql(0, $sql, $params);
$result = egb_sql($binding);

// 그룹 단위로 첫 번째 레코드만 남기기
$filtered = [];
$seenGroups = [];

foreach ($result[0] as $row) {
    $gid = $row['reservation_group_uniq_id'];

    // 그룹ID가 비어있지 않을 때만 중복 체크
    if ($gid !== null && $gid !== '') {
        if (isset($seenGroups[$gid])) {
            continue;
        }
        $seenGroups[$gid] = true;
    }

    $filtered[] = $row;
}

// 응답에 할당
$response = [
    'success' => true,
    'successCode' => 25,
    'data' => $filtered,
];

echo json_encode($response);

?>