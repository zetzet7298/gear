<?php


namespace Modules\Admin\core\Repositories;


interface IProductCacheRepository
{
    public function saveAllToRedis();
}