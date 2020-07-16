<?php


namespace Modules\Admin\core\Services;


use Modules\Admin\core\Repositories\IEloquentRepository;
use Modules\Admin\core\Repositories\IProductRepository;
use Modules\Admin\core\Repositories\ProductRepository;

class ProductService extends EloquentService implements IProductService
{
    public function getIRepository()
    {
        // TODO: Implement getIRepository() method.
        return \Modules\Admin\core\Repositories\IProductRepository::class;
    }
    public function getAllDeleted(){
        return $this->model->getAllDeleted();
    }
    public function uploadImage($image,$currentPhoto = false){
        return $this->model->uploadImage($image,$currentPhoto);
    }
    public function recovery($id){
        return $this->model->recovery($id);
    }
}