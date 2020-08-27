<?php
/*
 * 爆品分销 商品分佣比例
 */
class App_Model_Sequence_MysqlSequenceGoodsDeductStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_goods_deduct';
        $this->_pk = 'asgd_id';
        $this->_shopId = 'asgd_s_id';
        $this->sid = $sid;

    }

    public function getRowByGid($gid){
        $where[]    = array('name' => 'asgd_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getRow($where);
    }





}