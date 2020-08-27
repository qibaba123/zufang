<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/6
 * Time: 上午11:39
 */
class App_Model_Coupon_RedisCouponStorage extends Libs_Redis_RedisClient {
    /*
     * 店铺id
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }
    /*
     * 设置优惠券即将失效通知
     * @param int $crid 领取记录ID
     * @param int $end 优惠券终止时间
     */
    public function setCouponInvalidNotice($crid, $end) {
        $left   = intval($end)-time();
        //根据当前时间,决定在过期前60、36、12小时提醒
        if ($left > 60*60*60) {
            $tip    = $left-60*60*60;
        } else if ($left > 36*60*60) {
            $tip    = $left-36*60*60;
        } else if ($left > 12*60*60) {
            $tip    = $left-12*60*60;
        } else {
            $tip    = 0;
        }
        
        if ($tip > 0) {
            $this->redis->select(2);//操作2号数据库
            $key    = "coupon_receive_invalid_{$this->sid}_{$crid}";
            return $this->redis->setex($key, $tip, $key);
        } else {
            return false;
        }
    }
}