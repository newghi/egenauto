<?php
define('_EUNGABI_', true);
ini_set('display_errors', 1);
ini_set('memory_limit', '512M'); 
error_reporting(E_ALL);

// 1. JSON 헤더 설정
header('Content-Type: application/json; charset=utf-8');

// 2. DB 연결 정보
$host = 'localhost';
$user = 'root';
$password = '1111';
$database = 'CRM';

// 3. DB 연결
$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'DB 연결 실패: ' . mysqli_connect_error()]);
    exit;
}

// 4. POST 파라미터 처리
$user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';

// 5. SQL 준비
$sql = "SELECT * FROM members";
if (!empty($user_name)) {
    $safe_name = mysqli_real_escape_string($conn, $user_name);
    $sql .= " WHERE 이름 LIKE '%$safe_name%'";
}

// 6. 쿼리 실행
$result = mysqli_query($conn, $sql);

// 7. 결과 처리
// 결과 출력 (HTML 테이블 형태)
if ($result && mysqli_num_rows($result) > 0) {
    $i = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="grid_xx border_px-u_001" data-xx="5% 5% 12% 10% 12% 12% 11% 10% 10% 8% 5%"
            data-bd-a-color="#d9d9d9" data-bg-color="#ffffff">
            <label for="crm_searching_member_check_<?php echo $i; ?>"
                class="flex_xc border_px-r_001 padding_px-y_015 pointer" data-bd-a-color="#d9d9d9">
                <input class="border_px-a_001 width_px_020 height_px_020" type="checkbox"
                    id="crm_searching_member_check_<?php echo $i; ?>" data-bd-a-color="#d9d9d9">
            </label>
            <div class="flex_xc_yc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                <?php echo $i; ?>
            </div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                <?php echo !empty($row['등록일자']) ? htmlspecialchars($row['등록일자']) : '-'; ?>
            </div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                <?php echo htmlspecialchars($row['이름']); ?>
            </div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                <?php echo htmlspecialchars($row['회원_번호']); ?>
            </div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                <?php echo htmlspecialchars($row['휴대폰']); ?>
            </div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                <?php echo htmlspecialchars($row['이메일']); ?>
            </div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                <?php echo htmlspecialchars($row['코드생성1']); ?>
            </div>
            <div class="flex_xc border_px-r_001 padding_px-y_015" data-bd-a-color="#d9d9d9">
                <?php echo htmlspecialchars($row['회원']); ?>
            </div>
            <div class="flex_xc border_px-r_001 padding_px-y_015 " data-bd-a-color="#d9d9d9">
                <?php echo htmlspecialchars($row['성별'] ?? '모름'); ?>
            </div>
            <div class="flex_xc padding_px-y_015 pointer" data-bd-a-color="#d9d9d9"
                data-hover-bg-color="#15376b" data-hover-color="#ffffff">보기</div>
        </div>
        <?php
        $i++;
    }
} else {
    echo '<div class="padding_px-y_020 font_px_014">검색 결과가 없습니다.</div>';
}

// 9. DB 연결 종료
mysqli_close($conn);
?>
