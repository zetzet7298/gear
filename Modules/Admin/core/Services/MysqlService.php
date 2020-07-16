<?php


namespace Modules\Admin\core\Services;


class MysqlService extends EloquentService implements IMysqlService
{
    public function getIRepository()
    {
        return \Modules\Admin\core\Repositories\IMysqlRepository::class;
    }
}