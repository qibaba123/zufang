<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/7/4
 * Time: 上午8:10
 */
require_once __DIR__ . '/Gateway.php'; 

use GatewayClient\Gateway;

class App_Plugin_Gateway_Client {

    public function __construct() {
        Gateway::$registerAddress   = '127.0.0.1:2238';
    }

    /**
     * 客户端ID与用户ID绑定
     * @param int $client_id
     * @param int|string $uid
     * @return bool
     */
    public function bindUid($client_id, $uid) {
        return Gateway::bindUid($client_id, $uid);
    }

    /**
     * 向用户ID发送消息
     * @param int|string $uid
     * @param string $message
     */
    public function sendToUid($uid, $message) {
        Gateway::sendToUid($uid, $message);
    }

    /**
     * 判断当前用户的设备是否在线
     * @param $uid
     * @return int
     */
    public function isUidOnline($uid) {
        $uid    = strval($uid);
        return Gateway::isUidOnline($uid);
    }

    /**
     * 向所有客户端用户发送消息
     * @param $message
     */
    public function sentToAll($message) {
        Gateway::sendToAll($message);
    }
}