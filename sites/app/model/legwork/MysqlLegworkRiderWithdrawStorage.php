<?php

class App_Model_Legwork_MysqlLegworkRiderWithdrawStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $rider_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_legwork_rider_withdraw';
        $this->_pk     = 'alrw_id';
        $this->_shopId = 'alrw_s_id';
        $this->sid     = $sid;
        $this->rider_table = DB::table('applet_legwork_rider');
    }

    /*
     * 获得总金额
     */
    public function getSum($where){
        $sql = 'SELECT sum(alrw_money) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     * 获得列表
     */
    public function getRiderList($where,$index,$count,$sort){
        $sql = 'SELECT alrw.*,alr.alr_mobile,alr.alr_name ';
        $sql .= ' FROM `'.DB::table($this->_table).'` alrw ';
        $sql .= ' LEFT JOIN `'.$this->rider_table.'` alr on alrw.alrw_rider = alr.alr_id ';
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

    /*
     * 获得数量
     */
    public function getRiderCount($where){
        $sql = 'SELECT count(*) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` alrw ';
        $sql .= ' LEFT JOIN `'.$this->rider_table.'` alr on alrw.alrw_rider = alr.alr_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }




}