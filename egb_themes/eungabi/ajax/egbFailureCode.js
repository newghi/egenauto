function egbFailureCode(response) {
	const failureCode = response.failureCode;
    // 에러 코드에 따른 메시지 처리를 사용자가 직접 작성
    switch (failureCode) {
        case 'publicDataPortal1':
            alert('사업자등록번호를 입력해주세요.');
            break;
        case 'publicDataPortal2':
            alert('공공데이터 포털 API 연결에 실패했습니다.');
            break;
        case 'publicDataPortal3':
            alert('공공데이터 포털 API 응답이 올바르지 않습니다.');
            break;
        case 'publicDataPortal4':
            alert('사업자등록번호가 유효하지 않습니다.');
            break;
        case 'publicDataPortal5':
            alert('사업자명 또는 법인명을 입력해주세요.');
            break;
        case 'publicDataPortal6':
            alert('공공데이터 포털 API 응답이 실패했습니다.');
            break;
        case 'publicDataPortal7':
            alert('공공데이터 포털 API 응답이 올바르지 않습니다.');
            break;
        case 'toggle_weekday_status_1':
            alert('스토어 정보가 누락 되었습니다.');
            break;
        case 'toggle_weekday_status_2': 
            alert('요일 값이 누락되었습니다.');
            break;
        case 'toggle_weekday_status_3':
            alert('요청 페이지 정보가 없습니다.');
            break;
        case 'toggle_weekday_status_4':
            alert('유효하지 않은 요일 형식입니다.');
            break;
        case 'toggle_weekday_status_5':
            alert('요일 토글 상태 변경에 실패했습니다.');
            break;
        case 'toggle_slot_status_1':
            alert('스토어 정보가 누락 되었습니다.');
            break;
        case 'toggle_slot_status_2':
            alert('요일 값이 누락되었습니다.');
            break;
        case 'toggle_slot_status_3':
            alert('시간 값이 누락되었습니다.');
            break;
        case 'toggle_slot_status_4':
            alert('요청 페이지 정보가 없습니다.');
            break;
        case 'toggle_slot_status_5':
            alert('시간 토글 상태 변경에 실패했습니다.');
            break;
        case 'update_slot_count_1':
            alert('스토어 정보가 누락 되었습니다.');
            break;
        case 'update_slot_count_2':
            alert('요일 값이 누락되었습니다.');
            break;
        case 'update_slot_count_3':
            alert('시간 값이 누락되었습니다.');
            break;
        case 'update_slot_count_4':
            alert('차량 대수 값이 누락되었습니다.');
            break;
        case 'update_slot_count_5':
            alert('요청 페이지 정보가 없습니다.');
            break;
        case 'update_slot_count_6':
            alert('차량 대수 업데이트에 실패했습니다.');
            break;
        case 'store_add_holiday_1':
            alert('스토어 정보가 누락 되었습니다.');
            break;
        case 'store_add_holiday_2':
            alert('휴일 날짜가 누락되었습니다.');
            break;
        case 'store_add_holiday_3':
            alert('휴일 이름이 누락되었습니다.');
            break;
        case 'store_add_holiday_4':
            alert('휴일 추가에 실패했습니다.');
            break;
        case 'store_delete_holiday_1':
            alert('스토어 정보가 누락 되었습니다.');
            break;
        case 'store_delete_holiday_2':
            alert('휴일 날짜가 누락되었습니다.');
            break;
        case 'store_delete_holiday_3':
            alert('스토어 정보를 찾을 수 없습니다.');
            break;
        case 'store_delete_holiday_4':
            alert('스토어 스케줄 정보가 올바르지 않습니다.');
            break;
        case 'store_delete_holiday_5':
            alert('해당 날짜의 휴일을 찾을 수 없습니다.');
            break;
        case 'store_delete_holiday_7':
            alert('휴일 삭제에 실패했습니다.');
            break;
        case 'get_schedule_1':
            alert('스토어 정보가 누락되었습니다.');
            break;
        case 'get_schedule_2':
            alert('연도 정보가 누락되었습니다.');
            break;
        case 'get_schedule_3':
            alert('월 정보가 누락되었습니다.');
            break;
        case 'get_schedule_4':
            alert('일 정보가 누락되었습니다.');
            break;
        case 'get_schedule_7':
            alert('스케줄 정보 조회에 실패했습니다.');
            break;
        case 'egb_alarm_read_1':
            alert('알림 읽음 처리에 실패했습니다.');
            break;
        case 'egb_alarm_read_2':
            alert('알림 읽음 처리 중 오류가 발생했습니다.');
            break;
        case 0:
            alert('csrf보안 검증에 실패 했습니다.');
            break;
        case 1:
            alert('쇼핑몰 회원 구분을 선택해주세요.');
            break;
        case 2:
            alert('사업자 구분을 선택해주세요.');
            break;
        case 3:
            alert('상호명을 입력해주세요.');
            break;
        case 4:
            alert('법인명을 입력해주세요.');
            break;
        case 5:
            alert('사업자등록번호를 입력해주세요.');
            break;
        case 6:
            alert('커뮤니티 회원등급을 선택해주세요.');
            break;
        case 7:
            alert('멘토 아이디를 입력해주세요.');
            break;
        case 8:
            alert('존재하지 않는 멘토 아이디입니다.');
            break;
        case 9:
            alert('아이디를 입력해주세요.');
            break;
        case 10:
            alert('아이디는 영문, 숫자를 포함하여 6자 이상이어야 합니다.');
            break;
        case 10.1:
            alert('가입불가 아이디입니다.');
            break;
        case 11:
            alert('이미 사용중인 아이디입니다.');
            break;
        case 12:
            alert('비밀번호를 입력해주세요.');
            break;
        case 13:
            alert('비밀번호는 영문, 숫자를 포함하여 8자 이상이어야 합니다.');
            break;
        case 14:
            alert('비밀번호 확인을 입력해주세요.');
            break;
        case 15:
            alert('비밀번호가 일치하지 않습니다.');
            break;
        case 16:
            alert('이름을 올바르게 입력해주세요.');
            break;
        case 17:
            alert('닉네임을 올바르게 입력해주세요.');
            break;
        case 18:
            alert('우편번호를 입력해주세요.');
            break;
        case 19:
            alert('주소를 입력해주세요.');
            break;
        case 20:
            alert('상세주소를 입력해주세요.');
            break;
        case 21:
            alert('휴대전화를 올바르게 입력해주세요.');
            break;
        case 22:
            alert('기타 연락처를 올바르게 입력해주세요.');
            break;
        case 23:
            alert('이메일을 올바르게 입력해주세요.');
            break;
        case 24:
            alert('성별을 선택해주세요.');
            break;
        case 25:
            alert('홈페이지를 입력해주세요.');
            break;
        case 26:
            alert('가입목적을 입력해주세요.');
            break;
        case 27:
            alert('유입경로를 입력해주세요.');
            break;
        case 28:
            alert('생년월일을 선택해주세요.');
            break;
        case 28.1:
            alert('가입이 제한된 연령 입니다.');
            break;
        case 29:
            alert('기념일을 선택해주세요.');
            break;
        case 30:
            alert('은행명을 입력해주세요.');
            break;
        case 31:
            alert('계좌번호를 입력해주세요.');
            break;
        case 32:
            alert('예금주를 입력해주세요.');
            break;
        case 33:
            alert('직업을 입력해주세요.');
            break;
        case 34:
            alert('회사명을 입력해주세요.');
            break;
        case 35:
            alert('부서를 입력해주세요.');
            break;
        case 36:
            alert('직위를 입력해주세요.');
            break;
        case 37:
            alert('회사 전화번호를 입력해주세요.');
            break;
        case 38:
            alert('회사 팩스번호를 입력해주세요.');
            break;
        case 39:
            alert('회사 주소를 입력해주세요.');
            break;
        case 40:
            alert('활동지역을 입력해주세요.');
            break;
        case 41:
            alert('차량배기량을 선택해주세요.');
            break;
        case 42:
            alert('지역을 선택해주세요.');
            break;
        case 43:
            alert('회원가입 처리에 실패 했습니다.');
            break;
        case 44:
            alert('아이디를 입력해주세요.');
            break;
        case 45:
            alert('비밀번호를 입력해주세요.');
            break;
        case 46:
            alert('비밀번호가 일치하지 않습니다.');
            break;
        case 47:
            alert('존재하지 않는 아이디입니다.');
            break;
        case 48:
            alert('존재하지 않는 등급입니다.');
            break;
        case 49:
            alert('등급 상태값이 올바르지 않습니다.');
            break;
        case 50:
            alert('등급 정보 업데이트에 실패했습니다.');
            break;
        case 51:
            alert('그룹 코드가 존재하지 않습니다.');
            break;
        case 52:
            alert('필수 여부 또는 내용 값이 올바르지 않습니다.');
            break;
        case 53:
            alert('설정 업데이트에 실패했습니다.');
            break;
        case 54:
            alert('등급명을 입력해주세요.');
            break;
        case 55:
            alert('등급 ID가 존재하지 않습니다.');
            break;
        case 56:
            alert('이미 사용중인 등급명입니다.');
            break;
        case 57:
            alert('등급명 수정에 실패했습니다.');
            break;
        case 58:
            alert('리워드 ID가 존재하지 않습니다.');
            break;
        case 59:
            alert('mode 값이 올바르지 않습니다.');
            break;
        case 60:
            alert('리워드 지급 포인트를 입력해주세요.');
            break;
        case 61:
            alert('리워드 만료일을 입력해주세요.');
            break;
        case 62:
            alert('대상 등급을 선택해주세요.');
            break;
        case 63:
            alert('리워드 수정에 실패했습니다.');
            break;
        case 64:
            alert('잘못된 mode 값입니다.');
            break;
        case 65:
            alert('로그인이 필요한 서비스입니다.');
            break;
        case 66:
            alert('이미지를 선택해주세요.z');
            break;
        case 67:
            alert('제목을 입력해주세요.');
            break;
        case 68:
            alert('내용을 입력해주세요.');
            break;
        case 69:
            alert('파일 업로드에 실패했습니다.');
            break;
        case 70:
            alert('게시물 저장에 실패했습니다.');
            break;
        case 71:
            alert('댓글 테이블명이 올바르지 않습니다.');
            break;
        case 72:
            alert('게시글 ID가 올바르지 않습니다.');
            break;
        case 73:
            //alert('사용자 ID가 올바르지 않습니다.');
            alert('로그인 후 이용 가능 합니다.');
            break;
        case 74:
            alert('댓글 내용을 입력해주세요.');
            break;
        case 75:
            alert('댓글 등록에 실패했습니다.');
            break;
        case 76:
            alert('좋아요 대상 테이블이 올바르지 않습니다.');
            break;
        case 77:
            alert('좋아요 대상 ID가 올바르지 않습니다.');
            break;
        case 78:
            //alert('사용자 ID가 올바르지 않습니다.');
            alert('로그인 후 이용 가능 합니다.');
            break;
        case 79:
            alert('페이지 정보가 올바르지 않습니다.');
            break;
        case 80:
            alert('좋아요 상태 확인에 실패했습니다.');
            break;
        case 81:
            alert('좋아요 취소에 실패했습니다.');
            break;
        case 82:
            alert('좋아요 등록에 실패했습니다.');
            break;
        case 83:
            alert('스크랩 대상 테이블이 올바르지 않습니다.');
            break;
        case 84:
            alert('스크랩 대상 ID가 올바르지 않습니다.');
            break;
        case 85:
            //alert('사용자 ID가 올바르지 않습니다.');
            alert('로그인 후 이용 가능 합니다.');
            break;
        case 86:
            alert('페이지 정보가 올바르지 않습니다.');
            break;
        case 87:
            alert('스크랩 상태 확인에 실패했습니다.');
            break;
        case 88:
            alert('스크랩 취소에 실패했습니다.');
            break;
        case 89:
            alert('스크랩 등록에 실패했습니다.');
            break;
        case 90:
            alert('공유 대상 테이블이 올바르지 않습니다.');
            break;
        case 91:
            alert('공유 대상 ID가 올바르지 않습니다.');
            break;
        case 92:
            //alert('사용자 ID가 올바르지 않습니다.');
            alert('로그인 후 이용 가능 합니다.');
            break;
        case 93:
            alert('페이지 정보가 올바르지 않습니다.');
            break;
        case 94:
            alert('공유 URL이 올바르지 않습니다.');
            break;
        case 95:
            alert('공유 상태 확인에 실패했습니다.');
            break;
        case 96:
            alert('공유 취소에 실패했습니다.');
            break;
        case 97:
            alert('공유 등록에 실패했습니다.');
            break;
        case 98:
            alert('로그인 후 이용 가능 합니다.');
            break;
        case 99:
            alert('이미지를 첨부해주세요.');
            break;
        case 100:
            alert('제목을 입력해주세요.');
            break;
        case 101:
            alert('내용을 입력해주세요.');
            break;
        case 102:
            alert('파일 업로드에 실패했습니다.');
            break;
        case 103:
            alert('게시글 등록에 실패했습니다.');
            break;
        case 104:
            alert('로그인 후 이용 가능 합니다.');
            break;
        case 105:
            alert('제목을 입력해주세요.');
            break;
        case 106:
            alert('내용을 입력해주세요.');
            break;
        case 107:
            alert('동영상 업로드에 실패했습니다.');
            break;
        case 108:
            alert('썸네일 업로드에 실패했습니다.');
            break;
        case 109:
            alert('게시글 등록에 실패했습니다.');
            break;
        case 110:
            alert('로그인 후 이용 가능 합니다.');
            break;
        case 111:
            alert('제목을 입력해주세요.');
            break;
        case 112:
            alert('내용을 입력해주세요.');
            break;
        case 113:
            alert('동영상 업로드에 실패했습니다.');
            break;
        case 114:
            alert('썸네일 업로드에 실패했습니다.');
            break;
        case 115:
            alert('로그인 후 이용 가능 합니다.');
            break;
        case 116:
            alert('이미지를 첨부해주세요.');
            break;
        case 117:
            alert('제목을 입력해주세요.');
            break;
        case 118:
            alert('내용을 입력해주세요.');
            break;
        case 119:
            alert('카테고리를 선택해주세요.');
            break;
        case 120:
            alert('작업자를 선택해주세요.');
            break;
        case 121:
            alert('자가수리점을 선택해주세요.');
            break;
        case 122:
            alert('작업시간을 입력해주세요.');
            break;
        case 123:
            alert('부품 예산을 입력해주세요.');
            break;
        case 124:
            alert('소모품 예산을 입력해주세요.');
            break;
        case 125:
            alert('작업자 유형을 선택해주세요.');
            break;
        case 126:
            alert('브랜드를 선택해주세요.');
            break;
        case 127:
            alert('차량 모델을 선택해주세요.');
            break;
        case 128:
            alert('차종을 선택해주세요.');
            break;
        case 129:
            alert('차량 모델명을 입력해주세요.');
            break;
        case 130:
            alert('오일 타입을 선택해주세요.');
            break;
        case 131:
            alert('연식을 선택해주세요.');
            break;
        case 132:
            alert('파일 업로드에 실패했습니다.');
            break;
        case 133:
            alert('게시글 등록에 실패했습니다.');
            break;
        case 134:
            alert('로그인이 필요한 서비스입니다.');
            break;
        case 135:
            alert('제목을 입력해주세요.');
            break;
        case 136:
            alert('내용을 입력해주세요.');
            break;
        case 137:
            alert('게시글 등록에 실패했습니다.');
            break;
        case 138:
            if (response.is_status == 0) {
                alert('비활성화된 계정입니다.');
            } else if (response.is_status == 3) {
                alert('승인이 필요한 계정입니다.');
            } else if (response.is_status == 4) {
                alert('탈퇴한 계정입니다.');
            } else {
                alert('계정 상태에 문제가 있습니다.');
            }
            break;
        case 139:
            alert('매장을 선택해주세요.');
            break;
        case 140:
            alert('예약 연도를 선택해주세요.');
            break;
        case 141:
            alert('예약 월을 선택해주세요.');
            break;
        case 142:
            alert('예약 일을 선택해주세요.');
            break;
        case 143:
            alert('예약 시간을 선택해주세요.');
            break;
        case 144:
            alert('예약자 성함을 입력해주세요.');
            break;
        case 145:
            alert('연락처를 입력해주세요.');
            break;
        case 146:
            alert('차량 모델명을 입력해주세요.');
            break;
        case 147:
            alert('연식을 입력해주세요.');
            break;
        case 148:
            alert('차량번호를 입력해주세요.');
            break;
        case 149:
            alert('주행거리를 입력해주세요.');
            break;
        case 150:
            alert('업종을 선택해주세요.');
            break;
        case 151:
            alert('제품 지참 여부를 선택해주세요.');
            break;
        case 152:
            alert('정비 항목을 선택해주세요.');
            break;
        case 153:
            alert('제목을 입력해주세요.');
            break;
        case 154:
            alert('내용을 입력해주세요.');
            break;
        case 155:
            alert('이미 예약된 시간입니다.');
            break;
        case 156:
            alert('예약 등록에 실패했습니다.');
            break;
        case 157:
            alert('예약 그룹 ID가 유효하지 않습니다.');
            break;
        case 158:
            alert('예약 정보를 찾을 수 없습니다.');
            break;
        case 159:
            alert('예약 취소 사유를 입력해주세요.');
            break;
        case 160:
            alert('노쇼 사유를 입력해주세요.');
            break;
        case 161:
            alert('스토어를 선택해주세요.');
            break;
        case 162:
            alert('예약 날짜를 선택해주세요.');
            break;
        case 163:
            alert('예약 시간을 선택해주세요.');
            break;
        case 164:
            alert('차량 모델을 입력해주세요.');
            break;
        case 165:
            alert('예상 소요시간을 입력해주세요.');
            break;
        case 166:
            alert('관리자 메모를 입력해주세요.');
            break;
        case 167:
            alert('정비 항목을 선택해주세요.');
            break;
        case 168:
            alert('변경할 예약 정보를 찾을 수 없습니다.');
            break;
        case 169:
            alert('예약 정보 변경에 실패했습니다.');
            break;
        case 170:
            alert('예약 불가능 시간입니다.');
            break;
        case 171:
            alert('엑셀 다운로드에 실패했습니다.');
            break;
        case 172:
            alert('댓글 ID가 유효하지 않습니다.');
            break;
        case 173:
            alert('테이블 이름이 유효하지 않습니다.');
            break;
        case 174:
            alert('답글을 찾을 수 없습니다.');
            break;
        case 175:
            alert('댓글 테이블 이름이 유효하지 않습니다.');
            break;
        case 176:
            alert('게시글 ID가 유효하지 않습니다.');
            break;
        case 177:
            alert('마지막 댓글 ID가 유효하지 않습니다.');
            break;
        
            case 178:
            const commentList = document.getElementById('comment_list');
            if (commentList) {
                const noMoreDiv = document.createElement('div');
                noMoreDiv.className = 'flex_xc_yc padding_px-y_020';
                noMoreDiv.style.color = '#888888';
                noMoreDiv.textContent = '더 이상 불러올 댓글이 없습니다.';
                commentList.appendChild(noMoreDiv);
                
                // auto_comment_scroll_update_form 폼 제거
                const form = document.getElementById('auto_comment_scroll_update_form');
                if (form) {
                    form.remove();
                }
            }
            break;
        case 179:
            alert('유효하지 않은 연락처 형식입니다.');
            break;
        case 180:
            alert('차량모델명에 특수문자를 사용할 수 없습니다.');
            break;
        case 181:
            alert('연식에 특수문자를 사용할 수 없습니다.');
            break;
        case 182:
            alert('차량번호에 특수문자를 사용할 수 없습니다.');
            break;
        case 183:
            alert('주행거리에 특수문자를 사용할 수 없습니다.');
            break;
        default:
            alert('Unknown error: failureCode ' + failureCode + ' - 알 수 없는 에러가 발생했습니다.');
            break;
    }
}