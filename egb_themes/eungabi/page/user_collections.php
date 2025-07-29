<?php
// 사용자 ID를 가져옴
$user_uniq_id = $_GET['uniq_id'];

// 사용자 ID가 존재하는지 확인
if (!isset($user_uniq_id)) {
    echo json_encode(['success' => false, 'errorCode' => 1]); // 오류 코드 1: ID 없음
    exit;
}

// 닉네임 조회 쿼리
$query = "SELECT user_nick_name FROM auto_user WHERE user_uniq_id = :user_uniq_id";
$params = [
    ':user_uniq_id' => $user_uniq_id
];

// 바인딩 SQL 생성
$binding = binding_sql(1, $query, $params);

// SQL 실행
$sql_result = egb_sql($binding);

// 결과 확인 및 출력
if (isset($sql_result[0]['user_nick_name'])) {
    $user_nick_name = $sql_result[0]['user_nick_name'];
} else {
    $user_nick_name = '유저 정보가 없음';
}


// 쿼리 정의
$query = "SELECT * FROM auto_post_scrap 
WHERE auto_scrap_user_uniq_id = :auto_scrap_user_uniq_id 
AND auto_scrap_status = :auto_scrap_status";
$params = [
    ':auto_scrap_user_uniq_id' => $user_uniq_id,
	':auto_scrap_status' => 1
];

// 쿼리 바인딩
$binding = binding_sql(0, $query, $params);

// 쿼리 실행
$sql = egb_sql($binding);

?>
<section class="position1 width_box padding_px-t_050">
    <div class="width_px_1220 margin_x_auto" data-xy="1-1220: width_box">
        <div class="padding_px-x_010">
            <div class="flex_xs1_yc">
                <div class="font_px_025 flv6" data-xy="1-800: font_px_020">스크랩북</div>
                <div class="flex_xc_yc">
                    <div class="flex_fl_yc border_px-a_001 padding_px-y_010 padding_px-x_015 border_bre-a_005 pointer"
                        data-bg-color="#ffffff" data-hover-bg-color="#F7F9FA" data-bd-a-color="#d9d9d9">
                        <div class="width_px_015 height_px_015 margin_px-r_005">
                            <svg id="Layer_1" height="100%" viewBox="0 0 64 64" width="100%"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="m49.643 39.286c-3.479 0-6.563 1.725-8.442 4.363l-16.98-8.489c.32-.997.493-2.059.493-3.16s-.173-2.164-.493-3.161l16.979-8.489c1.879 2.64 4.963 4.364 8.442 4.364 5.712 0 10.358-4.646 10.358-10.357s-4.646-10.357-10.357-10.357-10.357 4.646-10.357 10.357c0 .806.093 1.591.268 2.344l-17.273 8.636c-1.901-2.257-4.748-3.694-7.924-3.694-5.711 0-10.357 4.646-10.357 10.357s4.646 10.357 10.357 10.357c3.176 0 6.023-1.437 7.924-3.695l17.272 8.637c-.175.753-.268 1.538-.268 2.344.001 5.711 4.647 10.357 10.358 10.357s10.357-4.646 10.357-10.357-4.646-10.357-10.357-10.357zm0-31.286c3.505 0 6.357 2.852 6.357 6.357s-2.852 6.357-6.357 6.357-6.356-2.852-6.356-6.357 2.851-6.357 6.356-6.357zm-35.286 30.357c-3.505 0-6.357-2.851-6.357-6.357 0-3.505 2.852-6.357 6.357-6.357s6.357 2.852 6.357 6.357c0 3.506-2.852 6.357-6.357 6.357zm35.286 17.643c-3.505 0-6.356-2.852-6.356-6.357s2.852-6.356 6.356-6.356c3.506 0 6.357 2.852 6.357 6.356 0 3.505-2.852 6.357-6.357 6.357z" />
                            </svg>
                        </div>
                        <div class="font_px_014">공유하기</div>
                    </div>
                </div>
            </div>
            <div class="flex_ft_yc padding_px-t_010 padding_px-u_050">
                <div class="width_px_100 height_px_100 border_px-a_001 border_bre-a_100 overflow_hidden"
                    data-bd-a-color="#efefef">
                    <img src="<?php echo DOMAIN . THEMES_PATH . '/img/z.gif'; ?>" class="width_box height_box">
                </div>
                <div class="padding_px-t_015 font_px_020 flv6">
					<?php echo  $user_nick_name; ?>
				</div>
            </div>
        </div>
    </div>
