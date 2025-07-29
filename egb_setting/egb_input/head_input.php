<?php
//값이 잘 넘어왔는지 체크
if (egb('seo_title') && egb('seo_subject') && egb('seo_description') && egb('seo_author') && egb('seo_keywords') && egb('page_title')){
	$mata_title = egb('seo_title');
	$mata_subject = egb('seo_subject'); 
	$mata_description = egb('seo_description');
	$mata_author = egb('seo_author');
	$mata_robots = 'index, follow';
	$mata_keyword = egb('seo_keywords');
	$site_title = egb('page_title');
	// head-constant.php 생성
	$head_constant_file_path = DS . "egb_setting" . DS . "egb_constant_2" . DS;
	$head_constant_file_name = "002-egb_head_constant.php";
	$head_constant_file_contents = "<?php
// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset(\$_SERVER['HTTPS']) and \$_SERVER['HTTPS'] === 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo \"<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='\". PROTOCOL.\$_SERVER['HTTP_HOST'].\"'; </script>\";exit;}

//head의 기본 mata 데이터 상수 선언
if (!defined('MATA_TITLE')) {define('MATA_TITLE', '$mata_title');}
if (!defined('MATA_SUBJECT')) {define('MATA_SUBJECT', '$mata_subject');}
if (!defined('MATA_DESCRIPTION')) {define('MATA_DESCRIPTION', '$mata_description');}
if (!defined('MATA_AUTHOR')) {define('MATA_AUTHOR', '$mata_author');}
if (!defined('MATA_ROBOTS')) {define('MATA_ROBOTS', '$mata_robots');}
if (!defined('MATA_KEYWORD')) {define('MATA_KEYWORD', '$mata_keyword');}
if (!defined('SITE_TITLE')) {define('SITE_TITLE', '$site_title');}
?>
"; 

	// 파일 생성
	egb_upload($head_constant_file_path, $head_constant_file_name, $head_constant_file_contents);
	// head.php 생성
	$head_file_path = DS . "egb_setting" . DS . "egb_default" . DS;
	$head_file_name = "egb_head.php";
	$head_file_contents = <<<'CODE'
<?php
// 개별 페이지 직접 접근 차단
if (!defined('_EUNGABI_')) {

    // 프로토콜 상수 설정
    if (!defined('PROTOCOL')) {
        $isHttps = (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)
        );
        define('PROTOCOL', $isHttps ? 'https://' : 'http://');
    }

    // 리디렉션 방식 (조용히 루트로 이동)
    header("Location: " . PROTOCOL . $_SERVER['HTTP_HOST']);
    exit;
}

// 메타 변수값이 없을 경우 기본값으로 설정
$seo_title = $_POST['seo_title'] ?? MATA_TITLE;
$seo_subject = $_POST['seo_subject'] ?? MATA_SUBJECT; 
$seo_description = $_POST['seo_description'] ?? MATA_DESCRIPTION;
$seo_keywords = $_POST['seo_keywords'] ?? MATA_KEYWORD;
$seo_robots = $_POST['seo_robots'] ?? MATA_ROBOTS;
$seo_author = $_POST['seo_author'] ?? MATA_AUTHOR;
$seo_og_img = $_POST['seo_og_img'] ?? DS . 'egb_thumbnail.webp';
$created_at = $_POST['created_at'] ?? date('Y-m-d H:i:s');
$updated_at = $_POST['updated_at'] ?? date('Y-m-d H:i:s');
$page_title = $_POST['page_title'] ?? SITE_TITLE;

$formatted_created_at = str_replace(" ", "T", $created_at);
$formatted_updated_at = str_replace(" ", "T", $updated_at);
// 값 초기화
$output = '';
$output .= "<!DOCTYPE html>\n";

// 기본 메타 및 head 정보 로드

$output .= "<meta charset='UTF-8'>" . PHP_EOL;
$output .= "<meta name='viewport' content='width=device-width, initial-scale=1.0'>" . PHP_EOL;
$output .= "<link rel='manifest' href='/manifest.json'>" . PHP_EOL;

$output .= '<script id="egbThemesName" type="text/javascript" nonce="'.NONCE.'" rel="preload" as="script"> let DOMAIN = "'.DOMAIN.'"; let egbThemesName = "'.THEMES_NAME.'"; let egbCsrfToken = "'.$_SESSION['csrf_token'].'"; let THEMES_PATH = "'.THEMES_PATH.'";</script>' . PHP_EOL;

