<?php

class App_Model_Handy_MysqlHandyRiderStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;
    private $member_table;
    private $trade_table;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'applet_handy_rider';
        $this->_pk      = 'ahr_id';
        $this->_df      = 'ahr_deleted';
        $this->_shopId  = 'ahr_s_id';
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

        $where[]    = array('name' => 'ahr_mobile', 'oper' => '=', 'value' => $mobile);
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
        $where[]    = array('name' => 'ahr_m_id', 'oper' => '=', 'value' => $mid);

        $ret = $this->getRow($where);

        return $ret;
    }

    /*
     * 获得骑手列表
     * 关联用户表
     */
    public function getRiderList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT ahr.* ';
        $sql .= ' FROM '.DB::table($this->_table).' ahr ';
//        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = ahr.ahr_m_id';
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
        $sql .= ' FROM '.DB::table($this->_table).' ahr ';
//        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = ahr.ahr_m_id';
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

        $where[]    = array('name' => 'ahr_id', 'oper' => '=', 'value' => $id);

        $sql = $this->formatIncrementSql($fields, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 获得骑手列表
     * 关联订单表
     */
    public function getRiderTradeList($where,$index,$count,$sort){
        $where[] = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sql  = 'SELECT ahr.*,count(aht.aht_id) as tradeCount ';
        $sql .= ' FROM '.DB::table($this->_table).' ahr ';
        $sql .= ' LEFT JOIN '.$this->trade_table.' aht on aht.aht_rider = ahr.ahr_id AND aht.aht_status in (4,5) ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' group by ahr_id ';
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


    /*
     * 通过押金订单id获取骑手信息
     */
    public function findUpdateRiderByTid($tid, $data = null) {
        $where[]    = array('name' => 'ahrd_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


    /*
     * @param $mid 骑手ID
     * @param $money 申请提现金额
     * @param $status 提现状态，1审核通过，2审核拒绝
     * @return bool
     */
    public function dealWithdrawMoney($rider,$money,$status){
        if(in_array($status,array(1,2))){
            switch ($status){
                case 1 : //提现成功 ：待审核金额减，已提现金额增加
                    $set = ' , ahr_goodsfee_ytx = ahr_goodsfee_ytx + '.intval($money);
                    break;
                case 2 : //提现拒绝 ：待审核金额减；可提现金额增加
                    $set = ' , ahr_goodsfee_ktx = ahr_goodsfee_ktx + '.intval($money);
                    break;
            }
            $sql = 'UPDATE '.DB::table($this->_table);
            $sql .= ' set ahr_goodsfee_dsh =  ahr_goodsfee_dsh - ' .intval($money).$set;
            $sql .= ' WHERE `ahr_id` = '.intval($rider);
            $ret = DB::query($sql);
            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }






}