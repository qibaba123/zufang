<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 2017/6/17
 * Time: 上午10:39
 */
class App_Model_House_MysqlHouseApplyStorage extends Libs_Mvc_Model_BaseModel
{

    private $shop_table;

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'applet_house_apply';
        $this->_pk = 'aha_id';
        $this->_shopId = 'aha_s_id';

        $this->shop_table = DB::table('shop');
    }


    public function getApplyById($id){
        $where[] = array('name' => 'aha_id', 'oper' => '=', 'value' => $id);
        $where[] = array('name' => 'aha_deleted', 'oper' => '=', 'value' => 0);
        $sql = 'SELECT *';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' LEFT JOIN pre_member m on aha_m_id = m_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getApplyList($where, $index, $count, $sort){
        $sql = 'SELECT *';
        $sql .= ' FROM '.DB::table($this->_table);
        $sql .= ' LEFT JOIN pre_member m on aha_m_id = m_id ';
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