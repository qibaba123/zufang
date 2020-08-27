<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/25
 * Time: 上午9:16
 */
class App_Model_Group_RedisOrgStorage extends Libs_Redis_RedisClient {
    /*
     * 店铺id
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }
    /*
     * 记录组团定时任务
     */
    public function recordOvertimeTask($goid, $left) {
        $left   = intval($left);


        if ($left > 0) {
            $this->redis->select(5);//操作5号数据库
            $key    = "group_buy_over_{$this->sid}_{$goid}";
            //距离结束倒计时12小时,6小时任务
            $key1   = "group_buy_countdown1_{$this->sid}_{$goid}";
            $key2   = "group_buy_countdown2_{$this->sid}_{$goid}";

            $left1  = $left - 12*60*60;
            $left2  = $left - 6*60*60;

            $this->redis->setex($key, $left, $key);

            if ($left1 > 0) {
                $this->redis->setex($key1, $left1, $key1);
            }

            if ($left2 > 0) {
                $this->redis->setex($key2, $left2, $key2);
            }
            //距离开团成功36小时,45小时定时任务
            $key3   = "group_buy_goods_{$this->sid}_{$goid}";
            $key4   = "group_buy_shop_{$this->sid}_{$goid}";

            $left3  = 36*60*60;
            $left4  = 45*60*60;

            $this->redis->setex($key3, $left3, $key3);
            $this->redis->setex($key4, $left4, $key4);
            return true;
        } else {
            return false;
        }
    }
    /*
     * 删除组团超时任务
     */
    public function deleteOvertimeTask($goid) {
        $this->redis->select(5);//操作5号数据库
        //活动开始倒计时
        $key        = "group_buy_over_{$this->sid}_{$goid}";
        //距离结束倒计时12小时,6小时任务
        $key1   = "group_buy_countdown1_{$this->sid}_{$goid}";
        $key2   = "group_buy_countdown2_{$this->sid}_{$goid}";

        $this->redis->del($key1);
        $this->redis->del($key2);
        return $this->redis->del($key);
    }
    /*
     * 获取超时任务的剩余时间
     */
    public function fetchTaskTtl($goid) {
        $this->redis->select(5);//操作5号数据库
        $key    = "group_buy_over_{$this->sid}_{$goid}";
        return  $this->redis->ttl($key);
    }
    /*
     * 记录活动结束剩余时间
     *
     * @param int $end 结束时间Unix时间戳
     */
    public function recordActEndTime($gbid, $end) {
        $left   = intval($end)-time();
        if ($left > 0) {
            $this->redis->select(5);//操作5号数据库
            $key    = "group_buy_actend_{$this->sid}_{$gbid}";
            return $this->redis->setex($key, $left, $key);
        } else {
            return false;
        }
    }
    /*
     * 删除活动结束剩余时间
     */
    public function deleteActEndTime($gbid) {
        $this->redis->select(5);//操作5号数据库
        //活动开始倒计时
        $key        = "group_buy_actend_{$this->sid}_{$gbid}";
        return $this->redis->del($key);
    }

    /*
     * 记录组团定时任务
     */
    public function merchantRecordOvertimeTask($goid, $left) {
        $left   = intval($left);

        if ($left > 0) {
            $this->redis->select(5);//操作5号数据库
            $key    = "merchant_group_over_{$this->sid}_{$goid}";
            //距离结束倒计时12小时,6小时任务
            $key1   = "merchant_group_countdown1_{$this->sid}_{$goid}";
            $key2   = "merchant_group_countdown2_{$this->sid}_{$goid}";

            $left1  = $left - 12*60*60;
            $left2  = $left - 6*60*60;

            $this->redis->setex($key, $left, $key);

            if ($left1 > 0) {
                $this->redis->setex($key1, $left1, $key1);
            }

            if ($left2 > 0) {
                $this->redis->setex($key2, $left2, $key2);
            }
            //距离开团成功36小时,45小时定时任务
            $key3   = "merchant_group_goods_{$this->sid}_{$goid}";
            $key4   = "merchant_group_shop_{$this->sid}_{$goid}";

            $left3  = 36*60*60;
            $left4  = 45*60*60;

            $this->redis->setex($key3, $left3, $key3);
            $this->redis->setex($key4, $left4, $key4);
            return true;
        } else {
            return false;
        }
    }
    /*
     * 删除组团超时任务
     */
    public function merchantDeleteOvertimeTask($goid) {
        $this->redis->select(5);//操作5号数据库
        //活动开始倒计时
        $key        = "merchant_group_over_{$this->sid}_{$goid}";
        //距离结束倒计时12小时,6小时任务
        $key1   = "merchant_group_countdown1_{$this->sid}_{$goid}";
        $key2   = "merchant_group_countdown2_{$this->sid}_{$goid}";

        $this->redis->del($key1);
        $this->redis->del($key2);
        return $this->redis->del($key);
    }
    /*
     * 获取超时任务的剩余时间
     */
    public function merchantFetchTaskTtl($goid) {
        $this->redis->select(5);//操作5号数据库
        $key    = "merchant_group_over_{$this->sid}_{$goid}";
        return  $this->redis->ttl($key);
    }
    /*
     * 记录活动结束剩余时间
     *
     * @param int $end 结束时间Unix时间戳
     */
    public function merchantRecordActEndTime($gbid, $end) {
        $left   = intval($end)-time();
        if ($left > 0) {
            $this->redis->select(5);//操作5号数据库
            $key    = "merchant_group_actend_{$this->sid}_{$gbid}";
            return $this->redis->setex($key, $left, $key);
        } else {
            return false;
        }
    }
    /*
     * 删除活动结束剩余时间
     */
    public function merchantDeleteActEndTime($gbid) {
        $this->redis->select(5);//操作5号数据库
        //活动开始倒计时
        $key        = "merchant_group_actend_{$this->sid}_{$gbid}";
        return $this->redis->del($key);
    }
}