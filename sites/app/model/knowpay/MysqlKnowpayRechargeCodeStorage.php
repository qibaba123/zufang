<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Knowpay_MysqlKnowpayRechargeCodeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_knowpay_recharge_code';
        $this->_pk = 'akrc_id';
        $this->_shopId = 'akrc_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    public function getCodeList($where, $index, $count, $sort){
        $sql = "select *";
        $sql .= " from `".DB::table($this->_table)."`";
        $sql .= $this->formatWhereSql($where);
        $sql .= " and (akrc_expire_time = 0 or akrc_expire_time > ".time().") ";
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

    }

}