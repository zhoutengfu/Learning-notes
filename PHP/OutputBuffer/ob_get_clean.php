<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-07
 * Time: 19:25
 */


//ob_start();
//
//echo "Hello World\n";
//
//$out = ob_get_clean();
//
//var_dump($out);
//
//echo "Hello World222\n";
//
//$out = ob_get_clean();
//var_dump($out);


ob_start();

echo "Hello World\n";

$out = ob_get_clean();

var_dump($out);

ob_start();
echo "Hello World222\n";

$out = ob_get_clean();
var_dump($out);