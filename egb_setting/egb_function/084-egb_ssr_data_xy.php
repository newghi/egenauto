




<?php
function egb_ssr_data_xy($xyMap) {
    
    // 1) JS에서 쓰던 egbRegexPattern 을 그대로 PCRE로 옮김
    $egbRegex = '/(width_px_\d+|r_width_\d+|width_vw_\d+|window-width-\d+|width_box|window_width|width_auto|width_none|width_off|' .
                'font_px_|r_font_|font_vw_|font_rem_|line_height_|linem_height_|letter_spacing_|letterm_spacing_|' .
                'word_spacing_|wordm_spacing_|transform_|transform_[a-z]+_|transform_3d_|transform_3dm_|' .
                'padding_px-[a-z]+_|padding_vw-[a-z]+_|margin_px-[a-z]+_|margin_vw-[a-z]+_|min_width_|max_width_|' .
                'height_px_|height_vw_|height_vh_|min_height_|max_height_|r_height_|' .
                'position1-[a-z]+_|position2-[a-z]+_|position3-[a-z]+_|border_bre-[a-z]+_|border_be-[a-z]+_|' .
                'bd-a-color-[a-zA-Z0-9\~]|bd-x-color-[a-zA-Z0-9\~]|bd-y-color-[a-zA-Z0-9\~]|bd-t-color-[a-zA-Z0-9\~]|' .
                'bd-u-color-[a-zA-Z0-9\~]|bd-l-color-[a-zA-Z0-9\~]|bd-r-color-[a-zA-Z0-9\~]|color-[a-zA-Z0-9\~]|' .
                'bg-color-[a-zA-Z0-9\~]|z-index_|zm-index_)(\d+)/u';

    // display, grid, flex 패턴 추가
    $displayRegex = '/(display_block|display_none|display_flex|display_contents|display_flow|display_flow_root|display_inline|display_inline_block|display_inline_grid|display_inline_flex|display_inline_table|display_list_item|display_table|display_table_caption|display_table_cell|display_table_column|display_table_column_group|display_table_header_group|display_table_footer_group|display_table_row|display_table_row_group|grid_[\w\d\-_]+|flex_[\w\d\-_]+)/u';
    
    // 2) prefix → CSS 속성, 단위 매핑
    $prefixMap = [
        'font_px_'     => ['prop'=>'font-size','unit'=>'px'],
        'r_font_'      => ['prop'=>'font-size','unit'=>'px'],
        'font_vw_'     => ['prop'=>'font-size','unit'=>'vw'],
        'font_rem_'    => ['prop'=>'font-size','unit'=>'rem'],
        'line_height_' => ['prop'=>'line-height','unit'=>'ratio'],
        'linem_height_' => ['prop'=>'line-height','unit'=>'-ratio'],
        'letter_spacing_' => ['prop'=>'letter-spacing','unit'=>'px'],
        'letterm_spacing_' => ['prop'=>'letter-spacing','unit'=>'-px'],
        'word_spacing_' => ['prop'=>'word-spacing','unit'=>'px'],
        'wordm_spacing_' => ['prop'=>'word-spacing','unit'=>'-px'],
        'transform_' => ['prop'=>'transform','unit'=>''],
        'transform_3d_' => ['prop'=>'transform','unit'=>'3d'],
        'transform_3dm_' => ['prop'=>'transform','unit'=>'-3d'],
        'width_px_'    => ['prop'=>'width','unit'=>'px'],
        'r_width_'     => ['prop'=>'width','unit'=>'px'],
        'width_vw_'    => ['prop'=>'width','unit'=>'vw'],
        'window-width-' => ['prop'=>'width','unit'=>'px'],
        'height_px_'   => ['prop'=>'height','unit'=>'px'],
        'r_height_'    => ['prop'=>'height','unit'=>'px'],
        'height_vw_'   => ['prop'=>'height','unit'=>'vw'],
        'height_vh_'   => ['prop'=>'height','unit'=>'vh'],
        'padding_px-a_' => ['prop'=>'padding','unit'=>'px'],
        'padding_vw-a_' => ['prop'=>'padding','unit'=>'vw'],
        'padding_px-x_' => ['prop'=>'padding-left;padding-right','unit'=>'px'],
        'padding_vw-x_' => ['prop'=>'padding-left;padding-right','unit'=>'vw'],
        'padding_px-y_' => ['prop'=>'padding-top;padding-bottom','unit'=>'px'],
        'padding_vw-y_' => ['prop'=>'padding-top;padding-bottom','unit'=>'vw'],
        'padding_px-l_' => ['prop'=>'padding-left','unit'=>'px'],
        'padding_vw-l_' => ['prop'=>'padding-left','unit'=>'vw'],
        'padding_px-r_' => ['prop'=>'padding-right','unit'=>'px'],
        'padding_vw-r_' => ['prop'=>'padding-right','unit'=>'vw'],
        'padding_px-t_' => ['prop'=>'padding-top','unit'=>'px'],
        'padding_vw-t_' => ['prop'=>'padding-top','unit'=>'vw'],
        'padding_px-u_' => ['prop'=>'padding-bottom','unit'=>'px'],
        'padding_vw-u_' => ['prop'=>'padding-bottom','unit'=>'vw'],
        'padding_px-b_' => ['prop'=>'padding-bottom','unit'=>'px'],
        'padding_vw-b_' => ['prop'=>'padding-bottom','unit'=>'vw'],
        'margin_px-a_'  => ['prop'=>'margin','unit'=>'px'],
        'margin_vw-a_'  => ['prop'=>'margin','unit'=>'vw'],
        'margin_px-x_'  => ['prop'=>'margin-left;margin-right','unit'=>'px'],
        'margin_vw-x_'  => ['prop'=>'margin-left;margin-right','unit'=>'vw'],
        'margin_px-y_'  => ['prop'=>'margin-top;margin-bottom','unit'=>'px'],
        'margin_vw-y_'  => ['prop'=>'margin-top;margin-bottom','unit'=>'vw'],
        'margin_px-l_'  => ['prop'=>'margin-left','unit'=>'px'],
        'margin_vw-l_'  => ['prop'=>'margin-left','unit'=>'vw'],
        'margin_px-r_'  => ['prop'=>'margin-right','unit'=>'px'],
        'margin_vw-r_'  => ['prop'=>'margin-right','unit'=>'vw'],
        'margin_px-t_'  => ['prop'=>'margin-top','unit'=>'px'],
        'margin_vw-t_'  => ['prop'=>'margin-top','unit'=>'vw'],
        'margin_px-u_'  => ['prop'=>'margin-bottom','unit'=>'px'],
        'margin_vw-u_'  => ['prop'=>'margin-bottom','unit'=>'vw'],
        'margin_px-b_'  => ['prop'=>'margin-bottom','unit'=>'px'],
        'margin_vw-b_'  => ['prop'=>'margin-bottom','unit'=>'vw'],
        'min_width_'    => ['prop'=>'min-width','unit'=>'px'],
        'max_width_'    => ['prop'=>'max-width','unit'=>'px'],
        'min_height_'   => ['prop'=>'min-height','unit'=>'px'],
        'max_height_'   => ['prop'=>'max-height','unit'=>'px'],
        'z-index_'      => ['prop'=>'z-index','unit'=>''],
        'zm-index_'     => ['prop'=>'z-index','unit'=>'-'],
        'position1-'    => ['prop'=>'position','unit'=>'1'],
        'position2-'    => ['prop'=>'position','unit'=>'2'],
        'position3-'    => ['prop'=>'position','unit'=>'3'],
        'border_bre-'   => ['prop'=>'border-radius','unit'=>'px'],
        'border_be-'    => ['prop'=>'border','unit'=>'px'],
        'bd-a-color-'   => ['prop'=>'border-color','unit'=>''],
        'bd-x-color-'   => ['prop'=>'border-left-color;border-right-color','unit'=>''],
        'bd-y-color-'   => ['prop'=>'border-top-color;border-bottom-color','unit'=>''],
        'bd-t-color-'   => ['prop'=>'border-top-color','unit'=>''],
        'bd-u-color-'   => ['prop'=>'border-bottom-color','unit'=>''],
        'bd-l-color-'   => ['prop'=>'border-left-color','unit'=>''],
        'bd-r-color-'   => ['prop'=>'border-right-color','unit'=>''],
        'color-'        => ['prop'=>'color','unit'=>''],
        'bg-color-'     => ['prop'=>'background-color','unit'=>'']
    ];

    $seenVars = [];
    $rootCss  = [];
    $medias   = [];  // ['1-800'=>[ 'xy_ab12'=>['flex_ft','hide_it'], … ], …]

    // 3) xyMap → 범위별 그룹핑
    foreach ($xyMap as $randCls => $raw) {
        // data-xy 형식인지 확인 (예: "1-600: xx-100per, 600-1050: xx-50per~50per")
        if (strpos($raw, 'xx-') !== false || strpos($raw, 'yy-') !== false) {
            // data-xy 형식 처리
            foreach (preg_split('/\s*,\s*/', trim($raw)) as $part) {
                if (! preg_match('/^(\d+)-(\d+)\s*:\s*(.+)$/', $part, $m)) continue;
                list(, $min, $max, $gridValue) = $m;
                $key = "{$min}-{$max}";
                
                // xx-와 yy- 값을 실제 CSS 값으로 변환
                $convertGridValue = function($value) {
                    // xx-100per -> 100%
                    $value = preg_replace('/xx-(\d+)per/', '$1%', $value);
                    // yy-50per -> 50%
                    $value = preg_replace('/yy-(\d+)per/', '$1%', $value);
                    // xx-1fr -> 1fr
                    $value = preg_replace('/xx-(\d+)fr/', '$1fr', $value);
                    // yy-1fr -> 1fr
                    $value = preg_replace('/yy-(\d+)fr/', '$1fr', $value);
                    // xx-auto -> auto
                    $value = preg_replace('/xx-auto/', 'auto', $value);
                    // yy-auto -> auto
                    $value = preg_replace('/yy-auto/', 'auto', $value);
                    // xx- 또는 yy- 접두사가 남아있는 경우 제거
                    $value = preg_replace('/^(xx-|yy-)/', '', $value);
                    // 접두사 없는 per 값도 %로 변환
                    $value = preg_replace('/(\d+)per/', '$1%', $value);
                    return $value;
                };
                
                // 그리드 값과 일반 클래스 분리
                $separateGridAndClasses = function($value) {
                    $parts = explode(' ', $value);
                    $gridParts = [];
                    $classParts = [];
                    
                    foreach ($parts as $part) {
                        $trimmedPart = trim($part);
                        if (empty($trimmedPart)) continue;
                        
                        // xx- 또는 yy-로 시작하는 경우 그리드 값
                        if (preg_match('/^(xx-|yy-)/', $trimmedPart)) {
                            $gridParts[] = $trimmedPart;
                        } else {
                            $classParts[] = $trimmedPart;
                        }
                    }
                    
                    return [
                        'grid' => implode(' ', $gridParts),
                        'classes' => implode(' ', $classParts)
                    ];
                };
                
                // 그리드 값과 일반 클래스 분리
                $separated = $separateGridAndClasses($gridValue);
                $gridValue = $separated['grid'];
                $classValue = $separated['classes'];
                
                $gridStyles = [];
                $classStyles = [];
                
                // 그리드 값 처리
                if (!empty($gridValue)) {
                    // grid-template-columns와 grid-template-rows 분리
                    $parts = explode('~', $gridValue);
                    $columns = trim($parts[0] ?? '');
                    $rows = trim($parts[1] ?? '');
                    
                    if ($columns) {
                        $convertedColumns = $convertGridValue($columns);
                        $gridStyles[] = "grid-template-columns: {$convertedColumns}";
                    }
                    if ($rows) {
                        $convertedRows = $convertGridValue($rows);
                        $gridStyles[] = "grid-template-rows: {$convertedRows}";
                    }
                    
                    // ~ 구분자가 있는 경우 처리
                    if (strpos($gridValue, '~') !== false && count($parts) > 1) {
                        // xx-로 시작하는 경우 grid-template-columns
                        if (strpos($parts[0], 'xx-') === 0) {
                            $allColumns = [];
                            foreach ($parts as $part) {
                                $convertedPart = $convertGridValue(trim($part));
                                $allColumns[] = $convertedPart;
                            }
                            $gridStyles = ["grid-template-columns: " . implode(' ', $allColumns)];
                        }
                        // yy-로 시작하는 경우 grid-template-rows
                        else if (strpos($parts[0], 'yy-') === 0) {
                            $allRows = [];
                            foreach ($parts as $part) {
                                $convertedPart = $convertGridValue(trim($part));
                                $allRows[] = $convertedPart;
                            }
                            $gridStyles = ["grid-template-rows: " . implode(' ', $allRows)];
                        }
                    }
                }
                
                // 일반 클래스 처리
                if (!empty($classValue)) {
                    $classStyles = preg_split('/\s+/', trim($classValue));
                }
                
                // 그리드 스타일과 클래스 스타일 합치기
                $allStyles = array_merge($gridStyles, $classStyles);
                if (!empty($allStyles)) {
                    $medias[$key][$randCls] = $allStyles;
                }
            }
        } else {
            // 기존 형식 처리
            foreach (preg_split('/\s*,\s*/', trim($raw)) as $part) {
                if (! preg_match('/^(\d+)-(\d+)\s*:\s*(.+)$/', $part, $m)) continue;
                list(, $min, $max, $clsList) = $m;
                $key = "{$min}-{$max}";
                $medias[$key][$randCls] = preg_split('/\s+/', trim($clsList));
            }
        }
    }

    // 4) 범위별 @media 블록 생성
    $out = '';
    foreach ($medias as $range => $elements) {
        list($min, $max) = explode('-', $range);
        $out .= "@media (min-width:{$min}px) and (max-width:{$max}px) {\n";

        foreach ($elements as $randCls => $classes) {
            $out .= "  .{$randCls} {\n";

            foreach ($classes as $cls) {
                
                // data-xy 형식의 직접 CSS 속성인지 확인
                if (strpos($cls, 'grid-template-columns:') === 0 || strpos($cls, 'grid-template-rows:') === 0) {
                    $out .= "    {$cls} !important;\n";
                    continue;
                }
                
                if ($cls === 'width_box') { $out .= "    width:100% !important;\n"; continue; }
                if ($cls === 'width_auto') { $out .= "    width:auto !important;\n"; continue; }
                if ($cls === 'width_none') { $out .= "    width:none !important;\n"; continue; }
                if ($cls === 'width_off') { $out .= "    width:0 !important;\n"; continue; }
                if ($cls === 'window_width') { $out .= "    width:100vw !important;\n"; continue; }
                if ($cls === 'height_box') { $out .= "    height:100% !important;\n"; continue; }
                if ($cls === 'height_auto') { $out .= "    height:auto !important;\n"; continue; }
                if ($cls === 'margin_a_auto') { $out .= "    margin:auto !important;\n"; continue; }
                if ($cls === 'margin_x_auto') { $out .= "    margin-left:auto !important;\n    margin-right:auto !important;\n"; continue; }
                if ($cls === 'margin_y_auto') { $out .= "    margin-top:auto !important;\n    margin-bottom:auto !important;\n"; continue; }
                if ($cls === 'margin_l_auto') { $out .= "    margin-left:auto !important;\n"; continue; }
                if ($cls === 'margin_r_auto') { $out .= "    margin-right:auto !important;\n"; continue; }
                if ($cls === 'margin_t_auto') { $out .= "    margin-top:auto !important;\n"; continue; }
                if ($cls === 'margin_b_auto') { $out .= "    margin-bottom:auto !important;\n"; continue; }
                if ($cls === 'margin_u_auto') { $out .= "    margin-bottom:auto !important;\n"; continue; }
                
                // Display 패턴 매칭
                if (preg_match($displayRegex, $cls)) {
                    if (strpos($cls, 'display_') === 0) {
                        $display = str_replace('display_', '', $cls);
                        $out .= "    display:{$display} !important;\n";
                        continue;
                    }
                    
                    
                    // Flex 정렬
                    if (strpos($cls, 'flex_') === 0) {
                        // 기존 flex 관련 속성들 초기화
                        $out .= "    justify-content:initial !important;\n";
                        $out .= "    align-items:initial !important;\n"; 
                        $out .= "    flex-direction:initial !important;\n";
                        $out .= "    flex-wrap:initial !important;\n";
                        $out .= "    display:flex !important;\n";
                        
                        if (strpos($cls, '_xl') !== false) {
                            $out .= "    justify-content:start !important;\n";
                        } else if (strpos($cls, '_xr') !== false) {
                            $out .= "    justify-content:end !important;\n";
                        } else if (strpos($cls, '_xc') !== false) {
                            $out .= "    justify-content:center !important;\n";
                        } else if (strpos($cls, '_xs1') !== false) {
                            $out .= "    justify-content:space-between !important;\n";
                        } else if (strpos($cls, '_xs2') !== false) {
                            $out .= "    justify-content:space-around !important;\n";
                        } else if (strpos($cls, '_xs3') !== false) {
                            $out .= "    justify-content:space-evenly !important;\n";
                        }
                        
                        // 수직 정렬
                        if (strpos($cls, '_yt') !== false) {
                            $out .= "    align-items:start !important;\n";
                        } else if (strpos($cls, '_yc') !== false) {
                            $out .= "    align-items:center !important;\n";
                        } else if (strpos($cls, '_yu') !== false) {
                            $out .= "    align-items:end !important;\n";
                        } else if (strpos($cls, '_ys') !== false) {
                            $out .= "    align-items:stretch !important;\n";
                        }
                        
                        // 플렉스 방향
                        if (strpos($cls, '_ft') !== false) {
                            $out .= "    flex-direction:column !important;\n";
                        } else if (strpos($cls, '_fu') !== false) {
                            $out .= "    flex-direction:column-reverse !important;\n";
                        } else if (strpos($cls, '_fl') !== false) {
                            $out .= "    flex-direction:row !important;\n";
                        } else if (strpos($cls, '_fr') !== false) {
                            $out .= "    flex-direction:row-reverse !important;\n";
                        }
                        
                        // 플렉스 랩
                        if (strpos($cls, '_wrap') !== false) {
                            $out .= "    flex-wrap:wrap !important;\n";
                        } else if (strpos($cls, '_nowrap') !== false) {
                            $out .= "    flex-wrap:nowrap !important;\n";
                        }
                        continue;
                    }
                    
                    // Grid 정렬 (flex와 동일한 정렬 규칙 적용)
                    if (strpos($cls, 'grid_') === 0) {
                        // 기존 grid 관련 속성들 초기화
                        $out .= "    justify-content:initial !important;\n";
                        $out .= "    align-items:initial !important;\n";
                        $out .= "    display:grid !important;\n";
                        
                        if (strpos($cls, '_xl') !== false) {
                            $out .= "    justify-content:start !important;\n";
                        } else if (strpos($cls, '_xr') !== false) {
                            $out .= "    justify-content:end !important;\n";
                        } else if (strpos($cls, '_xc') !== false) {
                            $out .= "    justify-content:center !important;\n";
                        } else if (strpos($cls, '_xs1') !== false) {
                            $out .= "    justify-content:space-between !important;\n";
                        } else if (strpos($cls, '_xs2') !== false) {
                            $out .= "    justify-content:space-around !important;\n";
                        } else if (strpos($cls, '_xs3') !== false) {
                            $out .= "    justify-content:space-evenly !important;\n";
                        }
                        
                        // 수직 정렬
                        if (strpos($cls, '_yt') !== false) {
                            $out .= "    align-items:start !important;\n";
                        } else if (strpos($cls, '_yc') !== false) {
                            $out .= "    align-items:center !important;\n";
                        } else if (strpos($cls, '_yu') !== false) {
                            $out .= "    align-items:end !important;\n";
                        } else if (strpos($cls, '_ys') !== false) {
                            $out .= "    align-items:stretch !important;\n";
                        }
                        continue;
                    }
                }

                // numeric 패턴 매칭
                if (preg_match($egbRegex, $cls, $mm)) {
                    $prefix = $mm[1];
                    $num    = (int)$mm[2];

                    // :root clamp 변수 생성
                    if (! isset($seenVars[$num])) {
                        $seenVars[$num] = true;
                        $rootCss[] = make_root_var($num);
                    }

                    // CSS 선언
                    if (isset($prefixMap[$prefix])) {
                        $prop = $prefixMap[$prefix]['prop'];
                        $unit = $prefixMap[$prefix]['unit'];
                        
                        // line-height는 배수 단위로 처리
                        if ($unit === 'ratio' || $unit === '-ratio') {
                            $ratio = $num / 100; // 160 -> 1.60
                            if ($unit === '-ratio') {
                                $ratio = -$ratio; // 음수 처리
                            }
                            foreach (explode(';', $prop) as $p) {
                                $out .= "    {$p}:{$ratio} !important;\n";
                            }
                        }
                        // letter-spacing만 특별히 px 단위로 직접 처리 (100 -> 1.00px)
                        else if (($unit === 'px' || $unit === '-px') && $prop === 'letter-spacing') {
                            $pxValue = $num / 100; // 100 -> 1.00
                            if ($unit === '-px') {
                                $pxValue = -$pxValue; // 음수 처리
                            }
                            foreach (explode(';', $prop) as $p) {
                                $out .= "    {$p}:" . number_format($pxValue, 2) . "px !important;\n";
                            }
                        } else {
                            foreach (explode(';', $prop) as $p) {
                                $out .= "    {$p}:var(--size-".sprintf('%03d',$num).",{$num}{$unit}) !important;\n";
                            }
                        }
                    }
                    continue;
                }

                // 기타 패턴(예: display_, position_, etc.) 처리 분기 추가 가능
                // 예: if (strpos($cls,'display_')===0) { … }
            }

            $out .= "  }\n";
        }

        $out .= "}\n\n";
    }

    // 5) :root 변수 블록 합치기
    $css  = ":root {\n" . implode("", $rootCss) . "}\n\n";
    $css .= $out;
    return $css;
}
?>
