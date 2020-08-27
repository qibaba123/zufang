<?php

class App_Model_Member_MysqlKefuUseStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $member_table;
    public function __construct($sid = 0) {
        parent::__construct();
        $this->_table   = 'kefu_use_record';
        $this->_pk      = 'kur_id';
        $this->_shopId  = 'kur_s_id';
        $this->sid      = $sid;
        $this->member_table = DB::table('member');
    }


    /*
     * 通过会员id获取或更新使用记录
     */
    public function findUpdateByMid($mid, $data = null) {
        $where[]    = array('name' => 'kur_m_id', 'oper' => '=', 'value' => $mid);

        if (!$data) {
            return $this->getRow($where);
        } else {
            return $this->updateValue($data, $where);
        }
    }

    /*
     * 获得客服使用记录 关联用户表
     */
    public function getRecordList($where,$index,$count,$sort){
        $sql = "select kur.*,m.m_nickname,m.m_avatar,m.m_openid ";
        $sql .= " from `".DB::table($this->_table)."` kur ";
        $sql .= " left join ".$this->member_table." m on m.m_id = kur.kur_m_id ";
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

    /*
     * 获得客服使用记录数量 关联用户表
     */
    public function getRecordCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` kur ";
        $sql .= " left join ".$this->member_table." m on m.m_id = kur.kur_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /*
     * 获得客服使用单条记录数量 关联用户表
     */
    public function getRecordRow($where){
        $sql = "select kur.*,m.m_nickname,m.m_avatar,m.m_openid ";
        $sql .= " from `".DB::table($this->_table)."` kur ";
        $sql .= " left join ".$this->member_table." m on m.m_id = kur.kur_m_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }




}