<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/9/12
 * Time: 下午6:09
 */
require_once PLUM_APP_PLUGIN.'/alixcx/AopSdk.php';


class App_Plugin_Alixcx_XcxClient {

    const GATEWAY_URL   = "https://openapi.alipay.com/gateway.do";
    const API_VERSION   = '3.3.1';

    public $client;
    public $alixcx_conf;

    public $sid;
    public $alixcx_app;

    public $app_auth_token;

    public function __construct($sid) {
        $this->_fetch_auth_token($sid);
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
    /*
     * 通过店铺ID获取授权token
     */
    private function _fetch_auth_token($sid) {
        $this->sid  = $sid;
        $applet_model   = new App_Model_Alixcx_MysqlAlixcxCfgStorage($sid);
        $this->alixcx_app   = $applet_model->findShopCfg();

        $this->app_auth_token   = $this->alixcx_app['ac_auth_access_token'];
    }
    /*
     * 检查支付宝授权token是否过期
     */
    public function checkAuthToken() {
        $result = false;
        if ($this->alixcx_app['ac_auth_status']) {//已授权，检查token是否过期
            $checked    = $this->queryAuthToken();
            if (isset($checked['status']) && $checked['status'] == 'valid') {
                $result = $this->alixcx_app['ac_auth_access_token'];
            } else {//返回失败或已过期
                //使用refresh刷新
                $refresh = $this->refreshAuthToken();
                if (isset($refresh['app_auth_token'])) {
                    $updata = array(
                        'ac_auth_access_token'  => $refresh['app_auth_token'],
                        'ac_auth_expire_time'   => $refresh['expires_in']+time()-20,//防止请求时间过长
                        'ac_auth_refresh_token' => $refresh['app_refresh_token'],
                        'ac_auth_status'        => 1,//设置为平台授权
                    );
                    $applet_model   = new App_Model_Alixcx_MysqlAlixcxCfgStorage($this->sid);
                    $applet_model->findShopCfg($updata);
                    $result = $refresh['app_auth_token'];
                }
            }
        }
        return $result;
    }
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
     * alipay.open.auth.token.app.query
     * @link https://docs.alipay.com/isv/10467/xldcyq
     */
    public function queryAuthToken($token = null) {
        $request    = new AlipayOpenAuthTokenAppQueryRequest();
        $params     = array(
            'app_auth_token'    => is_null($token) ? $this->app_auth_token : $token,
        );

        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }
    /*
     * 刷新授权应用token
     * 通过接口alipay.open.auth.token.app刷新授权令牌access_token
     */
    public function refreshAuthToken($refresh_token = null) {
        $request    = new AlipayOpenAuthTokenAppRequest();
        $params     = array(
            'grant_type'    => 'refresh_token',
            'refresh_token' => is_null($refresh_token) ? $this->alixcx_app['ac_auth_refresh_token'] : $refresh_token,
        );

        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request);

        return $this->_format_response_output($response);
    }
/************************************第三方平台获取商户授权信息开始*******************************************************/
    /*
    * 查询小程序基础信息
    * https://docs.open.alipay.com/api_49/alipay.open.mini.baseinfo.query
    * alipay.open.mini.baseinfo.query(查询小程序基础信息)
    */
    public function queryMiniBaseInfo() {
        $request    = new AlipayOpenMiniBaseinfoQueryRequest();
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.version.list.query(小程序版本列表查询)
     */
    public function queryMiniVersionList() {
        $request    = new AlipayOpenMiniVersionListQueryRequest();
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.version.detail.query(小程序版本详情查询)
     */
    public function queryMiniVersionDetail($version) {
        $request    = new AlipayOpenMiniVersionDetailQueryRequest();
        $params     = array(
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.version.upload(小程序基于模板上传版本)
     */
    public function miniVersionUpload($version, $ext, $tpl_id, $tpl_version) {
        $request    = new AlipayOpenMiniVersionUploadRequest();
        $params     = array(
            'template_version'   => $tpl_version,
            'ext'   => is_string($ext) ? $ext : json_encode($ext),
            'template_id'   => $tpl_id,
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.version.build.query(小程序查询版本构建状态)
     * @link https://docs.open.alipay.com/api_49/alipay.open.mini.version.build.query
     */
    public function miniVersionQuery($version) {
        $request    = new AlipayOpenMiniVersionBuildQueryRequest();
        $params     = array(
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.version.delete(小程序删除版本)
     */
    public function miniVersionDelete($version) {
        $request    = new AlipayOpenMiniVersionDeleteRequest();
        $params     = array(
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }

    /*
     * alipay.open.mini.experience.create(小程序生成体验版)
     * @link https://docs.open.alipay.com/api_49/alipay.open.mini.experience.create
     */
    public function miniTestCreate($version) {
        $request    = new AlipayOpenMiniExperienceCreateRequest();
        $params     = array(
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.experience.cancel(小程序取消体验版)
     */
    public function miniTestCancel($version) {
        $request    = new AlipayOpenMiniExperienceCancelRequest();
        $params     = array(
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }

    /*
     * alipay.open.mini.experience.query(小程序体验版状态查询接口)
     * @link https://docs.open.alipay.com/api_49/alipay.open.mini.experience.query
     */
    public function miniTestQuery($version) {
        $request    = new AlipayOpenMiniExperienceQueryRequest();
        $params     = array(
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }

    /*
     * alipay.open.app.members.create(应用添加成员)
     * @link https://docs.open.alipay.com/api_49/alipay.open.app.members.create
     */
    public function miniMemberCreate($account) {
        $request    = new AlipayOpenAppMembersCreateRequest();
        $params     = array(
            'logon_id'   => $account,
            'role'      => 'EXPERIENCER'
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }

    /*
     * alipay.open.mini.version.audit.apply(小程序提交审核)
     * @link https://docs.open.alipay.com/api_49/alipay.open.mini.version.audit.apply
     */
    public function miniVersionAudit($version, $desc) {
        $request    = new AlipayOpenMiniVersionAuditApplyRequest();
        $request->setAppVersion($version);
        $request->setVersionDesc($desc);
        $request->setRegionType('GLOBAL');
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.version.gray.online(小程序灰度上架)
     */
    public function miniVersionGrayOnline($version, $gray = 'p50') {
        $request    = new AlipayOpenMiniVersionGrayOnlineRequest();
        $params     = array(
            'app_version'   => $version,
            'gray_strategy' => $gray,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.version.gray.cancel(小程序结束灰度)
     */
    public function miniVersionGrayCancel($version) {
        $request    = new AlipayOpenMiniVersionGrayCancelRequest();
        $params     = array(
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.version.online(小程序上架)
     * @link https://docs.open.alipay.com/api_49/alipay.open.mini.version.online/
     */
    public function miniVersionOnline($version) {
        $request    = new AlipayOpenMiniVersionOnlineRequest();
        $params     = array(
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.version.audited.cancel(小程序退回开发)取消审核
     */
    public function miniVersionCancel($version) {
        $request    = new AlipayOpenMiniVersionAuditedCancelRequest();
        $params     = array(
            'app_version'   => $version,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * 小程序文本内容风险检测
     * @link https://docs.open.alipay.com/api_49/alipay.security.risk.content.detect
     */
    public function contentSecurityDetect($content) {
        $request    = new AlipaySecurityRiskContentDetectRequest();
        $params     = array(
            'content'   => $content,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }

    /*
     * alipay.open.app.qrcode.create 生成小程序推广二维码
     * @link https://docs.alipay.com/mini/api/openapi-qrcode
     */
    public function createMiniQrcode($url = null, $query = null, $desc = null) {
        $request    = new AlipayOpenAppQrcodeCreateRequest();
        $params     = array(
            'url_param'     => $url,
            'query_param'   => $query,
            'describe'      => $desc,
        );
        if (is_null($url)) {
            unset($params['url_param']);
        }
        if (is_null($query)) {
            unset($params['query_param']);
        }
        if (is_null($desc)) {
            unset($params['describe']);
        }
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.mini.category.query(小程序类目树查询)
     */
    public function queryMiniCategory() {
        $request    = new AlipayOpenMiniCategoryQueryRequest();
        $response   = $this->client->execute($request, null, $this->app_auth_token);

        return $this->_format_response_output($response);
    }
    /*
     * alipay.open.app.members.query(应用查询成员列表)
     * @param string $role 成员的角色类型，DEVELOPER-开发者，EXPERIENCER-体验者
     */
    public function queryMiniMemberList($role = 'EXPERIENCER') {
        $request    = new AlipayOpenAppMembersQueryRequest();
        $params     = array(
            'role'     => $role,
        );
        $request->setBizContent(json_encode($params));
        $response   = $this->client->execute($request, null, $this->app_auth_token);

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
     * 通过授权code获取授权token
     * alipay.system.oauth.token（换取授权访问令牌）
     * https://docs.open.alipay.com/api_9/alipay.system.oauth.token
     */
    public function fetchSystemOauthToken($code) {
        $request    = new AlipaySystemOauthTokenRequest();
        $request->setGrantType("authorization_code");
        $request->setCode($code);
        $response   = $this->client->execute($request,null,$this->app_auth_token);
        return $this->_format_response_output($response);
    }

    /*
    * alipay.user.info.share(获取用户信息)
    * @link https://docs.open.alipay.com/api_2/alipay.user.info.share
    */
    public function fetchMemberBaseInfo($auth_token) {
        $request    = new AlipayUserInfoShareRequest();
        $response   = $this->client->execute($request,$auth_token,$this->app_auth_token);
        return $this->_format_response_output($response);
    }

    /*
     *alipay.trade.create(统一收单交易创建接口)
     */
    public function fetchTradeCreate($uid,$tid,$amount,$title,$attach,$notify){
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
        $response   = $this->client->execute($request,null,$this->app_auth_token);
        Libs_Log_Logger::outputLog($response,'test.log');
        return $this->_format_response_output($response);
    }

    /*
     *alipay.trade.pay(统一收单交易支付接口)
     */
    public function fetchTradePay($uid,$tid,$amount,$title,$attach,$notify){
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
        $response   = $this->client->execute($request,null,$this->app_auth_token);

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