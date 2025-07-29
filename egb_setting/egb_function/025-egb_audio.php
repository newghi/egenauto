<?php

function egb_audio()
{
    // audio, audio2, audio3 파라미터 확인
    $audio = basename(egb('audio'));
    $audio2 = egb('audio2');
    $audio3 = basename(egb('audio3'));

    $exts = ['mp3', 'wav', 'ogg', 'aac', 'flac'];

    if ($audio) {
        // audio 파라미터가 있는 경우 egb_audio 디렉토리 검색
        $real_dir = ROOT . DS . 'egb_audio';
        foreach ($exts as $ext) {
            $full_path = $real_dir . DS . $audio . '.' . $ext;
            if (is_file($full_path)) {
                $proxy_url = "/proxy/audio/{$audio}.{$ext}";
                header("Location: $proxy_url", true, 302);
                exit;
            }
        }
    } else if ($audio2) {
        // audio2 파라미터가 있는 경우 테마 디렉토리 검색
        $theme = defined('THEMES_NAME') ? THEMES_NAME : 'eungabi';
        $real_dir = ROOT . DS . 'egb_themes' . DS . $theme . DS . 'audio';
        foreach ($exts as $ext) {
            $full_path = $real_dir . DS . str_replace('/', DS, $audio2) . '.' . $ext;
            if (is_file($full_path)) {
                $proxy_url = "/proxy/audio2/{$audio2}.{$ext}";
                header("Location: $proxy_url", true, 302);
                exit;
            }
        }
    } else if ($audio3) {
        // audio3 파라미터가 있는 경우 리소스 맵핑 테이블에서 검색
        $query = "SELECT resource_path, resource_extension FROM egb_resource_map 
                 WHERE uniq_id = :uniq_id AND resource_type = :resource_type AND is_status = 1";
        $param = [':uniq_id' => $audio3, ':resource_type' => 'audio'];
        $binding = binding_sql(1, $query, $param);
        $sql = egb_sql($binding);

        if ($sql && !empty($sql)) {
            $resource = $sql[0];
            if (isset($resource['resource_path']) && isset($resource['resource_extension'])) {
                $full_path = ROOT . $resource['resource_path'];
                if (is_file($full_path)) {
                    $proxy_url = "/proxy/audio3/{$audio3}.{$resource['resource_extension']}";
                    header("Location: $proxy_url", true, 302);
                    exit;
                }
            }
        }
    }
}

?>
