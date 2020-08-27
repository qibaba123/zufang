<?php

class App_Model_Legwork_MysqlLegworkRiderIncomeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_legwork_rider_income';
        $this->_pk     = 'alri_id';
        $this->_shopId = 'alri_s_id';
        $this->sid     = $sid;
    }

    /*
     * 获得总金额
     */
    public function getSum($where,$incomeType = 1){
        if($incomeType){
            $where[] = ['name' => 'alri_income_type', 'oper' => '=', 'value' => $incomeType];
        }
        $sql = 'SELECT sum(alri_money) as total ';
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