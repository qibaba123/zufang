<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2018/12/3
 * Time: 7:57 PM
 */
class App_Plugin_Weixin_ThirdPlatform {

    private $tp_token;

    public function __construct($type = 'weixin'){
        $p_s    = new App_Model_Auth_RedisWeixinPlatformStorage($type);

        $this->tp_token = $p_s->getCompAccessToken();
    }
    /*
     * 快速创建微信小程序
     * @link https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=21538208049W8uwq&token=&lang=zh_CN
     * @param int $type 企业代码类型（1：统一社会信用代码， 2：组织机构代码，3：营业执照注册号）
     */
    public function createWxxcx($company, $code, $type, $wechat, $name, $phone) {
        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/fastregisterweapp?action=create&component_access_token={$this->tp_token}";
        $params     = array(
            'name'      => $company,
            'code'      => $code,
            'code_type' => $type,
            'legal_persona_wechat'  => $wechat,
            'legal_persona_name'    => $name,
            'component_phone'       => $phone,
        );
        Libs_Log_Logger::outputLog($params);
        $result = Libs_Http_Client::post($req_url, json_encode($params, JSON_UNESCAPED_UNICODE));
        Libs_Log_Logger::outputLog($result);
        return $this->_format_response_output($result);
    }
    /*
     * 查询创建小程序的任务状态
     */
    public function searchWxxcx($company, $wechat, $name) {
        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/fastregisterweapp?action=search&component_access_token={$this->tp_token}";
        $params     = array(
            'name'      => $company,
            'legal_persona_wechat'  => $wechat,
            'legal_persona_name'    => $name,
        );
        $result = Libs_Http_Client::post($req_url,  json_encode($params, JSON_UNESCAPED_UNICODE));
        return $this->_format_response_output($result);
    }

    /*
     * 对输出结果进行格式化处理
     * @link https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=21538208049W8uwq&token=&lang=zh_CN
     */
    private function _format_response_output($response) {
        $res = json_decode($response, true);
        $code   = array();

        if ($res['errcode'] != 0 ) {//errno != 0
            $code['errcode']    = $res['errcode'];
            $code['errmsg']     = $res['errmsg'];
        } else {
            $code['errcode']    = 0;
            $code['errmsg']     = '获取成功';
            $code['data']       = isset($res['data']) ? $res['data'] : $res;
        }

        return $code;
    }
}