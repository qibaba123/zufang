<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Workorder_MysqlWorkorderUserStorage extends Libs_Mvc_Model_BaseModel
{

    private $shop_table;

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'applet_work_order_user';
        $this->_pk = 'awu_id';
        $this->_shopId = 'awu_s_id';
        $this->_df     = 'awu_deleted';
        $this->shop_table = DB::table('shop');
    }
}