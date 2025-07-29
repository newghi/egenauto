



<?php

function egb_img()
{
    // img, img2, img3 파라미터 확인
    $img = basename(egb('img')); 
    $img2 = egb('img2');
    $img3 = basename(egb('img3'));
    $width = (int)egb('rw');

    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    $prefer_webp = strpos($accept, 'image/webp') !== false;

    $exts = $prefer_webp
        ? ['webp', 'jpg', 'jpeg', 'png', 'gif', 'svg']
        : ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'];

    if ($img) {
        // img 파라미터가 있는 경우 egb_img 디렉토리 검색
        $real_dir = ROOT . DS . 'egb_img';
        foreach ($exts as $ext) {
            $full_path = $real_dir . DS . $img . '.' . $ext;
            if (is_file($full_path)) {
                if ($width > 0) {
                    $resized = egb_img_resize($full_path, $width);
                    if ($resized) {
                        $proxy_url = "/proxy/img/{$resized}";
                        header("Location: $proxy_url", true, 302);
                        exit;
                    }
                }
                $proxy_url = "/proxy/img/{$img}.{$ext}";
                header("Location: $proxy_url", true, 302);
                exit;
            }
        }
    } else if ($img2) {
        // img2 파라미터가 있는 경우 테마 디렉토리 검색
        $theme = defined('THEMES_NAME') ? THEMES_NAME : 'eungabi';
        $real_dir = ROOT . DS . 'egb_themes' . DS . $theme . DS . 'img';
        foreach ($exts as $ext) {
            $full_path = $real_dir . DS . str_replace('/', DS, $img2) . '.' . $ext;
            if (is_file($full_path)) {
                if ($width > 0) {
                    $resized = egb_img_resize($full_path, $width);
                    if ($resized) {
                        $proxy_url = "/proxy/img2/{$resized}";
                        header("Location: $proxy_url", true, 302);
                        exit;
                    }
                }
                header("Location: /proxy/img2/{$img2}.{$ext}", true, 302);
                exit;
            }
        }
    } else if ($img3) {
        // img3 파라미터가 있는 경우 리소스 맵핑 테이블에서 검색
        $query = "SELECT resource_path, resource_name, resource_extension FROM egb_resource_map 
                 WHERE uniq_id = :uniq_id AND resource_type = :resource_type AND is_status = 1";
        $param = [':uniq_id' => $img3, ':resource_type' => 'img'];
        $binding = binding_sql(1, $query, $param);
        $sql = egb_sql($binding);

        if ($sql && !empty($sql)) {
            $resource = $sql[0];
            if (isset($resource['resource_path']) && isset($resource['resource_extension'])) {
                $full_path = ROOT . $resource['resource_path'];
                
                if ($width > 0 && is_file($full_path)) {
                    $resized = egb_img_resize($full_path, $width);
                    if ($resized) {
                        $proxy_url = "/proxy/img3/{$resized}";
                        header("Location: $proxy_url", true, 302);
                        exit;
                    }
                }

                // 저장된 리소스 이름을 그대로 사용 (이미 width, height 정보 포함)
                if ($width) {
                    $proxy_url = "/proxy/img3/{$img3}_rw{$width}.{$resource['resource_extension']}";
                } else {
                    $proxy_url = "/proxy/img3/{$resource['resource_name']}";
                }
                
                if (!defined('EGB_PERFORMANCE_OPTIMIZATION_MODE') || !EGB_PERFORMANCE_OPTIMIZATION_MODE) {
                    if (!is_file($full_path)) {
                        http_response_code(404);
                        return;
                    }
                }
                header("Location: $proxy_url", true, 302);
                exit;
            }
        }
    }
}

?>
