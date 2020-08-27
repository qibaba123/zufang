<?php

class App_Model_Coupon_MysqlLeaderCouponHoldStorage extends Libs_Mvc_Model_BaseModel {

    private $coupon_table;
    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'leader_coupon_hold';
        $this->_pk      = 'lch_id';
        $this->_shopId  = 'lch_s_id';
//        $this->_df      = 'lch_deleted';
        $this->coupon_table = DB::table('coupon_list');
        $this->sid = $sid;
    }

    public function getRowByCouponLeader($coupon,$leader){
        $where[]    = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[]    = ['name' => 'lch_coupon', 'oper' => '=', 'value' => $coupon];
        $where[]    = ['name' => 'lch_leader', 'oper' => '=', 'value' => $leader];
        return $this->getRow($where);
    }

    /*
    * 不同字段 自增或自减
    */
    public function incrementField($field,$num,$coupon,$leader) {
        $field  = array($field);
        $inc    = array($num);

        $where[]    = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[]    = ['name' => 'lch_coupon', 'oper' => '=', 'value' => $coupon];
        $where[]    = ['name' => 'lch_leader', 'oper' => '=', 'value' => $leader];

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }


    public function getHoldCount($where){
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` lch ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = lch_coupon ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getHoldList($where){
        $sql  = 'SELECT lch.*,cl.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` lch ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = lch_coupon ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * 批量插入
     */
    public function batchSave(array $value){
        if(!empty($value)){
            $sql = 'INSERT '.' INTO '.DB::table($this->_table);
            $sql .= ' (`lch_id`,`lch_s_id`, `lch_leader`, `lch_coupon`, `lch_hold_num`, `lch_send_num`,`lch_create_time`) ';
            $sql .= ' VALUES '.implode(',',$value);

            $ret  = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
            return $ret;
        }
        return false;
    }

}