<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/7/29
 * Time: 下午2:59
 */
class App_Model_Meeting_MysqlMeetingStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_meeting';
        $this->_pk 		= 'am_id';
        $this->_shopId 	= 'am_s_id';
        $this->_df 	    = 'am_deleted';
        parent::__construct();
        $this->sid = $sid;
    }
    /**
     * 获取分类选择使用
     */
    public function getCategoryListForSelect(){
        $where = array();
        $where[] = array('name'=>'amc_deleted','oper'=>'=','value'=>0);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $list = $this->getList($where,0,0,array('amc_create_time'=>'DESC'));
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[$val['amc_id']] = $val['amc_name'];
            }
        }
        return $data;
    }

    /**
     * 批量插入分类使用
     * @param array $val_arr
     * @return bool
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= ' (`amc_id`, `amc_s_id`,`amc_name`, `amc_sort`,`amc_deleted`, `amc_create_time`) ';
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
    /**
     * 获取会议报名人数
     */
    public function getEnrolment($where) {
        $sql  = "select * ";
        $sql .= " from `pre_trade_order` tro ";
        $sql .= " left join `pre_trade`  tr on tro.to_t_id = tr.t_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }else{
            $num=count($ret);
            return $num;
        }
    }
    /**
     * 获取会议参会人
     */
    public function enrolmentUser($where,$index,$count) {
        $sql  = "select * ";
        $sql .= " from `pre_trade` tr ";
        $sql .= " left join `pre_member` m  on m.m_id = tr.t_m_id ";
        $sql .= " left join `pre_trade_order`  tro on tr.t_id = tro.to_t_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        else{
            return $ret;
        }
    }
    /**
     * 获取会议参会人
     */
    public function enrolmentUserNum($where) {
        $sql  = "select * ";
        $sql .= " from `pre_trade` tr ";
        $sql .= " left join `pre_member` m  on m.m_id = tr.t_m_id ";
        $sql .= " left join `pre_trade_order`  tro on tr.t_id = tro.to_t_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        else{
            $num=count($ret);
            return $num;
        }
    }

    /*
     * 增加会议浏览量
     */
    public function addMeetBrowsNum($amid, $num=1) {
        $field  = array('am_brows_num');
        $inc    = array($num);

        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $amid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }
}