<?php

class App_Model_Member_MysqlRechargeRemarkStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'recharge_record_remark';
        $this->_pk      = 'rrr_id';
        $this->_shopId  = 'rrr_s_id';
        $this->sid      = $sid;
    }

    /*
     * 通过订单ID查找充值记录
     */
    public function findRecordByTid($tid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rrr_tid', 'oper' => '=', 'value' => $tid);

        return $this->getRow($where);
    }




}