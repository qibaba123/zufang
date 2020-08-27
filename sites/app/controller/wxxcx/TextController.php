<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/29
 * Time: 上午11:24
 */

class App_Controller_Wxxcx_TextController extends App_Controller_Wxxcx_BaseController{

    public function __construct($weixin_msg) {
        parent::__construct($weixin_msg);
    }

    public function indexAction() {
        $content    = $this->weixinMsg['Content'];
        if (substr_compare($content, 'QUERY_AUTH_CODE', 0, 15) === 0 || $content == 'TESTCOMPONENT_MSG_TYPE_TEXT') {
            $this->_qwfb_text($content);
        } else {
            $this->_transfer_text_message();

        }
    }
    /*
     * 转发文本消息到聊天系统
     */
    private function _transfer_text_message() {
        $content    = $this->weixinMsg['Content'];
        $chatmsg_model  = new App_Model_Wechat_MysqlChatMsgStorage($this->sid);
        $indata     = array(
            'sc_s_id'       => $this->sid,
            'sc_openid'     => $this->wx_openid,
            'sc_content'    => $content,
            'sc_type'       => $chatmsg_model::CHAT_TYPE_TEXT,
            'sc_from'       => $chatmsg_model::CHAT_FROM_CUSTOMER,
            'sc_create_time'=> time(),
        );
        $chatmsg_model->insertValue($indata);
        $chatlist_model = new App_Model_Wechat_MysqlChatListStorage($this->sid);
        $chatlist_model->insertUpdateList($this->wx_openid, $content);

        //发起自动回复
        $this->_auto_reply_msg($this->weixinMsg['openid'], $content);

        $gateway_client = new App_Plugin_Gateway_Client();
        //当前店铺所在APP是否在线
        if ($gateway_client->isUidOnline($this->sid)) {
            $msg = array('openid'=>$this->weixinMsg['openid'],'msg' => $content, 'type' => 'txt');
            $gateway_client->sendToUid($this->sid, json_encode($msg));
        }
//        else {
//            //设置不在线,通过极光推送形式
//            $notice_model = new App_Helper_JiguangPush($this->sid);
//            $notice_model->pushNotice($notice_model::CUSTOMER_SERVICE_NEWS,'','notification');
//            // 信鸽推送不再使用,2019.1.14
//            $help_model = new App_Helper_XingePush($this->sid);
//            $help_model->pushNotice($help_model::CUSTOMER_SERVICE_NEWS);  // 收到客服消息推送通知
//        }
        // 在不在线都进行推送
        $notice_model = new App_Helper_JiguangPush($this->sid);
        $notice_model->pushNotice($notice_model::CUSTOMER_SERVICE_NEWS,'','message');
    }

    private function _auto_reply_msg($openid, $content){
        $msg_model  = new App_Model_Applet_MysqlAppletServiceMsgStorage($this->sid);
        //先精准匹配关键字
        $msg = $msg_model->getRowByKeyword($content, 1);
        if(!$msg){
            //模糊匹配
            $msg = $msg_model->getRowByKeyword($content, 2);
        }
        if(!$msg){
            //取出未匹配到关键字的默认回复
            $msg = $msg_model->getRowByKeyword($content, 3);
        }

        if($msg){
            $msg_plugin = new App_Plugin_Weixin_CustomerMsg($this->sid);
            switch ($msg['asm_type']){
                case "text":
                    $msg_plugin->sendTextMsg($openid, $msg['asm_content']);
                    break;
                case "image":
                    $msg_plugin->sendImageMsg($openid, $msg['asm_cover']);
                    break;
                case "link":
                    $msg_plugin->sendLinkMsg($openid, $msg['asm_title'], $msg['asm_desc'], $msg['asm_url'], plum_deal_image_url($msg['asm_cover']));
                    break;
                case "miniprogrampage":
                    $msg_plugin->sendCardMsg($openid, $msg['asm_title'],$msg['asm_path'], $msg['asm_cover']);
                    break;
            }
        }
    }

    /*
     * 全网发布测试,可注释
     */
    private function _qwfb_text($content) {
        Libs_Log_Logger::outputLog($this->weixinMsg);
        $tmp    = explode(':', $content);
        $code   = $tmp[1];

        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage($this->from);
        $token  = $plat_storage->getCompAccessToken();
        $platform   = plum_parse_config('platform', 'wxxcx');
        $plat_cfg   = $platform[$this->from];

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
            "text"      => array("content" => $code.'_from_api'),
        );
        Libs_Log_Logger::outputLog($body);
        $send_url   = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($body, JSON_UNESCAPED_UNICODE));

        $result     = json_decode($result, true);
        //记录错误
        Libs_Log_Logger::outputLog($result);

        $body['text'] = array("content" => 'TESTCOMPONENT_MSG_TYPE_TEXT_callback');
        $result     = Libs_Http_Client::post($send_url, json_encode($body, JSON_UNESCAPED_UNICODE));

        $result     = json_decode($result, true);
        //记录错误
        Libs_Log_Logger::outputLog($result);
    }
}