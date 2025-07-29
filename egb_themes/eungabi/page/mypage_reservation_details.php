<?php
require_once ROOT.THEMES_PATH.DS.'page'.DS.'mypage_menu.php';

// 로그인 유저 정보
$user_uniq_id = $_SESSION['user_uniq_id'] ?? null;

// 예약 데이터 조회 (마이페이지용)
$reservation_list = [];
if ($user_uniq_id) {
    $query = "
        SELECT 
            r.uniq_id,
            r.reservation_date,
            r.reservation_time,
            r.reservation_status AS status,
            r.reservation_store_uniq_id,
            r.reservation_data,
            r.reservation_group_uniq_id,
            s.store_name
        FROM egb_reservation r
        LEFT JOIN egb_store s ON r.reservation_store_uniq_id = s.uniq_id
        WHERE r.is_status = 1 AND r.reservation_user_uniq_id = :user_id
        ORDER BY r.created_at DESC
        LIMIT 30
    ";
    $binding = binding_sql(0, $query, [':user_id' => $user_uniq_id]);
    $result = egb_sql($binding);
    $reservation_list = $result[0] ?? [];
}

// 그룹 단위로 첫 번째 예약만 남기기 + 시간 범위 계산
$filtered = [];
$seenGroups = [];
$grouped = [];
foreach ($reservation_list as $row) {
    $gid = $row['reservation_group_uniq_id'] ?? null;
    if ($gid !== null && $gid !== '') {
        $grouped[$gid][] = $row;
    } else {
        $filtered[] = $row;
    }
}
foreach ($grouped as $gid => $rows) {
    // 시작/종료 시간 계산
    $times = array_column($rows, 'reservation_time');
    sort($times);
    $start = $times[0];
    $end = date('H:i:s', strtotime(end($times)) + 3600); // 마지막 예약 +1시간
    $date = $rows[0]['reservation_date'];
    $hours = count($rows);
    $row = $rows[0];
    $row['__time_range'] = $date . ' ' . substr($start,0,5) . ' ~ ' . substr($end,0,5) . " ({$hours}시간)";
    $filtered[] = $row;
}
// 그룹 없는 예약은 기존처럼 1시간 표시
foreach ($filtered as &$row) {
    if (!isset($row['__time_range'])) {
        $reservation_data = json_decode($row['reservation_data'], true);
        $estimated_time = isset($reservation_data['estimated_time']) ? (int)$reservation_data['estimated_time'] : 1;
        $row['__time_range'] = $row['reservation_date'] . ' ' . substr($row['reservation_time'],0,5) . " ({$estimated_time}시간)";
    }
}
unset($row);
$reservation_list = $filtered;

// 상태 텍스트/색상 매핑
function get_reservation_status($status) {
    switch ($status) {
        case 0: return ['취소', '#ff0000aa'];
        case 1: return ['신청', '#15376b'];
        case 2: return ['확정', '#007bff'];
        case 3: return ['완료', '#6c757d'];
        case 4: return ['노쇼', '#ff5722'];
        default: return ['-', '#888888'];
    }
}

// 9개만 표시
$display_list = array_slice($reservation_list, 0, 9);
$has_more = count($reservation_list) > 9;
?>

<div class="width_box">
    <div class="width_px_1220 margin_x_auto">
        <?php if (!empty($display_list)): ?>
        <div class="width_box display_block overflow_auto padding_px-y_030">
            <table class="width_box font_px_016" style="border-collapse:collapse;">
                <thead>
                    <tr>
                        <th class="padding_px-a_010 border_px-b_001 text_align_left" data-bd-b-color="#dadce0" data-color="#333333">예약번호</th>
                        <th class="padding_px-a_010 border_px-b_001 text_align_left" data-bd-b-color="#dadce0" data-color="#333333">예약일시</th>
                        <th class="padding_px-a_010 border_px-b_001 text_align_left" data-bd-b-color="#dadce0" data-color="#333333">정비소명</th>
                        <th class="padding_px-a_010 border_px-b_001 text_align_left" data-bd-b-color="#dadce0" data-color="#333333">예약상태</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($display_list as $res): 
                        $status_info = get_reservation_status($res['status']);
                    ?>
                    <tr>
                        <td class="padding_px-a_010 border_px-b_001 text_align_left" data-bd-b-color="#f0f0f0"><?php echo htmlspecialchars($res['uniq_id']); ?></td>
                        <td class="padding_px-a_010 border_px-b_001 text_align_left" data-bd-b-color="#f0f0f0"><?php echo htmlspecialchars($res['__time_range']); ?></td>
                        <td class="padding_px-a_010 border_px-b_001 text_align_left" data-bd-b-color="#f0f0f0"><?php echo htmlspecialchars($res['store_name']); ?></td>
                        <td class="padding_px-a_010 border_px-b_001 text_align_left" data-bd-b-color="#f0f0f0">
                            <span class="display_inline_block min_width_px_060 border_bre-a_010 padding_px-x_010 padding_px-y_005 font_px_014" data-bg-color="<?php echo $status_info[1]; ?>" data-color="#fff" data-bd-a-color="<?php echo $status_info[1]; ?>">
                                <?php echo $status_info[0]; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($has_more): ?>
        <div class="width_box text_align_center padding_px-y_020">
            <a href="/page/mypage_reservation_details" class="width_box margin_px-x_010">
                <div class="flex_xc_yc width_box padding_px-x_020 padding_px-y_010 border_bre-a_005 border_px-a_001 pointer" data-bd-a-color="#dadce0">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 1V13" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M13 7L1 7" stroke="#292D32" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    <span class="padding_px-x_010 padding_px-y_010 font_px_016 flv6" data-color="#292D32">더보기</span>
                </div>
            </a>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
            <div class="width_box font_px_018 flv6 text_align_center padding_px-a_040" data-color="#999999">
                예약 내역이 없습니다.
            </div>
        <?php endif; ?>
    </div>
</div> 