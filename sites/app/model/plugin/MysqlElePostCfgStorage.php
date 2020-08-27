<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/12
 * Time: 下午7:09
 */
class App_Model_Plugin_MysqlElePostCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct() {
        parent::__construct();
        $this->_table   = 'ele_post_cfg';
        $this->_pk      = 'epc_id';
        $this->_shopId  = 'epc_s_id';

    }

    public function findRowByCity($city){
        $where = array();
        $where[] = array('name' => 'epc_city_name', 'oper' => '=', 'value' => $city);
        return $this->getRow($where);
    }
}