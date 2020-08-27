<?php
/*
 * 知识付费小程序首页配置
 */
class App_Model_Knowpay_MysqlKnowpayIndexStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_knowpay_index';
        $this->_pk 		= 'aki_id';
        $this->_shopId 	= 'aki_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
      * 通过店铺id获取模版配置
      */
    public function findUpdateBySid($tpl=59,$data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aki_tpl_id', 'oper' => '=', 'value' => $tpl);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

}