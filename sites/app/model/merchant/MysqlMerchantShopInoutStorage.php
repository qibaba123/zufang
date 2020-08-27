<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/3
 * Time: 下午12:00
 */
class App_Model_Merchant_MysqlMerchantShopInoutStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'merchant_shop_inout';
        $this->_pk      = 'msi_id';
        $this->_shopId  = 'msi_s_id';
        $this->sid      = $sid;
    }

    /**
     * @param int $day 查询天数
     * @param int $type 1收入 2支出
     * @return bool
     */
    public function getSumAmountByDay($day=7,$type = 1){

        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $time       = strtotime(date('Y-m-d',time())) - ($day-1) * 86400;
        $where[]    = array('name' => 'msi_create_time', 'oper' => '>=', 'value' => $time);
        $where[]    = array('name' => 'msi_type', 'oper' => '=', 'value' => $type);

        $sql = 'SELECT SUM(msi_amount) ';
        $sql .= ' FROM `pre_merchant_shop_inout` ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param int $day 查询天数
     * @param int $type 1收入 2支出
     * @return bool
     */
    public function getSumAmountByMonth($month,$type = 1){
        $where      = array();
        if($month){
            $startTime = strtotime($month);
            $endTime   = strtotime($month, '+1 month');
            $where[]    = array('name' => 'msi_create_time', 'oper' => '>=', 'value' => $startTime);
            $where[]    = array('name' => 'msi_create_time', 'oper' => '<', 'value' => $endTime);
        }
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'msi_type', 'oper' => '=', 'value' => $type);

        $sql = 'SELECT SUM(msi_amount) ';
        $sql .= ' FROM `pre_merchant_shop_inout` ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}