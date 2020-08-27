<?php

class App_Model_Giftcard_MysqlGiftCardCartStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_gift_card_cart';
        $this->_pk = 'agcc_id';
        $this->_shopId = 'agcc_s_id';

        $this->sid = $sid;
    }

    public function getListByMid($mid,$cardType,$index = 0,$count = 0){
        $where = [];
        $where[] = ['name' => 'agcc_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'agcc_m_id', 'oper' => '=', 'value' => $mid];
        $where[] = ['name' => 'agcc_card_type', 'oper' => '=', 'value' => $cardType];
        return $this->getList($where,$index,$count,['agcc_create_time' => 'DESC']);
    }

    public function findUpdateByMidCardId($mid,$cardId,$data = []){
        $where = [];
        $where[] = ['name' => 'agcc_s_id', 'oper' => '=', 'value' => $this->sid];
        $where[] = ['name' => 'agcc_m_id', 'oper' => '=', 'value' => $mid];
        $where[] = ['name' => 'agcc_card_id', 'oper' => '=', 'value' => $cardId];
        if($data){
            return $this->updateValue($data,$where);
        }else{
            return $this->getRow($where);
        }
    }

}