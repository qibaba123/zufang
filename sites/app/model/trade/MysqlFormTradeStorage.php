<?php


class App_Model_Trade_MysqlFormTradeStorage extends Libs_Mvc_Model_BaseModel{


    public function __construct(){
        $this->_table 	= 'form_trade';
        $this->_pk 		= 'ft_id';
        $this->_shopId 	= 'ft_s_id';
        $this->_df      = 'ft_deleted';
        parent::__construct();
    }

    public function getSerList($where,$index,$count,$sort){
        $sql = 'SELECT ft.*,es.es_name ';
        $sql .= " FROM ".DB::table($this->_table)." ft ";
        $sql .= ' LEFT JOIN pre_enterprise_service es ON es.es_id = ft.ft_ser_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}