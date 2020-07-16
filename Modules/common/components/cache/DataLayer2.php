<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 27/04/2018
 * Time: 09:47
 */

namespace common\components\cache;

use common\components\zyz\XmlHelpers;

class DataLayer
{
    // For constant comment
    const KEY_APP_DETAIL = '_key::app::detail_';
    const KEY_COMMENT_DETAIL = '_key::app::object::comment::detail_';
    const KEY_LIST_COMMENT_BY_OBJECT_ID = '_key::list::comment::by::object_';
    const KEY_LIST_COMMENT_DETAIL_BY_OBJECT_ID = '_key::list::comment::detail::by::object_';
    const KEY_LIST_COMMENT_ROOT_NEWEST_BY_OBJECT_ID = '_key::list::comment::root::newest::by::object_';
    const KEY_LIST_COMMENT_ROOT_MOST_LIKE_BY_OBJECT_ID = '_key::list::comment::root::most::like::by::object_';
    const KEY_LIST_COMMENT_CHILD_NEWEST_BY_OBJECT_ID = '_key::list::comment::child::newest::by::object_';
    const KEY_LIST_COMMENT_CHILD_MOST_LIKE_BY_OBJECT_ID = '_key::list::comment::child::most::like::by::object_';

    const KEY_LIKE_BY_OBJECT_ID = '_key::like::by::object_';
    const UNDERSCORE = '_';

    // use to prevent duplicate cache key in using other sites.
    const MAX_COMMENT_PER_OBJECT = 500;
    const MAX_COMMENT_NEWEST = 500;
    const MAX_COMMENT_MOST_LIKE = 500;
    const MAX_OBJECT_MOST_COMMENT = 500;

	const KEY_OBJECT_ORIGINAL = '_key::object::original_';
	const KEY_LATEST_OBJECT_ARTICLES = '_klobart_';
	const KEY_LATEST_OBJECT_TAG_PROFILE = '_klobtgprf_';
	const KEY_TERMS = '_ktrm_';
	const KEY_VEL='_kv_pageId_cluster_';
	const KEY_DULICH_TERM = '_dl_ktrm_';
	const KEY_DULICH_OBJECT_DETAIL = '_dl_objdt_';
	const KEY_OBJECT_TERM_PRIORITY = '_kobtrmprt_';
	const KEY_BLOCKS = '_kblk_';
	const KEY_PAGES = '_kpg_';
	const KEY_MANUAL_QUEUES = '_kmq_';
    const KEY_ACTIVE_QUEUES = '_kaq_';
	const KEY_OBJECT_DETAIL = '_kobdt_';
	const KEY_MOST_VIEW_OBJECTS = '_kmstvwob_';
	const KEY_MOST_VIEW_COMMENTS = '_kmostvwcms_';
	const KEY_OBJECT_COMMENTS = '_kobcms_';
	const KEY_LIST_BY_TAG = '_klbt_';
	const KEY_MENU = '_kmnu_';
	const KEY_TAG_PROFILE_BY_TAG = '_ktprfdbtg_';
	const KEY_OBJECT_RANDOM_KEY = '_ordk_';
    const KEY_USERS = '_kuser_';
    const MAX_OBJECTS_PRIOR = 20;
	const MAX_OBJECT_PER_TRANSACTION = 1000;
    const KEY_CHARACTERS = '_kchar_';
    const KEY_LIST_BY_CHARACTER = '_klbc_';
    const KEY_LIST_CHARACTER = '_klc_';
    const KEY_LIST_BY_MEMBER = '_klbm_';
    const KEY_CHILD_OBJECT_DETAIL = '_kcobdt_';
    const KEY_MAPPING_BY_ID = '_kmbi_';
    const KEY_MAPPING_BY_TARGET = '_kmbt_';

    const MAX_OBJECTS_PER_PRIOR_PAGE = 20;
	const KEY_TERM_LIST = '_ktrml_';
	const KEY_TERM_SLUG = '_tsl_';
	const KEY_CRITERIA = '_crt_';
	const KEY_CONTENT_LIST = '_ctl_';
	const KEY_OBJECT_LIST = '_obj_';
	const KEY_PAGE_LIST = '_pge_';
	const KEY_BLOCK_LIST = '_blk_';
	const KEY_PAGE_BLOCK_LIST = '_pbk_';
	const KEY_OBJECT_ATTR_LIST = '_list_by_object_attr_';
	const KEY_PAGE_SLUG = '_psl_';
	const KEY_TAG = '_tag_';
	const KEY_META = '_mt_';
	const KEY_MANUAL_BY_OBJECT = '_maobjk_';
	const KEY_SPORT_OBJECT_LIST = '_sport_list_with_prior_';

	const KEY_OBJECT_META_ICON = '_kobjmeta_icon_';

	const KEY_INTERATIVE_BY_OBJECT = '_iobjk_';
	const KEY_ASSET_LAYOUT = '_alk_';
	const KEY_ARTICLE_PARAMS = '_artpam_';
	const KEY_TERM_LIST_NEW = '_ktrml2018_';
	//object_meta_new
	const KEY_META_NEW = '_mt2018_';
	// Event
    const KEY_OBJ_LIVE = '_kobli_';
    const KEY_EVENT_DETAIL = '_kevdt_';

    // Most view
    const KEY_MOST_VIEW_APP = '_kmsvwoba_';
    const KEY_MOST_VIEW_APP_CAT = '_kmsvwobac_';

	const MAX_OBJECT_PER_TERM = 500;
	const MAX_OBJECT_PER_META = 500;
    const MAX_EVENT_PER_OBJECT = 500;
	const MAX_OBJECT_PER_TAG = 500;
	const MAX_OBJECT_NO_TERM = 20000;
	const MAX_OBJECT_DETAILS = 10000;
	const MAX_OBJECTS_PER_TAG_PAGE = 500;
	const MAX_OBJECTS_OBJECT_ATTR = 500;

