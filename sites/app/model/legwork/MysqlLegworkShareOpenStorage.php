<?php

class App_Model_Legwork_MysqlLegworkShareOpenStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    private $member_table;
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table  = 'applet_legwork_share_open';
        $this->_pk     = 'also_id';
        $this->_shopId = 'also_s_id';
        $this->sid     = $sid;
        $this->member_table = DB::table('member');
    }

    /*
      * 通过店铺id
      */
    public function findUpdateByMid($mid,$data=null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'also_m_id', 'oper' => '=', 'value' => $mid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获得收益列表 关联会员表
     */
    public function getListMemberAction($where,$index,$count,$sort){
        $sql = "select also.*,m.m_nickname,m.m_avatar ";
        $sql .= " from `".DB::table($this->_table)."` also ";
        $sql .= " left join ".$this->member_table." m on m.m_id = also.also_m_id ";
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



}