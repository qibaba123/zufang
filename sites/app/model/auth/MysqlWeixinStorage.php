<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Auth_MysqlWeixinStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id

    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'weixin_cfg';
        $this->_pk      = 'wc_id';
        $this->_shopId  = 'wc_s_id';
        $this->sid      = $sid;
    }

    /*
     * 通过店铺id查找微信配置
     */
    public function findWeixinBySid($sid) {
        return $this->getRow($this->getWhereBySid($sid));
    }

    public function updateBySId($set,$sid){
        return $this->updateValue($set,$this->getWhereBySid($sid));
    }

    public function getCountBySid($sid){
        return $this->getCount($this->getWhereBySid($sid));
    }

    private function getWhereBySid($sid){
        $where   = array();
        $where[] = array('name' => 'wc_s_id', 'oper' => '=', 'value' => $sid);
        return $where;
    }

    /**
     * 获取店铺配置
     */
    public function findShopCfg($data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }


    /*
     * 通过公众号app_id获取微信配置
     */
    public function fetchUpdateWxcfgByAid($aid, $data = null) {
        $where[] = array('name' => 'wc_app_id', 'oper' => '=', 'value' => $aid);
        if (!$data) {
            return $this->getRow($where);
        } else {
            return $this->updateValue($data, $where);
        }

    }
}