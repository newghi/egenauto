<?php
function egb_api_management_insert(
    $api_service_name,
    $api_service_description,
    $api_service_type,
    $api_metadata = []
) {
    // 내부에서 고유 ID 및 생성자 설정
    $uniq_id = uniqid();
    $created_by = 'system';

    $query = "
        INSERT INTO egb_api_management (
            uniq_id,
            api_service_name,
            api_service_description,
            api_service_type,
            api_per_second_usage,
            api_per_minute_usage, 
            api_hourly_usage,
            api_daily_usage,
            api_monthly_usage,
            api_annual_usage,
            api_per_second_limit,
            api_per_minute_limit,
            api_hourly_limit,
            api_daily_limit,
            api_monthly_limit,
            api_annual_limit,
            api_total_usage,
            api_metadata,
            created_by
        ) VALUES (
            :uniq_id,
            :api_service_name,
            :api_service_description,
            :api_service_type,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            :api_metadata,
            :created_by
        )
    ";

    $params = [
        ':uniq_id' => $uniq_id,
        ':api_service_name' => $api_service_name,
        ':api_service_description' => $api_service_description,
        ':api_service_type' => $api_service_type,
        ':api_metadata' => json_encode($api_metadata),
        ':created_by' => $created_by
    ];

    $binding = binding_sql(2, $query, $params);
    $sql = egb_sql($binding);

    // 성공 여부를 boolean으로 반환
    return isset($sql[0]);
}
?>
