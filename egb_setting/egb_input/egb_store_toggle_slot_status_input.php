<?php
$uniq_id = egb('uniq_id', 'toggle_slot_status_1');
$weekday = egb('weekday', 'toggle_slot_status_2'); 
$time = egb('time', 'toggle_slot_status_3');
$request_page = egb('request_page', 'toggle_slot_status_4');

$result = egb_store_toggle_slot_status($uniq_id, $weekday, $time);

if ($result) {
    echo json_encode([
        'success' => true, 
        'successCode' => 'toggle_slot_status_1',
        'request_page' => $request_page,
        'weekday' => $weekday,
        'time' => $time
    ]);
} else {
    echo json_encode([
        'success' => false,
        'failureCode' => 'toggle_slot_status_5'
    ]);
}
?>
