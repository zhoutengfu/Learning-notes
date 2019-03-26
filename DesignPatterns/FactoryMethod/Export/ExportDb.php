<?php
/**
 * Created by PhpStorm.
 * User: zhoutengfu
 * Date: 2019-03-26
 * Time: 20:45
 */
namespace Export;

class ExportDb implements ExportFileApi
{
    public function export($data)
    {
        echo "{$data}\n";
    }
}