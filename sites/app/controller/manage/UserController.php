<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/1/31
 * Time: 上午10:55
 */

class App_Controller_Manage_UserController extends Libs_Mvc_Controller_FrontBaseController {

    const MAX_BUILD_SHOP    = 1;//单商户创建店铺最大数量

    const MANAGER_LOGIN_NORMAL  = 0;//正常登陆
    const MANAGER_LOGIN_REVIEW  = 1;//审核
    const MANAGER_LOGIN_PREVENT = 2;//阻止

    private $ucenter_error  = array(
        '-1'    => '用户名不合法',
        '-2'    => '包含不允许注册的词语',
        '-3'    => '用户名已经存在',
        '-4'    => 'Email 格式有误',
        '-5'    => 'Email 不允许注册',
        '-6'    => '该 Email 已经被注册',
    );

    private $remember_lifetime  = 864000;//十天时间

    public function __construct() {
        parent::__construct();
        //引入UCenter
        require_once PLUM_DIR_CONFIG.'/uc.cfg.php';
        require_once PLUM_DIR_ROOT.'/uc_client/client.php';
    }

    private function _check_user_login() {
        $uid    = plum_app_user_islogin();
        if ($uid) {
            // 获取公司类型，调转不同的后台
            $type = $this->_company_type($uid);
            $access_ctrl= plum_parse_config('access_control', 'system');//获取主域名
            if($type && $type==1){
                $url    = $access_ctrl['enter'];
            }else{
                $url    = $access_ctrl['host'].'/manage/user/home';
            }
            plum_redirect_with_msg('已登录，前往控制台', $url, 3);
        }
    }

    /**
     * 获取账号所在公司类型
     */
    private function _company_type($uid){
        if($uid){
            $manager_storage    = new App_Model_Member_MysqlManagerStorage();
            $manager = $manager_storage->getRowById($uid);
            if($manager){
                //获取公司主体类型,跳转到不同管理后台
                $company_model  = new App_Model_Member_MysqlCompanyCoreStorage();
                $company        = $company_model->getRowById($manager['m_c_id']);
                return $company['c_type'];
            }
        }
        return false;
    }

    /*
     * 登录、注册首页
     */
    public function indexAction() {
        $net = $this->request->getStrParam('form');
        //登录判断
        $this->_check_user_login();
        if($net){
            $this->output['isnet'] = true;
        }
        $this->_output_wxlogin();
        //$this->displaySmarty('manage/login.tpl', null, null, false);
        $this->displaySmarty('manage/newlogin.tpl', null, null, false);
    }

    /*
     * 登录、注册首页
     */
    public function newIndexAction() {
        $net = $this->request->getStrParam('form');
        //登录判断
        $this->_check_user_login();
        if($net){
            $this->output['isnet'] = true;
        }
        $this->_output_wxlogin();
        $this->displaySmarty('manage/newlogin.tpl', null, null, false);
    }


    /*
     * 登录成功后管理主页
     */
    public function homeAction() {
        // 判断是否登录
        $uid    = plum_app_user_islogin();
        // 如果已登录
        if($uid){
            // 获取管理员信息
            $manager_storage    = new App_Model_Member_MysqlManagerStorage();
            $manager = $manager_storage->getRowById($uid);
            // 获取当前管理的店铺
            $redis_shop = new App_Model_Shop_RedisShopQueueStorage();
            $curr_sid = $redis_shop->getSidByUid($uid);
            $shop_storage       = new App_Model_Shop_MysqlShopCoreStorage();
            if(!$curr_sid){
                // 获取店铺信息
                $shop = $shop_storage->findShopByCid($manager['m_c_id']);
                $curr_sid = $shop['s_id'];
            }else{
                 //获取店铺信息
                $shop = $shop_storage->getRowById($curr_sid);
            }
            $this->output['shop'] = $shop;
            // 获取小程序授权信息
            // 获取微信小程序是否授权
            $wxauth = App_Plugin_Weixin_WxxcxClient::weixinAuthType($curr_sid);
            $this->output['wxauth'] = $wxauth;
            // 获取微信小程序授权信息
            $weixin_storage = new App_Model_Applet_MysqlCfgStorage($curr_sid);
            $appletCfg  = $weixin_storage->findShopCfg();
            if($appletCfg && $appletCfg['ac_category']){
                $appletCfg['ac_category'] = json_decode($appletCfg['ac_category'],true);
            }
            $this->output['appletCfg'] = $appletCfg;
            // 微信小程序授权信息
            $this->_auth_code_uri($appletCfg,$manager);
            // 获取微信公众号是否授权
            $wechat_model   = new App_Model_Auth_MysqlWeixinStorage();
            $wechatAuth     = $wechat_model->findWeixinBySid($curr_sid);
            //获取百度小程序开通信息
            $baidu_storage = new App_Model_Baidu_MysqlBaiduCfgStorage($curr_sid);
            $baiduAppletCfg  = $baidu_storage->findShopCfg();
            //百度小程序授权信息
            $this->_baidu_auth_code_uri($baiduAppletCfg,$manager);
            $this->output['baiduAppletCfg'] = $baiduAppletCfg;
            $this->output['from'] = $this->request->getStrParam('from');

            //支付宝小程序授权时获取授权信息
            //获取支付宝小程序开通信息
            $alixcx_storage = new App_Model_Alixcx_MysqlAlixcxCfgStorage($curr_sid);
            $alixcxAppletCfg  = $alixcx_storage->findShopCfg();
            $this->output['alixcxAppletCfg'] = $alixcxAppletCfg;
            $this->_alixcx_auth_code_uri($alixcxAppletCfg,$manager);

            // 字节跳到小程序授权时授权信息
            //获取字节跳动小程序开通信息
            $toutiao_storage = new App_Model_Toutiao_MysqlToutiaoCfgStorage($shop['s_id']);
            $toutiaoAppletCfg        = $toutiao_storage->findShopCfg();
            $this->output['toutiaoAppletCfg'] = $toutiaoAppletCfg;
            $this->_baidu_auth_code_uri($baiduAppletCfg,$manager);



            $this->output['appletCategory'] = plum_parse_config('category','applet');
            $this->displaySmarty('manage/guide/home.tpl');
        }else{
            plum_redirect_with_msg('请登录','/manage/user/index',3);
        }
    }


    /*
    *微信小程序授权时获取授权信息
    */
    private function _auth_code_uri($appletCfg,$manager){
        $plat_type  = $this->fetchPlatformType($appletCfg['ac_s_id']);
        $plat_cfg       = plum_parse_config('platform', 'wxxcx');
        $auth_domain    = $plat_cfg[$plat_type]['auth_domain'];

        $this->output['authdomain'] = "http://".$auth_domain;
        //域名相同直接授权
        if ($auth_domain == plum_get_server('http_host')) {
            $auth   = $this->fetchPreAuthCode($appletCfg['ac_s_id']);
            $this->output['authcode']   = $auth ? $auth : '#';
            $this->output['authtype']   = 'domain';
            $this->output['authUrl'] = '/wxapp/guide/grantAuth';
        } else {
            //微信小程序授权，获取预授权码
            $encode = array(
                'm_id'      => $manager['m_id'],
                'sid'       => $appletCfg['ac_s_id'],
                'suid'      => $appletCfg['s_unique_id'],
                'ac_id'     => $appletCfg['ac_id'],
                'ac_type'   => $appletCfg['ac_type'],
                'from'      => plum_get_base_host(),
                'platform'  => $plat_type,
                'domain'    => $auth_domain,
            );
            $encode = http_build_query($encode);
            $token  = plum_parse_config('encode_token', 'wxxcx');
            $code   = plum_authcode($encode, 'ENCODE', $token);
            $this->output['authcode'] = rawurlencode($code);
            $this->output['authtype']   = 'redirect';
            $this->output['authUrl'] = "http://{$auth_domain}/manage/user/center?loginid=".rawurlencode($code);
        }
    }

