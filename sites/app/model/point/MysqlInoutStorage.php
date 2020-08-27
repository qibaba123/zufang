<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/3/6
 * Time: 下午7:02
 */
class App_Model_Point_MysqlInoutStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $member_table;
    private $curr_table;

    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'point_inout';
        $this->_pk      = 'pi_id';
        $this->_shopId  = 'pi_s_id';
        $this->member_table = DB::table('member');
        $this->curr_table   = DB::table($this->_table);

        $this->sid      = $sid;
    }
    /*
     * 获取会员的收支列表
     */
    public function getMemberList($mid, $index = 0, $count = 20) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'pi_m_id', 'oper' => '=', 'value' => $mid);

        $sort       = array('pi_create_time' => 'DESC');
        return $this->getList($where, $index, $count, $sort);
    }


    /*
     * 获取会员每天获取的总积分
     */

    public function getMemberSumPoint($mid,$source=0){
        $today = strtotime(date('Y-m-d',time()));
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'pi_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'pi_type', 'oper' => '=', 'value' => 1);  //收入积分
        $where[]    = array('name' => 'pi_create_time', 'oper' => '>', 'value' => $today);
        if($source>0){
            $where[]    = array('name' => 'pi_source', 'oper' => '=', 'value' => $source);
        }
        $sql  = 'SELECT sum(pi_point) total';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 积分统计
     * @param $insert
     * @return bool
     */
    public function pointStatistic($where){
        $sql  = 'SELECT sum(pi_point) total';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 批量增加积分记录
     */
    public function batchData($insert){
         $ret = false;
        if(is_array($insert) && !empty($insert)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`pi_id`, `pi_s_id`, `pi_m_id`, `pi_type`, `pi_title`, `pi_point` , `pi_source`, `pi_extra` ,`pi_manager_id` , `pi_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$insert);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }

    /*
     * 获得列表用户信息
     */
    public function getListMember($where,$index=0,$count=20,$sort){

        $sql    = "SELECT pi.*,m.m_id,m.m_nickname,m.m_points,asl.asl_status FROM `{$this->curr_table}` AS pi ";
        $sql    .= " LEFT JOIN `{$this->member_table}` AS m ON pi.pi_m_id=m.m_id ";
        $sql    .= " LEFT JOIN pre_applet_sequence_leader AS asl ON pi.pi_m_id=asl.asl_m_id ";
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
     * 获得列表用户数量
     */
    public function getCountMember($where){

        $sql    = "SELECT count(*) as total FROM `{$this->curr_table}` AS pi ";
        $sql    .= " LEFT JOIN `{$this->member_table}` AS m ON pi.pi_m_id=m.m_id ";
        $sql    .= " LEFT JOIN pre_applet_sequence_leader AS asl ON pi.pi_m_id=asl.asl_m_id ";
        $sql    .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}