<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/7/8
 * Time: 下午6:34
 */
class App_Model_Applet_MysqlCustomFormStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;//店铺id
    public function __construct($sid = null) {
        parent::__construct();
        $this->_table   = 'applet_custom_form';
        $this->_pk      = 'acf_id';
        $this->_shopId  = 'acf_s_id';

        $this->sid      = $sid;
    }

}