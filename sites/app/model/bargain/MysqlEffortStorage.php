<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/14
 * Time: 上午9:40
 */
class App_Model_Bargain_MysqlEffortStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $member_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'bargain_effort';
        $this->_pk      = 'be_id';
        $this->_shopId  = 'be_s_id';
        $this->member_table = DB::table('member');

        $this->sid      = $sid;
    }

    /*
     * 通过活动ID，会员ID查找参与者
     */
    public function findHelperByJidMid($jid, $mid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'be_j_id', 'oper' => '=', 'value' => $jid);
        $where[]    = array('name' => 'be_m_id', 'oper' => '=', 'value' => $mid);

        return $this->getRow($where);
    }

    /*
     * 获取参与者的砍价列表
     */
    public function fetchHelpListByJid($jid, $index = 0, $count = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'be_j_id', 'oper' => '=', 'value' => $jid);
        $sort       = array('be_help_time' => 'ASC');
        return $this->getList($where, $index, $count, $sort);
    }

    /*
     * 获取参与者的砍价列表
     */
    public function fetchHelpCountByJid($jid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'be_j_id', 'oper' => '=', 'value' => $jid);
        return $this->getCount($where);
    }

    /*
     * 获取参与者的砍价列表(新)
     */
    public function newFetchHelpListByJid($jid, $index = 0, $count = 0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'be_j_id', 'oper' => '=', 'value' => $jid);
        $sort       = array('be_help_time' => 'ASC');
        $sql = 'SELECT be.*,m.m_id,m.m_nickname,m.m_avatar ';
        $sql .= ' FROM `pre_bargain_effort` be';
        $sql .= " left join ".$this->member_table." m on m.m_id = be.be_m_id ";
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
     * 获取会员为活动已砍价次数
     */
    public function fetchCountByAidMid($aid, $mid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'be_a_id', 'oper' => '=', 'value' => $aid);
        $where[]    = array('name' => 'be_m_id', 'oper' => '=', 'value' => $mid);

        return $this->getCount($where);
    }

    /*
     * 获取每个活动砍价的总助力次数
     */
    public function fetchCountByAids($aid = array()){
        $where = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if(!empty($aid)){
            $where[]    = array('name' => 'be_a_id', 'oper' => 'in', 'value' => $aid);
        }
        $sql = 'SELECT be_a_id, COUNT(*) total ';
        $sql .= ' FROM `pre_bargain_effort` ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP by be_a_id ';
        $ret = DB::fetch_all($sql, array(), 'be_a_id');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}