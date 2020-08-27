<?php
/*
 * 爆品分销 参与表
 */
class App_Model_Sequence_MysqlSequenceGroupJoinStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    private $leader_table;
    private $activity_table;
    private $group_table;
    private $community_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_group_join';
        $this->_pk = 'asgj_id';
        $this->_shopId = 'asgj_s_id';
        $this->sid = $sid;
        $this->member_table = DB::table('member');
        $this->leader_table = DB::table('applet_sequence_leader');
        $this->activity_table = DB::table('applet_sequence_activity');
        $this->group_table = DB::table('applet_sequence_group');
        $this->community_table = DB::table('applet_sequence_community');
    }

    /*
     * 获得参与情况 关联会员表、团长表、群组表
     */
    public function getJoinList($where,$index,$count,$sort){
        $sql = "SELECT asgj.*,asg.*,asl.*,asct.*,asa.*,m.m_nickname,m.m_avatar,m.m_show_id ";
        $sql .= " FROM ".DB::table($this->_table)." asgj ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_m_id=asgj.asgj_m_id ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asgj.asgj_m_id ";
        $sql .= " LEFT JOIN ".$this->group_table." asg on asg.asg_id=asgj.asgj_asg_id ";
        $sql .= " LEFT JOIN ".$this->activity_table." asa on asa.asa_id=asg.asg_a_id ";
        $sql .= " LEFT JOIN ".$this->community_table." asct on asct.asc_id=asg.asg_c_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getJoinCount($where){
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asgj ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_m_id=asgj.asgj_m_id ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asgj.asgj_m_id ";
        $sql .= " LEFT JOIN ".$this->group_table." asg on asg.asg_id=asgj.asgj_asg_id ";
        $sql .= " LEFT JOIN ".$this->activity_table." asa on asa.asa_id=asg.asg_a_id ";
        $sql .= " LEFT JOIN ".$this->community_table." asct on asct.asc_id=asg.asg_c_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据群组id和会员id  查找会员是否参加过活动
     */
    public function findRowByAsgidMid($asgid,$mid){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asgj_asg_id', 'oper' => '=', 'value' => $asgid);
        $where[] = array('name' => 'asgj_m_id', 'oper' => '=', 'value' => $mid);
        return $this->getRow($where);
    }

    /*
     * 根据群组id 获得当前参与数量
     */
    public function getJoinCountByGroup($asgid){
        $where = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'asgj_asg_id', 'oper' => '=', 'value' => $asgid);
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asgj ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}