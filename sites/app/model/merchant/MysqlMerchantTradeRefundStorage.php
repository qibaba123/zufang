<?php
/*
 * 商家岛 订单退款记录
 */
class App_Model_Merchant_MysqlMerchantTradeRefundStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;


    public function __construct($sid){
        $this->_table 	= 'merchant_trade_refund';
        $this->_pk 		= 'mtr_id';
        $this->_shopId 	= 'mtr_s_id';
        parent::__construct();
        $this->sid  = $sid;
    }


    /**
     * @param $tid
     * @return array|bool
     * 根据tid获取退款记录（单条）
     */
    public function getRowTid($tid){
        $where      = array();
        $where[]    = array('name'=>'mtr_s_id','oper'=>'=','value'=>$this->sid);
        $where[]    = array('name'=>'mtr_tid','oper'=>'=','value'=>$tid);
        return $this->getRow($where);
    }


    /*
     * 通过订单id获取订单
     */
    public function findUpdateByTid($tid, $data = null) {
        $where[]    = array('name' => 'mtr_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'mtr_s_id', 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获取最近的一个退款记录
     */
    public function getLastRecord($tid) {
        $where[]    = array('name' => 'mtr_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'mtr_s_id', 'oper' => '=', 'value' => $this->sid);

        $sort   = array('mtr_create_time' => 'DESC');
        $list   = $this->getList($where, 0, 1, $sort);

        return $list ? $list[0] : false;
    }
    /*
     * 获取订单的维权记录
     */
    public function getAllRecord($tid) {
        $where[]    = array('name' => 'mtr_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'mtr_s_id', 'oper' => '=', 'value' => $this->sid);

        $sort       = array('mtr_create_time' => 'DESC');

        return $this->getList($where, 0, 0, $sort);
    }

    /*
     * 通过退款单id获取退款单信息或者修改退款申请信息
     */
    public function findUpdateByTrid($trid, $data = null) {
        $where[]    = array('name' => 'mtr_id', 'oper' => '=', 'value' => $trid);
        $where[]    = array('name' => 'mtr_s_id', 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}