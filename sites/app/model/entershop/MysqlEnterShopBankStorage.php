<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/3/17
 * Time: 下午9:34
 */

class App_Model_Entershop_MysqlEnterShopBankStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'enter_shop_bank';
        $this->_pk      = 'esb_id';
        $this->_shopId  = 'esb_es_id';
        $this->_df      = 'esb_deleted';
    }

    /**
     * @param $sid
     * @return bool
     * 清除默认值重新设置
     */
    public function clearDefault($sid){
        $set = array(
            'esb_is_default' => 0
        );
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        return $this->updateValue($set,$where);
    }

    /**
     * @param $sid
     * @param int $index
     * @param int $count
     * @return array|bool
     * 获取银行账户列表
     */
    public function getListBySid($sid,$index=0,$count=20){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $sort       = array('esb_is_default' => 'DESC','esb_create_time' => 'DESC');
        return $this->getList($where,$index,$count,$sort);
    }

    public function checkCode($sid,$code){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'esb_bank_code', 'oper' => '=', 'value' => $code);
        return $this->getCount($where);
    }

    public function checkCard($sid,$card){
        $where      = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => $this->_df, 'oper' => '=', 'value' => 0);
        $where[]    = array('name' => 'esb_bank_card', 'oper' => '=', 'value' => $card);
        return $this->getCount($where);
    }


}