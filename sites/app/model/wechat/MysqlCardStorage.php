<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/7/20
 * Time: 上午10:59
 */
class App_Model_Wechat_MysqlCardStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    public function __construct($sid){
        $this->_table 	= 'weixin_card';
        $this->_pk 		= 'wc_id';
        $this->_shopId 	= 'wc_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }

    public function findCardByID($cardid, $data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'wc_card_id', 'oper' => '=', 'value' => $cardid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


    public function findCardList($where,$index,$count){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $sort = array('wc_add_time'=>'DESC');
        return $this->getList($where,$index,$count,$sort);
    }
}