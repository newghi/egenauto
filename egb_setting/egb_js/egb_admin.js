EGB.function.loadScript("https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js", "egbaxios", function () {
});

function egbInitializeMenu(name = 'setting') {
    const menuItems = document.querySelectorAll('.site_' + name + '_menu');

    menuItems.forEach(item => {
        item.addEventListener('click', function (event) {
            // 모든 메뉴에서 active, flv6 클래스를 제거합니다.
            menuItems.forEach(menu => menu.classList.remove('active', 'flv6'));

            // 클릭된 메뉴에만 active, flv6 클래스를 추가합니다.
            event.currentTarget.classList.add('active', 'flv6');

            // ID의 숫자를 추출하여 처리
            const menuNumber = event.currentTarget.id.split('_').pop(); // 숫자 부분 추출

            // 동적으로 추가적인 처리를 여기에 수행 (필요 시)
            // 예를 들어, 메뉴 번호를 통해 무언가를 동적으로 할 수 있음.
            // 현재는 숫자에 따라 기본적인 동작만 유지.
        });
    });
}

// 전체 화면 전환 시 실행되는 함수들 (필요에 따라 정의되지 않을 수 있음)
// egbFullScreenTrue, egbFullScreenFalse 함수들은 프로젝트마다 필요에 의해 생성
function egbFullScreenTrue() {
    const maxSizeElement = document.querySelector(".maxsize");
    const minSizeElement = document.querySelector(".minisize");

    if (maxSizeElement) {
        maxSizeElement.classList.add("display_none");
    }
    if (minSizeElement) {
        minSizeElement.classList.remove("display_none");
    }
}

function egbFullScreenFalse() {
    const minSizeElement = document.querySelector(".minisize");
    const maxSizeElement = document.querySelector(".maxsize");

    if (minSizeElement) {
        minSizeElement.classList.add("display_none");
    }
    if (maxSizeElement) {
        maxSizeElement.classList.remove("display_none");
    }
}


const folders = document.querySelectorAll('.selected_folder');

// 폴더 클릭 이벤트 설정
folders.forEach(function (folder) {
    folder.addEventListener('click', function (event) {
        event.stopPropagation(); // 이벤트가 상위로 전파되지 않도록 방지

        // 클릭된 폴더가 이미 선택된 경우
        if (this.classList.contains('selected_folder_color')) {
            // 클릭된 폴더와 연결된 setting_box의 클래스 찾기
            const relatedClass = this.className.split(' ').find(className => className.startsWith('cm_'));
            if (relatedClass) {
                const settingBox = document.querySelector(`.setting_box.cf_${relatedClass.substring(3)}`); // 관련된 setting_box 선택
                if (settingBox) {
                    settingBox.classList.remove('display_off');
                    updateZIndex(settingBox);
                }
            }
        } else {
            // 모든 폴더에서 selected_folder_color 클래스 제거
            folders.forEach(function (f) {
                f.classList.remove('selected_folder_color');
            });

            // 클릭한 폴더에만 클래스 추가
            this.classList.add('selected_folder_color');
        }
    });
});


// 문서 전체에 클릭 이벤트 추가
document.addEventListener('click', function () {
    folders.forEach(function (folder) {
        folder.classList.remove('selected_folder_color');
    });
});

function initializeAdminSettingBox(adminSettingBox) {
    if (!adminSettingBox) return;
    const initialWidth = adminSettingBox.offsetWidth;
    const initialHeight = adminSettingBox.offsetHeight;

    // 1px씩 크기를 증가
    adminSettingBox.style.width = (initialWidth + 50) + 'px';
    adminSettingBox.style.height = (initialHeight + 50) + 'px';

    // 짧은 시간 뒤 원래 크기로 되돌림
    setTimeout(function () {
        adminSettingBox.style.width = initialWidth + 'px';
        adminSettingBox.style.height = initialHeight + 'px';
    }, 50); // 50ms 뒤에 원래 크기로 되돌림 (시간은 필요에 따라 조정 가능)
}

function toggleFullWindow(adminSettingBox) {
    if (!adminSettingBox) return;
    const isFullWindow = adminSettingBox.classList.contains('fullwindow');

    if (isFullWindow) {
        // fullwindow 클래스 제거
        adminSettingBox.classList.remove('fullwindow');
        adminSettingBox.style.position = 'absolute';
        adminSettingBox.style.top = adminSettingBox.dataset.originalTop;
        adminSettingBox.style.left = adminSettingBox.dataset.originalLeft;
        adminSettingBox.style.width = adminSettingBox.dataset.originalWidth;
        adminSettingBox.style.height = adminSettingBox.dataset.originalHeight;
    } else {
        // 현재 위치와 크기를 저장
        adminSettingBox.dataset.originalTop = adminSettingBox.style.top;
        adminSettingBox.dataset.originalLeft = adminSettingBox.style.left;
        adminSettingBox.dataset.originalWidth = adminSettingBox.style.width;
        adminSettingBox.dataset.originalHeight = adminSettingBox.style.height;

        // fullwindow 클래스 추가
        adminSettingBox.classList.add('fullwindow');
        adminSettingBox.style.position = 'fixed';
        adminSettingBox.style.top = '0';
        adminSettingBox.style.left = '0';
        adminSettingBox.style.width = '100vw';
        adminSettingBox.style.height = '100vh';
    }
}

