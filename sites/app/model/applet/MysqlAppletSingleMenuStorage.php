<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Applet_MysqlAppletSingleMenuStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_single_menu';
        $this->_pk = 'asm_id';
        $this->_shopId = 'asm_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

}