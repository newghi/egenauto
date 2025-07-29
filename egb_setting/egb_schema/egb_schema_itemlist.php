<?php

function egb_schema_itemlist($dom){
    
    $xpath = new DOMXPath($dom);
    
    // 모든 상품 노드들을 가져오기
    $productNodes = $xpath->query("//*[@data-schema-itemlist-name]");
    
    // 상품이 없으면 null 반환
    if ($productNodes->length === 0) {
        return null;
    }

    $items = [];
    $position = 1;

    // ItemList 기본 정보
    $schemaData = [
        "@context" => "https://schema.org",
        "@type"    => "ItemList",
        "itemListOrder" => "Ascending"
    ];

    // ItemList 추가 속성 처리
    $firstNode = $productNodes->item(0)->parentNode;
    $listAttrs = [
        'name' => 'data-schema-itemlist-list-name',
        'description' => 'data-schema-itemlist-list-description',
        'url' => 'data-schema-itemlist-list-url',
        'numberOfItems' => 'data-schema-itemlist-list-number',
        'itemListOrder' => 'data-schema-itemlist-list-order',
        'alternateName' => 'data-schema-itemlist-list-alternate-name',
        'identifier' => 'data-schema-itemlist-list-identifier',
        'inLanguage' => 'data-schema-itemlist-list-language',
        'mainEntityOfPage' => 'data-schema-itemlist-list-main-entity',
        'additionalType' => 'data-schema-itemlist-list-additional-type',
        'about' => 'data-schema-itemlist-list-about',
        'author' => 'data-schema-itemlist-list-author',
        'creator' => 'data-schema-itemlist-list-creator', 
        'publisher' => 'data-schema-itemlist-list-publisher',
        'datePublished' => 'data-schema-itemlist-list-date-published',
        'dateModified' => 'data-schema-itemlist-list-date-modified',
        'mainEntity' => 'data-schema-itemlist-list-main-entity',
        'image' => 'data-schema-itemlist-list-image'
    ];

    foreach ($listAttrs as $prop => $attr) {
        $value = $firstNode->getAttribute($attr);
        if (!empty($value)) {
            $schemaData[$prop] = trim($value);
        }
    }

    foreach ($productNodes as $node) {
        // 필수값인 name이 없으면 건너뛰기
        $name = trim($node->getAttribute('data-schema-itemlist-name'));
        if (empty($name)) {
            continue;
        }

        // 기본 상품 데이터
        $product = [
            "@type" => "Product",
            "name"  => $name
        ];

        // Product 속성 매핑 배열
        $productAttrs = [
            'description' => 'data-schema-itemlist-description',
            'sku' => 'data-schema-itemlist-sku',
            'mpn' => 'data-schema-itemlist-mpn',
            'category' => 'data-schema-itemlist-category',
            'material' => 'data-schema-itemlist-material',
            'color' => 'data-schema-itemlist-color',
            'url' => 'data-schema-itemlist-url',
            'productionDate' => 'data-schema-itemlist-production-date',
            'releaseDate' => 'data-schema-itemlist-release-date',
            'award' => 'data-schema-itemlist-award',
            'manufacturer' => 'data-schema-itemlist-manufacturer',
            'model' => 'data-schema-itemlist-model',
            'countryOfOrigin' => 'data-schema-itemlist-country',
            'slogan' => 'data-schema-itemlist-slogan',
            'disambiguatingDescription' => 'data-schema-itemlist-disambiguating',
            'productID' => 'data-schema-itemlist-product-id',
            'isAccessoryOrSparePartFor' => 'data-schema-itemlist-accessory-for',
            'keywords' => 'data-schema-itemlist-keywords',
            'size' => 'data-schema-itemlist-size',
            'additionalType' => 'data-schema-itemlist-additional-type',
            'identifier' => 'data-schema-itemlist-identifier',
            'sameAs' => 'data-schema-itemlist-same-as',
            'audience' => 'data-schema-itemlist-audience',
            'pattern' => 'data-schema-itemlist-pattern',
            'logo' => 'data-schema-itemlist-logo',
            'hasMerchantReturnPolicy' => 'data-schema-itemlist-return-policy',
            'isRelatedTo' => 'data-schema-itemlist-related-to',
            'isSimilarTo' => 'data-schema-itemlist-similar-to',
            'energyEfficiencyScaleMin' => 'data-schema-itemlist-energy-min',
            'energyEfficiencyScaleMax' => 'data-schema-itemlist-energy-max'
        ];

        // Product 속성들 처리
        foreach ($productAttrs as $prop => $attr) {
            $value = $node->getAttribute($attr);
            if (!empty($value)) {
                if (in_array($prop, ['sameAs', 'isRelatedTo', 'isSimilarTo'])) {
                    $product[$prop] = array_filter(array_map('trim', explode('|', $value)));
                } else {
                    $product[$prop] = trim($value);
                }
            }
        }

        // 무게, 높이, 너비, 깊이 처리
        $dimensions = [
            'weight' => ['attr' => 'data-schema-itemlist-weight', 'defaultUnit' => 'KGM'],
            'height' => ['attr' => 'data-schema-itemlist-height', 'defaultUnit' => 'CMT'],
            'width' => ['attr' => 'data-schema-itemlist-width', 'defaultUnit' => 'CMT'],
            'depth' => ['attr' => 'data-schema-itemlist-depth', 'defaultUnit' => 'CMT']
        ];

        foreach ($dimensions as $dim => $config) {
            $value = $node->getAttribute($config['attr']);
            if (!empty($value)) {
                // 숫자와 단위 분리
                preg_match('/^([\d.]+)\s*([a-zA-Z]+)?$/', trim($value), $matches);
                if (isset($matches[1])) {
                    $numValue = $matches[1];
                    $unit = isset($matches[2]) ? strtoupper($matches[2]) : $config['defaultUnit'];
                    
                    // 단위 변환
                    $unitCode = match($unit) {
                        'PX' => 'E37',
                        'CM' => 'CMT',
                        'KG' => 'KGM',
                        default => $unit
                    };

                    $product[$dim] = [
                        "@type" => "QuantitativeValue",
                        "value" => $numValue,
                        "unitCode" => $unitCode
                    ];
                }
            }
        }

        // 이미지 처리 (단일/복수)
        $images = $node->getAttribute('data-schema-itemlist-image');
        if (!empty($images)) {
            $imageArray = array_filter(array_map('trim', explode('|', $images)));
            $product["image"] = count($imageArray) > 1 ? $imageArray : $imageArray[0];
        }

        // 가격 정보 처리
        $price = $node->getAttribute('data-schema-itemlist-price');
        $priceCurrency = $node->getAttribute('data-schema-itemlist-pricecurrency');
        
        if (!empty($price) && !empty($priceCurrency)) {
            $price = preg_replace('/[^0-9.]/', '', $price);
            if (is_numeric($price) && floatval($price) > 0) {
                $price = number_format(floatval($price), 0, '.', '');
                
                $offer = [
                    "@type" => "Offer",
                    "priceCurrency" => trim($priceCurrency),
                    "price" => $price
                ];

                // 재고 수량(inventoryLevel)
                $inventoryLevel = $node->getAttribute('data-schema-itemlist-inventory');
                if (!empty($inventoryLevel) && is_numeric($inventoryLevel)) {
                    $offer["inventoryLevel"] = [
                        "@type" => "QuantitativeValue",
                        "value" => (int) $inventoryLevel
                    ];
                }

                // 재고 상태 처리
                $availability = "https://schema.org/InStock";
                $availabilityAttr = strtolower($node->getAttribute('data-schema-itemlist-availability'));
                $availabilityMap = [
                    'outofstock' => 'OutOfStock',
                    'preorder' => 'PreOrder',
                    'discontinued' => 'Discontinued',
                    'backorder' => 'BackOrder',
                    'limited' => 'LimitedAvailability',
                    'soldout' => 'SoldOut',
                    'instore' => 'InStoreOnly',
                    'online' => 'OnlineOnly'
                ];
                if (isset($availabilityMap[$availabilityAttr])) {
                    $availability = "https://schema.org/" . $availabilityMap[$availabilityAttr];
                }
                $offer["availability"] = $availability;

                $product["offers"] = $offer;
            }
        }

        $items[] = [
            "@type" => "ListItem",
            "position" => $position++,
            "item" => $product
        ];
    }

    // itemListElement가 빈 배열이면 null 반환
    if (empty($items)) {
        return null;
    }

    if (!isset($schemaData["numberOfItems"])) {
        $schemaData["numberOfItems"] = count($items);
    }
    $schemaData["itemListElement"] = $items;

    return json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

?>