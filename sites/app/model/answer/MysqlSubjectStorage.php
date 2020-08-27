<?php
/**
 * Created by PhpStorm.
 * User: zhaoweizhen
 * Date: 16/6/27
 * Time: 下午10:01
 */
class App_Model_Answer_MysqlSubjectStorage extends Libs_Mvc_Model_BaseModel {

    private $sid;
    private $shop_table = '';
    public function __construct($sid) {
        parent::__construct();
        $this->_table   = 'applet_subject';
        $this->_pk      = 'as_id';
        $this->_shopId  = 'as_s_id';
        $this->_df      = 'as_deleted';
        $this->sid      = $sid;
        $this->shop_table = DB::table('shop');
    }

}