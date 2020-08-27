<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/28
 * Time: 下午12:32
 */
class App_Plugin_Aldwx_AldwxClient {

    public $sid;
    /*
     * 小程序配置,参考pre_applet_cfg
     */
    public $ald_cfg;

    public $access_token = null;

    public function __construct($sid){
        $this->sid  = $sid;
        $this->ald_cfg = plum_parse_config('aldcfg');
    }

    public function generateAppkey() {
        $url    = "http://openapi.aldwx.com/Main/action/Oauth/Oauth/authorize?";

        $extra = array('sid' => $this->sid);
        $url .= 'response_type=code';
        $url .= '&client_id='.$this->ald_cfg['third_id'];
        $url .= '&state='.urlencode(json_encode($extra));
        $url .= '&redirect_uri='.plum_get_base_host().'/mobile/aldwx/codeNotify';
        file_get_contents($url);
    }
    /*
     * 获取有效的访问token
     */
    private function _fetch_access_token($code) {
        $aldwxCfg_model = new App_Model_Plugin_MysqlAldwxCfgStorage($this->sid);
        $cfg = $aldwxCfg_model->fetchUpdateCfg();

        $url    = "http://openapi.aldwx.com/Main/action/Oauth/Oauth/access_token";

        $params = array(
            'grant_type'       => 'authorization_code',
            'client_id'        => $this->ald_cfg['third_id'],
            'client_secret'    => $this->ald_cfg['third_secret'],
            'code'             => $code,
            'redirect_uri'     => plum_get_base_host().'/mobile/aldwx/codeNotify'
        );
        Libs_Log_Logger::outputLog($params);
        $result     = Libs_Http_Client::post($url, $params);
        $result     = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);

        if (isset($result['access_token'])) {
            $data     = array(
                'ac_access_token'     => $result['access_token'],
                'ac_expires_in'       => time()+(int)$result['expires_in'],
                'ac_refresh_token'    => $result['refresh_token'],
            );
            if($cfg){
                $aldwxCfg_model->fetchUpdateCfg($data);
            }else{
                $data['ac_s_id'] = $this->sid;
                $data['ac_code'] = $code;
                $data['ac_create_time'] = time();
            }
            $this->access_token     = $result['access_token'];
        } else {
            //刷新令牌一旦丢失或失效,只能让用户重新授权,才能再次拿到新的刷新令牌
            Libs_Log_Logger::outputLog($result);
        }
    }

    public function _generate_app_key($code){
        $this->_fetch_access_token($code);
        $weixin_storage = new App_Model_Applet_MysqlCfgStorage($this->sid);
        $weixin         = $weixin_storage->findShopCfg();
        $url    = "http://openapi.aldwx.com/Main/action/Appregister/Appregister/getApp";
        $params = array(
            'access_token'   => $this->access_token,
            'app_name'       => $weixin['ac_name'],
            'app_logo'       => $weixin['ac_avatar'],
        );
        Libs_Log_Logger::outputLog($params);
        $result     = Libs_Http_Client::post($url, $params);
        $result     = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);

        if($result['code'] == 200){
            $aldwxCfg_model = new App_Model_Plugin_MysqlAldwxCfgStorage($this->sid);
            $data['ac_app_key'] = $result['data']['appkey'];
            $aldwxCfg_model->fetchUpdateCfg($data);
        }
        return array('errcode' => $result['code'], 'errmsg' => $result['msg']);
    }

    public function getCode(){
        $url    = "http://openapi.aldwx.com/Main/action/Oauth/Oauth/authorize?";

        $extra = array('sid' => $this->sid);
        $url .= 'response_type=code';
        $url .= '&client_id='.$this->ald_cfg['third_id'];
        $url .= '&state='.urlencode(json_encode($extra));
        $url .= '&redirect_uri='.plum_get_base_host().'/mobile/aldwx/codeNotify';
        file_get_contents($url);
    }

    public function getAccessToken($code){
        $this->_fetch_access_token($code);
        return $this->access_token;
    }

}