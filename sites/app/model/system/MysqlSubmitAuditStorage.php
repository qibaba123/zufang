<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 17/3/11
 * Time: 上午10:47
 */
class App_Model_System_MysqlSubmitAuditStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
    private $shop_table;
    private $applet_table;
    public function __construct($sid=null){
        $this->_table 	= 'applet_submit_audit';
        $this->_pk 		= 'asa_id';
        $this->sid      = $sid;
        $this->shop_table        = DB::table('shop');
        $this->applet_table      = DB::table('applet_cfg');
        parent::__construct();
    }

    /*
     * 获取正在审核中记录
     */
    public function getAuditStatus(){
        $where = array();
        $where[]    = array('name' => 'asa_audit_status', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'asa_s_id', 'oper' => '=', 'value' => $this->sid);
        return $this->getRow($where);
    }


    /**
     * 获取小程序提交审核的信息
     */
    public function getAuditAppletList($where,$index,$count,$sort){
        $sql = 'select asa.*,s.s_name,ac.ac_name,m.m_mobile,m.m_password ';
        $sql .= ' from `'.DB::table($this->_table).'` asa ';
        $sql .= ' left join '.$this->shop_table.' s on asa.asa_s_id = s.s_id ';
        $sql .= ' left join '.$this->applet_table.' ac on asa.asa_ac_id = ac.ac_id ';
        $sql .= ' left join pre_manager m on s.s_c_id = m.m_c_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= ' GROUP BY m.`m_c_id` ';
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 获取小程序提交审核的信息
     */
    public function getAuditAppletCount($where){
        $sql = 'select count(*)';
        $sql .= ' from `'.DB::table($this->_table).'` asa ';
        $sql .= ' left join '.$this->shop_table.' s on asa.asa_s_id = s.s_id ';
        $sql .= ' left join '.$this->applet_table.' ac on asa.asa_ac_id = ac.ac_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

}