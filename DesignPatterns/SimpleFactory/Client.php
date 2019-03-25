<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-25
 * Time: 23:29
 */

use \ApiFactory\SimpleFactory;

function __autoload($className)
{
    if (file_exists('./' . str_replace('\\', '/', $className) . '.php')) {
        require_once './' . str_replace('\\', '/', $className) . '.php';
        return true;
    }
    return false;
}

$obj = new SimpleFactory();
$ImplA = $obj->create('A');
$ImplA->operation('我是A啊');

$ImplB = $obj->create('B');
$ImplB->operation('我是B啊');

