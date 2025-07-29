?



<?php
require_once ROOT . DS . 'egb_library' . DS . 'phpspreadsheet' . DS . 'vendor' . DS . 'autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

try {
    header_remove();
    ini_set('display_errors', 0);
    error_reporting(0);

    // 검색 파라미터 가져오기
    $search_type = egb('search_type');
    $search_keyword = egb('search_keyword');
    $date_type = egb('reservation_date_type');
    $start_date = egb('reservation_start_date');
    $end_date = egb('reservation_end_date');
    $status = egb('reservation_status');
    $store_id = egb('store_id');
    $total_count = egb('total_count');

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

    // 전체 데이터 가져오기
    if (isset($total_count) && $total_count !== '') {
        $sql .= " LIMIT :total_count";
        $params[':total_count'] = (int)$total_count;
    }

    // 쿼리 실행
    $binding = binding_sql(0, $sql, $params);
    $result = egb_sql($binding);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // 헤더 설정
    $headers = [
        'status' => '상태',
        'user_name' => '예약자',
        'user_phone' => '전화번호', 
        'reservation_group_uniq_id' => '예약번호',
        'reservation_date' => '이용일시',
        'store_name' => '예약',
        'reservation_applied_at' => '신청일시',
        'reservation_confirmed_at' => '확정일시',
        'reservation_completed_at' => '완료일시',
        'reservation_canceled_at' => '취소일시',
        'reservation_no_show_at' => '노쇼일시'
    ];

    // 컬럼 너비 설정
    $sheet->getColumnDimension('A')->setWidth(6); // 상태
    $sheet->getColumnDimension('B')->setWidth(8); // 예약자
    $sheet->getColumnDimension('C')->setWidth(13); // 전화번호
    $sheet->getColumnDimension('D')->setWidth(15); // 예약번호
    $sheet->getColumnDimension('E')->setWidth(33); // 이용일시
    $sheet->getColumnDimension('F')->setWidth(20); // 예약
    $sheet->getColumnDimension('G')->setWidth(23); // 신청일시
    $sheet->getColumnDimension('H')->setWidth(23); // 확정일시
    $sheet->getColumnDimension('I')->setWidth(23); // 완료일시
    $sheet->getColumnDimension('J')->setWidth(23); // 취소일시
    $sheet->getColumnDimension('K')->setWidth(23); // 노쇼일시

    $col = 'A';
    foreach ($headers as $key => $value) {
        $sheet->setCellValue($col . '1', $value);
        $sheet->getStyle($col . '1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('BDD7EE');
        $col++;
    }

    // 데이터 입력
    if ($result && is_array($result) && isset($result[0])) {
        $row = 2;
        foreach ($result[0] as $data) {
            $col = 'A';
            foreach ($headers as $key => $value) {
                $cellValue = '';
                
                if ($key == 'status') {
                    switch($data[$key]) {
                        case '0': $cellValue = '취소'; break;
                        case '1': $cellValue = '신청'; break;
                        case '2': $cellValue = '확정'; break;
                        case '3': $cellValue = '완료'; break;
                        case '4': $cellValue = '노쇼'; break;
                        default: $cellValue = '-'; break;
                    }
                } else if ($key == 'reservation_date') {
                    $date = new DateTime($data['reservation_date']);
                    $time = new DateTime($data['reservation_time']);
                    
                    $reservation_data = json_decode($data['reservation_data'], true);
                    $duration = isset($reservation_data['estimated_time']) ? intval($reservation_data['estimated_time']) : 2;
                    
                    $endTime = clone $time;
                    $endTime->modify('+' . $duration . ' hours');
                    
                    $weekday = ['일', '월', '화', '수', '목', '금', '토'][$date->format('w')];
                    
                    $cellValue = $date->format('y.m.d') . '(' . $weekday . ') ' . 
                                $time->format('H:i') . ' ~ ' . 
                                $endTime->format('H:i') . ' (' . $duration . '시간)';
                } else if (strpos($key, '_at') !== false && !empty($data[$key])) {
                    $datetime = new DateTime($data[$key]);
                    $weekday = ['일', '월', '화', '수', '목', '금', '토'][$datetime->format('w')];
                    $ampm = (int)$datetime->format('H') < 12 ? '오전' : '오후';
                    $cellValue = $datetime->format('y.m.d') . '(' . $weekday . ') ' . $ampm . ' ' . $datetime->format('h:i');
                } else if (in_array($key, ['car_model', 'car_model_year', 'car_number', 'car_mileage', 'car_type', 'car_product_check', 'title', 'contents'])) {
                    $reservation_data = json_decode($data['reservation_data'], true);
                    $cellValue = isset($reservation_data[$key]) ? $reservation_data[$key] : '-';
                } else {
                    $cellValue = $data[$key] ?? '-';
                }
                
                $sheet->setCellValue($col . $row, $cellValue);
                $col++;
            }
            $row++;
        }
    }

    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="reservation_list.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

} catch (Exception $e) {
    if (ob_get_length()) {
        ob_end_clean();
    }
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'failureCode' => 171]);
    exit;
}
?>