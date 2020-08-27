<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/21
 * Time: 上午11:10
 */
//引入必要文件
require_once PLUM_APP_PLUGIN.'/alipaysdk/precreate/service/AlipayTradeService.php';


class App_Plugin_Alipaysdk_NewClient {

    const GATEWAY_URL   = "https://openapi.alipay.com/gateway.do";
    const API_VERSION   = '1.0';

    /*
     * 店铺ID
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
    }

    public function agentPayRecharge($tid, $subject,$body, $amount,$notify_url)
    {
        require_once PLUM_APP_PLUGIN . '/alipaysdk/precreate/buildermodel/AlipayTradePrecreateContentBuilder.php';
        $alipay_cfg = plum_parse_config('alipay_cfg', 'alipay');
        $alipay_cfg['notify_url'] = $notify_url;
        $qrPayRequestBuilder = new AlipayTradePrecreateContentBuilder();
        $qrPayRequestBuilder->setOutTradeNo($tid);
        $qrPayRequestBuilder->setTotalAmount($amount);
        $qrPayRequestBuilder->setTimeExpress('10m');
        $qrPayRequestBuilder->setSubject($subject);
        $qrPayRequestBuilder->setBody($body);

        $qrPay = new AlipayTradePrecreateService($alipay_cfg);
        $qrPayResult = $qrPay->qrPay($qrPayRequestBuilder);

        $response = $qrPayResult->getResponse();
        if(!empty($response)&&("10000"==$response->code)){
            $result = array(
                'code'    => $response->code,
                'qr_code' => $response->qr_code,
                'msg'     => $response->msg
            );
            return $result;
        }else{
            return 20000;
        }

    }

}