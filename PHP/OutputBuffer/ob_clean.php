<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-07
 * Time: 19:06
 */

ob_start();

echo "Hello ";
ob_clean();
$len1 = ob_get_length();

echo "World";

$len2 = ob_get_length();

ob_end_clean();

echo $len1 . "|" . $len2;