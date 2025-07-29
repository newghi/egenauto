/**
 * egb_function.js
 * 
 * 공통 유틸리티 함수 모듈
 * 
 * 주요 기능:
 * - 전역 EGB 객체에 function 네임스페이스 추가
 * - 공통으로 사용되는 유틸리티 함수들 제공
 * 
 * 사용 예시:
 * EGB.function.test() // 테스트 함수 실행
 */

;(function(global) {
    const EGB = global.EGB = global.EGB || {};

    // 유틸리티 함수들

    // 스크립트를 동적으로 로드하는 함수
    function loadScript(egbUrl, Id, egbCallback) {
        // 스크립트가 이미 존재하는지 확인
        const existingScript = document.getElementById(Id);
        if (existingScript) {
            // 이미 존재하면 콜백 함수만 실행
            if (egbCallback) egbCallback();
            return;
        }

        // 스크립트가 없으면 새로 추가
        const egbScript = document.createElement("script");
        egbScript.id = Id;
        egbScript.src = egbUrl;
        egbScript.type = "text/javascript";
        egbScript.onload = () => {
            if (egbCallback) egbCallback();
            egbScript.onload = null; // 메모리 누수 방지
        };
        document.head.appendChild(egbScript);
    }

    function changeClass(target, newClass) {
        let els = [];
        if (typeof target === 'string') {
            try {
                els = document.querySelectorAll(target);
                if (!els.length) {
                    console.error(`[EGB Function] 선택자를 찾을 수 없습니다: ${target}`);
                    return;
                }
            } catch (e) {
                console.error(`[EGB Function] 유효하지 않은 선택자입니다: ${target}`);
                return;
            }
        } else if (target instanceof Element) {
            els = [target];
        } else if (target instanceof NodeList || target instanceof HTMLCollection) {
            els = Array.from(target);
        } else {
            console.error('[EGB Function] 유효하지 않은 target 타입입니다');
            return;
        }
        
        if (!els.length) {
            console.error('[EGB Function] 유효한 엘리먼트가 없습니다');
            return;
        }

        const patterns = [
            xyRegex, tulrRegex,
            positionRegex, position_t_Regex, position_u_Regex, position_l_Regex, position_r_Regex,
            egbRegexPattern, srefRegex, clefRegex, hoefRegex,
            widthRegex, maxWidthRegex, minWidthRegex, gapRegex,
            heightRegex, maxHeightRegex, minHeightRegex,
            fontRegex,
            padding_a_Regex, padding_x_Regex, padding_y_Regex, padding_l_Regex, padding_r_Regex, padding_t_Regex, padding_u_Regex,
            margin_a_Regex, margin_x_Regex, margin_y_Regex, margin_l_Regex, margin_r_Regex, margin_t_Regex, margin_u_Regex,
            displayRegex, colorRegex, bgColorRegex
        ];

        let matchedPattern = null;
        for (let pat of patterns) {
            pat.lastIndex = 0;
            if (pat.test(newClass)) {
                matchedPattern = pat;
                break;
            }
        }
        if (!matchedPattern) {
            console.error(`[EGB Function] 일치하는 패턴이 없습니다: ${newClass}`);
            return;
        }

        els.forEach(el => {
            const oldClasses = [...el.classList].filter(cls => {
                matchedPattern.lastIndex = 0;
                return matchedPattern.test(cls);
            });

            oldClasses.forEach(oldCls => {
                el.classList.remove(oldCls);
            });

            el.classList.add(newClass);
        });
    }

    // 클래스 추가 함수
    function addClass(target, newClass) {
        if (!target || !newClass) {
            console.error('[EGB Function] target과 newClass는 필수값입니다');
            return;
        }

        let els;
        if (target instanceof Element) {
            els = [target];
        } else if (typeof target === 'string') {
            els = Array.from(document.querySelectorAll(target));
        } else if (target instanceof NodeList || target instanceof HTMLCollection) {
            els = Array.from(target);
        } else {
            console.error('[EGB Function] 유효하지 않은 target 타입입니다');
            return;
        }
        
        if (!els.length) {
            console.error('[EGB Function] 유효한 엘리먼트가 없습니다');
            return;
        }

        els.forEach(el => {
            if (!el.classList.contains(newClass)) {
                el.classList.add(newClass);
            }
        });
    }

    // 클래스 제거 함수
    function delClass(target, className) {
        if (!target || !className) {
            console.error('[EGB Function] target과 className은 필수값입니다');
            return;
        }

        let els;
        if (target instanceof Element) {
            els = [target];
        } else if (typeof target === 'string') {
            els = Array.from(document.querySelectorAll(target));
        } else if (target instanceof NodeList || target instanceof HTMLCollection) {
            els = Array.from(target);
        } else {
            console.error('[EGB Function] 유효하지 않은 target 타입입니다');
            return;
        }

        if (!els.length) {
            console.error('[EGB Function] 유효한 엘리먼트가 없습니다');
            return;
        }

        els.forEach(el => {
            if (el.classList.contains(className)) {
                el.classList.remove(className);
            }
        });
    }

    // 스크롤 이벤트를 특정 요소에 부착하는 함수
    function headerHide1(id) {
        let egbLastScrollTop = 0;
        const header = document.getElementById(id);
        
        // 헤더가 존재하는지 확인
        if (!header) {
            console.error('[EGB Function] 헤더 요소를 찾을 수 없습니다:', id);
            return;
        }
        
        header.style.transition = 'transform 1s ease';

        window.addEventListener('scroll', function () {
            // 최신 브라우저 호환성을 위한 스크롤 위치 가져오기
            let scrollTop = window.scrollY || window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > egbLastScrollTop) {
                // 아래로 스크롤 시 헤더를 숨깁니다.
                header.style.transform = 'translateY(-100%)';
            } else {
                // 위로 스크롤 시 헤더를 표시합니다.
                header.style.transform = 'translateY(0)';
            }

            egbLastScrollTop = scrollTop;
        });
    }

    //타겟 아이디요소, 목표숫자, 얼마뒤 목표숫자 도달수치, 발견 후 언제 발동될지 딜레이시간, 쉼표 사용 여부
    function countUp(elementId, targetNumber = 1, duration = 1000, delay = 400, useComma = false) {
        const element = document.getElementById(elementId);
        if (!element) {
            console.warn(`ID가 '${elementId}'인 요소를 찾을 수 없습니다.`);
            return;
        }

        targetNumber = Number(targetNumber); // targetNumber를 항상 숫자로 보장

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        const frameRate = 1000 / 60; // 60fps
                        const totalFrames = Math.round(duration / frameRate);
                        const increment = targetNumber / totalFrames;

                        let currentValue = 0;
                        let frame = 0;

                        const getDecimalPlaces = (num) => {
                            if (!Number.isFinite(num)) return 0;
                            const str = Math.abs(num).toString();
                            return str.includes('.') ? str.split('.')[1].length : 0;
                        };

                        const decimalPlaces = getDecimalPlaces(targetNumber);

                        const counter = setInterval(() => {
                            frame++;
                            currentValue += increment;

                            // 소수 자릿수에 맞게 표시
                            let formattedValue = currentValue.toFixed(decimalPlaces);
                            if (useComma) {
                                formattedValue = Number(formattedValue).toLocaleString();
                            }

                            element.textContent = formattedValue;

                            // 마지막 프레임일 경우 정확한 목표값으로 설정
                            if (frame >= totalFrames) {
                                clearInterval(counter);
                                let finalValue = targetNumber.toFixed(decimalPlaces);
                                if (useComma) {
                                    finalValue = Number(finalValue).toLocaleString();
                                }
                                element.textContent = finalValue;
                            }
                        }, frameRate);
                    }, delay);
                    observer.unobserve(element);
                }
            });
        }, { threshold: 1 });

        observer.observe(element);
    }
    // 전체화면에 대한 function
    function fullScreen() {
        if (!document.fullscreenElement) {
            // 전체 화면이 아닐 때, 전체 화면으로 전환하고 fullScreenTrue() 실행
            document.documentElement.requestFullscreen().then(() => {
                if (typeof fullScreenTrue === "function") {
                    fullScreenTrue(); // 전체 화면으로 전환된 후 실행 해당 함수는 프로젝트마다 별도 생성
                }
            }).catch((error) => {
                console.error("Failed to enter fullscreen:", error);
            });
        } else {
            // 이미 전체 화면일 때, 전체 화면 해제하고 fullScreenFalse() 실행
            document.exitFullscreen().then(() => {
                if (typeof fullScreenFalse === "function") {
                    fullScreenFalse(); // 전체 화면 해제된 후 실행 해당 함수는 프로젝트마다 별도 생성
                }
            }).catch((error) => {
                console.error("Failed to exit fullscreen:", error);
            });
        }
    }

    function classHover(id, className) {
        const element = document.getElementById(id); // ID로 요소 선택

        if (!element) {
            console.warn(`ID가 '${id}'인 요소를 찾을 수 없습니다.`);
            return;
        }

        element.addEventListener('mouseover', function() {
            element.classList.add(className); // 호버 시 클래스 추가
        });

        element.addEventListener('mouseout', function() {
            element.classList.remove(className); // 호버 해제 시 클래스 제거
        });
    }

    // 타겟 아이디 요소의 클래스를 토글 하는 함수
    function toggle(targetId, ...classNames) {
        // 요소 선택
        const targetElement = document.getElementById(targetId);

        // 요소가 존재하는지 확인
        if (targetElement) {
            // 각 클래스에 대해 토글 수행
            classNames.forEach(className => {
                targetElement.classList.toggle(className);
            });
        } else {
            console.log(`아이디가 '${targetId}'인 요소를 찾을 수 없습니다.`);
        }
    }

    function click(targetId, delay = 0) {
        setTimeout(() => {
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.click();
                console.log(`${targetId}가 클릭되었습니다.`);
            } else {
                console.error(`ID가 '${targetId}'인 요소를 찾을 수 없습니다.`);
            }
        }, delay);
    }

    // 클래스 추가 함수 (여러 개 지원)
    function classAdd(targetId, ...classNames) {
        const element = document.getElementById(targetId);
        if (element) {
            classNames.forEach(className => {
                if (!element.classList.contains(className)) {
                    element.classList.add(className);
                }
            });
        }
    }

    // 클래스 삭제 함수 (여러 개 지원)
    function classDel(targetId, ...classNames) {
        const element = document.getElementById(targetId);
        if (element) {
            classNames.forEach(className => {
                if (element.classList.contains(className)) {
                    element.classList.remove(className);
                }
            });
        }
    }

    function urlToggle(targetId, includeQueryParams, compareUrl, ...classes) {
        console.log(targetId, includeQueryParams, compareUrl, classes);
        // 현재 URL 경로와 도메인 가져오기
        let currentPath = window.location.pathname;
        if (includeQueryParams) {
            currentPath += window.location.search; // 쿼리 문자열 포함
        }
        const currentDomain = window.location.origin;

        // ID로 요소 가져오기
        const element = document.getElementById(targetId);

        // 요소가 존재하는 경우에만 클래스 추가 또는 제거
        if (element) {
            if (currentPath.includes(compareUrl) || currentDomain === compareUrl) {
                // compareUrl이 경로나 도메인과 정확히 일치하면 클래스 추가
                classes.forEach(className => {
                    element.classList.add(className);
                });
            } else {
                // 포함되지 않으면 클래스 제거
                classes.forEach(className => {
                    element.classList.remove(className);
                });
            }
        } else {
            console.log(`ID가 '${targetId}'인 요소를 찾을 수 없습니다.`);
        }
    }

    function urlClassAdd(targetId, includeQueryParams, compareUrl, ...classes) {
        // 현재 URL 경로와 도메인 가져오기
        let currentPath = window.location.pathname;
        if (includeQueryParams) {
            currentPath += window.location.search; // 쿼리 문자열 포함
        }
        const currentDomain = window.location.origin;

        // ID로 요소 가져오기
        const element = document.getElementById(targetId);

        // 요소가 존재하는 경우에만 클래스 추가
        if (element) {
            if (currentPath.includes(compareUrl) || currentDomain === compareUrl) {
                classes.forEach(className => {
                    element.classList.add(className);
                });
            }
        } else {
            console.log(`ID가 '${targetId}'인 요소를 찾을 수 없습니다.`);
        }
    }

    function urlClassDel(targetId, includeQueryParams, compareUrl, ...classes) {
        // 현재 URL 경로와 도메인 가져오기
        let currentPath = window.location.pathname;
        if (includeQueryParams) {
            currentPath += window.location.search; // 쿼리 문자열 포함
        }
        const currentDomain = window.location.origin;

        // ID로 요소 가져오기
        const element = document.getElementById(targetId);

        // 요소가 존재하는 경우에만 클래스 제거
        if (element) {
            if (currentPath.includes(compareUrl) || currentDomain === compareUrl) {
                classes.forEach(className => {
                    element.classList.remove(className);
                });
            }
        } else {
            console.log(`ID가 '${targetId}'인 요소를 찾을 수 없습니다.`);
        }
    }

    function scrollToggle(targetId, offset, ...classNames) {
        // 1. 타겟 요소 가져오기
        const targetElement = document.getElementById(targetId);
        if (!targetElement) {
            console.log(`Element with id '${targetId}' not found`);
            return;
        }

        // 2. 스크롤 이벤트 핸들러
        function handleScroll() {
            const elementTop = targetElement.getBoundingClientRect().top;
            const viewportHeight = window.innerHeight;

            // 퍼센트값으로 offset을 계산 (예: 50%라면 뷰포트의 50% 위치)
            const offsetInPx = viewportHeight * (offset / 100);

            // 뷰포트에 offset 만큼 들어오면 class 추가
            if (elementTop < viewportHeight - offsetInPx) {
                targetElement.classList.add(...classNames);
            } else {
                targetElement.classList.remove(...classNames);
            }
        }

        // 3. 스크롤 이벤트 리스너 등록
        window.addEventListener('scroll', handleScroll);
        
        // 4. 초기화 - 페이지 로드 후 바로 실행하여 스크롤 상태 반영
        window.addEventListener('load', handleScroll);
    }

    function scrollClassAdd(targetId, offset, ...classNames) {
        // 1. 타겟 요소 가져오기
        const targetElement = document.getElementById(targetId);
        if (!targetElement) {
            console.log(`Element with id '${targetId}' not found`);
            return;
        }

        // 2. 스크롤 이벤트 핸들러
        function handleScrollClassAdd() {
            const elementTop = targetElement.getBoundingClientRect().top;
            const viewportHeight = window.innerHeight;

            // 퍼센트값으로 offset을 계산 (예: 50%라면 뷰포트의 50% 위치)
            const offsetInPx = viewportHeight * (offset / 100);

            // 뷰포트에 offset 만큼 들어오면 class 추가
            if (elementTop < viewportHeight - offsetInPx) {
                targetElement.classList.add(...classNames);
            }
        }

        // 3. 스크롤 이벤트 리스너 등록
        window.addEventListener('scroll', handleScrollClassAdd);
        
        // 4. 초기화 - 페이지 로드 후 바로 실행하여 스크롤 상태 반영
        window.addEventListener('load', handleScrollClassAdd);
    }

    function scrollClassDel(targetId, offset, ...classNames) {
        // 1. 타겟 요소 가져오기
        const targetElement = document.getElementById(targetId);
        if (!targetElement) {
            console.log(`Element with id '${targetId}' not found`);
            return;
        }

        // 2. 스크롤 이벤트 핸들러
        function handleScrollClassDel() {
            const elementTop = targetElement.getBoundingClientRect().top;
            const viewportHeight = window.innerHeight;

            // 퍼센트값으로 offset을 계산 (예: 50%라면 뷰포트의 50% 위치)
            const offsetInPx = viewportHeight * (offset / 100);

            // 뷰포트에 offset 만큼 들어오면 class 추가
            if (elementTop < viewportHeight - offsetInPx) {
                targetElement.classList.remove(...classNames);
            }
        }

        // 3. 스크롤 이벤트 리스너 등록
        window.addEventListener('scroll', handleScrollClassDel);
        
        // 4. 초기화 - 페이지 로드 후 바로 실행하여 스크롤 상태 반영
        window.addEventListener('load', handleScrollClassDel);
    }

    // 맨 위로 가기 버튼 기능
    function scrollToTop(buttonId = 'egb_scroll_top', showOffset = 300) {
        const scrollToTopBtn = document.getElementById(buttonId);
        
        if (!scrollToTopBtn) {
            console.error(`[EGB Function] ID가 '${buttonId}'인 맨 위로 가기 버튼을 찾을 수 없습니다.`);
            return;
        }
        
        // 스크롤 이벤트 리스너
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > showOffset) {
                scrollToTopBtn.classList.remove('display_none');
            } else {
                scrollToTopBtn.classList.add('display_none');
            }
        });
        
        // 버튼 클릭 이벤트
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        console.log(`[EGB Function] 맨 위로 가기 버튼 (${buttonId}) 기능이 활성화되었습니다.`);
    }

    /**
     * 해쉬 무브: 특정 id나 요소로 부드럽게 스크롤 이동 (가까워질수록 감속)
     * @param {string|Element} target - 이동할 요소의 id(문자열) 또는 DOM Element
     * @param {object} options - { offset, duration, easing }
     */
    function hashMove(target, options = {}) {
        // URL에 해시가 없으면 리턴
        if (!window.location.hash) return;

        let elem = null;
        if (typeof target === 'string') {
            elem = document.getElementById(target.replace(/^#/, ''));
        } else if (target instanceof Element) {
            elem = target;
        }
        if (!elem) return;

        const offset = options.offset || 0;
        const duration = options.duration || 1200;
        const startY = window.pageYOffset;
        const elemRect = elem.getBoundingClientRect();
        const targetY = elemRect.top + window.pageYOffset + offset;
        const distance = targetY - startY;

        let startTime = null;
        // 기본 감속 이징 (easeOutQuint)
        const defaultEasing = t => 1 - Math.pow(1 - t, 5);
        const easing = typeof options.easing === 'function' ? options.easing : defaultEasing;

        function animateScroll(currentTime) {
            if (!startTime) startTime = currentTime;
            const timeElapsed = currentTime - startTime;
            const progress = Math.min(timeElapsed / duration, 1);
            const eased = easing(progress);
            window.scrollTo(0, startY + distance * eased);
            if (progress < 1) {
                requestAnimationFrame(animateScroll);
            }
        }
        requestAnimationFrame(animateScroll);
    }

    // 공개 API
    EGB.function = {
        loadScript: loadScript,
        changeClass: changeClass,
        addClass: addClass,
        delClass: delClass,
        headerHide1: headerHide1,
        countUp: countUp,
        fullScreen: fullScreen,
        classHover: classHover,
        toggle: toggle,
        click: click,
        classAdd: classAdd,
        classDel: classDel,
        urlToggle: urlToggle,
        urlClassAdd: urlClassAdd,
        urlClassDel: urlClassDel,
        scrollToggle: scrollToggle,
        scrollClassAdd: scrollClassAdd,
        scrollClassDel: scrollClassDel,
        scrollToTop: scrollToTop,
        hashMove: hashMove
    };

})(window);
