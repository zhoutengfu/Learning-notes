<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-07
 * Time: 19:33
 */

ob_start();

echo "Hello ";

$out1 = ob_get_contents();

echo "World";

$out2 = ob_get_contents();

ob_end_clean();

var_dump($out1, $out2);