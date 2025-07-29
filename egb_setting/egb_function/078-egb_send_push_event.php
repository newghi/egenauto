
<?php
function egb_send_push_event($channel, $event, $data) {
    $query = "SELECT uniq_id, api_service_name, api_metadata 
              FROM egb_api_management
              WHERE api_service_type = 'push'
              AND is_status = 1 
              AND deleted_at IS NULL
              ORDER BY created_at ASC";

    $result = egb_sql(binding_sql(0, $query, []));
    if (empty($result[0])) {
        error_log("[Push] 사용 가능한 API가 없습니다.");
        return false;
    }

    foreach ($result[0] as $row) {
        $service = $row['api_service_name'];
        $uniq_id = $row['uniq_id'];

        $meta_json = $row['api_metadata'] ?? '';
        $meta = json_decode($meta_json, true);

        if (json_last_error() !== JSON_ERROR_NONE || !$meta) {
            error_log("[Push] {$service} 메타데이터 파싱 오류: " . json_last_error_msg());
            error_log("[Push] 원본 JSON: " . print_r($meta_json, true));
            continue;
        }

        $success = false;
        switch ($service) {
            case 'ably':
                $success = egb_send_push_event_ably($meta, $channel, $event, $data);
                break;
            case 'pusher':
                $success = egb_send_push_event_pusher($meta, $channel, $event, $data);
                break;
            default:
                error_log("[Push] 지원되지 않는 서비스: {$service}");
                continue 2;
        }

        if ($success) {
            $update_query = "UPDATE egb_api_management 
                             SET api_total_usage = api_total_usage + 1 
                             WHERE uniq_id = :uniq";
            egb_sql(binding_sql(2, $update_query, [':uniq' => $uniq_id]));
            error_log("[Push] {$service} 전송 성공");
            return true;
        } else {
            error_log("[Push] {$service} 전송 실패, 다음 서비스 시도");
        }
    }

    error_log("[Push] 모든 서비스 실패");
    return false;
}

?>
