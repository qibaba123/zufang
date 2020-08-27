<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/7/29
 * Time: 下午2:59
 */
class App_Model_Shop_MysqlShopServiceInformationStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct(){
        $this->_table 	= 'shop_service_information';
        $this->_pk 		= 'ss_id';
        $this->_shopId 	= 'ss_s_id';
        $this->_df 	    = 'ss_deleted';
        parent::__construct();
    }

    public function getShopList(){

    }

}