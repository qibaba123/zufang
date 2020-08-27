<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Agent_MysqlAgentSupportStorage extends Libs_Mvc_Model_BaseModel
{
    private $core_table;
    private $open_table;
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'agent_support';
        $this->_pk = 'as_id';
        $this->core_table    = DB::table('agent_admin');
        $this->open_table    = DB::table('agent_open');
    }
    /**
     * 根据代理商id获取信息
     */
    public function findRowByUid($uid) {
        if (!$uid) {
            return false;
        }
        $where[] = array('name' => 'as_a_id', 'oper' => '=', 'value' => $uid);
        return $this->getRow($where);
    }

    public function getAgentSupportBySid($sid){
        $where[] = array('name'=>'ao_s_id','oper'=>'=','value'=>$sid);
        $sql = 'select asp.* ';
        $sql .= ' from `'.DB::table($this->_table).'` asp ';
        $sql .= ' left join '.$this->open_table.' ao on asp.as_a_id = ao.ao_a_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


}