<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/7/20
 * Time: 上午10:59
 */
class App_Model_Wechat_MysqlActivityStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'weixin_activity';
        $this->_pk 		= 'wa_id';
        $this->_shopId 	= 'wa_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

}