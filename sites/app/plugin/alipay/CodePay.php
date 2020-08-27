<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/22
 * Time: 上午10:52
 */
require_once "lib/alipay_core.function.php";

class App_Plugin_Alipay_CodePay {

    const GATEWAY_URL   = "https://openapi.alipay.com/gateway.do";

    /*
     * 店铺ID
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;

    }

    /*
     * 支付宝wap支付统一下单
     * @param string $tid 订单编号
     * @param string $subject 商品名
     * @param float $amount 订单金额
     * @param string $show_url 商品展示URL
     * @param string $notify_url 支付回调URL
     * @param string $return_url 支付通知URL
     */
    public function unifyOrder($biz_content, $notify_url, $return_url) {
        $pay_cfg = plum_parse_config('alipay_cfg', 'alipay');
        //请求参数数组
        $params     = array(
            "app_id"        => $pay_cfg['app_id'],
            "method"        => $pay_cfg['gatewayUrl'],
            "format"        => $pay_cfg['format'],
            "charset"	    => $pay_cfg['charset'],
            'sign_type'     => $pay_cfg['sign_type'],
            "timestamp"	    => date('Y-m-d H:i:s',time()),
            "version"	    => '1.0',
            "notify_url"    => $notify_url,
            'biz_content'   => $biz_content,
        );
        $alipay_storage  = new AlipayNotify();

        $params['sign'] = self::makeRSA2Sign(paraFilter($params));

        $html_text  = $alipay_storage->buildRequestForm($params);
        return $html_text;
    }

    /*
     * 生成唯一性批次号
     */
    public static function makeBatchNo($key = '') {
        $shf_str    = (string)mt_rand(10000, 99999).(string)mt_rand(10000, 99999);//十位数字的字符串
        $oid    = array(
            $key,
            date('Ymd', time()),
            str_shuffle($shf_str)
        );

        return join('', $oid);
    }
    /*
     * 生成RSA签名
     */
    public static function makeSign(array $params) {
        ksort($params, SORT_NATURAL);

        $sign_data  = http_build_query($params);

        return base64_encode(sha1($sign_data));
    }
    /*
     * 生成RSA2签名
     */
    public static function makeRSA2Sign(array $params) {
        ksort($params, SORT_NATURAL);

        $sign_data  = http_build_query($params);

        return base64_encode(hash('sha256', $sign_data));
    }
}