<?php
//테마리스트 가져오기
function egb_theme_name_list() {
    $themes = [];
    $base_dir = ROOT . DS . 'egb_themes';

    if (!is_dir($base_dir)) {
        return $themes;
    }

    foreach (scandir($base_dir) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (is_dir($base_dir . '/' . $item)) {
            if ($item == 'eungabi') {
                array_unshift($themes, $item);
            } else {
                $themes[] = $item;
            }
        }
    }

    return $themes;
}

?>
