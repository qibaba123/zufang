<?php
/**
 * 与硬件结合的相关支付接口，小程序支付配置
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2019/5/27
 * Time: 11:52 AM
 */
class App_Plugin_Weixin_HardwarePay {
    /*
     * 错误信息映射
     */
    public static $error_map = array(
        40001    => "支付方式中,微信支付商户证书未上传",
        40002   => "微信支付商户信息配置不正确",
        40003   => "请求参数转换XML出错",
        40004   => "网络请求错误",
        40005   => "通信错误",
        40006   => "业务请求失败"
    );
    //微信付款码支付错误信息
    const MICROPAY_SYSTEMERROR       = 'SYSTEMERROR';//支付结果未知 系统超时
    const MICROPAY_PARAM_ERROR       = 'PARAM_ERROR'; //支付确认失败，请求参数未按指引进行填写
    const MICROPAY_ORDERPAID         = 'ORDERPAID';   //支付确认失败，订单号重复
    const MICROPAY_NOAUTH            = 'NOAUTH';        //支付确认失败，商户没有开通被扫支付权限
    const MICROPAY_AUTHCODEEXPIRE    = 'AUTHCODEEXPIRE'; //支付确认失败，用户的条码已经过期
    const MICROPAY_NOTENOUGH         = 'NOTENOUGH';   //支付确认失败，用户的零钱余额不足
    const MICROPAY_NOTSUPORTCARD     = 'NOTSUPORTCARD';  //支付确认失败，用户使用卡种不支持当前支付形式
    const MICROPAY_ORDERCLOSED       = 'ORDERCLOSED';  //支付确认失败，该订单已关
    const MICROPAY_ORDERREVERSED     = 'ORDERREVERSED';  //支付确认失败，当前订单已经被撤销
    const MICROPAY_BANKERROR         = 'BANKERROR';   //支付结果未知，银行端超时
    const MICROPAY_USERPAYING        = 'USERPAYING';  //支付结果未知，该笔交易因为业务规则要求，需要用户输入支付密码。
    const MICROPAY_AUTH_CODE_ERROR   = 'AUTH_CODE_ERROR';  //支付确认失败，请求参数未按指引进行填写
    const MICROPAY_AUTH_CODE_INVALID = 'AUTH_CODE_INVALID';   //支付确认失败，收银员扫描的不是微信支付的条码
    const MICROPAY_XML_FORMAT_ERROR  = 'XML_FORMAT_ERROR';  //支付确认失败，XML格式错误
    const MICROPAY_REQUIRE_POST_METHOD = 'REQUIRE_POST_METHOD'; //支付确认失败，未使用post传递参数
    const MICROPAY_SIGNERROR         = 'SIGNERROR'; //支付确认失败，参数签名结果不正确
    const MICROPAY_LACK_PARAMS       = 'LACK_PARAMS';  //支付确认失败，缺少必要的请求参数
    const MICROPAY_NOT_UTF8          = 'NOT_UTF8';  //支付确认失败，未使用指定编码格式
    const MICROPAY_BUYER_MISMATCH    = 'BUYER_MISMATCH';  //支付确认失败，暂不支持同一笔订单更换支付方
    const MICROPAY_APPID_NOT_EXIST   = 'APPID_NOT_EXIST'; //支付确认失败，参数中缺少APPID
    const MICROPAY_MCHID_NOT_EXIST   = 'MCHID_NOT_EXIST';  //支付确认失败，参数中缺少MCHID
    const MICROPAY_OUT_TRADE_NO_USED = 'OUT_TRADE_NO_USED'; //支付确认失败，同一笔交易不能多次提交
    const MICROPAY_APPID_MCHID_NOT_MATCH = 'APPID_MCHID_NOT_MATCH'; //支付确认失败，appid和mch_id不匹配
    const MICROPAY_INVALID_REQUEST       = 'INVALID_REQUEST';  //支付确认失败，商户系统异常导致，商户权限异常、重复请求支付、证书错误、频率限制等
    const MICROPAY_TRADE_ERROR           = 'TRADE_ERROR';   //支付确认失败，业务错误导致交易失败、用户账号异常、风控、规则限制等
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
     * 微信支付配置,字段名参考表pre_applet_pay
     */
    public $wx_pay;
    /*
     * 数据状态是否准备好
     */
    private $has_ready = true;
    /*
     * 支付相关URL对应
     */
    private $micropay_url       = "https://api.mch.weixin.qq.com/pay/micropay";
    private $query_url          = "https://api.mch.weixin.qq.com/pay/orderquery";
    private $reverse_url        = "https://api.mch.weixin.qq.com/secapi/pay/reverse";
    private $refund_url         = "https://api.mch.weixin.qq.com/secapi/pay/refund";//扫码、刷脸通用
    private $refund_query_url   = "https://api.mch.weixin.qq.com/pay/refundquery";//扫码、刷脸通用

