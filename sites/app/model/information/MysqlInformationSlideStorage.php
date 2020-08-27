<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Information_MysqlInformationSlideStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;

    public function __construct($sid){
        $this->_table 	= 'applet_information_slide';
        $this->_pk 		= 'ais_id';
        $this->_shopId 	= 'ais_s_id';
        $this->_df = 'ais_deleted';
        parent::__construct();
        $this->sid = $sid;
    }





}