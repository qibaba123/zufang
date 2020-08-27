<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/14
 * Time: 下午4:59
 * 模版设置
 */
class App_Model_Shop_MysqlShopSslStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $shopTable;
    private $agentTable;
    public function __construct(){
        $this->_table 	 = 'shop_ssl';
        $this->_pk 		 = 'ss_id';
        $this->_shopId   = 'ss_s_id';
        $this->shopTable = DB::table('shop');
        $this->agentTable = DB::table('agent_admin');
        parent::__construct();
        /*$this->sid  = $sid;*/
    }
    public function getSslList($where,$index=0,$count=20,$sort){
        $sql  = 'SELECT ss.* , s_name ';
        $sql .= ' FROM `'.DB::table($this->_table).'` ss ';
        $sql .= ' LEFT JOIN '.$this->shopTable.' s on s_id = ss_s_id ';
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
    public function findUpdateSslByTid($tid, $data = null) {
        $where[]    = array('name' => 'ss_tid', 'oper' => '=', 'value' => $tid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
    
}