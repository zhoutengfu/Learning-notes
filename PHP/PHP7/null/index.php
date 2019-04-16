<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-16
 * Time: 21:38
 */
//PHP 7提供了一个新的语法糖“??”，如果变量存在且值不为null，它会返回自身的值，否则返回它的第二个操作数。可以这样改写代码
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$page = $_GET['page'] ?? 0;