    private $facepay_url        = "https://api.mch.weixin.qq.com/pay/facepay";
    private $query_facepay_url  = "https://api.mch.weixin.qq.com/pay/facepayquery";
    private $reverse_facepay_url= "https://api.mch.weixin.qq.com/secapi/pay/facepayreverse";

    public function __construct($sid) {
        $this->sid  = $sid;
        //获取店铺数据
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop     = $shop_storage->getRowById($sid);
        //获取微信支付配置
        $wxpay_storage  = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $this->wx_pay   = $wxpay_storage->findRowPay();

        if (!$this->shop || !$this->wx_pay) {
            $this->has_ready = false;
        }
    }
    /*
     * 提交付款码支付
     * @link https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_10&index=1
     */
    public function microPay($body, $tid, $amount, $code, $other = array()) {
        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;

        $request_params = array(
            'body'              => $body,
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'auth_code'         => $code,//扫码支付授权码，设备读取用户微信中的条码或者二维码信息
        );
        $request_params = array_merge($request_params, $other);
        return $this->_request_format_response($request_params, $this->micropay_url);
    }
    /*
     * 查询订单状态
     * @link https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_2
     */
    public function queryOrder($tid, $trans_id = null) {
        $request_params = array(
            'out_trade_no'      => $tid,//商户内部订单号
        );
        //如果传入微信的订单号，则优先使用
        if (!is_null($trans_id)) {
            unset($request_params['out_trade_no']);
            $request_params['transaction_id']   = $trans_id;
        }
        return $this->_request_format_response($request_params, $this->query_url);
    }
    /*
     * 撤销支付
     * @link https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_11&index=3
     * 备注，请求需要证书
     */
    public function reversePay($tid, $trans_id = null) {
        $request_params = array(
            'out_trade_no'      => $tid,//商户内部订单号
        );
        //如果传入微信的订单号，则优先使用
        if (!is_null($trans_id)) {
            unset($request_params['out_trade_no']);
            $request_params['transaction_id']   = $trans_id;
        }

        return $this->_request_format_response($request_params, $this->reverse_url, true);
    }
    /*
     * 支付退款
     * @link https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_4
     */
    public function refundPay($tid,$refund_id, $total, $refund, $trans_id = null) {
        $total      = round($total*100);//转化为分
        $refund     = round($refund*100);//转化为分

        $request_params = array(
            'out_trade_no'      => $tid,//商户内部订单号
            'out_refund_no'     => $refund_id,//商户系统内部的退款单号，商户系统内部唯一
            'total_fee'         => $total,//订单总金额
            'refund_fee'        => $refund,//退款总金额，小于等于订单总金额
        );
        //如果传入微信的订单号，则优先使用
        if (!is_null($trans_id)) {
            unset($request_params['out_trade_no']);
            $request_params['transaction_id']   = $trans_id;
        }

        return $this->_request_format_response($request_params, $this->refund_url, true);
    }
    /*
     * 查询退款
     * @link https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_5
     */
    public function queryRefund($refund_id) {
        $request_params = array(
            'refund_id'         => $refund_id,//微信生成的退款单号，在申请退款接口有返回
        );

        return $this->_request_format_response($request_params, $this->refund_query_url);
    }

