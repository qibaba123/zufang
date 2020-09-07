<?php


class App_Model_Park_MysqlAddressParkStorage extends Libs_Mvc_Model_BaseModel
{

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'address_park';
        $this->_pk = 'ap_id';
        $this->_shopId = 'ap_s_id';
        $this->_df     = 'ap_deleted';
}


}