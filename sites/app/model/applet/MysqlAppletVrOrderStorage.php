<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午4:59
 * 模版设置
 */
class App_Model_Applet_MysqlAppletVrOrderStorage extends Libs_Mvc_Model_BaseModel{
    private $sid;
    private $shopTable;
    public function __construct($sid=null){
        $this->_table 	 = 'applet_vr_order';
        $this->_pk 		 = 'avo_id';
        $this->_shopId   = 'avo_s_id';
        $this->shopTable = DB::table('shop');
        $this->sid       = $sid;
        parent::__construct();
    }
    public function getVrOrderList($where,$index=0,$count=20,$sort){
        $sql  = 'SELECT avo.* , s_name ';
        $sql .= ' FROM `'.DB::table($this->_table).'` avo ';
        $sql .= ' LEFT JOIN '.$this->shopTable.' s on s_id = avo_s_id ';
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret  = DB::fetch_all($sql, array());
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
    * 通过订单id获取订单
    */
    public function findUpdateVrOrderByTid($tid, $data = null) {
        $where[]    = array('name' => 'avo_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'avo_s_id', 'oper' => '=', 'value' => $this->sid);
        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

}