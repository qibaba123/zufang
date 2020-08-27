<?php
/*
 * 爆品分销 已开团的群组表
 */
class App_Model_Sequence_MysqlSequenceGroupStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    private $member_extra;
    private $leader_table;
    private $activity_table;
    private $community_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_group';
        $this->_pk = 'asg_id';
        $this->_shopId = 'asg_s_id';
        $this->sid = $sid;
        $this->member_table = DB::table('member');
        $this->member_extra = DB::table('applet_member_extra');
        $this->leader_table = DB::table('applet_sequence_leader');
        $this->activity_table = DB::table('applet_sequence_activity');
        $this->community_table = DB::table('applet_sequence_community');

    }

    /*
     * 根团长id 小区id 活动id 查看是否开团
     */
    public function getRowByLidCidAid($cid,$aid,$leader = 0){
        if($leader){
            $where[] = array('name' =>'asg_leader', 'oper' => '=', 'value' => $leader);
        }
        $where[] = array('name' =>'asg_a_id', 'oper' => '=', 'value' => $aid);
        $where[] = array('name' =>'asg_c_id', 'oper' => '=', 'value' => $cid);
        $where[] = array('name' =>$this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getRow($where);
    }

    /*
     * 获得小区列表 关联团长表
     */
    public function getGroupLeaderList($where,$index,$count,$sort){

        $sql = "SELECT asg.*,asl.*,asct.*,m.m_nickname,m.m_avatar,m.m_show_id,asa.asa_start,asa.asa_end,asa.asa_title,asa.asa_desc,asa.asa_id,ame.* ";
        $sql .= " FROM ".DB::table($this->_table)." asg ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_id=asg.asg_leader ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN ".$this->member_extra." ame on ame.ame_m_id=asl.asl_m_id ";
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

    public function getGroupLeaderCount($where){

        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asg ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_id=asg.asg_leader ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN ".$this->member_extra." ame on ame.ame_m_id=asl.asl_m_id ";
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
     * 获得小区列表 关联团长表
     */
    public function getGroupLeaderRow($id){
        $where[] = array('name' => $this->_pk,'oper'=> '=', 'value' => $id);
        $where[] = array('name' => $this->_shopId,'oper'=> '=', 'value' => $this->sid);
        $sql = "SELECT asg.*,asl.*,asct.*,m.m_nickname,m.m_avatar,m.m_show_id,asa.asa_start,asa.asa_end,asa.asa_title,asa.asa_desc,asa.asa_id,ame.* ";
        $sql .= " FROM ".DB::table($this->_table)." asg ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_id=asg.asg_leader ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN ".$this->member_extra." ame on ame.ame_m_id=asl.asl_m_id ";
        $sql .= " LEFT JOIN ".$this->activity_table." asa on asa.asa_id=asg.asg_a_id ";
        $sql .= " LEFT JOIN ".$this->community_table." asct on asct.asc_id=asg.asg_c_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}