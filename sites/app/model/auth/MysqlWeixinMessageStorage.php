<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Auth_MysqlWeixinMessageStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'weixin_message';
        $this->_pk      = 'wm_id';
        $this->_shopId  = 'wm_s_id';
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
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        return $where;
    }

    /**
     * @param $sid
     * @return bool
     * 根据店铺ID删除自动回复配置
     */
    public function deleteBySid($sid){
        return $this->deleteValue($this->getWhereBySid($sid));
    }


}