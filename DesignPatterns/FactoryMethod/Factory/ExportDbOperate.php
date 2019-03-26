<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-26
 * Time: 20:54
 */
namespace Factory;

use Export\ExportDb;
use Export\ExportFileApi;

class ExportDbOperate extends ExportOperate
{
    public function factoryMethod(): ExportFileApi
    {
        return new ExportDb();
    }
}