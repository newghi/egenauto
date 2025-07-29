<?php
// 캐시 디렉토리와 TTL(초) 설정
define('EGB_CACHE_DIR', ROOT . DS . 'egb_cache' . DS);
define('EGB_CACHE_TTL', 300);

// 디렉토리 없으면 생성
if (!is_dir(EGB_CACHE_DIR) && !mkdir(EGB_CACHE_DIR, 0755, true)) {
    throw new RuntimeException('캐시 디렉토리 생성 실패: ' . EGB_CACHE_DIR);
}

/**
 * 캐시 파일 경로 반환
 */
function egb_cache_path($key)
{
    return EGB_CACHE_DIR . sha1($key) . '.cache';
}

/**
 * 캐시 저장
 */
function egb_cache_save($key, $value)
{
    $file = egb_cache_path($key);
    $tmp  = tempnam(EGB_CACHE_DIR, 'tmp_');
    if ($tmp === false) {
        return false;
    }
    $data = serialize($value);
    if (file_put_contents($tmp, $data, LOCK_EX) === false) {
        @unlink($tmp);
        return false;
    }
    return rename($tmp, $file);
}

/**
 * 캐시 로드
 * 만료됐거나 없으면 false 반환
 */
function egb_cache_load($key)
{
    $file = egb_cache_path($key);
    if (!is_file($file)) {
        return false;
    }
    
    if (filemtime($file) + EGB_CACHE_TTL < time()) {
        if (is_file($file)) {
            @unlink($file); // @ 연산자로 에러 억제
        }
        return false;
    }
    
    $contents = file_get_contents($file);
    if ($contents === false) {
        return false;
    }
    return unserialize($contents);
}

/**
 * 캐시 삭제
 */
function egb_cache_delete($key)
{
    $file = egb_cache_path($key);
    if (is_file($file)) {
        return @unlink($file); // @ 연산자로 에러 억제
    }
    return false;
}

/**
 * 전체 캐시 비우기
 */
function egb_cache_clear()
{
    $files = glob(EGB_CACHE_DIR . '*.cache');
    if ($files === false) {
        return;
    }
    foreach ($files as $file) {
        if (is_file($file)) {
            @unlink($file); // @ 연산자로 에러 억제
        }
    }
}