$output .= "<meta name='theme-color' content='#f7c679'>" . PHP_EOL;
$output .= "<meta name='Title' content='" . $seo_title . "'>" . PHP_EOL;
$output .= "<meta name='Subject' content='" . $seo_subject . "'>" . PHP_EOL;
$output .= "<meta name='description' content='" . $seo_description . "'>" . PHP_EOL;
$output .= "<meta name='author' content='" . $seo_author . "'>" . PHP_EOL;
$output .= "<meta name='robots' content='" . $seo_robots . "'>" . PHP_EOL;
$output .= "<meta name='keyword' content='" . $seo_keywords . "'>" . PHP_EOL;
$output .= "<meta name='Publisher' content='Eungabi'>" . PHP_EOL;
$output .= "<meta name='creation' content='" . $formatted_created_at . "'>" . PHP_EOL;
$output .= "<meta name='modification' content='" . $formatted_updated_at . "'>" . PHP_EOL;
$output .= "<meta property='og:type' content='" . 'website' . "'>" . PHP_EOL;
$output .= "<meta property='og:title' content='" . $seo_title . "'>" . PHP_EOL;
$output .= "<meta property='og:description' content='" . $seo_description . "'>" . PHP_EOL;
$output .= "<meta property='og:url' content='" . URL . "'>" . PHP_EOL;
$output .= "<meta property='og:image' content='" . $seo_og_img . "'>" . PHP_EOL;
$output .= "<meta property='og:image:type' content='image/webp'>" . PHP_EOL;
$output .= "<meta property='og:image:width' content='1200'>" . PHP_EOL;
$output .= "<meta property='og:image:height' content='630'>" . PHP_EOL;
$output .= "<meta property='og:image:alt' content='lii'>" . PHP_EOL;

// 파비콘 로드
if (file_exists(ROOT . DS . 'favicon.ico')) {
    $output .= "<link rel='icon' href='" . DOMAIN . DS . "favicon.ico'" . "sizes='32x32'>" . PHP_EOL;
} else {
}

// 폰트 로드
$fonts = require_once ROOT . THEMES_PATH . DS . 'font.php';
$font = '';

foreach ($fonts as $name => $url) {
    $url = str_replace('\\', '/', DS . 'proxy' . DS . 'font' . DS . $url); // 윈도우 경로를 유닉스 스타일로 변환
    
    // 파일 확장자 추출
    $ext = pathinfo($url, PATHINFO_EXTENSION);
    
    // 확장자별 형식 지정
    $format = '';
    switch ($ext) {
        case 'ttf': $format = 'truetype'; break;
        case 'otf': $format = 'opentype'; break;
        case 'woff': $format = 'woff'; break;
        case 'woff2': $format = 'woff2'; break;
        case 'svg': $format = 'svg'; break;
        default: $format = 'unknown'; break;
    }
    
    // @font-face 규칙 생성
    if ($format !== 'unknown') {
        $font .= "@font-face {font-family: '{$name}';src: url('{$url}') format('{$format}');font-display: swap;}";
    }
    
    // 폰트 클래스 정의
    $font .= ".{$name} { font-family: '{$name}', Arial, sans-serif;}";
}

// 현재 URL 경로 가져오기
$egbPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$egbPath = empty($egbPath) ? 'index' : $egbPath;

// JSON 파일 경로
$jsonFilePath = ROOT . DS . 'egb_themes' . DS . THEMES_NAME . DS . 'style' . DS . $egbPath . '.json';

// 스타일 데이터 읽기
$stylesData = [];
if (file_exists($jsonFilePath)) {
    $stylesData = json_decode(file_get_contents($jsonFilePath), true);
    $fileModifiedTime = filemtime($jsonFilePath);
    $currentTime = time();
    $oneDayAgo = $currentTime - 3600;

    if ($fileModifiedTime < $oneDayAgo) {
        if (unlink($jsonFilePath)) {
            $output .= '<script id="egbStyleTime" type="text/javascript" nonce="'.NONCE.'"> let egbStyleTime = "update";</script>' . PHP_EOL;
            $stylesData = [];
        } else {
            $output .= '<script id="egbStyleTime" type="text/javascript" nonce="'.NONCE.'"> let egbStyleTime = "skip";</script>' . PHP_EOL;
        }
    } else {
        $output .= '<script id="egbStyleTime" type="text/javascript" nonce="'.NONCE.'"> let egbStyleTime = "skip";</script>' . PHP_EOL;
    }
} else {
    $output .= '<script id="egbStyleTime" type="text/javascript" nonce="'.NONCE.'"> let egbStyleTime = "update";</script>' . PHP_EOL;
    $stylesData = [
        'styles' => [
            'egbStyleFont' => $font,
            'egbStyleTag' => '',
            'egbStyleAuto' => ''
        ]
    ];
}

