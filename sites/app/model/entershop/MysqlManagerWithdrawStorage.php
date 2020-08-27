<?php

class App_Model_Entershop_MysqlManagerWithdrawStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $manager_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'entershop_manager_withdraw';
        $this->_pk     = 'emw_id';
        $this->_shopId = 'emw_s_id';
        $this->sid     = $sid;
        $this->manager_table = DB::table('enter_shop_manager');
    }

    /*
     * 获得总金额
     */
    public function getSum($where){
        $sql = 'SELECT sum(emw_money) as total ';
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
    public function getManagerList($where,$index,$count,$sort){
        $sql = 'SELECT emw.*,esm.esm_mobile,esm.esm_nickname ';
        $sql .= ' FROM `'.DB::table($this->_table).'` emw ';
        $sql .= ' LEFT JOIN `'.$this->manager_table.'` esm on emw.emw_manager = esm.esm_id ';
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
    public function getManagerCount($where){
        $sql = 'SELECT count(*) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` emw ';
        $sql .= ' LEFT JOIN `'.$this->manager_table.'` esm on emw.emw_manager = esm.esm_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }




}