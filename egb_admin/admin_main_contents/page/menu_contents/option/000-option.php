<?php

//사용할 테이블 이름 수동 설정
$table_name = 'egb_option';
$filter_user_id = 'admin';

// 현재 파일의 상위 디렉토리 이름을 가져옴
$page_name = basename(dirname(__FILE__));
// 현재 파일의 상위 디렉토리 이름을 가져옴
$page_dir = basename(dirname(dirname(dirname(__FILE__))));

// 파일 경로 설정
$path_1 = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $page_dir . DS . 'menu_add' . DS . 'add_' . $page_name . '.php';
$path_2 = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $page_dir . DS . 'menu_edit' . DS . 'edit_' . $page_name . '.php';
$path_3 = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $page_dir . DS . 'menu_view' . DS . 'view_' . $page_name . '.php';
$path_4 = ROOT . DS . 'egb_admin' . DS . 'admin_main_contents' . DS . $page_dir . DS . 'menu_setting' . DS . 'setting_' . $page_name . '.php';

$add_button = file_exists($path_1) ? '' : 'display_off';
$edit_button = file_exists($path_2) ? '' : 'display_off';
$view_button = file_exists($path_3) ? '' : 'display_off';
$setting_button = file_exists($path_4) ? '' : 'display_off';
$del_button = ''; // 삭제 버튼 숨기려면 display_off 추가

// 아래부터는 자동 처리
//////////////////////////////////////////

// GET 파라미터 처리
$perPageValue = egb('filter_per_page');
$perPage = ($perPageValue !== null && ($perPageValue === '전체' || intval($perPageValue) > 0))
    ? $perPageValue
    : 10;

// egb_record_count 테이블에서 총 레코드 수 가져오기
// 테이블 명만 바꾸면 됨
$totalQuery = "SELECT record_total_count FROM egb_record_count WHERE record_table_name = '$table_name'";
$totalBinding = binding_sql(1, $totalQuery, []);
$totalResult = egb_sql($totalBinding);
$totalRecords = isset($totalResult[0]['record_total_count']) ? $totalResult[0]['record_total_count'] : 0;
    // 페이지 강제 처리
if ($perPage === '전체' || intval($perPage) >= $totalRecords) {
    $perPage = $totalRecords;
    $page = 1;
}

// 총 페이지 수 계산
$totalPages = ($totalRecords > 0) ? (($perPage === '전체') ? 1 : ceil($totalRecords / intval($perPage))) : 1;

$order = egb('filter_order') && in_array(egb('filter_order'), ['asc', 'desc'])
    ? egb('filter_order')
    : 'desc';

$page = egb('filter_page') && intval(egb('filter_page')) > 0
    ? intval(egb('filter_page'))
    : 1;

// 상태 필터 기본값 설정
$is_statusValue = egb('filter_is_status');
$is_status = ($is_statusValue !== null && $is_statusValue !== '') 
    ? intval($is_statusValue)  // 문자열을 정수로 변환
    : 99; // 기본값 1

// 검색어 처리
$searchKeyword = egb('filter_search_input');
// 디테일 필터 처리 
$isDetailFilterActive = egb('detail_filter_active'); // 상세 필터 활성화 여부 체크

// 데이터 가져오기 쿼리 처리
$query = "SELECT * FROM $table_name";
if ($is_status == 2) {
    $query .= " WHERE deleted_at IS NOT NULL";
} else {
    $query .= " WHERE deleted_at IS NULL";
}

// 상태 필터 적용
if ($is_status != 99) { // 99는 전체를 의미
    $query .= " AND is_status = :is_status"; 
    $params = [':is_status' => $is_status];
} else {
    $params = [];
}

// 컬럼 설정 가져오기 (공통)
$configQuery = "SELECT column_config_data_json FROM egb_table_column_config 
               WHERE column_config_table_name = :table_name 
               AND column_config_user_uniq_id IS NULL 
               AND deleted_at IS NULL 
               ORDER BY created_at DESC LIMIT 1";
$configBinding = binding_sql(1, $configQuery, [':table_name' => $table_name]);
$configResult = egb_sql($configBinding);
$columnConfig = [];

if ($configResult && !empty($configResult[0]['column_config_data_json'])) {
    $columnConfig = json_decode($configResult[0]['column_config_data_json'], true);
    
    // 검색어에 대한 쿼리 처리
    if (!$isDetailFilterActive && !empty($searchKeyword)) {
        $searchConditions = [];
        $searchCount = 1;
        foreach ($columnConfig as $config) {
            if (isset($config['keyword_filter']) && $config['keyword_filter'] == 1) {
                $searchParam = ":search" . $searchCount;
                $searchConditions[] = "{$config['name']} LIKE " . $searchParam;
                $params[$searchParam] = '%' . $searchKeyword . '%';
                $searchCount++;
            }
        }
        
        if (!empty($searchConditions)) {
            $query .= " AND (" . implode(" OR ", $searchConditions) . ")";
        }
    }
    
    if ($isDetailFilterActive) {
        foreach ($columnConfig as $config) {
            if ($config['detail_filter'] == 1) {
                $name = $config['name'];
                $value = egb($name);

                 // is_status가 상시 필터에서 이미 적용된 경우 스킵
                if ($name === 'is_status' && $is_status != 99) {
                    continue;
                }
                
                // page_name이라는 이름이 있다면 filter_page_name으로 변경
                if ($name === 'page_name') {
                    $name = 'filter_page_name';
                    $value = egb('filter_page_name');
                }
                
                if ($value !== null && $value !== '') {
                    if ($config['filter_type'] == 'date') {
                        $start = egb($name . '_start');
                        $end = egb($name . '_end');
                        if ($start) {
                            $query .= " AND $name >= :{$name}_start";
                            $params[":{$name}_start"] = $start;
                        }
                        if ($end) {
                            $query .= " AND $name <= :{$name}_end";
                            $params[":{$name}_end"] = $end;
                        }
                    } else if ($config['filter_type'] == 'text') {
                        $query .= " AND $name LIKE :$name";
                        $params[":$name"] = '%' . $value . '%';
                    } else {
                        $query .= " AND $name = :$name";
                        $params[":$name"] = $value;
                    }
                }
            }
        }
    }
}

//정렬 처리
$query .= " ORDER BY display_order ASC, created_at $order";

//페이지 처리
if ($perPage !== '전체') {
    $offset = ($page - 1) * intval($perPage);
    $query .= " LIMIT :limit OFFSET :offset";
    $params += [':limit' => intval($perPage), ':offset' => $offset];
}

$dataBinding = binding_sql(0, $query, $params);
$dataResult = egb_sql($dataBinding);

?>

