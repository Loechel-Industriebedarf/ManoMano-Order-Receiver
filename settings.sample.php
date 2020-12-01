<?php

/* 
 * Some variables
 */

$api_base = "https://ws.monechelle.com/?login=%APIUSER%&password=%APIPASS%&method=get_orders";
$api_base_accept = "https://ws.monechelle.com/?login=%APIUSER%&password=%APIPASS%&method=accept_order&order_ref=%ORDERREF%";
$api_user = "";
$api_pass = "";

$api_url = str_replace("%APIUSER%", $api_user, $api_base);
$api_url = str_replace("%APIPASS%", $api_pass, $api_url);

$api_url_accept = str_replace("%APIUSER%", $api_user, $api_base_accept);
$api_url_accept = str_replace("%APIPASS%", $api_pass, $api_url_accept);

$csvPath = "..\manomanoOrder.csv";
$datePath = "date.txt";

date_default_timezone_set('Europe/Berlin');