<?php
/*
 * 社区团购
 */
class App_Model_Sequence_MysqlSequencePickStationStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    private $member_extra;
    private $manager_table;
    private $leader_table;
    private $community_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_pick_station';
        $this->_pk = 'asps_id';
        $this->_shopId = 'asps_s_id';
        $this->sid = $sid;
        $this->_df = 'asps_deleted';
        $this->member_table = DB::table('member');
        $this->member_extra = DB::table('applet_member_extra');
        $this->manager_table = DB::table('applet_sequence_pick_station_manager');
        $this->leader_table = DB::table('applet_sequence_leader');
        $this->community_table = DB::table('applet_sequence_community');

    }

    /*
     *
     */
    public function getStationList($where,$index,$count,$sort){
        $where[] = ['name' => $this->_df, 'oper' => '=', 'value' => 0];
        $sql = "SELECT asps.*,aspsm.aspsm_nickname,aspsm.aspsm_avatar,aspsm.aspsm_show_id ";
        $sql .= " FROM ".DB::table($this->_table)." asps ";
        $sql .= " LEFT JOIN ".$this->manager_table." aspsm on aspsm.aspsm_id=asps.asps_manager_id ";
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

    public function getStationCount($where){
        $where[] = ['name' => $this->_df, 'oper' => '=', 'value' => 0];
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asps ";
        $sql .= " LEFT JOIN ".$this->manager_table." aspsm on aspsm.aspsm_id=asps.asps_manager_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     *
     */
    public function getStationRow($id){
        $where[] = array('name' => $this->_pk,'oper'=> '=', 'value' => $id);
        $where[] = array('name' => $this->_shopId,'oper'=> '=', 'value' => $this->sid);
        $where[] = ['name' => $this->_df, 'oper' => '=', 'value' => 0];
        $sql = "SELECT asps.*,aspsm.aspsm_nickname,aspsm.aspsm_avatar,aspsm.aspsm_show_id ";
        $sql .= " FROM ".DB::table($this->_table)." asps ";
        $sql .= " LEFT JOIN ".$this->manager_table." aspsm on aspsm.aspsm_id=asps.asps_manager_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function dealWithdraw($money,$sid,$id){
        $where      = array();
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $id);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[] = ['name' => $this->_df, 'oper' => '=', 'value' => 0];
        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET asps_deduct_ktx = asps_deduct_ktx - '.intval($money);
        $sql .= ' , asps_deduct_ytx = asps_deduct_ytx + '.intval($money);
        $sql .= $this->formatWhereSql($where);

        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     *
     */
    public function getStationLeaderList($where,$index,$count,$sort){
        $where[] = ['name' => $this->_df, 'oper' => '=', 'value' => 0];
        $sql = "SELECT asps.*,asl.asl_name,asl.asl_mobile,asct.asc_name ";
        $sql .= " FROM ".DB::table($this->_table)." asps ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_id=asps.asps_leader_id ";
        $sql .= " LEFT JOIN ".$this->community_table." asct on asct.asc_id=asps.asps_com_id ";
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

    public function getStationLeaderCount($where){
        $where[] = ['name' => $this->_df, 'oper' => '=', 'value' => 0];
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." asps ";
        $sql .= " LEFT JOIN ".$this->leader_table." asl on asl.asl_id=asps.asps_leader_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 可提现佣金 总佣金
     */
    public function incrementStationDeduct($id, $deduct) {
        $field  = array('asps_deduct_ktx', 'asps_deduct_amount');
        $inc    = array($deduct, $deduct);

        $where[]    = array('name' => 'asps_id', 'oper' => '=', 'value' => $id);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }


}