<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-16
 * Time: 21:33
 */

//PHP7.1.0对参数类型和返回值类型还有进一步的支持,其类型可以是可空类型,在参数或返回值类型声明前边加上"？,表示返回值要么是null，要么是声明的类型以下内容
declare(strict_types=1);
function sumOfInts(?int $a): ?int
{
    return $a;
}

var_dump(sumOfInts(2));
var_dump(sumOfInts(null));