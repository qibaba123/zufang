<?php
/*
 * 跑腿 商家配送费记录
 */
class App_Model_Legwork_MysqlLegworkShopPostConfirmStorage extends Libs_Mvc_Model_BaseModel
{

    private $sid;//店铺id
    public function __construct($sid)
    {
        parent::__construct();
        $this->_table = 'applet_legwork_shop_post_confirm';
        $this->_pk = 'lspc_id';
        $this->_shopId = 'lspc_s_id';
        $this->sid = $sid;
    }



}