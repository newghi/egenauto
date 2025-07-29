<?php
function egb_download_insert($download_board_id, $download_data_path, $download_data_name, $download_size) {
    $download_uniq_id = uniqid();
    $download_short_data_url = '/download/' . $download_board_id;
    $download_hash = hash_file('sha256', ROOT.$download_data_path); // 파일 해시 생성
    $query = "
    INSERT INTO egb_download (
        download_uniq_id, download_board_id, download_data_path, download_short_data_url, download_data_name, download_size, download_hash, download_level, download_count, download_etc1, download_etc2, download_etc3, download_etc4, download_etc5, download_etc6, download_etc7, download_etc8, download_etc9, download_publish_date, download_last_modified_at
    ) VALUES (
        :download_uniq_id, :download_board_id, :download_data_path, :download_short_data_url, :download_data_name, :download_size, :download_hash, :download_level, :download_count, :download_etc1, :download_etc2, :download_etc3, :download_etc4, :download_etc5, :download_etc6, :download_etc7, :download_etc8, :download_etc9, :download_publish_date, :download_last_modified_at
    );
    ";

    $params = [
        ':download_uniq_id' => $download_uniq_id,
        ':download_board_id' => $download_board_id,
        ':download_data_path' => $download_data_path,
        ':download_short_data_url' => $download_short_data_url,
        ':download_data_name' => $download_data_name,
        ':download_size' => $download_size,
        ':download_hash' => $download_hash,
        ':download_level' => 0,
        ':download_count' => 0,
        ':download_etc1' => null,
        ':download_etc2' => null,
        ':download_etc3' => null,
        ':download_etc4' => null,
        ':download_etc5' => null,
        ':download_etc6' => null,
        ':download_etc7' => null,
        ':download_etc8' => null,
        ':download_etc9' => null,
        ':download_publish_date' => date("Y-m-d H:i:s"),
        ':download_last_modified_at' => date("Y-m-d H:i:s")
    ];

    $binding = binding_sql(2, $query, $params);
    $result = egb_sql($binding);

    // 결과 확인
    return $result;
}
?>
