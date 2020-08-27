<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/10
 * Time: 下午9:00
 */
class App_Model_Unitary_RedisPlanStorage extends Libs_Redis_RedisClient {
    private $seq_prefix = "plan_seq_";
    /*
     * 店铺id
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }

    /*
     * 创建夺宝计划号码序列
     */
    public function createPlanSeq($pid, $total) {
        //首先移除原有的集合，防止数据冲突
        $this->redis->del($this->seq_prefix.$pid);
        $base   = App_Helper_UnitaryOrder::UNITARY_PLAN_BASE;//基数
        for ($i=1; $i<=$total; $i++) {
            $val = $base+$i;
            $this->redis->sAdd($this->seq_prefix.$pid, $val);
        }
    }

    /*
     * 获取某个夺宝计划，号码剩余量
     */
    public function fetchPlanLeft($pid) {
        return $this->redis->sCard($this->seq_prefix.$pid);
    }

    /*
     * 获取某个夺宝计划随机号码
     */
    public function fetchRandomNum($pid) {
        $left   = $this->fetchPlanLeft($pid);
        if ($left) {
            return $this->redis->sPop($this->seq_prefix.$pid);
        }
        return 0;
    }

    /*
     * 移除夺宝计划号码序列
     */
    public function removePlanSeq($pid) {
        return $this->redis->del($this->seq_prefix.$pid);
    }

    /*
     * 创建夺宝计划计算及放开倒计时
     */
    public function createPlanCountdown($pid, $ttl) {
        $this->redis->select(1);//操作1号数据库
        //计算倒计时
        $key    = "unitary_plan_compute_{$this->sid}_{$pid}";
        $this->redis->setex($key, $ttl, $key);
        //放开倒计时
        $key    = "unitary_plan_publish_{$this->sid}_{$pid}";
        $this->redis->setex($key, 2*$ttl, $key);
        return true;
    }

    /*
     * 创建定时红包计算倒计时
     */
    public function createRedpackCountdown($pid, $ttl) {
        $this->redis->select(1);//操作1号数据库
        //计算倒计时
        $key    = "unitary_redpack_compute_{$this->sid}_{$pid}";
        $this->redis->setex($key, $ttl, $key);
        //抢红包倒计时
        $key    = "unitary_redpack_award_{$this->sid}_{$pid}";
        $ttl    = $ttl+App_Helper_UnitaryOrder::UNITARY_REDPACK_AWARD;//增加五分钟抢红包时间
        $this->redis->setex($key, $ttl, $key);

        return true;
    }
    /*
     * 创建夺宝计划自动填充倒计时
     */
    public function createPlanAutoFill($pid, $ttl) {
        $this->redis->select(1);

        $key    = "unitary_plan_fill_{$this->sid}_{$pid}";
        $this->redis->setex($key, $ttl, $key);
    }
    /*
     * 移除已创建的夺宝计划自动填充倒计时
     */
    public function removePlanAutoFill($pid) {
        $this->redis->select(1);

        $key    = "unitary_plan_fill_{$this->sid}_{$pid}";
        $this->redis->del($key);
    }
    /**
     * 移除定时红包的计算倒计时
     */
    public function removeCreateRedpackCountdown($pid) {
        $this->redis->select(1);
        $key    = "unitary_redpack_compute_{$this->sid}_{$pid}";
        $this->redis->del($key);
    }
    /**
     * 移除定时红包的倒计时
     */
    public function removeRedpackCountdown($pid) {
        $this->redis->select(1);
        $key    = "unitary_redpack_award_{$this->sid}_{$pid}";
        $this->redis->del($key);
    }
}