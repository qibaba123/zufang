<?php
/*
 * 社区团购 活动参加表
 */
class App_Model_Sequence_MysqlSequenceActivityJoinStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_activity_join';
        $this->_pk = 'asaj_id';
        $this->_shopId = 'asaj_s_id';
        $this->sid = $sid;
        $this->member_table = DB::table('member');
    }

    /*
     * 获得加入活动的用户
     */
    public function getJoinMemberList($where,$index,$count,$sort){
        $sql  = 'SELECT asaj.asaj_create_time,m.m_nickname,m.m_avatar,m.m_id ';
        $sql .= ' FROM '.DB::table($this->_table).' asaj ';
        $sql .= ' LEFT JOIN '.$this->member_table.' m on m.m_id = asaj.asaj_m_id';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY asaj.asaj_m_id ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param array $val_arr
     * @return bool
     * 批量插入数据
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`asaj_id`, `asaj_s_id`,  `asaj_a_id`, `asaj_m_id`, `asaj_g_id`,   `asaj_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }


}