	// define MAX NUMBER
	const MAX_OBJECTS_RELATED = 10;
	const MAX_OBJECTS_PER_TERM_PAGE = 10;
	const MAX_OBJECTS_PER_QUEUE_PAGE = 10;
	const MAX_OBJECTS_PER_CHARACTER = 10;
	const MAX_NUMBER_CHARACTER = 20;

    const MAX_OBJECTS_PER_MEMBER = 10;

	const MIN_DATE_LIST = 7200;
	const TIME_ON_DATE = 86400;

	const KEY_APP = '_am';
	const KEY_STORAGE = '_sik_';
	const KEY_TOPTAG = '_kttg_';

    const MOSTVIEW_DAY_LIMIT = 3000;

    // tweet
    const KEY_TWEET_NEW = '_ktn_';
    const MAX_TWEET_NUM = 50;

    // Video
    const KEY_VIDEO_INFO = '_vids_';

	// use to prevent duplicate cache key in using other sites.
	public $prefix = '';

	/*------------------ BEGIN GET KEY FUNCTIONS ------------------*/

	/**
	 * Get the cache keys for Cache
	 *
	 * @param $type
	 * @param array $params
	 * @return string
	 */
	public function getKeys($type, $params = array('prior' => 0, 'id' => 0) , $app_id = 12)
	{
		switch ($type) {
            case 'tweet':
                return $this->getTweetKeys();
                break;
            case 'live':
                return $this->getEventKeys($params['mode'], $params['keys'], $params['object_id'], $params['object_type']);
                break;
			case 'sport_object_list':
				return $this->getSportObjectListKey($params['prior']);
				break;

            case 'app':
                return $this->getAppKey($params);
                break;

			case 'object_original':
				return $this->getObjectOriginalKey($params['id']);
				break;

			case 'latest_object_articles':
				return $this->getLatestObjectArticleKey();
				break;
			case 'latest_object_tag_profile':
				return $this->getLatestObjectTagProfileKey();
				break;

			case 'terms':
				return $this->getTermsKey($params['id']);
				break;

			case 'term_list':
				return $this->getTermListKey($params['id'], $params['prior']  , $app_id);

			case 'object_attr_list':
				return $this->getObjectAttrListKey($params['attr'], $params['id'], $params['prior']);

			case 'object_term_prior':
				return $this->getObjectTermPriorKey($params['prior']);
				break;

			case 'blocks':
				return $this->getBlocksKey($params['id']);
				break;

			case 'pages':
				return $this->getPagesKey($params['id']);
				break;

			case 'manual_queues':
				return $this->getManualQueuesKey($params['id']);
				break;

            case 'active_queues':
                return $this->getActiveQueuesKey($params['id']);
                break;

			case 'object_detail':
				return $this->getObjectDetailKey($params['id']);
				break;

            case 'event_detail':
				return $this->getEventDetailKey($params['id']);
				break;

			case 'most_view_objects':
				return $this->getMostViewObjectsKey();
				break;

            case 'most_view_app':
                return $this->getMostViewObjectKeys($params['app_id']);
                break;

            case 'most_view_app_cat':
                return $this->getMostViewObjectKeys($params['app_id'] , $params['cat_id']);
                break;

			case 'most_view_comments':
				return $this->getMostViewCommentsKey();
				break;

			case 'object_comments':
				return $this->getObjectCommentsKey();
				break;

			case 'tagprofile_by_tag':
				return $this->getTagProfileByTagKey($params['id']);
				break;

			case 'page_blocks':
				return $this->getPageBlocksKey($params['id']);
				break;

			case 'object_meta':
				return $this->getObjectMetaKey($params['meta_key'], $params['meta_value'], $params['object_type'] , $app_id);
				break;

			case 'list_by_tag':
				return $this->getListByTagKey($params['id']);
				break;

			case 'menu':
				return $this->getMenuKey($params['id']);
				break;

			case 'random':
				return $this->getObjectRandomKey($params['key']);
				break;

            case 'key_storage':
                return $this->getKeyStorage($params['id']);
                break;

			case 'top_tag':
				return $this->getTopTag();
				break;

			case 'tags':
				return $this->getTagKey($params['id']);
				break;
			case 'manualbyobject':
				return $this->getManualByObjectKey($params['id']);
				break;
			case 'dulichterm':
				return $this->getDulichTermKey($params['id']);
				break;
			case 'dulich_object_detail':
				return $this->getDulichObjectDetailKey($params['id']);
				break;
			case 'object_meta_icon': // NQP
				return $this->getObjectMetaIconKey($params);
				break;
			case 'interative': // vinh banh <apacheservices68@gmail.com>
				return $this->getInterativeObjectKey($params['id']);
				break;
			case 'asset': // vinh banh <apacheservices68@gmail.com>
				return $this->getAssetKey($params['id']);
				break;
			case 'article_params': // vinh banh <apacheservices68@gmail.com>
				return $this->getArticleParams($params['id']);
				break;
			case 'term_list_new': // vinh banh <apacheservices68@gmail.com>
				return $this->getTermListNewKey($params['id'], $params['prior'] , $app_id);

			case 'object_meta_new': // vinh banh <apacheservices68@gmail.com>
				return $this->getObjectMetaKeyNew($params['meta_key'], $params['meta_value'], $params['object_type'] , $app_id);

            // 	define key for comment
            case 'list_comment_root_most_like_by_object_id':

                return $this->getListCommentRootMostLikeByObjectIdKey($params['app_id'],$params['object_id']);

            case 'list_comment_root_newest_by_object_id':

                return $this->getListCommentRootNewestByObjectIdKey($params['app_id'],$params['object_id']);

            case 'list_comment_child_most_like_by_object_id':

                return $this->getListCommentChildMostLikeByObjectIdKey($params['app_id'],$params['object_id'],$params['parent_id']);

            case 'list_comment_child_newest_by_object_id':

                return $this->getListCommentChildNewestByObjectIdKey($params['app_id'],$params['object_id'],$params['parent_id']);

            case 'list_comment_detail_by_object_id':

                return $this->getListCommentDetailByObjectIdKey($params['app_id'],$params['object_id']);
            case 'users':
                return $this->getUsersKey($params['id']);
                break;
            case 'video_info':
                return $this->getVideoInfoKey($params['id']);

            case 'characters':
                return $this->getCharactersKey($params['id']);
                break;
            case 'list_by_character':
                return $this->getListByCharacterKey($params['id']);
                break;
            case 'list_character':
                return $this->getListCharacterKey($params['id']);
                break;
            case 'list_by_member':
                return $this->getListByMemberKey($params['id'], $app_id);
                break;
            case 'list_by_character_mapping':
                return $this->getListByCharacterWithMappingKey($params['id']);
                break;
            case 'child_object_detail':
                return $this->getChildObjectDetailKey($params['id']);
                break;
            case 'mapping_by_id':
                return $this->getMappingKeyById($params['id']);
                break;
            case 'mapping_by_target':
                return $this->getMappingKeyByTarget($params['id'], $params['type']);
                break;
            case 'veldet2':
                return $this->getVelKey($params['id'],$params['cluster']);
			default:
				# code...
				break;
		}
	}

