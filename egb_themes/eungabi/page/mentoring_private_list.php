<?php
$login_user_uniq_id = $_SESSION['user_uniq_id'] ?? null;
$is_admin = isset($_SESSION['admin_login']) && $_SESSION['admin_login'] == 1;

// 옵션 그룹 정보 조회 
$query_grade = "SELECT uniq_id FROM egb_option_group WHERE group_code = 'community_user_grade' AND is_status = 1";
$binding_grade = binding_sql(1, $query_grade, []);
$result_grade = egb_sql($binding_grade);

// 멘토 정보 가져오기
$query_mentor = "SELECT uniq_id, option_label FROM egb_option WHERE option_group_uniq_id = :option_group_uniq_id AND option_label = '멘토' AND is_status = 1";
$params_mentor = [':option_group_uniq_id' => $result_grade[0]['uniq_id']];
$binding_mentor = binding_sql(1, $query_mentor, $params_mentor);
$sql_mentor = egb_sql($binding_mentor);
$mentor_uniq_id = !empty($sql_mentor) ? $sql_mentor[0]['uniq_id'] : null;

// 멘티 정보 가져오기  
$query_mentee = "SELECT uniq_id, option_label FROM egb_option WHERE option_group_uniq_id = :option_group_uniq_id AND option_label = '멘티' AND is_status = 1";
$params_mentee = [':option_group_uniq_id' => $result_grade[0]['uniq_id']];
$binding_mentee = binding_sql(1, $query_mentee, $params_mentee);
$sql_mentee = egb_sql($binding_mentee);
$mentee_uniq_id = !empty($sql_mentee) ? $sql_mentee[0]['uniq_id'] : null;

// 현재 로그인한 사용자의 등급 조회
$is_mentor = false;
$is_mentee = false;

// 로그인한 사용자의 등급 확인
if ($login_user_uniq_id) {
    $query_user = "SELECT u.community_user_grade, u.uniq_id, u.user_id, u.user_mentor_id 
                   FROM egb_user u
                   WHERE u.uniq_id = :login_user_uniq_id AND u.is_status = 1";
    $params_user = [':login_user_uniq_id' => $login_user_uniq_id];
    $binding_user = binding_sql(1, $query_user, $params_user);
    $sql_user = egb_sql($binding_user);

    // 사용자 등급 확인
    if (!empty($sql_user)) {
        $user_grade = $sql_user[0]['community_user_grade'];
        if ($user_grade == $mentor_uniq_id) {
            $is_mentor = true;
        } else if ($user_grade == $mentee_uniq_id) {
            $is_mentee = true;
        }
    }
}

// 게시글 조회
if ($is_mentor) {
    // 멘토인 경우: 자신을 멘토로 지정한 멘티들의 게시글과 자신의 게시글 조회
    $query = "SELECT p.uniq_id, p.board_user_uniq_id, p.board_title, p.board_view, p.created_at
              FROM egb_board_mentoring_private p
              LEFT JOIN egb_user u ON p.board_user_uniq_id = u.uniq_id
              WHERE p.board_user_uniq_id = :login_user_uniq_id 
              OR u.user_mentor_id = :mentor_user_id
              ORDER BY p.created_at DESC";
    $params = [
        ':login_user_uniq_id' => $login_user_uniq_id,
        ':mentor_user_id' => $sql_user[0]['user_id']
    ];
} else if ($is_mentee) {
    // 멘티인 경우: 자신의 멘토의 게시글과 자신의 게시글 조회
    // 먼저 멘토의 uniq_id를 찾기
    $mentor_uniq_id = null;
    if (!empty($sql_user[0]['user_mentor_id'])) {
        $mentor_query = "SELECT uniq_id FROM egb_user WHERE user_id = :mentor_user_id AND is_status = 1";
        $mentor_params = [':mentor_user_id' => $sql_user[0]['user_mentor_id']];
        $mentor_binding = binding_sql(1, $mentor_query, $mentor_params);
        $mentor_result = egb_sql($mentor_binding);
        
        if (!empty($mentor_result[0]['uniq_id'])) {
            $mentor_uniq_id = $mentor_result[0]['uniq_id'];
        }
    }
    
    $query = "SELECT p.uniq_id, p.board_user_uniq_id, p.board_title, p.board_view, p.created_at
              FROM egb_board_mentoring_private p
              WHERE p.board_user_uniq_id = :login_user_uniq_id";
    
    $params = [':login_user_uniq_id' => $login_user_uniq_id];
    
    // 멘토의 uniq_id가 있으면 멘토의 글도 포함
    if ($mentor_uniq_id) {
        $query .= " OR p.board_user_uniq_id = :mentor_uniq_id";
        $params[':mentor_uniq_id'] = $mentor_uniq_id;
    }
    
    $query .= " ORDER BY p.created_at DESC";
} else {
    // 권한이 없는 경우 빈 결과 반환
    $query = "SELECT uniq_id, board_user_uniq_id, board_title, board_view, created_at
              FROM egb_board_mentoring_private 
              WHERE 1=0";
    $params = [];
}

