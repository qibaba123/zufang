<?php


class App_Model_Trade_MysqlReserveTradeStorage extends Libs_Mvc_Model_BaseModel{


    public function __construct(){
        $this->_table 	= 'service_trade';
        $this->_pk 		= 'st_id';
        $this->_shopId 	= 'st_s_id';
        $this->_df      = 'st_deleted';
        parent::__construct();
    }

    /*
 * 通过订单id获取订单
 */
    public function findUpdateTradeByTid($tid, $data = null) {
        $where[]    = array('name' => 'st_tid', 'oper' => '=', 'value' => $tid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
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