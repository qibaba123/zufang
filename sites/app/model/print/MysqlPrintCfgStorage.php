<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Print_MysqlPrintCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_print_cfg';
        $this->_pk      = 'apc_id';
        $this->_shopId  = 'apc_s_id';

        $this->sid      = $sid;
    }

    /*
    * 通过店铺id和打印机编号查找
    */
    public function findRowBySid($data=array(),$esId = 0) {
        $where   = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if($esId){
            $where[] = array('name' => 'apc_es_id', 'oper' => '=', 'value' => $esId);
        }
        if(!empty($data)){
            $ret = $this->updateValue($data,$where);
        }else{
            $ret = $this->getRow($where);
        }
        return $ret;
    }




}