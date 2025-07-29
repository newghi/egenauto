

<?php
function egb_img_resize($source_path, $target_width, $quality = 85)
{
    // 이미 리사이즈된 파일이면 처리 안 함
    if (preg_match('/_rw\d+$/', pathinfo($source_path, PATHINFO_FILENAME))) {
        return false;
    }

    if (!extension_loaded('gd') || !is_file($source_path)) {
        return false;
    }

    list($width, $height, $type) = getimagesize($source_path);
    if (!$width || !$height || !$target_width || $target_width > $width) {
        return false;
    }

    // 원본 이미지 로드
    switch ($type) {
        case IMAGETYPE_JPEG:
            $src = imagecreatefromjpeg($source_path);
            $has_alpha = false;
            break;
        case IMAGETYPE_PNG:
            $src = imagecreatefrompng($source_path);
            $has_alpha = true;
            break;
        case IMAGETYPE_GIF:
            $src = imagecreatefromgif($source_path);
            $has_alpha = true;
            break;
        case IMAGETYPE_WEBP:
            if (!function_exists('imagecreatefromwebp')) {
                return false;
            }
            $src = imagecreatefromwebp($source_path);
            $has_alpha = true;
            break;
        default:
            return false;
    }

    if (!$src) {
        return false;
    }

    // 타겟 캔버스 생성
    $target_height = (int)(($target_width / $width) * $height);
    $dst = imagecreatetruecolor($target_width, $target_height);
    if (!$dst) {
        imagedestroy($src);
        return false;
    }

    // 투명도 처리
    if ($has_alpha) {
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
    }

    imagecopyresampled(
        $dst, $src,
        0, 0, 0, 0,
        $target_width, $target_height,
        $width, $height
    );

    $info = pathinfo($source_path);
    
    // img 경로에서 themes/테마명/img 이후의 경로만 추출
    $path_parts = explode('img' . DS, $source_path);
    if (count($path_parts) > 1) {
        // img2의 경우 - img 디렉토리 이후의 경로를 사용
        $relative_path = str_replace(DS, '/', pathinfo($path_parts[1], PATHINFO_DIRNAME));
        $filename = ($relative_path ? $relative_path . '/' : '') . $info['filename'];
    } else {
        // img3의 경우 - 파일명만 사용 (유니크 아이디)
        $filename = $info['filename'];
    }
    
    $resized_filename = $filename . "_rw{$target_width}";
    $dir = $info['dirname'];

    // 1) WebP 시도
    if (function_exists('imagewebp')) {
        $out = "{$dir}/{$info['filename']}_rw{$target_width}.webp";
        if (imagewebp($dst, $out, $quality)) {
            imagedestroy($src);
            imagedestroy($dst);
            return $resized_filename . '.webp';
        }
    }

    // 2) PNG / JPG fallback
    if ($has_alpha) {
        // quality 100→9, 90→8, … 매핑
        $png_level = max(0, min(9, intval($quality / 10) - 1));
        $out = "{$dir}/{$info['filename']}_rw{$target_width}.png";
        if (imagepng($dst, $out, $png_level)) {
            imagedestroy($src);
            imagedestroy($dst);
            return $resized_filename . '.png';
        }
    } else {
        $out = "{$dir}/{$info['filename']}_rw{$target_width}.jpg";
        if (imagejpeg($dst, $out, $quality)) {
            imagedestroy($src);
            imagedestroy($dst);
            return $resized_filename . '.jpg';
        }
    }

    // 최종 해제
    imagedestroy($src);
    imagedestroy($dst);
    return false;
}
?>