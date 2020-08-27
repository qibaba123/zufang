<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/1
 * Time: 上午9:23
 */

class App_Plugin_Weixin_ClientPlugin {

    const WEIXIN_OPENID_LENGTH = 28;//微信openID长度

    const WEIXIN_AUTH_NONE  = 0;//未授权微信公众号
    const WEIXIN_AUTH_WRITE = 1;//填写方式授权微信公众号
    const WEIXIN_AUTH_OPEN  = 2;//开发平台方式授权微信公众号

    /*
     * 店铺ID
     */
    public $sid;
    /*
     * 微信配置数据，字段名参考表pre_weixin_cfg
     */
    public $weixin;
    /*
     * 微信访问token
     */
    public $access_token   = null;

    private $set_key    = array(1);

    public function __construct($sid) {
        $this->sid = $sid;
        $this->_fetch_access_token();
    }
    /*
     * 获取店铺微信授权方式,0未授权,1手工填写,2开放平台
     */
    public static function weixinAuthType($sid) {
        $weixin_storage = new App_Model_Auth_MysqlWeixinStorage();
        $weixin         = $weixin_storage->findWeixinBySid($sid);
        if (!$weixin || !$weixin['wc_app_id']) {
            return self::WEIXIN_AUTH_NONE;
        }

        if ($weixin['wc_auth_status'] && $weixin['wc_auth_access_token']) {
            return self::WEIXIN_AUTH_OPEN;
        }

        if (strlen($weixin['wc_app_id']) == 18 && strlen($weixin['wc_app_secret']) == 32) {
            return self::WEIXIN_AUTH_WRITE;
        }

        return self::WEIXIN_AUTH_NONE;
    }

    /*
     * 获取授权认证的访问token,不再支持填写方式访问token
     */
    private function _fetch_auth_access_token() {
        //根据店铺id获取access token
        $weixin_storage = new App_Model_Auth_MysqlWeixinStorage();
        $weixin         = $weixin_storage->findWeixinBySid($this->sid);
        //未授权账号,发送通知邮件
        if (!$weixin || !$weixin['wc_auth_status']) {
            Libs_Log_Logger::outputLog($weixin);
        } else {
            if ($weixin['wc_auth_expire_time'] > time()) {
                $this->access_token     = $weixin['wc_auth_access_token'];
            } else {
                //失效token重新获取
                $plat_cfg   = plum_parse_config('platform', 'weixin');
                $plat_redis = new App_Model_Auth_RedisWeixinPlatformStorage();
                $token  = $plat_redis->getCompAccessToken();
                $url    = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token={$token}";

                $params = array(
                    'component_appid'       => $plat_cfg['app_id'],
                    'authorizer_appid'      => $weixin['wc_app_id'],
                    'authorizer_refresh_token'  => $weixin['wc_auth_refresh_token'],
                );
                $result     = Libs_Http_Client::post($url, json_encode($params));
                $result     = json_decode($result, true);

                if (isset($result['authorizer_access_token'])) {
                    $updata     = array(
                        'wc_auth_access_token'      => $result['authorizer_access_token'],
                        'wc_auth_expire_time'       => time()+(int)$result['expires_in'],
                        'wc_auth_refresh_token'     => $result['authorizer_refresh_token'],
                    );
                    $weixin_storage->updateById($updata, $weixin['wc_id']);
                    $this->access_token     = $result['authorizer_access_token'];
                } else {
                    trigger_error('微信开发者，公众号授权，access token获取失败。sid=='.$this->sid."error=".json_encode($result), E_USER_ERROR);
                }
            }
            $this->weixin   = $weixin;
        }
    }

