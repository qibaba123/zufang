<?php

class App_Model_Legwork_MysqlLegworkRiderPayStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_legwork_rider_pay';
        $this->_pk     = 'alrp_id';
        $this->_shopId = 'alrp_s_id';
        $this->sid     = $sid;
    }

    /*
     * 获得总垫付金额
     */
    public function getSum($where){
        $sql = 'SELECT sum(alrp_money) as total ';
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