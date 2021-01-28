<?php

require_once '../vendor/autoload.php';

use tkmatch\Main;

$wordData = [
    ['word' => '信息时代', 'url' => 'www.baidu.com'],
    ['word' => '竞争中的地位', 'url' => 'www.google.com'],
    ['word' => '在高中历', 'url' => 'www.google.com'],
    ['word' => '创新能力', 'url' => 'www.google.com'],
];

$lib     = new Main();
$content = file_get_contents('./news.html');
$test    = $lib::init()->setTree($wordData)->replace($content);
echo $test;
