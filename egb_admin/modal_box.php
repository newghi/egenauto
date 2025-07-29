<?php
$template_id = egb('id');
$template_id_box = egb('id') . '_box';
$template_id_contents_box = egb('id') . '_contents_box';
$template_id_contents = egb('id') . '_contents';
$template_id_min = egb('id') . '_min';
$template_id_max = egb('id') . '_max';
$template_id_close = egb('id') . '_close';
$template_id_menu = egb('id') . '_menu';

//id에 따라 아이콘과 관리명 설정
if ($template_id == 'setting') {
    $modal_name = '사이트 설정';
    $modal_icon = '
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%"
                        viewBox="0 0 512 512" xml:space="preserve" style="enable-background:new 0 0 512 512;">
                        <g style="opacity:0.08;">
                            <path d="M129.051,512c-74.5,0-124.56-50.059-124.56-124.56V133.542c0-74.5,50.059-124.56,124.56-124.56h253.898
                        c74.5,0,124.56,50.059,124.56,124.56V387.44c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        </g>
                        <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                            x2="-15.0449" y2="637.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#C4C4C6" />
                            <stop offset="1" style="stop-color:#F0F0F3" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_1_);" d="M129.051,503.018c-74.5,0-124.56-50.059-124.56-124.56V124.56C4.491,50.059,54.55,0,129.051,0
                    h253.898c74.5,0,124.56,50.059,124.56,124.56v253.898c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        <g style="opacity:0.16;">

                            <linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                                x2="-15.0449" y2="637.5254"
                                gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                                <stop offset="0" style="stop-color:#000000" />
                                <stop offset="0.06" style="stop-color:#000000;stop-opacity:0" />
                            </linearGradient>
                            <path style="fill:url(#SVGID_2_);"
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898
                        c0,74.5,50.059,124.56,124.56,124.56h253.898c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z
                        M489.544,378.458c0,64.755-41.84,106.595-106.595,106.595H129.051c-64.755,0-106.595-41.84-106.595-106.595V124.56
                        c0-64.755,41.84-106.595,106.595-106.595h253.898c64.755,0,106.595,41.84,106.595,106.595V378.458z" />
                        </g>
                        <linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="586.5254"
                            x2="-15.0449" y2="632.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#414142" />
                            <stop offset="1" style="stop-color:#282829" />
                        </linearGradient>
                        <circle style="fill:url(#SVGID_3_);" cx="256" cy="251.509" r="206.596" />
                        <linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="-26.0449" y1="559.5254"
                            x2="-4.0449" y2="559.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="opacity:0.24;fill:url(#SVGID_4_);enable-background:new    ;" d="M354.807,254.204v-5.389l-18.315-4.276
                    c-0.207-2.407-0.539-4.779-0.952-7.123l16.6-8.875l-1.392-5.21l-18.827,0.611c-0.817-2.264-1.734-4.473-2.74-6.629l13.743-12.872
                    l-2.695-4.671l-17.992,5.452c-1.383-1.967-2.829-3.889-4.374-5.722l9.917-15.953l-3.809-3.809l-15.953,9.917
                    c-1.832-1.545-3.755-2.991-5.722-4.374l5.452-17.992l-4.671-2.695l-12.872,13.743c-2.165-1.015-4.374-1.922-6.629-2.74l0.611-18.827
                    l-5.21-1.392l-8.875,16.6c-2.344-0.413-4.716-0.746-7.123-0.952l-4.285-18.324h-5.389l-4.276,18.315
                    c-2.407,0.207-4.779,0.539-7.123,0.952l-8.875-16.6l-5.21,1.392l0.611,18.827c-2.264,0.817-4.473,1.734-6.629,2.74l-12.872-13.743
                    l-4.671,2.695l5.452,17.992c-1.967,1.383-3.889,2.829-5.722,4.374l-15.953-9.917l-3.809,3.809l9.917,15.953
                    c-1.545,1.832-2.991,3.755-4.374,5.722l-17.992-5.452l-2.695,4.671l13.743,12.872c-1.015,2.165-1.922,4.374-2.74,6.629
                    l-18.827-0.611l-1.392,5.21l16.6,8.875c-0.413,2.344-0.746,4.716-0.952,7.123l-18.324,4.285v5.389l18.315,4.276
                    c0.207,2.407,0.539,4.779,0.952,7.123l-16.6,8.875l1.392,5.21l18.827-0.611c0.817,2.264,1.734,4.473,2.74,6.629l-13.743,12.872
                    l2.695,4.671l17.992-5.452c1.383,1.967,2.829,3.889,4.374,5.722l-9.917,15.953l3.809,3.809l15.953-9.917
                    c1.832,1.545,3.755,2.991,5.722,4.374l-5.452,17.992l4.671,2.695l12.872-13.743c2.165,1.015,4.374,1.922,6.629,2.74l-0.611,18.827
                    l5.21,1.392l8.875-16.6c2.344,0.413,4.716,0.746,7.123,0.952l4.285,18.324h5.389l4.276-18.315c2.407-0.207,4.779-0.539,7.123-0.952
                    l8.875,16.6l5.21-1.392l-0.611-18.827c2.264-0.817,4.473-1.734,6.629-2.74l12.872,13.743l4.671-2.695l-5.452-17.992
                    c1.967-1.383,3.889-2.829,5.722-4.374l15.953,9.917l3.809-3.809l-9.917-15.953c1.545-1.832,2.991-3.755,4.374-5.722l17.992,5.452
                    l2.695-4.671l-13.743-12.872c1.015-2.165,1.922-4.374,2.74-6.629l18.827,0.611l1.392-5.21l-16.6-8.875
                    c0.413-2.344,0.746-4.716,0.952-7.123L354.807,254.204z M309.895,251.509c0,29.768-24.127,53.895-53.895,53.895
                    s-53.895-24.127-53.895-53.895s24.127-53.895,53.895-53.895S309.895,221.741,309.895,251.509z" />
                        <linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="-10.0699" y1="599.291"
                            x2="-27.5699" y2="635.291"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_5_);" d="M417.684,254.204v-5.389l-18.315-4.276c-0.386-8.003-1.311-15.863-2.964-23.471l16.465-8.803
                    l-1.392-5.21l-18.657,0.611c-2.434-7.581-5.542-14.857-9.144-21.845l13.689-12.827l-2.695-4.671l-17.974,5.452
                    c-4.285-6.638-9.135-12.854-14.426-18.675l9.953-16.016l-3.809-3.809l-16.016,9.953c-5.83-5.291-12.045-10.141-18.675-14.426
                    l5.452-17.974l-4.671-2.695l-12.827,13.689c-6.979-3.552-14.255-6.71-21.845-9.144l0.611-18.657l-5.21-1.392l-8.803,16.465
                    c-7.558-1.653-15.468-2.578-23.471-2.964l-4.267-18.306h-5.389l-4.276,18.315c-8.003,0.386-15.863,1.311-23.471,2.964l-8.803-16.465
                    l-5.21,1.392l0.611,18.657c-7.581,2.434-14.857,5.533-21.845,9.144l-12.827-13.689l-4.671,2.695l5.452,17.974
                    c-6.638,4.285-12.854,9.135-18.675,14.426l-16.016-9.953l-3.809,3.809l9.953,16.016c-5.291,5.83-10.141,12.045-14.426,18.675
                    l-17.974-5.452l-2.695,4.671l13.689,12.827c-3.552,6.979-6.71,14.255-9.144,21.845l-18.657-0.611l-1.392,5.21l16.465,8.803
                    c-1.653,7.558-2.578,15.468-2.964,23.471l-18.306,4.267v5.389l18.315,4.276c0.386,8.003,1.311,15.863,2.964,23.471l-16.465,8.803
                    l1.392,5.21l18.657-0.611c2.434,7.581,5.542,14.857,9.144,21.845l-13.689,12.827l2.695,4.671l17.974-5.452
                    c4.285,6.638,9.135,12.854,14.426,18.674l-9.953,16.016l3.809,3.809l16.016-9.953c5.83,5.291,12.045,10.141,18.675,14.426
                    l-5.452,17.974l4.671,2.695l12.827-13.689c6.979,3.552,14.255,6.71,21.845,9.144l-0.611,18.657l5.21,1.392l8.803-16.465
                    c7.558,1.653,15.468,2.578,23.471,2.964l4.267,18.306h5.389l4.276-18.315c8.003-0.386,15.863-1.311,23.471-2.964l8.803,16.465
                    l5.21-1.392l-0.611-18.657c7.581-2.434,14.857-5.533,21.845-9.144l12.827,13.689l4.671-2.695l-5.452-17.974
                    c6.638-4.285,12.854-9.135,18.675-14.426l16.016,9.953l3.809-3.809l-9.953-16.016c5.291-5.83,10.141-12.045,14.426-18.674
                    l17.974,5.452l2.695-4.671l-13.689-12.827c3.552-6.979,6.71-14.255,9.144-21.845l18.657,0.611l1.392-5.21l-16.465-8.803
                    c1.653-7.558,2.578-15.468,2.964-23.471L417.684,254.204z M368.802,221.525c2.228,8.372-4.482,16.51-13.141,16.51h-81.803
                    c-3.575-4.725-8.938-7.941-15.099-8.704l-40.915-70.863c-4.482-7.77-0.252-17.57,8.417-19.86c9.494-2.524,19.465-3.871,29.741-3.871
                    C310.021,134.737,355.535,171.619,368.802,221.525z M264.982,251.509c0,4.958-4.024,8.982-8.982,8.982s-8.982-4.024-8.982-8.982
                    c0-4.958,4.024-8.982,8.982-8.982S264.982,246.55,264.982,251.509z M139.228,251.509c0-32.022,13.016-61,33.972-82.091
                    c6.306-6.351,16.914-5.075,21.387,2.668l40.762,70.611c-1.159,2.704-1.805,5.686-1.805,8.812s0.647,6.108,1.814,8.812
                    l-40.762,70.552c-4.473,7.752-15.073,9.018-21.387,2.668C152.244,312.509,139.228,283.531,139.228,251.509z M256,368.281
                    c-10.276,0-20.246-1.347-29.741-3.871c-8.668-2.3-12.908-12.099-8.417-19.86l40.915-70.863c6.162-0.763,11.525-3.979,15.1-8.704
                    h81.803c8.668,0,15.369,8.138,13.141,16.51C355.535,331.39,310.021,368.281,256,368.281z" />
                        <g style="opacity:0.16;">
                            <path
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898c0,74.5,50.059,124.56,124.56,124.56h253.898
                        c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z M498.526,378.458
                        c0,69.129-46.448,115.577-115.577,115.577H129.051c-69.129,0-115.577-46.448-115.577-115.577V124.56
                        c0-69.129,46.448-115.577,115.577-115.577h253.898c69.129,0,115.577,46.448,115.577,115.577V378.458z" />
                        </g>
                    </svg>
	';
}
if ($template_id == 'page') {
    $modal_name = '사이트 관리';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'column_page') {
    $modal_name = '칼럼 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_page') {
    $modal_name = '페이지 추가';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_page') {
    $modal_name = '페이지 수정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'view_page') {
    $modal_name = '페이지 뷰';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'option_group') {
    $modal_name = '옵션 그룹 관리';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'column_option_group') {
    $modal_name = '칼럼 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_option_group') {
    $modal_name = '옵션 그룹 추가';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_option_group') {
    $modal_name = '옵션 그룹 수정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'view_option_group') {
    $modal_name = '옵션 그룹 뷰';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'setting_option_group') {
    $modal_name = '옵션 그룹 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'option') {
    $modal_name = '옵션 관리';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'column_option') {
    $modal_name = '칼럼 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_option') {
    $modal_name = '옵션 추가';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_option') {
    $modal_name = '옵션 수정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'view_option') {
    $modal_name = '옵션 뷰';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'setting_option') {
    $modal_name = '옵션 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'column2_option') {
    $modal_name = '칼럼 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'event') {
    $modal_name = '이벤트 관리';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'column_event') {
    $modal_name = '이벤트 칼럼 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_event') {
    $modal_name = '이벤트 추가';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_event') {
    $modal_name = '이벤트 수정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'view_event') {
    $modal_name = '이벤트 뷰';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'setting_event') {
    $modal_name = '이벤트 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'deposit') {
    $modal_name = '예치금 관리';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'column_deposit') {
    $modal_name = '예치금 칼럼 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_deposit') {
    $modal_name = '예치금 추가';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_deposit') {
    $modal_name = '예치금 수정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'view_deposit') {
    $modal_name = '예치금 뷰';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'setting_deposit') {
    $modal_name = '예치금 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'point') {
    $modal_name = '적립금 관리';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'column_point') {
    $modal_name = '적립금 칼럼 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_point') {
    $modal_name = '적립금 추가';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_point') {
    $modal_name = '적립금 수정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'view_point') {
    $modal_name = '적립금 뷰';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'setting_point') {
    $modal_name = '적립금 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'mileage') {
    $modal_name = '마일리지 관리';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'column_mileage') {
    $modal_name = '마일리지 칼럼 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_mileage') {
    $modal_name = '마일리지 추가';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_mileage') {
    $modal_name = '마일리지 수정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'view_mileage') {
    $modal_name = '마일리지 뷰';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'setting_mileage') {
    $modal_name = '마일리지 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'reward') {
    $modal_name = '리워드 설정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_reward') {
    $modal_name = '리워드 수정';
    $modal_icon = '
                    <svg class="svg_shadow" width="100%" height="100%" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
            <g id="Layer_17" data-name="Layer 17">
                <path d="m7 16h50a3 3 0 0 1 3 3v33a0 0 0 0 1 0 0h-56a0 0 0 0 1 0 0v-33a3 3 0 0 1 3-3z" fill="#a0a8b3" />
                <path d="m8 20h48v28h-48z" fill="#a2dbf7" />
                <path d="m2 2h46v38h-46z" fill="#c7e2fb" />
                <path d="m2 33.65a43.19 43.19 0 0 0 5.5.35c19.61 0 35.5-13 35.5-29a23 23 0 0 0 -.19-3h-40.81z"
                    fill="#ebf7fe" />
                <path d="m6 14h21v14h-21z" fill="#4472b0" />
                <path d="m20 20-8 8h15v-1z" fill="#78b75b" />
                <path d="m18 2h30v8h-30z" fill="#698ec0" />
                <path d="m2 2h16v8h-16z" fill="#4472b0" />
                <path d="m2 52h60a0 0 0 0 1 0 0v6a4 4 0 0 1 -4 4h-52a4 4 0 0 1 -4-4v-6a0 0 0 0 1 0 0z" fill="#8892a0" />
                <g fill="#fff">
                    <path d="m55 56h2v2h-2z" />
                    <path d="m51 56h2v2h-2z" />
                    <path d="m46 43-3-10 10 3-5 2z" />
                    <path d="m5 5h2v2h-2z" />
                    <path d="m9 5h2v2h-2z" />
                    <path d="m13 5h2v2h-2z" />
                    <path d="m21 5h24v2h-24z" />
                </g>
                <path d="m6 28 6-6 6 6z" fill="#96cc7f" />
                <path d="m10.87 14c.33 0 .13.65.13 1a4 4 0 0 1 -4 4 3.66 3.66 0 0 1 -1-.13v-4.87z" fill="#f47b50" />
                <path d="m6 32h34v4h-34z" fill="#976947" />
                <path d="m31 14h13v6h-13z" fill="#976947" />
                <path d="m30 27h15v2h-15z" fill="#976947" />
                <path d="m30 23h15v2h-15z" fill="#976947" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_api') {
    $modal_name = 'API 수정';
    $modal_icon = '
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%"
                        viewBox="0 0 512 512" xml:space="preserve" style="enable-background:new 0 0 512 512;">
                        <g style="opacity:0.08;">
                            <path d="M129.051,512c-74.5,0-124.56-50.059-124.56-124.56V133.542c0-74.5,50.059-124.56,124.56-124.56h253.898
                        c74.5,0,124.56,50.059,124.56,124.56V387.44c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        </g>
                        <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                            x2="-15.0449" y2="637.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#C4C4C6" />
                            <stop offset="1" style="stop-color:#F0F0F3" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_1_);" d="M129.051,503.018c-74.5,0-124.56-50.059-124.56-124.56V124.56C4.491,50.059,54.55,0,129.051,0
                    h253.898c74.5,0,124.56,50.059,124.56,124.56v253.898c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        <g style="opacity:0.16;">

                            <linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                                x2="-15.0449" y2="637.5254"
                                gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                                <stop offset="0" style="stop-color:#000000" />
                                <stop offset="0.06" style="stop-color:#000000;stop-opacity:0" />
                            </linearGradient>
                            <path style="fill:url(#SVGID_2_);"
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898
                        c0,74.5,50.059,124.56,124.56,124.56h253.898c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z
                        M489.544,378.458c0,64.755-41.84,106.595-106.595,106.595H129.051c-64.755,0-106.595-41.84-106.595-106.595V124.56
                        c0-64.755,41.84-106.595,106.595-106.595h253.898c64.755,0,106.595,41.84,106.595,106.595V378.458z" />
                        </g>
                        <linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="586.5254"
                            x2="-15.0449" y2="632.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#414142" />
                            <stop offset="1" style="stop-color:#282829" />
                        </linearGradient>
                        <circle style="fill:url(#SVGID_3_);" cx="256" cy="251.509" r="206.596" />
                        <linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="-26.0449" y1="559.5254"
                            x2="-4.0449" y2="559.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="opacity:0.24;fill:url(#SVGID_4_);enable-background:new    ;" d="M354.807,254.204v-5.389l-18.315-4.276
                    c-0.207-2.407-0.539-4.779-0.952-7.123l16.6-8.875l-1.392-5.21l-18.827,0.611c-0.817-2.264-1.734-4.473-2.74-6.629l13.743-12.872
                    l-2.695-4.671l-17.992,5.452c-1.383-1.967-2.829-3.889-4.374-5.722l9.917-15.953l-3.809-3.809l-15.953,9.917
                    c-1.832-1.545-3.755-2.991-5.722-4.374l5.452-17.992l-4.671-2.695l-12.872,13.743c-2.165-1.015-4.374-1.922-6.629-2.74l0.611-18.827
                    l-5.21-1.392l-8.875,16.6c-2.344-0.413-4.716-0.746-7.123-0.952l-4.285-18.324h-5.389l-4.276,18.315
                    c-2.407,0.207-4.779,0.539-7.123,0.952l-8.875-16.6l-5.21,1.392l0.611,18.827c-2.264,0.817-4.473,1.734-6.629,2.74l-12.872-13.743
                    l-4.671,2.695l5.452,17.992c-1.967,1.383-3.889,2.829-5.722,4.374l-15.953-9.917l-3.809,3.809l9.917,15.953
                    c-1.545,1.832-2.991,3.755-4.374,5.722l-17.992-5.452l-2.695,4.671l13.743,12.872c-1.015,2.165-1.922,4.374-2.74,6.629
                    l-18.827-0.611l-1.392,5.21l16.6,8.875c-0.413,2.344-0.746,4.716-0.952,7.123l-18.324,4.285v5.389l18.315,4.276
                    c0.207,2.407,0.539,4.779,0.952,7.123l-16.6,8.875l1.392,5.21l18.827-0.611c0.817,2.264,1.734,4.473,2.74,6.629l-13.743,12.872
                    l2.695,4.671l17.992-5.452c1.383,1.967,2.829,3.889,4.374,5.722l-9.917,15.953l3.809,3.809l15.953-9.917
                    c1.832,1.545,3.755,2.991,5.722,4.374l-5.452,17.992l4.671,2.695l12.872-13.743c2.165,1.015,4.374,1.922,6.629,2.74l-0.611,18.827
                    l5.21,1.392l8.875-16.6c2.344,0.413,4.716,0.746,7.123,0.952l4.285,18.324h5.389l4.276-18.315c2.407-0.207,4.779-0.539,7.123-0.952
                    l8.875,16.6l5.21-1.392l-0.611-18.827c2.264-0.817,4.473-1.734,6.629-2.74l12.872,13.743l4.671-2.695l-5.452-17.992
                    c1.967-1.383,3.889-2.829,5.722-4.374l15.953,9.917l3.809-3.809l-9.917-15.953c1.545-1.832,2.991-3.755,4.374-5.722l17.992,5.452
                    l2.695-4.671l-13.743-12.872c1.015-2.165,1.922-4.374,2.74-6.629l18.827,0.611l1.392-5.21l-16.6-8.875
                    c0.413-2.344,0.746-4.716,0.952-7.123L354.807,254.204z M309.895,251.509c0,29.768-24.127,53.895-53.895,53.895
                    s-53.895-24.127-53.895-53.895s24.127-53.895,53.895-53.895S309.895,221.741,309.895,251.509z" />
                        <linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="-10.0699" y1="599.291"
                            x2="-27.5699" y2="635.291"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_5_);" d="M417.684,254.204v-5.389l-18.315-4.276c-0.386-8.003-1.311-15.863-2.964-23.471l16.465-8.803
                    l-1.392-5.21l-18.657,0.611c-2.434-7.581-5.542-14.857-9.144-21.845l13.689-12.827l-2.695-4.671l-17.974,5.452
                    c-4.285-6.638-9.135-12.854-14.426-18.675l9.953-16.016l-3.809-3.809l-16.016,9.953c-5.83-5.291-12.045-10.141-18.675-14.426
                    l5.452-17.974l-4.671-2.695l-12.827,13.689c-6.979-3.552-14.255-6.71-21.845-9.144l0.611-18.657l-5.21-1.392l-8.803,16.465
                    c-7.558-1.653-15.468-2.578-23.471-2.964l-4.267-18.306h-5.389l-4.276,18.315c-8.003,0.386-15.863,1.311-23.471,2.964l-8.803-16.465
                    l-5.21,1.392l0.611,18.657c-7.581,2.434-14.857,5.533-21.845,9.144l-12.827-13.689l-4.671,2.695l5.452,17.974
                    c-6.638,4.285-12.854,9.135-18.675,14.426l-16.016-9.953l-3.809,3.809l9.953,16.016c-5.291,5.83-10.141,12.045-14.426,18.675
                    l-17.974-5.452l-2.695,4.671l13.689,12.827c-3.552,6.979-6.71,14.255-9.144,21.845l-18.657-0.611l-1.392,5.21l16.465,8.803
                    c-1.653,7.558-2.578,15.468-2.964,23.471l-18.306,4.267v5.389l18.315,4.276c0.386,8.003,1.311,15.863,2.964,23.471l-16.465,8.803
                    l1.392,5.21l18.657-0.611c2.434,7.581,5.542,14.857,9.144,21.845l-13.689,12.827l2.695,4.671l17.974-5.452
                    c4.285,6.638,9.135,12.854,14.426,18.674l-9.953,16.016l3.809,3.809l16.016-9.953c5.83,5.291,12.045,10.141,18.675,14.426
                    l-5.452,17.974l4.671,2.695l12.827-13.689c6.979,3.552,14.255,6.71,21.845,9.144l-0.611,18.657l5.21,1.392l8.803-16.465
                    c7.558,1.653,15.468,2.578,23.471,2.964l4.267,18.306h5.389l4.276-18.315c8.003-0.386,15.863-1.311,23.471-2.964l8.803,16.465
                    l5.21-1.392l-0.611-18.657c7.581-2.434,14.857-5.533,21.845-9.144l12.827,13.689l4.671-2.695l-5.452-17.974
                    c6.638-4.285,12.854-9.135,18.675-14.426l16.016,9.953l3.809-3.809l-9.953-16.016c5.291-5.83,10.141-12.045,14.426-18.674
                    l17.974,5.452l2.695-4.671l-13.689-12.827c3.552-6.979,6.71-14.255,9.144-21.845l18.657,0.611l1.392-5.21l-16.465-8.803
                    c1.653-7.558,2.578-15.468,2.964-23.471L417.684,254.204z M368.802,221.525c2.228,8.372-4.482,16.51-13.141,16.51h-81.803
                    c-3.575-4.725-8.938-7.941-15.099-8.704l-40.915-70.863c-4.482-7.77-0.252-17.57,8.417-19.86c9.494-2.524,19.465-3.871,29.741-3.871
                    C310.021,134.737,355.535,171.619,368.802,221.525z M264.982,251.509c0,4.958-4.024,8.982-8.982,8.982s-8.982-4.024-8.982-8.982
                    c0-4.958,4.024-8.982,8.982-8.982S264.982,246.55,264.982,251.509z M139.228,251.509c0-32.022,13.016-61,33.972-82.091
                    c6.306-6.351,16.914-5.075,21.387,2.668l40.762,70.611c-1.159,2.704-1.805,5.686-1.805,8.812s0.647,6.108,1.814,8.812
                    l-40.762,70.552c-4.473,7.752-15.073,9.018-21.387,2.668C152.244,312.509,139.228,283.531,139.228,251.509z M256,368.281
                    c-10.276,0-20.246-1.347-29.741-3.871c-8.668-2.3-12.908-12.099-8.417-19.86l40.915-70.863c6.162-0.763,11.525-3.979,15.1-8.704
                    h81.803c8.668,0,15.369,8.138,13.141,16.51C355.535,331.39,310.021,368.281,256,368.281z" />
                        <g style="opacity:0.16;">
                            <path
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898c0,74.5,50.059,124.56,124.56,124.56h253.898
                        c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z M498.526,378.458
                        c0,69.129-46.448,115.577-115.577,115.577H129.051c-69.129,0-115.577-46.448-115.577-115.577V124.56
                        c0-69.129,46.448-115.577,115.577-115.577h253.898c69.129,0,115.577,46.448,115.577,115.577V378.458z" />
                        </g>
                    </svg>
	';
}
if ($template_id == 'shop') {
    $modal_name = '쇼핑몰 설정';
    $modal_icon = '
           <svg class="svg_shadow" id="Artboard_30" height="100%" viewBox="0 0 64 64" width="100%"
            xmlns="http://www.w3.org/2000/svg" data-name="Artboard 30">
            <path d="m60 59v-35.28a2 2 0 0 0 -1.7-1.978l-31.3-4.742v42z" fill="#b5b1a5" />
            <path d="m60 23.72a2 2 0 0 0 -1.7-1.978l-28.3-4.287v26.132a11.413 11.413 0 0 0 11.413 11.413h18.587z"
                fill="#d9d5ca" />
            <path
                d="m25 13.173v-7.731a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.568 21.568 0 0 0 -6.82-1.107 21.568 21.568 0 0 0 -6.82 1.107l-1.312.437a2 2 0 0 0 -1.368 1.898v7.732z"
                fill="#66c2ed" />
            <path
                d="m4 59v-42.362a4 4 0 0 1 2.424-3.677l.44-.188a21.916 21.916 0 0 1 8.636-1.773 21.916 21.916 0 0 1 8.636 1.773l.44.188a4 4 0 0 1 2.424 3.677v42.362z"
                fill="#66c2ed" />
            <path
                d="m27 16.638a4 4 0 0 0 -2.424-3.677l-.44-.188a21.712 21.712 0 0 0 -16.114-.429c-.007.1-.022.194-.022.294v31.732a10.63 10.63 0 0 0 10.63 10.63h8.37z"
                fill="#76d8ff" />
            <rect fill="#494949" height="3" rx="1.5" width="20" x="33" y="40" />
            <path d="m36 43h14v16h-14z" fill="#76d8ff" />
            <path d="m42 43h2v16h-2z" fill="#d6fdff" />
            <path
                d="m21 11.73c-.661-.171-1.326-.312-2-.421v9.022a19.511 19.511 0 0 0 -7 .02v-9.042c-.674.109-1.339.25-2 .421v9.094a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v7.9a19.272 19.272 0 0 0 -5.293 2.494l-.707.467v2.41l1.825-1.22a17.221 17.221 0 0 1 4.175-2.05v7.894a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v8.895a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v5.071h2v-5.623a17.5 17.5 0 0 1 7 0v5.623h2v-5.106a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-8.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.275 19.275 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948zm-2 39.6a19.511 19.511 0 0 0 -7 .02v-8.973a17.479 17.479 0 0 1 7 0zm0-11a19.511 19.511 0 0 0 -7 .02v-7.972a17.479 17.479 0 0 1 7 0zm0-10a19.488 19.488 0 0 0 -7 .02v-7.973a17.479 17.479 0 0 1 7 0z"
                fill="#d6fdff" />
            <g fill="#b53c33">
                <path
                    d="m36 23.97h-1a1 1 0 0 0 -.928.628l-1.072 2.68-1.071-2.678a1 1 0 0 0 -.929-.63h-1a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-4.308l1.071 2.679a1 1 0 0 0 1.858 0l1.071-2.679v4.308a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-7a1 1 0 0 0 -1-1z" />
                <path
                    d="m43 23.97h-2a1 1 0 0 0 -.97.757l-1.758 7.03a1 1 0 0 0 .728 1.213 1 1 0 0 0 1.213-.728l.568-2.272h2.438l.568 2.272a1 1 0 0 0 1.213.728 1 1 0 0 0 .728-1.213l-1.758-7.03a1 1 0 0 0 -.97-.757zm-1.719 4 .5-2h.438l.5 2z" />
                <path
                    d="m48 23.97a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1h-2v-6a1 1 0 0 0 -1-1z" />
                <path d="m55 30.97v-6a1 1 0 0 0 -1-1 1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1z" />
            </g>
            <path
                d="m25 5.442a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.562 21.562 0 0 0 -13.64 0l-.68.226v4.613a2.085 2.085 0 0 0 2.631 2.028c5.84-1.706 12.016-.084 14.369.677z"
                fill="#76d8ff" />
            <rect fill="#494949" height="3" rx="1.5" width="60" x="2" y="59" />
        </svg>
	';
}
if ($template_id == 'add_shop_setting') {
    $modal_name = '상품 추가';
    $modal_icon = '
           <svg class="svg_shadow" id="Artboard_30" height="100%" viewBox="0 0 64 64" width="100%"
            xmlns="http://www.w3.org/2000/svg" data-name="Artboard 30">
            <path d="m60 59v-35.28a2 2 0 0 0 -1.7-1.978l-31.3-4.742v42z" fill="#b5b1a5" />
            <path d="m60 23.72a2 2 0 0 0 -1.7-1.978l-28.3-4.287v26.132a11.413 11.413 0 0 0 11.413 11.413h18.587z"
                fill="#d9d5ca" />
            <path
                d="m25 13.173v-7.731a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.568 21.568 0 0 0 -6.82-1.107 21.568 21.568 0 0 0 -6.82 1.107l-1.312.437a2 2 0 0 0 -1.368 1.898v7.732z"
                fill="#66c2ed" />
            <path
                d="m4 59v-42.362a4 4 0 0 1 2.424-3.677l.44-.188a21.916 21.916 0 0 1 8.636-1.773 21.916 21.916 0 0 1 8.636 1.773l.44.188a4 4 0 0 1 2.424 3.677v42.362z"
                fill="#66c2ed" />
            <path
                d="m27 16.638a4 4 0 0 0 -2.424-3.677l-.44-.188a21.712 21.712 0 0 0 -16.114-.429c-.007.1-.022.194-.022.294v31.732a10.63 10.63 0 0 0 10.63 10.63h8.37z"
                fill="#76d8ff" />
            <rect fill="#494949" height="3" rx="1.5" width="20" x="33" y="40" />
            <path d="m36 43h14v16h-14z" fill="#76d8ff" />
            <path d="m42 43h2v16h-2z" fill="#d6fdff" />
            <path
                d="m21 11.73c-.661-.171-1.326-.312-2-.421v9.022a19.511 19.511 0 0 0 -7 .02v-9.042c-.674.109-1.339.25-2 .421v9.094a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v7.9a19.272 19.272 0 0 0 -5.293 2.494l-.707.467v2.41l1.825-1.22a17.221 17.221 0 0 1 4.175-2.05v7.894a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v8.895a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v5.071h2v-5.623a17.5 17.5 0 0 1 7 0v5.623h2v-5.106a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-8.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.275 19.275 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948zm-2 39.6a19.511 19.511 0 0 0 -7 .02v-8.973a17.479 17.479 0 0 1 7 0zm0-11a19.511 19.511 0 0 0 -7 .02v-7.972a17.479 17.479 0 0 1 7 0zm0-10a19.488 19.488 0 0 0 -7 .02v-7.973a17.479 17.479 0 0 1 7 0z"
                fill="#d6fdff" />
            <g fill="#b53c33">
                <path
                    d="m36 23.97h-1a1 1 0 0 0 -.928.628l-1.072 2.68-1.071-2.678a1 1 0 0 0 -.929-.63h-1a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-4.308l1.071 2.679a1 1 0 0 0 1.858 0l1.071-2.679v4.308a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-7a1 1 0 0 0 -1-1z" />
                <path
                    d="m43 23.97h-2a1 1 0 0 0 -.97.757l-1.758 7.03a1 1 0 0 0 .728 1.213 1 1 0 0 0 1.213-.728l.568-2.272h2.438l.568 2.272a1 1 0 0 0 1.213.728 1 1 0 0 0 .728-1.213l-1.758-7.03a1 1 0 0 0 -.97-.757zm-1.719 4 .5-2h.438l.5 2z" />
                <path
                    d="m48 23.97a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1h-2v-6a1 1 0 0 0 -1-1z" />
                <path d="m55 30.97v-6a1 1 0 0 0 -1-1 1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1z" />
            </g>
            <path
                d="m25 5.442a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.562 21.562 0 0 0 -13.64 0l-.68.226v4.613a2.085 2.085 0 0 0 2.631 2.028c5.84-1.706 12.016-.084 14.369.677z"
                fill="#76d8ff" />
            <rect fill="#494949" height="3" rx="1.5" width="60" x="2" y="59" />
        </svg>
	';
}
if ($template_id == 'edit_shop_setting') {
    $modal_name = '상품 수정';
    $modal_icon = '
           <svg class="svg_shadow" id="Artboard_30" height="100%" viewBox="0 0 64 64" width="100%"
            xmlns="http://www.w3.org/2000/svg" data-name="Artboard 30">
            <path d="m60 59v-35.28a2 2 0 0 0 -1.7-1.978l-31.3-4.742v42z" fill="#b5b1a5" />
            <path d="m60 23.72a2 2 0 0 0 -1.7-1.978l-28.3-4.287v26.132a11.413 11.413 0 0 0 11.413 11.413h18.587z"
                fill="#d9d5ca" />
            <path
                d="m25 13.173v-7.731a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.568 21.568 0 0 0 -6.82-1.107 21.568 21.568 0 0 0 -6.82 1.107l-1.312.437a2 2 0 0 0 -1.368 1.898v7.732z"
                fill="#66c2ed" />
            <path
                d="m4 59v-42.362a4 4 0 0 1 2.424-3.677l.44-.188a21.916 21.916 0 0 1 8.636-1.773 21.916 21.916 0 0 1 8.636 1.773l.44.188a4 4 0 0 1 2.424 3.677v42.362z"
                fill="#66c2ed" />
            <path
                d="m27 16.638a4 4 0 0 0 -2.424-3.677l-.44-.188a21.712 21.712 0 0 0 -16.114-.429c-.007.1-.022.194-.022.294v31.732a10.63 10.63 0 0 0 10.63 10.63h8.37z"
                fill="#76d8ff" />
            <rect fill="#494949" height="3" rx="1.5" width="20" x="33" y="40" />
            <path d="m36 43h14v16h-14z" fill="#76d8ff" />
            <path d="m42 43h2v16h-2z" fill="#d6fdff" />
            <path
                d="m21 11.73c-.661-.171-1.326-.312-2-.421v9.022a19.511 19.511 0 0 0 -7 .02v-9.042c-.674.109-1.339.25-2 .421v9.094a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v7.9a19.272 19.272 0 0 0 -5.293 2.494l-.707.467v2.41l1.825-1.22a17.221 17.221 0 0 1 4.175-2.05v7.894a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v8.895a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v5.071h2v-5.623a17.5 17.5 0 0 1 7 0v5.623h2v-5.106a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-8.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.275 19.275 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948zm-2 39.6a19.511 19.511 0 0 0 -7 .02v-8.973a17.479 17.479 0 0 1 7 0zm0-11a19.511 19.511 0 0 0 -7 .02v-7.972a17.479 17.479 0 0 1 7 0zm0-10a19.488 19.488 0 0 0 -7 .02v-7.973a17.479 17.479 0 0 1 7 0z"
                fill="#d6fdff" />
            <g fill="#b53c33">
                <path
                    d="m36 23.97h-1a1 1 0 0 0 -.928.628l-1.072 2.68-1.071-2.678a1 1 0 0 0 -.929-.63h-1a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-4.308l1.071 2.679a1 1 0 0 0 1.858 0l1.071-2.679v4.308a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-7a1 1 0 0 0 -1-1z" />
                <path
                    d="m43 23.97h-2a1 1 0 0 0 -.97.757l-1.758 7.03a1 1 0 0 0 .728 1.213 1 1 0 0 0 1.213-.728l.568-2.272h2.438l.568 2.272a1 1 0 0 0 1.213.728 1 1 0 0 0 .728-1.213l-1.758-7.03a1 1 0 0 0 -.97-.757zm-1.719 4 .5-2h.438l.5 2z" />
                <path
                    d="m48 23.97a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1h-2v-6a1 1 0 0 0 -1-1z" />
                <path d="m55 30.97v-6a1 1 0 0 0 -1-1 1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1z" />
            </g>
            <path
                d="m25 5.442a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.562 21.562 0 0 0 -13.64 0l-.68.226v4.613a2.085 2.085 0 0 0 2.631 2.028c5.84-1.706 12.016-.084 14.369.677z"
                fill="#76d8ff" />
            <rect fill="#494949" height="3" rx="1.5" width="60" x="2" y="59" />
        </svg>
	';
}
if ($template_id == 'edit_pg_setting') {
    $modal_name = 'PG사 수정';
    $modal_icon = '
           <svg class="svg_shadow" id="Artboard_30" height="100%" viewBox="0 0 64 64" width="100%"
            xmlns="http://www.w3.org/2000/svg" data-name="Artboard 30">
            <path d="m60 59v-35.28a2 2 0 0 0 -1.7-1.978l-31.3-4.742v42z" fill="#b5b1a5" />
            <path d="m60 23.72a2 2 0 0 0 -1.7-1.978l-28.3-4.287v26.132a11.413 11.413 0 0 0 11.413 11.413h18.587z"
                fill="#d9d5ca" />
            <path
                d="m25 13.173v-7.731a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.568 21.568 0 0 0 -6.82-1.107 21.568 21.568 0 0 0 -6.82 1.107l-1.312.437a2 2 0 0 0 -1.368 1.898v7.732z"
                fill="#66c2ed" />
            <path
                d="m4 59v-42.362a4 4 0 0 1 2.424-3.677l.44-.188a21.916 21.916 0 0 1 8.636-1.773 21.916 21.916 0 0 1 8.636 1.773l.44.188a4 4 0 0 1 2.424 3.677v42.362z"
                fill="#66c2ed" />
            <path
                d="m27 16.638a4 4 0 0 0 -2.424-3.677l-.44-.188a21.712 21.712 0 0 0 -16.114-.429c-.007.1-.022.194-.022.294v31.732a10.63 10.63 0 0 0 10.63 10.63h8.37z"
                fill="#76d8ff" />
            <rect fill="#494949" height="3" rx="1.5" width="20" x="33" y="40" />
            <path d="m36 43h14v16h-14z" fill="#76d8ff" />
            <path d="m42 43h2v16h-2z" fill="#d6fdff" />
            <path
                d="m21 11.73c-.661-.171-1.326-.312-2-.421v9.022a19.511 19.511 0 0 0 -7 .02v-9.042c-.674.109-1.339.25-2 .421v9.094a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v7.9a19.272 19.272 0 0 0 -5.293 2.494l-.707.467v2.41l1.825-1.22a17.221 17.221 0 0 1 4.175-2.05v7.894a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v8.895a19.246 19.246 0 0 0 -5.294 2.493l-.706.473v2.41l1.825-1.221a17.257 17.257 0 0 1 4.175-2.05v5.071h2v-5.623a17.5 17.5 0 0 1 7 0v5.623h2v-5.106a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-8.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.275 19.275 0 0 0 -6-2.948v-7.918a17.328 17.328 0 0 1 4.841 2.494l1.159.894v-2.522a19.286 19.286 0 0 0 -6-2.948zm-2 39.6a19.511 19.511 0 0 0 -7 .02v-8.973a17.479 17.479 0 0 1 7 0zm0-11a19.511 19.511 0 0 0 -7 .02v-7.972a17.479 17.479 0 0 1 7 0zm0-10a19.488 19.488 0 0 0 -7 .02v-7.973a17.479 17.479 0 0 1 7 0z"
                fill="#d6fdff" />
            <g fill="#b53c33">
                <path
                    d="m36 23.97h-1a1 1 0 0 0 -.928.628l-1.072 2.68-1.071-2.678a1 1 0 0 0 -.929-.63h-1a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-4.308l1.071 2.679a1 1 0 0 0 1.858 0l1.071-2.679v4.308a1 1 0 0 0 1 1 1 1 0 0 0 1-1v-7a1 1 0 0 0 -1-1z" />
                <path
                    d="m43 23.97h-2a1 1 0 0 0 -.97.757l-1.758 7.03a1 1 0 0 0 .728 1.213 1 1 0 0 0 1.213-.728l.568-2.272h2.438l.568 2.272a1 1 0 0 0 1.213.728 1 1 0 0 0 .728-1.213l-1.758-7.03a1 1 0 0 0 -.97-.757zm-1.719 4 .5-2h.438l.5 2z" />
                <path
                    d="m48 23.97a1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1h-2v-6a1 1 0 0 0 -1-1z" />
                <path d="m55 30.97v-6a1 1 0 0 0 -1-1 1 1 0 0 0 -1 1v7a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1 1 1 0 0 0 -1-1z" />
            </g>
            <path
                d="m25 5.442a2 2 0 0 0 -1.368-1.9l-1.312-.435a21.562 21.562 0 0 0 -13.64 0l-.68.226v4.613a2.085 2.085 0 0 0 2.631 2.028c5.84-1.706 12.016-.084 14.369.677z"
                fill="#76d8ff" />
            <rect fill="#494949" height="3" rx="1.5" width="60" x="2" y="59" />
        </svg>
	';
}
if ($template_id == 'media') {
    $modal_name = '미디어 설정';
    $modal_icon = '
            <svg viewBox="0 0 64 64" width="100%" xmlns="http://www.w3.org/2000/svg"><g id="music_·_multimedia_·_audio_·_player_·_media" data-name="music · multimedia · audio · player · media"><path d="m9 13h46a4 4 0 0 1 4 4v36a0 0 0 0 1 0 0h-54a0 0 0 0 1 0 0v-36a4 4 0 0 1 4-4z" fill="#004fac"/><path d="m9 17h46v32h-46z" fill="#2488ff"/><path d="m23 49h32v-32a32 32 0 0 1 -32 32z" fill="#006df0"/><rect fill="#ff9811" height="22" rx="2" width="26" x="3" y="23"/><rect fill="#ffcd00" height="22" rx="2" width="26" x="35" y="23"/><rect fill="#5eac24" height="22" rx="2" width="26" x="19" y="3"/><path d="m5 53h-2v4a4 4 0 0 0 4 4h50a4 4 0 0 0 4-4v-4z" fill="#003f8a"/><path d="m26 55a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-2h-12z" fill="#939598"/><path d="m7 27h18v14h-18z" fill="#d1e7f8"/><path d="m7 41h6l.903-1.505-2.903-5.495z" fill="#4e901e"/><path d="m13 41h12l-6-10z" fill="#5eac24"/><path d="m39 27h18v14h-18z" fill="#ff5023"/><path d="m23 7h18v14h-18z" fill="#ed1c24"/><circle cx="45" cy="37" fill="#ffc477" r="1"/><circle cx="51" cy="36" fill="#ffc477" r="1"/><g fill="#f1f2f2"><path d="m29 18 7-4.029-7-3.971z"/><path d="m51.835 29.014-6 1a1 1 0 0 0 -.835.986v4a2 2 0 1 0 2 2v-5.153l4-.666v2.819a2 2 0 1 0 2 2v-6a1 1 0 0 0 -1.165-.986z"/></g></g></svg>
	';
}
if ($template_id == 'edit_image') {
    $modal_name = '이미지 수정';
    $modal_icon = '
            <svg viewBox="0 0 64 64" width="100%" xmlns="http://www.w3.org/2000/svg"><g id="music_·_multimedia_·_audio_·_player_·_media" data-name="music · multimedia · audio · player · media"><path d="m9 13h46a4 4 0 0 1 4 4v36a0 0 0 0 1 0 0h-54a0 0 0 0 1 0 0v-36a4 4 0 0 1 4-4z" fill="#004fac"/><path d="m9 17h46v32h-46z" fill="#2488ff"/><path d="m23 49h32v-32a32 32 0 0 1 -32 32z" fill="#006df0"/><rect fill="#ff9811" height="22" rx="2" width="26" x="3" y="23"/><rect fill="#ffcd00" height="22" rx="2" width="26" x="35" y="23"/><rect fill="#5eac24" height="22" rx="2" width="26" x="19" y="3"/><path d="m5 53h-2v4a4 4 0 0 0 4 4h50a4 4 0 0 0 4-4v-4z" fill="#003f8a"/><path d="m26 55a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-2h-12z" fill="#939598"/><path d="m7 27h18v14h-18z" fill="#d1e7f8"/><path d="m7 41h6l.903-1.505-2.903-5.495z" fill="#4e901e"/><path d="m13 41h12l-6-10z" fill="#5eac24"/><path d="m39 27h18v14h-18z" fill="#ff5023"/><path d="m23 7h18v14h-18z" fill="#ed1c24"/><circle cx="45" cy="37" fill="#ffc477" r="1"/><circle cx="51" cy="36" fill="#ffc477" r="1"/><g fill="#f1f2f2"><path d="m29 18 7-4.029-7-3.971z"/><path d="m51.835 29.014-6 1a1 1 0 0 0 -.835.986v4a2 2 0 1 0 2 2v-5.153l4-.666v2.819a2 2 0 1 0 2 2v-6a1 1 0 0 0 -1.165-.986z"/></g></g></svg>
	';
}
if ($template_id == 'edit_video') {
    $modal_name = '비디오 수정';
    $modal_icon = '
            <svg viewBox="0 0 64 64" width="100%" xmlns="http://www.w3.org/2000/svg"><g id="music_·_multimedia_·_audio_·_player_·_media" data-name="music · multimedia · audio · player · media"><path d="m9 13h46a4 4 0 0 1 4 4v36a0 0 0 0 1 0 0h-54a0 0 0 0 1 0 0v-36a4 4 0 0 1 4-4z" fill="#004fac"/><path d="m9 17h46v32h-46z" fill="#2488ff"/><path d="m23 49h32v-32a32 32 0 0 1 -32 32z" fill="#006df0"/><rect fill="#ff9811" height="22" rx="2" width="26" x="3" y="23"/><rect fill="#ffcd00" height="22" rx="2" width="26" x="35" y="23"/><rect fill="#5eac24" height="22" rx="2" width="26" x="19" y="3"/><path d="m5 53h-2v4a4 4 0 0 0 4 4h50a4 4 0 0 0 4-4v-4z" fill="#003f8a"/><path d="m26 55a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-2h-12z" fill="#939598"/><path d="m7 27h18v14h-18z" fill="#d1e7f8"/><path d="m7 41h6l.903-1.505-2.903-5.495z" fill="#4e901e"/><path d="m13 41h12l-6-10z" fill="#5eac24"/><path d="m39 27h18v14h-18z" fill="#ff5023"/><path d="m23 7h18v14h-18z" fill="#ed1c24"/><circle cx="45" cy="37" fill="#ffc477" r="1"/><circle cx="51" cy="36" fill="#ffc477" r="1"/><g fill="#f1f2f2"><path d="m29 18 7-4.029-7-3.971z"/><path d="m51.835 29.014-6 1a1 1 0 0 0 -.835.986v4a2 2 0 1 0 2 2v-5.153l4-.666v2.819a2 2 0 1 0 2 2v-6a1 1 0 0 0 -1.165-.986z"/></g></g></svg>
	';
}
if ($template_id == 'edit_sound') {
    $modal_name = '사운드 수정';
    $modal_icon = '
            <svg viewBox="0 0 64 64" width="100%" xmlns="http://www.w3.org/2000/svg"><g id="music_·_multimedia_·_audio_·_player_·_media" data-name="music · multimedia · audio · player · media"><path d="m9 13h46a4 4 0 0 1 4 4v36a0 0 0 0 1 0 0h-54a0 0 0 0 1 0 0v-36a4 4 0 0 1 4-4z" fill="#004fac"/><path d="m9 17h46v32h-46z" fill="#2488ff"/><path d="m23 49h32v-32a32 32 0 0 1 -32 32z" fill="#006df0"/><rect fill="#ff9811" height="22" rx="2" width="26" x="3" y="23"/><rect fill="#ffcd00" height="22" rx="2" width="26" x="35" y="23"/><rect fill="#5eac24" height="22" rx="2" width="26" x="19" y="3"/><path d="m5 53h-2v4a4 4 0 0 0 4 4h50a4 4 0 0 0 4-4v-4z" fill="#003f8a"/><path d="m26 55a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-2h-12z" fill="#939598"/><path d="m7 27h18v14h-18z" fill="#d1e7f8"/><path d="m7 41h6l.903-1.505-2.903-5.495z" fill="#4e901e"/><path d="m13 41h12l-6-10z" fill="#5eac24"/><path d="m39 27h18v14h-18z" fill="#ff5023"/><path d="m23 7h18v14h-18z" fill="#ed1c24"/><circle cx="45" cy="37" fill="#ffc477" r="1"/><circle cx="51" cy="36" fill="#ffc477" r="1"/><g fill="#f1f2f2"><path d="m29 18 7-4.029-7-3.971z"/><path d="m51.835 29.014-6 1a1 1 0 0 0 -.835.986v4a2 2 0 1 0 2 2v-5.153l4-.666v2.819a2 2 0 1 0 2 2v-6a1 1 0 0 0 -1.165-.986z"/></g></g></svg>
	';
}
if ($template_id == 'edit_menu') {
    $modal_name = '메뉴 수정';
    $modal_icon = '
           <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%"
                        viewBox="0 0 512 512" xml:space="preserve" style="enable-background:new 0 0 512 512;">
                        <g style="opacity:0.08;">
                            <path d="M129.051,512c-74.5,0-124.56-50.059-124.56-124.56V133.542c0-74.5,50.059-124.56,124.56-124.56h253.898
                        c74.5,0,124.56,50.059,124.56,124.56V387.44c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        </g>
                        <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                            x2="-15.0449" y2="637.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#C4C4C6" />
                            <stop offset="1" style="stop-color:#F0F0F3" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_1_);" d="M129.051,503.018c-74.5,0-124.56-50.059-124.56-124.56V124.56C4.491,50.059,54.55,0,129.051,0
                    h253.898c74.5,0,124.56,50.059,124.56,124.56v253.898c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        <g style="opacity:0.16;">

                            <linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                                x2="-15.0449" y2="637.5254"
                                gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                                <stop offset="0" style="stop-color:#000000" />
                                <stop offset="0.06" style="stop-color:#000000;stop-opacity:0" />
                            </linearGradient>
                            <path style="fill:url(#SVGID_2_);"
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898
                        c0,74.5,50.059,124.56,124.56,124.56h253.898c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z
                        M489.544,378.458c0,64.755-41.84,106.595-106.595,106.595H129.051c-64.755,0-106.595-41.84-106.595-106.595V124.56
                        c0-64.755,41.84-106.595,106.595-106.595h253.898c64.755,0,106.595,41.84,106.595,106.595V378.458z" />
                        </g>
                        <linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="586.5254"
                            x2="-15.0449" y2="632.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#414142" />
                            <stop offset="1" style="stop-color:#282829" />
                        </linearGradient>
                        <circle style="fill:url(#SVGID_3_);" cx="256" cy="251.509" r="206.596" />
                        <linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="-26.0449" y1="559.5254"
                            x2="-4.0449" y2="559.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="opacity:0.24;fill:url(#SVGID_4_);enable-background:new    ;" d="M354.807,254.204v-5.389l-18.315-4.276
                    c-0.207-2.407-0.539-4.779-0.952-7.123l16.6-8.875l-1.392-5.21l-18.827,0.611c-0.817-2.264-1.734-4.473-2.74-6.629l13.743-12.872
                    l-2.695-4.671l-17.992,5.452c-1.383-1.967-2.829-3.889-4.374-5.722l9.917-15.953l-3.809-3.809l-15.953,9.917
                    c-1.832-1.545-3.755-2.991-5.722-4.374l5.452-17.992l-4.671-2.695l-12.872,13.743c-2.165-1.015-4.374-1.922-6.629-2.74l0.611-18.827
                    l-5.21-1.392l-8.875,16.6c-2.344-0.413-4.716-0.746-7.123-0.952l-4.285-18.324h-5.389l-4.276,18.315
                    c-2.407,0.207-4.779,0.539-7.123,0.952l-8.875-16.6l-5.21,1.392l0.611,18.827c-2.264,0.817-4.473,1.734-6.629,2.74l-12.872-13.743
                    l-4.671,2.695l5.452,17.992c-1.967,1.383-3.889,2.829-5.722,4.374l-15.953-9.917l-3.809,3.809l9.917,15.953
                    c-1.545,1.832-2.991,3.755-4.374,5.722l-17.992-5.452l-2.695,4.671l13.743,12.872c-1.015,2.165-1.922,4.374-2.74,6.629
                    l-18.827-0.611l-1.392,5.21l16.6,8.875c-0.413,2.344-0.746,4.716-0.952,7.123l-18.324,4.285v5.389l18.315,4.276
                    c0.207,2.407,0.539,4.779,0.952,7.123l-16.6,8.875l1.392,5.21l18.827-0.611c0.817,2.264,1.734,4.473,2.74,6.629l-13.743,12.872
                    l2.695,4.671l17.992-5.452c1.383,1.967,2.829,3.889,4.374,5.722l-9.917,15.953l3.809,3.809l15.953-9.917
                    c1.832,1.545,3.755,2.991,5.722,4.374l-5.452,17.992l4.671,2.695l12.872-13.743c2.165,1.015,4.374,1.922,6.629,2.74l-0.611,18.827
                    l5.21,1.392l8.875-16.6c2.344,0.413,4.716,0.746,7.123,0.952l4.285,18.324h5.389l4.276-18.315c2.407-0.207,4.779-0.539,7.123-0.952
                    l8.875,16.6l5.21-1.392l-0.611-18.827c2.264-0.817,4.473-1.734,6.629-2.74l12.872,13.743l4.671-2.695l-5.452-17.992
                    c1.967-1.383,3.889-2.829,5.722-4.374l15.953,9.917l3.809-3.809l-9.917-15.953c1.545-1.832,2.991-3.755,4.374-5.722l17.992,5.452
                    l2.695-4.671l-13.743-12.872c1.015-2.165,1.922-4.374,2.74-6.629l18.827,0.611l1.392-5.21l-16.6-8.875
                    c0.413-2.344,0.746-4.716,0.952-7.123L354.807,254.204z M309.895,251.509c0,29.768-24.127,53.895-53.895,53.895
                    s-53.895-24.127-53.895-53.895s24.127-53.895,53.895-53.895S309.895,221.741,309.895,251.509z" />
                        <linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="-10.0699" y1="599.291"
                            x2="-27.5699" y2="635.291"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_5_);" d="M417.684,254.204v-5.389l-18.315-4.276c-0.386-8.003-1.311-15.863-2.964-23.471l16.465-8.803
                    l-1.392-5.21l-18.657,0.611c-2.434-7.581-5.542-14.857-9.144-21.845l13.689-12.827l-2.695-4.671l-17.974,5.452
                    c-4.285-6.638-9.135-12.854-14.426-18.675l9.953-16.016l-3.809-3.809l-16.016,9.953c-5.83-5.291-12.045-10.141-18.675-14.426
                    l5.452-17.974l-4.671-2.695l-12.827,13.689c-6.979-3.552-14.255-6.71-21.845-9.144l0.611-18.657l-5.21-1.392l-8.803,16.465
                    c-7.558-1.653-15.468-2.578-23.471-2.964l-4.267-18.306h-5.389l-4.276,18.315c-8.003,0.386-15.863,1.311-23.471,2.964l-8.803-16.465
                    l-5.21,1.392l0.611,18.657c-7.581,2.434-14.857,5.533-21.845,9.144l-12.827-13.689l-4.671,2.695l5.452,17.974
                    c-6.638,4.285-12.854,9.135-18.675,14.426l-16.016-9.953l-3.809,3.809l9.953,16.016c-5.291,5.83-10.141,12.045-14.426,18.675
                    l-17.974-5.452l-2.695,4.671l13.689,12.827c-3.552,6.979-6.71,14.255-9.144,21.845l-18.657-0.611l-1.392,5.21l16.465,8.803
                    c-1.653,7.558-2.578,15.468-2.964,23.471l-18.306,4.267v5.389l18.315,4.276c0.386,8.003,1.311,15.863,2.964,23.471l-16.465,8.803
                    l1.392,5.21l18.657-0.611c2.434,7.581,5.542,14.857,9.144,21.845l-13.689,12.827l2.695,4.671l17.974-5.452
                    c4.285,6.638,9.135,12.854,14.426,18.674l-9.953,16.016l3.809,3.809l16.016-9.953c5.83,5.291,12.045,10.141,18.675,14.426
                    l-5.452,17.974l4.671,2.695l12.827-13.689c6.979,3.552,14.255,6.71,21.845,9.144l-0.611,18.657l5.21,1.392l8.803-16.465
                    c7.558,1.653,15.468,2.578,23.471,2.964l4.267,18.306h5.389l4.276-18.315c8.003-0.386,15.863-1.311,23.471-2.964l8.803,16.465
                    l5.21-1.392l-0.611-18.657c7.581-2.434,14.857-5.533,21.845-9.144l12.827,13.689l4.671-2.695l-5.452-17.974
                    c6.638-4.285,12.854-9.135,18.675-14.426l16.016,9.953l3.809-3.809l-9.953-16.016c5.291-5.83,10.141-12.045,14.426-18.674
                    l17.974,5.452l2.695-4.671l-13.689-12.827c3.552-6.979,6.71-14.255,9.144-21.845l18.657,0.611l1.392-5.21l-16.465-8.803
                    c1.653-7.558,2.578-15.468,2.964-23.471L417.684,254.204z M368.802,221.525c2.228,8.372-4.482,16.51-13.141,16.51h-81.803
                    c-3.575-4.725-8.938-7.941-15.099-8.704l-40.915-70.863c-4.482-7.77-0.252-17.57,8.417-19.86c9.494-2.524,19.465-3.871,29.741-3.871
                    C310.021,134.737,355.535,171.619,368.802,221.525z M264.982,251.509c0,4.958-4.024,8.982-8.982,8.982s-8.982-4.024-8.982-8.982
                    c0-4.958,4.024-8.982,8.982-8.982S264.982,246.55,264.982,251.509z M139.228,251.509c0-32.022,13.016-61,33.972-82.091
                    c6.306-6.351,16.914-5.075,21.387,2.668l40.762,70.611c-1.159,2.704-1.805,5.686-1.805,8.812s0.647,6.108,1.814,8.812
                    l-40.762,70.552c-4.473,7.752-15.073,9.018-21.387,2.668C152.244,312.509,139.228,283.531,139.228,251.509z M256,368.281
                    c-10.276,0-20.246-1.347-29.741-3.871c-8.668-2.3-12.908-12.099-8.417-19.86l40.915-70.863c6.162-0.763,11.525-3.979,15.1-8.704
                    h81.803c8.668,0,15.369,8.138,13.141,16.51C355.535,331.39,310.021,368.281,256,368.281z" />
                        <g style="opacity:0.16;">
                            <path
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898c0,74.5,50.059,124.56,124.56,124.56h253.898
                        c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z M498.526,378.458
                        c0,69.129-46.448,115.577-115.577,115.577H129.051c-69.129,0-115.577-46.448-115.577-115.577V124.56
                        c0-69.129,46.448-115.577,115.577-115.577h253.898c69.129,0,115.577,46.448,115.577,115.577V378.458z" />
                        </g>
                    </svg>
	';
}
if ($template_id == 'edit_menu_plus') {
    $modal_name = '메뉴 수정';
    $modal_icon = '
           <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%"
                        viewBox="0 0 512 512" xml:space="preserve" style="enable-background:new 0 0 512 512;">
                        <g style="opacity:0.08;">
                            <path d="M129.051,512c-74.5,0-124.56-50.059-124.56-124.56V133.542c0-74.5,50.059-124.56,124.56-124.56h253.898
                        c74.5,0,124.56,50.059,124.56,124.56V387.44c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        </g>
                        <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                            x2="-15.0449" y2="637.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#C4C4C6" />
                            <stop offset="1" style="stop-color:#F0F0F3" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_1_);" d="M129.051,503.018c-74.5,0-124.56-50.059-124.56-124.56V124.56C4.491,50.059,54.55,0,129.051,0
                    h253.898c74.5,0,124.56,50.059,124.56,124.56v253.898c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        <g style="opacity:0.16;">

                            <linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                                x2="-15.0449" y2="637.5254"
                                gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                                <stop offset="0" style="stop-color:#000000" />
                                <stop offset="0.06" style="stop-color:#000000;stop-opacity:0" />
                            </linearGradient>
                            <path style="fill:url(#SVGID_2_);"
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898
                        c0,74.5,50.059,124.56,124.56,124.56h253.898c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z
                        M489.544,378.458c0,64.755-41.84,106.595-106.595,106.595H129.051c-64.755,0-106.595-41.84-106.595-106.595V124.56
                        c0-64.755,41.84-106.595,106.595-106.595h253.898c64.755,0,106.595,41.84,106.595,106.595V378.458z" />
                        </g>
                        <linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="586.5254"
                            x2="-15.0449" y2="632.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#414142" />
                            <stop offset="1" style="stop-color:#282829" />
                        </linearGradient>
                        <circle style="fill:url(#SVGID_3_);" cx="256" cy="251.509" r="206.596" />
                        <linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="-26.0449" y1="559.5254"
                            x2="-4.0449" y2="559.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="opacity:0.24;fill:url(#SVGID_4_);enable-background:new    ;" d="M354.807,254.204v-5.389l-18.315-4.276
                    c-0.207-2.407-0.539-4.779-0.952-7.123l16.6-8.875l-1.392-5.21l-18.827,0.611c-0.817-2.264-1.734-4.473-2.74-6.629l13.743-12.872
                    l-2.695-4.671l-17.992,5.452c-1.383-1.967-2.829-3.889-4.374-5.722l9.917-15.953l-3.809-3.809l-15.953,9.917
                    c-1.832-1.545-3.755-2.991-5.722-4.374l5.452-17.992l-4.671-2.695l-12.872,13.743c-2.165-1.015-4.374-1.922-6.629-2.74l0.611-18.827
                    l-5.21-1.392l-8.875,16.6c-2.344-0.413-4.716-0.746-7.123-0.952l-4.285-18.324h-5.389l-4.276,18.315
                    c-2.407,0.207-4.779,0.539-7.123,0.952l-8.875-16.6l-5.21,1.392l0.611,18.827c-2.264,0.817-4.473,1.734-6.629,2.74l-12.872-13.743
                    l-4.671,2.695l5.452,17.992c-1.967,1.383-3.889,2.829-5.722,4.374l-15.953-9.917l-3.809,3.809l9.917,15.953
                    c-1.545,1.832-2.991,3.755-4.374,5.722l-17.992-5.452l-2.695,4.671l13.743,12.872c-1.015,2.165-1.922,4.374-2.74,6.629
                    l-18.827-0.611l-1.392,5.21l16.6,8.875c-0.413,2.344-0.746,4.716-0.952,7.123l-18.324,4.285v5.389l18.315,4.276
                    c0.207,2.407,0.539,4.779,0.952,7.123l-16.6,8.875l1.392,5.21l18.827-0.611c0.817,2.264,1.734,4.473,2.74,6.629l-13.743,12.872
                    l2.695,4.671l17.992-5.452c1.383,1.967,2.829,3.889,4.374,5.722l-9.917,15.953l3.809,3.809l15.953-9.917
                    c1.832,1.545,3.755,2.991,5.722,4.374l-5.452,17.992l4.671,2.695l12.872-13.743c2.165,1.015,4.374,1.922,6.629,2.74l-0.611,18.827
                    l5.21,1.392l8.875-16.6c2.344,0.413,4.716,0.746,7.123,0.952l4.285,18.324h5.389l4.276-18.315c2.407-0.207,4.779-0.539,7.123-0.952
                    l8.875,16.6l5.21-1.392l-0.611-18.827c2.264-0.817,4.473-1.734,6.629-2.74l12.872,13.743l4.671-2.695l-5.452-17.992
                    c1.967-1.383,3.889-2.829,5.722-4.374l15.953,9.917l3.809-3.809l-9.917-15.953c1.545-1.832,2.991-3.755,4.374-5.722l17.992,5.452
                    l2.695-4.671l-13.743-12.872c1.015-2.165,1.922-4.374,2.74-6.629l18.827,0.611l1.392-5.21l-16.6-8.875
                    c0.413-2.344,0.746-4.716,0.952-7.123L354.807,254.204z M309.895,251.509c0,29.768-24.127,53.895-53.895,53.895
                    s-53.895-24.127-53.895-53.895s24.127-53.895,53.895-53.895S309.895,221.741,309.895,251.509z" />
                        <linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="-10.0699" y1="599.291"
                            x2="-27.5699" y2="635.291"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_5_);" d="M417.684,254.204v-5.389l-18.315-4.276c-0.386-8.003-1.311-15.863-2.964-23.471l16.465-8.803
                    l-1.392-5.21l-18.657,0.611c-2.434-7.581-5.542-14.857-9.144-21.845l13.689-12.827l-2.695-4.671l-17.974,5.452
                    c-4.285-6.638-9.135-12.854-14.426-18.675l9.953-16.016l-3.809-3.809l-16.016,9.953c-5.83-5.291-12.045-10.141-18.675-14.426
                    l5.452-17.974l-4.671-2.695l-12.827,13.689c-6.979-3.552-14.255-6.71-21.845-9.144l0.611-18.657l-5.21-1.392l-8.803,16.465
                    c-7.558-1.653-15.468-2.578-23.471-2.964l-4.267-18.306h-5.389l-4.276,18.315c-8.003,0.386-15.863,1.311-23.471,2.964l-8.803-16.465
                    l-5.21,1.392l0.611,18.657c-7.581,2.434-14.857,5.533-21.845,9.144l-12.827-13.689l-4.671,2.695l5.452,17.974
                    c-6.638,4.285-12.854,9.135-18.675,14.426l-16.016-9.953l-3.809,3.809l9.953,16.016c-5.291,5.83-10.141,12.045-14.426,18.675
                    l-17.974-5.452l-2.695,4.671l13.689,12.827c-3.552,6.979-6.71,14.255-9.144,21.845l-18.657-0.611l-1.392,5.21l16.465,8.803
                    c-1.653,7.558-2.578,15.468-2.964,23.471l-18.306,4.267v5.389l18.315,4.276c0.386,8.003,1.311,15.863,2.964,23.471l-16.465,8.803
                    l1.392,5.21l18.657-0.611c2.434,7.581,5.542,14.857,9.144,21.845l-13.689,12.827l2.695,4.671l17.974-5.452
                    c4.285,6.638,9.135,12.854,14.426,18.674l-9.953,16.016l3.809,3.809l16.016-9.953c5.83,5.291,12.045,10.141,18.675,14.426
                    l-5.452,17.974l4.671,2.695l12.827-13.689c6.979,3.552,14.255,6.71,21.845,9.144l-0.611,18.657l5.21,1.392l8.803-16.465
                    c7.558,1.653,15.468,2.578,23.471,2.964l4.267,18.306h5.389l4.276-18.315c8.003-0.386,15.863-1.311,23.471-2.964l8.803,16.465
                    l5.21-1.392l-0.611-18.657c7.581-2.434,14.857-5.533,21.845-9.144l12.827,13.689l4.671-2.695l-5.452-17.974
                    c6.638-4.285,12.854-9.135,18.675-14.426l16.016,9.953l3.809-3.809l-9.953-16.016c5.291-5.83,10.141-12.045,14.426-18.674
                    l17.974,5.452l2.695-4.671l-13.689-12.827c3.552-6.979,6.71-14.255,9.144-21.845l18.657,0.611l1.392-5.21l-16.465-8.803
                    c1.653-7.558,2.578-15.468,2.964-23.471L417.684,254.204z M368.802,221.525c2.228,8.372-4.482,16.51-13.141,16.51h-81.803
                    c-3.575-4.725-8.938-7.941-15.099-8.704l-40.915-70.863c-4.482-7.77-0.252-17.57,8.417-19.86c9.494-2.524,19.465-3.871,29.741-3.871
                    C310.021,134.737,355.535,171.619,368.802,221.525z M264.982,251.509c0,4.958-4.024,8.982-8.982,8.982s-8.982-4.024-8.982-8.982
                    c0-4.958,4.024-8.982,8.982-8.982S264.982,246.55,264.982,251.509z M139.228,251.509c0-32.022,13.016-61,33.972-82.091
                    c6.306-6.351,16.914-5.075,21.387,2.668l40.762,70.611c-1.159,2.704-1.805,5.686-1.805,8.812s0.647,6.108,1.814,8.812
                    l-40.762,70.552c-4.473,7.752-15.073,9.018-21.387,2.668C152.244,312.509,139.228,283.531,139.228,251.509z M256,368.281
                    c-10.276,0-20.246-1.347-29.741-3.871c-8.668-2.3-12.908-12.099-8.417-19.86l40.915-70.863c6.162-0.763,11.525-3.979,15.1-8.704
                    h81.803c8.668,0,15.369,8.138,13.141,16.51C355.535,331.39,310.021,368.281,256,368.281z" />
                        <g style="opacity:0.16;">
                            <path
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898c0,74.5,50.059,124.56,124.56,124.56h253.898
                        c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z M498.526,378.458
                        c0,69.129-46.448,115.577-115.577,115.577H129.051c-69.129,0-115.577-46.448-115.577-115.577V124.56
                        c0-69.129,46.448-115.577,115.577-115.577h253.898c69.129,0,115.577,46.448,115.577,115.577V378.458z" />
                        </g>
                    </svg>
	';
}
if ($template_id == 'edit_board') {
    $modal_name = '게시판 수정';
    $modal_icon = '
           <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%" height="100%"
                        viewBox="0 0 512 512" xml:space="preserve" style="enable-background:new 0 0 512 512;">
                        <g style="opacity:0.08;">
                            <path d="M129.051,512c-74.5,0-124.56-50.059-124.56-124.56V133.542c0-74.5,50.059-124.56,124.56-124.56h253.898
                        c74.5,0,124.56,50.059,124.56,124.56V387.44c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        </g>
                        <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                            x2="-15.0449" y2="637.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#C4C4C6" />
                            <stop offset="1" style="stop-color:#F0F0F3" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_1_);" d="M129.051,503.018c-74.5,0-124.56-50.059-124.56-124.56V124.56C4.491,50.059,54.55,0,129.051,0
                    h253.898c74.5,0,124.56,50.059,124.56,124.56v253.898c0,74.5-50.059,124.56-124.56,124.56H129.051z" />
                        <g style="opacity:0.16;">

                            <linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="581.5254"
                                x2="-15.0449" y2="637.5254"
                                gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                                <stop offset="0" style="stop-color:#000000" />
                                <stop offset="0.06" style="stop-color:#000000;stop-opacity:0" />
                            </linearGradient>
                            <path style="fill:url(#SVGID_2_);"
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898
                        c0,74.5,50.059,124.56,124.56,124.56h253.898c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z
                        M489.544,378.458c0,64.755-41.84,106.595-106.595,106.595H129.051c-64.755,0-106.595-41.84-106.595-106.595V124.56
                        c0-64.755,41.84-106.595,106.595-106.595h253.898c64.755,0,106.595,41.84,106.595,106.595V378.458z" />
                        </g>
                        <linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="-15.0449" y1="586.5254"
                            x2="-15.0449" y2="632.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#414142" />
                            <stop offset="1" style="stop-color:#282829" />
                        </linearGradient>
                        <circle style="fill:url(#SVGID_3_);" cx="256" cy="251.509" r="206.596" />
                        <linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="-26.0449" y1="559.5254"
                            x2="-4.0449" y2="559.5254"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="opacity:0.24;fill:url(#SVGID_4_);enable-background:new    ;" d="M354.807,254.204v-5.389l-18.315-4.276
                    c-0.207-2.407-0.539-4.779-0.952-7.123l16.6-8.875l-1.392-5.21l-18.827,0.611c-0.817-2.264-1.734-4.473-2.74-6.629l13.743-12.872
                    l-2.695-4.671l-17.992,5.452c-1.383-1.967-2.829-3.889-4.374-5.722l9.917-15.953l-3.809-3.809l-15.953,9.917
                    c-1.832-1.545-3.755-2.991-5.722-4.374l5.452-17.992l-4.671-2.695l-12.872,13.743c-2.165-1.015-4.374-1.922-6.629-2.74l0.611-18.827
                    l-5.21-1.392l-8.875,16.6c-2.344-0.413-4.716-0.746-7.123-0.952l-4.285-18.324h-5.389l-4.276,18.315
                    c-2.407,0.207-4.779,0.539-7.123,0.952l-8.875-16.6l-5.21,1.392l0.611,18.827c-2.264,0.817-4.473,1.734-6.629,2.74l-12.872-13.743
                    l-4.671,2.695l5.452,17.992c-1.967,1.383-3.889,2.829-5.722,4.374l-15.953-9.917l-3.809,3.809l9.917,15.953
                    c-1.545,1.832-2.991,3.755-4.374,5.722l-17.992-5.452l-2.695,4.671l13.743,12.872c-1.015,2.165-1.922,4.374-2.74,6.629
                    l-18.827-0.611l-1.392,5.21l16.6,8.875c-0.413,2.344-0.746,4.716-0.952,7.123l-18.324,4.285v5.389l18.315,4.276
                    c0.207,2.407,0.539,4.779,0.952,7.123l-16.6,8.875l1.392,5.21l18.827-0.611c0.817,2.264,1.734,4.473,2.74,6.629l-13.743,12.872
                    l2.695,4.671l17.992-5.452c1.383,1.967,2.829,3.889,4.374,5.722l-9.917,15.953l3.809,3.809l15.953-9.917
                    c1.832,1.545,3.755,2.991,5.722,4.374l-5.452,17.992l4.671,2.695l12.872-13.743c2.165,1.015,4.374,1.922,6.629,2.74l-0.611,18.827
                    l5.21,1.392l8.875-16.6c2.344,0.413,4.716,0.746,7.123,0.952l4.285,18.324h5.389l4.276-18.315c2.407-0.207,4.779-0.539,7.123-0.952
                    l8.875,16.6l5.21-1.392l-0.611-18.827c2.264-0.817,4.473-1.734,6.629-2.74l12.872,13.743l4.671-2.695l-5.452-17.992
                    c1.967-1.383,3.889-2.829,5.722-4.374l15.953,9.917l3.809-3.809l-9.917-15.953c1.545-1.832,2.991-3.755,4.374-5.722l17.992,5.452
                    l2.695-4.671l-13.743-12.872c1.015-2.165,1.922-4.374,2.74-6.629l18.827,0.611l1.392-5.21l-16.6-8.875
                    c0.413-2.344,0.746-4.716,0.952-7.123L354.807,254.204z M309.895,251.509c0,29.768-24.127,53.895-53.895,53.895
                    s-53.895-24.127-53.895-53.895s24.127-53.895,53.895-53.895S309.895,221.741,309.895,251.509z" />
                        <linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="-10.0699" y1="599.291"
                            x2="-27.5699" y2="635.291"
                            gradientTransform="matrix(8.9825 0 0 -8.9825 391.1404 5726.5439)">
                            <stop offset="0" style="stop-color:#CCCCCE" />
                            <stop offset="1" style="stop-color:#E8E8EA" />
                        </linearGradient>
                        <path style="fill:url(#SVGID_5_);" d="M417.684,254.204v-5.389l-18.315-4.276c-0.386-8.003-1.311-15.863-2.964-23.471l16.465-8.803
                    l-1.392-5.21l-18.657,0.611c-2.434-7.581-5.542-14.857-9.144-21.845l13.689-12.827l-2.695-4.671l-17.974,5.452
                    c-4.285-6.638-9.135-12.854-14.426-18.675l9.953-16.016l-3.809-3.809l-16.016,9.953c-5.83-5.291-12.045-10.141-18.675-14.426
                    l5.452-17.974l-4.671-2.695l-12.827,13.689c-6.979-3.552-14.255-6.71-21.845-9.144l0.611-18.657l-5.21-1.392l-8.803,16.465
                    c-7.558-1.653-15.468-2.578-23.471-2.964l-4.267-18.306h-5.389l-4.276,18.315c-8.003,0.386-15.863,1.311-23.471,2.964l-8.803-16.465
                    l-5.21,1.392l0.611,18.657c-7.581,2.434-14.857,5.533-21.845,9.144l-12.827-13.689l-4.671,2.695l5.452,17.974
                    c-6.638,4.285-12.854,9.135-18.675,14.426l-16.016-9.953l-3.809,3.809l9.953,16.016c-5.291,5.83-10.141,12.045-14.426,18.675
                    l-17.974-5.452l-2.695,4.671l13.689,12.827c-3.552,6.979-6.71,14.255-9.144,21.845l-18.657-0.611l-1.392,5.21l16.465,8.803
                    c-1.653,7.558-2.578,15.468-2.964,23.471l-18.306,4.267v5.389l18.315,4.276c0.386,8.003,1.311,15.863,2.964,23.471l-16.465,8.803
                    l1.392,5.21l18.657-0.611c2.434,7.581,5.542,14.857,9.144,21.845l-13.689,12.827l2.695,4.671l17.974-5.452
                    c4.285,6.638,9.135,12.854,14.426,18.674l-9.953,16.016l3.809,3.809l16.016-9.953c5.83,5.291,12.045,10.141,18.675,14.426
                    l-5.452,17.974l4.671,2.695l12.827-13.689c6.979,3.552,14.255,6.71,21.845,9.144l-0.611,18.657l5.21,1.392l8.803-16.465
                    c7.558,1.653,15.468,2.578,23.471,2.964l4.267,18.306h5.389l4.276-18.315c8.003-0.386,15.863-1.311,23.471-2.964l8.803,16.465
                    l5.21-1.392l-0.611-18.657c7.581-2.434,14.857-5.533,21.845-9.144l12.827,13.689l4.671-2.695l-5.452-17.974
                    c6.638-4.285,12.854-9.135,18.675-14.426l16.016,9.953l3.809-3.809l-9.953-16.016c5.291-5.83,10.141-12.045,14.426-18.674
                    l17.974,5.452l2.695-4.671l-13.689-12.827c3.552-6.979,6.71-14.255,9.144-21.845l18.657,0.611l1.392-5.21l-16.465-8.803
                    c1.653-7.558,2.578-15.468,2.964-23.471L417.684,254.204z M368.802,221.525c2.228,8.372-4.482,16.51-13.141,16.51h-81.803
                    c-3.575-4.725-8.938-7.941-15.099-8.704l-40.915-70.863c-4.482-7.77-0.252-17.57,8.417-19.86c9.494-2.524,19.465-3.871,29.741-3.871
                    C310.021,134.737,355.535,171.619,368.802,221.525z M264.982,251.509c0,4.958-4.024,8.982-8.982,8.982s-8.982-4.024-8.982-8.982
                    c0-4.958,4.024-8.982,8.982-8.982S264.982,246.55,264.982,251.509z M139.228,251.509c0-32.022,13.016-61,33.972-82.091
                    c6.306-6.351,16.914-5.075,21.387,2.668l40.762,70.611c-1.159,2.704-1.805,5.686-1.805,8.812s0.647,6.108,1.814,8.812
                    l-40.762,70.552c-4.473,7.752-15.073,9.018-21.387,2.668C152.244,312.509,139.228,283.531,139.228,251.509z M256,368.281
                    c-10.276,0-20.246-1.347-29.741-3.871c-8.668-2.3-12.908-12.099-8.417-19.86l40.915-70.863c6.162-0.763,11.525-3.979,15.1-8.704
                    h81.803c8.668,0,15.369,8.138,13.141,16.51C355.535,331.39,310.021,368.281,256,368.281z" />
                        <g style="opacity:0.16;">
                            <path
                                d="M382.949,0H129.051C54.55,0,4.491,50.059,4.491,124.56v253.898c0,74.5,50.059,124.56,124.56,124.56h253.898
                        c74.5,0,124.56-50.059,124.56-124.56V124.56C507.509,50.059,457.45,0,382.949,0z M498.526,378.458
                        c0,69.129-46.448,115.577-115.577,115.577H129.051c-69.129,0-115.577-46.448-115.577-115.577V124.56
                        c0-69.129,46.448-115.577,115.577-115.577h253.898c69.129,0,115.577,46.448,115.577,115.577V378.458z" />
                        </g>
                    </svg>
	';
}
if ($template_id == 'game') {
    $modal_name = '미니게임';
    $modal_icon = '
           <svg id="Layer_1" height="100%" viewBox="0 0 48 48" width="100%"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" data-name="Layer 1">
                    <linearGradient id="linear-gradient" gradientUnits="userSpaceOnUse" x1="24" x2="24" y1="9.126"
                        y2="40.022">
                        <stop offset="0" stop-color="#3e4154" />
                        <stop offset="1" stop-color="#1b2129" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-2" x2="24" xlink:href="#linear-gradient" y1="24.921"
                        y2="26.96" />
                    <linearGradient id="linear-gradient-3" x1="36" x2="36" xlink:href="#linear-gradient" y1="2.56"
                        y2="24.881" />
                    <linearGradient id="linear-gradient-4" x1="12" x2="12" xlink:href="#linear-gradient" y1="2.56"
                        y2="24.881" />
                    <linearGradient id="linear-gradient-5" gradientUnits="userSpaceOnUse" x1="34.5" x2="37.5" y1="15.5"
                        y2="15.5">
                        <stop offset="0" stop-color="#fed200" />
                        <stop offset="1" stop-color="#f59815" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-6" gradientUnits="userSpaceOnUse" x1="34.939" x2="37.061"
                        y1="21.439" y2="23.561">
                        <stop offset="0" stop-color="#6fc6fc" />
                        <stop offset="1" stop-color="#50a7f6" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-7" gradientUnits="userSpaceOnUse" x1="38.439" x2="40.561"
                        y1="17.939" y2="20.061">
                        <stop offset="0" stop-color="#34ca82" />
                        <stop offset="1" stop-color="#37a477" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-8" gradientUnits="userSpaceOnUse" x1="31.439" x2="33.561"
                        y1="17.939" y2="20.061">
                        <stop offset="0" stop-color="#e85155" />
                        <stop offset="1" stop-color="#c21d2c" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-9" gradientUnits="userSpaceOnUse" x1="8.468" x2="15.316"
                        y1="15.468" y2="22.316">
                        <stop offset="0" stop-color="#edf1f2" />
                        <stop offset="1" stop-color="#c6cbcc" />
                    </linearGradient>
                    <path
                        d="m42.059 40c-3.252 0-7.162-3.224-10.812-9h-14.494c-4.237 6.706-8.824 9.973-12.323 8.75a5.5 5.5 0 0 1 -3.077-3.056c-2.215-4.646-1.653-13.749 1.373-22.137a10.049 10.049 0 0 1 15.443-4.557h11.662a10.049 10.049 0 0 1 15.443 4.557c3.024 8.388 3.588 17.491 1.373 22.137a5.5 5.5 0 0 1 -3.077 3.056 4.555 4.555 0 0 1 -1.511.25z"
                        fill="url(#linear-gradient)" />
                    <path d="m26 27h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2z" fill="url(#linear-gradient-2)" />
                    <circle cx="36" cy="19" fill="url(#linear-gradient-3)" r="7.5" />
                    <circle cx="12" cy="19" fill="url(#linear-gradient-4)" r="7" />
                    <circle cx="36" cy="15.5" fill="url(#linear-gradient-5)" r="1.5" />
                    <circle cx="36" cy="22.5" fill="url(#linear-gradient-6)" r="1.5" />
                    <circle cx="39.5" cy="19" fill="url(#linear-gradient-7)" r="1.5" />
                    <circle cx="32.5" cy="19" fill="url(#linear-gradient-8)" r="1.5" />
                    <path
                        d="m15.5 17.5h-2v-2a1.5 1.5 0 0 0 -3 0v2h-2a1.5 1.5 0 0 0 0 3h2v2a1.5 1.5 0 0 0 3 0v-2h2a1.5 1.5 0 0 0 0-3z"
                        fill="url(#linear-gradient-9)" />
                </svg>
	';
}
if ($template_id == 'mini_game') {
    $modal_name = '게임';
    $modal_icon = '
           <svg id="Layer_1" height="100%" viewBox="0 0 48 48" width="100%"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" data-name="Layer 1">
                    <linearGradient id="linear-gradient" gradientUnits="userSpaceOnUse" x1="24" x2="24" y1="9.126"
                        y2="40.022">
                        <stop offset="0" stop-color="#3e4154" />
                        <stop offset="1" stop-color="#1b2129" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-2" x2="24" xlink:href="#linear-gradient" y1="24.921"
                        y2="26.96" />
                    <linearGradient id="linear-gradient-3" x1="36" x2="36" xlink:href="#linear-gradient" y1="2.56"
                        y2="24.881" />
                    <linearGradient id="linear-gradient-4" x1="12" x2="12" xlink:href="#linear-gradient" y1="2.56"
                        y2="24.881" />
                    <linearGradient id="linear-gradient-5" gradientUnits="userSpaceOnUse" x1="34.5" x2="37.5" y1="15.5"
                        y2="15.5">
                        <stop offset="0" stop-color="#fed200" />
                        <stop offset="1" stop-color="#f59815" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-6" gradientUnits="userSpaceOnUse" x1="34.939" x2="37.061"
                        y1="21.439" y2="23.561">
                        <stop offset="0" stop-color="#6fc6fc" />
                        <stop offset="1" stop-color="#50a7f6" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-7" gradientUnits="userSpaceOnUse" x1="38.439" x2="40.561"
                        y1="17.939" y2="20.061">
                        <stop offset="0" stop-color="#34ca82" />
                        <stop offset="1" stop-color="#37a477" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-8" gradientUnits="userSpaceOnUse" x1="31.439" x2="33.561"
                        y1="17.939" y2="20.061">
                        <stop offset="0" stop-color="#e85155" />
                        <stop offset="1" stop-color="#c21d2c" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-9" gradientUnits="userSpaceOnUse" x1="8.468" x2="15.316"
                        y1="15.468" y2="22.316">
                        <stop offset="0" stop-color="#edf1f2" />
                        <stop offset="1" stop-color="#c6cbcc" />
                    </linearGradient>
                    <path
                        d="m42.059 40c-3.252 0-7.162-3.224-10.812-9h-14.494c-4.237 6.706-8.824 9.973-12.323 8.75a5.5 5.5 0 0 1 -3.077-3.056c-2.215-4.646-1.653-13.749 1.373-22.137a10.049 10.049 0 0 1 15.443-4.557h11.662a10.049 10.049 0 0 1 15.443 4.557c3.024 8.388 3.588 17.491 1.373 22.137a5.5 5.5 0 0 1 -3.077 3.056 4.555 4.555 0 0 1 -1.511.25z"
                        fill="url(#linear-gradient)" />
                    <path d="m26 27h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2z" fill="url(#linear-gradient-2)" />
                    <circle cx="36" cy="19" fill="url(#linear-gradient-3)" r="7.5" />
                    <circle cx="12" cy="19" fill="url(#linear-gradient-4)" r="7" />
                    <circle cx="36" cy="15.5" fill="url(#linear-gradient-5)" r="1.5" />
                    <circle cx="36" cy="22.5" fill="url(#linear-gradient-6)" r="1.5" />
                    <circle cx="39.5" cy="19" fill="url(#linear-gradient-7)" r="1.5" />
                    <circle cx="32.5" cy="19" fill="url(#linear-gradient-8)" r="1.5" />
                    <path
                        d="m15.5 17.5h-2v-2a1.5 1.5 0 0 0 -3 0v2h-2a1.5 1.5 0 0 0 0 3h2v2a1.5 1.5 0 0 0 3 0v-2h2a1.5 1.5 0 0 0 0-3z"
                        fill="url(#linear-gradient-9)" />
                </svg>
	';
}
if ($template_id == 'tetris_game') {
    $modal_name = '게임';
    $modal_icon = '
           <svg id="Layer_1" height="100%" viewBox="0 0 48 48" width="100%"
                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" data-name="Layer 1">
                    <linearGradient id="linear-gradient" gradientUnits="userSpaceOnUse" x1="24" x2="24" y1="9.126"
                        y2="40.022">
                        <stop offset="0" stop-color="#3e4154" />
                        <stop offset="1" stop-color="#1b2129" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-2" x2="24" xlink:href="#linear-gradient" y1="24.921"
                        y2="26.96" />
                    <linearGradient id="linear-gradient-3" x1="36" x2="36" xlink:href="#linear-gradient" y1="2.56"
                        y2="24.881" />
                    <linearGradient id="linear-gradient-4" x1="12" x2="12" xlink:href="#linear-gradient" y1="2.56"
                        y2="24.881" />
                    <linearGradient id="linear-gradient-5" gradientUnits="userSpaceOnUse" x1="34.5" x2="37.5" y1="15.5"
                        y2="15.5">
                        <stop offset="0" stop-color="#fed200" />
                        <stop offset="1" stop-color="#f59815" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-6" gradientUnits="userSpaceOnUse" x1="34.939" x2="37.061"
                        y1="21.439" y2="23.561">
                        <stop offset="0" stop-color="#6fc6fc" />
                        <stop offset="1" stop-color="#50a7f6" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-7" gradientUnits="userSpaceOnUse" x1="38.439" x2="40.561"
                        y1="17.939" y2="20.061">
                        <stop offset="0" stop-color="#34ca82" />
                        <stop offset="1" stop-color="#37a477" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-8" gradientUnits="userSpaceOnUse" x1="31.439" x2="33.561"
                        y1="17.939" y2="20.061">
                        <stop offset="0" stop-color="#e85155" />
                        <stop offset="1" stop-color="#c21d2c" />
                    </linearGradient>
                    <linearGradient id="linear-gradient-9" gradientUnits="userSpaceOnUse" x1="8.468" x2="15.316"
                        y1="15.468" y2="22.316">
                        <stop offset="0" stop-color="#edf1f2" />
                        <stop offset="1" stop-color="#c6cbcc" />
                    </linearGradient>
                    <path
                        d="m42.059 40c-3.252 0-7.162-3.224-10.812-9h-14.494c-4.237 6.706-8.824 9.973-12.323 8.75a5.5 5.5 0 0 1 -3.077-3.056c-2.215-4.646-1.653-13.749 1.373-22.137a10.049 10.049 0 0 1 15.443-4.557h11.662a10.049 10.049 0 0 1 15.443 4.557c3.024 8.388 3.588 17.491 1.373 22.137a5.5 5.5 0 0 1 -3.077 3.056 4.555 4.555 0 0 1 -1.511.25z"
                        fill="url(#linear-gradient)" />
                    <path d="m26 27h-4a1 1 0 0 1 0-2h4a1 1 0 0 1 0 2z" fill="url(#linear-gradient-2)" />
                    <circle cx="36" cy="19" fill="url(#linear-gradient-3)" r="7.5" />
                    <circle cx="12" cy="19" fill="url(#linear-gradient-4)" r="7" />
                    <circle cx="36" cy="15.5" fill="url(#linear-gradient-5)" r="1.5" />
                    <circle cx="36" cy="22.5" fill="url(#linear-gradient-6)" r="1.5" />
                    <circle cx="39.5" cy="19" fill="url(#linear-gradient-7)" r="1.5" />
                    <circle cx="32.5" cy="19" fill="url(#linear-gradient-8)" r="1.5" />
                    <path
                        d="m15.5 17.5h-2v-2a1.5 1.5 0 0 0 -3 0v2h-2a1.5 1.5 0 0 0 0 3h2v2a1.5 1.5 0 0 0 3 0v-2h2a1.5 1.5 0 0 0 0-3z"
                        fill="url(#linear-gradient-9)" />
                </svg>
	';
}
if ($template_id == 'folder') {
    $modal_name = '관리 폴더';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_game_setting') {
    $modal_name = '게임 추가';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_game_setting') {
    $modal_name = '게임 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_tier_setting') {
    $modal_name = '티어 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_tier_setting') {
    $modal_name = '티어 추가';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit2_tier_setting') {
    $modal_name = '티어 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_position_setting') {
    $modal_name = '포지션 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit2_position_setting') {
    $modal_name = '포지션 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_character_setting') {
    $modal_name = '캐릭터 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit2_character_setting') {
    $modal_name = '캐릭터 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_user_setting') {
    $modal_name = '회원 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_user_setting') {
    $modal_name = '회원 추가';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_teacher_setting') {
    $modal_name = '코치 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_teacher_setting') {
    $modal_name = '코치 추가';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_review_setting') {
    $modal_name = '리뷰 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_plan_setting') {
    $modal_name = '수업 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_coupon_setting') {
    $modal_name = '쿠폰 추가';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_coupon_setting') {
    $modal_name = '쿠폰 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_point_setting') {
    $modal_name = '포인트 추가';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_point_setting') {
    $modal_name = '포인트 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_influencer_setting') {
    $modal_name = '인플루언서 추가';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_influencer_setting') {
    $modal_name = '인플루언서 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_faq_setting') {
    $modal_name = '자주하는질문 추가';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_faq_setting') {
    $modal_name = '자주하는질문 수정';
    $modal_icon = '
          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_banner_setting') {
    $modal_name = '배너 추가';
    $modal_icon = '

          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_banner_setting') {
    $modal_name = '배너 수정';
    $modal_icon = '


          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'add_terms_setting') {
    $modal_name = '약관 추가';
    $modal_icon = '



          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'edit_terms_setting') {
    $modal_name = '약관 수정';
    $modal_icon = '



          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}
