<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-26
 * Time: 20:49
 */
namespace Factory;

use Export\ExportFileApi;
use Export\ExportTxtFile;

class ExportTxtFileOperate extends ExportOperate
{
    public function factoryMethod(): ExportFileApi
    {
        return new ExportTxtFile();
    }
}