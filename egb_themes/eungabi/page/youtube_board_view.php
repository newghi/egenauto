
<?php
$uniq_id = egb('uniq_id');

if (isset($_SESSION['user_login']) && $_SESSION['user_login'] == 1) {
    $user_login = 'user';
}

if (isset($user_login)) {
    $login_user_uniq_id = $_SESSION['user_uniq_id'];
} else {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/youtube_board_preview/?uniq_id=' . $uniq_id . "'; </script>";
    exit;
}

// 게시물 데이터를 조회하는 쿼리
$query_post = "
    SELECT * FROM egb_board_youtube 
    WHERE uniq_id = :uniq_id
";
$params_post = [
    ':uniq_id' => $uniq_id
];
$binding_post = binding_sql(1, $query_post, $params_post);
$sql_post = egb_sql($binding_post);

// 결과 확인
if (!isset($sql_post[0]['uniq_id'])) {
    echo "<script nonce=" . NONCE . " type='text/javascript'>window.location.href='" . DOMAIN . '/page/youtube_board_list' . "'; </script>";
    exit;
}

$board_row = $sql_post[0];

// 게시물의 데이터를 JSON으로 파싱
$post_data = json_decode($board_row['board_data'], true);

$board_user_uniq_id = $board_row['board_user_uniq_id'];

// 유저 정보 가져오기
$query_user = "
    SELECT * FROM egb_user 
    WHERE uniq_id = :user_uniq_id
";
$params_user = [
    ':user_uniq_id' => $board_row['board_user_uniq_id']
];
$binding_user = binding_sql(1, $query_user, $params_user);
$sql_user = egb_sql($binding_user);

$user_name = isset($sql_user[0]['user_name']) ? $sql_user[0]['user_name'] : 'Unknown';
$user_uniq_id = $board_row['board_user_uniq_id'];

