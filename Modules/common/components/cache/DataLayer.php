<?php


namespace Modules\common\components\cache;


class DataLayer
{
    const KEY_LIST_PRODUCT = 'gear_klp';
    const KEY_PRODUCT = '_kp_';
    private $prefix = 'gear';
    public function getKey($type,$params =array('prior'=>0,'id'=>0)){
        switch ($type){
            case 'product':
                return $this->getProductKey($params['id']);
                break;
        }
    }
    private function getProductKey($id){
        return $this->prefix. self::KEY_PRODUCT.$id;
    }
}