    /**
     * @param $id
     * @return string
     */
    public function getTweetKeys()
    {
	    return $this->prefix . self::KEY_TWEET_NEW . self::MAX_TWEET_NUM;
    }

    /**
     * get key article params to check priority
     *
     * @param $id
     * @return string
     */
    public function getArticleParams( $id )
    {
        return $this->prefix . self::KEY_ARTICLE_PARAMS . $id;
    }

    // VB <apacheservices68@gmail.com>

    /**
     * @param $key
     * @param $value
     * @param $object_type
     * @param $app_id
     * @return string
     */
    private function getObjectMetaKeyNew($key, $value, $object_type , $app_id = 12)
    {
        #return $this->prefix . self::KEY_META_NEW . $object_type . '_' . $key . '_' . $value;
        return $app_id === 12 ?
            $this->prefix . self::KEY_META_NEW . $object_type . '_' . $key . '_' . $value :
            $this->prefix . self::KEY_META_NEW . $object_type . '_' . intval($app_id) . '_' . $key . '_' . $value;
    }

	/**
	 * @param $id
	 *
	 * @return string
	 */
	private function getKeyStorage($id)
    {
        return $this->prefix . self::KEY_STORAGE . $id;
    }

	/**
	 * @return string
	 */
	private function getTopTag()
	{
		return $this->prefix . self::KEY_TOPTAG;
	}

    private function getAppKey($params)
    {
        $type = isset($params['type']) ? 1 : null;
        return ($type === null) ? $this->prefix . self::KEY_APP : $this->prefix . self::KEY_APP . '_' . $type;
    }

    // VB

    /**
     * @param $id
     * @param $prior
     * @param int $app_id
     * @return string
     */
    private function getTermListNewKey($id, $prior  , $app_id = 12)
    {
        if (is_array($prior))
            $prior = implode('_', $prior);
        #return $this->prefix . self::KEY_TERM_LIST_NEW . $id . '_' . $prior;
        return ($app_id === 12) ?
            $this->prefix . self::KEY_TERM_LIST_NEW . $id . '_' . $prior :
            $this->prefix . self::KEY_TERM_LIST_NEW . $id . '_' . intval($app_id) . '_' . $prior
            ;
    }


    public function getManualByObjectKey($id)
    {
        return $this->prefix . self::KEY_MANUAL_BY_OBJECT . $id;
    }
    /**
     * get object original key
     *
     * @param $id
     * @return string
     */
    public function getObjectOriginalKey($id)
    {
        return $this->prefix . self::KEY_OBJECT_ORIGINAL . $id;
    }

    public function getSportObjectListKey($prior)
    {
        return $this->prefix . self::KEY_SPORT_OBJECT_LIST . $prior;
    }

    /**
     * get cache key for menu
     *
     * @param $id
     * @return string
     */
    private function getMenuKey($id)
    {
        return $this->prefix . self::KEY_MENU . $id;
    }

    /**
     * get cache key for object meta
     * VB <apacheservices68@gmail.com>
     *
     * @param $key
     * @param $value
     * @param $object_type
     * @param $app_id
     * @return string
     */
    private function getObjectMetaKey($key, $value, $object_type , $app_id = 12)
    {
        #return $this->prefix . self::KEY_META . $object_type . '_' . $key . '_' . $value;
        return $app_id === 12 ?
            $this->prefix . self::KEY_META . $object_type . '_' . $key . '_' . $value :
            $this->prefix . self::KEY_META . $object_type . '_' . ($app_id) . '_' . $key . '_' . $value;
    }

    /**
     * Get Cache key for event live
     *
     * @param $mode
     * @param $key
     * @param $object_id
     * @param $object_type
     * @return string
     */
    private function getEventKeys($mode , $key , $object_id , $object_type)
    {
        return $this->prefix . self::KEY_OBJ_LIVE . $object_type . '_' . $mode .'_' . $key . '_'. $object_id;
    }

    /**
     * Get the cache keys for Latest Object Article
     *
     * @return string  the key
     **/
    private function getLatestObjectArticleKey()
    {
        return $this->prefix . self::KEY_LATEST_OBJECT_ARTICLES;
    }

