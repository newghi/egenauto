// 슬라이더 초기화 상태를 관리하기 위한 WeakMap
const initializedSliders = new WeakMap();
// 슬라이더를 초기화하는 함수
function initializeSlider(sliderMainBox) {
    // 중복 초기화 방지
    if (initializedSliders.has(sliderMainBox)) return;
    initializedSliders.set(sliderMainBox, true);

    // 1. "슬라이드 준비중..." 메시지를 가져오기
    const loadingElement = sliderMainBox.querySelector(".slide_egb_loading");

    if (loadingElement) {
        // 페이드 아웃 효과 추가
        loadingElement.classList.remove('visibility_visible');
        loadingElement.classList.remove('o_10');
        loadingElement.classList.add('visibility_hidden');
        loadingElement.classList.add('o_0');

        // DOM에서 제거
        setTimeout(() => {
            if (loadingElement && loadingElement.parentNode) {
                loadingElement.parentNode.removeChild(loadingElement);
            }
        }, 500); // 0.5초 후에 삭제 (트랜지션 시간과 맞추기)
    }

    // 상위 슬라이더가 아닌 하위 슬라이더가 중복 처리되지 않도록 컨테이너 범위 설정
    const sliderBox = sliderMainBox.querySelector(":scope > .slide_egb_box");
    if (!sliderBox) return;

    const sliderWrapper = sliderBox.querySelector(":scope > .slide_egb_wrapper");
    let slideItems = Array.from(sliderWrapper.querySelectorAll(":scope > .slide_egb_item"));

    // 데이터 속성 파싱
    const autoSlide = sliderBox.getAttribute("data-slide-egb-auto") || "off";
    const loopSlide = sliderBox.getAttribute("data-slide-egb-loop") || "off";
    let slidesToView = parseInt(sliderBox.getAttribute("data-slide-egb-view"), 10) || 1;
    let slidesToMove = parseInt(sliderBox.getAttribute("data-slide-egb-move"), 10) || 1;
    let gapBetweenSlides = parseInt(sliderBox.getAttribute("data-slide-egb-gap"), 10) || 0;
    let directionAttr = sliderBox.getAttribute("data-slide-egb-direction") || "left";

    const slideSpeed = parseInt(sliderBox.getAttribute("data-slide-egb-speed"), 10) || 3000; // 슬라이드 이동 속도
    const transitionSpeed = parseInt(sliderBox.getAttribute("data-slide-egb-transition-speed"), 10) || 500; // 트랜지션 속도 기본값 500ms
    const transitionTiming = sliderBox.getAttribute("data-slide-egb-transition-timing") || "ease";

    const startSlide = parseInt(sliderBox.getAttribute("data-slide-egb-start"), 10) || 0;
    let lateSlide = parseFloat(sliderBox.getAttribute("data-slide-egb-late")) || 0;
    let latePosition = sliderBox.getAttribute("data-slide-egb-late-position") || "center";

    const hoverStop = sliderBox.getAttribute("data-slide-egb-hover-stop") || "off";
    const wheelControl = sliderBox.getAttribute("data-slide-egb-wheel") || "off";
    const keyboardControl = sliderBox.getAttribute("data-slide-egb-keyboard") || "off"; // 키보드 조작 여부

    const randomizeSlides = sliderBox.getAttribute("data-slide-egb-random") || "off";

    const navigationControl = sliderBox.getAttribute("data-slide-egb-navigation") || "off"; // 네비게이션 기능 여부
    let navigationBoxClass = sliderBox.getAttribute("data-slide-egb-navigation-box-class") || "";
    let prevClass = sliderBox.getAttribute("data-slide-egb-navigation-prev-class") || "";
    let nextClass = sliderBox.getAttribute("data-slide-egb-navigation-next-class") || "";
    let stopClass = sliderBox.getAttribute("data-slide-egb-navigation-stop-class") || "";
    let startClass = sliderBox.getAttribute("data-slide-egb-navigation-start-class") || "";

    const paginationControl = sliderBox.getAttribute("data-slide-egb-pagination") || "off";
    let paginationBoxClass = sliderBox.getAttribute("data-slide-egb-pagination-box-class") || "";
    let paginationButtonClass = sliderBox.getAttribute("data-slide-egb-pagination-button-class") || "";
    let paginationActiveClass = sliderBox.getAttribute("data-slide-egb-pagination-active-class") || "";

    const paginationButtonClick = sliderBox.getAttribute("data-slide-egb-pagination-button-click") || "off";

    const viewPortWidth = window.innerWidth;
    const slidesToViewXy = sliderBox.getAttribute("data-slide-egb-move-xy") || "";
    if (slidesToViewXy) {
        const Ranges = slidesToViewXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                slidesToMove = parseInt(value, 10);;
                //console.log(slidesToMove);
            }
        });
    }

    const slidesToMoveXy = sliderBox.getAttribute("data-slide-egb-view-xy") || "";
    if (slidesToMoveXy) {
        const Ranges = slidesToMoveXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                slidesToView = parseInt(value, 10);;
                //console.log(slidesToView);
            }
        });
    }

    const gapBetweenSlidesXy = sliderBox.getAttribute("data-slide-egb-gap-xy") || "";
    if (gapBetweenSlidesXy) {
        const Ranges = gapBetweenSlidesXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                gapBetweenSlides = parseInt(value, 10);;
                //console.log(gapBetweenSlides);
            }
        });
    }

    const lateSlideXy = sliderBox.getAttribute("data-slide-egb-late-xy") || "";
    if (lateSlideXy) {
        const Ranges = lateSlideXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                lateSlide = parseFloat(value);
                //console.log(lateSlide);
            }
        });
    }

    const directionAttrXy = sliderBox.getAttribute("data-slide-egb-direction-xy") || "";
    if (directionAttrXy) {
        const Ranges = directionAttrXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                directionAttr = value;
                //console.log(directionAttr);
            }
        });
    }

    const latePositionXy = sliderBox.getAttribute("data-slide-egb-late-position-xy") || "";
    if (latePositionXy) {
        const Ranges = latePositionXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                latePosition = value;
                //console.log(latePosition);
            }
        });
    }

    const navigationBoxClassXy = sliderBox.getAttribute("data-slide-egb-navigation-box-class-xy") || "";
    if (navigationBoxClassXy) {
        const Ranges = navigationBoxClassXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                navigationBoxClass = value;
                //console.log(navigationBoxClass);
            }
        });
    }

    const prevClassXy = sliderBox.getAttribute("data-slide-egb-navigation-prev-class-xy") || "";
    if (prevClassXy) {
        const Ranges = prevClassXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                prevClass = value;
                //console.log(prevClass);
            }
        });
    }

    const nextClassXy = sliderBox.getAttribute("data-slide-egb-navigation-next-class-xy") || "";
    if (nextClassXy) {
        const Ranges = nextClassXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                nextClass = value;
                //console.log(nextClass);
            }
        });
    }

    const stopClassXy = sliderBox.getAttribute("data-slide-egb-navigation-stop-class-xy") || "";
    if (stopClassXy) {
        const Ranges = stopClassXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                stopClass = value;
                //console.log(stopClass);
            }
        });
    }

    const startClassXy = sliderBox.getAttribute("data-slide-egb-navigation-start-class-xy") || "";
    if (startClassXy) {
        const Ranges = startClassXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                startClass = value;
                //console.log(startClass);
            }
        });
    }

    const paginationBoxClassXy = sliderBox.getAttribute("data-slide-egb-pagination-box-class-xy") || "";
    if (paginationBoxClassXy) {
        const Ranges = paginationBoxClassXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                paginationBoxClass = value;
                //console.log(paginationBoxClass);
            }
        });
    }

    const paginationButtonClassXy = sliderBox.getAttribute("data-slide-egb-pagination-button-class-xy") || "";
    if (paginationButtonClassXy) {
        const Ranges = paginationButtonClassXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                paginationButtonClass = value;
                //console.log(paginationButtonClass);
            }
        });
    }

    const paginationActiveClassXy = sliderBox.getAttribute("data-slide-egb-pagination-active-class-xy") || "";
    if (paginationActiveClassXy) {
        const Ranges = paginationActiveClassXy.split(',').map(range => range.trim());
        Ranges.forEach(range => {
            const [xyRange, value] = range.split(':').map(part => part.trim());
            const [min, max] = xyRange.split('-').map(Number);

            if (viewPortWidth >= min && viewPortWidth <= max) {
                paginationActiveClass = value;
                //console.log(paginationActiveClass);
            }
        });
    }

    // 방향 설정
    let translateProperty = "translateX";
    let moveMultiplier = -1;
    let flexDirection = "row";
    let isHorizontal = true;

    switch (directionAttr.toLowerCase()) {
        case "right":
            translateProperty = "translateX";
            flexDirection = "row";
            moveMultiplier = 1; // right에서는 양의 방향으로 이동
            isHorizontal = true;
            break;
        case "left":
            translateProperty = "translateX";
            flexDirection = "row";
            moveMultiplier = -1; // left에서는 음의 방향으로 이동
            isHorizontal = true;
            break;
        case "top":
            translateProperty = "translateY";
            flexDirection = "column";
            moveMultiplier = -1;
            isHorizontal = false;
            break;
        case "bottom":
            translateProperty = "translateY";
            flexDirection = "column";
            moveMultiplier = 1;
            isHorizontal = false;
            break;
    }

    let currentIndex = startSlide;
    const originalSlidesCount = slideItems.length;
    let slideInterval;
    let isTransitioning = false;
    let paginationButtons = [];

    /**
    * 슬라이드 클론 생성 함수
    * 원본 슬라이드를 앞뒤로 클론하여 추가
    */
    function cloneSlides() {

        if (randomizeSlides === "on") {
            shuffleSlides();
        }

        const clonesBefore = [];
        const clonesAfter = [];

        // 복제본 앞쪽과 뒤쪽에 동일한 슬라이드 추가
        for (let i = 0; i < originalSlidesCount; i++) {
            const cloneBefore = slideItems[i].cloneNode(true);
            const cloneAfter = slideItems[i].cloneNode(true);
            cloneBefore.classList.add("egb_slide_clone", "before_clone");
            cloneAfter.classList.add("egb_slide_clone", "after_clone");
            clonesBefore.push(cloneBefore);
            clonesAfter.push(cloneAfter);
        }

        // 앞쪽 복제본을 추가 (오른쪽 방향에서는 끝에 추가하는 것이 앞쪽처럼 보임)
        clonesBefore.reverse().forEach(clone => {
            sliderWrapper.insertBefore(clone, sliderWrapper.firstChild);
        });

        // 뒤쪽 복제본을 추가
        clonesAfter.forEach(clone => {
            sliderWrapper.appendChild(clone);
        });

        // 클론 추가 후 slideItems 업데이트
        slideItems = Array.from(sliderWrapper.querySelectorAll(".slide_egb_item"));

        // right 방향일 경우 첫 슬라이드를 오른쪽 끝으로 이동
        currentIndex = originalSlidesCount;
        if (directionAttr.toLowerCase() === "right") {
            moveToPosition(currentIndex, false);
        }
    }

    /**
    * 슬라이드 무작위 섞기 함수
    */
    function shuffleSlides() {
        for (let i = slideItems.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            sliderWrapper.insertBefore(sliderWrapper.children[i], sliderWrapper.children[j]);
        }
        slideItems = Array.from(sliderWrapper.querySelectorAll(".slide_egb_item"));
    }

    /**
    * 슬라이드 초기화 및 크기 설정 함수
    */
    function initSlides() {

        if (loopSlide === "on") {
            cloneSlides();
        }

        const parentSize = getParentSize(); // 슬라이더 박스 크기 가져오기
        const totalGap = gapBetweenSlides * (slidesToView - 1);

        // lateSlide 값에 맞추어 슬라이드 크기 설정, 갭 고려
        const slideSize = (parentSize - totalGap) / (slidesToView + lateSlide); // 갭을 포함하여 크기 조정

        slideItems.forEach((item) => {
            if (isHorizontal) {
                item.style.width = `${slideSize}px`; // 슬라이드 너비 설정
                item.style.height = 'auto';
            } else {
                item.style.height = `${slideSize}px`; // 슬라이드 높이 설정
                item.style.width = 'auto';
            }

            // 슬라이드 간 간격을 유지하기 위해 wrapper 크기를 슬라이드 개수에 맞게 확장
            if (isHorizontal) {
                sliderWrapper.style.width = `${(slideSize + gapBetweenSlides) * slideItems.length}px`; // 슬라이드 + 갭의 합으로 wrapper 너비 설정
            } else {
                sliderWrapper.style.height = `${(slideSize + gapBetweenSlides) * slideItems.length}px`; // 슬라이드 + 갭의 합으로 wrapper 높이 설정
            }

        });

        sliderWrapper.style.display = "flex";
        sliderWrapper.style.flexDirection = flexDirection;
        sliderWrapper.style.transition = `transform ${transitionSpeed}ms ${transitionTiming}`;

        moveToPosition(currentIndex, false); // 슬라이드 시작 위치로 이동
    }

    /**
    * 부모 요소의 크기 가져오기 함수
    * @returns {number} - 부모 요소의 너비 또는 높이
    */
    function getParentSize() {
        return isHorizontal ? sliderBox.clientWidth : sliderBox.clientHeight;
    }

    /**
    * 특정 위치로 슬라이더 이동 함수
    * @param {number} index - 이동할 슬라이드의 인덱스
    * @param {boolean} withTransition - 트랜지션 적용 여부
    */
    function moveToPosition(index, withTransition = true) {
        const parentSize = getParentSize(); // 부모 요소 크기 가져오기

        // 트랜지션 중복 방지를 위해 현재 트랜지션을 강제로 종료
        sliderWrapper.style.transition = 'none';
        void sliderWrapper.offsetWidth; // 브라우저 리플로우를 강제하여 이전 트랜지션을 종료
        if (withTransition) {
            sliderWrapper.style.transition = `transform ${transitionSpeed}ms ${transitionTiming}`;

            // 트랜지션이 끝나지 않는 경우를 대비하여 타임아웃 설정
            setTimeout(() => {
                if (isTransitioning) {
                    isTransitioning = false;
                }
            }, transitionSpeed + 50); // 트랜지션 시간보다 약간 더 긴 시간 설정
        }

        const slideSize = parseFloat(getSlideSize()); // 슬라이드 크기 가져오기
        const slideSizeWithGap = slideSize + gapBetweenSlides; // 갭을 포함한 슬라이드 크기 계산
        let translateValue = moveMultiplier * index * slideSizeWithGap;

        // right 방향일 경우 마지막 슬라이드를 오른쪽 끝에서 시작하도록 오프셋 적용
        if (directionAttr.toLowerCase() === "right") {
            const totalSlides = slideItems.length;
            const totalSliderLength = slideSizeWithGap * totalSlides - gapBetweenSlides;
            const maxTranslate = sliderBox.clientWidth - totalSliderLength;
            translateValue += maxTranslate;

            if (lateSlide == 0 || latePosition.toLowerCase() === "top" || latePosition.toLowerCase() === "bottom") {
                translateValue -= (gapBetweenSlides / 2) * moveMultiplier;
            } else {
                if (latePosition.toLowerCase() === "left") {
                    translateValue += (slideSize * lateSlide) / 2;
                }
                if (latePosition.toLowerCase() === "center") {

                    // 갭의 절반을 더해주어 위치 조정
                    translateValue -= (gapBetweenSlides / 2) * moveMultiplier;
                }
                if (latePosition.toLowerCase() === "right") {
                    translateValue -= (slideSize * lateSlide) / 2 + gapBetweenSlides;
                }
            }
        }

        // left 방향일 경우 갭의 절반을 빼주어 위치 조정
        if (directionAttr.toLowerCase() === "left") {

            if (lateSlide == 0 || latePosition.toLowerCase() === "top" || latePosition.toLowerCase() === "bottom") {
                translateValue += (gapBetweenSlides / 2) * moveMultiplier;
            } else {
                if (latePosition.toLowerCase() === "left") {
                    translateValue += (slideSize * lateSlide) / 2;
                }
                if (latePosition.toLowerCase() === "center") {
                    translateValue += (gapBetweenSlides / 2) * moveMultiplier;
                }
                if (latePosition.toLowerCase() === "right") {
                    translateValue -= (slideSize * lateSlide) / 2 + gapBetweenSlides;
                }
            }
        }

        // bottom 방향일 경우 마지막 슬라이드를 아래 끝에서 시작하도록 오프셋 적용
        if (directionAttr.toLowerCase() === "bottom") {
            const totalSlides = slideItems.length;
            const totalSliderLength = slideSizeWithGap * totalSlides - gapBetweenSlides;
            const maxTranslate = sliderBox.clientHeight - totalSliderLength;
            translateValue += maxTranslate;

            if (lateSlide == 0 || latePosition.toLowerCase() === "left" || latePosition.toLowerCase() === "right") {
                translateValue -= (gapBetweenSlides / 2) * moveMultiplier;
            } else {
                if (latePosition.toLowerCase() === "top") {
                    translateValue += (slideSize * lateSlide) / 2;
                }
                if (latePosition.toLowerCase() === "center") {
                    translateValue -= (gapBetweenSlides / 2) * moveMultiplier;
                }
                if (latePosition.toLowerCase() === "bottom") {
                    translateValue -= (slideSize * lateSlide) / 2 + gapBetweenSlides;
                }
            }
        }

        // top 방향일 경우 갭의 절반을 빼주어 위치 조정

        if (directionAttr.toLowerCase() === "top") {

            if (lateSlide == 0 || latePosition.toLowerCase() === "left" || latePosition.toLowerCase() === "right") {
                translateValue += (gapBetweenSlides / 2) * moveMultiplier;
            } else {
                if (latePosition.toLowerCase() === "top") {
                    translateValue += (slideSize * lateSlide) / 2;
                }
                if (latePosition.toLowerCase() === "center") {
                    translateValue += (gapBetweenSlides / 2) * moveMultiplier;
                }
                if (latePosition.toLowerCase() === "bottom") {
                    translateValue -= (slideSize * lateSlide) / 2 + gapBetweenSlides;
                }
            }
        }

        // 중앙 정렬 + 양쪽에 0.25씩 보이도록 오프셋 적용
        const visibleSlideOffset = (parentSize - (slideSize * slidesToView + gapBetweenSlides * (slidesToView - 1))) / 2; // 갭을 포함하여 양쪽에 0.25씩 보이도록 계산
        translateValue -= visibleSlideOffset * moveMultiplier; // 양쪽 끝에 0.25 슬라이드가 보이게 조정

        sliderWrapper.style.transform = `${translateProperty}(${translateValue}px)`; // 슬라이드 이동 적용

        if (!withTransition) {
            void sliderWrapper.offsetWidth;
            sliderWrapper.style.transition = `transform ${transitionSpeed}ms ${transitionTiming}`;
        }
    }
    /**
    * 슬라이드 크기 가져오기 함수
    * @returns {string} - 슬라이드의 너비 또는 높이 (px 단위)
    */
    function getSlideSize() {
        if (slideItems.length === 0) {

            return isHorizontal ? '0px' : '0px';
        }
        const slide = slideItems[0];
        return isHorizontal ? slide.style.width : slide.style.height;
    }
    /**
    * 슬라이드 이동 함수
    * @param {number} direction - 이동 방향 (1: 다음, -1: 이전)
    */
    function moveSlides(direction = 1) {
        if (isTransitioning) return; // 트랜지션 중복 방지

        const totalSlides = slideItems.length;
        const maxIndex = totalSlides - slidesToView;
        const minIndex = 0;

        // 다음 인덱스 계산
        const nextIndex = currentIndex + slidesToMove * direction;

        // 루프 모드가 아닐 때, 인덱스가 범위를 벗어나지 않도록 제한
        if (loopSlide !== 'on') {
            if (nextIndex < minIndex || nextIndex > maxIndex) {
                isTransitioning = false; // 추가 트랜지션 허용
                return; // 함수 종료하여 더 이상 이동하지 않음
            }
        }

        isTransitioning = true;
        currentIndex = nextIndex;
        moveToPosition(currentIndex, true);
        // Pagination 업데이트
        //updatePaginationButtons();
    }

    /**
    * 트랜지션 완료 후 위치 재설정 함수
    */
    function handleTransitionEnd() {
        isTransitioning = false;
        const totalSlides = slideItems.length;

        if (loopSlide == 'on') {
            // 무한 루프 처리를 위한 인덱스 조정
            if (currentIndex >= totalSlides - originalSlidesCount) {
                // 복제된 첫 번째 슬라이드에서 실제 첫 번째 슬라이드로 순간 이동
                currentIndex = originalSlidesCount;
                moveToPosition(currentIndex, false);  // 애니메이션 없이 이동
            }
            else if (currentIndex < originalSlidesCount) {
                // 복제된 마지막 슬라이드로 이동하는 것이 아니라 실제 마지막 슬라이드로 이동
                currentIndex = totalSlides - originalSlidesCount - 1;  // 정확한 마지막 슬라이드 인덱스 설정
                moveToPosition(currentIndex, false);  // 애니메이션 없이 이동
            }
            else {
                // 슬라이드 이동 중 인덱스
            }

        }
        // Pagination 업데이트
        updatePaginationButtons();
    }

    // 마우스 휠 이벤트 핸들링
    function handleWheelEvent(event) {
        if (wheelControl === 'on') {
            const delta = event.deltaY;

            // deltaY 값에 따라 슬라이드 이동
            if (delta > 0) {
                moveSlides(1);  // 아래로 스크롤하면 다음 슬라이드로 이동
            } else {
                moveSlides(-1);  // 위로 스크롤하면 이전 슬라이드로 이동
            }
        }
    }

    // 키보드 이벤트 핸들링 추가
    function handleKeyboardEvent(event) {
        if (keyboardControl === 'on') {
            switch (event.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    moveSlides(1); // 오른쪽 또는 아래로 이동
                    break;
                case 'ArrowLeft':
                case 'ArrowUp':
                    moveSlides(-1); // 왼쪽 또는 위로 이동
                    break;
            }
        }
    }

    /**
    * 자동 슬라이드 시작 함수
    */
    function startAutoSlide() {
        if (autoSlide === 'on') {
            slideInterval = setInterval(() => {
                moveSlides(1);
            }, slideSpeed);
        }
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    // 마우스 호버 또는 터치 시 슬라이드를 멈추고, 벗어나면 다시 시작
    if (hoverStop === "on") {
        sliderBox.addEventListener("mouseenter", () => {
            stopAutoSlide();  // 슬라이드 멈춤
        });

        sliderBox.addEventListener("mouseleave", () => {
            startAutoSlide(); // 슬라이드 다시 시작
        });

        if (egbIsMobile) {
            sliderBox.addEventListener("touchstart", () => {
                stopAutoSlide();  // 슬라이드 멈춤
            }, { passive: true });

            sliderBox.addEventListener("touchend", () => {
                startAutoSlide(); // 슬라이드 다시 시작
            }, { passive: true });
        }
    }

    sliderBox.addEventListener('wheel', handleWheelEvent, { passive: true });
    document.addEventListener('keydown', handleKeyboardEvent);

    sliderWrapper.addEventListener("transitionend", handleTransitionEnd);

    const dragControl = sliderBox.getAttribute("data-slide-egb-drag") || "off";
    const dragControlLate = parseFloat(sliderBox.getAttribute("data-slide-egb-drag-late")) || 0;
    const dragSpeed = parseFloat(sliderBox.getAttribute("data-slide-egb-drag-speed")) || 1;
    // 드래그 관련 변수 및 함수
    let startX, startY, startTranslate, currentTranslate, isDragging = false;
    let animationID;
    let velocity = 0;
    let lastPosition = 0;

    function handleDragStart(event) {
        if (dragControl === 'on') {
            isDragging = true;

            if (event.type.startsWith('touch')) {
                if (event.touches && event.touches.length > 0) {
                    startX = event.touches[0].pageX;
                    startY = event.touches[0].pageY;
                } else {
                    return;
                }
                event.preventDefault(); // 터치 이벤트의 기본 동작 방지
            } else {
                startX = event.pageX;
                startY = event.pageY;
                event.preventDefault(); // 마우스 이벤트의 텍스트 선택 방지
            }

            startTranslate = getTranslateValue();
            sliderWrapper.style.transition = 'none'; // 드래그 중 트랜지션 비활성화
            cancelAnimationFrame(animationID);
            lastPosition = isHorizontal ? startX : startY;

            // 드래그 중 자동 슬라이드 멈춤
            stopAutoSlide();
        }
    }

    function handleDragMove(event) {
        if (isDragging && dragControl === 'on') {
            let currentPageX, currentPageY;

            if (event.type.startsWith('touch')) {
                if (event.touches && event.touches.length > 0) {
                    currentPageX = event.touches[0].pageX;
                    currentPageY = event.touches[0].pageY;
                } else {
                    return;
                }
                event.preventDefault(); // 터치 이벤트의 기본 동작 방지
            } else {
                currentPageX = event.pageX;
                currentPageY = event.pageY;
                event.preventDefault(); // 마우스 이벤트의 텍스트 선택 방지
            }

            let moveDistance;
            if (isHorizontal) {
                const moveX = currentPageX - startX;
                moveDistance = moveX;
                velocity = currentPageX - lastPosition;
                lastPosition = currentPageX;
            } else {
                const moveY = currentPageY - startY;
                moveDistance = moveY;
                velocity = currentPageY - lastPosition;
                lastPosition = currentPageY;
            }

            currentTranslate = startTranslate + (moveDistance * dragSpeed);
            sliderWrapper.style.transform = `${translateProperty}(${currentTranslate}px)`;
        }
    }

    function handleDragEnd(event) {
        if (isDragging && dragControl === 'on') {
            isDragging = false;

            // 관성 효과 적용
            const inertia = () => {
                velocity *= 0.95; // 감속 계수
                currentTranslate += velocity;

                // 루프 모드에서의 경계 조건 처리
                if (loopSlide === 'on') {
                    // 루프를 위해 클론된 슬라이드가 보이는 경우 인덱스 조정
                    const totalSlides = slideItems.length;
                    const slideSizeWithGap = parseFloat(getSlideSize()) + gapBetweenSlides;
                    const maxTranslate = -slideSizeWithGap * (totalSlides - slidesToView);
                    const minTranslate = 0;

                    if (currentTranslate > minTranslate) {
                        currentTranslate -= slideSizeWithGap * originalSlidesCount;
                    } else if (currentTranslate < maxTranslate) {
                        currentTranslate += slideSizeWithGap * originalSlidesCount;
                    }
                } else {
                    // 일반 모드에서의 경계 조건 처리
                    const maxTranslate = 0;
                    const minTranslate = -((slideItems.length - slidesToView) * (parseFloat(getSlideSize()) + gapBetweenSlides));

                    if (currentTranslate > maxTranslate) {
                        currentTranslate = maxTranslate;
                        velocity = 0;
                    } else if (currentTranslate < minTranslate) {
                        currentTranslate = minTranslate;
                        velocity = 0;
                    }
                }

                sliderWrapper.style.transform = `${translateProperty}(${currentTranslate}px)`;

                if (Math.abs(velocity) > 0.5) {
                    animationID = requestAnimationFrame(inertia);
                } else {
                    // 관성 효과 종료 후 가장 가까운 슬라이드로 정렬
                    snapToClosestSlide();
                    // 드래그 종료 후 자동 슬라이드 다시 시작
                    if (autoSlide === 'on') {
                        startAutoSlide();
                    }
                }
            };

            animationID = requestAnimationFrame(inertia);
        }
    }

    function snapToClosestSlide() {
        sliderWrapper.style.transition = `transform ${transitionSpeed}ms ${transitionTiming}`;

        const slideSizeWithGap = parseFloat(getSlideSize()) + gapBetweenSlides;
        let index = -Math.round(currentTranslate / slideSizeWithGap);

        if (loopSlide === 'on') {
            // 루프 모드에서 인덱스 조정
            const totalSlides = slideItems.length;
            const maxIndex = totalSlides - slidesToView;
            const minIndex = 0;

            if (index >= maxIndex) {
                index -= originalSlidesCount;
                currentTranslate += slideSizeWithGap * originalSlidesCount;
                sliderWrapper.style.transform = `${translateProperty}(${currentTranslate}px)`;
            } else if (index < minIndex) {
                index += originalSlidesCount;
                currentTranslate -= slideSizeWithGap * originalSlidesCount;
                sliderWrapper.style.transform = `${translateProperty}(${currentTranslate}px)`;
            }
        } else {
            // 일반 모드에서 인덱스 경계 처리
            index = Math.min(Math.max(index, 0), slideItems.length - slidesToView);
        }

        currentIndex = index;
        moveToPosition(currentIndex, true);
    }

    // getTranslateValue 함수 수정 (transform 값을 정확히 가져오기 위해)
    function getTranslateValue() {
        const style = window.getComputedStyle(sliderWrapper);
        const transform = style.transform || style.webkitTransform || style.mozTransform;

        if (transform && transform !== 'none') {
            const matrix = new DOMMatrix(transform);
            return isHorizontal ? matrix.m41 : matrix.m42;
        } else {
            return 0;
        }
    }

    // 추가된 이벤트 리스너 (드래그 종료를 위한)
    function handleDragLeave(event) {
        if (isDragging && dragControl === 'on') {
            handleDragEnd(event);
        }
    }

    // 이벤트 리스너 수정
    sliderBox.addEventListener('mousedown', handleDragStart);
    sliderBox.addEventListener('mousemove', handleDragMove);
    sliderBox.addEventListener('mouseup', handleDragEnd);
    sliderBox.addEventListener('mouseleave', handleDragLeave); // 마우스가 슬라이더 영역을 벗어났을 때 드래그 종료

    if (egbIsMobile) {
        sliderBox.addEventListener('touchstart', handleDragStart, { passive: false });
        sliderBox.addEventListener('touchmove', handleDragMove, { passive: false });
        sliderBox.addEventListener('touchend', handleDragEnd, { passive: false });
        sliderBox.addEventListener('touchcancel', handleDragEnd, { passive: false }); // 터치 취소 시 드래그 종료
    }


    // 네비게이션 버튼 추가 함수
    function createNavigationButtons() {
        if (sliderBox.getAttribute("data-slide-egb-navigation") === "on") {
            const navigationBox = document.createElement("div");
            navigationBox.classList.add("slide_egb_navigation_box");

            // navigationBox에 클래스 추가
            navigationBoxClass.split(" ").forEach(cls => {
                if (cls) navigationBox.classList.add(cls);
            });

            const prevButton = document.createElement("div");
            prevButton.classList.add("slide_egb_prev");
            prevClass.split(" ").forEach(cls => {
                if (cls) prevButton.classList.add(cls);
            });
            prevButton.innerText = "";

            const nextButton = document.createElement("div");
            nextButton.classList.add("slide_egb_next");
            nextClass.split(" ").forEach(cls => {
                if (cls) nextButton.classList.add(cls);
            });
            nextButton.innerText = "";

            const stopButton = document.createElement("div");
            stopButton.classList.add("slide_egb_stop");
            stopClass.split(" ").forEach(cls => {
                if (cls) stopButton.classList.add(cls);
            });
            stopButton.innerText = "";

            const startButton = document.createElement("div");
            startButton.classList.add("slide_egb_start");
            startClass.split(" ").forEach(cls => {
                if (cls) startButton.classList.add(cls);
            });
            startButton.innerText = "";

            // 네비게이션 박스에 버튼 추가
            navigationBox.appendChild(prevButton);
            navigationBox.appendChild(nextButton);
            navigationBox.appendChild(stopButton);
            navigationBox.appendChild(startButton);

            // 네비게이션 박스를 slide_egb_main_box에 추가
            sliderMainBox.appendChild(navigationBox);

            // 네비게이션 버튼 이벤트 추가
            prevButton.addEventListener("click", function () {
                moveSlides(-1); // 이전 슬라이드로 이동
            });

            nextButton.addEventListener("click", function () {
                moveSlides(1); // 다음 슬라이드로 이동
            });

            stopButton.addEventListener("click", function () {
                stopAutoSlide(); // 자동 슬라이드 멈춤
            });

            startButton.addEventListener("click", function () {
                startAutoSlide(); // 자동 슬라이드 다시 시작
            });
        }
    }

    // Pagination 버튼 생성 함수
    function createPaginationButtons() {
        if (paginationControl === "on") {
            const paginationBox = document.createElement("div");
            paginationBox.classList.add("slide_egb_pagination_box");
            paginationBoxClass.split(" ").forEach(cls => {
                if (cls) paginationBox.classList.add(cls);
            });
            // slide_egb_pagination_box를 sliderMainBox에 추가
            sliderMainBox.appendChild(paginationBox);

            // 각 슬라이드에 대해 Pagination 버튼 생성
            for (let i = 0; i < originalSlidesCount; i++) {
                const paginationButton = document.createElement("div");
                paginationButton.classList.add("slide_egb_pagination_button");
                paginationButtonClass.split(" ").forEach(cls => {
                    if (cls) paginationButton.classList.add(cls);
                });
                paginationButton.dataset.index = i; // 인덱스 저장

                // Pagination 버튼 클릭 이벤트 리스너 추가
                addPaginationButtonClickHandler(paginationButton, i);

                // Pagination 버튼을 paginationBox에 추가
                paginationBox.appendChild(paginationButton);
                paginationButtons.push(paginationButton);
            }

            // 초기 활성화된 버튼 업데이트
            updatePaginationButtons();
        }
    }

    // 페이지네이션 버튼 클릭 이벤트 처리 함수
    function addPaginationButtonClickHandler(paginationButton, index) {
        if (paginationButtonClick === "on") {
            paginationButton.addEventListener("click", function () {
                // isTransitioning 변수를 체크하지 않습니다.
                isTransitioning = true;

                // 클릭된 버튼에 맞는 슬라이드 인덱스로 이동
                if (loopSlide === "on") {
                    currentIndex = index + originalSlidesCount; // 루프 모드인 경우 클론을 고려한 인덱스 이동
                } else {
                    currentIndex = index; // 일반 모드에서는 해당 인덱스로 이동
                }
                moveToPosition(currentIndex, true); // 해당 인덱스로 슬라이드 이동
            });
        }
    }

    // Pagination 버튼 활성화 업데이트 함수
    function updatePaginationButtons() {
        if (paginationControl === "on") {
            let activeIndex;
            if (loopSlide === "on") {
                activeIndex = (currentIndex - originalSlidesCount) % originalSlidesCount;
                if (activeIndex < 0) {
                    activeIndex += originalSlidesCount;
                }
            } else {
                activeIndex = currentIndex;
            }
            // 모든 버튼에서 'egb_active' 클래스 제거하고 현재 활성 버튼에만 추가
            paginationButtons.forEach((button, index) => {
                if (index === activeIndex) {
                    button.classList.add("egb_active");
                    paginationActiveClass.split(" ").forEach(cls => {
                        if (cls) button.classList.add(cls);
                    });
                } else {
                    button.classList.remove("egb_active");
                    paginationActiveClass.split(" ").forEach(cls => {
                        if (cls) button.classList.remove(cls);
                    });
                }
            });
        }
    }

    // Pagination 버튼 생성
    createPaginationButtons();

    // 네비게이션 기능 초기화
    createNavigationButtons();

    // 드래그 기능 초기화
    if (dragControl === 'on') {
        sliderWrapper.style.cursor = "grab";
    }

    // 슬라이드 초기화
    initSlides();

    // 자동 슬라이드 시작
    startAutoSlide();

    // 슬라이더가 제거될 때 이벤트 리스너와 인터벌을 정리하는 함수
    function destroySlider() {
        // 이벤트 리스너 제거
        sliderBox.removeEventListener('wheel', handleWheelEvent);
        document.removeEventListener('keydown', handleKeyboardEvent);
        sliderWrapper.removeEventListener("transitionend", handleTransitionEnd);
        // 기타 이벤트 리스너 제거...

        // 인터벌 정리
        stopAutoSlide();

        // 초기화 상태 제거
        initializedSliders.delete(sliderMainBox);
    }

    // MutationObserver를 사용하여 슬라이더가 DOM에서 제거될 때를 감지
    const removalObserver = new MutationObserver((mutationsList) => {
        mutationsList.forEach(mutation => {
            mutation.removedNodes.forEach(node => {
                if (node === sliderMainBox || node.contains(sliderMainBox)) {
                    destroySlider();
                    removalObserver.disconnect();
                }
            });
        });
    });

    removalObserver.observe(document.body, { childList: true, subtree: true });

    sliderMainBox._startAutoSlide = startAutoSlide;
    sliderMainBox._stopAutoSlide = stopAutoSlide;

}

