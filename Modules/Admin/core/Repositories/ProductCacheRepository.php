<?php


namespace Modules\Admin\core\Repositories;


use Illuminate\Support\Facades\Redis;
use Modules\common\components\cache\DataLayer;
use Modules\common\components\constants\ConstantDefine;
use Modules\common\components\queue\RabbitMQ;

class ProductCacheRepository extends EloquentRepository implements IProductCacheRepository
{
    private $keyListProduct = DataLayer::KEY_LIST_PRODUCT;
    public function getModel()
    {
        // TODO: Implement getModel() method.
        return \Modules\Admin\Entities\Product::class;
    }
    public function show($id)
    {
        // TODO: Implement show() method.
        return Redis::hGetAll($id);
    }
    public function store($data)
    {
        $id = $data['id'];
        try {
            $count = Redis::zCard($this->keyListProduct);
            $productDetail = parent::show($id);
            $dataLayer = new DataLayer;
            $keyProduct = $dataLayer->getKey('product',['id'=>$id]);
            if(!empty($productDetail) && !empty($keyProduct)){
                Redis::del($keyProduct);
                $result = Redis::hmSet($keyProduct,$productDetail[0]);
                Redis::zAdd($this->keyListProduct,$count,$id);
                return $result;
            }
            else{
                $result = Redis::hmSet($keyProduct,$productDetail[0]);
                Redis::zAdd($this->keyListProduct,$count,$id);
                return $result;
            }
        }catch (\Exception $exception){
            return $exception;
        }
    }
    public function destroy($id)
    {
        try {
            $dataLayer = new DataLayer;
            $keyProduct = $dataLayer->getKey('product',['id'=>$id]);
            if(!empty($keyProduct)&&!empty($this->keyListProduct)){
                $result = Redis::del($keyProduct);
                Redis::zRem($this->keyListProduct,$id);
                return $result;
            }
        }catch (\Exception $exception){
            return $exception;
        }
    }

    public function saveAllToRedis()
    {
        // TODO: Implement saveAllToRedis() method.
        $listProduct = parent::getAll();
        $builder=false;
        try {
            $i = 0;
            foreach ($listProduct as $k=>$v){
                $data = [
                    'id'=>$v['MaSP']
                ];
                Redis::zAdd($this->keyListProduct,$i,$v['MaSP']);
                $i++;
                $exchange = ConstantDefine::EXCHANGE_BACKEND;
                $routing_key = ConstantDefine::KEY_BACKEND_REDIS_PRODUCT;
                $queue = new RabbitMQ;
                if ($queue->isConnected()){
                    $builder = $queue->pub(serialize($data), $exchange, $routing_key, true);
                }
            }
            return $builder;
        }catch (\Exception $exception){
            return $exception;
        }
    }
    public function getAll()
    {
        $products = Redis::zRangeByScore($this->keyListProduct,'-inf','+inf');
        $result = [];
        foreach ($products as $item){
            $dataLayer = new DataLayer();
            $keyProduct = $dataLayer->getKey('product',['id'=>$item]);
            $product = Redis::hGetAll($keyProduct);
            $result[] = $product;
        }
        return $result;
    }
}