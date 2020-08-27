<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 下午4:39
 */
class App_Model_Applet_MysqlWeddingAppointmentStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'appointment_information';
        $this->_pk = 'ai_id';
        $this->_shopId = 'ai_s_id';
        $this->_df      = 'ai_deleted';
        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

}