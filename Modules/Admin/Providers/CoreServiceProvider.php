<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admin\core\Repositories\CTHoaDonRepository;
use Modules\Admin\core\Repositories\EloquentRepository;
use Modules\Admin\core\Repositories\HoaDonRepository;
use Modules\Admin\core\Repositories\ICTHoaDonRepository;
use Modules\Admin\core\Repositories\IEloquentRepository;
use Modules\Admin\core\Repositories\IHoaDonRepository;
use Modules\Admin\core\Repositories\ILoaiSPRepository;
use Modules\Admin\core\Repositories\IMysqlRepository;
use Modules\Admin\core\Repositories\IProductCacheRepository;
use Modules\Admin\core\Repositories\IProductESReposiroty;
use Modules\Admin\core\Repositories\IProductRepository;
use Modules\Admin\core\Repositories\IThanhToanRepository;
use Modules\Admin\core\Repositories\IThuongHieuRepository;
use Modules\Admin\core\Repositories\LoaiSPRepository;
use Modules\Admin\core\Repositories\MySQLRepository;
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
use Modules\Admin\core\Services\IMysqlService;
use Modules\Admin\core\Services\IProductCacheService;
use Modules\Admin\core\Services\IProductESService;
use Modules\Admin\core\Services\IProductService;
use Modules\Admin\core\Services\IThanhToanService;
use Modules\Admin\core\Services\IThuongHieuService;
use Modules\Admin\core\Services\MysqlService;
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
        $this->app->bind(IProductRepository::class,ProductRepository::class);
        $this->app->bind(IProductService::class,ProductService::class);
        $this->app->bind(IProductService::class,ProductCacheRepository::class);
        $this->app->bind(IProductCacheService::class,ProductCacheService::class);
        $this->app->bind(IProductCacheRepository::class,ProductCacheRepository::class);
        $this->app->bind(IProductESReposiroty::class,ProductESRepository::class);
        $this->app->bind(IProductESService::class,IProductESService::class);
        $this->app->bind(ILoaiSPRepository::class,LoaiSPRepository::class);
        $this->app->bind(ILoaiSPService::class,ILoaiSPService::class);
        $this->app->bind(IThuongHieuRepository::class,ThuongHieuRepository::class);
        $this->app->bind(IThuongHieuService::class,ThuongHieuService::class);
        $this->app->bind(IHoaDonRepository::class,HoaDonRepository::class);
        $this->app->bind(IHoaDonService::class,HoaDonService::class);
        $this->app->bind(ICTHoaDonRepository::class,CTHoaDonRepository::class);
        $this->app->bind(ICTHoaDonService::class,CTHoaDonService::class);
        $this->app->bind(IThanhToanRepository::class,ThanhToanRepository::class);
        $this->app->bind(IThanhToanService::class,ThanhToanService::class);
        $this->app->bind(IMysqlRepository::class,MySQLRepository::class);
        $this->app->bind(IMysqlService::class,MysqlService::class);
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
