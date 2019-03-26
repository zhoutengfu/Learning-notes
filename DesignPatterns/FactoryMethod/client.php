<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-26
 * Time: 18:48
 */

function __autoload($className)
{
    if (file_exists('./' . str_replace('\\', '/', $className) . '.php')) {
        require_once './' . str_replace('\\', '/', $className) . '.php';
        return true;
    }
    return false;
}

$exportTxtFileOperate= new \Factory\ExportTxtFileOperate();
$exportDbOperate = new \Factory\ExportDbOperate();


$exportTxtFileOperate->export('我想导入到txt file');
$exportDbOperate->export('我想导入到DB');