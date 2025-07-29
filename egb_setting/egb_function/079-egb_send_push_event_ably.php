
<?php
function egb_send_push_event_ably($meta, $channel, $event, $data) {
    $api_key = $meta['api_key'] ?? null;
    if (!$api_key) {
        error_log("[Ably] API Key가 없습니다.");
        return false;
    }

    if (!is_string($data)) {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        if (json_last_error() !== JSON_ERROR_NONE || $data === null) {
            error_log("[Ably] 데이터 JSON 변환 실패: " . json_last_error_msg());
            return false;
        }
    }

    $payload = [
        'name' => $event,
        'data' => $data,
    ];

    $payload_json = json_encode($payload);
    if (json_last_error() !== JSON_ERROR_NONE || $payload_json === null) {
        error_log("[Ably] payload JSON 변환 실패: " . json_last_error_msg());
        return false;
    }

    $url = "https://rest.ably.io/channels/{$channel}/messages";
    $headers = [
        "Content-Type: application/json",
        "Authorization: Basic " . base64_encode($api_key),
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_POSTFIELDS     => $payload_json,
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_err = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        error_log("[Ably] CURL 실패: {$curl_err}");
        return false;
    }

    if ($http_code >= 200 && $http_code < 300) {
        return true;
    }

    error_log("[Ably] 실패 - HTTP {$http_code}: {$response}");
    return false;
}

?>
