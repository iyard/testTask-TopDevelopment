<?php

$autoloadPath1 = __DIR__ . '/../../autoload.php';
$autoloadPath2 = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoloadPath1)) {
    require_once $autoloadPath1;
} else {
    require_once $autoloadPath2;
}

use App\YandexWheather;
use GuzzleHttp\Client;


$httpClient = new Client();
$yandexWheather = new YandexWheather($httpClient);
$weather = $yandexWheather->get('xml');
Log::file($weather);

