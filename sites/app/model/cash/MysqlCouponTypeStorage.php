<?php

/**
 * Class App_Model_Cash_MysqlCouponTypeStorage
 *
 * 优惠券赠送 分类配置
 */
class App_Model_Cash_MysqlCouponTypeStorage extends Libs_Mvc_Model_BaseModel {
    private $sid;

    public function __construct($sid='') {
        parent::__construct();
        $this->_table   = 'cash_coupon_type';
        $this->_pk      = 'cct_id';
        $this->_shopId  = 'cct_s_id';
        $this->_df      = 'cct_deleted';

        $this->sid      = $sid;
    }




}