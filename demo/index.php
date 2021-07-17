<?php
require_once '../vendor/autoload.php';

use tkmatch\Main;

$wordData = [
    ['word' => '信息时代', 'url' => 'www.baidu.com'],
    ['word' => '竞争中的地位', 'url' => 'www.google.com'],
    ['word' => '在高中历', 'url' => 'www.google.com'],
    ['word' => '创新能力', 'url' => 'www.google.com'],
    // ['word' => '创新', 'url' => 'www.baidu.com'],
    ['word' => '药物', 'url' => 'www.baidu.com'],
    ['word' => '技术', 'url' => 'www.baidu.com'],
];

$lib     = new Main();
$content = file_get_contents('./news.html');
$content = '技术药物技术';
$test    = $lib::init()->setTree($wordData)->replace($content, 'target="_blank"', 1);
// var_dump($lib::init()->setTree($wordData));

var_dump($lib::init()->setTree($wordData)->getTagWord($content));
//var_dump($lib::init()->setTree($wordData));exit;
echo $test;
