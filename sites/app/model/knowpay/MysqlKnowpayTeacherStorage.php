<?php
/*
 * 知识付费讲师
 */
class App_Model_Knowpay_MysqlKnowpayTeacherStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_knowpay_teacher';
        $this->_pk 		= 'akt_id';
        $this->_shopId 	= 'akt_s_id';
        $this->_df      = 'akt_deleted';
        parent::__construct();
        $this->sid  = $sid;
    }



}