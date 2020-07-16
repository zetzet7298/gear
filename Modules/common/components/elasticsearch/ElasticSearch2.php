<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 05/06/2018
 * Time: 17:59
 */

namespace ttc\components;

use common\components\constants\object\Constant;
use common\components\zyz\ConstantDefine;
use common\models\objectmeta\ObjectMeta;
use GuzzleHttp\Client;
use Yii;
use ttc\models\object\Object;
use common\models\objectlock\ObjectLock;
use common\models\objectresource\ObjectResource;
use common\models\objectscore\ObjectScore;
use ttc\models\objectterm\ObjectTerm;
use common\models\Resource;
use ttc\models\tag\Tag;
use Elasticsearch\Common\Exceptions\Curl\CouldNotConnectToHost;
use yii\base\Component;
use Elasticsearch\ClientBuilder;
use common\components\constants\object\Constant as ObjectConstant;

class ElasticSearch extends Component
{
    /**
     * @var bool
     */
    public $enable = false;

    /**
     * @var array
     */
    public $server = [
        '127.0.0.1:9200'
    ];

    /**
     * @var bool
     */
    public $client = false;

    /**
     * @var string
     */
    public $timeout = '1s';

    /**
     * @var string
     */
    public $defaultIndex = 'tto';

    public $veldetIndex = 'ttc_veldette';

    /**
     * @var ClientBuilder bool
     */
    private $_currentConnection = false;

    public function init()
    {
        parent::init();
        if ($this->enable) {
            $params = [$this->server];
            if ($this->_currentConnection === false) {
                $this->_currentConnection = $this->initConnection($params);
            }
            $this->initDefaultIndex();
            $this->initVeldetIndex();
        } else {
            $this->log("Elastic search components is not enabled.");
        }
    }

    /**
     * Init connection
     *
     * @param $params
     * @return \Elasticsearch\Client
     */
    public function initConnection($params)
    {
        try {
            $builder = ClientBuilder::create();
            $builder->setHosts($params);
            return $builder->build();
        } catch (CouldNotConnectToHost $e) {
            $this->log($e->getMessage());
        }
    }

    /**
     * check connection
     *
     * @return bool
     */
    public function isConnected()
    {
        return empty($this->_currentConnection) !== true || $this->_currentConnection->ping() !== false;
    }

