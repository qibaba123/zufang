<?php

class App_Model_Gamebox_MysqlGameboxTaskStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gamebox_task';
        $this->_pk = 'agt_id';
        $this->_shopId = 'agt_s_id';
        $this->_df = 'agt_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

}