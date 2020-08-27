<?php

class App_Model_Giftcard_MysqlGiftCardStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_gift_card';
        $this->_pk 		= 'agc_id';
        $this->_shopId 	= 'agc_s_id';
        $this->_df      = 'agc_deleted';
        parent::__construct();

        $this->sid = $sid;
    }


}