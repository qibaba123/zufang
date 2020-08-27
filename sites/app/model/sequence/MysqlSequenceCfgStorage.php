<?php

class App_Model_Sequence_MysqlSequenceCfgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_sequence_cfg';
        $this->_pk     = 'asc_id';
        $this->_shopId = 'asc_s_id';
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