<?php

class App_Model_Three_MysqlThreeAreaStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'three_area';
        $this->_pk      = 'ta_id';
        $this->_shopId  = 'ta_s_id';

        $this->sid      = $sid;
    }


}