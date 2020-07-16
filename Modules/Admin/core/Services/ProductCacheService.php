<?php


namespace Modules\Admin\core\Services;


use Modules\Admin\core\Repositories\IProductRepository;

class ProductCacheService extends EloquentService implements IProductCacheService
{
    public function getIRepository()
    {
        // TODO: Implement getIRepository() method.
        return \Modules\Admin\core\Repositories\IProductCacheRepository::class;
    }
    public function show($id)
    {
        // TODO: Implement getDetailProduct() method.
        return $this->model->show($id);
    }
    public function saveAllToRedis(){
        return $this->model->saveAllToRedis();
    }
}