    /**
     * Get the cache keys for Object Tag Profile
     *
     * @return string  the key
     **/
    private function getLatestObjectTagProfileKey()
    {
        return $this->prefix . self::KEY_LATEST_OBJECT_TAG_PROFILE;
    }

    /**
     * get term list key
     *
     * @param $id
     * @param $prior
     * @param $app_id
     * @return string
     */
    private function getTermListKey($id, $prior , $app_id = 12)
    {
        if (is_array($prior))
            $prior = implode('_', $prior);
        #return $this->prefix . self::KEY_TERM_LIST . $id . '_' . $prior;
        return ($app_id === 12) ?
            $this->prefix . self::KEY_TERM_LIST . $id . '_' . $prior :
            $this->prefix . self::KEY_TERM_LIST . $id . '_' . intval($app_id) . '_' . $prior;
    }

    /**
     * get object list by object attr
     *
     * @param $attr
     * @param $id
     * @param $prior
     * @return string
     */
    private function getObjectAttrListKey($attr, $id, $prior)
    {
        return $this->prefix . self::KEY_OBJECT_ATTR_LIST . $attr . '_' . $id . '_' . $prior;
    }

    /**
     * Get keys for term details
     *
     * @param $id
     * @return string
     */
    private function getTermsKey($id)
    {
        return $this->prefix . self::KEY_TERMS . $id;
    }

    private function getVelKey($page_id,$cluster){
        return $this->prefix. self::KEY_VEL. $page_id.'_'.$cluster;
    }
    /**
     * Get keys for term details
     *
     * @param $id
     * @return string
     */
    private function getUsersKey($id)
    {
        return $this->prefix . self::KEY_USERS . $id;
    }

    /**
     * Get stream information key
     *
     * @param $id
     * @return string
     */
    private function getVideoInfoKey($id)
    {
        return $this->prefix . self::KEY_VIDEO_INFO . $id;
    }

    /**
     * Get the cache keys for Object Term Priority
     * @param  integer $prior , prior=1 for prioritity level 1,
     * prior=2 for priority level 2, prior=3 for priority level 3, defaul prior=1
     * @return string  the key
     **/
    private function getObjectTermPriorKey($prior)
    {
        return $this->prefix . self::KEY_OBJECT_TERM_PRIORITY . $prior;
    }

    /**
     * Get the cache keys for Site Priority
     *
     * @param $id
     * @return string
     */
    private function getBlocksKey($id)
    {
        return $this->prefix . self::KEY_BLOCKS . $id;
    }

    /**
     * Get the cache keys for Site Priority
     *
     * @param $id
     * @return string
     */
    private function getPagesKey($id)
    {
        return $this->prefix . self::KEY_PAGES . $id;
    }

    /**
     * Get the cache keys for Site Priority
     * @param  integer $id , is id of manual queue
     * @return string  the key
     **/
    private function getManualQueuesKey($id = 0)
    {
        return $this->prefix . self::KEY_MANUAL_QUEUES . $id;
    }

    /**
     * Get the cache keys for active list object
     * @param  integer $id , is id of manual queue
     * @return string  the key
     **/
    private function getActiveQueuesKey($id = 0)
    {
        return $this->prefix . self::KEY_ACTIVE_QUEUES . $id;
    }

    /**
     * Get the cache keys for Object detail
     * @param  integer $id , is id of object
     * @return string  the key
     **/
    private function getObjectDetailKey($id)
    {
        return $this->prefix . self::KEY_OBJECT_DETAIL . $id;
    }

    /**
     * Get the cache keys for Event detail
     * @param  integer $id , is id of event
     * @return string  the key
     **/
    private function getEventDetailKey($id)
    {
        return $this->prefix . self::KEY_EVENT_DETAIL . $id;
    }

    /**
     * Get the cache keys for tagprofile detail
     * @param  integer $id , is id of object
     * @return string  the key
     **/
    private function getTagProfileByTagKey($id)
    {
        return $this->prefix . self::KEY_TAG_PROFILE_BY_TAG . $id;
    }

    /**
     * get most view object
     * @return string
     */
    private function getMostViewObjectsKey()
    {
        return $this->prefix . self::KEY_MOST_VIEW_OBJECTS;
    }

    /**
     * Get most view object keys
     *
     * @param int $app
     * @param int $cat
     * @return string
     */
    private function getMostViewObjectKeys($app =1 , $cat = 0)
    {
        return $cat == 0 ? $this->prefix . self::KEY_MOST_VIEW_APP . $app : $this->prefix . self::KEY_MOST_VIEW_APP_CAT .$app . "_".$cat;
    }

    /**
     * Get the cache keys for Most view comment list
     * @return string  the key
     **/
    private function getMostViewCommentsKey()
    {
        return $this->prefix . self::KEY_MOST_VIEW_COMMENTS;
    }

    /**
     * Get the cache keys for Object Comment
     * @return string  the key
     **/
    private function getObjectCommentsKey()
    {
        return $this->prefix . self::KEY_OBJECT_COMMENTS;
    }

    /**
     * get page and block relationship key
     * @param $id
     * @return string
     */
    private function getPageBlocksKey($id)
    {
        return $this->prefix . self::KEY_PAGE_BLOCK_LIST . $id;
    }

    /**
     * get list tag key
     * @param $id
     * @return string
     */
    private function getListByTagKey($id)
    {
        return $this->prefix . self::KEY_LIST_BY_TAG . $id;
    }

    /**
     * get object detail with random key
     *
     * @param $key
     * @return string
     */
    private function getObjectRandomKey($key)
    {
        return $this->prefix . self::KEY_OBJECT_RANDOM_KEY . $key;
    }

    private function getTagKey($key)
    {
        return $this->prefix . self::KEY_TAG . $key;
    }

