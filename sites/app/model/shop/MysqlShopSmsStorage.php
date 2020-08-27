<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/21
 * Time: 下午8:20
 */
class App_Model_Shop_MysqlShopSmsStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'shop_sms';
        $this->_pk 		= 'ss_id';
        $this->_shopId 	= 'ss_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
     * 前端获取店铺
     */
    public function findUpdateBySid($data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}