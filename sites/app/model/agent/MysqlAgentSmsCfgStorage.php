<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/5/9
 * Time: 上午10:39
 */
class App_Model_Agent_MysqlAgentSmsCfgStorage extends Libs_Mvc_Model_BaseModel
{
    private $core_table;
    private $uid;
    public function __construct($uid)
    {
        parent::__construct();
        $this->_table = 'agent_sms_cfg';
        $this->_pk = 'asc_id';
        $this->core_table    = DB::table('agent_admin');

        $this->uid = $uid;
    }
    /**
     * 根据代理商id获取信息
     */
    public function findRowByUid($data=null) {
        $where      = array();
        $where[]    = array('name' => 'asc_aa_id', 'oper' => '=', 'value' => $this->uid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function addSmsNum($num){
        $where      = array();
        $where[]    = array('name' => 'asc_aa_id', 'oper' => '=', 'value' => $this->uid);

        $sql  = 'UPDATE '.DB::table($this->_table);
        $sql .= ' SET asc_useable = asc_useable + '.intval($num);
        $sql .= $this->formatWhereSql($where);

        $ret = DB::query($sql);

        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 设置可用短信,已发送短信
     */
    public function incrementSmsTotal($use = -1, $send = 1) {
        $field  = array('asc_useable', 'asc_had_send');
        $inc    = array($use, $send);

        $where[]    = array('name' => 'asc_aa_id', 'oper' => '=', 'value' => $this->uid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }



}