
<?php
function egb_resource_update($uniq_id, $file_key = 'file') {
    try {
        // 기존 리소스 정보 조회
        $query = "SELECT * FROM egb_resource_map WHERE uniq_id = :uniq_id";
        $binding = binding_sql(1, $query, [':uniq_id' => $uniq_id]);
        $result = egb_sql($binding);

        if (!isset($result[0])) {
            error_log("[egb_resource_update] 기존 리소스를 찾을 수 없습니다: " . $uniq_id);
            return false;
        }

        $old_resource = $result[0];
        $old_path = ROOT . $old_resource['resource_path'];

        if (!isset($_FILES[$file_key])) {
            error_log("[egb_resource_update] 파일이 업로드되지 않았습니다.");
            return false;
        }

        $file = $_FILES[$file_key];
        $created_by = $_POST['created_by'] ?? 'system';

        $save_dir = ROOT . DS . 'egb_setting' . DS . 'egb_resource';
        if (!is_dir($save_dir) && !mkdir($save_dir, 0755, true)) {
            error_log("[egb_resource_update] 디렉토리 생성 실패: " . $save_dir);
            return false;
        }

        $original_name = $file['name'];
        $tmp_name = $file['tmp_name'];
        $size = $file['size'];
        
        if (!file_exists($tmp_name)) {
            error_log("[egb_resource_update] 임시 파일이 존재하지 않습니다: " . $tmp_name);
            return false;
        }
        
        $mime = mime_content_type($tmp_name);
        if ($mime == false) {
            error_log("[egb_resource_update] MIME 타입 확인 실패");
            return false;
        }

        $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
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

        // 기존 파일 삭제
        if (file_exists($old_path)) {
            unlink($old_path);
        }

        if (!move_uploaded_file($tmp_name, $save_path)) {
            error_log("[egb_resource_update] 파일 이동 실패: " . $tmp_name . " -> " . $save_path);
            return false;
        }

        $resource_path = DS . 'egb_setting' . DS . 'egb_resource' . DS . $save_name;

        if (strpos($mime, 'image/') == 0) {
            $resource_type = 'img';
        } elseif (strpos($mime, 'video/') == 0) {
            $resource_type = 'video';
        } elseif (strpos($mime, 'audio/') == 0) {
            $resource_type = 'audio';
        } elseif (in_array($extension, ['woff', 'woff2', 'ttf', 'otf'])) {
            $resource_type = 'font';
        } elseif ($mime == 'application/pdf' || $extension == 'pdf') {
            $resource_type = 'pdf';
        } elseif (in_array($extension, ['doc', 'docx', 'hwp'])) {
            $resource_type = 'doc';
        } elseif (in_array($extension, ['ppt', 'pptx'])) {
            $resource_type = 'ppt';
        } elseif (in_array($extension, ['xls', 'xlsx'])) {
            $resource_type = 'xls';
        } elseif (in_array($extension, ['zip', '7z', 'rar', 'tar', 'gz'])) {
            $resource_type = 'zip';
        } elseif ($mime == 'text/plain' || $extension == 'txt') {
            $resource_type = 'txt';
        } elseif (in_array($extension, ['html', 'css', 'js', 'php', 'py', 'json', 'xml'])) {
            $resource_type = 'code';
        } else {
            $resource_type = 'etc';
        }

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
            error_log("[egb_resource_update] DB 업데이트 실패: " . json_encode($params));
            return false;
        }

        return $uniq_id;

    } catch (Exception $e) {
        error_log("[egb_resource_update] 예외 발생: " . $e->getMessage());
        return false;
    }
}
?>
