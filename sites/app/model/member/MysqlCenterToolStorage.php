<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/9/12
 * Time: 下午7:58
 */
class App_Model_Member_MysqlCenterToolStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table   = 'center_tool';
        $this->_pk      = 'ct_id';
        $this->_shopId  = 'ct_s_id';
    }

    /*
     * 通过店铺id获取或更新会员管理中心配置项
     */
    public function findUpdateBySid($sid, $data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);

        if (!$data) {
            return $this->getRow($where);
        } else {
            return $this->updateValue($data, $where);
        }
    }

    public function isExistBySid($sid){
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $sid);
        return $this->getRow($where);
    }

}