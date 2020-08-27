<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobRelationStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $member_table;

    public function __construct($sid){
        $this->_table 	= 'applet_job_relation';
        $this->_pk 		= 'ajr_id';
        $this->_shopId 	= 'ajr_s_id';
        $this->member_table = DB::table('member');
        parent::__construct();
        $this->sid  = $sid;
    }

    //获取推荐排行
    public function getRecommendRank($where, $index, $count){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $sort = array('num' => 'desc');

        $sql  = ' SELECT count(*) as num, ajr.*, m.*';
        $sql .= " from `".DB::table($this->_table)."` ajr";
        $sql .= " left join ".$this->member_table." m on m.m_id = ajr.ajr_f1_mid ";

        $sql .= $this->formatWhereSql($where);
        $sql .= ' group by ajr_f1_mid ';
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
     * 获取我推荐的职位信息
     */
    public function getPositionList($where, $index, $count){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);

        $sort = array('ajr_create_time' => 'desc');
        $sql  = ' SELECT *';
        $sql .= " from `".DB::table($this->_table)."` ajr";
        $sql .= " left join pre_applet_job_position ajp on ajp.ajp_id = ajr.ajr_ajp_id ";
        $sql .= " left join pre_applet_job_company ajc on ajp.ajp_es_id = ajc.ajc_es_id";

        $sql .= $this->formatWhereSql($where);
        $sql .= ' group by ajr_ajp_id ';
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
     * 获取不同状态的数量
     */
    public function getRecommendStatus($status, $pid, $mid, $index, $count){
        $where[] = array('name' => 'ajr_f1_mid', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_ajp_id', 'oper' => '=', 'value' => $pid);
        $sort    = array('ajr_create_time' => 'desc');
        switch ($status){
            case 'invite':
                $where[] = array('name' => 'ajs_status', 'oper' => 'in', 'value' => array(3, 4, 5));
                $where[] = array('name' => 'ajs_f1_mid', 'oper' => '!=', 'value' => 0);
                break;
            case 'interview':
                $where[] = array('name' => 'ajs_status', 'oper' => 'in', 'value' => array(3, 4, 5));
                $where[] = array('name' => 'ajs_f1_mid', 'oper' => '!=', 'value' => 0);
                break;
            case 'entry':
                $where[] = array('name' => 'ajs_status', 'oper' => 'in', 'value' => array(6, 7));
                $where[] = array('name' => 'ajs_f1_mid', 'oper' => '!=', 'value' => 0);
                break;
            case 'all':
                break;
        }
        $sql  = ' SELECT ajr.*, ajs.*, m.m_id, m.m_nickname, m.m_avatar';
        $sql .= " from `".DB::table($this->_table)."` ajr";
        $sql .= " left join pre_applet_job_send ajs on ajs.ajs_id = ajr.ajr_ajs_id ";
        $sql .= " left join pre_member m on ajr.ajr_mid = m.m_id ";

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

    /**
     * 获取不同状态的数量
     */
    public function getStatusCount($status, $pid, $mid){
        $where[] = array('name' => 'ajr_f1_mid', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_ajp_id', 'oper' => '=', 'value' => $pid);
        switch ($status){
            case 'interview':
                $where[] = array('name' => 'ajs_status', 'oper' => 'in', 'value' => array(3, 4, 5));
                $where[] = array('name' => 'ajr_ajs_id', 'oper' => '!=', 'value' => 0);
                $where[] = array('name' => 'ajs_f1_mid', 'oper' => '!=', 'value' => 0);
                break;
            case 'entry':
                $where[] = array('name' => 'ajs_status', 'oper' => 'in', 'value' => array(6, 7));
                $where[] = array('name' => 'ajr_ajs_id', 'oper' => '!=', 'value' => 0);
                $where[] = array('name' => 'ajs_f1_mid', 'oper' => '!=', 'value' => 0);
                break;
            case 'show':

                break;
        }
        $sql  = ' SELECT count(*)';
        $sql .= " from `".DB::table($this->_table)."` ajr";
        $sql .= " left join pre_applet_job_send ajs on ajs.ajs_id = ajr.ajr_ajs_id ";

        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取是否推荐
     */
    public function hadRecommend($pid, $mid, $fid){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_f1_mid', 'oper' => '=', 'value' => $fid);
        $where[] = array('name' => 'ajr_mid', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajr_ajp_id', 'oper' => '=', 'value' => $pid);

        return $this->getRow($where);
    }

    /**
     * 获取推荐列表
     */
    public function getParentRelation($pid, $mid){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_mid', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajr_ajp_id', 'oper' => '=', 'value' => $pid);

        return $this->getList($where, 0, 0, array('ajr_create_time' => 'desc'));
    }

    /**
     * 递归的去查询所有的上级
     */
    public function getJoinMember($pid, $mid, $recommend=array()){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_mid', 'oper' => '=', 'value' => $mid);
        $where[] = array('name' => 'ajr_ajp_id', 'oper' => '=', 'value' => $pid);
        $recommendList = $this->getList($where, 0, 0, array('ajr_create_time' => 'desc'));
        if($recommendList){
            $mid = $recommendList[0]['ajs_f1_mid'];
            $recommend[] = $mid;
            $this->getJoinMember($pid, $mid, $recommend);
        }else{
            return $recommend;
        }
    }

    /**
     * 获取推荐状态的数量
     */
    public function getRecommendStatusCount($status, $mid, $esId = 0){
        $where[] = array('name' => 'ajr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'ajr_f1_mid', 'oper' => '=', 'value' => $mid);
        if($esId){
            $where[] = array('name' => 'ajp_es_id', 'oper' => '=', 'value' => $esId);
        }
        switch ($status){
            case 'show':
                break;
            case 'interview':
                $where[] = array('name' => 'ajs_f1_mid', 'oper' => '!=', 'value' => 0);
                $where[] = array('name' => 'ajs_status', 'oper' => 'in', 'value' => [1, 3, 4, 5, 6, 7, 8, 9]);
                break;
            case 'entry':
                $where[] = array('name' => 'ajs_f1_mid', 'oper' => '!=', 'value' => 0);
                $where[] = array('name' => 'ajs_status', 'oper' => 'in', 'value' => [6, 7]);
                break;
        }

        $sql  = ' SELECT count(*)';
        $sql .= " from `".DB::table($this->_table)."` ajr";
        $sql .= " left join pre_applet_job_position ajp on ajp.ajp_id = ajr.ajr_ajp_id ";
        $sql .= " left join pre_applet_job_send ajs on ajs.ajs_id = ajr.ajr_ajs_id ";

        $sql .= $this->formatWhereSql($where);

        if($mid == 1741053){
            Libs_Log_Logger::outputLog($sql);
        }

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}