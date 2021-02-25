<?php

require_once '../vendor/autoload.php';

use tkmatch\Main;

$wordData = [
     ['word' => '信息时代', 'url' => 'www.baidu.com'],
     ['word' => '竞争中的地位', 'url' => 'www.google.com'],
     ['word' => '在高中历', 'url' => 'www.google.com'],
     ['word' => '创新能力', 'url' => 'www.google.com'],
     ['word' => '创新', 'url' => 'www.baidu.com'],
];

$lib     = new Main();
$content = file_get_contents('./news.html');
//$content = '创新能力创新哟v创新创新能力';
// $test    = $lib::init()->setTree($wordData)->replace($content);
// var_dump($lib::init()->setTree($wordData));

var_dump($lib::init()->setTree($wordData)->getTagWord($content));exit;
//var_dump($lib::init()->setTree($wordData));exit;
echo $test;
