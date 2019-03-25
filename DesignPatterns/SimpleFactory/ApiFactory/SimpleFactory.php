<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-25
 * Time: 23:43
 */

namespace ApiFactory;

class SimpleFactory
{
    /**
     * @param string $string
     * @return ImplA|ImplB
     */
    public function create(string $string)
    {
        if ($string == 'A') {
            return new ImplA();
        } else {
            return new ImplB();
        }
    }
}