
<?php
$uniq_id = egb('uniq_id', 'store_add_holiday_1');
$holiday_date = egb('holiday_date', 'store_add_holiday_2');
$holiday_name = egb('holiday_name', 'store_add_holiday_3');

$result = egb_store_add_holiday($uniq_id, $holiday_date, $holiday_name);

if ($result) {
    echo json_encode([
        'success' => true,
        'successCode' => 'store_add_holiday_1',
        'holiday_date' => $holiday_date,
        'holiday_name' => $holiday_name,
        'uniq_id' => $uniq_id

    ]);
} else {
    echo json_encode([
        'success' => false,
        'failureCode' => 'store_add_holiday_4'
    ]);
}
?>
