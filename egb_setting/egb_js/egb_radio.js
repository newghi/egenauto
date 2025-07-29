/**
 * EGB 라디오 버튼 관련 스크립트
 * 
 * 라디오 버튼 그룹을 관리하고 상태를 변경하는 기능을 제공하는 모듈입니다.
 * 
 * 주요 기능:
 * 1. 라디오 버튼 그룹 등록 및 관리
 *    - 동일 그룹의 라디오 버튼들을 관리
 *    - 그룹별 활성화된 버튼 상태 추적
 * 
 * 2. 이벤트 처리
 *    - 클릭 이벤트 감지 및 처리
 *    - 상태 변경 시 콜백 함수 실행
 * 
 * 3. 클래스 제어
 *    - 활성화/비활성화 클래스 자동 토글
 *    - data-radio-target 속성을 통한 연관 요소 클래스 제어
 * 
 * 사용 방법:
 * 1. HTML에서 라디오 버튼 그룹 정의
 *    <div class="egb_radio_group1">라디오 버튼 1</div>
 *    <div class="egb_radio_group1">라디오 버튼 2</div>
 * 
 * 2. 상태 변경 감지
 *    EGB.radio.on('group1', function(newActive, prevActive) {
 *      // 상태 변경 시 실행할 코드
 *    });
 * 
 * 3. 동적 요소 관리
 *    - 추가: EGB.radio.add(element)
 *    - 제거: EGB.radio.remove(element)
 * 
 * 4. 타겟 요소 클래스 제어
 *    <div class="egb_radio_group1" 
 *         data-radio-target-add="대상선택자, 추가할클래스"
 *         data-radio-target-del="대상선택자, 제거할클래스">
 *    </div>
 */

