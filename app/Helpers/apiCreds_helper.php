<?php

helper('date');

function generateAPIUsername()
{
    $currentTimestamp = now('Asia/Singapore');
    $currentDateTime = date('dmyCH', $currentTimestamp);
    return "tesprogrammer$currentDateTime";
}
function generateAPIPassword()
{
    $currentTimestamp = now('Asia/Singapore');
    $day = date('d', $currentTimestamp);
    $month = date('m', $currentTimestamp);
    $year = date('y', $currentTimestamp);
    $returnString = "bisacoding-$day-$month-$year";
    return ['raw' => $returnString, 'hashed' => md5($returnString)];
}
