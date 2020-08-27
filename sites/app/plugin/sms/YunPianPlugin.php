<?php

/**
 * 云片网 发送短信验证码插件
 * Class App_Plugin_Sms_YunPianPlugin
 */
class App_Plugin_Sms_YunPianPlugin {
    /**
     * 在PHP 5.5.17 中测试通过。
     * 默认用智能匹配模版接口(send)发送，若需使用模板接口(tpl_send),请自行将代码注释去掉。
     */
    const YUNPIAN_HOST = 'http://yunpian.com';

    const YUNPIAN_SMS_HOST   = 'https://sms.yunpian.com';
    private $api_key;

    protected $error_map    = array(
        0       => 'OK',
        1       => '请求参数缺失',
        2       => '请求参数格式错误',
        3       => '账户余额不足',
        4       => '关键词屏蔽',
        5       => '未找到对应id的模板',
        6       => '添加模板失败',
        7       => '模板不可用',
        8       => '同一手机号30秒内重复提交相同的内容',
        9       => '同一手机号5分钟内重复提交相同的内容超过3次',
        10      => '手机号黑名单过滤',
        11      => '接口不支持GET方式调用',
        12      => '接口不支持POST方式调用',
        13      => '营销短信暂停发送',
        14      => '解码失败',
        15      => '签名不匹配',
        16      => '签名格式不正确',
        17      => '24小时内同一手机号发送次数超过限制',
        18      => '签名校验失败',
        19      => '请求已失效',
        20      => '不支持的国家地区',
        21      => '解密失败',
        22      => '1小时内同一手机号发送次数超过限制',
        23      => '发往模板支持的国家列表之外的地区',
        24      => '添加告警设置失败',
        25      => '手机号和内容个数不匹配',
        26      => '流量包错误',
        27      => '未开通金额计费',
        28      => '运营商错误',
        -1      => '非法的apikey',
        -2      => 'API没有权限',
        -3      => 'IP没有权限',
        -4      => '访问次数超限',
        -5      => '访问频率超限',
        -50     => '未知异常',
        -51     => '系统繁忙',
        -52     => '充值失败',
        -53     => '提交短信失败',
        -54     => '记录已存在',
        -55     => '记录不存在',
        -57     => '用户开通过固定签名功能，但签名未设置'
    );

    public $verify_code_error   = array(
        0       => '发送成功',
        40001   => '手机号格式不正确',
        40002   => '验证码为空',
        40003   => '验证码发送失败',
        40004   => '验证码已失效'
    );

    /**
     * @param string|null $apikey
     */
    public function __construct($apikey = null) {
        //获取api key，否则从配置文件中获取
        if ($apikey) {
            $this->api_key  = $apikey;
        } else {
            //plum_parse_config('yunpian', 'app')['api_key'] php >= 5.4 可用
            $yunpian_cfg    = plum_parse_config('yunpian', 'app');
            $this->api_key  = plum_check_array_key('api_key', $yunpian_cfg, null);
        }
        if (!$this->api_key) {
            trigger_error("云片网api key未设置", E_USER_ERROR);
            return null;
        }
        return $this;
    }

    /**
     * 智能匹配模版接口发短信
     * @param string $text 为短信内容，如【天点科技】您的验证码为1234
     * @param string $mobile 为接受短信的手机号，多个手机号，以,分隔开
     * @return bool
     */
    public function sendSms($text, $mobile){
        $url            = self::YUNPIAN_HOST."/v1/sms/send.json";
        $encoded_text   = urlencode("$text");
        $mobile         = urlencode("$mobile");
        $post_string    = "apikey={$this->api_key}&text=$encoded_text&mobile=$mobile";
        $result = $this->sock_post($url, $post_string);
        //结果处理
        if($result['code'] === 0 && $result['msg'] == "OK"){
            $data['status'] = 1;
        }else{
            $data['status'] = 2;
            $data['msg'] = $result['msg'];
            $data['detail'] = $result['detail'];
        }
        return $data;
    }

