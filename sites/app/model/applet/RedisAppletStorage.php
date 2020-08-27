<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/6/29
 * Time: 下午2:45
 */
class App_Model_Applet_RedisAppletStorage extends Libs_Redis_RedisClient {
    /*
     * 店铺id
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }

    public function setMsgForward($forward = true) {
        $forward    = $forward ? 1 : 0;

        $key    = "wxxcx_msg_forward_flag_".$this->sid;
        return $this->redis->set($key, strval($forward));
    }

    public function getMsgForward() {
        $key    = "wxxcx_msg_forward_flag_".$this->sid;
        $val    = $this->redis->get($key);
        $val    = is_string($val) ? intval($val) : 0;

        return $val;
    }
    /*
     * 记录置顶帖子任务
     * @param int $left 剩余时间,单位秒
     */
    public function recordTopPostTask($postid, $left) {
        $left   = intval($left);
        if ($left > 0) {
            $this->redis->select(9);//操作9号数据库
            $key    = "forum_top_over_{$this->sid}_{$postid}";
            return $this->redis->setex($key, $left, $key);
        } else {
            return false;
        }
    }

    /*
 * 记录置顶职位任务
 * @param int $left 剩余时间,单位秒
 */
    public function recordTopPositionTask($positionid, $left) {
        $left   = intval($left);
        if ($left > 0) {
            $this->redis->select(9);//操作9号数据库
            $key    = "position_top_over_{$this->sid}_{$positionid}";
            return $this->redis->setex($key, $left, $key);
        } else {
            return false;
        }
    }
    /*
     * 删除记录的置顶帖子任务
     */
    public function deleteTopPostTask($postid) {
        $this->redis->select(9);//操作9号数据库
        //活动开始倒计时
        $key        = "forum_top_over_{$this->sid}_{$postid}";
        return $this->redis->del($key);
    }

    /*
  * 删除记录的置顶职位任务
  */
    public function deleteTopPositionTask($positionid) {
        $this->redis->select(9);//操作9号数据库
        //活动开始倒计时
        $key        = "position_top_over_{$this->sid}_{$positionid}";
        return $this->redis->del($key);
    }

    /*
     * 记录红包退款任务
     * @param int $left 剩余时间,单位秒
     */
    public function recordRedbagTask($postid, $left) {
        $left   = intval($left);
        if ($left > 0) {
            $this->redis->select(9);//操作9号数据库
            $key    = "forum_bag_over_{$this->sid}_{$postid}";
            return $this->redis->setex($key, $left, $key);
        } else {
            return false;
        }
    }
    /*
     * 删除记录的红包退款任务
     */
    public function deleteRedbagTask($postid) {
        $this->redis->select(9);//操作9号数据库
        //活动开始倒计时
        $key        = "forum_bag_over_{$this->sid}_{$postid}";
        return $this->redis->del($key);
    }

    /*
 * 记录置顶帖子任务
 * @param int $left 剩余时间,单位秒
 */
    public function recordTopHouseTask($hid, $left) {
        $left   = intval($left);
        if ($left > 0) {
            $this->redis->select(9);//操作9号数据库
            $key    = "house_top_over_{$this->sid}_{$hid}";
            return $this->redis->setex($key, $left, $key);
        } else {
            return false;
        }
    }
    /*
     * 删除记录的置顶帖子任务
     */
    public function deleteTopHouseTask($hid) {
        $this->redis->select(9);//操作5号数据库
        //活动开始倒计时
        $key        = "house_top_over_{$this->sid}_{$hid}";
        return $this->redis->del($key);
    }

    /*
     * 记录多店置顶帖子任务
     * @param int $left 剩余时间,单位秒
     */
    public function recordCommunityTopPostTask($postid, $left) {
        $left   = intval($left);
        if ($left > 0) {
            $this->redis->select(9);//操作9号数据库
            $key    = "community_top_over_{$this->sid}_{$postid}";
            return $this->redis->setex($key, $left, $key);
        } else {
            return false;
        }
    }
     /*
     * 删除记录的置顶帖子任务
     */
    public function deleteCommunityTopPostTask($postid) {
        $this->redis->select(9);//操作5号数据库
        //活动开始倒计时
        $key        = "community_top_over_{$this->sid}_{$postid}";
        return $this->redis->del($key);
    }

    /*
     * 获取上次推送时间节点
     */
    public function getPushLast($sid) {
        $left   = $this->redis->ttl('push_left_last_'.$sid);

        $left   = $left > 0 ? $left : 0;
        return $left;
    }
    /*
     * 设置推送时间节点
     */
    public function setPushLast($sid, $ttl = 0) {
        return $this->redis->setex('push_left_last_'.$sid, $ttl, "last");
    }

