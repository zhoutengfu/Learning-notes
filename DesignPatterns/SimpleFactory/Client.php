<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-25
 * Time: 23:29
 */

use \ApiFactory\SimpleFactory;


include_once 'ApiFactory/SimpleFactory.php';
class Client
{
    public function main()
    {
        $obj = new SimpleFactory();
        $ImplA = $obj->create('A');
        $ImplA->operation('我是A啊');

        $ImplB = $obj->create('B');
        $ImplB->operation('我是A啊');
    }
}

$client = new Client();
$client->main();