
<?php
$uniq_id = egb('uniq_id', 'update_slot_count_1');
$weekday = egb('weekday', 'update_slot_count_2');
$time = egb('time', 'update_slot_count_3'); 
$count = egb('count', 'update_slot_count_4');
$request_page = egb('request_page', 'update_slot_count_5');

$result = egb_store_update_slot_count($uniq_id, $weekday, $time, $count);

if ($result) {
    echo json_encode([
        'success' => true,
        'successCode' => 'update_slot_count_1',
        'request_page' => $request_page,
        'weekday' => $weekday,
        'time' => $time,
        'count' => $count
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'failureCode' => 'update_slot_count_6'
    ]);
}
?>
