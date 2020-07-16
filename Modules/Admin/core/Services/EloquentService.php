<?php


namespace Modules\Admin\core\Services;


use Modules\Admin\core\Repositories\IEloquentRepository;
use Modules\Admin\core\Repositories\IProductRepository;

abstract class EloquentService
{
    protected $model;
    public function __construct()
    {
        $this->setIRepository();
    }
    public function setIRepository(){
        $this->model = app()->make(
          $this->getIRepository()
        );
    }
    public abstract function getIRepository();
    public function paginate($number)
    {
        // TODO: Implement paginate() method.
        return $this->model->paginate($number);
    }
    public function show($id)
    {
        // TODO: Implement show() method.
        return $this->model->show($id);
    }
    public function store($data)
    {
        // TODO: Implement store() method.
        return $this->model->store($data);
    }
    public function update($id, $data)
    {
        // TODO: Implement update() method.
        return $this->model->update($id,$data);
    }
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
        return $this->model->destroy($id);
    }
    public function getAll(){
        return $this->model->getAll();
    }
    public function getAllLoaiSP(){
        return $this->model->getAllLoaiSP();
    }
    public function getAllThuongHieu(){
        return $this->model->getAllThuongHieu();
    }
}