// MutationObserver로 새로 추가되는 슬라이더 감지
function observeNewSliders(targetNode) {
    const observer = new MutationObserver((mutationsList) => {
        for (let mutation of mutationsList) {
            if (mutation.type === "childList") {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        if (node.matches(".slide_egb_main_box")) {
                            initializeSliderWhenVisible(node);
                        } else if (node.querySelectorAll) {
                            node.querySelectorAll(".slide_egb_main_box").forEach(childNode => {
                                initializeSliderWhenVisible(childNode);
                            });
                        }
                    }
                });
            }
        }
    });

    observer.observe(targetNode, { childList: true, subtree: true });
}

// 문서 로딩 시 기존에 존재하는 슬라이더에 대해 가시성 초기화 로직 적용
document.querySelectorAll(".slide_egb_main_box").forEach(sliderMainBox => {
    initializeSliderWhenVisible(sliderMainBox);
});

// DOM 변화를 감시하여 새로 추가되는 슬라이더 처리
observeNewSliders(document.body);

// 초기화가 완료된 이후, 가시성 변화를 감지해 슬라이드 동작을 멈추거나 재개하는 함수
function watchSliderVisibility(sliderMainBox) {
    const sliderBox = sliderMainBox.querySelector(":scope > .slide_egb_box");
    if (!sliderBox) return;

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1  // 10% 이상 보일 때 동작 재개
    };

    const visibilityObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            // sliderBox가 화면에 일정 부분 이상 보이면 startAutoSlide(), 아니면 stopAutoSlide()
            if (entry.isIntersecting) {
                // 가시영역 안으로 들어옴 -> 슬라이드 재개
                startAutoSlideForSlider(sliderMainBox);
            } else {
                // 가시영역 밖으로 나감 -> 슬라이드 정지
                stopAutoSlideForSlider(sliderMainBox);
            }
        });
    }, options);

    visibilityObserver.observe(sliderBox);
}

