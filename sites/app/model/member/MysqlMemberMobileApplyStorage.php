<?php
/**
 * Created by PhpStorm.
 * User: zhaowie
 * Date: 16/5/30
 * Time: 下午4:28
 */
class App_Model_Member_MysqlMemberMobileApplyStorage extends Libs_Mvc_Model_BaseModel {
    private $member_table;
    private $sid;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'member_mobile_apply';
        $this->_pk      = 'mma_id';
        $this->_shopId  = 'mma_s_id';
        $this->_df      = 'mma_deleted';
        $this->sid      = $sid;
        $this->member_table = DB::table('member');
    }

    /**
     * 按特定手机号字段检索
     * @param mixed $mobile
     * @return array|bool
     */
    public function findRowByMobile($mobile, $sid=0) {
        if($sid){
            $where[]    = array('name' => 'mma_s_id', 'oper' => '=', 'value' => $sid);
        }
        $where[]    = array('name' => 'mma_mobile', 'oper' => '=', 'value' => $mobile);

        $ret = $this->getRow($where);

        return $ret;
    }

    public function findUpdateByMid($mid, $sid=0, $data = array()) {
        if($sid){
            $where[]    = array('name' => 'mma_s_id', 'oper' => '=', 'value' => $sid);
        }
        $where[]    = array('name' => 'mma_m_id', 'oper' => '=', 'value' => $mid);
        if($data){
            $ret = $this->updateValue($data,$where);
        }else{
            $ret = $this->getRow($where);
        }


        return $ret;
    }

    /*
     * 获得申请记录表 关联会员表
     */
    public function getListMember($where,$index = 0,$count = 15,$sort = array()){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "SELECT mma.*,m.m_nickname,m.m_avatar,m.m_show_id ";
        $sql .= " FROM ".DB::table($this->_table)." mma ";
        $sql .= " LEFT JOIN ".$this->member_table." m on mma.mma_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if($ret === false){
            //trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListMemberCount($where){
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sql = "SELECT count(*) as total ";
        $sql .= " FROM ".DB::table($this->_table)." mma ";
        $sql .= " LEFT JOIN ".$this->member_table." m on mma.mma_m_id = m.m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if($ret === false){
            //trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}