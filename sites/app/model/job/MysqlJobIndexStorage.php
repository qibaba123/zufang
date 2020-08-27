<?php
/*
 * 问答小程序首页配置
 */
class App_Model_Job_MysqlJobIndexStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    public function __construct($sid){
        $this->_table 	= 'applet_job_index';
        $this->_pk 		= 'aji_id';
        $this->_shopId 	= 'aji_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
      * 通过店铺id获取模版配置
      */
    public function findUpdateBySid($tpl=61,$data = null) {
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aji_tpl_id', 'oper' => '=', 'value' => $tpl);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 增减商品销量
     */
    public function incrementBrowse($tpl=61, $num) {
        $field  = array('aji_browse_num');
        $inc    = array($num);

        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'aji_tpl_id', 'oper' => '=', 'value' => $tpl);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }



}