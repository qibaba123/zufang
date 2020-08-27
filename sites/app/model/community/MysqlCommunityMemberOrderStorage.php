<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/3
 * Time: 下午10:12
 */
class App_Model_Community_MysqlCommunityMemberOrderStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $member_table='';

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_community_member_order';
        $this->_pk      = 'acmo_id';
        $this->_shopId  = 'acmo_s_id';
        $this->member_table = DB::table('member');
        $this->sid      = $sid;
    }

    public function findUpdateByNumber($tid, $data = null){
        $where[]    = array('name' => 'acmo_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'acmo_s_id', 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getListCount($where){
        $sql = 'SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m_id=acmo_m_id ';

        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListMember($where, $index, $count, $sort){
        $sql = 'SELECT acmo.* ,m_nickname ';
        $sql .= ' FROM `'.DB::table($this->_table).'` acmo ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m ON m_id=acmo_m_id ';

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
}