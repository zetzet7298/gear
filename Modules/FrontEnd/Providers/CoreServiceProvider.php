<?php

namespace Modules\FrontEnd\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\core\Repositories\CTHoaDonRepository;
use Modules\Admin\core\Repositories\EloquentRepository;
use Modules\Admin\core\Repositories\HoaDonRepository;
use Modules\Admin\core\Repositories\ICTHoaDonRepository;
use Modules\Admin\core\Repositories\IEloquentRepository;
use Modules\Admin\core\Repositories\IHoaDonRepository;
use Modules\Admin\core\Repositories\ILoaiSPRepository;
use Modules\Admin\core\Repositories\IProductCacheRepository;
use Modules\Admin\core\Repositories\IProductESReposiroty;
use Modules\Admin\core\Repositories\IProductRepository;
use Modules\Admin\core\Repositories\IThanhToanRepository;
use Modules\Admin\core\Repositories\IThuongHieuRepository;
use Modules\Admin\core\Repositories\LoaiSPRepository;
use Modules\Admin\core\Repositories\ProductCacheRepository;
use Modules\Admin\core\Repositories\ProductESRepository;
use Modules\Admin\core\Repositories\ProductRepository;
use Modules\Admin\core\Repositories\ThanhToanRepository;
use Modules\Admin\core\Repositories\ThuongHieuRepository;
use Modules\Admin\core\Services\CTHoaDonService;
use Modules\Admin\core\Services\HoaDonService;
use Modules\Admin\core\Services\ICTHoaDonService;
use Modules\Admin\core\Services\IHoaDonService;
use Modules\Admin\core\Services\ILoaiSPService;
use Modules\Admin\core\Services\IProductCacheService;
use Modules\Admin\core\Services\IProductESService;
use Modules\Admin\core\Services\IProductService;
use Modules\Admin\core\Services\IThanhToanService;
use Modules\Admin\core\Services\IThuongHieuService;
use Modules\Admin\core\Services\ProductCacheService;
use Modules\Admin\core\Services\ProductService;
use Modules\Admin\core\Services\ThanhToanService;
use Modules\Admin\core\Services\ThuongHieuService;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(IEloquentRepository::class,EloquentRepository::class);
        $this->app->bind(IHoaDonRepository::class,HoaDonRepository::class);
        $this->app->bind(IHoaDonService::class,HoaDonService::class);
        $this->app->bind(ICTHoaDonRepository::class,CTHoaDonRepository::class);
        $this->app->bind(ICTHoaDonService::class,CTHoaDonService::class);
        $this->app->bind(IThanhToanRepository::class,ThanhToanRepository::class);
        $this->app->bind(IThanhToanService::class,ThanhToanService::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
