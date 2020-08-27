<?php
/*
 * 城市合伙人分佣记录表
 */
class App_Model_City_MysqlCityTownDeductStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_town_deduct';
        $this->_pk = 'astd_id';
        $this->_shopId = 'astd_s_id';
        $this->sid = $sid;

    }







}