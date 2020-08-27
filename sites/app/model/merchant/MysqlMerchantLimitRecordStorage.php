<?php
/*
 * 商家岛 秒杀购买记录
 */
class App_Model_Merchant_MysqlMerchantLimitRecordStorage extends Libs_Mvc_Model_BaseModel{

    private $sid;
    private $curr_table;

    public function __construct($sid = null){
        $this->_table 	= 'merchant_limit_record';
        $this->_pk 		= 'mlr_id';
        $this->_shopId 	= 'mlr_s_id';
        parent::__construct();

        $this->sid      = $sid;
        $this->curr_table   = DB::table($this->_table);
    }
    /*
     * 计算秒杀活动商品购买总量
     */
    public function countBuyNum($mid, $aid) {
        //$where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'mlr_m_id', 'oper' => '=', 'value' => $mid);
        $where[]    = array('name' => 'mlr_a_id', 'oper' => '=', 'value' => $aid);

        $sql    = "SELECT SUM(mlr_num) FROM `{$this->curr_table}` ";
        $sql    .= $this->formatWhereSql($where);

        $ret  = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }
}