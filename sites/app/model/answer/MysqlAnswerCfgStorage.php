<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/6/27
 * Time: 下午10:01
 */
class App_Model_Answer_MysqlAnswerCfgStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $shop_table = '';
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_subject_cfg';
        $this->_pk      = 'asc_id';
        $this->_shopId  = 'asc_s_id';
        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }

    /*
     * 配置
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