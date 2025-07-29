<?php
// 전역 저장소 초기화
$GLOBALS['egb_hooks'] = [];
$GLOBALS['egb_hooks_counter'] = [];

// Hook 등록
function egb_hook_add($event, $callback, $group = 'default', $priority = null) {
    // 그룹별 우선순위 자동 증가
    if (!isset($GLOBALS['egb_hooks_counter'][$group])) {
        $GLOBALS['egb_hooks_counter'][$group] = 0;
    }

    if ($priority == null) {
        $priority = ++$GLOBALS['egb_hooks_counter'][$group];
    }

    // 중복 등록 방지
    foreach ($GLOBALS['egb_hooks'][$event][$priority] ?? [] as $existing) {
        if ($existing == $callback) {
            $msg = "[HOOK 중복 차단] '{$event}' (group: {$group}, priority: {$priority})";
            if (EGB_DEV_MODE) {
                trigger_error($msg, E_USER_WARNING);
            } else {
                error_log($msg);
            }
            return;
        }
    }

    // 등록
    $GLOBALS['egb_hooks'][$event][$priority][] = $callback;
}
?>