    /*
     * 获取或更新access token
     */
    private function _fetch_access_token() {
        $auth_type  = self::weixinAuthType($this->sid);
        //根据店铺id获取access token
        $weixin_storage = new App_Model_Auth_MysqlWeixinStorage();
        $weixin         = $weixin_storage->findWeixinBySid($this->sid);
        switch ($auth_type) {
            case self::WEIXIN_AUTH_NONE :
                trigger_error('店铺绑定的微信账号未设置，请核实！sid=='.$this->sid, E_USER_WARNING);
                break;
            case self::WEIXIN_AUTH_WRITE :
                if ($weixin['wc_token_expire'] > time()) {
                    //未失效
                    $this->access_token = $weixin['wc_access_token'];
                } else {
                    $url    = 'https://api.weixin.qq.com/cgi-bin/token';
                    $params = array(
                        'grant_type'    => 'client_credential',
                        'appid'         => $weixin['wc_app_id'],
                        'secret'        => $weixin['wc_app_secret'],
                    );
                    $result = Libs_Http_Client::get($url, $params);
                    $result = json_decode($result, true);

                    if (isset($result['access_token'])) {
                        $updata = array(
                            'wc_access_token'     => $result['access_token'],
                            'wc_token_expire'     => time()+(int)$result['expires_in'],
                        );
                        $weixin_storage->updateById($updata, $weixin['wc_id']);
                        $this->access_token = $result['access_token'];
                    } else {
                        //trigger_error('微信开发者，用户自定义填写，access token获取失败。sid=='.$this->sid, E_USER_ERROR);
                    }
                }
                $this->weixin   = $weixin;
                break;
            case self::WEIXIN_AUTH_OPEN :
                if ($weixin['wc_auth_expire_time'] > time()) {
                    $this->access_token     = $weixin['wc_auth_access_token'];
                } else {
                    //失效token重新获取
                    $plat_cfg   = plum_parse_config('platform', 'weixin');
                    $plat_redis = new App_Model_Auth_RedisWeixinPlatformStorage();
                    $token  = $plat_redis->getCompAccessToken();
                    $url    = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token={$token}";

                    $params = array(
                        'component_appid'       => $plat_cfg['app_id'],
                        'authorizer_appid'      => $weixin['wc_app_id'],
                        'authorizer_refresh_token'  => $weixin['wc_auth_refresh_token'],
                    );
                    $result     = Libs_Http_Client::post($url, json_encode($params));
                    $result     = json_decode($result, true);
                    Libs_Log_Logger::outputLog($result);
                    if (isset($result['authorizer_access_token'])) {
                        $updata     = array(
                            'wc_auth_access_token'      => $result['authorizer_access_token'],
                            'wc_auth_expire_time'       => time()+(int)$result['expires_in'],
                            'wc_auth_refresh_token'     => $result['authorizer_refresh_token'],
                        );
                        $weixin_storage->updateById($updata, $weixin['wc_id']);
                        $this->access_token     = $result['authorizer_access_token'];
                    } else {
                        //刷新令牌一旦丢失或失效,只能让用户重新授权,才能再次拿到新的刷新令牌
                        Libs_Log_Logger::outputLog($result);
                    }
                }
                $this->weixin   = $weixin;
                break;
        }
    }

    /*
     * 获取数字类型的场景二维码
     * 永久二维码最大值100000
     */
    public function fetchSpreadQrcode($uid, $forever = false) {
        if (!$this->access_token) {
            return false;
        }
        $url            = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$this->access_token}";

