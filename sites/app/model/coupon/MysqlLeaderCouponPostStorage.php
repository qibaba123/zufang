<?php

class App_Model_Coupon_MysqlLeaderCouponPostStorage extends Libs_Mvc_Model_BaseModel {

    private $coupon_table;
    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'leader_coupon_post';
        $this->_pk      = 'lcp_id';
        $this->_shopId  = 'lcp_s_id';
//        $this->_df      = 'lcp_deleted';
        $this->coupon_table = DB::table('coupon_list');
        $this->sid = $sid;
    }

    public function getRowByCouponLeader($coupon,$leader){
        $where[]    = ['name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid];
        $where[]    = ['name' => 'lcp_coupon', 'oper' => '=', 'value' => $coupon];
        $where[]    = ['name' => 'lcp_leader', 'oper' => '=', 'value' => $leader];
        return $this->getRow($where);
    }

    /*
    * 不同字段 自增或自减
    */
    public function incrementField($field,$num,$id) {
        $field  = array($field);
        $inc    = array($num);

        $where[]    = ['name' => $this->_pk, 'oper' => '=', 'value' => $id];

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }


    public function getPostCount($where){
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` lcp ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = lcp_coupon ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getPostList($where){
        $sql  = 'SELECT lcp.*,cl.* ';
        $sql .= ' FROM `'.DB::table($this->_table).'` lcp ';
        $sql .= ' LEFT JOIN pre_coupon_list cl ON cl_id = lcp_coupon ';
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
            $sql .= ' (`lcp_id`,`lcp_s_id`,`lcp_p_id`, `lcp_leader`, `lcp_coupon`, `lcp_count`, `lcp_receive`,`lcp_create_time`) ';
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