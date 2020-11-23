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


    public function get_park_by_parent($parent_id){
        $sql = 'SELECT * '.'FROM `pre_address_park` WHERE ap_area ='.intval($parent_id);
        $ret = DB::fetch_all($sql);
        return $ret;
    }


    public function get_park(){
        $sql = 'SELECT * '.'FROM `pre_address_park` ';
        $ret = DB::fetch_all($sql);
        return $ret;
    }

}