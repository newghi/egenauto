<?php
function egb_schema_website($dom){
    $xpath = new DOMXPath($dom);

    // 사이트명은 <title>에서 추출
    $titleNode = $xpath->query("//title")->item(0);
    $siteName = $titleNode ? trim(preg_replace('/\s+/', ' ', $titleNode->textContent)) : "웹커스텀";

    // 사이트 설명은 <meta name="description">에서 추출
    $descNode = $xpath->query("//meta[@name='description']")->item(0);
    $description = $descNode ? trim(preg_replace('/\s+/', ' ', $descNode->getAttribute('content'))) : "";

    // 언어 정보 추출
    $langNode = $xpath->query("//html")->item(0);
    $language = $langNode && $langNode->hasAttribute('lang') ? $langNode->getAttribute('lang') : 'ko';

    // 키워드 추출
    $keywordsNode = $xpath->query("//meta[@name='keywords']")->item(0);
    $keywords = $keywordsNode ? trim($keywordsNode->getAttribute('content')) : "";

    // 대표 이미지 추출
    $imageNode = $xpath->query("//meta[@property='og:image']")->item(0);
    $image = $imageNode ? $imageNode->getAttribute('content') : "";

    // SNS 링크 추출 (확장된 소셜 미디어 지원)
    $snsLinks = [];
    $socialNodes = $xpath->query("//a[contains(@href, 'facebook.com') or contains(@href, 'twitter.com') or 
        contains(@href, 'instagram.com') or contains(@href, 'linkedin.com') or 
        contains(@href, 'youtube.com') or contains(@href, 'blog.naver.com')]");
    foreach ($socialNodes as $node) {
        $snsLinks[] = $node->getAttribute('href');
    }

    $schemaData = [
        "@context" => "https://schema.org",
        "@type" => "WebSite",
        "name" => $siteName,
        "alternateName" => "WebCustom",
        "url" => DOMAIN,
        "description" => $description,
        "inLanguage" => $language,
        "datePublished" => defined('EGB_THEME_LAUNCH_DATE') ? EGB_THEME_LAUNCH_DATE : date('Y-m-d'),
        "dateModified" => date('Y-m-d'),
        "publisher" => [
            "@type" => "Organization",
            "name" => "웹커스텀"
        ],
        "about" => "웹사이트 제작 및 템플릿 판매",
        "creator" => [
            "@type" => "Organization",
            "name" => "웹커스텀"
        ]
    ];

    // 선택적 속성 추가
    if ($keywords) $schemaData["keywords"] = $keywords;
    if ($image) $schemaData["image"] = $image;
    if (!empty($snsLinks)) $schemaData["sameAs"] = $snsLinks;

    // 저작권 정보 추가
    if (defined('EGB_THEME_COMPANY_NAME')) {
        $schemaData["copyrightHolder"] = [
            "@type" => "Organization",
            "name" => EGB_THEME_COMPANY_NAME
        ];
        $schemaData["copyrightYear"] = date('Y');
    }

    // search 파일이 존재하는 경우에만 potentialAction 추가
    $searchPath = DOMAIN . "/page/search/";
    if (@file_exists(ROOT.THEMES_PATH.DS.'page'.DS.'search.php')) {
        $schemaData["potentialAction"] = [
            [
                "@type" => "SearchAction",
                "target" => $searchPath . "?q={search_term_string}",
                "query-input" => "required name=search_term_string"
            ]
        ];
    }

    // 뉴스레터 구독 액션이 있는 경우
    if (@file_exists(ROOT.THEMES_PATH.DS.'page'.DS.'newsletter.php')) {
        if (!isset($schemaData["potentialAction"])) {
            $schemaData["potentialAction"] = [];
        }
        $schemaData["potentialAction"][] = [
            "@type" => "SubscribeAction",
            "target" => DOMAIN . "/page/newsletter/",
            "description" => "뉴스레터 구독"
        ];
    }

    // 사이트맵 XML 파일에서 메뉴들을 하위 섹션으로 추가
    $hasPart = [];
    $sitemapPath = ROOT . DS . 'egb_sitemap' . DS . 'main.xml';
    
    if (@file_exists($sitemapPath)) {
        $xml = @file_get_contents($sitemapPath);
        if ($xml) {
            $dom = new DOMDocument();
            @$dom->loadXML($xml);
            $xpath = new DOMXPath($dom);
            $xpath->registerNamespace('sm', 'http://www.sitemaps.org/schemas/sitemap/0.9');
            
            // urlset 내의 모든 url 요소 찾기
            $urls = $xpath->query('//sm:urlset/sm:url');
            
            foreach ($urls as $url) {
                $loc = $xpath->query('.//sm:loc', $url)->item(0);
                if ($loc) {
                    $urlString = trim($loc->textContent);
                    
                    // 메인 페이지는 제외
                    if ($urlString !== DOMAIN . '/' && $urlString !== DOMAIN) {
                        // URL에서 페이지명 추출 (예: /page/about -> about)
                        $path = parse_url($urlString, PHP_URL_PATH);
                        $segments = explode('/', trim($path, '/'));
                        $pageName = end($segments);
                        
                        // 페이지명이 있으면 사용, 없으면 URL 사용
                        $name = !empty($pageName) ? ucfirst($pageName) : '페이지';
                        
                        $hasPart[] = [
                            "@type" => "WebPage",
                            "name" => $name,
                            "url" => $urlString
                        ];
                    }
                }
            }
        }
    }
    
    if (!empty($hasPart)) {
        $schemaData["hasPart"] = $hasPart;
    }

    // 메인 페이지 정보 추가
    $schemaData["mainEntityOfPage"] = [
        "@type" => "WebPage",
        "@id" => DOMAIN
    ];

    // 식별자 추가
    $schemaData["identifier"] = DOMAIN;

    return json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}
?>