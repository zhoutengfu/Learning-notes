<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-16
 * Time: 21:57
 */
//在PHP 7之前，我们需要动态地给一个对象添加方法时，可以通过Closure来复制一个闭包对象，并绑定到一个$this对象和类作用域

class Test{
    private $num = 1;
}
$f = function (){
    return $this->num +1;
};

$test = $f->bindTo(new Test,'Test');
echo $test();

var_dump($test);