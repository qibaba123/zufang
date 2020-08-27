<?php
/**
 * 小程序弹出层
 */
class App_Model_Applet_MysqlAppletPopupStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_popup';
        $this->_pk 		= 'ap_id';
        $this->_shopId 	= 'ap_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }


}