    private function getDulichTermKey($id)
    {
        return $this->prefix . self::KEY_DULICH_TERM . $id;
    }

    private function getDulichObjectDetailKey($id)
    {
        return $this->prefix . self::KEY_DULICH_OBJECT_DETAIL . $id;
    }

    private function getObjectMetaIconKey($patterns){
        return $this->prefix . self::KEY_OBJECT_META_ICON . $patterns[0] . '_prior_' . $patterns[1];
    }

    private function getInterativeObjectKey($id){ # Contact vinh banh <apacheservices68@gmail.com>
        return $this->prefix . self::KEY_INTERATIVE_BY_OBJECT . $id;
    }

    private function getAssetKey($id){ # Contact vinh banh <apacheservices68@gmail.com>
        return $this->prefix . self::KEY_ASSET_LAYOUT . $id;
    }
    /*------------------ END GET KEY FUNCTIONS ------------------*/


    /*--------------- BEGIN BUILD CACHE FUNCTIONS ------------------*/

    public function getListWithSportObject($prior)
    {
        $message = "Begin get list with sport object";
        self::log($message);
    }

    public function buildListWithSportObject($host, $prior, $max)
    {
        $message = "Begin build list with sport object";
        self::log($message);
    }

    public function buildObjectWithRandomKey($key, $data, $expire = 0)
    {
        $message = "Begin build object with random key = " . $key . " and data = " . is_array($data)?var_dump($data):$data . " and expire = " . $expire;
        self::log($message);
    }

    /**
     * build list with meta
     *
     * @param $meta_key
     * @param $meta_value
     * @param string $object_type
     * @param array $object_ids
     */
    public function buildListByMeta($meta_key, $meta_value, $object_type = 'article' , $object_ids = [])
    {
        $message = "Begin build list by meta with meta_key = " . $meta_key . " and meta_value = " . $meta_value . " and object_type = " . $object_type;
        self::log($message);
    }

    /**
     * build list with tag
     *
     * @param $id
     */
    public function buildListByTag($id)
    {
        $message = "Begin build list by tag with id = " . $id;
        self::log($message);
    }

    /**
     * build term details
     *
     * @param int $id
     */
    public function buildTerms($id = 0)
    {
        $message = ($id == 0) ? "Begin build all terms" : "Begin build term with id = " . $id;
        self::log($message);
    }

    /**
     * build block details
     *
     * @param int $id
     */
    public function buildBlocks($id = 0)
    {
        $message = ($id == 0) ? "Begin build all blocks" : "Begin build block with id = " . $id;
        self::log($message);
    }

    /**
     * build page details
     *
     * @param int $id
     */
    public function buildPages($id = 0)
    {

        $message = ($id == 0) ? "Begin build all pages" : "Begin build page with id = " . $id;
        self::log($message);
    }

    public function buildTags($id = 0)
    {
        $message = ($id == 0) ? "Begin build all tags" : "Begin build tag with id = " . $id;
        self::log($message);
    }

    /**
     * build manual queues
     *
     * @param int $id
     */
    public function buildManualQueues($id = 0)
    {
        $message = ($id == 0) ? "Begin build all queues" : "Begin build queue with id = " . $id;
        self::log($message);
    }

    /**
     * build object details
     *
     * @param int $id
     */
    public function buildObjects($id = 0, $force_slug = false)
    {
        $message = ($id == 0) ? "Begin build all objects" : "Begin build object with id = " . $id;
        self::log($message);
    }

    /**
     * build comment number of object
     *
     * @param int $id
     * @param int $comment_number
     */
    public function buildCommentObjects($id = 0, $comment_number = 0, $question_number = 0, $answer_number = 0)
    {
        $message = ($id == 0) ? "Begin build all number of object comments" : "Begin build comment number of object with id = " . $id;
        self::log($message);
    }

    /**
     * build list by term
     *
     * @param $id
     * @param $prior
     * @param string $object_type
     */
    public function buildListByTerm($id, $prior, $object_type = 'article')
    {
        $message = "Begin build list by term with id = " . $id . " and prior = " . $prior . " and object_type = " . $object_type;
        self::log($message,'trace');
    }

    public function buildDulichList($key=''){
    }

    /**
     * @param $attr
     * @param int $tid
     * @param string $object_type
     * @param array $between_date
     */
    public function buildListByObjectAttr($attr, $tid = -1, $object_type = 'article', $between_date = array())
    {
        self::log("Build list object by object attr with params: ". serialize(func_get_args()) );
    }

    /**
     * build term
     *
     * @param $id
     */
    public function buildMenu($id)
    {
        $message = "Begin build menu with id = " . $id;
        self::log($message);
    }

    /*--------------- END BUILD CACHE FUNCTIONS ------------------*/


    /*--------------- BEGIN GET CACHE FUNCTIONS  ------------------*/

    /**
     * get list by term id and term prior
     *
     * @param int $id
     * @param int $prior
     * @param int $number
     * @param string $page
     * @param string $object_type
     * @param string $return_type
     * @param bool $total_in_term
     * @param array $between_date
     * @param array $exclude_term_ids
     * @param int $app_id
     */
    //($id, $prior, $number, $page, $object_type = self::OBJECT_TYPE_DEFAULT, $between_date, $exclude_term_ids)
    //public function getListByTerm($id = 0, $prior = 0, $number = self::MAX_OBJECTS_PER_TERM_PAGE, $page = '0', $object_type = 'article', $return_type = 'array', &$total_in_term = false, $between_date = array(), $exclude_term_ids = array())
    public function getListByTerm($id = 0,
                                  $prior = 0,
                                  $number = self::MAX_OBJECTS_PER_TERM_PAGE,
                                  $page = '0',
                                  $object_type = 'article',
                                  $between_date = array(),
                                  $exclude_term_ids = array(),
                                  $return_type = 'array',
                                  $total_in_term = false,
                                  $app_id  = 12
    ){
        $message = "\n Begin get list by term with details: ";
        $message .= "\n  [*] id = " . $id;
        $message .= "\n  [*] prior = " . is_array($prior) ? var_dump($prior) : $prior;
        $message .= "\n  [*] number = " . $number;
        $message .= "\n  [*] page = " . $page;
        $message .= "\n  [*] object type = " . $object_type;
        $message .= "\n  [*] between_date = " . serialize($between_date);
        $message .= "\n  [*] exclude_term_ids = " . serialize($exclude_term_ids);
        $message .= "\n  [*] return_type = " . is_array($return_type) ? var_dump($return_type) : $return_type;
        $message .= "\n  [*] total in term = " . intval($total_in_term);
        $message .= "\n  [*] app id = " . $app_id;
        self::log($message);
    }


