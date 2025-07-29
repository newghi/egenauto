<?php
/*
| 값         | 의미                              |
| --------- | ------------------------------- |
| `always`  | 거의 실시간으로 바뀜 (예: 뉴스피드, 메인페이지)    |
| `hourly`  | 매 시간마다 바뀜                       |
| `daily`   | 매일 바뀜 (예: 블로그, 커뮤니티 게시판)        |
| `weekly`  | 매주 정도 바뀜 (예: 상품 목록, 월간 소식)      |
| `monthly` | 한 달에 한 번 정도 (예: 공지사항, 이벤트)      |
| `yearly`  | 거의 안 바뀜 (예: 소개 페이지, 이용약관)       |
| `never`   | 절대 안 바뀜 (예: 영구 보존 콘텐츠, 종료된 이벤트) |

$file_list = [
    'sitemap_main',
    'sitemap_board1', 
    'sitemap_board2'
];

*/
//수동 사이트맵 생성
function egb_index_sitemap($file_list) {
    $now = date('c'); // ISO 8601: 예: 2025-06-25T15:00:00+09:00
    $datetime = date('Y-m-d-H');
    [$y, $m, $d, $h] = explode('-', $datetime);

    $base_dir = ROOT . DS . 'egb_sitemap';
    $index_path = ROOT . DS . 'sitemap.xml';

    $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

    foreach ($file_list as $board) {
        $board_index_path = $base_dir . DS . $board . '.xml';
        $board_index_url  = DOMAIN . "/egb_sitemap/{$board}.xml";

        $xml .= "  <sitemap>" . PHP_EOL;
        $xml .= "    <loc>" . htmlspecialchars($board_index_url, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>" . PHP_EOL;
        $xml .= "    <lastmod>{$now}</lastmod>" . PHP_EOL;
        $xml .= "  </sitemap>" . PHP_EOL;

        // main 보드인 경우 urlset 구조로 생성
        if ($board === 'main' || $board === 'sitemap') {
            $main_xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
            $main_xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
            $main_xml .= '</urlset>';

            $fp_mid = fopen($board_index_path, 'c+');
            if ($fp_mid && flock($fp_mid, LOCK_EX)) {
                ftruncate($fp_mid, 0);
                fwrite($fp_mid, $main_xml);
                fflush($fp_mid);
                flock($fp_mid, LOCK_UN);
            }
            if ($fp_mid) {
                fclose($fp_mid);
            }
        } else {
            // 일자 단위 디렉토리 생성
            $target_dir = $base_dir . DS . $board . DS . $y . DS . $m . DS . $d;
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }

            $date_file = "sitemap_{$board}_{$datetime}.xml";
            $date_path = $target_dir . DS . $date_file;
            $date_url  = DOMAIN . "/egb_sitemap/{$board}/{$y}/{$m}/{$d}/{$date_file}";

            // 해당 시간 sitemap 파일 없으면 빈 것으로 생성
            if (!file_exists($date_path)) {
                $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
                $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
                $sitemap .= '</urlset>';

                file_put_contents($date_path, $sitemap);
            }

            // 중간 인덱스 XML 구성
            $mid_xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
            $mid_xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
            $mid_xml .= "  <sitemap>" . PHP_EOL;
            $mid_xml .= "    <loc>" . htmlspecialchars($date_url, ENT_XML1 | ENT_QUOTES, 'UTF-8') . "</loc>" . PHP_EOL;
            $mid_xml .= "    <lastmod>{$now}</lastmod>" . PHP_EOL;
            $mid_xml .= "  </sitemap>" . PHP_EOL;
            $mid_xml .= '</sitemapindex>';

            $fp_mid = fopen($board_index_path, 'c+');
            if ($fp_mid && flock($fp_mid, LOCK_EX)) {
                ftruncate($fp_mid, 0);
                fwrite($fp_mid, $mid_xml);
                fflush($fp_mid);
                flock($fp_mid, LOCK_UN);
            }
            if ($fp_mid) {
                fclose($fp_mid);
            }
        }
    }

    $xml .= '</sitemapindex>';

    $fp_top = fopen($index_path, 'c+');
    if ($fp_top && flock($fp_top, LOCK_EX)) {
        ftruncate($fp_top, 0);
        fwrite($fp_top, $xml);
        fflush($fp_top);
        flock($fp_top, LOCK_UN);
    }
    if ($fp_top) {
        fclose($fp_top);
    }
}

?>