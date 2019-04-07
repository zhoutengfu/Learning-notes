<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-07
 * Time: 20:02
 */

if (ob_get_level() == 0) ob_start();

for ($i = 0; $i<10; $i++){

    echo "<br> Line to show.";
    echo str_pad('',4096)."\n";

    //ob_flush();
    flush();
    sleep(2);
}

echo "Done.";

ob_end_flush();