<?php


namespace Modules\Admin\core\Services;


class ThanhToanService extends EloquentService implements IThanhToanService
{
    public function getIRepository()
    {
        // TODO: Implement getIRepository() method.
        return \Modules\Admin\core\Repositories\IThanhToanRepository::class;
    }
}