    /*
     * 设置社区团购商品到货推送时间节点
     */
    public function setGoodsGetPushLast($sid,$gid, $ttl = 0) {
        return $this->redis->setex('goodsget_push_left_last_'.$sid.'_'.$gid, $ttl, "last");
    }

    /*
     * 设置跑腿通知推送时间节点
     */
    public function setLegworkNoticePushLast($sid,$id, $ttl = 0) {
        return $this->redis->setex('legworknotice_push_left_last_'.$sid.'_'.$id, $ttl, "last");
    }
    /*
     * 获取社区团购商品到货上次推送时间节点
     */
    public function getLegworkNoticePushLast($sid,$id) {
        $left   = $this->redis->ttl('legworknotice_push_left_last_'.$sid.'_'.$id);

        $left   = $left > 0 ? $left : 0;
        return $left;
    }

    /*
     * 获取社区团购商品到货上次推送时间节点
     */
    public function getGoodsGetPushLast($sid,$gid) {
        $left   = $this->redis->ttl('goodsget_push_left_last_'.$sid.'_'.$gid);

        $left   = $left > 0 ? $left : 0;
        return $left;
    }

    /*
     * 设置社区团购团长商品到货推送时间节点
     */
    public function setGoodsGetPushLastLeader($sid,$gid,$leader, $ttl = 0) {
        return $this->redis->setex('goodsget_push_left_last_'.$sid.'_'.$gid.'_'.$leader, $ttl, "last");
    }

    /*
     * 获取社区团购商品到货上次推送时间节点
     */
    public function getGoodsGetPushLastLeader($sid,$gid,$leader) {
        $left   = $this->redis->ttl('goodsget_push_left_last_'.$sid.'_'.$gid.'_'.$leader);

        $left   = $left > 0 ? $left : 0;
        return $left;
    }

    public function setCookie($cookie) {
        $key    = "sougou_weixin_applet_gzh";
        return $this->redis->set($key, strval($cookie));
    }

    public function getCookie() {
        $key    = "sougou_weixin_applet_gzh";
        $val    = $this->redis->get($key);
        return $val;
    }

    /**
     * 记录商户入驻到期提醒
     */
    public function enterOvertimeTask($shid, $left) {
        $left   = intval($left);

        if ($left > 0) {
            $this->redis->select(9);//操作5号数据库
            //距离到期还有1天  7天  15天 提醒
            $key1   = "city_enter_expire1_{$this->sid}_{$shid}";
            $key7   = "city_enter_expire7_{$this->sid}_{$shid}";
            $key15  = "city_enter_expire15_{$this->sid}_{$shid}";

            $left1  = $left - 24*60*60;
            $left7  = $left - 24*60*60*7;
            $left15 = $left - 24*60*60*15;

            if ($left1 > 0) {
                $this->redis->setex($key1, $left1, $key1);
            }

            if ($left7 > 0) {
                $this->redis->setex($key7, $left7, $key7);
            }

            if ($left15 > 0) {
                $this->redis->setex($key15, $left15, $key15);
            }
            return true;
        } else {
            return false;
        }
    }

