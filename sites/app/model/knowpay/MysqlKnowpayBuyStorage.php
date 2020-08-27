<?php
/*
 * 知识付费小程序首页配置
 */
class App_Model_Knowpay_MysqlKnowpayBuyStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_knowpay_buy';
        $this->_pk 		= 'akb_id';
        $this->_shopId 	= 'akb_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }


}