// 스타일 내용 적용
$egbfont = isset($stylesData['styles']['egbStyleFont']) ? html_entity_decode($stylesData['styles']['egbStyleFont']) : $font;
$egbtag = isset($stylesData['styles']['egbStyleTag']) ? html_entity_decode($stylesData['styles']['egbStyleTag']) : '';
$egbauto = isset($stylesData['styles']['egbStyleAuto']) ? html_entity_decode($stylesData['styles']['egbStyleAuto']) : '';

$output .= '<style id="egbStyleFont" nonce="'.NONCE.'" rel="preload" as="style" crossorigin="anonymous">'. $egbfont .'</style>' . PHP_EOL;
$output .= '<style id="egbStyleTag" nonce="'.NONCE.'" rel="preload" as="style" crossorigin="anonymous">'. $egbtag .'</style>' . PHP_EOL;
$output .= '<style id="egbStyleAuto" nonce="'.NONCE.'" rel="preload" as="style" crossorigin="anonymous">'. $egbauto .'</style>' . PHP_EOL;

// 기본 스타일 규칙 추가
$output .= '<style id="egbStyleBase" nonce="'.NONCE.'" rel="preload" as="style" crossorigin="anonymous">';

// 기본 스타일 규칙
$output .= 'input,select,textarea{font-size:var(--size-012,12px);border-top-width:var(--size-001,1px);border-top-style:solid;border-bottom-width:var(--size-001,1px);border-bottom-style:solid;border-left-width:var(--size-001,1px);border-left-style:solid;border-right-width:var(--size-001,1px);border-right-style:solid}';
$output .= '*,.box_sizing,:after,:before,html{box-sizing:border-box}';
$output .= 'input{padding:var(--size-001,1px) var(--size-002,2px)}';
$output .= 'textarea{padding:var(--size-002,2px)}';
$output .= 'button{padding-block:var(--size-001,1px);padding-inline:var(--size-005,5px);border-top-width:var(--size-002,2px);border-top-style:solid;border-bottom-width:var(--size-002,2px);border-bottom-style:solid;border-left-width:var(--size-002,2px);border-left-style:solid;border-right-width:var(--size-002,2px);border-right-style:solid}';
$output .= '*{margin:0;padding:0;list-style:none;-webkit-tap-highlight-color: transparent;}';
$output .= 'html{scroll-behavior:smooth;font-family:fontstyle1,Arial,sans-serif}';
$output .= 'a{all:unset}';
$output .= 'scroll{border-top-width:var(--size-001,1px);border-top-style:solid;border-bottom-width:var(--size-001,1px);border-bottom-style:solid;border-left-width:var(--size-001,1px);border-left-style:solid;border-right-width:var(--size-001,1px);border-right-style:solid;border-radius:var(--size-016,16px);height:var(--size-044,44px);width:var(--size-028,28px);display:block;z-index:20}';
$output .= '.pointer{cursor:pointer}';

// 플렉스/그리드 기본 규칙
$output .= '[class*=" flex_"],[class^=flex_]{display:flex}';
$output .= '[class*=" grid_"],[class^=grid_]{display:grid}';

