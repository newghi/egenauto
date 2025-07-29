<?php
require_once ROOT . DS . 'egb_library' . DS . 'phpspreadsheet' . DS . 'vendor' . DS . 'autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

try {
    // 파일 업로드 확인
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'failureCode' => 22]);
        exit;
    }

    $filter_table_name = egb('filter_table_name', 23);

    $filter_page_name = egb('filter_page_name');
    $filter_menu_name = egb('filter_menu_name');
    $filter_page = egb('filter_page');
    $filter_perPage = egb('filter_per_page');
    $filter_order = egb('filter_order');
    $filter_is_status = egb('filter_is_status');
    $filter_search_input = egb('filter_search_input');
    $filter_user_id = egb('filter_user_id');

    // 테이블 컬럼 정보 조회
    $query = "
        SELECT COLUMN_NAME, COLUMN_COMMENT 
        FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_NAME = :table_name
        AND TABLE_SCHEMA = DATABASE()
        ORDER BY ORDINAL_POSITION
    ";
    $params = [':table_name' => $filter_table_name];
    $binding = binding_sql(0, $query, $params);
    $columns = egb_sql($binding);

    // 포맷에 사용될 컬럼 목록 생성
    $formatColumns = [];
    foreach ($columns[0] as $column) {
        if (!in_array($column['COLUMN_NAME'], [
            'no',
            'uniq_id',
            'created_at',
            'created_by', 
            'updated_at',
            'updated_by',
            'deleted_at',
            'deleted_by'
        ])) {
            $formatColumns[] = $column['COLUMN_NAME'];
        }
    }

    // 엑셀 파일 읽기
    $spreadsheet = IOFactory::load($_FILES['file']['tmp_name']);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray();

    // 첫번째 행의 컬럼명 가져오기
    $excelColumns = $data[0];

    // 포맷 검증
    foreach ($formatColumns as $formatColumn) {
        if (!in_array($formatColumn, $excelColumns)) {
            echo json_encode(['success' => false, 'failureCode' => 24]); // 포맷 불일치 에러 코드
            exit;
        }
    }

    // 테이블 컬럼 설정 조회
    $query = "SELECT column_config_data_json FROM egb_table_column_config 
             WHERE column_config_table_name = :table_name 
             AND is_status = 1 
             LIMIT 1";
    $binding = binding_sql(1, $query, [':table_name' => $filter_table_name]);
    $result = egb_sql($binding);

    if(!empty($result)) {
        $columns = json_decode($result[0]['column_config_data_json'], true);
    }
    
    // 컬럼 매핑 생성 (시스템 컬럼 제외)
    $columnMapping = [];
    foreach($columns as $index => $column) {
        if (!in_array($column['name'], [
            'no',
            'uniq_id',
            'created_at', 
            'created_by',
            'updated_at',
            'updated_by', 
            'deleted_at',
            'deleted_by'
        ])) {
            $columnIndex = array_search($column['name'], $excelColumns);
            if($columnIndex !== false) {
                $columnMapping[$columnIndex] = $column['name'];
            }
        }
    }

    // 첫번째 행은 컬럼명, 두번째 행은 코멘트이므로 제외
    $dataRows = array_slice($data, 2);

    // 데이터 삽입
    foreach($dataRows as $row) {
        $insertData = [];
        foreach($columnMapping as $excelIndex => $dbColumn) {
            if(isset($row[$excelIndex])) {
                $insertData[$dbColumn] = $row[$excelIndex];
            }
        }

        if(!empty($insertData)) {
            // 시스템 필드 추가
            $insertData['uniq_id'] = uniqid();
            $insertData['created_by'] = 'system';
            
            $fields = implode(',', array_keys($insertData));
            $placeholders = array_map(function($key) {
                return ':' . $key;
            }, array_keys($insertData));
            $values = implode(',', $placeholders);
            
            $query = "INSERT INTO $filter_table_name ($fields) VALUES ($values)";
            $params = array_combine($placeholders, array_values($insertData));
            $binding = binding_sql(2, $query, $params);
            egb_sql($binding);

            // 레코드 카운트 증가
            increase_record_total_count($filter_table_name);
            increase_record_active_count($filter_table_name);
        }
    }

    echo json_encode([
        'success' => true,
        'successCode' => 4,
        'filter_page_name' => $filter_page_name,
        'filter_menu_name' => $filter_menu_name,
        'filter_page' => $filter_page,
        'filter_per_page' => $filter_perPage,
        'filter_order' => $filter_order,
        'filter_is_status' => $filter_is_status,
        'filter_search_input' => $filter_search_input,
        'filter_user_id' => $filter_user_id,
        'filter_table_name' => $filter_table_name
    ]);
    exit;

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'failureCode' => 25]);
    exit;
}
?>