function updateZIndex(settingBox) {
    // 모든 setting_box 요소의 z-index를 5로 초기화
    document.querySelectorAll('.setting_box').forEach(box => {
        box.classList.remove('z-index_6');
        box.classList.remove('z-index_7');
        box.classList.add('z-index_5');
    });

    // 클릭된 setting_box 요소의 z-index를 6으로 설정
    settingBox.classList.remove('z-index_5');
    settingBox.classList.add('z-index_6');
}

let isDragging = false;
let isResizing = false;
let activeBox = null;
let offsetX = 0, offsetY = 0;

// 이벤트 위임을 사용하여 menu_box 드래그 기능 처리
document.addEventListener('mousedown', function (e) {
    const adminSettingBox = e.target.closest('.admin_setting_box');
    const menuBox = e.target.closest('.menu_box');
    const settingBox = e.target.closest('.setting_box');
    if (menuBox && adminSettingBox && !isResizing) { // 크기 조절 중이 아닐 때만 드래그 시작
        isDragging = true;
        activeBox = adminSettingBox;
        offsetX = e.clientX - adminSettingBox.getBoundingClientRect().left;
        offsetY = e.clientY - adminSettingBox.getBoundingClientRect().top;
        updateZIndex(settingBox); // z-index 업데이트
        e.stopPropagation(); // 이벤트 전파 방지
    }
});

document.addEventListener('mousemove', function (e) {
    if (isDragging && activeBox) {
        activeBox.style.left = (e.clientX - offsetX) + 'px';
        activeBox.style.top = (e.clientY - offsetY) + 'px';
    } else if (isResizing && activeBox) {
        const width = e.clientX - activeBox.getBoundingClientRect().left;
        const height = e.clientY - activeBox.getBoundingClientRect().top;
        activeBox.style.width = (width) + 'px';
        activeBox.style.height = (height) + 'px';
    }
});

document.addEventListener('mouseup', function () {
    // 드래그와 크기 조절 상태를 초기화
    isDragging = false;
    isResizing = false;
    activeBox = null;
});

// 크기 조절 기능 (resize_border를 동적으로 추가할 수도 있으므로 이벤트 위임 사용)
document.addEventListener('mousedown', function (e) {
    const resizeBorder = e.target.classList.contains('resize_border');
    const adminSettingBox = e.target.closest('.admin_setting_box');
    const settingBox = e.target.closest('.setting_box');
    if (resizeBorder && adminSettingBox && !isDragging) { // 드래그 중이 아닐 때만 크기 조절 시작
        isResizing = true;
        activeBox = adminSettingBox;
        updateZIndex(settingBox); // z-index 업데이트
        e.stopPropagation(); // 드래그 이벤트와 겹치지 않도록 방지
    }
});

// 내부의 다른 요소를 클릭했을 때 드래그 방지 (이벤트 위임 사용)
document.addEventListener('mousedown', function (e) {
    if (e.target.closest('.egb_setting_content')) {
        e.stopPropagation();
    }
});

// 마우스 오른쪽 클릭 메뉴 처리 (이벤트 위임 사용)
document.addEventListener('contextmenu', (event) => {
    const contextMenu = document.querySelector('.mouse_right_click');
    if (!contextMenu) return;

    event.preventDefault(); // 기본 브라우저 메뉴 방지

    const { clientX: mouseX, clientY: mouseY } = event;
    const menuWidth = contextMenu.offsetWidth;
    const menuHeight = contextMenu.offsetHeight;
    const parentElement = contextMenu.parentElement;
    const parentRect = parentElement.getBoundingClientRect();

    // 메뉴 위치 설정
    let posX = mouseX - parentRect.left;
    let posY = mouseY - parentRect.top;

    // 부모 요소의 오른쪽/아래쪽으로 나가는 경우 위치 조정
    if (posX + menuWidth > parentRect.width) {
        posX = parentRect.width - menuWidth;
    }

    if (posY + menuHeight > parentRect.height) {
        posY = parentRect.height - menuHeight;
    }

    // 부모 요소의 왼쪽/위쪽으로 나가는 경우 위치 조정
    if (posX < 0) {
        posX = 0;
    }

    if (posY < 0) {
        posY = 0;
    }

    contextMenu.style.top = `${posY}px`;
    contextMenu.style.left = `${posX}px`;
    contextMenu.style.display = 'block';
});

