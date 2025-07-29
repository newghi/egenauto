<?php

function egb_font()
{
    // font, font2, font3 파라미터 확인
    $font = basename(egb('font'));
    $font2 = egb('font2');
    $font3 = basename(egb('font3'));

    $exts = ['woff2', 'woff', 'ttf', 'otf', 'eot'];

    if ($font) {
        // font 파라미터가 있는 경우 egb_font 디렉토리 검색
        $real_dir = ROOT . DS . 'egb_font';
        foreach ($exts as $ext) {
            $full_path = $real_dir . DS . $font . '.' . $ext;
            if (is_file($full_path)) {
                $proxy_url = "/proxy/font/{$font}.{$ext}";
                header("Location: $proxy_url", true, 302);
                exit;
            }
        }
    } else if ($font2) {
        // font2 파라미터가 있는 경우 테마 디렉토리 검색
        $theme = defined('THEMES_NAME') ? THEMES_NAME : 'eungabi';
        $real_dir = ROOT . DS . 'egb_themes' . DS . $theme . DS . 'font';
        foreach ($exts as $ext) {
            $full_path = $real_dir . DS . str_replace('/', DS, $font2) . '.' . $ext;
            if (is_file($full_path)) {
                $proxy_url = "/proxy/font2/{$font2}.{$ext}";
                header("Location: $proxy_url", true, 302);
                exit;
            }
        }
    } else if ($font3) {
        // font3 파라미터가 있는 경우 리소스 맵핑 테이블에서 검색
        $query = "SELECT resource_path, resource_extension FROM egb_resource_map 
                 WHERE uniq_id = :uniq_id AND resource_type = :resource_type AND is_status = 1";
        $param = [':uniq_id' => $font3, ':resource_type' => 'font'];
        $binding = binding_sql(1, $query, $param);
        $sql = egb_sql($binding);

        if ($sql && !empty($sql)) {
            $resource = $sql[0];
            if (isset($resource['resource_path']) && isset($resource['resource_extension'])) {
                $full_path = ROOT . $resource['resource_path'];
                if (is_file($full_path)) {
                    $proxy_url = "/proxy/font3/{$font3}.{$resource['resource_extension']}";
                    header("Location: $proxy_url", true, 302);
                    exit;
                }
            }
        }
    }
}
?>
