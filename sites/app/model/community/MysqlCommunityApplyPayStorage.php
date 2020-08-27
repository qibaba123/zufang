<?php

class App_Model_Community_MysqlCommunityApplyPayStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid=0)
    {
        parent::__construct();
        $this->_table  = 'applet_community_apply_pay';
        $this->_pk     = 'acap_id';
        $this->_shopId = 'acap_s_id';

        $this->sid     = $sid;
    }

    /*
     * 通过店铺id和订单编号获取支付信息
     */
    public function findUpdateByNumber($number,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'acap_number', 'oper' => '=', 'value' => $number);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getProfitTotal($where){
        $sql = "select sum(acap_money) as total";
        $sql .= " from `".DB::table($this->_table)."` ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}