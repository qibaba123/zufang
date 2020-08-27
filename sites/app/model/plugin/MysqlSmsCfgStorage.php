<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/12
 * Time: 下午7:09
 */
class App_Model_Plugin_MysqlSmsCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;

    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'sms_cfg';
        $this->_pk      = 'sc_id';
        $this->_shopId  = 'sc_s_id';

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

    /*
     * 设置可用短信,已发送短信
     */
    public function incrementSmsTotal($use = -1, $send = 1) {
        $field  = array('sc_useable', 'sc_had_send');
        $inc    = array($use, $send);

        $where[]    = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);

        $sql = $this->formatIncrementSql($field, $inc, $where);
        return DB::query($sql);
    }

}