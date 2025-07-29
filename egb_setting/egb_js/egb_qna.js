/**
 * egb_qna.js
 * 
 * QnA 박스 애니메이션 처리를 위한 유틸리티 모듈
 * 
 * 주요 기능:
 * - details/summary 태그 기반 QnA 애니메이션
 * - 부드러운 열기/닫기 애니메이션
 * - 간단한 함수 기반 구조
 * - 메모리 효율적인 리소스 관리
 * 
 */
; (function (global) {
    const EGB = global.EGB = global.EGB || {};

    // QnA 관련 설정
    const QNA_CONFIG = {
        defaultAnimationSpeed: 300
    };

    EGB.qna = {
        // 초기화 여부 추적
        _isInitialized: false,
        // 설정 옵션
        _options: {
            animationSpeed: QNA_CONFIG.defaultAnimationSpeed
        },


        // 속도 설정 메서드
        speed: function(speed) {
            this._options.animationSpeed = Number(speed) || QNA_CONFIG.defaultAnimationSpeed;
            
            // 이미 초기화된 요소들의 애니메이션 속도도 업데이트
            if (this._isInitialized) {
                const allDetails = document.querySelectorAll('.egb-qna details, .egb_qna details, .egb_qna_accordion details');
                allDetails.forEach(detail => {
                    if (detail._qnaState) {
                        detail._qnaState.animationSpeed = this._options.animationSpeed;
                        
                        // 회전 아이콘의 트랜지션 속도도 업데이트
                        const rotateIcon = detail.querySelector('.egb_qna_rotate');
                        if (rotateIcon) {
                            rotateIcon.style.transition = `transform ${this._options.animationSpeed}ms ease`;
                        }
                    }
                });
            }
            
            return this; // 체이닝을 위해 this 반환
        },

        // 자동 초기화 실행
        init: function() {
            // 이미 초기화된 경우 중복 실행 방지
            if (this._isInitialized) {
                return this;
            }

            // DOM이 준비되었는지 확인
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.autoInit());
            } else {
                this.autoInit();
            }
            
            return this; // 체이닝을 위해 this 반환
        },

        // 자동 초기화 로직
        autoInit: function() {
            // egb-qna, egb_qna, egb_qna_accordion 클래스를 가진 모든 details 요소 찾기
            const qnaElements = document.querySelectorAll('.egb-qna details, .egb_qna details, .egb_qna_accordion details');
            
            if (qnaElements.length === 0) {
                return; // QnA 요소가 없으면 초기화하지 않음
            }

            qnaElements.forEach((detailsElement) => {
                this.initQnaElement(detailsElement);
            });

            // 딥링크 처리
            this.handleDeepLink();

            this._isInitialized = true;
            console.log(`QnA auto-initialized: ${qnaElements.length} elements found with speed: ${this._options.animationSpeed}ms`);
        },



        /**
         * 개별 QnA 요소 초기화
         * @param {Element} element - details 요소
         */
        initQnaElement: function(element) {
            const summary = element.querySelector('summary');
            
            if (!summary) {
                console.warn(`QnA initialization failed: Missing <summary> in element`);
                return;
            }

            // 이미 초기화된 요소인지 확인
            if (element._qnaState) {
                return;
            }

            // CSS 클래스로 스타일 적용 (인라인 스타일 대신)
            element.classList.add('egb-qna-details');
            
            const siblingDiv = summary.nextElementSibling;
            if (siblingDiv && siblingDiv.tagName === 'DIV') {
                siblingDiv.classList.add('egb-qna-content');
            }

            // 회전 아이콘 초기화
            this.initRotateIcon(element);

            // 상태 관리 객체 생성
            const state = {
                element: element,
                summary: summary,
                animationSpeed: this._options.animationSpeed,
                animation: null,
                isClosing: false,
                isExpanding: false,
                isAccordion: element.closest('.egb_qna_accordion') !== null
            };

            // 바인딩된 이벤트 핸들러 생성 (메모리 누수 방지)
            const boundHandleClick = this.handleClick.bind(this, state);
            state.boundHandleClick = boundHandleClick;

            // 이벤트 리스너 등록
            summary.addEventListener('click', boundHandleClick);

            // 요소에 상태 객체 저장
            element._qnaState = state;
        },

        /**
         * 클릭 이벤트 처리
         * @param {Object} state - QnA 상태 객체
         * @param {Event} e - 클릭 이벤트
         */
        handleClick: function(state, e) {
            e.preventDefault();
            
            if (state.isClosing || !state.element.open) {
                // 아코디언 그룹이면 다른 요소들 닫기
                if (state.isAccordion) {
                    this.closeOtherAccordionItems(state);
                }
                
                // 클릭 순간 바로 회전 시작
                this.updateRotateIcon(state, true);
                this.open(state);
                
                // 딥링크 업데이트
                this.updateDeepLink(state);
            } else if (state.isExpanding || state.element.open) {
                // 클릭 순간 바로 회전 시작
                this.updateRotateIcon(state, false);
                this.close(state);
                
                // 딥링크 제거
                this.removeDeepLink(state);
            }
        },

        /**
         * QnA 열기
         * @param {Object} state - QnA 상태 객체
         */
        open: function(state) {
            if (!state.element) return;

            state.element.style.height = state.element.offsetHeight + 'px';
            state.element.open = true;

            requestAnimationFrame(() => this.expand(state));
        },

        /**
         * QnA 확장 애니메이션
         * @param {Object} state - QnA 상태 객체
         */
        expand: function(state) {
            const startHeight = state.element.offsetHeight;
            const endHeight = state.element.scrollHeight;

            state.isExpanding = true;
            this.cancelCurrentAnimation(state);

            state.animation = this.animateHeight(state.element, startHeight, endHeight, state.animationSpeed, () => {
                this.onAnimationFinish(state, true);
            });
        },

        /**
         * QnA 닫기
         * @param {Object} state - QnA 상태 객체
         */
        close: function(state) {
            if (!state.element) return;

            const startHeight = state.element.offsetHeight;
            const endHeight = state.summary.offsetHeight; // summary 높이만큼만 남김

            state.isClosing = true;
            this.cancelCurrentAnimation(state);

            // 회전 아이콘도 함께 회전
            this.updateRotateIcon(state, false);

            state.animation = this.animateHeight(state.element, startHeight, endHeight, state.animationSpeed, () => {
                state.element.open = false;
                this.onAnimationFinish(state, false);
            });
        },

        /**
         * 높이 애니메이션 실행 (안정적인 타이밍)
         * @param {Element} element - 애니메이션 대상 요소
         * @param {number} startHeight - 시작 높이
         * @param {number} endHeight - 종료 높이
         * @param {number} duration - 애니메이션 지속시간
         * @param {Function} callback - 완료 콜백
         */
        animateHeight: function(element, startHeight, endHeight, duration, callback) {
            const startTime = Date.now();
            const heightDiff = endHeight - startHeight;
            let animationId = null;

            const animate = () => {
                const elapsed = Date.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // 부드러운 easeInOutQuad 이징 함수
                const easeProgress = progress < 0.5 
                    ? 2 * progress * progress 
                    : 1 - Math.pow(-2 * progress + 2, 2) / 2;

                const currentHeight = startHeight + (heightDiff * easeProgress);
                element.style.height = currentHeight + 'px';

                if (progress < 1) {
                    // 더 안정적인 타이밍을 위해 setTimeout 사용
                    animationId = setTimeout(animate, 16); // 약 60fps
                } else {
                    // 정확히 완료 상태로 설정
                    element.style.height = endHeight + 'px';
                    if (callback) callback();
                }
            };

            animate();
            
            // 애니메이션 ID 반환 (취소용)
            return animationId;
        },

        /**
         * 현재 애니메이션 취소
         * @param {Object} state - QnA 상태 객체
         */
        cancelCurrentAnimation: function(state) {
            if (state.animation) {
                clearTimeout(state.animation);
                state.animation = null;
            }
        },

        /**
         * 애니메이션 완료 처리
         * @param {Object} state - QnA 상태 객체
         * @param {boolean} isOpen - 열림 상태
         */
        onAnimationFinish: function(state, isOpen) {
            state.isClosing = false;
            state.isExpanding = false;
            state.animation = null;

            if (isOpen) {
                state.element.style.height = 'auto';
            } else {
                // 닫힌 상태에서는 height 스타일 제거
                state.element.style.removeProperty('height');
            }
        },

        /**
         * 회전 아이콘 초기화
         * @param {Element} element - details 요소
         */
        initRotateIcon: function(element) {
            const rotateIcon = element.querySelector('.egb_qna_rotate');
            if (rotateIcon) {
                // 초기 상태 설정 (닫힌 상태)
                rotateIcon.style.transition = `transform ${this._options.animationSpeed}ms ease`;
                rotateIcon.style.transform = 'rotate(0deg)';
            }
        },

        /**
         * 회전 아이콘 업데이트
         * @param {Object} state - QnA 상태 객체
         * @param {boolean} isOpen - 열림 상태
         */
        updateRotateIcon: function(state, isOpen) {
            const rotateIcon = state.element.querySelector('.egb_qna_rotate');
            if (rotateIcon) {
                // 애니메이션 속도를 QnA와 동일하게 설정
                rotateIcon.style.transition = `transform ${state.animationSpeed}ms ease`;
                
                if (isOpen) {
                    rotateIcon.style.transform = 'rotate(180deg)';
                } else {
                    rotateIcon.style.transform = 'rotate(0deg)';
                }
            }
        },

        /**
         * 아코디언 그룹 내 다른 아이템들 닫기
         * @param {Object} state - 현재 열리는 QnA 상태 객체
         */
        closeOtherAccordionItems: function(state) {
            // 같은 아코디언 그룹 내의 다른 열린 요소들 찾기
            const accordionGroup = state.element.closest('.egb_qna_accordion');
            if (!accordionGroup) return;
            
            const otherDetails = accordionGroup.querySelectorAll('details[open]');
            otherDetails.forEach(detail => {
                if (detail !== state.element && detail._qnaState) {
                    // 부드럽게 닫기 (애니메이션과 함께)
                    this.close(detail._qnaState);
                }
            });
        },

        /**
         * 딥링크 처리
         */
        handleDeepLink: function() {
            const hash = window.location.hash;
            if (hash && hash.startsWith('#qna-')) {
                const targetId = hash.substring(5); // '#qna-' 제거
                const targetElement = document.getElementById(targetId);
                if (targetElement && targetElement._qnaState) {
                    // 약간의 지연 후 열기 (페이지 로드 완료 후)
                    setTimeout(() => {
                        this.open(targetElement._qnaState);
                    }, 100);
                }
            }
        },

        /**
         * 딥링크 업데이트
         * @param {Object} state - QnA 상태 객체
         */
        updateDeepLink: function(state) {
            const elementId = state.element.id;
            if (elementId) {
                const newHash = `#qna-${elementId}`;
                if (window.location.hash !== newHash) {
                    window.location.hash = newHash;
                }
            }
        },

        /**
         * 딥링크 제거
         * @param {Object} state - QnA 상태 객체
         */
        removeDeepLink: function(state) {
            const elementId = state.element.id;
            if (elementId && window.location.hash === `#qna-${elementId}`) {
                history.replaceState(null, null, window.location.pathname + window.location.search);
            }
        },

        /**
         * 모든 QnA 열기
         */
        openAll: function() {
            const allDetails = document.querySelectorAll('.egb-qna details, .egb_qna details, .egb_qna_accordion details');
            allDetails.forEach(detail => {
                if (detail._qnaState && !detail.open) {
                    this.open(detail._qnaState);
                }
            });
        },

        /**
         * 모든 QnA 닫기
         */
        closeAll: function() {
            const allDetails = document.querySelectorAll('.egb-qna details, .egb_qna details, .egb_qna_accordion details');
            allDetails.forEach(detail => {
                if (detail._qnaState && detail.open) {
                    this.close(detail._qnaState);
                }
            });
        },



        /**
         * QnA 요소 정리 (메모리 누수 방지)
         * @param {string} targetId - 타겟 요소의 ID
         */
        destroy: function(targetId) {
            const targetElement = document.getElementById(targetId);
            
            if (!targetElement) {
                console.warn(`Target element with ID '${targetId}' not found for destruction.`);
                return false;
            }

            // 모든 details 요소의 이벤트 리스너 제거
            const detailsElements = targetElement.querySelectorAll('details');
            
            detailsElements.forEach((detailsElement) => {
                const state = detailsElement._qnaState;
                if (state) {
                    // 이벤트 리스너 제거
                    if (state.boundHandleClick) {
                        state.summary.removeEventListener('click', state.boundHandleClick);
                    }
                    
                    // 애니메이션 취소
                    this.cancelCurrentAnimation(state);
                    
                    // CSS 클래스 제거
                    detailsElement.classList.remove('egb-qna-details');
                    const siblingDiv = state.summary.nextElementSibling;
                    if (siblingDiv && siblingDiv.tagName === 'DIV') {
                        siblingDiv.classList.remove('egb-qna-content');
                    }
                    
                    // 상태 객체 정리
                    delete detailsElement._qnaState;
                    delete state.boundHandleClick;
                }
            });

            console.log(`QnA destroyed: ${detailsElements.length} elements in '${targetId}'`);
            return true;
        },

        /**
         * 모든 QnA 요소 정리
         */
        destroyAll: function() {
            // 모든 초기화된 요소들 정리
            this._initializedElements.forEach((value, element) => {
                const detailsElements = element.querySelectorAll('details');
                detailsElements.forEach((detailsElement) => {
                    const state = detailsElement._qnaState;
                    if (state && state.boundHandleClick) {
                        state.summary.removeEventListener('click', state.boundHandleClick);
                        this.cancelCurrentAnimation(state);
                        delete detailsElement._qnaState;
                    }
                });
            });
            
            this._initializedElements.clear();
            
            console.log('All QnA elements destroyed');
        }
    };

    // 자동 초기화 실행
    EGB.qna.init();

})(typeof window !== 'undefined' ? window : this);