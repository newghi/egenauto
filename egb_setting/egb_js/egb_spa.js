/**
 * egb_spa.js
 * 
 * 단일 페이지 애플리케이션(SPA) 구현을 위한 모듈
 * 
 * 주요 기능:
 * - 브라우저 뒤로가기/앞으로가기 지원
 * - 링크 클릭 시 SPA 방식으로 페이지 전환
 * - 페이지 전환 시 메타태그, 타이틀 등 업데이트
 * 
 * 활성화 조건:
 * - egb_spa 클래스가 붙은 a링크이면서 /로 시작하는 링크가 있을 때
 */

(function(window) {
    'use strict';

    if (!window.EGB) {
        window.EGB = {};
    }

    // SPA(Single Page Application) 구현을 위한 모듈
    EGB.spa = {
        // SPA 활성화 여부
        isEnabled: false,
        
        // 현재 페이지 상태를 저장하는 객체
        currentState: {
            url: window.location.pathname,  // 현재 URL 경로
            title: document.title,          // 현재 페이지 제목
            scrollY: 0,                     // 스크롤 위치
            formData: null,                 // 폼 데이터
            data: null                      // 추가 데이터 (필요시 사용)
        },
        
        // 프리로드 캐시 저장소
        preloadCache: new Map(),
        
        // 진행 중인 프리로드 요청 추적
        preloadPromises: new Map(),
        
        // 캐시 만료 시간 (5분)
        cacheExpiry: 5 * 60 * 1000,
        
        // 캐시 최대 크기
        maxCacheSize: 10,
        
        // 스윕 간격 (1분)
        sweepInterval: 60 * 1000,

        // 재시도 설정
        retryConfig: {
            maxRetries: 3,
            retryDelay: 1000, // 1초
            backoffMultiplier: 2 // 지수 백오프
        },

        // SPA 활성화 여부 확인
        checkEnabled: function() {
            // egb_spa 클래스가 붙은 a링크이면서 /로 시작하는 링크가 있으면 활성화
            const spaLinks = document.querySelectorAll('a.egb_spa[href^="/"]');
            return spaLinks.length > 0;
        },

        // SPA 초기화 함수
        init: function() {
            // SPA 활성화 여부 확인
            this.isEnabled = this.checkEnabled();
            
            if (!this.isEnabled) {
                return;
            }
            
            // 브라우저 뒤로가기/앞으로가기 처리
            window.addEventListener('popstate', (e) => {
                // state가 있으면 해당 URL로, 없으면 현재 경로로 페이지 로드
                const state = e.state || { url: window.location.pathname };
                this.loadPage(state.url, true, state);
            });

            // 이벤트 위임 한 번만 설정
            this.setupEventDelegation();
            
            // 주기적 캐시 스윕 시작
            this.startPeriodicSweep();
        },

        // 새 페이지로 이동하는 함수
        navigate: function(url) {
            if (!this.isEnabled) {
                // SPA가 비활성화된 경우 일반 페이지 이동
                window.location.href = url;
                return;
            }
            
            if (url !== this.currentState.url) {  // 현재 URL과 다를 경우에만 처리
                // 현재 상태 저장
                this.saveCurrentState();
                
                // 브라우저 히스토리에 저장된 상태 그대로 저장
                const state = { ...this.currentState, timestamp: Date.now() };
                window.history.pushState(state, '', url);
                
                this.loadPage(url);  // 페이지 콘텐츠 로드
            }
        },

        // 페이지 콘텐츠를 비동기로 로드하는 함수
        loadPage: async function(url, isPopState = false, restoreState = null) {
            if (!this.isEnabled) {
                window.location.href = url;
                return;
            }
            
            try {
                // 캐시에서 먼저 확인 (egb_cache 클래스가 있는 페이지만)
                const cachedData = this.getCachedPage(url);
                if (cachedData) {
                    this.renderPage(cachedData, isPopState, restoreState);
                    return;
                }
                
                // 캐시에 없으면 서버에서 로드
                const response = await fetch(url, {
                    credentials: 'include'  // 쿠키·세션 헤더 포함
                });
                const html = await response.text();
                
                // HTML 파싱
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // 새 페이지에서 body 추출
                const newBody = doc.querySelector('#egb_contents');
                
                // 페이지 데이터 생성
                const pageData = {
                    url: url,
                    title: doc.title,
                    head: doc.head,
                    body: newBody,
                    timestamp: Date.now()
                };
                
                // 페이지 렌더링
                this.renderPage(pageData, isPopState, restoreState);
                
            } catch (error) {
                // 실패 시 일반 페이지 이동으로 폴백
                window.location.href = url;
            }
        },
        
        // 페이지 렌더링 함수
        renderPage: function(pageData, isPopState = false, restoreState = null) {
            if (!this.isEnabled) return;
            
            // 페이지가 변경될 때마다 스크립트 실행 기록 초기화
            // (같은 페이지로 돌아와도 스크립트가 다시 실행되도록)
            this._executedScripts = new Set();
            
            // head 부분만 업데이트 (메타태그, 제목 등)
            this.updateHeadOnly(pageData.head);
            

            
            // egb_contents 부분만 업데이트 (컨텐츠만 교체)
            if (pageData.body) {
                const currentBody = document.querySelector('#egb_contents');
                if (currentBody) {
                    currentBody.innerHTML = pageData.body.innerHTML;
                }
            }
            
            // 현재 상태 정보 업데이트 (popstate 복원 시 기존 상태 유지)
            if (isPopState && restoreState) {
                // 뒤로가기 복원 시 저장된 상태 그대로 사용
                this.currentState = { ...restoreState };
            } else {
                // 새 페이지 시 기본값으로 초기화
                this.currentState = { 
                    url: pageData.url, 
                    title: pageData.title, 
                    scrollY: 0, 
                    formData: null, 
                    data: null 
                };
            }
            
            // popstate 복원인 경우 상태 복원
            if (isPopState && restoreState) {
                this.restorePageState(restoreState);
            } else {
                // 새 페이지인 경우 최상단으로 스크롤
                window.scrollTo(0, 0);
            }
            
            // 페이지 렌더링 완료 후 스크립트 실행 및 위젯 초기화
            this.execScripts(pageData);
            this.initPageWidgets();
        },
        
        // 페이지가 캐시 대상인지 확인하는 함수
        shouldCachePage: function(doc) {
            if (!this.isEnabled) return false;
            
            // egb_spa와 egb_cache 클래스가 모두 있는지 확인
            const spaLinks = doc.querySelectorAll('a.egb_spa.egb_cache');
            return spaLinks.length > 0;
        },
        
        // 캐시에서 페이지 가져오기
        getCachedPage: function(url) {
            if (!this.isEnabled) return null;
            
            const cached = this.preloadCache.get(url);
            if (!cached) {
                return null;
            }
            
            // 캐시 만료 확인
            if (Date.now() - cached.timestamp > this.cacheExpiry) {
                this.preloadCache.delete(url);
                return null;
            }
            
            return cached;
        },
        
        // 주기적 캐시 스윕 시작
        startPeriodicSweep: function() {
            if (!this.isEnabled) return;
            
            setInterval(() => {
                this.sweepExpiredCache();
            }, this.sweepInterval);
        },
        
        // 만료된 캐시 항목들을 정리하는 함수
        sweepExpiredCache: function() {
            if (!this.isEnabled) return;
            
            const now = Date.now();
            const expiredKeys = [];
            
            for (const [key, value] of this.preloadCache.entries()) {
                if (now - value.timestamp > this.cacheExpiry) {
                    expiredKeys.push(key);
                }
            }
            
            // 만료된 항목들 삭제
            expiredKeys.forEach(key => {
                this.preloadCache.delete(key);
            });
        },
        
        // 페이지를 캐시에 저장
        cachePage: function(url, pageData) {
            if (!this.isEnabled) return;
            
            // 만료된 항목들 먼저 정리
            this.sweepExpiredCache();
            
            this.preloadCache.set(url, pageData);
            
            // 캐시 크기 제한 (LRU 정책)
            if (this.preloadCache.size > this.maxCacheSize) {
                this.removeOldestItem();
            }
        },
        
        // 가장 오래된 캐시 항목 삭제
        removeOldestItem: function() {
            if (!this.isEnabled) return;
            
            let oldestKey = null;
            let oldestTime = Date.now();
            
            for (const [key, value] of this.preloadCache.entries()) {
                if (value.timestamp < oldestTime) {
                    oldestTime = value.timestamp;
                    oldestKey = key;
                }
            }
            
            if (oldestKey) {
                this.preloadCache.delete(oldestKey);
            }
        },
        
        // 페이지 스크립트 실행 (body의 스크립트만)
        execScripts: function(pageData) {
            if (!pageData || !this.isEnabled) return;
            
            // 기존에 동적으로 추가된 스크립트들 정리
            this.cleanupDynamicScripts();
            
            // body의 스크립트만 실행 (head는 이미 로드되어 있음)
            if (pageData.body) {
                const bodyScripts = pageData.body.querySelectorAll('script');
                bodyScripts.forEach(script => this.createAndExecScript(script, 'body'));
            }
        },
        
        // 동적으로 추가된 스크립트들 정리
        cleanupDynamicScripts: function() {
            if (!this.isEnabled) return;
            
            // 동적으로 추가된 스크립트들을 추적하기 위한 속성
            const dynamicScripts = document.querySelectorAll('script[data-egb-spa-dynamic="true"]');
            
            // 동적으로 추가된 스크립트들 제거
            dynamicScripts.forEach(script => {
                if (script.parentNode) {
                    script.parentNode.removeChild(script);
                }
            });
            
            // 실행된 스크립트 기록 초기화
            this._executedScripts = new Set();
            
            console.log('[EGB SPA] 동적 스크립트 정리 완료');
        },
        
        // 스크립트 생성 및 실행
        createAndExecScript: function(scriptElement, location) {
            if (!this.isEnabled) return;
            
            // 스크립트 식별자 생성
            const scriptId = this.getScriptIdentifier(scriptElement);
            
            // 이미 실행된 스크립트인지 확인
            if (this._executedScripts && this._executedScripts.has(scriptId)) {
                console.log('[EGB SPA] 이미 실행된 스크립트 스킵:', scriptId);
                return;
            }
            
            // 실행된 스크립트 추적 초기화 (없으면 생성)
            if (!this._executedScripts) {
                this._executedScripts = new Set();
            }
            
            const newScript = document.createElement('script');
            
            // 동적 스크립트임을 표시하는 속성 추가
            newScript.setAttribute('data-egb-spa-dynamic', 'true');
            
            // 속성 복사
            for (const attr of scriptElement.attributes) {
                newScript.setAttribute(attr.name, attr.value);
            }
            
            // CSP nonce 복사 (보안 정책)
            if (scriptElement.nonce) {
                newScript.nonce = scriptElement.nonce;
            }
            
            // 인라인 스크립트 내용 복사
            if (scriptElement.textContent) {
                newScript.textContent = scriptElement.textContent;
            }
            
            // 외부 스크립트는 src 속성만 있으면 됨
            if (scriptElement.src) {
                newScript.src = scriptElement.src;
            }
            
            // 문서에 추가하여 실행
            document.head.appendChild(newScript);
            
            // 실행된 스크립트로 기록
            this._executedScripts.add(scriptId);
            
            console.log('[EGB SPA] 새 스크립트 추가됨:', scriptId);
        },
        
        // 스크립트 식별자 생성
        getScriptIdentifier: function(scriptElement) {
            // 외부 스크립트는 src로 식별
            if (scriptElement.src) {
                return `src:${scriptElement.src}`;
            }
            
            // 인라인 스크립트는 내용의 해시로 식별
            if (scriptElement.textContent) {
                const content = scriptElement.textContent.trim();
                return `inline:${this.hashCode(content)}`;
            }
            
            // 기본값
            return `unknown:${Date.now()}`;
        },
        
        // 간단한 해시 함수
        hashCode: function(str) {
            let hash = 0;
            if (str.length === 0) return hash;
            for (let i = 0; i < str.length; i++) {
                const char = str.charCodeAt(i);
                hash = ((hash << 5) - hash) + char;
                hash = hash & hash; // 32bit 정수로 변환
            }
            return Math.abs(hash);
        },
        
        // 특정 페이지 프리로드 (조건부 캐싱)
        preload: async function(url, cacheFlag, retryCount = 0) {
            if (!this.isEnabled) return;
            
            // 이미 진행 중인 요청이 있으면 스킵
            if (this.preloadPromises.has(url)) return;
            
            try {
                // 프리로드 요청 시작
                const preloadPromise = fetch(url, {
                    credentials: 'include'  // 쿠키·세션 헤더 포함
                })
                    .then(response => response.text())
                    .then(html => {
                        // HTML은 파싱만 해서 렌더용 데이터 준비
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const pageData = {
                            url: url,
                            title: doc.title,
                            head: doc.head,
                            body: doc.querySelector('#egb_contents'),
                            timestamp: Date.now()
                        };
                        
                        // **오직** cacheFlag가 true일 때만 캐시 저장
                        if (cacheFlag) {
                            this.cachePage(url, pageData);
                        }
                    })
                    .catch(async error => {
                        // 재시도 로직
                        if (retryCount < this.retryConfig.maxRetries) {
                            const delay = this.retryConfig.retryDelay * Math.pow(this.retryConfig.backoffMultiplier, retryCount);
                            await new Promise(resolve => setTimeout(resolve, delay));
                            await this.preload(url, cacheFlag, retryCount + 1);
                        }
                    })
                    .finally(() => {
                        // 요청 완료 후 추적에서 제거
                        this.preloadPromises.delete(url);
                    });
                
                // 진행 중인 요청 추적에 추가
                this.preloadPromises.set(url, preloadPromise);
                
            } catch (error) {
                // 최종 실패 시에도 조용히 처리
                this.preloadPromises.delete(url);
            }
        },
        
        // SPA 캐시 초기화 (사용자 상호작용 후 사용)
        reset: function() {
            if (!this.isEnabled) return;
            
            this.preloadCache.clear();
            this.preloadPromises.clear();
            this._executedScripts.clear();
        },
        
        // 현재 페이지 상태 저장
        saveCurrentState: function() {
            if (!this.isEnabled) return;
            
            this.currentState.scrollY = window.scrollY;
            this.currentState.formData = this.collectFormData();
        },
        
        // 폼 데이터 수집
        collectFormData: function() {
            if (!this.isEnabled) return null;
            
            const forms = document.querySelectorAll('form');
            const formData = {};
            
            forms.forEach((form, index) => {
                const formElements = form.elements;
                const data = {};
                
                for (let i = 0; i < formElements.length; i++) {
                    const element = formElements[i];
                    if (element.name && element.type !== 'submit' && element.type !== 'button') {
                        if (element.type === 'checkbox' || element.type === 'radio') {
                            data[element.name] = element.checked;
                        } else {
                            data[element.name] = element.value;
                        }
                    }
                }
                
                if (Object.keys(data).length > 0) {
                    formData[`form_${index}`] = data;
                }
            });
            
            return Object.keys(formData).length > 0 ? formData : null;
        },
        
        // 페이지 상태 복원
        restorePageState: function(state) {
            if (!this.isEnabled) return;
            
            // 스크롤 위치 복원
            if (state.scrollY !== undefined) {
                setTimeout(() => {
                    window.scrollTo(0, state.scrollY);
                }, 100); // DOM 렌더링 완료 후 스크롤
            }
            
            // 폼 데이터 복원
            if (state.formData) {
                setTimeout(() => {
                    this.restoreFormData(state.formData);
                }, 100);
            }
        },
        
        // 폼 데이터 복원
        restoreFormData: function(formData) {
            if (!this.isEnabled) return;
            
            const forms = document.querySelectorAll('form');
            
            Object.keys(formData).forEach((formKey, index) => {
                if (forms[index]) {
                    const form = forms[index];
                    const data = formData[formKey];
                    
                    Object.keys(data).forEach(fieldName => {
                        const element = form.elements[fieldName];
                        if (element) {
                            if (element.type === 'checkbox' || element.type === 'radio') {
                                element.checked = data[fieldName];
                            } else {
                                element.value = data[fieldName];
                            }
                        }
                    });
                }
            });
        },
        
        // 개별 디바운스 프리로드 함수
        debouncedPreload: function(url, cacheFlag) {
            if (!this.isEnabled) return;
            
            // 이미 진행 중인 요청이 있으면 스킵
            if (this.preloadPromises.has(url)) return;
            
            // URL별 디바운스 타이머 관리
            if (!this.preloadTimers) {
                this.preloadTimers = new Map();
            }
            
            // 기존 타이머가 있으면 제거
            if (this.preloadTimers.has(url)) {
                clearTimeout(this.preloadTimers.get(url));
            }
            
            // 새로운 타이머 설정 (300ms)
            const timer = setTimeout(() => {
                this.preload(url, cacheFlag);
                this.preloadTimers.delete(url);
            }, 300);
            
            this.preloadTimers.set(url, timer);
        },
        
        // 페이지 위젯 및 이벤트 초기화
        initPageWidgets: function() {
            if (!this.isEnabled) return;
            
            // 동적으로 로드된 페이지의 egb_spa 링크들을 위한 이벤트 재설정
            this.setupDynamicEventHandlers();
            
            // 폼 이벤트 재바인딩 (SPA 페이지 로드 후)
            if (window.EGB && window.EGB.form && typeof window.EGB.form.rebindFormEvents === 'function') {
                window.EGB.form.rebindFormEvents();
            }
            
            // 클래스 기반 함수 실행 로직 실행 (SPA 페이지 로드 후)
            this.executeClassBasedFunctions();
            
            // 전역 위젯 초기화 함수 호출 (존재하는 경우)
            if (typeof window.initWidgets === 'function') {
                window.initWidgets();
            }
            
            // EGB 전역 함수 호출 (존재하는 경우)
            if (window.EGB && typeof window.EGB.initPage === 'function') {
                window.EGB.initPage();
            }
            
            // 커스텀 이벤트 발생 (다른 모듈에서 리스닝 가능)
            window.dispatchEvent(new CustomEvent('egb:pageLoaded', {
                detail: { url: this.currentState.url }
            }));
        },
        
        // 이벤트 위임 설정 (document 레벨로 안정적 처리)
        setupEventDelegation: function() {
            if (!this.isEnabled) return;
            
            // 이미 바인딩되었으면 스킵
            if (this._delegated) return;
            
            // egb_spa 클래스를 가진 링크 클릭 처리 (동적 요소 지원)
            document.addEventListener('click', (e) => {
                const link = e.target.closest('a');
                if (link && 
                    link.getAttribute('href') && 
                    link.getAttribute('href').startsWith('/') && 
                    link.classList.contains('egb_spa')) {
                    e.preventDefault();  // 기본 링크 동작 방지
                    this.navigate(link.getAttribute('href'));  // SPA 방식으로 페이지 전환
                }
            });
            
            // egb_spa 클래스를 가진 링크 마우스 오버 시 자동 프리로드
            document.addEventListener('mouseover', (e) => {
                const link = e.target.closest('a.egb_spa[href^="/"]');
                if (!link) return;
                const url = link.getAttribute('href');
                const cacheFlag = link.classList.contains('egb_cache');
                
                this.debouncedPreload(url, cacheFlag);
            });
            
            // document 레벨로 이벤트 위임 설정 (더 안정적)
            document.addEventListener('submit', (e) => {
                // #egb_contents 내부의 폼만 처리
                if (e.target.closest('#egb_contents')) {
                    const form = e.target.closest('form');
                    if (form) {
                        // 폼 제출 전 상태 저장
                        this.saveCurrentState();
                    }
                }
            });
            
            document.addEventListener('click', (e) => {
                // #egb_contents 내부의 버튼만 처리
                if (e.target.closest('#egb_contents')) {
                    const button = e.target.closest('button');
                    if (button && button.type === 'submit') {
                        // 제출 버튼 클릭 시 상태 저장
                        this.saveCurrentState();
                    }
                }
            });
            
            // 바인딩 완료 플래그 설정
            this._delegated = true;
        },
        
        // 동적으로 로드된 페이지의 이벤트 핸들러 설정 (이벤트 위임 방식 사용으로 단순화)
        setupDynamicEventHandlers: function() {
            if (!this.isEnabled) return;
            
            // 이벤트 위임 방식만 사용하므로 추가 설정 불필요
        },
        
        // 클래스 기반 함수 실행 로직 (SPA 페이지 로드 후 실행)
        executeClassBasedFunctions: function() {
            if (!this.isEnabled) return;
            
            // 클래스로 함수 실행
            document.querySelectorAll('[class]').forEach(el => {
                const calls = [...el.classList].filter(c => c.startsWith('-'));
                if (!calls.length) return;

                calls.forEach(cls => {
                    const m = cls.match(/^-([^-]+)-(.+)$/);
                    if (!m) return;
                    const [, moduleName, fnName] = m;
                    const fn = EGB[moduleName]?.[fnName];
                    if (typeof fn !== 'function') return;

                    const args = [];
                    if (calls.length === 1) {
                        // single: data-arg-1, data-arg-2…
                        let i = 1, v;
                        while ((v = el.getAttribute(`data-arg-${i}`)) !== null) {
                            args.push(v);
                            i++;
                        }
                    } else {
                        // multi: data-[fnName]-arg-1, data-[fnName]-arg-2…
                        let j = 1, v, prefix = fnName;
                        while ((v = el.getAttribute(`data-${prefix}-arg-${j}`)) !== null) {
                            args.push(v);
                            j++;
                        }
                    }

                    fn(...args);
                });
            });
        },
        

        

        
        // head 부분만 선택적으로 업데이트하는 함수
        updateHeadOnly: function(newHead) {
            if (!this.isEnabled) return;
            
            const currentHead = document.head;
            
            // 페이지 제목 업데이트
            const newTitle = newHead.querySelector('title');
            if (newTitle) {
                document.title = newTitle.textContent;
            }
            
            // meta 태그만 업데이트 (SEO 관련) - charset은 제외
            const newMetaTags = newHead.querySelectorAll('meta');
            newMetaTags.forEach(newMeta => {
                // charset 메타태그는 건너뛰기
                if (newMeta.hasAttribute('charset')) {
                    return;
                }
                
                const name = newMeta.getAttribute('name') || newMeta.getAttribute('property');
                const currentMeta = currentHead.querySelector(`meta[name="${name}"]`) || 
                                   currentHead.querySelector(`meta[property="${name}"]`);
                
                if (currentMeta) {
                    // 기존 메타태그 내용만 업데이트
                    currentMeta.setAttribute('content', newMeta.getAttribute('content'));
                } else {
                    // 새로운 메타태그만 추가
                    currentHead.appendChild(newMeta.cloneNode(true));
                }
            });
            
            // link 태그 처리 (CSS, 파비콘 등)
            const newLinks = newHead.querySelectorAll('link[rel="stylesheet"][id="egb_ssr_style"]');
            newLinks.forEach(newLink => {
                const href = newLink.getAttribute('href');
                const currentLink = currentHead.querySelector(`link[rel="stylesheet"][id="egb_ssr_style"][href="${href}"]`);
                if (!currentLink) {
                    // 새로운 CSS 파일만 추가
                    currentHead.appendChild(newLink.cloneNode(true));
                }
            });
            
            // base 태그 처리
            const newBase = newHead.querySelector('base');
            const currentBase = currentHead.querySelector('base');
            if (newBase && !currentBase) {
                currentHead.appendChild(newBase.cloneNode(true));
            } else if (newBase && currentBase) {
                // 기존 base 태그 업데이트
                currentBase.href = newBase.href;
                if (newBase.target) {
                    currentBase.target = newBase.target;
                }
            }
            // egb_ssr_style ID를 가진 스타일만 교체
            const newStyle = newHead.querySelector('#egb_ssr_style');
            const currentStyle = currentHead.querySelector('#egb_ssr_style');
            
            if (newStyle && currentStyle) {
                // 기존 스타일 내용만 교체
                currentStyle.textContent = newStyle.textContent;
            } else if (newStyle && !currentStyle) {
                // 새로운 스타일 태그 추가
                currentHead.appendChild(newStyle.cloneNode(true));
            }

            // egb-class-data 스크립트 교체
            const newClassData = newHead.querySelector('#egb-class-data');
            const currentClassData = currentHead.querySelector('#egb-class-data');

            if (newClassData && currentClassData) {
                // 기존 스크립트 내용만 교체
                currentClassData.textContent = newClassData.textContent;
            } else if (newClassData && !currentClassData) {
                // 새로운 스크립트 태그 추가
                currentHead.appendChild(newClassData.cloneNode(true));
            }
        },

    };

    // DOM이 로드되면 SPA 초기화
    document.addEventListener('DOMContentLoaded', () => {
        EGB.spa.init();
    });

})(window);
