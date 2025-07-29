<?php
//Hook 실행
function egb_hook($event, $payload = null) {
    if (empty($GLOBALS['egb_hooks'][$event])) return;

    ksort($GLOBALS['egb_hooks'][$event]); // 우선순위 정렬
    foreach ($GLOBALS['egb_hooks'][$event] as $priority => $callbacks) {
        foreach ($callbacks as $callback) {
            $callback($payload);
        }
    }
}

?>