// 플렉스/그리드 정렬 규칙
$output .= '[class*=" flex_"][class$="_xl"],[class*=" flex_"][class*="_xl "],[class*=" flex_"][class*="_xl_"],[class*=" grid_"][class$="_xl"],[class*=" grid_"][class*="_xl "],[class*=" grid_"][class*="_xl_"],[class^=flex_][class$="_xl"],[class^=flex_][class*="_xl "],[class^=flex_][class*="_xl_"],[class^=grid_][class$="_xl"],[class^=grid_][class*="_xl "],[class^=grid_][class*="_xl_"]{justify-content:start}';
$output .= '[class*=" flex_"][class$="_xr"],[class*=" flex_"][class*="_xr "],[class*=" flex_"][class*="_xr_"],[class*=" grid_"][class$="_xr"],[class*=" grid_"][class*="_xr "],[class*=" grid_"][class*="_xr_"],[class^=flex_][class$="_xr"],[class^=flex_][class*="_xr "],[class^=flex_][class*="_xr_"],[class^=grid_][class$="_xr"],[class^=grid_][class*="_xr "],[class^=grid_][class*="_xr_"]{justify-content:end}';
$output .= '[class*=" flex_"][class$="_xc"],[class*=" flex_"][class*="_xc "],[class*=" flex_"][class*="_xc_"],[class*=" grid_"][class$="_xc"],[class*=" grid_"][class*="_xc "],[class*=" grid_"][class*="_xc_"],[class^=flex_][class$="_xc"],[class^=flex_][class*="_xc "],[class^=flex_][class*="_xc_"],[class^=grid_][class$="_xc"],[class^=grid_][class*="_xc "],[class^=grid_][class*="_xc_"]{justify-content:center}';
$output .= '[class*=" flex_"][class$="_xs1"],[class*=" flex_"][class*="_xs1 "],[class*=" flex_"][class*="_xs1_"],[class*=" grid_"][class$="_xs1"],[class*=" grid_"][class*="_xs1 "],[class*=" grid_"][class*="_xs1_"],[class^=flex_][class$="_xs1"],[class^=flex_][class*="_xs1 "],[class^=flex_][class*="_xs1_"],[class^=grid_][class$="_xs1"],[class^=grid_][class*="_xs1 "],[class^=grid_][class*="_xs1_"]{justify-content:space-between}';
$output .= '[class*=" flex_"][class$="_xs2"],[class*=" flex_"][class*="_xs2 "],[class*=" flex_"][class*="_xs2_"],[class*=" grid_"][class$="_xs2"],[class*=" grid_"][class*="_xs2 "],[class*=" grid_"][class*="_xs2_"],[class^=flex_][class$="_xs2"],[class^=flex_][class*="_xs2 "],[class^=flex_][class*="_xs2_"],[class^=grid_][class$="_xs2"],[class^=grid_][class*="_xs2 "],[class^=grid_][class*="_xs2_"]{justify-content:space-around}';
$output .= '[class*=" flex_"][class$="_xs3"],[class*=" flex_"][class*="_xs3 "],[class*=" flex_"][class*="_xs3_"],[class*=" grid_"][class$="_xs3"],[class*=" grid_"][class*="_xs3 "],[class*=" grid_"][class*="_xs3_"],[class^=flex_][class$="_xs3"],[class^=flex_][class*="_xs3 "],[class^=flex_][class*="_xs3_"],[class^=grid_][class$="_xs3"],[class^=grid_][class*="_xs3 "],[class^=grid_][class*="_xs3_"]{justify-content:space-evenly}';

// 수직 정렬 규칙
$output .= '[class*=" flex_"][class$="_yt"],[class*=" flex_"][class*="_yt "],[class*=" flex_"][class*="_yt_"],[class*=" grid_"][class$="_yt"],[class*=" grid_"][class*="_yt "],[class*=" grid_"][class*="_yt_"],[class^=flex_][class$="_yt"],[class^=flex_][class*="_yt "],[class^=flex_][class*="_yt_"],[class^=grid_][class$="_yt"],[class^=grid_][class*="_yt "],[class^=grid_][class*="_yt_"]{align-items:start}';
$output .= '[class*=" flex_"][class$="_yc"],[class*=" flex_"][class*="_yc "],[class*=" flex_"][class*="_yc_"],[class*=" grid_"][class$="_yc"],[class*=" grid_"][class*="_yc "],[class*=" grid_"][class*="_yc_"],[class^=flex_][class$="_yc"],[class^=flex_][class*="_yc "],[class^=flex_][class*="_yc_"],[class^=grid_][class$="_yc"],[class^=grid_][class*="_yc "],[class^=grid_][class*="_yc_"]{align-items:center}';
$output .= '[class*=" flex_"][class$="_yu"],[class*=" flex_"][class*="_yu "],[class*=" flex_"][class*="_yu_"],[class*=" grid_"][class$="_yu"],[class*=" grid_"][class*="_yu "],[class*=" grid_"][class*="_yu_"],[class^=flex_][class$="_yu"],[class^=flex_][class*="_yu "],[class^=flex_][class*="_yu_"],[class^=grid_][class$="_yu"],[class^=grid_][class*="_yu "],[class^=grid_][class*="_yu_"]{align-items:end}';
$output .= '[class*=" flex_"][class$="_ys"],[class*=" flex_"][class*="_ys "],[class*=" flex_"][class*="_ys_"],[class*=" grid_"][class$="_ys"],[class*=" grid_"][class*="_ys "],[class*=" grid_"][class*="_ys_"],[class^=flex_][class$="_ys"],[class^=flex_][class*="_ys "],[class^=flex_][class*="_ys_"],[class^=grid_][class$="_ys"],[class^=grid_][class*="_ys "],[class^=grid_][class*="_ys_"]{align-items:stretch}';

