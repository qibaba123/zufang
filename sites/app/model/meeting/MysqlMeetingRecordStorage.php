<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_Meeting_MysqlMeetingRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_meeting_record';
        $this->_pk = 'amr_id';
        $this->_shopId = 'amr_s_id';
        $this->member_table = DB::table('member');

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    public function getJoinNum($id){
        $where[] = array('name' => 'amr_s_id' , 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'amr_l_id' , 'oper' => '=', 'value' => $id);

        $sql = 'SELECT count(*) ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';

        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListMember($where, $index, $count){
        $sql = "select amr.*,m.m_id,m.m_nickname,m.m_avatar,m.m_mobile ";
        $sql .= " from `".DB::table($this->_table)."` amr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = amr.amr_m_id ";

        $sort = array('amr_create_time' => 'desc');
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

    public function getListCount($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` amr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = amr.amr_m_id ";

        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}
