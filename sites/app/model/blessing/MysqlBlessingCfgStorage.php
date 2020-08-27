<?php

class App_Model_Blessing_MysqlBlessingCfgStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;//店铺id
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_blessing_cfg';
        $this->_pk      = 'abc_id';
        $this->_shopId  = 'abc_s_id';
        $this->sid      = $sid;
    }


    /*
      * 通过店铺id获取配置
      */
    public function findUpdateBySid($data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }




}