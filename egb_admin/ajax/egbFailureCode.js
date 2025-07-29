function egbFailureCode(response) {
	const failureCode = response.failureCode;
    // 에러 코드에 따른 메시지 처리를 사용자가 직접 작성
    switch (failureCode) {
        case 'undefined':
            alert('undefined 알수 없는 에러 입니다.');
            break;
        case 0:
            alert('csrf보안 검증에 실패 했습니다.');
            break;
        case 1:
            alert('페이지명(filter_page_name) 필드가 누락되었습니다.');
            break;
        case 2:
            alert('메뉴명(filter_menu_name) 필드가 누락되었습니다.');
            break;
        case 3:
            alert('페이지 번호(filter_page) 필드가 누락되었습니다.');
            break;
        case 4:
            alert('페이지당 표시 수(filter_per_page) 필드가 누락되었습니다.');
            break;
        case 5:
            alert('정렬(filter_order) 필드가 누락되었습니다.');
            break;
        case 6:
            alert('상태(filter_is_status) 필드가 누락되었습니다.');
            break;
        case 7:
            alert('사용자 ID(filter_user_id) 필드가 누락되었습니다.');
            break;
        case 8:
            alert('테이블명(filter_table_name) 필드가 누락되었습니다.');
            break;
        case 9:
            alert('컬럼(columns) 필드가 누락되었습니다.');
            break;
        case 10:
            alert('정렬순서(order) 필드가 누락되었습니다.');
            break;
        case 11:
            alert('너비(width) 필드가 누락되었습니다.');
            break;
        case 12:
            alert('정렬(align) 필드가 누락되었습니다.');
            break;
        case 13:
            alert('숨김여부(hidden) 필드가 누락되었습니다.');
            break;
        case 14:
            alert('코멘트(comment) 필드가 누락되었습니다.');
            break;
        case 15:
            alert('키워드 필터(keyword_filter) 필드가 누락되었습니다.');
            break;
        case 16:
            alert('상세 필터(detail_filter) 필드가 누락되었습니다.');
            break;
        case 17:
            alert('컬럼 설정 업데이트에 실패했습니다.');
            break;
        case 18:
            alert('컬럼 설정 삽입에 실패했습니다.');
            break;
        case 19:
            alert('상태 변경에 실패했습니다.');
            break;
        case 20:
            alert('테이블명(filter_table_name) 필드가 누락되었습니다.');
            break;
        case 21:
            alert('엑셀 파일 다운로드에 실패했습니다.');
            break;
        case 22:
            alert('엑셀 파일 업로드에 실패했습니다.');
            break;
        case 23:
            alert('테이블명(filter_table_name) 필드가 누락되었습니다.');
            break;
        case 24:
            alert('엑셀 파일 포맷이 일치하지 않습니다.');
            break;
        case 25:
            alert('엑셀 파일 업로드 중 오류가 발생했습니다.');
            break;
        case 26:
            alert('테이블명(filter_table_name) 필드가 누락되었습니다.');
            break;
        case 27:
            alert('고유 ID(uniq_id) 필드가 누락되었습니다.');
            break;
        case 28:
            alert('삭제 처리에 실패했습니다.');
            break;
        case 29:
            alert('테이블명(filter_table_name) 필드가 누락되었습니다.');
            break;
        case 30:
            alert('페이지 제목(page_title) 필드가 누락되었습니다.');
            break;
        case 31:
            alert('페이지명(page_name) 필드가 누락되었습니다.');
            break;
        case 32:
            alert('페이지 타입(page_type) 필드가 누락되었습니다.');
            break;
        case 33:
            alert('표시 순서(display_order) 필드가 누락되었습니다.');
            break;
        case 34:
            alert('페이지 SEO(page_seo) 필드가 누락되었습니다.');
            break;
        case 35:
            alert('페이지 사용(page_use) 필드가 누락되었습니다.');
            break;
        case 36:
            alert('페이지 등급(page_rank) 필드가 누락되었습니다.');
            break;
        case 37:
            alert('페이지 조회(page_view) 필드가 누락되었습니다.');
            break;
        case 38:
            alert('SEO 제목(seo_title) 필드가 누락되었습니다.');
            break;
        case 39:
            alert('SEO 주제(seo_subject) 필드가 누락되었습니다.');
            break;
        case 40:
            alert('SEO 설명(seo_description) 필드가 누락되었습니다.');
            break;
        case 41:
            alert('SEO 키워드(seo_keywords) 필드가 누락되었습니다.');
            break;
        case 42:
            alert('SEO OG 제목(seo_og_title) 필드가 누락되었습니다.');
            break;
        case 43:
            alert('SEO OG 설명(seo_og_description) 필드가 누락되었습니다.');
            break;
        case 44:
            alert('SEO 작성자(seo_author) 필드가 누락되었습니다.');
            break;
        case 45:
            alert('헤더 사용(setting_header_use) 필드가 누락되었습니다.');
            break;
        case 46:
            alert('푸터 사용(setting_footer_use) 필드가 누락되었습니다.');
            break;
        case 47:
            alert('댓글 사용(setting_comment_use) 필드가 누락되었습니다.');
            break;
        case 48:
            alert('접근 레벨(setting_access_level) 필드가 누락되었습니다.');
            break;
        case 49:
            alert('이미 사용중인 페이지명입니다.');
            break;
        case 50:
            alert('페이지 파일 생성에 실패했습니다.');
            break;
        case 51:
            alert('페이지 추가에 실패했습니다.');
            break;
        case 52:
            alert('테마(page_theme) 필드가 누락되었습니다.');
            break;
        case 53:
            alert('테이블명(filter_table_name) 필드가 누락되었습니다.');
            break;
        case 54:
            alert('페이지 제목(page_title) 필드가 누락되었습니다.');
            break;
        case 55:
            alert('표시 순서(display_order) 필드가 누락되었습니다.');
            break;
        case 56:
            alert('페이지 SEO(page_seo) 필드가 누락되었습니다.');
            break;
        case 57:
            alert('페이지 사용(page_use) 필드가 누락되었습니다.');
            break;
        case 58:
            alert('페이지 등급(page_rank) 필드가 누락되었습니다.');
            break;
        case 59:
            alert('SEO 제목(seo_title) 필드가 누락되었습니다.');
            break;
        case 60:
            alert('SEO 주제(seo_subject) 필드가 누락되었습니다.');
            break;
        case 61:
            alert('SEO 설명(seo_description) 필드가 누락되었습니다.');
            break;
        case 62:
            alert('SEO 키워드(seo_keywords) 필드가 누락되었습니다.');
            break;
        case 63:
            alert('SEO 로봇(seo_robots) 필드가 누락되었습니다.');
            break;
        case 64:
            alert('SEO 표준 링크(seo_canonical) 필드가 누락되었습니다.');
            break;
        case 65:
            alert('SEO OG 제목(seo_og_title) 필드가 누락되었습니다.');
            break;
        case 66:
            alert('SEO OG 설명(seo_og_description) 필드가 누락되었습니다.');
            break;
        case 67:
            alert('SEO 작성자(seo_author) 필드가 누락되었습니다.');
            break;
        case 68:
            alert('헤더 사용(setting_header_use) 필드가 누락되었습니다.');
            break;
        case 69:
            alert('푸터 사용(setting_footer_use) 필드가 누락되었습니다.');
            break;
        case 70:
            alert('댓글 사용(setting_comment_use) 필드가 누락되었습니다.');
            break;
        case 71:
            alert('접근 레벨(setting_access_level) 필드가 누락되었습니다.');
            break;
        case 72:
            alert('페이지 수정에 실패했습니다.');
            break;
        case 73:
            alert('옵션 그룹 코드(group_code) 필드가 누락되었습니다.');
            break;
        case 74:
            alert('옵션 그룹 제목(group_title) 필드가 누락되었습니다.');
            break;
        case 75:
            alert('옵션 그룹 입력명(group_description) 필드가 누락되었습니다.');
            break;
        case 76:
            alert('옵션 그룹 필수 여부(group_required) 필드가 누락되었습니다.');
            break;
        case 77:
            alert('옵션 그룹 추가에 실패했습니다.');
            break;
        case 78:
            alert('옵션 그룹 제목(group_title) 필드가 누락되었습니다.');
            break;
        case 79:
            alert('옵션 그룹 필수 여부(group_required) 필드가 누락되었습니다.');
            break;
        case 80:
            alert('옵션 그룹 수정에 실패했습니다.');
            break;
        case 81:
            //alert('검색어를 입력해주세요.');
            break;
        case 82:
            //alert('검색 결과가 없습니다.');
            break;
        case 83:
            //alert('검색어를 입력해주세요.');
            break;
        case 84:
            alert('옵션 그룹 ID(option_group_uniq_id) 필드가 누락되었습니다.');
            break;
        case 85:
            //alert('검색 결과가 없습니다.');
            break;
        case 85:
            alert('옵션 그룹 ID(option_group_uniq_id) 필드가 누락되었습니다.');
            break;
        case 86:
            alert('옵션 라벨(option_label) 필드가 누락되었습니다.');
            break;  
        case 87:
            alert('중복된 옵션이 존재합니다.');
            break;
        case 88:
            alert('옵션 추가에 실패했습니다.');
            break;
        case 89:
            alert('옵션 ID(uniq_id) 필드가 누락되었습니다.');
            break;
        case 90:
            alert('옵션 그룹 ID(option_group_uniq_id) 필드가 누락되었습니다.');
            break;
        case 91:
            alert('옵션 라벨(option_label) 필드가 누락되었습니다.');
            break;
        case 92:
            alert('중복된 옵션이 존재합니다.');
            break;
        case 93:
            alert('옵션 수정에 실패했습니다.');
            break;
        case 94:
            alert('이벤트 제목(event_title) 필드가 누락되었습니다.');
            break;
        case 95:
            alert('이벤트 카테고리(event_category) 필드가 누락되었습니다.');
            break;
        case 96:
            alert('이벤트 유형(event_type) 필드가 누락되었습니다.');
            break;
        case 97:
            alert('이벤트 시작일(event_start_date) 필드가 누락되었습니다.');
            break;
        case 98:
            alert('이벤트 종료일(event_end_date) 필드가 누락되었습니다.');
            break;
        case 99:
            alert('대상 등급(target_grades) 필드가 누락되었습니다.');
            break;
        case 100:
            alert('이벤트 추가에 실패했습니다.');
            break;
        case 109:
            alert('이벤트 수정에 실패했습니다.');
            break;
        case 101:
            alert('이벤트 ID(uniq_id) 필드가 누락되었습니다.');
            break;
        case 102:
            alert('이벤트 제목(event_title) 필드가 누락되었습니다.');
            break;
        case 103:
            alert('이벤트 카테고리(event_category) 필드가 누락되었습니다.');
            break;
        case 104:
            alert('이벤트 유형(event_type) 필드가 누락되었습니다.');
            break;
        case 105:
            alert('이벤트 설명(event_description) 필드가 누락되었습니다.');
            break;
        case 106:
            alert('이벤트 시작일(event_start_date) 필드가 누락되었습니다.');
            break;
        case 107:
            alert('이벤트 종료일(event_end_date) 필드가 누락되었습니다.');
            break;
        case 108:
            alert('대상 등급(target_grades) 필드가 누락되었습니다.');
            break;
        case 109:
            //alert('검색어를 입력해주세요.');
            break;
        case 110:
            //alert('검색 결과가 없습니다.');
            break;
        case 111:
            alert('예치금 대상 회원(deposit_target_uniq_id) 필드가 누락되었습니다.');
            break;
        case 112:
            alert('예치금 처리 유형(deposit_type) 필드가 누락되었습니다.');
            break;
        case 113:
            alert('예치금 처리 사유(deposit_reason) 필드가 누락되었습니다.');
            break;
        case 114:
            alert('예치금 금액(deposit_amount) 필드가 누락되었습니다.');
            break;
        case 115:
            alert('존재하지 않는 회원입니다.');
            break;
        case 116:
            alert('차감할 금액이 현재 예치금보다 큽니다.');
            break;
        case 117:
            alert('잘못된 예치금 처리 유형입니다.');
            break;
        case 118:
            alert('예치금 내역 추가에 실패했습니다.');
            break;
        case 119:
            alert('예치금 업데이트에 실패했습니다.');
            break;
        case 120:
            alert('적립금 대상 회원(point_target_uniq_id) 필드가 누락되었습니다.');
            break;
        case 121:
            alert('적립금 처리 유형(point_type) 필드가 누락되었습니다.');
            break;
        case 122:
            alert('적립금 처리 사유(point_reason) 필드가 누락되었습니다.');
            break;
        case 123:
            alert('적립금 금액(point_amount) 필드가 누락되었습니다.');
            break;
        case 124:
            alert('존재하지 않는 회원입니다.');
            break;
        case 125:
            alert('차감할 금액이 현재 적립금보다 큽니다.');
            break;
        case 126:
            alert('잘못된 적립금 처리 유형입니다.');
            break;
        case 127:
            alert('적립금 내역 추가에 실패했습니다.');
            break;
        case 128:
            alert('적립금 업데이트에 실패했습니다.');
            break;
        case 129:
            //alert('검색어를 입력해주세요.');
            break;
        case 130:
            //alert('검색 결과가 없습니다.');
            break;
        case 131:
            alert('마일리지 대상 회원(mileage_target_uniq_id) 필드가 누락되었습니다.');
            break;
        case 132:
            alert('마일리지 처리 유형(mileage_type) 필드가 누락되었습니다.');
            break;
        case 133:
            alert('마일리지 처리 사유(mileage_reason) 필드가 누락되었습니다.');
            break;
        case 134:
            alert('마일리지 금액(mileage_amount) 필드가 누락되었습니다.');
            break;
        case 135:
            alert('존재하지 않는 회원입니다.');
            break;
        case 136:
            alert('차감할 금액이 현재 마일리지보다 큽니다.');
            break;
        case 137:
            alert('잘못된 마일리지 처리 유형입니다.');
            break;
        case 138:
            alert('마일리지 내역 추가에 실패했습니다.');
            break;
        case 139:
            alert('마일리지 업데이트에 실패했습니다.');
            break;
        case 140:
            //alert('검색어를 입력해주세요.');
            break;
        case 141:
            //alert('검색 결과가 없습니다.');
            break;
        case 142:
            alert('리워드 고유번호(uniq_id) 필드가 누락되었습니다.');
            break;
        case 143:
            alert('리워드 제목(reward_title) 필드가 누락되었습니다.');
            break;
        case 144:
            alert('리워드 이름(reward_name) 필드가 누락되었습니다.');
            break;
        case 145:
            alert('리워드 타입(reward_type) 필드가 누락되었습니다.');
            break;
        case 146:
            alert('지급 횟수(reward_limit_count) 필드가 누락되었습니다.');
            break;
        case 147:
            alert('지급 금액/포인트(reward_grant) 필드가 누락되었습니다.');
            break;
        case 148:
            alert('소멸일(reward_expired_days) 필드가 누락되었습니다.');
            break;
        case 149:
            alert('대상 회원등급(target_grades) 필드가 누락되었습니다.');
            break;
        case 150:
            alert('리워드 정보 수정에 실패했습니다.');
            break;

        default:
            alert('Unknown error failureCode: 알 수 없는 에러가 발생했습니다.' + failureCode);
            break;
    }
}