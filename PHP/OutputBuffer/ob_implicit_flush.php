<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-07
 * Time: 20:05
 */

//ob_implicit_flush();
//for($i = 0; $i < 10; $i++)
//{
//    echo "$i\n";
//    sleep(1);
//}


//for ($i = 0; $i < 10; $i++)
//{
//    echo "$i\n";
//    flush();
//    sleep(1);
//}

//ob_end_flush();
//ob_implicit_flush();
//for ($i = 0; $i < 10; $i++)
//{
//    echo "$i\n";
//    sleep(1);
//}

ob_end_flush();
ob_implicit_flush(true);
for ($i=10; $i>0; $i--)
{
    echo $i;
    sleep(1);
}