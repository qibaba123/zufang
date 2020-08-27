<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/13
 * Time: 下午6:37
 */
class App_Model_Bargain_MysqlJoinStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $goods_table; //商品表
    private $activity_table; //活动表
    private $course_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'bargain_join';
        $this->goods_table = 'pre_goods';
        $this->activity_table = 'pre_bargain_activity';
        $this->course_table = 'pre_applet_train_course';
        $this->_pk      = 'bj_id';
        $this->_shopId  = 'bj_s_id';

        $this->sid      = $sid;
    }

    /**
     * 通过会员id获取参与的活动
     */
    public function getJoinerList($where, $index, $count, $sort){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "select bj.*, ba.*, g.*";
        $sql .= " from `".DB::table($this->_table)."` bj ";
        $sql .= " left join ".$this->activity_table." ba on bj.bj_a_id = ba.ba_id ";
        $sql .= " left join ".$this->goods_table." g on g.g_id = ba.ba_g_id ";

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
    /*
     * 培训用
     */
    public function getCourseJoinerList($where, $index, $count, $sort){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "select bj.*, ba.*, atc.*";
        $sql .= " from `".DB::table($this->_table)."` bj ";
        $sql .= " left join ".$this->activity_table." ba on bj.bj_a_id = ba.ba_id ";
        $sql .= " left join ".$this->course_table." atc on atc.atc_id = ba.ba_g_id ";

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


    public function getJoinerListTrade($where, $index, $count, $sort){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "select bj.*, t.t_bj_id,t.t_pay_time,t.t_payment,t.t_create_time ";
        $sql .= " from `".DB::table($this->_table)."` bj ";
        $sql .= " left join `pre_trade` t on bj.bj_id = t.t_bj_id and t.t_pay_time > 0 ";
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

    /*
     * 通过活动ID，会员ID查找参与者
     */
    public function findJoinerByAidMid($aid, $mid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'bj_a_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'bj_m_id', 'oper' => '=', 'value' => $mid);

        return $this->getRow($where);
    }

    /*
     * 增加参与者，砍价次数及砍价金额
     */
    public function incrementActivityAmount($jid, $money) {
        $field  = array('bj_total', 'bj_amount');
        $inc    = array(1, $money);

        $where[]    = array('name' => 'bj_id', 'oper' => '=', 'value' => $jid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 获取活动的砍价排行榜
     */
    public function fetchRankListByAid($aid, $index = 0, $count = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'bj_a_id', 'oper' => '=', 'value' => $aid);

        $sort   = array('bj_amount' => 'DESC');

        return $this->getList($where, $index, $count, $sort);
    }

    /*
     * 通过活动id获得参与者信息
     */
    public function fetchMemberByAid($aid,$index = 0 ,$count = 0 ,$sort = array(),$field = array()){
      $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
      $where[]    = array('name' => 'bj_a_id', 'oper' => '=', 'value' => $aid);

      return $this->getList($where, $index, $count, $sort , $field);
    }

    /**
     * @param array $aid
     * @return array|bool
     * 统计每个活动的参与总次数
     */
    public function statisticJoinByAids($aid = array()){
        $where = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if(!empty($aid)){
            $where[]    = array('name' => 'bj_a_id', 'oper' => 'in', 'value' => $aid);
        }
        $sql = 'SELECT bj_a_id, COUNT(*) total ';
        $sql .= ' FROM `pre_bargain_join` ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP by bj_a_id ';
        $ret = DB::fetch_all($sql, array(), 'bj_a_id');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getActivityRow($id){
        $sql = ' SELECT * ';
        $sql .= ' FROM `pre_bargain_join`  bj';
        $sql .= ' LEFT JOIN pre_bargain_activity ba ON ba.ba_id=bj.bj_a_id ';
        $sql .= ' WHERE bj_id = '.intval($id).' AND bj_s_id= '.$this->_shopId;
        $sql .= ' LIMIT 0,1 ';
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getSum($where){
        $sql = ' SELECT sum(bj_amount) as totalMoney,sum(bj_total) totalJoin ';
        $sql .= ' FROM `pre_bargain_join` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}