<?php


namespace Modules\Admin\core\Services;


class HoaDonService extends EloquentService implements IHoaDonService
{
    public function getIRepository()
    {
        // TODO: Implement getIRepository() method.
        return \Modules\Admin\core\Repositories\IHoaDonRepository::class;
    }
}