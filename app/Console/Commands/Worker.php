<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Admin\core\Services\ProductCacheService;
use Modules\Admin\core\Services\ProductESService;
use Modules\Admin\core\Services\ProductService;
use Modules\common\components\constants\ConstantDefine;
use Modules\common\components\queue\RabbitMQ;

class Worker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:worker {worker}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy data to redis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $service;
    protected $serviceRepo;
    protected $ESService;
    public function __construct(ProductCacheService $service, ProductService $serviceRepo, ProductESService $ESService)
    {
        parent::__construct();
        $this->service = $service;
        $this->serviceRepo = $serviceRepo;
        $this->ESService = $ESService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $args = $this->argument('worker');
        switch ($args){
            case 'product':
                $this->initAmqp(
                    ConstantDefine::EXCHANGE_BACKEND,
                    ConstantDefine::KEY_BACKEND_REDIS_PRODUCT,
                    "processProduct"
                );
                break;
            case 'listProduct':
                $this->service->saveAllToRedis();
            case 'saveAllToES':
                $this->ESService->saveAllToES();
        }
    }
    public function initAMQP($exchange,$key,$callback='processDefault'){
        try{
            $callback_function = array(&$this, $callback);
            echo "\n\n";
            $queue = new RabbitMQ();
            $queue->sub($exchange,$key,$callback_function);
        }catch (\Exception $e){
            return $e;
        }
    }
    public function processProduct($msg){
        try {
            $data = unserialize($msg->body);
            $result = $this->service->store($data);
            $this->processDone($msg);
        }catch (\Exception $e){
            return $e;
        }
    }
    public function processDone($msg)
    {
        echo "Closed Database Connection.";
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        echo "Reported message done to Rabbitmq.";
    }
}
