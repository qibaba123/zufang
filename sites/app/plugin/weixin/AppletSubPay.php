<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/4/11
 * Time: 上午9:48
 */
class App_Plugin_Weixin_AppletSubPay {

    private $trade_type = array('JSAPI', 'NATIVE', 'APP');
    /*
     * curl出错时重试次数
     */
    private static $curl_retry_times   = 0;
    /*
     * 店铺id
     */
    private $sid;
    /*
     * 店铺信息，字段名参考表pre_shop
     */
    public $shop;
    /*
     * 商户支付配置信息
     */
    public $payCfg;
    /*
     * 服务商配置信息
     */
    public $agent_pay_cfg;
    /*
     * 提现配置信息，字段名参考表pre_withdraw_cfg;
     */
    public $wd_cfg;

    private $unified_url    = "https://api.mch.weixin.qq.com/pay/unifiedorder";
    private $refund_url     = "https://api.mch.weixin.qq.com/secapi/pay/refund";
    private $transfer_url   = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
    private $redpack_url    = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";

    public function __construct($sid) {
        $this->sid  = $sid;

        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);

        // 商户支付配置
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $this->payCfg = $appletPay_Model->findRowPay();

        // 服务商支付配置
        $agentPay_Model = new App_Model_Agent_MysqlAgentPayStorage(0);
        $this->agent_pay_cfg = $agentPay_Model->getAgentPayBySid($sid);
    }

    /*
     * 微信JSAPI方式统一下单支付接口
     * @param string $appid 服务商id (微信分配的公众账号ID)
     * @param string $mch_id 商户号   微信支付分配的商户号
     * @param string $sub_appid 当前调起支付的小程序APPID
     * @param string $sub_mch_id 微信支付分配的子商户号
     * @param string $openid 用户的openID
     * @param string $body 商品描述，必填
     * @param string $tid 商户系统内部的订单号
     * @param float  $amount 支付总金额，单位元
     * @param string $notify_url 通知回调地址
     * @param array $other 其他辅助数据，例如array('attach')
     * @return array|int
     */
    public function unifiedJsapiOrder($appid,$openid,$amount, $tid, $notify_url, $body,$other = array(),$mchid='') {
        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;
        $appid = $appid ? $appid : $this->payCfg['ap_appid'];
        $request_params = array(
            'appid'             => $this->agent_pay_cfg['ap_appid'],//服务商支付的appID
            'mch_id'            => $this->agent_pay_cfg['ap_mchid'],//服务商商户号
            'sub_appid'         => $appid,    // 小程序APPID
            'sub_mch_id'        => $mchid ? $mchid : $this->payCfg['ap_mchid'],
            'nonce_str'         => self::getNonceStr(24),
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'notify_url'        => $notify_url,
            'trade_type'        => 'JSAPI',
            'sub_openid'        => $openid,
        );
        $request_params = array_merge($request_params, $other);

        $sign   = self::makeWxpaySign($request_params, $this->agent_pay_cfg['ap_mchkey']);
        $request_params['sign'] = $sign;
        if ($xml = $this->toXml($request_params)) {
            $ret = self::postXmlCurl($xml, $this->unified_url);
            $ret = $this->fromXml($ret);
            Libs_Log_Logger::outputLog($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    return array(
                        'code'  => 0,
                        'appid'         => $ret['sub_appid'],
                        'mch_id'        => $ret['sub_mch_id'],
                        'trade_type'    => $ret['trade_type'],
                        'prepay_id'     => $ret['prepay_id'],
                        'app_key'       => $this->agent_pay_cfg['ap_mchkey'],
                    );
                }
            } else {
                return 40004;
            }
        } else {
            return 40003;
        }
    }

    /**
     * 小程序支付退款
     */
    public function appletRefundPayOrder($appid, $tid, $rfid, $total_fee, $refund_fee, $num_type = 'sh', $source = 2) {
        $total_fee  = round($total_fee*100);//转化为分
        $refund_fee = round($refund_fee*100);//转化为分
        $dhtype     = $num_type == 'sh' ? "out_trade_no" : "transaction_id";
        $appid = $appid ? $appid : $this->payCfg['ap_appid'];
        $request_params = array(
            'appid'             => $this->agent_pay_cfg['ap_appid'],//服务商支付的appID
            'mch_id'            => $this->agent_pay_cfg['ap_mchid'],//服务商商户号
            'sub_appid'         => $appid,    // 小程序APPID
            'sub_mch_id'        => $this->payCfg['ap_mchid'],
            'nonce_str'         => self::getNonceStr(24),
            $dhtype             => $tid,//商户内部订单号或微信单号
            'out_refund_no'     => $rfid,
            'total_fee'         => $total_fee,//单位分
            'refund_fee'        => $refund_fee,
            'refund_account'    => $source==1?'REFUND_SOURCE_UNSETTLED_FUNDS':'REFUND_SOURCE_RECHARGE_FUNDS',
        );

        $sign   = self::makeWxpaySign($request_params, $this->agent_pay_cfg['ap_mchkey']);
        $request_params['sign'] = $sign;

        if ($xml = $this->toXml($request_params)) {
            $useCert    = array(
                'ssl_cert'  => PLUM_DIR_ROOT.$this->agent_pay_cfg['ap_sslcert'],
                'ssl_key'   => PLUM_DIR_ROOT.$this->agent_pay_cfg['ap_sslkey']
            );
            $ret = self::postXmlCurl($xml, $this->refund_url, $useCert);
            $ret = $this->fromXml($ret);
            Libs_Log_Logger::outputLog($ret);
            if ($ret) {
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    //退款成功,做相应处理
                    return array(
                        'code'          => $ret['result_code'],
                        'appid'         => $ret['appid'],
                        'mch_id'        => $this->agent_pay_cfg['ap_mchid'],
                        'tid'           => $ret['out_trade_no'],
                        'refund_id'     => $ret['out_refund_no'],
                        'refund_fee'    => $ret['refund_fee'],
                        'total_fee'     => $ret['total_fee'],
                    );
                }else if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'FAIL'){   // 提交成功但业务结果处理失败
                    return array(
                        'code'   => 'FAIL',
                        'errmsg' => $ret['err_code_des'],
                    );
                }
            }
        }
        return false;
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
     * 生成签名
     * @param string $appkey 微信支付商户密钥
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public static function makeWxpaySign(array $fields, $appkey) {
        //签名步骤一：按字典序排序参数
        ksort($fields);
        $string = self::toUrlParams($fields);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$appkey;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /*
     * 格式化参数格式化成url参数
     */
    public static function toUrlParams(array $fields) {
        $buff = "";
        foreach ($fields as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /*
     * 生成唯一性商户订单id
     */
    public static function makeMchOrderid($mchid) {
        $shf_str    = (string)mt_rand(10000, 99999).(string)mt_rand(10000, 99999);//十位数字的字符串
        $oid    = array(
            $mchid,
            date('Ymd', time()),
            str_shuffle($shf_str)
        );

        return join('', $oid);
    }

    /**
     * 输出xml字符
     * @throws WxPayException
     **/
    public static function toXml(array $values) {
        if(!is_array($values) || count($values) <= 0) {
            return false;
        }

        $xml = "<xml>";
        foreach ($values as $key=>$val) {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /*
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public static function fromXml($xml) {
        if(!$xml){
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

    /*
     * 以post方式提交xml到对应的接口url
     *
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param mixed $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     * @throws WxPayException
     */
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30) {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        //如果有配置代理这里就设置代理
        /*
        if(WxPayConfig::CURL_PROXY_HOST != "0.0.0.0"
            && WxPayConfig::CURL_PROXY_PORT != 0){
            curl_setopt($ch,CURLOPT_PROXY, WxPayConfig::CURL_PROXY_HOST);
            curl_setopt($ch,CURLOPT_PROXYPORT, WxPayConfig::CURL_PROXY_PORT);
        }
        */
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert !== false){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $useCert['ssl_cert']);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $useCert['ssl_key']);
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            Libs_Log_Logger::outputLog("curl出错，错误码:$error");
            //小于10次的重试
            if (self::$curl_retry_times < 10) {
                Libs_Log_Logger::outputLog("curl出错，重试次数:".self::$curl_retry_times);
                self::$curl_retry_times++;
                self::postXmlCurl($xml, $url, $useCert, $second);
            } else {
                return false;
            }
        }
    }

    /*
     * 校验回调支付通知
     */
    public function notifyVerify($code,$applet=false) {
        $sign           = $code['sign'];
        unset($code['sign']);
        $check_sign     = $this->makeWxpaySign($code, $this->fxb_pay_cfg['mch_key']);
        //校验签名
        if ($sign == $check_sign) {
            //验证公众号ID及商户ID
            if($applet){   // 如果是微信小程序支付
                $appcfg     = plum_parse_config('xcx_login','weixin');  // 获取小程序APPid
                $paycfg     = plum_parse_config('fxb_pay','weixin');    // 获取支付相关配置
                if ($code['appid'] == $appcfg['app_id'] && $code['mch_id'] == $paycfg['mch_id']) {
                    return true;
                }
            }else{
                if ($code['appid'] == $this->fxb_pay_cfg['app_id'] && $code['mch_id'] == $this->fxb_pay_cfg['mch_id']) {
                    return true;
                }
            }

        }

        return false;
    }

    /*
     * 转换参数字符长度
     */
    private function _convert_param_length(array $params) {
        $sn_len     = strlen($params['send_name']);
        $ws_len     = strlen($params['wishing']);
        $an_len     = strlen($params['act_name']);
        $rk_len     = strlen($params['remark']);

        while ($sn_len > 32) {
            $mbsn_len   = mb_strlen($params['send_name'], 'UTF-8');
            $params['send_name']  = mb_substr($params['send_name'], 0, $mbsn_len-1, 'UTF-8');
            $sn_len = strlen($params['send_name']);
        }

        while ($ws_len > 128) {
            $mbws_len   = mb_strlen($params['wishing']);
            $params['wishing']  = mb_substr($params['wishing'], 0, $mbws_len-1, 'UTF-8');
            $ws_len = strlen($params['wishing']);
        }

        while ($an_len > 32) {
            $mban_len   = mb_strlen($params['act_name']);
            $params['act_name']  = mb_substr($params['act_name'], 0, $mban_len-1, 'UTF-8');
            $an_len = strlen($params['act_name']);
        }

        while ($rk_len > 256) {
            $mbrk_len   = mb_strlen($params['remark']);
            $params['remark']  = mb_substr($params['remark'], 0, $mbrk_len-1, 'UTF-8');
            $rk_len = strlen($params['remark']);
        }

        return $params;
    }

}