// 마우스 클릭 시 메뉴 숨기기
document.addEventListener('click', () => {
    const contextMenu = document.querySelector('.mouse_right_click');
    if (contextMenu) {
        contextMenu.style.display = 'none';
    }
});

// 메뉴 항목에 마우스오버 이벤트 추가 (이벤트 위임 사용)
document.addEventListener('mouseover', (e) => {
    const item = e.target.closest('.mouse_right_click li');
    if (item) {
        const hoverBgColor = item.getAttribute('data-hover-bg-color');
        if (hoverBgColor) {
            item.style.backgroundColor = hoverBgColor;
        }
    }
});

document.addEventListener('mouseout', (e) => {
    const item = e.target.closest('.mouse_right_click li');
    if (item) {
        item.style.backgroundColor = '';
    }
});

// MutationObserver를 사용하여 동적으로 추가된 요소에 이벤트 핸들러 적용
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        mutation.addedNodes.forEach((node) => {
            if (node.nodeType === 1) { // ELEMENT_NODE 확인
                if (node.classList.contains('admin_setting_box')) {
                    // adminSettingBox가 동적으로 추가될 때 초기화 코드 실행
                    initializeAdminSettingBox(node);
                }                // 'details' 요소가 추가될 경우, QnA 인스턴스 적용
                if (node.tagName.toLowerCase() === 'details') {
                    new QnA(node);
                }

                // 추가된 노드 내에 'details' 요소가 있는 경우 처리
                const detailsElements = node.querySelectorAll('details');
                detailsElements.forEach((detailsElement) => {
                    if (!detailsElement.qnaInstance) {
                        detailsElement.qnaInstance = new QnA(detailsElement);
                    }
                });
            }
        });
    });
});

observer.observe(document.body, { childList: true, subtree: true });

// 초기 설정
document.querySelectorAll('.admin_setting_box').forEach(initializeAdminSettingBox);

// 화면 최대화 버튼 클릭 처리
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('min_maxwindow_button')) {
        const adminSettingBox = e.target.closest('.admin_setting_box');
        const settingBox = e.target.closest('.setting_box');
        updateZIndex(settingBox); // z-index 업데이트
        toggleFullWindow(adminSettingBox);
    }
});

// menu_box 더블 클릭 시 화면 최대화 처리
document.addEventListener('dblclick', function (e) {
    if (e.target.classList.contains('menu_box')) {
        const adminSettingBox = e.target.closest('.admin_setting_box');
        const settingBox = e.target.closest('.setting_box');
        updateZIndex(settingBox); // z-index 업데이트
        toggleFullWindow(adminSettingBox);
    }
});

const maximumWindowMode = document.querySelector('.maximum_window_mode');

// 초기 위치 설정을 위한 함수
function keepInView() {
    const rect = maximumWindowMode.getBoundingClientRect();
    const windowHeight = window.innerHeight;
    const windowWidth = window.innerWidth;

    // 요소의 현재 top과 left 값을 가져옵니다
    let currentTop = parseFloat(getComputedStyle(maximumWindowMode).top);
    let currentLeft = parseFloat(getComputedStyle(maximumWindowMode).left);

    // 상단 경계 체크
    if (rect.top < 0) {
        currentTop -= rect.top; // 화면 밖으로 벗어난 만큼 더합니다
    }
    // 하단 경계 체크
    if (rect.bottom > windowHeight) {
        currentTop -= (rect.bottom - windowHeight); // 화면 아래로 벗어난 만큼 뺍니다
    }
    // 왼쪽 경계 체크
    if (rect.left < 0) {
        currentLeft -= rect.left; // 화면 밖으로 벗어난 만큼 더합니다
    }
    // 오른쪽 경계 체크
    if (rect.right > windowWidth) {
        currentLeft -= (rect.right - windowWidth); // 화면 오른쪽으로 벗어난 만큼 뺍니다
    }

    // 수정된 위치를 적용
    maximumWindowMode.style.top = `${currentTop}px`;
    maximumWindowMode.style.left = `${currentLeft}px`;
}

// 스크롤 및 리사이즈 이벤트에 따라 위치 유지 (디바운스/스로틀 직접 구현)
function throttle(func, limit) {
    let inThrottle;
    return function () {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

const throttledKeepInView = throttle(keepInView, 100);
window.addEventListener('scroll', throttledKeepInView);
window.addEventListener('resize', throttledKeepInView);

// 페이지 로드 시 초기 위치 체크
window.addEventListener('load', keepInView);

