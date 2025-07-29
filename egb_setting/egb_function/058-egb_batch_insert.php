<?php
// 3) 배치 INSERT 유틸
function egb_batch_insert($table, $rows) {
    if (empty($rows)) {
        return false;
    }

    $cols = array_keys($rows[0]);
    $placeholders = [];
    $params = [];

    foreach ($rows as $i => $row) {
        $ph = [];
        foreach ($cols as $col) {
            $key = ':' . $col . '_' . $i;
            $ph[] = $key;
            $params[$key] = $row[$col];
        }
        $placeholders[] = '(' . implode(', ', $ph) . ')';
    }

    $sql = sprintf(
        'INSERT INTO %s (%s) VALUES %s',
        $table,
        implode(', ', $cols),
        implode(', ', $placeholders)
    );

    $res = egb_sql([
        'sql'    => $sql,
        'params' => $params,
        'fetch'  => 2
    ]);

    return ($res !== false);
}
?>
