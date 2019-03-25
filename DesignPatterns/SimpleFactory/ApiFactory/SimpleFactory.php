<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-25
 * Time: 23:43
 */

namespace ApiFactory;

include_once 'ImplA.php';
include_once 'ImplB.php';

class SimpleFactory
{
    public function create(string $string)
    {
        if ($string == 'A') {
            return new ImplA();
        } else {
            return new ImplB();
        }
    }
}