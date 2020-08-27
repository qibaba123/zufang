<?php
/*
 * 合伙人分佣
 */
class App_Model_Entershop_MysqlManagerDeductStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'entershop_manager_deduct';
        $this->_pk = 'emd_id';
        $this->_shopId = 'emd_s_id';
        $this->sid = $sid;
    }

    /**根据条件统计订单信息
     * @param int $yesterday
     * @return array|bool
     */
    public function deductSum($where){
        $sql  = 'SELECT count(*) as num,sum(emd_money) as money ';
        $sql .= ' FROM '.DB::table($this->_table).' ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }






}