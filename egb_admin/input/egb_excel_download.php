<?php
require_once ROOT . DS . 'egb_library' . DS . 'phpspreadsheet' . DS . 'vendor' . DS . 'autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

try {
    header_remove();
    ini_set('display_errors', 0);
    error_reporting(0);

    $filter_table_name = egb('filter_table_name', 22);
    $page_name = egb('filter_page_name');
    $menu_name = egb('filter_menu_name');
    // 필터 값들 가져오기
    $page = egb('filter_page');
    $perPage = egb('filter_per_page');
    $order = egb('filter_order');
    $is_status = egb('filter_is_status');
    $searchKeyword = egb('filter_search_input');
    $isDetailFilterActive = egb('detail_filter_active');

    // 테이블 컬럼 설정 조회
    $query = "SELECT column_config_data_json FROM egb_table_column_config 
             WHERE column_config_table_name = :table_name 
             AND column_config_user_uniq_id IS NULL
             AND deleted_at IS NULL
             ORDER BY created_at DESC LIMIT 1";
    $binding = binding_sql(1, $query, [':table_name' => $filter_table_name]);
    $result = egb_sql($binding);

    if(!empty($result)) {
        $columns = json_decode($result[0]['column_config_data_json'], true);
    }

    // 순서대로 정렬
    usort($columns, function($a, $b) {
        return $a['order'] - $b['order'];
    });

    // 보이는 컬럼만 필터링
    $visibleColumns = array_filter($columns, function($col) {
        return isset($col['visible']) && $col['visible'] == 1;
    });

    // 실제 데이터 조회
    $select_columns = array_map(function($col) {
        return $col['name'];
    }, $visibleColumns);
    
    $select_columns_str = implode(',', $select_columns);
    $query = "SELECT $select_columns_str FROM " . $filter_table_name;
    $params = [];

    // is_status가 1 또는 2가 아닌 경우 기본값 99로 설정
    if (!in_array($is_status, [1, 2])) {
        $is_status = 99;
    }
    // 삭제된 데이터 필터링
    if ($is_status == 2) {
        $query .= " WHERE deleted_at IS NOT NULL";
    } else {
        $query .= " WHERE deleted_at IS NULL";
    }

    // 상태 필터 적용
    if ($is_status != 99) { // 99는 전체를 의미
        $query .= " AND is_status = :is_status";
        $params[':is_status'] = $is_status;
    } 

    // 검색어와 디테일 필터 처리
    if (!$isDetailFilterActive && !empty($searchKeyword)) {
        $searchConditions = [];
        $searchCount = 1;
        foreach ($columns as $config) {
            if (isset($config['keyword_filter']) && $config['keyword_filter'] == 1) {
                $searchParam = ":search" . $searchCount;
                $searchConditions[] = "{$config['name']} LIKE " . $searchParam;
                $params[$searchParam] = '%' . $searchKeyword . '%';
                $searchCount++;
            }
        }
        
        if (!empty($searchConditions)) {
            $query .= " AND (" . implode(" OR ", $searchConditions) . ")";
        }
    }

    if ($isDetailFilterActive) {
        foreach ($columns as $config) {
            if ($config['detail_filter'] == 1) {
                $name = $config['name'];
                
                if ($name == 'page_name') {
                    $name = 'filter_page_name';
                }
                
                $value = egb($name);

                if ($value !== null && $value !== '') {
                    if ($config['filter_type'] == 'date') {
                        $start = egb($name . '_start');
                        $end = egb($name . '_end');
                        if ($start) {
                            $query .= " AND $name >= :{$name}_start";
                            $params[":{$name}_start"] = $start;
                        }
                        if ($end) {
                            $query .= " AND $name <= :{$name}_end";
                            $params[":{$name}_end"] = $end;
                        }
                    } else if ($config['filter_type'] == 'text') {
                        $query .= " AND $name LIKE :$name";
                        $params[":$name"] = '%' . $value . '%';
                    } else {
                        $query .= " AND $name = :$name";
                        $params[":$name"] = $value;
                    }
                }
            }
        }
    }

    // 정렬 적용
    $query .= " ORDER BY display_order ASC, created_at $order";

    // 페이지네이션 적용
    if ($perPage !== '전체') {
        $offset = ($page - 1) * intval($perPage);
        $query .= " LIMIT :limit OFFSET :offset";
        $params[':limit'] = intval($perPage);
        $params[':offset'] = $offset;
    }

    $binding = binding_sql(0, $query, $params);
    $data = egb_sql($binding);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $col = 'A';
    foreach ($visibleColumns as $column) {
        // 첫 번째 행에 컬럼명 추가 (파란색 배경)
        $sheet->setCellValue($col . '1', $column['name']);
        $sheet->getStyle($col . '1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('BDD7EE');
        
        // 두 번째 행에 코멘트 추가 (연한 녹색 배경)
        $sheet->setCellValue($col . '2', $column['comment']);
        $sheet->getStyle($col . '2')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('E2EFDA');

        $col++;
    }

    // 데이터 추가
    $row = 3;
    foreach($data[0] as $record) {
        $col = 'A';
        foreach($visibleColumns as $column) {
            $sheet->setCellValue($col . $row, $record[$column['name']]);
            $col++;
        }
        $row++;
    }

    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . rawurlencode($filter_table_name . '_data.xlsx') . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

} catch (Exception $e) {
    if (ob_get_length()) {
        ob_end_clean();
    }
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'failureCode' => 21]);
    exit;
}
?>
