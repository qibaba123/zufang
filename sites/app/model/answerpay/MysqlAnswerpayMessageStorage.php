<?php

class App_Model_Answerpay_MysqlAnswerpayMessageStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_answerpay_message';
        $this->_pk      = 'aam_id';
        $this->_shopId  = 'aam_s_id';
        $this->sid      = $sid;
    }


}