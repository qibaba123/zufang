<?php
/*
 * 商家岛 拼团参与用户
 */
class App_Model_Merchant_MysqlMerchantGroupMemStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;

    private $org_table;
    private $group_table;
    private $member_table;
    private $trade_table;
    private $address_table;
    private $activity_table;

    public function __construct($sid = null){
        $this->_table 	= 'merchant_group_mem';
        $this->_pk 		= 'mgm_id';
        $this->_shopId 	= 'mgm_s_id';
        parent::__construct();

        $this->sid              = $sid;
        $this->curr_table       = DB::table($this->_table);
        $this->org_table        = DB::table('merchant_group_org');
        $this->group_table      = DB::table('merchant_group_cfg');
        $this->member_table     = DB::table('member');
        $this->trade_table      = DB::table('merchant_trade');
        $this->address_table    = DB::table('member_address');
        $this->activity_table   = DB::table('merchant_activity');
    }

    /*
 * 根据订单ID查找拼团
 */
    public function findGroupOrg($tid, $mid = null) {
        if($this->sid){
            $where[]    = array('name' => 'mgm.mgm_s_id', 'oper' => '=', 'value' => $this->sid);
        }
        $where[]    = array('name' => 'mgm.mgm_tid', 'oper' => '=', 'value' => $tid);
        if ($mid) {
            $where[]    = array('name' => 'mgm.mgm_m_id', 'oper' => '=', 'value' => $mid);
        }

        $sql    = "SELECT mgm.*,go.*,mgc.*,ma.* FROM `{$this->curr_table}` AS mgm LEFT JOIN `{$this->org_table}` AS mgo ON mgm.mgm_mgo_id=mgo.mgo_id ";
        $sql    .= "LEFT JOIN `{$this->group_table}` AS mgc ON mgm.mgm_a_id=mgc.mgc_a_id ";
        $sql    .= "LEFT JOIN `{$this->activity_table}` AS ma ON mgc.mgc_a_id=ma.ma_id ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取组团参与者列表
     */
    public function fetchJoinList($goid) {
        if($this->sid){
            $where[]    = array('name' => 'mgm.mgm_s_id', 'oper' => '=', 'value' => $this->sid);
        }
        $where[]    = array('name' => 'mgm.mgm_mgo_id', 'oper' => '=', 'value' => $goid);

        $sort   = array('mgm.mgm_join_time' => 'ASC');

        $sql    = "SELECT mgm.*,m.m_avatar FROM `{$this->curr_table}` AS mgm LEFT JOIN `{$this->member_table}` AS m ON mgm.mgm_m_id=m.m_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemOrgList($where,$index,$count,$sort=array('mgm_join_time' => 'DESC')){
        $sql  = 'SELECT mgm.* ,m_nickname,m_avatar,m_mobile ';
        $sql .= ' FROM '.$this->curr_table.' mgm ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m_id = gm_mid ';
        $sql .= ' LEFT JOIN '.$this->org_table.' mgo on mgo_id = mgm_mgo_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 批量标记退款
     */
    public function updateHadRefund(array $ids){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $ids);
        $set        = array('mgm_had_refund' => 1);
        return      $this->updateValue($set,$where);
    }

    /*
     * 获取组团下的真实订单
     */
    public function getRealJoiner($goid) {
        if($this->sid){
            $where[]    = array('name' => 'mgm_s_id', 'oper' => '=', 'value' => $this->sid);
        }

        $where[]    = array('name' => 'mgm_mgo_id', 'oper' => '=', 'value' => $goid);
        $where[]    = array('name' => 'mgm_is_robot', 'oper' => '=', 'value' => 0);//真实订单

        $sql    = "SELECT mgm.*,mt.mt_id FROM `{$this->curr_table}` AS mgm ";
        $sql    .= "LEFT JOIN `{$this->trade_table}` AS mt ON mgm.mgm_tid=mt.mt_tid ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
    * 修改
    */
    public function updateJoinByTid($tid, array $data) {
        $where[]    = array('name' => 'mgm_tid', 'oper' => '=', 'value' => $tid);

        return $this->updateValue($data, $where);
    }

}