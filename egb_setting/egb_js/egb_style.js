//글로벌 객체 생성
/**
 * egb_style.js
 * 
 * 동적 스타일 관리를 위한 유틸리티 모듈
 * 
 * 주요 기능:
 * - SSR/CSR 스타일시트 관리
 * - 선택자 중복 체크
 * - 동적 스타일 규칙 추가
 * 
 * 사용 예시:
 * EGB.style.check('.my-class') // 선택자 존재 여부 확인
 * EGB.style.add('.my-class', 'color: red;') // 새 스타일 규칙 추가
 */

; (function (global) {
    const EGB = global.EGB = global.EGB || {};
    let ssrSheet, csrSheet;

    function initSheets() {
        ssrSheet = document.getElementById('egb_ssr_style')?.sheet;
        csrSheet = document.getElementById('egb_csr_style')?.sheet;
    }

    function check(selector) {
        if (!ssrSheet || !csrSheet) initSheets();
        for (const sheet of [ssrSheet, csrSheet]) {
            if (!sheet) continue;
            for (let i = 0; i < sheet.cssRules.length; i++) {
                if (sheet.cssRules[i].selectorText === selector) return true;
            }
        }
        return false;
    }

    function add(selector, cssText) {
        if (!check(selector) && csrSheet) {
            csrSheet.insertRule(`${selector} { ${cssText} }`, csrSheet.cssRules.length);
        }
    }

    EGB.style = { check, add };
})(window);