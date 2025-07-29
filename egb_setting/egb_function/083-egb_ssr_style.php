<?php

define('EGB_BASE_VW',   0.833335);
define('EGB_START_VW',  0.052084); 
define('EGB_REF_PX',   16.0);

function egb_ssr_style($classes) {
    $seenVars = [];  // 이미 만든 --size-XXX
    $rootCss   = [];
    $rules     = [];
    // CSS 속성 프리픽스 정의
    $validPrefixes = [
        'align_content' => 'align-content',
        'align_items' => 'align-items', 
        'align_self' => 'align-self',
        'animation_delay' => 'animation-delay',
        'animation_direction' => 'animation-direction',
        'animation_duration' => 'animation-duration',
        'animation_fill_mode' => 'animation-fill-mode',
        'animation_iteration_count' => 'animation-iteration-count',
        'animation_name' => 'animation-name',
        'animation_play_state' => 'animation-play-state',
        'animation_timing_function' => 'animation-timing-function',
        'background_attachment' => 'background-attachment',
        'background_clip' => 'background-clip',
        'background_color' => 'background-color',
        'background_image' => 'background-image',
        'background_position' => 'background-position',
        'background_repeat' => 'background-repeat',
        'background_size' => 'background-size',
        'border_collapse' => 'border-collapse',
        'border_color' => 'border-color',
        'border_spacing' => 'border-spacing',
        'border_style' => 'border-style',
        'border_width' => 'border-width',
        'box_shadow' => 'box-shadow',
        'box_sizing' => 'box-sizing',
        'cursor' => 'cursor',
        'flex_direction' => 'flex-direction',
        'flex_wrap' => 'flex-wrap',
        'font_family' => 'font-family',
        'font_size' => 'font-size',
        'font_style' => 'text-align',
        'font_weight' => 'font-weight',
        'justify_content' => 'justify-content',
        'letter_spacing' => 'letter-spacing',
        'line_height' => 'line-height',
        'list_style' => 'list-style',
        'opacity' => 'opacity',
        'order' => 'order',
        'outline' => 'outline',
        'overflow' => 'overflow',
        'position' => 'position',
        'text_align' => 'text-align',
        'text_decoration' => 'text-decoration',
        'text_transform' => 'text-transform',
        'transform' => 'transform',
        'transition' => 'transition',
        'vertical_align' => 'vertical-align',
        'visibility' => 'visibility',
        'white_space' => 'white-space',
        'word_break' => 'word-break',
        'word_spacing' => 'word-spacing',
        'z_index' => 'z-index',
        'z-index' => 'z-index',
        'zm-index' => 'z-index',
        'flex_shrink' => 'flex-shrink'
    ];

    
    foreach ($classes as $cls) {
        
        // line-height 처리
        if (preg_match('/^line_height_(\d+)$/', $cls, $m)) {
            $size = (int)$m[1] / 100;
            $rules[] = ".{$cls}{line-height: " . number_format($size, 2) . ";}";
            continue;
        }

        

        // word-spacing 처리 
        if (preg_match('/^word_spacing_(\d+)$/', $cls, $m)) {
            $size = (int)$m[1] / 100;
            $rules[] = ".{$cls}{word-spacing: " . number_format($size, 2) . ";}";
            continue;
        }

        // letter-spacing 처리
        if (preg_match('/^letter_spacing_(\d+)$/', $cls, $m)) {
            $size = (int)$m[1] / 100;
            $rules[] = ".{$cls}{letter-spacing: " . number_format($size, 2) . "px;}";
            continue;
        }

        // word-break 처리
        if (preg_match('/^word_break_(.+)$/', $cls, $m)) {
            $value = $m[1];
            // word-break 속성값 검증 및 변환
            switch($value) {
                case 'all':
                    $value = 'break-all';
                    break;
                case 'word':
                    $value = 'break-word';
                    break;
                case 'keep':
                    $value = 'keep-all';
                    break;
                case 'spaces':
                    $value = 'break-spaces';
                    break;
                case 'normal':
                default:
                    $value = 'normal';
                    break;
            }
            $rules[] = ".{$cls}{word-break:{$value};}";
            continue;
        }

        // display 처리
        if (strpos($cls, 'display_') === 0) {
            $value = substr($cls, strlen('display_'));
            $value = str_replace('_', '-', $value);
            if ($value === 'off') {
                $rules[] = ".{$cls}{display:none !important;}";
            } else {
                $rules[] = ".{$cls}{display:{$value};}";
            }
            continue;
        }

        // object-fit 처리
        if (strpos($cls, 'object_fit_') === 0) {
            $value = substr($cls, strlen('object_fit_'));
            $value = str_replace('_', '-', $value);
            $rules[] = ".{$cls}{object-fit:{$value};}";
            continue;
        }
        // color-888888 또는 color_888888
        if (preg_match('/^color[-_]([0-9A-Fa-f]{6})$/', $cls, $m)) {
            $color = '#'.$m[1];
            $rules[] = ".{$cls}{color:{$color};}";
            continue;
        }


        // bg-color-888888 
        if (preg_match('/^bg-color-([0-9A-Fa-f]{6})$/i', $cls, $m)) {
            $color = '#'.$m[1];
            $rules[] = ".{$cls}{background-color:{$color};}";
            continue;
        }

        // bd-a-color-888888 (border-color)
        if (preg_match('/^bd-([a-z])-color-([0-9A-Fa-f]{6})$/i', $cls, $m)) {
            $dir = $m[1];
            $color = '#'.$m[2];
            
            switch($dir) {
                case 'a': // all
                    $rules[] = ".{$cls}{border-top-color:{$color};border-right-color:{$color};border-bottom-color:{$color};border-left-color:{$color};}";
                    break;
                case 'x': // horizontal
                    $rules[] = ".{$cls}{border-left-color:{$color};border-right-color:{$color};}";
                    break;
                case 'y': // vertical
                    $rules[] = ".{$cls}{border-top-color:{$color};border-bottom-color:{$color};}";
                    break;
                case 't': // top
                    $rules[] = ".{$cls}{border-top-color:{$color};}";
                    break;
                case 'u': // bottom
                    $rules[] = ".{$cls}{border-bottom-color:{$color};}";
                    break;
                case 'l': // left
                    $rules[] = ".{$cls}{border-left-color:{$color};}";
                    break;
                case 'r': // right
                    $rules[] = ".{$cls}{border-right-color:{$color};}";
                    break;
            }
            continue;
        }

        // 폰트 두께 처리 
        if (preg_match('/^flv([1-9])$/', $cls, $m)) {
            $weight = $m[1] * 100;
            $rules[] = ".{$cls}{font-weight:{$weight};}";
            continue;
        }

        // o_4
        if (preg_match('/^o_(\d+)$/', $cls, $m)) {
            $opacity = $m[1] / 10;
            $rules[] = ".{$cls}{opacity:{$opacity};}";
            continue;
        }

        // border radius 처리 - border_bre 버전
        if (preg_match('/^border_bre-([a-z]+)_(\d+)$/', $cls, $m)) {
            list(, $dir, $size) = $m;
            $n = (int)$size;
            
            if (!isset($seenVars[$n])) {
                $seenVars[$n] = true;
                $rootCss[] = make_root_var($n);
            }
            
            $var = "var(--size-".sprintf('%03d',$n).", {$n}px)";
            
            switch($dir) {
                case 'a':
                    $rules[] = ".{$cls}{border-radius:{$var};border-top-left-radius:{$var};border-top-right-radius:{$var};border-bottom-left-radius:{$var};border-bottom-right-radius:{$var};}";
                    break;
                case 'tx':
                    $rules[] = ".{$cls}{border-top-left-radius:{$var};border-top-right-radius:{$var};}";
                    break;
                case 'ux':
                    $rules[] = ".{$cls}{border-bottom-left-radius:{$var};border-bottom-right-radius:{$var};}";
                    break;
                case 'ly':
                    $rules[] = ".{$cls}{border-top-left-radius:{$var};border-bottom-left-radius:{$var};}";
                    break;
                case 'ry':
                    $rules[] = ".{$cls}{border-top-right-radius:{$var};border-bottom-right-radius:{$var};}";
                    break;
                case 'tl':
                    $rules[] = ".{$cls}{border-top-left-radius:{$var};}";
                    break;
                case 'tr':
                    $rules[] = ".{$cls}{border-top-right-radius:{$var};}";
                    break;
                case 'ul':
                    $rules[] = ".{$cls}{border-bottom-left-radius:{$var};}";
                    break;
                case 'ur':
                    $rules[] = ".{$cls}{border-bottom-right-radius:{$var};}";
                    break;
            }
            continue;
        }

        // border radius 처리 - border_radius 버전 
        if (preg_match('/^border_radius-([a-z]+)_(\d+)$/', $cls, $m)) {
            list(, $dir, $size) = $m;
            $n = (int)$size;
            
            if (!isset($seenVars[$n])) {
                $seenVars[$n] = true;
                $rootCss[] = make_root_var($n);
            }
            
            $var = "var(--size-".sprintf('%03d',$n).", {$n}px)";
            
            switch($dir) {
                case 'a':
                    $rules[] = ".{$cls}{border-radius:{$var};border-top-left-radius:{$var};border-top-right-radius:{$var};border-bottom-left-radius:{$var};border-bottom-right-radius:{$var};}";
                    break;
                case 'tx':
                    $rules[] = ".{$cls}{border-top-left-radius:{$var};border-top-right-radius:{$var};}";
                    break;
                case 'ux':
                    $rules[] = ".{$cls}{border-bottom-left-radius:{$var};border-bottom-right-radius:{$var};}";
                    break;
                case 'ly':
                    $rules[] = ".{$cls}{border-top-left-radius:{$var};border-bottom-left-radius:{$var};}";
                    break;
                case 'ry':
                    $rules[] = ".{$cls}{border-top-right-radius:{$var};border-bottom-right-radius:{$var};}";
                    break;
                case 'tl':
                    $rules[] = ".{$cls}{border-top-left-radius:{$var};}";
                    break;
                case 'tr':
                    $rules[] = ".{$cls}{border-top-right-radius:{$var};}";
                    break;
                case 'ul':
                    $rules[] = ".{$cls}{border-bottom-left-radius:{$var};}";
                    break;
                case 'ur':
                    $rules[] = ".{$cls}{border-bottom-right-radius:{$var};}";
                    break;
            }
            continue;
        }

        // 프리픽스 매칭 확인
        foreach ($validPrefixes as $prefix => $cssProperty) {
            if (strpos($cls, $prefix.'_') === 0) {
                $value = substr($cls, strlen($prefix) + 1);
                $value = str_replace('_', '-', $value);
                
                // zm-index 처리 - 음수 z-index 값 적용
                if ($prefix === 'zm-index') {
                    $value = '-' . $value;
                }
                
                $rules[] = ".{$cls}{{$cssProperty}:{$value};}";
                continue 2;
            }
        }

        // position1~4 처리
        if (preg_match('/^position([1-4])$/', $cls, $m)) {
            $positions = [
                '1' => 'relative',
                '2' => 'absolute', 
                '3' => 'fixed',
                '4' => 'sticky'
            ];
            $rules[] = ".{$cls}{position:{$positions[$m[1]]};}";
            continue;
        }

        // 기본 박스 처리
        if ($cls === 'main_box') {
            $rules[] = ".{$cls}{width:100%;height:100vh;height:100dvh;}";
            continue;
        }

        // width 관련 처리
        if ($cls === 'width_box') {
            $rules[] = ".{$cls}{width:100%;}";
            continue;
        }
        if ($cls === 'width_auto') {
            $rules[] = ".{$cls}{width:auto;}";
            continue;
        }

        // height 관련 처리
        if ($cls === 'height_box') {
            $rules[] = ".{$cls}{height:100%;}";
            continue;
        }
        if ($cls === 'height_auto') {
            $rules[] = ".{$cls}{height:auto;}";
            continue;
        }

        // margin auto 처리
        if ($cls === 'margin_a_auto') {
            $rules[] = ".{$cls}{margin-top:auto;margin-right:auto;margin-bottom:auto;margin-left:auto;}";
            continue;
        }
        if ($cls === 'margin_t_auto') {
            $rules[] = ".{$cls}{margin-top:auto;}";
            continue;
        }
        if ($cls === 'margin_b_auto' || $cls === 'margin_u_auto') {
            $rules[] = ".{$cls}{margin-bottom:auto;}";
            continue;
        }
        if ($cls === 'margin_y_auto') {
            $rules[] = ".{$cls}{margin-top:auto;margin-bottom:auto;}";
            continue;
        }
        if ($cls === 'margin_l_auto') {
            $rules[] = ".{$cls}{margin-left:auto;}";
            continue;
        }
        if ($cls === 'margin_r_auto') {
            $rules[] = ".{$cls}{margin-right:auto;}";
            continue;
        }
        if ($cls === 'margin_x_auto') {
            $rules[] = ".{$cls}{margin-left:auto;margin-right:auto;}";
            continue;
        }

        // min_width, min_height 처리
        if (preg_match('/^(min_width|max_width|min_height|max_height)_(\d+)$/', $cls, $m)) {
            list(, $prop, $size) = $m;
            $n = (int)$size;
            
            if (!isset($seenVars[$n])) {
                $seenVars[$n] = true;
                $rootCss[] = make_root_var($n);
            }
            
            $prop = str_replace('_', '-', $prop);
            $rules[] = ".{$cls}{{$prop}:var(--size-".sprintf('%03d',$n).", {$n}px);}";
            continue;
        }

        
        // 단위가 있는 값 처리 (px, vw, rem 등)
        if (preg_match('/^(width|height|font|gap)_(px|vw|vh|rem)_(\d+)$/', $cls, $m)) {
            list(, $prop, $unit, $size) = $m;
            $n = (int)$size;
            
            if ($prop === 'height' && $unit === 'vh') {
                // 1080이 100vh이므로, n/10.8이 vh값이 됨
                $vh = number_format($n/10.8, 2);
                $rules[] = ".{$cls}{height:{$vh}vh;}";
                continue;
            }
            
            // vw 단위 처리 - 1920px 기준으로 계산
            if ($unit === 'vw') {
                $vwValue = number_format(($n / 1920) * 100, 2);
                $prop = ($prop === 'font') ? 'font-size' : str_replace('_', '-', $prop);
                $rules[] = ".{$cls}{{$prop}:{$vwValue}vw;}";
                continue;
            }
            
            if (!isset($seenVars[$n])) {
                $seenVars[$n] = true;
                $rootCss[] = make_root_var($n);
            }
            
            $prop = ($prop === 'font') ? 'font-size' : str_replace('_', '-', $prop);
            $rules[] = ".{$cls}{{$prop}:var(--size-".sprintf('%03d',$n).", {$n}px);}";
            continue;
        }

        // padding/margin/border 처리 (방향 포함)
        if (preg_match('/^(padding|margin|border)_px-([a-z])_(\d+)$/', $cls, $m)) {
            list(, $prop, $dir, $size) = $m;
            $n = (int)$size;
            
            if (!isset($seenVars[$n])) {
                $seenVars[$n] = true;
                $rootCss[] = make_root_var($n);
            }
            
            $prop = str_replace('_', '-', $prop);
            
            // 방향에 따른 속성 설정
            switch($dir) {
                case 'a': 
                    if ($prop === 'border') {
                        $rules[] = ".{$cls}{border-top-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-top-style:solid;border-bottom-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-bottom-style:solid;border-left-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-left-style:solid;border-right-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-right-style:solid;}";
                    } else {
                        $rules[] = ".{$cls}{{$prop}-top:var(--size-".sprintf('%03d',$n).", {$n}px);{$prop}-right:var(--size-".sprintf('%03d',$n).", {$n}px);{$prop}-bottom:var(--size-".sprintf('%03d',$n).", {$n}px);{$prop}-left:var(--size-".sprintf('%03d',$n).", {$n}px);}";
                    }
                    break;
                case 'x':
                    if ($prop === 'border') {
                        $rules[] = ".{$cls}{border-left-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-left-style:solid;border-right-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-right-style:solid;}";
                    } else {
                        $rules[] = ".{$cls}{{$prop}-left:var(--size-".sprintf('%03d',$n).", {$n}px);{$prop}-right:var(--size-".sprintf('%03d',$n).", {$n}px);}";
                    }
                    break;
                case 'y':
                    if ($prop === 'border') {
                        $rules[] = ".{$cls}{border-top-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-top-style:solid;border-bottom-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-bottom-style:solid;}";
                    } else {
                        $rules[] = ".{$cls}{{$prop}-top:var(--size-".sprintf('%03d',$n).", {$n}px);{$prop}-bottom:var(--size-".sprintf('%03d',$n).", {$n}px);}";
                    }
                    break;
                case 'l':
                    if ($prop === 'border') {
                        $rules[] = ".{$cls}{border-left-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-left-style:solid;}";
                    } else {
                        $rules[] = ".{$cls}{{$prop}-left:var(--size-".sprintf('%03d',$n).", {$n}px);}";
                    }
                    break;
                case 'r':
                    if ($prop === 'border') {
                        $rules[] = ".{$cls}{border-right-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-right-style:solid;}";
                    } else {
                        $rules[] = ".{$cls}{{$prop}-right:var(--size-".sprintf('%03d',$n).", {$n}px);}";
                    }
                    break;
                case 't':
                    if ($prop === 'border') {
                        $rules[] = ".{$cls}{border-top-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-top-style:solid;}";
                    } else {
                        $rules[] = ".{$cls}{{$prop}-top:var(--size-".sprintf('%03d',$n).", {$n}px);}";
                    }
                    break;
                case 'u':
                    if ($prop === 'border') {
                        $rules[] = ".{$cls}{border-bottom-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-bottom-style:solid;}";
                    } else {
                        $rules[] = ".{$cls}{{$prop}-bottom:var(--size-".sprintf('%03d',$n).", {$n}px);}";
                    }
                    break;
                case 'b':
                    if ($prop === 'border') {
                        $rules[] = ".{$cls}{border-bottom-width:var(--size-".sprintf('%03d',$n).", {$n}px);border-bottom-style:solid;}";
                    } else {
                        $rules[] = ".{$cls}{{$prop}-bottom:var(--size-".sprintf('%03d',$n).", {$n}px);}";
                    }
                    break;
            }
            continue;
        }

        // top-0
        if (preg_match('/^top-((?:[0-9]+)|(?:0)|(?:[0-9]+per))$/', $cls, $m)) {
            $value = $m[1];
            if ($value === '0') {
                $rules[] = ".{$cls}{top:0;}";
            } else if (strpos($value, 'per') !== false) {
                $num = str_replace('per', '', $value);
                $rules[] = ".{$cls}{top:{$num}%;}";
            } else {
                $rules[] = ".{$cls}{top:{$value}px;}";
            }
            continue;
        }
        
        // bottom-0
        if (preg_match('/^bottom-((?:[0-9]+)|(?:0)|(?:[0-9]+per))$/', $cls, $m)) {
            $value = $m[1];
            if ($value === '0') {
                $rules[] = ".{$cls}{bottom:0;}";
            } else if (strpos($value, 'per') !== false) {
                $num = str_replace('per', '', $value);
                $rules[] = ".{$cls}{bottom:{$num}%;}";
            } else {
                $rules[] = ".{$cls}{bottom:{$value}px;}";
            }
            continue;
        }
        
        // left-0
        if (preg_match('/^left-((?:[0-9]+)|(?:0)|(?:[0-9]+per))$/', $cls, $m)) {
            $value = $m[1];
            if ($value === '0') {
                $rules[] = ".{$cls}{left:0;}";
            } else if (strpos($value, 'per') !== false) {
                $num = str_replace('per', '', $value);
                $rules[] = ".{$cls}{left:{$num}%;}";
            } else {
                $rules[] = ".{$cls}{left:{$value}px;}";
            }
            continue;
        }

        // right-0
        if (preg_match('/^right-((?:[0-9]+)|(?:0)|(?:[0-9]+per))$/', $cls, $m)) {
            $value = $m[1];
            if ($value === '0') {
                $rules[] = ".{$cls}{right:0;}";
            } else if (strpos($value, 'per') !== false) {
                $num = str_replace('per', '', $value);
                $rules[] = ".{$cls}{right:{$num}%;}";
            } else {
                $rules[] = ".{$cls}{right:{$value}px;}";
            }
            continue;
        }

        //blur_px_000
        if (preg_match('/^blur_(\d+)$/', $cls, $m)) {
            $value = $m[1];
            $rules[] = ".{$cls}{backdrop-filter:blur({$value}px);}";
            continue;
        }
        
    }    

    $css = ":root {\n" . implode("", $rootCss) . "}\n\n";
    $css .= implode("\n", $rules);

    return $css;
}

/**
 * 숫자 하나 받아서 clamp()용 --size-XXX 변수를 만들어 줌
 */
function make_root_var(int $n): string {
    $var = sprintf('--size-%03d',$n);
    $px  = "{$n}px";
    $ref = EGB_REF_PX;
    $bw  = EGB_BASE_VW;
    $sw  = EGB_START_VW;
    $calc = sprintf(
        'calc(%.6fvw + (%d - %.0f)*%.6fvw)',
        $bw, $n, $ref, $sw
    );
    $cl   = "clamp({$px}, {$calc}, 9999px)";
    return "  {$var}: {$cl};\n";
}

?>