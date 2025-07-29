<?php
function egb_route() {
	// 중복 호출 방지
	static $route_called = false;
	if ($route_called) {
		return;
	}
	$route_called = true;
	
	// 현재 요청된 URL 경로 추출
	$request_uri = $_SERVER['REQUEST_URI'];
	$script_name = $_SERVER['SCRIPT_NAME'];
	$base_path = rtrim(dirname($script_name), DS);
	$path_info = substr($request_uri, strlen($base_path));
	
	// 경로를 /로 분리하여 배열로 저장
	$segments = explode(DS, trim($path_info, DS));
	
	if (strpos($segments[0], '?') == 0 && strpos($segments[0], '?') !== false) {egb_img(); egb_video(); egb_plugin_file_load(); egb_post(); egb_page_check(); exit;}
	if ($segments[0] == '') {
        
		// 메인 페이지 렌더링시에만 출력 버퍼 시작
		ob_start();
		
		$query = "SELECT * FROM egb_page WHERE page_name = :page_name AND page_theme = :page_theme";
		$param = [':page_name' => 'main', ':page_theme' => THEMES_NAME];
		$binding = binding_sql(1, $query, $param);
		$sql = egb_sql($binding);
		
		if (!empty($sql)) {
			if (!defined('UNIQ_ID')) {define('UNIQ_ID', $sql[0]['uniq_id'] ?? null);}
			if (!defined('PAGE')) {define('PAGE', $sql[0]['page_name'] ?? null);}
			if (!defined('PAGE_CONTENT')) {define('PAGE_CONTENT', $sql[0]['page_path'] ?? null);}
			if (!defined('PAGE_TYPE')) {define('PAGE_TYPE', $sql[0]['page_type'] ?? null);}
			if (!defined('PAGE_USE')) {define('PAGE_USE', $sql[0]['page_use'] ?? null);}
			
			if (defined('PAGE_USE') and (PAGE_USE == 1)){
				if (isset($sql[0]['page_seo']) && $sql[0]['page_seo'] == 1){
					egb_page_meta(
						$sql[0]['page_title'], 
						$sql[0]['page_path'],
						$sql[0]['seo_title'],
						$sql[0]['seo_subject'],
						$sql[0]['seo_description'],
						$sql[0]['seo_keywords'],
						$sql[0]['seo_robots'],
						$sql[0]['seo_author'],
						$sql[0]['seo_og_img'],
						$sql[0]['created_at'],
						$sql[0]['updated_at']
					);
				} else {
					egb_page_meta(
						$sql[0]['page_title'],
						$sql[0]['page_path'],
						null, null, null, null,
						'nofollow, noindex',
						'Eungabi',
						DS . 'egb_thumbnail.webp',
						$sql[0]['created_at'],
						$sql[0]['updated_at']
					);
				}
				
				if (defined('UNIQ_ID')){
					if (!defined('PAGE_HEADER_USE')) {define('PAGE_HEADER_USE', $sql[0]['setting_header_use'] ?? 'N');}
					if (!defined('PAGE_FOOTER_USE')) {define('PAGE_FOOTER_USE', $sql[0]['setting_footer_use'] ?? 'N');}
					if (!defined('PAGE_COMMENT_USE')) {define('PAGE_COMMENT_USE', $sql[0]['setting_comment_use'] ?? 'N');}
					if (!defined('PAGE_ACCESS_LEVEL')) {define('PAGE_ACCESS_LEVEL', $sql[0]['setting_access_level'] ?? '0');}
				}
			} else {
				echo '메인 페이지를 사용할 수 없거나 미사용 상태입니다.';
				exit;
			}
		}
		
		admin_top_box();
		egb_load(THEMES_PATH_INDEX);
		
	// 페이지 렌더링 시간 계산 및 출력
	$end_time = microtime(true);
	$render_time = round(($end_time - EGB_START_TIME) * 1000, 2);
	if (defined('EGB_LOG_UNIQ_ID')) {
		egb_get_device(EGB_LOG_UNIQ_ID, $render_time);
		echo '<div class="padding_px-a_020 flex_xc_yc font_size_12">페이지 렌더링 시간: ' . $render_time . 'ms</div>';
	}
	echo '</body>';
	echo '</html>';

	
	// *1회*만 동작할 shutdown hook 등록
    register_shutdown_function(function(){
        // 1) 버퍼에서 전체 HTML 가져오기
        $original = trim(ob_get_clean());
    
        // 2) HTML 본문만 분리 
        $htmlOnly = $original;
    
        // 3) <head>…</head> 블록 분리
        $headScripts   = [];
        $origHeadContent = '';
        if (preg_match('/<head\b[^>]*>(.*?)<\/head>/is', $htmlOnly, $m)) {
            $origHeadContent = $m[1];
            // head 전체를 빈 head 태그로 대체
            $htmlOnly = str_replace($m[0], '<head></head>', $htmlOnly);
        }
    
        // 4) head 안의 <script> 추출
        $cleanHead = preg_replace_callback(
            '/<script\b[^>]*>.*?<\/script>/is',
            function($m) use (&$headScripts) {
                $headScripts[] = $m[0];
                return '';
            },
            $origHeadContent
        );
    
        // 5) body 안의 <script> 추출
        $bodyScripts = [];
        $htmlOnly = preg_replace_callback(
            '/<script\b[^>]*>.*?<\/script>/is',
            function($m) use (&$bodyScripts) {
                $bodyScripts[] = $m[0];
                return '';
            },
            $htmlOnly
        );
    
        // 6) 치환된 head + rest 결합
        $htmlClean = "<head>{$cleanHead}</head>" . $htmlOnly;
    
        // ——— 6.1) br_ 숫자-숫자 커스텀 태그를 단일 <br class="br_x-y">로 변환 ———
        $htmlClean = preg_replace_callback(
            '#<(\/?)br_([0-9]+-[0-9]+)\b[^>]*>#i',
            function($m){
                // 닫는 태그면 삭제
                if ($m[1] === '/') {
                    return '';
                }
                // 여는 태그면 단일 <br class="br_x-y">
                return '<br class="br_'.$m[2].'">';
            },
            $htmlClean
        );
    
        // 7) DOM 파싱 (스크립트 없는 상태)
        libxml_use_internal_errors(true);
        $dom = new DOMDocument('1.0','UTF-8');
        $dom->loadHTML('<?xml encoding="UTF-8">'.$htmlClean, LIBXML_HTML_NOIMPLIED|LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // egb_schema 태그 찾기 및 처리 - DOM 파싱 직후로 이동
        $schemaTypes = [];
        foreach($xpath->query('//egb_schema') as $schema) {
            $type = $schema->getAttribute('type');
            $dataAttrs = [];
            foreach ($schema->attributes as $attr) {
                if (strpos($attr->name, 'data-schema-') === 0) {
                    $key = substr($attr->name, 12);
                    $dataAttrs[$key] = $attr->value;
                }
            }
            $schemaTypes[] = ['type' => $type, 'data' => $dataAttrs];
            
            // 파싱 후 해당 노드 삭제
            $schema->parentNode->removeChild($schema);
        }
    
        // html lang 속성 추가
        $htmlElement = $dom->getElementsByTagName('html')->item(0);
        if ($htmlElement) {
            $htmlElement->setAttribute('lang', 'ko');
        }
    
        // alt 없는 이미지에 alt 추가 및 지연로딩 적용
        foreach ($xpath->query('//img') as $img) {
            // alt 속성이 없으면 빈 alt 추가
            if (!$img->hasAttribute('alt')) {
                $img->setAttribute('alt', '이미지');
            }
            
            // img_fast_load 클래스가 있는 이미지는 제외하고 지연로딩 적용
            if ($img->hasAttribute('class') && strpos($img->getAttribute('class'), 'img_fast_load') !== false) {
                continue;
            }
            $img->setAttribute('loading', 'lazy');
        }
    
        // --- egb SSR 로직 시작 ---
    
    
        
        // 8) 클래스와 태그, ID 수집
        $classes = [];
        $tags = [];
        $ids = [];
        
        // 클래스, 태그, ID 동시 수집
        foreach ($xpath->query('//*') as $el) {
            // 태그명 수집
            $tags[$el->tagName] = true;
            
            // 클래스가 있는 경우 수집
            if ($el->hasAttribute('class')) {
                foreach (preg_split('/\s+/', trim($el->getAttribute('class'))) as $cls) {
                    if ($cls !== '') $classes[$cls] = true;
                }
            }
    
            // ID가 있는 경우 수집
            if ($el->hasAttribute('id')) {
                $ids[$el->getAttribute('id')] = true;
            }
        }
    
        // 태그 기반 스크립트 매핑 [src, position, loading]
        $tagScriptMap = [
            'html' => [['/js/egb_function', 'head']],
            'form' => [
                ['/js/egb_ajax', 'head', 'async'],
                ['/js/egb_form', 'head', 'defer']
            ],
            'style' => [['/js/egb_style', 'head', 'defer']],
            'img' => [['/js/egb_img', 'head', 'defer']]
        ];
    
        // 클래스 기반 스크립트 매핑 (정확히 일치하는 경우)
        $classScriptMap = [
            'slide_egb_main_box' => [['/js/egb_slide', 'head', 'async']],
            'egb_spa' => [['/js/egb_spa', 'head', 'defer']],
            'egb_qna' => [['/js/egb_qna', 'head', 'defer']],
            'egb_qna_accordion' => [['/js/egb_qna', 'head', 'defer']],
            'egb_admin_page' => [['/js/egb_admin', 'head', 'defer']]
        ];
    
        // 클래스 기반 스크립트 매핑 (부분 일치하는 경우)
        $classPatternScriptMap = [
            'egb_radio_' => [['/js/egb_radio', 'head', 'defer']]
        ];
    
        // ID 기반 스크립트 매핑
        $idScriptMap = [
            'egb_push' => [
                ['/js/pusher', 'head'],
                ['/js/ably', 'head', 'defer'],
                ['/js/egb_push', 'head', 'defer']
            ],
            'egb_masonry' => [['/js/egb_masonry', 'head', 'defer']]
        ];
    
        // 스크립트 로드 대상 수집
        $scriptsToLoad = [];
        
        // 태그 기반 스크립트 추가
        foreach ($tagScriptMap as $tag => $scripts) {
            if (isset($tags[$tag])) {
                foreach ($scripts as $script) {
                    list($src, $position) = $script;
                    $loading = $script[2] ?? null;
                    $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                }
            }
        }
    
        // 클래스 기반 스크립트 추가 (정확히 일치하는 경우)
        foreach ($classScriptMap as $class => $scripts) {
            if (isset($classes[$class])) {
                foreach ($scripts as $script) {
                    list($src, $position) = $script;
                    $loading = $script[2] ?? null;
                    $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                }
            }
        }
    
        // 클래스 기반 스크립트 추가 (부분 일치하는 경우)
        foreach ($classPatternScriptMap as $pattern => $scripts) {
            foreach ($classes as $class => $value) {
                if (strpos($class, $pattern) === 0) { // 패턴으로 시작하는지 확인
                    foreach ($scripts as $script) {
                        list($src, $position) = $script;
                        $loading = $script[2] ?? null;
                        $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                    }
                    break; // 하나라도 매칭되면 해당 패턴의 스크립트는 한 번만 추가
                }
            }
        }
    
        // ID 기반 스크립트 추가 
        foreach ($idScriptMap as $id => $scriptList) {
            if (isset($ids[$id])) {
                foreach ($scriptList as $script) {
                    list($src, $position) = $script;
                    $loading = $script[2] ?? null;
                    $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                }
            }
        }

        // push 관련 스크립트가 로드되지 않을 때 egbPushScript 요소 제거
        if (!isset($scriptsToLoad['/js/pusher']) && !isset($scriptsToLoad['/js/ably']) && !isset($scriptsToLoad['/js/egb_push'])) {
            // DOM에서 직접 제거
            foreach ($xpath->query("//script[@id='egbPushScript']") as $pushScriptEl) {
                $pushScriptEl->parentNode->removeChild($pushScriptEl);
            }
            
            // 스크립트 배열에서도 제거
            $headScripts = array_values(array_filter($headScripts, function($script) {
                return strpos($script, 'id="egbPushScript"') === false;
            }));
            $bodyScripts = array_values(array_filter($bodyScripts, function($script) {
                return strpos($script, 'id="egbPushScript"') === false;
            }));
        }
    
        // DNS 미리 조회와 TCP/SSL 미리 연결을 위한 도메인 수집
        $domains = [];
        foreach ($scriptsToLoad as $src => $config) {
            if (preg_match('/^(?:https?:)?\/\/([^\/]+)/', $src, $matches)) {
                $domains[$matches[1]] = true;
            }
        }
        foreach ($xpath->query('//img[@src]') as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/^(?:https?:)?\/\/([^\/]+)/', $src, $matches)) {
                $domains[$matches[1]] = true;
            }
        }
    
        // 수동으로 추가할 도메인들
        $manualDomains = [
            'cdn.jsdelivr.net'
        ];
    
        foreach ($manualDomains as $domain) {
            if (!isset($domains[$domain]) && $domain !== HOST) {
                $domains[$domain] = true;
            }
        }
    
        // 라디오 그룹 처리
        $radioGroups = array_filter(
            array_keys($classes),
            function($cls) {
                return strpos($cls, 'egb_radio_') === 0;
            }
        );
        if (!empty($radioGroups)) {
            // 그룹명만 추출 → 순차 인덱스 배열로 재정렬
            $groupNames = array_map(
                fn($full) => substr($full, strlen('egb_radio_')), 
                $radioGroups
            );
            $groupNames = array_values($groupNames);  // 0,1,2... 순차 인덱스 부여
    
            $json = htmlspecialchars(json_encode($groupNames), ENT_QUOTES);
    
            // <head>에 JSON 메타 삽입
            $headEl = $dom->getElementsByTagName('head')->item(0);
            if ($headEl) {
                $metaScript = $dom->createElement('script');
                $metaScript->setAttribute('id', 'egb-radio-group-data');
                $metaScript->setAttribute('type', 'application/json');
                $metaScript->setAttribute('nonce', NONCE);
                $metaScript->appendChild($dom->createTextNode($json));
                $headEl->appendChild($metaScript);
            }
        }
    
        // 수집된 클래스들을 JSON으로 변환하여 스크립트 태그에 삽입
        $classesJson = json_encode(array_keys($classes));
        $headEl = $dom->getElementsByTagName('head')->item(0);
        if ($headEl) {
            $classesScript = $dom->createElement('script');
            $classesScript->setAttribute('id', 'egb-class-data');
            $classesScript->setAttribute('type', 'application/json');
            $classesScript->setAttribute('nonce', NONCE);
            $classesScript->appendChild($dom->createTextNode($classesJson));
            $headEl->appendChild($classesScript);
        }
    
        // 이미지 미리 로드 처리 - 최상단으로 이동
        $preloadImages = [];
        foreach ($xpath->query('//img[contains(@class, "img_fast_load")]') as $img) {
            if ($img->hasAttribute('src')) {
                $src = $img->getAttribute('src');
                // 중복 제거를 위해 src를 키로 사용
                $preloadImages[$src] = true;
            }
        }
    
        // 9) data-* 속성 처리 & data-xy 처리
        $dataValues = [];
        $xyMap      = [];
        $attrs = [
            'bg-color'=>'background-color',
            'color'=>'color',
            'hover-bg-color'=>'background-color-hover',
            'hover-color'=>'color-hover',
            'bg-img'=>'background-image',
            'hover-bg-img'=>'background-image-hover',
            'box-shadow'=>'box-shadow',
            'hover-box-shadow'=>'box-shadow-hover',
            'top'=>'top','bottom'=>'bottom','left'=>'left','right'=>'right',
            'xx'=>'grid-template-columns','yy'=>'grid-template-rows',
            'bd-a-color'=>'border-top-color;border-right-color;border-bottom-color;border-left-color',
            'bd-t-color'=>'border-top-color','bd-r-color'=>'border-right-color',
            'bd-b-color'=>'border-bottom-color','bd-l-color'=>'border-left-color',
            'bd-x-color'=>'border-left-color;border-right-color','bd-y-color'=>'border-top-color;border-bottom-color',
            'hover-bd-a-color'=>'border-top-color-hover;border-right-color-hover;border-bottom-color-hover;border-left-color-hover',
            'hover-bd-t-color'=>'border-top-color-hover',
            'hover-bd-r-color'=>'border-right-color-hover',
            'hover-bd-b-color'=>'border-bottom-color-hover',
            'hover-bd-l-color'=>'border-left-color-hover',
            'hover-bd-x-color'=>'border-left-color-hover;border-right-color-hover',
            'hover-bd-y-color'=>'border-top-color-hover;border-bottom-color-hover',
            // border 속성들
            'border-top'=>'border-top',
            'border-bottom'=>'border-bottom', 
            'border-left'=>'border-left',
            'border-right'=>'border-right',
            //애니메이션 속성들
            'transition'=>'transition',
            'hover-transition'=>'transition-hover',
            'transform'=>'transform',
            'hover-transform'=>'transform-hover',
            'animation'=>'animation',
            'hover-animation'=>'animation-hover',
            'animation-delay'=>'animation-delay',
            'hover-animation-delay'=>'animation-delay-hover',
            'animation-duration'=>'animation-duration',
            'hover-animation-duration'=>'animation-duration-hover',
            'animation-iteration-count'=>'animation-iteration-count',
            'hover-animation-iteration-count'=>'animation-iteration-count-hover',
            'animation-direction'=>'animation-direction',
            'hover-animation-direction'=>'animation-direction-hover',
            'animation-fill-mode'=>'animation-fill-mode',
            'hover-animation-fill-mode'=>'animation-fill-mode-hover',
            'animation-play-state'=>'animation-play-state',
            'hover-animation-play-state'=>'animation-play-state-hover',
            'animation-timing-function'=>'animation-timing-function',
            'hover-animation-timing-function'=>'animation-timing-function-hover',
            'animation-name'=>'animation-name',
            'hover-animation-name'=>'animation-name-hover'
        ];
        foreach ($xpath->query('//*') as $el) {
            foreach ($attrs as $dataAttr => $props) {
                if ($el->hasAttribute("data-{$dataAttr}")) {
                    $val = $el->getAttribute("data-{$dataAttr}");
                    $dataValues[$dataAttr][$val] = true;
                }
            }
            if ($el->hasAttribute('data-xy')) {
                $raw  = $el->getAttribute('data-xy');
                $rand = 'xy_'.bin2hex(random_bytes(4));
                $el->setAttribute('class', trim($el->getAttribute('class')).' '.$rand);
                $xyMap[$rand] = $raw;
            }
        }
    
        // 10) 색상 보정이 필요한 요소들의 색상 정보 수집
        $colorElements = [];
        foreach ($xpath->query('//*[@data-color or @data-bg-color]') as $el) {
            // no_color_change 클래스가 있으면 건너뛰기
            if (strpos($el->getAttribute('class'), 'no_color_change') !== false) {
                continue;
            }
    
            $elementInfo = [
                'element' => $el,
                'bg_color' => null,
                'fg_colors' => [],
                'has_content' => trim($el->textContent) !== '' // 내용 존재 여부 체크
            ];
    
            // 배경색 찾기 (자신 또는 부모 요소에서)
            $current = $el;
            while ($current && $current->nodeType === XML_ELEMENT_NODE) {
                if ($current->hasAttribute('data-bg-color')) {
                    $elementInfo['bg_color'] = $current->getAttribute('data-bg-color');
                    break;
                }
                $current = $current->parentNode;
            }
    
            // 전경색 수집 (자신과 모든 자식 요소들에서)
            $colorNodes = $xpath->query('.//*[@data-color]|self::*[@data-color]', $el);
            foreach ($colorNodes as $node) {
                // no_color_change 클래스가 있는 노드는 건너뛰기
                if (strpos($node->getAttribute('class'), 'no_color_change') === false) {
                    $elementInfo['fg_colors'][] = $node->getAttribute('data-color');
                }
            }
    
            $colorElements[] = $elementInfo;
        }
    
        // 11) CSS 생성 & APCu 캐시 조회
        $cacheKey = 'egb_css_'.md5(json_encode([
            'classes'=>array_keys($classes),
            'data'   =>$dataValues,
            'xy'     =>array_values($xyMap),
            'ids'    =>array_keys($ids),
        ]));
        if (function_exists('apcu_fetch') && ($css = apcu_fetch($cacheKey))) {
            // 캐시 히트
        } else {
            $css  = '';
            // 클래스 기반 CSS
            if (!empty($classes)) {
                $css .= egb_ssr_style(array_keys($classes));
            }
            // data-xy 미디어쿼리
            if (!empty($xyMap)) {
                $css .= egb_ssr_data_xy($xyMap);
            }
            // ─── br_숫자-숫자 범위 클래스 CSS 추가 ───
            foreach (array_keys($classes) as $cls) {
                if (preg_match('/^br_(\d+)-(\d+)$/', $cls, $m)) {
                    // 기본 숨김
                    $css .= ".{$cls}{display:none;}\n";
                    // 지정된 범위에서만 표시
                    $css .= "@media (min-width:{$m[1]}px) and (max-width:{$m[2]}px){";
                    $css .= ".{$cls}{display:block;}";
                    $css .= "}\n";
                }
            }
            // 기타 data-* CSS
            foreach ($dataValues as $attr => $vals) {
                foreach (array_keys($vals) as $val) {
                    if ($attr === 'hover-color' || $attr === 'hover-bg-color' || $attr === 'hover-box-shadow' || $attr === 'hover-transition' || $attr === 'hover-transform') {
                        $css .= "[data-{$attr}=\"{$val}\"]:hover{";
                    } else {
                        $css .= "[data-{$attr}=\"{$val}\"]{";
                    }
                    foreach (explode(';', $attrs[$attr]) as $prop) {
                        if ($prop === 'color-hover') {
                            $css .= "color:{$val};";
                        } else if ($prop === 'background-color-hover') {
                            $css .= "background-color:{$val};";
                        } else if ($prop === 'box-shadow-hover') {
                            $css .= "box-shadow:{$val};";
                        } else if ($prop === 'background-image') {
                            $css .= "{$prop}:url({$val});";
                        } else if ($prop === 'transition-hover') {
                            $css .= "transition:{$val};";
                        } else if ($prop === 'transform-hover') {
                            $css .= "transform:{$val};";
                        } else {
                            $css .= "{$prop}:{$val};";
                        }
                    }
                    $css .= "}\n";
                }
            }
            if (function_exists('apcu_store')) {
                apcu_store($cacheKey, $css, 300);
            }
        }
    
        // 12) WCAG AAA 대비 색상 보정 함수 (대비율 7.0 이상 보장)
        $adjustColorContrast = function(string $bg, string $fg): array {
            // 유효한 16진수 색상 코드인지 검증
            if (!preg_match('/^#[0-9A-Fa-f]{6}$/',$bg) || !preg_match('/^#[0-9A-Fa-f]{6}$/',$fg)) {
                return [$bg, $fg];
            }
    
            // 배경색과 전경색을 RGB로 변환
            sscanf($bg,'#%02x%02x%02x',$rBG,$gBG,$bBG); 
            sscanf($fg,'#%02x%02x%02x',$rFG,$gFG,$bFG);
    
            // sRGB to 선형 RGB 변환 함수
            $lin = fn($c)=>($c/=255)<=0.03928 ? $c/12.92 : pow(($c+0.055)/1.055,2.4);
    
            // 상대 휘도 계산
            $Lbg = 0.2126*$lin($rBG)+0.7152*$lin($gBG)+0.0722*$lin($bBG);
            $Lfg = 0.2126*$lin($rFG)+0.7152*$lin($gFG)+0.0722*$lin($bFG);
    
            // 대비율 계산 및 조정 방향 결정
            $ratio = max(($Lbg+0.05)/($Lfg+0.05), ($Lfg+0.05)/($Lbg+0.05));
            
            // 대비율이 7.0 미만인 경우에만 조정
            if ($ratio < 7.0) {
                // 전경색이 배경색보다 밝은 경우
                if ($Lfg > $Lbg) {
                    // 전경색을 더 밝게, 배경색을 더 어둡게
                    while ($ratio < 7.0 && ($rFG < 255 || $gFG < 255 || $bFG < 255 || $rBG > 0 || $gBG > 0 || $bBG > 0)) {
                        if ($rFG < 255) $rFG = min(255, $rFG + 5);
                        if ($gFG < 255) $gFG = min(255, $gFG + 5);
                        if ($bFG < 255) $bFG = min(255, $bFG + 5);
                        if ($rBG > 0) $rBG = max(0, $rBG - 5);
                        if ($gBG > 0) $gBG = max(0, $gBG - 5);
                        if ($bBG > 0) $bBG = max(0, $bBG - 5);
                        
                        $Lbg = 0.2126*$lin($rBG)+0.7152*$lin($gBG)+0.0722*$lin($bBG);
                        $Lfg = 0.2126*$lin($rFG)+0.7152*$lin($gFG)+0.0722*$lin($bFG);
                        $ratio = max(($Lbg+0.05)/($Lfg+0.05), ($Lfg+0.05)/($Lbg+0.05));
                    }
                } else {
                    // 전경색을 더 어둡게, 배경색을 더 밝게
                    while ($ratio < 7.0 && ($rFG > 0 || $gFG > 0 || $bFG > 0 || $rBG < 255 || $gBG < 255 || $bBG < 255)) {
                        if ($rFG > 0) $rFG = max(0, $rFG - 5);
                        if ($gFG > 0) $gFG = max(0, $gFG - 5);
                        if ($bFG > 0) $bFG = max(0, $bFG - 5);
                        if ($rBG < 255) $rBG = min(255, $rBG + 5);
                        if ($gBG < 255) $gBG = min(255, $gBG + 5);
                        if ($bBG < 255) $bBG = min(255, $bBG + 5);
                        
                        $Lbg = 0.2126*$lin($rBG)+0.7152*$lin($gBG)+0.0722*$lin($bBG);
                        $Lfg = 0.2126*$lin($rFG)+0.7152*$lin($gFG)+0.0722*$lin($bFG);
                        $ratio = max(($Lbg+0.05)/($Lfg+0.05), ($Lfg+0.05)/($Lbg+0.05));
                    }
                }
            }
    
            return [
                sprintf("#%02x%02x%02x", $rBG, $gBG, $bBG),
                sprintf("#%02x%02x%02x", $rFG, $gFG, $bFG)
            ];
        };
    
        // 13) 각 요소에 대해 색상 보정 적용
        foreach ($colorElements as $info) {
            $el = $info['element'];
            $bg = $info['bg_color'];
            
            // 배경색이 있는 경우에만 색상 보정 처리
            if ($bg !== null) {
                // 각 전경색에 대해 보정 처리
                foreach ($info['fg_colors'] as $fg) {
                    list($newBg, $newFg) = $adjustColorContrast($bg, $fg);
                    if ($newBg !== $bg || $newFg !== $fg) {
                        $rand = 'color-'.bin2hex(random_bytes(4));
                        $el->setAttribute('class', trim($el->getAttribute('class')).' '.$rand);
                        $css .= ".{$rand} { background-color: {$newBg}; color: {$newFg}; }\n";
                    }
                }
                
                // 전경색이 없는 경우, 내용이 있을 때만 기본 검정색으로 보정
                if (empty($info['fg_colors']) && $info['has_content']) {
                    list($newBg, $newFg) = $adjustColorContrast($bg, '#000000');
                    $rand = 'color-'.bin2hex(random_bytes(4));
                    $el->setAttribute('class', trim($el->getAttribute('class')).' '.$rand);
                    $css .= ".{$rand} { background-color: {$newBg}; color: {$newFg}; }\n";
                }
            }
        }
    
        // 14) <head>와 <body> 엘리먼트 준비
        $headEl = $dom->getElementsByTagName('head')->item(0) 
               ?: $dom->createElement('head');
        $bodyEl = $dom->getElementsByTagName('body')->item(0)
               ?: $dom->createElement('body');
    
        if (!empty($css)) {
            // SSR 스타일 추가
            $ssrStyleEl = $dom->createElement('style', "\n{$css}\n");
            $ssrStyleEl->setAttribute('nonce', NONCE);
            $ssrStyleEl->setAttribute('id', 'egb_ssr_style');
            $headEl->appendChild($ssrStyleEl);
        }
    
        // 15) 중복 검사용 기존 스크립트 수집
        $existingScripts = [];
        foreach ($dom->getElementsByTagName('script') as $s) {
            if ($s->hasAttribute('src')) {
                $existingScripts[$s->getAttribute('src')] = true;
            }
        }
    
        // 16) 위치 제어하며 스크립트 주입
        foreach ($scriptsToLoad as $src => $config) {
            if (isset($existingScripts[$src])) {
                continue;
            }
            $scriptEl = $dom->createElement('script');
            $scriptEl->setAttribute('src', $src);
            if ($config['loading'] === 'async' || $config['loading'] === 'defer') {
                $scriptEl->setAttribute($config['loading'], '');
            }
            $scriptEl->setAttribute('nonce', NONCE);
    
            if ($config['position'] === 'body') {
                // body 끝에 추가
                $bodyEl->appendChild($scriptEl);
            } else {
                // 기본 head에 추가
                $headEl->appendChild($scriptEl);
            }
        }
    
        // CSR 스타일 추가
        $csrStyleEl = $dom->createElement('style', '');
        $csrStyleEl->setAttribute('id', 'egb_csr_style'); 
        $csrStyleEl->setAttribute('nonce', NONCE);
        $headEl->appendChild($csrStyleEl);
    
        if (!$dom->getElementsByTagName('head')->length) {
            $htmlElement = $dom->getElementsByTagName('html')->item(0);
            if ($htmlElement) {
                $htmlElement->insertBefore($headEl, $htmlElement->firstChild);
            } else {
                // html 태그가 없는 경우 documentElement에 추가
                $dom->appendChild($headEl);
            }
        }

        // 스키마 데이터가 있으면 생성
        if (!empty($schemaTypes)) {
            foreach ($schemaTypes as $schemaItem) {
                $type = $schemaItem['type'];
                $data = !empty($schemaItem['data']) ? $schemaItem['data'] : [];
                
                // egb_schema_autoload로 호출
                $schemaJson = egb_schema($type, $dom, $data);
                
                if ($schemaJson) {
                    $scriptEl = $dom->createElement('script');
                    $scriptEl->setAttribute('type', 'application/ld+json');
                    $scriptEl->setAttribute('id', 'egb_schema_' . $type);
                    $scriptEl->appendChild($dom->createTextNode($schemaJson));
                    $headEl->appendChild($scriptEl);
                }
            }
        }
                
        // 16) 최종 HTML 직렬화
        $out = str_replace('<?xml encoding="UTF-8">', '', html_entity_decode($dom->saveHTML(), ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    
        // 17) head 스크립트 복원 (</head> 바로 앞)
        if (!empty($headScripts)) {
            $inserts = implode("\n", $headScripts);
            $out = preg_replace(
                '/<\/head>/i',
                "\n{$inserts}\n</head>",
                $out,
                1
            );
        }
    
        // egb_csr_script를 head 태그 바로 뒤에 삽입
        $csr_script = egb_csr_script();
        $out = preg_replace(
            '/<head[^>]*>/i',
            "$0\n{$csr_script}",
            $out,
            1
        );
    
        // 18) body 스크립트 복원 (원래 자리 그대로) 
        if (!empty($bodyScripts)) {
            foreach($bodyScripts as $script) {
                $out = preg_replace('/<\/body>/i', $script."\n</body>", $out, 1);
            }
        }
    
        // 19) 도메인 프리커넥트와 이미지 프리로드 링크 생성
        $preconnectLinks = '';
        foreach ($domains as $domain => $value) {
            if ($domain !== HOST) {
                $preconnectLinks .= "<link rel='preconnect' href='https://{$domain}' crossorigin>\n";
                $preconnectLinks .= "<link rel='dns-prefetch' href='https://{$domain}'>\n";
            }
        }
    
        $preloadLinks = '';
        foreach (array_keys($preloadImages) as $imgSrc) {
            $preloadLinks .= "<link rel='preload' as='image' href='{$imgSrc}'>\n";
        }
    
        // 20) <!DOCTYPE html> 뒤에 프리커넥트와 프리로드 링크 삽입
        $out = "<!DOCTYPE html>\n" . $preconnectLinks . $preloadLinks . substr($out, strlen("<!DOCTYPE html>\n"));
    
        // 21) 출력
        echo $out;
    });



	exit;
	}
	if ($segments[0] == 'cron') {
		if (egb('cron')){
			$cron = egb('cron');
			if ($cron == 'test'){
				if (defined('EGB_USER_IP') && EGB_USER_IP == '117.52.89.210') {
					require_once ROOT.DS.'egb_cron'.DS.'index.php';
				}
			}
		}
		exit;
	}
	if ($segments[0] == 'admin') {
		// 페이지 렌더링시에만 출력 버퍼 시작
		ob_start();
		
		$admin_page = isset($segments[1]) ? $segments[1] : 'page';
		$GLOBALS['_EGB']['admin'] = $admin_page;
		$GLOBALS['_EGB']['__BLOCKED__'] = true;
		
		egb_admin_meta(); 
		admin_top_box(); 
		egb_file_load(DS. 'egb_admin' . DS . 'index.php' );

		
	// 페이지 렌더링 시간 계산 및 출력
	$end_time = microtime(true);
	$render_time = round(($end_time - EGB_START_TIME) * 1000, 2);
	if (defined('EGB_LOG_UNIQ_ID')) {
		egb_get_device(EGB_LOG_UNIQ_ID, $render_time);
		echo '<div class="padding_px-a_020 flex_xc_yc font_size_12" data-color="#999999">페이지 렌더링 시간: ' . $render_time . 'ms</div>';
	}


	// *1회*만 동작할 shutdown hook 등록
    register_shutdown_function(function(){
        // 1) 버퍼에서 전체 HTML 가져오기
        $original = trim(ob_get_clean());
    
        // 2) HTML 본문만 분리 
        $htmlOnly = $original;
    
        // 3) <head>…</head> 블록 분리
        $headScripts   = [];
        $origHeadContent = '';
        if (preg_match('/<head\b[^>]*>(.*?)<\/head>/is', $htmlOnly, $m)) {
            $origHeadContent = $m[1];
            // head 전체를 빈 head 태그로 대체
            $htmlOnly = str_replace($m[0], '<head></head>', $htmlOnly);
        }
    
        // 4) head 안의 <script> 추출
        $cleanHead = preg_replace_callback(
            '/<script\b[^>]*>.*?<\/script>/is',
            function($m) use (&$headScripts) {
                $headScripts[] = $m[0];
                return '';
            },
            $origHeadContent
        );
    
        // 5) body 안의 <script> 추출
        $bodyScripts = [];
        $htmlOnly = preg_replace_callback(
            '/<script\b[^>]*>.*?<\/script>/is',
            function($m) use (&$bodyScripts) {
                $bodyScripts[] = $m[0];
                return '';
            },
            $htmlOnly
        );
    
        // 6) 치환된 head + rest 결합
        $htmlClean = "<head>{$cleanHead}</head>" . $htmlOnly;
    
        // ——— 6.1) br_ 숫자-숫자 커스텀 태그를 단일 <br class="br_x-y">로 변환 ———
        $htmlClean = preg_replace_callback(
            '#<(\/?)br_([0-9]+-[0-9]+)\b[^>]*>#i',
            function($m){
                // 닫는 태그면 삭제
                if ($m[1] === '/') {
                    return '';
                }
                // 여는 태그면 단일 <br class="br_x-y">
                return '<br class="br_'.$m[2].'">';
            },
            $htmlClean
        );
    
        // 7) DOM 파싱 (스크립트 없는 상태)
        libxml_use_internal_errors(true);
        $dom = new DOMDocument('1.0','UTF-8');
        $dom->loadHTML('<?xml encoding="UTF-8">'.$htmlClean, LIBXML_HTML_NOIMPLIED|LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // egb_schema 태그 찾기 및 처리 - DOM 파싱 직후로 이동
        $schemaTypes = [];
        foreach($xpath->query('//egb_schema') as $schema) {
            $type = $schema->getAttribute('type');
            $dataAttrs = [];
            foreach ($schema->attributes as $attr) {
                if (strpos($attr->name, 'data-schema-') === 0) {
                    $key = substr($attr->name, 12);
                    $dataAttrs[$key] = $attr->value;
                }
            }
            $schemaTypes[] = ['type' => $type, 'data' => $dataAttrs];
            
            // 파싱 후 해당 노드 삭제
            $schema->parentNode->removeChild($schema);
        }
    
        // html lang 속성 추가
        $htmlElement = $dom->getElementsByTagName('html')->item(0);
        if ($htmlElement) {
            $htmlElement->setAttribute('lang', 'ko');
        }
    
        // alt 없는 이미지에 alt 추가 및 지연로딩 적용
        foreach ($xpath->query('//img') as $img) {
            // alt 속성이 없으면 빈 alt 추가
            if (!$img->hasAttribute('alt')) {
                $img->setAttribute('alt', '이미지');
            }
            
            // img_fast_load 클래스가 있는 이미지는 제외하고 지연로딩 적용
            if ($img->hasAttribute('class') && strpos($img->getAttribute('class'), 'img_fast_load') !== false) {
                continue;
            }
            $img->setAttribute('loading', 'lazy');
        }
    
        // --- egb SSR 로직 시작 ---
    
    
        
        // 8) 클래스와 태그, ID 수집
        $classes = [];
        $tags = [];
        $ids = [];
        
        // 클래스, 태그, ID 동시 수집
        foreach ($xpath->query('//*') as $el) {
            // 태그명 수집
            $tags[$el->tagName] = true;
            
            // 클래스가 있는 경우 수집
            if ($el->hasAttribute('class')) {
                foreach (preg_split('/\s+/', trim($el->getAttribute('class'))) as $cls) {
                    if ($cls !== '') $classes[$cls] = true;
                }
            }
    
            // ID가 있는 경우 수집
            if ($el->hasAttribute('id')) {
                $ids[$el->getAttribute('id')] = true;
            }
        }
    
        // 태그 기반 스크립트 매핑 [src, position, loading]
        $tagScriptMap = [
            'html' => [['/js/egb_function', 'head']],
            'form' => [
                ['/js/egb_ajax', 'head', 'async'],
                ['/js/egb_form', 'head', 'defer']
            ],
            'style' => [['/js/egb_style', 'head', 'defer']],
            'img' => [['/js/egb_img', 'head', 'defer']]
        ];
    
        // 클래스 기반 스크립트 매핑 (정확히 일치하는 경우)
        $classScriptMap = [
            'slide_egb_main_box' => [['/js/egb_slide', 'head', 'async']],
            'egb_spa' => [['/js/egb_spa', 'head', 'defer']],
            'egb_qna' => [['/js/egb_qna', 'head', 'defer']],
            'egb_qna_accordion' => [['/js/egb_qna', 'head', 'defer']],
            'egb_admin_page' => [['/js/egb_admin', 'head', 'defer']]
        ];
    
        // 클래스 기반 스크립트 매핑 (부분 일치하는 경우)
        $classPatternScriptMap = [
            'egb_radio_' => [['/js/egb_radio', 'head', 'defer']]
        ];
    
        // ID 기반 스크립트 매핑
        $idScriptMap = [
            'egb_push' => [
                ['/js/pusher', 'head'],
                ['/js/ably', 'head', 'defer'],
                ['/js/egb_push', 'head', 'defer']
            ],
            'egb_masonry' => [['/js/egb_masonry', 'head', 'defer']]
        ];
    
        // 스크립트 로드 대상 수집
        $scriptsToLoad = [];
        
        // 태그 기반 스크립트 추가
        foreach ($tagScriptMap as $tag => $scripts) {
            if (isset($tags[$tag])) {
                foreach ($scripts as $script) {
                    list($src, $position) = $script;
                    $loading = $script[2] ?? null;
                    $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                }
            }
        }
    
        // 클래스 기반 스크립트 추가 (정확히 일치하는 경우)
        foreach ($classScriptMap as $class => $scripts) {
            if (isset($classes[$class])) {
                foreach ($scripts as $script) {
                    list($src, $position) = $script;
                    $loading = $script[2] ?? null;
                    $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                }
            }
        }
    
        // 클래스 기반 스크립트 추가 (부분 일치하는 경우)
        foreach ($classPatternScriptMap as $pattern => $scripts) {
            foreach ($classes as $class => $value) {
                if (strpos($class, $pattern) === 0) { // 패턴으로 시작하는지 확인
                    foreach ($scripts as $script) {
                        list($src, $position) = $script;
                        $loading = $script[2] ?? null;
                        $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                    }
                    break; // 하나라도 매칭되면 해당 패턴의 스크립트는 한 번만 추가
                }
            }
        }
    
        // ID 기반 스크립트 추가 
        foreach ($idScriptMap as $id => $scriptList) {
            if (isset($ids[$id])) {
                foreach ($scriptList as $script) {
                    list($src, $position) = $script;
                    $loading = $script[2] ?? null;
                    $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                }
            }
        }

        // push 관련 스크립트가 로드되지 않을 때 egbPushScript 요소 제거
        if (!isset($scriptsToLoad['/js/pusher']) && !isset($scriptsToLoad['/js/ably']) && !isset($scriptsToLoad['/js/egb_push'])) {
            // DOM에서 직접 제거
            foreach ($xpath->query("//script[@id='egbPushScript']") as $pushScriptEl) {
                $pushScriptEl->parentNode->removeChild($pushScriptEl);
            }
            
            // 스크립트 배열에서도 제거
            $headScripts = array_values(array_filter($headScripts, function($script) {
                return strpos($script, 'id="egbPushScript"') === false;
            }));
            $bodyScripts = array_values(array_filter($bodyScripts, function($script) {
                return strpos($script, 'id="egbPushScript"') === false;
            }));
        }
    
        // DNS 미리 조회와 TCP/SSL 미리 연결을 위한 도메인 수집
        $domains = [];
        foreach ($scriptsToLoad as $src => $config) {
            if (preg_match('/^(?:https?:)?\/\/([^\/]+)/', $src, $matches)) {
                $domains[$matches[1]] = true;
            }
        }
        foreach ($xpath->query('//img[@src]') as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/^(?:https?:)?\/\/([^\/]+)/', $src, $matches)) {
                $domains[$matches[1]] = true;
            }
        }
    
        // 수동으로 추가할 도메인들
        $manualDomains = [
            'cdn.jsdelivr.net'
        ];
    
        foreach ($manualDomains as $domain) {
            if (!isset($domains[$domain]) && $domain !== HOST) {
                $domains[$domain] = true;
            }
        }
    
        // 라디오 그룹 처리
        $radioGroups = array_filter(
            array_keys($classes),
            function($cls) {
                return strpos($cls, 'egb_radio_') === 0;
            }
        );
    
        if (!empty($radioGroups)) {
            // 그룹명만 추출 → 순차 인덱스 배열로 재정렬
            $groupNames = array_map(
                fn($full) => substr($full, strlen('egb_radio_')), 
                $radioGroups
            );
            $groupNames = array_values($groupNames);  // 0,1,2... 순차 인덱스 부여
    
            $json = htmlspecialchars(json_encode($groupNames), ENT_QUOTES);
    
            // <head>에 JSON 메타 삽입
            $headEl = $dom->getElementsByTagName('head')->item(0);
            if ($headEl) {
                $metaScript = $dom->createElement('script');
                $metaScript->setAttribute('id', 'egb-radio-group-data');
                $metaScript->setAttribute('type', 'application/json');
                $metaScript->setAttribute('nonce', NONCE);
                $metaScript->appendChild($dom->createTextNode($json));
                $headEl->appendChild($metaScript);
            }
        }
    
        // 수집된 클래스들을 JSON으로 변환하여 스크립트 태그에 삽입
        $classesJson = json_encode(array_keys($classes));
        $headEl = $dom->getElementsByTagName('head')->item(0);
        if ($headEl) {
            $classesScript = $dom->createElement('script');
            $classesScript->setAttribute('id', 'egb-class-data');
            $classesScript->setAttribute('type', 'application/json');
            $classesScript->setAttribute('nonce', NONCE);
            $classesScript->appendChild($dom->createTextNode($classesJson));
            $headEl->appendChild($classesScript);
        }
    
        // 이미지 미리 로드 처리 - 최상단으로 이동
        $preloadImages = [];
        foreach ($xpath->query('//img[contains(@class, "img_fast_load")]') as $img) {
            if ($img->hasAttribute('src')) {
                $src = $img->getAttribute('src');
                // 중복 제거를 위해 src를 키로 사용
                $preloadImages[$src] = true;
            }
        }
    
        // 9) data-* 속성 처리 & data-xy 처리
        $dataValues = [];
        $xyMap      = [];
        $attrs = [
            'bg-color'=>'background-color',
            'color'=>'color',
            'hover-bg-color'=>'background-color-hover',
            'hover-color'=>'color-hover',
            'bg-img'=>'background-image',
            'hover-bg-img'=>'background-image-hover',
            'box-shadow'=>'box-shadow',
            'hover-box-shadow'=>'box-shadow-hover',
            'top'=>'top','bottom'=>'bottom','left'=>'left','right'=>'right',
            'xx'=>'grid-template-columns','yy'=>'grid-template-rows',
            'bd-a-color'=>'border-top-color;border-right-color;border-bottom-color;border-left-color',
            'bd-t-color'=>'border-top-color','bd-r-color'=>'border-right-color',
            'bd-b-color'=>'border-bottom-color','bd-l-color'=>'border-left-color',
            'bd-x-color'=>'border-left-color;border-right-color','bd-y-color'=>'border-top-color;border-bottom-color',
            'hover-bd-a-color'=>'border-top-color-hover;border-right-color-hover;border-bottom-color-hover;border-left-color-hover',
            'hover-bd-t-color'=>'border-top-color-hover',
            'hover-bd-r-color'=>'border-right-color-hover',
            'hover-bd-b-color'=>'border-bottom-color-hover',
            'hover-bd-l-color'=>'border-left-color-hover',
            'hover-bd-x-color'=>'border-left-color-hover;border-right-color-hover',
            'hover-bd-y-color'=>'border-top-color-hover;border-bottom-color-hover',
            // border 속성들
            'border-top'=>'border-top',
            'border-bottom'=>'border-bottom', 
            'border-left'=>'border-left',
            'border-right'=>'border-right',
            //애니메이션 속성들
            'transition'=>'transition',
            'hover-transition'=>'transition-hover',
            'transform'=>'transform',
            'hover-transform'=>'transform-hover',
            'animation'=>'animation',
            'hover-animation'=>'animation-hover',
            'animation-delay'=>'animation-delay',
            'hover-animation-delay'=>'animation-delay-hover',
            'animation-duration'=>'animation-duration',
            'hover-animation-duration'=>'animation-duration-hover',
            'animation-iteration-count'=>'animation-iteration-count',
            'hover-animation-iteration-count'=>'animation-iteration-count-hover',
            'animation-direction'=>'animation-direction',
            'hover-animation-direction'=>'animation-direction-hover',
            'animation-fill-mode'=>'animation-fill-mode',
            'hover-animation-fill-mode'=>'animation-fill-mode-hover',
            'animation-play-state'=>'animation-play-state',
            'hover-animation-play-state'=>'animation-play-state-hover',
            'animation-timing-function'=>'animation-timing-function',
            'hover-animation-timing-function'=>'animation-timing-function-hover',
            'animation-name'=>'animation-name',
            'hover-animation-name'=>'animation-name-hover'
        ];
        foreach ($xpath->query('//*') as $el) {
            foreach ($attrs as $dataAttr => $props) {
                if ($el->hasAttribute("data-{$dataAttr}")) {
                    $val = $el->getAttribute("data-{$dataAttr}");
                    $dataValues[$dataAttr][$val] = true;
                }
            }
            if ($el->hasAttribute('data-xy')) {
                $raw  = $el->getAttribute('data-xy');
                $rand = 'xy_'.bin2hex(random_bytes(4));
                $el->setAttribute('class', trim($el->getAttribute('class')).' '.$rand);
                $xyMap[$rand] = $raw;
            }
        }
    
        // 10) 색상 보정이 필요한 요소들의 색상 정보 수집
        $colorElements = [];
        foreach ($xpath->query('//*[@data-color or @data-bg-color]') as $el) {
            // no_color_change 클래스가 있으면 건너뛰기
            if (strpos($el->getAttribute('class'), 'no_color_change') !== false) {
                continue;
            }
    
            $elementInfo = [
                'element' => $el,
                'bg_color' => null,
                'fg_colors' => [],
                'has_content' => trim($el->textContent) !== '' // 내용 존재 여부 체크
            ];
    
            // 배경색 찾기 (자신 또는 부모 요소에서)
            $current = $el;
            while ($current && $current->nodeType === XML_ELEMENT_NODE) {
                if ($current->hasAttribute('data-bg-color')) {
                    $elementInfo['bg_color'] = $current->getAttribute('data-bg-color');
                    break;
                }
                $current = $current->parentNode;
            }
    
            // 전경색 수집 (자신과 모든 자식 요소들에서)
            $colorNodes = $xpath->query('.//*[@data-color]|self::*[@data-color]', $el);
            foreach ($colorNodes as $node) {
                // no_color_change 클래스가 있는 노드는 건너뛰기
                if (strpos($node->getAttribute('class'), 'no_color_change') === false) {
                    $elementInfo['fg_colors'][] = $node->getAttribute('data-color');
                }
            }
    
            $colorElements[] = $elementInfo;
        }
    
        // 11) CSS 생성 & APCu 캐시 조회
        $cacheKey = 'egb_css_'.md5(json_encode([
            'classes'=>array_keys($classes),
            'data'   =>$dataValues,
            'xy'     =>array_values($xyMap),
            'ids'    =>array_keys($ids),
        ]));
        if (function_exists('apcu_fetch') && ($css = apcu_fetch($cacheKey))) {
            // 캐시 히트
        } else {
            $css  = '';
            // 클래스 기반 CSS
            if (!empty($classes)) {
                $css .= egb_ssr_style(array_keys($classes));
            }
            // data-xy 미디어쿼리
            if (!empty($xyMap)) {
                $css .= egb_ssr_data_xy($xyMap);
            }
            // ─── br_숫자-숫자 범위 클래스 CSS 추가 ───
            foreach (array_keys($classes) as $cls) {
                if (preg_match('/^br_(\d+)-(\d+)$/', $cls, $m)) {
                    // 기본 숨김
                    $css .= ".{$cls}{display:none;}\n";
                    // 지정된 범위에서만 표시
                    $css .= "@media (min-width:{$m[1]}px) and (max-width:{$m[2]}px){";
                    $css .= ".{$cls}{display:block;}";
                    $css .= "}\n";
                }
            }
            // 기타 data-* CSS
            foreach ($dataValues as $attr => $vals) {
                foreach (array_keys($vals) as $val) {
                    if ($attr === 'hover-color' || $attr === 'hover-bg-color' || $attr === 'hover-box-shadow' || $attr === 'hover-transition' || $attr === 'hover-transform') {
                        $css .= "[data-{$attr}=\"{$val}\"]:hover{";
                    } else {
                        $css .= "[data-{$attr}=\"{$val}\"]{";
                    }
                    foreach (explode(';', $attrs[$attr]) as $prop) {
                        if ($prop === 'color-hover') {
                            $css .= "color:{$val};";
                        } else if ($prop === 'background-color-hover') {
                            $css .= "background-color:{$val};";
                        } else if ($prop === 'box-shadow-hover') {
                            $css .= "box-shadow:{$val};";
                        } else if ($prop === 'background-image') {
                            $css .= "{$prop}:url({$val});";
                        } else if ($prop === 'transition-hover') {
                            $css .= "transition:{$val};";
                        } else if ($prop === 'transform-hover') {
                            $css .= "transform:{$val};";
                        } else {
                            $css .= "{$prop}:{$val};";
                        }
                    }
                    $css .= "}\n";
                }
            }
            if (function_exists('apcu_store')) {
                apcu_store($cacheKey, $css, 300);
            }
        }
    
        // 12) WCAG AAA 대비 색상 보정 함수 (대비율 7.0 이상 보장)
        $adjustColorContrast = function(string $bg, string $fg): array {
            // 유효한 16진수 색상 코드인지 검증
            if (!preg_match('/^#[0-9A-Fa-f]{6}$/',$bg) || !preg_match('/^#[0-9A-Fa-f]{6}$/',$fg)) {
                return [$bg, $fg];
            }
    
            // 배경색과 전경색을 RGB로 변환
            sscanf($bg,'#%02x%02x%02x',$rBG,$gBG,$bBG); 
            sscanf($fg,'#%02x%02x%02x',$rFG,$gFG,$bFG);
    
            // sRGB to 선형 RGB 변환 함수
            $lin = fn($c)=>($c/=255)<=0.03928 ? $c/12.92 : pow(($c+0.055)/1.055,2.4);
    
            // 상대 휘도 계산
            $Lbg = 0.2126*$lin($rBG)+0.7152*$lin($gBG)+0.0722*$lin($bBG);
            $Lfg = 0.2126*$lin($rFG)+0.7152*$lin($gFG)+0.0722*$lin($bFG);
    
            // 대비율 계산 및 조정 방향 결정
            $ratio = max(($Lbg+0.05)/($Lfg+0.05), ($Lfg+0.05)/($Lbg+0.05));
            
            // 대비율이 7.0 미만인 경우에만 조정
            if ($ratio < 7.0) {
                // 전경색이 배경색보다 밝은 경우
                if ($Lfg > $Lbg) {
                    // 전경색을 더 밝게, 배경색을 더 어둡게
                    while ($ratio < 7.0 && ($rFG < 255 || $gFG < 255 || $bFG < 255 || $rBG > 0 || $gBG > 0 || $bBG > 0)) {
                        if ($rFG < 255) $rFG = min(255, $rFG + 5);
                        if ($gFG < 255) $gFG = min(255, $gFG + 5);
                        if ($bFG < 255) $bFG = min(255, $bFG + 5);
                        if ($rBG > 0) $rBG = max(0, $rBG - 5);
                        if ($gBG > 0) $gBG = max(0, $gBG - 5);
                        if ($bBG > 0) $bBG = max(0, $bBG - 5);
                        
                        $Lbg = 0.2126*$lin($rBG)+0.7152*$lin($gBG)+0.0722*$lin($bBG);
                        $Lfg = 0.2126*$lin($rFG)+0.7152*$lin($gFG)+0.0722*$lin($bFG);
                        $ratio = max(($Lbg+0.05)/($Lfg+0.05), ($Lfg+0.05)/($Lbg+0.05));
                    }
                } else {
                    // 전경색을 더 어둡게, 배경색을 더 밝게
                    while ($ratio < 7.0 && ($rFG > 0 || $gFG > 0 || $bFG > 0 || $rBG < 255 || $gBG < 255 || $bBG < 255)) {
                        if ($rFG > 0) $rFG = max(0, $rFG - 5);
                        if ($gFG > 0) $gFG = max(0, $gFG - 5);
                        if ($bFG > 0) $bFG = max(0, $bFG - 5);
                        if ($rBG < 255) $rBG = min(255, $rBG + 5);
                        if ($gBG < 255) $gBG = min(255, $gBG + 5);
                        if ($bBG < 255) $bBG = min(255, $bBG + 5);
                        
                        $Lbg = 0.2126*$lin($rBG)+0.7152*$lin($gBG)+0.0722*$lin($bBG);
                        $Lfg = 0.2126*$lin($rFG)+0.7152*$lin($gFG)+0.0722*$lin($bFG);
                        $ratio = max(($Lbg+0.05)/($Lfg+0.05), ($Lfg+0.05)/($Lbg+0.05));
                    }
                }
            }
    
            return [
                sprintf("#%02x%02x%02x", $rBG, $gBG, $bBG),
                sprintf("#%02x%02x%02x", $rFG, $gFG, $bFG)
            ];
        };
    
        // 13) 각 요소에 대해 색상 보정 적용
        foreach ($colorElements as $info) {
            $el = $info['element'];
            $bg = $info['bg_color'];
            
            // 배경색이 있는 경우에만 색상 보정 처리
            if ($bg !== null) {
                // 각 전경색에 대해 보정 처리
                foreach ($info['fg_colors'] as $fg) {
                    list($newBg, $newFg) = $adjustColorContrast($bg, $fg);
                    if ($newBg !== $bg || $newFg !== $fg) {
                        $rand = 'color-'.bin2hex(random_bytes(4));
                        $el->setAttribute('class', trim($el->getAttribute('class')).' '.$rand);
                        $css .= ".{$rand} { background-color: {$newBg}; color: {$newFg}; }\n";
                    }
                }
                
                // 전경색이 없는 경우, 내용이 있을 때만 기본 검정색으로 보정
                if (empty($info['fg_colors']) && $info['has_content']) {
                    list($newBg, $newFg) = $adjustColorContrast($bg, '#000000');
                    $rand = 'color-'.bin2hex(random_bytes(4));
                    $el->setAttribute('class', trim($el->getAttribute('class')).' '.$rand);
                    $css .= ".{$rand} { background-color: {$newBg}; color: {$newFg}; }\n";
                }
            }
        }
    
        // 14) <head>와 <body> 엘리먼트 준비
        $headEl = $dom->getElementsByTagName('head')->item(0) 
               ?: $dom->createElement('head');
        $bodyEl = $dom->getElementsByTagName('body')->item(0)
               ?: $dom->createElement('body');
    
        if (!empty($css)) {
            // SSR 스타일 추가
            $ssrStyleEl = $dom->createElement('style', "\n{$css}\n");
            $ssrStyleEl->setAttribute('nonce', NONCE);
            $ssrStyleEl->setAttribute('id', 'egb_ssr_style');
            $headEl->appendChild($ssrStyleEl);
        }
    
        // 15) 중복 검사용 기존 스크립트 수집
        $existingScripts = [];
        foreach ($dom->getElementsByTagName('script') as $s) {
            if ($s->hasAttribute('src')) {
                $existingScripts[$s->getAttribute('src')] = true;
            }
        }
    
        // 16) 위치 제어하며 스크립트 주입
        foreach ($scriptsToLoad as $src => $config) {
            if (isset($existingScripts[$src])) {
                continue;
            }
            $scriptEl = $dom->createElement('script');
            $scriptEl->setAttribute('src', $src);
            if ($config['loading'] === 'async' || $config['loading'] === 'defer') {
                $scriptEl->setAttribute($config['loading'], '');
            }
            $scriptEl->setAttribute('nonce', NONCE);
    
            if ($config['position'] === 'body') {
                // body 끝에 추가
                $bodyEl->appendChild($scriptEl);
            } else {
                // 기본 head에 추가
                $headEl->appendChild($scriptEl);
            }
        }
    
        // CSR 스타일 추가
        $csrStyleEl = $dom->createElement('style', '');
        $csrStyleEl->setAttribute('id', 'egb_csr_style'); 
        $csrStyleEl->setAttribute('nonce', NONCE);
        $headEl->appendChild($csrStyleEl);
    
        if (!$dom->getElementsByTagName('head')->length) {
            $htmlElement = $dom->getElementsByTagName('html')->item(0);
            if ($htmlElement) {
                $htmlElement->insertBefore($headEl, $htmlElement->firstChild);
            } else {
                // html 태그가 없는 경우 documentElement에 추가
                $dom->appendChild($headEl);
            }
        }

        // 스키마 데이터가 있으면 생성
        if (!empty($schemaTypes)) {
            foreach ($schemaTypes as $schemaItem) {
                $type = $schemaItem['type'];
                $data = !empty($schemaItem['data']) ? $schemaItem['data'] : [];
                
                // egb_schema_autoload로 호출
                $schemaJson = egb_schema($type, $dom, $data);
                
                if ($schemaJson) {
                    $scriptEl = $dom->createElement('script');
                    $scriptEl->setAttribute('type', 'application/ld+json');
                    $scriptEl->setAttribute('id', 'egb_schema_' . $type);
                    $scriptEl->appendChild($dom->createTextNode($schemaJson));
                    $headEl->appendChild($scriptEl);
                }
            }
        }
                
        // 16) 최종 HTML 직렬화
        $out = str_replace('<?xml encoding="UTF-8">', '', html_entity_decode($dom->saveHTML(), ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    
        // 17) head 스크립트 복원 (</head> 바로 앞)
        if (!empty($headScripts)) {
            $inserts = implode("\n", $headScripts);
            $out = preg_replace(
                '/<\/head>/i',
                "\n{$inserts}\n</head>",
                $out,
                1
            );
        }
    
        // egb_csr_script를 head 태그 바로 뒤에 삽입
        $csr_script = egb_csr_script();
        $out = preg_replace(
            '/<head[^>]*>/i',
            "$0\n{$csr_script}",
            $out,
            1
        );
    
        // 18) body 스크립트 복원 (원래 자리 그대로) 
        if (!empty($bodyScripts)) {
            foreach($bodyScripts as $script) {
                $out = preg_replace('/<\/body>/i', $script."\n</body>", $out, 1);
            }
        }
    
        // 19) 도메인 프리커넥트와 이미지 프리로드 링크 생성
        $preconnectLinks = '';
        foreach ($domains as $domain => $value) {
            if ($domain !== HOST) {
                $preconnectLinks .= "<link rel='preconnect' href='https://{$domain}' crossorigin>\n";
                $preconnectLinks .= "<link rel='dns-prefetch' href='https://{$domain}'>\n";
            }
        }
    
        $preloadLinks = '';
        foreach (array_keys($preloadImages) as $imgSrc) {
            $preloadLinks .= "<link rel='preload' as='image' href='{$imgSrc}'>\n";
        }
    
        // 20) <!DOCTYPE html> 뒤에 프리커넥트와 프리로드 링크 삽입
        $out = "<!DOCTYPE html>\n" . $preconnectLinks . $preloadLinks . substr($out, strlen("<!DOCTYPE html>\n"));
    
        // 21) 출력
        echo $out;
    });








		exit;
	}
	
	if ($segments[0] == 'post') {
		if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {
			if (egb('post')){
			//post 파라미터에 대한 페이지 출력 form에서 전달되는 경우에만 반응 하도록 한다.
				if (isset($segments[1])){
					$post = $segments[1];
					$query = "SELECT * FROM egb_input_page WHERE page_name = :page_name";
					$param = [':page_name' => $post];
					$binding = binding_sql(1, $query, $param);
					
					$sql = egb_sql($binding);
					
					if (isset($sql[0]['page_path'])){egb_file_load($sql[0]['page_path']); exit;}else{echo "올바른 경로가 아닙니다."; exit;}
				}
			}else{
				echo json_encode(['success' => false, 'failureCode' => 0]);
				exit;
			}
		}
	}
	if ($segments[0] == 'img') {
		if (isset($segments[1])) {
		    $img_key = basename($segments[1] ?? '');
		    $_GET['img'] = $img_key; // or 직접 egb() 초기화 구조에 반영
		    egb_img();
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] == 'video') {
		if (isset($segments[1])) {
		    $video_key = basename($segments[1] ?? '');
		    $_GET['video'] = $video_key; // or 직접 egb() 초기화 구조에 반영
		    egb_video();
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] == 'audio') {
		if (isset($segments[1])) {
		    $audio_key = basename($segments[1] ?? '');
		    $_GET['audio'] = $audio_key; // or 직접 egb() 초기화 구조에 반영
		    egb_audio();
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] == 'font') {
		if (isset($segments[1])) {
		    $font_key = basename($segments[1] ?? '');
		    $_GET['font'] = $font_key; // or 직접 egb() 초기화 구조에 반영
		    egb_font();
		} else {
			// 폰트 세그먼트는 있지만 폰트 파일이 제공되지 않은 경우
			header("HTTP/1.0 400 Bad Request");
			echo '<div class="g_c_c p_h_20 f_s_20">폰트 파일이 제공되지 않았습니다.</div>';
			exit;
		}
	}
	if ($segments[0] == 'img2') {
		if (isset($segments[1])) {
		$img_key = implode('/', array_slice($segments, 1));
		$_GET['img2'] = $img_key;
		egb_img();
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] == 'video2') {
		if (isset($segments[1])) {
		    $video_key = implode('/', array_slice($segments, 1));
		    $_GET['video2'] = $video_key;
		    egb_video();
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] == 'audio2') {
		if (isset($segments[1])) {
		    $audio_key = implode('/', array_slice($segments, 1));
		    $_GET['audio2'] = $audio_key;
		    egb_audio();
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] == 'font2') {
		if (isset($segments[1])) {
		    $font_key = implode('/', array_slice($segments, 1));
		    $_GET['font2'] = $font_key;
		    egb_font();
		} else {
			// 폰트 세그먼트는 있지만 폰트 파일이 제공되지 않은 경우
			header("HTTP/1.0 400 Bad Request");
			echo '<div class="g_c_c p_h_20 f_s_20">폰트 파일이 제공되지 않았습니다.</div>';
			exit;
		}
	}
	if ($segments[0] == 'img3') {
		if (isset($segments[1])) {
		    $img_key = basename($segments[1] ?? '');
		    $_GET['img3'] = $img_key; // or 직접 egb() 초기화 구조에 반영
		    egb_img();
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] == 'video3') {
		if (isset($segments[1])) {
		    $video_key = basename($segments[1] ?? '');
		    $_GET['video3'] = $video_key; // or 직접 egb() 초기화 구조에 반영
		    egb_video();
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] == 'audio3') {
		if (isset($segments[1])) {
		    $audio_key = basename($segments[1] ?? '');
		    $_GET['audio3'] = $audio_key; // or 직접 egb() 초기화 구조에 반영
		    egb_audio();
		} else {
			// 경로가 일치하지 않을 때 기본 처리
			echo '<div class="g_c_c p_h_20 f_s_20">해당 페이지는 미사용 중이거나, 없는 페이지 입니다.</div>';
			exit;
		}
		
	}
	if ($segments[0] == 'font3') {
		if (isset($segments[1])) {
		    $font_key = basename($segments[1] ?? '');
		    $_GET['font3'] = $font_key; // or 직접 egb() 초기화 구조에 반영
		    egb_font();
		} else {
			// 폰트 세그먼트는 있지만 폰트 파일이 제공되지 않은 경우
			header("HTTP/1.0 400 Bad Request");
			echo '<div class="g_c_c p_h_20 f_s_20">폰트 파일이 제공되지 않았습니다.</div>';
			exit;
		}
	}
	if ($segments[0] == 'download') {
		if (isset($segments[1])) {
			$download = $segments[1];
			// 유니크 아이디로 파일 정보 조회
			$query = "SELECT * FROM egb_download WHERE uniq_id = :uniq_id AND is_status = 1 AND (deleted_at IS NULL) AND (download_expire_at IS NULL OR download_expire_at > NOW())";
			$params = [':uniq_id' => $download];
			$binding = binding_sql(1, $query, $params);
			$result = egb_sql($binding);

			if ($result) {
				$fileInfo = $result[0];
				if ($fileInfo) {
					// 접근 레벨 확인
					if (intval($fileInfo['download_level']) > 0) {
						if (!isset($_SESSION['admin_id'])) {
							echo json_encode(['success' => false, 'errorCode' => 11, 'message' => '접근 권한이 없습니다']);
							exit;
						}
					}

					// 비밀번호 확인
					if (!empty($fileInfo['download_password'])) {
						if (!isset($_POST['password']) || !password_verify($_POST['password'], $fileInfo['download_password'])) {
							echo json_encode(['success' => false, 'errorCode' => 12, 'message' => '비밀번호가 필요합니다']);
							exit;
						}
					}

					$filePath = ROOT . $fileInfo['download_data_path'];
					$originalFileName = $fileInfo['download_data_name'];
					$downloadCount = intval($fileInfo['download_count']);
					$storedHash = $fileInfo['download_hash'];

					if (file_exists($filePath)) {
						// 파일 해시 확인
						$currentHash = hash_file('sha256', $filePath);
						if ($currentHash !== $storedHash) {
							echo json_encode(['success' => false, 'errorCode' => 10, 'message' => '파일 무결성 검증 실패']);
							exit;
						}

						// 다운로드 횟수 증가
						$downloadCount++;
						$updateQuery = "UPDATE egb_download SET download_count = :download_count WHERE uniq_id = :uniq_id";
						$updateParams = [
							':download_count' => $downloadCount,
							':uniq_id' => $download
						];
						$updateBinding = binding_sql(2, $updateQuery, $updateParams);
						egb_sql($updateBinding);

						// 파일 다운로드 처리
						$encodedFileName = rawurlencode($originalFileName);
						$encodedFileName = str_replace("%20", " ", $encodedFileName);

						if (ob_get_level()) {
							ob_end_clean();
						}

						header('Content-Description: File Transfer');
						header('Content-Type: application/octet-stream');
						header('Content-Disposition: attachment; filename="' . basename($originalFileName) . '"; filename*=UTF-8\'\'' . $encodedFileName);
						header('Expires: 0');
						header('Cache-Control: must-revalidate');
						header('Pragma: public');
						header('Content-Length: ' . filesize($filePath));

						if (ob_get_level()) {
							ob_end_clean();
						}

						readfile($filePath);
						exit;
					} else {
						echo json_encode(['success' => false, 'errorCode' => 7, 'message' => '파일이 존재하지 않습니다']);
						exit;
					}
				} else {
					echo json_encode(['success' => false, 'errorCode' => 8, 'message' => '파일 정보를 찾을 수 없습니다']);
					exit;
				}
			} else {
				echo json_encode(['success' => false, 'errorCode' => 1, 'message' => '데이터베이스 조회 실패']);
				exit;
			}
		} else {
			echo json_encode(['success' => false, 'errorCode' => 9, 'message' => '다운로드 ID가 제공되지 않았습니다']);
			exit;
		}
	}
	if ($segments[0] == 'template') {
		if (isset($segments[0])){
			require_once ROOT.DS.'egb_admin'.DS.'template.php'; exit;
		}
	}
	if ($segments[0] == 'js') {
		if (isset($segments[1])){
			$js_key = $segments[1];
			switch ($js_key) {
                case 'egb_function':
                    require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_function.js'; exit;
				case 'pusher':
					require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'pusher.min.js'; exit;
				case 'ably':
					require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'ably.min-1.js'; exit;
				case 'egb_slide':
					require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_slide.js'; exit;
				case 'egb_ajax':
					require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_ajax.js'; exit;
				case 'egb_form':
					require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_form.js'; exit;
				case 'egb_style':
					require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_style.js'; exit;
				case 'egb_img':
					require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_img.js'; exit;
                case 'egb_push':
                    require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_push.js'; exit;
                case 'egb_spa':
                    require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_spa.js'; exit;
                case 'egb_qna':
                    require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_qna.js'; exit;
                case 'egb_radio':
                    require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_radio.js'; exit;
                case 'egb_admin':
                    require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_admin.js'; exit;
                case 'egb_masonry':
                    require_once ROOT.DS.'egb_setting'.DS.'egb_js'.DS.'egb_masonry.js'; exit;
			}
		}
	}	
	if ($segments[0] == 'page') {
        
		// 페이지 렌더링시에만 출력 버퍼 시작
		ob_start();
		
		
		if (isset($segments[1])){
			$page = $segments[1];
			$query = "SELECT * FROM egb_page WHERE page_name = :page_name AND page_theme = :page_theme";
			$param = [':page_name' => $page, ':page_theme' => THEMES_NAME];
			$binding = binding_sql(1, $query, $param);
			$sql = egb_sql($binding);
			
			if (!defined('UNIQ_ID')) {define('UNIQ_ID', $sql[0]['uniq_id'] ?? null);}
			if (!defined('PAGE')) {define('PAGE', $sql[0]['page_name'] ?? null);}
			if (!defined('PAGE_CONTENT')) {define('PAGE_CONTENT', $sql[0]['page_path'] ?? null);}
			if (!defined('PAGE_TYPE')) {define('PAGE_TYPE', $sql[0]['page_type'] ?? null);}
			if (!defined('PAGE_USE')) {define('PAGE_USE', $sql[0]['page_use'] ?? null);}
			
			if (defined('PAGE_USE') and (PAGE_USE == 1)){
				
				if (isset($sql[0]['page_seo']) && $sql[0]['page_seo'] == 1){
					egb_page_meta(
						$sql[0]['page_title'], 
						$sql[0]['page_path'],
						$sql[0]['seo_title'],
						$sql[0]['seo_subject'],
						$sql[0]['seo_description'],
						$sql[0]['seo_keywords'],
						$sql[0]['seo_robots'],
						$sql[0]['seo_author'],
						$sql[0]['seo_og_img'],
						$sql[0]['created_at'],
						$sql[0]['updated_at']
					);
				} else {
					egb_page_meta(
						$sql[0]['page_title'],
						$sql[0]['page_path'],
						null, null, null, null,
						'nofollow, noindex',
						'Eungabi',
						DS . 'egb_thumbnail.webp',
						$sql[0]['created_at'],
						$sql[0]['updated_at']
					);
				}
				
				if (defined('UNIQ_ID')){
					if (!defined('PAGE_HEADER_USE')) {define('PAGE_HEADER_USE', $sql[0]['setting_header_use'] ?? 1);}
					if (!defined('PAGE_FOOTER_USE')) {define('PAGE_FOOTER_USE', $sql[0]['setting_footer_use'] ?? 1);}
					if (!defined('PAGE_COMMENT_USE')) {define('PAGE_COMMENT_USE', $sql[0]['setting_comment_use'] ?? 1);}
					if (!defined('PAGE_ACCESS_LEVEL')) {define('PAGE_ACCESS_LEVEL', $sql[0]['setting_access_level'] ?? '0');}
				}
				
			} else {
				echo '페이지를 사용할 수 없거나 미사용 상태입니다.';
				exit;
			}
			
		} else {
			egb_page_meta(null, null, null, null, null, null, null, null, null, '2023-12-30', '2023-12-30');
		}
	}

	// 이 부분에서 admin_top_box()와 egb_load() 함수 호출을 하도록 처리
	admin_top_box();
	egb_load(THEMES_PATH_INDEX);

	// 페이지 렌더링 시간 계산 및 출력
	$end_time = microtime(true);
	$render_time = round(($end_time - EGB_START_TIME) * 1000, 2);
	if (defined('EGB_LOG_UNIQ_ID')) {
		egb_get_device(EGB_LOG_UNIQ_ID, $render_time);
		echo '<div class="padding_px-a_020 flex_xc_yc font_size_12" data-color="#999999">페이지 렌더링 시간: ' . $render_time . 'ms</div>';
	}
	

	echo '</body>';
	echo '</html>';
	
	// *1회*만 동작할 shutdown hook 등록
    register_shutdown_function(function(){
        // 1) 버퍼에서 전체 HTML 가져오기
        $original = trim(ob_get_clean());
    
        // 2) HTML 본문만 분리 
        $htmlOnly = $original;
    
        // 3) <head>…</head> 블록 분리
        $headScripts   = [];
        $origHeadContent = '';
        if (preg_match('/<head\b[^>]*>(.*?)<\/head>/is', $htmlOnly, $m)) {
            $origHeadContent = $m[1];
            // head 전체를 빈 head 태그로 대체
            $htmlOnly = str_replace($m[0], '<head></head>', $htmlOnly);
        }
    
        // 4) head 안의 <script> 추출
        $cleanHead = preg_replace_callback(
            '/<script\b[^>]*>.*?<\/script>/is',
            function($m) use (&$headScripts) {
                $headScripts[] = $m[0];
                return '';
            },
            $origHeadContent
        );
    
        // 5) body 안의 <script> 추출
        $bodyScripts = [];
        $htmlOnly = preg_replace_callback(
            '/<script\b[^>]*>.*?<\/script>/is',
            function($m) use (&$bodyScripts) {
                $bodyScripts[] = $m[0];
                return '';
            },
            $htmlOnly
        );
    
        // 6) 치환된 head + rest 결합
        $htmlClean = "<head>{$cleanHead}</head>" . $htmlOnly;
    
        // ——— 6.1) br_ 숫자-숫자 커스텀 태그를 단일 <br class="br_x-y">로 변환 ———
        $htmlClean = preg_replace_callback(
            '#<(\/?)br_([0-9]+-[0-9]+)\b[^>]*>#i',
            function($m){
                // 닫는 태그면 삭제
                if ($m[1] === '/') {
                    return '';
                }
                // 여는 태그면 단일 <br class="br_x-y">
                return '<br class="br_'.$m[2].'">';
            },
            $htmlClean
        );
    
        // 7) DOM 파싱 (스크립트 없는 상태)
        libxml_use_internal_errors(true);
        $dom = new DOMDocument('1.0','UTF-8');
        $dom->loadHTML('<?xml encoding="UTF-8">'.$htmlClean, LIBXML_HTML_NOIMPLIED|LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        // egb_schema 태그 찾기 및 처리 - DOM 파싱 직후로 이동
        $schemaTypes = [];
        foreach($xpath->query('//egb_schema') as $schema) {
            $type = $schema->getAttribute('type');
            $dataAttrs = [];
            foreach ($schema->attributes as $attr) {
                if (strpos($attr->name, 'data-schema-') === 0) {
                    $key = substr($attr->name, 12);
                    $dataAttrs[$key] = $attr->value;
                }
            }
            $schemaTypes[] = ['type' => $type, 'data' => $dataAttrs];
            
            // 파싱 후 해당 노드 삭제
            $schema->parentNode->removeChild($schema);
        }
    
        // html lang 속성 추가
        $htmlElement = $dom->getElementsByTagName('html')->item(0);
        if ($htmlElement) {
            $htmlElement->setAttribute('lang', 'ko');
        }
    
        // alt 없는 이미지에 alt 추가 및 지연로딩 적용
        foreach ($xpath->query('//img') as $img) {
            // alt 속성이 없으면 빈 alt 추가
            if (!$img->hasAttribute('alt')) {
                $img->setAttribute('alt', '이미지');
            }
            
            // img_fast_load 클래스가 있는 이미지는 제외하고 지연로딩 적용
            if ($img->hasAttribute('class') && strpos($img->getAttribute('class'), 'img_fast_load') !== false) {
                continue;
            }
            $img->setAttribute('loading', 'lazy');
        }
    
        // --- egb SSR 로직 시작 ---
    
    
        
        // 8) 클래스와 태그, ID 수집
        $classes = [];
        $tags = [];
        $ids = [];
        
        // 클래스, 태그, ID 동시 수집
        foreach ($xpath->query('//*') as $el) {
            // 태그명 수집
            $tags[$el->tagName] = true;
            
            // 클래스가 있는 경우 수집
            if ($el->hasAttribute('class')) {
                foreach (preg_split('/\s+/', trim($el->getAttribute('class'))) as $cls) {
                    if ($cls !== '') $classes[$cls] = true;
                }
            }
    
            // ID가 있는 경우 수집
            if ($el->hasAttribute('id')) {
                $ids[$el->getAttribute('id')] = true;
            }
        }
    
        // 태그 기반 스크립트 매핑 [src, position, loading]
        $tagScriptMap = [
            'html' => [['/js/egb_function', 'head']],
            'form' => [
                ['/js/egb_ajax', 'head', 'async'],
                ['/js/egb_form', 'head', 'defer']
            ],
            'style' => [['/js/egb_style', 'head', 'defer']],
            'img' => [['/js/egb_img', 'head', 'defer']]
        ];
    
        // 클래스 기반 스크립트 매핑 (정확히 일치하는 경우)
        $classScriptMap = [
            'slide_egb_main_box' => [['/js/egb_slide', 'head', 'async']],
            'egb_spa' => [['/js/egb_spa', 'head', 'defer']],
            'egb_qna' => [['/js/egb_qna', 'head', 'defer']],
            'egb_qna_accordion' => [['/js/egb_qna', 'head', 'defer']],
            'egb_admin_page' => [['/js/egb_admin', 'head', 'defer']]
        ];
    
        // 클래스 기반 스크립트 매핑 (부분 일치하는 경우)
        $classPatternScriptMap = [
            'egb_radio_' => [['/js/egb_radio', 'head', 'defer']]
        ];
    
        // ID 기반 스크립트 매핑
        $idScriptMap = [
            'egb_push' => [
                ['/js/pusher', 'head'],
                ['/js/ably', 'head', 'defer'],
                ['/js/egb_push', 'head', 'defer']
            ],
            'egb_masonry' => [['/js/egb_masonry', 'head', 'defer']]
        ];
    
        // 스크립트 로드 대상 수집
        $scriptsToLoad = [];
        
        // 태그 기반 스크립트 추가
        foreach ($tagScriptMap as $tag => $scripts) {
            if (isset($tags[$tag])) {
                foreach ($scripts as $script) {
                    list($src, $position) = $script;
                    $loading = $script[2] ?? null;
                    $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                }
            }
        }
    
        // 클래스 기반 스크립트 추가 (정확히 일치하는 경우)
        foreach ($classScriptMap as $class => $scripts) {
            if (isset($classes[$class])) {
                foreach ($scripts as $script) {
                    list($src, $position) = $script;
                    $loading = $script[2] ?? null;
                    $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                }
            }
        }
    
        // 클래스 기반 스크립트 추가 (부분 일치하는 경우)
        foreach ($classPatternScriptMap as $pattern => $scripts) {
            foreach ($classes as $class => $value) {
                if (strpos($class, $pattern) === 0) { // 패턴으로 시작하는지 확인
                    foreach ($scripts as $script) {
                        list($src, $position) = $script;
                        $loading = $script[2] ?? null;
                        $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                    }
                    break; // 하나라도 매칭되면 해당 패턴의 스크립트는 한 번만 추가
                }
            }
        }
    
        // ID 기반 스크립트 추가 
        foreach ($idScriptMap as $id => $scriptList) {
            if (isset($ids[$id])) {
                foreach ($scriptList as $script) {
                    list($src, $position) = $script;
                    $loading = $script[2] ?? null;
                    $scriptsToLoad[$src] = ['position' => $position, 'loading' => $loading];
                }
            }
        }

        // push 관련 스크립트가 로드되지 않을 때 egbPushScript 요소 제거
        if (!isset($scriptsToLoad['/js/pusher']) && !isset($scriptsToLoad['/js/ably']) && !isset($scriptsToLoad['/js/egb_push'])) {
            // DOM에서 직접 제거
            foreach ($xpath->query("//script[@id='egbPushScript']") as $pushScriptEl) {
                $pushScriptEl->parentNode->removeChild($pushScriptEl);
            }
            
            // 스크립트 배열에서도 제거
            $headScripts = array_values(array_filter($headScripts, function($script) {
                return strpos($script, 'id="egbPushScript"') === false;
            }));
            $bodyScripts = array_values(array_filter($bodyScripts, function($script) {
                return strpos($script, 'id="egbPushScript"') === false;
            }));
        }
    
        // DNS 미리 조회와 TCP/SSL 미리 연결을 위한 도메인 수집
        $domains = [];
        foreach ($scriptsToLoad as $src => $config) {
            if (preg_match('/^(?:https?:)?\/\/([^\/]+)/', $src, $matches)) {
                $domains[$matches[1]] = true;
            }
        }
        foreach ($xpath->query('//img[@src]') as $img) {
            $src = $img->getAttribute('src');
            if (preg_match('/^(?:https?:)?\/\/([^\/]+)/', $src, $matches)) {
                $domains[$matches[1]] = true;
            }
        }
    
        // 수동으로 추가할 도메인들
        $manualDomains = [
            'cdn.jsdelivr.net'
        ];
    
        foreach ($manualDomains as $domain) {
            if (!isset($domains[$domain]) && $domain !== HOST) {
                $domains[$domain] = true;
            }
        }
    
        // 라디오 그룹 처리
        $radioGroups = array_filter(
            array_keys($classes),
            function($cls) {
                return strpos($cls, 'egb_radio_') === 0;
            }
        );
        
        if (!empty($radioGroups)) {
            // 그룹명만 추출 → 순차 인덱스 배열로 재정렬
            $groupNames = array_map(
                fn($full) => substr($full, strlen('egb_radio_')), 
                $radioGroups
            );
            $groupNames = array_values($groupNames);  // 0,1,2... 순차 인덱스 부여
    
            $json = htmlspecialchars(json_encode($groupNames), ENT_QUOTES);
    
            // <head>에 JSON 메타 삽입
            $headEl = $dom->getElementsByTagName('head')->item(0);
            if ($headEl) {
                $metaScript = $dom->createElement('script');
                $metaScript->setAttribute('id', 'egb-radio-group-data');
                $metaScript->setAttribute('type', 'application/json');
                $metaScript->setAttribute('nonce', NONCE);
                $metaScript->appendChild($dom->createTextNode($json));
                $headEl->appendChild($metaScript);
            }
        }
    
        // 수집된 클래스들을 JSON으로 변환하여 스크립트 태그에 삽입
        $classesJson = json_encode(array_keys($classes));
        $headEl = $dom->getElementsByTagName('head')->item(0);
        if ($headEl) {
            $classesScript = $dom->createElement('script');
            $classesScript->setAttribute('id', 'egb-class-data');
            $classesScript->setAttribute('type', 'application/json');
            $classesScript->setAttribute('nonce', NONCE);
            $classesScript->appendChild($dom->createTextNode($classesJson));
            $headEl->appendChild($classesScript);
        }
    
        // 이미지 미리 로드 처리 - 최상단으로 이동
        $preloadImages = [];
        foreach ($xpath->query('//img[contains(@class, "img_fast_load")]') as $img) {
            if ($img->hasAttribute('src')) {
                $src = $img->getAttribute('src');
                // 중복 제거를 위해 src를 키로 사용
                $preloadImages[$src] = true;
            }
        }
    
        // 9) data-* 속성 처리 & data-xy 처리
        $dataValues = [];
        $xyMap      = [];
        $attrs = [
            'bg-color'=>'background-color',
            'color'=>'color',
            'hover-bg-color'=>'background-color-hover',
            'hover-color'=>'color-hover',
            'bg-img'=>'background-image',
            'hover-bg-img'=>'background-image-hover',
            'box-shadow'=>'box-shadow',
            'hover-box-shadow'=>'box-shadow-hover',
            'top'=>'top','bottom'=>'bottom','left'=>'left','right'=>'right',
            'xx'=>'grid-template-columns','yy'=>'grid-template-rows',
            'bd-a-color'=>'border-top-color;border-right-color;border-bottom-color;border-left-color',
            'bd-t-color'=>'border-top-color','bd-r-color'=>'border-right-color',
            'bd-b-color'=>'border-bottom-color','bd-l-color'=>'border-left-color',
            'bd-x-color'=>'border-left-color;border-right-color','bd-y-color'=>'border-top-color;border-bottom-color',
            'hover-bd-a-color'=>'border-top-color-hover;border-right-color-hover;border-bottom-color-hover;border-left-color-hover',
            'hover-bd-t-color'=>'border-top-color-hover',
            'hover-bd-r-color'=>'border-right-color-hover',
            'hover-bd-b-color'=>'border-bottom-color-hover',
            'hover-bd-l-color'=>'border-left-color-hover',
            'hover-bd-x-color'=>'border-left-color-hover;border-right-color-hover',
            'hover-bd-y-color'=>'border-top-color-hover;border-bottom-color-hover',
            // border 속성들
            'border-top'=>'border-top',
            'border-bottom'=>'border-bottom', 
            'border-left'=>'border-left',
            'border-right'=>'border-right',
            //애니메이션 속성들
            'transition'=>'transition',
            'hover-transition'=>'transition-hover',
            'transform'=>'transform',
            'hover-transform'=>'transform-hover',
            'animation'=>'animation',
            'hover-animation'=>'animation-hover',
            'animation-delay'=>'animation-delay',
            'hover-animation-delay'=>'animation-delay-hover',
            'animation-duration'=>'animation-duration',
            'hover-animation-duration'=>'animation-duration-hover',
            'animation-iteration-count'=>'animation-iteration-count',
            'hover-animation-iteration-count'=>'animation-iteration-count-hover',
            'animation-direction'=>'animation-direction',
            'hover-animation-direction'=>'animation-direction-hover',
            'animation-fill-mode'=>'animation-fill-mode',
            'hover-animation-fill-mode'=>'animation-fill-mode-hover',
            'animation-play-state'=>'animation-play-state',
            'hover-animation-play-state'=>'animation-play-state-hover',
            'animation-timing-function'=>'animation-timing-function',
            'hover-animation-timing-function'=>'animation-timing-function-hover',
            'animation-name'=>'animation-name',
            'hover-animation-name'=>'animation-name-hover'
        ];
        foreach ($xpath->query('//*') as $el) {
            foreach ($attrs as $dataAttr => $props) {
                if ($el->hasAttribute("data-{$dataAttr}")) {
                    $val = $el->getAttribute("data-{$dataAttr}");
                    $dataValues[$dataAttr][$val] = true;
                }
            }
            if ($el->hasAttribute('data-xy')) {
                $raw  = $el->getAttribute('data-xy');
                $rand = 'xy_'.bin2hex(random_bytes(4));
                $el->setAttribute('class', trim($el->getAttribute('class')).' '.$rand);
                $xyMap[$rand] = $raw;
            }
        }
    
        // 10) 색상 보정이 필요한 요소들의 색상 정보 수집
        $colorElements = [];
        foreach ($xpath->query('//*[@data-color or @data-bg-color]') as $el) {
            // no_color_change 클래스가 있으면 건너뛰기
            if (strpos($el->getAttribute('class'), 'no_color_change') !== false) {
                continue;
            }
    
            $elementInfo = [
                'element' => $el,
                'bg_color' => null,
                'fg_colors' => [],
                'has_content' => trim($el->textContent) !== '' // 내용 존재 여부 체크
            ];
    
            // 배경색 찾기 (자신 또는 부모 요소에서)
            $current = $el;
            while ($current && $current->nodeType === XML_ELEMENT_NODE) {
                if ($current->hasAttribute('data-bg-color')) {
                    $elementInfo['bg_color'] = $current->getAttribute('data-bg-color');
                    break;
                }
                $current = $current->parentNode;
            }
    
            // 전경색 수집 (자신과 모든 자식 요소들에서)
            $colorNodes = $xpath->query('.//*[@data-color]|self::*[@data-color]', $el);
            foreach ($colorNodes as $node) {
                // no_color_change 클래스가 있는 노드는 건너뛰기
                if (strpos($node->getAttribute('class'), 'no_color_change') === false) {
                    $elementInfo['fg_colors'][] = $node->getAttribute('data-color');
                }
            }
    
            $colorElements[] = $elementInfo;
        }
    
        // 11) CSS 생성 & APCu 캐시 조회
        $cacheKey = 'egb_css_'.md5(json_encode([
            'classes'=>array_keys($classes),
            'data'   =>$dataValues,
            'xy'     =>array_values($xyMap),
            'ids'    =>array_keys($ids),
        ]));
        if (function_exists('apcu_fetch') && ($css = apcu_fetch($cacheKey))) {
            // 캐시 히트
        } else {
            $css  = '';
            // 클래스 기반 CSS
            if (!empty($classes)) {
                $css .= egb_ssr_style(array_keys($classes));
            }
            // data-xy 미디어쿼리
            if (!empty($xyMap)) {
                $css .= egb_ssr_data_xy($xyMap);
            }
            // ─── br_숫자-숫자 범위 클래스 CSS 추가 ───
            foreach (array_keys($classes) as $cls) {
                if (preg_match('/^br_(\d+)-(\d+)$/', $cls, $m)) {
                    // 기본 숨김
                    $css .= ".{$cls}{display:none;}\n";
                    // 지정된 범위에서만 표시
                    $css .= "@media (min-width:{$m[1]}px) and (max-width:{$m[2]}px){";
                    $css .= ".{$cls}{display:block;}";
                    $css .= "}\n";
                }
            }
            // 기타 data-* CSS
            foreach ($dataValues as $attr => $vals) {
                foreach (array_keys($vals) as $val) {
                    if ($attr === 'hover-color' || $attr === 'hover-bg-color' || $attr === 'hover-box-shadow' || $attr === 'hover-transition' || $attr === 'hover-transform') {
                        $css .= "[data-{$attr}=\"{$val}\"]:hover{";
                    } else {
                        $css .= "[data-{$attr}=\"{$val}\"]{";
                    }
                    foreach (explode(';', $attrs[$attr]) as $prop) {
                        if ($prop === 'color-hover') {
                            $css .= "color:{$val};";
                        } else if ($prop === 'background-color-hover') {
                            $css .= "background-color:{$val};";
                        } else if ($prop === 'box-shadow-hover') {
                            $css .= "box-shadow:{$val};";
                        } else if ($prop === 'background-image') {
                            $css .= "{$prop}:url({$val});";
                        } else if ($prop === 'transition-hover') {
                            $css .= "transition:{$val};";
                        } else if ($prop === 'transform-hover') {
                            $css .= "transform:{$val};";
                        } else {
                            $css .= "{$prop}:{$val};";
                        }
                    }
                    $css .= "}\n";
                }
            }
            if (function_exists('apcu_store')) {
                apcu_store($cacheKey, $css, 300);
            }
        }
    
        // 12) WCAG AAA 대비 색상 보정 함수 (대비율 7.0 이상 보장)
        $adjustColorContrast = function(string $bg, string $fg): array {
            // 유효한 16진수 색상 코드인지 검증
            if (!preg_match('/^#[0-9A-Fa-f]{6}$/',$bg) || !preg_match('/^#[0-9A-Fa-f]{6}$/',$fg)) {
                return [$bg, $fg];
            }
    
            // 배경색과 전경색을 RGB로 변환
            sscanf($bg,'#%02x%02x%02x',$rBG,$gBG,$bBG); 
            sscanf($fg,'#%02x%02x%02x',$rFG,$gFG,$bFG);
    
            // sRGB to 선형 RGB 변환 함수
            $lin = fn($c)=>($c/=255)<=0.03928 ? $c/12.92 : pow(($c+0.055)/1.055,2.4);
    
            // 상대 휘도 계산
            $Lbg = 0.2126*$lin($rBG)+0.7152*$lin($gBG)+0.0722*$lin($bBG);
            $Lfg = 0.2126*$lin($rFG)+0.7152*$lin($gFG)+0.0722*$lin($bFG);
    
            // 대비율 계산 및 조정 방향 결정
            $ratio = max(($Lbg+0.05)/($Lfg+0.05), ($Lfg+0.05)/($Lbg+0.05));
            
            // 대비율이 7.0 미만인 경우에만 조정
            if ($ratio < 7.0) {
                // 전경색이 배경색보다 밝은 경우
                if ($Lfg > $Lbg) {
                    // 전경색을 더 밝게, 배경색을 더 어둡게
                    while ($ratio < 7.0 && ($rFG < 255 || $gFG < 255 || $bFG < 255 || $rBG > 0 || $gBG > 0 || $bBG > 0)) {
                        if ($rFG < 255) $rFG = min(255, $rFG + 5);
                        if ($gFG < 255) $gFG = min(255, $gFG + 5);
                        if ($bFG < 255) $bFG = min(255, $bFG + 5);
                        if ($rBG > 0) $rBG = max(0, $rBG - 5);
                        if ($gBG > 0) $gBG = max(0, $gBG - 5);
                        if ($bBG > 0) $bBG = max(0, $bBG - 5);
                        
                        $Lbg = 0.2126*$lin($rBG)+0.7152*$lin($gBG)+0.0722*$lin($bBG);
                        $Lfg = 0.2126*$lin($rFG)+0.7152*$lin($gFG)+0.0722*$lin($bFG);
                        $ratio = max(($Lbg+0.05)/($Lfg+0.05), ($Lfg+0.05)/($Lbg+0.05));
                    }
                } else {
                    // 전경색을 더 어둡게, 배경색을 더 밝게
                    while ($ratio < 7.0 && ($rFG > 0 || $gFG > 0 || $bFG > 0 || $rBG < 255 || $gBG < 255 || $bBG < 255)) {
                        if ($rFG > 0) $rFG = max(0, $rFG - 5);
                        if ($gFG > 0) $gFG = max(0, $gFG - 5);
                        if ($bFG > 0) $bFG = max(0, $bFG - 5);
                        if ($rBG < 255) $rBG = min(255, $rBG + 5);
                        if ($gBG < 255) $gBG = min(255, $gBG + 5);
                        if ($bBG < 255) $bBG = min(255, $bBG + 5);
                        
                        $Lbg = 0.2126*$lin($rBG)+0.7152*$lin($gBG)+0.0722*$lin($bBG);
                        $Lfg = 0.2126*$lin($rFG)+0.7152*$lin($gFG)+0.0722*$lin($bFG);
                        $ratio = max(($Lbg+0.05)/($Lfg+0.05), ($Lfg+0.05)/($Lbg+0.05));
                    }
                }
            }
    
            return [
                sprintf("#%02x%02x%02x", $rBG, $gBG, $bBG),
                sprintf("#%02x%02x%02x", $rFG, $gFG, $bFG)
            ];
        };
    
        // 13) 각 요소에 대해 색상 보정 적용
        foreach ($colorElements as $info) {
            $el = $info['element'];
            $bg = $info['bg_color'];
            
            // 배경색이 있는 경우에만 색상 보정 처리
            if ($bg !== null) {
                // 각 전경색에 대해 보정 처리
                foreach ($info['fg_colors'] as $fg) {
                    list($newBg, $newFg) = $adjustColorContrast($bg, $fg);
                    if ($newBg !== $bg || $newFg !== $fg) {
                        $rand = 'color-'.bin2hex(random_bytes(4));
                        $el->setAttribute('class', trim($el->getAttribute('class')).' '.$rand);
                        $css .= ".{$rand} { background-color: {$newBg}; color: {$newFg}; }\n";
                    }
                }
                
                // 전경색이 없는 경우, 내용이 있을 때만 기본 검정색으로 보정
                if (empty($info['fg_colors']) && $info['has_content']) {
                    list($newBg, $newFg) = $adjustColorContrast($bg, '#000000');
                    $rand = 'color-'.bin2hex(random_bytes(4));
                    $el->setAttribute('class', trim($el->getAttribute('class')).' '.$rand);
                    $css .= ".{$rand} { background-color: {$newBg}; color: {$newFg}; }\n";
                }
            }
        }
    
        // 14) <head>와 <body> 엘리먼트 준비
        $headEl = $dom->getElementsByTagName('head')->item(0) 
               ?: $dom->createElement('head');
        $bodyEl = $dom->getElementsByTagName('body')->item(0)
               ?: $dom->createElement('body');
    
        if (!empty($css)) {
            // SSR 스타일 추가
            $ssrStyleEl = $dom->createElement('style', "\n{$css}\n");
            $ssrStyleEl->setAttribute('nonce', NONCE);
            $ssrStyleEl->setAttribute('id', 'egb_ssr_style');
            $headEl->appendChild($ssrStyleEl);
        }
    
        // 15) 중복 검사용 기존 스크립트 수집
        $existingScripts = [];
        foreach ($dom->getElementsByTagName('script') as $s) {
            if ($s->hasAttribute('src')) {
                $existingScripts[$s->getAttribute('src')] = true;
            }
        }
    
        // 16) 위치 제어하며 스크립트 주입
        foreach ($scriptsToLoad as $src => $config) {
            if (isset($existingScripts[$src])) {
                continue;
            }
            $scriptEl = $dom->createElement('script');
            $scriptEl->setAttribute('src', $src);
            if ($config['loading'] === 'async' || $config['loading'] === 'defer') {
                $scriptEl->setAttribute($config['loading'], '');
            }
            $scriptEl->setAttribute('nonce', NONCE);
    
            if ($config['position'] === 'body') {
                // body 끝에 추가
                $bodyEl->appendChild($scriptEl);
            } else {
                // 기본 head에 추가
                $headEl->appendChild($scriptEl);
            }
        }
    
        // CSR 스타일 추가
        $csrStyleEl = $dom->createElement('style', '');
        $csrStyleEl->setAttribute('id', 'egb_csr_style'); 
        $csrStyleEl->setAttribute('nonce', NONCE);
        $headEl->appendChild($csrStyleEl);
    
        if (!$dom->getElementsByTagName('head')->length) {
            $htmlElement = $dom->getElementsByTagName('html')->item(0);
            if ($htmlElement) {
                $htmlElement->insertBefore($headEl, $htmlElement->firstChild);
            } else {
                // html 태그가 없는 경우 documentElement에 추가
                $dom->appendChild($headEl);
            }
        }

        // 스키마 데이터가 있으면 생성
        if (!empty($schemaTypes)) {
            foreach ($schemaTypes as $schemaItem) {
                $type = $schemaItem['type'];
                $data = !empty($schemaItem['data']) ? $schemaItem['data'] : [];
                
                // egb_schema_autoload로 호출
                $schemaJson = egb_schema($type, $dom, $data);
                
                if ($schemaJson) {
                    $scriptEl = $dom->createElement('script');
                    $scriptEl->setAttribute('type', 'application/ld+json');
                    $scriptEl->setAttribute('id', 'egb_schema_' . $type);
                    $scriptEl->appendChild($dom->createTextNode($schemaJson));
                    $headEl->appendChild($scriptEl);
                }
            }
        }
                
        // 16) 최종 HTML 직렬화
        $out = str_replace('<?xml encoding="UTF-8">', '', html_entity_decode($dom->saveHTML(), ENT_QUOTES|ENT_HTML5, 'UTF-8'));
    
        // 17) head 스크립트 복원 (</head> 바로 앞)
        if (!empty($headScripts)) {
            $inserts = implode("\n", $headScripts);
            $out = preg_replace(
                '/<\/head>/i',
                "\n{$inserts}\n</head>",
                $out,
                1
            );
        }
    
        // egb_csr_script를 head 태그 바로 뒤에 삽입
        $csr_script = egb_csr_script();
        $out = preg_replace(
            '/<head[^>]*>/i',
            "$0\n{$csr_script}",
            $out,
            1
        );
    
        // 18) body 스크립트 복원 (원래 자리 그대로) 
        if (!empty($bodyScripts)) {
            foreach($bodyScripts as $script) {
                $out = preg_replace('/<\/body>/i', $script."\n</body>", $out, 1);
            }
        }
    
        // 19) 도메인 프리커넥트와 이미지 프리로드 링크 생성
        $preconnectLinks = '';
        foreach ($domains as $domain => $value) {
            if ($domain !== HOST) {
                $preconnectLinks .= "<link rel='preconnect' href='https://{$domain}' crossorigin>\n";
                $preconnectLinks .= "<link rel='dns-prefetch' href='https://{$domain}'>\n";
            }
        }
    
        $preloadLinks = '';
        foreach (array_keys($preloadImages) as $imgSrc) {
            $preloadLinks .= "<link rel='preload' as='image' href='{$imgSrc}'>\n";
        }
    
        // 20) <!DOCTYPE html> 뒤에 프리커넥트와 프리로드 링크 삽입
        $out = "<!DOCTYPE html>\n" . $preconnectLinks . $preloadLinks . substr($out, strlen("<!DOCTYPE html>\n"));
    
        // 21) 출력
        echo $out;
    });



    // 더 이상의 출력 방지
    exit;
}
?>