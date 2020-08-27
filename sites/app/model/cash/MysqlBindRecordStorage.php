<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/20
 * Time: 下午8:48
 * 绑定记录表
 */
class App_Model_Cash_MysqlBindRecordStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid='') {
        parent::__construct();
        $this->_table   = 'cash_bind_record';
        $this->_pk      = 'cbr_id';
        $this->_shopId  = 'cbr_s_id';
        $this->_df      = 'cbr_deleted';

        $this->sid      = $sid;
    }

    /**
     * 根据code判断是不是已经被门店绑定过
     */
    public function checkBindCode($code,$level=1,$osId='',$keeperId=''){
        $where   = array();
        $where[] = array('name'=>'cbr_bind_code','oper'=>'=','value'=>$code);
        $where[] = array('name'=>'cbr_bind_level','oper'=>'=','value'=>$level);
        if($osId){
            $where[] = array('name'=>'cbr_os_id','oper'=>'=','value'=>$osId);
        }
        if($keeperId){
            $where[] = array('name'=>'cbr_uid','oper'=>'=','value'=>$keeperId);
        }
        return $this->getRow($where);
    }

    /**
     * 根据条件删除已经绑定的信息
     * osid : 线下门店
     * mid  : 管理员
     */
    public function delDataBy($sid,$osid,$mid){
        $where   = array();
        $where[] = array('name'=>'cbr_s_id','oper'=>'=','value'=>$sid);
        if($osid){
            $where[] = array('name'=>'cbr_os_id','oper'=>'=','value'=>$osid);
        }
        if($mid){
            $where[] = array('name'=>'cbr_uid','oper'=>"=",'value'=>$mid);
        }
        if($osid || $mid){
            $set = array('cbr_deleted'=>1);
            return $this->updateValue($set,$where);
        }
        return false;
    }


    /**
     *  获取 设备信息
     */
    public function getMachineList($where=array(), $index=0, $count=20, $sort=array()) {
        $where[] = array('name'=>'cbr_deleted', 'oper'=>'=', 'value'=>0);

        $sql = '';
        $sql .= 'Select cbr.*, s.s_id,s.s_name, aa.aa_id,aa.aa_name ,os.os_id,os.os_name ';
        $sql .= ' From `'.DB::table($this->_table).'` cbr ';
        $sql .= ' Left Join `pre_shop` s ON cbr.cbr_s_id=s.s_id '; // 店铺
        $sql .= ' Left Join `pre_offline_store` os ON cbr.cbr_os_id=os.os_id'; // 门店
        $sql .= ' Left Join `pre_agent_open` ao ON ao.ao_s_id=cbr.cbr_s_id';
        $sql .= ' Left Join `pre_agent_admin` aa ON ao.ao_a_id=aa.aa_id'; // 代理商

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
     *  获取 设备数量
     */
    public function getMachineCount($where=array()) {
        $where[] = array('name'=>'cbr_deleted', 'oper'=>'=', 'value'=>0);

        $sql = '';
        $sql .= 'Select count(*) ';
        $sql .= ' From `'.DB::table($this->_table).'` cbr ';
        $sql .= ' Left Join `pre_shop` s ON cbr.cbr_s_id=s.s_id '; // 店铺
        $sql .= ' Left Join `pre_offline_store` os ON cbr.cbr_os_id=os.os_id'; // 门店
        $sql .= ' Left Join `pre_agent_open` ao ON ao.ao_s_id=cbr.cbr_s_id';
        $sql .= ' Left Join `pre_agent_admin` aa ON ao.ao_a_id=aa.aa_id'; // 代理商
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     *  修改机器单数
     */
    public function incrementMachineAlone($where, $num=0, $mark='+', $test=0) {
        $where[] = array('name'=>'cbr_deleted', 'oper'=>'=', 'value'=>0);

        $sql  = '';
        $sql .= ' Update `'.DB::table($this->_table).'`';
        $sql .= ' Set cbr_alone_num = ';
        $sql .= ' cbr_alone_num'.$mark.$num;

        $sql .= $this->formatWhereSql($where);
        if($test) {
            return $sql;
        }

        $ret = DB::query($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}