<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-04-07
 * Time: 18:07
 */

function callback($buffer)
{
    // replace all the apples with oranges
    return (str_replace("apples", "oranges", $buffer));
}

ob_start("callback");

?>
    <html>
    <body>
    <p>It's like comparing apples to oranges.</p>
    </body>
    </html>
<?php

ob_end_flush();

