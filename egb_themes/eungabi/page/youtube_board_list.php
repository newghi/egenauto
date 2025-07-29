<?php 

// 게시판 목록을 가져오는 쿼리
$query_board = "
    SELECT * FROM egb_board_youtube
    ORDER BY display_order ASC, created_at DESC
";
$params_board = [];
$binding_board = binding_sql(0, $query_board, $params_board);
$sql_board = egb_sql($binding_board);

?>

<section class="position1 width_box">
    <div class="width_px_1220 margin_x_auto padding_px-y_030 " data-color="#2f3438" data-xy="0-1220: width_box">
        <div class="padding_px-u_050 grid_xx font_px_016 line_height_150" data-xx="1fr 1fr 1fr" data-xy="0-600: xx-1ft, 601-1220: xx-1fr-1fr">
            
            <?php if (isset($sql_board[0][0])): ?>
                <?php foreach ($sql_board[0] as $board_row): ?>
                    <?php
                        // 게시물 데이터 JSON 파싱
                        $post_data = json_decode($board_row['board_data'], true);
                        
                        // 타이틀 및 썸네일 처리
                        $title = isset($post_data['title']) ? htmlspecialchars($post_data['title']) : 'No Title';
                        $thumbnail = isset($post_data['thumbnail']) ? htmlspecialchars($post_data['thumbnail']) : '/egb_thumbnail.webp';
                        $video = isset($post_data['video']) ? htmlspecialchars($post_data['video']) : '';
                        
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

                        $user_name = isset($sql_user[0]['user_name']) ? htmlspecialchars($sql_user[0]['user_name']) : 'Unknown';
                        
                        // 생성일 포맷팅
                        $created_date = date('Y-m-d', strtotime($board_row['created_at']));
                    ?>

                    <a href="<?php echo DOMAIN.'/page/youtube_board_view/?uniq_id='.$board_row['uniq_id']; ?>">
                        <div class="padding_px-a_010">
                            <div class="height_px_280 pointer video-container" data-video="<?php echo DOMAIN . $video; ?>">
                                <!-- 썸네일 이미지 -->
                                <img class="border_bre-a_004 width_box height_px_280 video-thumbnail"
                                     src="<?php echo DOMAIN . $thumbnail; ?>"
                                     style="object-fit: cover;">
                            </div>
                            <div class="flex_ft padding_px-t_010 pointer">
                                <div class="font_px_016 flv6 hidetext" data-color="#222222">
                                    <?php echo $title; ?>
                                </div>
                                <div class="flex_fl_yc padding_px-t_010 font_px_014">
                                    <div class="flex_fl_yc">
                                        <div class="flex_yc padding_px-r_005">
                                            <img src="<?php echo DOMAIN . THEMES_PATH . '/img/icon/profile.svg'; ?>"
                                                class="width_px_025 height_px_025 border_bre-a_020">
                                        </div>
                                        <div class="flex_yc flv6"><?php echo $user_name; ?></div>
                                    </div>
                                    <div class="">｜</div>
                                    <div>경력 15년 이상</div>
                                    <div>｜</div>
                                    <div>멘티 12명</div>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>등록된 게시물이 없습니다.</p>
            <?php endif; ?>
            
        </div>
    </div>
</section>

<style>
    .hidetext {
        white-space: normal;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .video-container {
        position: relative;
        width: 100%;
        height: 280px;
        overflow: hidden;
    }
    .video-container img, .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 1;
        transition: opacity 0.5s ease, transform 0.5s ease; /* 부드러운 전환 및 스케일 효과 */
    }
    .video-container img.fade-out, .video-container video.fade-in {
        opacity: 0; /* 서서히 사라짐 */
    }
    .video-container video.fade-in {
        opacity: 1; /* 서서히 나타남 */
    }
    .video-container img:hover {
        transform: scale(1.05); /* 호버 시 확대 */
    }
</style>

<script nonce="<?php echo NONCE; ?>">
    // 모든 비디오 컨테이너에 마우스 호버 이벤트 추가
    document.querySelectorAll('.video-container').forEach(function(container) {
        const thumbnail = container.querySelector('.video-thumbnail');
        let videoPlayer = null;
        let timeoutId = null;
        const videoSrc = container.getAttribute('data-video');

        container.addEventListener('mouseenter', function() {
            if (!videoPlayer) {
                videoPlayer = document.createElement('video');
                videoPlayer.src = videoSrc;
                videoPlayer.width = container.offsetWidth;
                videoPlayer.height = container.offsetHeight;
                videoPlayer.style.position = 'absolute';
                videoPlayer.style.top = 0;
                videoPlayer.style.left = 0;
                videoPlayer.style.objectFit = 'cover';
                videoPlayer.preload = 'auto'; // 비디오 미리 로드
                videoPlayer.muted = true; // 음소거
                videoPlayer.loop = true; // 반복 재생
                videoPlayer.style.opacity = '0'; // 처음엔 숨김
                videoPlayer.classList.add('fade-in'); // 동영상 서서히 나타남

                container.appendChild(videoPlayer);
            }

            // 비디오가 이미 로드된 경우 1초 후에 보여줌
            if (videoPlayer.readyState >= 3) { // readyState가 3 이상이면 데이터가 로드된 상태
                timeoutId = setTimeout(function() {
                    videoPlayer.style.opacity = '1'; // 1초 후에 비디오 보이기
                    videoPlayer.play().catch(function(error) {
                        console.error("Error playing video: ", error);
                    });
                    thumbnail.classList.add('fade-out'); // 썸네일 서서히 사라짐
                }, 1000); // 1초 후에 비디오 보여주기
            } else {
                videoPlayer.addEventListener('canplay', function() {
                    setTimeout(function() {
                        videoPlayer.style.opacity = '1'; // 비디오가 로드되면 1초 후에 보여주기
                        thumbnail.classList.add('fade-out'); // 썸네일 서서히 사라짐
                        videoPlayer.play().catch(function(error) {
                            console.error("Error playing video: ", error);
                        });
                    }, 1000);
                });
            }
        });

        // 마우스를 떼면 타이머를 취소하고, 동영상을 숨기고 썸네일 다시 표시
        container.addEventListener('mouseleave', function() {
            clearTimeout(timeoutId); // 마우스를 떼면 타이머 취소
            if (videoPlayer) {
                videoPlayer.pause(); // 비디오 일시정지
                videoPlayer.style.opacity = '0'; // 비디오 숨기기
            }
            thumbnail.classList.remove('fade-out'); // 썸네일 다시 보이기
        });
    });
</script>
