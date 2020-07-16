<?php


namespace Modules\Admin\core\Services;


interface IProductService
{
    public function getAllDeleted();
    public function recovery($id);
}