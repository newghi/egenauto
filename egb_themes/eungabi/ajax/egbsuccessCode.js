function egbsuccessCode(response) {
	const successCode = response.successCode;
    // 성공 코드에 따른 메시지 처리를 사용자가 직접 작성
    switch (successCode) {
        case 'publicDataPortal1':
            if (response.data && response.data.data && response.data.data[0]) {
                const status = response.data.data[0].b_stt_cd;
                const businessNumber = response.businessNumber;
                
                if (status === "01") {
                    alert(`사업자등록번호 ${businessNumber}는 정상적으로 등록된 사업자입니다.`);
                    
                    // 입력 필드 비활성화
                    document.querySelector('input[name="user_company_registration_number1"]').disabled = true;
                    document.querySelector('input[name="user_company_registration_number2"]').disabled = true;
                    document.querySelector('input[name="user_company_registration_number3"]').disabled = true;
                    
                    // 사업자명 입력 필드 비활성화
                    document.querySelector('input[name="user_company_name"]').disabled = true;
                    
                    // 확인 버튼 상태 업데이트
                    document.getElementById('company_check1').setAttribute('data-checked', 'true');
                    
                    // hidden input에 사업자번호 설정
                    document.querySelector('input[name="user_company_registration_number"]').value = businessNumber;
                    
                } else if (status === "02") {
                    alert(`사업자등록번호 ${businessNumber}는 휴업자 상태입니다.`);
                } else if (status === "03") {
                    alert(`사업자등록번호 ${businessNumber}는 폐업자 상태입니다.`);
                } else {
                    alert(`사업자등록번호 ${businessNumber}의 상태를 확인할 수 없습니다.`);
                }
            } else {
                alert('사업자등록번호 조회 결과를 확인할 수 없습니다.');
            }
        break;
        case 'publicDataPortal2':
            if (response.data && response.data.data && response.data.data[0]) {
                const status = response.data.data[0].b_stt_cd;
                const corporationNumber = response.corporationNumber;
                
                if (status === "01") {
                    alert(`법인등록번호 ${corporationNumber}는 정상적으로 등록된 법인입니다.`);
                    
                    // 입력 필드 비활성화
                    document.querySelector('input[name="user_company_registration_number4"]').disabled = true;
                    document.querySelector('input[name="user_company_registration_number5"]').disabled = true;
                    document.querySelector('input[name="user_company_registration_number6"]').disabled = true;
                    
                    // 법인명 입력 필드 비활성화 
                    document.querySelector('input[name="user_company_name2"]').disabled = true;
                    
                    // 확인 버튼 상태 업데이트
                    document.getElementById('company_check2').setAttribute('data-checked', 'true');
                    
                    // hidden input에 법인번호 설정
                    document.querySelector('input[name="user_company_registration_number"]').value = corporationNumber;
                    
                } else if (status === "02") {
                    alert(`법인등록번호 ${corporationNumber}는 휴업자 상태입니다.`);
                } else if (status === "03") {
                    alert(`법인등록번호 ${corporationNumber}는 폐업자 상태입니다.`);
                } else {
                    alert(`법인등록번호 ${corporationNumber}의 상태를 확인할 수 없습니다.`);
                }
            } else {
                alert('법인등록번호 조회 결과를 확인할 수 없습니다.');
            }
        break;
        case 'toggle_weekday_status_1':
        if (response.success) {
            if (response.request_page === 'crm') {
                // 요일 값 정규화를 위한 매핑
                const weekdayMap = {
                    // 한글 짧은 형식
                    '월': '월', '화': '화', '수': '수', '목': '목', 
                    '금': '금', '토': '토', '일': '일',
                    // 한글 긴 형식
                    '월요일': '월', '화요일': '화', '수요일': '수', '목요일': '목', 
                    '금요일': '금', '토요일': '토', '일요일': '일',
                    // 영어 전체 형식
                    'Monday': '월', 'Tuesday': '화', 'Wednesday': '수', 'Thursday': '목',
                    'Friday': '금', 'Saturday': '토', 'Sunday': '일',
                    // 영어 짧은 형식
                    'Mon': '월', 'Tue': '화', 'Wed': '수', 'Thu': '목',
                    'Fri': '금', 'Sat': '토', 'Sun': '일',
                    // 숫자 형식 (1:월요일 ~ 7:일요일)
                    '1': '월', '2': '화', '3': '수', '4': '목',
                    '5': '금', '6': '토', '7': '일',
                    // 숫자 형식 (0:일요일 ~ 6:토요일)
                    '0': '일',
                    // 소문자 영어도 처리
                    'monday': '월', 'tuesday': '화', 'wednesday': '수', 'thursday': '목',
                    'friday': '금', 'saturday': '토', 'sunday': '일',
                    'mon': '월', 'tue': '화', 'wed': '수', 'thu': '목',
                    'fri': '금', 'sat': '토', 'sun': '일'
                };
                const dayValue = weekdayMap[response.weekday];
                const checkbox = document.querySelector(`#holiday_${dayValue}`);
                
                if (checkbox) {
                    // 체크박스 상태 토글
                    checkbox.checked = !checkbox.checked;
                }
            }
        }
        break;
        case 'toggle_slot_status_1':
        if (response.success) {
            if (response.request_page === 'crm') {
                const weekday = response.weekday;
                const time = response.time;
                // 시간에서 콜론을 제거하고 ID 생성
                const uniqueId = `reservation_time_${weekday}_${time.replace(':', '')}`;
                const checkbox = document.querySelector(`#${uniqueId}`);
                
                if (checkbox) {
                    // 체크박스 상태 토글
                    checkbox.checked = !checkbox.checked;
                }
            }
        }
        break;
        case 'update_slot_count_1':
            if (response.success) {
                if (response.request_page === 'crm') {
                    const weekday = response.weekday;
                    const time = response.time;
                    const count = response.count;
                    // 시간에서 콜론을 제거하고 ID 생성
                    const uniqueId = `reservation_time_${weekday}_${time.replace(':', '')}`;
                    const countInput = document.querySelector(`#${uniqueId}`);
                    
                    if (countInput) {
                        // 입력값 업데이트
                        countInput.value = count;
                    }
                }
            }
            
            break;
            case 'store_add_holiday_1':
            if (response.success) {
            //resetTimeSelection();
                const holidayDate = response.holiday_date;
                const holidayName = response.holiday_name;
                const store_uniq_id = response.uniq_id;
                
                // 휴일 목록 컨테이너 찾기
                const holidayListBox = document.querySelector('.holiday_list_box');
                
                // 기존 날짜가 있는지 확인
                const existingHolidayItem = Array.from(holidayListBox.querySelectorAll('.holiday_list')).find(item => {
                    const dateDiv = item.querySelector('div:nth-child(2)');
                    return dateDiv && dateDiv.textContent === holidayDate;
                });

                if (existingHolidayItem) {
                    // 기존 날짜가 있으면 이름만 업데이트
                    const nameDiv = existingHolidayItem.querySelector('div:nth-child(3)');
                    if (nameDiv) {
                        nameDiv.textContent = holidayName;
                    }
                } else {
                    // 기존 "등록된 휴일이 없습니다" 메시지 제거
                    const noHolidayMsg = document.querySelector('.holiday_list');
                    if (noHolidayMsg && noHolidayMsg.textContent === '등록된 휴일이 없습니다.') {
                        noHolidayMsg.remove();
                    }
                    
                    // 새로운 휴일 항목의 인덱스 계산
                    const existingHolidays = holidayListBox.querySelectorAll('.holiday_list');
                    const newIndex = existingHolidays.length + 1;
                    
                    // 새로운 휴일 항목 HTML 생성
                    const newHolidayHTML = `
                            <div class="holiday_list holiday_id_${newIndex} grid_xx border_px-u_001 pointer bd-a-color-d9d9d9 bg-color-ffffff" data-xx="10% 40% 40% 10%" data-date="${holidayDate}" data-name="${holidayName}">
                                <div class="flex_xc_yc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">${newIndex}</div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">${holidayDate}</div>
                                <div class="flex_xc border_px-r_001 padding_px-y_015 bd-a-color-d9d9d9">${holidayName}</div>
                                <form action="${DOMAIN}/?post=egb_store_delete_holiday_input" method="post" class="delete_holiday_form">
                                    <input type="hidden" name="csrf_token" value="${egbCsrfToken}">
                                    <input type="hidden" name="uniq_id" value="${store_uniq_id}">
                                    <input type="hidden" name="holiday_date" value="${holidayDate}">
                                    <div class="egb_submit flex_xc padding_px-y_015 pointer delete_holiday bd-a-color-d9d9d9 hover-bg-color-ff0000aa hover-color-ffffff width_box" data-id="${newIndex}">삭제</div>
                                </form>
                            </div>
                    `;
                    
                    // 새로운 휴일 항목을 목록에 추가
                    holidayListBox.insertAdjacentHTML('beforeend', newHolidayHTML);
                }
                
                // 입력 필드 초기화
                document.getElementById('holiday_date').value = '';
                document.getElementById('holiday_name').value = '';
            }
            break;
        case 'store_delete_holiday_6':
            if (response.success) {
                const holidayDate = response.holiday_date;
                
                // 삭제할 휴일 항목 찾기
                const holidayListBox = document.querySelector('.holiday_list_box');
                const holidayToDelete = Array.from(holidayListBox.querySelectorAll('.holiday_list')).find(item => {
                    const dateDiv = item.querySelector('div:nth-child(2)');
                    return dateDiv && dateDiv.textContent === holidayDate;
                });

                if (holidayToDelete) {
                    // 휴일 항목 삭제
                    holidayToDelete.remove();

                    // 남은 휴일 항목들의 인덱스 재정렬
                    const remainingHolidays = holidayListBox.querySelectorAll('.holiday_list');
                    remainingHolidays.forEach((item, index) => {
                        const newIndex = index + 1;
                        item.classList.remove(Array.from(item.classList).find(c => c.startsWith('holiday_id_')));
                        item.classList.add(`holiday_id_${newIndex}`);
                        item.querySelector('div:first-child').textContent = newIndex;
                        item.querySelector('.delete_holiday').dataset.id = newIndex;
                    });

                    // 휴일이 없는 경우 메시지 표시
                    if (remainingHolidays.length === 0) {
                        const noHolidayHTML = `
                            <div class="holiday_list flex_xc_yc padding_px-y_015">등록된 휴일이 없습니다.</div>
                        `;
                        holidayListBox.insertAdjacentHTML('beforeend', noHolidayHTML);
                    }
                }
            }
            break;
        
            
            
            
            case 'get_schedule_1':
            if (response.success) {
                const schedule = response.schedule;
                const timeBox = document.getElementById('change_time');
                const carCountSpan = document.getElementById('reservation_car_count');
                const totalCarCountSpan = document.getElementById('reservation_total_car_count');
                const noReservationBox = document.getElementById('reservation_no_box');
                
                // 시간대 목록 초기화
                timeBox.innerHTML = '';
                
                // 휴일이거나 영업일이 아닌 경우
                if (schedule.is_holiday || !schedule.status) {
                    let message = schedule.is_holiday ? 
                        `휴일(${schedule.holiday_name})로 예약이 불가능합니다.` :
                        '영업일이 아니므로 예약이 불가능합니다.';
                    timeBox.innerHTML = `<div>${message}</div>`;
                    carCountSpan.textContent = '0';
                    totalCarCountSpan.textContent = '0';
                    return;
                }

                // 시간대별 예약 가능 수량 표시
                let totalAvailable = 0;
                let totalCount = 0;
                
                schedule.time_slots.forEach(slot => {
                    // 시간대 상태가 0인 경우 건너뛰기
                    if (!slot.status) return;

                    const availableCount = parseInt(slot.count);
                    const totalSlotCount = parseInt(slot.total_count);
                    const hour = slot.time.split(':')[0];
                    totalCount += totalSlotCount;
                    
                    if (availableCount <= 0) {
                        timeBox.insertAdjacentHTML('beforeend', `
                            <div class="padding_px-a_005">
                                <div class="width_px_140 flex_xc border_px-a_001 border_bre-a_005 padding_px-y_010 pointer"
                                    data-bd-a-color="#d9d9d9" data-bg-color="#eeeeee" data-xy="1-600: width_px_125"
                                    data-color="#cccccc">
                                    ${hour}시(마감)
                                </div>
                            </div>
                        `);
                    } else {
                        totalAvailable += availableCount;
                        timeBox.insertAdjacentHTML('beforeend', `
                            <div class="padding_px-a_005">
                                <div class="width_px_140 position1 flex_xc border_px-a_001 border_bre-a_005 padding_px-y_010 pointer reservation_hover"
                                    data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" data-xy="1-600: width_px_125"
                                    data-color="#000000">
                                    <div class="reservation_hover_1">
                                        ${hour}시<span class="color-ff0000">(${availableCount}대)</span>
                                    </div>
                                    <div class="position2 flex_xc_yc width_box height_box border_bre-a_005 o_0 reservation_hover_2 top-0per bg-color-15376b color-ffffff">예약하기</div>
                                </div>
                            </div>
                        `);
                    }
                });
                
                // 총 예약 가능 대수 업데이트
                carCountSpan.textContent = totalAvailable.toString();
                totalCarCountSpan.textContent = totalCount.toString();

                // 당일 예약 불가 메시지 숨기기
                if (noReservationBox) {
                    noReservationBox.classList.add('display_off');
                }
            }
            break;
        
            
            case 'egb_alarm_read_1':
            if (response.success && response.from_page === 'header') {
                try {
                    // 알림 카운트 업데이트
                    const alarmCount = document.getElementById('alarm_count');
                    if (alarmCount) {
                        alarmCount.classList.add('display_off');
                    }

                    // 빨간점 제거 
                    const alarmRedCheck = document.getElementById('alarm_red_check');
                    if (alarmRedCheck) {
                        alarmRedCheck.classList.add('display_off');
                    }

                    // 알림 아이템 제거
                    const alarmItem = document.getElementById('alarm_item_' + response.alarm_uniq_id);
                    if (alarmItem) {
                        const form = alarmItem.closest('form');
                        if (form) {
                            form.remove();
                        }
                    }

                    // 남은 알림 아이템 확인 - 이미 페이지 이동중인 경우는 처리하지 않음
                    if (!window.isNavigating) {
                        const remainingAlarms = document.querySelectorAll('.alarm_item');
                        if (remainingAlarms.length === 0) {
                            // 알림이 없을 경우 "알림 없음" 메시지 표시
                            const alarmContainer = document.querySelector('.alarm_container');
                            if (alarmContainer) {
                                const noAlarmDiv = document.createElement('div');
                                noAlarmDiv.className = 'padding_px-a_020 text_center';
                                noAlarmDiv.setAttribute('data-color', '#888888');
                                noAlarmDiv.textContent = '알림이 없습니다.';
                                alarmContainer.innerHTML = '';
                                alarmContainer.appendChild(noAlarmDiv);

                                // 알림창 닫기
                                const alarmBox = document.querySelector('.alarm_box');
                                if (alarmBox) {
                                    setTimeout(() => {
                                        alarmBox.classList.add('display_off');
                                    }, 1500);
                                }
                            }
                        }
                    }

                    if (response.redirect_url) {
                        window.isNavigating = true;
                        const [urlBase, hash] = response.redirect_url.split('#');
                        const timestamp = new Date().getTime();
                        
                        // hash가 undefined이거나 빈 값이면 # 부분을 제거
                        if (hash && hash !== 'undefined') {
                            const newUrl = urlBase + (urlBase.includes('?') ? '&' : '?') + 't=' + timestamp + '#' + hash;
                            window.location.href = newUrl;
                        } else {
                            const newUrl = urlBase + (urlBase.includes('?') ? '&' : '?') + 't=' + timestamp;
                            window.location.href = newUrl;
                        }
                    }
                } catch (error) {
                    console.error('알림 처리 중 오류 발생:', error);
                }
            }
            break;
        case 1:
            if (response.success) {
                // 회원가입 성공 시 로그인 페이지로 이동
                //alert('회원가입이 완료되었습니다.');
                window.location.href = '/page/signup_complete';
            }
            break;
        case 2:
            if (response.success) {
                // 로그인 성공 시 메인 페이지로 이동 (강력 새로고침)
                window.location.replace(response.url);
            }
            break;
        case 3:
            if (response.success) {
                //alert('회원등급 승인 상태가 변경되었습니다.');
            }
            break;
        case 4:
            if (response.success) {
                //alert('설정이 변경되었습니다.');
            }
            break;
        case 5:
            if (response.success) {
                alert('등급명이 변경되었습니다.');
                window.location.reload();
            }
            break;
        case 6:
            if (response.success) {
                alert('리워드 항목이 변경되었습니다.');
                //window.location.reload();
            }
            break;
        case 7:
            if (response.success) {
                alert('게시글이 등록되었습니다.');
                window.location.href = response.url;
            }
            break;
        
            
            case 8:
            if (response.success) {
                const commentData = response.data;
                const commentList = document.getElementById('comment_list');

                const newComment = document.createElement('div');
                newComment.id = `item_${commentData.uniq_id}`;
                newComment.className = 'comment_item';
                
                newComment.innerHTML = `
                    <div id="comment_${commentData.uniq_id}" class="comment_box flex_fl padding_px-y_010 margin_px-y_005">
                        <div class="flex_fl min_width_060 max_width_060 width_box max_height_040 pointer">
                            <img src="${DOMAIN}${THEMES_PATH}/img/icon/profile.svg" 
                                class="width_px_040 height_px_040 border_bre-a_035">
                        </div>
                        <div class="flex_ft width_box font_px_016">
                            <div class="flv6 pointer">${commentData.user_nick_name}</div>
                            <div class="padding_px-y_008">
                                ${commentData.comment_contents}
                            </div>
                            <div class="flex_fl_yc_wrap font_px_012" data-color="#888888">
                                <div>${commentData.created_at}</div>
                                <div>・</div>
                                <div class="pointer flex_fl_yc">
                                    <img class="width_px_016 height_px_016" 
                                        src="${DOMAIN}${THEMES_PATH}/img/icon/heart.svg">
                                    <div>좋아요</div>
                                </div>
                                <div>・</div>
                                <div class="comment_recomment recomment_${commentData.uniq_id} pointer" data-comment-id="${commentData.uniq_id}">
                                    댓글달기
                                </div>
                                <div>・</div>
                                <div class="pointer">신고</div>
                            </div>
                        </div>
                    </div>
                    <div class="replies_container replies_wrapper_${commentData.uniq_id}" id="replies_${commentData.uniq_id}" style="display: none;"></div>
                `;

                if (commentData.comment_parent_uniq_id) {
                    // 답글인 경우
                    const parentReplies = document.querySelector(`.replies_wrapper_${commentData.comment_parent_uniq_id}`);
                    if (parentReplies) {
                        parentReplies.style.display = 'block';
                        parentReplies.style.paddingLeft = '30px';
                        parentReplies.style.backgroundColor = '#f7f9fa';
                        parentReplies.appendChild(newComment);
                        
                        // 부모 댓글의 "댓글 보기" 버튼 업데이트
                        const parentComment = document.querySelector(`#comment_${commentData.comment_parent_uniq_id}`);
                        if (parentComment) {
                            const viewRepliesBtn = parentComment.querySelector(`.view_replies_btn_${commentData.comment_parent_uniq_id}`);
                            
                            if (viewRepliesBtn) {
                                const currentCount = parseInt(viewRepliesBtn.dataset.replyCount || '0') + 1;
                                viewRepliesBtn.dataset.replyCount = currentCount;
                                viewRepliesBtn.textContent = `댓글 숨기기 (${currentCount})`;
                            } else {
                                const viewRepliesDiv = document.createElement('div');
                                viewRepliesDiv.className = 'egb_submit toggle_replies pointer';
                                viewRepliesDiv.classList.add(`view_replies_btn_${commentData.comment_parent_uniq_id}`);
                                viewRepliesDiv.dataset.commentId = commentData.comment_parent_uniq_id;
                                viewRepliesDiv.dataset.replyCount = '1';
                                viewRepliesDiv.textContent = '댓글 숨기기 (1)';
                                
                                const commentRecommentDiv = parentComment.querySelector('.comment_recomment');
                                const dotDiv = document.createElement('div');
                                dotDiv.textContent = '・';
                                
                                // 댓글달기 다음에 ・ 추가
                                commentRecommentDiv.parentNode.insertBefore(dotDiv.cloneNode(true), commentRecommentDiv.nextSibling);
                                // ・ 다음에 댓글 숨기기 버튼 추가
                                commentRecommentDiv.parentNode.insertBefore(viewRepliesDiv, commentRecommentDiv.nextSibling.nextSibling);
                            }
                        }
                    }
                } else {
                    // 새 댓글인 경우
                    commentList.insertBefore(newComment, commentList.firstChild);
                }
                
                // 댓글 수 업데이트
                const commentCountElement = document.getElementById('all_comment_count');
                if (commentCountElement) {
                    const currentCount = parseInt(commentCountElement.textContent) || 0;
                    commentCountElement.textContent = currentCount + 1;
                }

                // 사이드바 댓글 수 업데이트
                const boardType = commentData.board_type || '';
                const sideCommentCount = document.querySelector(`.${boardType}_side_commnet_count`);
                if (sideCommentCount) {
                    sideCommentCount.textContent = parseInt(sideCommentCount.textContent) + 1;
                }
                
                // 입력 폼 초기화
                const commentForms = document.querySelectorAll('.comment_form');
                commentForms.forEach(form => {
                    const textarea = form.querySelector('textarea[name="comment_contents"]');
                    if (textarea) {
                        textarea.value = '';
                        textarea.style.height = '45px'; // min_height_045와 일치
                        
                        // 입력 버튼 스타일 초기화
                        const submitBtn = form.querySelector('.text_input');
                        if (submitBtn) {
                            submitBtn.style.color = '#d9d9d9';
                            submitBtn.classList.remove('pointer');
                        }

                        // 작성한 폼에만 포커스 유지
                        if ((commentData.comment_parent_uniq_id && textarea.classList.contains('reply_comment_textarea')) ||
                            (!commentData.comment_parent_uniq_id && textarea.classList.contains('main_comment_textarea'))) {
                            textarea.focus();
                        }
                    }
                });
            }
            break;
        case 9:
            if (response.success) {
                // 좋아요 상태에 따라 하트 아이콘과 카운트 업데이트
                if (response.status === 1) {
                    updateHeartCount(1); // 숫자 증가
                    toggleHeart(true);
                } else {
                    updateHeartCount(-1); // 숫자 감소 
                    toggleHeart(false);
                }
                function toggleHeart(isLiked) {
                    console.log('Toggling Heart:', isLiked);
                    const container = document.querySelector('.' + response.page + '_side_heart_box');
                    const existingInputs = container.querySelectorAll('input');
                    const inputsHTML = Array.from(existingInputs).map(input => input.outerHTML).join('');
                    
                    if (isLiked) {
                        container.innerHTML = `
                            ${inputsHTML}
                            <svg class="${response.page}_side_heart_check width_px_025 height_px_025" xmlns="http://www.w3.org/2000/svg" id="Layer_1" height="512" viewBox="0 0 512 512" width="512" data-name="Layer_1">
                                <g transform="translate(256, 256) rotate(1) translate(-256, -256)">
                                    <path fill="#15376b" d="M256 436a54.62 54.62 0 0 1-29.53-8.64c-25-16.07-73.08-49.05-113.75-89.32-49.91-49.46-75.22-96.04-75.22-138.48 0-29.49 8.72-56.51 25.22-78.13a115.2 115.2 0 0 1 137.89-35.75c21.18 9.14 40.07 24.55 55.39 45 15.32-20.5 34.21-35.91 55.39-45a115.2 115.2 0 0 1 137.89 35.75c16.5 21.62 25.22 48.64 25.22 78.13 0 42.44-25.31 89-75.22 138.44-40.67 40.27-88.73 73.25-113.75 89.32a54.62 54.62 0 0 1-29.53 8.68z"/>
                                </g>
                            </svg>
                        `;
                    } else {
                        container.innerHTML = `
                            ${inputsHTML}
                            <svg class="${response.page}_side_heart width_px_025 height_px_025" xmlns="http://www.w3.org/2000/svg" id="Layer_1" height="512" viewBox="0 0 512 512" width="512" data-name="Layer_1">
                                <path d="m256 436a54.62 54.62 0 0 1 -29.53-8.64c-25-16.07-73.08-49.05-113.75-89.32-49.91-49.46-75.22-96.04-75.22-138.48 0-29.49 8.72-56.51 25.22-78.13a115.2 115.2 0 0 1 137.89-35.75c21.18 9.14 40.07 24.55 55.39 45 15.32-20.5 34.21-35.91 55.39-45a115.2 115.2 0 0 1 137.89 35.75c16.5 21.62 25.22 48.64 25.22 78.13 0 42.44-25.31 89-75.22 138.44-40.67 40.27-88.73 73.25-113.75 89.32a54.62 54.62 0 0 1 -29.53 8.68zm-101.84-334.94a89.41 89.41 0 0 0 -23.42 3.1 90.93 90.93 0 0 0 -48.15 32.44c-13.14 17.22-20.09 39-20.09 63 0 35.52 22.81 76.12 67.81 120.68 39 38.66 85.47 70.5 109.67 86a29.72 29.72 0 0 0 32 0c24.2-15.54 70.63-47.38 109.67-86 45-44.56 67.81-85.16 67.81-120.68 0-24-6.95-45.74-20.09-63a90.93 90.93 0 0 0 -48.15-32.44c-34.17-9.28-82.18.42-114.48 55.48a12.49 12.49 0 0 1 -21.56 0c-25.38-43.34-60.54-58.58-91.02-58.58z"/>
                            </svg>
                        `;
                    }
                }
                function updateHeartCount(delta) {
                    const heartCountElements = document.querySelectorAll('.' + response.page + '_side_heart_count');
                    heartCountElements.forEach(element => {
                        const currentCount = parseInt(element.textContent) || 0;
                        element.textContent = currentCount + delta;
                    });
                }
            }
            break;
        case 10:
            if (response.success) {
                // 스크랩 상태에 따라 아이콘과 카운트 업데이트
                if (response.status === 1) {
                    updateScrapCount(1); // 숫자 증가
                    toggleScrap(true);
                } else {
                    updateScrapCount(-1); // 숫자 감소
                    toggleScrap(false); 
                }
                function toggleScrap(isScraped) {
                    const container = document.querySelector('.' + response.page + '_side_scrap_box');
                    const existingInputs = container.querySelectorAll('input');
                    const inputsHTML = Array.from(existingInputs).map(input => input.outerHTML).join('');
                    
                    if (isScraped) {
                        container.innerHTML = `
                            ${inputsHTML}
                            <svg class="${response.page}_side_scrap_check width_px_025 height_px_020" xmlns="http://www.w3.org/2000/svg" height="512" viewBox="0 0 100 100" width="512">
                                <g id="Layer_50" data-name="Layer 50">
                                    <path d="M90.59766 2.28174H9.40234a2 2 0 0 0-2 2v90.71826a2 2 0 0 0 3.00391 1.73l39.59375-22.97414 39.59375 22.97414a2 2 0 0 0 3.00391-1.73V4.28174a2 2 0 0 0-2-2z" fill="#15376b"/>
                                    <path d="M88.59766 91.52734l-37.59375-21.814a2 2 0 0 0-2.00782 0L11.40234 91.52734V6.28174h77.19532z" fill="#15376b"/>
                                </g>
                            </svg>
                        `;
                    } else {
                        container.innerHTML = `
                            ${inputsHTML}
                            <svg class="${response.page}_side_scrap width_px_025 height_px_020" xmlns="http://www.w3.org/2000/svg" height="512" viewBox="0 0 100 100" width="512">
                                <g id="Layer_50" data-name="Layer 50">
                                    <path d="m90.59766 2.28174h-81.19532a2.0001 2.0001 0 0 0 -2 2v90.71826a2.0004 2.0004 0 0 0 3.00391 1.73l39.59375-22.97414 39.59375 22.97414a2.0004 2.0004 0 0 0 3.00391-1.73v-90.71826a2.0001 2.0001 0 0 0 -2-2zm-2 89.2456-37.59375-21.814a2.00123 2.00123 0 0 0 -2.00782 0l-37.59375 21.814v-85.2456h77.19532z"/>
                                </g>
                            </svg>
                        `;
                    }
                }
                function updateScrapCount(delta) {
                    const scrapCountElements = document.querySelectorAll('.' + response.page + '_side_scrap_count');
                    scrapCountElements.forEach(element => {
                        const currentCount = parseInt(element.textContent) || 0;
                        element.textContent = currentCount + delta;
                    });
                }
            }
            break;
        case 11:
            // 공유하기 성공
            if (response.status === 1) {
                updateShareCount(1); // 숫자 증가
                copyToClipboard(); // 클립보드에 URL 복사
            }
            if (response.status === 0) {
                copyToClipboard(); // 클립보드에 URL 복사
            }
            function copyToClipboard() {
                const currentUrl = window.location.href; // 현재 페이지 URL 가져오기
                const tempInput = document.createElement('input');
                document.body.appendChild(tempInput);
                tempInput.value = currentUrl;
                tempInput.select();
                document.execCommand('copy');
                tempInput.remove();

                toggleShareMessage('#share_msg_box1'); // 클립보드 복사 메시지 표시
            }

            function updateShareCount(delta) {
                const shareCountElements = document.querySelectorAll('.' + response.page + '_side_share_count');
                shareCountElements.forEach(element => {
                    const currentCount = parseInt(element.textContent) || 0;
                    element.textContent = currentCount + delta;
                });
            }

            function toggleShareMessage(selector) {
                const element = document.querySelector(selector);
                if(element) {
                    element.classList.remove('display_off');
                    element.style.display = 'block';
                    
                    setTimeout(() => {
                        element.style.display = 'none'; 
                        element.classList.add('display_off');
                    }, 3400);
                }
            }
            break;
        case 12:
            // 블로그 게시글 작성 성공
            if (response.url) {
                window.location.href = response.url;
            }
            break;
        case 13:
            // 유튜브 게시글 작성 성공
            if (response.url) {
                window.location.href = response.url;
            }
            break;
        case 14:
            // 숏츠 게시글 작성 성공
            if (response.url) {
                window.location.href = response.url;
            }
            break;
        case 15:
            // 매뉴얼 게시글 작성 성공
            if (response.url) {
                window.location.href = response.url;
            }
            break;
        case 16:
            // 멘토링 문의 작성 성공
            if (response.url) {
                window.location.href = response.url;
            }
            break;
        case 17:
            // 예약 등록 성공
            alert('예약이 성공적으로 등록되었습니다.');
            if (response.url) {
                window.location.href = response.url;
            }
            break;
        case 18:
        // 예약 정보 갱신 성공
        if (response.data) {
            // 예약 상세 정보 업데이트
            const reservationUserName = document.getElementById('reservation_user_name_header');
            const reservationUserNameDisplay = document.getElementById('reservation_user_name_display');
            const reservationUserPhoneDisplay = document.getElementById('reservation_user_phone_display');
            const reservationNumberDisplay = document.getElementById('reservation_number_display');
            const reservationProductDisplay = document.getElementById('reservation_product_display');
            const reservationDatetimeDisplay = document.getElementById('reservation_datetime_display');
            const reservationCarModelDisplay = document.getElementById('reservation_car_model_display');
            const reservationMaintenanceDisplay = document.getElementById('reservation_maintenance_display');
            const reservationEstimatedTimeDisplay = document.getElementById('reservation_estimated_time_display');
            const reservationStatusIndicator = document.getElementById('reservation_status_indicator');
            const reservationCompleteButton = document.getElementById('reservation_complete_button');
            const reservationStaffMemo = document.getElementById('reservation_staff_memo');
            const reservationCancelReasonBox = document.getElementById('reservation_cancel_reason_box');
            const reservationCancelReasonText = document.getElementById('reservation_cancel_reason_text');
            const reservationGroupUniqId = document.getElementById('reservation_confirm_group_uniq_id');
            const reservationCompleteGroupUniqId = document.getElementById('reservation_complete_group_uniq_id');
            const reservationConfirmButton = document.getElementById('reservation_confirm_button');
            const reservationChangeButton = document.getElementById('reservation_change_button');
            const reservationNoshowButton = document.getElementById('reservation_noshow_button');
            const reservationCancelButton = document.getElementById('reservation_cancel_button');

            // 변경 관련 요소들
            const reservationChangeName = document.getElementById('reservation_change_name');
            const reservationChangeUserInput = document.getElementById('reservation_change_user_input');
            const reservationChangePhoneInput = document.getElementById('reservation_change_phone_input');
            const reservationChangeCarModelInput = document.getElementById('reservation_change_car_model_input');
            const reservationChangeEstimatedTimeInput = document.getElementById('reservation_change_estimated_time_input');
            const reservationChangeMemoInput = document.getElementById('reservation_change_memo_input');
            const reservationChangeProductSelect = document.getElementById('reservation_change_product_select');
            const reservationChangeDateInput = document.getElementById('reservation_change_date_input');
            const reservationChangeTimeSelect = document.getElementById('reservation_change_time_select');
            const reservationChangeGroupUniqId = document.getElementById('reservation_change_group_uniq_id');
            const reservationChangeFormGroupUniqId = document.getElementById('reservation_change_form_group_uniq_id');

            // 취소 관련 요소들
            const reservationCancelName = document.getElementById('reservation_cancel_name');
            const reservationCancelUserDisplay = document.getElementById('reservation_cancel_user_display');
            const reservationCancelNumberDisplay = document.getElementById('reservation_cancel_number_display');
            const reservationCancelProductDisplay = document.getElementById('reservation_cancel_product_display');
            const reservationCancelDatetimeDisplay = document.getElementById('reservation_cancel_datetime_display');
            const reservationCancelReasonInput = document.getElementById('reservation_cancel_reason_input');
            const reservationCancelGroupUniqId = document.getElementById('reservation_cancel_group_uniq_id');

            // 노쇼 관련 요소들
            const reservationNoshowName = document.getElementById('reservation_noshow_name');
            const reservationNoshowUserDisplay = document.getElementById('reservation_noshow_user_display');
            const reservationNoshowNumberDisplay = document.getElementById('reservation_noshow_number_display');
            const reservationNoshowProductDisplay = document.getElementById('reservation_noshow_product_display');
            const reservationNoshowDatetimeDisplay = document.getElementById('reservation_noshow_datetime_display');
            const reservationNoshowNoticeInput = document.getElementById('reservation_noshow_notice_input');
            const reservationNoshowGroupUniqId = document.getElementById('reservation_noshow_group_uniq_id');

            // 이력 관련 요소들
            const reservationRequestHistory = document.getElementById('reservation_request_history');
            const reservationConfirmHistory = document.getElementById('reservation_confirm_history');
            const reservationCompleteHistory = document.getElementById('reservation_complete_history');
            const reservationCancelHistory = document.getElementById('reservation_cancel_history');
            const reservationNoshowHistory = document.getElementById('reservation_noshow_history');

            // 이력 날짜 표시 요소들
            const reservationRequestDate = document.getElementById('reservation_request_date');
            const reservationConfirmDate = document.getElementById('reservation_confirm_date');
            const reservationCompleteDate = document.getElementById('reservation_complete_date');
            const reservationCancelDate = document.getElementById('reservation_cancel_date');
            const reservationNoshowDate = document.getElementById('reservation_noshow_date');

            // 이력 관리자 표시 요소들
            const reservationConfirmAdmin = document.getElementById('reservation_confirm_admin');
            const reservationCompleteAdmin = document.getElementById('reservation_complete_admin');
            const reservationCancelAdmin = document.getElementById('reservation_cancel_admin');
            const reservationNoshowAdmin = document.getElementById('reservation_noshow_admin');

            // 이력 메모 표시 요소들
            const reservationConfirmNote = document.getElementById('reservation_confirm_note');
            const reservationCompleteNote = document.getElementById('reservation_complete_note');
            const reservationCancelNote = document.getElementById('reservation_cancel_note');
            const reservationNoshowNote = document.getElementById('reservation_noshow_note');

            const reservationActionButtons = document.getElementById('reservation_action_buttons');

            const data = response.data;

            // 기본 정보 업데이트
            if (reservationUserName) reservationUserName.textContent = data.user_name;
            if (reservationUserNameDisplay) reservationUserNameDisplay.textContent = data.user_name;
            if (reservationUserPhoneDisplay) reservationUserPhoneDisplay.textContent = data.user_phone_number;
            if (reservationNumberDisplay) reservationNumberDisplay.textContent = data.reservation_group_uniq_id;
            if (reservationProductDisplay) reservationProductDisplay.textContent = data.store_name;
            if (reservationDatetimeDisplay) reservationDatetimeDisplay.textContent = `${data.reservation_date} ${data.reservation_time}`;
            if (reservationCarModelDisplay) reservationCarModelDisplay.textContent = `${data.car_model} (${data.car_model_year})`;
            if (reservationMaintenanceDisplay) {
                const maintenanceLabels = data.car_maintenance_items.map(item => item.label);
                reservationMaintenanceDisplay.textContent = maintenanceLabels.join(', ');
            }
            if (reservationEstimatedTimeDisplay) reservationEstimatedTimeDisplay.textContent = `${data.estimated_time}시간`;
            if (reservationStaffMemo) reservationStaffMemo.value = data.manager_note || '';
            if (reservationGroupUniqId) reservationGroupUniqId.value = data.reservation_group_uniq_id;
            if (reservationCompleteGroupUniqId) reservationCompleteGroupUniqId.value = data.reservation_group_uniq_id;
            if (reservationChangeGroupUniqId) reservationChangeGroupUniqId.value = data.reservation_group_uniq_id;
            if (reservationNoshowGroupUniqId) reservationNoshowGroupUniqId.value = data.reservation_group_uniq_id;
            if (reservationChangeFormGroupUniqId) reservationChangeFormGroupUniqId.value = data.reservation_group_uniq_id;

            // 변경 정보 업데이트
            if (reservationChangeName) reservationChangeName.textContent = data.user_name;
            if (reservationChangeUserInput) reservationChangeUserInput.value = data.user_name;
            if (reservationChangePhoneInput) reservationChangePhoneInput.value = data.user_phone_number;
            if (reservationChangeCarModelInput) reservationChangeCarModelInput.value = data.car_model;
            if (reservationChangeEstimatedTimeInput) reservationChangeEstimatedTimeInput.value = data.estimated_time;
            if (reservationChangeMemoInput) reservationChangeMemoInput.value = data.manager_note || '';
                
            if (reservationChangeProductSelect) {
                // 모든 옵션을 순회하면서 일치하는 값 찾기
                Array.from(reservationChangeProductSelect.options).forEach((option, index) => {
                    // 문자열로 변환하여 비교 (== 대신 === 사용)
                    if (String(option.value) == String(data.reservation_store_uniq_id)) {
                        reservationChangeProductSelect.selectedIndex = index;
                        // 선택된 옵션의 값을 명시적으로 설정
                        reservationChangeProductSelect.value = option.value;
                    }
                });
            }
            if (reservationChangeDateInput) reservationChangeDateInput.value = data.reservation_date;
            if (reservationChangeTimeSelect) reservationChangeTimeSelect.value = data.reservation_time;

            // 노쇼 정보 업데이트
            if (reservationNoshowName) reservationNoshowName.textContent = data.user_name;
            if (reservationNoshowUserDisplay) reservationNoshowUserDisplay.textContent = data.user_name;
            if (reservationNoshowNumberDisplay) reservationNoshowNumberDisplay.textContent = data.uniq_id;
            if (reservationNoshowProductDisplay) reservationNoshowProductDisplay.textContent = data.store_name;
            if (reservationNoshowDatetimeDisplay) reservationNoshowDatetimeDisplay.textContent = `${data.reservation_date} ${data.reservation_time}`;
            if (reservationNoshowNoticeInput) reservationNoshowNoticeInput.value = data.noshow_note || '예약하신 시간에 방문하지 못해 취소되었습니다. 다시 뵙기를 기대하며 예약 후 방문이 어려우시면 사전에 취소 부탁드립니다.';

            // 취소 정보 업데이트
            if (reservationCancelName) reservationCancelName.textContent = data.user_name;
            if (reservationCancelUserDisplay) reservationCancelUserDisplay.textContent = data.user_name;
            if (reservationCancelNumberDisplay) reservationCancelNumberDisplay.textContent = data.uniq_id;
            if (reservationCancelProductDisplay) reservationCancelProductDisplay.textContent = data.store_name;
            if (reservationCancelDatetimeDisplay) reservationCancelDatetimeDisplay.textContent = `${data.reservation_date} ${data.reservation_time}`;
            if (reservationCancelReasonInput) reservationCancelReasonInput.value = data.canceled_note || '고객님의 취소 요청으로 취소합니다. 미리 알려주셔서 감사합니다.';
            if (reservationCancelGroupUniqId) reservationCancelGroupUniqId.value = data.reservation_group_uniq_id;

            // 예약 상태 표시 업데이트
            if (reservationStatusIndicator) {
                let statusText = '';
                let statusColor = '#ff0000aa';
                
                // 날짜 포맷팅 함수
                const formatDate = (dateStr) => {
                    if (!dateStr) return '';
                    const date = new Date(dateStr);
                    const year = date.getFullYear().toString().slice(2);
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    const ampm = hours >= 12 ? '오후' : '오전';
                    const displayHours = hours >= 12 ? hours - 12 : hours;
                    return `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
                };

                // 이력 표시 업데이트 - 각 이력 섹션을 기본적으로 숨김
                if (reservationRequestHistory) reservationRequestHistory.classList.add('display_none');
                if (reservationConfirmHistory) reservationConfirmHistory.classList.add('display_none'); 
                if (reservationCompleteHistory) reservationCompleteHistory.classList.add('display_none');
                if (reservationCancelHistory) reservationCancelHistory.classList.add('display_none');
                if (reservationNoshowHistory) reservationNoshowHistory.classList.add('display_none');

                // 해당하는 이력이 있는 경우에만 표시
                if(data.request_date && reservationRequestHistory) {
                    reservationRequestHistory.classList.remove('display_none');
                    if(reservationRequestDate) reservationRequestDate.textContent = formatDate(data.request_date);
                }

                if(data.confirm_date && reservationConfirmHistory) {
                    reservationConfirmHistory.classList.remove('display_none');
                    if(reservationConfirmDate) reservationConfirmDate.textContent = formatDate(data.confirm_date);
                    if(data.confirm_admin && reservationConfirmAdmin) {
                        reservationConfirmAdmin.textContent = data.confirm_admin;
                    }
                    if(data.confirm_note && reservationConfirmNote) {
                        reservationConfirmNote.textContent = data.confirm_note;
                    }
                }

                if(data.complete_date && reservationCompleteHistory) {
                    reservationCompleteHistory.classList.remove('display_none');
                    if(reservationCompleteDate) reservationCompleteDate.textContent = formatDate(data.complete_date);
                    if(data.complete_admin && reservationCompleteAdmin) {
                        reservationCompleteAdmin.textContent = data.complete_admin;
                    }
                    if(data.complete_note && reservationCompleteNote) {
                        reservationCompleteNote.textContent = data.complete_note;
                    }
                }

                if(data.cancel_date && reservationCancelHistory) {
                    reservationCancelHistory.classList.remove('display_none');
                    if(reservationCancelDate) reservationCancelDate.textContent = formatDate(data.cancel_date);
                    if(data.cancel_admin && reservationCancelAdmin) {
                        reservationCancelAdmin.textContent = data.cancel_admin;
                    }
                    if(data.cancel_note && reservationCancelNote) {
                        reservationCancelNote.textContent = data.cancel_note;
                    }
                }

                if(data.noshow_date && reservationNoshowHistory) {
                    reservationNoshowHistory.classList.remove('display_none');
                    if(reservationNoshowDate) reservationNoshowDate.textContent = formatDate(data.noshow_date);
                    if(data.noshow_admin && reservationNoshowAdmin) {
                        reservationNoshowAdmin.textContent = data.noshow_admin;
                    }
                    if(data.noshow_note && reservationNoshowNote) {
                        reservationNoshowNote.textContent = data.noshow_note;
                    }
                }
                
                switch(data.reservation_status) {
                    case 2:
                        statusText = '확정';
                        statusColor = '#007bff';
                        if(reservationConfirmButton) {
                            reservationConfirmButton.classList.add('display_none');
                        }
                        if (reservationCompleteButton) {
                            reservationCompleteButton.classList.remove('display_none');
                        }
                        if(reservationChangeButton) {
                            reservationChangeButton.classList.add('display_none');
                        }
                        if(reservationNoshowButton) {
                            reservationNoshowButton.classList.remove('display_none');
                        }
                        if(reservationCancelButton) {
                            reservationCancelButton.classList.remove('display_none');
                        }
                        if(reservationCompleteButton) {
                            reservationCompleteButton.classList.remove('display_none');
                        }

                        break;
                    case 3:
                        statusText = '완료';
                        statusColor = '#6c757d';
                        if(reservationConfirmButton) {
                            reservationConfirmButton.classList.add('display_none');
                        }
                        if(reservationChangeButton) {
                            reservationChangeButton.classList.add('display_none');
                        }
                        if(reservationNoshowButton) {
                            reservationNoshowButton.classList.add('display_none');
                        }
                        if(reservationCancelButton) {
                            reservationCancelButton.classList.add('display_none');
                        }
                        if(reservationCompleteButton) {
                            reservationCompleteButton.classList.add('display_none');
                        }
                        break;
                    case 0:
                        statusText = '취소';
                        statusColor = '#ff0000aa';
                        if(reservationCancelReasonBox) {
                            reservationCancelReasonBox.classList.remove('display_off');
                            if(reservationCancelReasonText) {
                                reservationCancelReasonText.textContent = data.canceled_note || '';
                            }
                        }
                        if(reservationConfirmButton) {
                            reservationConfirmButton.classList.add('display_none');
                        }
                        if(reservationChangeButton) {
                            reservationChangeButton.classList.add('display_none');
                        }
                        if(reservationNoshowButton) {
                            reservationNoshowButton.classList.add('display_none');
                        }
                        if(reservationCancelButton) {
                            reservationCancelButton.classList.add('display_none');
                        }
                        if(reservationCompleteButton) {
                            reservationCompleteButton.classList.add('display_none');
                        }
                        break;
                    case 4:
                        statusText = '노쇼';
                        statusColor = '#ff5722';
                        if(reservationCancelReasonBox) {
                            reservationCancelReasonBox.classList.remove('display_off');
                            if(reservationCancelReasonText) {
                                reservationCancelReasonText.textContent = data.noshow_note || '';
                            }
                        }
                        if(reservationConfirmButton) {
                            reservationConfirmButton.classList.add('display_none');
                        }
                        if(reservationChangeButton) {
                            reservationChangeButton.classList.add('display_none');
                        }
                        if(reservationNoshowButton) {
                            reservationNoshowButton.classList.add('display_none');
                        }
                        if(reservationCancelButton) {
                            reservationCancelButton.classList.add('display_none');
                        }
                        if(reservationCompleteButton) {
                            reservationCompleteButton.classList.add('display_none');
                        }
                        break;
                    default:
                        statusText = '신청';
                        statusColor = '#15376b';
                        if (reservationCompleteButton) {
                            reservationCompleteButton.classList.add('display_none');
                        }
                        if(reservationConfirmButton) {
                            reservationConfirmButton.classList.remove('display_none');
                        }
                        if(reservationChangeButton) {
                            reservationChangeButton.classList.remove('display_none');
                        }
                        if(reservationNoshowButton) {
                            reservationNoshowButton.classList.remove('display_none');
                        }
                        if(reservationCancelButton) {
                            reservationCancelButton.classList.remove('display_none');
                        }
                        if(reservationActionButtons) {
                            reservationActionButtons.classList.remove('display_none');
                        }
                }
                    
                reservationStatusIndicator.textContent = statusText;
                reservationStatusIndicator.style.backgroundColor = statusColor;
            }

            // 예약 변경 폼 업데이트
            const reservationChangeForm = document.getElementById('reservation_change_date_form');
            if (reservationChangeForm) {
                const reservationChangeProductHiddenInput = document.getElementById('reservation_change_product_hidden_input');
                const reservationChangeDateHiddenInput = document.getElementById('reservation_change_date_hidden_input');
                const reservationChangeGroupUniqId = document.getElementById('reservation_change_group_uniq_id');

                if (reservationChangeProductHiddenInput) {
                    reservationChangeProductHiddenInput.value = data.reservation_store_uniq_id;
                }
                if (reservationChangeDateHiddenInput) {
                    reservationChangeDateHiddenInput.value = data.reservation_date;
                }
                if (reservationChangeGroupUniqId) {
                    reservationChangeGroupUniqId.value = data.reservation_group_uniq_id;
                }
            }

            
            // 예약 작업 내역 체크박스 업데이트
            if (data.car_maintenance_items && Array.isArray(data.car_maintenance_items)) {
                const checkboxes = document.querySelectorAll('input[name="reservation_car_maintenance_items_info_edit[]"]');
                checkboxes.forEach(checkbox => {
                    const uniqId = checkbox.value;
                    const matchingItem = data.car_maintenance_items.find(item => item.uniq_id === uniqId);
                    if (matchingItem) {
                        checkbox.checked = true;
                    }
                });
            }
        }
            egbAjaxDataHook('reservation_change_date_form', function (data) {
                console.log('예약 날짜 변경:', data);
            });
        break;

        
        case 19:
        // 예약 확정 성공
        alert('예약이 확정되었습니다.');
        if (response.data) {
            const data = response.data;
                
            // 예약 상세 정보 업데이트
            const reservationUserName = document.getElementById('reservation_user_name_header');
            const reservationUserNameDisplay = document.getElementById('reservation_user_name_display');
            const reservationUserPhoneDisplay = document.getElementById('reservation_user_phone_display');
            const reservationNumberDisplay = document.getElementById('reservation_number_display');
            const reservationProductDisplay = document.getElementById('reservation_product_display');
            const reservationDatetimeDisplay = document.getElementById('reservation_datetime_display');
            const reservationCarModelDisplay = document.getElementById('reservation_car_model_display');
            const reservationMaintenanceDisplay = document.getElementById('reservation_maintenance_display');
            const reservationEstimatedTimeDisplay = document.getElementById('reservation_estimated_time_display');
            const reservationStatusIndicator = document.getElementById('reservation_status_indicator');
            const reservationCompleteButton = document.getElementById('reservation_complete_button');
            const reservationStaffMemo = document.getElementById('reservation_staff_memo');
            const reservationGroupUniqId = document.getElementById('reservation_confirm_group_uniq_id');
            const reservationStatus = document.querySelector('.veservation_status_' + data.reservation_group_uniq_id);
            const reservationConfirmButton = document.getElementById('reservation_confirm_button');
            const reservationConfirmDateDisplay = document.getElementById('reservation_confirm_date_display');
            const reservationConfirmedDate = document.getElementById('list_confirmed_date_' + data.reservation_group_uniq_id);

            // 이력 관련 요소들
            const reservationRequestHistory = document.getElementById('reservation_request_history');
            const reservationConfirmHistory = document.getElementById('reservation_confirm_history');
            const reservationRequestDate = document.getElementById('reservation_request_date');
            const reservationConfirmDate = document.getElementById('reservation_confirm_date');
            const reservationConfirmAdmin = document.getElementById('reservation_confirm_admin');
            const reservationChangeButton = document.getElementById('reservation_change_button');
            const reservationNoshowButton = document.getElementById('reservation_noshow_button');
            const reservationCancelButton = document.getElementById('reservation_cancel_button');

            // 기본 정보 업데이트
            if (reservationUserName) reservationUserName.textContent = data.user_name;
            if (reservationUserNameDisplay) reservationUserNameDisplay.textContent = data.user_name;
            if (reservationUserPhoneDisplay) reservationUserPhoneDisplay.textContent = data.user_phone_number;
            if (reservationNumberDisplay) reservationNumberDisplay.textContent = data.uniq_id;
            if (reservationProductDisplay) reservationProductDisplay.textContent = data.store_name;
            if (reservationDatetimeDisplay) reservationDatetimeDisplay.textContent = `${data.reservation_date} ${data.reservation_time}`;
            if (reservationCarModelDisplay) reservationCarModelDisplay.textContent = `${data.car_model} (${data.car_model_year})`;
            if (reservationMaintenanceDisplay) reservationMaintenanceDisplay.textContent = data.car_maintenance_items.join(', ');
            if (reservationEstimatedTimeDisplay) reservationEstimatedTimeDisplay.textContent = `${data.estimated_time}시간`;
            if (reservationStaffMemo) reservationStaffMemo.value = data.manager_note || '';
            if (reservationGroupUniqId) reservationGroupUniqId.value = data.reservation_group_uniq_id;
            if (reservationConfirmDateDisplay) reservationConfirmDateDisplay.textContent = formatDate(data.confirm_date);

            // 상태 표시 업데이트
            if (reservationStatusIndicator) {
                reservationStatusIndicator.textContent = '확정';
                reservationStatusIndicator.style.backgroundColor = '#007bff';
            }
                
            if (reservationStatus) {
                reservationStatus.textContent = '확정';
                reservationStatus.dataset.bgColor = '#007bff';
                reservationStatus.style.backgroundColor = '#007bff';
            }

            if (reservationConfirmedDate) {
                const date = new Date(data.confirm_date);
                const year = date.getFullYear().toString().slice(2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const ampm = hours >= 12 ? '오후' : '오전';
                const displayHours = hours >= 12 ? hours - 12 : hours;
                
                reservationConfirmedDate.textContent = `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
            }

            // 이력 업데이트
            const formatDate = (dateStr) => {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                const year = date.getFullYear().toString().slice(2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const ampm = hours >= 12 ? '오후' : '오전';
                const displayHours = hours >= 12 ? hours - 12 : hours;
                return `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
            };

            if (reservationRequestHistory) {
                reservationRequestHistory.classList.remove('display_none');
                if (reservationRequestDate) reservationRequestDate.textContent = formatDate(data.request_date);
            }
            if (reservationConfirmHistory) {
                reservationConfirmHistory.classList.remove('display_none');
                if (reservationConfirmDate) reservationConfirmDate.textContent = formatDate(data.confirm_date);
                if (reservationConfirmAdmin) reservationConfirmAdmin.textContent = data.confirm_admin;
            }

            // 버튼 표시 상태 업데이트
            if (reservationCompleteButton) {
                reservationCompleteButton.classList.remove('display_none');
            }
            if (reservationConfirmButton) {
                reservationConfirmButton.classList.add('display_none');
            }
            if (reservationChangeButton) {
                reservationChangeButton.classList.add('display_none');
            }
            if (reservationNoshowButton) {
                reservationNoshowButton.classList.remove('display_none');
            }
            if (reservationCancelButton) {
                reservationCancelButton.classList.remove('display_none');
            }
        }
        break;
        case 20:
        // 예약 변경 날짜 선택 시 시간 슬롯 업데이트 
            if (response.data) {
                const timeSelect = document.getElementById('reservation_change_time_select');
                
                if (timeSelect) {
                    // 기존 옵션 제거
                    timeSelect.innerHTML = '';
                    
                    // 새로운 시간 슬롯 추가
                    response.data.time_slots.forEach(slot => {
                        // 시작 시간 옵션 추가
                        const startOption = document.createElement('option');
                        startOption.value = slot.time;
                        if (slot.available_count > 0) {
                            startOption.textContent = `${slot.time} (예약가능: ${slot.available_count}대)`;
                        } else {
                            startOption.textContent = `${slot.time} (마감)`;
                        }
                        
                        // 현재 예약 시간과 동일한 경우 선택
                        if (slot.is_current_time) {
                            startOption.selected = true;
                        }
                        
                        timeSelect.appendChild(startOption);
                    });
                }
            }
            break;

        
            case 21:
        // 예약 취소 성공
        alert('예약이 취소되었습니다.');
        if (response.data) {
            const data = response.data;
            const reservationCancelHistory = document.getElementById('reservation_cancel_history');
            const reservationCancelDate = document.getElementById('reservation_cancel_date');
            const reservationCancelAdmin = document.getElementById('reservation_cancel_admin');
            const reservationCancelNote = document.getElementById('reservation_cancel_note');
            const reservationStatusIndicator = document.getElementById('reservation_status_indicator');
            const reservationStatus = document.querySelector('.veservation_status_' + data.reservation_group_uniq_id);
            const reservationCanceledDate = document.querySelector('#reservation_canceled_date_' + data.reservation_group_uniq_id);
            const listCanceledDate = document.querySelector('#list_canceled_date_' + data.reservation_group_uniq_id);

            // 이력 업데이트
            const reservationRequestHistory = document.getElementById('reservation_request_history');
            const reservationConfirmHistory = document.getElementById('reservation_confirm_history');
            const reservationCompleteHistory = document.getElementById('reservation_complete_history');

            if (reservationRequestHistory) {
                reservationRequestHistory.classList.remove('display_none');
                const requestDate = document.getElementById('reservation_request_date');
                if (requestDate && data.request_date) {
                    const date = new Date(data.request_date);
                    const year = date.getFullYear().toString().slice(2);
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    const ampm = hours >= 12 ? '오후' : '오전';
                    const displayHours = hours >= 12 ? hours - 12 : hours;
                    requestDate.textContent = `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
                }
            }

            if (reservationConfirmHistory && data.confirm_date) {
                reservationConfirmHistory.classList.remove('display_none');
                const confirmDate = document.getElementById('reservation_confirm_date');
                const confirmAdmin = document.getElementById('reservation_confirm_admin');
                if (confirmDate) {
                    const date = new Date(data.confirm_date);
                    const year = date.getFullYear().toString().slice(2);
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    const ampm = hours >= 12 ? '오후' : '오전';
                    const displayHours = hours >= 12 ? hours - 12 : hours;
                    confirmDate.textContent = `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
                }
                if (confirmAdmin) confirmAdmin.textContent = data.confirm_admin;
            }

            if (reservationCompleteHistory && data.complete_date) {
                reservationCompleteHistory.classList.remove('display_none');
                const completeDate = document.getElementById('reservation_complete_date');
                const completeAdmin = document.getElementById('reservation_complete_admin');
                if (completeDate) {
                    const date = new Date(data.complete_date);
                    const year = date.getFullYear().toString().slice(2);
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    const ampm = hours >= 12 ? '오후' : '오전';
                    const displayHours = hours >= 12 ? hours - 12 : hours;
                    completeDate.textContent = `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
                }
                if (completeAdmin) completeAdmin.textContent = data.complete_admin;
            }

            if (reservationCancelHistory) {
                reservationCancelHistory.classList.remove('display_none');
                if (reservationCancelDate && data.cancel_date) {
                    const date = new Date(data.cancel_date);
                    const year = date.getFullYear().toString().slice(2);
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    const ampm = hours >= 12 ? '오후' : '오전';
                    const displayHours = hours >= 12 ? hours - 12 : hours;
                    reservationCancelDate.textContent = `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
                }
                if (reservationCancelAdmin) reservationCancelAdmin.textContent = data.cancel_admin;
                if (reservationCancelNote) reservationCancelNote.textContent = data.canceled_note;
            }

            // 상태 표시 업데이트
            if (reservationStatusIndicator) {
                reservationStatusIndicator.textContent = '취소';
                reservationStatusIndicator.style.backgroundColor = '#ff0000aa';
            }
            
            if (reservationStatus) {
                reservationStatus.textContent = '취소';
                reservationStatus.dataset.bdAColor = 'transparent';
                reservationStatus.dataset.bgColor = '#ff0000aa';
                reservationStatus.dataset.color = '#ffffff';
                reservationStatus.style.backgroundColor = '#ff0000aa';
                reservationStatus.style.color = '#ffffff';
                reservationStatus.classList.add('padding_px-x_010', 'padding_px-y_015', 'border_px-a_001', 'border_bre-a_100', 'notcolor');
            }

            // 모든 버튼 숨기기
            const reservationActionButtons = document.getElementById('reservation_action_buttons');
            if (reservationActionButtons) {
                reservationActionButtons.classList.add('display_none');
            }

            if (reservationCanceledDate) {
                const date = new Date(data.cancel_date);
                const year = date.getFullYear().toString().slice(2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const ampm = hours >= 12 ? '오후' : '오전';
                const displayHours = hours >= 12 ? hours - 12 : hours;
                
                reservationCanceledDate.textContent = `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
            }

            if (listCanceledDate) {
                const date = new Date(data.cancel_date);
                const year = date.getFullYear().toString().slice(2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const ampm = hours >= 12 ? '오후' : '오전';
                const displayHours = hours >= 12 ? hours - 12 : hours;
                
                listCanceledDate.textContent = `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
            }
        }
        break;
        
        case 22:
        // 예약 노쇼 성공
        alert('예약이 노쇼 처리 되었습니다.');
        if (response.data) {
            const data = response.data;
            const reservationNoshowHistory = document.querySelector('.reservation_noshow_history');
            const reservationNoshowDate = document.querySelector('.reservation_noshow_date');
            const reservationNoshowAdmin = document.querySelector('.reservation_noshow_admin');
            const reservationNoshowNote = document.querySelector('.reservation_noshow_note');
            const reservationStatusIndicator = document.getElementById('reservation_status_indicator');
            const reservationStatus = document.querySelector('.veservation_status_' + data.reservation_group_uniq_id);

            if (reservationNoshowHistory) {
                reservationNoshowHistory.classList.remove('display_none');
                if (reservationNoshowDate) reservationNoshowDate.textContent = formatDate(data.noshow_date);
                if (reservationNoshowAdmin) reservationNoshowAdmin.textContent = data.noshow_admin;
                if (reservationNoshowNote) reservationNoshowNote.textContent = data.noshow_note;
            }

            // 상태 표시 업데이트
            if (reservationStatusIndicator) {
                reservationStatusIndicator.textContent = '노쇼';
                reservationStatusIndicator.style.backgroundColor = '#ff5722';
            }
            
            if (reservationStatus) {
                reservationStatus.textContent = '노쇼';
                reservationStatus.dataset.bdAColor = 'transparent';
                reservationStatus.dataset.bgColor = '#ff5722';
                reservationStatus.dataset.color = '#ffffff';
                reservationStatus.style.backgroundColor = '#ff5722';
                reservationStatus.style.color = '#ffffff';
                reservationStatus.classList.add('padding_px-x_010', 'padding_px-y_015', 'border_px-a_001', 'border_bre-a_100', 'notcolor');
            }

            // 모든 버튼 숨기기
            const reservationActionButtons = document.getElementById('reservation_action_buttons');
            if (reservationActionButtons) {
                reservationActionButtons.classList.add('display_none');
            }
        }
        break;
        
        case 23:
        // 이용 완료 성공
        alert('이용이 완료되었습니다.');
        if (response.data) {
            const data = response.data;
            const reservationChangeButton = document.querySelector('#reservation_change_button');
            const reservationNoshowButton = document.querySelector('#reservation_noshow_button');
            const reservationCancelButton = document.querySelector('#reservation_cancel_button');
            const reservationConfirmButton = document.querySelector('#reservation_confirm_button');
            const reservationCompleteButton = document.querySelector('#reservation_complete_button');
            const reservationStatusIndicator = document.getElementById('reservation_status_indicator');
            const reservationStatus = document.querySelector('.veservation_status_' + data.reservation_group_uniq_id);
            const reservationCompleteHistory = document.getElementById('reservation_complete_history');
            const reservationCompleteDate = document.getElementById('reservation_complete_date');
            const reservationCompleteAdmin = document.getElementById('reservation_complete_admin');
            const reservationCompleteNote = document.getElementById('reservation_complete_note');
            const listCompletedDate = document.querySelector('#list_completed_date_' + data.reservation_group_uniq_id);

            // 이력 업데이트
            if (reservationCompleteHistory) {
                reservationCompleteHistory.classList.remove('display_none');
                if (reservationCompleteDate) {
                    const date = new Date(data.complete_date);
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    reservationCompleteDate.textContent = `${year}-${month}-${day} ${hours}:${minutes}`;
                }
                if (reservationCompleteAdmin) reservationCompleteAdmin.textContent = data.complete_admin;
                if (reservationCompleteNote) reservationCompleteNote.textContent = data.complete_note;
            }

            // 상태 표시 업데이트
            if (reservationStatusIndicator) {
                reservationStatusIndicator.textContent = '완료';
                reservationStatusIndicator.style.backgroundColor = '#6c757d';
            }
            if (reservationStatus) {
                reservationStatus.textContent = '완료';
                reservationStatus.dataset.bdAColor = 'transparent';
                reservationStatus.dataset.bgColor = '#6c757d';
                reservationStatus.dataset.color = '#ffffff';
                reservationStatus.style.backgroundColor = '#6c757d';
                reservationStatus.style.color = '#ffffff';
                reservationStatus.classList.add('padding_px-x_010', 'padding_px-y_015', 'border_px-a_001', 'border_bre-a_100', 'notcolor');
            }

            // 완료일시 업데이트
            if (listCompletedDate) {
                const date = new Date(data.complete_date);
                const year = String(date.getFullYear()).slice(-2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                const hours = date.getHours();
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const ampm = hours >= 12 ? '오후' : '오전';
                const displayHours = hours >= 12 ? hours - 12 : hours;
                
                listCompletedDate.textContent = `${year}.${month}.${day}(${weekday}) ${ampm} ${String(displayHours).padStart(2, '0')}:${minutes}`;
            }

            // 모든 버튼 숨기기
            if (reservationChangeButton) {
                reservationChangeButton.classList.add('display_none');
            }
            if (reservationNoshowButton) {
                reservationNoshowButton.classList.add('display_none');
            }
            if (reservationCancelButton) {
                reservationCancelButton.classList.add('display_none');
            }
            if (reservationConfirmButton) {
                reservationConfirmButton.classList.add('display_none');
            }
            if (reservationCompleteButton) {
                reservationCompleteButton.classList.add('display_none');
            }
        }
        break;

        
        case 24:
        // 예약 변경 성공
        alert('예약이 변경되었습니다.');
        if (response.data) {
            const data = response.data;
            // 예약 정보 업데이트
            const reservationDatetimeDisplay = document.querySelector('#reservation_datetime_display');
            if (reservationDatetimeDisplay) {
                const date = new Date(data.reservation_date);
                const year = String(date.getFullYear()).slice(-2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                
                // 시간 정보에서 소요시간 중복 제거
                const timeInfo = data.reservation_time.split('(')[0].trim();
                reservationDatetimeDisplay.textContent = `${year}.${month}.${day}(${weekday}) ${timeInfo} (${data.estimated_time}시간)`;
            }
            const reservationCarModelDisplay = document.querySelector('#reservation_car_model_display');
            if (reservationCarModelDisplay) {
                reservationCarModelDisplay.textContent = data.car_model;
            }
            const reservationMaintenanceDisplay = document.querySelector('#reservation_maintenance_display');
            if (reservationMaintenanceDisplay) {
                reservationMaintenanceDisplay.textContent = data.car_maintenance_items.join(', ');
            }
            const reservationEstimatedTimeDisplay = document.querySelector('#reservation_estimated_time_display');
            if (reservationEstimatedTimeDisplay) {
                reservationEstimatedTimeDisplay.textContent = `${data.estimated_time}시간`;
            }
            // 리스트 요소 업데이트
            const listDateElement = document.querySelector('#list_date_' + data.reservation_group_uniq_id);
            if (listDateElement) {
                listDateElement.classList.add('min_width_250', 'flex_xc_yc', 'border_px-r_001', 'border_px-u_001', 'padding_px-y_015');
                listDateElement.dataset.bdAColor = '#d9d9d9';
                
                const date = new Date(data.reservation_date);
                const year = String(date.getFullYear()).slice(-2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                
                // 시간 정보에서 소요시간 중복 제거
                const timeInfo = data.reservation_time.split('(')[0].trim();
                listDateElement.textContent = `${year}.${month}.${day}(${weekday}) ${timeInfo} (${data.estimated_time}시간)`;
            }
            
            const listStoreElement = document.querySelector('#list_store_' + data.reservation_group_uniq_id);
            if (listStoreElement) {
                listStoreElement.classList.add('min_width_150', 'flex_xc_yc', 'border_px-r_001', 'border_px-u_001', 'padding_px-y_015', 'equipment_type');
                listStoreElement.dataset.bdAColor = '#d9d9d9';
                listStoreElement.textContent = data.store_name;
            }
        }
        break;
        
        
        case 25:
        if (response.data && response.data.length > 0) {
            const data = response.data;
            // 예약 리스트 컨테이너 초기화
            const reservationList = document.querySelector('#reservation_list');
            // 총 건수 업데이트
            const totalCount = document.querySelector('#total_count');
            if (totalCount) {
                totalCount.textContent = data.length;
            }
            
            if (reservationList) {
                // 헤더를 제외한 모든 예약 항목 제거
                const header = reservationList.querySelector('.position4');
                reservationList.innerHTML = '';
                if (header) {
                    reservationList.appendChild(header);
                }
                // 새로운 예약 데이터 추가
                data.forEach(row => {
                    // 상태 텍스트와 배경색 설정
                    let statusText = '';
                    let statusBgColor = '';
                    switch (parseInt(row.status)) {
                        case 0:
                            statusText = '취소';
                            statusBgColor = '#ff0000aa';
                            break;
                        case 1:
                            statusText = '신청';
                            statusBgColor = '#15376b';
                            break;
                        case 2:
                            statusText = '확정';
                            statusBgColor = '#007bff';
                            break;
                        case 3:
                            statusText = '완료';
                            statusBgColor = '#6c757d';
                            break;
                        case 4:
                            statusText = '노쇼';
                            statusBgColor = '#ff5722';
                            break;
                    }
                    // 날짜 포맷팅
                    const date = new Date(row.reservation_date);
                    const weekdays = ['일', '월', '화', '수', '목', '금', '토'];
                    
                    // reservation_data에서 estimated_time 추출
                    const reservationData = JSON.parse(row.reservation_data);
                    const estimatedTime = reservationData.estimated_time;
                    
                    // 시작 시간과 종료 시간 계산
                    const startTime = row.reservation_time.split(':')[0] + ':' + row.reservation_time.split(':')[1];
                    const endTime = new Date(date);
                    const [hours, minutes] = startTime.split(':');
                    endTime.setHours(parseInt(hours) + parseInt(estimatedTime));
                    endTime.setMinutes(parseInt(minutes));
                    
                    const formattedDate = `${String(date.getFullYear()).slice(-2)}.${String(date.getMonth() + 1).padStart(2, '0')}.${String(date.getDate()).padStart(2, '0')}(${weekdays[date.getDay()]}) ${startTime} ~ ${endTime.getHours().toString().padStart(2, '0')}:${endTime.getMinutes().toString().padStart(2, '0')} (${estimatedTime}시간)`;
                    // 날짜 포맷팅 함수
                    const formatDateTime = (dateStr) => {
                        if (!dateStr) return '-';
                        const date = new Date(dateStr);
                        const year = String(date.getFullYear()).slice(-2);
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const day = String(date.getDate()).padStart(2, '0');
                        const weekday = ['일', '월', '화', '수', '목', '금', '토'][date.getDay()];
                        const hours = String(date.getHours()).padStart(2, '0');
                        const minutes = String(date.getMinutes()).padStart(2, '0');
                        const ampm = date.getHours() < 12 ? '오전' : '오후';
                        return `${year}.${month}.${day}(${weekday}) ${ampm} ${hours}:${minutes}`;
                    };
                    // 예약 항목 생성
                    const formElement = document.createElement('form');
                    formElement.id = `reservation_details_form_input_${row.reservation_group_uniq_id}`;
                    formElement.action = '/?post=reservation_details_form_input';
                    formElement.method = 'post';
                    formElement.className = 'reservation_details_form';
                    // Hidden inputs 추가
                    const hiddenInputGroup = document.createElement('input');
                    hiddenInputGroup.type = 'hidden';
                    hiddenInputGroup.name = 'reservation_group_uniq_id';
                    hiddenInputGroup.value = row.reservation_group_uniq_id;
                    formElement.appendChild(hiddenInputGroup);
                    const hiddenInputCsrf = document.createElement('input');
                    hiddenInputCsrf.type = 'hidden';
                    hiddenInputCsrf.name = 'csrf_token';
                    hiddenInputCsrf.value = document.querySelector('input[name="csrf_token"]').value;
                    formElement.appendChild(hiddenInputCsrf);
                    const reservationItem = document.createElement('div');
                    reservationItem.className = `egb_submit flex_fl pointer reservation_user_details_box_open reservation_id_${row.reservation_group_uniq_id} bg-color-ffffff bd-a-color-d9d9d9`;
                    reservationItem.setAttribute('data-bg-color', '#ffffff');
                    reservationItem.setAttribute('data-bd-a-color', '#d9d9d9');
                    
                    reservationItem.innerHTML = `
                        <div class="min_width_070 flex_xc_yc border_px-x_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">
                            <div id="list_status_${row.reservation_group_uniq_id}" class="padding_px-x_010 padding_px-y_015 border_px-a_001 border_bre-a_100 notcolor veservation_status_${row.reservation_group_uniq_id} bd-a-color-transparent bg-color-${statusBgColor.substring(1)} color-ffffff" data-bd-a-color="transparent" data-bg-color="${statusBgColor}" data-color="#ffffff">${statusText}</div>
                        </div>
                        <div id="list_user_name_${row.reservation_group_uniq_id}" class="min_width_100 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${row.user_name || ''}</div>
                        <div id="list_user_phone_${row.reservation_group_uniq_id}" class="min_width_180 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${row.user_phone || ''}</div>
                        <div id="list_group_id_${row.reservation_group_uniq_id}" class="min_width_130 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${row.reservation_group_uniq_id || ''}</div>
                        <div id="list_date_${row.reservation_group_uniq_id}" class="min_width_250 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formattedDate}</div>
                        <div id="list_store_${row.reservation_group_uniq_id}" class="min_width_150 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 equipment_type bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${row.store_name || ''}</div>
                        <div id="list_applied_date_${row.reservation_group_uniq_id}" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formatDateTime(row.reservation_applied_at)}</div>
                        <div id="list_confirmed_date_${row.reservation_group_uniq_id}" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formatDateTime(row.reservation_confirmed_at)}</div>
                        <div id="list_canceled_date_${row.reservation_group_uniq_id}" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formatDateTime(row.reservation_canceled_at)}</div>
                        <div id="list_completed_date_${row.reservation_group_uniq_id}" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formatDateTime(row.reservation_completed_at)}</div>
                    `;
                    formElement.appendChild(reservationItem);
                    reservationList.appendChild(formElement);
                });
            }
        } else {
            alert('검색 결과가 없습니다.');
            // 결과가 없을 경우 카운트를 0으로 설정
            const totalCount = document.querySelector('#total_count');
            if (totalCount) {
                totalCount.textContent = '0';
            }
        }
        break;
        
        case 26:
            // 예약 목록 스크롤 업데이트 성공
            if (response.data && Array.isArray(response.data)) {
                const reservationList = document.querySelector('#reservation_list');
                if (!reservationList) return;
                // 총 카운트 업데이트
                const totalCount = document.querySelector('#total_count');
                if (totalCount) {
                    const currentCount = parseInt(totalCount.textContent);
                    totalCount.textContent = (currentCount + response.data.length).toString();
                }
                response.data.forEach(row => {
                    // 상태에 따른 배경색과 텍스트 설정
                    let statusText = '';
                    let statusBgColor = '';
                    
                    switch(parseInt(row.status)) {
                        case 0:
                            statusText = '취소';
                            statusBgColor = '#ff0000aa';
                            break;
                        case 1:
                            statusText = '신청';
                            statusBgColor = '#15376b';
                            break;
                        case 2:
                            statusText = '확정';
                            statusBgColor = '#007bff';
                            break;
                        case 3:
                            statusText = '완료';
                            statusBgColor = '#6c757d';
                            break;
                        case 4:
                            statusText = '노쇼';
                            statusBgColor = '#ff5722';
                            break;
                    }
                    // 날짜 포맷팅
                    const date = new Date(row.reservation_date);
                    const weekdays = ['일', '월', '화', '수', '목', '금', '토'];
                    
                    // reservation_data에서 estimated_time 추출
                    const reservationData = JSON.parse(row.reservation_data);
                    const estimatedTime = reservationData.estimated_time;
                    
                    // 시작 시간과 종료 시간 계산
                    const startTime = row.reservation_time.split(':')[0] + ':' + row.reservation_time.split(':')[1];
                    const endTime = new Date(date);
                    const [hours, minutes] = startTime.split(':');
                    endTime.setHours(parseInt(hours) + parseInt(estimatedTime));
                    endTime.setMinutes(parseInt(minutes));
                    
                    const formattedDate = `${String(date.getFullYear()).slice(-2)}.${String(date.getMonth() + 1).padStart(2, '0')}.${String(date.getDate()).padStart(2, '0')}(${weekdays[date.getDay()]}) ${startTime} ~ ${endTime.getHours().toString().padStart(2, '0')}:${endTime.getMinutes().toString().padStart(2, '0')} (${estimatedTime}시간)`;
                    // 날짜/시간 포맷팅 함수
                    const formatDateTime = (dateTimeStr) => {
                        if (!dateTimeStr) return '';
                        const dt = new Date(dateTimeStr);
                        return `${dt.getFullYear()}-${String(dt.getMonth() + 1).padStart(2, '0')}-${String(dt.getDate()).padStart(2, '0')} ${String(dt.getHours()).padStart(2, '0')}:${String(dt.getMinutes()).padStart(2, '0')}:${String(dt.getSeconds()).padStart(2, '0')}`;
                    };
                    // 예약 아이템 폼 생성
                    const formElement = document.createElement('form');
                    formElement.id = `reservation_details_form_input_${row.reservation_group_uniq_id}`;
                    formElement.action = '/?post=reservation_details_form_input';
                    formElement.method = 'post';
                    formElement.className = 'reservation_details_form';
                    // Hidden inputs 추가
                    const hiddenInputGroup = document.createElement('input');
                    hiddenInputGroup.type = 'hidden';
                    hiddenInputGroup.name = 'reservation_group_uniq_id';
                    hiddenInputGroup.value = row.reservation_group_uniq_id;
                    formElement.appendChild(hiddenInputGroup);
                    const hiddenInputCsrf = document.createElement('input');
                    hiddenInputCsrf.type = 'hidden';
                    hiddenInputCsrf.name = 'csrf_token';
                    hiddenInputCsrf.value = document.querySelector('input[name="csrf_token"]').value;
                    formElement.appendChild(hiddenInputCsrf);
                    const reservationItem = document.createElement('div');
                    reservationItem.className = `egb_submit flex_fl pointer reservation_user_details_box_open reservation_id_${row.reservation_group_uniq_id} bg-color-ffffff bd-a-color-d9d9d9`;
                    reservationItem.setAttribute('data-bg-color', '#ffffff');
                    reservationItem.setAttribute('data-bd-a-color', '#d9d9d9');
                    
                    reservationItem.innerHTML = `
                        <div class="min_width_070 flex_xc_yc border_px-x_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">
                            <div id="list_status_${row.reservation_group_uniq_id}" class="padding_px-x_010 padding_px-y_015 border_px-a_001 border_bre-a_100 notcolor veservation_status_${row.reservation_group_uniq_id} bd-a-color-transparent bg-color-${statusBgColor.substring(1)} color-ffffff" data-bd-a-color="transparent" data-bg-color="${statusBgColor}" data-color="#ffffff">${statusText}</div>
                        </div>
                        <div id="list_user_name_${row.reservation_group_uniq_id}" class="min_width_100 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${row.user_name || ''}</div>
                        <div id="list_user_phone_${row.reservation_group_uniq_id}" class="min_width_180 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${row.user_phone || ''}</div>
                        <div id="list_group_id_${row.reservation_group_uniq_id}" class="min_width_130 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${row.reservation_group_uniq_id || ''}</div>
                        <div id="list_date_${row.reservation_group_uniq_id}" class="min_width_250 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formattedDate}</div>
                        <div id="list_store_${row.reservation_group_uniq_id}" class="min_width_150 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 equipment_type bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${row.store_name || ''}</div>
                        <div id="list_applied_date_${row.reservation_group_uniq_id}" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formatDateTime(row.reservation_applied_at)}</div>
                        <div id="list_confirmed_date_${row.reservation_group_uniq_id}" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formatDateTime(row.reservation_confirmed_at)}</div>
                        <div id="list_canceled_date_${row.reservation_group_uniq_id}" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formatDateTime(row.reservation_canceled_at)}</div>
                        <div id="list_completed_date_${row.reservation_group_uniq_id}" class="min_width_200 flex_xc_yc border_px-r_001 border_px-u_001 padding_px-y_015 bd-a-color-d9d9d9" data-bd-a-color="#d9d9d9">${formatDateTime(row.reservation_completed_at)}</div>
                    `;
                    formElement.appendChild(reservationItem);
                    reservationList.appendChild(formElement);
                });
            }
        break;
        case 27:
            alert('엑셀 파일이 다운로드 되었습니다.');
        break;
        
        
        case 28:
            if (response.success && response.data) {
                const replies = response.data;
                const commentId = replies[0].comment_id;
                const repliesContainer = document.querySelector(`.replies_wrapper_${commentId}`);
                const viewRepliesBtn = document.querySelector(`.view_replies_btn_${commentId}`);

                if (repliesContainer) {
                    repliesContainer.innerHTML = '';

                    replies.forEach(reply => {
                        const replyElement = document.createElement('div');
                        replyElement.id = `item_${reply.uniq_id}`;
                        replyElement.className = 'comment_item';
                        replyElement.innerHTML = `
                            <div id="comment_${reply.uniq_id}" class="comment_box flex_fl padding_px-y_010 margin_px-y_005 padding_px-l_030" style="background-color: #f7f9fa;">
                                <div class="flex_fl min_width_060 max_width_060 width_box max_height_040 pointer">
                                    <img src="${DOMAIN}${THEMES_PATH}/img/icon/profile.svg" class="width_px_040 height_px_040 border_bre-a_035">
                                </div>
                                <div class="flex_ft width_box font_px_016">
                                    <div class="flv6 pointer">${reply.user_nick_name}</div>
                                    <div class="padding_px-y_008">${reply.comment_contents}</div>
                                    <div class="flex_fl_yc_wrap font_px_012" data-color="#888888">
                                        <div>${reply.created_at}</div>
                                        <div>・</div>
                                        <div class="pointer flex_fl_yc">
                                            <img class="width_px_016 height_px_016" src="${DOMAIN}${THEMES_PATH}/img/icon/heart.svg">
                                            <div>좋아요</div>
                                        </div>
                                        <div>・</div>
                                        <div class="comment_recomment recomment_${reply.uniq_id} pointer" data-comment-id="${reply.uniq_id}">
                                            댓글달기
                                        </div>
                                        ${reply.reply_count > 0 ? `
                                        <div>・</div>
                                        <form class="view_replies_form" method="POST" action="${DOMAIN}/?post=auto_comment_view_replies_form_input">
                                            <input type="hidden" name="csrf_token" value="${egbCsrfToken}">
                                            <input type="hidden" id="comment_id_${reply.uniq_id}" name="comment_id" value="${reply.uniq_id}">
                                            <input type="hidden" name="table_name" value="${reply.table_name}">
                                            <div class="egb_submit toggle_replies pointer view_replies_btn_${reply.uniq_id}" data-comment-id="${reply.uniq_id}" data-reply-count="${reply.reply_count}" style="color: #15376b">
                                                댓글 보기 (${reply.reply_count})
                                            </div>
                                        </form>
                                        ` : ''}
                                        <div>・</div>
                                        <div class="pointer">신고</div>
                                    </div>
                                </div>
                            </div>
                            <div class="replies_container replies_wrapper_${reply.uniq_id}" id="replies_${reply.uniq_id}" style="display: none;"></div>
                        `;
                        repliesContainer.appendChild(replyElement);
                    });

                    if (viewRepliesBtn) {
                        const newBtn = document.createElement('div');
                        newBtn.className = 'toggle_replies pointer view_replies_btn_' + commentId;
                        newBtn.textContent = `댓글 숨기기 (${replies.length})`;
                        newBtn.dataset.commentId = commentId;
                        newBtn.dataset.replyCount = replies.length;
                        newBtn.style.color = '#15376b';
                        viewRepliesBtn.parentNode.replaceChild(newBtn, viewRepliesBtn);
                    }

                    repliesContainer.style.display = 'block';
                }
            }
            break;
        case 29:
            if (response.data && response.data.length > 0) {
            const commentList = document.getElementById('comment_list');
            
            response.data.forEach(comment => {
                const commentElement = document.createElement('div');
                commentElement.id = `item_${comment.uniq_id}`;
                commentElement.className = 'comment_item';
                commentElement.innerHTML = `
                    <div id="comment_${comment.uniq_id}" class="comment_box flex_fl padding_px-y_010">
                        <div class="flex_fl min_width_060 max_width_060 width_box max_height_040 pointer">
                            <img src="${DOMAIN}${THEMES_PATH}/img/icon/profile.svg" 
                                class="width_px_040 height_px_040 border_bre-a_035">
                        </div>
                        <div class="flex_ft width_box font_px_016">
                            <div class="flv6 pointer">${comment.user_nick_name}</div>
                            <div class="padding_px-y_008">
                                ${comment.comment_contents}
                            </div>
                            <div class="flex_fl_yc_wrap font_px_012" data-color="#888888">
                                <div>${comment.created_at}</div>
                                <div>・</div>
                                <div class="pointer flex_fl_yc">
                                    <img class="width_px_016 height_px_016" 
                                        src="${DOMAIN}${THEMES_PATH}/img/icon/heart.svg">
                                    <div>좋아요</div>
                                </div>
                                <div>・</div>
                                <div class="comment_recomment recomment_${comment.uniq_id} pointer" data-comment-id="${comment.uniq_id}">
                                    댓글달기
                                </div>
                                ${comment.reply_count && comment.reply_count > 0 ? `
                                <div>・</div>
                                <form class="view_replies_form" method="POST" action="${DOMAIN}/?post=auto_comment_view_replies_form_input">
                                    <input type="hidden" name="csrf_token" value="${egbCsrfToken}">
                                    <input type="hidden" id="comment_id_${comment.uniq_id}" name="comment_id" value="${comment.uniq_id}">
                                    <input type="hidden" name="table_name" value="${comment.table_name}">
                                    <div class="egb_submit toggle_replies pointer view_replies_btn_${comment.uniq_id}" data-comment-id="${comment.uniq_id}" data-reply-count="${comment.reply_count}" style="color: #15376b">
                                        댓글 보기 (${comment.reply_count})
                                    </div>
                                </form>
                                ` : ''}
                                <div>・</div>
                                <div class="pointer">신고</div>
                            </div>
                        </div>
                    </div>
                    <div class="replies_container replies_wrapper_${comment.uniq_id}" id="replies_${comment.uniq_id}" style="display: none;"></div>
                `;
                
                commentList.appendChild(commentElement);
            });
        }
        break;
        case 30:
            if (response.success) {
                const alarmList = document.getElementById('alarm_list_scroll');
                const alarmData = response.data.alarms;
                const unreadCount = response.data.unread_count;
                
                // 알림 아이콘 상태 업데이트
                const alarmRedCheck = document.getElementById('alarm_red_check');
                if (alarmRedCheck) {
                    if (unreadCount > 0) {
                        alarmRedCheck.classList.remove('display_off');
                    } else {
                        alarmRedCheck.classList.add('display_off'); 
                    }
                }

                // 알림 목록 내용 업데이트
                if (alarmList) {
                    let html = '<div id="alarm_list_title" class="position4 font_px_016 flv6 padding_px-t_020 padding_px-u_010" data-bg-color="#f9f9f9" data-top="0%">알림</div>';
                    
                    if (alarmData.length > 0) {
                        alarmData.forEach(alarm => {
                            html += `
                                <form id="alarm_form_${alarm.uniq_id}" method="POST" action="${DOMAIN}/?post=egb_alarm_read_input">
                                    <input type="hidden" name="csrf_token" value="${egbCsrfToken}">
                                    <input type="hidden" name="alarm_uniq_id" value="${alarm.uniq_id}">
                                    <input type="hidden" name="redirect_url" value="${alarm.link}">
                                    <input type="hidden" name="from_page" value="header">
                                    <button id="alarm_item_${alarm.uniq_id}" type="submit" class="block_link width_box" style="border:none; background:none; text-align:left;">
                                        <div class="border_px-u_001 padding_px-y_010 pointer hover_item" data-bd-a-color="#d9d9d9">
                                            <div class="flex_xr flv6" data-color="#888888">${alarm.created_at}</div>
                                            <div class="flex_xs1_yc padding_px-y_010">
                                                <div class="flex_ft font_px_017 flv6">
                                                    <span class="flex_fl_yc">${alarm.title}</span>
                                                    <span>${alarm.message}</span>
                                                </div>
                                                <div class="width_px_024 height_px_024 svg_container" fill="#999999">
                                                    <svg class="svg_hover" fill="#888888" height="100%" viewBox="0 0 24 24" width="100%" xmlns="http://www.w3.org/2000/svg">
                                                        <path clip-rule="evenodd" d="m7.57613 3.57573c.23431-.23431.61421-.23431.84852 0l8.00005 7.99997c.2343.2343.2343.6142 0 .8486l-8.00005 8c-.23431.2343-.61421.2343-.84852 0-.23432-.2344-.23432-.6143 0-.8486l7.57577-7.5757-7.57577-7.57574c-.23432-.23432-.23432-.61422 0-.84853z" fill-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="font_px_012 padding_px-u_020" data-color="#888888">알림 내용을 자세히 확인해보세요.</div>
                                        </div>
                                    </button>
                                </form>
                            `;
                        });
                    } else {
                        html += '<div id="no_alarm_message">알림이 없습니다.</div>';
                    }
                    
                    alarmList.innerHTML = html;
                }
            }
            break;
        default:
        alert('Unknown error: successCode ' + successCode + ' - 알 수 없는 에러가 발생했습니다.');
    }
}