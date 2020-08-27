<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/22
 * Time: 上午9:10
 */
class App_Model_Shop_MysqlDeductStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'deduct_cfg';
        $this->_pk      = 'dc_id';
        $this->_shopId  = 'dc_s_id';
    }

    /*
     * 获取提成比例列表，按店铺ID获取
     * 无配置时，返回默认值
     */
    public function fetchDeductListBySid($sid, $type=1) {
        $list       = $this->getListByShopId($sid, $type);
        //购买一次时的默认配置提成比
        $buy_default    = array(
            'dc_buy_num'    => 1,
            'dc_back_num'   => 0,//返利分期数，仅限于购买人
            'dc_0f_ratio'   => 0.00,
            'dc_1f_ratio'   => 0.00,
            'dc_2f_ratio'   => 0.00,
            'dc_3f_ratio'   => 0.00
        );
        $ret    = array();
        foreach ($list as $val) {
            $ret[intval($val['dc_buy_num'])]    = $val;
        }

        if (!isset($ret[1])) {
            $ret[1] = $buy_default;
        }
        return $ret;
    }

    public function getListByShopId($sid, $type=1){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'dc_type', 'oper' => '=', 'value' => $type);
        $sort       = array('dc_buy_num' => 'ASC');//从小到大正序排列
        return $this->getList($where, 0, 0, $sort);
    }

    public function checkBuyNum($num,$sid,$dc_id=0, $type=1){
        $where = array();
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        $where[]    = array('name' => 'dc_buy_num', 'oper' => '=', 'value' => $num);
        $where[]    = array('name' => 'dc_type', 'oper' => '=', 'value' => $type);
        if($dc_id){
            $where[]    = array('name' => $this->_pk, 'oper' => '!=', 'value' => $dc_id);
        }
        $count = $this->getCount($where);
        return $count;
    }

}