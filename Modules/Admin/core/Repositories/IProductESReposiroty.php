<?php


namespace Modules\Admin\core\Repositories;


interface IProductESReposiroty
{
    public function saveAllToES();
    public function search($params);
    public function productByLoaiSP($MaLoaiSP);
}