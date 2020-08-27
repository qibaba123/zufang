<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 18/10/15
 * Time: 上午10:51
 */
class App_Helper_Baidu {
    private $sid;
    private $shop;

    public function __construct($sid) {
        $this->sid  = $sid;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop = $shop_model->getRowById($sid);
    }

    /**百度小程序用户
     * 获取用户的openid 和 session_key
     * @param $appid 小程序的appid
     * @param $appSecret  小程序的appsecret
     * @param $code  用户换取openID的code
     * @return mixed|string 返回openid 和session_key
     */
    static public function getBdopenid($appKey,$appSecret,$code){
        // 获取session_key和openid的地址
        $session_url = "https://openapi.baidu.com/nalogin/getSessionKeyByCode?client_id={$appKey}&sk={$appSecret}&code={$code}";
        $result = file_get_contents($session_url);
        // 将获取的数据转换
        $result = json_decode($result,true);
        if ($result['openid']) {
            return $result;
        }
        //记录错误
        Libs_Log_Logger::outputLog($result);
        return false;
    }
}