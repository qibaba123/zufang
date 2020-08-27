<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/7/3
 * Time: 下午10:12
 */
class App_Model_Member_MysqlVipCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'vip_cfg';
        $this->_pk      = 'vc_id';
        $this->_shopId  = 'vc_s_id';

        $this->sid      = $sid;
    }

    /*
     * 通过订单id获取订单
     */
    public function findUpdateOrderBySid( $data = null) {
        $where    = array();
        $where[]  = array('name' => 'vc_s_id', 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
    /*
     * 获取店铺下格式化的VIP购买提成比例
     */
    public function fetchFormatRatio() {
        $where[]  = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $ratio    = array(0,0,0,0);
        $cfg    = $this->getRow($where);
        if (!$cfg) {
            return $ratio;
        }
        for ($i=1; $i<=3; $i++) {
            $ratio[$i]  = $cfg["vc_{$i}f_radio"];
        }
        return $ratio;
    }

    /*
     * 获取VIP专区配置或默认配置
     */
    public function fetchConfigOrDefault() {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        $config     = array('vc_bg' => '', 'vc_qrcode_limit' => 0,
            'vc_center_limit' => 0, 'vc_zone_link' => '');//默认配置
        $cfg    = $this->getRow($where);

        return $cfg ? $cfg : $config;
    }
}