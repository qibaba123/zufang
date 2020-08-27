<?php

class App_Model_Handy_MysqlHandyRiderPayStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_handy_rider_pay';
        $this->_pk     = 'ahrp_id';
        $this->_shopId = 'ahrp_s_id';
        $this->sid     = $sid;
    }

    /*
     * 获得总垫付金额
     */
    public function getSum($where){
        $sql = 'SELECT sum(ahrp_money) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }





}