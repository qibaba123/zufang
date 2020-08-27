<?php

class App_Model_Train_MysqlTrainInvoiceStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;

    private $curr_table;
    private $member_table;
    private $trade_order_table;
    private $trade_table;
    private $offline_order_table;

    public function __construct($sid = null){
        $this->_table 	= 'applet_train_invoice';
        $this->_pk 		= 'ati_id';
        $this->_shopId 	= 'ati_s_id';
        parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
        $this->member_table = DB::table('member');
        $this->trade_order_table = DB::table('trade_order');
        $this->trade_table = DB::table('trade');
        $this->offline_order_table = DB::table('offline_order');
    }


    public function getTradeCount($where){
        $sql = "select count(*) as total ";
        $sql .= " from `".DB::table($this->_table)."` ati ";
        $sql .= " LEFT JOIN ".$this->trade_table." AS t ON ati.ati_tid=t.t_tid ";
        $sql .= $this->formatWhereSql($where);
        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    public function getTradeList($where,$index,$count,$sort){
        $sql = "select ati.*,t.t_payment,t.t_pay_time,t.t_tid,t.t_title,oo.oo_amount,oo.oo_pay_time,oo.oo_tid,oo.oo_title ";
        $sql .= " from `".DB::table($this->_table)."` ati ";
        $sql .= " LEFT JOIN ".$this->trade_table." AS t ON ati.ati_tid=t.t_tid AND ati.ati_trade_type = 1 ";
        $sql .= " LEFT JOIN ".$this->offline_order_table." AS oo ON ati.ati_tid=oo.oo_tid AND ati.ati_trade_type = 2 ";
        $sql .= $this->formatWhereSql($where);
        $sql .= $this->getSqlSort($sort);
        $sql .= $this->formatLimitSql($index,$count);
        Libs_Log_Logger::outputLog($sql,'test.log');
        $ret = DB::fetch_all($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }




}