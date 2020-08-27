<?php
/**
 * 退款方式选择（此类只处理退钱的操作，其他的后续操作不涉及）
 * zhangzc
 * 2019-10-29
 */

// 这个里面是执行后续的操作呢还是只退钱
// afterEntershopRefund
// _recharge_record
// 这两个函数要么是引入，要么是重新定义
class App_Helper_RefundWay{
	// 是否执行入住店铺的退款后续操作
	private $es_refund=true;
	public function __construct($sid){
		$this->sid=$sid;
	}
	/**
     * 根据不同的支付方式进行相应的退款逻辑(工厂方法)
     * zhangzc
     * 2019-10-29
     * @return [type] [description]
     */
    public function doRefundWithPayType($payWay,$trade,$refund,$source){
        $trade_redis    = new App_Model_Trade_RedisTradeStorage($this->sid);
        switch ($payWay) {
            // 微信自有支付 支付状态1
            case App_Helper_Trade::TRADE_PAY_WXZFZY:
                $refund_status=$this->wechatRefundWay($trade,$refund,$source);
                break;
            //微信支付代销  支付状态2
            case App_Helper_Trade::TRADE_PAY_WXZFDX:
                $refund_status=$this->wechatAgentRefundWay($trade,$refund,$trade_redis);
                $this->es_refund=false;
                break;
            // 支付宝支付 支付状态3
            case App_Helper_Trade::TRADE_PAY_ZFBZFDX:
                $refund_status=$this->aliPayRefundWay($trade, $refund);
                break;
            // 余额支付 支付状态5
            case App_Helper_Trade::TRADE_PAY_YEZF:
                $refund_status=$this-> goldRefundWay($trade,$refund);
                break;
            // 微信金币混合支付 支付状态 9
            case App_Helper_Trade::TRADE_PAY_HHZF:
                $refund_status=$this->multiWechatGoldRefundWay($trade,$refund,$source);
                break;
            // 微财猫支付 支付状态11
            case App_Helper_Trade::TRADE_PAY_VCMWXZF:
                $refund_status=$this->wcmRefundWay($trade,$refund);
                break;
            // 货到付款 支付状态4
            // 优惠全面 支付状态6
            // 其他方式
            // 以上三种支付方式不进行退款操作
            case App_Helper_Trade::TRADE_PAY_HDFK:
            case App_Helper_Trade::TRADE_PAY_YHQM:
            default:
            	$refund_status=FALSE;
                break;

            // 退款执行成功，进行入住店铺的退款相关逻辑
            if($trade['t_es_id'] > 0 && $refund_status===true){
	            $this->afterEntershopRefund($trade,$refund);
	        }
        }
    }
    /**
     * 微信支付的退款
     * zhangzc
     * 2019-10-29
     * @param  [type] $trade  [订单对象]
     * @param  [type] $refund [退款对象]
     * @param  [type] $source [退款方式]
     * @return [type]         [正常返回TRUE，错误范围指定类型的错误信息]
     */
    private function wechatRefundWay($trade,$refund,$source){
        // 判断是否是服务商模式下支付
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();

        // 服务商方式退款
        if($appcfg && $appcfg['ap_sub_pay']==1){
            $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
            $ret = $subPay_storage->appletRefundPayOrder($appcfg['ap_appid'],$trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx', $source);

            $ret_sub = $ret;

            // 如果服务商模式退款处理失败，尝试普通商户退款
            if($ret['code']!='SUCCESS'){
                //发起微信退款
                $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx', $source);
                //当两次都失败时 防止尝试普通商户退款覆盖错误信息
                if($ret_sub['code'] != 'SUCCESS' && $ret['code'] != 'SUCCESS'){
                    $ret['errmsg'] = $ret_sub['errmsg'];
                }

            }
            $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
        // 普通商家方式
        }else{
            //发起微信退款
            $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
            $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx', $source);

            $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
        }

        

        if(!$ret || $ret['code']!='SUCCESS' ){
            if($trade['t_es_id']>0){
                return array(
                    'code' => 'fail',
                    'msg'  => '退款处理失败，请联系平台管理员。失败原因：'.$ret['errmsg'],
                );
            }else{
                return array(
                    'code' => 'fail',
                    'msg'  => $ret['errmsg'],
                );
            }
        }
        return $refund_state;
    }
    /**
     * 微信代销的退款
     * zhangzc
     * 2019-10-29
     * @param  [type] $trade       [订单对象]
     * @param  [type] $refund      [退款订单对象]
     * @param  [type] $trade_redis [订单缓存对象]
     * @return [type]              [错误返回错误信息，争取返回TRUE]
     */
    private function wechatAgentRefundWay($trade,$refund,$trade_redis){
        $store_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $store = $store_model->getRowById($trade['t_es_id']);
        //支付宝支付代销
        $balance    = floatval($store['es_balance']);   //店铺收益余额
        $recharge   = floatval($store['es_recharge']);  //店铺通天币
        $settled_model  = new App_Model_Trade_MysqlTradeSettledStorage($this->sid);
        $settled    = $settled_model->findSettledByTid($trade['t_tid']);
        //未找到结算,或已退款结算
        if (!$settled || $settled['ts_status'] == self::TRADE_SETTLED_REFUND) {
            return array(
                'code' => 'fail',
                'msg'  => '未找到结算,或已退款结算',
            );
        }
        //已成功结算的交易,退款时,判断店铺余额是否充足
        if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
            //需要判断店铺余额
            if ($balance < floatval($refund['tr_money']) && $recharge < floatval($refund['tr_money'])) {
                return array(
                    'code' => 'fail',
                    'msg'  => '店铺余额不足以支撑退款金额',
                );
            }
        }
        //发起微信退款
        $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
        $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_total_fee'], $refund['tr_money'], 'wx');
        if(!$ret || $ret['code']!='SUCCESS' ){
            return array(
                'code' => 'fail',
                'msg'  => '退款处理失败，请联系平台管理员。失败原因：'.$ret['errmsg'],
            );
        }
        //清除订单的自动结算
        $trade_redis->delTradeSettledTtl($trade['t_id']);
        //已成功结算的交易,退款
        if ($settled['ts_status'] == self::TRADE_SETTLED_SUCCESS) {
            $title      = "订单{$trade['t_tid']}退款, 扣除余额";
            $store_model->incrementShopBalance($store['es_id'], -floatval($refund['tr_money']));
            //记录支出流水
            $inout_model    = new App_Model_Shop_MysqlShopInoutStorage($this->sid);
            $outdata    = array(
                'si_s_id'   => $this->sid,
                'si_es_id'  => $store['es_id'],
                'si_name'   => $title,
                'si_amount' => $refund['tr_money'],
                'si_balance'=> $balance-floatval($refund['tr_money']),
                'si_type'   => 2,
                'si_create_time'    => time(),
            );
            $inout_model->insertValue($outdata);
        }
        //修改待结算交易为已退款状态
        $updata = array(
            'ts_status'     => self::TRADE_SETTLED_REFUND,
            'ts_update_time'=> time(),
        );
        $settled_model->findUpdateSettled($settled['ts_id'], $updata);
        return TRUE;
    }
    /**
     * 余额支付的退款方式（使用店铺金币）
     * zhangzc
     * 2019-10-29
     * @param  [type] $trade  [订单对象]
     * @param  [type] $refund [退款订单对象]
     * @return [type]         [错误返回错误信息，争取返回TRUE]
     */
    private function goldRefundWay($trade,$refund){
        //增加会员金币
        $res = App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['t_m_id'], $refund['tr_money']);
        if($res){
            $this->_recharge_record($trade,$refund['tr_money']);
        }
        return $res?true:false;
    }

    /**
     * 微信与金币混合支付的退款方式
     * zhangzc
     * 2019-10-29
     * @param  [type] $trade  [订单对象]
     * @param  [type] $refund [退款订单对象]
     * @param  [type] $source [退款来源]
     * @return [type]         [错误返回错误信息，争取返回TRUE]
     */
    private function multiWechatGoldRefundWay($trade,$refund,$source){
        // 判断是否是服务商模式下支付
        $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
        $appcfg = $appletPay_Model->findRowPay();
        if($refund['tr_money'] > $trade['t_payment']){
            $wxRefund = $trade['t_payment'];
            $coinRefund = $refund['tr_money'] - $trade['t_payment'];
        }else{
            $wxRefund = $refund['tr_money'];
            $coinRefund = 0;
        }
        // 服务商退款
        if($appcfg && $appcfg['ap_sub_pay']==1){
            $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
            $ret = $subPay_storage->appletRefundPayOrder($appcfg['ap_appid'],$trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_payment'], $wxRefund, 'wx', $source);
            // 如果服务模式下退款失败，尝试一次普通商户退款
            if($ret['code']!='SUCCESS'){
                $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
                $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_payment'], $wxRefund, 'wx', $source);
            }
            $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
        }else{
            //发起微信退款
            $new_pay    = new App_Plugin_Weixin_NewPay($this->sid);
            $ret = $new_pay->appletRefundPayOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $trade['t_payment'], $wxRefund, 'wx', $source);
            $refund_state   = $ret && $ret['code']=='SUCCESS' ? true : false;
        }
        if($trade['t_es_id'] > 0 && $refund_state){
            $this->afterEntershopRefund($trade,$refund);
        }

        if(!$ret || $ret['code']!='SUCCESS' ){
            if($trade['t_es_id']>0){
                return array(
                    'code' => 'fail',
                    'msg'  => '退款处理失败，请联系平台管理员。失败原因：'.$ret['errmsg'],
                );
            }else{
                return array(
                    'code' => 'fail',
                    'msg'  => $ret['errmsg'],
                );
            }
        }else{
            //增加会员金币
            $res = App_Helper_MemberLevel::goldCoinTrans($this->sid, $trade['t_m_id'], $coinRefund);
            if($res){
                $this->_recharge_record($trade,$coinRefund);
            }
        }
        return $res?true:false;
    }
   
    /**
     * 微财猫的退款方式
     * zhangzc
     * 2019-10-29
     * @param  [type] $trade  [订单对象]
     * @param  [type] $refund [退款订单对象]
     * @return [type]         [错误返回错误信息，争取返回TRUE]
     */
    private function wcmRefundWay($trade,$refund){
        $new_pay    = new App_Plugin_Vcaimao_PayClient($this->sid);
        $ret = $new_pay->tradeRefund($trade['t_pay_trade_no'],round($refund['tr_money']*100),$refund['tr_reason']);
        if(!$ret || $ret['errcode']){
            return array(
                'code' => 'fail',
                'msg'  => '未找到结算,或已退款结算',
            );
        }
        return $ret?true:false;
    }

    /**
     * 支付宝退款方式
     * zhangzc
     * 2019-10-29
     * @param  [type] $trade  [订单对象]
     * @param  [type] $refund [退款订单对象]
     * @return [type]         [错误返回错误信息，争取返回TRUE]
     */
    private function aliPayRefundWay($trade, $refund){
        //发起支付宝退款
        $zfb_pay    = new App_Plugin_Alipaysdk_Client($this->sid);
        // 读取头条小程序-支付宝的配置信息
        $pay_cfg_model=new App_Model_Toutiao_MysqlToutiaoPayStorage($this->sid);
        $pay_cfg=$pay_cfg_model->findRowPay();
        if(!$pay_cfg){
            return array(
                'code' => 'fail',
                'msg'  => '获取支付配置信息失败',
            );
        }
        $pay_config_param=[
            'app_id'                    =>$pay_cfg['atp_alipay_appid'],
            'sign_type'                 =>'RSA2',
            'merchant_private_key'      =>$pay_cfg['atp_alipay_private_key'],
            'alipay_public_key'         =>$pay_cfg['atp_alipay_public_key'],
            'charset'                   =>'UTF-8',
            'format'                    =>'json',
            'gatewayUrl'                =>'https://openapi.alipay.com/gateway.do',
            'MaxQueryRetry'             =>'5',
            'QueryDuration'             =>'3',
        ];

        $ret = $zfb_pay->refundOrder($trade['t_pay_trade_no'], $refund['tr_wid'], $refund['tr_money'],$pay_config_param);

        $refund_state   = $ret['code']=='10000' ? true : false;
        if (!$refund_state) {
            return array(
                'code' => 'fail',
                'msg'  => '退款处理失败，请联系平台管理员。失败原因：'.$ret['errmsg'],
            );
        }
        return $refund_state;
    }
}