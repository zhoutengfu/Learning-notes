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
     * @return Api
     */
    public function create(string $string): Api
    {
        if ($string == 'A') {
            return new ImplA();
        } else {
            return new ImplB();
        }
    }
}