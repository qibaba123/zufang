<?php
/*
 * 社区团购 未结算收益记录表
 */
class App_Model_Sequence_MysqlSequenceDeductNosettledStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_sequence_deduct_nosettled';
        $this->_pk = 'asdn_id';
        $this->_shopId = 'asdn_s_id';
        $this->sid = $sid;
    }

    /**根据条件统计订单信息
     * @param int $yesterday
     * @return array|bool
     */
    public function deductCountSum($where){
        $sql  = 'SELECT count(*) as num,sum(asdn_money) as money ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function deductSum($where){
        $sql  = 'SELECT sum(asdn_money) as money ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



    public function getListTrade($where,$index,$count,$sort){
        $sql = "select asdn.*,t.t_id,t.t_buyer_nick,t.t_goods_fee,t.t_total_fee,t.t_payment,t.t_post_fee,t.t_create_time ";
        $sql .= " from `".DB::table($this->_table)."` asdn ";
        $sql .= " left join pre_trade t on t.t_tid = asdn.asdn_tid ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);

        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getCountTrade($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` asdn ";
        $sql .= " left join pre_trade t on t.t_tid = asdn.asdn_tid ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /*
     * 根据订单号获得佣金
     */
    public function getRowByTid($tid,$type = 1,$status = 0,$leaderId = 0){
        $where = [];
        $where[] = ['name'=>'asdn_s_id','oper'=>'=','value'=>$this->sid];
        $where[] = ['name'=>'asdn_tid','oper'=>'=','value'=>$tid];
        $where[] = ['name'=>'asdn_status','oper'=>'=','value'=>$status];
        $where[] = ['name'=>'asdn_type','oper'=>'=','value'=>$type];
        if($leaderId){
            $where[] = ['name'=>'asdn_leader','oper'=>'=','value'=>$leaderId];
        }
        return $this->getRow($where);
    }

    /**
     * @param array $val_arr
     * @return bool
     * 批量插入数据
     */
    public function insertBatch(array $val_arr){
        $ret = false;
        if(!empty($val_arr) && is_array($val_arr)){
            $sql  = 'INSERT INTO '.DB::table($this->_table);
            $sql .= '  (`asdn_id`, `asdn_s_id`,  `asdn_m_id`, `asdn_leader`, `asdn_money`, `asdn_tid`, `asdn_status`,`asdn_type`, `asdn_create_time`) ';
            $sql .= ' VALUES ';
            $sql .= implode(',',$val_arr);
            $ret = DB::query($sql);

            if ($ret === false) {
                trigger_error("query mysql failed.", E_USER_ERROR);
                return false;
            }
        }
        return $ret;
    }


}