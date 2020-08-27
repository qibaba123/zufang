<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/8/17
 * Time: 下午2:55
 */
class App_Model_Entershop_MysqlEnterShopWithdrawStorage extends Libs_Mvc_Model_BaseModel {

    private $bank_table = '';
    private $shop_table = '';
    public function __construct() {
        parent::__construct();
        $this->_table   = 'enter_shop_withdraw';
        $this->_pk      = 'esw_id';
        $this->_shopId  = 'esw_es_id';
        $this->bank_table  = DB::table('enter_shop_bank');
        $this->shop_table  = DB::table('enter_shop');

    }

    public function getStatInfo($where)
    {
        $sql = 'select count(*) as total,sum(esw_amount) as money ';
        $sql .= ' from `' . DB::table($this->_table) . '` ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param $sort
     * @return array|bool
     * 链银行账户表查询
     */
    public function getBankList($where , $index, $count, $sort=array('esw_create_time' => 'DESC')) {
        $sql = 'select * ';
        $sql .= ' from `'.DB::table($this->_table).'` sw ';
        $sql .= ' left join '.$this->bank_table.' sb on esb_id = esw_bank_id ';
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

    /**
     * @param $where
     * @param $index
     * @param $count
     * @param array $sort
     * @return array|bool
     * 获取申请信息，连表银行，店铺
     */
    public function getShopBankList($where , $index, $count, $sort=array('esw_create_time' => 'DESC')) {
        $sql = 'select * ';
        $sql .= ' from `'.DB::table($this->_table).'` sw ';
        $sql .= ' left join '.$this->bank_table.' sb on esb_id = esw_bank_id ';
        $sql .= ' left join '.$this->shop_table.' sh on es_id = esw_es_id ';
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
    /**
     * @param $where
     * @return array|bool
     * 获取申请信息，连表银行，店铺
     */
    public function getShopBankRow($where) {
        $sql = 'select * ';
        $sql .= ' from `'.DB::table($this->_table).'` sw ';
        $sql .= ' left join '.$this->bank_table.' sb on esb_id = esw_bank_id ';
        $sql .= ' left join '.$this->shop_table.' sh on es_id = esw_es_id ';
        $sql .= $this->formatWhereSql($where);
        $ret = DB::fetch_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }


    /**
     * @param $where
     * @return bool
     * 统计信息
     */
    public function getShopBankCount($where) {
        $sql = 'select count(*) ';
        $sql .= ' from `'.DB::table($this->_table).'` sw ';
        $sql .= ' left join '.$this->bank_table.' sb on esb_id = esw_bank_id ';
        $sql .= ' left join '.$this->shop_table.' sh on es_id = esw_es_id ';
        $sql .= $this->formatWhereSql($where);

        $ret = DB::result_first($sql);
        if ($ret === false) {
            trigger_error("query mysql failed.", E_USER_ERROR);
            return false;
        }
        return $ret;
    }



}