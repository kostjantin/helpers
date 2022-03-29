<?php
function seconds_to_read_form($time) {
    $hours = floor($time / 3600);
    $minutes = floor(($time / 60) % 60);
    $seconds = $time % 60;
    $millisec = floor(($time - floor($time)) * 10000);

    return str_pad($hours, 2, '0', STR_PAD_LEFT)
        . ':' . str_pad($minutes, 2, '0', STR_PAD_LEFT)
        . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT)
        . '.' . str_pad($millisec, 4, '0', STR_PAD_LEFT);
}

function ld($string, $type='INFO') {
    static $uniqid = null;

    static $start_time = null;
    static $cur_time = null;
    $prev_time = null;

    static $first_memory = null;
    static $cur_memory = null;

    if (!$uniqid) {
        $uniqid = uniqid('', false);
    }

    if ($cur_time === null) {
        $prev_time = $start_time = microtime(true);
    }
    if ($cur_memory === null) {
        $first_memory = memory_get_usage();
    }

    if ($cur_time) {
        $prev_time = $cur_time;
    }
    $cur_time = microtime(true);
    $cur_memory = memory_get_usage();

    $date_time = (new DateTime())->format('Y-m-d H:i:s');

    $spent_time = seconds_to_read_form($cur_time - $start_time);
    $execution_time = seconds_to_read_form($cur_time - $prev_time);

    $mem_diff = number_format(($cur_memory - $first_memory)/(1024*1024), 6);

    echo "{$date_time} [{$type}] {$uniqid}\t{$spent_time} - {$execution_time}\t{$mem_diff}\t{$string}" . PHP_EOL;
}
