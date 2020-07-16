<?php


namespace Modules\Admin\core\Services;


class LoaiSPService extends EloquentService implements ILoaiSPService
{

    public function getIRepository()
    {
        // TODO: Implement getIRepository() method.
        return \Modules\Admin\core\Repositories\ILoaiSPRepository::class;
    }

}