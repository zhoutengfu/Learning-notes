<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-16
 * Time: 21:59
 */
class Test{
    private $num = 1;
}
$f = function (){
    return $this->num +1;
};

echo $f->call(new Test);
