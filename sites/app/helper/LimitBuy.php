<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/12/30
 * Time: 下午2:09
 */
class App_Helper_LimitBuy {

    const LIMIT_BUY_WAIT    = 0;
    const LIMIT_BUY_RUN     = 1;
    const LIMIT_BUY_OVER    = 2;

    private $sid;

    public function __construct($sid) {
        $this->sid  = intval($sid);
    }
    /*
     * 检查商品参与的限时抢购活动
     */
    public function checkLimitAct($gid,$laid = 0, $is_curr=0) {
        $limit_goods    = new App_Model_Limit_MysqlLimitGoodsStorage($this->sid);

        $limit_act      = $limit_goods->getActByGid($gid,$laid, $is_curr);

        if ($limit_act) {
            //判断活动开始中,还是未开始
            $curr   = time();
            $limit_act['status']    = intval($limit_act['la_start_time']) < $curr ?(intval($limit_act['la_end_time'])<$curr?self::LIMIT_BUY_OVER:self::LIMIT_BUY_RUN) : self::LIMIT_BUY_WAIT;
            $limit_act['server_time']   = $curr;
            return $limit_act;
        }

        return false;
    }

    /*
     * 检查商品参与的限时抢购活动
     */
    public function checkMerchantLimitAct($laid = 0, $time=0) {
        $limit_goods    = new App_Model_Merchant_MysqlMerchantActivityStorage($this->sid);

        $limit_act      = $limit_goods->getActivityRow($laid,$time);

        if ($limit_act) {
            //判断活动开始中,还是未开始
            $curr   = time();
            $limit_act['status'] = intval($limit_act['ma_start']) < $curr ? (intval($limit_act['ma_end']) < $curr ? self::LIMIT_BUY_OVER : self::LIMIT_BUY_RUN) : self::LIMIT_BUY_WAIT;
            $limit_act['server_time'] = $curr;
            return $limit_act;
        }

        return false;
    }
}