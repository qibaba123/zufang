<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/21
 * Time: 上午8:58
 */
class App_Model_Member_MysqlMemberCenterStorage extends Libs_Mvc_Model_BaseModel {

    public function __construct() {
        parent::__construct();
        $this->_table = 'center_cfg';
        $this->_pk = 'cc_id';
        $this->_shopId = 'cc_s_id';
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