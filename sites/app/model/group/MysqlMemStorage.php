<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/22
 * Time: 上午10:29
 */
class App_Model_Group_MysqlMemStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;

    private $org_table;
    private $group_table;
    private $goods_table;
    private $member_table;
    private $trade_table;
    private $address_table;
    private $course_table;

    public function __construct($sid = null){
        $this->_table 	= 'group_mem';
        $this->_pk 		= 'gm_id';
        $this->_shopId 	= 'gm_s_id';
        parent::__construct();

        $this->sid              = $sid;
        $this->curr_table       = DB::table($this->_table);
        $this->org_table        = DB::table('group_org');
        $this->group_table      = DB::table('group_buy');
        $this->goods_table      = DB::table('goods');
        $this->member_table     = DB::table('member');
        $this->trade_table      = DB::table('trade');
        $this->address_table    = DB::table('member_address');
        $this->course_table     = DB::table('applet_train_course');
    }
    /*
     * 根据订单ID查找拼团
     */
    public function findGroupOrg($tid, $mid = null) {
        $where[]    = array('name' => 'gm.gm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm.gm_tid', 'oper' => '=', 'value' => $tid);
        if ($mid) {
            $where[]    = array('name' => 'gm.gm_mid', 'oper' => '=', 'value' => $mid);
        }

        $sql    = "SELECT gm.*,go.*,gb.*,g.* FROM `{$this->curr_table}` AS gm LEFT JOIN `{$this->org_table}` AS go ON gm.gm_go_id=go.go_id ";
        $sql    .= "LEFT JOIN `{$this->group_table}` AS gb ON gm.gm_gb_id=gb.gb_id ";
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
     * 修改
     */
    public function updateJoinByTid($tid, array $data) {
        $where[]    = array('name' => 'gm_tid', 'oper' => '=', 'value' => $tid);

        return $this->updateValue($data, $where);
    }
    /*
     * 获取组团参与者列表
     */
    public function fetchJoinList($goid) {
        $where[]    = array('name' => 'gm.gm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm.gm_go_id', 'oper' => '=', 'value' => $goid);

        $sort   = array('gm.gm_join_time' => 'ASC');

        $sql    = "SELECT gm.*,m.m_avatar,m.m_nickname FROM `{$this->curr_table}` AS gm LEFT JOIN `{$this->member_table}` AS m ON gm.gm_mid=m.m_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取活动参与者列表
     */
    public function fetchBuyJoinList($gbid, $index = 0, $count = 20) {
        $where[]    = array('name' => 'gm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_gb_id', 'oper' => '=', 'value' => $gbid);

        return $this->getList($where, $index, $count);
    }

    public function getMemList($where,$index,$count,$sort=array('gm_join_time' => 'DESC')){
        $sql  = 'SELECT gm.* ,m_id,m_nickname,m_avatar,m_mobile ';
        $sql .= ' FROM '.$this->curr_table.' gm ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m_id = gm_mid ';
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

    public function getMemCount($where){
        $sql  = 'SELECT count(*) ';
        $sql .= ' FROM '.$this->curr_table.' gm ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m_id = gm_mid ';
        $sql .= $this->formatWhereSql($where);

        $ret    = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    public function getMemOrgList($where,$index,$count,$sort=array('gm_join_time' => 'DESC')){
        $sql  = 'SELECT gm.* ,m_nickname,m_avatar,m_mobile ';
        $sql .= ' FROM '.$this->curr_table.' gm ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m_id = gm_mid ';
        $sql .= ' LEFT JOIN '.$this->org_table.' go on go_id = gm_go_id ';
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

    public function checkWinnerByGbid($gbid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_gb_id', 'oper' => '=', 'value' => $gbid);
        $where[]    = array('name' => 'gm_is_winner', 'oper' => '=', 'value' => 1);
        return $this->getCount($where);
    }

    //获取中奖者列表
    public function getWinnerListByGbid($gbid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_gb_id', 'oper' => '=', 'value' => $gbid);
        $where[]    = array('name' => 'gm_is_winner', 'oper' => '=', 'value' => 1);

        $sql  = 'SELECT m_id,m_nickname ';
        $sql .= ' FROM '.$this->curr_table.' gm ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m_id = gm_mid ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql(0,0);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function updateHadRefund(array $ids){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => 'in', 'value' => $ids);
        $set        = array('gm_had_refund' => 1);
        return      $this->updateValue($set,$where);
    }
    /*
     * 获取拼团订单数量
     */
    public function fetchTradeCount($mid, $list = 'pt', $type = -1) {
        $type       = intval($type);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_mid', 'oper' => '=', 'value' => $mid);

        $sql    = "SELECT count(*) FROM `{$this->curr_table}` AS gm ";
        $sql    .= "INNER JOIN `{$this->org_table}` AS gog ON gm.gm_go_id=gog.go_id ";
        if ($type >= 0) {
            $sql .= "AND gog.go_status={$type} ";
        }
        $sql    .= "INNER JOIN `{$this->group_table}` AS gb ON gm.gm_gb_id=gb.gb_id ";
        $sql    .= "AND gb.gb_type".($list == 'pt' ? '<>' : '=')."2 ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取拼团订单列表（单个会员的）
     * @param string $list pt==拼团 cj==抽奖
     */
    public function fetchTradeList($mid, $list = 'pt', $type = -1, $index = 0, $count = 20) {
        $type       = intval($type);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_mid', 'oper' => '=', 'value' => $mid);

        $sort       = array('gm_join_time' => 'DESC');

        $sql    = "SELECT gm.*,gog.*,gb.gb_g_id,gb.gb_price,gb.gb_total,gb.gb_tz_price,gb.gb_type,g_knowledge_pay_type,g_id FROM `{$this->curr_table}` AS gm ";
        $sql    .= "INNER JOIN `{$this->org_table}` AS gog ON gm.gm_go_id=gog.go_id ";
        if ($type >= 0) {
            $sql .= "AND gog.go_status={$type} ";
        }
        $sql    .= "INNER JOIN `{$this->group_table}` AS gb ON gm.gm_gb_id=gb.gb_id ";
        $sql    .= "AND gb.gb_type".($list == 'pt' ? '<>' : '=')."2 ";

        $sql    .= "INNER JOIN `{$this->goods_table}` AS g ON gb.gb_g_id=g.g_id ";

        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index, $count);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取拼团订单列表 该店铺的所有的
     * @param $gtype 拼团类型 ：1普通团，2抽奖团，3团长免单团
     * @param $type : -1全部，0待成团，1拼团成功，2 拼团失败
     */
    public function fetchAllTradeList($where=array(),$gtype = 0, $type = -1, $index = 0, $count = 20) {
        $type       = intval($type);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_is_robot', 'oper' => '=', 'value' => 0);

        $sort       = array('gm_join_time' => 'DESC');

        $sql    = "SELECT gm.*,gog.*,tr.*,ma.*,gb.gb_g_id,gb.gb_price,gb.gb_total,gb.gb_tz_price,gb.gb_type FROM `{$this->curr_table}` AS gm ";
        $sql    .= "LEFT JOIN `{$this->org_table}` AS gog ON gm.gm_go_id=gog.go_id ";
        $sql    .= "LEFT JOIN `{$this->trade_table}` AS tr ON gm.gm_tid=tr.t_tid ";
        $sql .= " LEFT join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";

        $sql    .= "LEFT JOIN `{$this->group_table}` AS gb ON gm.gm_gb_id=gb.gb_id ";
        $sql    .= $this->formatWhereSql($where);
        if ($type >= 0) {
            $sql .= "AND gog.go_status={$type} ";
        }
        if($gtype>0){
            $sql    .= "AND gb.gb_type={$gtype}";
        }
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index, $count);
        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 统计拼团订单数量 该店铺的所有的
     * @param $gtype 拼团类型 ：1普通团，2抽奖团，3团长免单团
     * @param $type : -1全部，0待成团，1拼团成功，2拼团失败
     */
    public function fetchAllTradeCount($where=array(),$gtype = 0, $type = -1) {
        $type       = intval($type);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_is_robot', 'oper' => '=', 'value' => 0);

        $sql    = "SELECT count(*) FROM `{$this->curr_table}` AS gm ";
        $sql    .= "LEFT JOIN `{$this->org_table}` AS gog ON gm.gm_go_id=gog.go_id ";
        $sql    .= "LEFT JOIN `{$this->trade_table}` AS tr ON gm.gm_tid=tr.t_tid ";
        $sql .= " LEFT join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";

        $sql    .= "LEFT JOIN `{$this->group_table}` AS gb ON gm.gm_gb_id=gb.gb_id ";

        $sql    .= $this->formatWhereSql($where);
        if ($type >= 0) {
            $sql .= "AND gog.go_status={$type} ";
        }
        if($gtype>0){
            $sql    .= "AND gb.gb_type={$gtype}";
        }
        $ret    = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 获取组团下的真实订单
     */
    public function getRealJoiner($goid) {
        $where[]    = array('name' => 'gm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_go_id', 'oper' => '=', 'value' => $goid);
        $where[]    = array('name' => 'gm_is_robot', 'oper' => '=', 'value' => 0);//真实订单

        $sql    = "SELECT gm.*,tr.t_id FROM `{$this->curr_table}` AS gm ";
        $sql    .= "LEFT JOIN `{$this->trade_table}` AS tr ON gm.gm_tid=tr.t_tid ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**根据条件统计订单信息
     * @param int $yesterday
     * @return array|bool
     */
    public function statOrderStatistic($where=array(),$gtype = 0, $type = -1){
        $type       = intval($type);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_is_robot', 'oper' => '=', 'value' => 0);

        $sql  = "SELECT count(*) total,sum(t_payment) money FROM `{$this->curr_table}` AS gm ";
        $sql .= " LEFT JOIN `{$this->org_table}` AS gog ON gm.gm_go_id=gog.go_id ";
        $sql .= " LEFT JOIN `{$this->trade_table}` AS tr ON gm.gm_tid=tr.t_tid ";
        $sql .= " LEFT join ".$this->address_table." ma on ma.ma_id = tr.t_addr_id ";
        $sql .= " LEFT JOIN `{$this->group_table}` AS gb ON gm.gm_gb_id=gb.gb_id ";
        $sql .= $this->formatWhereSql($where);
        if ($type >= 0) {
            $sql .= "AND gog.go_status={$type} ";
        }
        if($gtype>0){
            $sql    .= "AND gb.gb_type={$gtype}";
        }
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据订单ID查找培训拼团
     */
    public function findGroupOrgCourse($tid, $mid = null) {
        $where[]    = array('name' => 'gm.gm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm.gm_tid', 'oper' => '=', 'value' => $tid);
        if ($mid) {
            $where[]    = array('name' => 'gm.gm_mid', 'oper' => '=', 'value' => $mid);
        }

        $sql    = "SELECT gm.*,go.*,gb.*,atc.* FROM `{$this->curr_table}` AS gm LEFT JOIN `{$this->org_table}` AS go ON gm.gm_go_id=go.go_id ";
        $sql    .= "LEFT JOIN `{$this->group_table}` AS gb ON gm.gm_gb_id=gb.gb_id ";
        $sql    .= "LEFT JOIN `{$this->course_table}` AS atc ON gb.gb_g_id=atc.atc_id ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 获取拼团订单列表（单个会员的）
     * @param string $list pt==拼团 cj==抽奖
     */

    public function fetchCourseTradeList($mid, $list = 'pt', $type = -1, $index = 0, $count = 20) {
        $type       = intval($type);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'gm_mid', 'oper' => '=', 'value' => $mid);

        $sort       = array('gm_join_time' => 'DESC');

        $sql    = "SELECT gm.*,gog.*,gb.gb_g_id,gb.gb_price,gb.gb_total,gb.gb_tz_price,gb.gb_type,atc.atc_id FROM `{$this->curr_table}` AS gm ";
        $sql    .= "INNER JOIN `{$this->org_table}` AS gog ON gm.gm_go_id=gog.go_id ";
        if ($type >= 0) {
            $sql .= "AND gog.go_status={$type} ";
        }
        $sql    .= "INNER JOIN `{$this->group_table}` AS gb ON gm.gm_gb_id=gb.gb_id ";
        $sql    .= "AND gb.gb_type".($list == 'pt' ? '<>' : '=')."2 ";

        $sql    .= "INNER JOIN `{$this->course_table}` AS atc ON gb.gb_g_id=atc.atc_id ";

        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index, $count);

        $ret    = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function checkGroupGoodsHadBuy($mid, $gbid){
        $sql    = "SELECT SUM(t.t_num) AS hadbuy FROM `{$this->curr_table}` AS gm  LEFT JOIN `{$this->trade_table}` AS t ON gm.gm_tid=t.t_tid";
        $sql    .= " WHERE gm.gm_gb_id={$gbid} AND gm.gm_mid={$mid} AND gm.gm_s_id={$this->sid} AND t.t_status > ".App_Helper_Trade::TRADE_NO_CREATE_PAY ." AND t.t_status!=".App_Helper_Trade::TRADE_CLOSED." AND t.t_status!=".App_Helper_Trade::TRADE_REFUND;
        return DB::fetch_first($sql);
    }
}