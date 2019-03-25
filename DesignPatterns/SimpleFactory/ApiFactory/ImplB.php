<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-25
 * Time: 23:27
 */
namespace ApiFactory;

include_once 'Api.php';
class ImplB implements Api
{
    public function operation(string $string)
    {
        echo "ImplB:$string\n";
    }
}