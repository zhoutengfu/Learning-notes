<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-26
 * Time: 20:46
 */
namespace Factory;

use Export\ExportFileApi;

abstract class ExportOperate
{
    public function export(string $data)
    {
        $obj = $this->factoryMethod();
        $obj->export($data);
    }

    abstract function factoryMethod(): ExportFileApi;
}