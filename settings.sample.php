<?php

/* 
 * Some variables
 */

$api_base = "https://ws.monechelle.com/?login=%APIUSER%&password=%APIPASS%&method=get_orders";
$api_user = "";
$api_pass = "";

$api_url = str_replace("%APIUSER%", $api_user, $api_base);
$api_url = str_replace("%APIPASS%", $api_pass, $api_url);

$csvPath = "..\manomanoOrder.csv";
$datePath = "date.txt";

date_default_timezone_set('Europe/Berlin');

$lastDate = readDate($datePath);
$lastDateStr = $lastDate->format('Y-m-d H:i:s');




function readDate($datePath){
    $datetime = file_get_contents($datePath); 
    $date = new DateTime($datetime);
    return $date;
}