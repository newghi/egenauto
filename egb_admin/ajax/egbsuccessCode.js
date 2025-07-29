function egbsuccessCode(response) {
	const successCode = response.successCode;
    // 성공 코드에 따른 메시지 처리를 사용자가 직접 작성
    switch (successCode) {
        case 0:
           //
            break;
        case 1:
            alert('컬럼 설정이 성공적으로 저장되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 2:
            alert('상태가 성공적으로 변경되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 3:
            alert('엑셀 파일이 성공적으로 다운로드 되었습니다.');
            break;
        case 4:
            alert('엑셀 파일이 성공적으로 업로드 되었습니다.');
            document.getElementById(response.filter_menu_name + '_excel_file').value = '';
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 5:
            alert('삭제가 성공적으로 완료되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 6:
            alert('해당 데이터가 영구 삭제 되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 7:
            alert('페이지 생성이 성공적으로 완료되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input, true);
            break;
        case 8:
            alert('페이지 수정이 성공적으로 완료되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input, true);
            break;
        case 9:
            alert('옵션 그룹이 성공적으로 추가되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 10:
            alert('옵션 그룹이 성공적으로 수정되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 11:
            let optionGroupSelect;
            if(response.mode == 'add'){
                optionGroupSelect = document.querySelector('#option_group_uniq_id_add');
            }else{
                optionGroupSelect = document.querySelector('#option_group_uniq_id_edit');
            }
            if (response.data) {
                optionGroupSelect.innerHTML = '<option value="">그룹 옵션 선택</option>';

                // 반환된 데이터가 있는지 확인 
                if (Array.isArray(response.data) && response.data.length > 0) {
                    response.data.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.value = option.uniq_id;
                        optionElement.textContent = `${option.group_title} (${option.group_code})`;
                        optionGroupSelect.appendChild(optionElement);
                    });
                } else {
                    // 검색 결과가 없는 경우의 옵션 추가
                    const noResultOption = document.createElement('option');
                    noResultOption.value = '';
                    noResultOption.textContent = '검색 결과가 없습니다';
                    noResultOption.disabled = true;
                    optionGroupSelect.appendChild(noResultOption);
                }
            } else {
                // 검색 실패 시의 기본 옵션 설정
                optionGroupSelect.innerHTML = '<option value="">부모 옵션 선택</option>';
            }
            
            break;           
        case 12:
            let optionParentSelect;
            if (response.mode == 'add') {
                optionParentSelect = document.querySelector('#option_parent_uniq_id_add');
            } else {
                optionParentSelect = document.querySelector('#option_parent_uniq_id_edit');
            }
            if (response.data) {
                optionParentSelect.innerHTML = '<option value="">부모 옵션 선택</option>';
                
                // 반환된 데이터가 있는지 확인 
                if (Array.isArray(response.data) && response.data.length > 0) {
                    response.data.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.value = option.uniq_id;
                        optionElement.textContent = `${option.option_label} (${option.option_depth})`;
                        optionParentSelect.appendChild(optionElement);
                    });
                } else {
                    // 검색 결과가 없는 경우의 옵션 추가
                    const noResultOption = document.createElement('option');
                    noResultOption.value = '';
                    noResultOption.textContent = '검색 결과가 없습니다';
                    noResultOption.disabled = true;
                    optionParentSelect.appendChild(noResultOption);
                }
            } else {
                // 검색 실패 시의 기본 옵션 설정
                    optionParentSelect.innerHTML = '<option value="">부모 옵션 선택</option>';
                }
            break;
        case 13:
            alert('옵션이 성공적으로 추가되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 14:
            alert('옵션이 성공적으로 수정되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 15:
            alert('이벤트가 성공적으로 추가되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 16:
            alert('이벤트가 성공적으로 수정되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 17:
            const depositMemberSelect = document.querySelector('select[name="deposit_target_uniq_id"]');
            const userKeywordInput1 = document.querySelector('#user_keyword_deposit');
            if (response.data && Array.isArray(response.data) && response.data.length > 0) {
                depositMemberSelect.innerHTML = '<option value="">회원 선택</option>';
                response.data.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.uniq_id;
                    option.textContent = `${user.user_nick_name} (${user.user_name})`;
                    depositMemberSelect.appendChild(option);
                });
                depositMemberSelect.value = response.data[0].uniq_id;
                userKeywordInput1.focus();
            } else {
                depositMemberSelect.innerHTML = '<option value="">회원 선택</option>';
                const noResultOption = document.createElement('option');
                noResultOption.value = '';
                noResultOption.textContent = '검색 결과가 없습니다';
                noResultOption.disabled = true;
                depositMemberSelect.appendChild(noResultOption);
                userKeywordInput1.focus();
            }
            break;
        case 18:
            alert('예치금이 성공적으로 추가되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 19:
            alert('적립금이 성공적으로 추가되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 20:
            const pointMemberSelect = document.querySelector('select[name="point_target_uniq_id"]');
            const userKeywordInput2 = document.querySelector('#user_keyword_point');
            if (response.data && Array.isArray(response.data) && response.data.length > 0) {
                pointMemberSelect.innerHTML = '<option value="">회원 선택</option>';
                response.data.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.uniq_id;
                    option.textContent = `${user.user_nick_name} (${user.user_name})`;
                    pointMemberSelect.appendChild(option);
                });
                pointMemberSelect.value = response.data[0].uniq_id;
                userKeywordInput2.focus();
            } else {
                pointMemberSelect.innerHTML = '<option value="">회원 선택</option>';
                const noResultOption = document.createElement('option');
                noResultOption.value = '';
                noResultOption.textContent = '검색 결과가 없습니다';
                noResultOption.disabled = true;
                pointMemberSelect.appendChild(noResultOption);
                userKeywordInput2.focus();
            }
            break;
        case 21:
            alert('마일리지가 성공적으로 추가되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        case 22:
            const mileageMemberSelect = document.querySelector('select[name="mileage_target_uniq_id"]');
            const userKeywordInput3 = document.querySelector('#user_keyword_mileage');
            if (response.data && Array.isArray(response.data) && response.data.length > 0) {
                mileageMemberSelect.innerHTML = '<option value="">회원 선택</option>';
                response.data.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.uniq_id;
                    option.textContent = `${user.user_nick_name} (${user.user_name})`;
                    mileageMemberSelect.appendChild(option);
                });
                mileageMemberSelect.value = response.data[0].uniq_id;
                userKeywordInput3.focus();
            } else {
                mileageMemberSelect.innerHTML = '<option value="">회원 선택</option>';
                const noResultOption = document.createElement('option');
                noResultOption.value = '';
                noResultOption.textContent = '검색 결과가 없습니다';
                noResultOption.disabled = true;
                mileageMemberSelect.appendChild(noResultOption);
                userKeywordInput3.focus();
            }
            break;
        case 23:
            alert('리워드 정보가 성공적으로 수정되었습니다.');
            egbT('modal_' + response.filter_page_name + '_contents', 'id=modal_' + response.filter_page_name + '_contents_' + response.filter_menu_name + '&path=/right_contents_box&filter_page_name=' + response.filter_page_name + '&filter_menu_name=' + response.filter_menu_name + '&filter_page=' + response.filter_page + '&filter_per_page=' + response.filter_per_page + '&filter_order=' + response.filter_order + '&filter_is_status=' + response.filter_is_status + '&filter_search_input=' + response.filter_search_input + '&filter_user_id=' + response.filter_user_id + '&filter_table_name=' + response.filter_table_name, true);
            break;
        default:
            alert('Unknown error successCode: 알 수 없는 에러가 발생했습니다.');
            break;
    }
}