<?php


namespace Modules\Admin\core\Repositories;


class ThuongHieuRepository extends EloquentRepository implements IThuongHieuRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return \Modules\Admin\Entities\ThuongHieu::class;
    }
}