// 플렉스 방향 규칙
$output .= '[class*=" flex_"][class$="_ft"],[class*=" flex_"][class*="_ft "],[class*=" flex_"][class*="_ft_"],[class^=flex_][class$="_ft"],[class^=flex_][class*="_ft "],[class^=flex_][class*="_ft_"]{flex-direction:column}';
$output .= '[class*=" flex_"][class$="_fu"],[class*=" flex_"][class*="_fu "],[class*=" flex_"][class*="_fu_"],[class^=flex_][class$="_fu"],[class^=flex_][class*="_fu "],[class^=flex_][class*="_fu_"]{flex-direction:column-reverse}';
$output .= '[class*=" flex_"][class$="_fl"],[class*=" flex_"][class*="_fl "],[class*=" flex_"][class*="_fl_"],[class^=flex_][class$="_fl"],[class^=flex_][class*="_fl "],[class^=flex_][class*="_fl_"]{flex-direction:row}';
$output .= '[class*=" flex_"][class$="_fr"],[class*=" flex_"][class*="_fr "],[class*=" flex_"][class*="_fr_"],[class^=flex_][class$="_fr"],[class^=flex_][class*="_fr "],[class^=flex_][class*="_fr_"]{flex-direction:row-reverse}';

// 플렉스 랩 규칙
$output .= '[class*=" flex_"][class$="_wrap"],[class*=" flex_"][class*="_wrap "],[class*=" flex_"][class*="_wrap_"],[class^=flex_][class$="_wrap"],[class^=flex_][class*="_wrap "],[class^=flex_][class*="_wrap_"]{flex-wrap:wrap}';
$output .= '[class*=" flex_"][class$="_nowrap"],[class*=" flex_"][class*="_nowrap "],[class*=" flex_"][class*="_nowrap_"],[class^=flex_][class$="_nowrap"],[class^=flex_][class*="_nowrap "],[class^=flex_][class*="_nowrap_"]{flex-wrap:nowrap}';

$output .= '</style>' . PHP_EOL;

// 관리자/테마 스타일시트 로드
if (egb('admin')) {
    if (file_exists(ROOT . DS . 'egb_admin' . DS . 'style.css')) {
        $output .= '<link rel="stylesheet" href="' . DOMAIN . DS . 'egb_admin' . DS . 'style.css">' . PHP_EOL;
    }
} else {
    if (file_exists(ROOT . THEMES_PATH . DS . 'style.css')) {
        $output .= '<link rel="stylesheet" href="' . THEMES_STYLE . '">' . PHP_EOL;
    }
}

// title 로드
$output .= "<title class='daum-wm-title'>" . $page_title . "</title>" . PHP_EOL;

// 추가 사용자 설정 로드
$sub_head_file_path = ROOT . THEMES_PATH_SUB_HEAD;
if (file_exists($sub_head_file_path)) {
    $output .= file_get_contents($sub_head_file_path);
}

if (file_exists(ROOT . THEMES_PATH . DS . 'cookie.php')) {
    require_once(ROOT . THEMES_PATH . DS . 'cookie.php');
}
?>