    /**
     * get list object by object attr
     *
     * @param $attr
     * @param $tid
     * @param $prior
     * @param string $object_type
     * @param array $between_date
     */

    public function getListByObjectAttr($attr, $tid = -1, $number = 20, $page = 0, $between_date = array())
    {
        self::log("Build list object by object att");
    }

    /**
     * get list by meta
     *
     * @param $meta_key
     * @param $meta_value
     * @param int $number
     * @param string $page
     * @param string $object_type
     * @param array $between_date
     * @param array $exclude_object_ids
     * @param string $return_type
     * @param integer $app_id
     */
    public function getListByMeta($meta_key, $meta_value, $number = self::MAX_OBJECTS_PER_PRIOR_PAGE, $page = '0', $object_type = 'article', $between_date = array(), $exclude_object_ids = array(), $return_type = 'array' , $app_id = 12)
    {
        $message = "\n Begin get list by meta with details: ";
        $message .= "\n  [*] meta_key = " . $meta_key;
        $message .= "\n  [*] meta_value = " . $meta_value;
        $message .= "\n  [*] number = " . $number;
        $message .= "\n  [*] page = " . $page;
        $message .= "\n  [*] object_type = " . $object_type;
        $message .= "\n  [*] between_date = " . serialize($between_date);
        $message .= "\n  [*] exclude_object_ids = " . serialize($exclude_object_ids);
        $message .= "\n  [*] return_type = " . $return_type;
        $message .= "\n  [*] app_id = " . $app_id;
        self::log($message);
    }

    /**
     * get list by queue
     *
     * @param $id
     * @param $number
     * @param string $page
     * @param array $between_date
     * @param array $exclude_term_ids
     */
    public function getListByQueue($id, $number = self::MAX_OBJECTS_PER_QUEUE_PAGE, $page = '0', $object_type = 'article', $between_date = array(), $exclude_term_ids = array())
    {
        self::log('Begin get list by queue with id = ' . $id);
    }

    /**
     * get list by tag
     *
     * @param $id
     * @param int $number
     * @param string $page
     * @param string $object_type
     * @param array $between_date
     * @param array $exclude_term_ids
     * @param string $return_type
     */
    public function getListByTag($id, $number = self::MAX_OBJECTS_PER_TAG_PAGE, $page = '0', $object_type = 'article', $between_date = array(), $exclude_term_ids = array(), $return_type = 'array')
    {
        $message = "\n Begin get list by tag with details: ";
        $message .= "\n  [*] id = " . $id;
        $message .= "\n  [*] number = " . $number;
        $message .= "\n  [*] page = " . $page;
        $message .= "\n  [*] object_type = " . $object_type;
        $message .= "\n  [*] between_date = " . serialize($between_date);
        $message .= "\n  [*] exclude_object_ids = " . serialize($exclude_object_ids);
        $message .= "\n  [*] return_type = " . $return_type;
        self::log($message);
    }

    /**
     * get term details
     *
     * @param $param
     * @param string $mode
     */
    public function getTermDetail($param, $mode = 'id')
    {
        self::log('Begin get term details with ' . $mode . ' = ' . $param);
    }

    /**
     * get tag details
     *
     * @param $param
     * @param string $mode
     */
    public function getTagDetail($param, $mode = 'id')
    {
        self::log('Begin get tag details with ' . $mode . ' = ' . $param);
    }

    /**
     * get page details
     *
     * @param $param
     * @param string $mode
     */
    public function getPageDetail($param, $mode = 'id')
    {
        self::log('Begin get page details with ' . $mode . ' = ' . $param);
    }

    /**
     * get block details
     *
     * @param $id
     */
    public function getBlockDetail($id)
    {
        self::log('Begin get block details with id = ' . $id);
    }

    /**
     * get page and block relationship
     *
     * @param $id
     * @param $region
     */
    public function getPageBlocks($id, $region = -1)
    {
        self::log('Begin get blocks in page with id= ' . $id . ' and region= ' . $region);
    }

    /**
     * get menu details
     *
     * @param $id
     */
    public function getMenu($id)
    {
        self::log('Begin get menu with id = ' . $id);
    }

    /**
     * get object details
     * @param $id
     */
    public function getObjectDetail($id)
    {
        self::log('Begin get object details with id = ' . $id);
    }

    /**
     * get event details
     *
     * @param $id
     */
    public function getEventDetail($id)
    {
        self::log('Begin get event details with id = '. $id );
    }

    /**
     * get object with random key
     * @param $key
     */
    public function getObjectWithRandomKey($key)
    {
        self::log('Begin get object with random key = ' . $key);
    }

    public function getMostViewObjects($tid = -1, $between_date = array())
    {
        self::log('Begin get most view objects with term id '. $tid);
    }

    public function getMostLikedObject($type = 'mixed', $term, $start, $end, $number)
    {

    }

