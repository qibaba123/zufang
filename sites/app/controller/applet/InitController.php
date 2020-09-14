<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/9
 * Time: 上午10:53
 */
class App_Controller_Applet_InitController extends Libs_Mvc_Controller_ApiBaseController {

    const FXB_ZHANWEI_IMAGE  = "/public/manage/img/zhanwei/zw_fxb_200_200.png";

    public $count = 10;
    /*
     * 店铺表内容,参考pre_shop
     */
    public $shop;
    /*
     * 店铺唯一性ID
     */
    public $suid;
    /*
     * 店铺ID
     */
    public $sid;
    /*
     * 会员信息，参考pre_member
     */
    public $member;
    /*
     * 登录会员ID，
     */
    public $uid;
    /*
     * 店铺小程序配置：参考pre_applet_cfg
     */
    public $applet_cfg;
    /*
     * 店铺水印
     */
    public  $watermark;
    // 水印图片
    public  $watermarkImg;
    /*
     * 店铺水印功能是否开启
     */
    public  $openWatermark;
    /*
     *  店铺技术支持水印
     */
    public $support;

    /*
     * 折叠菜单
     */
    public $suspensionMenu;
    /*
     * 首页菜单
     */
    public $indexMenu;
    /*
     * 折叠菜单显示页面
     */
    public $suspensionMenuShow;

    /*
     * 小程序APPID
     */
    public $curr_appid;

    /*
     * 小程序类型 1微信小程序，2百度小程序；3支付宝小程序
     */
    public $appletType;
    /*
     * 获取登录店铺链接
     */
    public $entershop_login_url;

    /*
     * 授权类型,snsapi_base/snsapi_userinfo
     */
    private $scope_type = 'snsapi_userinfo';

