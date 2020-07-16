<?php


namespace Modules\Admin\core\Services;


class ProductESService extends  EloquentService implements IProductESService
{
    public function getIRepository()
    {
        // TODO: Implement getIRepository() method.
        return \Modules\Admin\core\Repositories\IProductESReposiroty::class;
    }
    public function saveAllToES()
    {
        // TODO: Implement saveAllToES() method.
        return $this->model->saveAllToES();
    }
    public function search($params)
    {
        // TODO: Implement search() method.
        return $this->model->search($params);
    }
    public function productByLoaiSP($MaLoaiSP){
        return $this->model->productByLoaiSP($MaLoaiSP);
    }
}