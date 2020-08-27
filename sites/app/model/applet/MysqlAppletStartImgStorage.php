<?php
/**
 * 小程序启动图
 */
class App_Model_Applet_MysqlAppletStartImgStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_start_img';
        $this->_pk 		= 'asi_id';
        $this->_shopId 	= 'asi_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }


}