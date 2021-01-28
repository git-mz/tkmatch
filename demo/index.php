<?php

require_once './lib.php';
use dfa\Lib;

$start    = microtime(true);
$wordPool = file_get_contents('./keyWord.txt');
$wordData = explode(',', $wordPool);
$wordData = [
    ['word' => '信息时代', 'url' => 'www.baidu.com'],
    ['word' => '创新能力', 'url' => 'www.google.com'],
    ['word' => '竞争中的地位', 'url' => 'www.google.com'],
    ['word' => '在高中历', 'url' => 'www.google.com'],
    ['word' => '创新能力', 'url' => 'www.google.com'],
    ['word' => '创新能力', 'url' => 'www.google.com'],
];

$lib     = new Lib();
$content = file_get_contents('./news.html');
$test    = $lib::init()
    ->setTree($wordData)
    ->replace($content);
// ->getBadWord($content);
var_dump('======' . $test);
$end     = microtime(true);
$alltime = $end - $start;
var_dump($test);
var_dump($alltime);
exit;
