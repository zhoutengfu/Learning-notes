<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-16
 * Time: 21:28
 */

//当对函数返回值声明，可以定义其返回值为void。无论是否开启严格模式，只要函数中"return;"以外的return语句都会报错
//测试不返回也符合要求
declare(strict_types=1);
function sumOfInts(int ...$ints) :void
{
//    return;
}

var_dump(sumOfInts(2, 3, 4));