</section>
<section class="position1 width_box border_px-u_001" data-bd-a-color="#d9d9d9">
    <div class="flex_xc flv6">
        <div class="padding_px-x_016 padding_px-y_010 border_px-u_002 pointer favorite_button choice_favorite_button"
            data-bd-a-color="transparent">
            <div>모두<span>(3)</span></div>
        </div>
        <div class="padding_px-x_016 padding_px-y_010 border_px-u_002 pointer favorite_button"
            data-bd-a-color="transparent">
            <div>사진<span>(3)</span></div>
        </div>
    </div>
</section>
<style>
    .choice_favorite_button {
        color: #15376b;
        border-color: #15376b;
    }
</style>
<section class="position1 width_box padding_px-u_050">
    <div class="width_px_1220 margin_x_auto" data-xy="1-1220: width_box">
        <div class="padding_px-x_010">
            <div class="flex_xs1_yc padding_px-y_015 font_px_014 flv6">
                <div>
                    <div class="edit_favorite_number display_off">
                        <span data-color="#15376b">0</span>/<span>50</span>
                    </div>
                </div>
                <div class="">
                    <div class="flex_yc pointer" data-color="#15376b">
                        <div class="margin_px-r_010 edit_favorite_button edit">편집</div>
                        <div class="margin_px-r_010 edit_favorite_button delete display_off">삭제</div>
                        <div class="margin_px-r_010 edit_favorite_button cancel display_off">취소</div>
                    </div>
                </div>
            </div>
            <div class="grid_xx font_px_012 flv6" data-xx="25% 25% 25% 25%" data-xy="1-767: xx-50per~50per, 768-1000: xx-1fr~1fr~1fr">
<?php
// 결과 확인 및 HTML 반복 생성
// 결과 확인 및 동적 데이터 처리
if (isset($sql[0])) {
	
	$i = 0;
	
    foreach ($sql[0] as $row) {
		
        $tableName = $row['auto_scrap_table_name'];
        $postId = $row['auto_scrap_post_uniq_id'];

        // 테이블 이름에서 'auto_'와 '_board'를 제거하고 중간 값을 추출
        $contentType = str_replace(['auto_', '_board'], '', $tableName);

        // 동적으로 테이블에서 해당 게시글을 가져오는 쿼리 생성
        $postQuery = "
            SELECT * 
            FROM $tableName 
            WHERE auto_{$contentType}_board_uniq_id = :post_id
        ";
        $postParams = [':post_id' => $postId];

        // 게시글 데이터 쿼리 실행
        $postBinding = binding_sql(1, $postQuery, $postParams);
        $postResult = egb_sql($postBinding);

        // 게시글 데이터가 있는 경우 HTML로 출력
        if (isset($postResult[0])) {
            $postData = json_decode($postResult[0]["auto_{$contentType}_board_post_data"], true);
            ?>
                <div class="padding_px-a_010">
                    <div class="position1 border_px-a_001 border_bre-a_005 pointer overflow_hidden"
                        data-bd-a-color="#efefef">
                        <img src="<?php echo $postData[0]['image']; ?>"
                            class="width_box height_box img_scale_hover no_drag">
                        <div class="position2 width_box height_box none_click flex_ft_xs1" data-top="0%" data-left="0%">
                            <div class="flex_xr">
                                <div class="padding_px-a_010" data-hover-color="#ff0000">
                                    <svg width="12px" height="12px" fill="#ffffff" version="1.1" id="Capa_1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        x="0px" y="0px" viewBox="0 0 490.667 490.667"
                                        style="enable-background:new 0 0 490.667 490.667;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path d="M480,0H53.333c-5.888,0-10.667,4.779-10.667,10.667V64h-32C4.779,64,0,68.779,0,74.667V480
            c0,5.888,4.779,10.667,10.667,10.667H416c5.888,0,10.667-4.779,10.667-10.667v-32H480c5.888,0,10.667-4.779,10.667-10.667V10.667
            C490.667,4.779,485.888,0,480,0z M405.333,437.333v32h-384v-384h32h352V437.333z M469.333,426.667h-42.667v-352
            C426.667,68.779,421.888,64,416,64H64V21.333h405.333V426.667z" />
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex_fl">
                                <div class="padding_px-a_010">
                                    <div class="padding_px-a_005 border_bre-a_005" data-bg-color="#000000cc"
                                        data-color="#ffffff">사진</div>
                                </div>
                            </div>
                        </div>
                        <div class="position2 width_box height_box checked_favorite_img_box_color checked_favorite_img_box_change_color display_off"
                            data-top="0%" data-left="0%">
                            <label for="checked_favorite_img_box_<?php echo $i; ?>">
                                <div class="width_box height_box padding_px-a_005 pointer">
                                    <input id="checked_favorite_img_box_<?php echo $i; ?>" type="checkbox"
                                        class="width_px_016 height_px_016">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            <?php
        } else {
            echo "<p>No post found for table: $tableName, Post ID: $postId</p>";
        }
	$i++;
    }
} else {
    echo "No scrap data found.";
}


