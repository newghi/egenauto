
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
        <div class="border_px-t_001 border_px-u_001 grid_xx fontstyle3" data-bg-color="#eeeeee"
            data-bd-t-color="#202020" data-bd-u-color="#d9d9d9" data-xx="10% 55% 15% 10% 10%">
            <div class="flex_xc padding_px-y_020">번호</div>
            <div class="flex_fl padding_px-y_020">제목</div>
            <div class="flex_xc padding_px-y_020">작성자</div>
            <div class="flex_xc padding_px-y_020">작성일</div>
            <div class="flex_xc padding_px-y_020">조회수</div>
        </div>
<?php
$login_user_uniq_id = $_SESSION['user_uniq_id'] ?? null;
$is_admin = isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === 'Y';

// 로그인한 사용자의 uniq_id
$allowed_user_uniq_ids = [$login_user_uniq_id];

if (!$is_admin) {
    // 사용자 정보 가져오기
    $query_get_user = "SELECT user_id, user_mentor_id FROM auto_user WHERE user_uniq_id = :login_user_uniq_id";
    $params_get_user = [':login_user_uniq_id' => $login_user_uniq_id];
    $binding_get_user = binding_sql(1, $query_get_user, $params_get_user);
    $sql_get_user = egb_sql($binding_get_user);

    if ($sql_get_user[0] && isset($sql_get_user[0])) {
        $user_data = $sql_get_user[0];
        $user_id = $user_data['user_id'];
        $user_mentor_id = $user_data['user_mentor_id'];

        if ($user_mentor_id) {
            // 멘티인 경우: 자신의 멘토의 uniq_id를 추가
            $query_get_mentor_uniq_id = "SELECT user_uniq_id FROM auto_user WHERE user_id = :mentor_id";
            $params_get_mentor_uniq_id = [':mentor_id' => $user_mentor_id];
            $binding_get_mentor_uniq_id = binding_sql(1, $query_get_mentor_uniq_id, $params_get_mentor_uniq_id);
            $sql_get_mentor_uniq_id = egb_sql($binding_get_mentor_uniq_id);

            if ($sql_get_mentor_uniq_id && isset($sql_get_mentor_uniq_id[0]['user_uniq_id'])) {
                $mentor_uniq_id = $sql_get_mentor_uniq_id[0]['user_uniq_id'];
                $allowed_user_uniq_ids[] = $mentor_uniq_id;
            }
        } else {
            // 멘토인 경우: 자신의 멘티들의 uniq_id를 추가
            $query_get_mentees = "SELECT user_uniq_id FROM auto_user WHERE user_mentor_id = :user_id";
            $params_get_mentees = [':user_id' => $user_id];
            $binding_get_mentees = binding_sql(1, $query_get_mentees, $params_get_mentees);
            $sql_get_mentees = egb_sql($binding_get_mentees);

            if ($sql_get_mentees && !empty($sql_get_mentees)) {
                foreach ($sql_get_mentees as $mentee) {
                    $allowed_user_uniq_ids[] = $mentee['user_uniq_id'];
                }
            }
        }
    }

    // allowed_user_uniq_ids를 사용하여 IN 절 생성
    $placeholders = [];
    $params = [];
    foreach ($allowed_user_uniq_ids as $index => $uniq_id) {
        $placeholder = ':user_uniq_id' . $index;
        $placeholders[] = $placeholder;
        $params[$placeholder] = $uniq_id;
    }
    $in_clause = implode(',', $placeholders);

    $query = "SELECT no, auto_mentoring_private_consultation_board_post_data, auto_mentoring_private_consultation_board_user_uniq_id, auto_mentoring_private_consultation_board_uniq_id, auto_mentoring_private_consultation_board_publish_date 
              FROM auto_mentoring_private_consultation_board 
              WHERE auto_mentoring_private_consultation_board_user_uniq_id IN ($in_clause)
              ORDER BY auto_mentoring_private_consultation_board_publish_date DESC";
} else {
    // 관리자는 모든 게시물을 볼 수 있음
    $query = "SELECT no, auto_mentoring_private_consultation_board_post_data, auto_mentoring_private_consultation_board_user_uniq_id, auto_mentoring_private_consultation_board_uniq_id, auto_mentoring_private_consultation_board_publish_date 
              FROM auto_mentoring_private_consultation_board 
              ORDER BY auto_mentoring_private_consultation_board_publish_date DESC";
    $params = [];
}

// 쿼리 실행
$binding = binding_sql(0, $query, $params);
$sql = egb_sql($binding);

// 결과가 없는 경우 처리
if (!isset($sql[0]) || empty($sql[0])) {
    echo "<div class='padding_px-y_010'>멘토 또는 멘티의 글만 확인 할 수 있습니다.</div>";
    exit;
}

