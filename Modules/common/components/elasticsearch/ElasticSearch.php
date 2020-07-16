<?php

namespace Modules\common\components\elasticsearch;


use Elasticsearch\ClientBuilder;

class ElasticSearch
{
    public $server = [
        'elastic'
    ];

    private $isConnected = false;

    private $client = false;

    private $timeout = '1s';

    public $defaultIndex = 'gear';

    private $currentConnection = false;

    public function __construct()
    {
        if($this->currentConnection === false){
            $params = $this->server;
            $this->currentConnection = $this->inItConnection($params);
            $this->isConnected = true;
        }
        $this->inItIndexDefault();
    }

    public function inItConnection($params){
        try {
            $builder = ClientBuilder::create()
                ->setHosts($params)
                ->build();
            return $builder;
        }catch (\Exception $exception){
            return $exception;
        }
    }

    public function inItIndexDefault(){
        self::inIt([
           'index' => $this->defaultIndex,
           'body' => [
               'settings' => [
                   'analysis' => [
                       'analyzer' => [
                           'my_standard' => [
                               'tokenizer' => 'icu_tokenizer',
                               'filter' => ['icu_folding', 'icu_normalizer', 'icu_collation'],
                           ],
                       ]
                   ]
               ],
               'mapping' => [
                   'product' => [
                       'properties' => [
                            'MaSP' => [
                                'type' => 'integer',
                                'index' => 'not_analyzed'
                            ],
                           'TenSP' => [
                                'type' => 'string',
                               'analyzer' => 'standard'
                           ],
                           'Gia' => [
                                'type' => 'integer',
                               'analyzer' => 'standard'
                           ],
                           'MaLoaiSP' => [
                                'type' => 'integer',
                               'analyzer' => 'standard'
                           ],
                           'MaThuongHieu' => [
                               'type' => 'integer',
                               'analyzer' => 'standard'
                           ]
                       ]
                   ],
               ]
           ]
        ]);
    }

    protected function inIt($params){
        $params['timeout'] = $this->timeout;
        if($this->currentConnection->indices()->exists(['index'=>$params['index']])){
            return false;
        }
        else{
            return $this->currentConnection->indices()->create($params);
        }
    }

    public function index($params, $refresh = true){
        if($this->isConnected){
            if(!isset($params['timeout'])){
                $params['timeout'] = $this->timeout;
            }
            if($refresh == true){
                $params['refresh'] = $refresh;
            }
            return $this->currentConnection->index($params);
        }else{
            return false;
        }
    }

    public function search($params){
        if($this->isConnected){
            if(empty($params['timeout'])){
                $params['timeout'] = $this->timeout;
            }
            return $this->currentConnection->search($params);
        }else{
            return false;
        }
    }

    public function delete($params){
        if($this->isConnected){
            if(empty($params['timeout'])){
                $params['timeout'] = $this->timeout;
            }
            return $this->currentConnection->delete($params);
        }else{
            return false;
        }
    }

    public function scroll($params){
        if($this->isConnected){
            return $this->currentConnection->scroll($params);
        }else{
            return false;
        }
    }
}