// 특정 슬라이더의 startAutoSlide, stopAutoSlide를 직접 호출하기 위한 헬퍼 함수
// initializeSlider 내에 startAutoSlide 함수가 정의되어 있으므로,
// startAutoSlide/stopAutoSlide를 전역 접근 가능하도록 수정하거나,
// sliderMainBox에 참조를 저장하는 식으로 접근해야 합니다.

// 예를 들어, initializeSlider 함수 안에 sliderMainBox에 dataset으로 참조 저장:

// initializeSlider 내부 끝부분에 다음과 같은 식으로 참조를 저장해둔다고 가정:
// sliderMainBox._startAutoSlide = startAutoSlide;
// sliderMainBox._stopAutoSlide = stopAutoSlide;

// 그러면 외부에서 startAutoSlideForSlider, stopAutoSlideForSlider 함수를 다음과 같이 구현 가능:
function startAutoSlideForSlider(sliderMainBox) {
    if (sliderMainBox._startAutoSlide) sliderMainBox._startAutoSlide();
}

function stopAutoSlideForSlider(sliderMainBox) {
    if (sliderMainBox._stopAutoSlide) sliderMainBox._stopAutoSlide();
}

// initializeSlider 함수를 수정하여 startAutoSlide, stopAutoSlide 참조를 sliderMainBox에 저장
// (위 코드 내용은 참고사항이며 실제로 initializeSlider 내부 맨 아래쪽에 다음 두 줄을 추가)
// sliderMainBox._startAutoSlide = startAutoSlide;
// sliderMainBox._stopAutoSlide = stopAutoSlide;


// 그리고 initializeSliderWhenVisible에서 초기화 완료 후 watchSliderVisibility 호출:
function initializeSliderWhenVisible(sliderMainBox) {
    if (!sliderMainBox) return;
    if (initializedSliders.has(sliderMainBox)) return;

    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0
    };

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                initializeSlider(sliderMainBox);
                // 초기화 완료 후 가시성 변화 감지용 옵저버 시작
                watchSliderVisibility(sliderMainBox);
                obs.unobserve(entry.target);
            }
        });
    }, options);

    observer.observe(sliderMainBox);
}