    /*
    *百度小程序授权时获取授权信息
    */
    private function _baidu_auth_code_uri($appletCfg,$manager){
        $plat_type  = $this->fetchPlatformType($appletCfg['ac_s_id'],2);
        $plat_cfg       = plum_parse_config('platform', 'baidu');
        $auth_domain    = $plat_cfg[$plat_type]['auth_domain'];

        $this->output['baidu_authdomain'] = "http://".$auth_domain;
        //域名相同直接授权
        if ($auth_domain == plum_get_server('http_host')) {
//            $third_plat     = new App_Plugin_Baidu_ThirdPlatform($plat_type);
//            $pre_result     = $third_plat->getPreAuthCode();
//            //获取预授权码成功
//            if (!$pre_result['errcode']) {
//                $platform   = plum_parse_config('platform', 'baidu');
//                $plat_cfg   = $platform[$plat_type];
//
//                $callback   = "http://{$auth_domain}/manage/user/bdcallback";
//
//                $auth       = "https://smartprogram.baidu.com/mappconsole/tp/authorization?client_id={$plat_cfg['key_id']}&redirect_uri={$callback}&&pre_auth_code={$pre_result['data']['pre_auth_code']}";
//
//                $this->output['baidu_authcode']   = $auth ? $auth : '#';
//                $this->output['baidu_authUrl']    = $auth_domain;
//                $this->output['baidu_authtype']   = 'domain';
//            }
            //百度小程序授权，获取预授权码
            $encode = array(
                'm_id'      => $manager['m_id'],
                'sid'       => $appletCfg['ac_s_id'],
                'suid'      => $appletCfg['s_unique_id'],
                'ac_id'     => $appletCfg['ac_id'],
                'ac_type'   => $appletCfg['ac_type'],
                'from'      => plum_get_base_host(),
                'platform'  => $plat_type,
                'domain'    => $auth_domain,
            );
            $encode = http_build_query($encode);
            $token  = plum_parse_config('encode_token', 'baidu');
            $code   = plum_authcode($encode, 'ENCODE', $token);
            $this->output['baidu_authcode'] = rawurlencode($code);
            $this->output['baidu_authtype']   = 'redirect';
            $this->output['baidu_authUrl'] = "http://{$auth_domain}/manage/user/baidu?loginid=".rawurlencode($code);
        } else {
            //百度小程序授权，获取预授权码
            $encode = array(
                'm_id'      => $manager['m_id'],
                'sid'       => $appletCfg['ac_s_id'],
                'suid'      => $appletCfg['s_unique_id'],
                'ac_id'     => $appletCfg['ac_id'],
                'ac_type'   => $appletCfg['ac_type'],
                'from'      => plum_get_base_host(),
                'platform'  => $plat_type,
                'domain'    => $auth_domain,
            );
            $encode = http_build_query($encode);
            $token  = plum_parse_config('encode_token', 'baidu');
            $code   = plum_authcode($encode, 'ENCODE', $token);
            $this->output['baidu_authcode'] = rawurlencode($code);
            $this->output['baidu_authtype']   = 'redirect';
            $this->output['baidu_authUrl'] = "http://{$auth_domain}/manage/user/baidu?loginid=".rawurlencode($code);
        }
    }

    private function _alixcx_auth_code_uri($appletCfg,$manager){
        $plat_type  = $this->fetchPlatformType($appletCfg['ac_s_id'],3);
        $plat_cfg       = plum_parse_config('platform', 'alixcx');
        $auth_domain    = $plat_cfg[$plat_type]['auth_domain'];

        $this->output['alixcx_authdomain'] = "http://".$auth_domain;
        //支付宝小程序授权，获取预授权码
        $encode = array(
            'm_id'      => $manager['m_id'],
            'sid'       => $appletCfg['ac_s_id'],
            'suid'      => $appletCfg['s_unique_id'],
            'ac_id'     => $appletCfg['ac_id'],
            'ac_type'   => $appletCfg['ac_type'],
            'from'      => plum_get_base_host(),
            'platform'  => $plat_type,
            'domain'    => $auth_domain,
        );
        $encode = http_build_query($encode);
        $code   = plum_authcode($encode, 'ENCODE');
        $this->output['alixcx_authcode'] = rawurlencode($code);
        $this->output['alixcx_authtype']   = 'redirect';
        $this->output['alixcx_authUrl'] = "http://{$auth_domain}/manage/user/alixcxGrantAuth?loginid=".rawurlencode($code);
    }

    /*
     * 获取当前授权平台类型
     */
    public function fetchPlatformType($sid,$type=1) {
        if($type==1){
            $wcfg_storage   = new App_Model_Applet_MysqlCfgStorage($sid);
            $applet_cfg     = $wcfg_storage->findShopCfg();

            $category       = plum_parse_config('category', 'applet');
        }elseif ($type==2){
            $wcfg_storage   = new App_Model_Baidu_MysqlBaiduCfgStorage($sid);
            $applet_cfg     = $wcfg_storage->findShopCfg();

            $category       = plum_parse_config('category', 'baidu');
        }elseif ($type==3){
            $wcfg_storage   = new App_Model_Alixcx_MysqlAlixcxCfgStorage($sid);
            $applet_cfg     = $wcfg_storage->findShopCfg();

            $category       = plum_parse_config('category', 'alixcx');
        }
        $applet_type    = intval($applet_cfg['ac_type']);
        $platform_type  = $category[$applet_type]['platform'];

        return $platform_type;
    }

    /*微信小程序授权获取预授权码
    * @return bool|string
    * 授权回调前的预授权码
    */
    public function fetchPreAuthCode($sid) {
        $platform_type  = $this->fetchPlatformType($sid);
        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage($platform_type);
        $token  = $plat_storage->getCompAccessToken();

        $platform   = plum_parse_config('platform', 'wxxcx');
        $plat_cfg   = $platform[$platform_type];
        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$token}";
        $params     = array('component_appid' => $plat_cfg['app_id']);

