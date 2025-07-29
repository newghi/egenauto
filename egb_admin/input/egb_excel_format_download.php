<?php
require_once ROOT . DS . 'egb_library' . DS . 'phpspreadsheet' . DS . 'vendor' . DS . 'autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

try {
    header_remove();
    ini_set('display_errors', 0);
    error_reporting(0);

    $filter_table_name = egb('filter_table_name', 20);

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

    // 실제 데이터 조회 
    $query = "SELECT * FROM $filter_table_name LIMIT 1";
    $binding = binding_sql(0, $query, []);
    $data = egb_sql($binding);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $col = 'A';
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
            // 첫 번째 행에 컬럼명 추가 (파란색 배경)
            $sheet->setCellValue($col . '1', $column['COLUMN_NAME']);
            $sheet->getStyle($col . '1')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('BDD7EE');
            
            // 두 번째 행에 코멘트 추가 (연한 녹색 배경)
            $comment = $column['COLUMN_COMMENT'] ?: $column['COLUMN_NAME'];
            $sheet->setCellValue($col . '2', $comment);
            $sheet->getStyle($col . '2')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E2EFDA');

            // 실제 데이터 추가
            if(isset($data[0][0][$column['COLUMN_NAME']])) {
                $sheet->setCellValue($col . '3', $data[0][0][$column['COLUMN_NAME']]);
            } else {
                $sheet->setCellValue($col . '3', '');
            }
            
            $col++;
        }
    }

    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . rawurlencode($filter_table_name . '_format.xlsx') . '"');
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
