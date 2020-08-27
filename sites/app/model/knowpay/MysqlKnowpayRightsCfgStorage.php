<?php
/*
 * 知识付费讲师
 */
class App_Model_Knowpay_MysqlKnowpayRightsCfgStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_knowpay_rights_cfg';
        $this->_pk 		= 'akrc_id';
        $this->_shopId 	= 'akrc_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }


    public function findUpdateBySid($set=null){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($set){
            return $this->updateValue($set, $where);
        }else{
            return $this->getRow($where);
        }
    }

}