$view_total_count = $board_row['board_view'] + 1;
?>
<section class="position1 width_box height_box">
    <div class="padding_px-x_010">
        <div class="width_px_720 margin_x_auto padding_px-y_050" data-xy="1-800: width_box">
            <div class="video-container position-relative width_box height_auto" style="position: relative;">
                <!-- 비디오가 로드되기 전에는 이미지가 표시됩니다 -->
                <img id="youtube_main_img" src="<?php echo DOMAIN . $post_data['thumbnail']; ?>"
                    class="youtube_main_img width_box height_box" style="object-fit: cover;">
                <!-- 비디오가 로드되면 이미지를 숨기고 비디오가 표시됩니다 -->
                <video id="youtube_main_video" src="<?php echo DOMAIN . $post_data['video']; ?>" preload="metadata" playsinline
                    class="youtube_main_video width_box height_box" style="object-fit: cover; display:none;">
                    <source src="<?php echo DOMAIN . $post_data['video']; ?>" type="video/mp4">
                    브라우저가 비디오 재생을 지원하지 않습니다.
                </video>

                <!-- 사용자 UI 컨트롤 -->
                <div id="video_controls" class="video-controls">
                    <button id="play_pause" class="control-btn">
                        ▶ <!-- 재생/일시정지 버튼 -->
                    </button>
                    <button id="mute_unmute" class="control-btn">
                        🔇 <!-- 음소거/해제 버튼 -->
                    </button>
                    <input id="volume_slider" type="range" min="0" max="1" step="0.1" value="1" class="volume-slider">
                </div>
            </div>

            <div class="flex_ft font_px_015 youtube_content_1 padding_px-t_010">
                <div class="youtube_title_1 flv6 padding_px-u_010"><?php echo $post_data['title']; ?></div>
                <div class="youtube_contents_1"><?php echo nl2br($post_data['content']); ?></div>
            </div>

            <script nonce="<?php echo NONCE; ?>">
                // 비디오 및 이미지 요소
                var videoElement = document.getElementById('youtube_main_video');
                var imageElement = document.getElementById('youtube_main_img');
                var controls = document.getElementById('video_controls');
                var playPauseButton = document.getElementById('play_pause');
                var muteUnmuteButton = document.getElementById('mute_unmute');
                var volumeSlider = document.getElementById('volume_slider');
                var videoContainer = document.querySelector('.video-container');

                // 비디오 로드 에러 처리
                videoElement.addEventListener('error', function(e) {
                    console.error("비디오 로드 에러:", e.target.error);
                    // 에러 발생 시 이미지로 대체
                    imageElement.style.display = 'block';
                    videoElement.style.display = 'none';
                    controls.style.display = 'none';
                });

                // 비디오가 로드되면 이미지 숨기고 비디오를 표시
                videoElement.addEventListener('loadeddata', function() {
                    if (videoElement.readyState >= 2) { // 충분한 데이터가 로드됨
                        imageElement.style.display = 'none';  // 이미지 숨기기
                        videoElement.style.display = 'block'; // 비디오 표시
                    }
                });

                // 이미지 클릭 시 비디오 재생 시도
                imageElement.addEventListener('click', function() {
                    if (videoElement.readyState >= 2) { // 충분한 데이터가 있는지 확인
                        imageElement.style.display = 'none';
                        videoElement.style.display = 'block';
                        videoElement.play().catch(function(error) {
                            console.log("비디오 재생 에러:", error);
                            // 재생 실패 시 이미지로 복귀
                            imageElement.style.display = 'block';
                            videoElement.style.display = 'none';
                        });
                    }
                });

                // 마우스가 video-container에 들어올 때만 컨트롤 UI를 표시
                videoContainer.addEventListener('mouseenter', function() {
                    if (videoElement.readyState >= 2) {
                        controls.style.opacity = '1';  // UI 표시
                        controls.style.visibility = 'visible';
                    }
                });

                // 마우스가 video-container에서 나갈 때 컨트롤 UI를 숨김
                videoContainer.addEventListener('mouseleave', function() {
                    controls.style.opacity = '0';  // UI 숨기기
                    controls.style.visibility = 'hidden';
                });

                // 재생/일시정지 버튼 클릭 이벤트
                playPauseButton.addEventListener('click', function() {
                    if (videoElement.paused) {
                        videoElement.play().then(function() {
                            playPauseButton.innerHTML = '⏸'; // 일시정지 아이콘으로 변경
                        }).catch(function(error) {
                            console.log("재생 에러:", error);
                        });
                    } else {
                        videoElement.pause();
                        playPauseButton.innerHTML = '▶'; // 재생 아이콘으로 변경
                    }
                });

                // 음소거/해제 버튼 클릭 이벤트
                muteUnmuteButton.addEventListener('click', function() {
                    if (videoElement.muted) {
                        videoElement.muted = false;
                        muteUnmuteButton.innerHTML = '🔇'; // 음소거 아이콘으로 변경
                    } else {
                        videoElement.muted = true;
                        muteUnmuteButton.innerHTML = '🔊'; // 음소거 해제 아이콘으로 변경
                    }
                });

                // 볼륨 슬라이더 변경 이벤트
                volumeSlider.addEventListener('input', function() {
                    videoElement.volume = volumeSlider.value;
                });
            </script>

            <style>
                .video-container {
                    position: relative;
                }

                .video-controls {
                    position: absolute;
                    bottom: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    display: flex;
                    align-items: center;
                    justify-content: space-around;
                    background-color: rgba(0, 0, 0, 0.7);
                    padding: 10px 30px;
                    border-radius: 30px;
                    opacity: 0;
                    visibility: hidden;
                    transition: opacity 0.4s ease, visibility 0.4s ease;
                    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
                }

                .control-btn {
                    background: none;
                    border: none;
                    color: white;
                    font-size: 28px;
                    margin-right: 15px;
                    cursor: pointer;
                    transition: transform 0.2s, color 0.2s;
                }

                .control-btn:hover {
                    transform: scale(1.2);
                    color: #00ffcc;
                }

                .volume-slider {
                    -webkit-appearance: none;
                    width: 120px;
                    height: 8px;
                    background: linear-gradient(90deg, #00ffcc, #0099ff);
                    border-radius: 5px;
                    outline: none;
                    transition: opacity 0.2s;
                }

                .volume-slider::-webkit-slider-thumb {
                    -webkit-appearance: none;
                    appearance: none;
                    width: 16px;
                    height: 16px;
                    background: #ffffff;
                    border-radius: 50%;
                    cursor: pointer;
                    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
                }

                .volume-slider:hover {
                    opacity: 1;
                }

                /* UI 애니메이션과 디자인 */
                .video-container:hover .video-controls {
                    opacity: 1;
                    visibility: visible;
                }
            </style>
            <?php

            // SQL 쿼리 작성 (auto_like_status가 1인 갯수 조회)
            $query = "SELECT COUNT(*) as like_count 
          FROM egb_like_log 
          WHERE like_target_table = 'egb_board_youtube'
          AND like_target_uniq_id = :post_uniq_id";

            // 바인딩할 파라미터 설정
            $params = [
                ':post_uniq_id' => $uniq_id
            ];

            // 바인딩 쿼리 생성
            $binding = binding_sql(1, $query, $params);

            // 쿼리 실행
            $sql = egb_sql($binding);

            // 결과 확인 및 출력
            if (isset($sql[0]['like_count'])) {
                $like_count = $sql[0]['like_count'];
            } else {
                $like_count = 0;
            }
            ?>
            <?php

            // SQL 쿼리 작성 (auto_like_status가 1인 갯수 조회)
            $query = "SELECT COUNT(*) as scrap_count 
          FROM egb_scrap_log 
          WHERE scrap_target_table = 'egb_board_youtube'
          AND scrap_target_uniq_id = :post_uniq_id";

            // 바인딩할 파라미터 설정
            $params = [
                ':post_uniq_id' => $uniq_id
            ];

            // 바인딩 쿼리 생성
            $binding = binding_sql(1, $query, $params);

            // 쿼리 실행
            $sql = egb_sql($binding);

            // 결과 확인 및 출력
            if (isset($sql[0]['scrap_count'])) {
                $scrap_count = $sql[0]['scrap_count'];
            } else {
                $scrap_count = 0;
            }
            ?>
            <div class="flex_fl_yc_wrap padding_px-y_030 font_px_013" data-color="#828c94">
                <span><?php echo $board_row['created_at']; ?></span>
                <span class="padding_px-x_003">·</span>
                <span>좋아요&nbsp;<span class="youtube_side_heart_count"><?php echo number_format($like_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>스크랩&nbsp;<span class="youtube_side_scrap_count"><?php echo number_format($scrap_count); ?></span></span>
                <span class="padding_px-x_003">·</span>
                <span>조회&nbsp<span class="youtube_view_total_count"><?php echo number_format($view_total_count); ?></span></span>
            </div>
            <div class="flex_xs1_yc">
                <div class="flex_fl_yc font_px_011">
                    <div class="flex_yc padding_px-r_010">
                        <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                            class="width_px_040 height_px_040 border_bre-a_035">
                    </div>
                    <div class="flex_ft">
                        <div class="flex_yc font_px_014 flv6"><?php echo $user_name; ?></div>
                        <div class="flex_yc font_px_013" data-color="#828c94">소개말</div>
                    </div>
                </div>
                <div class="flex_xc">
                    <div class="border_px-a_001 border_bre-a_005 padding_px-x_020 padding_px-y_010 font_px_014 pointer"
                        data-bg-color="#15376b" data-bd-a-color="#15376b" data-color="#ffffff">팔로우</div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .more {
        flex-shrink: 0;
    }

    .a:hover .a_1 {
        scale: 1.2;
        transition: 0.4s;
    }
</style>
<?php
//댓글 출력
//프로팅 출력
auto_comment('egb_comment_youtube', $uniq_id, $board_user_uniq_id); 
auto_floating('egb_board_youtube', $uniq_id, 'youtube');

 //조회수 1증가
 $query = "UPDATE egb_board_youtube SET board_view = board_view + 1 WHERE uniq_id = :uniq_id";
 $params = [':uniq_id' => $uniq_id];
 $binding = binding_sql(1, $query, $params);
 $sql = egb_sql($binding);
 
?>