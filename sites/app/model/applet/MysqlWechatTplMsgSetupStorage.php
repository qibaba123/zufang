<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/4/19
 * Time: 下午12:13
 */

class App_Model_Applet_MysqlWechatTplMsgSetupStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_wechat_setup';
        $this->_pk      = 'aws_id';
        $this->_shopId  = 'aws_s_id';

        $this->sid      = $sid;
    }

    /*
     * 获取模板消息
     */
    public function findOneBySid() {
        $where[] = array('name' => $this->_shopId, 'oper' => '=', 'value' => $this->sid);
        return $this->getRow($where);
    }



}