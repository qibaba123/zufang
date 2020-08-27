<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/6
 * Time: 下午8:31
 */
class App_Model_Redpack_RedisRedpackStorage extends Libs_Redis_RedisClient {
    /*
     * 店铺id
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }
    /*
     * 检查红包领取情况
     * @param int $crid 领取记录ID
     * @param int $end 优惠券终止时间
     */
    public function setRedpackCheck($rrid) {
        $ttl    = 60*60;//1小时后检查红包领取情况
        $this->redis->select(2);//操作2号数据库
        $key    = "redpack_send_feedback_{$this->sid}_{$rrid}";
        return $this->redis->setex($key, $ttl, $key);
    }
    /*
     * 添加关键词到集合中
     */
    public function addKeywordSet($keyword) {
        $this->redis->select(2);
        $key    = "redpack_keyword_set_{$this->sid}";
        return $this->redis->sAdd($key, $keyword);
    }
    /*
     * 从集合中移除指定的关键词
     */
    public function remKeywordSet($keyword) {
        $this->redis->select(2);
        $key    = "redpack_keyword_set_{$this->sid}";
        return $this->redis->sRem($key, $keyword);
    }
    /*
     * 获取关键词集合中所有成员
     */
    public function getKeywordSet() {
        $this->redis->select(2);
        $key    = "redpack_keyword_set_{$this->sid}";
        return $this->redis->sMembers($key);
    }
}