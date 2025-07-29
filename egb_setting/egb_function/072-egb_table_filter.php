<?php
function egb_table_filter($params_or_code = [], $maybe_code = null) {
    // 1) 인자 구분
    if (is_array($params_or_code)) {
        $params       = $params_or_code;
        $success_code = $maybe_code;
    } else {
        $params       = [];
        $success_code = $params_or_code;
    }

    // 2) egb() 초기화: GET/POST/JSON → $GLOBALS['_EGB']
    egb('__init__');

    // 3) 기존 egb 파라미터 위에 $params 덮어쓰기 (params 우선)
    $GLOBALS['_EGB'] = array_merge(
        $GLOBALS['_EGB'] ?? [],
        $params
    );

    // 4) superglobal 차단 플래그 설정 (인덱스 차단 로직 우회용)
    $_GET     = ['__BLOCKED__' => true];
    $_POST    = ['__BLOCKED__' => true];
    $_REQUEST = ['__BLOCKED__' => true];

    // 5) 테이블명
    $table_name = egb('table_name');
    if (!$table_name) {
        return false;
    }

    // 6) 컬럼 목록 캐싱
    static $columns_cache = [];
    if (isset($columns_cache[$table_name])) {
        $columns = $columns_cache[$table_name];
    } else {
        $q1 = "
            SELECT COLUMN_NAME
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = :table_name
        ";
        $b1 = binding_sql(0, $q1, [':table_name' => $table_name]);
        $r1 = egb_sql($b1);
        if (!isset($r1[0]) || !count($r1[0])) {
            return false;
        }
        $columns = array_column($r1[0], 'COLUMN_NAME');
        $columns_cache[$table_name] = $columns;
    }

    // 7) 조회 필드 제한 (fields 파라미터)
    $fields_csv = egb('fields');  // e.g. "col1,col2"
    if ($fields_csv) {
        $req = array_map('trim', explode(',', $fields_csv));
        $select_list = array_values(array_intersect($req, $columns));
        if (empty($select_list)) {
            return false;
        }
    } else {
        $select_list = $columns;
    }

    // 8) WHERE 절 구성
    $where   = [];
    $params2 = [];
    foreach ($columns as $col) {
        $val = egb($col);
        if ($val !== null && $val !== '') {
            $where[]          = "`$col` = :$col";
            $params2[":$col"] = $val;
        }
    }
    $where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    // 9) SELECT 구문
    $select_sql = implode(', ', array_map(fn($c)=>"`$c`", $select_list));

    // 10) 정렬 처리 (기본 no DESC)
    $sort_column    = egb('sort_column');
    $sort_direction = strtolower(egb('sort_direction'));
    if ($sort_column && in_array($sort_column, $columns)) {
        $dir     = in_array($sort_direction, ['asc','desc']) ? $sort_direction : 'asc';
        $order_by = "ORDER BY `$sort_column` $dir";
    } else {
        $order_by = "ORDER BY `no` DESC";
    }

    // 11) 페이징 처리
    $limit  = egb('limit');
    $offset = egb('offset');
    $limit_clause = '';
    if (is_numeric($limit) && $limit > 0) {
        $limit_clause = "LIMIT " . intval($limit);
        if (is_numeric($offset) && $offset >= 0) {
            $limit_clause .= " OFFSET " . intval($offset);
        }
    }
    $current_page = ($limit && is_numeric($offset))
        ? intval(floor($offset / $limit)) + 1
        : 1;

    // 12) 단건/다건 제어
    $is_single = ((int)egb('is_single') === 1);

    // 13) 데이터 조회
    $q2 = "
        SELECT $select_sql
        FROM `$table_name`
        $where_sql
        $order_by
        $limit_clause
    ";
    $b2 = binding_sql($is_single ? 1 : 0, $q2, $params2);

    // 14) 통계 조회
    $q3 = "
        SELECT
            record_total_count,
            record_active_count,
            record_inactive_count,
            record_soft_deleted_count,
            record_hard_deleted_count
        FROM egb_record_count
        WHERE record_table_name = :table_name
    ";
    $b3 = binding_sql(1, $q3, [':table_name' => $table_name]);

    // 15) 실행
    $res = egb_sql($b2, $b3);
    if (!isset($res[0], $res[1])) {
        return false;
    }

    // 16) 결과 정리
    $rows = $res[0];
    if ($is_single) {
        $rows = $rows ? [$rows] : [];
    }
    $stats = $res[1];
    $total = intval($stats['record_total_count'] ?? 0);
    $total_pages = ($limit > 0)
        ? intval(ceil($total / $limit))
        : 1;

    return [
        'success'                  => true,
        'successCode'              => $success_code,
        'rows'                     => $rows,
        'record_total_count'       => $total,
        'record_active_count'      => $stats['record_active_count']   ?? 0,
        'record_inactive_count'    => $stats['record_inactive_count'] ?? 0,
        'record_soft_deleted_count'=> $stats['record_soft_deleted_count'] ?? 0,
        'record_hard_deleted_count'=> $stats['record_hard_deleted_count'] ?? 0,
        'current_page'             => $current_page,
        'limit'                    => $limit,
        'offset'                   => $offset,
        'total_pages'              => $total_pages
    ];
}
?>