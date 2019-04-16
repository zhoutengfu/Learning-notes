<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-16
 * Time: 22:09
 */
$arr = [1, 2, 3];
list($a, $b, $c) = $arr;

//这里的[]并不是数组的意思，只是list的简略形式
[$d, $e, $f] = $arr;

var_dump($a, $b, $c, $d, $e, $f);
