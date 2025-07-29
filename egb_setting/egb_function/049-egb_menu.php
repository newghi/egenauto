<?php
function egb_menu($group_uniq_id) {
    // SQL 쿼리: group_uniq_id를 기준으로 메뉴 세부 정보를 가져옵니다.
    $query = "
    SELECT * 
    FROM egb_menu 
    WHERE group_uniq_id = :group_uniq_id AND is_status = 1
    ORDER BY display_order ASC
    ";
    $params = [':group_uniq_id' => $group_uniq_id];
    $binding = binding_sql(0, $query, $params);
    $result = egb_sql($binding);

    return $result[0] ?? []; // 결과가 있으면 메뉴 목록, 없으면 빈 배열 반환
}

?>