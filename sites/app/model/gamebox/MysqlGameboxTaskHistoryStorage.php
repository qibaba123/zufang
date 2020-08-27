<?php

class App_Model_Gamebox_MysqlGameboxTaskHistoryStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gamebox_task_history';
        $this->_pk = 'agth_id';
        $this->_shopId = 'agth_s_id';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

}