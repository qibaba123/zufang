<?php

/**
 * Class App_Model_Cash_MysqlRechargeCouponStorage
 * 充值赠送优惠券
 */
class App_Model_Cash_MysqlRechargeCouponStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;

    public function __construct($sid='') {
        parent::__construct();
        $this->_table   = 'cash_recharge_coupon';
        $this->_pk      = 'crc_id';
        $this->_shopId  = 'crc_s_id';
        $this->_df      = 'crc_deleted';

        $this->sid      = $sid;

    }

    /**
     *  获取优惠券
     */
    public function getRechargeCouponList($where, $index=0, $count=20, $sort=array()) {
        $where[] = array('name'=>'crc_deleted', 'oper'=>'=', 'value'=>0);

        $sql = '';
        $sql .= ' Select crc.*, cl.cl_id,cl.cl_name,cl.cl_end_time, rv.*';
        $sql .= ' From `'.DB::table($this->_table).'` crc ';
        $sql .= ' Left Join `pre_coupon_list` cl ON cl.cl_id=crc.crc_c_id ';
        $sql .= ' Left Join `pre_recharge_value` rv ON rv.rv_id=crc.crc_r_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index, $count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /**
     *  获取数量
     */
    public function getRechargeCouponCount($where) {
        $where[] = array('name'=>'crc_deleted', 'oper'=>'=', 'value'=>0);

        $sql = '';
        $sql .= ' Select count(*) ';
        $sql .= ' From `'.DB::table($this->_table).'` crc ';
        $sql .= ' Left Join `pre_coupon_list` cl ON cl.cl_id=crc.crc_c_id ';
        $sql .= ' Left Join `pre_recharge_value` rv ON rv.rv_id=crc.crc_r_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 获取满足条件的最大限定金额
     */
    public function getMaxMoney($where) {
        $where[] = array('name'=>'crc_deleted', 'oper'=>'=', 'value'=>0);

        $sql = '';
        $sql .= ' Select max(crc_limit_money) ';
        $sql .= ' From `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     *  跟进充值卡获取优惠券
     */
    public function getCouponList($where, $test=0) {
        $where[] = ['name'=>'crc_s_id', 'oper'=>'=', 'value'=>$this->sid];
        $where[] = ['name'=>'crc_type', 'oper'=>'=', 'value'=>2]; // 充值卡
        $where[] = ['name'=>'crc_deleted', 'oper'=>'=', 'value'=>0];
        $where[] = ['name'=>'cl_deleted', 'oper'=>'=', 'value'=>0];

        $sql = '';
        $sql .= ' Select cl.cl_id,cl.cl_name,crc.crc_num ';
        $sql .= ' From `'.DB::table($this->_table).'` crc ';
        $sql .= ' Left Join `pre_coupon_list` cl ON cl.cl_id=crc.crc_c_id ';
//        $sql .= ' Left Join `pre_recharge_value` rv ON rv.rv_id=crc.crc_r_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' and (cl_end_time=0 || cl_end_time > '.time().') ';
        $sql .= ' and (cl_had_receive + crc_num < cl_count)';
        if($test) {
            return $sql;
        }

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}
