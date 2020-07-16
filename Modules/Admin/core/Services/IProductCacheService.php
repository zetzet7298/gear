<?php


namespace Modules\Admin\core\Services;


interface IProductCacheService
{
    public function saveAllToRedis();
}