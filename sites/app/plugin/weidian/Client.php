<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/11
 * Time: 下午7:46
 */
class App_Plugin_Weidian_Client {

    private $sid;

    private $shop;
    private $refresh_token_url  = "https://api.vdian.com/oauth2/refresh_token";

    private $vdian_api_url      = "https://api.vdian.com/api";
    private $vdian_api_version  = "1.0";
    private $vdian_api_format   = "json";
    //微店接口访问token
    public $access_token        = null;

    public function __construct($sid) {
        $this->sid  = $sid;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop = $shop_model->getRowById($sid);
        //获取访问token
        $this->_fetch_access_token();
    }
    /*
     * 获取access token,获取失败时,要求重新授权
     */
    private function _fetch_access_token() {
        $wdcfg_model    = new App_Model_Auth_MysqlWeidianAuthStorage();
        $wdcfg      = $wdcfg_model->findWeidianBySid($this->sid);
        if (!$wdcfg) {
            return;
        }
        //未失效
        if ($wdcfg['wc_expires_in'] > time()) {
            $this->access_token = $wdcfg['wc_access_token'];
        } else {
            $wd_cfg = plum_parse_config('weidian');

            $params = array(
                'appkey'        => $wd_cfg['appkey'],
                'grant_type'    => 'refresh_token',
                'refresh_token' => $wdcfg['wc_refresh_token'],
            );

            $ret    = Libs_Http_Client::get($this->refresh_token_url, $params);
            $ret    = json_decode($ret, true);
            //通过refresh_token(30天有效期)获取,获取成功
            if ($ret['status']['status_code'] == 0) {
                $basic  = $ret['result'];
                $updata = array(
                    'wc_shop_name'   => $basic['shop_name'],
                    'wc_shop_logo'   => $basic['shop_logo'],
                    'wc_access_token'   => $basic['access_token'],
                    'wc_scope'          => $basic['scope'],
                    'wc_expires_in'     => time()+intval($basic['expires_in']),
                    'wc_refresh_token'  => $basic['refresh_token'],
                    'wc_create_time'    => time(),
                );
                $wdcfg_model->updateById($updata, $wdcfg['wc_id']);

                $this->access_token = $basic['access_token'];
            } else {
                //授权失败
                App_Helper_Tool::sendMail("微店获取token失败", json_encode($this->shop));
                $url    = "/manage/auth/weidian/suid/".$this->shop['s_unique_id'];
                plum_redirect_with_msg("微店授权过期,请重新授权", $url, 4);
            }
        }
    }
    /*
     * 获取全店商品
     */
    public function getGoodsList($page_num = 1, $page_size = 50, $order_by = 1) {
        $method = 'vdian.item.list.get';

        $param  = '{"page_num":' . $page_num . ',"page_size":' . $page_size . ',"orderby":' . $order_by . '}';
        $request    = array(
            'param'     => $param,
            'public'    => $this->_format_request_public($method),
        );

        $ret    = Libs_Http_Client::post($this->vdian_api_url, $request);
        //Libs_Log_Logger::outputLog($ret);
        //$ret    = Libs_Http_Client::get($this->vdian_api_url, $request);
        $ret    = json_decode($ret, true);

        return $ret;
    }
    /*
     * 获取单个商品
     */
    public function getGoodsSingle($itemid) {
        $method = 'vdian.item.get';
        $param  = '{"itemid":' . $itemid . '}';
        $request    = array(
            'param'     => $param,
            'public'    => $this->_format_request_public($method),
        );

        $ret    = Libs_Http_Client::post($this->vdian_api_url, $request);
        $ret    = json_decode($ret, true);

        return $ret;
    }
    /*
     * 获取订单详情
     */
    public function getOrderDetail($tid) {
        if (!$this->access_token) {
            return false;
        }
        $method = 'vdian.order.get';
        $param  = '{"order_id":' . $tid . '}';
        $request    = array(
            'param'     => $param,
            'public'    => $this->_format_request_public($method),
        );

        $ret    = Libs_Http_Client::post($this->vdian_api_url, $request);
        $ret    = json_decode($ret, true);

        if ($ret && $ret['status']['status_code'] == 0) {
            return $ret['result'];
        }
        return false;
    }
    /*
     * 格式化请求的public参数
     */
    private function _format_request_public($method) {
        $public = '{"method":"' . $method . '","access_token":"' . $this->access_token . '","version":"' . $this->vdian_api_version . '","format":"' . $this->vdian_api_format . '","lang":"php"}';

        return $public;
    }
}