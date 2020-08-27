<?php

class App_Model_Legwork_MysqlLegworkShopPostStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_legwork_shop_post';
        $this->_pk     = 'alsp_id';
        $this->_shopId = 'alsp_s_id';
        $this->sid     = $sid;
    }


    public function getSum($where){
        $sql = 'SELECT sum(alsp_rider_money) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListTrade($where,$index,$count,$sort){
        $sql = 'SELECT alsp.*,t.t_id,t.t_es_id ';
        $sql .= ' FROM `'.DB::table($this->_table).'` alsp ';
        $sql .= ' LEFT JOIN `pre_trade` t on alsp.alsp_other_tid = t.t_tid ';
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