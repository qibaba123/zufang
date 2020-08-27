<?php

class App_Model_Handy_MysqlHandyRiderIncomeStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_handy_rider_income';
        $this->_pk     = 'ahri_id';
        $this->_shopId = 'ahri_s_id';
        $this->sid     = $sid;
    }

    /*
     * 获得总金额
     */
    public function getSum($where,$incomeType = 1){
        if($incomeType){
            $where[] = ['name' => 'ahri_income_type', 'oper' => '=', 'value' => $incomeType];
        }
        $sql = 'SELECT sum(ahri_money) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListRider($where,$index,$count,$sort){

        $sql = 'SELECT ahri.*,ahr.ahr_name ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ahri ';
        $sql .= ' LEFT JOIN `pre_applet_handy_rider` ahr on ahr.ahr_id = ahri.ahri_rider  ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }







}