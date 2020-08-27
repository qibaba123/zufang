<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/9/10
 * Time: 下午3:13
 */
class App_Model_Trade_MysqlPrintStorage extends Libs_Mvc_Model_BaseModel{

    public function __construct(){
        $this->_table 	= 'trade_print';
        $this->_pk 		= 'tp_id';
        $this->_shopId 	= 'tp_s_id';
        parent::__construct();
    }

    /**
     * @param $sid
     * @param $type
     * @param null $data
     * @return array|bool
     * 通过类型和店铺ID查询、更新打印模版数据
     */
    public function findUpdateRowBySidType($sid,$type, $data = null , $esId = 0) {
        $where      = array();
        $where[]    = array('name' => 'tp_s_id', 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'tp_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'tp_es_id', 'oper' => '=', 'value' => $esId);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    public function getListBySid($sid){
        $where      = array();
        $where[]    = array('name' => 'tp_s_id', 'oper' => '=', 'value' => $sid);
        return $this->getList($where);
    }

}