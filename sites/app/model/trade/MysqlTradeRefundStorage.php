<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/8/8
 * Time: 下午5:22
 */
class App_Model_Trade_MysqlTradeRefundStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;


    public function __construct($sid){
        $this->_table 	= 'trade_refund';
        $this->_pk 		= 'tr_id';
        $this->_shopId 	= 'tr_s_id';
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
        $where[]    = array('name'=>'tr_s_id','oper'=>'=','value'=>$this->sid);
        $where[]    = array('name'=>'tr_tid','oper'=>'=','value'=>$tid);
        return $this->getRow($where);
    }

    /**
     * @param $tid
     * @return array|bool
     * 根据tid获取退款记录（单条）
     */
    public function getFinishTid($tid,$toid=0){
        $where      = array();
        $where[]    = array('name'=>'tr_s_id','oper'=>'=','value'=>$this->sid);
        $where[]    = array('name'=>'tr_tid','oper'=>'=','value'=>$tid);
        if($toid){
            $where[]=['name'=>'tr_to_id','oper'=>'=','value'=>$toid];
        }
        $where[]    = array('name'=>'tr_status','oper'=>'=','value'=>1);
        return $this->getRow($where);
    }


    /*
     * 通过订单id获取订单
     */
    public function findUpdateByTid($tid, $data = null) {
        $where[]    = array('name' => 'tr_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'tr_s_id', 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 获取最近的一个退款记录
     */
    public function getLastRecord($tid, $toid=0,$isFinish = 0) {
        $where[]    = array('name' => 'tr_tid', 'oper' => '=', 'value' => $tid);
        $where[]    = array('name' => 'tr_s_id', 'oper' => '=', 'value' => $this->sid);
       
        if($toid){
            $where[]    = array('name' => 'tr_to_id', 'oper' => '=', 'value' => $toid);
        }
        if($isFinish){
            $where[]    = array('name' => 'tr_to_id', 'oper' => '=', 'value' => $toid);
        }

        $sort   = array('tr_create_time' => 'DESC');
        $list   = $this->getList($where, 0, 1, $sort);

        return $list ? $list[0] : false;
    }
    /*
     * 获取订单的维权记录
     */
    public function getAllRecord($tid,$toid=0) {
        $where[]    = array('name' => 'tr_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'tr_tid', 'oper' => '=', 'value' => $tid);

        
        if($toid){
            $where[]    = ['name' => 'tr_to_id', 'oper' => '=', 'value' => $toid];
        }
        $sort       = array('tr_create_time' => 'DESC');

        return $this->getList($where, 0, 0, $sort);
    }

    /*
     * 通过退款单id获取退款单信息或者修改退款申请信息
     */
    public function findUpdateByTrid($trid, $data = null) {
        $where[]    = array('name' => 'tr_id', 'oper' => '=', 'value' => $trid);
        $where[]    = array('name' => 'tr_s_id', 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /**根据条件统计退款订单信息
     * @param int $yesterday
     * @return array|bool
     */
    public function  refundOrderStatistic($where){
        $sql  = 'SELECT count(*) total,sum(tr_money) money ';
        $sql .= ' FROM '.DB::table($this->_table).' tr ';
        $sql .= " left join pre_trade t on tr.tr_tid = t.t_tid ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}