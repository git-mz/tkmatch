<?php

$content = '你们快去挑战权威拉开水晶车丫=======拉开水晶撒打算大';

$str = '拉开水晶车';

$str = implode('-???-', preg_split('/(?<!^)(?!$)/u', $str));

var_dump($str);
exit;

$strarr = [
    '<a href="www.google.com">拉开水晶车</a>',
    'www.baidu.com',
];

$test = str_replace(['拉开水晶车', '拉开水晶'], $strarr, $content);
var_dump($test);
