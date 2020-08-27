<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/3/8
 * Time: 下午3:14
 */
class App_Model_Point_MysqlPointSignStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $member_table;
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'point_sign';
        $this->_pk      = 'ps_id';
        $this->_shopId  = 'ps_s_id';

        $this->sid      = $sid;
        $this->member_table = DB::table('member');
    }
    /*
     * 获取会员签到记录
     */
    public function findSignByMid($mid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ps_m_id', 'oper' => '=', 'value' => $mid);

        return $this->getRow($where);
    }

    /*
     * 获得签到积分领取记录表 关联会员表
     */
    public function getListMember($where,$index = 0,$count = 15,$sort = array()){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "SELECT ps.*,m.m_nickname,m.m_avatar,m.m_show_id ";
        $sql .= " FROM ".DB::table($this->_table)." ps ";
        $sql .= " LEFT JOIN ".$this->member_table." m on ps.ps_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            //trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListMemberCount($where){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." ps ";
        $sql .= " LEFT JOIN ".$this->member_table." m on ps.ps_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            //trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}