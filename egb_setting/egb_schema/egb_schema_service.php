<?php
function egb_schema_service($dom, $data = []){

    $serviceData = [
        "@type" => "Service",
        "name" => $data['service-name'] ?? "",
        "description" => $data['service-description'] ?? "",
        "provider" => [
            "@type" => "Organization",
            "name" => defined('EGB_THEME_COMPANY_NAME') ? EGB_THEME_COMPANY_NAME : "웹커스텀",
            "url" => DOMAIN
        ]
    ];
    
    // 추가 속성들 처리
    if (!empty($data['service-type'])) {
        $serviceData['serviceType'] = $data['service-type'];
    }
    
    if (!empty($data['service-area'])) {
        $serviceData['areaServed'] = [
            "@type" => "Country",
            "name" => $data['service-area']
        ];
    }
    
    if (!empty($data['service-price']) && !empty($data['service-price-currency'])) {
        $serviceData['offers'] = [
            "@type" => "Offer",
            "price" => $data['service-price'],
            "priceCurrency" => $data['service-price-currency']
        ];
        
        if (!empty($data['service-availability'])) {
            $serviceData['offers']['availability'] = "https://schema.org/" . $data['service-availability'];
        }
    }
    
    if (!empty($data['service-url'])) {
        $serviceData['url'] = $data['service-url'];
    }
    
    return json_encode($serviceData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);


}
?>