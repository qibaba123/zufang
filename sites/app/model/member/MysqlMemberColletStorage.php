<?php


class App_Model_Member_MysqlMemberColletStorage extends Libs_Mvc_Model_BaseModel {


    public function __construct() {
        parent::__construct();
        $this->_table   = 'member_collet';
        $this->_pk      = 'mc_id';
        $this->_shopId  = 'mc_s_id';
        $this->_df      = 'mc_deleted';
    }

   public function getAreaRow($where){
        $sql  = ' SELECT p.region_name as p_name,c.region_name as c_name,a.region_name as a_name';
        $sql .= " from `".DB::table($this->_table)."` ame ";
        $sql .= " left join `pre_china_address` p on p.region_id = ame.ame_pro ";
        $sql .= " left join `pre_china_address` c on c.region_id = ame.ame_city ";
        $sql .= " left join `pre_china_address` a on a.region_id = ame.ame_area ";
        $sql .= $this->formatWhereSql($where);
     Libs_Log_Logger::outputLog($sql,'wxpay.log');
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}