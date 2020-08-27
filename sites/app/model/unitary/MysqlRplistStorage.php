<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/5/24
 * Time: 上午10:42
 */
class App_Model_Unitary_MysqlRplistStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    //会员表
    private $member_table;
    private $rplist_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'unitary_rplist';
        $this->_pk      = 'ur_id';
        $this->_shopId  = 'ur_s_id';
        $this->sid      = $sid;

        $this->member_table = DB::table('member');
        $this->rplist_table = DB::table($this->_table);
    }

    /*
     * 随机获取会员某个红包的中奖记录，判断是否手动领取过
     */
    public function fetchRandomAwardByMidRid($mid, $rid) {
        $where[]    = array('name' => 'ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'ur_red_id', 'oper' => '=', 'value' => $rid);

        return $this->getRow($where);
    }
    /*
     * 修改定时红包分发记录
     */
    public function updateAwardByMidRid($mid, $rid, $set) {
        $where[]    = array('name' => 'ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'ur_red_id', 'oper' => '=', 'value' => $rid);

        return $this->updateValue($set, $where);
    }

    /*
     * 通过红包ID或会员ID获取中奖列表
     */
    public function fetchAwardListByRidOrMid($rid, $mid = null) {
        $where[]    = array('name' => 'ur.ur_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ur.ur_red_id', 'oper' => '=', 'value' => $rid);
        if ($mid) {
            $where[]    = array('name' => 'ur.ur_m_id', 'oper' => '=', 'value' => $mid);
        }
        $where_sql  = $this->formatWhereSql($where);
        $sort       = array('ur.ur_amount' => 'DESC');
        $sort_sql   = $this->getSqlSort($sort);

        $sql = "SELECT ur.*,m.m_id,m.m_show_id,m.m_nickname,m.m_avatar FROM {$this->rplist_table} AS ur JOIN {$this->member_table} AS m ON ur.ur_m_id=m.m_id {$where_sql} {$sort_sql}";

        return DB::fetch_all($sql);
    }
}