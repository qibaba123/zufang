<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/8/16
 * Time: 下午4:13
 */

class App_Model_Applet_MysqlAppletTencentyunStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_tencentyun';
        $this->_pk      = 'at_id';
        $this->_shopId  = 'at_s_id';
        $this->sid      = $sid;
    }

    /*
     * 通过店铺id查找小程序腾讯云配置
     */
    public function findRowCfg($data = array()) {
        $where   = array();
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        if(!empty($data)){
            $ret = $this->updateValue($data,$where);
        }else{
            $ret = $this->getRow($where);
        }
        return $ret;
    }

}