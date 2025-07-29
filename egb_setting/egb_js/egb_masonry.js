/**
 * egb_masonry.js
 * 
 * Onesal 스타일 벽돌 레이아웃 처리를 위한 유틸리티 모듈
 * 
 * 주요 기능:
 * - 클래스 기반 벽돌 레이아웃 시스템
 * - 점진적 열 증가 애니메이션
 * - 반응형 레이아웃 자동 조정
 * - SPA 환경 호환성
 * - 메모리 효율적인 리소스 관리
 * 
 */
; (function (global) {
    const EGB = global.EGB = global.EGB || {};

    // Masonry 관련 설정
    const MASONRY_CONFIG = {
        defaultGap: 24,
        defaultMaxColumns: 4,
        defaultAnimationDelay: 100,
        defaultColumnIncreaseDelay: 500
    };

    EGB.masonry = {
        // 초기화 여부 추적
        _isInitialized: false,
        // 활성화된 인스턴스들 추적
        _instances: new Map(),
        // 설정 옵션
        _options: {
            gap: MASONRY_CONFIG.defaultGap,
            maxColumns: MASONRY_CONFIG.defaultMaxColumns,
            animationDelay: MASONRY_CONFIG.defaultAnimationDelay,
            columnIncreaseDelay: MASONRY_CONFIG.defaultColumnIncreaseDelay
        },

        // 옵션 설정 메서드
        config: function(options = {}) {
            this._options = { ...this._options, ...options };
            
            // 이미 초기화된 인스턴스들의 옵션도 업데이트
            this._instances.forEach(instance => {
                Object.assign(instance.options, this._options);
            });
            
            return this;
        },

        // 자동 초기화 실행
        init: function() {
            if (this._isInitialized) {
                return this;
            }

            // DOM이 준비되었는지 확인하고, 약간의 지연을 두어 다른 스크립트들이 로드될 시간을 줍니다
            const initMasonry = () => {
                setTimeout(() => {
                    this.autoInit();
                }, 100);
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initMasonry);
            } else {
                initMasonry();
            }
            
            return this;
        },

        // 자동 초기화 로직
        autoInit: function() {
            // 이미 초기화된 경우 중복 실행 방지
            if (this._isInitialized) {
                console.log('Masonry already initialized, skipping...');
                return;
            }
            
            // id가 egb_masonry인 요소만 찾기
            const masonryElements = document.querySelectorAll('#egb_masonry');
            
            console.log('Masonry autoInit called, found elements:', masonryElements.length);
            
            if (masonryElements.length === 0) {
                console.log('No masonry elements found');
                return;
            }

            masonryElements.forEach((element, index) => {
                console.log(`Initializing masonry element ${index}:`, element);
                this.initMasonryElement(element);
            });

            // SPA 환경을 위한 MutationObserver 설정
            this.setupMutationObserver();

            this._isInitialized = true;
            console.log(`Masonry auto-initialized: ${masonryElements.length} elements found`);
        },

        /**
         * 개별 Masonry 요소 초기화
         * @param {Element} element - masonry 컨테이너 요소
         */
        initMasonryElement: function(element) {
            if (element._masonryInstance) {
                return;
            }

            const instance = new EGBMasonryInstance(element, this._options);
            element._masonryInstance = instance;
            this._instances.set(element, instance);
        },

        /**
         * MutationObserver 설정 (SPA 환경용)
         */
        setupMutationObserver: function() {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'childList') {
                        mutation.addedNodes.forEach((node) => {
                            if (node.nodeType === 1) {
                                if (node.id === 'egb_masonry') {
                                    setTimeout(() => this.initMasonryElement(node), 100);
                                }
                                const masonryElements = node.querySelectorAll('#egb_masonry');
                                if (masonryElements.length > 0) {
                                    masonryElements.forEach(element => {
                                        setTimeout(() => this.initMasonryElement(element), 100);
                                    });
                                }
                            }
                        });
                    }
                });
            });
            
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        },

        /**
         * 수동으로 특정 요소 초기화
         * @param {string|Element} selector - 선택자 또는 요소
         * @param {Object} options - 추가 옵션
         */
        initElement: function(selector, options = {}) {
            const element = typeof selector === 'string' ? document.querySelector(selector) : selector;
            if (element) {
                const mergedOptions = { ...this._options, ...options };
                this.initMasonryElement(element);
                if (element._masonryInstance) {
                    Object.assign(element._masonryInstance.options, mergedOptions);
                }
            }
            return this;
        },

        /**
         * 특정 요소 새로고침
         * @param {string|Element} selector - 선택자 또는 요소
         */
        refresh: function(selector) {
            const element = typeof selector === 'string' ? document.querySelector(selector) : selector;
            if (element && element._masonryInstance) {
                element._masonryInstance.refresh();
            }
            return this;
        },

        /**
         * 모든 요소 새로고침
         */
        refreshAll: function() {
            this._instances.forEach(instance => {
                instance.refresh();
            });
            return this;
        },

        /**
         * SPA 환경 재초기화
         */
        reinit: function() {
            this._instances.forEach(instance => {
                instance.destroy();
            });
            this._instances.clear();
            
            setTimeout(() => {
                this.autoInit();
            }, 200);
            
            return this;
        },

        /**
         * 특정 요소 정리
         * @param {string|Element} selector - 선택자 또는 요소
         */
        destroy: function(selector) {
            const element = typeof selector === 'string' ? document.querySelector(selector) : selector;
            if (element && element._masonryInstance) {
                element._masonryInstance.destroy();
                this._instances.delete(element);
                delete element._masonryInstance;
            }
            return this;
        },

        /**
         * 모든 요소 정리
         */
        destroyAll: function() {
            this._instances.forEach(instance => {
                instance.destroy();
            });
            this._instances.clear();
            this._isInitialized = false;
            return this;
        }
    };

    /**
     * 개별 Masonry 인스턴스 클래스
     */
    class EGBMasonryInstance {
        constructor(container, options = {}) {
            this.container = container;
            this.options = {
                gap: MASONRY_CONFIG.defaultGap,
                maxColumns: MASONRY_CONFIG.defaultMaxColumns,
                animationDelay: MASONRY_CONFIG.defaultAnimationDelay,
                columnIncreaseDelay: MASONRY_CONFIG.defaultColumnIncreaseDelay,
                ...options
            };
            
            this.currentColumnCount = 1;
            this.maxColumnCount = this.getMaxColumnCount();
            this.isInitialized = false;
            this.resizeListener = null;
            
            this.init();
        }
        
        getMaxColumnCount() {
            const width = window.innerWidth;
            if (width <= 480) return 1;
            if (width <= 768) return 2;
            if (width <= 1200) return 3;
            return this.options.maxColumns;
        }
        
        init() {
            if (!this.container || this.isInitialized) return;
            
            this.setupContainer();
            this.setupItems();
            this.startProgressiveLayout();
            this.setupImageLoading();
            this.setupResizeListener();
            
            this.isInitialized = true;
        }
        
        setupContainer() {
            this.container.style.position = 'relative';
            this.container.style.width = '100%';
            this.container.style.padding = '20px 0';
            this.container.style.opacity = '1';
        }
        
        setupItems() {
            const items = this.container.querySelectorAll('.masonry_item');
            items.forEach(item => {
                item.style.breakInside = 'avoid';
                item.style.marginBottom = this.options.gap + 'px';
                item.style.display = 'block';
            });
        }
        
        startProgressiveLayout() {
            this.layoutMasonry(1);
            setTimeout(() => this.increaseColumns(), 200);
        }
        
        increaseColumns() {
            if (this.currentColumnCount < this.maxColumnCount) {
                this.currentColumnCount++;
                this.layoutMasonry(this.currentColumnCount);
                
                if (this.currentColumnCount < this.maxColumnCount) {
                    setTimeout(() => this.increaseColumns(), this.options.columnIncreaseDelay);
                }
            }
        }
        
        layoutMasonry(targetColumnCount = null) {
            const items = Array.from(this.container.children);
            const gap = this.options.gap;
            let columnCount = targetColumnCount || this.getMaxColumnCount();
            
            const columnHeights = new Array(columnCount).fill(0);
            
            items.forEach((item, index) => {
                const itemHeight = item.offsetHeight;
                const minHeight = Math.min(...columnHeights);
                const columnIndex = columnHeights.indexOf(minHeight);
                
                const itemWidth = (this.container.offsetWidth - (gap * (columnCount - 1))) / columnCount;
                const left = columnIndex * (itemWidth + gap);
                const top = minHeight;
                
                item.style.position = 'absolute';
                item.style.left = left + 'px';
                item.style.top = top + 'px';
                item.style.width = itemWidth + 'px';
                
                setTimeout(() => {
                    item.classList.add('loaded');
                }, index * this.options.animationDelay);
                
                columnHeights[columnIndex] += itemHeight + gap;
            });
            
            const maxHeight = Math.max(...columnHeights);
            this.container.style.height = maxHeight + 'px';
        }
        
        setupImageLoading() {
            const images = this.container.querySelectorAll('img');
            let loadedImages = 0;
            const totalImages = images.length;
            
            if (totalImages === 0) return;
            
            const checkAllImagesLoaded = () => {
                loadedImages++;
                if (loadedImages === totalImages) {
                    setTimeout(() => {
                        this.layoutMasonry(this.maxColumnCount);
                    }, 100);
                }
            };
            
            images.forEach(img => {
                if (img.complete) {
                    checkAllImagesLoaded();
                } else {
                    img.addEventListener('load', checkAllImagesLoaded);
                    img.addEventListener('error', checkAllImagesLoaded);
                }
            });
        }
        
        setupResizeListener() {
            this.resizeListener = () => {
                this.maxColumnCount = this.getMaxColumnCount();
                this.layoutMasonry();
            };
            window.addEventListener('resize', this.resizeListener);
        }
        
        refresh() {
            this.isInitialized = false;
            this.currentColumnCount = 1;
            this.maxColumnCount = this.getMaxColumnCount();
            this.init();
        }
        
        relayout() {
            this.layoutMasonry();
        }
        
        destroy() {
            if (this.resizeListener) {
                window.removeEventListener('resize', this.resizeListener);
                this.resizeListener = null;
            }
            this.isInitialized = false;
        }
    }

    // 전역 함수들 (기존 호환성 유지)
    window.EGBMasonry = EGBMasonryInstance;
    window.egbInitMasonryLayout = () => EGB.masonry.init();
    window.egbMasonryInit = (selector, options) => EGB.masonry.initElement(selector, options);
    window.egbMasonryRefresh = (selector) => EGB.masonry.refresh(selector);
    window.egbMasonryReinit = () => EGB.masonry.reinit();

    // 디버깅을 위한 전역 함수 추가
    window.debugMasonry = function() {
        console.log('=== Masonry Debug Info ===');
        console.log('EGB.masonry exists:', !!EGB.masonry);
        console.log('EGB.masonry._isInitialized:', EGB.masonry._isInitialized);
        console.log('document.getElementById("egb_masonry"):', document.getElementById('egb_masonry'));
        console.log('document.querySelectorAll("#egb_masonry"):', document.querySelectorAll('#egb_masonry'));
        console.log('document.readyState:', document.readyState);
        console.log('========================');
    };

    // 초기 로드 시 확인 (이미 DOM에 있는 경우)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            if (document.getElementById('egb_masonry')) {
                console.log('Masonry element found on DOMContentLoaded, initializing...');
                setTimeout(() => EGB.masonry.init(), 100);
            }
        });
    } else {
        // DOM이 이미 준비된 경우 즉시 확인
        if (document.getElementById('egb_masonry')) {
            console.log('Masonry element found immediately, initializing...');
            setTimeout(() => EGB.masonry.init(), 100);
        }
    }

})(typeof window !== 'undefined' ? window : this);