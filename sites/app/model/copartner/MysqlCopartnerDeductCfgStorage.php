<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/22
 * Time: 上午9:10
 */
class App_Model_Copartner_MysqlCopartnerDeductCfgStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'copartner_deduct_cfg';
        $this->_pk      = 'cdc_id';
        $this->_shopId  = 'cdc_s_id';
    }

    /*
     * 获取提成比例列表，按店铺ID获取
     * 无配置时，返回默认值
     */
    public function fetchDeductListBySid($sid, $lid=0) {
        $list       = $this->getListByShopId($sid, $lid);
        //购买一次时的默认配置提成比
        $buy_default    = array(
            'cdc_buy_num'    => 1,
            'cdc_back_num'   => 0,//返利分期数，仅限于购买人
            'cdc_0f_ratio'   => 0.00,
            'cdc_1f_ratio'   => 0.00,
            'cdc_2f_ratio'   => 0.00,
            'cdc_3f_ratio'   => 0.00
        );
        $ret    = array();
        foreach ($list as $val) {
            $ret[intval($val['cdc_buy_num'])]    = $val;
        }

        if (!isset($ret[1])) {
            $ret[1] = $buy_default;
        }
        return $ret;
    }

    public function getListByShopId($sid, $lid=0){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cdc_l_id', 'oper' => '=', 'value' => $lid);
        $sort       = array('cdc_buy_num' => 'ASC');//从小到大正序排列
        return $this->getList($where, 0, 0, $sort);
    }

    public function checkBuyNum($num,$sid,$cdc_id=0, $type=1){
        $where = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cdc_buy_num', 'oper' => '=', 'value' => $num);
        $where[]    = array('name' => 'cdc_l_id', 'oper' => '=', 'value' => $type);
        if($cdc_id){
            $where[]    = array('name' => $this->_pk, 'oper' => '!=', 'value' => $cdc_id);
        }
        $count = $this->getCount($where);
        return $count;
    }

    public function deleteByLid($lid, $sid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'cdc_l_id', 'oper' => '=', 'value' => $lid);
        return $this->deleteValue($where);
    }

}