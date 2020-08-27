<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/8/17
 * Time: 上午午9:40
 */
class App_Model_Entershop_MysqlEnterShopStoreStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'enter_shop_store';
        $this->_pk 		= 'ess_id';
        $this->_shopId 	= 'ess_s_id';
        $this->_df      = 'ess_is_deleted';
        parent::__construct();
        $this->sid  = $sid;
    }

    /*
     * 获取门店详情
     */
    public function findStoreById($stid) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => $this->_pk, 'oper' => '=', 'value' => $stid);

        return $this->getRow($where);
    }

    /**
     * 查询本店所有门店
     */
    public function getAllListBySid(){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort       = array($this->_pk => 'DESC');
        return $this->getList($where,0,0,$sort,array(),true);
    }

}