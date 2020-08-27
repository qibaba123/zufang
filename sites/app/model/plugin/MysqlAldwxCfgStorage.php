<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/12
 * Time: 下午7:09
 */
class App_Model_Plugin_MysqlAldwxCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'aldwx_cfg';
        $this->_pk      = 'ac_id';
        $this->_shopId  = 'ac_s_id';

        $this->sid      = $sid;
    }

    /*
     * 获取或修改店铺短信配置
     */
    public function fetchUpdateCfg($data = null) {
        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        if ($data) {
            return $this->updateValue($data, $where);
        } else {
            return $this->getRow($where);
        }
    }
}