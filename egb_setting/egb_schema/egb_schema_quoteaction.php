<?php
function egb_schema_quoteaction($dom, $data = []){
    $quoteActionData = [
        "@context" => "https://schema.org",
        "@type" => "QuoteAction",
        "agent" => [
            "@type" => "Person",
            "name" => $data['quoteaction-agent-name'] ?? "고객명 (자동)"
        ],
        "object" => [
            "@type" => "Service",
            "name" => $data['quoteaction-service-name'] ?? "홈페이지 맞춤 제작 서비스",
            "description" => $data['quoteaction-service-description'] ?? "맞춤형 제작 및 템플릿 판매 서비스"
        ],
        "result" => [
            "@type" => "Quotation",
            "description" => $data['quoteaction-description'] ?? "자동 견적서 발급",
            "price" => $data['quoteaction-price'] ?? "99,000 ~",
            "priceCurrency" => $data['quoteaction-price-currency'] ?? "KRW",
            "url" => $data['quoteaction-url'] ?? URL
        ],
        "startTime" => $data['quoteaction-start-time'] ?? date("Y-m-d\TH:i:s+09:00"),
        "location" => [
            "@type" => "VirtualLocation",
            "url" => $data['quoteaction-location-url'] ?? URL
        ]
    ];
    
    if (!empty($data['quoteaction-end-time'])) {
        $quoteActionData['endTime'] = $data['quoteaction-end-time'];
    }
    
    if (!empty($data['quoteaction-target'])) {
        $quoteActionData['target'] = [
            "@type" => "EntryPoint",
            "urlTemplate" => $data['quoteaction-target']
        ];
    }
    
    if (!empty($data['quoteaction-instrument'])) {
        $quoteActionData['instrument'] = [
            "@type" => "WebApplication",
            "name" => $data['quoteaction-instrument']
        ];
    }
    
    if (!empty($data['quoteaction-recipient'])) {
        $quoteActionData['recipient'] = [
            "@type" => "Organization",
            "name" => defined('EGB_THEME_COMPANY_NAME') ? EGB_THEME_COMPANY_NAME : "웹커스텀",
            "url" => DOMAIN
        ];
    }
    
    return json_encode($quoteActionData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}
?>