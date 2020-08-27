<?php

class App_Model_Entershop_MysqlManagerWithdrawCfgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'entershop_manager_withdraw_cfg';
        $this->_pk     = 'emwc_id';
        $this->_shopId = 'emwc_s_id';
        $this->sid     = $sid;
    }

    /*
      * 通过店铺id
      */
    public function findUpdateBySid($data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }



}