; (function (global) {
    const EGB = global.EGB = global.EGB || {};

    EGB.radio = (function () {
        // 상수 정의
        const RADIO_PREFIX = 'egb_radio_';  // 라디오 버튼 그룹 클래스 접두사
        const ACTIVE_SUFFIX = '_active';     // 활성화 상태 클래스 접미사

        // 상태 관리를 위한 Map 객체들
        const elementsMap = new Map();       // 그룹별 라디오 버튼 요소 저장
        const activeMap = new Map();         // 그룹별 활성화된 버튼 저장
        const changeHandlers = new Map();    // 그룹별 상태 변경 핸들러 저장

        /**
         * 라디오 버튼을 그룹에 등록
         * @param {HTMLElement} el - 등록할 라디오 버튼 요소
         * @param {string} group - 라디오 버튼 그룹명
         */
        function register(el, group) {
            if (!elementsMap.has(group)) {
                elementsMap.set(group, new Set());
            }
            elementsMap.get(group).add(el);

            const activeCls = 'egb_' + group + ACTIVE_SUFFIX;
            if (el.classList.contains(activeCls)) {
                activeMap.set(group, el);
            }
        }

        /**
         * 타겟 요소의 클래스 변경 지시자 처리
         * @param {string} raw - 클래스 변경 지시자 문자열 (형식: "선택자, 클래스명")
         * @param {string} action - 수행할 동작 ('add' 또는 'remove')
         * @param {HTMLElement} btn - 클래스 변경을 트리거한 버튼
         */
        function applyDirective(raw, action, btn) {
            const parts = raw.split(/\s*,\s*/);
            const selPart = parts[0] || '';
            const clsPart = parts[1] || '';

            const sels = selPart.trim().split(/\s+/).filter(Boolean);
            const clss = clsPart.trim().split(/\s+/).filter(Boolean);

            sels.forEach(sel => {
                const targets = document.querySelectorAll(sel);
                targets.forEach(target => {
                    EGB.function.changeClass(target, clss.join(' '));
                });
            });
        }

        /**
         * 라디오 버튼 클릭 이벤트 핸들러
         * @param {Event} e - 클릭 이벤트 객체
         */
        function handleClick(e) {
            const btn = e.target.closest(`[class*="${RADIO_PREFIX}"]`);
            if (!btn) return;

            Array.from(btn.classList)
                .filter(c => c.startsWith(RADIO_PREFIX))
                .forEach(full => {
                    const group = full.slice(RADIO_PREFIX.length);
                    const activeCls = 'egb_' + group + ACTIVE_SUFFIX;
                    const prev = activeMap.get(group);

                    // 활성화 상태 변경
                    if (prev) prev.classList.remove(activeCls);
                    btn.classList.add(activeCls);
                    activeMap.set(group, btn);

                    // data-radio-add 처리 (addClass 사용)
                    if (btn.dataset.radioAdd) {
                        const [selector, className] = btn.dataset.radioAdd.split(',').map(s => s.trim());
                        const targets = document.querySelectorAll(selector);
                        targets.forEach(target => {
                            if (EGB.function && EGB.function.addClass) {
                                EGB.function.addClass(target, className);
                            } else {
                                target.classList.add(className);
                            }
                        });
                    }

                    // data-radio-del 처리 (delClass 사용)
                    if (btn.dataset.radioDel) {
                        const [selector, className] = btn.dataset.radioDel.split(',').map(s => s.trim());
                        const targets = document.querySelectorAll(selector);
                        targets.forEach(target => {
                            if (EGB.function && EGB.function.delClass) {
                                EGB.function.delClass(target, className);
                            } else {
                                target.classList.remove(className);
                            }
                        });
                    }

                    // 기존 data-radio-target-add 처리 (하위 호환성)
                    Object.entries(btn.dataset).forEach(([key, value]) => {
                        if (key.startsWith('radioTargetAdd')) {
                            const num = key.slice('radioTargetAdd'.length);
                            if (num) {
                                applyDirective(value, 'add', btn);
                            }
                        }
                    });

                    // 기존 data-radio-target-del 처리 (하위 호환성)
                    Object.entries(btn.dataset).forEach(([key, value]) => {
                        if (key.startsWith('radioTargetDel')) {
                            const num = key.slice('radioTargetDel'.length);
                            if (num) {
                                applyDirective(value, 'remove', btn);
                            }
                        }
                    });

                    // 상태 변경 핸들러 실행
                    const handlers = changeHandlers.get(group);
                    if (handlers) {
                        handlers.forEach(fn => fn(btn, prev));
                    }
                });
        }

        /**
         * 라디오 버튼 모듈 초기화
         * - 페이지 내 라디오 버튼 그룹 등록
         * - 클릭 이벤트 리스너 등록
         */
        function init() {
            const dataEl = document.getElementById('egb-radio-group-data');
            if (dataEl) {
                try {
                    const groups = JSON.parse(dataEl.textContent);
                    groups.forEach(group => {
                        const elements = document.querySelectorAll(`.${RADIO_PREFIX}${group}`);
                        elements.forEach(el => register(el, group));
                    });
                } catch (err) { }
            }
            document.addEventListener('click', handleClick);
        }

        /**
         * 상태 변경 핸들러 등록
         * @param {string} group - 라디오 버튼 그룹명
         * @param {Function} fn - 상태 변경 시 실행할 콜백 함수
         */
        function on(group, fn) {
            if (typeof fn !== 'function') return;
            if (!changeHandlers.has(group)) {
                changeHandlers.set(group, new Set());
            }
            changeHandlers.get(group).add(fn);
        }

        /**
         * 상태 변경 핸들러 제거
         * @param {string} group - 라디오 버튼 그룹명
         * @param {Function} fn - 제거할 핸들러 함수
         */
        function off(group, fn) {
            const handlers = changeHandlers.get(group);
            if (handlers) handlers.delete(fn);
        }

        /**
         * 동적으로 라디오 버튼 추가
         * @param {HTMLElement} el - 추가할 라디오 버튼 요소
         */
        function add(el) {
            Array.from(el.classList)
                .filter(c => c.startsWith(RADIO_PREFIX))
                .forEach(full => register(el, full.slice(RADIO_PREFIX.length)));
        }

        /**
         * 라디오 버튼 제거
         * @param {HTMLElement} el - 제거할 라디오 버튼 요소
         */
        function remove(el) {
            Array.from(el.classList)
                .filter(c => c.startsWith(RADIO_PREFIX))
                .forEach(full => {
                    const group = full.slice(RADIO_PREFIX.length);
                    const set = elementsMap.get(group);
                    if (!set) return;
                    set.delete(el);
                    if (activeMap.get(group) === el) activeMap.delete(group);
                    if (set.size === 0) elementsMap.delete(group);
                });
        }

        // 공개 API
        return { init, add, remove, on, off };
    })();

    // DOM 로드 완료 시 초기화
    document.addEventListener('DOMContentLoaded', () => {
        if (EGB.radio && typeof EGB.radio.init === 'function') {
            EGB.radio.init();
        }
    });
})(window);
