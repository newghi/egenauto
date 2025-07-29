<?php
function egb_schema_organization($dom){
    $xpath = new DOMXPath($dom);

    // 사이트명 (og:site_name → <title> → fallback)
    $orgName = '';
    $ogSiteName = $xpath->query("//meta[@property='og:site_name']")->item(0);
    if ($ogSiteName) {
        $orgName = trim($ogSiteName->getAttribute('content'));
    } else {
        $titleNode = $xpath->query("//title")->item(0);
        $orgName = $titleNode ? trim(preg_replace('/\s+/', ' ', $titleNode->textContent)) : (defined('EGB_THEME_COMPANY_NAME') ? EGB_THEME_COMPANY_NAME : '웹커스텀');
    }

    // 로고 이미지 (og:image → fallback)
    $logoUrl = '';
    $ogImage = $xpath->query("//meta[@property='og:image']")->item(0);
    if ($ogImage) {
        $logoUrl = trim($ogImage->getAttribute('content'));
    } else {
        $logoUrl = DOMAIN . THEMES_PATH . DS . 'logo.webp';
    }

    $schemaData = [
        "@context" => "https://schema.org",
        "@type"    => "Organization",
        "name"     => $orgName,
        "url"      => DOMAIN,
        "logo"     => $logoUrl
    ];

    // 기본 정보 추가
    // 회사 소개
    if (defined('EGB_THEME_COMPANY_DESCRIPTION') && !empty(EGB_THEME_COMPANY_DESCRIPTION)) {
        $schemaData["description"] = EGB_THEME_COMPANY_DESCRIPTION;
    }
    
    // 설립일
    if (defined('EGB_THEME_FOUNDING_DATE') && !empty(EGB_THEME_FOUNDING_DATE)) {
        $schemaData["foundingDate"] = EGB_THEME_FOUNDING_DATE;
    }

    // 슬로건
    if (defined('EGB_THEME_COMPANY_SLOGAN') && !empty(EGB_THEME_COMPANY_SLOGAN)) {
        $schemaData["slogan"] = EGB_THEME_COMPANY_SLOGAN;
    }

    // 주소 정보 추가
    if (defined('EGB_THEME_COMPANY_ADDRESS') && !empty(EGB_THEME_COMPANY_ADDRESS)) {
        $schemaData["address"] = [
            "@type" => "PostalAddress",
            "streetAddress" => EGB_THEME_COMPANY_ADDRESS,
            "addressCountry" => defined('EGB_THEME_COMPANY_COUNTRY') ? EGB_THEME_COMPANY_COUNTRY : 'KR',
            "postalCode" => defined('EGB_THEME_COMPANY_POSTAL_CODE') ? EGB_THEME_COMPANY_POSTAL_CODE : '',
            "addressLocality" => defined('EGB_THEME_COMPANY_LOCALITY') ? EGB_THEME_COMPANY_LOCALITY : ''
        ];
    }

    // SNS 링크 추가
    $sameAs = [];
    // 페이스북
    if (defined('EGB_THEME_FACEBOOK_URL') && !empty(EGB_THEME_FACEBOOK_URL)) {
        $sameAs[] = EGB_THEME_FACEBOOK_URL;
    }
    // 인스타그램
    if (defined('EGB_THEME_INSTAGRAM_URL') && !empty(EGB_THEME_INSTAGRAM_URL)) {
        $sameAs[] = EGB_THEME_INSTAGRAM_URL;
    }
    // 트위터
    if (defined('EGB_THEME_TWITTER_URL') && !empty(EGB_THEME_TWITTER_URL)) {
        $sameAs[] = EGB_THEME_TWITTER_URL;
    }
    // 유튜브
    if (defined('EGB_THEME_YOUTUBE_URL') && !empty(EGB_THEME_YOUTUBE_URL)) {
        $sameAs[] = EGB_THEME_YOUTUBE_URL;
    }
    // 네이버 블로그
    if (defined('EGB_THEME_NAVER_BLOG_URL') && !empty(EGB_THEME_NAVER_BLOG_URL)) {
        $sameAs[] = EGB_THEME_NAVER_BLOG_URL;
    }
    // 네이버 카페
    if (defined('EGB_THEME_NAVER_CAFE_URL') && !empty(EGB_THEME_NAVER_CAFE_URL)) {
        $sameAs[] = EGB_THEME_NAVER_CAFE_URL;
    }
    if (!empty($sameAs)) {
        $schemaData["sameAs"] = $sameAs;
    }

    // contactPoint 정보 추가
    if (defined('EGB_THEME_COMPANY_PHONE') && defined('EGB_THEME_AREA_SERVED') && 
        defined('EGB_THEME_AVAILABLE_LANGUAGE') &&
        !empty(EGB_THEME_COMPANY_PHONE) && !empty(EGB_THEME_AREA_SERVED) &&
        !empty(EGB_THEME_AVAILABLE_LANGUAGE)) {
        $schemaData["contactPoint"] = [
            [
                "@type" => "ContactPoint",
                "telephone" => EGB_THEME_COMPANY_PHONE,
                "contactType" => "customer service",
                "areaServed" => EGB_THEME_AREA_SERVED,
                "availableLanguage" => EGB_THEME_AVAILABLE_LANGUAGE
            ]
        ];
    }

    return json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

?>