<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/9/20
 * Time: 下午8:48
 * 绑定记录表
 */
class App_Model_Cash_MysqlRefundRecordStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $member_table;
    private $store_table;
    public function __construct($sid='') {
        parent::__construct();
        $this->_table   = 'cash_refund_record';
        $this->_pk      = 'crr_id';
        $this->_shopId  = 'crr_s_id';

        $this->member_table = DB::table('member');
        $this->store_table  = DB::table('offline_store');

        $this->sid      = $sid;
    }
    //获取退款统计数据
    public function findCashRecordMemberStorageSum($where){
        $sql = "select count(*) as total , sum(crr_refund_money) as money ";
        $sql .= " from `".DB::table($this->_table)."` crr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = crr.crr_m_id ";
        $sql .= " left join ".$this->store_table." as os on os.os_id = crr.crr_os_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



    public function findCashRecordMemberStorage($where,$index,$count,$sort){
        $sql = "select * ";
        $sql .= " from `".DB::table($this->_table)."` crr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = crr.crr_m_id ";
        $sql .= " left join ".$this->store_table." as os on os.os_id = crr.crr_os_id ";
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
    public function findCashRecordMemberStorageCount($where){
        $sql = "select count(*) ";
        $sql .= " from `".DB::table($this->_table)."` crr ";
        $sql .= " left join ".$this->member_table." m on m.m_id = crr.crr_m_id ";
        $sql .= " left join ".$this->store_table." as os on os.os_id = crr.crr_os_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }





}