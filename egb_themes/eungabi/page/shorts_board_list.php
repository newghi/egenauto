<?php 

// 게시판 목록을 가져오는 쿼리
$query_board = "
    SELECT * FROM egb_board_shorts
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

                    <a href="<?php echo DOMAIN.'/page/shorts_board_view/?uniq_id='.$board_row['uniq_id']; ?>">
                        <div class="padding_px-a_010">
                            <div class="height_px_500 pointer video-container" data-video="<?php echo DOMAIN . $video; ?>">
                                <!-- 썸네일 이미지 -->
                                <img class="border_bre-a_004 width_box height_px_500 video-thumbnail"
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
        height: 500px;
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
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .video-container img.fade-out, .video-container video.fade-in {
        opacity: 0;
    }
    .video-container video.fade-in {
        opacity: 1;
    }
    .video-container img:hover {
        transform: scale(1.05);
    }
</style>

<script nonce="<?php echo NONCE; ?>">
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
                videoPlayer.preload = 'auto';
                videoPlayer.muted = true;
                videoPlayer.loop = true;
                videoPlayer.style.opacity = '0';
                videoPlayer.classList.add('fade-in');

                container.appendChild(videoPlayer);
            }

            if (videoPlayer.readyState >= 3) {
                timeoutId = setTimeout(function() {
                    videoPlayer.style.opacity = '1';
                    videoPlayer.play().catch(function(error) {
                        console.error("Error playing video: ", error);
                    });
                    thumbnail.classList.add('fade-out');
                }, 1000);
            } else {
                videoPlayer.addEventListener('canplay', function() {
                    setTimeout(function() {
                        videoPlayer.style.opacity = '1';
                        thumbnail.classList.add('fade-out');
                        videoPlayer.play().catch(function(error) {
                            console.error("Error playing video: ", error);
                        });
                    }, 1000);
                });
            }
        });

        container.addEventListener('mouseleave', function() {
            clearTimeout(timeoutId);
            if (videoPlayer) {
                videoPlayer.pause();
                videoPlayer.style.opacity = '0';
            }
            thumbnail.classList.remove('fade-out');
        });
    });
</script>
