<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/29
 * Time: 下午8:13
 */
class App_Model_Shop_MysqlShopSalesStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'shop_sales';
        $this->_pk      = 'ss_id';
        $this->_shopId  = 'ss_s_id';
        $this->sid      = $sid;
    }

}