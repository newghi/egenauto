<?php
function egb_csr_script() {
    return "<script rel='preload' as='script' fetchpriority='high' nonce='" . NONCE . "'>\n" . <<<'JS'

//전역 변수 설정
let egbOriginDomain = window.location.origin; //현재 도메인
let egbUserAgent = navigator.userAgent;  // 사용자 에이전트 정보 (브라우저 및 운영체제 정보)
let egbLanguage = navigator.language || navigator.userLanguage; //브라우저 설정 언어
let egbIsMobile = /Mobi/i.test(egbUserAgent); // 모바일 기기 여부를 변수에 저장 모바일인 경우 true

//브라우져 창 사이즈
let windowWidth = document.documentElement.clientWidth;
let windowHeight = document.documentElement.clientHeight;

//패턴에 대한 정의
let xyRegex = /\b(?:xx-|yy-)[\w\d-_]+\b/g;
let tulrRegex = /\b(?:top-|bottom-|left-|right-)[\w\d-_]+\b/g;
let positionRegex = /position1|position2|position3|position4/g;
let position_t_Regex = /\b(?:top-)[\w\d-_]+\b/g;
let position_u_Regex = /\b(?:bottom-)[\w\d-_]+\b/g;
let position_l_Regex = /\b(?:left-)[\w\d-_]+\b/g;
let position_r_Regex = /\b(?:right-)[\w\d-_]+\b/g;
let egbRegexPattern = /(font_px_|r_font_|font_vw_|font_rem_|line_height_|linem_height_|letter_spacing_|letterm_spacing_|word_spacing_|wordm_spacing_|transform_|transform_[a-z]+_|transform_3d_|transform_3dm_|padding_px-[a-z]+_|padding_vw-[a-z]+_|margin_px-[a-z]+_|margin_vw-[a-z]+_|min_width_|max_width_|width_px_|width_vw_|min_height_|height_px_|height_vw_|height_vh_|max_height_|r_width_|r_height_|position1-[a-z]+_|position2-[a-z]+_|position3-[a-z]+_|border_bre-[a-z]+_|border_be-[a-z]+_|bd-a-color-[a-zA-Z0-9~]|bd-x-color-[a-zA-Z0-9~]|bd-y-color-[a-zA-Z0-9~]|bd-t-color-[a-zA-Z0-9~]|bd-u-color-[a-zA-Z0-9~]|bd-l-color-[a-zA-Z0-9~]|bd-r-color-[a-zA-Z0-9~]|color-[a-zA-Z0-9~]|bg-color-[a-zA-Z0-9~]|z-index_|zm-index_)(\d+)/g;
let srefRegex = /(sref_)([a-zA-Z0-9-]+)(?:_([a-zA-Z0-9-]+)(?:_([a-zA-Z0-9-]+)(?:_([a-zA-Z0-9-]+))?)?)?/;
let clefRegex = /(clef_)([a-zA-Z0-9-]+)(?:_([a-zA-Z0-9-]+)(?:_([a-zA-Z0-9-]+)(?:_([a-zA-Z0-9-]+))?)?)?/;
let hoefRegex = /(hoef_)([a-zA-Z0-9-]+)(?:_([a-zA-Z0-9-]+)(?:_([a-zA-Z0-9-]+)(?:_([a-zA-Z0-9-]+))?)?)?/;
let widthRegex = /width_px_\d+|r_width_\d+|width_vw_\d+|window-width-\d+|width_box|window_width|width_auto|width_none|width_off/g;
let maxWidthRegex = /max_width_\d+/g;
let minWidthRegex = /min_width_\d+/g;
let gapRegex = /gap_\d+/g;
let heightRegex = /height_px_\d+|r_height_\d+|height_vw_\d+|height_vh_\d+|window-height-\d+|height_box|window_height|height_auto|height_none|height_off/g;
let maxHeightRegex = /max_height_\d+/g;
let minHeightRegex = /min_height_\d+/g;
let fontRegex = /font_px_\d+|r_font_\d+|font_vw_\d+|font_rem_\d+/g;
let padding_a_Regex = /padding_px-a_\d+|padding_vw-a_\d+|padding_px-x_\d+|padding_vw-x_\d+|padding_px-y_\d+|padding_vw-y_\d+|padding_px-l_\d+|padding_vw-l_\d+|padding_px-r_\d+|padding_vw-r_\d+|padding_px-t_\d+|padding_vw-t_\d+|padding_px-u_\d+|padding_vw-u_\d+|padding_px-b_\d+|padding_vw-b_\d+/g;
let padding_x_Regex = /padding_px-x_\d+|padding_vw-x_\d+|padding_px-l_\d+|padding_vw-l_\d+|padding_px-r_\d+|padding_vw-r_\d+/g;
let padding_y_Regex = /padding_px-y_\d+|padding_vw-y_\d+|padding_px-t_\d+|padding_vw-t_\d+|padding_px-u_\d+|padding_vw-u_\d+|padding_px-b_\d+|padding_vw-b_\d+/g;
let padding_l_Regex = /padding_px-l_\d+|padding_vw-l_\d+/g;
let padding_r_Regex = /padding_px-r_\d+|padding_vw-r_\d+/g;
let padding_t_Regex = /padding_px-t_\d+|padding_vw-t_\d+/g;
let padding_u_Regex = /padding_px-u_\d+|padding_vw-u_\d+|padding_px-b_\d+|padding_vw-b_\d+/g;
let margin_a_Regex = /margin_px-a_\d+|margin_a_auto|margin_vw-a_\d+|margin_px-x_\d+|margin_x_auto|margin_vw-x_\d+|margin_px-y_\d+|margin_y_auto|margin_vw-y_\d+|margin_px-l_\d+|margin_l_auto|margin_vw-l_\d+|margin_px-r_\d+|margin_r_auto|margin_vw-r_\d+|margin_px-t_\d+|margin_t_auto|margin_vw-t_\d+|margin_px-u_\d+|margin_u_auto|margin_vw-u_\d+|margin_px-b_\d+|margin_b_auto|margin_vw-b_\d+/g;
let margin_x_Regex = /margin_px-x_\d+|margin_x_auto|margin_vw-x_\d+|margin_px-l_\d+|margin_l_auto|margin_vw-l_\d+|margin_px-r_\d+|margin_r_auto|margin_vw-r_\d+/g;
let margin_y_Regex = /margin_px-y_\d+|margin_y_auto|margin_vw-y_\d+|margin_px-t_\d+|margin_t_auto|margin_vw-t_\d+|margin_px-u_\d+|margin_u_auto|margin_vw-u_\d+|margin_px-b_\d+|margin_b_auto|margin_vw-b_\d+/g;
let margin_l_Regex = /margin_px-l_\d+|margin_l_auto|margin_vw-l_\d+/g;
let margin_r_Regex = /margin_px-r_\d+|margin_r_auto|margin_vw-r_\d+/g;
let margin_t_Regex = /margin_px-t_\d+|margin_t_auto|margin_vw-t_\d+/g;
let margin_u_Regex = /margin_px-u_\d+|margin_u_auto|margin_vw-u_\d+|margin_px-b_\d+|margin_b_auto|margin_vw-b_\d+/g;
let displayRegex = /display_block|display_none|display_flex|display_contents|display_flow|display_flow_root|display_inline|display_inline_block|display_inline_grid|display_inline_flex|display_inline_table|display_list_item|display_table|display_table_caption|display_table_cell|display_table_column|display_table_column_group|display_table_header_group|display_table_footer_group|display_table_row|display_table_row_group|grid_[\w\d-_]+|flex_[\w\d-_]+/g;
let colorRegex = /color-[a-zA-Z0-9_]+/g;
let bgColorRegex = /bg-color-[a-zA-Z0-9_]+/g;
let eventsRegex = /^(click|mouseover|mouseout|mousedown|mouseup|dblclick|mousemove|keydown|keyup|keypress|change|focus|blur|input|submit|load|resize|scroll|touchstart|touchend|drag|drop|contextmenu|wheel|select|cut|copy|paste|dragenter|dragleave|dragover|animationstart|animationend|animationiteration|transitionend|pointerdown|pointerup|pointermove|pointerover|pointerout|pointercancel|visibilitychange|focusin|focusout)$/;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 스타일 중복 체크를 위한 캐시
const generatedStylesCache = new Set();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////


// 검사시 무시할 노드 이름 목록 정의
const IGNORE_NODE_NAMES = [
	'SCRIPT', 'LINK', 'META', 'STYLE',
	'SVG', 'PATH', 'CIRCLE', 'ELLIPSE', 'RECT', 'LINE', 'POLYLINE', 'POLYGON', 'G', 'MARKER', 'DEFS', 'CLIPPATH', 'MASK', 'USE', 'SYMBOL', 'TEXT', 'TSPAN'
];

// 훅 저장소 초기화 (EGB.form 모듈과 동기화)
let dataHooks = new Map();

// 디바운스 타이머 저장용 Map
let debounceTimers = new Map();

//함수목록
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 타겟 아이디 요소의 클래스를 토글 하는 함수
function egbToggle(targetId, ...classNames) {
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function egbDragBox() {

}

//전체화면에 대한 function
function egbFullScreen() {
    if (!document.fullscreenElement) {
        // 전체 화면이 아닐 때, 전체 화면으로 전환하고 egbFullScreenTrue() 실행
        document.documentElement.requestFullscreen().then(() => {
            if (typeof egbFullScreenTrue === "function") {
                egbFullScreenTrue(); // 전체 화면으로 전환된 후 실행 해당 함수는 프로젝트마다 별도 생성
            }
        }).catch((error) => {
            console.error("Failed to enter fullscreen:", error);
        });
    } else {
        // 이미 전체 화면일 때, 전체 화면 해제하고 egbFullScreenFalse() 실행
        document.exitFullscreen().then(() => {
            if (typeof egbFullScreenFalse === "function") {
                egbFullScreenFalse(); // 전체 화면 해제된 후 실행 해당 함수는 프로젝트마다 별도 생성
            }
        }).catch((error) => {
            console.error("Failed to exit fullscreen:", error);
        });
    }
}

function egbClassHover(id, className) {
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
function egbToggle(targetId, ...classNames) {
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


function egbClick(targetId, delay = 0) {
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
function egbClassAdd(targetId, ...classNames) {
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
function egbClassDel(targetId, ...classNames) {
    const element = document.getElementById(targetId);
    if (element) {
        classNames.forEach(className => {
            if (element.classList.contains(className)) {
                element.classList.remove(className);
            }
        });
    }
}
function egbUrlToggle(targetId, includeQueryParams, compareUrl, ...classes) {
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

function egbUrlClassAdd(targetId, includeQueryParams, compareUrl, ...classes) {
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

function egbUrlClassDel(targetId, includeQueryParams, compareUrl, ...classes) {
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



function egbScrollToggle(targetId, offset, ...classNames) {
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

function egbScrollClassAdd(targetId, offset, ...classNames) {
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

function egbScrollClassDel(targetId, offset, ...classNames) {
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

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// egb 대상 노드를 html로 설정
const egbTargetNode = document.documentElement;

// egb 감시할 옵션을 설정
const egbConfig = { childList: true, subtree: true, attributes: true, attributeOldValue: false };

// 스크립트 로드 상태 추적 (전역으로 관리)
if (!window.egbLoadedScripts) {
    window.egbLoadedScripts = new Set();
}

// 스크립트 로드 함수
function loadRequiredScripts(node) {
    const scriptsToLoad = [];
    
    // 태그 기반 스크립트 매핑
    const tagScriptMap = {
        'FORM': ['/js/egb_ajax', '/js/egb_form'],
        'STYLE': ['/js/egb_style'],
        'IMG': ['/js/egb_img']
    };
    
    // 클래스 기반 스크립트 매핑
    const classScriptMap = {
        'slide_egb_main_box': ['/js/egb_slide'],
        'egb_spa': ['/js/egb_spa'],
        'egb_qna': ['/js/egb_qna'],
        'egb_qna_accordion': ['/js/egb_qna'],
        'egb_admin_page': ['/js/egb_admin']
    };
    
    // 스크립트별 로드 조건 확인 함수
    const scriptLoadConditions = {
        '/js/egb_admin': () => {
            // egb_admin은 한 번만 로드되도록 추가 확인
            return !window.egbAdminLoaded;
        }
    };
    
    // 클래스 패턴 기반 스크립트 매핑
    const classPatternScriptMap = {
        'egb_radio_': ['/js/egb_radio']
    };
    
    // ID 기반 스크립트 매핑
    const idScriptMap = {
        'egb_push': ['/js/pusher', '/js/ably', '/js/egb_push']
    };
    
    // 태그 기반 스크립트 확인
    if (tagScriptMap[node.tagName]) {
        scriptsToLoad.push(...tagScriptMap[node.tagName]);
    }
    
    // 클래스 기반 스크립트 확인
    if (node.classList) {
        Array.from(node.classList).forEach(className => {
            // 정확히 일치하는 클래스
            if (classScriptMap[className]) {
                scriptsToLoad.push(...classScriptMap[className]);
            }
            
            // 패턴으로 시작하는 클래스
            Object.keys(classPatternScriptMap).forEach(pattern => {
                if (className.startsWith(pattern)) {
                    scriptsToLoad.push(...classPatternScriptMap[pattern]);
                }
            });
        });
    }
    
    // ID 기반 스크립트 확인
    if (node.id && idScriptMap[node.id]) {
        scriptsToLoad.push(...idScriptMap[node.id]);
    }
    
    // 중복 제거 및 로드되지 않은 스크립트만 필터링
    const uniqueScripts = [...new Set(scriptsToLoad)].filter(script => {
        // 기본 중복 체크
        if (window.egbLoadedScripts.has(script)) return false;
        
        // 스크립트별 추가 조건 체크
        if (scriptLoadConditions[script]) {
            return scriptLoadConditions[script]();
        }
        
        return true;
    });
    
    // 스크립트 로드
    uniqueScripts.forEach(script => {
        if (!window.egbLoadedScripts.has(script)) {
            window.egbLoadedScripts.add(script);
            console.log(`[EGB] 스크립트 로드 중: ${script}`);
            
            // 이미 DOM에 존재하는 스크립트 태그 확인
            const existingScript = document.querySelector(`script[src="${script}"]`);
            if (existingScript) {
                console.log(`[EGB] 스크립트가 이미 DOM에 존재합니다: ${script}`);
                return;
            }
            
            // EGB.function.loadScript 사용 (egb_function.js에서 제공)
            if (EGB.function && EGB.function.loadScript) {
                // 스크립트 경로에서 고유 ID 생성
                const scriptId = script.replace(/[^a-zA-Z0-9]/g, '_').replace(/^_+|_+$/g, '');
                EGB.function.loadScript(script, `egb_script_${scriptId}`, function() {
                    console.log(`[EGB] 스크립트 로드 완료: ${script}`);
                    
                    // 특정 스크립트 로드 완료 시 플래그 설정
                    if (script === '/js/egb_admin') {
                        window.egbAdminLoaded = true;
                    }
                });
            } else {
                // 폴백: 직접 스크립트 로드
                const scriptEl = document.createElement('script');
                scriptEl.src = script;
                scriptEl.onload = () => {
                    console.log(`[EGB] 스크립트 로드 완료: ${script}`);
                    
                    // 특정 스크립트 로드 완료 시 플래그 설정
                    if (script === '/js/egb_admin') {
                        window.egbAdminLoaded = true;
                    }
                };
                document.head.appendChild(scriptEl);
            }
        }
    });
}

// egbAnalyzeNodeAndAddEvents 함수 정의
const egbAnalyzeNodeAndAddEvents = (egbNode) => {
    // 스크립트 로드 확인 및 처리
    loadRequiredScripts(egbNode);
    
    // 클래스 관련 분석
    egbAnalyzeNodeClasses(egbNode);

    // egb 이벤트 속성 분석 및 리스너 추가
    Array.from(egbNode.attributes).forEach(egbAttr => {
        if (egbAttr.name.startsWith('egb:')) {
            const egbEventType = egbAttr.name.replace('egb:', ''); // 'egb:' 접두사 제거
            let egbEventHandler = egbAttr.value; // 핸들러 함수 이름 또는 함수 호출

            if (egbEventType === 'style') {
                console.log('egb:style 처리 시작:', egbEventHandler);
                // egb:style 속성에 대한 처리
                let egbStyleTag = document.getElementById('egbStyleTag');

                // egbStyleTag가 없으면 생성하여 head에 추가
                if (!egbStyleTag) {
                    egbStyleTag = document.createElement('style');
                    egbStyleTag.id = 'egbStyleTag';
                    document.head.appendChild(egbStyleTag);
                    console.log('egbStyleTag 생성됨');
                }

                // 스타일 정보를 '}'를 기준으로 분리하여 각 스타일 블록을 개별적으로 처리
                const styleBlocks = egbEventHandler.split('}').map(block => block.trim()).filter(Boolean);
                styleBlocks.forEach(styleBlock => {
                    if (styleBlock) {
                        // @keyframes 처리
                        if (styleBlock.startsWith('@keyframes')) {
                            const keyframesName = styleBlock.match(/@keyframes\s+([^\s{]+)/)[1];
                            const keyframesContent = styleBlock.slice(styleBlock.indexOf('{') + 1).trim();

                            // 키프레임 블록 내부를 분리 및 변환
                            const updatedKeyframesContent = keyframesContent.split('}').map(frame => {
                                const [percentage, styles] = frame.split('{').map(part => part.trim());
                                if (!percentage || !styles) return '';
                                
                                const updatedStyles = styles.replace(/(-?\d*\.?\d+)px/g, function(match, number) {
                                    const paddedNumber = String(Math.abs(number)).replace('.', '_').padStart(3, '0');
                                    const diff = Math.abs(number) - EGB_REF_PX;
                                    const variableName = '--size-' + paddedNumber;
                                    const egbAdjustValue = (EGB_BASE_VW + (diff * EGB_START_VW)).toFixed(6) + 'vw';
                                    const updateValue = `clamp(${Math.abs(number)}px, ${egbAdjustValue}, 9999px)`;
                                    const cssRoot = `:root {${variableName}: ${updateValue};}`;

                                    if (!generatedStylesCache.has(cssRoot)) {
                                        generatedStylesCache.add(cssRoot);
                                        // updateOrCreateStyleTag 함수 호출 (필요시 구현)
                                    }

                                    return `calc(var(${variableName}, ${Math.abs(number)}px)${parseFloat(number) < 0 ? ' * -1' : ''})`;
                                });

                                return `${percentage} { ${updatedStyles} }`;
                            }).join(' ');

                            const finalKeyframesBlock = `@keyframes ${keyframesName} { ${updatedKeyframesContent} }`;

                            // 중복 방지 및 추가
                            if (!egbStyleTag.innerHTML.includes(finalKeyframesBlock)) {
                                egbStyleTag.innerHTML += finalKeyframesBlock;
                            }
                            return;
                        }

                        // 일반 스타일 블록 처리
                        const [selectors, styles] = styleBlock.split('{').map(part => part.trim());
                        if (!selectors || !styles) return;

                        // 소수점을 포함한 px 단위 값을 처리하여 루트 변수로 추가
                        const updatedStyles = styles.replace(/(-?\d*\.?\d+)px/g, function(match, number) {
                            const paddedNumber = String(Math.abs(number)).replace('.', '_').padStart(3, '0');
                            const diff = Math.abs(number) - EGB_REF_PX;
                            const variableName = '--size-' + paddedNumber;
                            const egbAdjustValue = (EGB_BASE_VW + (diff * EGB_START_VW)).toFixed(6) + 'vw';
                            const updateValue = `clamp(${Math.abs(number)}px, ${egbAdjustValue}, 9999px)`;
                            const cssRoot = `:root {${variableName}: ${updateValue};}`;

                            if (!generatedStylesCache.has(cssRoot)) {
                                generatedStylesCache.add(cssRoot);
                                // updateOrCreateStyleTag 함수 호출 (필요시 구현)
                            }

                            return `calc(var(${variableName}, ${Math.abs(number)}px)${parseFloat(number) < 0 ? ' * -1' : ''})`;
                        });

                        // 최종 스타일 블록 생성
                        const finalStyleBlock = `${selectors} { ${updatedStyles} }`;
                        console.log('생성된 스타일 블록:', finalStyleBlock);

                        // egbStyleTag에 중복 스타일 추가 방지
                        if (!egbStyleTag.innerHTML.includes(finalStyleBlock)) {
                            egbStyleTag.innerHTML += finalStyleBlock;
                            console.log('스타일이 egbStyleTag에 추가됨');
                        } else {
                            console.log('중복 스타일이므로 추가하지 않음');
                        }
                    }
                });

                // egb:style을 처리한 요소를 DOM에서 제거
                if (egbAttr.ownerElement) {
                    egbAttr.ownerElement.remove();
                }
            } else if (egbEventType === 'css') {
                // egb:css 속성 처리
                const cssParts = egbEventHandler.split(':').map(part => part.trim());
                if (cssParts.length !== 2) {
                    console.warn('잘못된 egb:css 속성 형식입니다.');
                    return;
                }
                const [newClassName, classNamesString] = cssParts;
                const classNames = classNamesString.split(' ').filter(Boolean);

                let combinedStyles = '';

                // 전체 페이지의 스타일 시트를 탐색
                Array.from(document.styleSheets).forEach(sheet => {
                    try {
                        const cssRules = sheet.cssRules;
                        for (let rule of cssRules) {
                            if (rule.selectorText && classNames.includes(rule.selectorText.replace('.', ''))) {
                                // CSS 텍스트에서 클래스 이름을 제거하고 스타일 속성만 합치기
                                const styleContent = rule.style.cssText;
                                combinedStyles += styleContent;
                            }
                        }
                    } catch (e) {
                        // 외부 도메인의 스타일 시트는 접근이 제한될 수 있으므로 예외 처리
                        console.warn('스타일 시트에 접근할 수 없습니다.', e);
                    }
                });

                // 찾은 스타일 속성을 egbStyleTag에 추가
                let egbStyleTag = document.getElementById('egbStyleTag');
                if (!egbStyleTag) {
                    egbStyleTag = document.createElement('style');
                    egbStyleTag.id = 'egbStyleTag';
                    document.head.appendChild(egbStyleTag);
                }

                if (combinedStyles) {
                    const newClassRule = `.${newClassName} { ${combinedStyles} }`;
                    if (!egbStyleTag.innerHTML.includes(newClassRule)) {
                        egbStyleTag.innerHTML += `${newClassRule}\n`;
                    }
                }

                // 기존 egb:css 속성 제거
                egbNode.removeAttribute(egbAttr.name);
            } else if (egbEventType === 'function') {
                // egbEventHandler에 여러 개의 함수가 있는 경우 ';'으로 분리
                const egbFunctions = egbEventHandler.split(';');

                // 각 함수 호출을 순회하며 실행
                egbFunctions.forEach(func => {
                    const trimmedFunc = func.trim(); // 공백 제거
                    if (trimmedFunc) {
                        try {
                            const funcName = trimmedFunc.split('(')[0];
                            const argsString = trimmedFunc.match(/\((.*)\)/)?.[1];
                            const args = argsString ? argsString.split(',').map(arg => arg.trim().replace(/^['"]|['"]$/g, '')) : [];
                            if (typeof window[funcName] === 'function') {
                                window[funcName](...args);
                            } else {
                                console.error(`Function not found: ${funcName}`);
                            }
                        } catch (error) {
                            console.error(`Error executing function: ${trimmedFunc}`, error);
                        }
                    }
                });

                // egb:function을 실행한 요소를 DOM에서 제거
                if (egbAttr.ownerElement) {
                    egbAttr.ownerElement.remove();
                }
            } else if (eventsRegex.test(egbEventType)) {
                // 올바른 이벤트 타입인지 확인
                egbNode.removeEventListener(egbEventType, window[egbEventHandler]);

                // 이벤트 리스너 추가
                egbNode.addEventListener(egbEventType, function(event) {
                    // 여러 이벤트 핸들러를 ';'로 구분하여 실행
                    egbEventHandler.split(';').forEach(handler => {
                        handler = handler.trim();
                        if (handler.includes('(')) {
                            const handlerName = handler.split('(')[0]; // 함수 이름 추출
                            const handlerArgs = handler.match(/\(([^)]*)\)/)[1]
                                .split(',').map(arg => arg.trim().replace(/['"]/g, '')); // 함수 인자 추출 및 정리

                            if (typeof window[handlerName] === 'function') {
                                window[handlerName](...handlerArgs); // 함수 호출 시 인자 전달
                            } else {
                                //console.warn(`함수 ${handlerName}가 정의되지 않았습니다.`);
                            }
                        } else {
                            if (typeof window[handler] === 'function') {
                                window[handler](); // 인자 없는 함수 호출
                            } else {
                                //console.warn(`함수 ${handler}가 정의되지 않았습니다.`);
                            }
                        }
                    });
                });

                // 기존 egb: 속성 제거
                egbNode.removeAttribute(egbAttr.name);
            }
        } else if (egbAttr.name.startsWith('data-')) {
            // data-xx, data-yy 속성 처리
            if (egbAttr.name === 'data-xx') {
                const dataValue = egbNode.getAttribute("data-xx");
                if (dataValue) {
                    const values = dataValue.split(" ").map(val => val.trim());
                    const xyStyleName = 'xx-' + dataValue.replace(/%/g, "per").replace(/\s/g, "-").replace(/\./g, '_');
                    
                    // 스타일 생성
                    const styleString = `.${xyStyleName} { grid-template-columns: ${dataValue}; }`;
                    
                    // egbStyleTag에 추가
                    let egbStyleTag = document.getElementById('egbStyleTag');
                    if (!egbStyleTag) {
                        egbStyleTag = document.createElement('style');
                        egbStyleTag.id = 'egbStyleTag';
                        document.head.appendChild(egbStyleTag);
                    }
                    
                    if (!egbStyleTag.innerHTML.includes(styleString)) {
                        egbStyleTag.innerHTML += styleString;
                    }
                    
                    // 클래스 추가
                    egbNode.classList.add(xyStyleName);
                    egbNode.removeAttribute(egbAttr.name);
                }
            } else if (egbAttr.name === 'data-yy') {
                const dataValue = egbNode.getAttribute("data-yy");
                if (dataValue) {
                    const values = dataValue.split(" ").map(val => val.trim());
                    const xyStyleName = 'yy-' + dataValue.replace(/%/g, "per").replace(/\s/g, "-").replace(/\./g, '_');
                    
                    // 스타일 생성
                    const styleString = `.${xyStyleName} { grid-template-rows: ${dataValue}; }`;
                    
                    // egbStyleTag에 추가
                    let egbStyleTag = document.getElementById('egbStyleTag');
                    if (!egbStyleTag) {
                        egbStyleTag = document.createElement('style');
                        egbStyleTag.id = 'egbStyleTag';
                        document.head.appendChild(egbStyleTag);
                    }
                    
                    if (!egbStyleTag.innerHTML.includes(styleString)) {
                        egbStyleTag.innerHTML += styleString;
                    }
                    
                    // 클래스 추가
                    egbNode.classList.add(xyStyleName);
                    egbNode.removeAttribute(egbAttr.name);
                }
            } else if (egbAttr.name === 'data-color') {
                const dataValue = egbNode.getAttribute("data-color");
                if (dataValue) {
                    // CSS 속성 선택자 규칙 생성
                    const selector = `[data-color="${dataValue}"]`;
                    const styleString = `${selector} { color: ${dataValue}; }`;
                    
                    // egbStyleTag에 추가
                    let egbStyleTag = document.getElementById('egbStyleTag');
                    if (!egbStyleTag) {
                        egbStyleTag = document.createElement('style');
                        egbStyleTag.id = 'egbStyleTag';
                        document.head.appendChild(egbStyleTag);
                    }
                    
                    if (!egbStyleTag.innerHTML.includes(styleString)) {
                        egbStyleTag.innerHTML += styleString;
                    }
                    
                    // data 속성은 그대로 유지 (CSS 선택자로 사용)
                }
            } else if (egbAttr.name === 'data-hover-color') {
                const dataValue = egbNode.getAttribute("data-hover-color");
                if (dataValue) {
                    // CSS 속성 선택자 규칙 생성
                    const selector = `[data-hover-color="${dataValue}"]`;
                    const styleString = `${selector}:hover { color: ${dataValue}; }`;
                    
                    // egbStyleTag에 추가
                    let egbStyleTag = document.getElementById('egbStyleTag');
                    if (!egbStyleTag) {
                        egbStyleTag = document.createElement('style');
                        egbStyleTag.id = 'egbStyleTag';
                        document.head.appendChild(egbStyleTag);
                    }
                    
                    if (!egbStyleTag.innerHTML.includes(styleString)) {
                        egbStyleTag.innerHTML += styleString;
                    }
                    
                    // data 속성은 그대로 유지 (CSS 선택자로 사용)
                }
            } else if (egbAttr.name === 'data-bg-color') {
                const dataValue = egbNode.getAttribute("data-bg-color");
                if (dataValue) {
                    // CSS 속성 선택자 규칙 생성
                    const selector = `[data-bg-color="${dataValue}"]`;
                    const styleString = `${selector} { background-color: ${dataValue}; }`;
                    
                    // egbStyleTag에 추가
                    let egbStyleTag = document.getElementById('egbStyleTag');
                    if (!egbStyleTag) {
                        egbStyleTag = document.createElement('style');
                        egbStyleTag.id = 'egbStyleTag';
                        document.head.appendChild(egbStyleTag);
                    }
                    
                    if (!egbStyleTag.innerHTML.includes(styleString)) {
                        egbStyleTag.innerHTML += styleString;
                    }
                    
                    // data 속성은 그대로 유지 (CSS 선택자로 사용)
                }
            } else if (egbAttr.name === 'data-hover-bg-color') {
                const dataValue = egbNode.getAttribute("data-hover-bg-color");
                if (dataValue) {
                    // CSS 속성 선택자 규칙 생성
                    const selector = `[data-hover-bg-color="${dataValue}"]`;
                    const styleString = `${selector}:hover { background-color: ${dataValue}; }`;
                    
                    // egbStyleTag에 추가
                    let egbStyleTag = document.getElementById('egbStyleTag');
                    if (!egbStyleTag) {
                        egbStyleTag = document.createElement('style');
                        egbStyleTag.id = 'egbStyleTag';
                        document.head.appendChild(egbStyleTag);
                    }
                    
                    if (!egbStyleTag.innerHTML.includes(styleString)) {
                        egbStyleTag.innerHTML += styleString;
                    }
                    
                    // data 속성은 그대로 유지 (CSS 선택자로 사용)
                }
            } else if (egbAttr.name.startsWith('data-bd-') && egbAttr.name.endsWith('-color')) {
                // 테두리 색상 속성 처리 (data-bd-a-color, data-bd-x-color, data-bd-y-color, data-bd-t-color, data-bd-u-color, data-bd-l-color, data-bd-r-color)
                const dataValue = egbNode.getAttribute(egbAttr.name);
                if (dataValue) {
                    const borderType = egbAttr.name.replace('data-bd-', '').replace('-color', '');
                    
                    // 테두리 방향에 따른 CSS 속성 매핑
                    const borderDirections = {
                        'a': ['border-top-color', 'border-right-color', 'border-bottom-color', 'border-left-color'],
                        'x': ['border-left-color', 'border-right-color'],
                        'y': ['border-top-color', 'border-bottom-color'],
                        't': ['border-top-color'],
                        'u': ['border-bottom-color'],
                        'l': ['border-left-color'],
                        'r': ['border-right-color']
                    };
                    
                    const directions = borderDirections[borderType];
                    if (directions) {
                        const borderRules = directions.map(d => `${d}: ${dataValue}`).join('; ');
                        const selector = `[${egbAttr.name}="${dataValue}"]`;
                        const styleString = `${selector} { ${borderRules}; }`;
                        
                        // egbStyleTag에 추가
                        let egbStyleTag = document.getElementById('egbStyleTag');
                        if (!egbStyleTag) {
                            egbStyleTag = document.createElement('style');
                            egbStyleTag.id = 'egbStyleTag';
                            document.head.appendChild(egbStyleTag);
                        }
                        
                        if (!egbStyleTag.innerHTML.includes(styleString)) {
                            egbStyleTag.innerHTML += styleString;
                        }
                        
                        // data 속성은 그대로 유지 (CSS 선택자로 사용)
                    }
                }
            } else if (egbAttr.name.startsWith('data-hover-bd-') && egbAttr.name.endsWith('-color')) {
                // 호버 시 테두리 색상 속성 처리
                const dataValue = egbNode.getAttribute(egbAttr.name);
                if (dataValue) {
                    const borderType = egbAttr.name.replace('data-hover-bd-', '').replace('-color', '');
                    
                    // 테두리 방향에 따른 CSS 속성 매핑
                    const borderDirections = {
                        'a': ['border-top-color', 'border-right-color', 'border-bottom-color', 'border-left-color'],
                        'x': ['border-left-color', 'border-right-color'],
                        'y': ['border-top-color', 'border-bottom-color'],
                        't': ['border-top-color'],
                        'u': ['border-bottom-color'],
                        'l': ['border-left-color'],
                        'r': ['border-right-color']
                    };
                    
                    const directions = borderDirections[borderType];
                    if (directions) {
                        const borderRules = directions.map(d => `${d}: ${dataValue}`).join('; ');
                        const selector = `[${egbAttr.name}="${dataValue}"]`;
                        const styleString = `${selector}:hover { ${borderRules}; }`;
                        
                        // egbStyleTag에 추가
                        let egbStyleTag = document.getElementById('egbStyleTag');
                        if (!egbStyleTag) {
                            egbStyleTag = document.createElement('style');
                            egbStyleTag.id = 'egbStyleTag';
                            document.head.appendChild(egbStyleTag);
                        }
                        
                        if (!egbStyleTag.innerHTML.includes(styleString)) {
                            egbStyleTag.innerHTML += styleString;
                        }
                        
                        // data 속성은 그대로 유지 (CSS 선택자로 사용)
                    }
                }
            } else if (['data-top', 'data-bottom', 'data-left', 'data-right'].includes(egbAttr.name)) {
                // position 관련 속성 처리 (data-top, data-bottom, data-left, data-right)
                const dataValue = egbNode.getAttribute(egbAttr.name);
                if (dataValue) {
                    const positionType = egbAttr.name.replace('data-', '');
                    
                    // 값이 숫자인지 확인 (px 단위)
                    let cssValue;
                    if (dataValue === '0') {
                        cssValue = '0';
                    } else if (dataValue.includes('%')) {
                        cssValue = dataValue; // 퍼센트 값 그대로 사용
                    } else if (dataValue.includes('per')) {
                        cssValue = dataValue.replace('per', '%'); // per를 %로 변환
                    } else if (dataValue.includes('px')) {
                        cssValue = dataValue; // px 값 그대로 사용
                    } else if (dataValue.includes('vw')) {
                        cssValue = dataValue; // vw 값 그대로 사용
                    } else if (dataValue.includes('vh')) {
                        cssValue = dataValue; // vh 값 그대로 사용
                    } else if (dataValue.includes('rem')) {
                        cssValue = dataValue; // rem 값 그대로 사용
                    } else if (dataValue.includes('em')) {
                        cssValue = dataValue; // em 값 그대로 사용
                    } else if (!isNaN(dataValue)) {
                        cssValue = `${dataValue}px`; // 숫자인 경우 px 단위 추가
                    } else {
                        cssValue = dataValue; // 기타 값은 그대로 사용
                    }
                    
                    // CSS 속성 선택자 규칙 생성
                    const selector = `[${egbAttr.name}="${dataValue}"]`;
                    const styleString = `${selector} { ${positionType}: ${cssValue}; }`;
                    
                    // egbStyleTag에 추가
                    let egbStyleTag = document.getElementById('egbStyleTag');
                    if (!egbStyleTag) {
                        egbStyleTag = document.createElement('style');
                        egbStyleTag.id = 'egbStyleTag';
                        document.head.appendChild(egbStyleTag);
                    }
                    
                    if (!egbStyleTag.innerHTML.includes(styleString)) {
                        egbStyleTag.innerHTML += styleString;
                    }
                    
                    // data 속성은 그대로 유지 (CSS 선택자로 사용)
                }
            }
        }
    });

    // 자식 노드가 있으면 재귀적으로 분석
    egbNode.childNodes.forEach((egbChildNode) => {
        if (egbChildNode.nodeType === 1) {
            egbAnalyzeNodeAndAddEvents(egbChildNode);
        }
    });
};

// egbAnalyzeNodeClasses 함수 정의 
function egbAnalyzeNodeClasses(node) {
    // 클래스 변경 분석 로직 구현
    //console.log('클래스 변경 분석:', node);
}

/**
 * EGB CSR 스타일 관리 모듈
 * 
 * 클라이언트 사이드에서 동적으로 EGB 클래스에 대한 CSS 스타일을 생성하고 관리합니다.
 */

// 기본 상수 정의
const EGB_BASE_VW = 0.833335;
const EGB_START_VW = 0.052084;
const EGB_REF_PX = 16.0;

// CSS 속성 프리픽스 정의
const validPrefixes = {
    'align_content': 'align-content',
    'align_items': 'align-items',
    'align_self': 'align-self',
    'animation_delay': 'animation-delay',
    'animation_direction': 'animation-direction',
    'animation_duration': 'animation-duration',
    'animation_fill_mode': 'animation-fill-mode',
    'animation_iteration_count': 'animation-iteration-count',
    'animation_name': 'animation-name',
    'animation_play_state': 'animation-play-state',
    'animation_timing_function': 'animation-timing-function',
    'background_attachment': 'background-attachment',
    'background_clip': 'background-clip',
    'background_color': 'background-color',
    'background_image': 'background-image',
    'background_position': 'background-position',
    'background_repeat': 'background-repeat',
    'background_size': 'background-size',
    'border_collapse': 'border-collapse',
    'border_color': 'border-color',
    'border_radius': 'border-radius',
    'border_spacing': 'border-spacing',
    'border_style': 'border-style',
    'border_width': 'border-width',
    'box_shadow': 'box-shadow',
    'box_sizing': 'box-sizing',
    'cursor': 'cursor',
    'flex_direction': 'flex-direction',
    'flex_wrap': 'flex-wrap',
    'font_family': 'font-family',
    'font_size': 'font-size',
    'font_style': 'text-align',
    'font_weight': 'font-weight',
    'justify_content': 'justify-content',
    'letter_spacing': 'letter-spacing',
    'line_height': 'line-height',
    'list_style': 'list-style',
    'opacity': 'opacity',
    'order': 'order',
    'outline': 'outline',
    'position': 'position',
    'text_align': 'text-align',
    'text_decoration': 'text-decoration',
    'text_transform': 'text-transform',
    'transform': 'transform',
    'transition': 'transition',
    'vertical_align': 'vertical-align',
    'visibility': 'visibility',
    'white_space': 'white-space',
    'word_break': 'word-break',
    'word_spacing': 'word-spacing',
    'z_index': 'z-index',
    'z-index': 'z-index',
    'zm-index': 'z-index'
};

// 루트 변수 생성 함수
function makeRootVar(n) {
    const varName = `--size-${String(n).padStart(3, '0')}`;
    const px = `${n}px`;
    const calc = `calc(${EGB_BASE_VW}vw + (${n} - ${EGB_REF_PX})*${EGB_START_VW}vw)`;
    const clamp = `clamp(${px}, ${calc}, 9999px)`;
    return `  ${varName}: ${clamp};\n`;
}

// EGB 클래스에 대한 CSS 생성 함수
function egbCsrStyle(classes) {
    const seenVars = new Set();
    const rootCss = [];
    const rules = [];

    classes.forEach(cls => {
        // line-height 처리
        if (/^line_height_(\d+)$/.test(cls)) {
            const size = parseInt(cls.match(/^line_height_(\d+)$/)[1]) / 100;
            rules.push(`.${cls}{line-height: ${size.toFixed(2)};}`);
            return;
        }

        // word-spacing 처리
        if (/^word_spacing_(\d+)$/.test(cls)) {
            const size = parseInt(cls.match(/^word_spacing_(\d+)$/)[1]) / 100;
            rules.push(`.${cls}{word-spacing: ${size.toFixed(2)};}`);
            return;
        }

        // letter-spacing 처리
        if (/^letter_spacing_(\d+)$/.test(cls)) {
            const size = parseInt(cls.match(/^letter_spacing_(\d+)$/)[1]) / 100;
            rules.push(`.${cls}{letter-spacing: ${size.toFixed(2)};}`);
            return;
        }

        // display 처리
        if (cls.startsWith('display_')) {
            const value = cls.substring(8).replace(/_/g, '-');
            if (value === 'off') {
                rules.push(`.${cls}{display:none !important;}`);
            } else {
                rules.push(`.${cls}{display:${value};}`);
            }
            return;
        }

        // color 처리
        if (/^color[-_]([0-9A-Fa-f]{6})$/.test(cls)) {
            const color = '#' + cls.match(/^color[-_]([0-9A-Fa-f]{6})$/)[1];
            rules.push(`.${cls}{color:${color};}`);
            return;
        }

        // bg-color 처리
        if (/^bg-color-([0-9A-Fa-f]{6})$/i.test(cls)) {
            const color = '#' + cls.match(/^bg-color-([0-9A-Fa-f]{6})$/i)[1];
            rules.push(`.${cls}{background-color:${color};}`);
            return;
        }

        // border-color 처리
        if (/^bd-([a-z])-color-([0-9A-Fa-f]{6})$/i.test(cls)) {
            const [, dir, colorCode] = cls.match(/^bd-([a-z])-color-([0-9A-Fa-f]{6})$/i);
            const color = '#' + colorCode;
            
            const borderDirections = {
                'a': ['top', 'right', 'bottom', 'left'],
                'x': ['left', 'right'],
                'y': ['top', 'bottom'],
                't': ['top'],
                'u': ['bottom'],
                'l': ['left'],
                'r': ['right']
            };

            const directions = borderDirections[dir];
            if (directions) {
                const borderRules = directions.map(d => `border-${d}-color:${color}`).join(';');
                rules.push(`.${cls}{${borderRules};}`);
            }
            return;
        }

        // 폰트 두께 처리 (flv1~9)
        if (/^flv([1-9])$/.test(cls)) {
            const weight = parseInt(cls.match(/^flv([1-9])$/)[1]) * 100;
            rules.push(`.${cls}{font-weight:${weight};}`);
            return;
        }

        // o_4 (opacity)
        if (/^o_(\d+)$/.test(cls)) {
            const opacity = parseInt(cls.match(/^o_(\d+)$/)[1]) / 10;
            rules.push(`.${cls}{opacity:${opacity};}`);
            return;
        }

        // border radius 처리
        if (/^border_bre-([a-z]+)_(\d+)$/.test(cls)) {
            const [, dir, size] = cls.match(/^border_bre-([a-z]+)_(\d+)$/);
            const n = parseInt(size);
            
            if (!seenVars.has(n) && !isRootVarAlreadyGenerated(n)) {
                seenVars.add(n);
                rootCss.push(makeRootVar(n));
            }
            
            const varValue = `var(--size-${String(n).padStart(3, '0')},${n}px)`;
            
            const radiusMap = {
                'a': `border-radius:${varValue};border-top-left-radius:${varValue};border-top-right-radius:${varValue};border-bottom-left-radius:${varValue};border-bottom-right-radius:${varValue}`,
                'tx': `border-top-left-radius:${varValue};border-top-right-radius:${varValue}`,
                'ux': `border-bottom-left-radius:${varValue};border-bottom-right-radius:${varValue}`,
                'ly': `border-top-left-radius:${varValue};border-bottom-left-radius:${varValue}`,
                'ry': `border-top-right-radius:${varValue};border-bottom-right-radius:${varValue}`,
                'tl': `border-top-left-radius:${varValue}`,
                'tr': `border-top-right-radius:${varValue}`,
                'ul': `border-bottom-left-radius:${varValue}`,
                'ur': `border-bottom-right-radius:${varValue}`
            };
            
            if (radiusMap[dir]) {
                rules.push(`.${cls}{${radiusMap[dir]};}`);
            }
            return;
        }

        // 프리픽스 매칭 확인
        for (const [prefix, cssProperty] of Object.entries(validPrefixes)) {
            if (cls.startsWith(prefix + '_')) {
                let value = cls.substring(prefix.length + 1).replace(/_/g, '-');
                
                // zm-index 처리 - 음수 z-index 값 적용
                if (prefix === 'zm-index') {
                    value = '-' + value;
                }
                
                rules.push(`.${cls}{${cssProperty}:${value};}`);
                return;
            }
        }

        // position1~4 처리
        if (/^position([1-4])$/.test(cls)) {
            const positions = {
                '1': 'relative',
                '2': 'absolute',
                '3': 'fixed',
                '4': 'sticky'
            };
            const num = cls.match(/^position([1-4])$/)[1];
            rules.push(`.${cls}{position:${positions[num]};}`);
            return;
        }

        // 기본 박스 처리
        if (cls === 'main_box') {
            rules.push(`.${cls}{width:100%;height:100vh;height:100dvh;}`);
            return;
        }

        // width 관련 처리
        if (cls === 'width_box') {
            rules.push(`.${cls}{width:100%;}`);
            return;
        }
        if (cls === 'width_auto') {
            rules.push(`.${cls}{width:auto;}`);
            return;
        }

        // height 관련 처리
        if (cls === 'height_box') {
            rules.push(`.${cls}{height:100%;}`);
            return;
        }
        if (cls === 'height_auto') {
            rules.push(`.${cls}{height:auto;}`);
            return;
        }

        // overflow 처리
        if (/^overflow_(hidden|visible|scroll|auto)$/.test(cls)) {
            const value = cls.match(/^overflow_(hidden|visible|scroll|auto)$/)[1];
            rules.push(`.${cls}{overflow:${value};}`);
            return;
        }

        // overflow-x 처리
        if (/^overflow_x_(hidden|visible|scroll|auto)$/.test(cls)) {
            const value = cls.match(/^overflow_x_(hidden|visible|scroll|auto)$/)[1];
            rules.push(`.${cls}{overflow-x:${value};}`);
            return;
        }

        // overflow-y 처리
        if (/^overflow_y_(hidden|visible|scroll|auto)$/.test(cls)) {
            const value = cls.match(/^overflow_y_(hidden|visible|scroll|auto)$/)[1];
            rules.push(`.${cls}{overflow-y:${value};}`);
            return;
        }

        // margin auto 처리
        const marginAutoMap = {
            'margin_a_auto': 'margin-top:auto;margin-right:auto;margin-bottom:auto;margin-left:auto',
            'margin_t_auto': 'margin-top:auto',
            'margin_b_auto': 'margin-bottom:auto',
            'margin_u_auto': 'margin-bottom:auto',
            'margin_y_auto': 'margin-top:auto;margin-bottom:auto',
            'margin_l_auto': 'margin-left:auto',
            'margin_r_auto': 'margin-right:auto',
            'margin_x_auto': 'margin-left:auto;margin-right:auto'
        };
        
        if (marginAutoMap[cls]) {
            rules.push(`.${cls}{${marginAutoMap[cls]};}`);
            return;
        }

        // min_width, min_height 처리
        if (/^(min_width|max_width|min_height|max_height)_(\d+)$/.test(cls)) {
            const [, prop, size] = cls.match(/^(min_width|max_width|min_height|max_height)_(\d+)$/);
            const n = parseInt(size);
            
            if (!seenVars.has(n) && !isRootVarAlreadyGenerated(n)) {
                seenVars.add(n);
                rootCss.push(makeRootVar(n));
            }
            
            const cssProp = prop.replace(/_/g, '-');
            rules.push(`.${cls}{${cssProp}:var(--size-${String(n).padStart(3, '0')},${n}px);}`);
            return;
        }

        // 단위가 있는 값 처리 (px, vw, rem 등)
        if (/^(width|height|font)_(px|vw|vh|rem)_(\d+)$/.test(cls)) {
            const [, prop, unit, size] = cls.match(/^(width|height|font)_(px|vw|vh|rem)_(\d+)$/);
            const n = parseInt(size);
            
            if (prop === 'height' && unit === 'vh') {
                // 1080이 100vh이므로, n/10.8이 vh값이 됨
                const vh = (n / 10.8).toFixed(2);
                rules.push(`.${cls}{height:${vh}vh;}`);
                return;
            }
            
            if (!seenVars.has(n) && !isRootVarAlreadyGenerated(n)) {
                seenVars.add(n);
                rootCss.push(makeRootVar(n));
            }
            
            const cssProp = (prop === 'font') ? 'font-size' : prop.replace(/_/g, '-');
            rules.push(`.${cls}{${cssProp}:var(--size-${String(n).padStart(3, '0')},${n}px);}`);
            return;
        }

        // padding/margin/border 처리 (방향 포함)
        if (/^(padding|margin|border)_px-([a-z])_(\d+)$/.test(cls)) {
            const [, prop, dir, size] = cls.match(/^(padding|margin|border)_px-([a-z])_(\d+)$/);
            const n = parseInt(size);
            
            if (!seenVars.has(n) && !isRootVarAlreadyGenerated(n)) {
                seenVars.add(n);
                rootCss.push(makeRootVar(n));
            }
            
            const cssProp = prop.replace(/_/g, '-');
            const varValue = `var(--size-${String(n).padStart(3, '0')},${n}px)`;
            
            const directionMap = {
                'a': prop === 'border' ? 
                    `border-top-width:${varValue};border-top-style:solid;border-bottom-width:${varValue};border-bottom-style:solid;border-left-width:${varValue};border-left-style:solid;border-right-width:${varValue};border-right-style:solid` :
                    `${cssProp}-top:${varValue};${cssProp}-right:${varValue};${cssProp}-bottom:${varValue};${cssProp}-left:${varValue}`,
                'x': prop === 'border' ?
                    `border-left-width:${varValue};border-left-style:solid;border-right-width:${varValue};border-right-style:solid` :
                    `${cssProp}-left:${varValue};${cssProp}-right:${varValue}`,
                'y': prop === 'border' ?
                    `border-top-width:${varValue};border-top-style:solid;border-bottom-width:${varValue};border-bottom-style:solid` :
                    `${cssProp}-top:${varValue};${cssProp}-bottom:${varValue}`,
                'l': prop === 'border' ?
                    `border-left-width:${varValue};border-left-style:solid` :
                    `${cssProp}-left:${varValue}`,
                'r': prop === 'border' ?
                    `border-right-width:${varValue};border-right-style:solid` :
                    `${cssProp}-right:${varValue}`,
                't': prop === 'border' ?
                    `border-top-width:${varValue};border-top-style:solid` :
                    `${cssProp}-top:${varValue}`,
                'u': prop === 'border' ?
                    `border-bottom-width:${varValue};border-bottom-style:solid` :
                    `${cssProp}-bottom:${varValue}`,
                'b': prop === 'border' ?
                    `border-bottom-width:${varValue};border-bottom-style:solid` :
                    `${cssProp}-bottom:${varValue}`
            };
            
            if (directionMap[dir]) {
                rules.push(`.${cls}{${directionMap[dir]};}`);
            }
            return;
        }

        // top-0, bottom-0, left-0, right-0 처리
        const positionProps = ['top', 'bottom', 'left', 'right'];
        for (const prop of positionProps) {
            const regex = new RegExp(`^${prop}-((?:[0-9]+)|(?:0)|(?:[0-9]+per))$`);
            if (regex.test(cls)) {
                const value = cls.match(regex)[1];
                if (value === '0') {
                    rules.push(`.${cls}{${prop}:0;}`);
                } else if (value.includes('per')) {
                    const num = value.replace('per', '');
                    rules.push(`.${cls}{${prop}:${num}%;}`);
                } else {
                    rules.push(`.${cls}{${prop}:${value}px;}`);
                }
                return;
            }
        }

        // blur 처리
        if (/^blur_(\d+)$/.test(cls)) {
            const value = cls.match(/^blur_(\d+)$/)[1];
            rules.push(`.${cls}{backdrop-filter:blur(${value}px);}`);
            return;
        }

        // overflow 처리
        if (/^overflow_(hidden|visible|scroll|auto)$/.test(cls)) {
            const value = cls.match(/^overflow_(hidden|visible|scroll|auto)$/)[1];
            rules.push(`.${cls}{overflow:${value};}`);
            return;
        }

        // overflow-x 처리
        if (/^overflow_x_(hidden|visible|scroll|auto)$/.test(cls)) {
            const value = cls.match(/^overflow_x_(hidden|visible|scroll|auto)$/)[1];
            rules.push(`.${cls}{overflow-x:${value};}`);
            return;
        }

        // overflow-y 처리
        if (/^overflow_y_(hidden|visible|scroll|auto)$/.test(cls)) {
            const value = cls.match(/^overflow_y_(hidden|visible|scroll|auto)$/)[1];
            rules.push(`.${cls}{overflow-y:${value};}`);
            return;
        }
    });

    // CSS 변수가 있을 때만 :root 블록 생성
    const rootBlock = rootCss.length > 0 ? `:root {\n${rootCss.join('')}}\n\n` : '';
    const css = `${rootBlock}${rules.join('\n')}`;
    return css;
}

// 클래스를 받아서 egb_csr_style에 CSS 추가하는 함수
function addEgbCsrStyle(classes) {
    // 이미 생성된 클래스들만 필터링
    const newClasses = classes.filter(className => !isStyleAlreadyGenerated(className));
    
    if (newClasses.length === 0) {
        return; // 새로운 클래스가 없으면 아무것도 하지 않음
    }
    
    const cssContent = egbCsrStyle(newClasses);
    
    // CSS 내용이 비어있으면 추가하지 않음
    if (!cssContent || cssContent.trim() === '') {
        return;
    }
    
    let styleElement = document.getElementById('egb_csr_style');
    if (!styleElement) {
        styleElement = document.createElement('style');
        styleElement.id = 'egb_csr_style';
        document.head.appendChild(styleElement);
    }
    
    // 기존 CSS에 새로운 CSS를 추가 (덮어쓰지 않음)
    if (styleElement.textContent) {
        styleElement.textContent += '\n' + cssContent;
    } else {
        styleElement.textContent = cssContent;
    }
    
    // 새로 생성된 클래스들을 캐시에 추가
    newClasses.forEach(className => {
        generatedStylesCache.add(className);
    });
}

// 이미 생성된 스타일을 확인하는 함수
function isStyleAlreadyGenerated(className) {
    // 캐시에서 먼저 확인
    if (generatedStylesCache.has(className)) {
        return true;
    }
    
    const ssrStyle = document.getElementById('egb_ssr_style');
    const csrStyle = document.getElementById('egb_csr_style');
    
    // SSR 스타일에서 확인 (정확한 클래스 매칭)
    if (ssrStyle && ssrStyle.textContent.includes(`.${className}{`)) {
        generatedStylesCache.add(className);
        return true;
    }
    
    // CSR 스타일에서 확인 (정확한 클래스 매칭)
    if (csrStyle && csrStyle.textContent.includes(`.${className}{`)) {
        generatedStylesCache.add(className);
        return true;
    }
    
    return false;
}

// CSS 변수가 이미 생성되었는지 확인하는 함수
function isRootVarAlreadyGenerated(size) {
    const varName = `--size-${String(size).padStart(3, '0')}`;
    const ssrStyle = document.getElementById('egb_ssr_style');
    const csrStyle = document.getElementById('egb_csr_style');
    
    // SSR 스타일에서 확인
    if (ssrStyle && ssrStyle.textContent.includes(`${varName}:`)) {
        return true;
    }
    
    // CSR 스타일에서 확인
    if (csrStyle && csrStyle.textContent.includes(`${varName}:`)) {
        return true;
    }
    
    return false;
}

// 클래스 검사 함수 - 이미 생성된 스타일은 통과, 새로운 클래스는 콘솔로그 
function checkEgbClasses(classes) {
    classes.forEach(className => {
        // 이미 생성된 스타일인지 확인
        if (!isStyleAlreadyGenerated(className)) {
            console.log('새로운 EGB 클래스 발견:', className);
        }
    });
}

// 노드의 클래스를 분석하고 처리하는 함수
function analyzeNodeClasses(node) {
    if (!node || !node.classList) return;
    
    const classes = Array.from(node.classList);
    
    // EGB 클래스 패턴 정의 (정확한 EGB 클래스만 매칭)
    const egbPatterns = {
        // 기본 텍스트 관련
        line_height: /^line_height_\d+$/,
        word_spacing: /^word_spacing_\d+$/,
        letter_spacing: /^letter_spacing_\d+$/,
        
        // display 관련
        display: /^display_(block|none|flex|contents|flow|flow_root|inline|inline_block|inline_grid|inline_flex|inline_table|list_item|table|table_caption|table_cell|table_column|table_column_group|table_header_group|table_footer_group|table_row|table_row_group|off)$/,
        
        // 색상 관련
        color: /^color[-_][0-9A-Fa-f]{6}$/,
        bgColor: /^bg-color-[0-9A-Fa-f]{6}$/i,
        borderColor: /^bd-[a-z]-color-[0-9A-Fa-f]{6}$/i,
        
        // position 관련
        position: /^position[1-4]$/,
        positionProps: /^(top|bottom|left|right)-((?:[0-9]+)|(?:0)|(?:[0-9]+per))$/,
        
        // 크기 관련
        width: /^width_(px|vw|vh|rem)_\d+$|^width_(box|auto|none|off)$/,
        height: /^height_(px|vw|vh|rem)_\d+$|^height_(box|auto|none|off)$/,
        minWidth: /^min_width_\d+$/,
        maxWidth: /^max_width_\d+$/,
        minHeight: /^min_height_\d+$/,
        maxHeight: /^max_height_\d+$/,
        
        // 폰트 관련
        font: /^font_(px|vw|rem)_\d+$/,
        fontWeight: /^flv[1-9]$/,
        
        // padding/margin/border 관련
        padding: /^padding_(px|vw)-[a-z]_(\d+)$/,
        margin: /^margin_(px|vw)-[a-z]_(\d+)$|^margin_[a-z]_auto$/,
        border: /^border_(px|vw)-[a-z]_(\d+)$/,
        borderRadius: /^border_bre-[a-z]+_\d+$/,
        
        // 기타 속성들
        overflow: /^overflow_(hidden|visible|scroll|auto)$/,
        overflowX: /^overflow_x_(hidden|visible|scroll|auto)$/,
        overflowY: /^overflow_y_(hidden|visible|scroll|auto)$/,
        zIndex: /^z_index_\d+$|^z-index_\d+$|^zm-index_\d+$/,
        opacity: /^o_\d+$/,
        cursor: /^cursor_(pointer|default|text|move|not-allowed|grab|grabbing)$/,
        

        
        // CSS 프리픽스 매칭 (정확한 속성만)
        cssPrefix: /^(align_content|align_self|animation_delay|animation_direction|animation_duration|animation_fill_mode|animation_iteration_count|animation_name|animation_play_state|animation_timing_function|background_attachment|background_clip|background_image|background_position|background_repeat|background_size|border_collapse|border_spacing|border_style|border_width|box_shadow|box_sizing|font_family|font_style|text_align|text_decoration|text_transform|transform|transition|vertical_align|visibility|white_space|word_break|word_spacing)_/,
        
        // 특수 클래스들
        mainBox: /^main_box$/,
        blur: /^blur_\d+$/,
        
        // 기타 숫자값을 가지는 속성들 (더 구체적으로)
        numeric: /^(width|height|font|padding|margin|border|min_width|max_width|min_height|max_height|line_height|word_spacing|letter_spacing|z_index|z-index|zm-index|o|blur)_\d+$/
    };

    // 패턴에 매칭되는 클래스들만 필터링
    const egbClasses = classes.filter(className => {
        return Object.values(egbPatterns).some(pattern => pattern.test(className));
    });

    if (egbClasses.length > 0) {
        checkEgbClasses(egbClasses);
        addEgbCsrStyle(egbClasses);
    }
}


// egb 콜백 함수: DOM 변화가 있을 때 실행
const egbCallback = (egbMutationsList, egbObserver) => {
    egbMutationsList.forEach(egbMutation => {
        if (egbMutation.type === 'childList') {
            // 자식 노드가 추가된 경우 처리
            if (egbMutation.addedNodes.length > 0) {
                egbMutation.addedNodes.forEach(childNode => {
                    // 노드를 재귀적으로 처리하는 함수 정의
                    const processNode = (egbNode) => {
                        if (egbNode.nodeType === 1 && !IGNORE_NODE_NAMES.includes(egbNode.nodeName.toUpperCase())) {
                            // egb_masonry 요소 감지 및 초기화
                            if (egbNode.id === 'egb_masonry') {
                                if (!window.EGB || !window.EGB.masonry) {
                                    // 스크립트가 로드되지 않은 경우 로드
                                    const script = document.createElement('script');
                                    script.src = '/js/egb_masonry';
                                    script.onload = () => {
                                        window.EGB.masonry.init();
                                    };
                                    document.head.appendChild(script);
                                } else {
                                    setTimeout(() => window.EGB.masonry.init(), 100);
                                }
                            }
                            
                            // 스크립트 로드 확인 및 처리 (egbAnalyzeNodeAndAddEvents 내부에서 처리됨)
                            egbAnalyzeNodeAndAddEvents(egbNode);
                            analyzeNodeClasses(egbNode); // 클래스 분석 추가
                            
                            // 자식 노드들을 재귀적으로 처리
                            if (egbNode.hasChildNodes()) {
                                egbNode.childNodes.forEach(child => {
                                    processNode(child);
                                });
                            }
                        }
                    };
                    // 현재 노드와 그 자손들을 처리
                    processNode(childNode);
                });
            }
        } else if (egbMutation.type === 'attributes') {
            const egbNode = egbMutation.target;
            const attributeName = egbMutation.attributeName;

            if (attributeName === 'class') {
                egbAnalyzeNodeClasses(egbNode);
                analyzeNodeClasses(egbNode);
            } else if (attributeName.startsWith('egb:') || 
                     attributeName.startsWith('data-')) {
                egbAnalyzeNodeAndAddEvents(egbNode);
            }
        }
    });
};

// 이벤트 핸들러 함수들
function handleSubmit(e) {
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (form.classList.contains('egb_no_submit')) return;

    e.preventDefault();
    e.stopImmediatePropagation();

    if (form.dataset.submitting === 'true') return;
    form.dataset.submitting = 'true';

    const loading = document.getElementById('egb_form_loading');
    loading?.classList.remove('display_off');

    const fd = new FormData(form);
    const hooks = dataHooks.get(form.id) || [];
    hooks.forEach(fn => fn(fd));

    EGB.ajax.request({
        url: form.action || window.location.pathname,
        method: form.method || 'POST',
        data: fd,
        contentType: false,
        processData: false,
        dataType: 'json',
        // 캐시 방지 설정
        cache: false,
        headers: {
            'Cache-Control': 'no-cache, no-store, must-revalidate',
            'Pragma': 'no-cache',
            'Expires': '0'
        },
        success: res => egbsuccessCode(res),
        failure: err => egbFailureCode(err),
        error: err => egbErrorCode(err),
        complete: () => {
            loading?.classList.add('display_off');
            delete form.dataset.submitting;
            egbCompleteCode(form.id);
        }
    });
}

function handleClick(e) {
    const btn = e.target.closest('.egb_submit, input[type=submit]');
    if (!btn) return;
    const form = btn.closest('form');
    form?.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
}

function handleChange(e) {
    const el = e.target;
    if (el.matches('select.select_submit, input[type=radio].radio_submit, input[type=file].file_submit, input[type=checkbox].checkbox_submit')) {
        const form = el.closest('form');
        form?.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
    }
}

function handleInput(e) {
    const el = e.target;
    if (el.matches('input[type=text].text_change_submit, input[type=number].number_change_submit')) {
        const form = el.closest('form');
        if (!form) return;

        const key = form.id + '::' + (el.name || el.className);
        clearTimeout(debounceTimers.get(key));
        debounceTimers.set(key, setTimeout(() => {
            form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
            debounceTimers.delete(key);
        }, 300));
    }
}

// 이벤트 리스너 등록
document.addEventListener('submit', handleSubmit, true);
document.addEventListener('click', handleClick);
document.addEventListener('change', handleChange);
document.addEventListener('input', handleInput);

// egb MutationObserver 인스턴스를 생성하고 대상 노드를 감시
const egbObserver = new MutationObserver(egbCallback);
egbObserver.observe(egbTargetNode, egbConfig);

// 페이지 정리를 위해 beforeunload와 visibilitychange 이벤트 모두 사용
window.addEventListener('beforeunload', cleanup);
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState === 'hidden') {
        cleanup();
    }
});

function cleanup() {
    egbObserver.disconnect();
    document.removeEventListener('submit', handleSubmit, true); 
    document.removeEventListener('click', handleClick);
    document.removeEventListener('change', handleChange);
    document.removeEventListener('input', handleInput);
    debounceTimers.forEach(timer => clearTimeout(timer));
    debounceTimers.clear();
    dataHooks.clear();
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

const egbLoadingTemplates = new Set(); // 로딩 중인 템플릿
const egbLoadedTemplates = new Set();  // 이미 로드된 템플릿

async function egbT(targetElementId, egbHref, shouldRemoveTemplate = false) {
  // egbHref를 egbOriginDomain과 egbThemesName을 이용해 설정
  egbHref = `${egbOriginDomain}/template/?${egbHref}`;

  // egbHref에서 id 값을 추출하여 확인
  const urlParams = new URLSearchParams(egbHref.split('?')[1]);
  const templateId = urlParams.get('id');

  if (!templateId) {
    console.error('템플릿 ID가 필요합니다.');
    return;
  }

  // 이미 로드된 템플릿인지 확인
  if (egbLoadedTemplates.has(templateId)) {
    console.log(`템플릿 ID ${templateId}는 이미 로드된 상태입니다.`);
    return;
  }

  // 이미 해당 템플릿을 불러오는 중인지 확인
  if (egbLoadingTemplates.has(templateId)) {
    console.log(`템플릿 ID ${templateId}가 이미 로드 중입니다. 요청을 무시합니다.`);
    return;
  }

  // 로드 중인 템플릿에 추가
  egbLoadingTemplates.add(templateId);

  // 로딩 페이지 표시
  toggleLoading(true);

  let attemptCount = 0; // 재시도 카운터

  while (attemptCount < 10) { // 최대 10회 시도
    try {
      attemptCount++;
      console.log(`템플릿 ID ${templateId} 로드 시도 중... (${attemptCount}/10)`);

      let egbText;

      // Axios, fetch, XMLHttpRequest 순서로 요청 시도
      if (window.axios) {
        console.log('Axios를 사용하여 템플릿 로드 중...');
        const egbResponse = await axios.get(egbHref, { withCredentials: true });
        egbText = egbResponse.data;
      } else if (window.fetch) {
        console.log('fetch를 사용하여 템플릿 로드 중...');
        const egbResponse = await fetch(egbHref, { credentials: 'include' });
        if (!egbResponse.ok) {
          throw new Error(`서버 응답 오류: ${egbResponse.status}`);
        }
        egbText = await egbResponse.text();
      } else {
        console.log('XMLHttpRequest를 사용하여 템플릿 로드 중...');
        egbText = await new Promise((resolve, reject) => {
          const xhr = new XMLHttpRequest();
          xhr.open('GET', egbHref, true);
          xhr.withCredentials = true;
          xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
              resolve(xhr.responseText);
            } else {
              reject(new Error(`서버 응답 오류: ${xhr.status}`));
            }
          };
          xhr.onerror = function () {
            reject(new Error('네트워크 오류 발생'));
          };
          xhr.send();
        });
      }

      // 현재 문서에서 targetElement를 찾음
      const egbCurrentTargetElement = document.getElementById(targetElementId);
      if (!egbCurrentTargetElement) {
        throw new Error('대상 요소를 찾을 수 없습니다.');
      }

      // 서버에서 받은 콘텐츠를 파싱하여 템플릿 요소 가져오기
      const egbParser = new DOMParser();
      const egbDoc = egbParser.parseFromString(egbText, 'text/html');
      const egbTemplateElement = egbDoc.querySelector('template');

      if (!egbTemplateElement) {
        throw new Error('서버에서 받은 콘텐츠에 템플릿 요소를 찾을 수 없습니다.');
      }

      // 받은 템플릿을 현재 문서에 추가하여 저장
      document.body.appendChild(egbTemplateElement);

      // 타겟 요소의 기존 내용 비우기
      egbCurrentTargetElement.innerHTML = '';

      // 템플릿의 내용 가져오기
      const egbNewNodes = Array.from(egbTemplateElement.content.childNodes);

      // 노드를 하나씩 타겟 요소에 추가하며 지연 효과 적용
      for (const egbNewNode of egbNewNodes) {
        egbCurrentTargetElement.appendChild(egbNewNode.cloneNode(true));
        await new Promise(resolve => setTimeout(resolve, 50));
      }

      // 템플릿 사용 후 삭제 여부 확인
      if (shouldRemoveTemplate) {
        egbTemplateElement.remove();
        console.log(`템플릿 ID ${templateId}가 사용 후 삭제되었습니다.`);
      } else {
        egbLoadedTemplates.add(templateId); // 성공적으로 로드된 템플릿으로 추가
      }

      console.log(`템플릿 ID ${templateId}가 성공적으로 로드되었습니다.`);
      break; // 성공하면 반복문 탈출
    } catch (error) {
      console.error(`템플릿 로드 중 오류 발생 (${attemptCount}/10):`, error);
      if (attemptCount < 10) {
        console.log(`1초 후 다시 시도합니다...`);
        await new Promise(resolve => setTimeout(resolve, 1000)); // 1초 대기
      } else {
        console.error(`최대 재시도 횟수에 도달했습니다. 템플릿 로드를 중단합니다.`);
      }
    }
  }

  // 로드 완료 후 템플릿 ID 제거
  egbLoadingTemplates.delete(templateId);
  // 로딩 페이지 숨기기
  toggleLoading(false);
}


async function egbTc(targetElementId, egbHref, shouldRemoveTemplate = false) {
  // egbHref를 egbOriginDomain과 egbThemesName을 이용해 설정
  egbHref = `${egbOriginDomain}/template/?${egbHref}`;

  // egbHref에서 id 값을 추출하여 확인
  const urlParams = new URLSearchParams(egbHref.split('?')[1]);
  const templateId = urlParams.get('id');

  if (!templateId) {
    console.error('템플릿 ID가 필요합니다.');
    return;
  }

  // 이미 로드된 템플릿인지 확인
  if (egbLoadedTemplates.has(templateId)) {
    console.log(`템플릿 ID ${templateId}는 이미 로드된 상태입니다.`);
    return;
  }

  // 이미 해당 템플릿을 불러오는 중인지 확인
  if (egbLoadingTemplates.has(templateId)) {
    console.log(`템플릿 ID ${templateId}가 이미 로드 중입니다. 요청을 무시합니다.`);
    return;
  }

  // 로드 중인 템플릿에 추가
  egbLoadingTemplates.add(templateId);

  // 로딩 페이지 표시
  toggleLoading(true);

  try {
    let egbText;

    // Axios, fetch, XMLHttpRequest 순서로 요청 시도
    if (window.axios) {
      console.log('Axios를 사용하여 템플릿 로드 중...');
      const egbResponse = await axios.get(egbHref, { withCredentials: true });
      egbText = egbResponse.data;
    } else if (window.fetch) {
      console.log('fetch를 사용하여 템플릿 로드 중...');
      const egbResponse = await fetch(egbHref, { credentials: 'include' });
      if (!egbResponse.ok) {
        throw new Error(`서버 응답 오류: ${egbResponse.status}`);
      }
      egbText = await egbResponse.text();
    } else {
      console.log('XMLHttpRequest를 사용하여 템플릿 로드 중...');
      egbText = await new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', egbHref, true);
        xhr.withCredentials = true;
        xhr.onload = function () {
          if (xhr.status >= 200 && xhr.status < 300) {
            resolve(xhr.responseText);
          } else {
            reject(new Error(`서버 응답 오류: ${xhr.status}`));
          }
        };
        xhr.onerror = function () {
          reject(new Error('네트워크 오류 발생'));
        };
        xhr.send();
      });
    }

    // 현재 문서에서 targetElement를 찾음
    const egbCurrentTargetElement = document.getElementById(targetElementId);
    if (!egbCurrentTargetElement) {
      throw new Error('대상 요소를 찾을 수 없습니다.');
    }

    // 서버에서 받은 콘텐츠를 파싱하여 템플릿 요소 가져오기
    const egbParser = new DOMParser();
    const egbDoc = egbParser.parseFromString(egbText, 'text/html');
    const egbTemplateElement = egbDoc.querySelector('template');

    if (!egbTemplateElement) {
      throw new Error('서버에서 받은 콘텐츠에 템플릿 요소를 찾을 수 없습니다.');
    }

    // 받은 템플릿을 현재 문서에 추가하여 저장
    document.body.appendChild(egbTemplateElement);

    // 템플릿의 내용 가져오기
    const egbNewNodes = Array.from(egbTemplateElement.content.childNodes);

    // 노드를 하나씩 타겟 요소에 추가하며 지연 효과 적용
    for (const egbNewNode of egbNewNodes) {
      egbCurrentTargetElement.appendChild(egbNewNode.cloneNode(true));
      await new Promise(resolve => setTimeout(resolve, 50));
    }

    // 템플릿 사용 후 삭제 여부 확인
    if (shouldRemoveTemplate) {
      egbTemplateElement.remove();
      console.log(`템플릿 ID ${templateId}가 사용 후 삭제되었습니다.`);
    } else {
      egbLoadedTemplates.add(templateId); // 성공적으로 로드된 템플릿으로 추가
    }

    console.log(`템플릿 ID ${templateId}가 성공적으로 로드되었습니다.`);
  } catch (error) {
    console.error('템플릿 로드 중 오류 발생. 다시 시도합니다:', error);
    await new Promise(resolve => setTimeout(resolve, 1000)); // 1초 대기 후 재시도
  } finally {
    // 로드 완료 후 템플릿 ID 제거
    egbLoadingTemplates.delete(templateId);
    toggleLoading(false);
  }
}

function toggleLoading(show) {
  document.querySelectorAll('.egb_loading').forEach(el =>
    el.classList.toggle('display_off', !show)
  );
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

//class로 함수 실행
document.addEventListener('DOMContentLoaded', () => {
  // 페이지 로드 시 기존 요소들의 클래스 분석
  document.querySelectorAll('[class]').forEach(el => {
    analyzeNodeClasses(el);
  });
  
  // 페이지 로드 시 기존 요소들의 egb: 속성 및 data-xx, data-yy, 색상, 테두리, position 속성 분석
  document.querySelectorAll('*').forEach(el => {
    if (Array.from(el.attributes).some(attr => 
      attr.name.startsWith('egb:') || 
      attr.name === 'data-xx' || 
      attr.name === 'data-yy' ||
      attr.name === 'data-color' ||
      attr.name === 'data-hover-color' ||
      attr.name === 'data-bg-color' ||
      attr.name === 'data-hover-bg-color' ||
      (attr.name.startsWith('data-bd-') && attr.name.endsWith('-color')) ||
      (attr.name.startsWith('data-hover-bd-') && attr.name.endsWith('-color')) ||
      ['data-top', 'data-bottom', 'data-left', 'data-right'].includes(attr.name)
    )) {
      egbAnalyzeNodeAndAddEvents(el);
    }
  });
  
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
  
  // 벽돌 레이아웃은 별도 모듈로 분리됨 (egb_masonry.js)
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////

// 벽돌 레이아웃 관련 코드는 egb_masonry.js 모듈로 분리됨





JS . "\n</script>";
}
?>