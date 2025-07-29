<?php
function egb_send_push_event_pusher($meta, $channel, $event, $data) {
    $app_id  = $meta['app_id'] ?? null;
    $key     = $meta['key'] ?? null;
    $secret  = $meta['secret'] ?? null;
    $cluster = $meta['cluster'] ?? 'ap3';

    if (!$app_id || !$key || !$secret) {
        error_log("[Pusher] 메타데이터 누락");
        return false;
    }

    if (!is_string($data)) {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        if (json_last_error() !== JSON_ERROR_NONE || $data === null) {
            error_log("[Pusher] 데이터 JSON 변환 실패: " . json_last_error_msg());
            return false;
        }
    }

    $body = json_encode([
        'name'     => $event,
        'data'     => $data,
        'channels' => [$channel],
    ]);
    
    if (json_last_error() !== JSON_ERROR_NONE || $body === null) {
        error_log("[Pusher] body JSON 변환 실패: " . json_last_error_msg());
        return false;
    }
    
    $body_md5 = md5($body);

    $timestamp = time();
    $params = [
        'auth_key'       => $key,
        'auth_timestamp' => $timestamp,
        'auth_version'   => '1.0',
        'body_md5'       => $body_md5,
    ];
    ksort($params);
    $query_string = http_build_query($params);
    $string_to_sign = "POST\n/apps/{$app_id}/events\n{$query_string}";
    $signature = hash_hmac('sha256', $string_to_sign, $secret);

    $url = "https://api-{$cluster}.pusher.com/apps/{$app_id}/events?{$query_string}&auth_signature={$signature}";

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => $body,
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_err = curl_error($ch);
    curl_close($ch);

    if ($response === false) {
        error_log("[Pusher] CURL 실패: {$curl_err}");
        return false;
    }

    if ($http_code === 202) {
        return true;
    }

    error_log("[Pusher] 실패 - HTTP {$http_code}: {$response}");
    return false;
}

?>
