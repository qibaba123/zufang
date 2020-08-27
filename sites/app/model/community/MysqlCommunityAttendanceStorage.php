<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/8/17
 * Time: 上午10:39
 */
class App_Model_Community_MysqlCommunityAttendanceStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $shop_table;
    private $member_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_community_attendance';
        $this->_pk = 'aca_id';
        $this->_shopId = 'aca_s_id';

        $this->sid = $sid;
        $this->shop_table = DB::table('shop');
        $this->member_table = DB::table('member');
    }

    //获取签到排行榜
    public function getRankList($where, $index, $count){
        $sort = array('total' => 'desc');
        $sql = "select count(*) as total, m.m_avatar, m.m_nickname ";
        $sql .= " from `".DB::table($this->_table)."` aca ";
        $sql .= " left join ".$this->member_table." m on aca.aca_m_id = m.m_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= " group by aca_m_id";
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