if ($template_id == 'column_banner') {
    $modal_name = '배너 칼럼 설정';
    $modal_icon = '



          <svg class="svg_shadow" height="100%" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg">
            <g id="Folder">
                <path
                    d="m28 5h-12.86a1 1 0 0 0 -1 1 1.017 1.017 0 0 0 .1065.4492c.0107.023.0224.0449.0351.0669l2.563 4.4854a2.0115 2.0115 0 0 0 1.7354.9985h12.42a1 1 0 0 0 1-1v-2a4.0042 4.0042 0 0 0 -4-4z"
                    fill="#ffb125" />
                <path
                    d="m32 10-13.4219.0042-2.5444-4.4529c-.0078-.0161-.0166-.0323-.0259-.0479a4.9941 4.9941 0 0 0 -4.3278-2.5034h-8.68a3 3 0 0 0 -3 3v20a3 3 0 0 0 3 3h26a3 3 0 0 0 3-3z"
                    fill="#fcd354" />
            </g>
        </svg>
	';
}


//이 아래로는 건드릴 필요 없음.
?>

<div id="<?php echo $template_id_box; ?>"
    class="position2 setting_box cf_<?php echo $template_id; ?> display_off z-index_5" data-top="0%" data-left="0%">
    <div class="display_off" egb:style="
        .content_box{box-shadow:0 4px 16px 0 #00000099; box-sizing: border-box;}
        .egb_setting_content{width: 100%; height: calc(100% - 45px);}
        .resize_border{width: 10px; height: 10px; background: #f9f9f9; position: absolute; right: 0;bottom: 0; cursor: se-resize; z-index: 7;}
        .close_setting_box{cursor: pointer;}
        .fullwindow{position: fixed !important; top: 50px !important; left: 0 !important; width: calc(100% - 50px) !important; height: calc(100% - 50px) !important; transition: top 0.2s ease-in-out, left 0.2s ease-in-out, width 0.2s ease-in-out, height 0.2s ease-in-out;}
        .content_box_size{height: calc(100% - 45px);}
        .scrollbar::-webkit-scrollbar-track{border-radius: 10px; -webkit-box-shadow: inset 0 0 6px #ffffffff; background-color: transparent; padding-top: 3px; padding-bottom: 3px;}
        .scrollbar::-webkit-scrollbar{width: 5px; border-radius: 10px; background-color: transparent; padding-top: 3px; padding-bottom: 3px;}
        .scrollbar::-webkit-scrollbar-thumb{border-radius: 10px; -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3); background-color: #E8E8EB; padding-top: 3px; padding-bottom: 3px;}
        .no_scroll{align-content: flex-start; -webkit-user-select: none !important; -moz-user-select: none !important; -ms-user-select: none !important; user-select: none !important;}
    "></div>
    <section id="<?php echo $template_id_menu; ?>"
        class="position3 width_px_1000 height_px_700 min_width_700 min_height_510 border_be-a_001 border_bre-a_008 z-index_5 menu_box content_box admin_setting_box"
        data-bd-a-color="#f2f2f2" data-bg-color="#fbfbfb" data-top="15%" data-left="10%">
        <div class="width_box height_px_045 flex_xs1_yc font_px_014 fontstyle1 padding_px-x_010 padding_px-y_008 border_px-u_001 menu_box"
            data-bd-a-color="#e9e9e9">
            <div class="flex_fl_yc no_scroll">
                <div class="width_px_030 height_px_030 margin_px-r_005">
                    <?php echo $modal_icon; ?>
                </div>
                <div><?php echo $modal_name; ?></div>
            </div>
            <div class="flex_fl_yc">
                <div class="flex_xc_yc width_px_026 height_px_026">
                    <div id="<?php echo $template_id_min; ?>"
                        class="border_bre-a_015 width_px_015 height_px_015 pointer hidewindow_button"
                        data-bg-color="#ffa500aa" title="숨기기"></div>
                </div>
                <div class="flex_xc_yc width_px_026 height_px_026">
                    <div id="<?php echo $template_id_max; ?>"
                        class="border_bre-a_015 width_px_015 height_px_015 pointer min_maxwindow_button"
                        data-bg-color="#00ff00aa" title="화면크기변환"></div>
                </div>
                <div class="flex_xc_yc width_px_026 height_px_026"
                    egb:click="egbToggle(<?php echo $template_id_box; ?>, display_off);">
                    <div id="<?php echo $template_id_close; ?>"
                        class="border_bre-a_015 width_px_015 height_px_015 pointer close_setting_box"
                        data-bg-color="#ff0000aa" title="닫기">
                    </div>
                </div>
            </div>
        </div>
        <div id="<?php echo $template_id_contents_box; ?>" class="content_box_size">

        </div>
        <div class="resize_border width_px_010 height_010" data-bg-color="#d9d9d9"></div>
    </section>
</div>
<div class="display_off"
    egb:function="egbT('<?php echo $template_id_contents_box; ?>', 'id=<?php echo $template_id_contents; ?>&path=/contents_box&template_id=<?php echo $template_id; ?>')">
</div>
<script nonce="<?php echo NONCE; ?>">
    document.addEventListener('mousedown', function (e) {
        const isResizeBorder = e.target.classList.contains('resize_border');
        const isSettingMenuDragDrop = e.target.classList.contains('setting_menu_drag_drop');
        const isMenuBox = e.target.closest('.menu_box');

        if ((isResizeBorder || isSettingMenuDragDrop) && !isMenuBox) {
            e.stopPropagation(); // 이벤트 전파 중지
        }
    });

    ['resize_border', 'setting_menu_drag_drop'].forEach(className => {
        document.querySelectorAll(`.${className}`).forEach(function (border) {
            border.addEventListener('mousedown', function (e) {
                e.stopPropagation(); // 드래그 방지
                isResizing = true; // 크기 조절 상태로 설정

                activeBox = e.target.closest('.admin_setting_box');
                if (activeBox) {
                    updateZIndex(activeBox.closest('.setting_box')); // z-index 업데이트
                }

                e.preventDefault(); // 기본 동작 방지
            });
        });
    });


</script>