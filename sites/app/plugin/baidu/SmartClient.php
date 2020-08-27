<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/10/11
 * Time: 下午3:21
 */
class App_Plugin_Baidu_SmartClient {

    public $access_token = null;

    const BAIDU_AUTH_NONE  = 0;//未授权
    const BAIDU_AUTH_WRITE = 1;//填写方式授权百度小程序
    const BAIDU_AUTH_OPEN  = 2;//开放平台方式授权百度小程序
    // 店铺id
    public $sid;
    /*
    * 小程序配置,参考pre_applet_baidu_cfg
    */
    public $baidu_cfg;
    /*
     * 当前小程序平台类型
     */
    public $platform_type;
    /*
     * 手工填写方式的授权，无法调用以下接口函数
     */
    public function __construct($sid, $access_token = null){
        $this->sid = $sid;
        $this->_fetch_access_token($access_token);
    }
    /*
     * 检查访问token
     */
    private function _check_token() {

    }
    /*
     * 获取有效的访问token
     */
    private function _fetch_access_token($access_token) {
        if(!is_null($access_token)){
            $this->access_token = $access_token;
        }else{
            $auth_type  = self::baiduAuthType($this->sid);
            //根据店铺id获取access token
            $baidu_storage = new App_Model_Baidu_MysqlBaiduCfgStorage($this->sid);
            $baidu         = $baidu_storage->findShopCfg();
            $category       = plum_parse_config('category', 'baidu');
            $applet_type    = intval($baidu['ac_type']);
            $this->platform_type    = $category[$applet_type]['platform'];

            switch ($auth_type) {
                //未授权
                case self::BAIDU_AUTH_NONE :
                    trigger_error('店铺绑定的百度小程序未设置，请核实！sid=='.$this->sid, E_USER_WARNING);
                    break;
                //自定义填写
                case self::BAIDU_AUTH_WRITE :
                    if ($baidu['ac_expires_in'] > time()) {
                        //未失效
                        $this->access_token = $baidu['ac_access_token'];
                    } else {
                        $url    = 'https://openapi.baidu.com/oauth/2.0/token';
                        $params = array(
                            'grant_type'    => 'client_credentials',
                            'client_id'     => $baidu['ac_appkey'],
                            'client_secret' => $baidu['ac_appsecret'],
                            'scope'         => 'smartapp_snsapi_base'
                        );
                        $result = Libs_Http_Client::post($url, $params);
                        $result = json_decode($result, true);

                        if (isset($result['access_token'])) {
                            $updata = array(
                                'ac_access_token'       => $result['access_token'],
                                'ac_expires_in'         => time()+(int)$result['expires_in'] - 20,
                            );
                            $baidu_storage->updateById($updata, $baidu['ac_id']);
                            $this->access_token = $result['access_token'];
                        } else {
                            Libs_Log_Logger::outputLog($result);
                            trigger_error('百度小程序开发者，用户自定义填写，access token获取失败。sid=='.$this->sid, E_USER_ERROR);
                        }
                    }
                    $this->baidu_cfg   = $baidu;
                    break;
                //开放平台授权
                case self::BAIDU_AUTH_OPEN :
                    if ($baidu['ac_auth_expire_time'] > time()) {
                        $this->access_token = $baidu['ac_auth_access_token'];
                    } else {
                        //失效token重新获取
                        $client = new App_Plugin_Baidu_ThirdPlatform($this->platform_type);
                        $result = $client->refreshAccessToken($this->baidu_cfg['ac_auth_refresh_token']);

                        if (!$result['errcode']) {
                            $updata     = array(
                                'ac_auth_access_token'      => $result['data']['access_token'],
                                'ac_auth_expire_time'       => time()+(int)$result['data']['expires_in'] - 20,
                                'ac_auth_refresh_token'     => $result['data']['refresh_token'],
                            );
                            $baidu_storage->findShopCfg($updata);
                            $this->access_token     = $result['data']['access_token'];
                        } else {
                            Libs_Log_Logger::outputLog($result);
                            $this->access_token = null;
                            //刷新令牌一旦丢失或失效,只能让用户重新授权,才能再次拿到新的刷新令牌
                            //设置当前状态为未授权
                            //trigger_error('百度开放平台，refresh token令牌被复用。sid=='.$this->sid.json_encode(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT)), E_USER_ERROR);
                        }
                    }
                    $this->baidu_cfg   = $baidu;
                    break;
            }
        }
    }
    /*
     * 检查授权token情况
     */
    public function checkAuthToken() {
        $type   = self::baiduAuthType($this->sid);
        $return = false;
        if ($type == self::BAIDU_AUTH_OPEN) {//开放平台授权
            if (is_null($this->access_token)) {
                //失效token重新获取
                $client = new App_Plugin_Baidu_ThirdPlatform($this->platform_type);
                $result = $client->refreshAccessToken($this->baidu_cfg['ac_auth_refresh_token']);

                Libs_Log_Logger::outputLog($result, 'ele.log');
                if (!$result['errcode']) {
                    $baidu_storage = new App_Model_Baidu_MysqlBaiduCfgStorage($this->sid);
                    $updata     = array(
                        'ac_auth_access_token'      => $result['data']['access_token'],
                        'ac_auth_expire_time'       => time()+(int)$result['data']['expires_in'] - 20,
                        'ac_auth_refresh_token'     => $result['data']['refresh_token'],
                    );
                    $baidu_storage->findShopCfg($updata);
                    $return     = $result['data']['access_token'];
                } else {

                    //刷新令牌一旦丢失或失效,只能让用户重新授权,才能再次拿到新的刷新令牌
                    //设置当前状态为未授权
                    //trigger_error('百度开放平台，refresh token令牌被复用。sid=='.$this->sid.json_encode(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT)), E_USER_ERROR);
                }
            } else {
                $return = $this->access_token;
            }
        }
        return $return;
    }

