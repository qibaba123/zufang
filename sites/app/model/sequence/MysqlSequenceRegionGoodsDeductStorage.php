<?php 
/**
 * 社区团购区域管理合伙人 对于单个商品可以领取到的佣金
 * zhangzc
 * 2019-04-11
 */
class App_Model_Sequence_MysqlSequenceRegionGoodsDeductStorage extends Libs_Mvc_Model_BaseModel{
	private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_region_goods_deduct';
        $this->_pk = 'asrgd_id';
        $this->_shopId = 'asrgd_s_id';
        $this->sid = $sid;

    }

    public function getRowByGid($gid){
        $where[]    = array('name' => 'asrgd_g_id', 'oper' => '=', 'value' => $gid);
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getRow($where);
    }
}