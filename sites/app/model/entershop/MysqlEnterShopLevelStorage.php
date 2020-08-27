<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/8/17
 * Time: 上午午9:40
 */
class App_Model_Entershop_MysqlEnterShopLevelStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'enter_shop_level';
        $this->_pk 		= 'esl_id';
        $this->_shopId 	= 'esl_s_id';
        $this->_df      = 'esl_deleted';
        parent::__construct();
        $this->sid  = $sid;
    }

    public function getListBySid($sid,$index,$count){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $sort       = array('esl_weight' => 'DESC');
        return $this->getList($where, $index, $count,$sort );

    }

    public function getCountBySid($sid){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        return $this->getCount($where);

    }




}