    /*
     * 获取店铺百度授权方式,0未授权,1手工填写,2开放平台
     */
    public static function baiduAuthType($sid) {
        $baidu_storage = new App_Model_Baidu_MysqlBaiduCfgStorage($sid);
        $baidu         = $baidu_storage->findShopCfg();

        if (!$baidu || !$baidu['ac_appid']) {
            return self::BAIDU_AUTH_NONE;
        }

        if ($baidu['ac_auth_status'] && $baidu['ac_auth_access_token']) {
            return self::BAIDU_AUTH_OPEN;
        }

        if (strlen($baidu['ac_appid']) == 8 && strlen($baidu['ac_appsecret']) == 32) {
            return self::BAIDU_AUTH_WRITE;
        }

        return self::BAIDU_AUTH_NONE;
    }
/*******************参考链接@link https://smartprogram.baidu.com/docs/develop/third/apppage/ ***************************/
    /*
     * 为授权的小程序上传代码
     * @link https://smartprogram.baidu.com/docs/develop/third/apppage/
     */
    public function uploadCode($tpl_id, $ext, $version, $desc) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/package/upload";
        $params     = array(
            'access_token'      => $this->access_token,
            'template_id'       => $tpl_id,
            'ext_json'          => is_string($ext) ? $ext : json_encode($ext),
            'user_version'      => $version,
            'user_desc'         => $desc,
        );
        $result = Libs_Http_Client::post($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 提交授权小程序审核
     */
    public function submitAudit($content, $pkg_id, $remark) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/package/submitaudit";
        $params     = array(
            'access_token'      => $this->access_token,
            'content'           => $content,
            'package_id'        => $pkg_id,
            'remark'            => $remark,
        );
        $result = Libs_Http_Client::post($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 发布上线
     */
    public function releaseApp($pkg_id) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/package/release";
        $params     = array(
            'access_token'      => $this->access_token,
            'package_id'        => $pkg_id,
        );
        $result = Libs_Http_Client::post($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 小程序版本回退
     */
    public function rollbackApp($pkg_id) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/package/rollback";
        $params     = array(
            'access_token'      => $this->access_token,
            'package_id'        => $pkg_id,
        );
        $result = Libs_Http_Client::post($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 撤回审核版本
     */
    public function revokeAudit($pkg_id) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/package/withdraw";
        $params     = array(
            'access_token'      => $this->access_token,
            'package_id'        => $pkg_id,
        );
        $result = Libs_Http_Client::post($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 获取授权小程序预览包详情
     */
    public function getPreviewPackage() {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/package/gettrial";
        $params     = array(
            'access_token'      => $this->access_token,
        );
        $result = Libs_Http_Client::get($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 获取小程序包列表
     */
    public function getPackageList() {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/package/get";
        $params     = array(
            'access_token'      => $this->access_token,
        );
        $result = Libs_Http_Client::get($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 获取授权小程序包详情
     */
    public function getPackageDetail($type = null, $pkg_id = 0) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/package/getdetail";
        $params     = array(
            'access_token'      => $this->access_token,
            'type'              => $type,
            'package_id'        => $pkg_id,
        );
        if (is_null($type)) {
            unset($params['type']);
        }
        if (!$pkg_id) {
            unset($params['package_id']);
        }
        $result = Libs_Http_Client::get($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
/*******************参考链接@link https://smartprogram.baidu.com/docs/develop/third/apppage/ ***************************/
    /*
     * 获取小程序类目列表
     */
    public function getCategoryList() {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/app/category/list";
        $params     = array(
            'access_token'      => $this->access_token,
            'category_type'     => 2,
        );
        $result = Libs_Http_Client::get($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 获取小程序体验二维码
     */
    public function getTestQrcode($pkg_id = 0) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/app/qrcode";
        $params     = array(
            'access_token'      => $this->access_token,
            'package_id'        => $pkg_id,
        );
        if (!$pkg_id) {
            unset($params['package_id']);
        }

        Libs_Log_Logger::outputLog($params, 'ele.log');
        $result = Libs_Http_Client::get($req_url, $params);

        $retjson    = json_decode($result, true);
        if ($retjson && is_array($retjson) && isset($retjson['errno'])) {
            return $this->_format_response_output($retjson);
        } else {
            return $result;
        }
    }
    /*
     * 小程序图片上传
     * @link https://smartprogram.baidu.com/docs/develop/third/upload/
     */
    public function uploadImage($file_path) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/upload/image";
        $params     = array(
            'access_token'      => $this->access_token,
        );

        $result = Libs_Http_Client::postFiles($req_url, $file_path, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 小程序授权登录
     * @link https://smartprogram.baidu.com/docs/develop/third/login/
     */
    public function oauthLogin($code) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/oauth/getsessionkeybycode";
        $params     = array(
            'access_token'      => $this->access_token,
            'code'              => $code,
            'grant_type'        => 'authorization_code'
        );
        $result = Libs_Http_Client::get($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 获取小程序的基础信息
     * @link https://smartprogram.baidu.com/docs/develop/third/pro/
     */
    public function getAppInfo() {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/app/info";
        $params     = array(
            'access_token'      => $this->access_token,
        );
        $result = Libs_Http_Client::get($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
/*******************参考链接@link https://smartprogram.baidu.com/docs/develop/third/address/ ***************************/
    /*
     * 设置小程序服务器域名
     * @param string $action add,delete,set,get
     * @param mixed $req,$wss,$upl,$dow 字符串或数组
     */
    public function modifyReqDomain($action = 'add', $req = null, $wss = null, $upl = null, $dow = null) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/app/modifydomain";
        $total      = array('add', 'delete', 'set', 'get');
        $action     = in_array($action, $total) ? $action : 'get';
        $params     = array(
            'access_token'      => $this->access_token,
            'action'            => $action,
        );
        array_pop($total);
        if (in_array($action, $total)) {
            $req = is_array($req) ? implode(',', $req) : trim(strval($req));
            $wss = is_array($wss) ? implode(',', $wss) : trim(strval($wss));
            $upl = is_array($upl) ? implode(',', $upl) : trim(strval($upl));
            $dow = is_array($dow) ? implode(',', $dow) : trim(strval($dow));

            strlen($req) == 0 ? : $params['request_domain'] = $req;
            strlen($wss) == 0 ? : $params['socket_domain']  = $wss;
            strlen($upl) == 0 ? : $params['download_domain']= $upl;
            strlen($dow) == 0 ? : $params['upload_domain']  = $dow;
        }
        $result = Libs_Http_Client::post($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 设置小程序业务域名
     * @param string $action add,delete,set,get
     * @param mixed $web 字符串或数组
     */
    public function modifyWebDomain($action = 'add', $web = null) {
        $this->_check_token();
        $req_url    = "https://openapi.baidu.com/rest/2.0/smartapp/app/modifywebviewdomain";
        $total      = array('add', 'delete', 'set', 'get');
        $action     = in_array($action, $total) ? $action : 'get';
        $params     = array(
            'access_token'      => $this->access_token,
            'action'            => $action,
        );
        array_pop($total);
        if (in_array($action, $total)) {
            $req = is_array($web) ? implode(',', $web) : trim(strval($web));

            $params['web_view_domain'] = $req;
        }
        $result = Libs_Http_Client::post($req_url, $params);
        $result = json_decode($result, true);

        return $this->_format_response_output($result);
    }
    /*
     * 对输出结果进行格式化处理
     * @link https://smartprogram.baidu.com/docs/develop/third/error/
     */
    private function _format_response_output($res) {
        Libs_Log_Logger::outputLog($res, 'ele.log');
        $code   = array();

        if (isset($res['error']) || $res['errno'] != 0) {//errno != 0
            $code['errcode']    = isset($res['error']) ? $res['error'] : $res['errno'];
            $code['errmsg']     = isset($res['error_description']) ? $res['error_description'] : $res['msg'];
        } else {
            $code['errcode']    = 0;
            $code['errmsg']     = '获取成功';
            $code['data']       = isset($res['data']) ? $res['data'] : (isset($res['errno']) ? null : $res);
        }

        return $code;
    }
}