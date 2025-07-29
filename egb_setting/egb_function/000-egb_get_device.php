
<?php

    // UserAgentParser
    require_once ROOT . DS . 'egb_library' . DS . 'phpuseragentparser' . DS . 'src' . DS . 'UserAgentParser.php';
    require_once ROOT . DS . 'egb_library' . DS . 'phpuseragentparser' . DS . 'src' . DS . 'UserAgent' . DS . 'UserAgentInterface.php';
    require_once ROOT . DS . 'egb_library' . DS . 'phpuseragentparser' . DS . 'src' . DS . 'UserAgent' . DS . 'UserAgent.php'; 
    require_once ROOT . DS . 'egb_library' . DS . 'phpuseragentparser' . DS . 'src' . DS . 'UserAgent' . DS . 'UserAgentParser.php'; 

    // CrawlerDetect
    require_once ROOT . DS . 'egb_library' . DS . 'crawlerdetect' . DS . 'src' . DS . 'Fixtures' . DS . 'AbstractProvider.php';
    require_once ROOT . DS . 'egb_library' . DS . 'crawlerdetect' . DS . 'src' . DS . 'Fixtures' . DS . 'Crawlers.php';
    require_once ROOT . DS . 'egb_library' . DS . 'crawlerdetect' . DS . 'src' . DS . 'Fixtures' . DS . 'Exclusions.php';
    require_once ROOT . DS . 'egb_library' . DS . 'crawlerdetect' . DS . 'src' . DS . 'Fixtures' . DS . 'Headers.php';
    require_once ROOT . DS . 'egb_library' . DS . 'crawlerdetect' . DS . 'src' . DS . 'CrawlerDetect.php';

    use donatj\UserAgent\UserAgentParser;

function egb_get_device($uniq_id = null, $render_time = null) {
    // 렌더 타임 업데이트
    if ($uniq_id && $render_time) {
        $query = "
        UPDATE egb_log 
        SET log_render_time = :render_time 
        WHERE uniq_id = :uniq_id
        ";
        
        $params = [
            ':uniq_id' => $uniq_id,
            ':render_time' => $render_time
        ];
        
        $binding = binding_sql(2, $query, $params);
        egb_sql($binding);
        return;
    }

    // IP 주소 가져오기
    $ip = egb_ip();
          
    if (!defined('EGB_USER_IP')) {define('EGB_USER_IP', $ip);}
    
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
    $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

    // 리소스 요청 제외
    $excluded_patterns = ['/favicon.ico', 
    '/img/', '?img=', '&img=', 
    '/img2/', '?img2=', '&img2=', 
    '/img3/', '?img3=', '&img3=', 
    '?post=page_style_input', '&post=video_view', 
    '/admin', '/admin/', '/download/', '/template/', '/cron', '/cron/',
    '/video/', '?video=', '&video=', 
    '/video2/', '?video2=', '&video2=', 
    '/video3/', '?video3=', '&video3=', 
    '/audio/', '?audio=', '&audio=', 
    '/audio2/', '?audio2=', '&audio2=', 
    '/audio3/', '?audio3=', '&audio3=', 
    '/font/', '?font=', '&font=', 
    '/font2/', '?font2=', '&font2=', 
    '/font3/', '?font3=', '&font3=', 
    ];
    foreach ($excluded_patterns as $pattern) {
        if (stripos($uri, $pattern) !== false) {
            return; // 로그 기록하지 않음
        }
    }

    // UserAgent 분석
    $parser = new UserAgentParser();
    $result = $parser->parse($ua);

    // 봇 여부 판단
    $crawlerDetect = new \Jaybizzle\CrawlerDetect\CrawlerDetect();
    $is_bot = $crawlerDetect->isCrawler($ua) ? 1 : 0;

    // 디바이스 분류 ('MO', 'TB', 'PC')
    $ua_lc = strtolower($ua);
    if (strpos($ua_lc, 'tablet') !== false || strpos($ua_lc, 'ipad') !== false || strpos($ua_lc, 'nexus 7') !== false) {
        $device = 'TB';
    } elseif (strpos($ua_lc, 'mobile') !== false || strpos($ua_lc, 'iphone') !== false || strpos($ua_lc, 'android') !== false) {
        $device = 'MO';
    } elseif (strpos($ua_lc, 'windows') !== false || strpos($ua_lc, 'macintosh') !== false || strpos($ua_lc, 'linux') !== false) {
        $device = 'PC';
    } else {
        $device = 'UNKNOWN';
    }

    if (!defined('EGB_DEVICE')) {define('EGB_DEVICE', $device);}

    // DB 기록
    $uniq_id = uniqid();
    
    if (!defined('EGB_LOG_UNIQ_ID')) {define('EGB_LOG_UNIQ_ID', $uniq_id);}
    
    $query = "
    INSERT INTO egb_log (
        uniq_id, log_ip, log_uri, log_method, log_agent, log_referer,
        log_device, log_platform, log_browser, log_browser_ver, log_is_bot,
        log_render_time, is_status, display_order, created_by
    ) VALUES (
        :uniq_id, :log_ip, :log_uri, :log_method, :log_agent, :log_referer,
        :log_device, :log_platform, :log_browser, :log_browser_ver, :log_is_bot,
        :log_render_time, :is_status, :display_order, :created_by
    )";

    $params = [
        ':uniq_id' => $uniq_id,
        ':log_ip' => $ip,
        ':log_uri' => $uri,
        ':log_method' => $method,
        ':log_agent' => $ua,
        ':log_referer' => $referer,
        ':log_device' => $device,
        ':log_platform' => $result->platform(),
        ':log_browser' => $result->browser(),
        ':log_browser_ver' => $result->browserVersion(),
        ':log_is_bot' => $is_bot,
        ':log_render_time' => null,
        ':is_status' => 1,
        ':display_order' => 0,
        ':created_by' => 'system',
    ];

    $binding = binding_sql(2, $query, $params);
    egb_sql($binding);
}
?>