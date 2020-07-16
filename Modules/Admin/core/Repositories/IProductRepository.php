<?php


namespace Modules\Admin\core\Repositories;


interface IProductRepository
{
    //Phuong thuc rieng viet o day
    public function getAllDeleted();
    public function uploadImage($image,$currentPhoto);
    public function recovery($id);
}