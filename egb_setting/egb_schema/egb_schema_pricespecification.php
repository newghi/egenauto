<?php
function egb_schema_pricespecification($dom, $data = []){
    $priceSpecificationData = [
        "@context" => "https://schema.org",
        "@type" => "PriceSpecification",
        "price" => $data['pricespecification-price'] ?? "0",
        "priceCurrency" => $data['pricespecification-price-currency'] ?? "KRW",
        "validFrom" => $data['pricespecification-valid-from'] ?? date("Y-m-d\TH:i:s+09:00"),
        "validThrough" => $data['pricespecification-valid-through'] ?? "",
        "minPrice" => $data['pricespecification-min-price'] ?? "",
        "maxPrice" => $data['pricespecification-max-price'] ?? "",
        "valueAddedTaxIncluded" => $data['pricespecification-vat-included'] ?? "true",
        "eligibleQuantity" => [
            "@type" => "QuantitativeValue",
            "minValue" => $data['pricespecification-quantity-min'] ?? "1",
            "maxValue" => $data['pricespecification-quantity-max'] ?? ""
        ],
        "eligibleTransactionVolume" => [
            "@type" => "PriceSpecification",
            "price" => $data['pricespecification-transaction-price'] ?? "",
            "priceCurrency" => $data['pricespecification-transaction-currency'] ?? "KRW"
        ]
    ];
    
    if (!empty($data['pricespecification-description'])) {
        $priceSpecificationData['description'] = $data['pricespecification-description'];
    }
    
    if (!empty($data['pricespecification-name'])) {
        $priceSpecificationData['name'] = $data['pricespecification-name'];
    }
    
    if (!empty($data['pricespecification-unit-text'])) {
        $priceSpecificationData['unitText'] = $data['pricespecification-unit-text'];
    }
    
    if (!empty($data['pricespecification-unit-code'])) {
        $priceSpecificationData['unitCode'] = $data['pricespecification-unit-code'];
    }
    
    if (!empty($data['pricespecification-eligible-region'])) {
        $priceSpecificationData['eligibleRegion'] = [
            "@type" => "Country",
            "name" => $data['pricespecification-eligible-region']
        ];
    }
    
    if (!empty($data['pricespecification-price-type'])) {
        $priceSpecificationData['priceType'] = $data['pricespecification-price-type'];
    }
    
    if (!empty($data['pricespecification-reference-quantity'])) {
        $priceSpecificationData['referenceQuantity'] = [
            "@type" => "QuantitativeValue",
            "value" => $data['pricespecification-reference-quantity'],
            "unitText" => $data['pricespecification-reference-unit'] ?? "개"
        ];
    }
    
    return json_encode($priceSpecificationData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}
?>