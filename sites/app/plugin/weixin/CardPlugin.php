<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/5/8
 * Time: 下午9:31
 */
class App_Plugin_Weixin_CardPlugin extends App_Plugin_Weixin_ClientPlugin {

    public $api_ticket=null;


    public function __construct($sid){
        parent::__construct($sid);
    }

    /*
     * 获取所有的卡券列表
     * @param int $count <= 50
     */
    public function fetchCardList($index = 0, $count = 10) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/card/batchget";

        $getp   = array(
            'access_token'  => $this->access_token,
        );
        $params = array(
            'offset'        => $index,
            'count'         => $count,
        );
        $url = $url . '?' . http_build_query($getp);

        $result = Libs_Http_Client::post($url, json_encode($params));
        $result = json_decode($result, true);
        Libs_Log_Logger::outputLog($result);
        if (isset($result['errcode']) && $result['errcode']) {
            //产生错误
            Libs_Log_Logger::outputLog($result);
            Libs_Log_Logger::outputLog("店铺ID={$this->sid}");
            return false;
        } else {
            return $result;
        }
    }
    /*
     * 获取卡券详情
     */
    public function fetchCardDetail($card_id) {
        if (!$this->access_token) {
            return false;
        }
        $url    = "https://api.weixin.qq.com/card/get";

        $getp   = array(
            'access_token'  => $this->access_token,
        );
        $params = array(
            'card_id'       => $card_id,
        );
        $url = $url . '?' . http_build_query($getp);

        $result = Libs_Http_Client::post($url, json_encode($params));
        $result = json_decode($result, true);

        if (isset($result['errcode']) && $result['errcode']) {
            //产生错误
            Libs_Log_Logger::outputLog($result);
            Libs_Log_Logger::outputLog("店铺ID={$this->sid}");
            return false;
        } else {
            return $result;
        }
    }
    /*
     * 客服接口发送卡券
     * 微信认证的服务号可用
     * 仅支持非自定义Code码和导入code模式的卡券的卡券
     */
    public function sendCardMessage($toUser, $card_id) {
        if (!$this->access_token) {
            return false;
        }
        $body   = array(
            "touser"    => $toUser,
            "msgtype"   => "wxcard",
            "wxcard"    => array("card_id" => $card_id),
        );

        $send_url   = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$this->access_token}";
        $result     = Libs_Http_Client::post($send_url, json_encode($body, JSON_UNESCAPED_UNICODE));
        return $result;
    }

    /**获取微信卡券的api_tacket
     * 1.参考以下文档获取access_token（有效期7200秒，开发者必须在自己的服务全局缓存access_token）：../15/54ce45d8d30b6bf6758f68d2e95bc627.html
     * 2.用第一步拿到的access_token 采用http GET方式请求获得卡券 api_ticket（有效期7200秒，开发者必须在自己的服务全局缓存卡券 api_ticket）
     * ：https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=wx_card
     */

    public function getApiTicketAction(){
        if($this->weixin['wc_card_api_ticket'] && $this->weixin['wc_card_ticket_expire']>time()){
            $ticket = $this->weixin['wc_card_api_ticket'];
        }else{
            if (!$this->access_token) {
                return false;
            }
            $send_url   = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$this->access_token}&type=wx_card";
            $result     = Libs_Http_Client::get($send_url);
            $result = json_decode($result, true);
            if ($result['errcode']==0) {
                $updata = array(
                    'wc_card_api_ticket' => $result['ticket'],
                    'wc_card_ticket_expire' => time()+$result['expires_in'],
                );
                $weixin_storage = new App_Model_Auth_MysqlWeixinStorage();
                $weixin_storage->updateBySId($updata, $this->sid);
                $ticket = $result['ticket'];
            } else {
                //产生错误
                Libs_Log_Logger::outputLog($result);
                Libs_Log_Logger::outputLog("店铺ID={$this->sid}");
                return false;
            }
        }
        return $ticket;
    }

    /*
     * 生成签名
     * @param string $appkey 微信卡券的签名
     */
    public static function getCardSignature(array $fields) {
        //签名步骤一：按字符串型字典序排序参数
        asort($fields,SORT_STRING);
        //签名步骤二：sha1加密
        $result = sha1(implode($fields));
        return $result;
    }

}