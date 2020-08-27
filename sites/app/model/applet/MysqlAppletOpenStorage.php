<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/7/7
 * Time: 下午1:39
 */
class App_Model_Applet_MysqlAppletOpenStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'applet_open';
        $this->_pk      = 'ao_id';
        $this->_shopId  = 'ao_s_id';

        $this->sid      = $sid;
    }

    public function deleteRowByAppid($appid) {
        $where[]    = array('name' => 'ao_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[]    = array('name' => 'ao_appid', 'oper' => '=', 'value' => $appid);

        return $this->deleteValue($where);
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

}