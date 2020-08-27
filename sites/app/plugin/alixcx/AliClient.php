<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/9/12
 * Time: 下午6:09
 */
require_once PLUM_APP_PLUGIN.'/alixcx/AopSdk.php';


class App_Plugin_Alixcx_AliClient {

    const GATEWAY_URL   = "https://openapi.alipay.com/gateway.do";
    const API_VERSION   = '3.3.1';

    public $client;
    public $alixcx_conf;

    public function __construct() {
        $alixcx_conf    = plum_parse_config('third_app', 'alixcx');
        $client = new AopClient();

        $client->gatewayUrl = self::GATEWAY_URL;
        $client->appId = $alixcx_conf['app_id'];
        $client->rsaPrivateKey = $alixcx_conf['rsa_private_key'];
        $client->format = "json";
        $client->postCharset= "utf-8";
        $client->signType= "RSA2";
        $client->alipayrsaPublicKey = $alixcx_conf['alipayrsa_public_key'];

        $this->client   = $client;
        $this->alixcx_conf  = $alixcx_conf;
    }
/************************************第三方平台获取商户授权信息开始*******************************************************/
    /*
     * 获取授权应用token
     * @api 接口名称：alipay.open.auth.token.app
     */
    public function getAuthToken($auth_code) {
        $request    = new AlipayOpenAuthTokenAppRequest();
        $params     = array(
            'grant_type'    => 'authorization_code',
            'code'          => $auth_code,
        );

        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }

