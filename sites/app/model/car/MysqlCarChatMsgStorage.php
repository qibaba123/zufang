<?php

class App_Model_Car_MysqlCarChatMsgStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_car_chat_msg';
        $this->_pk     = 'accm_id';
        $this->_shopId = 'accm_s_id';
        $this->sid     = $sid;
        $this->member_table = DB::table('member');
    }

    /*
     * 根据会员id和会话id 获得未读信息数量和最后一条信息
     */
    public function getCountLast($mid,$dialog, $test=0){
        $sql = "SELECT accm.*,";
        $sql .= "(select count(*) from ".DB::table($this->_table)." where accm_s_id = {$this->sid} AND accm_dialog = {$dialog} AND accm_m_id = {$mid} AND accm_read = 0 ) as total ";//获得对方发送的未读数量
        $sql .= " FROM ".DB::table($this->_table)." accm ";
        $sql .= " where accm_s_id = {$this->sid} AND accm_dialog = {$dialog} ";
        $sql .= " order by accm_create_time DESC ";
        $sql .= $this->formatLimitSql(0,1);

        if($test) {
            return $sql;
        }
        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据会员id和会话id 获得未读信息数量和最后一条信息
     *  -2019-11-09
     */
    public function getNOReadCountLast($mid,$dialog){
        $sql = "SELECT accm.*,";
        $sql .= "(select count(*) from ".DB::table($this->_table)." where accm_s_id = {$this->sid} AND accm_dialog = {$dialog} AND accm_to_mid = {$mid} AND accm_read = 0 ) as total ";//获得对方发送的未读数量
        $sql .= " FROM ".DB::table($this->_table)." accm ";
        $sql .= " where accm_s_id = {$this->sid} AND accm_dialog = {$dialog} ";
        $sql .= " order by accm_create_time DESC ";
        $sql .= $this->formatLimitSql(0,1);

        $ret = DB::fetch_all($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
 * 获得聊天信息
 */
    public function getListMember($where,$index,$count,$sort){
        $sql = "SELECT accm.*,m.m_id,m.m_avatar,m.m_nickname ";
        $sql .= " FROM ".DB::table($this->_table)." accm ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id = accm.accm_m_id ";
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

    /*
     * 获得聊天信息
     */
    public function getListMemberCompany($where,$index,$count,$sort){
        $sql = "SELECT accm.*,m.m_id,m.m_avatar,m.m_nickname,c.ajc_id,c.ajc_logo,c.ajc_company_name ";
        $sql .= " FROM ".DB::table($this->_table)." accm ";
        $sql .= " LEFT JOIN ".$this->member_table." m on m.m_id = accm.accm_m_id ";
        $sql .= " LEFT JOIN pre_applet_job_company c on c.ajc_id = accm.accm_m_id ";
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



    /**
     *  统计数量
     *  ** 没有deleted
     */
    public function getNoReadCount($where) {

        $sql = '';
        $sql .= " Select count(*) ";
        $sql .= " FROM ".DB::table($this->_table)." accm ";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if($ret === false){
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;

    }

}