?>



            </div>
        </div>
    </div>
</section>
<style>
    .img_scale_hover:hover {
        scale: 1.2;
        transition: 0.4s;
    }

    .none_click {
        pointer-events: none;
    }

    .no_drag {
        -webkit-user-drag: none;
        /* 크롬, 사파리 */
        -khtml-user-drag: none;
        /* 옛날 Konqueror 브라우저 */
        -moz-user-drag: none;
        /* 파이어폭스 */
        -o-user-drag: none;
        /* 오페라 */
        user-drag: none;
        /* 기본 브라우저 */
    }
</style>
<script nonce="<?php echo NONCE; ?>">
   const editFavoriteNumber = document.querySelector('.edit_favorite_number');
const editButton = document.querySelector('.edit');
const cancelButton = document.querySelector('.cancel');
const deleteButton = document.querySelector('.delete');

// 초기 상태 설정 (기존 스타일 유지)
document.querySelectorAll('.checked_favorite_img_box_change_color').forEach((box) => {
    box.style.backgroundColor = 'transparent';
    box.style.transition = 'background-color 0.3s ease'; // 부드러운 전환 효과
});

// 편집 버튼 클릭 시: 취소, 삭제, 숫자 표시를 보이고, 편집 버튼을 숨김
editButton.addEventListener('click', function () {
    editButton.classList.add('display_off');
    cancelButton.classList.remove('display_off');
    deleteButton.classList.remove('display_off');
    editFavoriteNumber.classList.remove('display_off');

    document.querySelectorAll('.checked_favorite_img_box_change_color').forEach((box) => {
        box.classList.remove('display_off'); // 모든 박스 보이기
    });
});

// 취소 버튼 클릭 시: 모든 요소를 숨기고 편집 버튼 보이기
cancelButton.addEventListener('click', function () {
    editButton.classList.remove('display_off');
    cancelButton.classList.add('display_off');
    deleteButton.classList.add('display_off');
    editFavoriteNumber.classList.add('display_off');

    document.querySelectorAll('.checked_favorite_img_box_change_color').forEach((box) => {
        box.classList.add('display_off'); // 모든 박스 숨기기
    });
});

// 이벤트 위임: body에서 모든 체크박스의 change 이벤트 처리
document.body.addEventListener('change', function (event) {
    const target = event.target;

    // 체크박스가 "checked_favorite_img_box"로 시작하는지 확인
    if (target.id && target.id.startsWith('checked_favorite_img_box')) {
        const favoriteImgBox = target.closest('.checked_favorite_img_box_change_color');

        if (favoriteImgBox) {
            if (target.checked) {
                favoriteImgBox.style.backgroundColor = '#00000080'; // 체크 시 색상 변경
            } else {
                favoriteImgBox.style.backgroundColor = 'transparent'; // 체크 해제 시 원상복구
            }
        }
    }
});

</script>