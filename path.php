<?php
/**
 * scan_structure.php
 *
 * 주어진 디렉터리(기본: 이 스크립트가 위치한 디렉터리)부터 시작하여
 * 모든 파일과 폴더 구조를 재귀적으로 탐색한 후 JSON으로 출력합니다.
 *
 * 사용법 (CLI):
 *   php scan_structure.php /path/to/start
 *
 * 사용법 (웹):
 *   https://your-domain.com/scan_structure.php?dir=/var/www/html
 */

// 1) 시작 디렉터리 결정
if (PHP_SAPI === 'cli') {
    $baseDir = isset($argv[1]) && is_dir($argv[1]) ? $argv[1] : getcwd();
} else {
    $baseDir = isset($_GET['dir']) && is_dir($_GET['dir']) ? $_GET['dir'] : __DIR__;
}

/**
 * 재귀적으로 디렉터리를 스캔하여 트리 구조 배열을 반환
 *
 * @param string $dir
 * @return array
 */
function scanDirTree(string $dir): array {
    $result = [];
    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            // 하위 폴더는 키를 디렉터리명으로, 값은 그 하위 트리
            $result[$item] = scanDirTree($path);
        } else {
            // 파일은 배열에 추가
            $result[] = $item;
        }
    }
    return $result;
}

// 2) 스캔 수행
$structure = scanDirTree($baseDir);

// 3) JSON 출력
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'success'  => true,
    'base_dir' => $baseDir,
    'tree'     => $structure,
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
exit;
?>