    public function initDefaultIndex()
    {
        self::initIndex(
            [
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
                    'mappings' => [
                        'veldette' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                    'index' => 'not_analyzed'
                                ],
                                'page_id' => [
                                    'type' => 'integer',
                                    'index' => 'not_analyzed'
                                ],
                                'cluster' => [
                                    'type' => 'string',
                                    'analyzer' => 'standard',
                                ]
                            ]
                        ],
                        'article' => [
                            'properties' => [
                                'id' => [
                                    'type' => 'integer',
                                    'index' => 'not_analyzed'
                                ],
                                'name' => [
                                    'type' => 'string',
                                    'analyzer' => 'standard',
                                    'fields' => [
                                        'folded' => [
                                            'type' => 'string',
                                            'analyzer' => 'my_standard'
                                        ]
                                    ]
                                ],
                                'title' => [
                                    'type' => 'string',
                                    'analyzer' => 'standard',
                                    'fields' => [
                                        'folded' => [
                                            'type' => 'string',
                                            'analyzer' => 'my_standard'
                                        ]
                                    ]
                                ],
                                'excerpt' => [
                                    'type' => 'string',
                                    'analyzer' => 'standard',
                                    'fields' => [
                                        'folded' => [
                                            'type' => 'string',
                                            'analyzer' => 'my_standard'
                                        ]
                                    ]
                                ],
                                'content' => [
                                    'type' => 'string',
                                    'analyzer' => 'standard',
                                    'fields' => [
                                        'folded' => [
                                            'type' => 'string',
                                            'analyzer' => 'my_standard'
                                        ]
                                    ]
                                ],
                                'creator' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => [
                                            'type' => 'integer',
                                        ],
                                        'name' => [
                                            'type' => 'string',
                                        ]
                                    ]
                                ],
                                'atype' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'video' => [
                                            'type' => 'boolean',
                                            'index' => 'not_analyzed'
                                        ],
                                        'audio' => [
                                            'type' => 'boolean',
                                            'index' => 'not_analyzed'
                                        ],
                                        'gallery' => [
                                            'type' => 'boolean',
                                            'index' => 'not_analyzed'
                                        ],
                                        'text' => [
                                            'type' => 'boolean',
                                            'index' => 'not_analyzed'
                                        ]
                                    ]
                                ],
                                'author' => [
                                    'type' => 'string',
                                    'analyzer' => 'standard',
                                    'fields' => [
                                        'folded' => [
                                            'type' => 'string',
                                            'analyzer' => 'my_standard'
                                        ]
                                    ]
                                ],
                                'thumbnail' => [
                                    'type' => 'string',
                                ],
                                'slug' => [
                                    'type' => 'string',
                                    'index' => 'not_analyzed'
                                ],
                                'status' => [
                                    'type' => 'integer',
                                    'index' => 'not_analyzed'
                                ],
                                'date' => [
                                    'type' => 'string',
                                    'index' => 'not_analyzed'
                                ],
                                'modified' => [
                                    'type' => 'date',
                                    'format' => 'dd-MM-yyyy HH:mm:ss'
                                ],
                                'published' => [
                                    'type' => 'date',
                                    'format' => 'dd-MM-yyyy HH:mm:ss'
                                ],
                                'priority' => [
                                    'type' => 'integer',
                                    'index' => 'not_analyzed'
                                ],
                                'categories' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'name' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                        'description' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                        'priority' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'primary' => [
                                            'type' => 'boolean',
                                            'index' => 'not_analyzed'
                                        ]
                                    ]
                                ],
                                'taxonomy' => [
                                    'type' => 'integer',
                                    'index' => 'not_analyzed'
                                ],
                                'character' => [
                                    'type' => 'integer',
                                    'index' => 'not_analyzed'
                                ],
                                'tags' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'slug' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                        'raw' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                        'tag' => [
                                            'type' => 'string',
                                            'analyzer' => 'standard',
                                            'fields' => [
                                                'folded' => [
                                                    'type' => 'string',
                                                    'analyzer' => 'my_standard'
                                                ]
                                            ]
                                        ]
                                    ]
                                ],
                                'transfers' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'from' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'to' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'before' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'after' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'type' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'time' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                        'note' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                        'log' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'isWorkflow' => [
                                            'type' => 'boolean',
                                            'index' => 'not_analyzed'
                                        ]
                                    ]
                                ],
                                'workflow' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'from' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'to' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'before' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'after' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'type' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'time' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                        'note' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                        'log' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ]
                                    ]
                                ],
                                'zone' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'id' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'name' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                    ]
                                ],
                                'isScore' => [
                                    'type' => 'boolean',
                                    'index' => 'not_analyzed'
                                ],
                                'isLocked' => [
                                    'type' => 'boolean',
                                    'index' => 'not_analyzed'
                                ],
                                'lock' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'user_id' => [
                                            'type' => 'integer',
                                            'index' => 'not_analyzed'
                                        ],
                                        'time' => [
                                            'type' => 'string',
                                            'index' => 'not_analyzed'
                                        ],
                                    ]
                                ],
                                'isLive' => [
                                    'type' => 'boolean',
                                    'index' => 'not_analyzed'
                                ],
                                'live' => [
                                    'type' => 'integer',
                                    'index' => 'not_analyzed'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    public function initVeldetIndex(){
        self::initIndex(
            [
                'index' => $this->veldetIndex,
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
                    'mappings' => [
                        'veldette' => [
                            'properties' => [
                                'page_id' => [
                                    'type' => 'integer',
                                    'index' => 'not_analyzed'
                                ],
                                'cluster' => [
                                    'type' => 'string',
                                    'analyzer' => 'standard',
                                ]
                            ]
                        ],
            ]
                    ]]
        );
    }

    /**
     * @param $params
     * @return bool
     */
    protected function initIndex($params)
    {
        $params['timeout'] = $this->timeout;
        if ($this->_currentConnection->indices()->exists(['index' => [$params['index']]]))
            return false;
        else
            return $this->_currentConnection->indices()->create($params);
    }

    /**
     * @param $params
     * @param bool $refresh
     * @return bool
     */
    public function index($params, $refresh = true)
    {
        if ($this->isConnected()) {
            if (empty($params['timeout'])) {
                $params['timeout'] = $this->timeout;
            }
            if ($refresh === true) {
                $params['refresh'] = $refresh;
            }
            return $this->_currentConnection->index($params);
        } else {
            return false;
        }
    }

    public function indexVeldet($vel, $print_message = true, $content_type = 'veldette'){
        $params = [
            'index' => 'ttc_veldette',
            'type' => $content_type,
            'id' => $vel['id'],
            'body'=>[
                'page_id' => $vel['page_id'],
                'cluster'=> $vel['cluster'],
                'user_id' => $vel['user_id'],
                'created_at' => $vel['created_at'],
                'updated_at' => $vel['updated_at'],
                //'list_object'=>$vel->list_object,
            ]
        ];
        $listObject = @json_decode($vel['list_object']);
        $arrObject = [];
        foreach ($listObject as $k => $v) {
            $object = z()->dbHelper->getObjectDetailById($v);
            $arrTemp = [];
            foreach ($object as $item) {
                $arrTemp ['object_title'] = $object['object_title'];
                $arrTemp ['object_excerpt'] = $object['object_excerpt'];
                $arrTemp ['object_url'] = $object['object_url'];
                $arrTemp ['mapping_id'] = $object['mapping_id'];
                $arrTemp ['object_thumbnail'] = $object['object_thumbnail'];
                $arrTemp ['id'] = $object['id'];
                $arrTemp ['object_comment_count'] = $object['object_comment_count'];
                if(isset($object['character_id'])){
                    $arrTemp['character_id'] = $object['character_id'];
                }
            }
            $arrObject [] = $arrTemp;
            unset($arrTemp);
//            $arrObject['object_title'] = $object['title'];
//            $arrObject['object_excerpt'] = $object['object_excerpt'];
        }
        $params['body']['list_object'] = @json_encode($arrObject);
        $isIndexed = self::index($params);
        if ($print_message)
            $this->log("index version " . $isIndexed['_version'] . " with id: " . $params['id']);

    }

    /**
     * @param Object $obj
     * @param bool $print_message
     * @param string $content_type
     */
    public function indexObject($obj, $print_message = true, $content_type = 'article')
    {
        if (!empty($obj)) {
            $params = [
                'index' => $this->defaultIndex,
                'type' => $content_type,
                'id'    => $obj->id
            ];

            // get terms information
            $terms = [];
            $currentPrimaryTermId = false;
            foreach ($obj->terms as $k => $term) {
                if ($k === 0) {
                    $currentPrimaryTermId = $term->id;
                }
                $terms[$term->id] = [
                    'id' => $term->id,
                    'name' => $term->name,
                    'description' => $term->description,
                    'priority' => (int)ObjectTerm::find()->where(['object_id' => $obj->id, 'term_id' => $term->id])->one()->data,
                    'primary' => $k === 0
                ];
            }

            // get site priority and term primary
            $priority = 0;
            $taxonomy_id = 0;
            $character_id = 0;
            $atype = [];
            foreach ($obj->objectMetas as $meta) {
                // get site priority information
                if ($meta->meta_key === 'display_order') {
                    $priority = $meta->meta_value;
                }

                // get term primary information
                if ($meta->meta_key === 'term_primary') {
                    if (isset($terms[$meta->meta_value])) {
                        $terms[$meta->meta_value]['primary'] = true;
                        if ($currentPrimaryTermId !== false && $currentPrimaryTermId != $meta->meta_value) {
                            $terms[$currentPrimaryTermId]['primary'] = false;
                        }
                    }
                }

                if ($meta->meta_key === 'icon') {
                    if ($icons = @json_decode($meta->meta_value)) {
                        $this->updateAtype($atype, $icons);
                    }
                }

                // get site taxonomy_id information
                if ($meta->meta_key === 'taxonomy_id') {
                    $taxonomy_id = $meta->meta_value;
                }

                // get site character_id information
                if ($meta->meta_key === 'character_id') {
                    $character_id = $meta->meta_value;
                }
            }
            if (count($atype) == 0) {
                $atype['text'] = true;
            } else {
                $atype['text'] = false;
            }

            /**
             * Get tags
             */
            $tags = [];
//            $tags_arr = explode(',', $obj->object_tags);
            if (!empty($obj->objectTag)) {
                foreach ($obj->objectTag as $obj_tag) {
                    $tag_info = Tag::findOne($obj_tag->tag_id);
                    if ($tag_info) {
                        $tags[] = [
                            'id' => $tag_info->id,
                            'slug' => $tag_info->tag_slug,
                            'raw' => $tag_info->tag_name,
                            'tag' => $tag_info->tag_name
                        ];
                    }
                }
            }

            // get transfers
            $transfers = [];
            $transferArr = $obj->transfer;
            $lastTransfer = count($transferArr) - 1;
            $workflow = [];
            foreach ($transferArr as $k => $transfer) {
                if ($k == $lastTransfer) {
                    $workflow = [
                        'id' => getOriginId($transfer->id,$taxonomy_id),
                        'from' => $transfer->from_user_id,
                        'to' => $transfer->to_user_id,
                        'before' => $transfer->before_status,
                        'after' => $transfer->after_status,
                        'type' => $transfer->type,
                        'time' => $transfer->created_at,
                        'note' => $transfer->note,
                        'log' => getOriginId($transfer->log_id,$taxonomy_id)
                    ];
                    $isWorkflow = true;
                } else {
                    $isWorkflow = false;
                }

                $transfers[] = [
                    'id' => getOriginId($transfer->id,$taxonomy_id),
                    'from' => $transfer->from_user_id,
                    'to' => $transfer->to_user_id,
                    'before' => $transfer->before_status,
                    'after' => $transfer->after_status,
                    'type' => $transfer->type,
                    'time' => $transfer->created_at,
                    'note' => $transfer->note,
                    'log' => getOriginId($transfer->log_id,$taxonomy_id),
                    'isWorkflow' => $isWorkflow
                ];
            }

            // get creator information
            $creator = [];
            if (!empty($obj->author)) {
                $creator = ['id' => $obj->author->id, 'name' => $obj->object_author_name];
            }

            // get object thumbnail
            $thumbnail = !empty(self::getObjectThumbnail($obj->id)) ? self::getObjectThumbnail($obj->id) : '';

            // get article zone
            $zone = explode('-', ($obj->object_excerpt));
            $article_zone_raw = array_shift($zone);

            // remove un-character
            preg_match('/[A-Z]+/', $article_zone_raw, $matches);
            if (!empty($matches[0]))
                $article_zone_raw = $matches[0];

            switch ($article_zone_raw) {
                // TTO case
                case ObjectConstant::zoneTypes()[ObjectConstant::ZONE_TTO]:
                    $article_zone = [
                        'id' => ObjectConstant::ZONE_TTO,
                        'name' => ObjectConstant::zoneTypes()[ObjectConstant::ZONE_TTO]
                    ];
                    break;

                // TTCT case
                case ObjectConstant::zoneTypes()[ObjectConstant::ZONE_TTCT]:
                    $article_zone = [
                        'id' => ObjectConstant::ZONE_TTCT,
                        'name' => ObjectConstant::zoneTypes()[ObjectConstant::ZONE_TTCT]
                    ];
                    break;

                // TTC case
                case ObjectConstant::zoneTypes()[ObjectConstant::ZONE_TTC]:
                    $article_zone = [
                        'id' => ObjectConstant::ZONE_TTC,
                        'name' => ObjectConstant::zoneTypes()[ObjectConstant::ZONE_TTC]
                    ];
                    break;

                // AT case
                case ObjectConstant::zoneTypes()[ObjectConstant::ZONE_AT]:
                    $article_zone = [
                        'id' => ObjectConstant::ZONE_AT,
                        'name' => ObjectConstant::zoneTypes()[ObjectConstant::ZONE_AT]
                    ];
                    break;

                // TT case
                case ObjectConstant::zoneTypes()[ObjectConstant::ZONE_TT]:
                    $article_zone = [
                        'id' => ObjectConstant::ZONE_TT,
                        'name' => ObjectConstant::zoneTypes()[ObjectConstant::ZONE_TT]
                    ];
                    break;

                // UNKNOWN case
                default:
                    $article_zone = [
                        'id' => ObjectConstant::ZONE_UNKNOWN,
                        'name' => ObjectConstant::zoneTypes()[ObjectConstant::ZONE_UNKNOWN]
                    ];
                    break;
            }

            // check is money
            $score = false;
            $find_score = ObjectScore::find()->where('object_id = :id', [':id' => $obj->id])->one();
            if (!empty($find_score) && trim($find_score->score) != '')
                $score = true;

            // check is locked
            $isLocked = false;
            $lockInfo = [];
            $lock = ObjectLock::find()->where("object_id = :id", [':id' => $obj->id])->one();
            if ($lock) {
                $isLocked = true;
                $lockInfo = [
                    'user_id' => $lock->user_id,
                    'time' => $lock->created_at
                ];
            }

            // check is live
            $isLive = false;
            $liveInfo = 0;
            $live = ObjectMeta::find()->where("object_id = :id AND meta_key = :key", [':id' => $obj->id, ':key' => 'is_live'])->one();
            if ($live) {
                $isLive = true;
                $liveInfo = $live->meta_value;
            }

            // get object poster
            $poster = !empty(self::getObjectPoster($obj->id)) ? self::getObjectPoster($obj->id) : ['file' => $thumbnail, 'thumb' => $thumbnail];
            $primary_id = $taxonomy_id > 1 ? getOriginId($obj->id,$taxonomy_id): $obj->id;
            $params['body'] = [
                'id' => $primary_id,
                'name' => strip_tags($obj->object_name),
                'title' => strip_tags($obj->object_title),
                'excerpt' => strip_tags($obj->object_excerpt),
                'content' => strip_tags($obj->object_content),
                'atype' => $atype,
                'thumbnail' => $thumbnail,
                'poster' => $poster,
                'author' => $obj->object_author_name,
                'creator' => $creator,
                'status' => (int)$obj->object_status,
                'slug' => $obj->object_slug,
                'date' => $obj->object_date,
                'modified' => date('d-m-Y H:i:s', $obj->updated_at),
                'published' => date('d-m-Y H:i:s', (int)$obj->object_date),
                'tags' => $tags,
                'transfers' => $transfers,
                'workflow' => $workflow,
                'zone' => $article_zone,
                'isScore' => $score,
                'isLocked' => $isLocked,
                'lock' => $lockInfo,
                'isLive' => $isLive,
                'live' => $liveInfo,
                'taxonomy' => (int)$taxonomy_id,
                'character' => (int)$character_id,
            ];

//            if ($content_type == 'article') {
                $params['body']['priority'] = (int)$priority;
                $params['body']['categories'] = array_values($terms); // reset key and assign terms to categories
//            }
            $isIndexed = self::index($params);
            if ($print_message)
                $this->log("index version " . $isIndexed['_version'] . " with id: " . $params['id']);
        }
    }

    /**
     * @param $params
     * @param bool $refresh
     * @return bool
     */
    public function update($params, $refresh = true)
    {
        if ($this->isConnected()) {
            if (empty($params['timeout'])) {
                $params['timeout'] = $this->timeout;
            }
            $existParams = [
                'index' => $params['index'],
                'id' => $params['id'],
                'type' => $params['type'],
            ];
            if ($this->_currentConnection->exists($existParams)) {
                if ($refresh === true) {
                    $params['refresh'] = $refresh;
                }
                return $this->_currentConnection->update($params);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $index
     * @param $type
     * @param $objId
     * @param $userId
     * @param $lockTime
     * @return bool
     */
    public function lockObject($index, $type, $objId, $userId, $lockTime)
    {
        $params = [
            'index' => $this->defaultIndex,
            'type' => $type
        ];
        $params['id'] = $objId;
        $params['body']['doc']['isLocked'] = true;
        $params['body']['doc']['lock'] = ['user_id' => $userId, 'time' => $lockTime];

        return $this->update($params, true);
    }

    /**
     * @param $index
     * @param $type
     * @param $objId
     * @return bool
     */
    public function unlockObject($index, $type, $objId)
    {
        $params = [
            'index' => $this->defaultIndex,
            'type' => $type
        ];
        $params['id'] = $objId;
        $params['body']['doc']['isLocked'] = false;
        $params['body']['doc']['lock'] = [];

        return $this->update($params, true);
    }

    /**
     * @param $params
     * @param bool $refresh
     * @return bool
     */
    public function delete($params, $refresh = true)
    {
        if ($this->isConnected()) {
            if (empty($params['timeout'])) {
                $params['timeout'] = $this->timeout;
            }
            $existParams = [
                'index' => $params['index'],
                'id' => $params['id'],
                'type' => $params['type'],
            ];
            if ($this->_currentConnection->exists($existParams)) {
                if ($refresh === true) {
                    $params['refresh'] = $refresh;
                }
                return $this->_currentConnection->delete($params);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param $params
     * @return bool
     */
    public function search($params)
    {
        if ($this->isConnected()) {
            if (empty($params['timeout'])) {
                $params['timeout'] = $this->timeout;
            }
            return $this->_currentConnection->search($params);
        } else {
            return false;
        }
    }

    /**
     * @param $params
     * @param bool $backend
     * @param array $content_type
     * @param array $indices
     * @return array
     */

    public function searchVeldet($params, $number, $backend = false, $content_type = [], $indices = [2014]){
        $search_params['index'] = $this->veldetIndex;
        $search_params['timeout'] = $this->timeout;
        $search_params['body'] = $params;
        $elastic_data = $this->search($search_params);
        if(!empty($elastic_data['hits']['hits'][0]['_source']['list_object'])){
            $list_object = $elastic_data['hits']['hits'][0]['_source']['list_object'];
            $list_object = @json_decode($list_object,true);
        }
        return !empty($list_object) ? $list_object : [];
    }

    public function searchObject($params, $backend = false, $content_type = [], $indices = [2014])
    {
        $search_params['index'] = $this->defaultIndex;
        if ($content_type) {
            $content_type = implode(',', (array)$content_type);
            $search_params['type'] = $content_type;
        }

        $search_params['timeout'] = $this->timeout;
        $search_params['body'] = $params;

        $elastic_data = $this->search($search_params);

        $result = [];
        $total = empty($elastic_data['hits']['total']) ? 0 : $elastic_data['hits']['total'];
        if ($backend === false) {
            if (!empty($elastic_data['hits']['hits'])) {
                foreach ($elastic_data['hits']['hits'] as $obj) {

                    if (empty($obj['_source']['slug'])) {
                        $obj['_source']['slug'] = '#';
                    }
                    if (empty($obj['_source']['thumbnail'])) {
                        $obj['_source']['thumbnail'] = '#';
                    }

                    $article['id'] = $obj['_source']['id'];
                    $article['name'] = $obj['_source']['name'];
                    $article['title'] = !empty($obj['highlight']['title.folded'][0]) ? $obj['highlight']['title.folded'][0] : $obj['_source']['title'];
                    $article['excerpt'] = !empty($obj['highlight']['excerpt.folded'][0]) ? $obj['highlight']['excerpt.folded'][0] : $obj['_source']['excerpt'];
                    $article['thumbnail'] = $obj['_source']['thumbnail'];
                    $article['status'] = $obj['_source']['status'];
                    $article['priority'] = isset($obj['_source']['priority']) ? $obj['_source']['priority'] : 0;
                    $article['taxonomy'] = $obj['_source']['taxonomy'] ?? 1;
                    $article['character'] = $obj['_source']['character'] ?? 0;
                    $article['slug'] = $obj['_source']['slug'];
                    $article['terms'] = isset($obj['_source']['categories']) ? $obj['_source']['categories'] : [];
                    $article['tags'] = $obj['_source']['tags'];
                    $article['author'] = !empty($obj['highlight']['author.folded'][0]) ? $obj['highlight']['author.folded'][0] : $obj['_source']['author'];
                    $article['date'] = $obj['_source']['date'];
                    $article['published'] = isset($obj['_source']['published']) ? $obj['_source']['published'] : '';
                    $article['atype'] = $obj['_source']['atype'];

                    // fetch additional data from cache
                    $cache_data = Yii::$app->dbHelper->getObjectDetailById($article['id']);
                    if (!empty($cache_data)) {
                        $article['icon'] = isset($cache_data['icon']) ? $cache_data['icon'] : null;
                        $article['comment_count'] = isset($cache_data['comment_count']) ? $cache_data['comment_count'] : null;
                        $article['redirect_link'] = isset($cache_data['redirect_link']) ? $cache_data['redirect_link'] : null;
                        $article['price'] = isset($cache_data['price']) ? $cache_data['price'] : null;
                        $article['is_atex'] = isset($cache_data['is_atex']) ? $cache_data['is_atex'] : null;
                        unset($cache_data);
                    }

                    $result[] = $article;
                    unset($article);
                }
            }

            return ['took' => $elastic_data['took'], 'data' => $result, 'total' => $total];
        } else {

            if (!empty($elastic_data['hits']['hits'])) {
                foreach ($elastic_data['hits']['hits'] as $obj) {

                    if (empty($obj['_source']['slug'])) {
                        $obj['_source']['slug'] = '#';
                    }
                    if (empty($obj['_source']['thumbnail'])) {
                        $obj['_source']['thumbnail'] = '#';
                    }
                    $article['id'] = $obj['_source']['id'];
                    $article['name'] = $obj['_source']['name'];

                    if (!empty($obj['highlight']['title.folded'][0]))
                        $article['title'] = $obj['highlight']['title.folded'][0];
                    elseif (!empty($obj['highlight']['title'][0]))
                        $article['title'] = $obj['highlight']['title'][0];
                    else
                        $article['title'] = $obj['_source']['title'];

                    if (!empty($obj['highlight']['excerpt.folded'][0]))
                        $article['excerpt'] = $obj['highlight']['excerpt.folded'][0];
                    elseif (!empty($obj['highlight']['excerpt'][0]))
                        $article['excerpt'] = $obj['highlight']['excerpt'][0];
                    else
                        $article['excerpt'] = $obj['_source']['excerpt'];

                    $article['thumbnail'] = $obj['_source']['thumbnail'];
                    $article['status'] = $obj['_source']['status'];
                    $article['priority'] = $obj['_source']['priority'];
                    $article['taxonomy'] = $obj['_source']['taxonomy'];
                    $article['character'] = $obj['_source']['character'];
                    $article['slug'] = $obj['_source']['slug'];
                    $article['terms'] = $obj['_source']['categories'];
                    $article['tags'] = $obj['_source']['tags'];

                    if (!empty($obj['highlight']['author.folded'][0]))
                        $article['author'] = $obj['highlight']['author.folded'][0];
                    elseif (!empty($obj['highlight']['author'][0]))
                        $article['author'] = $obj['highlight']['author'][0];
                    else
                        $article['author'] = $obj['_source']['author'];

                    $article['date'] = $obj['_source']['date'];
                    $article['atype'] = $obj['_source']['atype'];

                    if (!empty($content_type) && strpos($content_type, 'news') != -1) {
                        if (isset($obj['_source']['newspaper'])) {
                            $article['newspaper']['date'] = substr($obj['_source']['newspaper']['date'], 0, 10);
                            $article['newspaper']['type'] = $obj['_source']['newspaper']['type'];
                            $article['newspaper']['page'] = $obj['_source']['newspaper']['page'];
                        }
                    }
                    $result[] = $article;
                    unset($article);
                }
            }

            return ['took' => $elastic_data['took'], 'data' => $result, 'total' => $total];
        }
    }

    public function scroll($params)
    {
        if ($this->isConnected()) {
            $params['timeout'] = $this->timeout;

            return $this->_currentConnection->scroll($params);
        } else {
            return false;
        }
    }

    /**
     * @param $mgs
     */
    public function log($mgs)
    {
        echo "\n";
        echo $mgs;
    }

    /**
     * @param $object_id
     * @return null
     */
    private static function getObjectThumbnail($object_id)
    {
        try {
            $resources = self::getObjectResourcesById($object_id, 'slideshow');
            if (empty($resources)) {
                # Check gallery of Media article
                $resources = self::getObjectResourcesById($object_id, 'gallery');
                if(empty($resources))
                    /*--- end ---*/

                    return null;
            }
            foreach ($resources[0]['resource_content'] as $res) {
                if ($res['resource_thumb'] == 1) {
                    return $res['resource_path'];
                }
            }
            return null;
        } catch (\Exception $e) {
            echo "\n";
            echo 'Class ' . get_called_class() . ' - ' . $e->getMessage() . ' - Line: ' . $e->getLine();
        }
    }

    /**
     * get all resources of object
     *
     * @param $object_id
     * @param string $object_resource_type
     * @return array
     */
    private static function getObjectResourcesById($object_id, $object_resource_type = '')
    {
        try {
            $obj_res = ObjectResource::find()
                ->where('object_id = :object_id', [
                    ':object_id' => $object_id
                ]);
            if ($object_resource_type != '')
                $obj_res->andWhere('type = :type', [
                    ':type' => $object_resource_type
                ]);
            $obj_res = $obj_res->all();

            if (!$obj_res) return null;

            $result = [];

            foreach ($obj_res as $res) {
                $resource = [];
                $resource_content_list = [];

                $resource['object_resource_type'] = $res->type;
                $res_contents = json_decode($res->content, true);
                if (is_array($res_contents)) {
                    foreach ($res_contents as $content) {
                        $resource_content = [];
                        $resource_content['resource_id'] = $content['res_id'];
                        $resource_content['resource_description'] = $content['desc'];
                        $resource_content['resource_order'] = $content['order'];
                        $resource_content['resource_slide'] = isset($content['slide']) ? $content['slide'] : '';
                        $resource_content['resource_thumb'] = isset($content['thumb']) ? $content['thumb'] : '';
                        $resource_content['resource_note'] = isset($content['note']) ? $content['note'] : '';
                        $resource_content['resource_poster'] = isset($content['poster']) ? $content['poster'] : '';
                        $resource_content['resource_is_vertical'] = isset($content['is_vertical']) ? $content['is_vertical'] : '';
                        $resource_content['resource_is_fb_thumb'] = isset($content['is_fbthumb']) ? $content['is_fbthumb'] : '';
                        $resource_content['resource_is_vertical_15x22'] = isset($content['is_vertical_15x22']) ? $content['is_vertical_15x22'] : '';
                        $resource_content['resource_is_horizontal_26x17'] = isset($content['is_horizontal_26x17']) ? $content['is_horizontal_26x17'] : '';
                        $resource_content['resource_is_square'] = isset($content['is_square']) ? $content['is_square'] : '';
                        $resource_content['resource_file_thumb'] = isset($content['video_thumb']['main']) ? $content['video_thumb']['main'] : '';

                        // if filetype = audio add new resource_duration when get Object detail.
                        $resource_content['resource_duration'] = isset($content['duration']) ? $content['duration'] : '';
                        $resource_content['resource_additional_info'] = isset($content['additional_info']) ? $content['additional_info'] : '';

                        $r = Resource::findOne($content['res_id']);
                        if ($r) {
                            $resource_content['resource_path'] = $r->path;
                            $resource_content['resource_type'] = $r->type;
                            $resource_content['resource_url'] = $r->path;
                            $resource_content_list[] = $resource_content;
                        }
                    }
                    $resource['resource_content'] = $resource_content_list;
                } else {
                    $resource['resource_content'] = [];
                }
                $result[] = $resource;
            }

            return $result;
        } catch (\Exception $e) {
            echo "\n";
            echo 'Class ' . get_called_class() . ' - ' . $e->getMessage() . ' - Line: ' . $e->getLine();
        }
    }

    /**
     * @param $object_id
     * @return array
     */
    private static function getObjectPoster($object_id)
    {
        $poster = [];
        $resources = self::getObjectResourcesById($object_id);

        if (!empty($resources)) {
            foreach ($resources as $resource_list) {
                if (!empty($resource_list['resource_content'])) {
                    foreach ($resource_list['resource_content'] as $resource) {
                        if (isset($resource['resource_poster']) && $resource['resource_poster'] == 1) {
                            $poster = [
                                'file' => $resource['resource_url'],
                                'thumb' => isset($resource['resource_file_thumb']) ? $resource['resource_file_thumb'] : ''
                            ];
                            break;
                        }
                    }
                }
            }
        }
        return $poster;
    }

    public function updateAtype(&$atype, $icons)
    {
        if (is_array($icons)) {
            if (in_array(ObjectConstant::OBJECT_ICON_VIDEO, $icons)) {
                $atype['video'] = true;
            } else {
                $atype['video'] = false;
            }

            if (in_array(ObjectConstant::OBJECT_ICON_AUDIO, $icons)) {
                $atype['audio'] = true;
            } else {
                $atype['audio'] = false;
            }

            if (in_array(ObjectConstant::OBJECT_ICON_GALLERY, $icons)) {
                $atype['gallery'] = true;
            } else {
                $atype['gallery'] = false;
            }
        }
    }

    public function liveObject($type, $objId, $live)
    {
        $params = [
            'index' => $this->defaultIndex,
            'type' => $type
        ];
        $params['id'] = $objId;
        $params['body']['doc']['isLive'] = true;
        $params['body']['doc']['live'] = $live;

        return $this->update($params, true);
    }
}