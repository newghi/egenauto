<?php
function egb_schema_webpage($dom){
    $xpath = new DOMXPath($dom);

    // 1) 제목 (og:title → <title>)
    $ogTitleNode = $xpath->query("//meta[@property='og:title']")->item(0);
    if ($ogTitleNode) {
        $title = trim($ogTitleNode->getAttribute('content'));
    } else {
        $titleNode = $xpath->query("//title")->item(0);
        $title = $titleNode ? trim(preg_replace('/\s+/', ' ', $titleNode->textContent)) : "";
    }

    // 2) 설명 (og:description → <meta name='description'>)
    $ogDescNode = $xpath->query("//meta[@property='og:description']")->item(0);
    if ($ogDescNode) {
        $description = trim($ogDescNode->getAttribute('content'));
    } else {
        $descNode = $xpath->query("//meta[@name='description']")->item(0);
        $description = $descNode ? trim(preg_replace('/\s+/', ' ', $descNode->getAttribute('content'))) : "";
    }

    // 3) 대표 이미지 (og:image)
    $ogImageNode = $xpath->query("//meta[@property='og:image']")->item(0);
    $primaryImage = $ogImageNode ? trim($ogImageNode->getAttribute('content')) : "";
    
    // 이미지 크기 정보 가져오기
    $imageWidth = null;
    $imageHeight = null;
    if ($primaryImage) {
        $ogImageWidth = $xpath->query("//meta[@property='og:image:width']")->item(0);
        $ogImageHeight = $xpath->query("//meta[@property='og:image:height']")->item(0);
        $imageWidth = $ogImageWidth ? intval($ogImageWidth->getAttribute('content')) : null;
        $imageHeight = $ogImageHeight ? intval($ogImageHeight->getAttribute('content')) : null;
    }

    // 4) 언어 (og:locale → html lang)
    $ogLocaleNode = $xpath->query("//meta[@property='og:locale']")->item(0);
    if ($ogLocaleNode) {
        $language = trim($ogLocaleNode->getAttribute('content'));
    } else {
        $htmlNode = $xpath->query("//html[@lang]")->item(0);
        $language = $htmlNode ? trim($htmlNode->getAttribute('lang')) : "ko";
    }

    // 5) 페이지 타입 (og:type)
    $ogTypeNode = $xpath->query("//meta[@property='og:type']")->item(0);
    $pageType = $ogTypeNode ? trim($ogTypeNode->getAttribute('content')) : "";

    if (!$title && !$description) return null;

    $schemaData = [
        "@context"    => "https://schema.org",
        "@type"       => "WebPage",
        "name"        => $title,
        "description" => $description,
        "url"         => URL,
        "inLanguage"  => $language,
        "datePublished" => defined('EGB_THEME_LAUNCH_DATE') ? EGB_THEME_LAUNCH_DATE : date("Y-m-d"),
        "dateModified"  => date("Y-m-d"),
        "lastReviewed"  => defined('EGB_THEME_LAUNCH_DATE') ? EGB_THEME_LAUNCH_DATE : date("Y-m-d"),
        "isPartOf"    => [
            "@type" => "WebSite",
            "@id" => DOMAIN,
            "url"   => DOMAIN
        ],
        "author" => [
            "@type" => "Organization",
            "name" => "웹커스텀"
        ],
        "publisher" => [
            "@type" => "Organization", 
            "name" => "웹커스텀"
        ]
    ];

    // 대표 이미지가 있는 경우만 추가
    if ($primaryImage) {
        $imageObject = [
            "@type" => "ImageObject",
            "url"   => $primaryImage
        ];
        
        // 이미지 크기 정보가 있는 경우 추가
        if ($imageWidth) {
            $imageObject["width"] = $imageWidth;
        }
        if ($imageHeight) {
            $imageObject["height"] = $imageHeight;
        }
        
        $schemaData["primaryImageOfPage"] = $imageObject;
    }

    // 브레드크럼 설정 파일 로드
    $breadcrumbConfigPath = ROOT . DS . "egb_setting" . DS . "egb_config" . DS . "009-egb_breadcrumb_config.php";
    $breadcrumbPaths = [];
    
    if (@file_exists($breadcrumbConfigPath)) {
        $configContent = @file_get_contents($breadcrumbConfigPath);
        if ($configContent) {
            // PHP 배열 부분만 추출하여 eval로 실행
            if (preg_match('/\[\s*(.*?)\s*\];/s', $configContent, $matches)) {
                $arrayString = '[' . $matches[1] . ']';
                $breadcrumbPaths = eval('return ' . $arrayString . ';');
            }
        }
    }
    
    // 브레드크럼 정보 추가
    $breadcrumbItems = [];
    $currentPath = parse_url(URL, PHP_URL_PATH);
    
    if (isset($breadcrumbPaths[$currentPath])) {
        $position = 1;
        foreach ($breadcrumbPaths[$currentPath] as $item) {
            $breadcrumbItems[] = [
                "@type" => "ListItem",
                "position" => $position,
                "name" => $item['name'],
                "item" => $item['url']
            ];
            $position++;
        }
    }
    
    if (!empty($breadcrumbItems)) {
        $schemaData["breadcrumb"] = [
            "@type" => "BreadcrumbList",
            "itemListElement" => $breadcrumbItems
        ];
    }
    
    // about/mentions 정보 추가 (페이지가 특정 주제에 대해 다룰 때)
    $aboutItems = [];
    
    // 회사 정보가 있는 경우 about에 추가
    if (defined('EGB_THEME_COMPANY_NAME') && EGB_THEME_COMPANY_NAME) {
        $aboutItems[] = [
            "@type" => "Organization",
            "name" => EGB_THEME_COMPANY_NAME,
            "url" => DOMAIN
        ];
    }
    
    if (!empty($aboutItems)) {
        $schemaData["about"] = $aboutItems;
    }

    // mainEntity 추가 (페이지 타입에 따라)
    if ($pageType) {
        switch($pageType) {
            case 'article':
                $schemaData["mainEntity"] = [
                    "@type" => "Article",
                    "headline" => $title,
                    "description" => $description,
                    "image" => $primaryImage,
                    "datePublished" => defined('EGB_THEME_LAUNCH_DATE') ? EGB_THEME_LAUNCH_DATE : date("Y-m-d"),
                    "dateModified" => date("Y-m-d")
                ];
                break;
            case 'product':
                $schemaData["mainEntity"] = [
                    "@type" => "Product",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage,
                    "offers" => [
                        "@type" => "Offer",
                        "availability" => "https://schema.org/InStock"
                    ]
                ];
                break;
            case 'service':
                $schemaData["mainEntity"] = [
                    "@type" => "Service",
                    "name" => $title,
                    "description" => $description,
                    "provider" => [
                        "@type" => "Organization",
                        "name" => "웹커스텀"
                    ]
                ];
                break;
            case 'blog':
                $schemaData["mainEntity"] = [
                    "@type" => "BlogPosting",
                    "headline" => $title,
                    "description" => $description,
                    "image" => $primaryImage,
                    "datePublished" => defined('EGB_THEME_LAUNCH_DATE') ? EGB_THEME_LAUNCH_DATE : date("Y-m-d"),
                    "dateModified" => date("Y-m-d"),
                    "author" => [
                        "@type" => "Organization",
                        "name" => "웹커스텀"
                    ]
                ];
                break;
            case 'news':
                $schemaData["mainEntity"] = [
                    "@type" => "NewsArticle",
                    "headline" => $title,
                    "description" => $description,
                    "image" => $primaryImage,
                    "datePublished" => defined('EGB_THEME_LAUNCH_DATE') ? EGB_THEME_LAUNCH_DATE : date("Y-m-d"),
                    "dateModified" => date("Y-m-d")
                ];
                break;
            case 'event':
                $schemaData["mainEntity"] = [
                    "@type" => "Event",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage,
                    "organizer" => [
                        "@type" => "Organization",
                        "name" => "웹커스텀"
                    ]
                ];
                break;
            case 'faq':
                $schemaData["mainEntity"] = [
                    "@type" => "FAQPage",
                    "name" => $title,
                    "description" => $description
                ];
                break;
            case 'about':
                $schemaData["mainEntity"] = [
                    "@type" => "AboutPage",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'contact':
                $schemaData["mainEntity"] = [
                    "@type" => "ContactPage",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'review':
                $schemaData["mainEntity"] = [
                    "@type" => "Review",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage,
                    "datePublished" => defined('EGB_THEME_LAUNCH_DATE') ? EGB_THEME_LAUNCH_DATE : date("Y-m-d"),
                    "author" => [
                        "@type" => "Organization",
                        "name" => "웹커스텀"
                    ]
                ];
                break;
            case 'video':
                $schemaData["mainEntity"] = [
                    "@type" => "VideoObject",
                    "name" => $title,
                    "description" => $description,
                    "thumbnailUrl" => $primaryImage,
                    "uploadDate" => defined('EGB_THEME_LAUNCH_DATE') ? EGB_THEME_LAUNCH_DATE : date("Y-m-d")
                ];
                break;
            case 'profile':
                $schemaData["mainEntity"] = [
                    "@type" => "ProfilePage",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'collection':
                $schemaData["mainEntity"] = [
                    "@type" => "CollectionPage",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'search':
                $schemaData["mainEntity"] = [
                    "@type" => "SearchResultsPage",
                    "name" => $title,
                    "description" => $description
                ];
                break;
            case 'software':
                $schemaData["mainEntity"] = [
                    "@type" => "SoftwareApplication",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'organization':
                $schemaData["mainEntity"] = [
                    "@type" => "Organization",
                    "name" => $title,
                    "description" => $description,
                    "logo" => $primaryImage
                ];
                break;
            case 'game':
                $schemaData["mainEntity"] = [
                    "@type" => "Game",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'howto':
                $schemaData["mainEntity"] = [
                    "@type" => "HowTo",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'music':
                $schemaData["mainEntity"] = [
                    "@type" => "MusicRecording",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'profile':
                $schemaData["mainEntity"] = [
                    "@type" => "ProfilePage",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'recipe':
                $schemaData["mainEntity"] = [
                    "@type" => "Recipe",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;
            case 'job':
                $schemaData["mainEntity"] = [
                    "@type" => "JobPosting",
                    "title" => $title,
                    "description" => $description,
                    "datePosted" => defined('EGB_THEME_LAUNCH_DATE') ? EGB_THEME_LAUNCH_DATE : date("Y-m-d")
                ];
                break;
            case 'course':
                $schemaData["mainEntity"] = [
                    "@type" => "Course",
                    "name" => $title,
                    "description" => $description,
                    "image" => $primaryImage
                ];
                break;   
        }
    }

    return json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

?>