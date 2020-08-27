<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/28
 * Time: 下午12:32
 */
class App_Plugin_Weixin_WxxcxClient {

    const WEIXIN_AUTH_NONE  = 0;//未授权微信公众号
    const WEIXIN_AUTH_WRITE = 1;//填写方式授权微信公众号
    const WEIXIN_AUTH_OPEN  = 2;//开发平台方式授权微信公众号

    const DISTRIB_SHARE_CODE_PATH = 'pages/distributionTip/distributionTip';  // 三级分销分享
    const CITY_DISTRIB_SHARE_CODE_PATH = 'subpages0/distributionTip/distributionTip';// 同城三级分销分享
    const MEAL_TABLE_CODE_PATH = 'pages/orderMeal/orderMeal';  // 订餐餐桌页面
    const GOODS_DETAIL_CODE_PATH = 'pages/goodDetail/goodDetail';  // 商品详情页面
    const KNOWPAY_ARTICLE_CODE_PATH = 'pages/zlDetail/zlDetail';  // 知识付费图文商品详情
    const KNOWPAY_AUDIO_CODE_PATH = 'pages/audioDetail/audioDetail';  // 知识付费音频商品详情
    const KNOWPAY_VIDEO_CODE_PATH = 'pages/videoDetail/videoDetail';  // 知识付费视频商品详情
    const BARGAIN_DETAIL_CODE_PATH = 'subpages/bargainGoodDetail/bargainGoodDetail'; //砍价详情页
    const KNOWPAY_BARGAIN_CODE_PATH = 'subpages/bargainDetail/bargainDetail'; //知识付费砍价详情页
    const CONNECT_WIFI_CODE_PATH = 'pages/connectWifi/connectWifi'; //连接wifi
    const CITY_SHOP_CODE_PATH = 'pages/shopDetailnew/shopDetailnew'; //同城店铺详情
    const HOUSE_DETAIL_CODE_PATH = 'pages/houseDetail/houseDetail'; //房产房源详情
    const HOUSE_EXPERT_SHOP_PATH = 'pages/expertShop/expertShop'; //房产专家店铺
    const CITY_POST_DETAIL_PATH = 'pages/postDetail/postDetail'; //同城帖子详情
    const GROUP_DETAIL_CODE_PATH = 'pages/groupGoodDetail/groupGoodDetail'; //拼团详情
    const KNOWPAY_GROUP_CODE_PATH = 'subpages/groupDetail/groupDetail'; //知识付费拼团详情
    const SHOP_GOODS_DETAILS_PATH = 'pages/shopgoodsDetail/shopgoodsDetail';  //  多店店铺商品详情路径
    const DISTRIB_BECOME_PARTNER_PATH = 'pages/becomePartners/becomePartners'; //成为分销商申请页面
    const DISTRIB_BECOME_PARTNER_SUBPATH = 'subpages/becomePartners/becomePartners'; //成为分销商申请页面
    const BUSINESS_CARD_PATH = 'subpages/namecard/namecardDetail/namecardDetail'; //微名片分享名片页
    const SHOP_SERVICE_INFORMATION_PATH = 'pages/articleDetail/articleDetail';//企业版产品服务详情
    const MEAL_STORE_DETAIL_PATH = 'pages/mulShopDetail/mulShopDetail'; //餐饮多店店铺详情
    const ENTERSHOP_DETAIL_PATH = 'pages/shopDetail/shopDetail'; //多店入驻店铺详情
    const CITY_SHOP_GOODS_DETAIL = 'subpages/shopgoodsDetail/shopgoodsDetail';
    const JOB_DETAIL_CODE_PATH = 'pages/jobDetail/jobDetail';  // 职位详情
    const COMPANY_DETAIL_CODE_PATH = 'subpages/companyDetail/companyDetail';  // 公司详情
    const INFORMATION_DETAIL = 'pages/informationDetail/informationDetail';
    const SEQUENCE_ACTIVITY_DETAIL = 'pages/activityDetail/activityDetail';
    const CAR_INDEX_MEMBER = 'pages/index/index';
    const CAR_GOODS_DETAIL = 'pages/productDetail/productDetail';
    const CAR_SHOP_DETAIL = 'pages/serviceproDetail/serviceproDetail';
    const LEGWORK_INDEX_MEMBER = 'pages/index/index';
    const MOBILE_SHOP_DETAIL_PATH = 'subpages/shopInfoDetail/shopInfoDetail'; //电话本店铺详情页
    const SHOP_BLESSING_SHARE_PATH = 'subpages0/yearGreeting/shopGreeting/shopGreeting'; //新年祝福分享
    const MEAL_MALL_GOODS_DETAIL = 'subpages0/goodDetail/goodDetail';
    const GENERAL_RESERVATION_DETAIL1 = "subpages/Generalreservationdetail/Generalreservationdetail"; //付费预约商品详情  营销商城、多店平台、预约服务、知识付费、同城
    const GENERAL_RESERVATION_DETAIL2 = "pages/Generalreservationdetail/Generalreservationdetail";//付费预约商品详情  酒店、驾校、企业、房产、婚纱会议、门店、培训、餐饮
    const COURSE_DETAIL_CODE_PATH = 'pages/newCourseDetail/newCourseDetail';  //教育培训课程详情页面
    const MEETING_DETAIL_CODE_PATH = 'pages/meetingDetail/meetingDetail';  //会务报名详情页
    const APPLET_ENTER_CODE_PATH = 'pages/singlePage/singlePage';  //入口页
    const AUCTION_DETAIL_CODE_PATH = 'subpages0/auctionpage/auctionDetail/auctionDetail'; //拍卖详情页

    public $sid;
    /*
     * 小程序配置,参考pre_applet_cfg
     */
    public $xcx_cfg;
    /*
     * 当前小程序平台类型
     */
    public $platform_type;

    public $access_token = null;

    public function __construct($sid){
        $this->sid  = $sid;
        $this->_fetch_access_token();
    }

