<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午4:59
 * 模版设置
 */
class App_Model_Shop_MysqlShopAboutUsStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'shop_about_us';
        $this->_pk 		= 'sa_id';
        $this->_shopId 	= 'sa_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
      * 通过店铺id获取配置
      */
    public function findUpdateBySid($data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }



}