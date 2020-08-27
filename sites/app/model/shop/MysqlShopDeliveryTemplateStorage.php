<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/17
 * Time: 下午9:34
 */

class App_Model_Shop_MysqlShopDeliveryTemplateStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'shop_delivery_template';
        $this->_pk      = 'sdt_id';
    }



}