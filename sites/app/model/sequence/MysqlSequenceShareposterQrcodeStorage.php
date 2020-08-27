<?php

class App_Model_Sequence_MysqlSequenceShareposterQrcodeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_sequence_shareposter_qrcode';
        $this->_pk     = 'assq_id';
        $this->_shopId = 'assq_s_id';
        $this->sid     = $sid;
    }

    /*
      * 通过店铺id
      */
    public function findUpdateBySidMid($mid,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'assq_m_id', 'oper' => '=', 'value' => $mid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }



}