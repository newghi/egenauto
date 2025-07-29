// 전역 EGB 객체에 form 기능 추가
/**
 * egb_form.js
 * 
 * 폼 관련 유틸리티 모듈
 * 
 * 주요 기능:
 * - 폼 제출 이벤트 처리 및 훅 관리
 * - 폼 데이터 검증 및 가공
 * - AJAX 제출 지원
 * 
 * 사용 예시:
 * // 폼 제출 훅 추가
 * EGB.form.add('formId', data => {
 *   // 데이터 처리
 * });
 * 
 * // 폼 제출 트리거
 * EGB.form.submit('formId', data => {
 *   // 제출 후 처리
 * });
 * 
 * 주의사항:
 * - 훅 함수는 중복 등록되지 않음
 * - 폼 ID는 필수값
 * - 훅은 반드시 함수 형태여야 함
 */

(function (global) {
    const EGB = global.EGB = global.EGB || {};

    EGB.form = {
        // 훅 데이터 저장소에 대한 접근자 (SPA에서 사용)
        _dataHooks: dataHooks,
        // 훅 추가 및 폼 제출 메서드
        submit: function (targetId, hook) {
            if (typeof hook === 'function') {
                if (!dataHooks.has(targetId)) {
                    dataHooks.set(targetId, []); // ID에 맞는 훅 배열 초기화
                }

                const hooksArray = dataHooks.get(targetId);

                // 중복 확인 후 추가
                if (!hooksArray.includes(hook)) {
                    hooksArray.push(hook); // 중복이 아닐 경우에만 해당 폼 ID에 맞는 훅 추가
                    console.log('훅 추가됨:', hook);
                } else {
                    console.log('이미 존재하는 훅:', hook);
                }
            } else {
                console.error('함수가 아닙니다:', hook);
            }

            // 폼을 찾아서 제출 이벤트 트리거
            const formElement = document.querySelector(`#${targetId}`);
            if (formElement) {
                formElement.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
            }
        },

        // 훅 추가 메서드
        add: function (targetId, hook) {
            if (typeof hook === 'function') {
                if (!dataHooks.has(targetId)) {
                    dataHooks.set(targetId, []); // ID에 맞는 훅 배열 초기화
                }
                const hooksArray = dataHooks.get(targetId);

                // 중복 확인 후 추가
                if (!hooksArray.includes(hook)) {
                    hooksArray.push(hook); // 중복이 아닐 경우에만 해당 폼 ID에 맞는 훅 추가
                    console.log('훅 추가됨:', hook);
                } else {
                    console.log('이미 존재하는 훅:', hook);
                }
            } else {
                console.error('함수가 아닙니다:', hook);
            }
        }
    };
})(window);

// 기존 함수를 EGB.form.submit으로 연결
function egbAjaxDataHook(targetId, hook) {
    EGB.form.submit(targetId, hook);
}

//기존함수
function egbAjaxDataHookAdd(targetId, hook) {
    EGB.form.add(targetId, hook);
}