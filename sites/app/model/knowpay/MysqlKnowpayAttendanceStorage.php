<?php
/*
 * 知识付费小程序首页配置
 */
class App_Model_Knowpay_MysqlKnowpayAttendanceStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;
    public function __construct($sid){
        $this->_table 	= 'applet_knowpay_attendance';
        $this->_pk 		= 'aka_id';
        $this->_shopId 	= 'aka_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->member_table = DB::table('member');
    }

    //获取签到排行榜
    public function getRankList($where, $index, $count){
        $sort = array('total' => 'desc');
        $sql = "select count(*) as total, m.m_avatar, m.m_nickname ";
        $sql .= " from `".DB::table($this->_table)."` aka ";
        $sql .= " left join ".$this->member_table." m on aka.aka_m_id = m.m_id ";

        $sql .= $this->formatWhereSql($where);
        $sql .= " group by aka_m_id";
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