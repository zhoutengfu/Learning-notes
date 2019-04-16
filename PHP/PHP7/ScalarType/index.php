<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-16
 * Time: 21:19
 */

//默认模式下，当传入的参数不符合声明类型时，会首先尝试转换类型

function sumOfInts(int ...$ints)
{
    return array_sum($ints);
}

var_dump(sumOfInts(2, '3.1', 4));

