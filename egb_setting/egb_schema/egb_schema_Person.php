<?php
function egb_schema_person($dom, $data = []){
    $personData = [
        "@context" => "https://schema.org",
        "@type" => "Person",
        "name" => $data['person-name'] ?? (defined('EGB_THEME_COMPANY_CEO') ? EGB_THEME_COMPANY_CEO : ""),
        "description" => $data['person-description'] ?? "",
        "url" => $data['person-url'] ?? DOMAIN,
        "email" => $data['person-email'] ?? (defined('EGB_THEME_COMPANY_EMAIL') ? EGB_THEME_COMPANY_EMAIL : ""),
        "telephone" => $data['person-telephone'] ?? (defined('EGB_THEME_COMPANY_PHONE') ? EGB_THEME_COMPANY_PHONE : ""),
        "address" => [
            "@type" => "PostalAddress",
            "streetAddress" => $data['person-street-address'] ?? (defined('EGB_THEME_COMPANY_ADDRESS') ? EGB_THEME_COMPANY_ADDRESS : ""),
            "addressLocality" => $data['person-address-locality'] ?? (defined('EGB_THEME_COMPANY_LOCALITY') ? EGB_THEME_COMPANY_LOCALITY : ""),
            "addressRegion" => $data['person-address-region'] ?? (defined('EGB_THEME_COMPANY_REGION') ? EGB_THEME_COMPANY_REGION : ""),
            "postalCode" => $data['person-postal-code'] ?? (defined('EGB_THEME_COMPANY_POSTAL_CODE') ? EGB_THEME_COMPANY_POSTAL_CODE : ""),
            "addressCountry" => $data['person-address-country'] ?? (defined('EGB_THEME_COMPANY_COUNTRY') ? EGB_THEME_COMPANY_COUNTRY : "KR")
        ],
        "birthDate" => $data['person-birth-date'] ?? "",
        "deathDate" => $data['person-death-date'] ?? "",
        "gender" => $data['person-gender'] ?? "",
        "nationality" => $data['person-nationality'] ?? (defined('EGB_THEME_COMPANY_COUNTRY') ? EGB_THEME_COMPANY_COUNTRY : "KR"),
        "jobTitle" => $data['person-job-title'] ?? "CEO",
        "worksFor" => [
            "@type" => "Organization",
            "name" => defined('EGB_THEME_COMPANY_NAME') ? EGB_THEME_COMPANY_NAME : "웹커스텀",
            "url" => defined('EGB_THEME_COMPANY_WEBSITE') ? EGB_THEME_COMPANY_WEBSITE : DOMAIN
        ],
        "alumniOf" => [
            "@type" => "Organization",
            "name" => $data['person-alumni-of'] ?? ""
        ],
        "knowsAbout" => [],
        "knowsLanguage" => $data['person-knows-language'] ?? (defined('EGB_THEME_AVAILABLE_LANGUAGE') ? EGB_THEME_AVAILABLE_LANGUAGE : "Korean"),
        "award" => [],
        "hasOccupation" => [
            "@type" => "Occupation",
            "name" => $data['person-occupation'] ?? "웹 개발자",
            "occupationLocation" => [
                "@type" => "Place",
                "name" => defined('EGB_THEME_COMPANY_NAME') ? EGB_THEME_COMPANY_NAME : "웹커스텀"
            ]
        ]
    ];
    
    if (!empty($data['person-image'])) {
        $personData['image'] = [
            "@type" => "ImageObject",
            "url" => $data['person-image'],
            "width" => $data['person-image-width'] ?? 400,
            "height" => $data['person-image-height'] ?? 400
        ];
    }
    
    if (!empty($data['person-given-name'])) {
        $personData['givenName'] = $data['person-given-name'];
    }
    
    if (!empty($data['person-family-name'])) {
        $personData['familyName'] = $data['person-family-name'];
    }
    
    if (!empty($data['person-additional-name'])) {
        $personData['additionalName'] = $data['person-additional-name'];
    }
    
    if (!empty($data['person-honorific-prefix'])) {
        $personData['honorificPrefix'] = $data['person-honorific-prefix'];
    }
    
    if (!empty($data['person-honorific-suffix'])) {
        $personData['honorificSuffix'] = $data['person-honorific-suffix'];
    }
    
    if (!empty($data['person-birth-place'])) {
        $personData['birthPlace'] = [
            "@type" => "Place",
            "name" => $data['person-birth-place']
        ];
    }
    
    if (!empty($data['person-death-place'])) {
        $personData['deathPlace'] = [
            "@type" => "Place",
            "name" => $data['person-death-place']
        ];
    }
    
    if (!empty($data['person-height'])) {
        $personData['height'] = [
            "@type" => "QuantitativeValue",
            "value" => $data['person-height'],
            "unitText" => $data['person-height-unit'] ?? "cm"
        ];
    }
    
    if (!empty($data['person-weight'])) {
        $personData['weight'] = [
            "@type" => "QuantitativeValue",
            "value" => $data['person-weight'],
            "unitText" => $data['person-weight-unit'] ?? "kg"
        ];
    }
    
    if (!empty($data['person-fax-number'])) {
        $personData['faxNumber'] = $data['person-fax-number'];
    } elseif (defined('EGB_THEME_COMPANY_FAX')) {
        $personData['faxNumber'] = EGB_THEME_COMPANY_FAX;
    }
    
    if (!empty($data['person-same-as'])) {
        $sameAs = explode(',', $data['person-same-as']);
        $personData['sameAs'] = array_map('trim', $sameAs);
    } else {
        $sameAs = [];
        if (defined('EGB_THEME_FACEBOOK_URL') && EGB_THEME_FACEBOOK_URL) $sameAs[] = EGB_THEME_FACEBOOK_URL;
        if (defined('EGB_THEME_INSTAGRAM_URL') && EGB_THEME_INSTAGRAM_URL) $sameAs[] = EGB_THEME_INSTAGRAM_URL;
        if (defined('EGB_THEME_YOUTUBE_URL') && EGB_THEME_YOUTUBE_URL) $sameAs[] = EGB_THEME_YOUTUBE_URL;
        if (defined('EGB_THEME_NAVER_BLOG_URL') && EGB_THEME_NAVER_BLOG_URL) $sameAs[] = EGB_THEME_NAVER_BLOG_URL;
        if (defined('EGB_THEME_NAVER_CAFE_URL') && EGB_THEME_NAVER_CAFE_URL) $sameAs[] = EGB_THEME_NAVER_CAFE_URL;
        if (!empty($sameAs)) {
            $personData['sameAs'] = $sameAs;
        }
    }
    
    if (!empty($data['person-knows-about'])) {
        $knowsAbout = explode(',', $data['person-knows-about']);
        $personData['knowsAbout'] = array_map('trim', $knowsAbout);
    } elseif (defined('EGB_THEME_COMPANY_KNOWS_ABOUT')) {
        $knowsAbout = explode(',', EGB_THEME_COMPANY_KNOWS_ABOUT);
        $personData['knowsAbout'] = array_map('trim', $knowsAbout);
    }
    
    if (!empty($data['person-award'])) {
        $awards = explode(',', $data['person-award']);
        $personData['award'] = array_map('trim', $awards);
    }
    
    if (!empty($data['person-contact-point'])) {
        $personData['contactPoint'] = [
            "@type" => "ContactPoint",
            "telephone" => $data['person-contact-point-telephone'] ?? (defined('EGB_THEME_COMPANY_PHONE') ? EGB_THEME_COMPANY_PHONE : ""),
            "contactType" => $data['person-contact-point-type'] ?? "customer service",
            "availableLanguage" => $data['person-contact-point-language'] ?? (defined('EGB_THEME_AVAILABLE_LANGUAGE') ? EGB_THEME_AVAILABLE_LANGUAGE : "Korean")
        ];
    }
    
    if (!empty($data['person-spouse'])) {
        $personData['spouse'] = [
            "@type" => "Person",
            "name" => $data['person-spouse']
        ];
    }
    
    if (!empty($data['person-children'])) {
        $children = explode(',', $data['person-children']);
        $personData['children'] = array_map(function($child) {
            return [
                "@type" => "Person",
                "name" => trim($child)
            ];
        }, $children);
    }
    
    if (!empty($data['person-parents'])) {
        $parents = explode(',', $data['person-parents']);
        $personData['parents'] = array_map(function($parent) {
            return [
                "@type" => "Person",
                "name" => trim($parent)
            ];
        }, $parents);
    }
    
    if (!empty($data['person-siblings'])) {
        $siblings = explode(',', $data['person-siblings']);
        $personData['siblings'] = array_map(function($sibling) {
            return [
                "@type" => "Person",
                "name" => trim($sibling)
            ];
        }, $siblings);
    }
    
    if (!empty($data['person-colleague'])) {
        $colleagues = explode(',', $data['person-colleague']);
        $personData['colleague'] = array_map(function($colleague) {
            return [
                "@type" => "Person",
                "name" => trim($colleague)
            ];
        }, $colleagues);
    }
    
    if (!empty($data['person-follows'])) {
        $follows = explode(',', $data['person-follows']);
        $personData['follows'] = array_map(function($follow) {
            return [
                "@type" => "Person",
                "name" => trim($follow)
            ];
        }, $follows);
    }
    
    if (!empty($data['person-friend'])) {
        $friends = explode(',', $data['person-friend']);
        $personData['friend'] = array_map(function($friend) {
            return [
                "@type" => "Person",
                "name" => trim($friend)
            ];
        }, $friends);
    }
    
    return json_encode($personData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}
?>