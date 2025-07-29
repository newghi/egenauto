<?php
function egb_schema_localbusiness($dom, $data = []){
    $localBusinessData = [
        "@context" => "https://schema.org",
        "@type" => "LocalBusiness",
        "name" => $data['localbusiness-name'] ?? (defined('EGB_THEME_COMPANY_NAME') ? EGB_THEME_COMPANY_NAME : "웹커스텀"),
        "description" => $data['localbusiness-description'] ?? (defined('EGB_THEME_COMPANY_DESCRIPTION') ? EGB_THEME_COMPANY_DESCRIPTION : "홈페이지 제작 및 웹 개발 서비스"),
        "url" => $data['localbusiness-url'] ?? (defined('EGB_THEME_COMPANY_WEBSITE') ? EGB_THEME_COMPANY_WEBSITE : DOMAIN),
        "telephone" => $data['localbusiness-telephone'] ?? (defined('EGB_THEME_COMPANY_PHONE') ? EGB_THEME_COMPANY_PHONE : ""),
        "email" => $data['localbusiness-email'] ?? (defined('EGB_THEME_COMPANY_EMAIL') ? EGB_THEME_COMPANY_EMAIL : ""),
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => $data['localbusiness-street-address'] ?? (defined('EGB_THEME_COMPANY_ADDRESS') ? EGB_THEME_COMPANY_ADDRESS : ""),
            "addressLocality" => $data['localbusiness-address-locality'] ?? (defined('EGB_THEME_COMPANY_LOCALITY') ? EGB_THEME_COMPANY_LOCALITY : ""),
            "addressRegion" => $data['localbusiness-address-region'] ?? (defined('EGB_THEME_COMPANY_REGION') ? EGB_THEME_COMPANY_REGION : ""),
            "postalCode" => $data['localbusiness-postal-code'] ?? (defined('EGB_THEME_COMPANY_POSTAL_CODE') ? EGB_THEME_COMPANY_POSTAL_CODE : ""),
            "addressCountry" => $data['localbusiness-address-country'] ?? (defined('EGB_THEME_COMPANY_COUNTRY') ? EGB_THEME_COMPANY_COUNTRY : "KR")
        ],
        "geo" => [
            "@type" => "GeoCoordinates",
            "latitude" => $data['localbusiness-latitude'] ?? (defined('EGB_THEME_COMPANY_LATITUDE') ? EGB_THEME_COMPANY_LATITUDE : ""),
            "longitude" => $data['localbusiness-longitude'] ?? (defined('EGB_THEME_COMPANY_LONGITUDE') ? EGB_THEME_COMPANY_LONGITUDE : "")
        ],
        "openingHoursSpecification" => [
            "@type" => "OpeningHoursSpecification",
            "dayOfWeek" => $data['localbusiness-day-of-week'] ?? "Monday Tuesday Wednesday Thursday Friday",
            "opens" => $data['localbusiness-opens'] ?? (defined('EGB_THEME_COMPANY_OPENS') ? EGB_THEME_COMPANY_OPENS : "09:00"),
            "closes" => $data['localbusiness-closes'] ?? (defined('EGB_THEME_COMPANY_CLOSES') ? EGB_THEME_COMPANY_CLOSES : "18:00")
        ],
        "priceRange" => $data['localbusiness-price-range'] ?? (defined('EGB_THEME_COMPANY_PRICE_RANGE') ? EGB_THEME_COMPANY_PRICE_RANGE : "$$"),
        "paymentAccepted" => $data['localbusiness-payment-accepted'] ?? (defined('EGB_THEME_COMPANY_PAYMENT_ACCEPTED') ? EGB_THEME_COMPANY_PAYMENT_ACCEPTED : "Cash Credit Card"),
        "currenciesAccepted" => $data['localbusiness-currencies-accepted'] ?? (defined('EGB_THEME_COMPANY_CURRENCIES_ACCEPTED') ? EGB_THEME_COMPANY_CURRENCIES_ACCEPTED : "KRW"),
        "areaServed" => [
            "@type" => "Country",
            "name" => $data['localbusiness-area-served'] ?? (defined('EGB_THEME_AREA_SERVED') ? EGB_THEME_AREA_SERVED : (defined('EGB_THEME_COMPANY_COUNTRY') ? EGB_THEME_COMPANY_COUNTRY : "KR"))
        ],
        "serviceArea" => [
            "@type" => "GeoCircle",
            "geoMidpoint" => [
                "@type" => "GeoCoordinates",
                "latitude" => $data['localbusiness-service-latitude'] ?? "",
                "longitude" => $data['localbusiness-service-longitude'] ?? ""
            ],
            "geoRadius" => $data['localbusiness-service-radius'] ?? ""
        ],
        "hasOfferCatalog" => [
            "@type" => "OfferCatalog",
            "name" => $data['localbusiness-offer-catalog-name'] ?? "서비스 카탈로그",
            "itemListElement" => []
        ]
    ];
    
    if (!empty($data['localbusiness-image'])) {
        $localBusinessData['image'] = [
            "@type" => "ImageObject",
            "url" => $data['localbusiness-image'],
            "width" => $data['localbusiness-image-width'] ?? 1200,
            "height" => $data['localbusiness-image-height'] ?? 630
        ];
    }
    
    if (!empty($data['localbusiness-logo'])) {
        $localBusinessData['logo'] = [
            "@type" => "ImageObject",
            "url" => $data['localbusiness-logo'],
            "width" => $data['localbusiness-logo-width'] ?? 400,
            "height" => $data['localbusiness-logo-height'] ?? 400
        ];
    }
    
    if (!empty($data['localbusiness-founding-date'])) {
        $localBusinessData['foundingDate'] = $data['localbusiness-founding-date'];
    } elseif (defined('EGB_THEME_FOUNDING_DATE')) {
        $localBusinessData['foundingDate'] = EGB_THEME_FOUNDING_DATE;
    }
    
    if (!empty($data['localbusiness-employee'])) {
        $localBusinessData['employee'] = [
            "@type" => "Person",
            "name" => $data['localbusiness-employee']
        ];
    }
    
    if (!empty($data['localbusiness-founder'])) {
        $localBusinessData['founder'] = [
            "@type" => "Person",
            "name" => $data['localbusiness-founder']
        ];
    } elseif (defined('EGB_THEME_COMPANY_CEO')) {
        $localBusinessData['founder'] = [
            "@type" => "Person",
            "name" => EGB_THEME_COMPANY_CEO
        ];
    }
    
    if (!empty($data['localbusiness-contact-point'])) {
        $localBusinessData['contactPoint'] = [
            "@type" => "ContactPoint",
            "telephone" => $data['localbusiness-contact-point-telephone'] ?? (defined('EGB_THEME_COMPANY_PHONE') ? EGB_THEME_COMPANY_PHONE : ""),
            "contactType" => $data['localbusiness-contact-point-type'] ?? "customer service",
            "availableLanguage" => $data['localbusiness-contact-point-language'] ?? (defined('EGB_THEME_AVAILABLE_LANGUAGE') ? EGB_THEME_AVAILABLE_LANGUAGE : "Korean")
        ];
    }
    
    if (!empty($data['localbusiness-same-as'])) {
        $sameAs = explode(',', $data['localbusiness-same-as']);
        $localBusinessData['sameAs'] = array_map('trim', $sameAs);
    } else {
        $sameAs = [];
        if (defined('EGB_THEME_FACEBOOK_URL') && EGB_THEME_FACEBOOK_URL) $sameAs[] = EGB_THEME_FACEBOOK_URL;
        if (defined('EGB_THEME_INSTAGRAM_URL') && EGB_THEME_INSTAGRAM_URL) $sameAs[] = EGB_THEME_INSTAGRAM_URL;
        if (defined('EGB_THEME_YOUTUBE_URL') && EGB_THEME_YOUTUBE_URL) $sameAs[] = EGB_THEME_YOUTUBE_URL;
        if (defined('EGB_THEME_NAVER_BLOG_URL') && EGB_THEME_NAVER_BLOG_URL) $sameAs[] = EGB_THEME_NAVER_BLOG_URL;
        if (defined('EGB_THEME_NAVER_CAFE_URL') && EGB_THEME_NAVER_CAFE_URL) $sameAs[] = EGB_THEME_NAVER_CAFE_URL;
        if (!empty($sameAs)) {
            $localBusinessData['sameAs'] = $sameAs;
        }
    }
    
    if (!empty($data['localbusiness-service-type'])) {
        $localBusinessData['serviceType'] = $data['localbusiness-service-type'];
    } elseif (defined('EGB_THEME_COMPANY_SERVICE_TYPE')) {
        $localBusinessData['serviceType'] = EGB_THEME_COMPANY_SERVICE_TYPE;
    }
    
    if (!empty($data['localbusiness-knows-about'])) {
        $knowsAbout = explode(',', $data['localbusiness-knows-about']);
        $localBusinessData['knowsAbout'] = array_map('trim', $knowsAbout);
    } elseif (defined('EGB_THEME_COMPANY_KNOWS_ABOUT')) {
        $knowsAbout = explode(',', EGB_THEME_COMPANY_KNOWS_ABOUT);
        $localBusinessData['knowsAbout'] = array_map('trim', $knowsAbout);
    }
    
    if (!empty($data['localbusiness-award'])) {
        $awards = explode(',', $data['localbusiness-award']);
        $localBusinessData['award'] = array_map('trim', $awards);
    }
    
    if (!empty($data['localbusiness-review'])) {
        $localBusinessData['review'] = [
            "@type" => "Review",
            "reviewRating" => [
                "@type" => "Rating",
                "ratingValue" => $data['localbusiness-review-rating'] ?? "5",
                "bestRating" => $data['localbusiness-review-best-rating'] ?? "5"
            ],
            "author" => [
                "@type" => "Person",
                "name" => $data['localbusiness-review-author'] ?? "고객"
            ],
            "reviewBody" => $data['localbusiness-review-body'] ?? ""
        ];
    }
    
    return json_encode($localBusinessData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}
?>