<!DOCTYPE html>
<html lang="ko" style="font-size: 1rem;">
    <head>
    <?php
    if (file_exists(ROOT . THEMES_PATH . DS . 'License_used.php')) {
        require_once ROOT . THEMES_PATH . DS . 'License_used.php';
    }
    
    echo $output;
    
    if (file_exists(ROOT . THEMES_PATH . DS . 'style.php')) {
        require_once ROOT . THEMES_PATH . DS . 'style.php';
    }
    ?>
    <?php 

function egb_push_script($events, $handlers){
    if (empty($_SESSION['user_uniq_id'])) {
        return;
    }
    $nonce = NONCE;
    $userId    = $_SESSION['user_uniq_id'];
    $eventsJs  = json_encode(array_values($events), JSON_UNESCAPED_SLASHES);
    $handlerJs = '';
    foreach ($handlers as $evt => $body) {
        $handlerJs .= "'{$evt}': function(data) { {$body} },\n";
    }

    echo <<<HTML
<script id="egbPushScript" nonce="{$nonce}">
    document.addEventListener('DOMContentLoaded', function() {
        const userId   = '{$userId}';
        const events   = {$eventsJs};
        const handlers = {
            {$handlerJs}
        };
        EGB.push.init(userId, events, handlers);
    });
</script>
HTML;
}


// 푸시 알림을 받을 이벤트와 핸들러 정의
$events = ['new-comment', 'new-reply', 'new-like', 'new-scrap'];
$handlers = [
    'new-comment' => "updateAlarmUI();",
    'new-reply'   => "updateAlarmUI();",
    'new-like'    => "updateAlarmUI();",
    'new-scrap'   => "updateAlarmUI();"
];

// egb_push 스크립트 자동 출력
egb_push_script($events, $handlers);
?>
    </head>
    <body class="fontstyle1">
<noscript class="flex_ft_xc_yc main_box">
<div>이 사이트의 기능을 모두 활용하기 위해서는 자바스크립트를 활성화 시킬 필요가 있습니다.</div>
<div><a class="flv9 font_style_underline pointer" href="https://www.enable-javascript.com/ko/">브라우저에서 자바스크립트를 활성화하는 방법</a>을 참고 하세요.</div>
<style>
#egb_contents {display: none;}
br {display: none;}
</style>
</noscript>
<?php
if (file_exists(ROOT . THEMES_PATH . DS . 'font_auto.php')) {
    require_once(ROOT . THEMES_PATH . DS . 'font_auto.php');
}
?>
<?php 
if (file_exists(ROOT . THEMES_PATH . DS . 'channeltalk.php')) {
    $channeltalk = DOMAIN . THEMES_PATH . DS . 'channeltalk.php';
}
?>
CODE;

// db-constant.php 파일 생성
egb_upload($head_file_path, $head_file_name, $head_file_contents);
}else{}

//체크 파일 수정
$site_check_file_path = DS;
$site_check_file_name = "egb_site-check.php";
$site_check_file_contents = '<?php define(\'SITE_CHECK\', \'3\'); ?>'; 

// site-check.php 파일 내용 3로 수정
egb_upload($site_check_file_path, $site_check_file_name, $site_check_file_contents);

$themes_path_file_path = DS . "egb_setting" . DS . "egb_constant_2" . DS;
$themes_path_file_name = "003-egb_themes_path.php";
$themes_path_file_contents = "<?php

// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset(\$_SERVER['HTTPS']) and \$_SERVER['HTTPS'] === 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo \"<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='\". PROTOCOL.\$_SERVER['HTTP_HOST'].\"'; </script>\";exit;}

if (!defined('THEMES_NAME')) {define('THEMES_NAME', 'eungabi');}

if (!defined('THEMES_PATH')) {define('THEMES_PATH', DS . 'egb_themes' . DS . THEMES_NAME);}

if (!defined('THEMES_PATH_INDEX')) {define('THEMES_PATH_INDEX', DS . 'egb_themes' . DS . THEMES_NAME. DS . 'index.php');}

if (!defined('THEMES_PATH_HEAD')) {define('THEMES_PATH_HEAD', DS . 'egb_themes' . DS .THEMES_NAME . DS . 'head.php');}

if (!defined('THEMES_PATH_SUB_HEAD')) {define('THEMES_PATH_SUB_HEAD', DS . 'egb_themes' . DS . THEMES_NAME . DS . 'sub_head.php');}

if (!defined('THEMES_STYLE')) {define('THEMES_STYLE', '" . DOMAIN . "' . DS . 'egb_themes' . DS . THEMES_NAME . DS . 'style.css');}

