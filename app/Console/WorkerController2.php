<?php

namespace console\modules\ttc\controllers;

/**
 * @author Vinh Banh <apacheservices68@gmail.com>
 * @package Worker Update Cache for tto
 * @version 1.0
 */

use common\behaviors\AssetBehavior;
use common\components\constants\CacheConstant;
use common\components\constants\object\Constant;
use common\components\constants\pageblock\PageConstant;
use common\components\zyz\PrintingHelpers;
use common\models\object\Object;
use common\components\db\User;
use console\constants\CdnConstant;
use ttc\models\character\Character;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Console;

class WorkerController extends Controller
{
    /**
     * @var PrintingHelpers $helpers
     */
    public $helpers;

    const KEY_BACKEND_ELASTIC_OBJ = 'zyz.backend.elastic.object';
    const KEY_BACKEND_VELDET = 'zyz.backend.veldet.list';
    const KEY_BACKEND_VELDET2 = 'zyz.backend.cache.veldette';

    /**
     *
     */
    public function init()
    {
        $this->helpers = new PrintingHelpers(get_called_class());
        parent::init();
    }

    /**
     * @param array $args
     */
    public function actionIndex(array $args)
    {
        if (isset($args[0])) {
            $task = $args[0];
            switch ($task) {
                case 'menu':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_MENU,
                        "processMenu"
                    );
                    break;
                case 'page_dynamic':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_PAGE,
                        "processPageDynamic"
                    );
                    break;
                case 'block':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_BLOCK,
                        "processBlock"
                    );
                    break;
                case 'term':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_TERM,
                        "processTerm"
                    );
                    break;
                case 'key_storage':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_KEY_STORAGE,
                        "processKeyStorage"
                    );
                    break;
                case 'app':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_APP,
                        "processApp"
                    );
                    break;
                case 'object':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_OBJECT,
                        "processObject"
                    );
                    break;
                case 'object_slug':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_OBJECT_SLUG,
                        "processObjectSlug"
                    );
                    break;
                case 'tag_profile':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_TAGPROFILE,
                        "processTagProfile"
                    );
                    break;
                case 'manual_queue':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_MANUAL_QUEUE,
                        "processManualQueue"
                    );
                    break;
                case 'varnish':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_VARNISH_CACHE,
                        "processVarnish"
                    );
                    break;
                case 'tag':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_TAG,
                        "processTag"
                    );
                    break;
                case 'elasticsearch':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_ELASTIC_SEARCH_INDEX,
                        "processElasticSearch"
                    );
                    break;
                case 'elasticsearch_import':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_IMPORT,
                        CacheConstant::KEY_BACKEND_ELASTIC_SEARCH_INDEX_IMPORT,
                        "processElasticSearch"
                    );
                    break;
                case 'remove':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_REMOVE,
                        "processRemove"
                    );
                    break;
                case 'list':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_LIST,
                        "processList"
                    );
                    break;
                case 'sort_page':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_SORT,
                        "processSortPage"
                    );
                    break;
                case 'sort_order_page':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_SORT_ORDER,
                        "processSortOrderPage"
                    );
                    break;
                case 'tweet':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_TWEET,
                        "processTweet"
                    );
                    break;
                case 'user':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_USER,
                        "processUser"
                    );
                    break;
                case 'video_info':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_VIDEO_INFO,
                        "processVideo"
                    );
                    break;
                case 'time-event-build-redis':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_TIME_EVENT_AFTERSAVE,
                        'processBuildCacheTagProfileAfterSave'
                    );
                    break;
                case 'character':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_CHARACTER,
                        "processCharacter"
                    );
                    break;
                case 'dis-character':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REDIS_CHARACTER_INACTIVE,
                        "processDisCharacter"
                    );
                    break;
                case 'rebuild-url-object':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_REBUILD_URL_OBJECT,
                        "processRebuildUrlObject"
                    );
                    break;
                case 'update-date-for-object':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_UPDATE_DATE_FOR_OBJECT,
                        "processUpdateDateForObject"
                    );
                    break;
                case 'update-url-comment-object':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        CacheConstant::KEY_BACKEND_UPDATE_URL_COMMENT_OBJECT,
                        "processUpdateUrlCommentObject"
                    );
                    break;
				case 'update-object-view':
					$this->initAmqp(
						CacheConstant::EXCHANGE_BACKEND,
						CacheConstant::KEY_BACKEND_OBJECT_VIEW_UPDATE,
						"processUpdateObjView"
					);
					break;
				case 'mapping-cache':
					$this->initAmqp(
						CacheConstant::EXCHANGE_BACKEND,
						CacheConstant::KEY_BACKEND_CACHE_MAPPING,
						"processBuildCacheMapping"
					);
					break;
                case 'elastic':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        self::KEY_BACKEND_ELASTIC_OBJ,
                        "processElasticObject"
                    );
                    break;
                case 'veldet':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        self::KEY_BACKEND_VELDET,
                        "processVeldet"
                    );
                    break;
                case 'veldet2':
                    $this->initAmqp(
                        CacheConstant::EXCHANGE_BACKEND,
                        self::KEY_BACKEND_VELDET2,
                        "processVeldet2"
                    );
                    break;
                default :
                    $this->getHelper();
            }
        } else {
            print("\n ------------------------------");
            $this->helpers->printMessage("1st arguments is required.");
            $this->getHelper();
        }
    }

    /**
     * @param $msg
     */
    public function processVeldet($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if(!empty($data)){
                $list_obj = [];
                $data['list_obj'] =  !empty($data['list_obj']) ? $data['list_obj'] : [];
                $i = 1;
                foreach($data['list_obj'] as $k=> $v){
                    $list_obj[] = [
                        'id' => $v,
                        'rank' => $i
                    ];
                    $i++;
                }
                $updated_list = z()->searchHelper->getSortedByPage(
                    1,
                    (int)$data['page_id'],
                    (string)$data['cluster'],
                    [],
                    false,
                    (int)$data['app_id']);
                $params = [
                    'index' => 'ttc_veldet',
                    'type' => 'ttc_veldet_type',
//                    'id'    => $key,
                    'body' => [
                        'app_id' => (int)$data['app_id'],
                        'page' => (int)$data['page_id'],
                        'slug' => '', // Default empty
                        'region' => (string)$data['cluster'],
                        'status' => 1, // Default 1
                        'objects' => $list_obj
                    ]
                ];
                if(!empty($updated_list)){
                    $params['id'] = array_keys($updated_list)[0];
                }
                $response_body = z()->searchHelper->createSingleDoc($params);
                $this->helpers->printMessage("Created elastic document ".@json_encode($response_body,JSON_UNESCAPED_UNICODE)." successful", true);
                print_r($response_body);
            }
            else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }
    public function processVeldet2($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_array($data)) {
                $result = z()->dbHelper->buildVeldette($data);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processElasticObject($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if(isset($data['id'])){
                $obj  = Object::findOne($data['id']);
                if(!$obj){
                    $this->helpers->printMessage('Object is not exist');
                    $this->processDone($msg);
                }else{
                    $d = collectObj($obj);
                    $params = [
                        'index' => 'ttc_data',
                        'type' => 'ttc_data_type',
                        'id'    => $obj->id,
                        'body' => $d['data']
                    ];
                    $insert_data =  z()->searchHelper->createSingleDoc($params);
                    $tracking_params = [
                        'index' => 'ttc_tracking',
                        'type' => 'ttc_tracking_type',
                        'id'    => $obj->id,
                        'body' => $d['tracking']
                    ];
                    $insert_tracking =  z()->searchHelper->createSingleDoc($tracking_params);
                    print_r([$insert_data , $insert_tracking]);
                    $this->helpers->printMessage("Created elastic document {$data['id']} successful", true);
                    $this->helpers->printMessage("Serialize data here : ".@json_encode([$insert_data , $insert_tracking],JSON_UNESCAPED_UNICODE) ."\n", true);
                }
            }
            else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

	/**
	 * @param $msg
	 */

    public function processUpdateObjView($msg)
	{
		try {
			$this->helpers->printLog($msg);
			$data = unserialize($msg->body);
			if($data){
				$object = Object::findOne($data[0]);
				if($object){
					$object->object_view = (int)$data[1];
					$object->object_date = (string)$object->object_date;
					if($object->save(true)){
						z()->dbHelper->buildObjectsVer2($data[0]);
						$this->helpers->printMessage('Successful build object '. $data[0]);
					}else{
						$this->helpers->printMessage(\json_encode($object->getErrors() , JSON_UNESCAPED_UNICODE));
					}
				}
				$this->helpers->printMessage($msg->body, true);
			}
			else
				$this->helpers->printMessage(t('backend', 'Input params is invalid'));
			$this->processDone($msg);
		} catch (\Exception $e) {
			$this->helpers->printError($e);
		}
	}

    /**
     * @param $msg
     */
    public function processSortPage($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            $result = z()->dbHelper->buildListFeaturedHomePage($data[0] , $data[1]);
            if($result)
                $this->helpers->printMessage($result, true);
            else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processSortOrderPage($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            $result = z()->dbHelper->buildListFeaturedOrderPage($data[0] , $data[1] , $data[2]);
            if($result){
                $this->helpers->printMessage('Build list for sorted page : '.$data[1]. ' with priority : '.$data[0]);
                $this->helpers->printMessage($result, true);
            }else{
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            }
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    public function processList($msg){
        try {
            // log this
            $this->helpers->printLog($msg);

            // unserialize your message
            $data = unserialize($msg->body);

            if (isset($data) && is_array($data) && count($data) > 0) {
                switch ($data['type']) {
                    case 'prior_list':
                    case 'prior':
                        if (isset($data['params'])) {
                            $result = z()->dbHelper->buildListByPrior($data['params']);
                            $this->helpers->printMessage($result, true);
                        } else {
                            $this->helpers->printMessage("Input params is invalid");
                        }
                        break;

                    case 'term_list':
                    case 'term':
                        $prior_list = Constant::getTermOrder();
                        $prior_list["-1"] = "All";
                        if (isset($data['params']) && isset($prior_list)) {
                            foreach ($prior_list as $key => $value) {
                                $result = z()->dbHelper->buildListByTerm($data['params'], $key);
                                $this->helpers->printMessage($result, true);
                            }
                        } else {
                            $this->helpers->printMessage("Input params is invalid");
                        }
                        break;

                    case 'tag_list':
                    case 'tag':
                        if (isset($data['params'])) {
                            $result = z()->dbHelper->buildListByTag($data['params']);
                            $this->helpers->printMessage($result, true);
                        } else {
                            $this->helpers->printMessage("Input params is invalid");
                        }
                        break;

                    case 'meta_list':
                    case 'meta':
                        # code...
                        if (isset($data['params']) && is_array($data['params']) && count($data['params']) > 0) {
                            $result = z()->dbHelper->buildListByMeta($data['params'][0], $data['params'][1]);
                            $this->helpers->printMessage($result, true);
                        } else {
                            $this->helpers->printMessage("Input params is invalid");
                        }
                        break;

                    case 'mostview_list':
                    case 'mostview':
                        if (isset($data['params']) && is_numeric($data['params'])) {
                            // build most view on 7 days
                            $now = time();
                            $between_date =array($now - (86400 * 7), $now);
                            $result = z()->dbHelper->buildMostViewObjectList($data['params'], $between_date);
                            $this->helpers->printMessage($result, true);
                        } else {
                            $this->helpers->printMessage("Input params is invalid");
                        }
                        break;

                    default:
                        echo 'Wrong list type';
                        break;

                }
            } else {
                $this->helpers->printMessage("Input params is invalid");
            }

            $this->processDone($msg);

        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processKeyStorage($msg){
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            $result = z()->dbHelper->buildKeyStorageItem(array_keys($data)[0] , array_values($data)[0]);
            if((string)array_keys($data)[0] === CacheConstant::KEY_ASSET_CONSTANT)
                z()->build->build();
            if($result)
                $this->helpers->printMessage($result, true);
            else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processTerm($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildTerms($data);
                $result_2 = \console\modules\ttc\repository\TermRepository::saveRedisTerm($data);
                $this->helpers->printMessage($result, true);
                $this->helpers->printMessage($result_2, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processUser($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildUsers($data);
                $user = User::buildUserIdentity($data);
                $this->helpers->printMessage($result, true);
                $this->helpers->printMessage($user, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            z()->redis->close();
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processVideo($msg){
        try {
            $this->helpers->printLog($msg);
            $data = @unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildVid($data);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processTagProfile($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (isset($data['tagprofile']) && isset($data['id'])) { // Object id
                $tagprofile = intval($data['tagprofile']);
                $object_id = intval($data['id']);
                $result = z()->dbHelper->buildTagProfileByTag($tagprofile, $object_id);
                $this->helpers->printMessage($result, true);
            } else {
                $this->helpers->printMessage("Input params is invalid");
            }

            $this->processDone($msg);

        } catch (Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processObject($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildObjectsVer2($data);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processObjectSlug($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildObjectsVer2($data, true);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processPageDynamic($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildPages($data);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * process build block by id
     *
     * @param $msg
     */
    public function processBlock($msg)
    {
        try {
            // log this
            $this->helpers->printLog($msg);

            // unserialize your message
            $data = unserialize($msg->body);

            // run your code here with $msg value
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildBlocks($data);
                $this->helpers->printMessage($result, true);
            } else {
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            }

            $this->processDone($msg);

        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processManualQueue($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildListByManualQueues($data);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processMenu($msg)
    {
        try {
            // log this
            $this->helpers->printLog($msg);

            // unserialize your message
            $data = unserialize($msg->body);
            if ($data) {
                $result = z()->dbHelper->buildMenu($data);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    public function processTweet($msg)
    {
        try {
            // log this
            $this->helpers->printLog($msg);

            // unserialize your message
            $data = unserialize($msg->body);
            if ($data) {
                $result = z()->dbHelper->buildTweet();
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * build tag details
     *
     * @param $msg
     */
    public function processTag($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildTags($data);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processElasticSearch($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (z()->getComponents('elastic') && z()->elastic->enable) {
                $obj = Object::findOne($data);
                if($obj){
                    z()->elastic->indexObject($obj , true, $obj->object_type);
                }
                $this->helpers->printMessage('Process 1');
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processRemove($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_array($data) && isset($data['mode']) && isset($data['params']) && is_array($data['params'])) {
                $result = z()->dbHelper->deleteCacheKey($data['mode'], $data['params']);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processApp($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            $result = z()->dbHelper->buildApps(0);
            if ($result)
                $this->helpers->printMessage($result, true);
            else
                $this->helpers->printMessage(t('backend', 'Build App Failed'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $msg
     */
    public function processVarnish($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (isset($data)) {
                $raw_link = (strpos($data, 'http://') === false) ? 'http://' . $data : $data;

                // parse raw url to array [scheme, host, path]
                $urlInfo = parse_url($raw_link);

                // check if raw link is not having sub folder.
                // meaning invalidate varnish cache for homepage http://tuoitre.vn
                if (!empty($urlInfo['path']) && $urlInfo['path'] !== '/' && $urlInfo['path'] !== '') {
                    // get page slug info and real link info to clear cache
                    $pageSlug = str_replace('/' . PageConstant::PAGE_PREFIX . '/', '', $urlInfo['path']);
                    $cacheLinkInfo = parse_url(detectMenuLink($pageSlug));
                    // set variable value to clear cache
                    $domain = $cacheLinkInfo['host'];
                    $clearUrl = $urlInfo['host'] . '/';
                    if (!empty($cacheLinkInfo['path']))
                        $clearUrl .= $cacheLinkInfo['path'];

                    // to make sure that it's clean url
                    $clearUrl = str_replace('///', '/', $clearUrl);
                    $clearUrl = str_replace('//', '/', $clearUrl);

                    // add scheme to clear url
                    $clearUrl = $urlInfo['scheme'] . '://' . $clearUrl;
                } else {
                    $clearUrl = $raw_link;
                    $domain = 'tuoitre.vn';
                }

                // invalidate varnish cache belongs to url and domain
                $result = z()->varnish->invalidateCache($clearUrl, $domain);
                $this->helpers->printMessage("Link: " . $clearUrl);
                $this->helpers->printMessage("Domain: " . $domain);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    public function processBuildCacheTagProfileAfterSave($msg)
    {
        try {
            // unserialize your message
            $data = unserialize($msg->body);
            if (isset($data['id'])) {
                foreach (json_decode($data['object_ids']) as $k => $v) {
                    // get detail of list object_ids
                    $data['list_object'][] = z()->dbHelper->getObjectDetailById($v);
                }
                $result1 = z()->TimeEventHelper->buildDetailTimeEvent($data['id'], $data);
                // print message info buildDetailTagProfile
                if ($result1) {
                    echo 'Build Cache Detail TimeEvent is SUCCESS' . "\n";
                } else {
                    echo 'Build Cache Detail TimeEvent is FAIL' . "\n";
                }
                // check term_primary and term_foreign
                if (($data['term_primary'] && $data['term_foreign']) != null) {
                    $result2 = z()->TimeEventHelper->buildListTimeEventByTerm([$data['term_primary'], $data['term_foreign']]);
                } else {
                    $result2 = z()->TimeEventHelper->buildListTimeEventByTerm([$data['term_primary']]);
                }
                // print message info buildListTagProfileByTerm
                if ($result2) {
                    echo 'Build Cache List TimeEvent By Term is SUCCESS' . "\n";
                } else {
                    echo 'Build Cache List TimeEvent By Term is FAIL' . "\n";
                }
                // build cache related time event by time event
                $result3 = z()->TimeEventHelper->buildRelatedTimeEvent($data['term_primary']);
                if ($result3) {
                    echo 'Build Cache List Related TimeEvent is SUCCESS' . "\n";
                } else {
                    echo 'Build Cache List Related TimeEvent is FAIL' . "\n";
                }
                // build cache newest time event
                $result4 = z()->TimeEventHelper->buildListTimeEventByNewest();
                if ($result4) {
                    echo 'Build Cache List TimeEvent By Newest is SUCCESS' . "\n";
                } else {
                    echo 'Build Cache List TimeEvent By Newest is FAIL' . "\n";
                }
            } else {
                $this->helpers->printMessage('Variable ID is not exist');
            }
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * @param $exchange
     * @param $key
     * @param string $callback
     */
    private function initAmqp($exchange, $key, $callback = "processDefault")
    {
        try {
            if (isQueueEnable()) {
                // send to amqp interface
                $callback_function = array(&$this, $callback);
                echo "\n\n";
                z()->queue->sub($exchange, $key, $callback_function);
            } else {
                $this->helpers->printMessage("Can't connect with rabbitmq");
            }
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     *
     */
    public function getHelper()
    {

        $this->stdout("\n ----------------------------------\n", Console::BG_GREEN);
        print("\n This command uses for init worker.");
        print("\n Here is command template: ");
        $this->stdout("\n php yii/console zyz/worker/index", Console::BOLD);
        $this->stdout("\n\n ----------------------------------\n\n", Console::BG_GREEN);
        exit(1);
    }

    /**
     * @param $msg
     */
    public function processDone($msg)
    {
    	z()->db->close();
    	z()->redis->close();
        $this->helpers->printMessage("Closed Database Connection.");
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        $this->helpers->printMessage("Reported message done to Rabbitmq.");
    }

    /**
     * default process when you not define callback function
     *
     * @param $msg
     */
    public function processDefault($msg)
    {
        $this->helpers->printLog($msg);
        $this->helpers->printMessage("\n This is default process function message. \n");
    }

    /**
     * build character details
     * @param $msg
     */
    public function processCharacter($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildCharacters($data);
                $result2 = z()->dbHelper->buildListChar($data);
                $this->helpers->printMessage($result, true);
                $this->helpers->printMessage($result2, true);
                sleep(2);
                $character = Character::findOne($data);
                $link = DIRECTORY_SEPARATOR . \common\components\constants\pageblock\PageConstant::PAGE_PREFIX_CHARACTER. DIRECTORY_SEPARATOR . $character->character_slug . '-' . $character->id . '.html';

                if (isQueueEnable()) {
                    $builder = \Yii::$app->queue->pub(serialize($link), CdnConstant::EXCHANGE_BACKEND, CdnConstant::KEY_CONSOLE_LINK_CDN, false);
                    echo "[S] =>>>> Sent queue success by link: ".$link ."\n";
                } else {
                    echo "[ERROR] !!!!!! Sent queue error by link: ".$link ."\n";
                }
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * build character details
     * @param $msg
     */
    public function processDisCharacter($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
//                $result = z()->dbHelper->buildCharacters($data);
                $result2 = z()->dbHelper->disListChar($data);
                $result3 = z()->dbHelper->disCharacters($data);

//                $this->helpers->printMessage($result, true);
                $this->helpers->printMessage($result2, true);
                $this->helpers->printMessage($result3, true);
                sleep(2);
                $character = Character::findOne($data);
                $link = DIRECTORY_SEPARATOR . \common\components\constants\pageblock\PageConstant::PAGE_PREFIX_CHARACTER. DIRECTORY_SEPARATOR . $character->character_slug . '-' . $character->id . '.html';

                if (isQueueEnable()) {
                    $builder = \Yii::$app->queue->pub(serialize($link), CdnConstant::EXCHANGE_BACKEND, CdnConstant::KEY_CONSOLE_LINK_CDN, false);
                    echo "[S] =>>>> Sent queue success by link: ".$link ."\n";
                } else {
                    echo "[ERROR] !!!!!! Sent queue error by link: ".$link ."\n";
                }
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * rebuild url object
     * @param $msg
     */
    public function processRebuildUrlObject($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data['id'])) {
                $force_slug = !empty($data['force_slug']) ? true : false;
                $result = z()->dbHelper->buildObjectsVer2($data['id'], $force_slug);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * rebuild url object
     * @param $msg
     */
    public function processUpdateDateForObject($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (is_numeric($data)) {
                $result = z()->dbHelper->buildObjectsVer3($data, true);
                $this->helpers->printMessage($result, true);
            } else
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     * rebuild url object
     * @param $msg
     */
    public function processUpdateUrlCommentObject($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (!empty($data['id'])) {
                $comment = \comment\models\Comment::findOne($data['id']);
                if ($comment) {
                    $comment->object_url = !empty($data['link']) ? $data['link'] : "";
                    if ($comment->save()) {
                        echo "\n\n[S] =>>>>>> Update url object: " . $data['link'] . " for comment id : " . $comment->id . "\n";
                    } else {
                        echo "\n\n[ERROR] ****** Update fail !!! \n";
                    }
                } else {
                    $this->helpers->printMessage(t('comment', 'Input params is invalid'));
                }
            }
            z()->cm_db->close();
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

    /**
     *  build cache mapping
     * @param $msg
     */
    public function processBuildCacheMapping($msg)
    {
        try {
            $this->helpers->printLog($msg);
            $data = unserialize($msg->body);
            if (!empty($data['params']['id'])) {
                $result = z()->dbHelper->buildMapping($data['params']['id']);
                $this->helpers->printMessage($result, true);
            } else {
                $this->helpers->printMessage(t('backend', 'Input params is invalid'));
            }
            $this->processDone($msg);
        } catch (\Exception $e) {
            $this->helpers->printError($e);
        }
    }

}