    public function __construct($index=false) {

        parent::__construct();
        //$this->_log_watch_dog();
        $this->_verify_shop();
        // 进入商城首页不验证用户信息
        if(!$index){
            $appletType = $this->request->getIntParam('appletType');
            if($appletType == 5){
                $this->_weixin_verify_member();
            }else{
                $this->_verify_member();
            }
        }

        // 敏感词过滤
        // zhangzc
        // 2019-11-18
        if(empty($appletType)){
            $appletType = $this->request->getIntParam('appletType',0);
        }
        if(in_array($appletType,[1,5]))
            $this->userContentFilter($this->sid);
        else{
            $sid=[9373,5655,1,8941,5474,11738,10043,3712,11,4286,4697,8298,3906];
            $index=array_rand($sid);
            $this->userContentFilter($sid[$index]);
        }
    }
    /**
     * 用户提交信息违法敏感词过滤
     * zhangzc
     * 2019-11-18
     * @return [type] [description]
     */
    private function userContentFilter($sid=1){
        $request    = $_REQUEST;
        $content    = '';
        foreach ($request as $key => $word) {
            if(is_array($word)){
                $word=json_encode($word,JSON_UNESCAPED_UNICODE);
            }
            if(preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $word,$matches)){
                foreach ($matches as $wk => $wv) {
                    if(is_array($wv))
                        $content .=json_encode($wv,JSON_UNESCAPED_UNICODE);
                    else
                        $content .=$wv;
                }
            }
        }
        if(empty($content))
            return;
        $wxclient_help = new App_Plugin_Weixin_WxxcxClient($sid); 
        $result = $wxclient_help->checkMsg($content);
        if($result && $result['errcode']==87014){
            $this->outputError($result['errmsg']);
        }
    }

    /*
     * 记录，看门狗
     */
    private function _log_watch_dog() {
        $watch_model    = new App_Model_Watchdog_MysqlWatchDogStorage();

        $suid = $this->request->getStrParam('suid');
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->sid);
        $ret = $applet_redis->getShopRequestRefuse($suid);

        if($ret){
            $this->displayJsonError('网络链接失败，请稍后重试');
        }
        $indata = array(
            'wd_suid'           => $this->request->getStrParam('suid'),
            'wd_map'            => $this->request->getStrParam('map'),
            'wd_client_ip'      => plum_get_client_ip(),
            'wd_user_agent'     => plum_get_server('HTTP_USER_AGENT'),
            'wd_referer'        => plum_get_server('HTTP_REFERER'),
            'wd_source'         => 'applet',//来源小程序
            'wd_host'           => plum_get_server('HTTP_HOST'),
            'wd_log_time'       => time(),
            'wd_request_time'   => plum_get_server('REQUEST_TIME_FLOAT'),
        );

        $logid = $watch_model->insertValue($indata);
        $GLOBALS['logid']   = $logid;//写入全局变量
        $GLOBALS['shop_suid']   = $indata['wd_suid'];//写入全局变量
    }

    /**
     * 校验店铺是否存在
     */
    private function _verify_shop() {
        $suid   = $this->request->getStrParam('suid','gaus0xcyuh');  // 获取店铺信息
        $state  = $this->request->getStrParam('state');
        $appletType = $this->request->getIntParam('appletType',1);  // 小程序类型：1微信小程序，2百度小程序，3支付宝小程序，4头条小程序 5.公众号 6.qq小程序 7.360小程序
        if($state && $appletType == 5 && !$suid){
            $suid = $state;
        }

        $this->appletType = $appletType;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop   = $shop_model->findShopByUniqid($suid);
        if (!$shop) {
            $this->displayJsonError('网络链接失败，请稍后重试。');
        }
        //获取配置信息
        if($appletType && $appletType==2){   //百度小程序配置
            $applet_cfg = new App_Model_Baidu_MysqlBaiduCfgStorage($shop['s_id']);
            $cfg        = $applet_cfg->findShopCfg();
        }else if($appletType && $appletType==3){   //支付宝小程序配置
            $applet_cfg = new App_Model_Alixcx_MysqlAlixcxCfgStorage($shop['s_id']);
            $cfg        = $applet_cfg->findShopCfg();
        }else if($appletType && $appletType==4){   //头条抖音小程序配置
            $applet_cfg = new App_Model_Toutiao_MysqlToutiaoCfgStorage($shop['s_id']);
            $cfg        = $applet_cfg->findShopCfg();
        }else if($appletType && $appletType==5){    //微信公众号配置
            $applet_model = new App_Model_Weixin_MysqlWeixinCfgStorage($shop['s_id']);
            $cfg = $applet_model->findShopCfg();
        } else if($appletType && $appletType==6){    //QQ小程序配置
            $applet_cfg = new App_Model_Qq_MysqlQqCfgStorage($shop['s_id']);
            $cfg        = $applet_cfg->findShopCfg();
        }else if($appletType && $appletType==7){ //360小程序配置
            $applet_cfg = new App_Model_Qihoo_MysqlQihooCfgStorage($shop['s_id']);
            $cfg        = $applet_cfg->findShopCfg();
        } else{
            $applet_cfg = new App_Model_Applet_MysqlCfgStorage($shop['s_id']);
            $cfg        = $applet_cfg->findShopCfg();
        }
//        $appletCategory = plum_parse_config('category','applet');
//        if(!in_array($cfg['ac_index_tpl'],$appletCategory[$cfg['ac_type']]['tpl'])){
//            $cfg['ac_index_tpl'] = $appletCategory[$cfg['ac_type']]['tpl'][0];
//        }
        // 判断小程序是否被封禁
        if ($cfg['ac_status']) {
            $this->displayJsonError('小程序已被封禁');
        }

        // 判断小程序是否到期
        if (!$cfg || $cfg['ac_expire_time']<time()) {
            $this->displayJsonError('小程序已到期请联系服务商续费');
        }

        // 判断小程序是否到期
        if (!$cfg || $cfg['ac_type']==0) {
            $this->displayJsonError('小程序未订购任何类型模板，请联系服务商订购');
        }
        // 判断小程序是否匹配，防止重复授权情况
        if(plum_get_isset_param('appid') && $appletType==1){
            $appid = $this->request->getStrParam('appid');
//            $appletAppid = $this->request->getStrParam('appletAppid');
//            if($appletType == 5 && $appletAppid){
//                $appid = $appletAppid;
//            }

            if($appletType==1){
                if($appid=='' || $appid=='undefined'){
                    $this->displayJsonError('小程序APPID不存在');
                }elseif($appid != $cfg['ac_appid']){

                    //获取分身小程序信息
                    $child_cfg = new App_Model_Applet_MysqlChildStorage();
                    $child = $child_cfg->fetchUpdateWxcfgByAid($appid);
                    if(!$child){
                        $this->displayJsonError('小程序APPID不匹配');
                    }
                }
            }
            $this->curr_appid = $appid;
        }else{
            $this->curr_appid = $cfg['ac_appid'];
        }

        $this->shop = $shop;
        $this->suid = $shop['s_unique_id'];
        $this->sid  = $shop['s_id'];
        $this->applet_cfg = $cfg;
        $this->watermark = isset($cfg['ac_watermark']) && $cfg['ac_watermark'] ? $cfg['ac_watermark'].'提供技术支持' : ($this->appletType  == 4 ? '河南天店通网络科技有限公司提供技术支持' : '微信服务商提供技术支持');
        $this->openWatermark = $cfg['ac_open_watermark'];  // 是否开启水印功能
        $this->suspensionMenuShow = $cfg['ac_suspension_menu_show'];
        $this->suspensionMenu = $this->_fetch_suspension_menu($cfg['ac_suspension_menu']);
        $this->indexMenu = $this->_fetch_index_menu($cfg['ac_index_menu'],$cfg['ac_index_menu_title'],$cfg['ac_index_menu_open']);
        //检查店铺小程序开通情况
        $result = App_Helper_PluginIn::checkShopAppletOpen($this->sid,$this->appletType);
        if ($result['code']) {
            $this->displayJsonError($result['msg']);
        }
        // 检查店铺是否开通支付宝小程序或百度小程序
//        if(!$result['code']){
//            $this->_wxapp_alipay_Visit($cfg);
//        }
        /*
         * 获取店铺技术支持信息
         */
        

        // 验证用户是否被禁用
        if($this->member){
            if($this->member['m_status']==1 && $this->applet_cfg['ac_type'] != 26){
                plum_app_user_logout();
                $this->outputError('该账户已被禁用，请联系管理员');
            }
        }
    }

    /*
     * 获取程序是否设置首页折叠菜单
     */
     private function _fetch_suspension_menu($suspensionMenu){
         $meunData = array();
         if($suspensionMenu){
             $suspensionMenu = json_decode($suspensionMenu,true);
             foreach ($suspensionMenu as $value){
                 $meunData[] = array(
                     'title'  => $value['title'],
                     'type'   => $value['type'],
                     'imgsrc' => $this->dealImagePath($value['imgsrc']),
                     'link'   => $this->get_link_by_type($value['type'],$value['link'],$value['title']),
                 );
             }
         }
         return $meunData;
     }

    /*
     * 获取程序是否设置首页菜单
     */
    private function _fetch_index_menu($indexMenu,$indexMenuTile,$indexMenuOpen){
        $meunData = array(
            'menu'  => array(),
            'title' => isset($indexMenuTile) && $indexMenuTile ? $indexMenuTile : '',
            'open'  => $indexMenuOpen ? $indexMenuOpen : 0,
        );
        if($indexMenu){
            $indexMenu = json_decode($indexMenu,true);
            if(!empty($indexMenu)){
                foreach ($indexMenu as $value){
                    $meunData['menu'][] = array(
                        'title'  => $value['title'],
                        'type'   => $value['type'],
                        'imgsrc' => $this->dealImagePath($value['imgsrc']),
                        'link'   => $this->get_link_by_type($value['type'],$value['link'],$value['title']),
                    );
                }
            }
        }
        return $meunData;
    }

    /**
     * 根据店铺id获取代理商信息
     */
    function getSuperiorAgent($sid){
        $support = array();
        // 根据公司id获取代理商信息
        $support_storage = new App_Model_Agent_MysqlAgentSupportStorage();
        $row = $support_storage->getAgentSupportBySid($sid);
        if($row){
            $support = $row;
            if($support['as_audit'] && $this->applet_cfg['ac_appletad_open']){
                $support['as_audit'] = 1;
            }else{
                $support['as_audit'] = 0;
            }

        }
        $this->support = $support;
        // 获取技术支持水印图片
        $agent_storage = new App_Model_Agent_MysqlOpenStorage(0);
        $agent = $agent_storage->getAgentBySid($sid);
        $this->watermarkImg = isset($agent['aa_default_watermark_img']) && $agent['aa_default_watermark_img'] ? $this->dealImagePath($agent['aa_default_watermark_img']): ($this->appletType == 4 ? $this->dealImagePath(plum_parse_config('default_wartermark','agent')['logo']) : '');
        $oem_storage = new App_Model_Agent_MysqlAgentOemStorage();
        $oem = $oem_storage->findOemByAaid($agent['aa_id']);
        if($oem && $oem['ao_domain']){
            $this->entershop_login_url = $oem['ao_domain'].'/shop/index/enterLogin?from=shop';
        }else{
            $this->entershop_login_url = plum_parse_config('url_arr')['entershop_login'];
        }

    }


    /**
     * 检查店铺是微信小程序访问或者支付宝访问；如果未开通支付宝小程序将会限制访问
     */
    private function _wxapp_alipay_Visit($cfg){
        $wxsign = 'MicroMessenger';   // 微信小程序访问标志
        $alsign = 'ALIPAY';           // 支付宝小程序访问的标志
        $bdsign = 'baiduboxapp';       // 百度小程序访问标志
        $ttsign = 'Toutiao';       // 头条及抖音客户端访问标志
        $wxwebsign = 'Process/tools';       // 微信网页访问
        $qqsign = 'qq'; // qq小程序访问标志
        $str = plum_get_server('HTTP_USER_AGENT');   // 访问传过来的一些信息
        if($this->sid == 8589){
            Libs_Log_Logger::outputLog($str,'test.log');
        }

        // 判断是否是支付宝访问
        if(stripos($str,$alsign) !== false){
            // 判断是否开通了支付宝小程序
            if(!$cfg['ac_aliapp_open'] && (!$cfg || $cfg['ac_type']==0 || $cfg['ac_expire_time']<time())){
                $this->outputError('该账户暂未开通支付宝小程序');
            }
        }
        //判断是否是百度小程序访问
        if(stripos($str,$bdsign) !== false){
            // 判断是否开通了百度小程序
            $applet_cfg = new App_Model_Baidu_MysqlBaiduCfgStorage($this->sid);
            $baiducfg = $applet_cfg->findShopCfg();
            if(!$baiducfg || $baiducfg['ac_type']==0 || $baiducfg['ac_expire_time']<time()){
                $this->outputError('该账户暂未开通百度小程序');
            }
        }
        if($this->sid==11){
            Libs_Log_Logger::outputLog($str,'test2.log');
        }

        // 可以进行调试的店铺ids,小程序店铺类型，小程序类型（微信，百度，）
        // zhangzc
        // 2019-09-18
        $debug_sids=[12253,9373,5655,8941,5474,11738,10043,3712,11,4286,4697,8298,3906];
        $debug_actypes=[15,27,6];
        $debug_miniTypes=[4,5];

        // if($this->appletType != 4 && $this->sid != 12253 && $this->sid != 9373 && $this->sid != 5655 && $this->sid != 8941 && $this->sid != 5474 && $this->applet_cfg['ac_type'] !=15 && $this->applet_cfg['ac_type'] != 27 && $this->applet_cfg['ac_type'] != 6 && $this->sid != 11738 && $this->sid!=10043 && $this->sid != 3712 && $this->sid != 11){
        if(!in_array($this->appletType,$debug_miniTypes) && !in_array($this->sid,$debug_sids) && !in_array($this->applet_cfg,$debug_actypes) && $this->appletType != 6){
            // 判断是否在客户端中访问小程序
            if(stripos($str,$wxsign) == false && stripos($str,$alsign) == false && stripos($str,$bdsign) == false && stripos($str,$ttsign) == false && stripos($str,$qqsign) === false){
                $this->outputError('请在客户端中访问小程序.');
            }
            // 判断是否在微信网页中访问
            if(stripos($str,$wxsign) !== false && stripos($str,$wxwebsign) !== false){
                $this->outputError('请在客户端中访问小程序..');
            }
        }



    }

    /**
     * 校验是否获取用户信息
     */
    private function _verify_member(){
        $uid    = plum_app_user_islogin();
        //$test   = $this->request->getIntParam('test');

        //  测试 -2019-11-09
        if(!$uid) {
            $test11 = $this->request->getIntParam('test');
            if($test11) {
                $uid = 4;
            }
        }

        // 如果会员信息不存在会去验证
        if(!$uid){
            $this->_weixin_applet_Bind();
        }else {
            //通过session获取用户信息
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member   = $member_storage->getRowById($uid);
            //非同一个店铺
            if ($member['m_s_id'] != $this->shop['s_id']) {
                plum_app_user_logout();
                $this->_verify_member();
                //$this->outputError('获取用户信息失败');
            } else {
                if($member['m_status']==1 && $this->applet_cfg['ac_type'] != 26){
                    plum_app_user_logout();
                    $this->outputError('该账户已被禁用，请联系管理员');
                }else{
                    $this->member = $member;
                    $this->uid = $uid;
                }
            }
        }
    }


    /*
   * 通过code和encryptedData和iv解密获取用户信息
   */
    private function _weixin_applet_Bind(){
        $code       = $this->request->getStrParam('code');          // 用户code
        $nickname   = $this->request->getStrParam('nickname');      // 昵称
        $gender     = $this->request->getIntParam('gender');        // 性别：0未知，1男，2女
        $province   = $this->request->getStrParam('province');      // 省份
        $city       = $this->request->getStrParam('city');          // 城市
        $avatarUrl  = $this->request->getStrParam('avatarUrl');     // 头像
        $appid      = $this->request->getStrParam('appid');         // 小程序APPID
        $slient     = $this->request->getIntParam('slient');        // 是否是静默授权
        $fid        = $this->request->getIntParam('mid');           // 邀请人id
        $join_type  = $this->request->getIntParam('join_type',0);           // 邀请人id
        $iv         = $this->request->getStrParam('iv');            // 加密算法的初始向量
        $encryptedData = $this->request->getParam('encryptedData'); // 加密后的数据
        $shareMid = $this->request->getIntParam('shareMid');
        $getUnionId = $this->request->getIntParam('getUnionId',0);
        if($code){
            if($appid && mb_strlen($appid)==18){
                $curr_appid = $appid;
            }else{
                $curr_appid = $this->applet_cfg['ac_appid'];
            }
            if($this->appletType==2){  //百度小程序
                $result = App_Helper_Baidu::getBdopenid($this->applet_cfg['ac_appkey'],$this->applet_cfg['ac_appsecret'],$code);
                $source = 4; // 百度小程序
            }elseif($this->appletType==3){  //支付宝小程序
                $alixcx_client  = new App_Plugin_Alixcx_XcxClient($this->sid);
                $token  = $alixcx_client->fetchSystemOauthToken($code);
                if($token && $token['access_token'] && $token['alipay_user_id']){
                    $infoBase = $alixcx_client->fetchMemberBaseInfo($token['access_token']);
                    if($infoBase && $infoBase['code']=='10000' && $infoBase['msg']=='Success'){
                        $result['openid'] = $infoBase['user_id'];
                    }
                }
                $source = 3; //支付宝小程序
            }elseif($this->appletType==4){  //头条小程序
                $result = App_Plugin_Toutiao_XcxClient::getToutiaoOpenid($curr_appid,$this->applet_cfg['ac_appsecret'],$code);
                $source = 6; // 头条小程序
            }elseif ($this->appletType == 6){
                $result = App_Plugin_Qq_XcxClient::getQqOpenid($curr_appid,$this->applet_cfg['ac_appsecret'],$code);
                $source = 7; // qq小程序
            }elseif ($this->appletType == 7){
                $result = App_Plugin_Qihoo_XcxClient::getQihooOpenid($curr_appid,$this->applet_cfg['ac_appsecret'],$code);
                $result['openid'] = $result['open_id'];
                $source = 8; // 360小程序
            } else{  // 微信小程序
                // 获取用户授权方式
                $auth   = App_Plugin_Weixin_WxxcxClient::weixinAuthType($this->sid);
                if($auth == App_Plugin_Weixin_WxxcxClient::WEIXIN_AUTH_OPEN){
                    // 获取用户的openID
                    $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->sid);
                    $result    = $wxxcx_client->fetchOpenidByCode($curr_appid,$code);
                }else{
                    $result = App_Helper_WeixinEvent::getWxopenid($curr_appid,$this->applet_cfg['ac_appsecret'],$code);
                }
                $source = 2; //微信小程序
            }

            // 获取到用户的openID
            if($result && $result['openid']){
                // 通过用户的openID获取会员信息
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_storage->findUpdateMemberByWeixinOpenid($result['openid'],$this->sid);

                // 如果信息不存在则插入一条新纪录
                if(!$member){
                    // 获取会员编号的最大值
                    $member_redis   = new App_Model_Member_RedisMemberStorage($this->sid);
                    $max = $member_redis->fetchShopMaxShowId();

                    $date = date('YmdHi', time()).rand(1111,9999);
                    if($this->appletType==3){
                        $data = array(
                            'm_user_id'     => 0,//有赞用户id，设置为空
                            'm_is_follow'   => 1,//默认为关注
                            'm_source'      => $source,//会员来源，小程序
                            'm_show_id'     => $max,//会员来源，小程序
                            'm_nickname'    => $infoBase['nick_name'] ? trim($infoBase['nick_name']) : "会员{$date}",
                            'm_sex'         => $infoBase['gender'] == 'm' ? '男' : '女',
                            'm_province'    => $infoBase['province'],
                            'm_city'        => $infoBase['city'],
                            'm_avatar'      => $infoBase['avatar'],
                            'm_s_id'        => $this->shop['s_id'],
                            'm_c_id'        => $this->shop['s_c_id'],//所属公司id
                            'm_openid'      => $result['openid'],
                            'm_follow_time' => date('Y-m-d H:i:s', time()),
                            'm_update_time' => time(),//记录为创建时间
                            'm_join_status'   => $join_type,
                        );
                    }else{
                        $data = array(
                            'm_user_id'     => 0,//有赞用户id，设置为空
                            'm_is_follow'   => 1,//默认为关注
                            'm_source'      => $source,//会员来源，小程序
                            'm_show_id'     => $max,//会员来源，小程序
                            'm_nickname'    => $nickname ? trim($nickname) : "会员{$date}",
                            'm_sex'         => $gender == 1 ? '男' : '女',
                            'm_province'    => $province,
                            'm_city'        => $city,
                            'm_avatar'      => $avatarUrl,
                            'm_s_id'        => $this->shop['s_id'],
                            'm_c_id'        => $this->shop['s_c_id'],//所属公司id
                            'm_openid'      => $result['openid'],
                            'm_follow_time' => date('Y-m-d H:i:s', time()),
                            'm_update_time' => time(),//记录为创建时间
                            'm_join_status'   => $join_type,
                        );
                    }
                    if($slient){
                        $data['m_is_slient'] = 1;  //是否是静默授权
                    }
                    // 微信小程序获取用户unionID等用户信息
                    if(($this->appletType==1 || $this->appletType == 6) && $result['session_key'] && $iv && $encryptedData){
                        $userinfo = $this->_get_user_info($result['session_key'],$iv,$encryptedData);
                        if(isset($userinfo['unionId']) && $userinfo['unionId']){
                            $data['m_union_id'] = $userinfo['unionId'];
                        }
                    }
                    if(($this->appletType==1 || $this->appletType == 6) && $result['unionid']){
                        $data['m_union_id'] = $result['unionid'];
                    }
                    $uid  = $member_storage->insertValue($data,true,false,true);
                    if($fid && $this->applet_cfg['ac_type'] == 30){
                        //邀请新用户任务
                        App_Helper_Tool::checkGameTask($this->sid, $fid, 6);
                    }
                    //再次取出会员数据
                    $this->member   = $member_storage->getRowById($uid);
                }else{
                    // 如果账号被封禁
                    if($member && $member['m_status']==1 && $this->applet_cfg['ac_type']!=26){
                        plum_app_user_logout();
                        $this->outputError('账号已被禁用，请联系管理员');
                    }
                    // 获取用户的unionid等用户信息
                    if($this->appletType==1 && $result['session_key'] && $iv && $encryptedData){
                        $userinfo = $this->_get_user_info($result['session_key'],$iv,$encryptedData);
                        if($this->sid == 8298){
                            Libs_Log_Logger::outputLog('解密userinfo','test.log');
                            Libs_Log_Logger::outputLog($userinfo,'test.log');
                        }
                    }
                    if(!$slient){
                        // 如果存在则修改用户信息
                        $updata = [];
                        if(!$getUnionId){
                            $updata = array(
                                'm_nickname'    => $nickname,
                                'm_sex'         => $gender == 1 ? '男' : '女',
                                'm_province'    => $province,
                                'm_city'        => $city,
                                'm_avatar'      => $avatarUrl,
                            );
                        }

                        if(isset($userinfo['unionId']) && $userinfo['unionId']){
                            $updata['m_union_id'] = $userinfo['unionId'];
                        }
                        if(!empty($updata)){
                            $member_storage->findUpdateMemberByWeixinOpenid($result['openid'],$this->sid,$updata);
                        }

                    }
                    if(($this->appletType==1 || $this->appletType == 6) && $result['unionid'] && (!$member['m_union_id'] || $member['m_union_id']!=$result['unionid'])){
                        $updata['m_union_id'] = $result['unionid'];
                        $member['m_union_id'] = $result['unionid'];
                        $ret = $member_storage->findUpdateMemberByWeixinOpenid($member['m_openid'],$this->sid,$updata);
                    }
                    $uid = $member['m_id'];
                    $this->member = $member;
                }
                $this->uid = $uid;

                plum_app_user_login($uid);
            }else{
                $this->outputError('获取用户信息失败.');
            }
        }else{
            $this->outputError('获取用户信息失败..');
        }
    }

    /*
    * 通过code和encryptedData和iv解密获取用户信息
    */
    private function _weixin_applet_Bind_old(){
        $code          = $this->request->getStrParam('code');   // 用户code
        $iv            = $this->request->getStrParam('iv');     // 加密算法的初始向量
        $encryptedData = $this->request->getParam('encryptedData');  // 加密后的数据
        if($code){
            // 通过code换取用户的openID
            $wx_cfg = array(
                'app_id'     => 'wxc3923a18b21ad187',
                'app_secret' => 'ad66c4c76a083723f5b43a870d0dda73',
            );
            $result = App_Helper_WeixinEvent::getWxopenid($wx_cfg['app_id'],$wx_cfg['app_secret'],$code);
            // 获取到用户的openID
            if($result['openid']){
                // 通过用户的openID获取会员信息
                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_storage->findUpdateMemberByWeixinOpenid($result['openid'],$this->sid);
                // 如果信息不存在则插入一条新纪录
                if(!$member){
                    if($result['session_key'] && $iv && $encryptedData){
                        $userinfo = $this->_get_user_info($result['session_key'],$iv,$encryptedData);
                        if($userinfo){
                            $data = array(
                                'm_user_id'     => 0,//有赞用户id，设置为空
                                'm_is_follow'   => 1,//默认为关注
                                'm_source'      => 2,//会员来源，小程序
                                'm_nickname'    => $userinfo['nickName'],
                                'm_sex'         => $userinfo['gender'] == 1 ? '男' : '女',
                                'm_province'    => $userinfo['province'],
                                'm_city'        => $userinfo['city'],
                                'm_avatar'      => $userinfo['avatarUrl'],
                                'm_s_id'        => $this->shop['s_id'],
                                'm_c_id'        => $this->shop['s_c_id'],//所属公司id
                                'm_openid'      => $userinfo['openId'],
                                'm_follow_time' => date('Y-m-d H:i:s', time()),
                            );
                            if(isset($userinfo['unionId']) && $userinfo['unionId']){
                                $data['m_union_id'] = $userinfo['unionId'];
                            }
                            $uid  = $member_storage->insertShopNewMember($this->shop['s_id'], $data);
                        }
                    }
                    //再次取出会员数据
                    $this->member   = $member_storage->getRowById($uid);
                }else{
                    $uid = $member['m_id'];
                    $this->member = $member;
                }
                plum_app_user_login($uid);
            }
        }else{
            $this->outputError('获取用户信息失败');
        }
    }

    /*
     * encryptedData和iv解密获取用户信息
     */
    private function _get_user_info($sessionKey,$iv,$encryptedData){
        // 获取小程序微信配置
//        $applet_storage = new App_Model_Applet_MysqlCfgStorage($this->sid);
//        $wx_cfg = $applet_storage->findShopCfg();
        $wx_cfg = $this->applet_cfg;
        if($sessionKey && $iv && $encryptedData){
            // 解密数据
            $wxBizDataCrypt = new App_Plugin_Weixin_DecryptInfo();
            $decryptData = $wxBizDataCrypt->getUserInfo($wx_cfg['ac_appid'],$sessionKey,$encryptedData, $iv);
            $userInfo = json_decode($decryptData['data'],true);
            if($decryptData['code']==0){
                return $userInfo;
            }
        }
        return false;
    }


    /**
     * 获取店铺小程序配置
     */
    public function shop_cfg_updata($version,$base){
        // 获取小程序配置
        $applet_storage = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $wx_cfg = $applet_storage->findShopCfg();
        if($base && $wx_cfg['ac_base']<$base){
            $data = array(
                'ac_base'    => $base,
                'ac_version' => $version,
            );
            $applet_storage->findShopCfg($data);
        }
    }


    /**
     * 获取模板首页幻灯
     */
    public function get_shop_index_slide($tpl_id, $type=1){
        $data = array();
        //获取店铺幻灯
        $slide_storage  = new App_Model_Shop_MysqlShopSlideStorage($this->sid);
        $slide      = $slide_storage->fetchSlideShowList($tpl_id, $type);
        if($slide){
            foreach ($slide as $val){
                $data[] = array(
                    'id'   => $val['ss_id'],
                    'link' => $val['ss_link'],
                    'type' => intval($val['ss_link_type']),
                    'img'  => isset($val['ss_path']) ? $this->dealImagePath($val['ss_path']) : '',
                    'url'  => $this->get_link_by_type($val['ss_link_type'],$val['ss_link'],$val['ss_name']),
                );
            }
        }else{
            if($type != 9 && $type != 13){
                $data[] = array(
                    'id'   => 1,
                    'type' => 1,
                    'link' => '',
                    'img'  => $this->dealImagePath('/public/wxapp/images/slide_default.png'),
                );
            }
        }
        return $data;

    }

    //根据用户传入的经纬度，计算用户与店铺的距离，单位米
    public function getDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6367000;
        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;

        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;

        $calcLongitude = $lng2 - $lng1;
        $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = $earthRadius * $stepTwo;

        return round($calculatedDistance);
    }

    /**
     * 根据经纬度获取位置信息
     */
    public function _get_address_by_lat_lng($lng=0,$lat=0){
        /*$lat   =  $this->request->getStrParam('lat');
        $lng   =  $this->request->getStrParam('lng');
        if($lat && $lng){
            $key  =  '7B4BZ-ZY6LJ-IXOFN-FWAZO-3PQCO-BZBRB';
            $arr  =  array('location'=>$lat.','.$lng,'key'=>$key);
            $ret  =  Libs_Http_Client::get('http://apis.map.qq.com/ws/geocoder/v1',$arr);
            $adr  =  json_decode($ret,1)['result']['address'];
            return $adr;
        }*/
        if(!$lng || !$lat){
            $lat   =  $this->request->getStrParam('lat');
            $lng   =  $this->request->getStrParam('lng');
        }
        if($lat && $lng){
            $key  =  plum_parse_config('mapKay');
            $ret  =  Libs_Http_Client::get('http://restapi.amap.com/v3/geocode/regeo?output=json&location='.$lng.','.$lat.'&key='.$key.'&radius=1000&extensions=all');
            $ret_arr = json_decode($ret,1);
            $adr  =  $ret_arr['regeocode']['formatted_address'];
            $province = $ret_arr['regeocode']['addressComponent']['province'];
            $city  = $ret_arr['regeocode']['addressComponent']['city'];
            $adcode = $ret_arr['regeocode']['addressComponent']['adcode'];
            $citycode = $ret_arr['regeocode']['addressComponent']['citycode'];
            $district = $ret_arr['regeocode']['addressComponent']['district'];
            $township = $ret_arr['regeocode']['addressComponent']['township'];
            $building = $ret_arr['regeocode']['addressComponent']['building']['name'];
            if(!$building){
                $building = $ret_arr['regeocode']['addressComponent']['neighborhood']['name'];
            }

            $data = array(
                'address' => str_replace($province.$city, '', $adr),
                'building' => $building?$building:str_replace($province.$city, '', $adr),
                'prov' => $province,
                'adcode' => $adcode,
                'citycode' => $citycode,
                'district' => is_array($district)?(is_array($township)?'':$township):$district,
                'city' => $city?$city:($province ? $province : ''),
            );
        }else{
            $company_storage = new App_Model_Member_MysqlCompanyCoreStorage();
            $company = $company_storage->getRowById($this->shop['s_c_id']);
            $data = array(
                'address'   => $company['c_province'].$company['c_city'],
                'building'  => '',
                'prov'      => $company['c_province'],
                'city'      => $company['c_city'],
                'district'  => ''
            );
        }
        return $data;
    }
    /*
     * 新的连接地址
     */
    public function get_link_by_type($type,$link,$name,$extra = ''){
        if($this->appletType == 4){
            $url = $this->_get_link_by_type_toutiao($type,$link,$name,$extra);
        }else{
            $url = $this->_get_link_by_type_normal($type,$link,$name,$extra);
        }

        return $url;
    }

    /*
     * 获得链接地址
     */
    private function _get_link_by_type_normal($type,$link,$name,$extra = ''){
        $system = $this->request->getStrParam('system');
        $appletType = $this->request->getIntParam('appletType',1);
        $type = intval($type);
        $url = '';
        switch ($type){
            case 1 :   // 资讯详情
                $url = '/pages/informationDetail/informationDetail?id='.$link;
                break;
            case 2 :  // 列表
                $exist = strstr($link,'?');
                if($exist){
                    $url = $link.'&title='.$name;
                }else{
                    $url = $link.'?title='.$name;
                }
                if(($this->applet_cfg['ac_type'] == 8 || $this->applet_cfg['ac_type'] == 6) && $link=="/pages/goodslist/goodslist"){
                    $url = $link.'?type=special&title='.$name;
                }
                //酒店版链接配置特殊 2018-12-25
                if($this->applet_cfg['ac_type'] == 7){
                    $url = $link;
                }
                if($link == '/pages/applyTuan/applyTuan'){
                    //社区团购团长申请不要title
                    $url = $link;
                }

                break;
            case 3 :   //自定义外链
                //$url = '/pages/commonView/commonView?linksrc='.$link;
                $this->sid==10418 ? $url=$link : $url = 'https://hz.51fenxiaobao.com/?url='.$link;
                break;
            case 4 :   // 商城分组列表
                if($this->applet_cfg['ac_type'] == 32 || $this->applet_cfg['ac_type'] == 36){
                    $url = '/subpages0/flGoodsList/flGoodsList?id='.$link.'&title='.$name;
                }else{
                    $url = '/pages/flGoodsList/flGoodsList?id='.$link.'&title='.$name;
                }

                break;
            case 5 :   // 商城商品详情
                if($this->applet_cfg['ac_type'] == 27){
                    //知识付费
                    $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                    $goods = $goods_storage->getRowById($link);
                    if($goods['g_knowledge_pay_type'] == 1){
                        $url = '/pages/zlDetail/zlDetail?id='.$link;
                    }
                    if($goods['g_knowledge_pay_type'] == 2){
                        $url = '/pages/audioDetail/audioDetail?id='.$link;
                    }
                    if($goods['g_knowledge_pay_type'] == 3){
                        $url = '/pages/videoDetail/videoDetail?id='.$link;
                    }
                }elseif ($this->applet_cfg['ac_type'] == 4){
                    $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                    $goods = $goods_storage->getRowById($link);
                    if($goods['g_independent_mall'] == 1){
                        $url = '/subpages0/goodDetail/goodDetail?id='.$link;
                    }else{
                        $url = '/pages/goodDetail/goodDetail?id='.$link;
                    }
                }else{
                    $url = '/pages/goodDetail/goodDetail?id='.$link;
                }
                break;
            // 独立商城的商品详情
            case 502:
                if($this->applet_cfg['ac_type'] == 27)
                    $url = '/subpages0/goodDetail/goodDetail?id='.$link;
                break;
             // 社区团购商品活动页面
             // zhangzc
             // 2019-10-18
            case 503:
                if($this->applet_cfg['ac_type'] == 32)
                    $url = '/pages/activityDetail/activityDetail?id='.$link;
                break;
            //添加收银台链接
            //zhangzc
            //2019-11-11 
            case 504:
                $url = '/pages/payshort/payshort';
                break;
            // 添加分类导航页面
            // zhangzc
            // 2019-11-15
            case 505:
                if($this->applet_cfg['ac_type'] == 32)
                    $url = '/subpages/allFlGoodsPage/allFlGoodsPage';
                break;

            case 6 :    // 微预约分类列表
                $url = '/pages/goods/goods?id='.$link.'&title='.$name;
                break;
            case 7 :   // 微婚纱样片详情
                $url = '/pages/articleDetail/articleDetail?id='.$link;
                break;
            case 8 :   // 微驾考练车场地详情
                $url = '/pages/lccdDetail/lccdDetail?id='.$link;
                break;
            case 9 :   // 商城商品分类列表
            case 501:
                if($this->applet_cfg['ac_type'] == 6 || $this->applet_cfg['ac_type'] == 8){
                    $url = '/subpages0/allgoodsPage/allgoodsPage?oneid=&secondid='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 18){
                    $url = '/pages/goods/goods?id='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 8){
                    $url = '/subpages0/allgoodsPage/allgoodsPage?id='.$link.'&title='.$name;
                }elseif ($this->applet_cfg['ac_type'] == 32 || $this->applet_cfg['ac_type'] == 36){
                    $kind_model     = new App_Model_Shop_MysqlKindStorage($this->sid);
                    $kind = $kind_model->getRowById($link);
                    $url = '/subpages/flGoods/flGoods?secondCategoryId='.$link.'&title='.$name.'&categoryId='.$kind['sk_fid'];
                }elseif($this->applet_cfg['ac_type'] == 27){
                    $url = '/subpages0/allgoodsPage/allgoodsPage?oneid=&secondid='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 4){
                    $url = '/subpages0/flGoods/flGoods?categoryId=&secondCategoryId='.$link.'&title='.$name;
                } else{
                    $url = '/pages/allgoodsPage/allgoodsPage?oneid=&secondid='.$link.'&title='.$name;
                }
                break;
            case 10 :   // 门店版商品分类列表
                $url = '/pages/goodsList/goodsList?id='.$link.'&title='.$name;
                break;
            case 11 :   // 秒杀版秒杀商品分组
                $url = '/pages/seckillGoodList/seckillGoodList?category='.$link.'&title='.$name;
                break;
            case 12 :   // 拼团版拼团商品分组
                if($this->applet_cfg['ac_type'] == 6||$this->applet_cfg['ac_type'] == 21){
                    $url = '/subpages0/groupGoodsList/groupGoodsList?menuid='.$link.'&title='.$name;
                }else if($this->applet_cfg['ac_type'] == 18 ){
                    $url = '/subpages/groupGoodsList/groupGoodsList?menuid='.$link.'&title='.$name;
                }else{
                    $url = '/pages/groupGoodsList/groupGoodsList?menuid='.$link.'&title='.$name;
                }
                break;
            case 13 :   // 房产版房源详情
                $url = '/pages/houseDetail/houseDetail?id='.$link.'&title='.$name;
                break;
            case 14 :   // 房产版楼盘详情
                $url = '/pages/skillHousesDetail/skillHousesDetail?id='.$link.'&title='.$name;
                break;
            case 16 :   // 社区版店铺分类列表
                if($this->applet_cfg['ac_type'] == 4){
                    //餐饮
                    $url = '/subpages/flMulShopList/flMulShopList?cate1='.$link.'&title='.$name;
                }else{
                    $url = '/pages/flShoplist/flShoplist?cate1='.$link.'&title='.$name;
                }
                break;
            case 17 :   // 社区版入驻店铺详情
                $url = '/pages/shopDetail/shopDetail?id='.$link;
                break;
            case 18 :   // 企业版店铺产品服务列表
                $url = '/pages/servicePage/servicePage?id='.$link.'&title='.$name;
                break;
            case 19 :   // 企业版店铺产品服务详情
                $url = '/pages/articleDetail/articleDetail?id='.$link;
                break;
            case 20 :   // 同城版入驻店铺详情
                if($this->applet_cfg['ac_type'] == 33){
                    $url = '/pages/serviceproDetail/serviceproDetail?id='.$link;
                }else{
                    $url = '/pages/shopDetailnew/shopDetailnew?id='.$link;
                }

                break;
            case 21 :   // 多门店资讯分类
                $url = '/pages/informationPage/informationPage?id='.$link.'&title='.$name;
                break;
            case 22 :   // 全功能商城商品列表(分类)
                if($this->applet_cfg['ac_type'] == 24){
                    $url = '/pages/wnGoodsList/wnGoodsList?id='.$link;
                }else{
                    $url = '/pages/wnGoodsList/wnGoodsList?goodType='.$link;
                }
                break;
            case 23 :   // 一级分类商品列表
            case 500:
                if($this->applet_cfg['ac_type'] == 6){
                    $url = '/subpages0/wnGoodsList/wnGoodsList?id='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 32 || $this->applet_cfg['ac_type'] == 36){
                    $url = '/subpages/flGoods/flGoods?categoryId='.$link.'&title='.$name;
                }elseif ($this->applet_cfg['ac_type'] == 8){
                    $url = '/subpages0/wnGoodsList/wnGoodsList?id='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 27){
                    $url = '/pages/wnGoodsList/wnGoodsList?id='.$link.'&title='.$name;
                } elseif($this->applet_cfg['ac_type'] == 4){
                    $url = '/subpages0/flGoods/flGoods?categoryId='.$link.'&title='.$name;
                }else{
                    $url = '/pages/wnGoodsList/wnGoodsList?id='.$link.'&title='.$name;
                }
                break;
            case 24 :   // 培训课程列表 带分类id
                $url = '/pages/course/course?id='.$link;
                break;
            case 25 :   // 问答小程序 分类问题列表
                $url = '/pages/problemList/problemList?id='.$link;
                break;
            case 26 :   // 知识付费 分类列表
                $url = '/pages/productList/productList?type='.$link.'&name='.$name;
                if($extra > 0){
                    $url .= '&id='.$extra;
                }
                break;
            case 27 : //同城多店  商家商品详情
                if ($this->applet_cfg['ac_type'] == 33){
                    $url = '/pages/productDetail/productDetail?id='.$link;
                }elseif ($this->applet_cfg['ac_type'] == 8){
                    $url = '/pages/shopgoodsDetail/shopgoodsDetail?id='.$link;
                }else{
                    $url = '/subpages/shopgoodsDetail/shopgoodsDetail?id='.$link;
                }
                break;
            case 28 : //同城多店 商品分类
                $esgc_model = new App_Model_Entershop_MysqlGoodsCategoryStorage(0);
                $esgc = $esgc_model->getRowById($link);
                $esId = intval($esgc['esgc_s_id']);
                $title = $esgc['esgc_name'];
                $url = '/subpages/goodslist/goodslist?sid='.$esId.'&flid='.$link.'&title='.$title;
                break;
            case 29 : //秒杀商品详情
                $url = '/pages/goodDetail/goodDetail?id='.$link;
                break;
            case 30 : //拼团商品详情
                $url = '/pages/groupGoodDetail/groupGoodDetail?goodid='.$link;
                break;
            case 31 : //砍价商品详情
                $url = '/subpages/bargainGoodDetail/bargainGoodDetail?id='.$link;
                break;
            case 32 : //资讯分类
                if($this->applet_cfg['ac_type'] == 7){
                    $url = '/pages/informationSpecial/informationSpecial?id='.$link.'&title='.$name;
                }else{
                    $url = '/pages/informationPage/informationPage?id='.$link.'&title='.$name;
                }

                break;
            case 33 ://同城多店 入主店铺商品分组
                $url = '/subpages/wnGoodsList/wnGoodsList?goodType='.$link;
                break;
            case 34 ://同城 商家分类列表
                $category_model = new App_Model_City_MysqlCityPostCategoryStorage(0);
                $category = $category_model->getRowById($link);
                $name = $category['acc_title'];
                $url = '/pages/searchShop/searchShop?id='.$link.'&title='.$name;
                break;
            case 35 ://招聘小程序 职位列表
                $url = '/pages/jobList/jobList?secondid='.$link.'&title='.$name;
                break;
            case 36 ://招聘小程序 职位详情
                $url = '/pages/jobDetail/jobDetail?id='.$link;
                break;
            case 37 ://预约 专家详情
                $url = '/pages/teamsDetail/teamsDetail?id='.$link;
                break;
            case 38 ://预约 专家分类列表
//                $category_model = new App_Model_Shop_MysqlKindStorage(0);
//                $category = $category_model->getRowById($link);
                $name = $name ? $name : '团队';
                $url = '/pages/teams/teams?id='.$link.'&title='.$name;
                break;
            case 39 ://游戏盒子 游戏列表
                $url = '/pages/gameList/gameList?id='.$link.'&title='.$name;
                break;
            case 40 ://同城帖子分类列表
                $category_model = new App_Model_City_MysqlCityPostCategoryStorage(0);
                $category = $category_model->getRowById($link);
                $url = '/pages/postList/postList?id='.$link.'&title='.$category['acc_title'].'&price='.$category['acc_price'];
                break;
            case 41 ://多店 平台商品分组
                if($this->applet_cfg['ac_type'] == 8){
                    $url = '/pages/wnGoodsList/wnGoodsList?from=platform&goodType='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 6){
                    $url = '/subpages/wnGoodsList/wnGoodsList?from=platform&goodType='.$link.'&title='.$name;
                }
                break;
            case 42 ://多店 入主店铺商品分组
                if($this->applet_cfg['ac_type'] == 6){
                    $url = '/subpages/wnGoodsList/wnGoodsList?from=shop&goodType='.$link.'&title='.$name;
                }else{
                    $url = '/pages/wnGoodsList/wnGoodsList?from=shop&goodType='.$link.'&title='.$name;
                }
                break;
            case 43 ://餐饮 店铺详情
                $url = '/pages/mulShopDetail/mulShopDetail?esId='.$link;
                break;
            case 44://二手车 车源详情详情
                $url = '/pages/carDetail/carDetail?id='.$link;
                break;
            case 45://二手车 服务商分类列表
                $url = '/subpages/serviceProvider/serviceProvider?id='.$link.'&title='.$name;
                break;
            case 46://付费预约商品详情
                // 付费预约添加婚纱的特殊类型
                // zhangzc
                // 2019-11-11
                if($this->applet_cfg['ac_type'] == 9)
                    $url = '/pages/Generalreservationdetail/Generalreservationdetail?id='.$link;
                else
                    $url = '/subpages/Generalreservationdetail/Generalreservationdetail?id='.$link;
                break;
            case 47://付费预约商品详情
                $url = '/subpages0/auctionpage/auctionDetail/auctionDetail?id='.$link;
                break;
            case 48://内推招聘公司详情
                $url = '/subpages/companyDetail/companyDetail?id='.$link;
                break;
            case 49://知识付费签到
                $url = '/subpages/signin/signin';
                break;
            case 50://招聘公司列表
                $url = '/subpages0/companyHall/companyHall?oneid='.$link.'&title='.$name;
                break;
            case 51://婚纱系列分类列表
                $url = '/pages/fenggeList/fenggeList?id='.$link.'&title='.$name;
                break;
            case 52://婚纱模特样片分类列表
                $url = '/pages/jianzheng/jianzheng?cate='.$link.'&type=1';
                break;
            case 53://婚纱见证客片分类列表
                $url = '/pages/jianzheng/jianzheng?cate='.$link.'&type=2';
                break;
            case 54://婚纱见证客片分类列表
                $url = '/pages/shopDetail/shopDetail?id='.$link;
                break;
            case 55://自定义表单
                if($extra > 0 && !$link){
                    $link = $extra;
                }
                $url = '/pages/generalForm/generalForm?id='.$link;
                break;
            case 56://自定义模板
                if($extra > 0 && !$link){
                    $link = $extra;
                }
                $url = '/pages/webviewPage/webviewPage?id='.$link;
                break;
            case 57 :   // 培训课程详情
                $url = '/pages/newCourseDetail/newCourseDetail?id='.$link;
                break;
            case 58 :   // 餐饮排号
                $url = '/subpages/arrangingPage/arrangingPage?esId='.$link;
                break;
            case 59 :   //入驻店铺秒杀活动详情
                $url = '/pages/goodDetail/goodDetail?id='.$link;
                break;
            case 60 :   //入驻店铺砍价活动详情
                $url = '/subpages/bargainGoodDetail/bargainGoodDetail?id='.$link;
                break;
            case 61 :   //菜单详情
                $url = '/subpages0/finefoodDetail/finefoodDetail?id='.$link;
                break;
            case 62 :   //内推招聘职位一级分类列表
                $url = '/pages/jobList/jobList?oneid='.$link.'&title='.$name;
                break;
            case 104 :   // 菜单
                if($link == '/subpages/walletRecharge/walletRecharge?from=slide'){
                    $url = $link.'&title='.$name;
                }else{
                    $url = '/'.$link.'?title='.$name;
                }
                break;
            case 106 :   // 小程序appid
                $url = $link;
                break;
        }
        if($system && $system == 'ios'){
            if($link == "/subpages/memberCard/memberCard"){
                $url = array(
                    'msg' => '十分抱歉，由于相关规范，暂时无法使用此功能'
                );
            }
        }

        if($appletType == 5 && $url && $type != 3){
            $routeInfo = $this->getPageRoute($url);
            $url = $routeInfo['route'];
        }
        return $url;
    }

    /*
     * 获得抖音链接地址
     */
    private function _get_link_by_type_toutiao($type,$link,$name,$extra = ''){
        $system = $this->request->getStrParam('system');
        $type = intval($type);
        $url = '';
        switch ($type){
            case 1 :   // 资讯详情
                $url = '/pages/informationDetail/informationDetail?id='.$link;
                break;
            case 2 :  // 列表
                $exist = strstr($link,'?');
                if($exist){
                    $url = $link.'&title='.$name;
                }else{
                    $url = $link.'?title='.$name;
                }
                if(($this->applet_cfg['ac_type'] == 8 || $this->applet_cfg['ac_type'] == 6) && $link=="/pages/goodslist/goodslist"){
                    $url = $link.'?type=special&title='.$name;
                }
                //酒店版链接配置特殊 2018-12-25
                if($this->applet_cfg['ac_type'] == 7){
                    $url = $link;
                }
                if($link == '/pages/applyTuan/applyTuan'){
                    //社区团购团长申请不要title
                    $url = $link;
                }

                break;
            case 3 :   //自定义外链
                //$url = '/pages/commonView/commonView?linksrc='.$link;
                $this->sid==10418 ? $url=$link : $url = 'https://hz.51fenxiaobao.com/?url='.$link;
                break;
            case 4 :   // 商城分组列表
                if($this->applet_cfg['ac_type'] == 32 || $this->applet_cfg['ac_type'] == 36){
                    $url = '/subpages0/flGoodsList/flGoodsList?id='.$link.'&title='.$name;
                }else{
                    $url = '/pages/flGoodsList/flGoodsList?id='.$link.'&title='.$name;
                }

                break;
            case 5 :   // 商城商品详情
            case 201: //营销商城抖音知识付费详情
                if($this->applet_cfg['ac_type'] == 27 || $type == 201){
                    //知识付费
                    $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                    $goods = $goods_storage->getRowById($link);
                    if($goods['g_knowledge_pay_type'] == 1){
                        $url = '/pages/zlDetail/zlDetail?id='.$link;
                    }
                    if($goods['g_knowledge_pay_type'] == 2){
                        $url = '/pages/audioDetail/audioDetail?id='.$link;
                    }
                    if($goods['g_knowledge_pay_type'] == 3){
                        $url = '/pages/videoDetail/videoDetail?id='.$link;
                    }
                }elseif ($this->applet_cfg['ac_type'] == 4){
                    $goods_storage = new App_Model_Goods_MysqlGoodsStorage($this->sid);
                    $goods = $goods_storage->getRowById($link);
                    if($goods['g_independent_mall'] == 1){
                        $url = '/subpages0/goodDetail/goodDetail?id='.$link;
                    }else{
                        $url = '/pages/goodDetail/goodDetail?id='.$link;
                    }
                }else{
                    $url = '/pages/goodDetail/goodDetail?id='.$link;
                }
                break;
            // 独立商城详情页面
            case 502:
                $url = '/pages/goodDetail/goodDetail?id='.$link;
                break;
            case 6 :    // 微预约分类列表
                $url = '/pages/goods/goods?id='.$link.'&title='.$name;
                break;
            case 7 :   // 微婚纱样片详情
                $url = '/pages/articleDetail/articleDetail?id='.$link;
                break;
            case 8 :   // 微驾考练车场地详情
                $url = '/pages/lccdDetail/lccdDetail?id='.$link;
                break;
            case 9 :   // 商城商品分类列表
            case 501:
                if($this->applet_cfg['ac_type'] == 6 || $this->applet_cfg['ac_type'] == 8){
                    $url = '/subpages0/allgoodsPage/allgoodsPage?oneid=&secondid='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 18){
                    $url = '/pages/goods/goods?id='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 8){
                    $url = '/subpages0/allgoodsPage/allgoodsPage?id='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 27){
                    $url = '/pages/allgoodsPage/allgoodsPage?oneid=&secondid='.$link.'&title='.$name;
                }else{
                    $url = '/pages/allgoodsPage/allgoodsPage?oneid=&secondid='.$link.'&title='.$name;
                }
                break;
            case 10 :   // 门店版商品分类列表
                $url = '/pages/goodsList/goodsList?id='.$link.'&title='.$name;
                break;
            case 11 :   // 秒杀版秒杀商品分组
                $url = '/pages/seckillGoodList/seckillGoodList?category='.$link.'&title='.$name;
                break;
            case 12 :   // 拼团版拼团商品分组
                if($this->applet_cfg['ac_type'] == 6||$this->applet_cfg['ac_type'] == 21){
                    $url = '/subpages0/groupGoodsList/groupGoodsList?menuid='.$link.'&title='.$name;
                }else if($this->applet_cfg['ac_type'] == 18 ){
                    $url = '/subpages/groupGoodsList/groupGoodsList?menuid='.$link.'&title='.$name;
                }else{
                    $url = '/pages/groupGoodsList/groupGoodsList?menuid='.$link.'&title='.$name;
                }
                break;
            case 13 :   // 房产版房源详情
                $url = '/pages/houseDetail/houseDetail?id='.$link.'&title='.$name;
                break;
            case 14 :   // 房产版楼盘详情
                $url = '/pages/skillHousesDetail/skillHousesDetail?id='.$link.'&title='.$name;
                break;
            case 16 :   // 社区版店铺分类列表
                if($this->applet_cfg['ac_type'] == 4){
                    //餐饮
                    $url = '/subpages/flMulShopList/flMulShopList?cate1='.$link.'&title='.$name;
                }else{
                    $url = '/pages/flShoplist/flShoplist?cate1='.$link.'&title='.$name;
                }
                break;
            case 17 :   // 社区版入驻店铺详情
                $url = '/pages/shopDetail/shopDetail?id='.$link;
                break;
            case 18 :   // 企业版店铺产品服务列表
                $url = '/pages/servicePage/servicePage?id='.$link.'&title='.$name;
                break;
            case 19 :   // 企业版店铺产品服务详情
                $url = '/pages/articleDetail/articleDetail?id='.$link;
                break;
            case 20 :   // 同城版入驻店铺详情
                if($this->applet_cfg['ac_type'] == 33){
                    $url = '/pages/serviceproDetail/serviceproDetail?id='.$link;
                }else{
                    $url = '/pages/shopDetailnew/shopDetailnew?id='.$link;
                }

                break;
            case 21 :   // 多门店资讯分类
                $url = '/pages/informationPage/informationPage?id='.$link.'&title='.$name;
                break;
            case 22 :   // 全功能商城商品列表(分类)
                if($this->applet_cfg['ac_type'] == 24){
                    $url = '/pages/wnGoodsList/wnGoodsList?id='.$link;
                }else{
                    $url = '/pages/wnGoodsList/wnGoodsList?goodType='.$link;
                }
                break;
            case 23 :   // 一级分类商品列表
            case 500:
                if($this->applet_cfg['ac_type'] == 6){
                    $url = '/subpages0/wnGoodsList/wnGoodsList?id='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 32 || $this->applet_cfg['ac_type'] == 36){
                    $url = '/subpages/flGoods/flGoods?categoryId='.$link.'&title='.$name;
                }elseif ($this->applet_cfg['ac_type'] == 8){
                    $url = '/subpages0/wnGoodsList/wnGoodsList?id='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 27){
                    $url = '/pages/wnGoodsList/wnGoodsList?id='.$link.'&title='.$name;
                }else{
                    $url = '/pages/wnGoodsList/wnGoodsList?id='.$link.'&title='.$name;
                }
                break;
            case 24 :   // 培训课程列表 带分类id
                $url = '/pages/course/course?id='.$link;
                break;
            case 25 :   // 问答小程序 分类问题列表
                $url = '/pages/problemList/problemList?id='.$link;
                break;
            case 26 :   // 知识付费 分类列表
                $url = '/pages/productList/productList?type='.$link.'&name='.$name;
                if($extra > 0){
                    $url .= '&id='.$extra;
                }
                break;
            case 27 : //同城多店  商家商品详情
                if ($this->applet_cfg['ac_type'] == 33){
                    $url = '/pages/productDetail/productDetail?id='.$link;
                }elseif ($this->applet_cfg['ac_type'] == 8){
                    $url = '/pages/shopgoodsDetail/shopgoodsDetail?id='.$link;
                }else{
                    $url = '/subpages/shopgoodsDetail/shopgoodsDetail?id='.$link;
                }
                break;
            case 28 : //同城多店 商品分类
                $esgc_model = new App_Model_Entershop_MysqlGoodsCategoryStorage(0);
                $esgc = $esgc_model->getRowById($link);
                $esId = intval($esgc['esgc_s_id']);
                $title = $esgc['esgc_name'];
                $url = '/subpages/goodslist/goodslist?sid='.$esId.'&flid='.$link.'&title='.$title;
                break;
            case 29 : //秒杀商品详情
                $url = '/pages/goodDetail/goodDetail?id='.$link;
                break;
            case 30 : //拼团商品详情
                $url = '/pages/groupGoodDetail/groupGoodDetail?goodid='.$link;
                break;
            case 31 : //砍价商品详情
                $url = '/subpages/bargainGoodDetail/bargainGoodDetail?id='.$link;
                break;
            case 32 : //资讯分类
                if($this->applet_cfg['ac_type'] == 7){
                    $url = '/pages/informationSpecial/informationSpecial?id='.$link.'&title='.$name;
                }else{
                    $url = '/pages/informationPage/informationPage?id='.$link.'&title='.$name;
                }

                break;
            case 33 ://同城多店 入主店铺商品分组
                $url = '/subpages/wnGoodsList/wnGoodsList?goodType='.$link;
                break;
            case 34 ://同城 商家分类列表
                $category_model = new App_Model_City_MysqlCityPostCategoryStorage(0);
                $category = $category_model->getRowById($link);
                $name = $category['acc_title'];
                $url = '/pages/searchShop/searchShop?id='.$link.'&title='.$name;
                break;
            case 35 ://招聘小程序 职位列表
                $url = '/pages/jobList/jobList?secondid='.$link.'&title='.$name;
                break;
            case 36 ://招聘小程序 职位详情
                $url = '/pages/jobDetail/jobDetail?id='.$link;
                break;
            case 37 ://预约 专家详情
                $url = '/pages/teamsDetail/teamsDetail?id='.$link;
                break;
            case 38 ://预约 专家分类列表
//                $category_model = new App_Model_Shop_MysqlKindStorage(0);
//                $category = $category_model->getRowById($link);
                $name = $name ? $name : '团队';
                $url = '/pages/teams/teams?id='.$link.'&title='.$name;
                break;
            case 39 ://游戏盒子 游戏列表
                $url = '/pages/gameList/gameList?id='.$link.'&title='.$name;
                break;
            case 40 ://同城帖子分类列表
                $category_model = new App_Model_City_MysqlCityPostCategoryStorage(0);
                $category = $category_model->getRowById($link);
                $url = '/pages/postList/postList?id='.$link.'&title='.$category['acc_title'].'&price='.$category['acc_price'];
                break;
            case 41 ://多店 平台商品分组
                if($this->applet_cfg['ac_type'] == 8){
                    $url = '/pages/wnGoodsList/wnGoodsList?from=platform&goodType='.$link.'&title='.$name;
                }elseif($this->applet_cfg['ac_type'] == 6){
                    $url = '/subpages/wnGoodsList/wnGoodsList?from=platform&goodType='.$link.'&title='.$name;
                }
                break;
            case 42 ://多店 入主店铺商品分组
                if($this->applet_cfg['ac_type'] == 6){
                    $url = '/subpages/wnGoodsList/wnGoodsList?from=shop&goodType='.$link.'&title='.$name;
                }else{
                    $url = '/pages/wnGoodsList/wnGoodsList?from=shop&goodType='.$link.'&title='.$name;
                }
                break;
            case 43 ://餐饮 店铺详情
                $url = '/pages/mulShopDetail/mulShopDetail?esId='.$link;
                break;
            case 44://二手车 车源详情详情
                $url = '/pages/carDetail/carDetail?id='.$link;
                break;
            case 45://二手车 服务商分类列表
                $url = '/subpages/serviceProvider/serviceProvider?id='.$link.'&title='.$name;
                break;
            case 46://付费预约商品详情
                $url = '/subpages/Generalreservationdetail/Generalreservationdetail?id='.$link;
                break;
            case 47://付费预约商品详情
                $url = '/subpages0/auctionpage/auctionDetail/auctionDetail?id='.$link;
                break;
            case 48://内推招聘公司详情
                $url = '/subpages/companyDetail/companyDetail?id='.$link;
                break;
            case 49://知识付费签到
                $url = '/subpages/signin/signin';
                break;
            case 50://招聘公司列表
                $url = '/subpages0/companyHall/companyHall?oneid='.$link.'&title='.$name;
                break;
            case 51://婚纱系列分类列表
                $url = '/pages/fenggeList/fenggeList?id='.$link.'&title='.$name;
                break;
            case 52://婚纱模特样片分类列表
                $url = '/pages/jianzheng/jianzheng?cate='.$link.'&type=1';
                break;
            case 53://婚纱见证客片分类列表
                $url = '/pages/jianzheng/jianzheng?cate='.$link.'&type=2';
                break;
            case 54://婚纱见证客片分类列表
                $url = '/pages/shopDetail/shopDetail?id='.$link;
                break;
            case 55://自定义表单
                if($extra > 0 && !$link){
                    $link = $extra;
                }
                $url = '/pages/generalForm/generalForm?id='.$link;
                break;
            case 56://自定义模板
                if($extra > 0 && !$link){
                    $link = $extra;
                }
                $url = '/pages/webviewPage/webviewPage?id='.$link;
                break;
            case 57 :   // 培训课程详情
                $url = '/pages/newCourseDetail/newCourseDetail?id='.$link;
                break;
            case 58 :   // 餐饮排号
                $url = '/subpages/arrangingPage/arrangingPage?esId='.$link;
                break;
            case 104 :   // 菜单
                if($link == '/subpages/walletRecharge/walletRecharge?from=slide'){
                    $url = $link.'&title='.$name;
                }else{
                    $url = '/'.$link.'?title='.$name;
                }
                break;
            case 106 :   // 小程序appid
                $url = $link;
                break;
        }
        if($system && $system == 'ios'){
            if($link == "/subpages/memberCard/memberCard"){
                $url = array(
                    'msg' => '十分抱歉，由于相关规范，暂时无法使用此功能'
                );
            }
        }

        if($this->appletType == 4){
            $url = str_replace('subpages0/','pages/',$url);
            $url = str_replace('subpages/','pages/',$url);
        }

        return $url;
    }

    /**
     * 判断是否有已经可以展示的活动
     */
    public function _check_lottery_now(){
        $where   = array();
        $where[] = array('name' => 'amll_status', 'oper' => '=', 'value' => 1);
        $where[] = array('name' => 'amll_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amll_deleted', 'oper' => '=', 'value' => 0);
        $list_model = new App_Model_Meeting_MysqlMeetingLotteryListStorage($this->sid);
        $row        = $list_model->getRow($where);
        return $row && $row['amll_index_status']==1?1:0;
    }






    /**
     * 数量信息格式化,大于10000
     */
    public function number_format($num){
        if($num>10000){
            $num = number_format($num/10000,1).'万';
        }
        return $num;
    }
    /**
     * 数量信息格式化,大于10000
     */
    public function number_format_new($num){
        if($num>10000){
            $num = number_format($num/10000,1);
            $num = floatval($num).'万';
        }
        return $num;
    }

    /**
     * 获取公司地址电话等信息
     */
    public function shop_company_info(){
        //获取关于我们配置
        $about_storage = new App_Model_Shop_MysqlShopAboutUsStorage($this->sid);
        $row = $about_storage->findUpdateBySid();
        $contact = array(
            'open'     => $row['sa_ison'] ? intval($row['sa_ison']) : 0,
            'name'     => isset($row['sa_name']) && $row['sa_name'] ? $row['sa_name'] : $this->applet_cfg['ac_name'],
            'brief'    => isset($row['sa_brief']) && $row['sa_brief'] ? (mb_strlen($row['sa_brief'])>75 ? mb_substr($row['sa_brief'],0,75) : $row['sa_brief']) : '',
            'mobile'   => isset($row['sa_mobile']) && $row['sa_mobile'] ? $row['sa_mobile'] : '',
            'address'  => isset($row['sa_address']) && $row['sa_address'] ? $row['sa_address'] : '',
            'logo'     => isset($row['sa_logo']) && $row['sa_logo'] ? $this->dealImagePath($row['sa_logo']) : '',
            'lng'      => isset($row['sa_lng']) && $row['sa_lng'] ? $row['sa_lng'] : '',
            'lat'      => isset($row['sa_lat']) && $row['sa_lat'] ? $row['sa_lat'] : '',
            'link'     => isset($row['sa_link']) && $row['sa_link'] ? $this->get_link_by_type(1,$row['sa_link'],$row['sa_name']) : ''
        );
        return $contact;
    }

    /*
     * 判断当前小程序类型是正确
     */
    public function _verify_current_applet_type($type){
        if(!in_array($this->applet_cfg['ac_type'],$type)){
            $this->outputError('您访问的小程序类型不正确，请检查后重试');
        }
    }


    /**
     * 判断VR地址
     */
    public function _judge_vrurl($url){
        if(plum_is_url($url)){
            $vrurl = 'https://hz.51fenxiaobao.com/?url='.$url;
        }else{
            $vrurl = 'https://hb.51fenxiaobao.com/tour.html?id='.$url;
        }
        return $vrurl;
    }

    // 获取当前订单的核销二维码码
    public function _fetch_order_verify($trade){
        $data = array();
        if($trade['t_pickup_code']){
            $data['code'] = $trade['t_pickup_code'];
            if($trade['t_pickup_qrcode']){
                $data['qrcode'] = $this->dealImagePath($trade['t_pickup_qrcode']);
            }else{
                //生成订单核销码
                $filename = $trade['t_pickup_code']. '.png';
                $text = $trade['t_pickup_code'];
                Libs_Qrcode_QRCode::png($text, PLUM_APP_BUILD.'/spread/' . $filename, 'Q', 10, 1);
                $updata['t_pickup_qrcode'] = PLUM_PATH_PUBLIC.'/build/spread/'.$filename;
                $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
                $trade_model->findUpdateTradeByTid($trade['t_tid'],$updata);
                $data['qrcode'] = $this->dealImagePath($updata['t_pickup_qrcode']);
            }
        }else{
            $updata['t_pickup_code'] = plum_random_code(8);
            //生成订单核销码
            $filename = $updata['t_pickup_code']. '.png';
            $text = $updata['t_pickup_code'];
            Libs_Qrcode_QRCode::png($text, PLUM_APP_BUILD.'/spread/' . $filename, 'Q', 10, 1);
            $updata['t_pickup_qrcode'] = PLUM_PATH_PUBLIC.'/build/spread/'.$filename;
            $trade_model    = new App_Model_Trade_MysqlTradeStorage($this->sid);
            $trade_model->findUpdateTradeByTid($trade['t_tid'],$updata);
            $data = array(
                'code'   => $updata['t_pickup_code'],
                'qrcode' => $this->dealImagePath($updata['t_pickup_qrcode'])
            );
        }
        return $data;
    }

    /*
     * 检查是否开通了对应营销工具
     */
    public function checkToolUsable($plugin_id){
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->sid);
        $row = $plugin_model->findUpdateBySid($plugin_id);
        // 插件客服通知、自动回复、收藏有礼、答题、实名验证、名片夹、发帖实名验证等不再收费，不再做验证，zy 2019.5.25
        if(in_array($plugin_id,array('kf','dt','yhyz','scyl','autoreply','mpj','mobilecheck'))){
            return TRUE;
        }else{
            if(!$row || $row['apo_expire_time']<time() || ($plugin_id == 'gdb' && $this->applet_cfg['ac_principal'] == '个人')){
                return FALSE;
            }else{
                return TRUE;
            }
        }

    }

    /*
     * 获得弹出层
     */
    public function _get_popup(){
        //获得首页开启的弹出层
        $popup_model = new App_Model_Applet_MysqlAppletPopupStorage($this->sid);
        $where = array();
        $data = array();
        $where[] = array('name'=>'ap_s_id','oper'=>'=','value'=> $this->sid);
        $where[] = array('name'=>'ap_show','oper'=>'=','value'=> 1);
        $row = $popup_model->getRow($where);
        if($row && $row['ap_path']){
            $timeType = $row['ap_time_type'] ? $row['ap_time_type'] : 1;
            $timeValue = $row['ap_time_value'] ? $row['ap_time_value'] : 1;


            $data = array(
                'id'   => intval($row['ap_id']),
                'cover' => $this->dealImagePath($row['ap_path']),
                'type' => intval($row['ap_link_type']),
                'url'  => $this->get_link_by_type($row['ap_link_type'],$row['ap_link'],''),
                'showType' => intval($row['ap_show_type']),
                'time' => $timeType == 1 ? $timeValue * 86400 : $timeValue * 3600
                //'time' => 60
            );
        }
        return $data;
    }

    /*
     * 获得购物车数量
     */
    protected function _get_cart_sum($independent,$esId = 0){
        $cart_storage = new App_Model_Shop_MysqlShopCartStorage($this->sid);
        $uid = plum_app_user_islogin();
        $mid = $this->member['m_id'] ? $this->member['m_id'] : ($uid ? $uid : 0);
        $total = 0;
        if($mid){
            if($this->applet_cfg['ac_type'] == 32 || $this->applet_cfg['ac_type'] == 36){
                $where = [];
                $where[]  = array('name' => 'sc_s_id', 'oper' => '=', 'value' => $this->sid);
                $where[]  = array('name' => 'g_deleted', 'oper' => '=', 'value' => 0);
                $where[]  = array('name' => 'sc_m_id', 'oper' => '=', 'value' => $mid);
                $where[]  = array('name' => 'sc_es_id', 'oper' => '=', 'value' => $esId);
                $where[]  = array('name' => 'sc_independent_mall', 'oper' => '=', 'value' => $independent);
                $sort = array('sc_add_time' => 'DESC');
                $field = 'sc_num,sc_g_id,sc_gf_id,g_id,g_stock,gf_stock,g_is_sale';
                $list = $cart_storage->getGoodsFormat($where, 0, 0, $sort,false,$field);
                foreach ($list as $val){
                    $limit_goods_model  = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);
                    $limit = $limit_goods_model->getActingByGid($val['g_id'],'');
                    //如果存在秒杀并且限购，检查之前购买记录
                    if ($limit && $limit['lg_limit']) {
                        $record_model   = new App_Model_Limit_MysqlLimitRecordStorage($this->sid);
                        $had_buy    = $record_model->countBuyNum($this->member['m_id'], $limit['lg_actid'], $val['g_id']);
                        $had_buy    = intval($had_buy)+$val['sc_num'];
                        if ($had_buy > intval($limit['lg_limit'])) {
                            $limit = '';
                        }
                    }
                    //如果是秒杀且存在规格
                    if($val['gf_id'] > 0 && $limit){
                        $limit_goods_format = new App_Model_Limit_MysqlLimitGoodsFormatStorage();
                        $limitFormat = $limit_goods_format->getRowByActIdGfid($limit['la_id'], $val['gf_id']);
                        if($limitFormat){
                            if($limitFormat['lgf_stock'] > 0){
                                $limit['lg_stock'] = $limitFormat['lgf_stock'];
                            }
                            $limit['lg_yh_price'] = $limitFormat['lgf_yh_price'];
                        }
                    }
                    //如果设置了秒杀数量，替换为设置值
                    $stock = isset($limit['lg_stock']) && $limit['lg_stock'] > 0 ? $limit['lg_stock'] : ($val['sc_gf_id'] ? $val['gf_stock'] : $val['g_stock']);
                    //对未下架未售罄的数量进行计算
                    if($val['g_is_sale'] != 2 && $stock > 0){
                        $total += $stock >= $val['sc_num'] ? $val['sc_num'] : $stock;
                    }else{
                        $total += $val['sc_num'];
                    }
//                    Libs_Log_Logger::outputLog('商品id：'.$val['g_id'],'test.log');
//                    Libs_Log_Logger::outputLog('总数：'.$total,'test.log');
                }

            }else{
                $total = $cart_storage->getCartSum($mid,$independent,$esId);
            }
        }
        return $total;
    }

    /*
     * 获得url及对应参数 支持中文
     * url 待处理链接
     */
    protected function mb_parse_url($url, $component = -1) {
        $encodedUrl = preg_replace_callback(
            '%[^:/?#&=\.]+%usD',
            function ($matches) {
                return urlencode($matches[0]);
            }, $url );
        $components = parse_url($encodedUrl, $component);
        if (is_array($components)) {
            foreach ($components as &$part) {
                if (is_string($part)) {
                    $part = urldecode($part);
                }
            }
        } else if (is_string($components)) {
            $components = urldecode($components);
        }
        return $components;
    }

    /*
     * 根据小程序页面链接 获得公众号Vue路由相关
     */
    protected function getPageRoute($link){
        $parse_url = $this->mb_parse_url($link);
        $route_info = [
            'route' => '',
            'query' => [],
        ];
        if($parse_url){
            $path = $parse_url['path'];
            $query = $parse_url['query'];
            $route_name = substr($path,(strripos($path,'/') + 1));
            $route_name = '/'.ucfirst($route_name);

//            $query_parts = explode('&', $query);
//            $params = [];
//            foreach ($query_parts as $param) {
//                $item = explode('=', $param);
//                $params[$item[0]] = $item[1];
//            }
//            $route_info['query'] = $params;
            if($query){
                $route_name = $route_name.'?'.$query;
            }
            $route_info['route'] = $route_name;
        }
        return $route_info;
    }

    public function __destruct(){

        $logid  = $GLOBALS['logid'];
        $suid  = $GLOBALS['shop_suid'];

        list($usec, $sec) = explode(" ", microtime());
        $use_time   = round(((float)$usec + (float)$sec) - (float)plum_get_server('REQUEST_TIME_FLOAT'), 4);

        $updata = array(
            'wd_for_id'     => $this->sid,//店铺ID
            'wd_end_time'   => round(((float)$usec + (float)$sec), 4),
            'wd_use_time'   => $use_time,
        );
        $watch_model    = new App_Model_Watchdog_MysqlWatchDogStorage();
        $watch_model->updateById($updata, $logid);


        $limit_time = 3;//接口执行时长
        $limit_count= 30;
        $applet_redis = new App_Model_Applet_RedisAppletStorage($this->sid);
        $count  = $applet_redis->getShopRequestFrequency($suid, $limit_count);

        if ($use_time > $limit_time) {
            if ($count > $limit_count) {
                //超过次数
                $log_arr = [
                    'suid' => $suid,
                    'sid'  => $this->sid,
                    'shop' => $this->shop['s_name'],
                    'usetime'   => $use_time,
                    'map'   => $this->request->getStrParam('map'),
                    'count' => $count,
                ];
                //超过次数和时间阈值 记录日志 创建限制key
                $applet_redis->setShopRequestRefuse($suid, 30);//封禁5秒
                Libs_Log_Logger::outputLog($log_arr,'request-frequency-refuse-20.log');
            }
        }

    }

    ////////////////////////////公众号授权相关///////////////////////////////
    /*
     * 微信公众平台授权方式
     */
    private function _weixin_oauth() {

        //获取微信配置
//        $weixin_storage = new App_Model_Auth_MysqlWeixinStorage();
        $weixin_storage = new App_Model_Weixin_MysqlWeixinCfgStorage();
        $ret            = $weixin_storage->fetchUpdateCfgBySid($this->shop['s_id']);
        if (!$ret || !$ret['ac_appid'] || !$ret['ac_appsecret']) {
            $this->outputError("开放平台信息未设置，请管理员核实");
        }
        $wx_redirect_client = new App_Plugin_Weixin_RedirectApiClient($ret['ac_appid'], $ret['ac_appsecret']);
        //获取自定义值，以判断是否跳转
        $custom         = $this->request->getStrParam('state');
//        $custom = $custom ? $custom : $this->suid;
        if ($custom && $custom == $this->shop['s_unique_id']) {
            //第二步，认证完成后的跳转
            $code   = $this->request->getStrParam('code');
            $userinfo       = $wx_redirect_client->fetchWeixinUserinfo($code);
            if (!$userinfo) {
                $this->outputError("网页授权失败，请重试");
            }
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();

            $member = $member_storage->findUpdateMemberByWeixinOpenid($userinfo['openid'], $this->shop['s_id']);
            $uidata = array(
                'm_user_id'     => 0,//有赞用户id，设置为空
                'm_is_follow'   => 0,//默认为未关注
                'm_nickname'    => $userinfo['nickname'],
                'm_sex'         => $userinfo['sex'] == 1 ? 'M' : 'Y',
                'm_province'    => $userinfo['province'],
                'm_city'        => $userinfo['city'],
                'm_avatar'      => $userinfo['headimgurl'],
//                'm_union_id'    => $userinfo['unionid'] ? $userinfo['unionid'] : ''
            );
            if ($member) {
                $uidata['m_is_follow']  = $member['m_is_follow'];//设置关注情况
                //会员存在，则更新数据
                $member_storage->findUpdateMemberByWeixinOpenid($userinfo['openid'], $this->shop['s_id'], $uidata);
                $uid    = $member['m_id'];
            } else {
                //会员不存在，则插入新数据
                $indata = array(
                    'm_s_id'        => $this->shop['s_id'],
                    'm_c_id'        => $this->shop['s_c_id'],//所属公司id
                    'm_openid'      => $userinfo['openid'],
                    'm_follow_time' => date('Y-m-d H:i:s', time()),
                    'm_is_slient'   => 1,//置为观望会员
                    'm_union_id'    => $userinfo['unionid'] ? $userinfo['unionid'] : '',
                    'm_update_time' => time()
                );

                $data = array_merge($uidata, $indata);

                $uid  = $member_storage->insertShopNewMember($this->shop['s_id'], $data);
            }
            //再次取出会员数据
            $this->member   = $member_storage->getRowById($uid);

            plum_app_user_login($uid);

//            $lifetime   = plum_check_array_key('lifetime', plum_parse_config('mobile', 'session'), 30*24*60) * 60;
//            plum_remember_login_user($lifetime, '/mobile');
        } else {
            //第一步，开始授权，获取授权码
            //获取待跳转URL
//            $redirect_uri   = $this->request->getRequestUrl();
//            $redirect_uri   = $this->_filter_query_url($redirect_uri);

            $redirect_uri   = plum_parse_config('weixin_index','weixin')[$this->applet_cfg['ac_type']].'?appletType=5';
            $url = $wx_redirect_client->redirectUrl($redirect_uri, $this->scope_type, $this->shop['s_unique_id'],null,5);
            return $url;
        }
    }

    private function _filter_query_url($url) {
        $query  = parse_url($url, PHP_URL_QUERY);
        list($prefix)  = explode('?', $url);
        parse_str($query, $arr);
        unset($arr['code']);
        unset($arr['state']);
        unset($arr['appid']);
        unset($arr['from']);
        unset($arr['isappinstalled']);

        Libs_Log_Logger::outputLog($query);
        Libs_Log_Logger::outputLog($arr);
        Libs_Log_Logger::outputLog($prefix);

        if (count($arr) > 0) {
            return $prefix.'?'.http_build_query($arr);
        }
        return $prefix;
    }

    /*
     * 微信三方平台代授权方式
     */
    private function _weixin_oauth_platform() {
        //获取微信配置
//        $weixin_storage = new App_Model_Auth_MysqlWeixinStorage();
        $weixin_storage = new App_Model_Weixin_MysqlWeixinCfgStorage();
        $ret            = $weixin_storage->fetchUpdateCfgBySid($this->shop['s_id']);
        if (!$ret || !$ret['ac_appid']) {
            $this->outputError("商家未授权公众号");
        }
        //未授权走微信自有授权方式
        if (!$ret['ac_auth_status'] || !$ret['ac_auth_access_token']) {
            return $this->_weixin_oauth();
        }
        //平台配置信息
        $plat_cfg   = plum_parse_config('platform', 'weixin');
        $wx_redirect_client = new App_Plugin_Weixin_RedirectApiClient($ret['ac_appid']);
        //获取自定义值，以判断是否跳转
        $custom         = $this->request->getStrParam('state');
//        $custom = $custom ? $custom : $this->suid;
        if ($custom && $custom == $this->shop['s_unique_id']) {
            //第二步，认证完成后的跳转
            $code   = $this->request->getStrParam('code');
            $userinfo       = $wx_redirect_client->fetchWeixinOpenIDPlatform($code, $plat_cfg['app_id']);
            if (!$userinfo) {
                $this->outputError("网页授权失败，请重试");
            }
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();

            $member = $member_storage->findUpdateMemberByWeixinOpenid($userinfo['openid'], $this->shop['s_id']);
            $uidata = array(
                'm_user_id'     => 0,//有赞用户id，设置为空
                'm_is_follow'   => 0,//默认为未关注
                'm_nickname'    => $userinfo['nickname'],
                'm_sex'         => $userinfo['sex'] == 1 ? 'M' : 'Y',
                'm_province'    => $userinfo['province'],
                'm_city'        => $userinfo['city'],
                'm_avatar'      => $userinfo['headimgurl'],
//                'm_union_id'    => $userinfo['unionid'] ? $userinfo['unionid'] : ''
            );
            if ($member) {
                $uidata['m_is_follow']  = $member['m_is_follow'];//设置关注情况
                //会员存在，则更新数据
                $member_storage->findUpdateMemberByWeixinOpenid($userinfo['openid'], $this->shop['s_id'], $uidata);
                $uid    = $member['m_id'];
            } else {
                // 获取会员编号的最大值
                $member_redis   = new App_Model_Member_RedisMemberStorage($this->sid);
                $max = $member_redis->fetchShopMaxShowId();
                //会员不存在，则插入新数据
                $indata = array(
                    'm_s_id'        => $this->shop['s_id'],
                    'm_c_id'        => $this->shop['s_c_id'],//所属公司id
                    'm_openid'      => $userinfo['openid'],
                    'm_follow_time' => date('Y-m-d H:i:s', time()),
                    'm_is_slient'   => 1,//置为观望会员
                    'm_show_id'     => $max,
                    'm_union_id'    => $userinfo['unionid'] ? $userinfo['unionid'] : '',
                    'm_source'      => 1, //来源公众号
                    'm_update_time' => time()
                );
                $data = array_merge($uidata, $indata);
                $uid  = $member_storage->insertValue($data,true,false,true);
                // $uid  = $member_storage->insertShopNewMember($this->shop['s_id'], $data);
            }
            //再次取出会员数据

            $this->member   = $member_storage->getRowById($uid);
            $this->uid = $uid;
//            $this->member['sessionExpire'] =
//            if($uid && $need_jump){
//                $jump = plum_parse_config('weixin_index','weixin')[$this->applet_cfg['ac_type']].'?suid='.$this->suid;
//                header('Location: ' . $jump);
//            }
            plum_app_user_login($uid);

//            $lifetime   = plum_check_array_key('lifetime', plum_parse_config('mobile', 'session'), 30*24*60) * 60;
//            plum_remember_login_user($lifetime, '/mobile');
        } else {
            //第一步，开始授权，获取授权码
            $redirect_uri   = plum_parse_config('weixin_index','weixin')[$this->applet_cfg['ac_type']].'?appletType=5';
            $url = $wx_redirect_client->redirectUrl($redirect_uri, $this->scope_type, $this->shop['s_unique_id'], $plat_cfg['app_id'],5);
            return $url;
        }
    }

    private function _fxb_auth() {
        //获取微信配置
//        $need_jump = false;
        $fxb_cfg    = plum_parse_config('fxb_pay', 'weixin');
        $wx_redirect_client = new App_Plugin_Weixin_RedirectApiClient($fxb_cfg['app_id'], $fxb_cfg['app_secret']);
        //获取自定义值，以判断是否跳转
        $custom         = $this->request->getStrParam('state');
//        $custom = $custom ? $custom : $this->suid;
        if ($custom && $custom == $this->shop['s_unique_id']) {
            //第二步，认证完成后的跳转
            $code   = $this->request->getStrParam('code');
            $userinfo       = $wx_redirect_client->fetchWeixinUserinfo($code);
            if (!$userinfo) {
                $this->outputError("网页授权失败，请重试");
            }
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $user_model     = new App_Model_Member_MysqlUserStorage();
            $user       = $user_model->findUpdateByOpenid($userinfo['openid']);
            $mid        = 0;
            if (!$user) {
                //创建用户
                $urdata = array(
                    'u_open_id'     => $userinfo['openid'],
                    'u_create_time' => time(),
                );
                $uid    = $user_model->insertValue($urdata);
            } else {
                $uid        = $user['u_id'];
                $member     = $member_storage->findUpdateMemberByUidSid($uid, $this->shop['s_id']);
                $mid        = $member ? $member['m_id'] : 0;
            }

            if (!$mid) {
                // 获取会员编号的最大值
                $member_redis   = new App_Model_Member_RedisMemberStorage($this->sid);
                $max = $member_redis->fetchShopMaxShowId();
                //创建会员
                $mrdata = array(
                    'm_openid'  => plum_uniqid_base36(true),
                    'm_uid'     => $uid,
                    'm_s_id'    => $this->shop['s_id'],
                    'm_c_id'    => $this->shop['s_c_id'],//所属公司id
                    'm_follow_time' => date('Y-m-d H:i:s', time()),
                    'm_is_slient'   => 1,//置为观望会员,非真实会员
                    'm_show_id'     => $max,
                    'm_source'      => 1,//来源公众号
                    'm_union_id'    => $userinfo['unionid'] ? $userinfo['unionid'] : '',
                    'm_update_time' => time()

                );
                $mid  = $member_storage->insertValue($mrdata,true,false,true);
               // $need_jump = true;
               //  $mid    = $member_storage->insertShopNewMember($this->shop['s_id'], $mrdata);
               //  会员关系绑定
               // $um_model   = new App_Model_Member_MysqlUserMemberStorage();
               // $umdata = array(
               //     'um_uid'        => $uid,
               //     'um_mid'        => $mid,
               //     'um_sid'        => $this->shop['s_id'],
               //     'um_create_time'=> time(),
               // );
               // $um_model->insertValue($umdata);
            }
            //再次取出会员数据
            $this->member   = $member_storage->getRowById($mid);
            $this->uid = $mid;
           // if($mid && $need_jump){
           //     $jump = plum_parse_config('weixin_index','weixin')[$this->applet_cfg['ac_type']].'?suid='.$this->suid;
           //     header('Location: ' . $jump);
           // }

            plum_app_user_login($mid);

           // $lifetime   = plum_check_array_key('lifetime', plum_parse_config('mobile', 'session'), 30*24*60) * 60;
           // plum_remember_login_user($lifetime, '/mobile');
        } else {
            //第一步，开始授权，获取授权码
            //获取待跳转URL
            $redirect_uri   = plum_parse_config('weixin_index','weixin')[$this->applet_cfg['ac_type']].'?appletType=5';

            //天店通授权,@TODO 暂时使用基本授权
            $url = $wx_redirect_client->redirectUrl($redirect_uri, 'snsapi_userinfo', $this->shop['s_unique_id'],null,5);
            return $url;
        }
}

    /*
     * 微信公众号校验会员信息
     */
    protected function _weixin_verify_member($scope_type = '') {
        $uid    = plum_app_user_islogin();
       // Libs_Log_Logger::outputLog('获得用户信息uid','test.log');
       // Libs_Log_Logger::outputLog($uid,'test.log');
        if (!$uid) {
            //授权类型检查
            $scope  = plum_parse_config('scope_type', 'weixin');
            $allow_scope    = array_keys($scope);
            $snsapi = $this->request->getStrParam('snsapi');
            $snsapi = $snsapi && in_array($snsapi, $allow_scope) ? $snsapi : 'info';
            if($scope_type){
                $snsapi = $scope_type;
            }
            $this->scope_type   = $scope[$snsapi];
           // echo $this->scope_type;die();
            //需要授权的情况
            if ($this->scope_type) {
               // $inwx   = $this->request->isWeixin();
               // if ($inwx) {
                    $from   = $this->request->getStrParam('from', null);
                    $isapp  = $this->request->getIntParam('isappinstalled', null);
                    if (!is_null($from) && !is_null($isapp)) {
                        unset($_REQUEST['code']);
                        unset($_REQUEST['state']);
                    }
                    $url = $this->_weixin_oauth_platform();
                    //已认证的服务号
//                    if ($wxtype == App_Helper_ShopWeixin::WX_VERIFY_YRZFWH) {
//                        //优先走公众号代授权,最后走微信自有授权
//
//                    } else {
//                        $url = $this->_fxb_auth();
//                    }
                   if($url){
                       $info['data'] = [
                           'url' => $url,
                           'applet_appid' => $this->applet_cfg['ac_appid'],
                       ];
                       $this->outputSuccess($info);
                       exit;
                   }
//                } else {//非微信端打开
//                    $this->outputError('请在微信公众号中访问');
//                }
            }
        } else {
            //通过session获取用户信息
            $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
            $member   = $member_storage->getRowById($uid);
            //非同一个店铺
            if ($member['m_s_id'] != $this->shop['s_id']) {
                plum_app_user_logout();
                $this->_weixin_verify_member();
            } else {
                $this->member = $member;
                $this->uid = $uid;
            }
        }
    }

    /**
     * @return int
     * 判断知识付费相关内容是否显示
     */
    public function _check_knowledgepay_show(){
        if(in_array($this->applet_cfg['ac_type'],[21]) && $this->applet_cfg['ac_show_knowledge'] == 1){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * @param $mid
     * @param $esId
     * 抖音入驻店铺浏览记录
     */
    public function shopVisitRecord($mid,$esId){
        $visit_model = new App_Model_Entershop_MysqlEnterShopMemberVisitStorage($this->sid);
        $row = $visit_model->getRowByMidEsId($mid,$esId);
        if(!$row){
            $insert = [
                'esmv_s_id' => $this->sid,
                'esmv_es_id' => $esId,
                'esmv_m_id' => $mid,
                'esmv_create_time' => time()
            ];
            $visit_model->insertValue($insert);
        }
    }

    /**
     * 抖音文本检测通用方法
     */
    public function dyCheckText($content){
        if($this->appletType == 4){
            if($content){
                $client = new App_Plugin_Toutiao_XcxClient($this->sid);
                $res = $client->antidirt($content);
                if(isset($res['data'][0]['predicts'][0]['prob']) && $res['data'][0]['predicts'][0]['prob'] == 1){
                    $info['data'] = [
                        'prob' => 1,
                        'msg' => '您输入的内容包含违规信息，请重新输入'
                    ];
                    $this->outputSuccess($info);
                    exit;
                }
            }

        }
    }




}