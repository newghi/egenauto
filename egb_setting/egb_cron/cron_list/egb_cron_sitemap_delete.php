<?php
// 설정
$base_dir = ROOT . DS . 'egb_sitemap';
$now = time();
$now_c = date('c');
$prev_hour = date('Y-m-d-H', strtotime('-1 hour', $now));
[$y, $m, $d, $h] = explode('-', $prev_hour);

$sitemap_index_url = DOMAIN . '/sitemap.xml';
$ping_urls = [
    "https://www.google.com/ping?sitemap=" . urlencode($sitemap_index_url),
    "https://www.bing.com/ping?sitemap=" . urlencode($sitemap_index_url),
];

$ping_required = false;

// 게시판 목록 조회
$boards = scandir($base_dir);
foreach ($boards as $board) {
    if ($board === '.' || $board === '..' || !is_dir($base_dir . DS . $board)) continue;

    $file_name = "sitemap_{$board}_{$prev_hour}.xml";
    $file_path = $base_dir . DS . $board . DS . $y . DS . $m . DS . $d . DS . $file_name;
    $file_url = DOMAIN . "/egb_sitemap/{$board}/{$y}/{$m}/{$d}/{$file_name}";

    if (!file_exists($file_path)) continue;

    $content = file($file_path);
    if (!preg_grep('/<url>/', $content)) {
        // 빈 sitemap 파일 삭제
        unlink($file_path);

        // 중간 sitemap에서 항목 제거
        $mid_path = $base_dir . DS . $board . '.xml';
        if (file_exists($mid_path)) {
            $mid_xml = file_get_contents($mid_path);
            $pattern = '#<sitemap>\s*<loc>' . preg_quote($file_url, '#') . '</loc>.*?</sitemap>#s';
            $updated = preg_replace($pattern, '', $mid_xml);

            if ($updated !== $mid_xml) {
                $fp = fopen($mid_path, 'c+');
                if ($fp) {
                    if (flock($fp, LOCK_EX)) {
                        ftruncate($fp, 0);
                        fwrite($fp, $updated);
                        fflush($fp);
                        flock($fp, LOCK_UN);
                    }
                    fclose($fp);
                }
            }
        }
    } else {
        // url이 존재 → ping 대상 있음
        $ping_required = true;
    }
}

// sitemap index ping 전송 (조건 만족 시에만)
if ($ping_required) {
    foreach ($ping_urls as $ping_url) {
        @file_get_contents($ping_url);
    }
}

?>