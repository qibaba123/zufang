<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/17
 * Time: 下午9:34
 */

class App_Model_Shop_MysqlShopMessageStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'shop_message';
        $this->_pk      = 'sm_id';

        $this->sid      = $sid;
    }

    public function getNoReadMessageCount($where = []){

        $where[] = array('name' => 'sm_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'sm_read', 'oper' => '=', 'value' => 0);

        return $this->getCount($where);
    }

    public function getNoReadMessageCountSeqregion($where){
        $where[] = ['name' => 'sm_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'sm_read', 'oper' => '=', 'value' => 0];
        $sql  = 'SELECT count(*) total ';
        $sql .= ' FROM '.DB::table($this->_table).' sm ';
        $sql .= " left join pre_trade t on sm.sm_tid = t.t_tid ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= " left join pre_applet_sequence_area as asa on asct.asc_area = asa.asa_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getListSeqregion($where,$index,$count,$sort){
        $sql  = 'SELECT sm.* ';
        $sql .= ' FROM '.DB::table($this->_table).' sm ';
        $sql .= " left join pre_trade t on sm.sm_tid = t.t_tid ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= " left join pre_applet_sequence_area as asa on asct.asc_area = asa.asa_id ";
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

    public function getCountSeqregion($where){
        $sql  = 'SELECT count(*) as total ';
        $sql .= ' FROM '.DB::table($this->_table).' sm ';
        $sql .= " left join pre_trade t on sm.sm_tid = t.t_tid ";
        $sql .= " left join pre_applet_sequence_community asct on asct.asc_id = t.t_home_id ";
        $sql .= " left join pre_applet_sequence_area as asa on asct.asc_area = asa.asa_id ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}