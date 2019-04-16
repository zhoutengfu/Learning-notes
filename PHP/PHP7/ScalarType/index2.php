<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-16
 * Time: 21:26
 */

//当开始严格模式后，代码会直接报错
declare(strict_types=1);
function sumOfInts(int ...$ints)
{
    return array_sum($ints);
}

var_dump(sumOfInts(2, '3.1', 4));