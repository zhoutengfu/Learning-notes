<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-07
 * Time: 19:21
 */

//echo ob_get_level(),'<br/> ';
//ob_start();
//echo ob_get_level(),'<br/> ';
//ob_start();
//echo ob_get_level(),'<br/> ';
//
//$aa = ob_end_clean();
//
//echo ob_get_level(),'<br/> ';



echo ob_get_level(),'<br/> ';
ob_start();
echo ob_get_level(),'<br/> ';
ob_start();
echo ob_get_level(),'<br/> ';

ob_end_flush();
echo ob_get_level(),'<br/> ';