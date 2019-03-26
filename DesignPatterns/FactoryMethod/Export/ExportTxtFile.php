<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-26
 * Time: 20:41
 */
namespace Export;

class ExportTxtFile implements ExportFileApi
{
    public function export($data)
    {
        echo "{$data}\n";
    }
}