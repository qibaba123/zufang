<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/6/9
 * Time: 下午5:13
 */
class App_Model_Agent_MysqlAgentOemStorage extends Libs_Mvc_Model_BaseModel {

    private $curr_table;
    private $admin_table;

    public function __construct() {
        parent::__construct();
        $this->_table   = 'agent_oem';
        $this->_pk      = 'ao_id';
        $this->curr_table   = DB::table($this->_table);
        $this->admin_table  = DB::table('agent_admin');
    }
    /*
     * 通过域名查找OEM信息
     */
    public function findOemByDomain($domain) {
        $sql  = "SELECT * FROM `{$this->curr_table}` ";
        $sql .= " JOIN `{$this->admin_table}` ON ao_aa_id=aa_id WHERE ao_domain=".DB::quote($domain)." AND aa_open_oem=1 ";

        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * 通过代理商id获取代理商是否开通OEM
     * @param $aaid
     * @return array|bool
     */

    public function findOemByAaid($aaid,$data = null) {
        $where[]    = array('name' => 'ao_aa_id', 'oper' => '=', 'value' => $aaid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}