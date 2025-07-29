/**
 * egb_img.js
 * 
 * 이미지 최적화 및 관리를 위한 유틸리티 모듈
 * 
 * 주요 기능:
 * - 렌더링된 이미지 크기 자동 설정
 * - 반응형 이미지 크기 조정
 * - 이미지 로드 최적화
 * 
 * 사용 예시:
 * EGB.img.getDims(imgElement) // 이미지 크기 가져오기
 * EGB.img.updateDims() // 모든 이미지 크기 업데이트
 */

;(function(global) {
    const EGB = global.EGB = global.EGB || {};

    function getDims(img) {
        return {
            width: img.offsetWidth || img.clientWidth,
            height: img.offsetHeight || img.clientHeight
        };
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function updateDims() {
        const images = document.querySelectorAll('img');
        
        for(const img of images) {
            try {
                const dimensions = getDims(img);
                img.setAttribute('width', dimensions.width);
                img.setAttribute('height', dimensions.height);
            } catch(err) {
                console.error('이미지 크기를 가져오는데 실패했습니다:', img.src);
            }
        }
    }

    // 초기화 및 이벤트 바인딩
    document.addEventListener('DOMContentLoaded', updateDims);
    window.addEventListener('resize', debounce(updateDims, 250));

    EGB.img = { getDims, updateDims };
})(window);
