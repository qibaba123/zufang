<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/2/15
 * Time: 15:26
 * 轮播图
 */

class App_Model_Slide_MysqlSlideStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;

    public function __construct($sid=1) {
        parent::__construct();
        $this->_table   = 'slide';
        $this->_pk      = 'sl_id';
        $this->_df      = 'sl_deleted';
        $this->_shopId  = 'sl_s_id';
        $this->sid      = $sid;
//        $this->company_staff = DB::table($this->_table);
    }



}