    public function getMostComments($app_id, $cat_id, $limit)
    {

    }

    public function getRangeComments($start, $type = 'article', $number = 10)
    {

    }

    public function getObjectComments($id)
    {

    }

    /*------------------ END GET CACHE FUNCTIONS ------------------*/


    /*------------------ BEGIN CRUD CACHE FUNCTIONS ------------------*/

    /**
     * add object to sorted set
     *
     * @param $mode_key
     * @param $score
     * @param $member
     */
    public function addMemberToSortedSet($mode_key, $score, $member)
    {
        $message = "Add member " . $member . " with score " . $score . " to key " . $mode_key;
        self::log($message);
    }

    /**
     * remove object out sorted set
     *
     * @param $mode_key
     * @param $member
     */
    public function removeMemberInSortedSet($mode_key, $member)
    {
        $message = "Delete member " . $member . " in key " . $mode_key;
        self::log($message);
    }

    /**
     * Build key storage item
     *
     * @param $mode_key
     * @param $value
     */
    public function buildKeyStorageItem($mode_key , $value)
    {
        $message = "Begin build value for key " . $mode_key ;
        self::log($message);
    }

    /**
     * @param $mode_key
     */
    public function getKeyStorageItem($mode_key)
    {
        self::log("Begin get key storage item ". $mode_key);
    }

    /**
     * build event details
     *
     * @param int $id
     */
    public function buildEvents($id = 0)
    {
        $message = ($id == 0) ? "Begin build all events" : "Begin build events with events id = " . $id;
        self::log($message);
    }

    /**
     *
     */
    public function buildTweets()
    {
        self::log("Begin build key tweets");
    }

    /**
     *
     */
    public function getKeyTweets()
    {
        self::log("Begin get key tweets = ". self::MAX_TWEET_NUM);
    }
    /**
     * delete cache key
     *
     * @param $key
     */
    public function deleteKeys($key)
    {
        self::log('Begin delete key = ' . $key);
    }

    /**
     * Get Object by Meta Icons
     *
     * @param $key
     * @param $page
     * @param $limit
     */
    public function getObjectsByMetaIcon($key  , $page , $limit )
    {
        $message = "Begin get list object of key : " . $key . " with page : " . $page ." and limit : " . $limit ;
        self::log($message);
    }

    /**
     * @param $app_id
     * @param $limit
     */
    public function getMostViewByApp($app_id , $limit)
    {
        $message = "Begin get most view object list by app : ". $app_id . " with limit : ". $limit;
        self::log($message);
    }

    /**
     * @param $app
     * @param $cat
     * @param $limit
     */
    public function getMostViewByAppCat($app , $cat , $limit){
        $message = "Begin get most view object list by app : ". $app . " and cat id : " . $cat . " with limit : ". $limit;
        self::log($message);
    }

	/**
	 * @param $app_id
	 * @param $limit
	 */
	public function getMostTagViewByApp($app_id , $limit)
	{
		$message = "Begin get most view tag list by app : ". $app_id . " with limit : ". $limit;
		self::log($message);
	}

	/**
	 * @param $app
	 * @param $cat
	 * @param $limit
	 */
	public function getMostTagViewByAppCat($app , $cat , $limit){
		$message = "Begin get most view tag list by app : ". $app . " and cat id : " . $cat . " with limit : ". $limit;
		self::log($message);
	}

    /**
     * @param $tag_id
     */
    public function getTagProfileByTag($tag_id)
    {
        $message = "Begin tag profile by tag id : " . $tag_id;
        self::log($message);
    }

    /**
     * @param $tag_id
     * @param $tag_profile_id
     */
    public function buildTagProfileByTag($tag_id  , $tag_profile_id)
    {
        $message = "Begin tag profile by tag id : " . serialize(func_get_args());
        self::log($message);
    }

    /**
     * @param $mode
     * @param $object_ids
     */
    public function buildListByFeatured($mode  , $object_ids)
    {
        $message = "Begin build list priority for mode : " .$mode;
        self::log($message);
    }

	/**
	 * @param       $app
	 * @param       $cat
	 * @param       $limit
	 * @param array $object_list
	 */
	public function buildMostViewByApp($app , $cat , $limit , $object_list = [])
    {
        self::log(__FUNCTION__  . ' - ' . serialize(func_get_args()));
    }

	/**
	 * @param       $app
	 * @param       $cat
	 * @param       $limit
	 * @param array $object_list
	 */
	public function buildMostTagViewByApp($app , $cat , $limit , $object_list = [])
	{
		self::log(__FUNCTION__  . ' - ' . serialize(func_get_args()));
	}

    /**
     * @param $id
     * @param int $prior
     * @param int $number
     * @param string $page
     * @param array $between_date
     * @param array $exclude_term_ids
     */
    public function getListByTerm2018($id, $prior = 0, $number = 10, $page = '0', $between_date = [], $exclude_term_ids = [])
    {
        self::log(__FUNCTION__  . ' - ' . serialize(func_get_args()));
    }


    /**
     * @param $order
     * @param $page_id
     * @param $object_ids
     * @param string $content_type
     */
    public function buildListFeaturedOrderPage($order , $page_id  , $object_ids , $content_type = 'article')
    {
        $message = "Begin build list priority for mode : " . serialize(func_get_args());
        self::log($message);
    }

    /**
     * @param $id
     */
    public function getObjectOriginal($id)
    {
        $message = "Begin get list priority for mode : " . serialize(func_get_args());
        self::log($message);
    }

    public function buildObjectOriginal($id)
    {
        $message = "Begin build list priority for mode : " . serialize(func_get_args());
        self::log($message);
    }

    /**
     * @param $id
     */
    public function buildVid($id)
    {
        $message = "Begin build video list for resource id ". $id;
        self::log($message);
    }

