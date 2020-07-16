<?php


namespace Modules\Admin\core\Repositories;


class ThanhToanRepository extends EloquentRepository implements IThanhToanRepository
{
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return \Modules\Admin\Entities\ThanhToan::class;
    }
}