<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobSendStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_job_send';
        $this->_pk 		= 'ajs_id';
        $this->_shopId 	= 'ajs_s_id';
        parent::__construct();
        $this->sid  = $sid;

    }

    //根据简历id和职位id获取投递记录
    public function getSendByRidPid($rid, $pid){
        $where[] = array('name' => 'ajs_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajs_ajr_id', 'oper' => '=', 'value' => $rid);
        $where[] = array('name' => 'ajs_ajp_id', 'oper' => '=', 'value' => $pid);
        $where[] = array('name' => 'ajs_deleted', 'oper' => '=', 'value' => 0);

        return $this->getRow($where);
    }

    //根据会员id获取投递列表
    public function getListByMid($where, $index, $count, $sort){
        $where[] = array('name' => 'ajs_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajs_deleted', 'oper' => '=', 'value' => 0);
        $sql = "select ajs.*, ajp.*, ajc.* ";
        $sql .= " from `".DB::table($this->_table)."` ajs ";
        $sql .= " left join pre_applet_job_position ajp on ajs.ajs_ajp_id = ajp.ajp_id ";
        $sql .= " left join pre_applet_job_company ajc on ajp.ajp_es_id = ajc.ajc_es_id";

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

    //根据会员id和职位id获取投递记录
    public function getRowByMidPid($mid, $pid){
        $where[] = array('name' => 'ajs_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajs_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajs_ajp_id', 'oper' => '=', 'value' => $pid);
        $where[] = array('name' => 'ajs_deleted', 'oper' => '=', 'value' => 0);

        $sql  = ' SELECT ajs.*,ajp.* ';
        $sql .= " from `".DB::table($this->_table)."` ajs ";
        $sql .= " left join pre_applet_job_position ajp on ajs.ajs_ajp_id = ajp.ajp_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //根据会员id和公司id获取已入职投递记录
    public function getEntryRowByMidPid($mid, $esId=0){
        $where[] = array('name' => 'ajs_s_id', 'oper' => '=', 'value' => $this->sid);
        if($esId){
            $where[] = array('name' => 'ajp_es_id', 'oper' => '=', 'value' => $esId);
        }
        $where[] = array('name' => 'ajs_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajs_status', 'oper' => '=', 'value' => 7);

        $sql  = ' SELECT ajs.*,ajp.* ';
        $sql .= " from `".DB::table($this->_table)."` ajs ";
        $sql .= " left join pre_applet_job_position ajp on ajs.ajs_ajp_id = ajp.ajp_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    //根据简历id和公司id获取最新投递记录
    public function getSendRowByRidEsid($rid, $esId){
        $where[] = array('name' => 'ajs_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajp_es_id', 'oper' => '=', 'value' => $esId);
        $where[] = array('name' => 'ajs_ajr_id', 'oper' => '=', 'value' => $rid);
        $sort = array('ajs_create_time' => 'desc');

        $sql  = ' SELECT ajs.*,ajp.* ';
        $sql .= " from `".DB::table($this->_table)."` ajs ";
        $sql .= " left join pre_applet_job_position ajp on ajs.ajs_ajp_id = ajp.ajp_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql(0,0);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret[0];
    }

    /*
     * 获取会员不同类型下订单的数量
     */
    public function fetchMemberCountByType($mid, $type = 'all') {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajs_m_id', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajs_deleted', 'oper' => '=', 'value' => 0);

        switch ($type) {
            case 'all' :
                $where[] = array('name' => 'ajs_seeker_read', 'oper' => '=', 'value' => 0);
                break;
            case 'send' : //已投递
                $where[]    = array('name' => 'ajs_status', 'oper' => 'in', 'value' => [1]);
                break;
            case 'interview' : //面试中
                $where[]    = array('name' => 'ajs_status', 'oper' => 'in', 'value' => [3, 4, 5]);
                break;
            case 'refuse' : //不合适
                $where[] = array('name' => 'ajs_seeker_read', 'oper' => '=', 'value' => 0);
                $where[] = array('name' => 'ajs_status', 'oper' => '=', 'value' => 8);
                break;
        }
        return $this->getCount($where);
    }

    /*
     * 获取公司不同类型的数量
     */
    public function fetchCompanyCountByType($esId, $type = 'all', $pid=0, $all=false) {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($esId){
            $where[] = array('name' => 'ajp_es_id', 'oper' => '=', 'value' => $esId);
        }
        if($pid){
            $where[] = array('name' => 'ajp_id', 'oper' => '=', 'value' => $pid);
        }
        if(!$all){
            $where[] = array('name' => 'ajs_company_deleted', 'oper' => '=', 'value' => 0);
        }

        switch ($type) {
            case 'send' : //待处理
                $where[]    = array('name' => 'ajs_status', 'oper' => '=', 'value' => 1);
                break;
            case 'interview' : //待面试
                $where[]    = array('name' => 'ajs_status', 'oper' => 'in', 'value' => [3, 4]);
                break;
            case 'entry' : //已面试
                $where[]    = array('name' => 'ajs_status', 'oper' => 'in', 'value' => [5, 6, 7]);
                break;
            case 'refuse' : //不合适
                $where[]    = array('name' => 'ajs_status', 'oper' => '=', 'value' => 8);
                break;
        }
        $sql = "select count(*)";
        $sql .= " from `".DB::table($this->_table)."` ajs ";
        $sql .= " left join pre_applet_job_position ajp on ajp.ajp_id = ajs.ajs_ajp_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取简历管理列表（公司）
     */
    public function getResumeManageList($where, $status, $index, $count, $all=false){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if(!$all){
            $where[] = array('name' => 'ajs_company_deleted', 'oper' => '=', 'value' => 0);
        }
        $sort = array('ajs_update_time' => 'desc');
        switch ($status) {
            case 'all':
                break;
            case 'send' : //待处理
                $where[]    = array('name' => 'ajs_status', 'oper' => '=', 'value' => 1);
                break;
            case 'interview' : //待面试
                $where[]    = array('name' => 'ajs_status', 'oper' => 'in', 'value' => [3, 4]);
                break;
            case 'entry' : //已面试
                $where[]    = array('name' => 'ajs_status', 'oper' => 'in', 'value' => [5, 6, 7]);
                break;
            case 'refuse' : //不合适
                $where[]    = array('name' => 'ajs_status', 'oper' => '=', 'value' => 8);
                break;
        }
        $sql = "select *";
        $sql .= " from `".DB::table($this->_table)."` ajs ";
        $sql .= " left join pre_applet_job_position ajp on ajp.ajp_id = ajs.ajs_ajp_id ";
        $sql .= " left join pre_applet_job_resume ajr on ajs.ajs_ajr_id = ajr.ajr_id ";
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

    public function fetchCompanyResumeCountByType($esId, $mid,$type="refuse"){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajp_es_id', 'oper' => '=', 'value' => $esId);
        $where[] = array('name' => 'ajs_company_deleted', 'oper' => '=', 'value' => 0);

        switch ($type) {
            case 'send' : //待处理
                $where[]    = array('name' => 'ajs_status', 'oper' => '=', 'value' => 1);
                break;
            case 'interview' : //待面试
                $where[]    = array('name' => 'ajs_status', 'oper' => 'in', 'value' => [3, 4, 5, 6]);
                break;
            case 'entry' : //待入职
                $where[]    = array('name' => 'ajs_status', 'oper' => '=', 'value' => 7);
                break;
            case 'refuse' : //不合适
                $where[]    = array('name' => 'ajs_status', 'oper' => '=', 'value' => 8);
                break;
        }
        $sql = "select *";
        $sql .= " from `".DB::table($this->_table)."` ajs ";
        $sql .= " left join pre_applet_job_position ajp on ajp.ajp_id = ajs.ajs_ajp_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        foreach ($ret as $key=>$val){
            if(in_array($mid, json_decode($val['ajs_company_read'], true))){
                unset($ret[$key]);
            }
        }
        return count($ret);
    }

    /**
     * 获取投递简历详情
     */
    public function fetchSendResumeDetail($id){
        $where[] = array('name' => 'ajs_id', 'oper' => '=', 'value' => $id);

        $sql  = ' SELECT * ';
        $sql .= " from `".DB::table($this->_table)."` ajs ";
        $sql .= " left join pre_applet_job_resume ajr on ajs.ajs_ajr_id = ajr.ajr_id ";
        $sql .= " left join pre_applet_job_position ajp on ajp.ajp_id = ajs.ajs_ajp_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取投递职位和公司
     */
    public function fetchSendPositionCompanyDetail($id){
        $where[] = array('name' => 'ajs_id', 'oper' => '=', 'value' => $id);

        $sql  = ' SELECT * ';
        $sql .= " from `".DB::table($this->_table)."` ajs ";
        $sql .= " left join pre_applet_job_position ajp on ajp.ajp_id = ajs.ajs_ajp_id ";
        $sql .= " left join pre_applet_job_company ajc on ajc.ajc_es_id = ajp.ajp_es_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}