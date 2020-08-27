<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/10/26
 * Time: 下午5:51
 */
class App_Model_Shop_MysqlCommentStorage extends Libs_Mvc_Model_BaseModel {
    
    private $sid;

    public function __construct($sid = null){
        parent::__construct();
        $this->_table   = 'shop_comment';
        $this->_pk      = 'sc_id';
        $this->_shopId  = 'sc_s_id';

        $this->sid      = $sid;
    }
}