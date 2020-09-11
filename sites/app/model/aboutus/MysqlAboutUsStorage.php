<?php

class App_Model_aboutus_MysqlAboutUsStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        $this->_table = 'about_us';
        $this->_pk    = 'au_id';
        $this->_shopId    = 'au_s_id';
        parent::__construct();
    }

}
