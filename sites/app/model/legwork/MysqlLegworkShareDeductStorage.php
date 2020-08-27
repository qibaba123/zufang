<?php

class App_Model_Legwork_MysqlLegworkShareDeductStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_legwork_share_deduct';
        $this->_pk     = 'alsd_id';
        $this->_shopId = 'alsd_s_id';
        $this->sid     = $sid;
        $this->member_table = DB::table('member');
    }

    /*
     * 获得收益列表 关联会员表
     */
    public function getListMemberAction($where,$index,$count,$sort){
        $sql = "select alsd.*,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` alsd ";
        $sql .= " left join ".$this->member_table." m on m.m_id = alsd.alsd_open_mid ";
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

    public function getSum($mid){
        $where = array();
        $where[] = array('name'=>'alsd_m_id','oper'=>'=','value'=>$mid);
        $where[] = array('name'=>$this->_shopId,'oper'=>'=','value'=>$this->sid);
        $sql = 'SELECT sum(alsd_money) as total ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ';

        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }





}