        $i = 0;
        do{
            $result     = Libs_Http_Client::post($req_url, json_encode($params));
            $result     = json_decode($result, true);
            $i++;
        } while (!$result && $i < 10);
        $callback   = $this->response->responseHost()."/wxapp/guide/authuri";
        $auth_url   = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$plat_cfg['app_id']}&pre_auth_code={$result['pre_auth_code']}&redirect_uri={$callback}";
        Libs_Log_Logger::outputLog($auth_url);
        return $auth_url;
    }

    /*
     * 检查当前小程序授权状态
     */
    public function checkWxappAuth($appletCfg,$manager) {
        //未授权将跳转到授权引导页面
        $auth   = App_Plugin_Weixin_WxxcxClient::weixinAuthType($appletCfg['ac_s_id']);
        if ($auth == App_Plugin_Weixin_WxxcxClient::WEIXIN_AUTH_NONE) {
            $plat_type  = $this->fetchPlatformType($appletCfg['ac_s_id']);
            $plat_cfg   = plum_parse_config('platform', 'wxxcx');
            $auth_domain    = $plat_cfg[$plat_type]['auth_domain'];

            $msg    = "请绑定需要管理的小程序";
            $from   = $this->request->getStrParam('from');
            //域名相同直接授权
            if ($auth_domain == plum_get_server('http_host')) {
                plum_redirect_with_msg($msg, "/wxapp/guide/grantAuth?from={$from}&msg={$msg}", 3);
            } else {
                //微信小程序授权，获取预授权码
                $encode = array(
                    'm_id'      => $manager['m_id'],
                    'sid'       => $this->curr_sid,
                    'suid'      => $this->curr_shop['s_unique_id'],
                    'ac_id'     => $this->wxapp_cfg['ac_id'],
                    'ac_type'   => $this->wxapp_cfg['ac_type'],
                    'from'      => plum_get_base_host(),
                    'platform'  => $plat_type,
                    'domain'    => $auth_domain,
                );
                $encode = http_build_query($encode);
                $token  = plum_parse_config('encode_token', 'wxxcx');
                $code   = plum_authcode($encode, 'ENCODE', $token);

                plum_redirect_with_msg($msg, "http://{$auth_domain}/manage/user/center?loginid=".rawurlencode($code));
            }
        }
        return true;
    }

    /*
     * 重定向到管理中心
     */
    private function _redirect_to_home() {
        $uid    = plum_app_user_islogin();
        if ($uid) {
            plum_redirect_with_msg('已登录，前往管理中心', '/manage/user/home', 3);
        }
    }
    /*
     * 注册页面
     */
    public function signupAction() {
        //登录判断
        $this->_check_user_login();

        $this->displaySmarty('manage/open.tpl', null, null, false);
    }

    private function _output_wxlogin() {
        $login_cfg  = plum_parse_config('web_login', 'weixin');
        $wxjs   = array(
            'id'        => 'wx-login-box',
            'appid'     => $login_cfg['app_id'],
            'scope'     => 'snsapi_login',
            'redirect_uri'  => 'https://www.tiandiantong.com/manage/user/wxlogin',
            'href'      => 'https://www.tiandiantong.com/public/manage/css/login.css?16'
        );
        $this->output['wxjs']  = json_encode($wxjs);
    }
    /*
     * 微信扫码登录
     */
    public function wxloginAction() {
        $code   = $this->request->getStrParam('code');
        $r_msg  = "微信授权失败, 请重试";
        $r_url  = "/manage/user/index#login";
        if ($code) {
            $login_cfg  = plum_parse_config('web_login', 'weixin');
            //通过code获取access_token
            $params = array(
                'appid'     => $login_cfg['app_id'],
                'secret'    => $login_cfg['app_secret'],
                'code'      => $code,
                'grant_type'=> 'authorization_code',
            );
            $url    = "https://api.weixin.qq.com/sns/oauth2/access_token";
            $tok_ret    = Libs_Http_Client::get($url, $params);
            $tok_ret    = json_decode($tok_ret, true);
            if (isset($tok_ret['access_token'])) {
                $unionid    = null;
                if (isset($tok_ret['unionid']) && $tok_ret['unionid']) {
                    $unionid    = $tok_ret['unionid'];
                } else {
                    //获取会员unionid
                    $params = array(
                        'access_token'  => $tok_ret['access_token'],
                        'openid'        => $tok_ret['openid'],
                    );
                    $info_url   = "https://api.weixin.qq.com/sns/userinfo";
                    $info_ret   = Libs_Http_Client::get($info_url, $params);
                    if (isset($info_ret['unionid']) && $info_ret['unionid']) {
                        $unionid    = $info_ret['unionid'];
                    }
                }

                if ($unionid) {
                    $manager_model  = new App_Model_Member_MysqlManagerStorage();

                    $manager    = $manager_model->findManagerByUnionid($tok_ret['unionid']);
                    if ($manager) {
                        switch ($manager['m_status']) {
                            case self::MANAGER_LOGIN_NORMAL :
                                plum_app_user_login($manager['m_id']);

                                $r_msg  = "登录成功, 正在前往控制台";
                                $r_url  = "/manage/index";
                                break;
                            case self::MANAGER_LOGIN_REVIEW :
                                $r_msg  = "账号正在申请中, 销售经理将很快与您联系";
                                $r_url  = "/manage/user/index#login";
                                break;
                            case self::MANAGER_LOGIN_PREVENT :
                                $r_msg  = "账号已被禁止访问";
                                $r_url  = "/manage/user/index#login";
                                break;
                        }
                    } else {
                        $r_msg  = "未绑定管理账号, 请使用其他方式登录";
                        $r_url  = "/manage/user/index#login";
                    }
                } else {
                    $r_msg  = "微信授权失败, 请重试";
                    $r_url  = "/manage/user/index#login";
                }
            } else {
                $r_msg  = "微信授权失败, 请重试";
                $r_url  = "/manage/user/index#login";
            }
        }

        plum_redirect_with_msg($r_msg, $r_url);
    }
    /*
     * 异步登录功能
     */
    public function loginAction() {
        plum_send_http_header('Access-Control-Allow-Origin:*');
        plum_send_http_header('Access-Control-Allow-Methods:POST,GET');
        $mobile     = $this->request->getStrParam('mobile');
        $password   = $this->request->getStrParam('password');
        $remember   = $this->request->getIntParam('remember', 0);
        $password   = plum_salt_password($password);//密码加盐并加密处理
        $manager_storage    = new App_Model_Member_MysqlManagerStorage();

        $exists = $manager_storage->findManagerByMobile($mobile);

        if ($exists) {
            if ($exists['m_password'] != $password) {
                $this->displayJsonError('手机号与密码不匹配');
            } else {
                //可以正常登陆
                switch ($exists['m_status']) {
                    case self::MANAGER_LOGIN_NORMAL :
                        plum_app_user_login($exists['m_id']);
                        //勾选记住用户时设置
                        if ($remember) {
                            plum_remember_login_user($this->remember_lifetime, '/');
                        }
                      
                        $redirect_url   = '/wxapp/index';
                        $ret    = array(
                            'status'        => '登录成功，正在跳转',
                            'redirect_url'  => $redirect_url."?from=login",
                        );
                        $this->displayJsonSuccess($ret);
                        break;
                    case self::MANAGER_LOGIN_REVIEW :
                        $this->displayJsonError("账号正在申请中, 销售经理将很快与您联系");
                        break;
                    case self::MANAGER_LOGIN_PREVENT :
                        $this->displayJsonError("账号已被禁止访问");
                        break;
                }
            }
        } else {
            $this->displayJsonError('手机号码尚未注册');
        }
    }

    /*
     * 账号退出
     */
    public function logoutAction() {

        plum_app_user_logout();
        plum_redirect_with_output(array('msg' => '已安全退出登录', 'script' => ''), '/manage/user/index', 3);
       
    }

    /**
     * 根据用户登录信息获取用户所属代理商是否开通OEM，或者是否绑定域名
     */
    private function _shop_agent_oem(){
        $uid = plum_app_user_islogin();
        $manager_storage    = new App_Model_Member_MysqlManagerStorage();
        $manager = $manager_storage->getRowById($uid);

        $open_storage = new App_Model_Agent_MysqlOpenStorage(0);
        $ret = $open_storage->getAgentOemBySid($manager['m_c_id'],0);
        if($ret && $ret['aa_web_server']){
            $web_storage = App_Model_Agent_MysqlWebStorage::getInstance($ret['aa_web_server']);
            $row = $web_storage->getWebRow($ret['aa_id']);
            if($row && $row['aw_domain']){
                return $row['aw_domain'];
            }
        }
//        $oem_domain = plum_parse_config('oem_domain','agent');
//        if($ret && $ret['ao_domain'] && $oem_domain[$ret['ao_domain']]){
//            return $oem_domain[$ret['ao_domain']];
//        }else{
//            if($ret && $ret['aa_web_server']){
//                $web_storage = App_Model_Agent_MysqlWebStorage::getInstance($ret['aa_web_server']);
//                $row = $web_storage->getWebRow($ret['aa_id']);
//                if($row['aw_domain']){
//                    return $row['aw_domain'];
//                }
//            }
//        }
        return false;
    }

    public function captchaAction() {
        $type       = $this->request->getStrParam('type');
        $width      = $this->request->getIntParam('w');
        $height     = $this->request->getIntParam('h');
        $captcha    = new Libs_Captcha_Captcha($width, $height, $type, 4);

        $captcha->outputCaptcha();
    }

    /*
     * 使用云片发送短信功能,废弃
     * 发送短信验证码的功能
     */
    public function _fetchCodeAction() {
        $mobile = $this->request->getStrParam('mobile');

        if (!plum_is_mobile($mobile)) {
            $this->displayJsonError("手机号格式不正确");
        }

        $yunpian_plugin = new App_Plugin_Sms_YunPianPlugin();
        $code   = mt_rand(1000, 9999);//四位随机数
        $ret    = $yunpian_plugin->webSendVerify($mobile, $code);

        if (is_array($ret) && !$ret['status']) {
            $this->displayJsonSuccess(array('sign' => $ret['signature'], 'timestamp' => $ret['timestamp']));
        } else {
            $this->displayJsonError($yunpian_plugin->verify_code_error[$ret]);
        }
    }
    /*
     * 发送短信验证码的功能
     * 注册，手机号不能存在
     * 忘记密码，手机号必须存在
     */
    public function sendSmsCodeAction() {
        $mobile = $this->request->getStrParam('mobile');
        $type   = $this->request->getStrParam('type', 'register');

        Libs_Log_Logger::outputLog($_SERVER['HTTP_USER_AGENT']);
        $match = preg_match("/UBrowser/i", $_SERVER['HTTP_USER_AGENT']);
        if ($match == 1) {
            die();
        }
        Libs_Log_Logger::outputLog($mobile);
        Libs_Log_Logger::outputLog($type);

        if (!plum_is_mobile($mobile)) {
            $this->displayJsonError("手机号格式不正确");
        }
        $manager_storage    = new App_Model_Member_MysqlManagerStorage();
        $send = array(
            'ec' => 200,
            'em' => ''
        );
        switch ($type) {
            case 'register' :
            case 'forget'   :
                $exists = $manager_storage->findManagerByMobile($mobile);

                if($type == 'register' && !empty($exists)) {
                    $send = array(
                        'ec' => 400,
                        'em' => '手机号已经存在'
                    );
                }else if($type == 'forget' && empty($exists)) {
                    $send = array(
                        'ec' => 400,
                        'em' => '手机号不存在'
                    );
                }
                break;
            default :
                $style  = 'yhzc';
                break;
        }
        if($send['ec'] == 200){
            $sms_plugin = new App_Plugin_Sms_UcpaasPlugin();
            $code   = mt_rand(1000, 9999);//四位随机数
            $ret    = $sms_plugin->webSendVerify($mobile, $code, null, $type);

            if (is_array($ret) && !$ret['status']) {
                $this->displayJsonSuccess(array('sign' => $ret['signature'], 'timestamp' => $ret['timestamp']));
            } else {
                $this->displayJsonError($sms_plugin->verify_code_error[$ret]);
            }
        }else{
            $this->displayJsonError($send['em']);
        }
    }

    /*
     * 发送短信验证码
     * 注册，手机号不能存在
     * 忘记密码，手机号必须存在
     */
    public function sendCodeAction(){
        $mobile = $this->request->getStrParam('mobile');
        $type   = $this->request->getStrParam('type', 'register');
        $code   = $this->request->getStrParam('code');
        if($type=='register'){
            $this->displayJsonError('暂不支持自助注册，如需开通小程序请和客服联系');
        }
        if (!plum_is_mobile($mobile)) {
            $this->displayJsonError("手机号格式不正确");
        }
        if($code != $_SESSION['captcha_code']){
            $this->displayJsonError("图片验证码不正确");
        }
        $manager_storage    = new App_Model_Member_MysqlManagerStorage();
        $send = array(
            'ec' => 200,
            'em' => ''
        );
        switch ($type) {
            case 'register' :
            case 'forget'   :
                $exists = $manager_storage->findManagerByMobile($mobile);

                if($type == 'register' && !empty($exists)) {
                    $send = array(
                        'ec' => 400,
                        'em' => '手机号已经存在'
                    );
                }else if($type == 'forget' && empty($exists)) {
                    $send = array(
                        'ec' => 400,
                        'em' => '手机号不存在'
                    );
                }
                break;
            default :
                $style  = 'yhzc';
                break;
        }
        if($send['ec'] == 200){
            $sms_plugin = new App_Plugin_Sms_UcpaasPlugin();
            $code   = mt_rand(1000, 9999);//四位随机数
            $ret    = $sms_plugin->webSendVerify($mobile, $code, null, $type);

            if (is_array($ret) && !$ret['status']) {
                $this->displayJsonSuccess(array('sign' => $ret['signature'], 'timestamp' => $ret['timestamp']));
            } else {
                $this->displayJsonError($sms_plugin->verify_code_error[$ret]);
            }
        }else{
            $this->displayJsonError($send['em']);
        }
    }

    /*
     * 异步注册功能
     */
    public function registerAction() {
        $company    = $this->request->getStrParam('company');
        $mobile     = $this->request->getStrParam('mobile');
        $nickname   = $this->request->getStrParam('nickname');
        $password   = $this->request->getStrParam('password');
        $code       = $this->request->getIntParam('code');
        $signature  = $this->request->getStrParam('sign');
        $timestamp  = $this->request->getIntParam('timestamp');

        $province   = $this->request->getStrParam('province');
        $city       = $this->request->getStrParam('city');
        $type       = $this->request->getIntParam('type');
        //判断验证码是否正确
        /*
        $yunpian_plugin = new App_Plugin_Sms_YunPianPlugin();
        $verify = $yunpian_plugin->webSendVerify($mobile, $code, $timestamp, null, null, false);
        if (!is_array($verify)) {
            $this->displayJsonError($yunpian_plugin->verify_code_error[$verify]);
        }
        */
        $sms_plugin = new App_Plugin_Sms_UcpaasPlugin();
        $verify = $sms_plugin->webSendVerify($mobile, $code, $timestamp, null, null, false);
        if (!is_array($verify)) {
            $this->displayJsonError($sms_plugin->verify_code_error[$verify]);
        }

        if (!$signature || $signature != $verify['signature']) {
            $this->displayJsonError("验证码不正确，请重新输入");
        }

        $salt_pass   = plum_salt_password($password);//密码加盐并加密处理

        $manager_storage    = new App_Model_Member_MysqlManagerStorage();

        $exists = $manager_storage->findManagerByMobile($mobile);

        if ($exists) {
            $this->displayJsonError('手机号已存在，请登录');
        } else {
            $company_storage    = new App_Model_Member_MysqlCompanyCoreStorage();
            //获取注册来源
            $source = $this->request->getStrCookie('plum_token_source');
            $source = $source && $source == 'weidian' ? 'PC版:微店' : 'PC版:自主';
            
            //第一步创建公司
            $cpdata = array(
                'c_name'        => $company,
                'c_max_build'   => self::MAX_BUILD_SHOP,
                'c_created'     => time(),
                'c_founder_id'  => 0,//先设为0，后续修改
                'c_province'    => $province,
                'c_source'      => $source,
                'c_city'        => $city,
                'c_type'        => $type
            );
            // 通过手机号获取归属地
//            $address = App_Helper_Tool::getAddressByMobile($mobile);
//            if(!empty($address)){
//                $cpdata['c_province'] = $address['province'];
//                $cpdata['c_city'] = $address['city'];
//            }
            $cid    = $company_storage->insert($cpdata, true);//获取新创建的公司id
            //UCenter信息配置
            $username   = "fxb_".plum_random_code(8);//用户名,由随机数组成
            $uc_pass    = plum_random_code();//生成随机密码
            $email      = "{$mobile}@fxb.xin";//会员邮箱
            $uid        = uc_user_register($username,$uc_pass,$email);
            if ($uid < 0) {
                Libs_Log_Logger::outputLog("UCenter注册失败==>".$this->ucenter_error[strval($uid)]);
                $uid = 0;
            }
            //第二步新建管理员
            $mgdata = array(
                'm_c_id'        => $cid,
                'm_u_id'        => $uid,
                'm_u_pass'      => $uc_pass,
                'm_mobile'      => $mobile,
                'm_nickname'    => $nickname,
                'm_password'    => $salt_pass,
                'm_createtime'  => time(),
                'm_status'      => self::MANAGER_LOGIN_NORMAL,//设置为审核中
            );
            $mid = $manager_storage->insert($mgdata, true);//获取创建人id
            //第三步修改公司创建人
            $cpupdata   = array(
                'c_founder_id'  => $mid
            );
            $company_storage->updateById($cpupdata, $cid);
            $mailto     = plum_parse_config('xyhzc', 'mail');
            App_Helper_Tool::sendMail("新商户注册通知", "商户名:{$company},手机号:{$mobile},来源:{$source}", $mailto);
            //第四步返回成功提示信息
            $ret = array(
                'status' => '注册成功，请登录',
            );
            $this->displayJsonSuccess($ret);
        }
    }

    /*
     * 找回、重置密码功能
     */
    public function forgetAction() {
        $mobile     = $this->request->getStrParam('mobile');
        $password   = $this->request->getStrParam('password');
        $code       = $this->request->getIntParam('code');
        $signature  = $this->request->getStrParam('sign');
        $timestamp  = $this->request->getIntParam('timestamp');
        //判断验证码是否正确
        /*
        $yunpian_plugin = new App_Plugin_Sms_YunPianPlugin();
        $verify = $yunpian_plugin->webSendVerify($mobile, $code, $timestamp, null, null, false);
        if (!is_array($verify)) {
            $this->displayJsonError($yunpian_plugin->verify_code_error[$verify]);
        }
        */
        $sms_plugin = new App_Plugin_Sms_UcpaasPlugin();
        $verify = $sms_plugin->webSendVerify($mobile, $code, $timestamp, null, null, false);
        if (!is_array($verify)) {
            $this->displayJsonError($sms_plugin->verify_code_error[$verify]);
        }

        if (!$signature || $signature != $verify['signature']) {
            $this->displayJsonError("验证码不正确，请重新输入");
        }

        $password   = plum_salt_password($password);//密码加盐并加密处理

        $manager_storage    = new App_Model_Member_MysqlManagerStorage();

        $exists = $manager_storage->findManagerByMobile($mobile);

        if (!$exists) {
            $this->displayJsonError('该手机号未被注册！');
        } else {
            $updata = array(
                'm_password'    => $password
            );
            $manager_storage->updateById($updata, $exists['m_id']);
            $ret = array(
                'status' => '重置成功，请登录',
            );
            $this->displayJsonSuccess($ret);
        }
    }
    /*
     * 手机版店铺申请
     */
    public function mobileAction() {

        $this->displaySmarty("manage/mobile-reg.tpl", null, null, false);
    }

    //生成图片验证码
    public function validateAction(){
        $validate_libs = new Libs_Captcha_Captcha(90,32,'math',4);
        $validate_libs->outputCaptcha();
    }

    /*
     * 进入后端逻辑
     */
    public function backstageAction() {
        $manager_storage    = new App_Model_Member_MysqlManagerStorage();

        $mid    = plum_app_user_islogin();
        $exist  = $manager_storage->getRowById($mid);

        //获取公司主体类型,跳转到不同管理后台
        $company_model  = new App_Model_Member_MysqlCompanyCoreStorage();
        $company        = $company_model->getRowById($exist['m_c_id']);

        $redirect_url   = $company['c_type'] == 1 ? '/manage/index' : '/wxapp/index';
        $redirect_url   .= "?from=site";
        plum_redirect($redirect_url);
    }

    public function sysloginAction() {
        $cookietime = 604800;//七天时间
        $code       = $this->request->getStrParam('code');
        parse_str(plum_authcode($code, 'DECODE', PLUM_AUTH_TOKEN), $params);

        $password   = isset($params['password']) ? plum_salt_password($params['password']) : $params['check'];
        $params['check']    = $password;
        $manager_storage    = new App_Model_Member_MysqlManagerStorage();
        $exists     = $manager_storage->findManagerByMobile($params['username']);
        $referer    = plum_get_server('HTTP_REFERER');
        if ($exists) {
            if ($exists['m_password'] != $password) {
                plum_redirect_with_msg('手机号与密码不匹配', $referer);
            } else {
                //可以正常登陆
                switch ($exists['m_status']) {
                    case self::MANAGER_LOGIN_NORMAL :
                        plum_app_user_login($exists['m_id']);
                        $_SESSION['refer_url'] = $referer;
                        plum_remember_login_user($cookietime, '/');
                        //获取公司主体类型,跳转到不同管理后台
                        $company_model  = new App_Model_Member_MysqlCompanyCoreStorage();
                        $company        = $company_model->getRowById($exists['m_c_id']);
                        // 判断代理商是否开通了OEM及是否配置了自己的域名
                        $this->_get_agent_domain($exists['m_c_id'],$params);
                        if($params['domain'] && isset($params['domain'])){
                            $domain = 'http://'.$params['domain'];
                        }else{
                            $domain = '';
                        }
                        $redirect_url   = $company['c_type'] == 1 ? $domain.'/manage/index' : $domain.'/manage/user/home';
                        plum_redirect_with_msg('登录成功，正在跳转', $redirect_url."?from=login");
                        break;
                    case self::MANAGER_LOGIN_REVIEW :
                        plum_redirect_with_msg("账号正在申请中, 销售经理将很快与您联系", $referer);
                        break;
                    case self::MANAGER_LOGIN_PREVENT :
                        plum_redirect_with_msg("账号已被禁止访问", $referer);
                        break;
                }
            }
        } else {
            plum_redirect_with_msg('手机号码尚未注册', $referer);
        }
    }
    /**
     * 获取上级代理商是否开通OEM及代理商域名
     */
    private function _get_agent_domain($cid,$params){
        $open_storage = new App_Model_Agent_MysqlOpenStorage(0);
        $ret = $open_storage->getAgentOemBySid($cid);
        if($ret){
            $agent_domain = $ret['ao_domain'];
            if($agent_domain){
                $corrent_domain = plum_get_server('http_host');
                // 如果代理商设置的域名和当前域名不相同就再重新执行
                if($corrent_domain != $agent_domain){
                    //同步登录
                    $curr = time();
                    $params = array('username' => $params['username'], 'check' => $params['check'], 'action' => 'synlogin','domain'=>$agent_domain);
                    $curr_code   = plum_authcode(http_build_query($params), 'ENCODE');
                    $curr_code   = urlencode($curr_code);
                    plum_redirect('http://'.$agent_domain."/manage/user/syslogin?time={$curr}&code={$curr_code}");
                }
            }
        }
        return false;
    }
    /*
     * 百度小程序授权中心
     */
    public function baiduAction() {
        $loginid    = $this->request->getStrParam('loginid');
        $loginid    = rawurldecode($loginid);
        $token      = plum_parse_config('encode_token', 'baidu');
        $decode     = plum_authcode($loginid, 'DECODE', $token);
        parse_str($decode, $output);

        $platform_type  = $output['platform'];
        $third_plat     = new App_Plugin_Baidu_ThirdPlatform($platform_type);
        $pre_result     = $third_plat->getPreAuthCode();
        //获取预授权码成功
        if (!$pre_result['errcode']) {
            $platform   = plum_parse_config('platform', 'baidu');
            $plat_cfg   = $platform[$platform_type];

            $callback   = "http://{$output['domain']}/manage/user/bdcallback?loginid=".base64_encode($loginid);

            $auth       = "https://smartprogram.baidu.com/mappconsole/tp/authorization?client_id={$plat_cfg['key_id']}&redirect_uri={$callback}&&pre_auth_code={$pre_result['data']['pre_auth_code']}";

            $this->output['auth_uri']   = $auth ? $auth : '#';
            $this->output['domain'] = "{$output['from']}";
            $this->displaySmarty('wxapp/baidu-auth.tpl');
        }
    }
    /*
     * 百度小程序授权回调
     */
    public function bdcallbackAction() {
        $loginid    = $this->request->getStrParam('loginid');
        $token      = plum_parse_config('encode_token', 'baidu');
        $decode     = plum_authcode(base64_decode($loginid), 'DECODE', $token);
        parse_str($decode, $output);
        //跳转的授权成功页@todo
        $redirect_url   = $output['from'].'/wxapp/index?menuType=bdapp';
        //获取当前店铺的百度配置@todo
        $wcfg_storage   = new App_Model_Baidu_MysqlBaiduCfgStorage($output['sid']);
        $applet_cfg     = $wcfg_storage->findShopCfg();

        $auth_code  = $this->request->getStrParam('authorization_code');
        $expires    = $this->request->getIntParam('expires_in');

        $platform_type  = $output['platform'];

        $platform   = plum_parse_config('platform', 'baidu');
        $plat_cfg   = $platform[$platform_type];

        $third_plat = new App_Plugin_Baidu_ThirdPlatform($platform_type);
        $result     = $third_plat->getAccessToken($auth_code);
        if (!$result['errcode']) {//获取access token成功
            $bdapp_result   = $third_plat->getAppInfo($result['data']['access_token']);
            if (!$bdapp_result['errcode']) {//获取百度小程序基本信息成功
                $info   = array_merge($result['data'], $bdapp_result['data']);
                //重新授权时，必须是已授权的相同小程序@todo
                if (!empty($applet_cfg) && $applet_cfg['ac_appid'] && $applet_cfg['ac_appid'] != $info['app_id']) {
                    //$shop_name = $this->shopIdArray[$this->curr_sid]['s_name'];
                    plum_redirect_with_msg("系统已授权到小程序{$applet_cfg['ac_name']}，无法授权给新的小程序", $redirect_url);
                }
                //新授权时，需要判断当前小程序是否已在其他店铺授权
                if (!empty($applet_cfg) && !$applet_cfg['ac_appid']) {
                    $exists = $wcfg_storage->fetchUpdateWxcfgByAid($info['app_id']);
                    if ($exists) {
                        plum_redirect_with_msg("小程序{$info['app_name']}已被系统其他用户授权，无法重复授权", $redirect_url);
                    }
                    /*
                    //判断小程序是否在子程序账号中授权
                    $child_model    = new App_Model_Applet_MysqlChildStorage($output['sid']);
                    $exists = $child_model->fetchUpdateWxcfgByAid($info['authorizer_appid']);
                    if ($exists) {
                        plum_redirect_with_msg("小程序{$info['authorizer_appid']}已在系统子程序中授权，请解除授权后, 可以再次授权", $redirect_url);
                    }
                    */
                }

                $updata = array(
                    'ac_appid'              => $info['app_id'],
                    'ac_auth_access_token'  => $info['access_token'],
                    'ac_auth_expire_time'   => $info['expires_in']+time()-100,//防止请求时间过长
                    'ac_auth_refresh_token' => $info['refresh_token'],
                    'ac_auth_status'        => 1,//设置为平台授权
                );

                $auth = $this->_applet_is_auth($output['sid'],2);   //获取是否授权过
                if(!$auth && !$applet_cfg['ac_domain_time'] && !$applet_cfg['ac_func_scope'] && !$applet_cfg['ac_appsecret']){    //未授权过
                    $updata['ac_expire_time'] = $applet_cfg['ac_expire_time']+(time()-$applet_cfg['ac_open_time']);  //给用户补偿未授权消耗的时间
                }
                $avatar = json_decode($info['photo_addr'],true);
                $basedata   = array(
                    'ac_service_type'   => $info['qualification']['type'],
                    'ac_verify_type'    => $info['qualification']['satus'],
                    'ac_name'           => $info['app_name'],
                    'ac_avatar'         => $avatar[0]['cover'],
                    'ac_principal'      => $info['qualification']['name'],
                    'ac_domain_time'    => time(),
                    'ac_category'       => json_encode($info['category']),
                    'ac_signature'      => $info['app_desc'],
                );
                $updata = array_merge($updata, $basedata);
                $wcfg_storage->findShopCfg($updata);
                //授权成功后修改域名
                $smart_client   = new App_Plugin_Baidu_SmartClient($output['sid'], $info['access_token']);
                $domain         = plum_parse_config('domain', 'baidu');
                $smart_client->modifyReqDomain('add',$domain['req'], $domain['wss'], $domain['upl'], $domain['dow']);

                //授权成功后记录授权信息
                $this->_save_applet_auth($output['sid'],$info['app_id'],$info['app_name'],2);
                plum_redirect_with_msg("小程序{$info['app_name']}授权成功", $redirect_url);
            }else{
                plum_redirect_with_msg("授权失败，请将所有权限授予平台", $redirect_url);
            }
        }
        plum_redirect_with_msg("授权失败，请重试", $redirect_url);
    }
    /*
     * 微信小程序授权中心
     */
    public function centerAction() {
        $loginid    = $this->request->getStrParam('loginid');
        $loginid    = rawurldecode($loginid);
        $token      = plum_parse_config('encode_token', 'wxxcx');
        $decode     = plum_authcode($loginid, 'DECODE', $token);
        parse_str($decode, $output);

        $platform_type  = $output['platform'];
        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage($platform_type);
        $token  = $plat_storage->getCompAccessToken();

        $platform   = plum_parse_config('platform', 'wxxcx');
        $plat_cfg   = $platform[$platform_type];
        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$token}";
        $params     = array('component_appid' => $plat_cfg['app_id']);

        $i = 0;
        do{
            $result     = Libs_Http_Client::post($req_url, json_encode($params));
            $result     = json_decode($result, true);
            $i++;
        } while (!$result && $i < 10);

        $callback   = "http://{$output['domain']}/manage/user/authuri?loginid=".base64_encode($loginid);
        $auth       = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$plat_cfg['app_id']}&pre_auth_code={$result['pre_auth_code']}&redirect_uri={$callback}";

        $this->output['auth_uri']   = $auth ? $auth : '#';
        $this->output['domain'] = "{$output['from']}";
        $this->displaySmarty('wxapp/wxxcx-auth.tpl');
    }

    /*
     * 微信小程序主程序授权回调
     */
    public function authuriAction() {
        $loginid    = $this->request->getStrParam('loginid');
        $token      = plum_parse_config('encode_token', 'wxxcx');
        $decode     = plum_authcode(base64_decode($loginid), 'DECODE', $token);
        parse_str($decode, $output);
        $redirect_url   = $output['from'].'/wxapp/setup/index';
        //获取当前店铺的微信配置
        $wcfg_storage   = new App_Model_Applet_MysqlCfgStorage($output['sid']);
        $wx_cfg     = $wcfg_storage->findShopCfg();

        $auth_code  = $this->request->getStrParam('auth_code');
        $expires    = $this->request->getIntParam('expires_in');

        $platform_type  = $output['platform'];

        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage($platform_type);
        $token  = $plat_storage->getCompAccessToken();
        $platform   = plum_parse_config('platform', 'wxxcx');
        $plat_cfg   = $platform[$platform_type];

        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token={$token}";
        $params     = array(
            'component_appid'   => $plat_cfg['app_id'],
            'authorization_code'=> $auth_code,
        );

        $result     = Libs_Http_Client::post($req_url, json_encode($params));
        $result     = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);
        if ($result && isset($result['authorization_info'])) {
            $info   = $result['authorization_info'];
            //重新授权时，必须是已授权的相同小程序
            if (!empty($wx_cfg) && $wx_cfg['ac_appid'] && $wx_cfg['ac_appid'] != $info['authorizer_appid']) {
                //$shop_name = $this->shopIdArray[$this->curr_sid]['s_name'];
                plum_redirect_with_msg("系统已授权到小程序{$wx_cfg['ac_appid']}，无法授权给新的小程序", $redirect_url);
            }
            //新授权时，需要判断当前公众号是否已在其他店铺授权
            if (!empty($wx_cfg) && !$wx_cfg['ac_appid']) {
                $exists = $wcfg_storage->fetchUpdateWxcfgByAid($info['authorizer_appid']);
                if ($exists) {
                    plum_redirect_with_msg("小程序{$info['authorizer_appid']}已被系统其他用户授权，无法重复授权", $redirect_url);
                }
                //判断小程序是否在子程序账号中授权
                $child_model    = new App_Model_Applet_MysqlChildStorage($output['sid']);
                $exists = $child_model->fetchUpdateWxcfgByAid($info['authorizer_appid']);
                if ($exists) {
                    plum_redirect_with_msg("小程序{$info['authorizer_appid']}已在系统子程序中授权，请解除授权后, 可以再次授权", $redirect_url);
                }
            }

            $updata = array(
                'ac_appid'              => $info['authorizer_appid'],
                'ac_auth_access_token'  => $info['authorizer_access_token'],
                'ac_auth_expire_time'   => $info['expires_in']+time()-20,//防止请求时间过长
                'ac_auth_refresh_token' => $info['authorizer_refresh_token'],
                'ac_auth_status'        => 1,//设置为平台授权
            );
            //获取公众号基本信息
            $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token={$token}";
            $params     = array(
                'component_appid'       => $plat_cfg['app_id'],
                'authorizer_appid'      => $info['authorizer_appid'],
            );

            $ret    = Libs_Http_Client::post($req_url, json_encode($params));
            $ret    = json_decode($ret, true);
            //Libs_Log_Logger::outputLog($ret);
            if ($ret && isset($ret['authorizer_info'])) {
                $base_info  = $ret['authorizer_info'];

                //存储小程序二维码图片
                $img_data   = file_get_contents($base_info['qrcode_url']);
                $img        = imagecreatefromstring($img_data);
                $filename   = plum_uniqid_base36(true).".jpg";
                imagejpeg($img, PLUM_APP_BUILD."/".$filename);
                imagedestroy($img);

                $has_func   = array();
                foreach ($info['func_info'] as $category) {
                    $has_func[] = $category['funcscope_category']['id'];
                }
                $auth = $this->_applet_is_auth($output['sid']);   //获取是否授权过
                if(!$auth && !$wx_cfg['ac_domain_time'] && !$wx_cfg['ac_func_scope']){    //未授权过
                    $updata['ac_expire_time'] = $wx_cfg['ac_expire_time']+(time()-$wx_cfg['ac_open_time']);  //给用户补偿未授权消耗的时间
                }
                $basedata   = array(
                    'ac_gh_id'          => $base_info['user_name'],
                    'ac_service_type'   => $base_info['service_type_info']['id'],
                    'ac_verify_type'    => $base_info['verify_type_info']['id'],
                    'ac_name'           => $base_info['nick_name'],
                    'ac_avatar'         => $base_info['head_img'],
                    'ac_principal'      => $base_info['principal_name'],
                    'ac_qrcode'         => '/public/build/'.$filename,
                    'ac_domain_time'    => time(),
                    'ac_func_scope'     => json_encode($has_func),
                    //'ac_category'       => $base_info['miniprograminfo']['categories'],
                    'ac_signature'      => $base_info['signature'],
                );
                $updata = array_merge($updata, $basedata);
                $wcfg_storage->findShopCfg($updata);
                //如果是代理商创建的小程序，将这行数据附一个sid
                $wxapp_model = new App_Model_Applet_MysqlAppletWxappStorage();
                $wxappset = array('paw_s_id' => $output['sid']);
                $wxapp_model->findUpdateRowByAppid($updata['ac_appid'], $wxappset);
                //授权成功后修改域名
                $server_domain  = plum_parse_config('server', 'wxxcx');
                $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($output['sid']);
                $domain         = isset($server_domain[$wx_cfg['ac_type']]) ? $server_domain[$wx_cfg['ac_type']]['domain'] : plum_parse_config('domain', 'wxxcx');
                if($wx_cfg['ac_s_id']==10376){
                    $wxxcx_client->coverCodeDomain($domain['req'], $domain['wss'], $domain['upl'], $domain['dow'],'add');
                }else{
                    $wxxcx_client->coverCodeDomain($domain['req'], $domain['wss'], $domain['upl'], $domain['dow']);
                }
                //授权成功后记录授权信息
                $this->_save_applet_auth($output['sid'],$info['authorizer_appid'],$base_info['nick_name']);

                //检测授权权限,便于信息提示
                $func_scope = plum_parse_config('func_scope', 'applet');
                Libs_Log_Logger::outputLog($has_func);
                $not_func   = array_diff(array_keys($func_scope), $has_func);
                if (!empty($not_func)) {
                    $msg    = "小程序{$info['authorizer_appid']}授权成功<br>";
                    foreach ($not_func as $func) {
                        $msg .= "{$func_scope[$func]['name']}未授权, {$func_scope[$func]['desc']}<br>";
                    }
                    plum_redirect_with_msg($msg, $redirect_url, 6);
                } else {
                    plum_redirect_with_msg("小程序{$info['authorizer_appid']}授权成功", $redirect_url);
                }
            }
        }
        plum_redirect_with_msg("授权失败，请重试", $redirect_url);
    }

    /*
     * 子账号授权中心
     */
    public function childCenterAction() {
        $loginid    = $this->request->getStrParam('loginid');
        $loginid    = rawurldecode($loginid);
        $token      = plum_parse_config('encode_token', 'wxxcx');
        $decode     = plum_authcode($loginid, 'DECODE', $token);
        parse_str($decode, $output);

        $platform_type  = $output['platform'];
        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage($platform_type);
        $token  = $plat_storage->getCompAccessToken();

        $platform   = plum_parse_config('platform', 'wxxcx');
        $plat_cfg   = $platform[$platform_type];
        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$token}";
        $params     = array('component_appid' => $plat_cfg['app_id']);

        $i = 0;
        do{
            $result     = Libs_Http_Client::post($req_url, json_encode($params));
            $result     = json_decode($result, true);
            $i++;
        } while (!$result && $i < 10);

        $callback   = "http://{$output['domain']}/manage/user/childAuthuri?loginid=".base64_encode($loginid);
        $auth       = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$plat_cfg['app_id']}&pre_auth_code={$result['pre_auth_code']}&redirect_uri={$callback}";

        $this->output['auth_uri']     = $auth ? $auth : '#';

        $this->displaySmarty('wxapp/wxxcx-auth.tpl');
    }

    /**
     * 子程序授权回调
     */
    public function childAuthuriAction() {
        $loginid    = $this->request->getStrParam('loginid');
        $token      = plum_parse_config('encode_token', 'wxxcx');
        $decode     = plum_authcode(base64_decode($loginid), 'DECODE', $token);
        parse_str($decode, $output);
        //获取当前店铺的微信配置
        $wcfg_storage   = new App_Model_Applet_MysqlCfgStorage($output['sid']);
        $wx_cfg     = $wcfg_storage->findShopCfg();
        $redirect_url   = $output['from'].'/wxapp/child/index';
        //获取当前店铺的微信配置
        $auth_code  = $this->request->getStrParam('auth_code');
        $expires    = $this->request->getIntParam('expires_in');

        $platform_type  = $output['platform'];

        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage($platform_type);
        $token  = $plat_storage->getCompAccessToken();
        $platform   = plum_parse_config('platform', 'wxxcx');
        $plat_cfg   = $platform[$platform_type];

        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token={$token}";
        $params     = array(
            'component_appid'   => $plat_cfg['app_id'],
            'authorization_code'=> $auth_code,
        );

        $result     = Libs_Http_Client::post($req_url, json_encode($params));
        $result     = json_decode($result, true);

        if ($result && isset($result['authorization_info'])) {
            $info   = $result['authorization_info'];
            //判断是否在主程序中是否已授权过
            $wcfg_storage   = new App_Model_Applet_MysqlCfgStorage($output['sid']);
            $exists         = $wcfg_storage->fetchUpdateWxcfgByAid($info['authorizer_appid']);
            if ($exists) {
                plum_redirect_with_msg("小程序{$info['authorizer_appid']}已被系统其他用户授权，无法重复授权", $redirect_url);
            }
            //判断是否在子程序中是否已授权过
            $child_model  = new App_Model_Applet_MysqlChildStorage($output['sid']);
            $exists = $child_model->fetchUpdateWxcfgByAid($info['authorizer_appid']);
            if ($exists && $exists['ac_s_id'] != $output['sid']) {
                plum_redirect_with_msg("小程序{$info['authorizer_appid']}已被系统其他用户授权，无法重复授权", $redirect_url);
            }
            //新授权,二次授权
            $updata = array(
                'ac_s_id'               => $output['sid'],
                'ac_acid'               => $wx_cfg['ac_id'],
                'ac_appid'              => $info['authorizer_appid'],
                'ac_auth_access_token'  => $info['authorizer_access_token'],
                'ac_auth_expire_time'   => $info['expires_in']+time()-20,//防止请求时间过长
                'ac_auth_refresh_token' => $info['authorizer_refresh_token'],
                'ac_auth_status'        => 1,//设置为平台授权
            );
            //获取公众号基本信息
            $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token={$token}";
            $params     = array(
                'component_appid'       => $plat_cfg['app_id'],
                'authorizer_appid'      => $info['authorizer_appid'],
            );

            $ret    = Libs_Http_Client::post($req_url, json_encode($params));
            $ret    = json_decode($ret, true);
            Libs_Log_Logger::outputLog($ret);
            if ($ret && isset($ret['authorizer_info'])) {
                $base_info  = $ret['authorizer_info'];

                $has_func   = array();
                foreach ($info['func_info'] as $category) {
                    $has_func[] = $category['funcscope_category']['id'];
                }

                $basedata   = array(
                    'ac_gh_id'          => $base_info['user_name'],
                    'ac_service_type'   => $base_info['service_type_info']['id'],
                    'ac_verify_type'    => $base_info['verify_type_info']['id'],
                    'ac_name'           => $base_info['nick_name'],
                    'ac_logo'           => $base_info['head_img'],
                    'ac_principal'      => $base_info['principal_name'],
                    'ac_func_scope'     => json_encode($has_func),
                    'ac_signature'      => $base_info['signature'],
                );
                $updata = array_merge($updata, $basedata);

                if ($exists) {
                    $child_model->updateById($updata, $exists['ac_id']);
                } else {
                    $surplus    = $output['ac_insert_total']-$output['ac_insert_use'];
                    if ($surplus > 0) {
                        $child_model->insertValue($updata);
                        //新授权已用数量+1
                        $wcfg_storage->incrementInsertUse(1);
                    } else {
                        plum_redirect_with_msg("您目前可授权接入的分身小程序数量为0,请联系您的服务商已增加更多可授权分身小程序数量。", $redirect_url);
                    }
                }
                //授权成功后修改域名
                $server_domain  = plum_parse_config('server', 'wxxcx');
                $wxxcx_client   = new App_Plugin_Weixin_WxxcxChild($output['sid'], $info['authorizer_appid']);
                $domain         = isset($server_domain[$wx_cfg['ac_type']]) ? $server_domain[$wx_cfg['ac_type']]['domain'] : plum_parse_config('domain', 'wxxcx');
                Libs_Log_Logger::outputLog($domain);
                $wxxcx_client->coverCodeDomain($domain['req'], $domain['wss'], $domain['upl'], $domain['dow']);

                //检测授权权限,便于信息提示
                $func_scope = plum_parse_config('func_scope', 'applet');
                $not_func   = array_diff(array_keys($func_scope), $has_func);
                if (!empty($not_func)) {
                    $msg    = "小程序{$info['authorizer_appid']}授权成功<br>";
                    foreach ($not_func as $func) {
                        $msg .= "{$func_scope[$func]['name']}未授权, {$func_scope[$func]['desc']}<br>";
                    }
                    plum_redirect_with_msg($msg, $redirect_url, 6);
                } else {
                    plum_redirect_with_msg("小程序{$info['authorizer_appid']}授权成功", $redirect_url);
                }
            }
        }
        plum_redirect_with_msg("授权失败，请重试", $redirect_url);
    }
    /*
     * 公众号授权中心
     */
    public function wxCenterAction() {
        $loginid    = $this->request->getStrParam('loginid');
        $loginid    = rawurldecode($loginid);
        $token      = plum_parse_config('encode_token', 'wxxcx');
        $decode     = plum_authcode($loginid, 'DECODE', $token);
        parse_str($decode, $output);

        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage();
        $token  = $plat_storage->getCompAccessToken();

        $plat_cfg   = plum_parse_config('platform', 'weixin');

        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$token}";
        $params     = array('component_appid' => $plat_cfg['app_id']);

        $i = 0;
        do{
            $result     = Libs_Http_Client::post($req_url, json_encode($params));
            $result     = json_decode($result, true);
            $i++;
        } while (!$result && $i < 10);

        $callback   = "http://{$output['domain']}/manage/user/wxAuthuri?loginid=".base64_encode($loginid);
        $auth       = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$plat_cfg['app_id']}&pre_auth_code={$result['pre_auth_code']}&redirect_uri={$callback}";

        $this->output['auth_uri']   = $auth ? $auth : '#';

        $this->displaySmarty('wxapp/wxxcx-auth.tpl');
    }
    /*
     * 公众号授权回调
     */
    public function wxAuthuriAction() {
        $loginid    = $this->request->getStrParam('loginid');
        $token      = plum_parse_config('encode_token', 'wxxcx');
        $decode     = plum_authcode(base64_decode($loginid), 'DECODE', $token);
        parse_str($decode, $output);
        $redirect_url   = $output['from'].'/wxapp/currency/wxcard';
        //获取当前店铺的微信配置
        $wcfg_storage   = new App_Model_Auth_MysqlWeixinStorage();
        $wx_cfg     = $wcfg_storage->findWeixinBySid($output['sid']);

        $auth_code  = $this->request->getStrParam('auth_code');
        $expires    = $this->request->getIntParam('expires_in');

        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage();
        $token  = $plat_storage->getCompAccessToken();
        $plat_cfg   = plum_parse_config('platform', 'weixin');

        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token={$token}";
        $params     = array(
            'component_appid'   => $plat_cfg['app_id'],
            'authorization_code'=> $auth_code,
        );

        $result     = Libs_Http_Client::post($req_url, json_encode($params));
        $result     = json_decode($result, true);

        if ($result && isset($result['authorization_info'])) {
            $info   = $result['authorization_info'];
            //重新授权时，必须是已授权的相同公众号
            if (!empty($wx_cfg) && $wx_cfg['wc_app_id'] && $wx_cfg['wc_app_id'] != $info['authorizer_appid']) {
                plum_redirect_with_msg("店铺已授权到公众号{$wx_cfg['wc_app_id']}，无法授权给新公众号", $redirect_url);
            }
            //新授权时，需要判断当前公众号是否已在其他店铺授权
            if (empty($wx_cfg) || !$wx_cfg['wc_app_id']) {
                $exists = $wcfg_storage->fetchUpdateWxcfgByAid($info['authorizer_appid']);
                if ($exists) {
                    plum_redirect_with_msg("公众号{$info['authorizer_appid']}已被其他店铺授权，无法重复授权", $redirect_url);
                }
            }

            $updata = array(
                'wc_app_id'         => $info['authorizer_appid'],
                'wc_auth_access_token'  => $info['authorizer_access_token'],
                'wc_auth_expire_time'   => $info['expires_in']+time()-20,//防止请求时间过长
                'wc_auth_refresh_token' => $info['authorizer_refresh_token'],
                'wc_auth_status'        => 1,//设置为平台授权
            );
            //获取公众号基本信息
            $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token={$token}";
            $params     = array(
                'component_appid'       => $plat_cfg['app_id'],
                'authorizer_appid'      => $info['authorizer_appid'],
            );

            $ret    = Libs_Http_Client::post($req_url, json_encode($params));
            $ret    = json_decode($ret, true);
            if ($ret && isset($ret['authorizer_info'])) {
                $base_info  = $ret['authorizer_info'];

                //存储公众号二维码图片
                $img_data   = file_get_contents($base_info['qrcode_url']);
                $img        = imagecreatefromstring($img_data);
                $filename   = plum_uniqid_base36(true).".jpg";
                imagejpeg($img, PLUM_APP_BUILD."/".$filename);

                $basedata   = array(
                    'wc_app_no'         => $base_info['alias'],
                    'wc_gh_id'          => $base_info['user_name'],
                    'wc_service_type'   => $base_info['service_type_info']['id'],
                    'wc_verify_type'    => $base_info['verify_type_info']['id'],
                    'wc_name'           => $base_info['nick_name'],
                    'wc_avatar'         => $base_info['head_img'],
                    'wc_qrcode'         => '/public/build/'.$filename,
                );
                $updata = array_merge($updata, $basedata);
                //配置不存在时,插入新数据
                if (empty($wx_cfg)) {
                    $updata['wc_s_id']  = $output['sid'];
                    $updata['wc_c_id']  = 0;//@todo 公司ID信息
                    $wcfg_storage->insertValue($updata);
                } else {//存在时,更新数据
                    $wcfg_storage->updateBySId($updata, $output['sid']);
                }

                //检测授权权限,便于信息提示
                $func_scope = plum_parse_config('func_scope', 'weixin');

                $has_func   = array();
                foreach ($info['func_info'] as $category) {
                    $has_func[] = $category['funcscope_category']['id'];
                }
                $not_func   = array_diff(array_keys($func_scope), $has_func);
                if (!empty($not_func)) {
                    $msg    = "公众号{$info['authorizer_appid']}授权成功<br>";
                    foreach ($not_func as $func) {
                        $msg .= "{$func_scope[$func]['name']}未授权, {$func_scope[$func]['desc']}<br>";
                    }
                    plum_redirect_with_msg($msg, $redirect_url, 6);
                } else {
                    plum_redirect_with_msg("公众号{$info['authorizer_appid']}授权成功", $redirect_url);
                }
            }
        }
        plum_redirect_with_msg("授权失败，请重试", $redirect_url);
    }

    /*
   *获取小程序是否授权过
   */
    private function _applet_is_auth($sid,$type=1){
        $auth_storage = new App_Model_Applet_MysqlAppletAuthRecordStorage($sid);
        return $auth_storage->findRecordBySid($type);
    }

    /*
     * 保存授权信息
     */
    private function _save_applet_auth($sid,$appid,$name,$type=1){
        $data = array(
            'aar_s_id'        => $sid,
            'arr_appid'       => $appid,
            'arr_name'        => $name,
            'arr_create_time' => time()
        );
        $auth_storage = new App_Model_Applet_MysqlAppletAuthRecordStorage($sid);
        return $auth_storage->insertValue($data);
    }

    /*
     * 支付宝授权引导页面
     */
    public function alixcxGrantAuthAction() {
        $loginid    = $this->request->getStrParam('loginid');
        $suid       = $this->request->getStrParam('suid');
        //支付宝小程序授权拼装
        $alixcx_conf    = plum_parse_config('third_app', 'alixcx');
        $redirect_uri = 'https://www.tiandiantong.com/manage/user/alixcx?loginid='.base64_encode($loginid);

        $request_url = 'https://openauth.alipay.com/oauth2/appToAppBatchAuth.htm?app_id='.$alixcx_conf['app_id'].'&application_type=TINYAPP&redirect_uri='.$redirect_uri;
        $this->output['auth_uri']   = $request_url;
        $this->output['suid']   = $suid;
        $this->output['loginid']   = base64_encode($loginid);
        //输出二维码图片
        //Libs_Qrcode_QRCode::png($request_url);
        $this->displaySmarty('wxapp/setup/alixcx-bangding.tpl');
    }

    /*
     * 支付宝小程序授权回调
     * @link https://docs.alipay.com/isv/10467/xldcyq
     */
    public function alixcxAction() {
        $auth_code  = $this->request->getStrParam('app_auth_code');
        $loginid    = $this->request->getStrParam('loginid');
        $decode     = plum_authcode(rawurldecode(base64_decode($loginid)), 'DECODE');
        parse_str($decode, $output);

        $redirect_url   = '/mobile/index/alixcxAuthSuccess';
        //获取当前店铺的支付宝配置
        $wcfg_storage   = new App_Model_Alixcx_MysqlAlixcxCfgStorage($output['sid']);
        $wx_cfg     = $wcfg_storage->findShopCfg();
        $alixcx_client  = new App_Plugin_Alixcx_XcxClient($output['sid']);
        $result  = $alixcx_client->getAuthToken($auth_code);
        if ($result && !$result['errcode'] && $result['code']==10000) {   //授权成功
            $info   = $result['tokens'][0];
            //重新授权时，必须是已授权的相同小程序
            if (!empty($wx_cfg) && $wx_cfg['ac_appid'] && $wx_cfg['ac_appid'] != $info['auth_app_id']) {
                //$shop_name = $this->shopIdArray[$this->curr_sid]['s_name'];
                plum_redirect_with_msg("系统已授权到小程序{$wx_cfg['ac_appid']}，无法授权给新的小程序", $redirect_url."?msg=授权失败&reason=系统已授权到小程序{$wx_cfg['ac_appid']}，无法授权给新的小程序");
            }
            //新授权时，需要判断当前公众号是否已在其他店铺授权
            if (!empty($wx_cfg) && !$wx_cfg['ac_appid']) {
                $exists = $wcfg_storage->fetchUpdateWxcfgByAid($info['auth_app_id']);
                if ($exists) {
                    plum_redirect_with_msg("小程序{$info['auth_app_id']}已被系统其他用户授权，无法重复授权", $redirect_url."?msg=授权失败&reason=小程序{$info['auth_app_id']}已被系统其他用户授权，无法重复授权");
                }
                //判断小程序是否在子程序账号中授权
                $child_model    = new App_Model_Applet_MysqlChildStorage($output['sid']);
                $exists = $child_model->fetchUpdateWxcfgByAid($info['auth_app_id']);
                if ($exists) {
                    plum_redirect_with_msg("小程序{$info['auth_app_id']}已在系统子程序中授权，请解除授权后, 可以再次授权", $redirect_url."?msg=授权失败&reason=小程序{$info['auth_app_id']}已在系统子程序中授权，请解除授权后, 可以再次授权");
                }
            }

            $updata = array(
                'ac_appid'              => $info['auth_app_id'],
                'ac_auth_access_token'  => $info['app_auth_token'],
                'ac_auth_expire_time'   => $info['expires_in']+time()-20,//防止请求时间过长
                'ac_auth_refresh_token' => $info['app_refresh_token'],
                'ac_auth_status'        => 1,//设置为平台授权
            );
            // 获取小程序的基本信息
            $appinfo = $alixcx_client->queryMiniBaseInfo();
            if($appinfo && $appinfo['code']==10000){
                $basedata   = array(
                    'ac_name'           => $appinfo['app_name'],
                    'ac_avatar'         => $appinfo['app_logo'],
                    'ac_domain_time'    => time(),
                    'ac_category'       => $appinfo['category_names'],
                    'ac_signature'      => $appinfo['app_desc'],
                );
                $updata = array_merge($updata, $basedata);
            }

            $ret = $wcfg_storage->findShopCfg($updata);
            if($ret){
                $auth = $this->_applet_is_auth($output['sid'],3);   //获取是否授权过
                if(!$auth && !$wx_cfg['ac_domain_time'] && !$wx_cfg['ac_func_scope']){    //未授权过
                    $updata['ac_expire_time'] = $wx_cfg['ac_expire_time']+(time()-$wx_cfg['ac_open_time']);  //给用户补偿未授权消耗的时间
                }
                //授权成功后记录授权信息
                $this->_save_applet_auth($output['sid'],$info['auth_app_id'],'',3);
                plum_redirect_with_msg("小程序{$info['auth_app_id']}授权成功", $redirect_url."?msg=授权成功&name={$basedata["ac_name"]}&avatar={$basedata["ac_avatar"]}");
            }else{
                // 数据回入失败造成的授权未成功
                plum_redirect_with_msg("授权失败，请重试",$redirect_url."?msg=授权失败&reason=数据写入出错");
            }
        }
        // 授权过程中产生的错误信息
        plum_redirect_with_msg("授权失败，请重试",$redirect_url."?msg=授权失败&reason={$result['errmsg']}");
    }

    /*
     * 查下授权小程序是否已授权
     */
    public function authSuccessAction(){
        //获取当前店铺的微信配置
        $suid = $this->request->getStrParam('suid');
        $loginid    = $this->request->getStrParam('loginid');
        $decode     = plum_authcode(rawurldecode(base64_decode($loginid)), 'DECODE');
        parse_str($decode, $output);
        if($suid){
            $alixcx_storage = new App_Model_Alixcx_MysqlAlixcxCfgStorage();
            $alixcx_cfg     = $alixcx_storage->getAppletShopCfgBySuid($suid);
            if($alixcx_cfg && $alixcx_cfg['ac_auth_status']==1 && $alixcx_cfg['ac_auth_access_token']){
                $redirect_url = '/alixcx/index?menuType=aliapp';
                $this->displayJsonSuccess(array('msg'=>'授权成功','url'=>$output['from'].$redirect_url));
            }else{
                $this->displayJsonError('授权失败，请稍后重试');
            }
        }else{
             $this->displayJsonError('授权失败，请稍后重试');
        }

    }

}