<?php

function egb_video()
{
    // video, video2, video3 파라미터 확인
    $video = basename(egb('video'));
    $video2 = egb('video2'); 
    $video3 = basename(egb('video3'));

    $exts = ['mp4', 'webm', 'ogg'];

    if ($video) {
        // video 파라미터가 있는 경우 egb_video 디렉토리 검색
        $real_dir = ROOT . DS . 'egb_video';
        foreach ($exts as $ext) {
            $full_path = $real_dir . DS . $video . '.' . $ext;
            if (is_file($full_path)) {
                $proxy_url = "/proxy/video/{$video}.{$ext}";
                header("Location: $proxy_url", true, 302);
                exit;
            }
        }
    } else if ($video2) {
        // video2 파라미터가 있는 경우 테마 디렉토리 검색
        $theme = defined('THEMES_NAME') ? THEMES_NAME : 'eungabi';
        $real_dir = ROOT . DS . 'egb_themes' . DS . $theme . DS . 'video';
        foreach ($exts as $ext) {
            $full_path = $real_dir . DS . str_replace('/', DS, $video2) . '.' . $ext;
            if (is_file($full_path)) {
                $proxy_url = "/proxy/video2/{$video2}.{$ext}";
                header("Location: $proxy_url", true, 302);
                exit;
            }
        }
    } else if ($video3) {
        // video3 파라미터가 있는 경우 리소스 맵핑 테이블에서 검색
        $query = "SELECT resource_path, resource_extension FROM egb_resource_map 
                 WHERE uniq_id = :uniq_id AND resource_type = :resource_type AND is_status = 1";
        $param = [':uniq_id' => $video3, ':resource_type' => 'video'];
        $binding = binding_sql(1, $query, $param);
        $sql = egb_sql($binding);

        if ($sql && !empty($sql)) {
            $resource = $sql[0];
            if (isset($resource['resource_path']) && isset($resource['resource_extension'])) {
                $full_path = ROOT . $resource['resource_path'];
                if (is_file($full_path)) {
                    $proxy_url = "/proxy/video3/{$video3}.{$resource['resource_extension']}";
                    header("Location: $proxy_url", true, 302);
                    exit;
                }
            }
        }
    }
}

?>
