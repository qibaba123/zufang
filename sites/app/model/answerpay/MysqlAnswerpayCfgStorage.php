<?php

class App_Model_Answerpay_MysqlAnswerpayCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_answerpay_cfg';
        $this->_pk      = 'aac_id';
        $this->_shopId  = 'aac_s_id';
        $this->sid      = $sid;
    }

    /*
     * 配置
     */
    public function findUpdateCfg($data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

}