<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/28
 * Time: 下午12:32
 */
class App_Plugin_Weixin_WxxcxChild {

    const WEIXIN_AUTH_NONE  = 0;//未授权微信公众号
    const WEIXIN_AUTH_WRITE = 1;//填写方式授权微信公众号
    const WEIXIN_AUTH_OPEN  = 2;//开发平台方式授权微信公众号

    public $sid;

    public $appid;
    /*
     * 小程序配置,参考pre_applet_cfg
     */
    public $xcx_cfg;

    public $access_token;

    public function __construct($sid, $appid){
        $this->sid  = $sid;
        $this->appid= $appid;
        $this->_fetch_access_token();
    }

    /*
     * 获取店铺微信授权方式,0未授权,1手工填写,2开放平台
     */
    public static function weixinAuthType($sid, $appid) {
        $child_model    = new App_Model_Applet_MysqlChildStorage($sid);
        $weixin         = $child_model->fetchUpdateWxcfgByAid($appid);

        if (!$weixin || !$weixin['ac_appid'] || $weixin['ac_s_id'] != $sid) {
            return self::WEIXIN_AUTH_NONE;
        }

        if ($weixin['ac_auth_status'] && $weixin['ac_auth_access_token']) {
            return self::WEIXIN_AUTH_OPEN;
        }

        return self::WEIXIN_AUTH_NONE;
    }
    /*
     * 获取平台所属类型
     */
    public function fetchPlatformType() {
        $weixin_storage = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $weixin         = $weixin_storage->findShopCfg();
        $category       = plum_parse_config('category', 'applet');
        $applet_type    = intval($weixin['ac_type']);
        $platform_type  = $category[$applet_type]['platform'];

        return $platform_type;
    }
    /*
     * 获取有效的访问token
     */
    private function _fetch_access_token() {
        $auth_type  = self::weixinAuthType($this->sid, $this->appid);
        //根据店铺id获取access token
        $child_model    = new App_Model_Applet_MysqlChildStorage($this->sid);
        $weixin         = $child_model->fetchUpdateWxcfgByAid($this->appid);
        switch ($auth_type) {
            //未授权
            case self::WEIXIN_AUTH_NONE :
                trigger_error('店铺绑定的微信账号未设置，请核实！sid=='.$this->sid, E_USER_WARNING);
                break;
            //开放平台授权
            case self::WEIXIN_AUTH_OPEN :
                if ($weixin['ac_auth_expire_time'] > time()) {
                    $this->access_token     = $weixin['ac_auth_access_token'];
                } else {
                    //失效token重新获取
                    $platform_type  = $this->fetchPlatformType();
                    $platform   = plum_parse_config('platform', 'wxxcx');
                    $plat_cfg   = $platform[$platform_type];
                    $plat_redis = new App_Model_Auth_RedisWeixinPlatformStorage($platform_type);
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
                        $child_model->updateById($updata, $weixin['ac_id']);
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
     * 客服发送图片消息
     */
    public function sendCustomImage($openid, $media_id) {

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
            Libs_Log_Logger::outputLog($result);
            Libs_Log_Logger::outputLog($params);
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
     * @return bool
     */
    public function commitTemplateCode($tpl_id, $ext_json, $version, $desc) {
        if (!$this->access_token) {
            return false;
        }
        $data   = array(
            'template_id'   => intval($tpl_id),
            'ext_json'      => $ext_json,
            'user_version'  => strval($version),
            'user_desc'     => $desc,
        );
        $send_url   = "https://api.weixin.qq.com/wxa/commit?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($data, JSON_UNESCAPED_UNICODE));
        Libs_Log_Logger::outputLog($result);

        $result     = json_decode($result, true);
        if (!$result['errcode']) {
            return true;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
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
     * 覆盖小程序的配置域名
     */
    public function coverCodeDomain($req_dom, $wss_dom = array(), $upl_dom = array(), $dow_dom = array()) {
        if (!$this->access_token) {
            return false;
        }
        Libs_Log_Logger::outputLog($this->access_token);
        $data   = array(
            'action'        => 'set',
            'requestdomain' => is_array($req_dom) ? $req_dom : array($req_dom),
            'wsrequestdomain'   => is_array($wss_dom) ? $wss_dom : array($wss_dom),
            'uploaddomain'      => is_array($upl_dom) ? $upl_dom : array($upl_dom),
            'downloaddomain'    => is_array($dow_dom) ? $dow_dom : array($dow_dom),
        );

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
     *通过code获取用户的openid和session_key
     */
    public function fetchOpenidByCode($appid,$code){
        // 获取平台appid;
        $platform_type  = $this->fetchPlatformType();
        $platform   = plum_parse_config('platform', 'wxxcx');
        $plat_cfg   = $platform[$platform_type];
        // 获取token
        $plat_redis = new App_Model_Auth_RedisWeixinPlatformStorage($platform_type);
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
        $errcode    = intval($result['errcode']);

        $errmap     = array(
            0       => '绑定成功',
            -1      => '系统错误,请重试',
            85001   => '微信号不存在或微信号设置为不可搜索',
            85002   => '小程序绑定的体验者数量达到上限',
            85003   => '微信号绑定的小程序体验者达到上限',
            85004   => '微信号已经绑定',
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
            //Libs_Log_Logger::outputLog('---------access_token false------------');
            return false;
        }
        // if($str){
        //     $str = $str.'&enterfrom=share';
        // }else{
        //     $str = 'enterfrom=share';
        // }
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
        // Libs_Log_Logger::outputLog('---------result false------------');
        Libs_Log_Logger::outputLog($resultArr);
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
                    Libs_Log_Logger::outputLog($cover);
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
        $url    = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template";

        $params = array(
            'access_token'  => $this->access_token,
        );

        $result = Libs_Http_Client::get($url, $params);
        $result = json_decode($result, true);

        Libs_Log_Logger::outputLog($result);
        if (isset($result['errcode'])) {
            //产生错误

            Libs_Log_Logger::outputLog("店铺ID={$this->sid}");
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
            0       => '获取成功',
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

        Libs_Log_Logger::outputLog($data);
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
}