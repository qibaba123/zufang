<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 16/6/11
 * Time: 下午10:28
 */
class App_Helper_BargainActivity {

    const BARGAIN_ACTIVITY_PREPARING    = 0;//活动准备中
    const BARGAIN_ACTIVITY_ONGOING      = 1;//活动进行中
    const BARGAIN_ACTIVITY_CLOSED       = 2;//活动已结束

    const BARGAIN_JOINER_NO_BUY     = 0;//未购买
    const BARGAIN_JOINER_HAS_BUY    = 1;//已购买

    private $sid;

    public function __construct($sid) {
        $this->sid  = $sid;
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $this->shop = $shop_model->getRowById($sid);
    }

    /**
     * 修改活动当前状态
     * @param int $aid
     * @param string $type preparing、ongoing、closed
     */
    public function updateActivityStatus($aid, $type = 'preparing') {
        $status = self::BARGAIN_ACTIVITY_PREPARING;
        switch ($type) {
            case 'preparing' :
                $status = self::BARGAIN_ACTIVITY_PREPARING;
                break;
            case 'ongoing' :
                $status = self::BARGAIN_ACTIVITY_ONGOING;
                break;
            case 'closed' :
                $status = self::BARGAIN_ACTIVITY_CLOSED;
                break;
        }

        $updata = array(
            'ba_status'     => $status,
        );
        $activity_storage   = new App_Model_Bargain_MysqlActivityStorage($this->sid);
        $activity_storage->fetchUpdateByAid($aid, $updata);
    }

    /*
     * 修改参与记录购买状态
     */
    public function updateJoinerBuy($jid) {
        $updata = array(
            'bj_has_buy'    => self::BARGAIN_JOINER_HAS_BUY,
        );

        $join_storage   = new App_Model_Bargain_MysqlJoinStorage($this->sid);
        $join_storage->updateById($updata, $jid);
    }
    /*
     * 修改参与记录购买状态
     */
    public function updateMerchantJoinerBuy($jid) {
        $updata = array(
            'mbj_has_buy'    => self::BARGAIN_JOINER_HAS_BUY,
        );

        $join_storage   = new App_Model_Merchant_MysqlMerchantBargainJoinStorage($this->sid);
        $join_storage->updateById($updata, $jid);
    }
}