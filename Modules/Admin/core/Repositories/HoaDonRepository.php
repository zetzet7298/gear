<?php


namespace Modules\Admin\core\Repositories;


use Modules\Admin\core\Services\EloquentService;

class HoaDonRepository extends EloquentRepository implements IHoaDonRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return \Modules\Admin\Entities\HoaDon::class;
    }

    public function getAll()
    {
        return $this->model
            ->join('thanhtoan','thanhtoan.MaHD','hoadon.MaHD')
            ->where('hoadon.deleteFlag','=',0)
            ->orderBy('NgayThanhToan','desc')
            ->get()->toArray();
    }

    public function show($id)
    {
            $result = $this->model
            ->where('hoadon.MaHD',$id)
            ->join('users','users.id','=','hoadon.MaKH')
            ->get()->toArray();
        return $result[0];
    }
}