<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/3/1
 * Time: 下午2:10
 */
class App_Model_Point_MysqlPointLineCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'line_cfg';
        $this->_pk      = 'lc_id';
        $this->_shopId  = 'lc_s_id';

        $this->sid      = $sid;
    }

    /*
     * 添加或获取配置
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