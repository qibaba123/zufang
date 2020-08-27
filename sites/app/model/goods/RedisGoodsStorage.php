<?php

class App_Model_Goods_RedisGoodsStorage extends Libs_Redis_RedisClient {
    /*
     * 店铺id
     */
    private $sid;

    public function __construct($sid) {
        $this->sid = $sid;
        return parent::__construct();
    }
  
      /*
* 设置确认收货订单返佣时间
*/
    public function setTradeReturn($tid,$ttl) {
        $this->redis->select(3);//操作3号数据库

        $key    = "goods_sale_return_{$this->sid}_{$tid}";
        return  $this->redis->setex($key, $ttl, $key);
    }


    /*
     * 设置商品自动上架定时
     */
    public function setGoodsSaleUpTtl($gid, $ttl) {
        $this->redis->select(10);//操作10号数据库
        //计算倒计时
        $key    = "goods_sale_up_{$this->sid}_{$gid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获得商品自动上架前失效时间
     */
    public function getGoodsSaleUpTtl($gid) {
        $this->redis->select(10);//操作10号数据库
        //计算倒计时
        $key    = "goods_sale_up_{$this->sid}_{$gid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的商品自动上架倒计时
     */
    public function delGoodsSaleUp($gid) {
        $this->redis->select(10);//操作10号数据库
        //计算倒计时
        $key    = "goods_sale_up_{$this->sid}_{$gid}";
        return $this->redis->del($key);
    }


    /*
    * 设置商品自动下架定时
    */
    public function setGoodsSaleDownTtl($gid, $ttl) {
        $this->redis->select(10);//操作10号数据库
        //计算倒计时
        $key    = "goods_sale_down_{$this->sid}_{$gid}";
        $this->redis->setex($key, $ttl, $key);
        return true;
    }
    /*
     * 获得商品自动下架前失效时间
     */
    public function getGoodsSaleDownTtl($gid) {
        $this->redis->select(10);//操作10号数据库
        //计算倒计时
        $key    = "goods_sale_down_{$this->sid}_{$gid}";
        return $this->redis->ttl($key);
    }
    /*
     * 删除进行中的商品自动下架倒计时
     */
    public function delGoodsSaleDown($gid) {
        $this->redis->select(10);//操作10号数据库
        //计算倒计时
        $key    = "goods_sale_down_{$this->sid}_{$gid}";
        return $this->redis->del($key);
    }

    /*
     * 批量删除商品上下架键
     */
    public function delGoodsSaleKeys($gids,$type = 'all'){
        $this->redis->select(10);//操作10号数据库
        $keys = [];
        if($gids){
            foreach ($gids as $gid){
                if($type == 'all' || $type == 'up'){
                    $keys[] = 'goods_sale_up_'.$this->sid.'_'.$gid;
                }
                if($type == 'all' || $type == 'down'){
                    $keys[] = 'goods_sale_down_'.$this->sid.'_'.$gid;
                }
            }
            return $this->redis->del($keys);
        }

    }





}