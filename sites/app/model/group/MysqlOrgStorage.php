<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/21
 * Time: 下午4:48
 */
class App_Model_Group_MysqlOrgStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;

    private $group_table;
    private $goods_table;
    private $member_table;
    private $course_table;

    public function __construct($sid = null){
        $this->_table 	= 'group_org';
        $this->_pk 		= 'go_id';
        $this->_shopId 	= 'go_s_id';
        parent::__construct();

        $this->sid         = $sid;
        $this->curr_table  = DB::table($this->_table);

        $this->group_table = DB::table('group_buy');
        $this->goods_table = DB::table('goods');
        $this->member_table= DB::table('member');
        $this->course_table= DB::table('applet_train_course');
    }

    public function incrementJoin($gbid, $num = 1) {
        $field  = array('go_had');
        $inc    = array($num);

        $where[]    = array('name' => 'go_id', 'oper' => '=', 'value' => $gbid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
    /*
     * 根据组团ID查找拼团
     */
    public function findGroupOrg($gbid) {
        $where[]    = array('name' => 'goa.go_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'goa.go_id', 'oper' => '=', 'value' => $gbid);

        $sql    = "SELECT goa.*,gb.*,g.* FROM `{$this->curr_table}` AS goa ";
        $sql    .= "LEFT JOIN `{$this->group_table}` AS gb ON goa.go_gb_id=gb.gb_id ";
        $sql    .= "LEFT JOIN `{$this->goods_table}` AS g ON gb.gb_g_id=g.g_id ";
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
    public function fetchJoiningList($gbid, $total, $gbIdSection=array()) {
        if (!$total) {
            return null;
        }
        $where[]    = array('name' => 'go.go_s_id', 'oper' => '=', 'value' => $this->sid);
        if($gbIdSection){
            $where[]    = array('name' => 'go.go_gb_id', 'oper' => 'in', 'value' => $gbIdSection);
        }else{
            $where[]    = array('name' => 'go.go_gb_id', 'oper' => '=', 'value' => $gbid);
        }
        $where[]    = array('name' => 'gm.gm_is_tz', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'go.go_status', 'oper' => '=', 'value' => 0);//进行中

        $sort   = array('go.go_had' => 'DESC');

        $sql    = "SELECT go.*,m.m_nickname,m.m_avatar,gm_tid FROM `{$this->curr_table}` AS go LEFT JOIN `{$this->member_table}` AS m ON go.go_tz_mid=m.m_id ";
        $sql    .= " LEFT JOIN `pre_group_mem` AS gm ON go.go_id=gm.gm_go_id";
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
    public function getPartakeList($where,$index,$count,$sort=array('go_create_time' => 'DESC')){
        $sql  = 'SELECT go.* ,m_nickname,m_avatar ';
        $sql .= ' FROM '.$this->curr_table.' go ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m_id = go_tz_mid ';
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
        $where[]    = array('name' => 'go_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'go_id', 'oper' => '=', 'value' => $id);
        $sql  = 'SELECT * ';
        $sql .= ' FROM '.$this->curr_table.' go ';
        $sql .= ' LEFT JOIN '.$this->group_table.' gb on gb_id = go_gb_id ';
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
    public function getGroupMemberCount($gbid){
        $where[]    = array('name' => 'go_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'go_gb_id', 'oper' => '=', 'value' => $gbid);
        $where[]    = array('name' => 'go_status', 'oper' => '!=', 'value' => 2);//进行中

        $sql    = "SELECT count(go_had) as total FROM `{$this->curr_table}` ";
        $sql    .= $this->formatWhereSql($where);
        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据组团ID查找拼团
     */
    public function findGroupOrgCourse($gbid) {
        $where[]    = array('name' => 'goa.go_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'goa.go_id', 'oper' => '=', 'value' => $gbid);

        $sql    = "SELECT goa.*,gb.*,atc.* FROM `{$this->curr_table}` AS goa ";
        $sql    .= "LEFT JOIN `{$this->group_table}` AS gb ON goa.go_gb_id=gb.gb_id ";
        $sql    .= "LEFT JOIN `{$this->course_table}` AS atc ON gb.gb_g_id=atc.atc_id ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
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
     * @param $sort
     * @return array|bool
     * 获得拼团信息列表
     */
    public function getGroupOrgInfoList($where,$index,$count,$sort){
        $sql  = 'SELECT go.*,gb.gb_price,gb.gb_type,gb.gb_end_time,m.m_nickname,m.m_avatar ';
        $sql .= ' FROM '.$this->curr_table.' go ';
        $sql .= ' LEFT JOIN '.$this->group_table.' gb on gb_id = go_gb_id ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m_id = go_tz_mid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $list = DB::fetch_all($sql);
        if ($list === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $list;
    }

    /**
     * @param $id
     * @return array|bool
     * 获得单条信息，包含商品
     */
    public function getGroupOrgInfoGoodsById($id){
        $where[]    = array('name' => 'go_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'go_id', 'oper' => '=', 'value' => $id);
        $sql  = 'SELECT go.*,gb.gb_price,gb.gb_type,gb.gb_total,gb.gb_gbs_id,g.g_name,g.g_cover,g.g_price,g.g_ori_price ';
        $sql .= ' FROM '.$this->curr_table.' go ';
        $sql .= ' LEFT JOIN '.$this->group_table.' gb on gb_id = go_gb_id ';
        $sql .= ' LEFT JOIN '.$this->goods_table.' g on gb_g_id = g_id ';
        $sql .= $this->formatWhereSql($where);

        $row = DB::fetch_first($sql);
        if ($row === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $row;
    }



}