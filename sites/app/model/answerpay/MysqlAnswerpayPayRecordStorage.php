<?php

class App_Model_Answerpay_MysqlAnswerpayPayRecordStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_answerpay_pay_record';
        $this->_pk      = 'aapr_id';
        $this->_shopId  = 'aapr_s_id';
        $this->sid      = $sid;
    }

    /*
     * 配置
     */
    public function findUpdateByNumber($number,$data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aapr_number', 'oper' => '=', 'value' => $number);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 根据mid和购买信息id获得记录
     */
    public function getRowByMidBuyId($mid,$buyId){
        $where = [];
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aapr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'aapr_buy_id', 'oper' => '=', 'value' => $buyId);
        return $this->getRow($where);
    }

}