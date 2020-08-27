<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/7/8
 * Time: 下午6:34
 */
class App_Model_Applet_MysqlChildStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'applet_child';
        $this->_pk      = 'ac_id';
        $this->_shopId  = 'ac_s_id';

        $this->sid      = $sid;
    }

    /*
     * 通过小程序app_id获取微信配置
     */
    public function fetchUpdateWxcfgByAid($aid, $data = null) {
        $where[] = array('name' => 'ac_appid', 'oper' => '=', 'value' => $aid);
        if (!$data) {
            return $this->getRow($where);
        } else {
            return $this->updateValue($data, $where);
        }
    }

}