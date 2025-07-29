



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

*/

function egb_sitemap_insert($board, $link, $changefreq = null, $priority = null) {
    $now = date('c'); // ISO 8601 형식 (예: 2025-06-25T15:00:00+09:00)
    $datetime = date('Y-m-d-H');
    [$y, $m, $d, $h] = explode('-', $datetime);

    $base_dir = ROOT . DS . 'egb_sitemap' . DS . $board . DS . $y . DS . $m . DS . $d;
    if (!is_dir($base_dir)) {
        mkdir($base_dir, 0755, true);
    }

    $file_name = "sitemap_{$board}_{$datetime}.xml";
    $file_path = $base_dir . DS . $file_name;
    $date_url  = DOMAIN . "/egb_sitemap/{$board}/{$y}/{$m}/{$d}/{$file_name}";

    // sitemap 파일 없으면 빈 구조로 생성
    if (!file_exists($file_path)) {
        $empty = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $empty .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        $empty .= '</urlset>';

        $fp = fopen($file_path, 'c+');
        if ($fp && flock($fp, LOCK_EX)) {
            fwrite($fp, $empty);
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }

    // 자동 changefreq/priority 계산
    if ($changefreq === null || $priority === null) {
        $now_ts = time();
        $created = $now_ts;
        $updated = $now_ts;

        // board에서 유니크 ID로 최신 날짜 가져오기
        if (preg_match('/uniq_id=([a-zA-Z0-9_]+)/', $link, $match)) {
            $uniq_id = $match[1];
            $table = "egb_board_{$board}";
            $query = "SELECT created_at, updated_at FROM {$table} WHERE uniq_id = :uniq_id LIMIT 1";
            $params = [':uniq_id' => $uniq_id];
            $binding = binding_sql(1, $query, $params);
            $result = egb_sql($binding);
            if (isset($result[0])) {
                $created = strtotime($result[0]['created_at'] ?? 'now');
                $updated = strtotime($result[0]['updated_at'] ?? 'now');
            }
        }

        $diff = $now_ts - max($created, $updated);

        if ($diff < 3600) {
            $changefreq = 'hourly';
            $priority = '0.9';
        } elseif ($diff < 86400 * 2) {
            $changefreq = 'daily';
            $priority = '0.8';
        } elseif ($diff < 86400 * 7) {
            $changefreq = 'weekly';
            $priority = '0.7';
        } else {
            $changefreq = 'monthly';
            $priority = '0.6';
        }
    }

    $xml_lines = file($file_path);
    $xml = implode('', $xml_lines);
    $escaped_link        = htmlspecialchars($link, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $escaped_changefreq  = htmlspecialchars($changefreq, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    $escaped_priority    = htmlspecialchars($priority, ENT_XML1 | ENT_QUOTES, 'UTF-8');

    if (strpos($xml, $escaped_link) !== false) {
        return;
    }

    $new_entry  = '  <url>' . PHP_EOL;
    $new_entry .= "    <loc>{$escaped_link}</loc>" . PHP_EOL;
    $new_entry .= "    <lastmod>{$now}</lastmod>" . PHP_EOL;
    $new_entry .= "    <changefreq>{$escaped_changefreq}</changefreq>" . PHP_EOL;
    $new_entry .= "    <priority>{$escaped_priority}</priority>" . PHP_EOL;
    $new_entry .= '  </url>' . PHP_EOL;

    $xml = preg_replace('/<\/urlset>/', $new_entry . '</urlset>', $xml);

    $fp = fopen($file_path, 'c+');
    if ($fp && flock($fp, LOCK_EX)) {
        ftruncate($fp, 0);
        fwrite($fp, $xml);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
    }

    // board.xml <lastmod> 갱신 및 생성
    $board_index_path = ROOT . DS . 'egb_sitemap' . DS . $board . '.xml';
    $board_index_url = DOMAIN . "/egb_sitemap/{$board}.xml";
    
    // board.xml 파일이 없으면 생성
    if (!file_exists($board_index_path)) {
        $board_xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $board_xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        $board_xml .= '  <sitemap>' . PHP_EOL;
        $board_xml .= '    <loc>' . htmlspecialchars($date_url, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>' . PHP_EOL;
        $board_xml .= '    <lastmod>' . $now . '</lastmod>' . PHP_EOL;
        $board_xml .= '  </sitemap>' . PHP_EOL;
        $board_xml .= '</sitemapindex>';
        
        $fp = fopen($board_index_path, 'c+');
        if ($fp && flock($fp, LOCK_EX)) {
            fwrite($fp, $board_xml);
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    } else {
        // 기존 board.xml에서 해당 URL 찾아서 lastmod 갱신
        $board_xml_lines = file($board_index_path);
        $board_xml = implode('', $board_xml_lines);
        
        // 해당 URL이 이미 존재하는지 확인
        if (strpos($board_xml, htmlspecialchars($date_url, ENT_XML1 | ENT_QUOTES, 'UTF-8')) !== false) {
            // 기존 URL의 lastmod 갱신
            $escaped_date_url = preg_quote(htmlspecialchars($date_url, ENT_XML1 | ENT_QUOTES, 'UTF-8'), '/');
            $updated = preg_replace(
                '/(<loc>' . $escaped_date_url . '<\/loc>\s*<lastmod>)([^<]*)(<\/lastmod>)/',
                '${1}' . $now . '${3}',
                $board_xml
            );
            
            if ($updated !== null && $updated !== $board_xml) {
                $fp = fopen($board_index_path, 'c+');
                if ($fp && flock($fp, LOCK_EX)) {
                    ftruncate($fp, 0);
                    fwrite($fp, $updated);
                    fflush($fp);
                    flock($fp, LOCK_UN);
                    fclose($fp);
                }
            }
        } else {
            // 새로운 URL 추가
            $body = '';
            if (preg_match('/<sitemapindex[^>]*>(.*?)<\/sitemapindex>/s', $board_xml, $matches)) {
                $body = trim($matches[1]);
            }
            
            $body .= PHP_EOL . '  <sitemap>' . PHP_EOL;
            $body .= '    <loc>' . htmlspecialchars($date_url, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</loc>' . PHP_EOL;
            $body .= '    <lastmod>' . $now . '</lastmod>' . PHP_EOL;
            $body .= '  </sitemap>' . PHP_EOL;
            
            $board_xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
            $board_xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
            $board_xml .= $body;
            $board_xml .= '</sitemapindex>';
            
            $fp = fopen($board_index_path, 'c+');
            if ($fp && flock($fp, LOCK_EX)) {
                ftruncate($fp, 0);
                fwrite($fp, $board_xml);
                fflush($fp);
                flock($fp, LOCK_UN);
                fclose($fp);
            }
        }
    }

    // sitemap.xml <lastmod> 갱신
    $root_index_path = ROOT . DS . 'sitemap.xml';
    $board_index_url = DOMAIN . '/egb_sitemap/' . $board . '.xml';
    if (file_exists($root_index_path)) {
        $root_xml_lines = file($root_index_path);
        $root_xml = implode('', $root_xml_lines);
        $updated = preg_replace(
            '/(<loc>' . preg_quote($board_index_url, '/') . '<\/loc>\s*<lastmod>)([^<]*)/',
            '${1}' . $now,
            $root_xml
        );
        if ($updated !== null) {
            $fp = fopen($root_index_path, 'c+');
            if ($fp && flock($fp, LOCK_EX)) {
                ftruncate($fp, 0);
                fwrite($fp, $updated);
                fflush($fp);
                flock($fp, LOCK_UN);
                fclose($fp);
            }
        }
    }
}



?>