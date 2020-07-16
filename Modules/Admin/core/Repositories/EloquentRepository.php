<?php


namespace Modules\Admin\core\Repositories;


abstract class EloquentRepository implements IEloquentRepository
{
    protected $model;
    public function __construct()
    {
        $this->setModel();
    }
    public function setModel(){
        $this->model = app()->make(
            $this->getModel()
        );
    }
    abstract public function getModel();
    public function paginate($number)
    {
        // TODO: Implement paginate() method.
        return $this->model->paginate($number)->toArray();
    }
    public function show($id)
    {
        // TODO: Implement show() method.
        return $this->model->find($id)->toArray();
    }
    public function store($data)
    {
        // TODO: Implement store() method.
        return $this->model->create($data);
    }
    public function update($id,$data)
    {
        // TODO: Implement update() method.
        return $this->model->where('MaSP',$id)->update($data);
    }
    public function destroy($id)
    {
        // TODO: Implement destroy() method.
        //$model = $this->model->show($id);
        return $this->model->find($id)->update(['deleteFlag'=>1]);
    }
    public function getAll()
    {
        // TODO: Implement getAll() method.
        return $this->model
            ->where('deleteFlag','=',0)
            ->get()->toArray();
    }
    public function getAllLoaiSP()
    {
        // TODO: Implement getAllLoaiSP() method.
        return $this->model
            ->all()->toArray();
    }
    public function getAllThuongHieu()
    {
        // TODO: Implement getAllLoaiSP() method.
        return $this->model
            ->all()->toArray();
    }
}