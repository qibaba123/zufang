<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/12
 * Time: 下午7:09
 */
class App_Model_Plugin_MysqlEleCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'ele_cfg';
        $this->_pk      = 'ec_id';
        $this->_shopId  = 'ec_s_id';

        $this->sid      = $sid;
    }

    /*
     * 获取或修改店铺短信配置
     */
    public function fetchUpdateCfg($data = null, $esId=0) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if($esId){
            $where[]    = array('name' => 'ec_es_id', 'oper' => '=', 'value' => $esId);
        }else{
            $where[]    = array('name' => 'ec_es_id', 'oper' => '=', 'value' => 0);
        }

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }

    /*
     * 设置店铺预存金额自增或自减
     */
    public function incrementMemberBalance($money) {
        $field  = array('ec_balance');
        $inc    = array($money);

        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ec_es_id', 'oper' => '=', 'value' => 0);
        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 设置店铺预存金额自增或自减
     */
    public function incrementSendNum($money) {
        $field  = array('ec_send_num');
        $inc    = array($money);

        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ec_es_id', 'oper' => '=', 'value' => 0);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

    /*
     * 设置店铺使用金额自增或自减
     */
    public function incrementSpendMoney($money) {
        $field  = array('ec_spend');
        $inc    = array($money);

        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ec_es_id', 'oper' => '=', 'value' => 0);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

}