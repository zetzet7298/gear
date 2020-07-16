<?php


namespace Modules\Admin\core\Repositories;


class LoaiSPRepository extends EloquentRepository implements ILoaiSPRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return \Modules\Admin\Entities\LoaiSanPham::class;
    }
}