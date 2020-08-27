<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午11:14
 */
class App_Model_Member_RedisMemberStorage extends Libs_Redis_RedisClient {
    /*
     * 店铺id
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }
    /*
     * 创建推广二维码发送事件
     */
    public function createQrcodeEvent($mid) {
        $ttl    = 2;//2秒后执行
        $this->redis->select(2);//操作2号数据库
        //计算倒计时
        $key    = "member_weixin_qrcode_{$this->sid}_{$mid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 创建拉取微信所有会员事件
     * @param int $ttl 多少秒后执行
     */
    public function createPullEvent($ttl) {
        $this->redis->select(2);//操作2号数据库
        //计算倒计时
        $key    = "member_weixin_pull_{$this->sid}_{$this->sid}";
        return $this->redis->setex($key, $ttl, $key);
    }

    /*
     * 获取店铺会员id的最大值
     */
    public function fetchShopMaxShowId(){
        $this->redis->select(4); //操作4号数据库
        $key = "member_show_max_{$this->sid}_{$this->sid}";
        return $this->redis->incr($key);
    }

    /*
     * 设置店铺会员id的最大值
     *
     */
    public function setShopMaxShowId($val){
        $this->redis->select(4); //操作4号数据库
        $key = "member_show_max_{$this->sid}_{$this->sid}";
        return $this->redis->incrBy($key,$val);
    }

    /*
     *减少店铺的会员id的最大值
     */
    public function decrShopMaxShowId(){
        $this->redis->select(4); //操作4号数据库
        $key = "member_show_max_{$this->sid}_{$this->sid}";
        return $this->redis->DECR($key);
    }

    public function decrShopMaxShowIdVal($val){
        $this->redis->select(4); //操作4号数据库
        $key = "member_show_max_{$this->sid}_{$this->sid}";
        return $this->redis->DECRBY($key,$val);
    }
}