?>";

// themes-path 파일 생성
egb_upload($themes_path_file_path, $themes_path_file_name, $themes_path_file_contents);

$main_font_size_file_path = DS . "egb_setting" . DS . "egb_constant_2" . DS;
$main_font_size_file_name = "004-egb_main_font_size.php";
$main_font_size_file_contents = "<?php

// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset(\$_SERVER['HTTPS']) and \$_SERVER['HTTPS'] === 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo \"<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='\". PROTOCOL.\$_SERVER['HTTP_HOST'].\"'; </script>\";exit;}

if (!defined('EGB_MAIN_FONT_SIZE')) {define('EGB_MAIN_FONT_SIZE', 'font_fe_016');}

if (!defined('CSS_LOAD_COUNT')) {define('CSS_LOAD_COUNT', '040');}

?>";

// themes-path 파일 생성
egb_upload($main_font_size_file_path, $main_font_size_file_name, $main_font_size_file_contents);

// head-constant.php 생성
$board_perma_link_file_path = "/egb_setting/egb_constant_2/";
$board_perma_link_file_name = "005-egb_board_perma_link.php";
$board_perma_link_file_contents = "<?php

// 개별 페이지 접근 불가
if (!defined('PROTOCOL')) { if (isset(\$_SERVER['HTTPS']) and \$_SERVER['HTTPS'] === 'on') {define('PROTOCOL', 'https://');}else{define('PROTOCOL', 'http://');}} // 프로토콜 상수 설정
if (!defined('_EUNGABI_')) {echo \"<script type=\'text/javascript\'> alert(\'개별 페이지 접근 권한이 없습니다.\'); window.location.href='\". PROTOCOL.\$_SERVER['HTTP_HOST'].\"'; </script>\";exit;}

//head의 기본 mata 데이터 상수 선언
if (!defined('MATA_TITLE')) {define('MATA_TITLE', '" . $seo_title . "');}
if (!defined('MATA_SUBJECT')) {define('MATA_SUBJECT', '" . $seo_subject . "');}
if (!defined('MATA_DESCRIPTION')) {define('MATA_DESCRIPTION', '" . $seo_description . "');}
if (!defined('MATA_KEYWORD')) {define('MATA_KEYWORD', '" . $seo_keywords . "');}
if (!defined('MATA_ROBOTS')) {define('MATA_ROBOTS', '" . $seo_robots . "');}
if (!defined('MATA_AUTHOR')) {define('MATA_AUTHOR', '" . $seo_author . "');}
if (!defined('SITE_TITLE')) {define('SITE_TITLE', '" . $page_title . "');}

if (!defined('BOARD_PERMA_LINK')) {define('BOARD_PERMA_LINK', 'short_url_route_short_url');}

?>
"; 

// 파일 생성
egb_upload($board_perma_link_file_path, $board_perma_link_file_name, $board_perma_link_file_contents);

//008-PHPMAILER_CONSTANT
$php_mailer_constant_file_path = "/egb_setting/egb_constant_2/";
$php_mailer_constant_file_name = "008-PHPMAILER_CONSTANT.php";
$php_mailer_constant_file_contents = "<?php

if (!defined('PHPMAILER_EMAIL')) {define('PHPMAILER_EMAIL', 'ibik@ibik.kr');}
if (!defined('PHPMAILER_EMAIL_PASSWORD')) {define('PHPMAILER_EMAIL_PASSWORD', 'qkdgodls1!');}
if (!defined('PHPMAILER_HOST')) {define('PHPMAILER_HOST', 'smtps.hiworks.com');}
if (!defined('PHPMAILER_PORT')) {define('PHPMAILER_PORT', '465');}
if (!defined('PHPMAILER_SMTP_SECURE')) {define('PHPMAILER_SMTP_SECURE', 'ssl');}
if (!defined('PHPMAILER_CHARSET')) {define('PHPMAILER_CHARSET', 'UTF-8');}
if (!defined('PHPMAILER_ENCODING')) {define('PHPMAILER_ENCODING', 'base64');}

?>";

// 파일 생성
egb_upload($php_mailer_constant_file_path, $php_mailer_constant_file_name, $php_mailer_constant_file_contents);

//head 생성 후 새로고침
redirect(DOMAIN);

?>
