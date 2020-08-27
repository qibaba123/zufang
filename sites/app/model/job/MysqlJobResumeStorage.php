<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobResumeStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;
    private $city_table;
    public function __construct($sid){
        $this->_table 	= 'applet_job_resume';
        $this->_pk 		= 'ajr_id';
        $this->_shopId 	= 'ajr_s_id';
        $this->_df      = 'ajr_deleted';
        $this->member_table = DB::table('member');
        $this->city_table = DB::table('applet_job_resume_city');
        parent::__construct();
        $this->sid  = $sid;

    }

    //根据会员id获取简历
    public function getUpdateByMid($mid, $data=array()){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_m_id', 'oper' => '=', 'value' => $mid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getResumeMemberList($where, $index, $count, $sort = array('ajr_create_time' => 'desc')){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_deleted', 'oper' => '=', 'value' => 0);
        $sql  = ' SELECT ajr.*,m.m_id,m.m_nickname,m.m_avatar,ajc.ajc_name ';
        $sql .= " from `".DB::table($this->_table)."` ajr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = ajr.ajr_m_id ";
        $sql .= " left join pre_applet_job_category ajc on ajr.ajr_cate2 = ajc.ajc_id";
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

    public function getCityResumeMemberList($where, $index, $count, $sort = array('ajr_create_time' => 'desc')){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_deleted', 'oper' => '=', 'value' => 0);
        $sql  = ' SELECT ajr.*,m.m_id,m.m_nickname,m.m_avatar,ajc.ajc_name ';
        $sql .= " from `".$this->city_table."` ajrc  ";
        $sql .= " left join `".DB::table($this->_table)."` ajr on ajr.ajr_id = ajrc.ajrc_r_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = ajr.ajr_m_id ";
        $sql .= " left join pre_applet_job_category ajc on ajr.ajr_cate2 = ajc.ajc_id";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
//        Libs_Log_Logger::outputLog($sql,'test.log');
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCityResumeMemberCount($where){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_deleted', 'oper' => '=', 'value' => 0);
        $sql  = ' SELECT count(*) as total ';
        $sql .= " from `".$this->city_table."` ajrc  ";
        $sql .= " left join `".DB::table($this->_table)."` ajr on ajr.ajr_id = ajrc.ajrc_r_id ";
        $sql .= " left join ".$this->member_table." m on m.m_id = ajr.ajr_m_id ";
        $sql .= " left join pre_applet_job_category ajc on ajr.ajr_cate2 = ajc.ajc_id";
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
//        Libs_Log_Logger::outputLog($sql,'test.log');
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}