    /*
     * web端验证码发送或校验
     */
    public function webSendVerify($mobile, $code, $timestamp = null, $company = null, $token = null, $send = true) {
        $code = trim($code);
        if (!plum_is_mobile($mobile)) {
            return 40001;
        }
        $yunpian_cfg    = plum_parse_config('yunpian', 'app');
        if (!$token) {
            $token      = plum_check_array_key('sign_token', $yunpian_cfg, null);
        }
        if (!$company) {
            $company    = plum_check_array_key('sign_company', $yunpian_cfg, null);
        }
        $valid_time     = plum_check_array_key('valid_time', $yunpian_cfg, 10*60);
        //token或验证码为空时，返回错误
        if (!$token || !$code) {
            trigger_error('验证码自动验证验证token为空', E_USER_ERROR);
            return 40002;
        }

        //发送验证码，否则为校验验证码
        if ($send) {
            if (!$this->sendTplSms(2, array('company' => $company, 'code' => $code), $mobile)) {
                return 40003;
            }
            $timestamp  = time();
        } else {
            if (!$timestamp || intval($timestamp)+intval($valid_time) < time()) {
                return 40004;
            }
        }

        $nonce      = $code;

        $tmpArr = array($token, $mobile,$timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr     = implode('', $tmpArr);
        $signature  = md5($tmpStr);
        return array(
            'status'    => 0,
            'mobile'    => $mobile,
            'timestamp' => $timestamp,
            'signature' => $signature
        );
    }
    /**
     * 验证码自动验证机制
     * @param string $mobile 只接收单个手机号
     * @param int $code 数字类型验证码
     * @param null|string $company 公司名
     * @param null|string $token
     * @return array|bool
     */
    public function autoVerify($mobile, $code, $company = null, $token = null) {
        $code = trim($code);
        if (!plum_is_mobile($mobile)) {
            return false;
        }
        $yunpian_cfg    = plum_parse_config('yunpian', 'app');
        if (!$token) {
            $token      = plum_check_array_key('sign_token', $yunpian_cfg, null);
        }
        if (!$company) {
            $company    = plum_check_array_key('sign_company', $yunpian_cfg, null);
        }
        //token或验证码为空时，返回错误
        if (!$token || !$code) {
            trigger_error('验证码自动验证验证token为空', E_USER_ERROR);
            return false;
        }

        if (!$this->sendTplSms(2, array('company' => $company, 'code' => $code), $mobile)) {
            return false;
        }

        $timestamp  = time();
        $nonce      = $code;

        $tmpArr = array($token, $mobile, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr     = implode('', $tmpArr);
        $signature  = md5($tmpStr);
        return array(
            'mobile'    => $mobile,
            'timestamp' => $timestamp,
            'signature' => $signature
        );
    }

    /**
     * 模板接口发短信
     * @param int $tpl_id 为模板id
     * @param array $tpl_value 为模板值，例array('company' => '天点科技', 'code' => 1234)
     * @param string $mobile 为接受短信的手机号，多个手机号以英文逗号隔开
     * @return bool
     */
    public function sendTplSms($tpl_id, $tpl_value, $mobile){
        $tpl_cfg            = plum_check_array_key('tpl', plum_parse_config('yunpian', 'app'), array());
        if (!isset($tpl_cfg[$tpl_id])) {
            trigger_error("云片网短信模块ID未设置", E_USER_WARNING);
            $tpl_cfg[$tpl_id]['tpl_key']    = array();//设置默认值，发生产生警告
        }
        $tpl_link   = '';
        $tpl        = $tpl_cfg[$tpl_id];
        foreach ($tpl_value as $key => $val) {
            if (!in_array($key, $tpl['tpl_key'])) {
                trigger_error("云片网短信模块ID=$tpl_id，不存在的key=$key", E_USER_NOTICE);
            }
            $tpl_link .= "#$key#=$val&";
        }

        $tpl_link   = substr($tpl_link, 0, strlen($tpl_link) - 1);
        $url                = self::YUNPIAN_HOST."/v1/sms/tpl_send.json";
        $encoded_tpl_value  = urlencode("$tpl_link");  //tpl_value需整体转义
        $mobile             = urlencode("$mobile");
        $post_string        = "apikey={$this->api_key}&tpl_id=$tpl_id&tpl_value=$encoded_tpl_value&mobile=$mobile";
        return $this->sock_post($url, $post_string);
    }

    /**
     * url 为服务的url地址
     * query 为请求串
     */
    private function sock_post($url, $query){
        $data   = "";
        $info   = parse_url($url);
        $fp     = fsockopen($info["host"],80,$errno,$errstr,30);
        if(!$fp){
            return $data;
        }
        $head   = "POST ".$info['path']." HTTP/1.0\r\n";
        $head   .= "Host: ".$info['host']."\r\n";
        $head   .= "Referer: http://".$info['host'].$info['path']."\r\n";
        $head   .= "Content-type: application/x-www-form-urlencoded\r\n";
        $head   .= "Content-Length: ".strlen(trim($query))."\r\n";
        $head   .= "\r\n";
        $head   .= trim($query);
        $write  = fputs($fp,$head);
        $header = "";
        while ($str = trim(fgets($fp,4096))) {
            $header .= $str;
        }
        while (!feof($fp)) {
            $data .= fgets($fp,4096);
        }
        //解析json并检查错误
        $json   = json_decode($data, true);
        if ($json['code'] == 0) {
            //验证码发送成功
            return true;
        } else {
            $trigger_msg    = '错误信息：'.$this->error_map[$json['code']].';错误描述：'.$json['detail'];
            if ($json['code'] > 0) {
                //调用API时，发生错误，需要开发者进行相应处理
                trigger_error($trigger_msg, E_USER_ERROR);
            } else if ( -50 < $json['code'] && $json['code'] < 0) {
                //权限验证失败，需要开发者进行相应处理
                trigger_error($trigger_msg, E_USER_ERROR);
            } else {
                //云片网系统内部错误，需联系技术支持
                trigger_error($trigger_msg, E_USER_ERROR);
            }
        }
        return false;
    }

    /*
     * 添加验证码类短信模板
     * @param sting $company 短信签名
     * @return
     * {
     *   "tpl_id": 1,                 //模板id
     *   "tpl_content": "【云片网】您的验证码是#code#", //模板内容
     *   "check_status": "CHECKING",     //审核状态：CHECKING/SUCCESS/FAIL
     *   "reason": null                  //审核未通过的原因
     * }
     */
    public function addCodeSmsTpl($company) {
        //签名3-8字，建议使用汉字
        if (plum_utf8_strlen($company) < 3 || plum_utf8_strlen($company) > 8) {
            return false;
        }

        $url    = self::YUNPIAN_SMS_HOST.'/v2/tpl/add.json';
        $tpl    = "【{$company}】您的验证码是#code#";
        $params = array(
            'apikey'        => $this->api_key,
            'tpl_content'   => $tpl,
            'notify_type'   => 0,
        );

        $ret    = Libs_Http_Client::post($url, $params);
        $ret    = json_decode($ret, true);
        if (isset($ret['http_status_code']) && $ret['http_status_code'] == 400) {
            trigger_error(json_encode($ret), E_USER_ERROR);
            return false;
        }

        return $ret;
    }

    /*
     * 获取指定ID的短信模板状态
     * @return
     * {
     *   "tpl_id": 1,                 //模板id
     *   "tpl_content": "【云片网】您的验证码是#code#", //模板内容
     *   "check_status": "CHECKING",     //审核状态：CHECKING/SUCCESS/FAIL
     *   "reason": null                  //审核未通过的原因
     * }
     */
    public function getCodeSmsTpl($tpl_id) {
        $url    = self::YUNPIAN_SMS_HOST.'/v2/tpl/get.json';

        $params = array(
            'apikey'    => $this->api_key,
            'tpl_id'    => $tpl_id,
        );
        $ret    = Libs_Http_Client::post($url, $params);
        $ret    = json_decode($ret, true);
        if (isset($ret['http_status_code']) && $ret['http_status_code'] == 400) {
            trigger_error(json_encode($ret), E_USER_ERROR);
            return false;
        }

        return $ret;
    }

    /*
     * 发送单条验证码类短信,云片V2版本接口
     */
    public function sendSingleCode($mobile, $code, $company) {
        $url    = self::YUNPIAN_SMS_HOST.'/v2/sms/single_send.json';

        $params = array(
            'apikey'    => $this->api_key,
            'mobile'    => $mobile,
            'text'      => "【{$company}】您的验证码是{$code}",
        );

        $ret    = Libs_Http_Client::post($url, $params);
        if (isset($ret['http_status_code']) && $ret['http_status_code'] == 400) {
            trigger_error(json_encode($ret), E_USER_ERROR);
            return false;
        }

        $ret    = json_decode($ret, true);
        $ret['text']    = $params['text'];//返回短信内容
        return $ret;
    }
    /*
     * 指定模板单发
     */
    public function sendSingleTpl($tpl_id,array $tpl_val, $mobile) {
        $url    = self::YUNPIAN_SMS_HOST.'/v2/sms/tpl_single_send.json';

        $tpl_cfg            = plum_check_array_key('tpl', plum_parse_config('yunpian', 'app'), array());
        if (!isset($tpl_cfg[$tpl_id])) {
            trigger_error("云片网短信模块ID未设置", E_USER_WARNING);
            $tpl_cfg[$tpl_id]['tpl_key']    = array();//设置默认值，发生产生警告
        }
        $tpl_link   = '';
        $tpl        = $tpl_cfg[$tpl_id];
        foreach ($tpl_val as $key => $val) {
            if (!in_array($key, $tpl['tpl_key'])) {
                trigger_error("云片网短信模块ID=$tpl_id，不存在的key=$key", E_USER_NOTICE);
            }
            $val    = preg_replace("/[【】]/", "", $val);
            $tpl_link .= "#$key#=".urlencode($val)."&";
        }

        $tpl_link   = substr($tpl_link, 0, strlen($tpl_link) - 1);
        $params = array(
            'apikey'    => $this->api_key,
            'mobile'    => $mobile,
            'tpl_id'    => $tpl_id,
            'tpl_value' => $tpl_link,
        );
        $ret    = Libs_Http_Client::post($url, $params);
        if (isset($ret['http_status_code']) && $ret['http_status_code'] == 400) {
            trigger_error(json_encode($ret), E_USER_ERROR);
            return false;
        }

        $ret    = json_decode($ret, true);

        $reg    = array_keys($tpl_val);
        $msg    = array_values($tpl_val);
        foreach ($reg as &$item) {
            $item   = "/#{$item}#/";
        }

        $text   = preg_replace($reg, $msg, $tpl['tpl_content']);
        $ret['text']    = $text;//返回短信内容
        return $ret;
    }
}