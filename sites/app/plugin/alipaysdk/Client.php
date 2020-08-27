<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/21
 * Time: 上午11:10
 */
//引入必要文件
require_once PLUM_APP_PLUGIN.'/alipaysdk/wappay/service/AlipayTradeService.php';


class App_Plugin_Alipaysdk_Client {

    const GATEWAY_URL   = "https://openapi.alipay.com/gateway.do";
    const API_VERSION   = '1.0';

    /*
     * 店铺ID
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
    }

    /**
     * 网页支付统一下单接口
     * @param string $tid
     * @param string $subject
     * @param float $amount
     * @param string $notify_url
     * @param string $return_url
     * @return string
     */
    public function unifyOrder($tid, $subject, $amount, $notify_url, $return_url) {
        require_once PLUM_APP_PLUGIN.'/alipaysdk/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
        $alipay_cfg = plum_parse_config('alipay_cfg', 'alipay');
        $alipay_cfg['notify_url']   = $notify_url;
        $alipay_cfg['return_url']   = $return_url;

        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($subject);
        $payRequestBuilder->setSubject($subject);//设置商品标题,不可空
        $payRequestBuilder->setOutTradeNo($tid);
        $payRequestBuilder->setTotalAmount($amount);
        $payRequestBuilder->setTimeExpress('90m');

        $payResponse = new AlipayTradeService($alipay_cfg);
        $result=$payResponse->wapPay($payRequestBuilder, $alipay_cfg['return_url'], $alipay_cfg['notify_url']);

        return $result;
    }
    /**
     * 交易退款接口
     * @param string $pay_no
     * @param string $refund_no
     * @param float $refund_money
     * @throws Exception
     * @return bool|array
     */
    public function refundOrder($pay_no, $refund_no, $refund_money) {
        require_once PLUM_APP_PLUGIN.'/alipaysdk/wappay/buildermodel/AlipayTradeRefundContentBuilder.php';
        $alipay_cfg = plum_parse_config('alipay_cfg', 'alipay');

        $RequestBuilder = new AlipayTradeRefundContentBuilder();
        $RequestBuilder->setTradeNo($pay_no);
        $RequestBuilder->setRefundAmount($refund_money);
        $RequestBuilder->setRefundReason("协商一致");
        $RequestBuilder->setOutRequestNo($refund_no);

        $Response   = new AlipayTradeService($alipay_cfg);
        $result     = $Response->Refund($RequestBuilder);

        Libs_Log_Logger::outputLog($result);
        if ($result->code == '10000') {
            return array(
                'out_trade_no'  => $result->out_trade_no,
                'refund_fee'    => $result->refund_fee,
                'trade_no'      => $result->trade_no,
            );
        } else {
            //退款失败
            Libs_Log_Logger::outputLog("支付宝退款失败");
            Libs_Log_Logger::outputLog($result);
            return false;
        }
    }

}