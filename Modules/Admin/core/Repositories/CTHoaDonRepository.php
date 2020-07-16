<?php


namespace Modules\Admin\core\Repositories;


class CTHoaDonRepository extends EloquentRepository implements IHoaDonRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return \Modules\Admin\Entities\CTHoaDon::class;
    }

    public function show($id)
    {
        return $this->model
            ->where('cthoadon.MaHD','=',$id)
            ->join('hoadon','hoadon.MaHD','=','cthoadon.MaHD')
            ->join('sanpham','sanpham.MaSP','=','cthoadon.MaSP')
            ->get()->toArray();
    }
}