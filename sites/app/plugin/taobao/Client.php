<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/30
 * Time: 下午5:59
 */

include "TopSdk.php";

class App_Plugin_Taobao_Client {

    public $verify_code_error   = array(
        0       => '发送成功',
        40001   => '手机号格式不正确',
        40002   => '验证码为空',
        40003   => '验证码发送失败',
        40004   => '验证码已失效'
    );

    public function __construct() {

    }

    /**
     * 阿里大鱼发送短信验证码
     * @param mixed $mobile 单个或多个手机号
     * @param mixed $code 验证码
     * @param string $type 模板key
     * @param mixed $sign 自定义签名
     * @param array $extra 除code,product外的其他数据
     * @return bool
     */
    public function sendSmsCode($mobile, $code, $type = 'yhzc', $sign = null, $extra = array()) {
        $alidayu_cfg= plum_parse_config('alidayu');
        $client     = new TopClient($alidayu_cfg['app_key'], $alidayu_cfg['app_secret']);
        $client->format = 'json';//设置响应格式

        //初始化数据
        $sign       = is_null($sign) ? $alidayu_cfg['app_sign'] : $sign;
        $product    = $alidayu_cfg['app_product'];
        $mobile     = is_array($mobile) ? join(',', $mobile) : $mobile;
        $tpl        = plum_check_array_key($type, $alidayu_cfg['tpl'], false);

        if (!$tpl) {
            return false;
        }

        $req    = new AlibabaAliqinFcSmsNumSendRequest();
        $req->setSmsType('normal');//短信类型
        $req->setSmsFreeSignName($sign);
        $param   = array(
            'code'      => $code,
            'product'   => $product,
        );
        $param  = array_merge($param, $extra);
        $req->setSmsParam(json_encode($param));
        $req->setRecNum($mobile);
        $req->setSmsTemplateCode($tpl['tpl_id']);

        $resp   = $client->execute($req);

        if (!property_exists($resp, 'result')) {
            //短信发送失败
            App_Helper_Tool::sendMail("阿里大于短信发送失败", $resp);
            return false;
        }

        return true;
    }

    /*
     * web端验证码发送或校验
     */
    public function webSendVerify($mobile, $code, $timestamp = null, $type = 'register', $token = null, $send = true) {
        $code = trim($code);
        if (!plum_is_mobile($mobile)) {
            return 40001;
        }

        $alidayu_cfg    = plum_parse_config('alidayu', 'app');
        if (!$token) {
            $token      = plum_check_array_key('sign_token', $alidayu_cfg, null);
        }
        
        $valid_time     = plum_check_array_key('valid_time', $alidayu_cfg, 10*60);
        //token或验证码为空时，返回错误
        if (!$token || !$code) {
            trigger_error('验证码自动验证验证token为空', E_USER_ERROR);
            return 40002;
        }
        switch ($type) {
            case 'register' :
                $style  = 'yhzc';
                break;
            case 'forget'   :
                $style  = 'xgmm';
                break;
            default :
                $style  = 'yhzc';
                break;
        }
        //发送验证码，否则为校验验证码
        if ($send) {
            if (!$this->sendSmsCode($mobile, $code, $style)){
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
}