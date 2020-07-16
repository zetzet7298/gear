<?php


namespace App\Console;


use Modules\common\components\queue\RabbitMQ;
use Modules\common\components\constants\ConstantDefine;
class WorkerController
{
    public function initAMQP($exchange,$key,$callback='processDefault'){
        try{
            $callback_function = array(&$this,$callback);
            echo "\n\n";
            $queue = new RabbitMQ();
            $queue->sub($exchange,$key,$callback_function);
        }catch (\Exception $e){
            return $e;
        }
    }
    public function index($args){
        switch ($args){
            case 'product':$this->initAMQP(
                ConstantDefine::EXCHANGE_BACKEND,
                ConstantDefine::KEY_BACKEND_REDIS_PRODUCT,
                'processProduct'
            );
        }
    }
    public function processProduct($msg){
        try {
            $data = unserialize($msg);
            dd($data);
        }catch (\Exception $e){
            return $e;
        }
    }
}