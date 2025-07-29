<?php
function egb_schema_faqpage($dom) {
    $xpath = new DOMXPath($dom);
    $detailsNodes = $xpath->query("//div[contains(@class,'egb-qna') or contains(@class,'egb_qna') or contains(@class,'egb_qna_accordion')]//details");
    if ($detailsNodes->length === 0) {
        return null; // QnA 구조가 없으면 스키마 없음
    }
    $mainEntity = [];
    foreach ($detailsNodes as $details) {
        $summaryNode = $details->getElementsByTagName('summary')->item(0);
        $answerNodeList = $xpath->query(".//*[contains(@class,'answer')]", $details);
        $answerNode = $answerNodeList->length > 0 ? $answerNodeList->item(0) : null;
        if ($summaryNode && $answerNode) {
            $question = trim(preg_replace('/\s+/', ' ', $summaryNode->textContent));
            $answer = trim(preg_replace('/\s+/', ' ', $answerNode->textContent));
            if ($question && $answer) {
                $mainEntity[] = [
                    "@type" => "Question",
                    "name" => $question,
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => $answer
                    ]
                ];
            }
        }
    }
    if (empty($mainEntity)) {
        return null;
    }
    $schemaData = [
        "@context" => "https://schema.org",
        "@type" => "FAQPage", 
        "mainEntity" => $mainEntity
    ];
    return json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
}

?>