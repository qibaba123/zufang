<?php

class App_Model_Handy_MysqlHandyCfgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_handy_cfg';
        $this->_pk     = 'ahc_id';
        $this->_shopId = 'ahc_s_id';
        $this->sid     = $sid;
    }

    /*
      * 通过店铺id
      */
    public function findUpdateBySid($data=null,$fields='') {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where,$fields);
        }
    }



}