    /*
     * 发起请求并格式化输出结果
     */
    private function _request_format_response($request_params, $request_url, $use_cert = false) {
        $code   = array();//返回的数据
        if (!$this->has_ready) {
            $code['errcode']    = 40002;
            $code['errmsg']     = self::$error_map[40002];

            return $code;
        }
        //如果使用证书，判断是否存在
        if ($use_cert) {
            if (!$this->wx_pay['ap_sslcert'] || !$this->wx_pay['ap_sslkey']) {
                $code['errcode']    = 40001;
                $code['errmsg']     = self::$error_map[40001];

                return $code;
            }
        }
        $request_params['appid']    = $this->wx_pay['ap_appid'];//公众号ID，微信分配的公众账号ID
        $request_params['mch_id']   = $this->wx_pay['ap_mchid'];//商户ID
        $request_params['nonce_str']= self::getNonceStr(24);

        $mch_key    = $this->wx_pay['ap_mchkey'];//商户key
        $sign   = self::makeWxpaySign($request_params, $mch_key);
        $request_params['sign'] = $sign;

        Libs_Log_Logger::outputLog($request_params);

        if ($xml = $this->toXml($request_params)) {//请求参数非数组，或空数据返回false
            if ($use_cert) {
                $use_cert    = array(
                    'ssl_cert'  => PLUM_DIR_ROOT.$this->wx_pay['ap_sslcert'],
                    'ssl_key'   => PLUM_DIR_ROOT.$this->wx_pay['ap_sslkey']
                );
            }
            $ret = self::postXmlCurl($xml, $request_url, $use_cert);
            Libs_Log_Logger::outputLog($ret);
            $ret = $this->fromXml($ret);
            if ($ret) {//非xml数据转换，返回false
                if ($ret['return_code'] == 'SUCCESS' && $ret['result_code'] == 'SUCCESS') {
                    $code['errcode']    = 0;
                    $code['errmsg']     = '获取成功';
                    $code['data']   = $ret;
                } else {
                    $code['errcode']    = -1;
                    $code['data']   = $ret;
                }
            } else {
                $code['errcode']    = 40004;
                $code['errmsg']     = self::$error_map[40004];
            }
        } else {
            $code['errcode']    = 40003;
            $code['errmsg']     = self::$error_map[40003];
        }
        return $code;
    }
/***********************************************刷脸支付****************************************************************/
    /*
     * 发起刷脸支付
     */
    public function facePay($openid, $body, $tid, $amount, $code, $other = array()) {
        $amount     = round($amount*100);//转化为分
        $body       = mb_strlen($body, 'UTF-8') > 40 ? mb_substr($body, 0, 40, 'UTF-8') : $body;

        $request_params = array(
            'body'              => $body,//商品或支付单简要描述，格式要 求:门店品牌名-城市分店名-实际 商品名称
            'out_trade_no'      => $tid,//商户内部订单号
            'total_fee'         => $amount,//单位分
            'spbill_create_ip'  => plum_get_server('SERVER_ADDR'),
            'openid'            => $openid,
            'face_code'         => $code,//人脸凭证，用于刷脸支付
        );
        $request_params = array_merge($request_params, $other);
        return $this->_request_format_response($request_params, $this->facepay_url);
    }
    /*
     * 查询刷脸支付订单
     */
    public function queryFacePay($tid, $trans_id = null) {
        $request_params = array(
            'out_trade_no'      => $tid,//商户内部订单号
        );
        //如果传入微信的订单号，则优先使用
        if (!is_null($trans_id)) {
            unset($request_params['out_trade_no']);
            $request_params['transaction_id']   = $trans_id;
        }
        return $this->_request_format_response($request_params, $this->query_facepay_url);
    }
    /*
     * 撤销刷脸支付
     */
    public function reverseFacePay($tid, $trans_id = null) {
        $request_params = array(
            'out_trade_no'      => $tid,//商户内部订单号
        );
        //如果传入微信的订单号，则优先使用
        if (!is_null($trans_id)) {
            unset($request_params['out_trade_no']);
            $request_params['transaction_id']   = $trans_id;
        }

        return $this->_request_format_response($request_params, $this->reverse_facepay_url, true);
    }
/***********************************************工具方法****************************************************************/
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

    /*
     * 输出xml字符
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
}