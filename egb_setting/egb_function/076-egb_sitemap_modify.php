



<?php
function egb_sitemap_modify($board, $uniq_id, $mode = 1, $link = null) {
    $table = "egb_board_{$board}";
    $query = "SELECT created_at, updated_at FROM {$table} WHERE uniq_id = :uniq_id LIMIT 1";
    $params = [':uniq_id' => $uniq_id];

    $binding = binding_sql(1, $query, $params);
    $result = egb_sql($binding);
    if (!isset($result[0])) return false;

    $row = $result[0];
    $date = substr(($row['created_at'] ?? $row['updated_at']), 0, 10);
    [$y, $m, $d] = explode('-', $date);
    $now = date('c');
    $hour = date('H');

    $base_dir = ROOT . DS . 'egb_sitemap';
    $file = "sitemap_{$board}_{$date}_{$hour}.xml";
    $file_path = $base_dir . DS . $board . DS . $y . DS . $m . DS . $d . DS . $file;
    if (!file_exists($file_path)) return false;

    if ($link === null) {
        $link = DOMAIN . "/page/{$board}_view/?uniq_id={$uniq_id}";
    }
    $escaped_link = preg_quote(htmlspecialchars($link, ENT_XML1 | ENT_QUOTES, 'UTF-8'), '/');

    // 1차 sitemap 수정/삭제 (락 처리)
    $xml_lines = file($file_path);
    if (!$xml_lines) return false;
    $xml = implode('', $xml_lines);

    if ($mode === 0) {
        $xml = preg_replace(
            "/<url>\s*<loc>{$escaped_link}<\/loc>.*?<\/url>\s*/s",
            '',
            $xml
        );
    } else {
        $xml = preg_replace(
            "/(<url>\s*<loc>{$escaped_link}<\/loc>\s*<lastmod>)([^<]*)/",
            "\$1{$now}",
            $xml
        );
    }

    $fp = fopen($file_path, 'c+');
    if ($fp && flock($fp, LOCK_EX)) {
        ftruncate($fp, 0);
        fwrite($fp, $xml);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    // 중간 sitemap 갱신
    $mid_path = $base_dir . DS . "{$board}.xml";
    if (file_exists($mid_path)) {
        $mid_lines = file($mid_path);
        $mid = implode('', $mid_lines);
        $mid = preg_replace(
            "/(<loc>[^<]*{$y}\/{$m}\/{$d}\/sitemap_{$board}_{$date}_{$hour}\.xml<\/loc>\s*<lastmod>)([^<]*)/",
            "\$1{$now}",
            $mid
        );
        $fp = fopen($mid_path, 'c+');
        if ($fp && flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            fwrite($fp, $mid);
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }

    // 최상위 sitemap 갱신
    $top_path = ROOT . DS . 'sitemap.xml';
    if (file_exists($top_path)) {
        $top_lines = file($top_path);
        $top = implode('', $top_lines);
        $top = preg_replace(
            "/(<loc>[^<]*\/egb_sitemap\/{$board}\.xml<\/loc>\s*<lastmod>)([^<]*)/",
            "\$1{$now}",
            $top
        );
        $fp = fopen($top_path, 'c+');
        if ($fp && flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            fwrite($fp, $top);
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }

    return true;
}

?>