<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/6/27
 * Time: 下午10:01
 */
class App_Model_Answer_MysqlCurrencyStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $shop_table = '';
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_city_currency';
        $this->_pk      = 'acc_id';
        $this->_shopId  = 'acc_s_id';
        $this->_df      = 'acc_deleted';
        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }
}