// 쿼리 실행
$binding = binding_sql(0, $query, $params);
$sql = egb_sql($binding);

?>
<section class="position1 width_box" data-bg-color="#efefef">
    <div class="width_px_1220 margin_x_auto height_px_200 flex_yc font_px_030 flv6">멘토링 1:1 게시판</div>
</section>
<section class="position1 width_box">
    <div class="flex_xs1_yc width_px_1220 margin_x_auto padding_px-y_020">
        <div class="flex_fl_yc">
            <div class="padding_px-r_010">
                <select
                    class="width_px_120 height_px_040 border_px-a_001 border_bre-a_005 padding_px-x_010 fontstyle1 font_px_014"
                    data-color="#000000" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" name="" id="">
                    <option value="제목">제목</option>
                    <option value="제목">내용</option>
                </select>
            </div>
            <div class="position1 width_px_300 border_px-a_001 border_bre-a_005 fakeinput_2" data-bd-a-color="#d9d9d9">
                <input class="width_box height_px_040 fontstyle1 font_px_014 padding_px-l_015 padding_px-r_050"
                    type="text" name="" id="" placeholder="검색어를 입력해주세요">
                <div class="position2" data-right="2%" data-top="0%">
                    <div class="width_px_020 height_px_040 pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                            width="100%" height="100%" x="0" y="0" viewBox="0 0 62.993 62.993"
                            style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <path
                                    d="M62.58 60.594 41.313 39.329c3.712-4.18 5.988-9.66 5.988-15.677C47.301 10.61 36.692.001 23.651.001 10.609.001 0 10.61 0 23.652c0 13.041 10.609 23.65 23.651 23.65 6.016 0 11.497-2.276 15.677-5.988l21.265 21.267a1.403 1.403 0 0 0 1.987 0c.55-.551.55-1.438 0-1.987zM23.651 44.492c-11.492 0-20.841-9.348-20.841-20.84S12.159 2.811 23.651 2.811c11.491 0 20.84 9.349 20.84 20.841 0 5.241-1.958 10.023-5.163 13.689a21.416 21.416 0 0 1-1.987 1.987c-3.666 3.206-8.449 5.164-13.69 5.164z"
                                    style="" fill="#828c94" data-original="#010002" opacity="1"></path>
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex_fl_yc">
            <div class="padding_px-r_010">
                <select
                    class="width_px_120 height_px_040 border_px-a_001 border_bre-a_005 padding_px-x_010 fontstyle1 font_px_014"
                    data-color="#000000" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" name="" id="">
                    <option value="최신순">최신순</option>
                    <option value="오래딘순">오래된순</option>
                </select>
            </div>
            <div>
                <select
                    class="width_px_120 height_px_040 border_px-a_001 border_bre-a_005 padding_px-x_010 fontstyle1 font_px_014"
                    data-color="#000000" data-bd-a-color="#d9d9d9" data-bg-color="#ffffff" name="" id="">
                    <option value="20개씩 보기">20개씩 보기</option>
                    <option value="10개씩 보기">10개씩 보기</option>
                </select>
            </div>
        </div>
    </div>
