    <?php
//Hook 리스트
function egb_hook_list($as_array = 1, $event = null) {
    $result = [];

    $target = $event ? array($event => (isset($GLOBALS['egb_hooks'][$event]) ? $GLOBALS['egb_hooks'][$event] : array())) : $GLOBALS['egb_hooks'];

    foreach ($target as $event_key => $hooks) {
        ksort($hooks);
        foreach ($hooks as $priority => $callbacks) {
            foreach ($callbacks as $cb) {
                $cb_type = is_string($cb) ? 0 : (is_array($cb) ? 1 : 2);
                if ($cb_type == 0) {
                    $cb_name = $cb;
                } else if ($cb_type == 1) {
                    if (is_object($cb[0])) {
                        $cb_name = get_class($cb[0]) . '->' . $cb[1];
                    } else {
                        $cb_name = $cb[0] . '::' . $cb[1];
                    }
                } else {
                    $cb_name = 'Closure';
                }
                $result[] = array(
                    'event'    => $event_key,
                    'priority' => $priority, 
                    'type'     => $cb_type,   // 0 = 함수, 1 = 배열, 2 = 클로저
                    'callback' => $cb_name,
                );
            }
        }
    }

    return $as_array == 1 ? $result : json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
?>
