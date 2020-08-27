<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/16
 * Time: 下午4:13
 */

class App_Model_Qq_MysqlAppletQqPayStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_qq_pay';
        $this->_pk      = 'ap_id';
        $this->_shopId  = 'ap_s_id';
        $this->sid      = $sid;
    }

    /*
     * 通过店铺id查找小程序微信支付配置
     */
    public function findRowPay($data = array()) {
        $where   = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if(!empty($data)){
            $ret = $this->updateValue($data,$where);
        }else{
            $ret = $this->getRow($where);
        }
        return $ret;
    }

    /*
     * 根据店铺id获取配置列表
     */
    public function getPayCfgListByIds($sids){
        $where   = array();
        $where[] = array('name' => $this->_shopId, 'oper' => 'in', 'value' => $sids);
        $list = $this->getList($where,0,0,array());
        $data = array();
        if($list){
            foreach ($list as $value){
                $data[$value['ap_s_id']] = $value;
            }
        }
        return $data;
    }

}