<div class="display_off" egb:style="
    input{all: unset; box-sizing: border-box;}
    input.egb_<?php echo $page_dir; ?>_checked{all: unset; width: 14px; height: 14px; border: 1px solid #d9d9d9; border-radius: 3px;}
    input.egb_<?php echo $page_dir; ?>_checked:checked {background-color: #4caf50; border-color: #4caf50;}
    input.egb_<?php echo $page_dir; ?>_checked:checked::after {content: ''; display: block; width: 4px; height: 9px; margin: 2px auto; border: solid white; border-width: 0 2px 2px 0; transform: rotate(45deg);}
    .input_gender_box_design {box-shadow: 0 0 1px #00000020;}
    input.filter_select_gender_radio:checked {width: 12px; height: 12px; background-color: #111; border: 2px solid #fff; box-shadow: 0 0 0 1px #111;}
    .fake_checked{display: block; width: 6px; height: 11px; margin: 2px auto; border: solid #757575; border-width: 0 2px 2px 0; transform: rotate(45deg);}
    input.search_input{width:160px; padding-left:15px; padding-right:37px; padding-top:8px; padding-bottom:8px; border: 1px solid #d9d9d9; font-size:12px;}
    input.number_input_design::-webkit-outer-spin-button,input.number_input_design::-webkit-inner-spin-button {-webkit-appearance: none; margin: 0;}
    input.number_input_design {-moz-appearance:textfield;}
    .refresh_icon:hover{background-color: #dddddd; transition: 0.4s;}
    .refresh_icon:hover svg{fill: #000000; transform: rotate(90deg); transition: 0.4s;}
    .refresh_icon_2:hover{background-color: #dddddd; transition: 0.4s;}
    .refresh_icon_2:hover svg{fill: #000000; transition: 0.4s;}
    .rotate_icon{transform: rotate(180deg);}
    .pagination_choice_color{background-color: #aaaaaa; color: #333333;}
    select.array_select{all:unset; font-size: 12px; font-family: fontstyle1; padding: 2px; border: 1px solid #e9e9e9; background-color: #f5f5f5;}
    .<?php echo $page_name; ?>_filter_modal {transform: translateX(300px); transition: transform 0.4s;}
    .<?php echo $page_dir; ?>_height{height: calc(100% - 120px);}
    .<?php echo $page_name; ?>_class_hover:hover * {background-color: #f1f1f1;}
">
</div>


<div class="position4 z-index_5" data-top="0%" data-left="0%">
    <div class="position1 width_box height_px_040 z-index_5" data-top="0%" data-left="0%" data-bg-color="#ffffff">
        <div class="position4 flex_xs1_yc width_box height_px_040 border_px-u_001 padding_px-x_010 padding_px-y_005"
            data-bd-a-color="#e9e9e9" data-top="0%" data-left="0%">
            <div class="flex_fl font_px_010">
                <div id="<?php echo $page_name; ?>_excel_format_download" class="margin_px-x_003 padding_px-x_008 padding_px-y_005 border_px-a_001 pointer" 
                    data-bg-color="#f5f5f5" 
                    data-hover-bg-color="#dddddd" 
                    data-bd-a-color="#e9e9e9">엑셀 양식다운</div>
                <script nonce="<?php echo NONCE; ?>">
                document.querySelector('#<?php echo $page_name; ?>_excel_format_download').addEventListener('click', function () {
                    const formData = new FormData();
                    formData.append('filter_table_name', '<?php echo $table_name; ?>');
                    formData.append('csrf_token', '<?php echo $_SESSION["csrf_token"]; ?>');

                    fetch('<?php echo DOMAIN . "/?post=egb_excel_format_download"; ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('서버 오류');
                        return response.blob();
                    })
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = '<?php echo $table_name; ?>_format.xlsx';
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);

                        egbsuccessCode({ successCode: 3 });
                    })
                    .catch(error => {
                        egbFailureCode({ failureCode: 21 });
                        console.error(error);
                    });
                });
                </script>
                <div id="<?php echo $page_name; ?>_excel_download_button" class="margin_px-x_003 padding_px-x_008 padding_px-y_005 border_px-a_001 pointer" 
                    data-bg-color="#f5f5f5" 
                    data-hover-bg-color="#dddddd" 
                    data-bd-a-color="#e9e9e9">엑셀 다운</div>
                <script nonce="<?php echo NONCE; ?>">
                document.querySelector('#<?php echo $page_name; ?>_excel_download_button').addEventListener('click', function () {
                    const formData = new FormData();
                    formData.append('filter_table_name', '<?php echo $table_name; ?>');
                    formData.append('csrf_token', '<?php echo $_SESSION["csrf_token"]; ?>');
                    // PHP에서 이미 설정된 값들을 사용
                    formData.append('filter_page', '<?php echo $page; ?>');
                    formData.append('filter_per_page', '<?php echo $perPage; ?>');
                    formData.append('filter_order', '<?php echo $order; ?>');
                    formData.append('filter_is_status', '<?php echo isset($is_status) ? $is_status : "99"; ?>'); // 기본값 99 (전체)로 설정
                    formData.append('filter_search_input', '<?php echo $searchKeyword; ?>');
                    formData.append('detail_filter_active', '<?php echo $isDetailFilterActive; ?>');

                    // 컬럼 설정에서 디테일 필터 값들 추가
                    <?php foreach($columnConfig as $config): ?>
                        <?php if($config['detail_filter'] == 1): ?>
                            <?php 
                            $name = $config['name'];
                            if($name === 'page_name') {
                                $name = 'filter_page_name';
                            }
                            ?>
                            <?php if($config['filter_type'] == 'date'): ?>
                                formData.append('<?php echo $name; ?>_start', '<?php echo egb($name . '_start'); ?>');
                                formData.append('<?php echo $name; ?>_end', '<?php echo egb($name . '_end'); ?>');
                            <?php else: ?>
                                formData.append('<?php echo $name; ?>', '<?php echo egb($name); ?>');
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    fetch('<?php echo DOMAIN . "/?post=egb_excel_download"; ?>', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('서버 오류');
                        return response.blob();
                    })
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = '<?php echo $table_name; ?>_data.xlsx';
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);

                        egbsuccessCode({ successCode: 3 });
                    })
                    .catch(error => {
                        egbFailureCode({ failureCode: 21 });
                        console.error(error);
                    });
                });
                </script>
                <form id="<?php echo $page_name; ?>_excel_upload_form" method="post" enctype="multipart/form-data" action="<?php echo DOMAIN . "/?post=egb_excel_upload"; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="filter_page_name" value="<?php echo $page_dir; ?>">
                    <input type="hidden" name="filter_menu_name" value="<?php echo $page_name; ?>">
                    <input type="hidden" name="filter_page" value="<?php echo $page; ?>">
                    <input type="hidden" name="filter_per_page" value="<?php echo $perPage; ?>">
                    <input type="hidden" name="filter_order" value="<?php echo $order; ?>">
                    <input type="hidden" name="filter_is_status" value="<?php echo $is_status; ?>">
                    <input type="hidden" name="filter_search_input" value="<?php echo $searchKeyword; ?>">
                    <input type="hidden" name="filter_user_id" value="<?php echo $filter_user_id; ?>">
                    <input type="hidden" name="filter_table_name" value="<?php echo $table_name; ?>">
                    <label for="<?php echo $page_name; ?>_excel_file">
                        <div id="<?php echo $page_name; ?>_excel_upload_button" class="margin_px-x_003 padding_px-x_008 padding_px-y_005 border_px-a_001 pointer"
                            data-bg-color="#f5f5f5" data-hover-bg-color="#dddddd" data-bd-a-color="#e9e9e9">엑셀 업로드</div>
                    </label>
                    <input type="file" id="<?php echo $page_name; ?>_excel_file" name="file" accept=".xlsx" class="file_submit" style="display:none">
                </form>
                <div id="<?php echo $page_name; ?>_output_column_button" class="margin_px-x_003 padding_px-x_008 padding_px-y_005 border_px-a_001 pointer"
                    data-bg-color="#f5f5f5" data-hover-bg-color="#dddddd" data-bd-a-color="#e9e9e9"
                    egb:click="egbToggle('column_<?php echo $page_name; ?>_box', 'display_off', 'z-index_7');
                    egbT('column_<?php echo $page_name; ?>_contents_box', 'id=<?php echo $page_name; ?>_column&path=/admin_main_contents/<?php echo $page_dir; ?>/menu_column/column_<?php echo $page_name; ?>&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=<?php echo $page; ?>&filter_per_page=<?php echo $perPage; ?>&filter_order=<?php echo $order; ?>&filter_is_status=<?php echo $is_status; ?>&filter_table_name=<?php echo $table_name; ?>&filter_user_id=<?php echo $filter_user_id; ?>&filter_search_input=<?php echo $searchKeyword; ?>', true);">칼럼설정</div>
            </div>
            <div class="flex_fl">
                <div class="flex_fl_yc">
                    <div class="width_px_038 height_px_032 padding_px-x_009 padding_px-y_006 border_px-a_001 margin_px-r_005 pointer refresh_icon"
                        data-bd-a-color="#d9d9d9" data-bg-color="#f5f5f5" title="새로고침"
                        egb:click="egbInitializeMenu('<?php echo $page_dir; ?>'); 
						egbT('modal_<?php echo $page_dir; ?>_contents', 'id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=<?php echo $page; ?>&filter_per_page=<?php echo $perPage; ?>&filter_order=<?php echo $order; ?>&filter_is_status=<?php echo $is_status; ?>&filter_search_input=<?php echo $searchKeyword; ?>', true);">
                        <svg fill="#aaaaaa" id="Capa_1" enable-background="new 0 0 512.449 512.449" height="100%"
                            viewBox="0 0 512.449 512.449" width="100%" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="m152.083 286.805c7.109-8.155 1.318-20.888-9.501-20.888h-32.392c-.211-3.205-.329-6.435-.329-9.692 0-80.706 65.658-146.364 146.363-146.364 38.784 0 74.087 15.168 100.304 39.877l45.676-53.435c-39.984-36.577-91.44-56.612-145.98-56.612-57.838 0-112.214 22.524-153.112 63.421-40.897 40.898-63.421 95.274-63.421 153.112 0 3.243.081 6.473.222 9.692h-27.284c-10.819 0-16.611 12.733-9.501 20.888l61.549 70.6 12.928 14.829 46.416-53.242z" />
                                <path
                                    d="m509.321 245.614-45.907-52.658-28.57-32.771-40.791 46.789-33.686 38.64c-7.109 8.155-1.318 20.888 9.501 20.888h32.354c-5.293 75.928-68.748 136.086-145.997 136.086-33.721 0-64.811-11.469-89.586-30.703l-45.679 53.439c38.267 30.731 85.479 47.434 135.266 47.434 57.838 0 112.214-22.523 153.112-63.421 38.466-38.466 60.672-88.856 63.177-142.834h27.306c10.818-.001 16.609-12.734 9.5-20.889z" />
                            </g>
                        </svg>
                    </div>
                    <div class="width_px_038 height_px_032 padding_px-x_009 padding_px-y_006 border_px-a_001 margin_px-r_005 pointer refresh_icon_2 <?php echo $page_name; ?>_filter_modal_open_button"
                        data-bd-a-color="#d9d9d9" data-bg-color="#f5f5f5" title="필터">
                        <!DOCTYPE svg
                            PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
                        <svg width="100%" height="100%" fill="#aaaaaa" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                            y="0px" viewBox="0 0 247.46 247.46" style="enable-background:new 0 0 247.46 247.46;"
                            xml:space="preserve">
                            <path d="M246.744,13.984c-1.238-2.626-3.881-4.301-6.784-4.301H7.5c-2.903,0-5.545,1.675-6.784,4.301
    c-1.238,2.626-0.85,5.73,0.997,7.97l89.361,108.384v99.94c0,2.595,1.341,5.005,3.545,6.373c1.208,0.749,2.579,1.127,3.955,1.127
    c1.137,0,2.278-0.259,3.33-0.78l50.208-24.885c2.551-1.264,4.165-3.863,4.169-6.71l0.098-75.062l89.366-108.388
    C247.593,19.714,247.982,16.609,246.744,13.984z M143.097,122.873c-1.105,1.34-1.711,3.023-1.713,4.761l-0.096,73.103
    l-35.213,17.453v-90.546c0-1.741-0.605-3.428-1.713-4.771L23.404,24.682h200.651L143.097,122.873z" />
                        </svg>
                    </div>
                </div>
                <div class="position1">
                    <input class="search_input" type="text" name="search_input" value="<?php echo $searchKeyword; ?>" id="<?php echo $page_name; ?>_search_input">
                    <div id="<?php echo $page_name; ?>_search_input_button" class="position2 width_px_020 height_px_032" data-top="0%" data-right="3%">
                        <svg class="pointer" width="100%" height="100%" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                            y="0px" viewBox="0 0 62.993 62.993" style="enable-background:new 0 0 62.993 62.993;"
                            xml:space="preserve">
                            <g>
                                <path style="fill:#888888;" d="M62.58,60.594L41.313,39.329c3.712-4.18,5.988-9.66,5.988-15.677
                c0-13.042-10.609-23.651-23.65-23.651C10.609,0.001,0,10.61,0,23.652c0,13.041,10.609,23.65,23.651,23.65
                c6.016,0,11.497-2.276,15.677-5.988l21.265,21.267c0.273,0.273,0.634,0.411,0.993,0.411c0.36,0,0.721-0.138,0.994-0.411
                C63.13,62.03,63.13,61.143,62.58,60.594z M23.651,44.492c-11.492,0-20.841-9.348-20.841-20.84S12.159,2.811,23.651,2.811
                c11.491,0,20.84,9.349,20.84,20.841c0,5.241-1.958,10.023-5.163,13.689c-0.619,0.706-1.281,1.368-1.987,1.987
                C33.675,42.534,28.892,44.492,23.651,44.492z" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="position1 width_box height_px_040 z-index_5" data-top="0%" data-left="0%" data-bg-color="#ffffff">
        <div class="position4 flex_xs1_yc width_box height_px_040 border_px-u_001 padding_px-x_010 padding_px-y_005"
            data-bd-a-color="#e9e9e9" data-top="0%" data-left="0%">
            <div class="flex_fl_yc">
                <div class="flex_fl_yc padding_px-x_005">
                    <input type="checkbox" id="<?php echo $page_name; ?>_check_all" name="<?php echo $page_name; ?>_check_all"
                        class="width_px_014 height_px_014 margin_px-r_005 border_px-a_001 border_bre-a_003 egb_<?php echo $page_dir; ?>_checked"
                        data-bd-a-color="#d9d9d9">
                    <label for="<?php echo $page_name; ?>_check_all">
                        <div class="font_px_012 padding_px-x_005">
                            전체선택
                        </div>
                    </label>
                </div>
<div class="padding_px-a_003 font_style_center">
    <select class="array_select" name="filter_order" id="<?php echo $page_name; ?>_order_select">
        <option value="정렬방식" selected hidden disabled>정렬방식</option>
        <option value="desc" <?php echo ($order === 'desc') ? 'selected' : ''; ?>>최신순</option>
        <option value="asc" <?php echo ($order === 'asc') ? 'selected' : ''; ?>>오래된순</option>
    </select>
</div>
<div class="padding_px-a_003 font_style_center">
    <select class="array_select" name="filter_per_page" id="<?php echo $page_name; ?>_per_page_select">
        <option value="출력방식" selected hidden disabled>출력방식</option>
        <option value="10" <?php echo ($perPage == 10) ? 'selected' : ''; ?>>10개</option>
        <option value="30" <?php echo ($perPage == 30) ? 'selected' : ''; ?>>30개</option>
        <option value="50" <?php echo ($perPage == 50) ? 'selected' : ''; ?>>50개</option>
        <option value="100" <?php echo ($perPage == 100) ? 'selected' : ''; ?>>100개</option>
        <option value="전체" <?php echo ($perPage == '전체') ? 'selected' : ''; ?>>전체</option>
    </select>
</div>
<div class="padding_px-a_003 font_style_center">
    <select class="array_select" name="filter_is_status" id="<?php echo $page_name; ?>_status_select">
        <option value="상태" selected hidden disabled>상태</option>
        <option value="1" <?php echo ($is_status == 1) ? 'selected' : ''; ?>>활성화</option>
        <option value="0" <?php echo ($is_status == 0) ? 'selected' : ''; ?>>비활성화</option>
        <option value="2" <?php echo ($is_status == 2) ? 'selected' : ''; ?>>휴지통</option>
        <option value="99" <?php echo ($is_status == 99) ? 'selected' : ''; ?>>전체</option>
    </select>
</div>

<script nonce="<?php echo NONCE; ?>">
document.getElementById('<?php echo $page_name; ?>_search_input_button').addEventListener('click', function () {
    const searchInput = document.getElementById('<?php echo $page_name; ?>_search_input').value.trim();
    const currentOrder = document.getElementById('<?php echo $page_name; ?>_order_select').value;
    const currentPerPage = document.getElementById('<?php echo $page_name; ?>_per_page_select').value;
    const currentStatus = document.getElementById('<?php echo $page_name; ?>_status_select').value;

    const url = `id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&page=1&per_page=${currentPerPage}&order=${currentOrder}&is_status=${currentStatus}&search_input=${encodeURIComponent(searchInput)}`;
    egbInitializeMenu('<?php echo $page_dir; ?>');
    egbT('modal_<?php echo $page_dir; ?>_contents', url, true);
});

document.getElementById('<?php echo $page_name; ?>_search_input').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        document.getElementById('<?php echo $page_name; ?>_search_input_button').click();
    }
});

(() => {
    const perPageSelect = document.getElementById('<?php echo $page_name; ?>_per_page_select');
    const orderSelect = document.getElementById('<?php echo $page_name; ?>_order_select');
    const statusSelect = document.getElementById('<?php echo $page_name; ?>_status_select');
    const searchInput = document.getElementById('<?php echo $page_name; ?>_search_input');

    // 현재 페이지와 perPage 값을 추적
    let currentPage = <?php echo $page; ?>;
    let currentPerPage = "<?php echo $perPage; ?>";

    if (perPageSelect) {
        // 선택값 변경 전 값을 추적하기 위한 변수
        let previousValue = currentPerPage;

        // focus 이벤트로 이전 값을 저장
        perPageSelect.addEventListener('focus', function () {
            previousValue = this.value;
        });

        perPageSelect.addEventListener('change', function () {
            const selectedValue = perPageSelect.value;
            const currentOrder = orderSelect.value;
            const currentStatus = statusSelect.value;
            const searchValue = searchInput.value.trim();

            if (selectedValue === '전체') {
                const confirmSelection = confirm("전체 선택의 경우 데이터가 많을 경우 오래 걸릴 수 있습니다.\n계속하시겠습니까?");
                if (!confirmSelection) {
                    this.value = previousValue;
                    return;
                }
            }

            const page = selectedValue === '전체' ? 1 : currentPage;
            currentPerPage = selectedValue;

            const url = `id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=${page}&filter_per_page=${selectedValue}&filter_order=${currentOrder}&filter_is_status=${currentStatus}&filter_search_input=${encodeURIComponent(searchValue)}`;
            egbInitializeMenu('<?php echo $page_dir; ?>');
            egbT('modal_<?php echo $page_dir; ?>_contents', url, true);
        });
    }

    if (orderSelect) {
        orderSelect.addEventListener('change', function () {
            const selectedValue = orderSelect.value;
            const perPageValue = perPageSelect ? perPageSelect.value : '<?php echo $perPage; ?>';
            const currentStatus = statusSelect.value;
            const searchValue = searchInput.value.trim();

            const url = `id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=${currentPage}&filter_per_page=${perPageValue}&filter_order=${selectedValue}&filter_is_status=${currentStatus}&filter_search_input=${encodeURIComponent(searchValue)}`;
            egbInitializeMenu('<?php echo $page_dir; ?>');
            egbT('modal_<?php echo $page_dir; ?>_contents', url, true);
        });
    }

    if (statusSelect) {
        statusSelect.addEventListener('change', function () {
            const selectedValue = statusSelect.value;
            const perPageValue = perPageSelect ? perPageSelect.value : '<?php echo $perPage; ?>';
            const currentOrder = orderSelect.value;
            const searchValue = searchInput.value.trim();

            const url = `id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=${currentPage}&per_page=${perPageValue}&filter_order=${currentOrder}&filter_is_status=${selectedValue}&filter_search_input=${encodeURIComponent(searchValue)}`;
            egbInitializeMenu('<?php echo $page_dir; ?>');
            egbT('modal_<?php echo $page_dir; ?>_contents', url, true);
        });
    }
})();
</script>


            </div>
            <div class="flex_fl_yc <?php echo $page_name; ?>_change_button_filter_off">
                <form id="<?php echo $page_name; ?>_delete_form" method="post" action="<?php echo DOMAIN . '/?post=egb_delete_form_input'; ?>">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="filter_page_name" value="<?php echo $page_dir; ?>">
                    <input type="hidden" name="filter_menu_name" value="<?php echo $page_name; ?>">
                    <input type="hidden" name="filter_page" value="<?php echo $page; ?>">
                    <input type="hidden" name="filter_per_page" value="<?php echo $perPage; ?>">
                    <input type="hidden" name="filter_order" value="<?php echo $order; ?>">
                    <input type="hidden" name="filter_is_status" value="<?php echo $is_status; ?>">
                    <input type="hidden" name="filter_search_input" value="<?php echo $searchKeyword; ?>">
                    <input type="hidden" name="filter_user_id" value="<?php echo $filter_user_id; ?>">
                    <input type="hidden" name="filter_table_name" value="<?php echo $table_name; ?>">
                    <input type="hidden" name="uniq_id" id="<?php echo $page_name; ?>_delete_uniq_id">
                    <div class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 margin_px-x_010 pointer display_off <?php echo $page_name; ?>_check_delete"
                        data-bd-a-color="#dddddd" data-bg-color="#ff0000cc" data-color="#ffffff" 
                        data-hover-bg-color="#ff0000">삭제</div>
                </form>
                <script nonce="<?php echo NONCE; ?>">
                document.querySelector('.<?php echo $page_name; ?>_check_delete').addEventListener('click', function() {
                    if(confirm('정말 삭제하시겠습니까?\n만약 휴지통에서 삭제 하면 더이상 복구 불가능')) {
                        egbAjaxDataHook('<?php echo $page_name; ?>_delete_form', function(formData) {
                            formData.append('csrf_token', '<?php echo $_SESSION['csrf_token']; ?>');
                            formData.append('filter_page_name', '<?php echo $page_dir; ?>');
                            formData.append('filter_menu_name', '<?php echo $page_name; ?>');
                            formData.append('filter_page', '<?php echo $page; ?>');
                            formData.append('filter_per_page', '<?php echo $perPage; ?>');
                            formData.append('filter_order', '<?php echo $order; ?>');
                            formData.append('filter_is_status', '<?php echo $is_status; ?>');
                            formData.append('filter_search_input', '<?php echo $searchKeyword; ?>');
                            formData.append('filter_user_id', '<?php echo $filter_user_id; ?>');
                            formData.append('filter_table_name', '<?php echo $table_name; ?>');
                            formData.append('uniq_id', document.getElementById('<?php echo $page_name; ?>_delete_uniq_id').value);
                            return true;
                        });
                    }
                });
                </script>
                <div class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 margin_px-x_010 pointer display_off <?php echo $page_name; ?>_check_view"
                    data-bd-a-color="#dddddd" data-bg-color="#0066ffaa" data-color="#ffffff"
                    data-hover-bg-color="#0066ff"
                    egb:click="egbToggle('view_<?php echo $page_name; ?>_box', 'display_off', 'z-index_7');">뷰어</div>
                <div class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 margin_px-x_010 pointer display_off <?php echo $page_name; ?>_check_edit <?php echo $edit_button; ?>" 
                    data-bd-a-color="#dddddd" data-bg-color="#ffa500aa" data-color="#ffffff"
                    data-hover-bg-color="#ffa500"
                    egb:click="egbToggle('edit_<?php echo $page_name; ?>_box', 'display_off', 'z-index_7');">수정</div>
                <div class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 margin_px-x_010 pointer <?php echo $page_name; ?>_check_add <?php echo $add_button; ?>"
                    data-bd-a-color="#dddddd" data-bg-color="#14870c" data-color="#ffffff"
                    data-hover-bg-color="#006b00" 
                    egb:click="egbToggle('add_<?php echo $page_name; ?>_box', 'display_off', 'z-index_7');
                    egbT('add_<?php echo $page_name; ?>_contents_box', 'id=<?php echo $page_name; ?>_add&path=/admin_main_contents/<?php echo $page_dir; ?>/menu_add/add_<?php echo $page_name; ?>&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=<?php echo $page; ?>&filter_per_page=<?php echo $perPage; ?>&filter_order=<?php echo $order; ?>&filter_is_status=<?php echo $is_status; ?>&filter_search_input=<?php echo urlencode($searchKeyword); ?>', true);">추가</div>
                <div class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 margin_px-x_010 pointer display_off <?php echo $page_name; ?>_check_setting <?php echo $setting_button; ?>"
                    data-bd-a-color="#dddddd" data-bg-color="#14870c" data-color="#ffffff"
                    data-hover-bg-color="#006b00" 
                    egb:click="egbToggle('setting_<?php echo $page_name; ?>_box', 'display_off', 'z-index_7');">설정</div>
            
            </div>
            <div class="flex_fl_yc font_px_015 <?php echo $page_name; ?>_change_button_filter_on display_off">
                <div id="<?php echo $page_name; ?>_filter_reset" class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 margin_px-x_010 pointer"
                    data-bd-a-color="#dddddd" data-bg-color="#ff0000cc" data-color="#ffffff"
                    data-hover-bg-color="#ff0000">초기화</div>
                <script nonce="<?php echo NONCE; ?>">
                document.querySelector('#<?php echo $page_name; ?>_filter_reset').addEventListener('click', function() {
                    document.querySelectorAll('#filter_<?php echo $page_name; ?>_box input, #filter_<?php echo $page_name; ?>_box select').forEach(el => {
                        if(el.type === 'date') {
                            el.value = '';
                        } else if(el.type === 'number') {
                            el.value = '0';
                        } else {
                            el.value = '';
                        }
                    });
                });
                </script>
                <div class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 margin_px-x_010 pointer"
                    data-bd-a-color="#dddddd" data-bg-color="#ffa500aa" data-color="#ffffff"
                    data-hover-bg-color="#ffa500">그냥</div>
                <div id="<?php echo $page_name; ?>_filter_search" class="padding_px-y_005 padding_px-x_020 border_px-a_001 border_bre-a_005 margin_px-x_010 pointer"
                    data-bd-a-color="#dddddd" data-bg-color="#14870c" data-color="#ffffff"
                    data-hover-bg-color="#006b00">검색</div>
                <script nonce="<?php echo NONCE; ?>">
                document.querySelector('#<?php echo $page_name; ?>_filter_search').addEventListener('click', function() {
                    const searchInput = document.getElementById('<?php echo $page_name; ?>_search_input').value.trim();
                    const currentOrder = document.getElementById('<?php echo $page_name; ?>_order_select').value;
                    const currentPerPage = document.getElementById('<?php echo $page_name; ?>_per_page_select').value;
                    const currentStatus = document.getElementById('<?php echo $page_name; ?>_status_select').value;

                    // 필터 입력값 수집
                    const filterInputs = document.querySelectorAll('#filter_<?php echo $page_name; ?>_box input, #filter_<?php echo $page_name; ?>_box select');
                    let filterParams = {};
                    filterInputs.forEach(el => {
                        const value = el.value.trim();
                        if (value !== '') { // 빈 값이 아닌 경우만 파라미터에 추가 (0도 허용)
                            // page_name이라는 이름이 있다면 filter_page_name으로 변경
                            const paramName = el.name === 'page_name' ? 'filter_page_name' : el.name;
                            filterParams[paramName] = value;
                        }
                    });

                    const url = `id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=1&filter_per_page=${currentPerPage}&filter_order=${currentOrder}&filter_is_status=${currentStatus}&filter_search_input=${encodeURIComponent(searchInput)}&detail_filter_active=1`;
                    
                    // 필터 파라미터 추가
                    const filterUrl = Object.entries(filterParams)
                        .map(([key, value]) => `&${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
                        .join('');

                    egbInitializeMenu('<?php echo $page_dir; ?>');
                    egbT('modal_<?php echo $page_dir; ?>_contents', url + filterUrl, true);
                });
                </script>
            </div>
        </div>
    </div>
</div>


<div id="column_<?php echo $page_name; ?>_print_area" class="<?php echo $page_name; ?>_box position1 <?php echo $page_dir; ?>_height max_width_9999 scrolls_1 point_all_reset overflow_x_hidden scrollbar"
    egb:mouseover="egbClassDel('<?php echo $page_dir; ?>_box_menu', 'menu_box'); egbClassDel('<?php echo $page_dir; ?>_loading', 'egb_loading');"
    egb:mouseout="egbClassAdd('<?php echo $page_dir; ?>_box_menu', 'menu_box'); egbClassAdd('<?php echo $page_dir; ?>_loading', 'egb_loading');">
    <div class="position1 max_width_9999 max_height_9999 font_px_014 scrollbar" data-top="0%" data-left="0%">
        <div class="position4 z-index_2 max_width_9999" data-top="0%" data-left="0%">
            <div class="flex_fl width_box">
                <div class="flex_ft_xc_yc min_width_040 max_width_040 padding_px-y_010 border_px-y_002 border_px-x_001"
                    data-bg-color="#e5e5e5" data-bd-a-color="#d9d9d9">
                    <div class="flex_xc_yc width_px_014 height_px_014">
                        <div class="fake_checked"></div>
                    </div>
                </div>
                <?php
                // 테이블 컬럼 설정 조회
                $query = "SELECT column_config_data_json FROM egb_table_column_config 
                         WHERE column_config_table_name = :table_name 
                         AND column_config_user_uniq_id IS NULL
                         AND deleted_at IS NULL
                         ORDER BY created_at DESC 
                         LIMIT 1";
                $binding = binding_sql(1, $query, [':table_name' => $table_name]);
                $result = egb_sql($binding);

                if(!empty($result)) {
                    $columns = json_decode($result[0]['column_config_data_json'], true);
                } else {
                    // 설정이 없는 경우 기본 설정 생성
                    $insertResult = egb_table_column_config_insert($table_name);
                    if($insertResult['success']) {
                        // 새로 생성된 설정 조회
                        $binding = binding_sql(1, $query, [':table_name' => $table_name]);
                        $result = egb_sql($binding);
                        $columns = json_decode($result[0]['column_config_data_json'], true);
                    }
                }

                // 순서대로 정렬
                usort($columns, function($a, $b) {
                    return $a['order'] - $b['order'];
                });

                // 보이는 컬럼만 필터링
                $visibleColumns = array_filter($columns, function($col) {
                    return isset($col['visible']) && $col['visible'] == 1;
                });

                foreach($visibleColumns as $column) {
                    ?>
                    <div class="flex_xc_yc width_box min_width_<?php echo $column['width']; ?> max_width_<?php echo $column['width']; ?> padding_px-y_010 border_px-y_002 border_px-x_001"
                        data-bg-color="#e5e5e5" data-bd-a-color="#d9d9d9"><?php echo $column['comment']; ?></div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
        if (isset($dataResult[0]) && !empty($dataResult[0])) {
            $class_index = 1;
            foreach ($dataResult[0] as $row) {
                ?>
                <label class="<?php echo $page_name; ?>_item" for="<?php echo $page_name; ?>_check_<?php echo $class_index; ?>"
                    data-egb-uniq-id="<?php echo $row['uniq_id']; ?>">
                    <div class="flex_fl width_box <?php echo $page_name; ?>_class_hover">
                        <div class="flex_xc_yc min_width_040 max_width_040 padding_px-y_010 border_px-u_002 border_px-x_001"
                            data-bg-color="#f9f9f9" data-bd-a-color="#d9d9d9">
                            <input class="width_px_016 height_px_016 border_px-a_001 border_bre-a_003 egb_<?php echo $page_dir; ?>_checked"
                                data-bd-a-color="#d9d9d9" type="checkbox" name="<?php echo $page_name; ?>_check"
                                id="<?php echo $page_name; ?>_check_<?php echo $class_index; ?>">
                        </div>
                        <?php
                        foreach($visibleColumns as $column) {
                            $value = $row[$column['name']];
                            $alignClass = isset($column['align']) ? "flex_x{$column['align'][0]}_yc" : "flex_xc_yc";
                            if($column['name'] == 'is_status') {
                                ?>
                                <form id="<?php echo $page_name; ?>_status_form_input_<?php echo $class_index; ?>" 
                                    action="<?php echo DOMAIN . '/?post=egb_is_status_update'; ?>" 
                                    method="post" enctype="multipart/form-data" 
                                    class="<?php echo $alignClass; ?> min_width_<?php echo $column['width']; ?> max_width_<?php echo $column['width']; ?> padding_px-y_010 border_px-u_002 border_px-x_001"
                                    data-bg-color="#f9f9f9" data-bd-a-color="#d9d9d9">
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="filter_page_name" value="<?php echo $page_dir; ?>">
                                    <input type="hidden" name="filter_menu_name" value="<?php echo $page_name; ?>">
                                    <input type="hidden" name="filter_page" value="<?php echo $page; ?>">
                                    <input type="hidden" name="filter_per_page" value="<?php echo $perPage; ?>">
                                    <input type="hidden" name="filter_order" value="<?php echo $order; ?>">
                                    <input type="hidden" name="filter_search_input" value="<?php echo $searchKeyword; ?>">
                                    <input type="hidden" name="filter_user_id" value="<?php echo $filter_user_id; ?>">
                                    <input type="hidden" name="filter_table_name" value="<?php echo $table_name; ?>">
                                    <input type="hidden" name="uniq_id" value="<?php echo $row['uniq_id']; ?>">
                                    <select class="select_submit" name="filter_is_status">
                                        <option value="1" <?php echo ($value == 1) ? 'selected' : ''; ?>>활성화</option>
                                        <option value="0" <?php echo ($value == 0) ? 'selected' : ''; ?>>비활성화</option>
                                        <?php if($value == 2): ?>
                                        <option value="2" selected>휴지통</option>
                                        <?php endif; ?>
                                    </select>
                                </form>
                                <?php
                            } else {
                                ?>
                                <div class="<?php echo $alignClass; ?> min_width_<?php echo $column['width']; ?> max_width_<?php echo $column['width']; ?> padding_px-y_010 border_px-u_002 border_px-x_001"
                                    data-bg-color="#f9f9f9" data-bd-a-color="#d9d9d9"><?php echo $value; ?></div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </label>
                <?php
                $class_index++;
            }
        } else {
            echo "데이터가 없습니다.";
        }
        ?>
    </div>
</div>

<script nonce="<?php echo NONCE; ?>">
(() => {
    // 부모 요소 선택
    const parentElement = document.querySelector('.<?php echo $page_name; ?>_box');

    // egb 함수가 정의되어 있는지 확인하는 헬퍼 함수 
    const getEgbValue = (param) => {
        if (typeof egb === 'function') {
            return egb(param);
        }
        return '';
    };

    // 부모 요소에 클릭 이벤트 리스너 추가
    parentElement.addEventListener('click', (event) => {
        // 클릭된 요소가 '.<?php echo $page_name; ?>_item' 클래스인지 확인
        let targetElement = event.target;

        // '.<?php echo $page_name; ?>_item' 요소를 찾을 때까지 부모로 이동
        while (targetElement && !targetElement.classList.contains('<?php echo $page_name; ?>_item')) {
            targetElement = targetElement.parentElement;
        }

        if (targetElement && targetElement.classList.contains('<?php echo $page_name; ?>_item')) {
            // 클릭된 체크박스 가져오기
            const checkbox = targetElement.querySelector('input[type="checkbox"]');
            if (checkbox) {
                const wasChecked = checkbox.checked; // 기존 체크 상태 저장

                // 모든 체크박스 해제
                const allCheckboxes = document.querySelectorAll('input[type="checkbox"]');
                allCheckboxes.forEach(cb => cb.checked = false);

                // 자기 자신을 다시 클릭하면 해제 상태 유지, 그렇지 않으면 체크
                checkbox.checked = !wasChecked;

                // 선택된 경우에만 동작 수행
                if (checkbox.checked) {
                    const uniqId = targetElement.getAttribute('data-egb-uniq-id');
                    // 삭제 폼에 uniq_id 설정
                    document.getElementById('<?php echo $page_name; ?>_delete_uniq_id').value = uniqId;
                    
                    // 체크박스 관련 버튼 표시/숨김 처리
                    const viewBtn = document.querySelector('.<?php echo $page_name; ?>_check_view');
                    const editBtn = document.querySelector('.<?php echo $page_name; ?>_check_edit');
                    const deleteBtn = document.querySelector('.<?php echo $page_name; ?>_check_delete');
                    const settingBtn = document.querySelector('.<?php echo $page_name; ?>_check_setting');

                    if(viewBtn) viewBtn.classList.remove('display_off');
                    if(editBtn) editBtn.classList.remove('display_off');
                    if(deleteBtn) deleteBtn.classList.remove('display_off');

                    // 원하는 동작 수행
                    <?php if(file_exists($path_1)): ?>
                    if (typeof egbT === 'function') {
                        egbT('add_<?php echo $page_name; ?>_contents_box', 
                            'id=add_<?php echo $page_name; ?>_contents_box_' + uniqId + 
                            '&path=/admin_main_contents/<?php echo $page_dir; ?>/menu_add/add_<?php echo $page_name; ?>' +
                            '&uniq_id=' + uniqId +
                            '&filter_page_name=<?php echo $page_dir ?>' +
                            '&filter_menu_name=<?php echo $page_name; ?>' +
                            '&filter_page=' + encodeURIComponent(getEgbValue('filter_page')) +
                            '&filter_per_page=' + encodeURIComponent(getEgbValue('filter_per_page')) +
                            '&filter_order=' + encodeURIComponent(getEgbValue('filter_order')) +
                            '&filter_is_status=' + encodeURIComponent(getEgbValue('filter_is_status')) +
                            '&filter_search_input=' + encodeURIComponent(getEgbValue('filter_search_input')), true);
                    }
                    <?php endif; ?>
                    <?php if(file_exists($path_2)): ?>
                    if (typeof egbT === 'function') {
                        egbT('edit_<?php echo $page_name; ?>_contents_box', 
                            'id=edit_<?php echo $page_name; ?>_contents_box_' + uniqId + 
                            '&path=/admin_main_contents/<?php echo $page_dir; ?>/menu_edit/edit_<?php echo $page_name; ?>' +
                            '&uniq_id=' + uniqId +
                            '&filter_page_name=<?php echo $page_dir ?>' +
                            '&filter_menu_name=<?php echo $page_name; ?>' +
                            '&filter_page=' + encodeURIComponent(getEgbValue('filter_page')) +
                            '&filter_per_page=' + encodeURIComponent(getEgbValue('filter_per_page')) +
                            '&filter_order=' + encodeURIComponent(getEgbValue('filter_order')) +
                            '&filter_is_status=' + encodeURIComponent(getEgbValue('filter_is_status')) +
                            '&filter_search_input=' + encodeURIComponent(getEgbValue('filter_search_input')), true);
                    }
                    <?php endif; ?>
                    <?php if(file_exists($path_3)): ?>
                    if (typeof egbT === 'function') {
                        egbT('view_<?php echo $page_name; ?>_contents_box',
                            'id=view_<?php echo $page_name; ?>_contents_box_' + uniqId +
                            '&path=/admin_main_contents/<?php echo $page_dir; ?>/menu_view/view_<?php echo $page_name; ?>' +
                            '&uniq_id=' + uniqId +
                            '&filter_page_name=<?php echo $page_dir ?>' +
                            '&filter_menu_name=<?php echo $page_name; ?>' +
                            '&filter_page=' + encodeURIComponent(getEgbValue('filter_page')) +
                            '&filter_per_page=' + encodeURIComponent(getEgbValue('filter_per_page')) +
                            '&filter_order=' + encodeURIComponent(getEgbValue('filter_order')) +
                            '&filter_is_status=' + encodeURIComponent(getEgbValue('filter_is_status')) +
                            '&filter_search_input=' + encodeURIComponent(getEgbValue('filter_search_input')), true);
                    }
                    <?php endif; ?>
                    <?php if(file_exists($path_4)): ?>
                    if (typeof egbT === 'function') {
                        egbT('setting_<?php echo $page_name; ?>_contents_box',
                            'id=setting_<?php echo $page_name; ?>_contents_box_' + uniqId +
                            '&path=/admin_main_contents/<?php echo $page_dir; ?>/menu_setting/setting_<?php echo $page_name; ?>' +
                            '&uniq_id=' + uniqId +
                            '&filter_page_name=<?php echo $page_dir ?>' +
                            '&filter_menu_name=<?php echo $page_name; ?>' +
                            '&filter_page=' + encodeURIComponent(getEgbValue('filter_page')) +
                            '&filter_per_page=' + encodeURIComponent(getEgbValue('filter_per_page')) +
                            '&filter_order=' + encodeURIComponent(getEgbValue('filter_order')) +
                            '&filter_is_status=' + encodeURIComponent(getEgbValue('filter_is_status')) +
                            '&filter_search_input=' + encodeURIComponent(getEgbValue('filter_search_input')), true);
                    }
                    <?php endif; ?>
                    console.log('선택된 메뉴 ID:', uniqId);
                } else {
                    // 체크 해제시 버튼 숨김
                    const viewBtn = document.querySelector('.<?php echo $page_name; ?>_check_view');
                    const editBtn = document.querySelector('.<?php echo $page_name; ?>_check_edit');
                    const deleteBtn = document.querySelector('.<?php echo $page_name; ?>_check_delete');
                    const settingBtn = document.querySelector('.<?php echo $page_name; ?>_check_setting');

                    if(viewBtn) viewBtn.classList.add('display_off');
                    if(editBtn) editBtn.classList.add('display_off'); 
                    if(deleteBtn) deleteBtn.classList.add('display_off');
                    if(settingBtn) settingBtn.classList.add('display_off');
                }
            }
        }
    });
})();
</script>


<div class="position4 z-index_5 flex_xs1_yc padding_px-x_020 width_box height_px_040 border_px-t_001 font_px_018 fontstyle2"
    data-bg-color="#f5f5f5" data-bd-a-color="#d9d9d9" data-bottom="0%" data-left="0%" data-color="#777777">
    <div id="<?php echo $page_name; ?>_print_button" class="width_px_020 height_px_020 pointer refresh_icon_2" title="인쇄">
        <svg fill="#777777" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="100%" height="100%">
            <g id="_01_align_center" data-name="01 align center">
                <path
                    d="M24,9a3,3,0,0,0-3-3H19V0H5V6H3A3,3,0,0,0,0,9V21H5v3H19V21h5ZM7,2H17V6H7ZM17,22H7V16H17Zm5-3H19V14H5v5H2V9A1,1,0,0,1,3,8H21a1,1,0,0,1,1,1Z" />
                <rect x="15" y="10" width="4" height="2" />
            </g>
        </svg>
    </div>
    <script nonce="<?php echo NONCE; ?>">
        document.getElementById('<?php echo $page_name; ?>_print_button').addEventListener('click', function() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo DOMAIN . '/page/egb_admin_column_print'; ?>';
            form.target = '_blank';

            // CSRF 토큰 추가
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = 'csrf_token';
            csrfToken.value = '<?php echo $_SESSION['csrf_token']; ?>';
            form.appendChild(csrfToken);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'print_data';
            input.value = document.getElementById('column_<?php echo $page_name; ?>_print_area').innerHTML;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
            form.remove();
        });
    </script>
    <div class="flex_yc">
    <div class="flex_xc_yc width_px_030 height_px_034 margin_px-x_002 border_px-a_001 pointer"
         data-bd-a-color="#d9d9d9" data-hover-bg-color="#dddddd"
         <?php if ($page > 5): ?>
             egb:click="egbInitializeMenu('<?php echo $page_dir; ?>'); egbT('modal_<?php echo $page_dir; ?>_contents', 'id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&page=<?php echo max($page - 5, 1); ?>&per_page=<?php echo $perPage; ?>&order=<?php echo $order; ?>&is_status=<?php echo $is_status; ?>&search_input=<?php echo urlencode($searchKeyword); ?>', true);"
         <?php else: ?>
             style="pointer-events: none; opacity: 0.5;"
         <?php endif; ?>>
        <div class="flex_xc_yc width_px_017 height_px_017 rotate_icon">
            <svg fill="#777777" height="100%" viewBox="0 0 24 24" width="100%" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <path d="m13.061 4.93896-2.122 2.122 4.94 4.93904-4.94 4.939 2.122 2.122 7.06-7.061z" />
                    <path d="m6.06103 19.061 7.05997-7.061-7.05997-7.06104-2.122 2.122 4.94 4.93904-4.94 4.939z" />
                </g>
            </svg>
        </div>
    </div>
    <div class="flex_xc_yc width_px_030 height_px_034 margin_px-x_002 border_px-a_001 pointer"
         data-bd-a-color="#d9d9d9" data-hover-bg-color="#dddddd"
         <?php if ($page > 1): ?>
             egb:click="egbInitializeMenu('<?php echo $page_dir; ?>'); egbT('modal_<?php echo $page_dir; ?>_contents', 'id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&page=<?php echo $page - 1; ?>&per_page=<?php echo $perPage; ?>&order=<?php echo $order; ?>&is_status=<?php echo $is_status; ?>&search_input=<?php echo urlencode($searchKeyword); ?>', true);"
         <?php else: ?>
             style="pointer-events: none; opacity: 0.5;"
         <?php endif; ?>>
        <div class="flex_xc_yc width_px_017 height_px_017 rotate_icon">
            <svg fill="#777777" height="100%" viewBox="0 0 24 24" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="m10.061 19.061 7.06-7.061-7.06-7.06104-2.12197 2.122 4.93997 4.93904-4.93997 4.939z" />
            </svg>
        </div>
    </div>
    <!-- 페이지 번호 -->
    <?php
    // 페이지네이션 범위 계산
    $startPage = max(1, $page - 2); // 현재 페이지 기준 앞 2개
    $endPage = min($totalPages, $page + 2); // 현재 페이지 기준 뒤 2개

    // 동적으로 페이지 버튼 생성
    for ($i = $startPage; $i <= $endPage; $i++): ?>
        <div class="flex_xc_yc width_px_030 height_px_034 margin_px-x_002 border_px-a_001 pointer <?php echo ($i == $page) ? 'pagination_choice_color' : ''; ?>"
             data-bd-a-color="#d9d9d9" data-hover-bg-color="#dddddd"
             egb:click="egbInitializeMenu('<?php echo $page_dir; ?>'); egbT('modal_<?php echo $page_dir; ?>_contents', 'id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=<?php echo $i; ?>&filter_per_page=<?php echo $perPage; ?>&filter_order=<?php echo $order; ?>&filter_is_status=<?php echo $is_status; ?>&filter_search_input=<?php echo urlencode($searchKeyword); ?>', true);">
            <?php echo $i; ?>
        </div>
    <?php endfor; ?>
    <div class="flex_xc_yc width_px_030 height_px_034 margin_px-x_002 border_px-a_001 pointer"
         data-bd-a-color="#d9d9d9" data-hover-bg-color="#dddddd"
         <?php if ($page < $totalPages): ?>
             egb:click="egbInitializeMenu('<?php echo $page_dir; ?>'); egbT('modal_<?php echo $page_dir; ?>_contents', 'id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=<?php echo $page + 1; ?>&filter_per_page=<?php echo $perPage; ?>&filter_order=<?php echo $order; ?>&filter_is_status=<?php echo $is_status; ?>&filter_search_input=<?php echo urlencode($searchKeyword); ?>', true);"
         <?php else: ?>
             style="pointer-events: none; opacity: 0.5;"
         <?php endif; ?>>
        <div class="flex_xc_yc width_px_017 height_px_017">
            <svg fill="#777777" height="100%" viewBox="0 0 24 24" width="100%" xmlns="http://www.w3.org/2000/svg">
                <path d="m13.061 4.93896-2.122 2.122 4.94 4.93904-4.94 4.939 2.122 2.122 7.06-7.061z" />
            </svg>
        </div>
    </div>
    <div class="flex_xc_yc width_px_030 height_px_034 margin_px-x_002 border_px-a_001 pointer"
         data-bd-a-color="#d9d9d9" data-hover-bg-color="#dddddd"
         <?php if ($page <= $totalPages - 5): ?>
             egb:click="egbInitializeMenu('<?php echo $page_dir; ?>'); egbT('modal_<?php echo $page_dir; ?>_contents', 'id=modal_<?php echo $page_dir; ?>_contents_<?php echo $page_name; ?>&path=/right_contents_box&filter_page_name=<?php echo $page_dir; ?>&filter_menu_name=<?php echo $page_name; ?>&filter_page=<?php echo min($page + 5, $totalPages); ?>&filter_per_page=<?php echo $perPage; ?>&filter_order=<?php echo $order; ?>&filter_is_status=<?php echo $is_status; ?>&filter_search_input=<?php echo urlencode($searchKeyword); ?>', true);"
         <?php else: ?>
             style="pointer-events: none; opacity: 0.5;"
         <?php endif; ?>>
        <div class="flex_xc_yc width_px_017 height_px_017">
            <svg fill="#777777" height="100%" viewBox="0 0 24 24" width="100%" xmlns="http://www.w3.org/2000/svg">
                <g>
                    <path d="m13.061 4.93896-2.122 2.122 4.94 4.93904-4.94 4.939 2.122 2.122 7.06-7.061z" />
                    <path d="m6.06103 19.061 7.05997-7.061-7.05997-7.06104-2.122 2.122 4.94 4.93904-4.94 4.939z" />
                </g>
            </svg>
        </div>
    </div>
    </div>
</div>



<div id="filter_<?php echo $page_name; ?>_box" class="position2 width_px_300 height_box overflow_y_auto z-index_4 scrollbar <?php echo $page_name; ?>_filter_modal display_off"
    data-top="0%" data-right="0%" data-bg-color="#f1f1f1">
    <div class="height_box height_auto padding_px-t_080 padding_px-u_040 font_px_012">
        <div class="padding_px-a_010">
            <?php
            // 테이블 컬럼 설정 가져오기
            $sql = "SELECT column_config_data_json FROM egb_table_column_config 
                    WHERE column_config_table_name = 'egb_page' 
                    AND column_config_user_uniq_id IS NULL 
                    AND deleted_at IS NULL 
                    ORDER BY created_at DESC LIMIT 1";
                    
            $dataBinding = binding_sql(1, $sql, []);
            $result = egb_sql($dataBinding);
            $column_config = [];
            
            if($result && !empty($result[0]['column_config_data_json'])) {
                $column_config = json_decode($result[0]['column_config_data_json'], true);
            }

            // 컬럼 설정이 없는 경우 기본 설정 생성
            if(empty($column_config)) {
                $result = egb_table_column_config_insert('egb_page');
                if($result['success']) {
                    $dataBinding = binding_sql(1, $sql, []);
                    $result = egb_sql($dataBinding);
                    if($result && !empty($result[0]['column_config_data_json'])) {
                        $column_config = json_decode($result[0]['column_config_data_json'], true);
                    }
                }
            }

            // 필터 UI 동적 생성
            foreach($column_config as $config) {
                if($config['detail_filter'] == 1) {
                    $name = $config['name'];
                    $comment = $config['comment'];
                    $filter_type = $config['filter_type'] ?? 'text';
                    
                    // page_name이라는 이름이 있다면 filter_page_name으로 변경
                    if ($name === 'page_name') {
                        $name = 'filter_page_name';
                        $value = egb('filter_page_name');
                    } else {
                        $value = egb($name); // 현재 필터 값 가져오기
                    }
                    
                    // 기본값 설정
                    $default_value = '';
                    switch($filter_type) {
                        case 'date':
                            $default_value = date('Y-m-d');
                            break;
                        case 'number':
                            $default_value = '0';
                            break;
                        case 'boolean':
                        case 'status':
                            $default_value = '';
                            break;
                        default:
                            $default_value = '';
                    }
                    
                    // 값이 없는 경우 기본값 사용
                    $value = ($value !== null && $value !== '') ? $value : $default_value;
                    
                    echo "<div class='padding_px-u_005'>";
                    echo "<div class='padding_px-u_003'>{$comment}</div>";
                    
                    switch($filter_type) {
                        case 'date':
                            $start_value = egb($name . '_start') ?? '';
                            $end_value = egb($name . '_end') ?? '';
                            echo "<div class='flex_xs1_yc'>";
                            echo "<input class='width_box padding_px-x_010 padding_px-y_006 font_px_012 folders_input_design' type='date' name='{$name}_start' id='{$name}_start' value='{$start_value}' style='background-color: #ffffff;'>";
                            echo "<div class='padding_px-x_003'>-</div>";
                            echo "<input class='width_box padding_px-x_010 padding_px-y_006 font_px_012 folders_input_design' type='date' name='{$name}_end' id='{$name}_end' value='{$end_value}' style='background-color: #ffffff;'>";
                            echo "</div>";
                            break;
                            
                        case 'boolean':
                            echo "<select class='width_box padding_px-x_010 padding_px-y_006' name='{$name}' id='{$name}' style='background-color: #ffffff;'>";
                            echo "<option value=''>전체</option>";
                            echo "<option value='1'" . ($value === '1' ? ' selected' : '') . ">예</option>";
                            echo "<option value='0'" . ($value === '0' ? ' selected' : '') . ">아니오</option>";
                            echo "</select>";
                            break;
                            
                        case 'status':
                            echo "<select class='width_box padding_px-x_010 padding_px-y_006' name='{$name}' id='{$name}' style='background-color: #ffffff;'>";
                            echo "<option value=''>전체</option>";
                            echo "<option value='1'" . ($value === '1' ? ' selected' : '') . ">사용</option>";
                            echo "<option value='0'" . ($value === '0' ? ' selected' : '') . ">미사용</option>";
                            echo "</select>";
                            break;
                            
                        case 'number':
                            echo "<input class='width_box padding_px-x_010 padding_px-y_006 font_px_012 folders_input_design number_input_design' type='number' name='{$name}' id='{$name}' value='{$value}' style='background-color: #ffffff;'>";
                            break;
                            
                        default:
                            echo "<input class='width_box padding_px-x_010 padding_px-y_006 font_px_012 folders_input_design' type='text' name='{$name}' id='{$name}' value='{$value}' style='background-color: #ffffff;'>";
                            break;
                    }
                    
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>
</div>

<script nonce="<?php echo NONCE; ?>">
    (() => {
        document.querySelectorAll('.<?php echo $page_name; ?>_filter_modal_open_button').forEach((filterButton) => {
            filterButton.addEventListener('click', function () {
                const modalFolder = document.getElementById('modal_<?php echo $page_dir; ?>_contents');
                const filterModal = document.querySelectorAll('.<?php echo $page_name; ?>_filter_modal');
                const changeButtonOn = document.querySelectorAll('.<?php echo $page_name; ?>_change_button_filter_on');
                const changeButtonOff = document.querySelectorAll('.<?php echo $page_name; ?>_change_button_filter_off');

                filterModal.forEach((modal, index) => {
                    if (modal.classList.contains('display_off')) {
                        // 모달이 비활성화된 상태이므로 활성화하기
                        modalFolder.style.overflow = 'hidden';

                        // display_off 클래스를 제거하고 transform과 transition 초기화
                        modal.classList.remove('display_off');

                        // change_button_filter_on의 display_off 제거, change_button_filter_off에 display_off 추가
                        changeButtonOn[index].classList.remove('display_off');
                        changeButtonOff[index].classList.add('display_off');

                        // 초기 위치 설정을 위한 transform: translateX(300px) 그대로 유지
                        modal.style.transform = 'translateX(300px)';

                        // 다음 프레임에 트랜지션을 적용하여 애니메이션 시작
                        requestAnimationFrame(() => {
                            modal.style.transition = 'transform 0.4s';
                            modal.style.transform = 'translateX(0)'; // 화면으로 나타나게 설정
                        });
                    } else {
                        closeModal(modal, changeButtonOn[index], changeButtonOff[index]);
                    }
                });

                // 외부 클릭 감지 함수 추가
                document.addEventListener('click', handleOutsideClick);
            });
        });

        // 모달을 닫는 함수 정의
        function closeModal(filterModal, changeButtonOn, changeButtonOff) {
            const modalFolder = document.getElementById('modal_<?php echo $page_dir; ?>_contents');

            filterModal.style.transition = 'transform 0.4s';
            filterModal.style.transform = 'translateX(300px)'; // 숨기기 위치로 이동
            modalFolder.style.overflow = 'hidden'; // 트랜지션 동안 숨기기

            setTimeout(() => {
                filterModal.classList.add('display_off');

                // change_button_filter_on에 display_off 추가, change_button_filter_off의 display_off 제거
                changeButtonOn.classList.add('display_off');
                changeButtonOff.classList.remove('display_off');

                // 트랜지션이 끝난 후에 modalFolder의 overflow를 auto로 설정
                modalFolder.style.overflow = 'auto';
            }, 400);

            // 외부 클릭 감지 이벤트 제거
            document.removeEventListener('click', handleOutsideClick);
        }

        // 외부 클릭을 감지하여 모달을 닫는 함수
        function handleOutsideClick(event) {
            const filterModals = document.querySelectorAll('.<?php echo $page_name; ?>_filter_modal');
            const filterButtons = document.querySelectorAll('.<?php echo $page_name; ?>_filter_modal_open_button');
            const changeButtonsOn = document.querySelectorAll('.<?php echo $page_name; ?>_change_button_filter_on');

            filterModals.forEach((modal, index) => {
                const filterButton = filterButtons[index];
                const changeButtonOn = changeButtonsOn[index];

                // 클릭한 요소가 모달 내부나 버튼, change_button_filter_on div가 아닐 때만 닫기
                if (
                    !modal.contains(event.target) &&
                    !filterButton.contains(event.target) &&
                    !changeButtonOn.contains(event.target)
                ) {
                    closeModal(modal, changeButtonOn, document.querySelectorAll('.<?php echo $page_name; ?>_change_button_filter_off')[index]);
                }
            });
        }
    })();















    (() => {
        // 마우스가 올라갔을 때 menu_box 클래스 제거하고, 제거된 요소들 저장
        let removedElements = [];

        document.querySelector('.point_all_reset').addEventListener('mouseenter', () => {
            removedElements = []; // 이전 기록 초기화
            document.querySelectorAll('.menu_box').forEach(element => {
                element.classList.remove('menu_box');
                removedElements.push(element); // 제거된 요소 저장
            });

            // menu_box 클래스 제거 후 scrolls_1 요소의 이벤트 리스너 재부착
            attachScrollHandlers();
        });

        // 마우스가 벗어났을 때 이전에 제거된 요소에만 menu_box 클래스 다시 추가
        document.querySelector('.point_all_reset').addEventListener('mouseleave', () => {
            removedElements.forEach(element => {
                element.classList.add('menu_box');
            });

            // menu_box 클래스 다시 추가 후 scrolls_1 요소의 이벤트 리스너 재부착
            attachScrollHandlers();
        });

        // 스크롤 이벤트 핸들러를 부착하는 함수 정의
        function attachScrollHandlers() {
            const elements = document.querySelectorAll('.scrolls_1');

            elements.forEach(function (ele) {
                // 기존 이벤트 리스너 제거
                ele.removeEventListener('mousedown', ele.startHandler);
                ele.removeEventListener('touchstart', ele.startHandler);

                let pos = { top: 0, left: 0, x: 0, y: 0 };

                const startHandler = function (e) {
                    // <select> 요소 클릭 시 실행되지 않도록 조건 추가
                    if (e.target.tagName === 'SELECT') return;

                    e.preventDefault(); // 선택 방지

                    pos = {
                        left: ele.scrollLeft,
                        top: ele.scrollTop,
                        x: e.touches ? e.touches[0].clientX : e.clientX,
                        y: e.touches ? e.touches[0].clientY : e.clientY,
                    };

                    document.addEventListener('mousemove', moveHandler);
                    document.addEventListener('mouseup', endHandler);
                    document.addEventListener('touchmove', moveHandler);
                    document.addEventListener('touchend', endHandler);
                };

                const moveHandler = function (e) {
                    const x = e.touches ? e.touches[0].clientX : e.clientX;
                    const y = e.touches ? e.touches[0].clientY : e.clientY;

                    const dx = x - pos.x;
                    const dy = y - pos.y;

                    // 좌우와 상하 스크롤 이동을 모두 반영
                    ele.scrollTop = pos.top - dy;
                    ele.scrollLeft = pos.left - dx;
                };

                const endHandler = function () {
                    document.removeEventListener('mousemove', moveHandler);
                    document.removeEventListener('mouseup', endHandler);
                    document.removeEventListener('touchmove', moveHandler);
                    document.removeEventListener('touchend', endHandler);
                };

                ele.addEventListener('mousedown', startHandler);
                ele.addEventListener('touchstart', startHandler);

                // startHandler를 요소에 저장하여 나중에 제거할 수 있도록 함
                ele.startHandler = startHandler;
            });
        }

        // 초기 로드 시 스크롤 이벤트 핸들러 부착
        document.addEventListener('DOMContentLoaded', function () {
            attachScrollHandlers();
        });
    })();







    (() => {
        // '<?php echo $page_name; ?>_check_all' 클릭 시 전체 체크
        document.getElementById('<?php echo $page_name; ?>_check_all').addEventListener('change', function () {
            const isChecked = this.checked;
            const checkboxes = document.querySelectorAll('input[id^="<?php echo $page_name; ?>_check_"]:not(#<?php echo $page_name; ?>_check_all)');

            checkboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });

            updateDisplay();
        });

        // 각 개별 체크박스 클릭 시 '<?php echo $page_name; ?>_check_all' 상태 업데이트 및 div 표시 상태 조정
        document.querySelectorAll('input[id^="<?php echo $page_name; ?>_check_"]:not(#<?php echo $page_name; ?>_check_all)').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const allCheckbox = document.getElementById('<?php echo $page_name; ?>_check_all');
                const checkboxes = document.querySelectorAll('input[id^="<?php echo $page_name; ?>_check_"]:not(#<?php echo $page_name; ?>_check_all)');

                // 전체 선택 체크박스의 상태 업데이트
                allCheckbox.checked = Array.from(checkboxes).every(cb => cb.checked);

                updateDisplay();
            });
        });

        // div 박스 표시 상태 조정 함수 
        function updateDisplay() {
            const checkboxes = document.querySelectorAll('input[id^="<?php echo $page_name; ?>_check_"]:not(#<?php echo $page_name; ?>_check_all)');
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const allCheckbox = document.getElementById('<?php echo $page_name; ?>_check_all');
            const totalCheckboxes = checkboxes.length;

            const editBox = document.querySelector('.<?php echo $page_name; ?>_check_edit');
            const deleteBox = document.querySelector('.<?php echo $page_name; ?>_check_delete');
            const viewBox = document.querySelector('.<?php echo $page_name; ?>_check_view');
            const addBox = document.querySelector('.<?php echo $page_name; ?>_check_add');
            const settingBox = document.querySelector('.<?php echo $page_name; ?>_check_setting');

            if (editBox) {
                <?php if (file_exists($path_2)): ?>
                if (checkedCount === 1) {
                    editBox.classList.remove('display_off');
                } else if (checkedCount >= 2) {
                    editBox.classList.add('display_off');
                } else {
                    editBox.classList.add('display_off'); 
                }
                <?php endif; ?>
            }

            if (deleteBox) {
                <?php if ($del_button !== 'display_off'): ?>
                    // 전체 선택이면서 1개 이상의 데이터가 있는 경우에만 삭제 버튼 숨김
                    if (allCheckbox.checked && totalCheckboxes > 1) {
                        deleteBox.classList.add('display_off');
                    } else if (checkedCount >= 1) {
                        deleteBox.classList.remove('display_off');
                    } else {
                        deleteBox.classList.add('display_off');
                    }
                <?php endif; ?>
            }

            if (viewBox) {
                if (checkedCount === 1) {
                    viewBox.classList.remove('display_off');
                } else {
                    viewBox.classList.add('display_off');
                }
            }

            <?php if (file_exists($path_4)): ?>
            if (addBox && settingBox) {
                if (checkedCount >= 1) {
                    addBox.classList.add('display_off');
                    settingBox.classList.remove('display_off');
                } else {
                    addBox.classList.remove('display_off');
                    settingBox.classList.add('display_off');
                }
            }
            <?php endif; ?>
        }

        // 초기 로드 시 체크박스 상태 업데이트
        document.addEventListener('DOMContentLoaded', function() {
            updateDisplay();
        });
    })();
</script>