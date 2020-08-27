<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/13
 * Time: 上午11:44
 */

class App_Model_Shop_RedisOrderStatusStorage extends Libs_Redis_RedisClient {
    private $hash_prefix  = 'order_status_';
    /*
     * 店铺id
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }

    /*
     * 添加新的订单状态到hash表
     */
    public function addNewToHash($tid, $status) {
        return $this->redis->hSet($this->hash_prefix.$this->sid, $tid, $status);
    }

    /*
     * 将订单从hash表中移除
     */
    public function delTidFromHash($tid) {
        return $this->redis->hDel($this->hash_prefix.$this->sid, $tid);
    }

    /*
     * 从hash表中获取所有的订单数据
     */
    public function getAllTidFromHash() {
        return $this->redis->hGetAll($this->hash_prefix.$this->sid);
    }
}