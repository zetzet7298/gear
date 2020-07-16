<?php


namespace Modules\Admin\core\Services;


class CTHoaDonService extends EloquentService implements ICTHoaDonService
{
    public function getIRepository()
    {
        // TODO: Implement getIRepository() method.
        return \Modules\Admin\core\Repositories\ICTHoaDonRepository::class;
    }
}