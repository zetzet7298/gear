<?php


namespace Modules\Admin\core\Services;


interface IProductESService
{
    public function saveAllToES();
    public function search($params);
}