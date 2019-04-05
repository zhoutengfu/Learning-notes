<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-05
 * Time: 20:00
 */

require_once './SessionHandlerDb.php';
$CustomSession = new SessionHandlerDb;
ini_set('session.save_handler', 'user');
session_set_save_handler($CustomSession, true);

//var_dump(ini_get('session.gc_probability'));
//var_dump(ini_get('session.gc_divisor'));
//var_dump(ini_set('session.gc_divisor', 1));

session_start();
$_SESSION['username'] = '周藤福';
$_SESSION['age'] = 26;
$_SESSION['email'] = '931945321@qq.com';

var_dump($_SESSION);
session_write_close();
