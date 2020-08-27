<?php
/*
 * 爆品分销 团长关联合伙人表
 */
class App_Model_Sequence_MysqlSequenceLeaderManagerStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $leader_table;//团长表
    private $manager_table;//合伙人表
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_leader_manager';
        $this->_pk = 'aslm_id';
        $this->_shopId = 'aslm_s_id';
        $this->sid = $sid;
        $this->leader_table = DB::table('applet_sequence_leader');
        $this->manager_table = DB::table('applet_sequence_manager');
    }

    public function getLeaderManager($where,$index,$count,$sort){
        $sql = "SELECT * ";
        $sql .= " FROM ".DB::table($this->_table)." aslm ";
        $sql .= " LEFT JOIN ".$this->manager_table." esm on aslm.aslm_manager=esm.esm_id ";
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

    public function getRowByleaderManager($leader,$manager = 0){
        $where[] = array('name' =>$this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' =>'aslm_leader', 'oper' => '=', 'value' => $leader);
        if($manager){
            $where[] = array('name' =>'aslm_manager', 'oper' => '=', 'value' => $manager);
        }

        return $this->getRow($where);
    }


}