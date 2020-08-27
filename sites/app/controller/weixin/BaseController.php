<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/2
 * Time: 下午7:38
 */

class App_Controller_Weixin_BaseController extends Libs_Mvc_Controller_WeixinController {
    /*
     * 会员的微信openID
     */
    protected $wx_openid;
    /*
     * 店铺唯一性ID
     */
    protected $suid;
    /*
     * 店铺信息，具体字段名可参考pre_shop
     */
    protected $shop;
    /*
     * 店铺ID
     */
    protected $sid;

    public function __construct($weixin_msg) {
        parent::__construct($weixin_msg);
        $this->wx_openid  = (string)$this->weixinMsg->FromUserName;
        $shop_storage   = new App_Model_Shop_MysqlShopCoreStorage();
        if (property_exists($this->weixinMsg, 'suid')) {
            $this->suid     = (string)$this->weixinMsg->suid;

            $this->shop     = $shop_storage->findShopByUniqid($this->suid);
            $this->sid      = $this->shop['s_id'];
        } else {
            $this->sid      = (int)$this->weixinMsg->sid;
            $this->shop     = $shop_storage->getRowById($this->sid);

            $this->suid     = $this->shop['s_unique_id'];
        }
    }
}