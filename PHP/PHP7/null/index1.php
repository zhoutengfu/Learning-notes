<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-16
 * Time: 21:43
 */

$_GET['page'] = 1;
$_POST['page'] = 2;
$page = $_GET['page']?? $_POST['page']?? 0;

echo $page;