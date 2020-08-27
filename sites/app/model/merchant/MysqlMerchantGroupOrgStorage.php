<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/21
 * Time: 下午4:48
 */
class App_Model_Merchant_MysqlMerchantGroupOrgStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;

    private $group_table;
    private $member_table;
    private $activity_table;
    public function __construct($sid = null){
        $this->_table 	= 'merchant_group_org';
        $this->_pk 		= 'mgo_id';
        $this->_shopId 	= 'mgo_s_id';
        parent::__construct();

        $this->sid         = $sid;
        $this->curr_table  = DB::table($this->_table);

        $this->group_table = DB::table('merchant_group_cfg');
        $this->activity_table = DB::table('merchant_activity');
        $this->member_table= DB::table('member');
    }

    public function incrementJoin($aid, $num = 1) {
        $field  = array('mgo_had');
        $inc    = array($num);

        $where[]    = array('name' => 'mgo_id', 'oper' => '=', 'value' => $aid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
    /*
     * 根据组团ID查找拼团
     */
    public function findGroupOrg($aid) {
        if($this->sid){
            $where[]    = array('name' => 'mgo.mgo_s_id', 'oper' => '=', 'value' => $this->sid);
        }

        $where[]    = array('name' => 'mgo.mgo_id', 'oper' => '=', 'value' => $aid);

        $sql    = "SELECT mgo.*,mgc.*,ma.* FROM `{$this->curr_table}` AS mgo ";
        $sql    .= "LEFT JOIN `{$this->group_table}` AS mgc ON mgo.mgo_a_id=mgc.mgc_a_id ";
        $sql    .= "LEFT JOIN `{$this->activity_table}` AS ma ON mgo.mgo_a_id=ma.ma_id ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取发起中的组团活动
     */
    public function fetchJoiningList($aid, $total) {
        if (!$total) {
            return null;
        }
        if($this->sid){
            $where[]    = array('name' => 'mgo.mgo_s_id', 'oper' => '=', 'value' => $this->sid);
        }

        $where[]    = array('name' => 'mgo.mgo_a_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'mgm.mgm_is_tz', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'mgo.mgo_status', 'oper' => '=', 'value' => 0);//进行中

        $sort   = array('mgo.mgo_had' => 'DESC');

        $sql    = "SELECT mgo.*,m.m_nickname,m.m_avatar,mgm_tid FROM `{$this->curr_table}` AS mgo LEFT JOIN `{$this->member_table}` AS m ON mgo.mgo_tz_mid=m.m_id ";
        $sql    .= " LEFT JOIN `pre_merchant_group_mem` AS mgm ON mgo.mgo_id=mgm.mgm_mgo_id";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql(0, $total);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param array $sort
     * @return array|bool
     * 获取参与者的情况
     */
    public function getPartakeList($where,$index,$count,$sort=array('mgo_create_time' => 'DESC')){
        $sql  = 'SELECT mgo.* ,m_nickname,m_avatar ';
        $sql .= ' FROM '.$this->curr_table.' mgo ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m_id = mgo_tz_mid ';
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

    /**
     * @param $id
     * @return array|bool
     * 获取单条记录
     */
    public function getGroupOrgInfoById($id){
        if($this->sid){
            $where[]    = array('name' => 'mgo_s_id', 'oper' => '=', 'value' => $this->sid);
        }

        $where[]    = array('name' => 'mgo_id', 'oper' => '=', 'value' => $id);
        $sql  = 'SELECT * ';
        $sql .= ' FROM '.$this->curr_table.' mgo ';
        $sql .= ' LEFT JOIN '.$this->group_table.' mgc on mgc_a_id = mgo_a_id ';
        $sql .= $this->formatWhereSql($where);

        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }

    /**
     * 根据活动id获取已团人数
     */
    public function getGroupMemberCount($aid){
        if($this->sid){
            $where[]    = array('name' => 'mgo_s_id', 'oper' => '=', 'value' => $this->sid);
        }

        $where[]    = array('name' => 'mgo_a_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'mgo_status', 'oper' => '!=', 'value' => 2);//进行中

        $sql    = "SELECT count(mgo_had) as total FROM `{$this->curr_table}` ";
        $sql    .= $this->formatWhereSql($where);
        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}