// 결과가 있는 경우에만 출력
foreach ($sql[0] as $row) {
    // JSON 데이터 디코딩 및 구조 확인
    $post_data = json_decode($row['auto_mentoring_private_consultation_board_post_data'], true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "JSON Decode Error: " . json_last_error_msg();
        continue;
    }

    // 디코딩된 데이터 구조 확인
    if ($post_data === null) {
        echo "Decoding failed for post data with ID " . $row['no'];
        continue;
    }
    
    // 배열로 감싸져 있는 형식인지 확인하고, 첫 번째 요소를 선택
    if (isset($post_data[0])) {
        $post_data = $post_data[0];
    }

    // 제목, 내용 및 이미지 데이터 추출
    $title = isset($post_data['title']) ? htmlspecialchars($post_data['title']) : '제목없음';
    $content = isset($post_data['content']) ? $post_data['content'] : '';
    $image = isset($post_data['image']) ? $post_data['image'] : '';
    
    // 작성자 닉네임을 가져오는 쿼리
    $user_uniq_id = $row['auto_mentoring_private_consultation_board_user_uniq_id'];
    $user_query = "SELECT user_nick_name FROM auto_user WHERE user_uniq_id = :user_uniq_id";
    $user_params = [':user_uniq_id' => $user_uniq_id];
    $user_binding = binding_sql(1, $user_query, $user_params);
    $user_sql = egb_sql($user_binding);

    // 닉네임이 있는 경우, 없으면 기본값 설정
    $user_nick_name = isset($user_sql[0]['user_nick_name']) ? htmlspecialchars($user_sql[0]['user_nick_name']) : '알 수 없음';

    $publish_date = date("H:i", strtotime($row['auto_mentoring_private_consultation_board_publish_date']));
    $view_count = 0; // 조회수 임의 생성, 실제 조회수로 대체 가능

    echo '
    <a href="'.DOMAIN.'/page/mentoring_private_consultation_board_view/?uniq_id='.$row['auto_mentoring_private_consultation_board_uniq_id'].'" class="border_px-u_001 grid_xx pointer" data-bg-color="#ffffff" data-bd-u-color="#d9d9d9"
        data-xx="10% 55% 15% 10% 10%" data-color="#333333">
        <div class="flex_xc padding_px-y_020">' . htmlspecialchars($row['no']) . '</div>
        <div class="flex_fl_yc padding_px-y_020">' . $title . '&nbsp;<div
                class="border_px-a_001 border_bre-a_003 padding_px-x_003 font_px_012 flv6" data-color="#ff0000"
                data-bd-a-color="#ff0000">N</div>
        </div>
        <div class="flex_xc padding_px-y_020">' . $user_nick_name . '</div>
        <div class="flex_xc padding_px-y_020">' . $publish_date . '</div>
        <div class="flex_xc padding_px-y_020">' . $view_count . '</div>
    </a>';
}
?>




<!--
        <div class="border_px-u_001 grid_xx pointer" data-bg-color="#ffffff" data-bd-u-color="#d9d9d9"
            data-xx="10% 55% 15% 10% 10%" data-color="#333333">
            <div class="flex_xc padding_px-y_020">8019</div>
            <div class="flex_fl_yc padding_px-y_020">[정비꿀팁]바 어셈블리-스테빌라이저(부싱소음)에 대해 알아봅시다!&nbsp;<div
                    class="border_px-a_001 border_bre-a_003 padding_px-x_003 font_px_012 flv6" data-color="#ff0000"
                    data-bd-a-color="#ff0000">N</div>
            </div>
            <div class="flex_xc padding_px-y_020">관세음보살</div>
            <div class="flex_xc padding_px-y_020">18:46</div>
            <div class="flex_xc padding_px-y_020">8</div>
        </div>
        <div class="border_px-u_001 grid_xx pointer" data-bg-color="#ffffff" data-bd-u-color="#d9d9d9"
            data-xx="10% 55% 15% 10% 10%" data-color="#333333">
            <div class="flex_xc padding_px-y_020">8019</div>
            <div class="flex_fl_yc padding_px-y_020">[자유게시판]일욜입니다&nbsp;<div
                    class="border_px-a_001 border_bre-a_003 padding_px-x_003 font_px_012 flv6" data-color="#ff0000"
                    data-bd-a-color="#ff0000">N</div>&nbsp;<span data-color="#ff0000">[1]</span></div>
            <div class="flex_xc padding_px-y_020">shwany</div>
            <div class="flex_xc padding_px-y_020">15:21</div>
            <div class="flex_xc padding_px-y_020">7</div>
        </div>
        <div class="border_px-u_001 grid_xx pointer" data-bg-color="#ffffff" data-bd-u-color="#d9d9d9"
            data-xx="10% 55% 15% 10% 10%" data-color="#333333">
            <div class="flex_xc padding_px-y_020">8019</div>
            <div class="flex_fl_yc padding_px-y_020">[자유게시판]오늘이 바로 밤과 낮의 길이가 같은 절기 '추분'입니다!&nbsp;<div
                    class="border_px-a_001 border_bre-a_003 padding_px-x_003 font_px_012 flv6" data-color="#ff0000"
                    data-bd-a-color="#ff0000">N</div>&nbsp;<span data-color="#ff0000">[1]</span></div>
            <div class="flex_xc padding_px-y_020">관세음보살</div>
            <div class="flex_xc padding_px-y_020">14:09</div>
            <div class="flex_xc padding_px-y_020">11</div>
        </div>
-->
    </div>
</section>