    /*
     * 获取店铺微信授权方式,0未授权,1手工填写,2开放平台
     */
    public static function weixinAuthType($sid) {
        $weixin_storage = new App_Model_Applet_MysqlCfgStorage($sid);
        $weixin         = $weixin_storage->findShopCfg();

        if (!$weixin || !$weixin['ac_appid']) {
            return self::WEIXIN_AUTH_NONE;
        }

        if ($weixin['ac_auth_status'] && $weixin['ac_auth_access_token']) {
            return self::WEIXIN_AUTH_OPEN;
        }

        if (strlen($weixin['ac_appid']) == 18 && strlen($weixin['ac_appsecret']) == 32) {
            return self::WEIXIN_AUTH_WRITE;
        }

        return self::WEIXIN_AUTH_NONE;
    }
    /*
     * 获取有效的访问token
     */
    private function _fetch_access_token() {
        $auth_type  = self::weixinAuthType($this->sid);
        //根据店铺id获取access token
        $weixin_storage = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $weixin         = $weixin_storage->findShopCfg();
        $category       = plum_parse_config('category', 'applet');
        $applet_type    = intval($weixin['ac_type']);
        $this->platform_type    = $category[$applet_type]['platform'];

        switch ($auth_type) {
            //未授权
            case self::WEIXIN_AUTH_NONE :
                trigger_error('店铺绑定的微信账号未设置，请核实！sid=='.$this->sid, E_USER_WARNING);
                break;
            //自定义填写
            case self::WEIXIN_AUTH_WRITE :
                if ($weixin['ac_expires_in'] > time()) {
                    //未失效
                    $this->access_token = $weixin['ac_access_token'];
                } else {
                    $url    = 'https://api.weixin.qq.com/cgi-bin/token';
                    $params = array(
                        'grant_type'    => 'client_credential',
                        'appid'         => $weixin['ac_appid'],
                        'secret'        => $weixin['ac_appsecret'],
                    );
                    $result = Libs_Http_Client::get($url, $params);
                    $result = json_decode($result, true);
                    if (isset($result['access_token'])) {
                        $updata = array(
                            'ac_access_token'       => $result['access_token'],
                            'ac_expires_in'         => time()+(int)$result['expires_in'],
                        );
                        $weixin_storage->updateById($updata, $weixin['ac_id']);
                        $this->access_token = $result['access_token'];
                    } else {
                        Libs_Log_Logger::outputLog($result);
                        //trigger_error('微信开发者，用户自定义填写，access token获取失败。sid=='.$this->sid, E_USER_ERROR);
                    }
                }
                $this->xcx_cfg   = $weixin;
                break;
            //开放平台授权
            case self::WEIXIN_AUTH_OPEN :
                if ($weixin['ac_auth_expire_time'] > time()) {
                    $this->access_token     = $weixin['ac_auth_access_token'];
                } else {
                    //失效token重新获取
                    $platform   = plum_parse_config('platform', 'wxxcx');
                    $plat_cfg   = $platform[$this->platform_type];
                    $plat_redis = new App_Model_Auth_RedisWeixinPlatformStorage($this->platform_type);
                    $token  = $plat_redis->getCompAccessToken();
                    $url    = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token={$token}";

                    $params = array(
                        'component_appid'       => $plat_cfg['app_id'],
                        'authorizer_appid'      => $weixin['ac_appid'],
                        'authorizer_refresh_token'  => $weixin['ac_auth_refresh_token'],
                    );
                    $result     = Libs_Http_Client::post($url, json_encode($params));
                    $result     = json_decode($result, true);
                    if (isset($result['authorizer_access_token'])) {
                        $updata     = array(
                            'ac_auth_access_token'      => $result['authorizer_access_token'],
                            'ac_auth_expire_time'       => time()+(int)$result['expires_in'],
                            'ac_auth_refresh_token'     => $result['authorizer_refresh_token'],
                        );
                        $weixin_storage->updateById($updata, $weixin['ac_id']);
                        $this->access_token     = $result['authorizer_access_token'];
                    } else {
                        //刷新令牌一旦丢失或失效,只能让用户重新授权,才能再次拿到新的刷新令牌
                        Libs_Log_Logger::outputLog($result);
                    }
                }
                $this->xcx_cfg   = $weixin;
                break;
        }
    }
    /*
     * 客服发送文本消息
     */
    public function sendCustomText($openid, $content) {
        if (!$this->access_token) {
            return false;
        }
        $data   = array(
            'touser'    => $openid,
            'msgtype'   => 'text',
            'text'      => array('content' => $content)
        );

        $send_url   = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        if (!$result['errcode']) {
            return true;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
     /*
     * 获取账号下添加的订阅消息模板列表
     */
    public function fetchAllPrivateSubscribeTemplate($log = false) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/wxaapi/newtmpl/gettemplate?access_token={$this->access_token}";
        $result = Libs_Http_Client::get($url);
        $result = json_decode($result,1);
        if($log){
            Libs_Log_Logger::outputLog($result,'ding.log');
        }
        return $result;

    }
  
  
    /*
     * 客服发送图片消息
     */
    public function sendCustomImage($openid, $imgPath) {
        if (!$this->access_token) {
            return false;
        }
        $imgPath    = PLUM_DIR_ROOT.$imgPath;//绝对路径
        if (!file_exists($imgPath)) {
            return false;
        }
        //首先新增临时素材
        $url    = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$this->access_token}&type=image";

        $fields	=	array("media" => $imgPath);
        $result = Libs_Http_Client::post($url, array(), $fields);;
        $result = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);
        if (!isset($result['media_id'])) {
            return false;
        }

        //
        $body   = array(
            "touser"    => $openid,
            "msgtype"   => "image",
            "image"     => array("media_id" => $result['media_id']),
        );

