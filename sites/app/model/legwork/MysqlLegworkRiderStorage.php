<?php

class App_Model_Legwork_MysqlLegworkRiderStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;
    private $member_table;
    private $trade_table;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'applet_legwork_rider';
        $this->_pk      = 'alr_id';
        $this->_df      = 'alr_deleted';
        $this->_shopId  = 'alr_s_id';
        $this->sid      = $sid;
        $this->member_table = DB::table('member');
        $this->trade_table = DB::table('applet_legwork_trade');
    }


    /**
     * 按特定手机号字段检索骑手
     * @param mixed $mobile
     * @return array|bool
     */
    public function findRowByMobile($mobile,$id = 0) {
        if($id){
            //排除自身
            $where[]    = array('name' => $this->_pk, 'oper' => '!=', 'value' => $id);
        }
        if($this->sid){
            $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        }

        $where[]    = array('name' => 'alr_mobile', 'oper' => '=', 'value' => $mobile);
        $ret = $this->getRow($where);
        return $ret;
    }

    /**
     * 按会员id检索骑手
     * @param mixed $mid
     * @return array|bool
     */
    public function findRowByMid($mid,$id = 0) {
        if($id){
            //排除自身
            $where[]    = array('name' => $this->_pk, 'oper' => '!=', 'value' => $id);
        }
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'alr_m_id', 'oper' => '=', 'value' => $mid);

        $ret = $this->getRow($where);

        return $ret;
    }

    /*
     * 获得骑手列表
     * 关联用户表
     */
    public function getRiderList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT alr.* ';
        $sql .= ' FROM '.DB::table($this->_table).' alr ';
//        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = alr.alr_m_id';
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

    public function getRiderCount($where){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' alr ';
//        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = alr.alr_m_id';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 设置指定字段自增或自减
     */
    public function incrementRiderField($id,$num,$field) {
        $fields  = array($field);
        $inc    = array($num);

        $where[]    = array('name' => 'alr_id', 'oper' => '=', 'value' => $id);

        $sql = $this->formatIncrementSql($fields, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 获得骑手列表
     * 关联订单表
     */
    public function getRiderTradeList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT alr.*,count(alt.alt_id) as tradeCount ';
        $sql .= ' FROM '.DB::table($this->_table).' alr ';
        $sql .= ' LEFT JOIN '.$this->trade_table.' alt on alt.alt_rider = alr.alr_id AND alt.alt_status in (4,5) ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' group by alr_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        Libs_Log_Logger::outputLog($sql,'test.log');
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }






}