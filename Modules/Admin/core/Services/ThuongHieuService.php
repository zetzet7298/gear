<?php


namespace Modules\Admin\core\Services;


class ThuongHieuService extends EloquentService implements IThuongHieuService
{
    public function getIRepository()
    {
        // TODO: Implement getIRepository() method.
        return \Modules\Admin\core\Repositories\IThuongHieuRepository::class;
    }
}