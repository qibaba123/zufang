<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/1/7
 * Time: 下午2:32
 */
class App_Model_Redpack_MysqlListStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    private $curr_table = '';
    private $member_table;
    private $act_table;
    private $tpl_table;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'redpack_list';
        $this->_pk      = 'rl_id';
        $this->_shopId  = 'rl_s_id';

        $this->sid          = $sid;
        $this->curr_table   = DB::table($this->_table);
        $this->member_table = DB::table('member');
        $this->act_table    = DB::table('redpack_command');
        $this->tpl_table    = DB::table('redpack_tpl');
    }

    /*
     * 修改或插入一条数据
     */
    public function getRowUpdate($id,$data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
    /*
     * 查找未被领取的口令红包
     */
    public function findNoReceived($command, $actid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rl_actid', 'oper' => '=', 'value' => $actid);
        $where[]    = array('name' => 'rl_command', 'oper' => '=', 'value' => $command);
        $where[]    = array('name' => 'rl_received', 'oper' => '=', 'value' => 0);//未被领取

        return $this->getRow($where);
    }

    /*
     * 根据活动id获取口令红包
     */
    public function getListByRcid($rcid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rl_actid', 'oper' => '=', 'value' => $rcid);
        $files = array('rl_command','rl_received');
        return $this->getList($where,0,0,array(),$files);
    }

    /*
     * 根据条件获取口令红包列表及会员信息
     */
    public function getListMemberByRcid($where,$index=0,$count=20,$sort){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql    = "SELECT rl.*,m.m_id,m.m_nickname FROM `{$this->curr_table}` AS rl ";
        $sql    .= " LEFT JOIN `{$this->member_table}` AS m ON rl.rl_m_id=m.m_id ";
        $sql    .= $this->formatWhereSql($where);
        $sql    .= $this->getSqlSort($sort);
        $sql    .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据活动id获取口令红包列表及会员信息
     */
    public function getListMemberCountByRcid($where){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql    = "SELECT count(*) FROM `{$this->curr_table}` AS rl ";
        $sql    .= " LEFT JOIN `{$this->member_table}` AS m ON rl.rl_m_id=m.m_id ";
        $sql    .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 通过口令获取红包活动
     */
    public function findRedpackByCommand($command) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rl_command', 'oper' => '=', 'value' => $command);

        $sql    = "SELECT rl.*,rc.*,rt.* FROM `{$this->curr_table}` AS rl ";
        $sql    .= " LEFT JOIN `{$this->act_table}` AS rc ON rl.rl_actid=rc.rc_id ";
        $sql    .= " LEFT JOIN `{$this->tpl_table}` AS rt ON rc.rc_rp_id=rt.rt_id ";
        $sql    .= $this->formatWhereSql($where);

        $ret    = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
    /*
     * 判断单会员、单活动已领取数量
     */
    public function countMemberReceived($mid, $actid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'rl_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'rl_actid', 'oper' => '=', 'value' => $actid);

        return $this->getCount($where);
    }
}