    /*
     * 招聘领取入职奖
     * $tid 订单ID
     */
    public function setReceivedAwardTtl($rid, $ttl) {
        $this->redis->select(9);//操作9号数据库
        //计算倒计时
        $key    = "job_award_entry_{$this->sid}_{$rid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }

    //获取领取倒计时
    public function getReceivedAwardTtl($rid) {
        $this->redis->select(9);

        $key    = "job_award_entry_{$this->sid}_{$rid}";
        return  $this->redis->ttl($key);
    }

    /*
 * 删除订单超时完成倒计时
 */
    public function delReceivedAward($rid) {
        $this->redis->select(9);//操作9号数据库
        //计算倒计时
        $key    = "job_award_entry_{$this->sid}_{$rid}";
        return $this->redis->del($key);
    }

    public function setConfirmInterviewTtl($sid, $ttl){
        $this->redis->select(9);//操作9号数据库
        //计算倒计时
        $key    = "job_confirm_interview_{$this->sid}_{$sid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }

    public function delConfirmInterview($sid) {
        $this->redis->select(9);//操作9号数据库
        //计算倒计时
        $key    = "job_confirm_interview_{$this->sid}_{$sid}";
        return $this->redis->del($key);
    }

    /**
     * 拍卖结束倒计时
     */
    public function setAuctionEndTtl($aid, $ttl){
        $this->redis->select(9);//操作9号数据库
        //计算倒计时
        $key    = "auction_activity_end_{$this->sid}_{$aid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }

    /**
     * 拍卖获拍支付倒计时
     */
    public function setAuctionTradeCloseTtl($tid, $ttl){
        $this->redis->select(9);//操作9号数据库
        //计算倒计时
        $key    = "auction_trade_close_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }

    /*
     * 获取订单关闭前失效时间
     */
    public function getAuctionTradeCloseTtl($tid) {
        $this->redis->select(9);//操作9号数据库
        //计算倒计时
        $key    = "auction_trade_close_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }

    /*
     * 删除进行中的订单失效倒计时
     */
    public function delAuctionTradeClose($tid) {
        $this->redis->select(9);//操作9号数据库
        //计算倒计时
        $key    = "auction_trade_close_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }


    /*
     * 设置城市天气预报过期时间
     * $tid 订单ID
     */
    public function setCityWeatherDataCloseTtl($city, $ttl,$value) {
        $this->redis->select(1);//操作1号数据库
        //计算倒计时
        $key    = "city_weather_close_{$city}";
        $this->redis->setex($key, $ttl, $value);
        return true;
    }

    public function fetchCityWeatherDataCloseTtl($city) {
        $this->redis->select(1);//操作1号数据库
        //计算倒计时
        $key    = "city_weather_close_{$city}";
        return $this->redis->get($key);
    }

    /*
     * 记录车源置顶任务
     * @param int $left 剩余时间,单位秒
     */
    public function recordTopCarTask($postid, $left) {
        $left   = intval($left);
        if ($left > 0) {
            $this->redis->select(9);//操作9号数据库
            $key    = "car_top_over_{$this->sid}_{$postid}";
            return $this->redis->setex($key, $left, $key);
        } else {
            return false;
        }
    }

    /*
     * 删除记录的置顶车源任务
     */
    public function deleteTopCarTask($postid) {
        $this->redis->select(9);//操作9号数据库
        //活动开始倒计时
        $key        = "car_top_over_{$this->sid}_{$postid}";
        return $this->redis->del($key);
    }

    public function setCashRemarkTid($tid, $remark) {
        $this->redis->select(9);//操作9号数据库
        $key    = "cash_remark_".$tid;
        $left = 60 * 5;
        return $this->redis->setex($key, $left, strval($remark));
    }

    public function getCashRemarkTid($tid) {
        $this->redis->select(9);//操作9号数据库
        $key    = "cash_remark_".$tid;
        $val    = $this->redis->get($key);
        return $val;
    }

    public function delCashRemarkTid($tid) {
        $this->redis->select(9);//操作9号数据库
        $key    = "cash_remark_".$tid;
        return $this->redis->del($key);
    }

    /*
     * 获取入驻店铺提现key
     */
    public function getEnterShopWithdraw($id) {
        $this->redis->select(9);//操作9号数据库

        $left   = $this->redis->ttl('enter_shop_withdraw_'.$id);
        $left   = $left > 0 ? $left : 0;
        return $left;
    }

    /*
     * 设置入驻店铺提现key
     */
    public function setEnterShopWithdraw($id, $ttl = 0) {
        $this->redis->select(9);//操作9号数据库

        return $this->redis->setex('enter_shop_withdraw_'.$id, $ttl, 'enter_shop_withdraw_'.$id);
    }

    /*
    * 获取店铺请求频率每秒
    */
    public function getShopRequestFrequency($suid, $limit) {
        $key    = "wxxcx_applet_request_".$suid;     //小程序请求信息
        $check  = $this->redis->exists($key);
        $count  = 1;
        if($check){
            $count = $this->redis->incr($key);  //键值递增
            if ($count > $limit) {
                $this->redis->del($key);
            }
        }else{
            //利用事务执行原子操作
            $this->redis->multi();
            $this->redis->incr($key);
            $this->redis->expire($key,2);
            $this->redis->exec();
        }
        return $count;
    }

    /*
     * 获得请求拒绝key
     */
    public function getShopRequestRefuse($suid){
        $key    = "wxxcx_applet_request_refuse_".$suid;
        $check = $this->redis->exists($key);
        if($check){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 设置请求拒绝key
     */
    public function setShopRequestRefuse($suid,$ttl = 5){
        $key    = "wxxcx_applet_request_refuse_".$suid;
        $this->redis->del($key);
        $this->redis->setex($key, $ttl, $key);
    }


    /*
     * 记录社区团购置顶帖子任务
     * @param int $left 剩余时间,单位秒
     */
    public function recordSequenceTopPostTask($postid, $left) {
        $left   = intval($left);
        if ($left > 0) {
            $this->redis->select(9);//操作9号数据库
            $key    = "sequence_top_over_{$this->sid}_{$postid}";
            return $this->redis->setex($key, $left, $key);
        } else {
            return false;
        }
    }
    /*
    * 删除记录的置顶帖子任务
    */
    public function deleteSequenceTopPostTask($postid) {
        $this->redis->select(9);//操作5号数据库
        //活动开始倒计时
        $key        = "sequence_top_over_{$this->sid}_{$postid}";
        return $this->redis->del($key);
    }

}