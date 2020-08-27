<?php

class App_Model_Gamebox_MysqlGameboxCategoryStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gamebox_category';
        $this->_pk = 'agc_id';
        $this->_shopId = 'agc_s_id';
        $this->_df = 'agc_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

}