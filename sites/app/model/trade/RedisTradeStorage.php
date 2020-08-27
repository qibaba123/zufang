<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/26
 * Time: 上午11:55
 */
class App_Model_Trade_RedisTradeStorage extends Libs_Redis_RedisClient {
    /*
     * 店铺id
     */
    private $sid;

    /*
     * $tid均为订单表自增ID
     */
    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }
  
  
      /*
 * 设置确认收货订单返佣时间
 */
    public function setTradeReturn($tid,$ttl) {
        $this->redis->select(3);//操作3号数据库

        $key    = "mall_trade_return_{$this->sid}_{$tid}";
        return  $this->redis->setex($key, $ttl, $key);
    }
  
    /*
     * 设置订单关闭失效时间
     * $tid 订单ID
     */
    public function setTradeCloseTtl($tid, $ttl) {
  
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_close_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获取订单关闭前失效时间
     */
    public function getTradeCloseTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_close_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的订单失效倒计时
     */
    public function delTradeClose($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_close_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }
    /*
     * 设置订单超时完成时间
     * $tid 订单ID
     */
    public function setTradeFinishTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_finish_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }

    /*
     * 获取订单超时完成剩余时间
     */
    public function getTradeFinishTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_finish_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除订单超时完成倒计时
     */
    public function delTradeFinish($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_finish_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }
    /*
     * 设置待结算订单超时完成时间
     */
    public function setTradeSettledTtl($tsid, $ttl) {
        $this->redis->select(3);//操作3号数据库

        $key    = "mall_trade_settled_{$this->sid}_{$tsid}";
        return  $this->redis->setex($key, $ttl, $key);
    }

    public function getTradeSettledTtl($tsid) {
        $this->redis->select(3);

        $key    = "mall_trade_settled_{$this->sid}_{$tsid}";
        return  $this->redis->ttl($key);
    }

    public function delTradeSettledTtl($tsid) {
        $this->redis->select(3);

        $key    = "mall_trade_settled_{$this->sid}_{$tsid}";
        return  $this->redis->del($key);
    }

    /*
     * 设置退款订单超时完成时间
     * $tsid 订单ID主键ID,非订单编号
     */
    public function setTradeRefundTtl($tsid, $ttl) {
        $this->redis->select(3);//操作3号数据库

        $key    = "mall_trade_refund_{$this->sid}_{$tsid}";
        return  $this->redis->setex($key, $ttl, $key);
    }

    public function getTradeRefundTtl($tsid) {
        $this->redis->select(3);

        $key    = "mall_trade_refund_{$this->sid}_{$tsid}";
        return  $this->redis->ttl($key);
    }

    public function delTradeRefundTtl($tsid) {
        $this->redis->select(3);

        $key    = "mall_trade_refund_{$this->sid}_{$tsid}";
        return  $this->redis->del($key);
    }

    /*
     * 设置退款订单单商品超时完成时间
     * $tsid 订单ID主键ID,非订单编号
     */
    public function setTradeOrderRefundTtl($toid, $ttl) {
        $this->redis->select(3);//操作3号数据库

        $key    = "mall_order_refund_{$this->sid}_{$toid}";
        return  $this->redis->setex($key, $ttl, $key);
    }

    public function getTradeOrderRefundTtl($toid) {
        $this->redis->select(3);

        $key    = "mall_order_refund_{$this->sid}_{$toid}";
        return  $this->redis->ttl($key);
    }

    public function delTradeOrderRefundTtl($toid) {
        $this->redis->select(3);

        $key    = "mall_order_refund_{$this->sid}_{$toid}";
        return  $this->redis->del($key);
    }

    /**
     * 设置秒杀集合的过期时间
     */
    public function setLimitTradeExpire($actid, $gid, $time){
        $this->redis->select(3);
        $key    = "mall_trade_limit_{$this->sid}_{$actid}_{$gid}";
        $this->redis->expire($key, $time);
        return true;
    }

    /**
     * 设置秒杀集合
     */
    public function setLimitTradeValue($actid, $gid, $value) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_limit_{$this->sid}_{$actid}_{$gid}";
        $this->redis->sAdd($key, $value);
        return true;
    }

    /**
     * 获取秒杀集合
     */
    public function getLimitTradeValue($actid, $gid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_limit_{$this->sid}_{$actid}_{$gid}";
        return $this->redis->sMembers($key);
    }


    /*
     * 设置商家岛订单关闭失效时间
     * $tid 订单ID
     */
    public function setMerchantTradeCloseTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "merchant_trade_close_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获取商家岛订单关闭前失效时间
     */
    public function getMerchantTradeCloseTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "merchant_trade_close_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的商家岛订单失效倒计时
     */
    public function delMerchantTradeClose($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "merchant_trade_close_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }

    /**
     * 商家岛设置秒杀集合的过期时间
     */
    public function setMerchantLimitTradeExpire($actid,  $time){
        $this->redis->select(3);
        $key    = "merchant_trade_limit_{$this->sid}_{$actid}";
        $this->redis->expire($key, $time);
        return true;
    }

    /**
     * 商家岛设置秒杀集合
     */
    public function setMerchantLimitTradeValue($actid, $value) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "merchant_trade_limit_{$this->sid}_{$actid}";
        $this->redis->sAdd($key, $value);
        return true;
    }

    /**
     * 商家岛获取秒杀集合
     */
    public function getMerchantLimitTradeValue($actid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "merchant_trade_limit_{$this->sid}_{$actid}";
        return $this->redis->sMembers($key);
    }

    /*
     * 设置订单超时完成时间
     * $tid 订单ID
     */
    public function setMerchantTradeFinishTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "merchant_trade_finish_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }

    /*
     * 获取订单超时完成剩余时间
     */
    public function getMerchantTradeFinishTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "merchant_trade_finish_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除订单超时完成倒计时
     */
    public function delMerchantTradeFinish($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "merchant_trade_finish_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }

    /*
     * 设置待结算订单超时完成时间
     */
    public function setMerchantTradeSettledTtl($tsid, $ttl) {
        $this->redis->select(3);//操作3号数据库

        $key    = "merchant_trade_settled_{$this->sid}_{$tsid}";
        return  $this->redis->setex($key, $ttl, $key);
    }

    public function getMerchantTradeSettledTtl($tsid) {
        $this->redis->select(3);

        $key    = "merchant_trade_settled_{$this->sid}_{$tsid}";
        return  $this->redis->ttl($key);
    }

    public function delMerchantTradeSettledTtl($tsid) {
        $this->redis->select(3);

        $key    = "merchant_trade_settled_{$this->sid}_{$tsid}";
        return  $this->redis->del($key);
    }
    /*
     * 设置退款订单超时完成时间
     * $tsid 订单ID主键ID,非订单编号
     */
    public function setMerchantTradeRefundTtl($tsid, $ttl) {
        $this->redis->select(3);//操作3号数据库

        $key    = "merchant_trade_refund_{$this->sid}_{$tsid}";
        return  $this->redis->setex($key, $ttl, $key);
    }

    public function getMerchantTradeRefundTtl($tsid) {
        $this->redis->select(3);

        $key    = "merchant_trade_refund_{$this->sid}_{$tsid}";
        return  $this->redis->ttl($key);
    }

    public function delMerchantTradeRefundTtl($tsid) {
        $this->redis->select(3);

        $key    = "merchant_trade_refund_{$this->sid}_{$tsid}";
        return  $this->redis->del($key);
    }

    /*
     * 设置蜂鸟配送推单倒计时
     * $tid 订单ID
     */
    public function setEleDeliveryTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_eledelivery_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }

    /*
     * 删除蜂鸟配送推单倒计时
     */
    public function delEleDelivery($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_eledelivery_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }


    /*
     * 设置跑腿订单关闭失效时间
     * $tid 跑腿订单ID
     */
    public function setLegworkTradeCloseTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "legwork_trade_close_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获取跑腿订单关闭前失效时间
     */
    public function getLegworkTradeCloseTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "legwork_trade_close_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的跑腿订单失效倒计时
     */
    public function delLegworkTradeClose($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "legwork_trade_close_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }

    /*
     * 设置订单打印倒计时
     * $tid 订单ID
     */
    public function setTradePrintTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_print_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }

    /*
     * 删除订单打印倒计时
     */
    public function delTradePrintTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "mall_trade_print_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }


    /*
     * 设置跑腿订单关闭失效时间
     * $tid 跑腿订单ID
     */
    public function setGiftcardTradeCloseTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "giftcard_trade_close_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获取跑腿订单关闭前失效时间
     */
    public function getGiftcardTradeCloseTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "giftcard_trade_close_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的跑腿订单失效倒计时
     */
    public function delGiftcardTradeClose($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "giftcard_trade_close_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }

    /*
    * 餐饮未接单退款倒计时
    */
    public function setMealUnReceiveRefundTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "meal_trade_unreceive_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 餐饮未接单退款倒计时
     */
    public function delMealUnReceiveRefundTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "meal_trade_unreceive_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }

    /*社区团购 商品库存redis 缓存
     * zhangzc
     * 2019-08-11
     */
    
    /**
     * 设置社区团购中商品的库存 选中6号数据库存储社区团购的商品的相关的库存
     * zhangzc
     * 2019-08-11
     * @param  [type] $goods_id     [商品id]
     * @param  [type] $goods_format [商品规格id]
     * @param  [type] $stock        [商品库存]
     * @return [type]               [description]
     */
    // 弊端 在用户从redis里面取出一个库存的还没真正减去数据库里面的库存的时候，该商品库存键值过期了（或者是当前1000个数据刚好卖完要写入redis下一个1000），然后开始读取数据库里面的库存，那么在下一次商品键值过期之前库存就是多一个的状态
    // 那么下单的时候就会出现超卖的情况（有什么好的避免方法呢）
    // 1.将过期时间设置的长一些 可以避免过期造成的超卖
    // 2.限制后台可以添加的库存量，这样可以把所有的库存放到redis里面去，然后不设置过期时间或者是过期时间设置的长一些，并且计算下不能让这个键值的过期时间放到白天人流量多的时候过期
    // 3.延迟500毫秒执行此方法
    public function sequenceSetGoodsStock($goods_id,$goods_format=0,$stock){
        set_time_limit(10);
        $this->redis->select(6);//操作6号数据库
        $key="sequence_goods_stock_{$this->sid}_{$goods_id}";
        if($goods_format){
            $key.="_{$goods_format}";
        }
        //若mysql中的库存发生了变化立即更新库存操作
        $status=$this->sequenceGetGoodsStockStatus($goods_id);
        $len=$this->sequenceLenGoodsStock($goods_id,$goods_format);
        if($status || (!$len && $stock)){
            // 商品redis末端库存是否被锁定
            $lock=$this->sequenceGetGoodsStockLock($goods_id,$goods_format);
            if($lock && $lock==$stock){
                return;
            }else if($lock && $lock<$stock){
                $stock-=$lock;
            }

            // 设置前先清空当前键
            $this->redis->del($key);
            // 将库存pop进去
            // 限制大库存往redis 写的时候出现超时和内存溢出的问题
            if($stock>1000)
                $stock=1000;
            for($i=1;$i<=$stock;$i++){
                $ret=$this->redis->rPush($key,$i);
            }
            // 设置过期时间
            $this->sequenceSetGoodsStockTtl($goods_id,$goods_format);
            if($status){
                $this->sequenceDelGoodsStockStatus($goods_id);
            }
        }else{
            //如果即将过期并且剩余库存不为0 刷新时间
            $time = $this->sequenceGetGoodsStockTtl($goods_id,$goods_format);
            if($time <= 10 && $len > 0){
                $this->sequenceSetGoodsStockTtl($goods_id,$goods_format);
            }
        }
    }
    /**
     * 读取社区团购中的商品的库存，出栈-删除
     * @param  [type] $goods_id     [商品id]
     * @param  [type] $goods_format [商品规格]
     * @param  [type] $num          [购买的个数]
     * @return [type]               [description]
     */
    public function sequencePopGoodsStock($goods_id,$goods_format=0,$num=1){
        $this->redis->select(6);//操作6号数据库
        $key="sequence_goods_stock_{$this->sid}_{$goods_id}";
        if($goods_format){
            $key.="_{$goods_format}";
        }
        $value=false;
        $len=$this->redis->llen($key);
        if($len >= $num){
            // 商品末端库存上锁
            if($len==$num){
                $this->sequenceSetGoodsStockLock($goods_id,$goods_format,$stock);
            }
            for($i=0;$i<$num;$i++){
                $value=$this->redis->rPop($key);
            }
        }else{
            return -1;
        } 
        return $value;       
    }
    /**
     * 设置过期时间
     * @param  [type] $goods_id     [商品id]
     * @param  [type] $goods_format [商品规格id]
     * @param  [type] $ttl          [默认1个小时]
     * @return [type]               [description]
     */
    public function sequenceSetGoodsStockTtl($goods_id,$goods_format,$ttl=3600){
        $this->redis->select(6);//操作6号数据库
        $key="sequence_goods_stock_{$this->sid}_{$goods_id}";
        if($goods_format){
            $key.="_{$goods_format}";
        }
        $this->redis->expire($key,$ttl);
    }

    /**
     * 获得过期时间
     * @param  [type] $goods_id     [商品id]
     * @param  [type] $goods_format [商品规格id]
     * @return [type]               [description]
     */
    public function sequenceGetGoodsStockTtl($goods_id,$goods_format){
        $this->redis->select(6);//操作6号数据库
        $key="sequence_goods_stock_{$this->sid}_{$goods_id}";
        if($goods_format){
            $key.="_{$goods_format}";
        }
        $this->redis->ttl($key);
    }

    /**
     * 获取库存的长度查看商品或者是某个规格是否有库存存在
     * zhangzc
     * 209-08-11
     * @param  [type] $goods_id     [description]
     * @param  [type] $goods_format [description]
     * @return [type]               [description]
     */
    public function sequenceLenGoodsStock($goods_id,$goods_format=0){
        $this->redis->select(6);//操作6号数据库
        $key="sequence_goods_stock_{$this->sid}_{$goods_id}";
        if($goods_format){
            $key.="_{$goods_format}";
        }
        return $this->redis->lLen($key);
    }
    /**
     * 社区团购库存改变时重新设置社区团购中商品的库存(在后台更改商品，商品库存恢复的时候-订单关闭恢复库存)
     * zhangzc
     * 2019-08-12
     * @param  [type] $goods_id     [description]
     * @return [type]               [description]
     */
    public function sequenceSetGoodsStockStatus($goods_id){
        $this->redis->select(6);
        $key="sequence_goods_stock_change_{$this->sid}_{$goods_id}";
        $this->redis->set($key,1);
    }
    /**
     * 社区团购获取库存改变 时状态控制的redis
     * zhangzc
     * 2019-08-12
     * @param  [type]  $goods_id     [description]
     * @param  integer $goods_format [description]
     * @return [type]                [description]
     */
    public function sequenceGetGoodsStockStatus($goods_id){
        $this->redis->select(6);
        $key="sequence_goods_stock_change_{$this->sid}_{$goods_id}";
        return $this->redis->get($key);
    }
    /**
     * 社区团购 删除商品库存更改的状态
     * zhangzc
     * 2019-08-12
     * @param  [type] $goods_id     [description]
     * @param  [type] $goods_format [description]
     * @return [type]               [description]
     */
    public function sequenceDelGoodsStockStatus($goods_id){
        $this->redis->select(6);
        $key="sequence_goods_stock_change_{$this->sid}_{$goods_id}";
        return $this->redis->del($key);
    }
    /**
     * 获取商品库存锁（redis list为空的时候对库存的争抢锁）
     * zhangzc
     * 2019-09-28
     * @param  [type] $goods_id      [description]
     * @param  [type] $goods_format [description]
     * @return [type]                [description]
     */
    private function sequenceGetGoodsStockLock($goods_id,$goods_format){
        $this->redis->select(6);
        $key="sequence_goods_stock_lock_{$this->sid}_{$goods_id}";
        if($goods_format){
            $key.="_{$goods_format}";
        }
        return $this->redis->get($key);
    }
    /**
     * 设置商品的库存锁（redis list 为空的时候对库存的争抢）
     * zhangzc
     * 2019-09-28
     * @param [type] $goods_id      [description]
     * @param [type] $goods_format [description]
     * @param [type] $stock         [description]
     */
    private function sequenceSetGoodsStockLock($goods_id,$goods_format,$stock){
        $this->redis->select(6);
        $key="sequence_goods_stock_lock_{$this->sid}_{$goods_id}";
        if($goods_format){
            $key.="_{$goods_format}";
        }
        return $this->redis->set($key,$stock,['nx','px'=>500]);
    }
    /**
     * 删除商品末端库存锁定
     * zhangzc
     * 2019-09-28
     * @param  [type] $goods_id     [description]
     * @param  [type] $goods_format [description]
     * @return [type]               [description]
     */
    public function sequenceDelGoodsStockLock($goods_id,$goods_format){
        $this->redis->select(6);
        $key="sequence_goods_stock_lock_{$this->sid}_{$goods_id}";
        if($goods_format){
            $key.="_{$goods_format}";
        }
        return $this->redis->del($key);
    }





    /*
     * 设置跑腿订单未接单自动关闭时间
     * $tid 跑腿订单ID
     */
    public function setLegworkTradeCancelTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "legwork_trade_cancel_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获取跑腿订单未接单自动关闭时间
     */
    public function getLegworkTradeCancelTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "legwork_trade_cancel_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的跑腿订单未接单自动关闭时间
     */
    public function delLegworkTradeCancel($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "legwork_trade_cancel_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }


    /*
     * 设置校园跑腿订单关闭失效时间
     * $tid 校园跑腿订单ID
     */
    public function setHandyTradeCloseTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "handy_trade_close_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获取校园跑腿订单关闭前失效时间
     */
    public function getHandyTradeCloseTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "handy_trade_close_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的校园跑腿订单失效倒计时
     */
    public function delHandyTradeClose($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "handy_trade_close_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }


    /*
     * 设置校园跑腿订单未接单自动关闭时间
     * $tid 校园跑腿订单ID
     */
    public function setHandyTradeCancelTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "handy_trade_cancel_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获取校园跑腿订单未接单自动关闭时间
     */
    public function getHandyTradeCancelTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "handy_trade_cancel_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的校园跑腿订单未接单自动关闭时间
     */
    public function delHandyTradeCancel($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "handy_trade_cancel_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }


    /*
     * 设置校园跑腿订单用户未确认自动完成时间
     * $tid 校园跑腿订单ID
     */
    public function setHandyTradeFinishTtl($tid, $ttl) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "handy_trade_finish_{$this->sid}_{$tid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获取校园跑腿订单未接单自动完成时间
     */
    public function getHandyTradeFinishTtl($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "handy_trade_finish_{$this->sid}_{$tid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的校园跑腿订单未接单自动完成时间
     */
    public function delHandyTradeFinish($tid) {
        $this->redis->select(3);//操作3号数据库
        //计算倒计时
        $key    = "handy_trade_finish_{$this->sid}_{$tid}";
        return $this->redis->del($key);
    }

}