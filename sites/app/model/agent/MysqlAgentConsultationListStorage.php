<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/6/9
 * Time: 下午5:13
 */
class App_Model_Agent_MysqlAgentConsultationListStorage extends Libs_Mvc_Model_BaseModel {

    private $curr_table;
    private $admin_table;
    private $company_table;
    private $shop_table;
    private $applet_cfg;
    public function __construct() {
        parent::__construct();
        $this->_table   = 'agent_consultation_list';
        $this->_pk      = 'acl_id';
        $this->curr_table   = DB::table($this->_table);
        $this->admin_table  = DB::table('agent_admin');
        $this->company_table = DB::table('company');
        $this->shop_table    = DB::table('shop');
        $this->applet_cfg    = DB::table('applet_cfg');
    }


    public function getConsultationListAction($where,$index,$count,$sort){
        $sql = 'select acl.*, s.s_name, c.c_name, ac.* ';
        $sql .= ' from `'.DB::table($this->_table).'` acl ';
        $sql .= ' left join '.$this->shop_table.' s on acl.acl_s_id = s.s_id ';
        $sql .= ' left join '.$this->company_table.' c on s.s_c_id = c.c_id ';
        $sql .= ' left join '.$this->applet_cfg.' ac on ac.ac_s_id = acl.acl_s_id';
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