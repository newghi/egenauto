



<?php
function egb_resource($uniq_id = null, $file_key = 'file') {
    try {
        if (!isset($_FILES[$file_key])) {
            error_log("[egb_resource_save] 파일이 업로드되지 않았습니다.");
            return false;
        }

        $file = $_FILES[$file_key];
        $created_by = $_POST['created_by'] ?? 'system';

        $save_dir = ROOT . DS . 'egb_setting' . DS . 'egb_resource';
        if (!is_dir($save_dir) && !mkdir($save_dir, 0755, true)) {
            error_log("[egb_resource_save] 디렉토리 생성 실패: " . $save_dir);
            return false;
        }

        $original_name = $file['name'];
        $tmp_name = $file['tmp_name'];
        $size = $file['size'];

        if (!file_exists($tmp_name)) {
            error_log("[egb_resource_save] 임시 파일이 존재하지 않습니다: " . $tmp_name);
            return false;
        }

        $mime = mime_content_type($tmp_name);
        if ($mime == false) {
            error_log("[egb_resource_save] MIME 타입 확인 실패");
            return false;
        }

        $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

        // 신규로 판단할 기본 조건
        $is_insert = true;

        // 유효하지 않은 기본 썸네일 경로
        $default_path = DS . 'egb_thumbnail.webp';

        if (!isset($uniq_id) && $uniq_id !== $default_path) {
            // DB에 존재하는지 확인
            $check_query = "SELECT resource_path FROM egb_resource_map WHERE uniq_id = :uniq_id";
            $check_binding = binding_sql(1, $check_query, [':uniq_id' => $uniq_id]);
            $check_result = egb_sql($check_binding);
        
            if (isset($check_result[0])) {
                $is_insert = false;
                // 기존 파일 삭제
                $old_path = ROOT . $check_result[0]['resource_path'];
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
        } else {
            // uniq_id가 없거나 기본 썸네일 경로인 경우 새로 생성
            $uniq_id = uniqid();
        }

        $save_name = $uniq_id;
        
        // 이미지인 경우 너비와 높이 정보를 파일명에 추가
        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
            $image_info = getimagesize($tmp_name);
            if ($image_info !== false) {
                $width = $image_info[0];
                $height = $image_info[1];
                $save_name .= "_w{$width}_h{$height}";
            }
        }

        $save_name .= '.' . $extension;
        $save_path = $save_dir . DS . $save_name;
        $resource_path = DS . 'egb_setting' . DS . 'egb_resource' . DS . $save_name;

        if (!move_uploaded_file($tmp_name, $save_path)) {
            error_log("[egb_resource_save] 파일 이동 실패: " . $tmp_name . " -> " . $save_path);
            return false;
        }

$resource_type = 'etc';

if (in_array($extension, ['mp4', 'avi', 'mov', 'wmv'])) {
    $resource_type = 'video';
} elseif (in_array($extension, ['mp3', 'wav', 'ogg'])) {
    $resource_type = 'audio';
} elseif (in_array($extension, ['woff', 'woff2', 'ttf', 'otf'])) {
    $resource_type = 'font';
} elseif (in_array($extension, ['pdf'])) {
    $resource_type = 'pdf';
} elseif (in_array($extension, ['doc', 'docx', 'hwp'])) {
    $resource_type = 'doc';
} elseif (in_array($extension, ['ppt', 'pptx'])) {
    $resource_type = 'ppt';
} elseif (in_array($extension, ['xls', 'xlsx'])) {
    $resource_type = 'xls';
} elseif (in_array($extension, ['zip', '7z', 'rar', 'tar', 'gz'])) {
    $resource_type = 'zip';
} elseif (in_array($extension, ['txt'])) {
    $resource_type = 'txt';
} elseif (in_array($extension, ['html', 'css', 'js', 'php', 'py', 'json', 'xml'])) {
    $resource_type = 'code';
} elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'])) {
    $resource_type = 'img';
}

// MIME 기반 보정 (확장자에 못 걸린 경우만 처리)
if ($resource_type === 'etc') {
    if (strpos($mime, 'video/') === 0) {
        $resource_type = 'video';
    } elseif (strpos($mime, 'image/') === 0) {
        $resource_type = 'img';
    } elseif (strpos($mime, 'audio/') === 0) {
        $resource_type = 'audio';
    } elseif ($mime === 'text/plain') {
        $resource_type = 'txt';
    }
}




        if ($is_insert) {
            $query = "
                INSERT INTO egb_resource_map (
                    uniq_id, resource_path, resource_name, resource_original_name,
                    resource_size, resource_mime, resource_extension, resource_type,
                    created_by
                ) VALUES (
                    :uniq_id, :resource_path, :resource_name, :resource_original_name,
                    :resource_size, :resource_mime, :resource_extension, :resource_type,
                    :created_by
                )
            ";

            // 레코드 카운트 증가
            increase_record_total_count('egb_resource_map');
            increase_record_active_count('egb_resource_map');

        } else {
            $query = "
                UPDATE egb_resource_map SET
                    resource_path = :resource_path,
                    resource_name = :resource_name,
                    resource_original_name = :resource_original_name,
                    resource_size = :resource_size,
                    resource_mime = :resource_mime,
                    resource_extension = :resource_extension,
                    resource_type = :resource_type,
                    created_by = :created_by,
                    updated_at = NOW()
                WHERE uniq_id = :uniq_id
            ";
        }

        $params = [
            ':uniq_id' => $uniq_id,
            ':resource_path' => $resource_path,
            ':resource_name' => $save_name,
            ':resource_original_name' => $original_name,
            ':resource_size' => $size,
            ':resource_mime' => $mime,
            ':resource_extension' => $extension,
            ':resource_type' => $resource_type,
            ':created_by' => $created_by
        ];

        $binding = binding_sql(2, $query, $params);
        $sql = egb_sql($binding);

        if (!isset($sql[0])) {
            error_log("[egb_resource_save] DB 처리 실패: " . json_encode($params));
            return false;
        }
        
        return $uniq_id;

    } catch (Exception $e) {
        error_log("[egb_resource_save] 예외 발생: " . $e->getMessage());
        return false;
    }
}
?>
