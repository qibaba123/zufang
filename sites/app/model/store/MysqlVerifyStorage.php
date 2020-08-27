<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/8/23
 * Time: 下午6:40
 */
class App_Model_Store_MysqlVerifyStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $table_member;
    private $table_store;
    private $table_city_store;
    private $verify_table;
    private $offline_member;
    private $train_course_exchange;
    private $train_course;
    private $trade_table;

    public function __construct($sid){
        $this->_table 	= 'offline_verify';
        $this->_pk 		= 'ov_id';
        $this->_shopId 	= 'ov_s_id';
        parent::__construct();
        $this->sid  = $sid;
        $this->table_member = DB::table('member');
        $this->table_store = DB::table('offline_store');
        $this->table_city_store = DB::table('applet_city_shop');
        $this->offline_member = DB::table('offline_member');
        $this->verify_table = DB::table($this->_table);
        $this->train_course_exchange = DB::table('applet_train_course_exchange');
        $this->train_course = DB::table('applet_train_course');
        $this->trade_table  = DB::table('trade');
    }

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param array $sort
     * @return array|bool
     * 门店核销记录
     */
    public function getStoreMemberList($where,$index,$count,$sort=array('ov_record_time' => 'DESC')){
        $sql = 'SELECT * '.' FROM `'.DB::table($this->_table).'` ov ';
        $sql .= ' LEFT JOIN '.$this->table_member.' m ON m.m_id=ov.ov_m_id ';
        $sql .= ' LEFT JOIN '.$this->table_store.' os ON os.os_id=ov.ov_st_id ';
        $sql .= ' LEFT JOIN '.$this->table_city_store.' acs ON acs.acs_id=ov.ov_st_id ';
        $sql .= ' LEFT JOIN '.$this->offline_member.' om ON om.om_m_id=m.m_id and om.om_type = 1 ';
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

    public function getStoreMemberCount($where){
        $sql = 'SELECT count(*) '.' FROM `'.DB::table($this->_table).'` ov ';
        $sql .= ' LEFT JOIN '.$this->table_member.' m ON m.m_id=ov.ov_m_id ';
        $sql .= ' LEFT JOIN '.$this->table_store.' os ON os.os_id=ov.ov_st_id ';
        $sql .= ' LEFT JOIN '.$this->table_city_store.' acs ON acs.acs_id=ov.ov_st_id ';
        $sql .= ' LEFT JOIN '.$this->offline_member.' om ON om.om_m_id=m.m_id and om.om_type = 1 ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param array $sort
     * @return array|bool
     * 门店核销记录-收银台使用
     */
    public function getStoreMemberListCashier($where,$index,$count,$sort=array('ov_record_time' => 'DESC')){
        $sql = 'SELECT * '.' FROM `'.DB::table($this->_table).'` ov ';
        $sql .= ' LEFT JOIN '.$this->table_member.' m ON m.m_id=ov.ov_m_id ';
        $sql .= ' LEFT JOIN '.$this->table_store.' os ON os.os_id=ov.ov_st_id ';
        $sql .= ' LEFT JOIN '.$this->table_city_store.' acs ON acs.acs_id=ov.ov_st_id ';
        $sql .= ' LEFT JOIN '.$this->offline_member.' om ON om.om_m_id=m.m_id ';
        $sql .= ' LEFT JOIN '.$this->trade_table.' as t On t.t_id = ov.ov_se_tid ';
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

    public function getStoreMemberCountCashier($where){
        $sql = 'SELECT count(*) '.' FROM `'.DB::table($this->_table).'` ov ';
        $sql .= ' LEFT JOIN '.$this->table_member.' m ON m.m_id=ov.ov_m_id ';
        $sql .= ' LEFT JOIN '.$this->table_store.' os ON os.os_id=ov.ov_st_id ';
        $sql .= ' LEFT JOIN '.$this->table_city_store.' acs ON acs.acs_id=ov.ov_st_id ';
        $sql .= ' LEFT JOIN '.$this->trade_table.' as t On t.t_id = ov.ov_se_tid ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $mid
     * @param $days
     * @param int $st_id
     * @return bool
     * 统计某人在特定的时间内，在某店铺消费次数
     */
    public function getCountByMidDays($mid,$days,$st_id=0){
        if($days < 1){
            $days = 1;
        }
        $time    = time() - ($days-1) * 86400;
        $start   = strtotime(date('Y-m-d',$time)); //开始时间

        $where   = array();
        $where[] = array('name' => 'ov_s_id','oper' => '=','value' =>$this->sid);
        $where[] = array('name' => 'ov_m_id','oper' => '=','value' =>$mid);
        $where[] = array('name' => 'ov_record_time','oper' => '>=','value' =>$start);
        $where[] = array('name' => 'ov_record_time','oper' => '<=','value' =>time());
        if($st_id){
            $where[] = array('name' => 'ov_st_id','oper' => '=','value' =>$st_id);
        }
        return $this->getCount($where);
    }
    /*
     * 获取会员核销总记录数
     */
    public function getCountByMid($mid,$type = '') {
        $where[] = array('name' => 'ov_s_id','oper' => '=','value' =>$this->sid);
        $where[] = array('name' => 'ov_m_id','oper' => '=','value' =>$mid);
        if($type == 'card'){
            $where[] = array('name' => 'ov_type','oper' => '=','value' =>1); //类型会员卡
        }
        return $this->getCount($where);
    }
    /*
     * 获取会员的消费记录
     */
    public function getVerifyListByMid($mid, $index = 0, $count = 20) {
        $where[] = array('name' => 'ov.ov_s_id','oper' => '=','value' =>$this->sid);
        $where[] = array('name' => 'ov.ov_m_id','oper' => '=','value' =>$mid);
        $where[] = array('name' => 'ov.ov_type','oper' => '=','value' =>1); //类型会员卡
        $sort   = array('ov.ov_record_time' => 'DESC');
        $where_sql  = $this->formatWhereSql($where);
        $sort_sql   = $this->getSqlSort($sort);
        $limit_sql  = $this->formatLimitSql($index, $count);

        $sql    = "SELECT ov.*,os.*,acs.acs_name,acs.acs_address FROM `{$this->verify_table}` AS ov LEFT JOIN `{$this->table_store}` AS os ON ov.ov_st_id=os.os_id LEFT JOIN `{$this->table_city_store}` AS acs ON ov.ov_st_id=acs.acs_id ";
        $sql    = $sql.$where_sql.$sort_sql.$limit_sql;

        return DB::fetch_all($sql);
    }

    public function getVerifyCourseListByMid($mid, $index = 0, $count = 20) {
        $where[] = array('name' => 'ov.ov_s_id','oper' => '=','value' =>$this->sid);
        $where[] = array('name' => 'ov.ov_m_id','oper' => '=','value' =>$mid);
        $where[] = array('name' => 'ov.ov_type','oper' => '=','value' =>1); //类型会员卡
        $sort   = array('ov.ov_record_time' => 'DESC');
        $where_sql  = $this->formatWhereSql($where);
        $sort_sql   = $this->getSqlSort($sort);
        $limit_sql  = $this->formatLimitSql($index, $count);

        $sql    = "SELECT ov.*,os.*,acs.acs_name,acs.acs_address,atc.atc_title FROM `{$this->verify_table}` AS ov LEFT JOIN `{$this->table_store}` AS os ON ov.ov_st_id=os.os_id LEFT JOIN `{$this->table_city_store}` AS acs ON ov.ov_st_id=acs.acs_id LEFT JOIN `{$this->train_course_exchange}` AS atce ON ov.ov_id=atce.atce_verify_id LEFT JOIN `{$this->train_course}` AS atc ON atce.atce_course=atc.atc_id";
        $sql    = $sql.$where_sql.$sort_sql.$limit_sql;

        return DB::fetch_all($sql);
    }

    /**
     * @param $mid
     * @param $os_id
     * @param $mlId
     * @param string $value
     * @param int $manager_id
     * @param string $manager_role
     * @return array
     * 根据会员ID，会员等级，核验
     * 核销分两种情况，1，按卡核销，只需要判断核销次数；2、自定义核销，需要判断指定时间内核销次数
     * $mchCode : 核销的机器编码
     */
    public function verifyByMid($mid,$os_id,$mlId,$value='',$manager_id = 0,$manager_role = '',$esId = 0,$osId = 0){
        $result = array(
            'ec' => 400,
            'em' => '对不起，不满足核销条件'
        );
        //@todo 查询核销限制
        $cfg_model= new App_Model_Store_MysqlStoreCfgStorage($this->sid);
        $cfg      = $cfg_model->fetchUpdateCfg();
        $canVerify= 1; //标注是否可以核销
        if($cfg['oc_verify_type'] == 2 && $cfg['oc_use_num'] > 0){ //自定义核销，检查固定时间内核销次数
            $days     = $cfg['oc_use_day'];
            $times    = $cfg['oc_use_num'];
            //@todo 限定时间内查询核销记录
            $fee_times    = $this->getCountByMidDays($mid,$days);
            if($fee_times >= $times){
                $result['em'] = '该会员在'.$days.'天内，免费消费'.$times.'次，已经用完。';
                $canVerify= 0;
            }
        }
        //@todo 减少核销次数，保存核销记录
        if($canVerify){
            $member_card_model = new App_Model_Store_MysqlMemberStorage($this->sid);
            $ret = $member_card_model->verifyByMid($mid);
            if($ret){

                $role_type = [
                    'admin' => 1,
                    'entershop' => 2,
                    'store' => 3,
                ];

                $role_status = $role_type[$manager_role] ? $role_type[$manager_role] : 0;

                $data = array(
                    'ov_s_id'        => $this->sid,
                    'ov_m_id'        => $mid,
                    'ov_st_id'       => $os_id,
                    'ov_value'       => $value,
                    'ov_record_time' => time(),
                    'ov_manager_id' => $manager_id,
                    'ov_manager_role' => $role_status,
                    'ov_es_id'       => $esId,
                    'ov_os_id'       => $osId,
                );
                $this->insertValue($data);
                $result = array(
                    'ec' => 200,
                    'em' => '核销成功'
                );
            }else{
                $result['em'] = '核销失败';
            }
        }
        return $result;
    }

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param $sort
     * @param bool $region_id
     * @return array|bool
     * 处理收银台的核销功能
     */
    public function verifyByMidCashier($mid,$os_id,$mlId,$value='',$manager_id = 0,$manager_role = '',$esId = 0,$osId = 0,$mchCode=''){
        $result = array(
            'ec' => 400,
            'em' => '对不起，不满足核销条件'
        );
        //@todo 查询核销限制
        $cfg_model= new App_Model_Store_MysqlStoreCfgStorage($this->sid);
        $cfg      = $cfg_model->fetchUpdateCfg();
        $canVerify= 1; //标注是否可以核销
        if($cfg['oc_verify_type'] == 2 && $cfg['oc_use_num'] > 0){ //自定义核销，检查固定时间内核销次数
            $days     = $cfg['oc_use_day'];
            $times    = $cfg['oc_use_num'];
            //@todo 限定时间内查询核销记录
            $fee_times    = $this->getCountByMidDays($mid,$days);
            if($fee_times >= $times){
                $result['em'] = '该会员在'.$days.'天内，免费消费'.$times.'次，已经用完。';
                $canVerify= 0;
            }
        }
        //@todo 减少核销次数，保存核销记录
        if($canVerify){
            $member_card_model = new App_Model_Store_MysqlMemberStorage($this->sid);
            $ret = $member_card_model->verifyByMid($mid);
            if($ret){

                $role_type = [
                    'admin' => 1,
                    'entershop' => 2,
                    'store' => 3,
                ];

                $role_status = $role_type[$manager_role] ? $role_type[$manager_role] : 0;

                $data = array(
                    'ov_s_id'        => $this->sid,
                    'ov_m_id'        => $mid,
                    'ov_st_id'       => $os_id,
                    'ov_value'       => $value,
                    'ov_record_time' => time(),
                    'ov_manager_id'  => $manager_id,
                    'ov_manager_role' => $role_status,
                    'ov_es_id'       => $esId,
                    'ov_os_id'       => $osId,
                    'ov_mch_code'    => $mchCode
                );
                $this->insertValue($data);
                $result = array(
                    'ec' => 200,
                    'em' => '核销成功'
                );
            }else{
                $result['em'] = '核销失败';
            }
        }
        return $result;
    }




    /*
     * 社区团购 核销记录
     * @params $region_id  社区团购的话传入对应的区域管理员的所管辖的城市的id
     */
    public function sequenceVerifyList($where,$index,$count,$sort,$region_id=false){
        $sql = 'SELECT ov.*,t.t_id,t.t_tid,t.t_se_group,t.t_se_leader,m.m_id,m.m_nickname,m.m_show_id,asl.asl_id,asl.asl_name,asl.asl_mobile '.' FROM `'.DB::table($this->_table).'` ov ';
        $sql .= ' LEFT JOIN pre_trade t ON t.t_tid=ov.ov_se_tid ';
        $sql .= ' LEFT JOIN pre_member m ON m.m_id=ov.ov_se_mid ';
        $sql .= ' LEFT JOIN pre_applet_sequence_leader asl ON asl.asl_m_id=ov.ov_se_mid ';
        //$sql .= ' LEFT JOIN pre_member m ON m.m_id=ov.ov_se_mid ';
            
        if($region_id){
            $sql.=' LEFT JOIN `pre_applet_sequence_community`  ON asc_leader=t.t_se_leader ';
            $sql.=' LEFT JOIN `pre_applet_sequence_area`  on asc_area=asa_id ';
        }




        $sql .= $this->formatWhereSql($where);
        if($region_id)
            $sql.=' GROUP BY t.t_tid';

        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 社区团购 核销记录
     * @params $region_id  社区团购的话传入对应的区域管理员的所管辖的城市的id
     */
    public function sequenceVerifyCount($where,$region_id=false){
        if($region_id)
            $sql = 'SELECT count(DISTINCT(`t_tid`)) as total '.' FROM `'.DB::table($this->_table).'` ov ';
        else
            $sql = 'SELECT count(*) as total '.' FROM `'.DB::table($this->_table).'` ov ';
        $sql .= ' LEFT JOIN pre_trade t ON t.t_tid=ov.ov_se_tid ';
        $sql .= ' LEFT JOIN pre_member m ON m.m_id=ov.ov_se_mid ';
        $sql .= ' LEFT JOIN pre_applet_sequence_leader asl ON asl.asl_m_id=ov.ov_se_mid ';
        //$sql .= ' LEFT JOIN pre_member m ON m.m_id=ov.ov_se_mid ';
        

        if($region_id){
            $sql.=' LEFT JOIN `pre_applet_sequence_community`  ON asc_leader=t.t_se_leader ';
            $sql.=' LEFT JOIN `pre_applet_sequence_area`  on asc_area=asa_id ';
        }


        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListApplet($where,$index,$count,$sort){
        $sql = 'SELECT ov.*,ac.ac_type '.' FROM `'.DB::table($this->_table).'` ov ';
        $sql .= ' LEFT JOIN pre_applet_cfg ac ON ac.ac_type=ov.ov_s_id ';
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
    //获取指定类型的数量
    public function getCountByType($where,$type=1){
        $where[] = array('name'=>'ov_type','oper'=>'=','value'=>$type);
        return $this->getCount($where);
    }



}