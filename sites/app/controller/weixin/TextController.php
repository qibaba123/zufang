<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/31
 * Time: 下午7:25
 */

class App_Controller_Weixin_TextController extends App_Controller_Weixin_BaseController {

    public function __construct($weixin_msg) {
        parent::__construct($weixin_msg);
    }

    /*
     * 默认动作
     */
    public function indexAction() {
        $this->_qwfb_text();
        $content    = (string)$this->weixinMsg->Content;
        $this->_redpack_check($content);
    }

    /*
     * 关键词红包,口令红包,裂变红包检查
     */
    private function _redpack_check($content) {
        $match      = false;
        $redp_redis = new App_Model_Redpack_RedisRedpackStorage($this->sid);
        $all        = $redp_redis->getKeywordSet();
        Libs_Log_Logger::outputLog($all);
        Libs_Log_Logger::outputLog($content);
        //关键词存在
        if ($all && in_array($content, $all)) {
            $curr           = time();
            $redp_helper    = new App_Helper_Redpack($this->sid);
            //判断是否为关键词红包
            $kwrp_model = new App_Model_Redpack_MysqlKeywordStorage($this->sid);
            $redp       = $kwrp_model->findRedpackByKeyword($content);

            if ($redp) {
                $match  = true;//匹配成功
                $wxcfg  = plum_parse_config('redpack_txt', 'weixin');
                $txt    = $wxcfg['keyword'];
                if ($redp['rk_start_time'] > $curr) {
                    $this->sendTextResponse($redp['rk_wks_txt'] ? $redp['rk_wks_txt'] : $txt['wks']);
                    return;
                }
                
                if ($redp['rk_end_time'] < $curr) {
                    $this->sendTextResponse($redp['rk_yjs_txt'] ? $redp['rk_yjs_txt'] : $txt['yjs']);
                    $redp_helper->sendRedpackTmplmsg($redp['rk_lqsb_msgid'], $this->wx_openid);
                    $redp_helper->sendRedpackNewsmsg($redp['rk_lqsb_nwid'], $this->wx_openid);
                    return;
                }
                
                if ($redp['rk_had'] >= $redp['rk_total']) {
                    $this->sendTextResponse($redp['rk_blw_txt'] ? $redp['rk_blw_txt'] : $txt['blw']);
                    $redp_helper->sendRedpackTmplmsg($redp['rk_lqsb_msgid'], $this->wx_openid);
                    $redp_helper->sendRedpackNewsmsg($redp['rk_lqsb_nwid'], $this->wx_openid);
                    return;
                }
                //正常发放关键词红包
                $ret = $redp_helper->sendKeywordRedpack($redp['rk_id'], $this->wx_openid);
            }
            
            if (!$match) {
                //判断是否为裂变红包
                $fsrp_model = new App_Model_Redpack_MysqlFissionStorage($this->sid);
                $redp       = $fsrp_model->findRedpackByKeyword($content);

                if ($redp) {
                    $match  = true;//匹配成功
                    $wxcfg  = plum_parse_config('redpack_txt', 'weixin');
                    $txt    = $wxcfg['fission'];
                    if ($redp['rf_start_time'] > $curr) {
                        $this->sendTextResponse($redp['rf_wks_txt'] ? $redp['rf_wks_txt'] : $txt['wks']);
                        return;
                    }

                    if ($redp['rf_end_time'] < $curr) {
                        $this->sendTextResponse($redp['rf_yjs_txt'] ? $redp['rf_yjs_txt'] : $txt['yjs']);
                        $redp_helper->sendRedpackTmplmsg($redp['rf_lqsb_msgid'], $this->wx_openid);
                        $redp_helper->sendRedpackNewsmsg($redp['rf_lqsb_nwid'], $this->wx_openid);
                        return;
                    }
                    Libs_Log_Logger::outputLog($redp);
                    if ($redp['rf_had'] >= $redp['rf_total']) {
                        $this->sendTextResponse($redp['rf_blw_txt'] ? $redp['rf_blw_txt'] : $txt['blw']);
                        $redp_helper->sendRedpackTmplmsg($redp['rf_lqsb_msgid'], $this->wx_openid);
                        $redp_helper->sendRedpackNewsmsg($redp['rf_lqsb_nwid'], $this->wx_openid);
                        return;
                    }
                    //正常发放裂变红包
                    $ret = $redp_helper->sendFissionRedpack($redp['rf_id'], $this->wx_openid);
                }
            }
        }

        //口令红包匹配
        if (!$match) {
            //六位以上数字激活口令红包
            if (is_numeric($content) && strlen($content) > 5) {
                $redp_helper    = new App_Helper_Redpack($this->sid);
                $ret = $redp_helper->sendCommandRedpack($content, $this->wx_openid);

            }
//            else{//新口令红包
//               //原二维码红包
//                $content = strtoupper($content);
//                $content = $this->_remove_emoj($content);
//                $redp_helper    = new App_Helper_Redpack($this->sid);
//                $ret = $redp_helper->verifyQrcodeRedpack($content, $this->wx_openid,$this->shop['s_unique_id']);
//            }
        }
        if (isset($ret) && $ret['errcode'] <= 0) {
            //发放应答
            $this->sendTextResponse($ret['errmsg']);
        }
    }
    /*
     * 移除内容中的emoj表情
     */
    private function _remove_emoj($text) {
        $clean_text = "";
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);
        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        return $clean_text;
    }

    /*
     * 全网发布测试,可注释
     */
    private function _qwfb_text() {
        $content    = (string)$this->weixinMsg->Content;
        Libs_Log_Logger::outputLog($content);
        if ( $content == 'TESTCOMPONENT_MSG_TYPE_TEXT' ) {
            $this->sendTextResponse('TESTCOMPONENT_MSG_TYPE_TEXT_callback');
        } else if (substr_compare($content, 'QUERY_AUTH_CODE', 0, 15) === 0) {

            $tmp    = explode(':', $content);
            $code   = $tmp[1];

            $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage();
            $token  = $plat_storage->getCompAccessToken();
            $plat_cfg   = plum_parse_config('platform', 'weixin');

            $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token={$token}";
            $params     = array(
                'component_appid'   => $plat_cfg['app_id'],
                'authorization_code'=> $code,
            );

            $result     = Libs_Http_Client::post($req_url, json_encode($params));
            $result     = json_decode($result, true);

            $info   = $result['authorization_info'];
            $access_token = $info['authorizer_access_token'];
            $body   = array(
                "touser"    => $this->wx_openid,
                "msgtype"   => "text",
                "text"     => array("content" => $code.'_from_api'),
            );

            $send_url   = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
            Libs_Http_Client::post($send_url, json_encode($body, JSON_UNESCAPED_UNICODE));

            $this->sendEmptyResponse();
        } else {
            //$this->sendTextResponse('test');
        }
    }
}