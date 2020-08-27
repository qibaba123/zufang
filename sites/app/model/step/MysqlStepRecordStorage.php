<?php

class App_Model_Step_MysqlStepRecordStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_step_record';
        $this->_pk     = 'asr_id';
        $this->_shopId = 'asr_s_id';
        $this->sid     = $sid;
    }

    /*
     * 通过订单id获取订单
     */
    public function findUpdateByMid($mid, $data = null) {
        $where[]    = array('name' => 'asr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'asr_update_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d')));
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获得指定用户排名
     */
    public function getRank($mid){
        $where[]    = array('name' => 'asr_m_id', 'oper' => '=', 'value' => $mid);
        $timeToday = strtotime(date('Y-m-d'));
//        $where[]    = array('name' => 'asr_update_time', 'oper' => '>', 'value' => strtotime(date('Y-m-d')));
//        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = 'SELECT * FROM (SELECT asr_m_id,asr_s_id,asr_update_time,(@rowNum:=@rowNum+1) AS rowNo ';
        $sql .= " FROM `pre_applet_step_record` ,(SELECT(@rowNum:=0)) b where asr_s_id = {$this->sid} and asr_update_time > {$timeToday} ORDER BY asr_step DESC,asr_update_time DESC) c ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;


    }



}