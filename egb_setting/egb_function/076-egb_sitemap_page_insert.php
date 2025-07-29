<?php
/*
수동으로 추가한 사이트맵에 내용을 추가하는 함수

사용법:
egb_sitemap_page_insert('main', '/page/login/', '0.8', 'monthly');
egb_sitemap_page_insert('blog', '/page/blog_view?uniq_id=abc123', '0.9', 'daily');
*/

function egb_sitemap_page_insert($board, $link, $priority = '0.5', $changefreq = 'monthly') {
    $now = date('c'); // ISO 8601 형식
    
    // 상대 경로인 경우 DOMAIN 추가
    if (strpos($link, 'http') !== 0) {
        $link = DOMAIN . $link;
    }
    
    // board.xml 파일 경로
    $board_index_path = ROOT . DS . 'egb_sitemap' . DS . $board . '.xml';
    
    // board.xml 파일이 없으면 생성
    if (!file_exists($board_index_path)) {
        $board_xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $board_xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        $board_xml .= '</urlset>';
        
        $fp = fopen($board_index_path, 'c+');
        if ($fp && flock($fp, LOCK_EX)) {
            fwrite($fp, $board_xml);
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }
    
    // board.xml 파일에 URL 추가
    $board_xml = file_get_contents($board_index_path);
    $escaped_link = htmlspecialchars($link, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    
    // URL이 이미 존재하는지 확인
    if (strpos($board_xml, $escaped_link) !== false) {
        return true; // 이미 존재하면 성공으로 처리
    }
    
    // 새로운 URL 엔트리 생성
    $new_entry = '  <url>' . PHP_EOL;
    $new_entry .= '    <loc>' . $escaped_link . '</loc>' . PHP_EOL;
    $new_entry .= '    <lastmod>' . $now . '</lastmod>' . PHP_EOL;
    $new_entry .= '    <changefreq>' . htmlspecialchars($changefreq, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</changefreq>' . PHP_EOL;
    $new_entry .= '    <priority>' . htmlspecialchars($priority, ENT_XML1 | ENT_QUOTES, 'UTF-8') . '</priority>' . PHP_EOL;
    $new_entry .= '  </url>' . PHP_EOL;
    
    // </urlset> 태그 앞에 새로운 URL 추가
    $updated_content = str_replace('</urlset>', $new_entry . '</urlset>', $board_xml);
    
    // 파일에 저장
    $fp = fopen($board_index_path, 'c+');
    if ($fp && flock($fp, LOCK_EX)) {
        ftruncate($fp, 0);
        fwrite($fp, $updated_content);
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
        
        return true;
    }
    
    if ($fp) {
        fclose($fp);
    }
    
    return false;
}

?> 