<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/12
 * Time: 下午2:50
 */

class App_Model_Shop_RedisShopQueueStorage extends Libs_Redis_RedisClient {
    private $list_name  = 'youzan_auth_shop';

    private $hash_name  = 'manage_shop_hash';
    private $menu_hash_name  = 'manage_menu_type_hash';
//    private $entershop_hash_name  = 'manage_entershop_hash';
    public function __construct() {
        parent::__construct();
    }

    /*
     * 将店铺ID放置到队列尾部
     */
    public function pushSidToQueue($sid) {
        $this->redis->rPush($this->list_name, $sid);
    }

    /*
     * 从店铺队列头部移除并返回店铺id
     */
    public function popSidFromQueue() {
        return $this->redis->lPop($this->list_name);
    }

    /*************维护一个hash表，保存当前登录会员正在管理的店铺***********************/
    /*
     * 获取当前管理员管理的店铺id
     */
    public function getSidByUid($uid) {
        return $this->redis->hGet($this->hash_name, $uid);
    }
    /*
     * 设置当前管理员正在管理的店铺id
     */
    public function setSidWithUid($sid, $uid) {
        $this->redis->hSet($this->hash_name, $uid, $sid);
    }

    /*
     * 删除进行中的订单失效倒计时
     */
    public function delHashKey() {
        return $this->redis->del($this->hash_name);
    }

    /*************测试 维护一个hash表，保存当前登录会员正在管理的门店***********************/
    /*
     * 获取当前管理员管理的门店id
     */
//    public function getEsIdByUid($uid) {
//        return $this->redis->hGet($this->entershop_hash_name, $uid);
//    }
//    /*
//     * 设置当前管理员正在管理的门店id
//     */
//    public function setEsIdWithUid($sid, $uid) {
//        $this->redis->hSet($this->entershop_hash_name, $uid, $sid);
//    }
    /*************维护一个hash表，保存当前登录管理员正在管理的店铺类型（微信小程序wxapp，百度小程序bdapp，支付宝小程序aliapp）***********************/
    /*
        * 获取当前管理员管理的店铺id
        */
    public function getMenuTypeBySid($sid) {
        return $this->redis->hGet($this->menu_hash_name, $sid);
    }
    /*
     * 设置当前管理员正在管理的店铺id
     */
    public function setMenuTypeWithSid($sid, $menuType) {
        $this->redis->hSet($this->menu_hash_name, $sid, $menuType);
    }


    /*
     * 设置每天允许发短信数量
     * $limit：平台允许24小时发送短信数量200条
     */
    public function getEveryDaySendSms(){
        $limit = 200;
        $key    = "tiandiantong_every_send_sms_count";     //天店通平台每天发送短信数量
        $check  = $this->redis->exists($key);
        if($check){
            $count = $this->redis->incr($key);  //键值递增
        }else{
            $count = $this->redis->incr($key);
            $this->redis->expire($key,86400);
        }
        if($limit > $count){
            return true;
        }else{
            return false;
        }
    }

}