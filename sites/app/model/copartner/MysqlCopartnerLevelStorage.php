<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/8/17
 * Time: 上午午9:40
 */
class App_Model_Copartner_MysqlCopartnerLevelStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'copartner_level';
        $this->_pk 		= 'cl_id';
        $this->_shopId 	= 'cl_s_id';
        $this->_df      = 'cl_deleted';
        parent::__construct();
        $this->sid  = $sid;
    }

    public function getListBySid($sid,$index,$count){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $sort       = array('cl_weight' => 'DESC');
        return $this->getList($where, $index, $count,$sort );

    }

    public function getCountBySid($sid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        return $this->getCount($where);

    }


    public function getListBySidForSelect($sid){
        $list = $this->getListBySid($sid, 0, 0);
        $data = array();
        foreach($list as $val){
            $data[$val['cl_id']] = $val['cl_name'];
        }
        return $data;
    }


}