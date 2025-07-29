<?php
// print_data 수신
$print_data = egb('print_data');

// 기본 보안 필터링 (XSS 방지)
if (empty($print_data)) {
    echo '출력할 데이터가 없습니다.';
    exit;
}

// admin-box 클래스 요소 제거 (서버사이드 안전장치)
$dom = new DOMDocument();
@$dom->loadHTML(mb_convert_encoding($print_data, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
$xpath = new DOMXPath($dom);
foreach ($xpath->query("//*[contains(@class, 'admin-box')]") as $box) {
    $box->parentNode->removeChild($box);
}
$print_data = $dom->saveHTML();
?>
    <style>
        body {
            margin: 0; 
            padding: 20px; 
            font-family: sans-serif;
            transform-origin: top left;
        }
        .scrolls_1 { overflow-y: visible !important; }
        .scrollbar::-webkit-scrollbar { display: none; }

        @media print {
            @page {
                margin: 10mm;
                size: A4 portrait;  /* 기본값을 세로로 설정 */
            }
            body {
                -webkit-print-color-adjust: exact;
                margin: 0; 
                padding: 0;
                width: 100%;
                height: 100%;
            }
            /* 가로/세로 콘텐츠 모두 페이지 크기에 맞추기 */
            img, table, .wide-content {
                max-width: 100% !important;
                width: auto !important;
                height: auto !important;
            }
            /* 동적 admin-box 숨김 */
            .admin-box {
                display: none !important;
            }
            /* 자연스러운 페이지 나누기 허용 */
            * { 
                page-break-inside: auto;
            }
            /* 테이블 헤더 반복 */
            thead {
                display: table-header-group;
            }
            /* 원하지 않는 위치에서 페이지 나누기 방지 */
            h1, h2, h3, h4, h5, h6, img, table { 
                page-break-inside: avoid;
            }
            /* 새로운 섹션은 새 페이지에서 시작 */
            section {
                page-break-before: always;
            }
        }
    </style>
    <?php
    echo html_entity_decode($print_data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    ?>
<script nonce="<?php echo NONCE; ?>">
    window.onload = function() {
        const content = document.body;
        const contentWidth = content.scrollWidth;
        const contentHeight = content.scrollHeight;
        
        // A4 크기 (px 단위, 96dpi 기준)
        const a4Width = 210 * 96 / 25.4;  // A4 가로
        const a4Height = 297 * 96 / 25.4;  // A4 세로
        
        // 가로/세로 비율 확인 및 페이지 방향 설정
        const isLandscape = contentWidth > contentHeight;
        
        let scale;
        if (isLandscape) {
            // 가로가 긴 경우 - 가로 방향으로 설정
            const styleSheet = document.styleSheets[0];
            const mediaRule = Array.from(styleSheet.cssRules).find(rule => rule.media && rule.media.mediaText == 'print');
            const pageRule = Array.from(mediaRule.cssRules).find(rule => rule.selectorText == '@page');
            pageRule.style.size = 'A4 landscape';
            
            // 가로 모드에서의 스케일 계산
            scale = Math.min(
                (a4Height / contentWidth) * 0.9,  // 가로 기준 (A4 가로 = 297mm)
                (a4Width / contentHeight) * 0.9   // 세로 기준 (A4 세로 = 210mm)
            );
        } else {
            // 세로가 긴 경우 - 세로 방향으로 설정
            scale = Math.min(
                (a4Width / contentWidth) * 0.9,   // 가로 기준
                (a4Height / contentHeight) * 0.9  // 세로 기준
            );
        }
        
        // 스케일 적용
        document.body.style.transform = `scale(${scale})`;
    };

    // 로드 후 조금 기다렸다가 인쇄 대화상자 열기
    window.addEventListener('load', function() {
        setTimeout(function() {
            window.print();
        }, 1000);
    });
</script>