        $send_url   = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($body, JSON_UNESCAPED_UNICODE));
        if ($result['errcode'] == 0) {
            return true;
        }
        return false;
    }
    /*
     * 发送模板消息
     */
    public function sendTemplateMessage($openid, $tplid, $formid, $data, $page = null, $emphasis_keyword = 0) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send";

        $getp   = array(
            'access_token'  => $this->access_token,
        );
        $params = array(
            'touser'        => $openid,
            'template_id'   => $tplid,
            'form_id'       => $formid,
            'page'          => $page ? $page : 'pages/index/index',
            'data'          => $data
        );
        if ($emphasis_keyword) {
            $params['emphasis_keyword'] = "keyword{$emphasis_keyword}.DATA";
        }
        $url = $url . '?' . http_build_query($getp);

        $result = Libs_Http_Client::post($url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        if (isset($result['errcode']) && $result['errcode']) {
            //产生错误
            Libs_Log_Logger::outputLog($result,'test.log');
            Libs_Log_Logger::outputLog($params,'test.log');
            //trigger_error(json_encode($result), E_USER_ERROR);
            return false;
        } else {
            return $result;
        }
    }
    /**
     * 提交小程序模板代码
     * @param int $tpl_id
     * @param string $ext_json 序列化后的源码
     * @param string $version
     * @param string $desc
     * @return array
     */
    public function commitTemplateCode($tpl_id, $ext_json, $version, $desc) {
        if (!$this->access_token) {
            return array('errcode' => 61023, 'errmsg' => '授权已过期,请重新授权');
        }
        $data   = array(
            'template_id'   => intval($tpl_id),
            'ext_json'      => $ext_json,
            'user_version'  => strval($version),
            'user_desc'     => $desc,
        );
        $send_url   = "https://api.weixin.qq.com/wxa/commit?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));

        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        //记录错误
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '发布成功',
            -1      => '系统错误,请重试',
            85013   => '无效的自定义配置',
            85014   => '无效的模版编号',
            61023   => '授权已过期,请重新授权',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }

    /**
     * 发布已通过审核的小程序代码
     * @return array
     */
    public function releaseTemplateCode() {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }
        $data   = array();

        $send_url   = "https://api.weixin.qq.com/wxa/release?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, '{}');
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);

        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '发布成功',
            -1      => '系统错误,请重试',
            85019   => '没有审核版本',
            85020   => '审核状态未满足发布',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }

    /**
     * 获取代码的审核状态
     * @param int $audit_id 审核ID
     * @return bool
     */
    public function fetchCodeAudit($audit_id) {
        if (!$this->access_token) {
            return false;
        }
        $data   = array('auditid' => intval($audit_id));

        $send_url   = "https://api.weixin.qq.com/wxa/get_auditstatus?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        if (!$result['errcode']) {
            return $result;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }

    /**
     * 获取最新一次的审核状态
     * auditid	最新的审核ID
     * status	审核状态，其中0为审核成功，1为审核失败，2为审核中
     * reason	当status=1，审核被拒绝时，返回的拒绝原因
     * @return array|mixed
     */
    public function fetchLatestAudit() {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $send_url   = "https://api.weixin.qq.com/wxa/get_latest_auditstatus?access_token={$this->access_token}";
        $result     = Libs_Http_Client::get($send_url);
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);

        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '获取成功',
            -1      => '系统错误,请重试',
            86000   => '不是由第三方代小程序进行调用',
            86001   => '不存在第三方的已经提交的代码',
            85012   => '无效的审核id',
        );
        $ret    = array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
        if ($errcode == 0) {
            $ret    = $result;
        }
        return $ret;
    }
    /*
     * 获取小程序类别
     */
    public function fetchWxappCategory() {
        if (!$this->access_token) {
            return false;
        }

        $send_url   = "https://api.weixin.qq.com/wxa/get_category?access_token={$this->access_token}";
        $result     = Libs_Http_Client::get($send_url);
        $result     = json_decode($result, true);
        if (!$result['errcode']) {
            return $result['category_list'];
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
    /*
     * 获取小程序的第三方提交代码的页面配置
     */
    public function fetchWxappPages() {
        if (!$this->access_token) {
            return false;
        }

        $send_url   = "https://api.weixin.qq.com/wxa/get_page?access_token={$this->access_token}";
        $result     = Libs_Http_Client::get($send_url);
        $result     = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);
        if (!$result['errcode']) {
            return $result['page_list'];
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
    /**
     * 提交代码审核
     * @param array $item
     * @return array
     */
    public function submitCodeToAudit(array $item) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('item_list' => $item);

        $send_url   = "https://api.weixin.qq.com/wxa/submit_audit?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);
        $errcode    = intval($result['errcode']);
        
        $auditid    = 0;
        if ($errcode == 0 || $errcode == 85009) {
            $auditid = $errcode == 0 ? $result['auditid'] : -1;
        }
        $errmap     = array(
            0       => '提交审核成功',
            -1      => '系统错误,请重试',
            86000   => '不是由第三方代小程序进行调用。',
            86001   => '不存在第三方的已经提交的代码。',
            85006   => '标签格式错误。',
            85007   => '页面路径错误。',
            85008   => '类目填写错误。',
            85009   => '已经有正在审核的版本。',
            85010   => 'item_list有项目为空。',
            85011   => '标题填写错误。',
            85023   => '审核列表填写的项目数不在1-5以内。',
            85077   => '您选择的类目已经不再支持,请选择其他类目后重试。',
            86002   => '小程序还未设置昵称、头像、简介。请先设置完后再重新提交。',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode], 'auditid' => $auditid);
    }
    /*
     * 撤回已经提交的小程序审核
     */
    public function undoCodeAudit() {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $send_url   = "https://api.weixin.qq.com/wxa/undocodeaudit?access_token={$this->access_token}";
        $result     = Libs_Http_Client::get($send_url);
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);

        $errmap     = array(
            0       => '审核撤回成功',
            -1      => '系统错误,请重试',
            87013   => '撤回次数达到上线（每天一次，每个月10次）',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }

    /**
     * 获取小程序信息
     */
    public function getWxappInfoAction(){
        if (!$this->access_token) {
            return false;
        }

        $send_url   = "https://api.weixin.qq.com/cgi-bin/account/getaccountbasicinfo?access_token={$this->access_token}";
        $result     = Libs_Http_Client::get($send_url);

        $result     = json_decode($result, true);

        Libs_Log_Logger::outputLog($result);

        return $result;
    }

    /**
     * 小程序名称设置
     */
    public function setnicknameAction($nickname, $idCard='', $license='', $stuff1='', $stuff2=''){
        if (!$this->access_token) {
            return false;
        }

        $data   = array(
            'nick_name'             => $nickname,
            'id_card'               => $idCard,
            'license'               => $license,
            'naming_other_stuff_1'  => $stuff1,
            'naming_other_stuff_2'  => $stuff2,
        );

        $send_url   = "https://api.weixin.qq.com/wxa/setnickname?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);

        //记录错误
        Libs_Log_Logger::outputLog($result);
        return $result;
    }

    /**
     * 小程序改名审核状态查询
     */
    public function nicknameQueryAction($auditId){
        if (!$this->access_token) {
            return false;
        }

        $data   = array(
            'audit_id' => $auditId
        );

        $send_url   = "https://api.weixin.qq.com/wxa/api_wxa_querynickname?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);

        //记录错误
        Libs_Log_Logger::outputLog($result);
        return $result;
    }

    /**
     * 微信认证名称检测
     */
    public function verifyNicknameAction($nickname){
        if (!$this->access_token) {
            return false;
        }

        $data   = array(
            'nick_name' => $nickname
        );

        $send_url   = "https://api.weixin.qq.com/cgi-bin/wxverify/checkwxverifynickname?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);

        //记录错误
        Libs_Log_Logger::outputLog($result);
        return $result;
    }

    /**
     * 修改头像
     */
    public function modifyHeadImageAction($headImgId, $x1, $y1, $x2, $y2){
        if (!$this->access_token) {
            return false;
        }

        $data   = array(
            'head_img_media_id' => $headImgId,
            'x1' => $x1,
            'y1' => $y1,
            'x2' => $x2,
            'y2' => $y2,
        );

        $send_url   = "https://api.weixin.qq.com/cgi-bin/account/modifyheadimage?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);

        if (!$result['errcode']) {
            return true;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }

    /**
     * 上传临时图片
     */
    public function mediaUploadAction($imgPath){
        $imgPath    = PLUM_DIR_ROOT.$imgPath;//绝对路径
        if (!file_exists($imgPath)) {
            return false;
        }
        //首先新增临时素材
        $url    = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$this->access_token}&type=image";

        $fields	=	array("media" => $imgPath);
        $result = Libs_Http_Client::post($url, array(), $fields);;
        $result = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);
        if (!isset($result['media_id'])) {
            return false;
        }
        return $result['media_id'];
    }

    /**
     * 修改功能介绍
     */
    public function modifySignatureAction($signature){
        if (!$this->access_token) {
            return false;
        }

        $data   = array(
            'signature' => $signature,
        );

        $send_url   = "https://api.weixin.qq.com/cgi-bin/account/modifysignature?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);

        if (!$result['errcode']) {
            return true;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }

    /**
     * 获取账号设置的所有类目
     */
    public function getCategoryAction(){
        if (!$this->access_token) {
            return false;
        }

        $send_url   = "https://api.weixin.qq.com/cgi-bin/wxopen/getcategory?access_token={$this->access_token}";
        $result     = Libs_Http_Client::get($send_url);

        $result     = json_decode($result, true);

        Libs_Log_Logger::outputLog($result);

        return $result;
    }

    /**
     * 添加类目
     */
    public function addCategoryAction($data = array()){
        if (!$this->access_token) {
            return false;
        }
        Libs_Log_Logger::outputLog($data);

        $send_url   = "https://api.weixin.qq.com/cgi-bin/wxopen/addcategory?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);

        if (!$result['errcode']) {
            return true;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }

    /**
     * 删除类目
     */
    public function delCategoryAction($first, $second){
        if (!$this->access_token) {
            return false;
        }

        $data = array(
            'first' => $first,
            'second' => $second,
        );

        $send_url   = "https://api.weixin.qq.com/cgi-bin/wxopen/deletecategory?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);

        if (!$result['errcode']) {
            return true;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }

    /**
     * 获取账号可以设置的所有类目
     */
    public function getAllCategoriesAction(){
        if (!$this->access_token) {
            return false;
        }

        $send_url   = "https://api.weixin.qq.com/cgi-bin/wxopen/getallcategories?access_token={$this->access_token}";
        $result     = Libs_Http_Client::get($send_url);

        $result     = json_decode($result, true);

        return $result;
    }

    /*
     * 获取体验二维码
     */
    public function fetchCodeQrcode() {
        if (!$this->access_token) {
            return false;
        }

        $send_url   = "https://api.weixin.qq.com/wxa/get_qrcode?access_token={$this->access_token}";
        $result     = Libs_Http_Client::get($send_url);

        return $result;
    }
    /*
     * 设置小程序服务器域名
     * @param string $action [set,add,delete]
     * set覆盖、add添加、delete删除
     */
    public function coverCodeDomain($req_dom, $wss_dom = array(), $upl_dom = array(), $dow_dom = array(), $action = 'set') {
        if (!$this->access_token) {
            return false;
        }

        $data   = array(
            'action'        => $action,
            'requestdomain'     => is_array($req_dom) ? $req_dom : array($req_dom),
            'wsrequestdomain'   => is_array($wss_dom) ? $wss_dom : array($wss_dom),
            'uploaddomain'      => is_array($upl_dom) ? $upl_dom : array($upl_dom),
            'downloaddomain'    => is_array($dow_dom) ? $dow_dom : array($dow_dom),
        );
        Libs_Log_Logger::outputLog($data);
        $send_url   = "https://api.weixin.qq.com/wxa/modify_domain?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);
        if (!$result['errcode']) {
            return true;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
    /*
     * 获取小程序服务器域名
     */
    public function fetchCodeDomain() {
        if (!$this->access_token) {
            return false;
        }

        $data   = array(
            'action'        => 'get',
        );

        $send_url   = "https://api.weixin.qq.com/wxa/modify_domain?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        if (!$result['errcode']) {
            return $result;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
    /*
     * 设置小程序业务域名
     * @param string $action [add,set,delete]
     */
    public function addWebDomain($web_dom, $action = 'add') {
        if (!$this->access_token) {
            return false;
        }

        $data   = array(
            'action'        => $action,
            'webviewdomain'     => is_array($web_dom) ? $web_dom : array($web_dom),
        );

        $send_url   = "https://api.weixin.qq.com/wxa/setwebviewdomain?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        if (!$result['errcode']) {
            return true;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
    /*
     * 获取设置的小程序业务域名
     */
    public function getWebDomain() {
        if (!$this->access_token) {
            return false;
        }

        $data   = array(
            'action'        => 'get',
        );

        $send_url   = "https://api.weixin.qq.com/wxa/setwebviewdomain?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        if (!$result['errcode']) {
            return $result;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
    /*
     *通过code获取用户的openid和session_key
     */
    public function fetchOpenidByCode($appid,$code){
        // 获取平台appid;
        $platform   = plum_parse_config('platform', 'wxxcx');
        $plat_cfg   = $platform[$this->platform_type];
        // 获取token
        $plat_redis = new App_Model_Auth_RedisWeixinPlatformStorage($this->platform_type);
        $token  = $plat_redis->getCompAccessToken();
        $send_url   = "https://api.weixin.qq.com/sns/component/jscode2session?appid={$appid}&js_code={$code}&grant_type=authorization_code&component_appid={$plat_cfg['app_id']}&component_access_token={$token}";
        $result     = Libs_Http_Client::get($send_url);
        $result     = json_decode($result, true);
        if ($result['openid']) {
            return $result;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
    /*
     * 绑定微信用户为小程序体验者
     */
    public function bindTester($wechatid) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('wechatid' => $wechatid);

        $send_url   = "https://api.weixin.qq.com/wxa/bind_tester?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);
        $errcode    = intval($result['errcode']);

        $errmap     = array(
            0       => '绑定成功',
            -1      => '系统错误,请重试',
            85001   => '微信号不存在或微信号设置为不可搜索',
            85002   => '小程序绑定的体验者数量达到上限',
            85003   => '微信号绑定的小程序体验者达到上限',
            85004   => '微信号已经绑定',
            89031   => '当前用户绑定的体验小程序已达上限',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }
    /*
     * 获取小程序码并保存下来
     */
    public function fetchWxappCode($path = null, $width = 430) {
        if (!$this->access_token) {
            return false;
        }

        $path   = is_null($path) ? 'pages/index/index' : $path;
        $data   = array(
            'path'      => $path,
            'width'     => $width,
            'auto_color'    => false,
        );

        $send_url   = "https://api.weixin.qq.com/wxa/getwxacode?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));

        if ($result) {
            $im     = imagecreatefromstring($result);
            $filename   = plum_uniqid_base36(true).".jpg";
            imagejpeg($im, PLUM_APP_BUILD."/".$filename);
            imagedestroy($im);
            $filepath   = '/public/build/'.$filename;

            return $filepath;
        }
        //记录错误
        return false;
    }

    /*
    * 获取带参数的小程序码并保存下来
    */
    public function fetchWxappShareCode($str, $path = null, $width = 210, $cover='', $isHyaline=false) {
        if (!$this->access_token) {
            return false;
        }
        $path   = is_null($path) ? 'pages/index/index' : $path;
        $data   = array(
            'scene'     => $str,
            'page'      => $path, //分享页面路径
            'width'     => $width,
            'is_hyaline' => $isHyaline
        );
        $send_url   = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $resultArr  = json_decode($result, true);
        if ($result && !isset($resultArr['errcode'])) {
            $im     = imagecreatefromstring($result);
            if($im){
                if($isHyaline){
                    imagealphablending($im,false);
                    imagesavealpha($im, true);
                    $filename   = plum_uniqid_base36(true).".png";
                    imagepng($im, PLUM_APP_BUILD."/".$filename);
                }else{
                    $filename   = plum_uniqid_base36(true).".jpg";
                    imagejpeg($im, PLUM_APP_BUILD."/".$filename);
                }
                imagedestroy($im);
                $filepath   = '/public/build/'.$filename;
                if($cover){
                    return $this->_image_merge($filepath, $cover, PLUM_APP_BUILD."/".$filename, $width);
                }else{
                    return $filepath;
                }
            }
        }
        //记录错误
        return false;
    }

    private function _image_merge($path_1, $path_2, $real_path, $width){
        $logo_width = ($width<280?280:$width) * 0.46;  //中间logo的宽度
        $logo_height = ($width<280?280:$width) * 0.46; //中间logo的高度
        $logo_offsetx = ($width<280?280:$width) * 0.27; //中间logo的x偏移量
        $logo_offsety = ($width<280?280:$width) * 0.27; //中间logo的y偏移量
        //创建图片对象
        $image_1 = imagecreatefromjpeg(plum_deal_image_url($path_1));
        list(,,$type) = getimagesize(plum_deal_image_url($path_2));
        switch ($type) {
            case IMAGETYPE_GIF:
                $image_2 = imagecreatefromgif(plum_deal_image_url($path_2));
                break;

            case IMAGETYPE_JPEG:
                $image_2 = imagecreatefromjpeg(plum_deal_image_url($path_2));
                break;

            case IMAGETYPE_PNG:
                $image_2 = imagecreatefrompng(plum_deal_image_url($path_2));
                break;
        }

        // 创建缩略画布
        $cropped_image = imagecreatetruecolor($logo_width, $logo_height);
        //合成图片
        imagecopyresampled($cropped_image, $image_2,  0, 0, 0, 0, $logo_width, $logo_height, imagesx($image_2),imagesy($image_2));

        $img = imagecreatetruecolor($logo_width, $logo_height);
        //这一句一定要有
        imagealphablending($img,false);
        imagesavealpha($img, true);
        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
        $r   = $logo_width / 2; //圆半径
        for ($x = 0; $x < $logo_width; $x++) {
            for ($y = 0; $y < $logo_height; $y++) {
                $c = imagecolorat($cropped_image,$x,$y);
                $_x = $x - $logo_width/2;
                $_y = $y - $logo_height/2;
                if((($_x*$_x) + ($_y*$_y)) < ($r*$r)){
                    imagesetpixel($img,$x,$y,$c);
                }else{
                    imagesetpixel($img,$x,$y,$bg);
                }
            }
        }
        $alphefilename   = plum_uniqid_base36(true).".png";
        imagepng($img, PLUM_APP_BUILD."/".$alphefilename);
        //将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。
        imagecopy($image_1, $img, $logo_offsetx, $logo_offsety, 0, 0, imagesx($img), imagesy($img));
        // 输出合成图片
        imagejpeg($image_1, $real_path);
        return $path_1;
    }

    /*
     * 获取账号下添加的模板列表
     * 微信认证的服务号可用
     */
    public function fetchAllPrivateTemplate() {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/wxopen/template/list?access_token={$this->access_token}";
        $offset = -20;
        $count  = 20;
        $list   = array();

        do {
            $offset += $count;
            $params = array(
                'offset'    => $offset,
                'count'     => $count,
            );

            $result = Libs_Http_Client::post($url, json_encode($params, JSON_UNESCAPED_UNICODE));
            $result = json_decode($result, true);
            Libs_Log_Logger::outputLog($result);
            if ($result['errcode']) {
                //产生错误
                Libs_Log_Logger::outputLog("店铺ID={$this->sid}");
                break;
            } else {
                $curr   = $result['list'];
                $list   = array_merge($list, $curr);
            }
        } while (count($curr) == $count);

        return $list;
    }
    /*
     * 删除账号下的模板
     * 微信认证的服务号可用
     */
    public function deletePrivateTemplate($tplid) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/wxopen/template/del";

        $getp   = array(
            'access_token'  => $this->access_token,
        );
        $params = array(
            'template_id'   => $tplid,
        );
        $url = $url . '?' . http_build_query($getp);

        $result = Libs_Http_Client::post($url, json_encode($params));
        $result = json_decode($result, true);

        if (isset($result['errcode']) && $result['errcode']) {
            //产生错误
            Libs_Log_Logger::outputLog($result);
            Libs_Log_Logger::outputLog("店铺ID={$this->sid}");
            //trigger_error(json_encode($result), E_USER_ERROR);
            return false;
        } else {
            return $result;
        }
    }

    /**
     * 添加账号下的模板
     */
    public function addPrivateTemplate($tempId, $keywordList){
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/wxopen/template/add";

        $getp   = array(
            'access_token'  => $this->access_token,
        );
        $params = array(
            'id'   => $tempId,
            'keyword_id_list' => $keywordList
        );
        $url = $url . '?' . http_build_query($getp);

        $result = Libs_Http_Client::post($url, json_encode($params));
        $result = json_decode($result, true);

        if (isset($result['errcode']) && $result['errcode']) {
            //产生错误
            Libs_Log_Logger::outputLog($result);
            Libs_Log_Logger::outputLog("店铺ID={$this->sid}");
            //trigger_error(json_encode($result), E_USER_ERROR);
            return false;
        } else {
            return $result;
        }
    }

    /*
     * 获取微信开放平台账号
     */
    public function getOpenAppid($appid) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('appid' => $appid);

        $send_url   = "https://api.weixin.qq.com/cgi-bin/open/get?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '获取成功',
            -1      => '系统错误,请重试',
            40013   => 'invalid appid，appid无效。',
            89002   => 'open not exists，该公众号/小程序未绑定微信开放平台帐号。',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode], 'open_appid' => isset($result['open_appid']) ? $result['open_appid'] : null);
    }
    /*
     * 创建微信开放平台账号并绑定
     */
    public function createOpenAppid($appid) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('appid' => $appid);

        $send_url   = "https://api.weixin.qq.com/cgi-bin/open/create?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '创建成功',
            -1      => '系统错误,请重试',
            40013   => 'invalid appid，appid无效。',
            89000   => 'account has bound open，该公众号/小程序已经绑定了开放平台帐号。',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode], 'open_appid' => isset($result['open_appid']) ? $result['open_appid'] : null);
    }
    /*
     * 绑定新的公众号或微信小程序到开放平台
     */
    public function bindOpenAppid($appid, $open_appid) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('appid' => $appid, 'open_appid' => $open_appid);

        //Libs_Log_Logger::outputLog($data);
        $send_url   = "https://api.weixin.qq.com/cgi-bin/open/bind?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '绑定成功',
            -1      => '系统错误,请重试',
            40013   => 'invalid appid，appid或open_appid无效。',
            89000   => 'account has bound open，该公众号/小程序已经绑定了开放平台帐号。',
            89001   => 'not same contractor，Authorizer与开放平台帐号主体不相同。',
            89002   => '该开放平台帐号所绑定的公众号/小程序已达上限（100个）。',
            89003   => '该开放平台帐号并非通过api创建，不允许操作',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }

    public function unbindOpenAppid($appid, $open_appid) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('appid' => $appid, 'open_appid' => $open_appid);

        $send_url   = "https://api.weixin.qq.com/cgi-bin/open/unbind?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '解绑成功',
            -1      => '系统错误,请重试',
            40013   => 'invalid appid，appid或open_appid无效。',
            89001   => 'not same contractor，Authorizer与开放平台帐号主体不相同。',
            89003   => '该开放平台帐号并非通过api创建，不允许操作',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }


    //商户接口升级
    public function testpay($type=1) {
        $client = new App_Plugin_Weixin_Wxpay_MchPay($this->sid);

        $openid = 'ojYj5s-f4FgajOswD7EnXegYbqNA';
        $body   = '免预存立减测试';
        //$tid    = '112018011712598634';
        $tid    = $this->sid.date('Ymd', time()).($type==1?'12598634':'12598635');
        $amount = $type==1?5.51:5.52;
        $notify = 'http://www.tiandiantong.com/index/testnot';
        return $client->unifiedJsapiOrder($openid, $body, $tid, $amount, $notify);
    }

    public function testqy($type) {
        $client = new App_Plugin_Weixin_Wxpay_MchPay($this->sid);
        //$tid    = '112018011712598634';
        $tid    = $this->sid.date('Ymd', time()).($type==1?'12598634':'12598635');;
        return $client->queryPayOrder($tid);
    }

    public function testrf() {
        $client = new App_Plugin_Weixin_Wxpay_MchPay($this->sid);

        //$tid    = '112018011712598634';
        $tid    = $this->sid.date('Ymd', time()).'12598635';
        //$rfid   = '112018011712595656';
        $rfid   = $this->sid.date('Ymd', time()).'12595656';
        $amount = 5.52;
        return $client->refundPayOrder($tid, $rfid, $amount, $amount);
    }

    public function testqyrf() {
        $client = new App_Plugin_Weixin_Wxpay_MchPay($this->sid);
        //$tid    = '112018011712598634';
        $tid    = $this->sid.date('Ymd', time()).'12598635';
        return $client->queryRefundOrder($tid);
    }

    public function testbill($type='ALL') {
        $client = new App_Plugin_Weixin_Wxpay_MchPay($this->sid);
        $date   = date('Ymd', time());
        return $client->downloadPayBill($date, $type);
    }
    /*************************************小程序插件管理接口***********************************************************/
    /*
     * 微信小程序插件管理
     * @param string $action [apply,list,unbind]
     * @link https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=21521637082Sqi4M&token=&lang=zh_CN
     */
    public function wxaPlugin($action, $appid = null, $version = null) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('action' => $action);
        if (in_array($action, array('apply', 'unbind', 'update'))) {
            $data['plugin_appid']   = $appid;
            if ($action == 'update') {
                $data['user_version']   = $version;
            }
        }

        $send_url   = "https://api.weixin.qq.com/wxa/plugin?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        Libs_Log_Logger::outputLog($result,'test.log');
        $errcode    = intval($result['errcode']);

        $errmap     = array(
            0       => '成功',
            -1      => '系统错误,请重试',
            89236   => '该插件不能申请',
            89237   => '已经添加该插件',
            89238   => '申请或使用的插件已经达到上限',
            89239   => '该插件不存在',
            89243   => '该申请为“待确认”状态，不可删除',
            89244   => '不存在该插件appid',
        );
        $return     = array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
        if ($action == 'list') {
            $return['list'] = $result['plugin_list'];
        }
        return $return;
    }

    /*************************************小程序内容安全校验接口***********************************************************/
    /*
     * 校验文本信息安全
     * @link https://developers.weixin.qq.com/miniprogram/dev/api/msgSecCheck.html
     */
    public function checkMsg($content) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('content' => $content);

        $send_url   = "https://api.weixin.qq.com/wxa/msg_sec_check?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '内容正常',
            -1      => '系统错误,请重试',
            87014   => '内容含有违法违规内容',
        );
        $return     = array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
        return $return;
    }
    /*
     * 校验图片信息安全
     * @link https://developers.weixin.qq.com/miniprogram/dev/api/imgSecCheck.html
     */
    public function checkImg($imgPath) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $imgPath    = PLUM_DIR_ROOT.$imgPath;//绝对路径
        if (!file_exists($imgPath)) {
            return array('errcode' => -2, 'errmsg' => '图片路径不正确');
        }
        list($width, $height) = getimagesize($imgPath);
        if ($width > 750 || $height > 1334) {
            // 如果图片尺寸过大将图片尺寸修改
            $imgPath = $this->updateImageSize($imgPath);
            //return array('errcode' => -3, 'errmsg' => '图片尺寸超出规定');
        }
        $fields	=	array("media" => @$imgPath);
        $send_url   = "https://api.weixin.qq.com/wxa/img_sec_check?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, array(), $fields);
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        $errmap     = array(
            0       => '内容正常',
            -1      => '系统错误,请重试',
            87014   => '内容含有违法违规内容',
        );
        $return     = array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
        return $return;
    }

    /*
     * 修改图片尺寸
     */
    public function updateImageSize($imgsrc){
        //取得图片的宽度,高度值
        list($width,$height,$type) = getimagesize($imgsrc);
        $imagecreate    = "imagecreatefrom";
        $imageoutput    = "image";
        $imageext       = '';
        switch ($type) {
            case IMAGETYPE_GIF :
                $imagecreate    .= "gif";
                $imageoutput    .= "gif";
                $imageext       = '.gif';
                break;
            case IMAGETYPE_JPEG :
                $imagecreate    .= "jpeg";
                $imageoutput    .= "jpeg";
                $imageext       = '.jpg';
                break;
            case IMAGETYPE_PNG :
                $imagecreate    .= "png";
                $imageoutput    .= "png";
                $imageext       = '.png';
                break;
        }
        if($width>750){
            $newWidth = 750;
        }else{
            $newWidth = $width;
        }
        if($height>1334){
            $newHeight = 1334;
        }else{
            $newHeight = $height;
        }
        // Create image and define colors
        $imgsrc = $imagecreate($imgsrc);
        $image = imagecreatetruecolor($newWidth, $newHeight); //创建一个彩色的底图
        imagecopyresized($image, $imgsrc, 0, 0, 0, 0,$newWidth,$newHeight,$width, $height);
        $filename   = PLUM_APP_BUILD."/".plum_random_code(8, false) . '-' . plum_random_code(6, false) . $imageext;
        $imageoutput($image,$filename);
        imagedestroy($image);
        // 将图片缩小尺寸再次请求
        return $filename;
    }

    /**
     * 动态获取小程序二维码
     * @param  [type] $path   [路径]
     * @param  string $params [参数]
     * @return [type]         [description]
     */
    public function getQrcodeDynamic($path,$params=''){
        $path   = is_null($path) ? 'pages/index/index' : $path;
        $data   =array(
            'scene'      => $params,
            'page'       => $path, //分享页面路径
            'is_hyaline' => true
        );

        $send_url   = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        Libs_Log_Logger::outputLog($result);
        $resultArr  = json_decode($result, true);
        if ($result && !isset($resultArr['errcode']))
            return $result;
        else
            return null;
    }

    /*************************************物流助手***********************************************************/
    /**
     * 物流助手 获取快递公司列表
     */
    public function getAllDelivery(){
        $send_url   = "https://api.weixin.qq.com/cgi-bin/express/business/delivery/getall?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, []);
        $result     = json_decode($result, true);

        if ($result && !isset($result['errcode'])){
            return $result;
        }else{
            return null;
        }

    }

    /**
     * 生成运单
     */
    public function addOrder($orderId, $openId, $deliveryId, $bizId, $sender, $receiver, $cargo, $shop, $insured, $service, $remark){
        $data = [
            'order_id' => $orderId,                  //订单ID
            'openid'   => $openId,                   //用户 openid
            'delivery_id' => $deliveryId,            //快递公司ID
            'biz_id'   => $bizId,                    //快递客户编码或者现付编码
            'custom_remark' => $remark,              //快递备注信息
            'sender'   => array(
                'name'    => $sender['name'],        //发件人姓名
                'tel'     => $sender['tel'],         //发件人座机号， 与手机号二选一
                'mobile'  => $sender['mobile'],      //发件人手机号码
                'company' => $sender['company'],     //发件人公司名称
                'post_code' => $sender['post_code'],  //发件人邮编
                'country'   => '中国',
                'province'  => $sender['province'],  //发件人省份
                'city'      => $sender['city'],      //发件人市/地区
                'area'      => $sender['area'],      //发件人区/县
                'address'   => $sender['address']    //发件人详细地址
            ),
            'receiver' => array(
                'name'    => $receiver['name'],      //收件人姓名
                'mobile'  => $receiver['mobile'],    //收件人手机号码
                'company' => $receiver['company'],   //收件人公司名
                'post_code' => $receiver['post_code'],//收件人邮编
                'country'   => '中国',
                'province'  => $receiver['province'],//收件人省份
                'city'      => $receiver['city'],    //收件人地区/市
                'area'      => $receiver['area'],    //收件人区/县
                'address'   => $receiver['address']  //收件人详细地址
            ),
            'cargo'    => array(
                'count'   => $cargo['count'],        //包裹数量
                'weight'  => $cargo['weight'],       //包裹总重量，单位是千克(kg)
                'space_x' => $cargo['space_x'],       //包裹长度，单位厘米(cm)
                'space_y' => $cargo['space_y'],       //包裹宽度，单位厘米(cm)
                'space_z' => $cargo['space_z'],       //包裹高度，单位厘米(cm)
                'detail_list' => $cargo['detail_list']    //detailList数组   name 商品名   count  商品数量
            ),
            'shop'     => array(
                'wxa_path' => $shop['wxa_path'],       //商家小程序的路径
                'img_url'  => $shop['img_url'],        //商品缩略图 url
                'goods_name'  => $shop['goods_name'],  //商品名称
                'goods_count' => $shop['goods_count'], //商品数量
            ),
            'insured'  => array(
                'use_insured' => $insured['use_insured'],   //是否保价，0 表示不保价，1 表示保价
                'insured_value'=> $insured['insured_value'] //保价金额，单位是分，比如: 10000 表示 100 元
            ),
            'service'  => array(
                'service_type' => $service['service_type'], //服务类型ID
                'service_name' => $service['service_name']  //服务名称
            )
        ];
        $send_url   = "https://api.weixin.qq.com/cgi-bin/express/business/order/add?access_token={$this->access_token}";

        //die();
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        if ($result && !isset($result['errcode'])){
            return array(
                'errcode' => 200,
                'data'    => $result
            );
        }else{
            return array(
                'errcode' => 400,
                'errmsg'  => $result['delivery_resultmsg']
            );
        }
    }

    /**
     * 取消运单
     * orderId 订单号
     * openId  用户openId
     * deliveryId 快递公司id
     * waybill_id 运单id
     */
    public function cancelOrder($orderId, $openId, $deliveryId, $waybillId){
        $send_url   = "https://api.weixin.qq.com/cgi-bin/express/business/order/cancel?access_token={$this->access_token}";
        $data   =[
            'order_id' => $orderId,
            'openid'   => $openId,
            'delivery_id' => $deliveryId,
            'waybill_id'  => $waybillId
        ];
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        var_dump($result);
        die();
        $errcode    = intval($result['errcode']);
        $errmap     = array(
            0       => '成功',
            -1      => '系统失败',
            40199   => '运单 ID 不存在',
            9300506 => '运单 ID 已经存在轨迹，不可取消'
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }

    /**
     * 获取运单数据
     * orderId 订单号
     * openId  用户openId
     * deliveryId 快递公司id
     * waybill_id 运单id
     */
    public function getOrder($orderId, $openId, $deliveryId, $waybillId){
        $send_url   = "https://api.weixin.qq.com/cgi-bin/express/business/order/get?access_token={$this->access_token}";
        $data   =[
            'order_id' => $orderId,
            'openid'   => $openId,
            'delivery_id' => $deliveryId,
            'waybill_id'  => $waybillId
        ];
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        var_dump($result);
        die();
        if ($result && !isset($result['errcode'])){
            return $result;
        }else{
            return null;
        }
    }



    /**
     * 更新打印员
     * update  bind 绑定  unbind  解绑
     */
    public function updatePrinter($openId, $updateType='bind'){
        $send_url   = "https://api.weixin.qq.com/cgi-bin/express/business/printer/update?access_token={$this->access_token}";
        $data   =[
            'openid'      => $openId,
            'update_type' => $updateType,
        ];
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);
        $errmap     = array(
            0       => '操作成功',
            -1      => '系统错误,请重试',
            9300517 => 'update_type 不正确'
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode]);
    }
  
  
    /*
     * 微信小程序发送通知消息
     */
    public function sendSubscribeMessage($openid, $tplid, $data, $page = null,$log = false) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send";

        $getp   = array(
            'access_token'  => $this->access_token,
        );
        $params = array(
            'touser'        => $openid,
            'template_id'   => $tplid,
            'page'          => $page ? $page : 'pages/index/index',
            'data'          => $data
        );

        $url = $url . '?' . http_build_query($getp);

        $result = Libs_Http_Client::post($url, json_encode($params, JSON_UNESCAPED_UNICODE));

        if($log){
            Libs_Log_Logger::outputLog('发送结果','ding.log');
            Libs_Log_Logger::outputLog($result,'ding.log');
            Libs_Log_Logger::outputLog($tplid,'ding.log');
            Libs_Log_Logger::outputLog($data,'ding.log');
        }

        return $result;
    }
}