        $params = array(
            'action_info'       => array(
                'scene'     => array(
                    'scene_id'  => $uid
                ),
            ),
        );
        //生成永久二维码
        if ($forever) {
            $params['action_name']      = "QR_LIMIT_SCENE";
        } else {
            $expire_long    = 2592000;//最大失效时长，30天
            $params['expire_seconds']   = $expire_long;
            $params['action_name']      = "QR_SCENE";
        }
        $result = Libs_Http_Client::post($url, json_encode($params));
        return json_decode($result, true);
    }
    /*
     * 获取字符串类型的场景二维码
     */
    public function fetchSecnestrQrcode($str) {
        if (!$this->access_token) {
            return false;
        }
        $url            = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$this->access_token}";
        //生成永久字符串类型二维码
        $params = array(
            'action_name'   => 'QR_LIMIT_STR_SCENE',
            'action_info'   => array(
                'scene' => array(
                    'scene_str'  => $str
                ),
            ),
        );
        $result = Libs_Http_Client::post($url, json_encode($params));
        return json_decode($result, true);
    }

    /*
     * 获取小程序场景二维码
     */
    public function fetchWxappSecnestrQrcode($str) {
        if (!$this->access_token) {
            return false;
        }
        $url            = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token={$this->access_token}";
        //生成永久字符串类型二维码
        $params = array(
            'scene' => $str,
            'page'  => "pages/index/index"
        );
        $result = Libs_Http_Client::post($url, json_encode($params));
        return json_decode($result, true);
    }

    /*
     * 客服接口发送图片信息
     */
    public function sendImageMessage($toUser, $imgPath) {
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
        $result = Libs_Http_Client::post($url,array(),$fields);
        $result = json_decode($result, true);
        if (!isset($result['media_id'])) {
             return false;
        }

        //
        $body   = array(
            "touser"    => $toUser,
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
     * 客服接口发送跳转到外链的图文消息
     * 微信认证的订阅号、服务号可用
     */
    public function sendLinkNewsMessage($toUser, $article) {
        if (!$this->access_token) {
            return false;
        }
        $body   = array(
            "touser"    => $toUser,
            "msgtype"   => "news",
            "news"     => array("articles" => $article),
        );

        $send_url   = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($body, JSON_UNESCAPED_UNICODE));
        return $result;
    }

    /*
     * 客服接口发送文本信息
     * 微信认证的订阅号、服务号可用
     */
    public function sendTextMessage($toUser, $content) {
        if (!$this->access_token) {
            return false;
        }
        $body   = array(
            "touser"    => $toUser,
            "msgtype"   => "text",
            "text"     => array("content" => $content),
        );

        $send_url   = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->access_token}";

        $result     = Libs_Http_Client::post($send_url, json_encode($body, JSON_UNESCAPED_UNICODE));
        return $result;
    }

    /*
     * 上传图片素材
     */
    public function addImageMedia($imgPath) {
        if (!$this->access_token) {
            return false;
        }
        $imgPath    = PLUM_DIR_ROOT.$imgPath;//绝对路径
        if (!file_exists($imgPath)) {
            return false;
        }
        //上传图片素材
        $url    = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token={$this->access_token}";

        $fields	=	array("buffer" => $imgPath);
        $result = Libs_Http_Client::post($url, array(), $fields);
        $result = json_decode($result, true);

        if (!isset($result['url'])) {
            return false;
        }

        return $result;
    }
    /*
     * 添加永久性图片素材
     * @param string $img_path  图片的相对路径地址
     * @return bool|array array('media_id', 'url')
     */
    public function addImageMaterial($img_path) {
        $url    = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token={$this->access_token}&type=image";

        $fields	=	array("media" => PLUM_DIR_ROOT.$img_path);
        $result = Libs_Http_Client::post($url,array(), $fields);
        $result = json_decode($result, true);
        if (!isset($result['media_id'])) {
            return false;
        }

        return $result;
    }

    /*
     * 获取用户基本信息
     * 微信认证的订阅号、服务号可用
     */
    public function fetchUserInfo($openid) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/user/info";

        $params = array(
            'access_token'  => $this->access_token,
            'openid'        => $openid,
            'lang'          => 'zh_CN',
        );

        $result = Libs_Http_Client::get($url, $params);
        $result = json_decode($result, true);

        if (isset($result['errcode'])) {
            //产生错误
            Libs_Log_Logger::outputLog($result);
            Libs_Log_Logger::outputLog("店铺ID={$this->sid}");
            return false;
        } else {
            return $result;
        }
    }
    /*
     * 获取账号下添加的模板列表
     * 微信认证的服务号可用
     */
    public function fetchAllPrivateTemplate() {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template";

        $params = array(
            'access_token'  => $this->access_token,
        );

        $result = Libs_Http_Client::get($url, $params);
        $result = json_decode($result, true);

        if (isset($result['errcode'])) {
            //产生错误
            Libs_Log_Logger::outputLog($result);
            Libs_Log_Logger::outputLog("店铺ID={$this->sid}");
            return false;
        } else {
            return $result;
        }
    }
    /*
     * 获取公众号关注的用户列表
     * 微信认证的服务号、订阅号可用
     */
    public function fetchAllUserList($next_openid = null) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/user/get";

        $params = array(
            'access_token'  => $this->access_token,
        );
        if ($next_openid) {
            $params['next_openid']  = $next_openid;
        }

        $result = Libs_Http_Client::get($url, $params);
        $result = json_decode($result, true);

        if (isset($result['errcode'])) {
            //产生错误
            trigger_error(json_encode($result), E_USER_ERROR);
            return false;
        } else {
            return $result;
        }
    }

    /*
     * 删除账号下的模板
     * 微信认证的服务号可用
     */
    public function deletePrivateTemplate($tplid) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/template/del_private_template";

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
            trigger_error(json_encode($result), E_USER_ERROR);
            return false;
        } else {
            return $result;
        }
    }
    /*
     * 发送模板消息
     * 微信认证的服务号可用
     */
    public function sendTemplateMessage($openid, $tplid, $jump, $data) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/message/template/send";

        $getp   = array(
            'access_token'  => $this->access_token,
        );
        $params = array(
            'touser'        => $openid,
            'template_id'   => $tplid,
            'url'           => $jump,
            'data'          => $data
        );
        $url = $url . '?' . http_build_query($getp);

        $result = Libs_Http_Client::post($url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $result = json_decode($result, true);

        if (isset($result['errcode']) && $result['errcode']) {
            //产生错误
            Libs_Log_Logger::outputLog($result);
            Libs_Log_Logger::outputLog($params);
            //trigger_error(json_encode($result), E_USER_ERROR);
            return false;
        } else {
            return $result;
        }
    }

    /*
     * 创建微信自定义菜单
     */
    public function createMenu() {
        if (!$this->access_token) {
            return false;
        }
        $menu_sog   = new App_Model_Auth_MysqlWeixinMenuStorage();
        $first      = $menu_sog->fetchFirstLevelBySid($this->sid);
        //无一级菜单,或一级菜单超出3个
        if (!$first || count($first) == 0 || count($first) > 3) {
            return false;
        }
        $menu_cfg   = plum_parse_config('menu', 'weixin');
        $button     = array();
        foreach ($first as $one) {
            $item   = array('name'  => $one['wm_name']);
            //二级菜单存在
            $second = $menu_sog->fetchSecondLevelByFid($one['wm_id']);
            if ($one['wm_has_child'] && count($second) > 0) {
                $item['sub_button'] = array();
                for ($i = 0; $i < 5; $i++) {
                    if ($second[$i]) {
                        $type       = intval($second[$i]['wm_type']);
                        $cfg        = plum_fetch_value_byid($type, $menu_cfg);
                        $item['sub_button'][]   = array(
                            'type'  => $cfg['type'],
                            'name'  => $second[$i]['wm_name'],
                            $cfg['extra']   => in_array($type, $this->set_key) ? $second[$i]['wm_id'] : $second[$i]['wm_extra'],
                        );
                    } else {
                        break;
                    }
                }
            } else {
                $type       = intval($one['wm_type']);
                $cfg        = plum_fetch_value_byid($type, $menu_cfg);
                $item['type']       = $cfg['type'];
                $item[$cfg['extra']]= in_array($type, $this->set_key) ? $one['wm_id'] : $one['wm_extra'];
            }
            $button[]   = $item;
        }
        $url    = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$this->access_token}";
        $params = array('button' => $button);
        Libs_Log_Logger::outputLog($params);
        $ret    = Libs_Http_Client::post($url, json_encode($params, JSON_UNESCAPED_UNICODE));
        $ret    = json_decode($ret, true);
        if (!$ret['errcode']) {
            return true;
        }
        Libs_Log_Logger::outputLog($ret);
        return false;
    }

    /*
     * 微信openID正则校验
     */
    public static function openIDVerify($openid) {
        if (strlen($openid) != self::WEIXIN_OPENID_LENGTH) {
            return false;
        }
        $pattern = "/^([\w-]{28})$/";

        if (preg_match($pattern, $openid) == 1) {
            return true;
        }
        return false;
    }

    /*
     * 获取jsapi签名信息
     */
    public function fetchJsapiTicketSignature($req_url, array $js_api_list, $debug = false) {
        if (!$this->access_token) {
            return false;
        }
        $ticket     = $this->weixin['wc_jsapi_ticket'];
        $expire     = intval($this->weixin['wc_jsapi_expire']);
        //ticket不存在，或已失效
        if (!$ticket || $expire < time()) {
            $url    = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$this->access_token}&type=jsapi";
            $ret    = Libs_Http_Client::get($url);
            $ret    = json_decode($ret, true);

            if ($ret['errcode'] == 0) {
                $updata     = array(
                    'wc_jsapi_ticket'   => $ret['ticket'],
                    'wc_jsapi_expire'   => time()+intval($ret['expires_in'])
                );
                $weixin_storage = new App_Model_Auth_MysqlWeixinStorage();
                $weixin_storage->updateBySId($updata, $this->sid);
                $ticket     = $ret['ticket'];
            } else {
                return false;
            }
        }
        $param  = array(
            'jsapi_ticket'  => $ticket,
            'timestamp'     => time(),
            'noncestr'      => self::getNonceStr(12),
            'url'           => $req_url,
        );
        $signature  = self::makeSha1Sign($param);
        return array(
            'debug'     => $debug,
            'appId'     => $this->weixin['wc_app_id'],
            'timestamp' => $param['timestamp'],
            'nonceStr'  => $param['noncestr'],
            'signature' => $signature,
            'jsApiList' => $js_api_list
        );
    }

    /*
     * 生成sha1签名
     */
    public static function makeSha1Sign(array $fields) {
        //签名步骤一：按字典序排序参数
        ksort($fields);
        $buff = "";
        foreach ($fields as $k => $v) {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        //签名步骤二：SHA1加密
        $string = sha1($buff);

        //签名步骤三：所有字符转为小写
        $result = strtolower($string);

        return $result;
    }

    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return string 产生的随机字符串
     */
    public static function getNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }
    /*
     * 获取当前店铺微信配置
     */
    public function getWeixinCfg() {
        return $this->weixin;
    }

    /*
     * 创建代金券并设置跳转小程序
     */
    public function createCard(array $cash) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('card' => array(
            'card_type'        => "CASH",
            'cash'    => $cash
        ));

        $send_url   = "https://api.weixin.qq.com/card/create?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);

        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '绑定成功',
            -1      => '系统错误,请重试',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode], 'result' => $result);
    }

    /*
     * 更新卡券
     */
    public function updateCard($data) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $send_url   = "https://api.weixin.qq.com/card/update?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);

        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '绑定成功',
            -1      => '系统错误,请重试',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode], 'result' => $result);
    }

    /*
     * 创建卡券活动
     * @link https://mp.weixin.qq.com/wiki?t=resource/res_main&id=21515658940X5pIn
     * @param array $basic_info array("activity_bg_color" "activity_tinyappid" "begin_time"  "end_time" "gift_num"  "max_partic_times_act" "max_partic_times_one_day"  "mch_code")
     */
    public function createCardActivity(array $basic_info, array $card_list) {
        if (!$this->access_token) {
            return array('errcode' => -1, 'errmsg' => '系统错误,请重试');
        }

        $data   = array('info' => array(
            'basic_info'        => $basic_info,
            'card_info_list'    => array_key_exists(0, $card_list) ? $card_list : array( 0 => $card_list),
            'custom_info'       => array('type' => 'AFTER_PAY_PACKAGE'),
        ));

        $send_url   = "https://api.weixin.qq.com/card/mkt/activity/create?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        $result     = json_decode($result, true);
        $errcode    = intval($result['errcode']);

        Libs_Log_Logger::outputLog($result);
        $errmap     = array(
            0       => '绑定成功',
            -1      => '系统错误,请重试',
        );
        return array('errcode' => $errcode, 'errmsg' => $errmap[$errcode], 'result' => $result);
    }
}