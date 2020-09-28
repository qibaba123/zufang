<?php


class App_Model_Trade_MysqlReserveTradeStorage extends Libs_Mvc_Model_BaseModel{


    public function __construct(){
        $this->_table 	= 'reserve_trade';
        $this->_pk 		= 'rt_id';
        $this->_shopId 	= 'rt_s_id';
        $this->_df      = 'rt_deleted';
        parent::__construct();
    }

    public function statOrderStatus($where){
        $sql  = 'SELECT count(*) total,sum(rt_fee) money ';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
 * 通过订单id获取订单
 */
    public function findUpdateTradeByTid($tid, $data = null) {
        $where[]    = array('name' => 'rt_tid', 'oper' => '=', 'value' => $tid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


    public function getMemberList($where,$index,$count,$sort){
        $sql = 'SELECT rt.*,m.*,sf.sf_name ';
        $sql .= " FROM ".DB::table($this->_table)." rt ";
       // $sql .= ' LEFT JOIN pre_enterprise_service es ON es.es_id = rt.rt_ser_id ';
        $sql .= ' LEFT JOIN pre_member m ON rt.rt_m_id = m.m_id ';
        $sql .= ' LEFT JOIN pre_service_format sf ON rt.rt_format_id = sf.sf_id ';
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