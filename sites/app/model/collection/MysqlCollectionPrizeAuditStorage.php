<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/11
 * Time: 下午10:33
 */
class App_Model_Collection_MysqlCollectionPrizeAuditStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_collection_prize_audit';
        $this->_pk      = 'acpa_id';
        $this->_shopId  = 'acpa_s_id';

        $this->sid      = $sid;
    }

    public function getMemberCount($where){
        $sql = "select count(*)";
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' acpa LEFT JOIN pre_member m on acpa.acpa_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getMemberList($where, $index, $count, $sort){
        $sql = 'SELECT acpa.*, m.m_avatar, m.m_nickname';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' acpa LEFT JOIN pre_member m on acpa.acpa_m_id = m.m_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}