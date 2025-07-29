



<?php
//보드 추가 할때 사이트맵 추가 자동
function egb_index_sitemap_insert($board) {
    $now = date('c'); // ISO 8601
    $datetime = date('Y-m-d-H');
    [$y, $m, $d, $h] = explode('-', $datetime);

    $base_dir = ROOT . DS . 'egb_sitemap';
    $board_index_path = $base_dir . DS . $board . '.xml';
    $main_index_path  = ROOT . DS . 'sitemap.xml';

    $date_file = "sitemap_{$board}_{$datetime}.xml";
    $date_url  = DOMAIN . "/egb_sitemap/{$board}/{$y}/{$m}/{$d}/{$date_file}";
    $board_index_url = DOMAIN . "/egb_sitemap/{$board}.xml";

    // 1. 일 단위 sitemap 경로 생성
    $target_dir = $base_dir . DS . $board . DS . $y . DS . $m . DS . $d;
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $date_path = $target_dir . DS . $date_file;
    if (!file_exists($date_path)) {
        $empty_xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $empty_xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        $empty_xml .= '</urlset>';

        $fp = fopen($date_path, 'c+');
        if ($fp) {
            if (flock($fp, LOCK_EX)) {
                fwrite($fp, $empty_xml);
                fflush($fp);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
    }

    // 2. board.xml에 해당 시간 sitemap 링크 추가
    $board_lines = file_exists($board_index_path) ? file($board_index_path) : [];
    $board_xml = implode('', $board_lines);
    if (strpos($board_xml, htmlspecialchars($date_url, ENT_XML1 | ENT_QUOTES, 'UTF-8')) === false) {
        $body = '';
        if (preg_match('/<sitemapindex[^>]*>(.*?)<\/sitemapindex>/s', $board_xml, $matches)) {
            $body = trim($matches[1]);
        }

        $body .= PHP_EOL . '  <sitemap>' . PHP_EOL;
        $body .= '    <loc>' . htmlspecialchars($date_url, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>' . PHP_EOL;
        $body .= '    <lastmod>' . $now . '</lastmod>' . PHP_EOL;
        $body .= '  </sitemap>' . PHP_EOL;

        $board_xml  = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $board_xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        $board_xml .= $body;
        $board_xml .= '</sitemapindex>';

        $fp = fopen($board_index_path, 'c+');
        if ($fp) {
            if (flock($fp, LOCK_EX)) {
                ftruncate($fp, 0);
                fwrite($fp, $board_xml);
                fflush($fp);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
    }

    // 3. sitemap.xml에 board.xml 링크 추가
    $main_lines = file_exists($main_index_path) ? file($main_index_path) : [];
    $main_xml = implode('', $main_lines);
    if (strpos($main_xml, htmlspecialchars($board_index_url, ENT_XML1 | ENT_QUOTES, 'UTF-8')) === false) {
        $body = '';
        if (preg_match('/<sitemapindex[^>]*>(.*?)<\/sitemapindex>/s', $main_xml, $matches)) {
            $body = trim($matches[1]);
        }

        $body .= PHP_EOL . '  <sitemap>' . PHP_EOL;
        $body .= '    <loc>' . htmlspecialchars($board_index_url, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>' . PHP_EOL;
        $body .= '    <lastmod>' . $now . '</lastmod>' . PHP_EOL;
        $body .= '  </sitemap>' . PHP_EOL;

        $main_xml  = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $main_xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        $main_xml .= $body;
        $main_xml .= '</sitemapindex>';

        $fp = fopen($main_index_path, 'c+');
        if ($fp) {
            if (flock($fp, LOCK_EX)) {
                ftruncate($fp, 0);
                fwrite($fp, $main_xml);
                fflush($fp);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
    }
}

?>