<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_City_MysqlCityRedbagReceiveStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;

    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_city_redbag_receive';
        $this->_pk = 'acrr_id';
        $this->_shopId = 'acrr_s_id';
        $this->member_table = DB::table('member');

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
    }

    public function hadReceive($pid, $uid){
        $where[] = array('name' => 'acrr_m_id','oper' => '=', 'value' => $uid);
        $where[] = array('name' => 'acrr_s_id','oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acrr_type','oper' => '=', 'value' => 0);
        $where[] = array('name' => 'acrr_post_id','oper' => '=', 'value' => $pid);
        return $this->getRow($where);
    }

    public function getReceiveMemberList($pid, $index, $count){
        $where[] = array('name' => 'acrr_s_id','oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acrr_post_id','oper' => '=', 'value' => $pid);
        $where[] = array('name' => 'acrr_type','oper' => '=', 'value' => 0);

        $sql = "select acrr.*,m.m_id,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` acrr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acrr.acrr_m_id ";

        $sort = array('acrr_create_time' => 'desc');
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

    public function getReceiveMemberCount($pid){
        $where[] = array('name' => 'acrr_s_id','oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'acrr_post_id','oper' => '=', 'value' => $pid);
        $where[] = array('name' => 'acrr_type','oper' => '=', 'value' => 0);

        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` acrr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = acrr.acrr_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}