</section>
<style>
    select {
        box-sizing: border-box;
        outline: none;
    }

    input {
        all: unset;
        box-sizing: border-box;
        outline: none;
    }

    select:focus {
        box-shadow: 0 0 0 3px #2020204d;
        border: 1px solid #202020;
    }

    input:focus {
        outline: none;
    }

    .fakeinput_2:focus-within {
        box-shadow: 0 0 0 3px #2020204d;
        border: 1px solid #202020;
        transition: 0.3s;
        z-index: 3;
    }
</style>
<section class="position1 width_box">
    <div class="width_px_1220 margin_x_auto padding_px-t_020 padding_px-u_060">
        <div class="border_px-t_001 border_px-u_001 grid_xx fontstyle3" data-xx="10% 55% 15% 10% 10%" data-bg-color="#eeeeee"
            data-bd-t-color="#202020" data-bd-u-color="#d9d9d9">
            <div class="flex_xc padding_px-y_020">번호</div>
            <div class="flex_fl padding_px-y_020">제목</div>
            <div class="flex_xc padding_px-y_020">작성자</div>
            <div class="flex_xc padding_px-y_020">작성일</div>
            <div class="flex_xc padding_px-y_020">조회수</div>
        </div>
        <?php
        
        // 로그인하지 않은 경우 메시지 표시 후 종료
        if (!$login_user_uniq_id && !$is_admin) {
            echo "<div class='padding_px-y_010'>로그인이 필요한 서비스입니다.</div>";

        }
        
        if (!$is_mentor && !$is_mentee && !$is_admin) {
            echo "<div class='padding_px-y_010'>멘토 또는 멘티 회원만 이용 가능한 서비스입니다.</div>";

        }
        
        // 결과가 없는 경우 처리
        if (empty($sql[0]) || !is_array($sql[0]) || count($sql[0]) == 0) {
            echo "<div class='padding_px-y_010'>등록된 게시물이 없습니다.</div>";

        }

        // 결과가 있는 경우에만 출력
        $index = 1; // 인덱스 초기화
        foreach ($sql[0] as $row) {
            if (!isset($row['board_user_uniq_id']) || !isset($row['created_at']) || !isset($row['board_title']) || !isset($row['uniq_id'])) {
                continue; // 필수 데이터가 없는 경우 건너뛰기
            }

            // 작성자 닉네임을 가져오는 쿼리  
            $user_uniq_id = $row['board_user_uniq_id'];
            $user_query = "SELECT user_nick_name FROM egb_user WHERE uniq_id = :user_uniq_id";
            $user_params = [':user_uniq_id' => $user_uniq_id];
            $user_binding = binding_sql(1, $user_query, $user_params);
            $user_sql = egb_sql($user_binding);
        
            // 닉네임이 있는 경우, 없으면 기본값 설정
            $user_nick_name = !empty($user_sql[0]['user_nick_name']) ? htmlspecialchars($user_sql[0]['user_nick_name']) : '알 수 없음';
        
            // 날짜 처리
            $publish_date = !empty($row['created_at']) ? date("H:i", strtotime($row['created_at'])) : '-';
            
            // 조회수와 제목 처리
            $view_count = isset($row['board_view']) ? intval($row['board_view']) : 0;
            $title = !empty($row['board_title']) ? htmlspecialchars($row['board_title']) : '제목 없음';
        
            echo '
            <div class="border_px-u_001 grid_xx no_color_change" data-bg-color="#ffffff" data-bd-u-color="#d9d9d9"
                data-xx="10% 55% 15% 10% 10%" data-color="#333333">
                <div class="flex_xc padding_px-y_020">' . $index . '</div>
                <a href="'.DOMAIN.'/page/mentoring_private_view/?uniq_id='.$row['uniq_id'].'" class="flex_fl_yc padding_px-y_020 pointer">' . $title . '&nbsp;<div
                        class="border_px-a_001 border_bre-a_003 padding_px-x_003 font_px_012 flv6" data-color="#ff0000"
                        data-bd-a-color="#ff0000">N</div>
                </a>
                <div class="flex_xc padding_px-y_020">' . $user_nick_name . '</div>
                <div class="flex_xc padding_px-y_020">' . $publish_date . '</div>
                <div class="flex_xc padding_px-y_020">' . $view_count . '</div>
            </div>';
            
            $index++; // 인덱스 증가
        }
        ?>
    </div>
</section>