    /*
     * 查询授权信息
     * 接口名称：alipay.open.auth.token.app.query
     * @link https://docs.alipay.com/isv/10467/xldcyq
     */
    public function queryAuthToken($token) {
        $request    = new AlipayOpenAuthTokenAppQueryRequest();
        $params     = array(
            'app_auth_token'    => $token,
        );

        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }
    /*
     * 刷新授权应用token
     * 通过接口alipay.open.auth.token.app刷新授权令牌access_token
     */
    public function refreshAuthToken($refresh_token) {
        $request    = new AlipayOpenAuthTokenAppRequest();
        $params     = array(
            'grant_type'    => 'refresh_token',
            'refresh_token' => $refresh_token,
        );

        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }
/************************************第三方平台获取商户授权信息结束 *******************************************************/


/************************************第三方平台代商家实现事务及业务开始*******************************************************/
    /*
     * 第一个先创建事务
     * alipay.open.agent.create(开启代商户签约、创建应用事务)
     * @link https://docs.open.alipay.com/api_50/alipay.open.agent.create/
     */
    public function agentCreateWork($account, $contact) {
        $request    = new AlipayOpenAgentCreateRequest();
        $params     = array(
            'account'   => $account,
            'contact_info'  => array(
                'contact_name'  => $contact['name'],
                'contact_mobile'=> $contact['mobile'],
                'contact_email' => $contact['email'],
            )
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }

    /*
     * 第二步代商家创建小程序
     * alipay.open.agent.mini.create(代商家创建小程序应用)
     * @link https://docs.open.alipay.com/api_50/alipay.open.agent.mini.create/
     */
    public function agentTinyApp($batch_no, $app_info) {
        $request    = new AlipayOpenAgentMiniCreateRequest();
        $params     = array(
            'batch_no'   => $batch_no,
            'app_name'      => $app_info['name'],
            'app_english_name'  => $app_info['ename'],
            'app_category_ids'  => $app_info['kind'],
            'app_slogan'        => $app_info['slogan'],
            'service_phone'     => $app_info['phone'],
            'app_logo'  => $app_info['logo'],
            'app_desc'  => $app_info['desc'],
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }

    /*
     * 第三步提交事务
     * alipay.open.agent.confirm(提交代商户签约、创建应用事务)
     * @link https://docs.open.alipay.com/api_50/alipay.open.agent.confirm/
     */
    public function agentConfirmWork($batch_no) {
        $request    = new AlipayOpenAgentConfirmRequest();
        $params     = array(
            'batch_no'   => $batch_no,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }

    /*
     * alipay.open.agent.order.query(查询申请单状态)
     * @link https://docs.open.alipay.com/api_50/alipay.open.agent.order.query/
     */
    public function agentOrderQuery($batch_no) {
        $request    = new AlipayOpenAgentOrderQueryRequest();
        $params     = array(
            'batch_no'   => $batch_no,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }

    /*
     * alipay.open.agent.cancel(取消代商户签约、创建应用事务)
     * @link https://docs.open.alipay.com/api_50/alipay.open.agent.cancel/
     */
    public function agentCancelWork($batch_no) {
        $request    = new AlipayOpenAgentCancelRequest();
        $params     = array(
            'batch_no'   => $batch_no,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }
    /************************************第三方平台代商家实现事务及业务结束*******************************************************/

    /*
     * alipay.open.mini.template.usage.query(查询使用模板的小程序列表)
     */
    public function queryTplUsage($tplid) {
        $request    = new AlipayOpenMiniTemplateUsageQueryRequest();
        $params     = array(
            'template_id'   => $tplid,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.category.query(小程序类目树查询)
     */
    public function queryMiniCategory() {
        $request    = new AlipayOpenMiniCategoryQueryRequest();
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }
    /*
     * 对输出结果进行格式化处理
     * @link https://docs.open.alipay.com/common/105806
     * @todo 验签
     */
    private function _format_response_output($response) {
        $res = json_decode(json_encode($response), true);
        $sign   = $response->sign;

        $code   = array_shift($res);


        if ($code['code'] == '10000') {
            $code['errcode']    = 0;
            $code['errmsg']     = '获取成功';
        } else {
            $code['errcode']    = $code['code'];
            $code['errmsg']     = $code['msg'].'=='.$code['sub_msg'];
        }

        return $code;
    }

    /*
     * 查询小程序基础信息
     * https://docs.open.alipay.com/api_49/alipay.open.mini.baseinfo.query
     * alipay.open.mini.baseinfo.query(查询小程序基础信息)
     */
    public function queryMiniBaseInfo($app_auth_token){
        $request = new AlipayOpenMiniBaseinfoQueryRequest();
        $response   = $this->client->execute($request,null,$app_auth_token);
        return $this->_format_response_output($response);
    }

    /*
     * 通过授权code获取授权token
     * alipay.system.oauth.token（换取授权访问令牌）
     * https://docs.open.alipay.com/api_9/alipay.system.oauth.token
     */
    public function fetchSystemOauthToken($code,$app_auth_token) {
        $request    = new AlipaySystemOauthTokenRequest();
        $request->setGrantType("authorization_code");
        $request->setCode($code);
        $response   = $this->client->execute($request,null,$app_auth_token);
        return $this->_format_response_output($response);
    }

    /*
    * alipay.user.info.share(获取用户信息)
    * @link https://docs.open.alipay.com/api_2/alipay.user.info.share
    */
    public function fetchMemberBaseInfo($auth_token,$app_auth_token) {
        $request    = new AlipayUserInfoShareRequest();
        $response   = $this->client->execute($request,$auth_token,$app_auth_token);
        return $this->_format_response_output($response);
    }

    /*
     *alipay.trade.create(统一收单交易创建接口)
     */
    public function fetchTradeCreate($app_auth_token,$uid,$tid,$amount,$title,$attach,$notify){
        $request = new AlipayTradeCreateRequest();
        $request->setNotifyUrl($notify);
        $params = array(
            'out_trade_no' => $tid,
            'total_amount' => $amount,
            'subject'      => $title,
            'buyer_id'     => $uid,
            'body'         => json_encode($attach)   // 额外参数
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request,null,$app_auth_token);
        return $this->_format_response_output($response);
    }

    /*
     *alipay.trade.pay(统一收单交易支付接口)
     */
    public function fetchTradePay($app_auth_token,$uid,$tid,$amount,$title,$attach,$notify){
        $request = new AlipayTradePayRequest();
        $request->setNotifyUrl($notify);
        $params = array(
            'out_trade_no' => $tid,
            'total_amount' => $amount,
            'subject'      => $title,
            'buyer_id'     => $uid,
            'body'         => json_encode($attach)
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request,null,$app_auth_token);

        return $this->_format_response_output($response);
    }

    /*
     * 支付宝支付回调获取签名
     */
    public function checkSign($arr){
        $result = $this->client->rsaCheckV1($arr, $this->client->alipayrsaPublicKey,$this->client->signType);
        return $result;
    }
}