    /**
     * @param $id
     */
    public function getVid($id)
    {
        $message = "Begin get video list for resource id ". $id;
        self::log($message);
    }

	public function buildTopTagObjList(){
		$message = "Begin build Top tag list for Biem Hoa";
		self::log($message);
	}

    /*------------------ END CRUD CACHE FUNCTIONS ------------------*/


    /*------------------ BEGIN OTHER FUNCTIONS ---------------------*/

    /**
     * return value method
     * @param array $data
     * @param $type
     * @return array|string
     */
    protected static function convertData($data = array(), $type = 'array')
    {
        switch ($type) {
            case 'json':
                return json_encode($data);
                break;
            case 'xml':
                $xml = XmlHelpers::toXml($data, 'objects');
                return $xml;
                break;
            default:
                return $data;
                break;
        }
    }

    /**
     * Yii::log or send request to rabbit for logging
     *
     * @param $message
     * @param $level
     */
    protected static function log($message, $level = 'error')
    {
        if(!isConsole()) return;
        switch($level){
            case 'error':
                $level = 'e';
                break;
            case 'trace':
                $level = 't';
                break;
            default:
                $level = 'o';
                break;
        }
        echo " [". $level ."] ". date('d/m/Y H:i:s'). " - " . $message . "\n";
    }

    /**
     * get list comment newest by object_id
     *
     * @param $app_id
     * @param $object_id
     * @return string
     */
    private function getListCommentRootNewestByObjectIdKey($app_id, $object_id)
    {
        return $this->prefix . self::KEY_LIST_COMMENT_ROOT_NEWEST_BY_OBJECT_ID . $app_id . self::UNDERSCORE . $object_id;
    }

    /**
     * get list comment most like by object_id
     *
     * @param $app_id
     * @param $object_id
     * @return string
     */
    private function getListCommentRootMostLikeByObjectIdKey($app_id, $object_id)
    {
        return $this->prefix . self::KEY_LIST_COMMENT_ROOT_MOST_LIKE_BY_OBJECT_ID . $app_id . self::UNDERSCORE . $object_id;
    }

    /**
     * get list comment most like by object_id
     *
     * @param $app_id
     * @param $object_id
     * @return string
     */
    private function getListCommentChildMostLikeByObjectIdKey($app_id, $object_id, $parent_id)
    {
        return $this->prefix . self::KEY_LIST_COMMENT_CHILD_MOST_LIKE_BY_OBJECT_ID . $app_id . self::UNDERSCORE . $object_id . self::UNDERSCORE . $parent_id;
    }

    /**
     * get list comment newest by object_id
     *
     * @param $app_id
     * @param $object_id
     * @return string
     */
    private function getListCommentChildNewestByObjectIdKey($app_id, $object_id, $parent_id)
    {
        return $this->prefix . self::KEY_LIST_COMMENT_CHILD_NEWEST_BY_OBJECT_ID . $app_id . self::UNDERSCORE . $object_id . self::UNDERSCORE . $parent_id;
    }

    /**
     * get list comment detail by object_id
     *
     * @param $app_id
     * @param $object_id
     * @return string
     */
    private function getListCommentDetailByObjectIdKey($app_id, $object_id)
    {
        return $this->prefix . self::KEY_LIST_COMMENT_DETAIL_BY_OBJECT_ID . $app_id . self::UNDERSCORE . $object_id;
    }

    /**
     * Get keys for character details
     *
     * @param $id
     * @return string
     */
    private function getCharactersKey($id)
    {
        return $this->prefix . self::KEY_CHARACTERS . $id;
    }

    /**
     * get list character key
     * @param $id
     * @return string
     */
    private function getListByCharacterKey($id)
    {
        return $this->prefix . self::KEY_LIST_BY_CHARACTER . $id;
    }

    /**
     * get list character key
     * @param $id
     * @return string
     */
    private function getListCharacterKey($id)
    {
        return $this->prefix . self::KEY_LIST_CHARACTER . $id;
    }

    /**
     * get list object contrib by member
     * @param $id
     * @param $app_id
     * @return string
     */
    private function getListByMemberKey($id, $app_id)
    {
        return $this->prefix . self::KEY_LIST_BY_MEMBER . $id . '_' . intval($app_id);
    }

    /**
     * get child object detail
     * @param $id
     * @param $app_id
     * @return string
     */
    private function getChildObjectDetailKey($id, $app_id = '')
    {
        if (!empty($app_id))
            return $this->prefix . self::KEY_CHILD_OBJECT_DETAIL . $id . '_' . $app_id;
        else
            return $this->prefix . self::KEY_CHILD_OBJECT_DETAIL . $id;
    }

    /**
     * get child object detail
     * @param $id
     * @param $app_id
     * @return string
     */
    private function getMappingKeyById($id, $app_id = '')
    {
        if (!empty($app_id))
            return $this->prefix . self::KEY_MAPPING_BY_ID . $id . '_' . $app_id;
        else
            return $this->prefix . self::KEY_MAPPING_BY_ID . $id;
    }

    /**
     * get child object detail
     * @param $id
     * @param $type
     * @param $app_id
     * @return string
     */
    private function getMappingKeyByTarget($id, $type, $app_id = '')
    {
        if (!empty($app_id))
            return $this->prefix . self::KEY_MAPPING_BY_TARGET . $type . '_' . $id . '_' . $app_id;
        else
            return $this->prefix . self::KEY_MAPPING_BY_TARGET . $type . '_' . $id;
    }

    /**
     * get list character key with mapping
     * @param $id
     * @return string
     */
    private function getListByCharacterWithMappingKey($id)
    {
        return $this->prefix . self::KEY_LIST_BY_CHARACTER . 'mapping_' . $id;
    }

}