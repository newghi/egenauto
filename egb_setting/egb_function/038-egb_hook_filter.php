<?php
//Hook 필터 (값 변경 반환)
function egb_hook_filter($event, $value) {
    if (empty($GLOBALS['egb_hooks'][$event])) return $value;

    ksort($GLOBALS['egb_hooks'][$event]); // 우선순위 정렬
    foreach ($GLOBALS['egb_hooks'][$event] as $priority => $callbacks) {
        foreach ($callbacks as $callback) {
            $value = $callback($value);
        }
    }
    return $value;
}
?>
