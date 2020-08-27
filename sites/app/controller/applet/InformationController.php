<?php

class App_Controller_Applet_InformationController extends App_Controller_Applet_InitController {


    public function __construct() {
        parent::__construct();
    }

    
    public function informationCardAction(){
        $card_storage = new App_Model_Information_MysqlInformationCardStorage($this->sid);
        $cardList = $card_storage->fetchListBySid();
        if($cardList){
            $info = array();
            foreach ($cardList as $val){
                $info['data']['list'][] = array(
                    'id'     => $val['aic_id'],
                    'title'  => $val['aic_title'],
                    'money'  => floatval($val['aic_money']),
                    'type'   => 'member',
                );
            }
            $info['data']['prompt'] = '开通会员可以免费观看所有文章信息';
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未添加付费类型');
        }
    }

    
    public function payForInformationAction(){
        $type = $this->request->getStrParam('type');  //type='member'开通会员  ，type='single' // 单次
        $id = $this->request->getStrParam('id');   //如果type='member' id表示会员类型id，type='single'表示资讯id
        $appid = $this->request->getStrParam('appid');
        $weixin_appid = $this->request->getStrParam('weixin_appid');
        $appletType = $this->request->getIntParam('appletType');
        if($type && $id){
            if($type=='member'){
                // 获取会员卡是否存在
                $card_storage = new App_Model_Information_MysqlInformationCardStorage($this->sid);
                $card = $card_storage->fetchRowById($id);
                if($card && $card['aic_s_id']){
                    $body   = $card['aic_title'];
                    $amount = floatval($card['aic_money']);
                    $notify_url = $this->response->responseHost().'/mobile/wxpay/appletInformationMemberPay';//回调地址
                    $alipay_notify_url = $this->response->responseHost().'/alixcx/alipay/appletInformationMemberPay';//抖音小程序和支付宝小程序
                }else{
                    $this->outputError('参数有误请重试');
                }
            }else{   // 单次付费
                $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
                $row = $information_storage->getRowById($id);
                if($row && $row['ai_price'] > 0){
                    $body   = $row['ai_title'];
                    $amount = floatval($row['ai_price']);
                    $notify_url = $this->response->responseHost().'/mobile/wxpay/appletInformationSinglePay';//回调地址
                    $alipay_notify_url = $this->response->responseHost().'/alixcx/alipay/appletInformationSinglePay';//回调地址
                }else{
                    $this->outputError('参数有误请重试');
                }
            }
            $openid     = $this->member['m_openid'];
            $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
            $attach = array(
                'suid'       => $this->shop['s_unique_id'],
                'mid'        => $this->member['m_id'],
                'id'         => $id,
                'appletType' => 'toutiao'
            );
            $other      = array(
                'attach'    => json_encode($attach),
            );
            if($this->sid==4546 || $this->sid == 4298 || $this->sid == 8298){
                $amount = 0.01;
            }
            $tid    = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->sid);//生成唯一性订单ID
            //微信小程序接口公众号支付
            if($weixin_appid &&  $appletType == 5){
                $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $appletPay         = $pay_model->findRowPay();
                $appletPay['weixin_appid'] = $weixin_appid;
                $has_wxpay  = App_Helper_Trade::checkHasWxpay($this->sid);
                if($has_wxpay){
                    $wx_pay     = new App_Plugin_Weixin_NewPay($this->shop['s_id'],true);
                    $ret        = $wx_pay->unifiedJsapiOrder($openid, $body, $tid, $amount, $notify_url, $other,$appletPay);
                }else{
                    $this->outputError("微信支付发起失败.");
                }

            }else if($appletType == 4){   // 抖音头条小程序支付
                // 获取超时关闭时间
                $over_time     = plum_parse_config('trade_overtime');
                $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
                $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
                $result = $pay_storage->appletOrderPayRecharge($amount, $openid, $tid, $alipay_notify_url, $body, time(), $overTime, $attach);
                if (is_array($result) && !$result['code']) {
                    $params = array(
                        'app_id'      => $result['appid'],
                        'timestamp'   => $result['timestamp'],
                        'trade_no'    => $result['trade_no'],
                        'merchant_id' => $result['biz_content']['merchant_id'],
                        'uid'         => $result['uid'],
                        'total_amount' => $result['biz_content']['total_amount'],
                        'sign_type'   => 'MD5',
                        'params'      => json_encode(array(
                            'url' => $result['params_url']
                        )),
                    );
                    $params['sign']        = $pay_storage::makeToutiaoSign($params,$result['appsecret']);
                    $params['params']      = $result['params_url'];
                    $params['method']      = 'tp.trade.confirm';
                    $params['pay_channel'] = 'ALIPAY_NO_SIGN';
                    $params['pay_type']    = 'ALIPAY_APP';
                    $params['risk_info']   = $result['biz_content']['risk_info'];
                    $this->outputSuccessWithExit($params);
                } else{
                    $this->outputError('支付错误，请稍后重试');
                }
            } else{
                //微信小程序支付
                if($appid){
                    //获取分身小程序信息
                    $child_cfg = new App_Model_Applet_MysqlChildStorage();
                    $child = $child_cfg->fetchUpdateWxcfgByAid($appid);
                }
                $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $appcfg = $appletPay_Model->findRowPay();
                if($child){
                    //$ret = $pay_storage->appletChildOrderPayRecharge($appid,$amount,$openid,$tid,$notify_url,$body,$other);
                    if($appcfg && $appcfg['ap_sub_pay']==1 && $child['ac_mchid']){    // 使用服务商模式下支付
                        $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                        $ret = $subPay_storage->unifiedJsapiOrder($appid,$openid,$amount,$tid,$notify_url,$body,$other,$child['ac_mchid']);
                    }else{
                        $ret = $pay_storage->appletChildOrderPayRecharge($appid,$amount,$openid,$tid,$notify_url,$body,$other);
                    }
                }else{
                    if($appcfg && $appcfg['ap_sub_pay']==1){   // 服务商模式下支付
                        $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                        $ret = $subPay_storage->unifiedJsapiOrder($appid,$openid,$amount,$tid,$notify_url,$body,$other);
                    }else{
                        $ret = $pay_storage->appletOrderPayRecharge($amount,$openid,$tid,$notify_url,$body,$other);
                    }
                    //$ret = $pay_storage->appletOrderPayRecharge($amount,$openid,$tid,$notify_url,$body,$other);
                }
            }
            if ($ret && is_array($ret)) {
                // 将prepay_id保存到数据库
                $params = array(
                    'appId'     => $ret['appid'],
                    'timeStamp' => strval(time()),
                    'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                    'package'   => "prepay_id={$ret['prepay_id']}",
                    'signType'  => 'MD5',
                );
                $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
                $this->outputSuccess(array('data' => $params));
            } else{
                $this->outputError('支付错误，请稍后重试');
            }
        }else{
            $this->outputError('参数错误请稍后重试');
        }
    }

    
    public function informationRewardAction() {
        $curr_id       = $this->request->getIntParam('aid');  //选择打赏的id
        $type        = $this->request->getIntParam('type');  //选择打赏的类型   1资讯 ，2帖子
        $money      = $this->request->getFloatParam('money');//打赏的金额
        $payWay     = $this->request->getIntParam('payWay'); // 支付方式

        $weixin_appid = $this->request->getStrParam('weixin_appid');
        $appletType = $this->request->getIntParam('appletType');

        $pay_type   = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType    = $pay_type->findRowPay();
        if(!$payType){
            $this->outputError('该店铺暂未开启支付.');
        }else if($payType){
            if($appletType==4){
                if($payType['pt_toutiao_pay']==0)
                    $this->outputError('该店铺暂未开启支付宝支付.'.$appletType);
            }else if($payType['pt_wxpay_applet']==0){
                $this->outputError('该店铺暂未开启微信支付.'.$appletType);
            }
        }
        if($payType && in_array($payWay,array(1,3))){
            if($payWay==1){  
                // 判断在线支付是微信还是支付宝（头条使用支付宝）
                // zhangzc
                // 2019-10-30
                // 头条小程序使用支付宝支付
                if($appletType==4){
                    if($payType['pt_toutiao_pay']==0)
                        $this->outputError('该店铺暂未开启支付宝支付');
                }else{//微信支付
                    if($payType['pt_wxpay_applet']==0)
                        $this->outputError('该店铺暂未开启微信支付');
                } 
            }else if($payWay==3 && $payType['pt_coin']==0){  //金币余额支付
                $this->outputError('该店铺暂未开启余额支付');
            }
            $money = floatval($money);
            //打赏金额
            if ($money > 0) {
                $tid         = App_Plugin_Weixin_NewPay::makeMchOrderid($this->shop['s_id']);//生成唯一性订单ID
                //设置订单分佣及通知信息
                $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
                $tcRow         = $copartner_cfg->findShopCfg();
                if($tcRow['tc_copartner_isopen'] == 1){
                    $this->_recharge_copartner_order_deduct($tid, floatval($money), $type==1?6:7);
                }
                // 微信支付
                if($payWay==1 && App_Plugin_Weixin_ClientPlugin::openIDVerify($this->member['m_openid'])){
                    
                    $body        = "{$this->shop['s_name']}打赏{$money}";

                    $attach      = array('suid' => $this->shop['s_unique_id'], 'type' => $type, 'id'=> $curr_id ,'muid' => $this->member['m_id']);
                    $other       = array('attach'    => json_encode($attach));
                    $notify_url  = $this->response->responseHost().'/mobile/wxpay/appletRewardNotify';//回调地址

                    if($appletType == 5){
                        if($this->sid == 12653){
                            Libs_Log_Logger::outputLog('执行公众号支付123','test.log');
                            Libs_Log_Logger::outputLog($this->applet_cfg['ac_appid'],'test.log');
                        }


                        $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                        $appletPay         = $pay_model->findRowPay();
                        $appletPay['weixin_appid'] = $this->applet_cfg['ac_appid'];
                        $wx_pay     = new App_Plugin_Weixin_NewPay($this->shop['s_id'],true);
                        $ret        = $wx_pay->unifiedJsapiOrder($this->member['m_openid'], $body, $tid, $money, $notify_url, $other,$appletPay);
                    }else{
                        $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
                        $ret = $pay_storage->appletOrderPayRecharge($money,$this->member['m_openid'],$tid,$notify_url,$body,$other);
                    }

                    if (is_array($ret)) {
                        $params = array(
                            'appId'     => $ret['appid'],
                            'timeStamp' => strval(time()),
                            'nonceStr'  => App_Plugin_Weixin_PayPlugin::getNonceStr(24),
                            'package'   => "prepay_id={$ret['prepay_id']}",
                            'signType'  => 'MD5',
                        );
                        $params['paySign']  = App_Plugin_Weixin_PayPlugin::makeWxpaySign($params, $ret['app_key']);
                        $params['payWay']    = $payWay;
                        $this->outputSuccess(array('data' => $params));
                    } else {
                        $this->outputError("微信支付发起失败");
                    }
                }else if($appletType == 4){   // 抖音头条小程序支付
                    
                    $body        = "{$this->shop['s_name']}打赏{$money}";

                    $attach      = array('suid' => $this->shop['s_unique_id'], 'type' => $type, 'id'=> $curr_id ,'muid' => $this->member['m_id']);
                    $other       = array('attach'    => json_encode($attach));

                    $alipay_notify_url = $this->response->responseHost().'/alixcx/alipay/appletCardNotify';//回调地址
                    // 获取超时关闭时间
                    $over_time     = plum_parse_config('trade_overtime');
                    $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
                    $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
                    $result = $pay_storage->appletOrderPayRecharge($money, $this->member['m_openid'], $tid, $alipay_notify_url, $body, time(), $overTime, $attach);
                    if (is_array($result) && !$result['code']) {
                        $params = array(
                            'app_id'      => $result['appid'],
                            'timestamp'   => $result['timestamp'],
                            'trade_no'    => $result['trade_no'],
                            'merchant_id' => $result['biz_content']['merchant_id'],
                            'uid'         => $result['uid'],
                            'total_amount' => $result['biz_content']['total_amount'],
                            'sign_type'   => 'MD5',
                            'params'      => json_encode(array(
                                'url' => $result['params_url']
                            )),
                        );
                        $params['sign']        = $pay_storage::makeToutiaoSign($params,$result['appsecret']);
                        $params['params']      = $result['params_url'];
                        $params['method']      = 'tp.trade.confirm';
                        $params['pay_channel'] = 'ALIPAY_NO_SIGN';
                        $params['pay_type']    = 'ALIPAY_APP';
                        $params['risk_info']   = $result['biz_content']['risk_info'];
                        $this->outputSuccessWithExit($params);
                    } else{
                        $this->outputError('支付错误，请稍后重试');
                    }
                }else{
                    if($this->member['m_gold_coin']>=$money){
                        $data = array(
                            'arr_s_id'        => $this->sid,
                            'arr_m_id'        => $this->uid,
                            'arr_type'        => $type,
                            'arr_corr_id'     => $curr_id,
                            'arr_pay_type'    => $payWay,
                            'arr_money'       => $money,
                            'arr_number'      => $tid, //生成唯一性订单ID
                            'arr_create_time' => time()
                        );
                        //减少会员金币
                        $debit = App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$money);
                        if($debit){
                            // 记录打赏记录
                            $reward_storage = new App_Model_Applet_MysqlAppletRewardRecordStorage($this->sid);
                            $ret = $reward_storage->insertValue($data);
                            // 记录余额使用记录
                            App_Helper_MemberLevel::rechargeRecord($this->sid,$data['arr_number'], $this->member['m_id'], $money,'帖子打赏');
                            // 判断打赏类型，如果打赏的是帖子的话，需要给发帖人增加余额
                            if($type==2){
                                $post_model = new App_Model_City_MysqlCityPostStorage($this->sid);
                                $row = $post_model->getRowById($curr_id);
                                // 平台抽成比例
                                $percentage = $this->shop['s_post_percentage'];
                                $account = round($money*(100-$percentage)/100,2) ;
                                // 增加发帖人余额
                                $member_storage = new App_Model_Member_MysqlMemberCoreStorage();
                                $member_storage->addWithdraw($account,$this->sid,$row['acp_m_id']);
                                $data = array(
                                    'dd_s_id'           => $this->sid,
                                    'dd_m_id'           => $row['acp_m_id'],
                                    'dd_o_id'           => $ret,
                                    'dd_amount'         => $account,
                                    'dd_tid'            => $data['arr_number'],
                                    'dd_inout_put'      => 2,
                                    'dd_level'          => 0,
                                    'dd_record_type'    => 4,
                                    'dd_record_time'    => time(),
                                    'dd_record_remark'  => '帖子打赏收入'
                                );
                                $book_model = new App_Model_Deduct_MysqlDeductDaybookStorage();
                                $book_ret = $book_model->insertValue($data);

                                //帖子打赏，发送模板消息
                                plum_open_backend('templmsg', 'postRewardTempl', array('sid' => $this->sid, 'id' => $ret,'appletType' => $this->appletType));
                            }
                            //是否开通分销功能
                            $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
                            $order_deduct->completeOrderDeduct($tid, $this->member['m_id']);
                            $info['data'] = array(
                                'payWay'   => $payWay,
                                'result' => true,
                                'msg'    => '打赏成功'
                            );
                            $this->outputSuccess($info);
                        }else{
                            $this->outputError('打赏失败');
                        }
                    }else{
                        $this->outputError('账户余额不足');
                    }
                }
            }else{
                $this->outputError("打赏金额不合法");
            }
        }else{
            $this->outputError('该店铺暂未开启支付功能');
        }
    }

    
    private function _recharge_copartner_order_deduct($tid, $total, $type) {

        $goods_deduct   = new App_Model_Goods_MysqlDeductStorage($this->sid);
        $order_deduct   = new App_Helper_OrderDeduct($this->sid);

        //使用店铺分佣设置
        $ratio  = $this->_deduct_copartner_translate();
        Libs_Log_Logger::outputLog($ratio);
        //设置商品分佣
        $order_deduct->createOrderDeduct($this->member['m_id'], $tid, $total, $ratio, 0, $type);
    }

    
    private function _deduct_copartner_translate() {
        $three_level  = App_Helper_ShopWeixin::checkShopThreeLevel($this->sid);
        $member_storage   = new App_Model_Member_MysqlMemberCoreStorage();
        $member     = $member_storage->getRowById($this->uid);
        $deduct_model   = new App_Model_Copartner_MysqlCopartnerDeductCfgStorage();
        $data = array();
        for ($i=0; $i<=$three_level; $i++) {
            $tmp    = "{$i}f";
            //购买人或其上级存在
            $benefit    = $i == 0 ? $member['m_id'] : $member["m_{$tmp}_id"];
            $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
            $extra = $extra_model->findUpdateExtraByMid($benefit);
            $deduct_list    = $deduct_model->fetchDeductListBySid($this->sid, $extra['ame_copartner']);
            $deduct = $deduct_list[1];
            $data[$i] = $deduct['cdc_'.$i.'f_ratio'];
        }
        return $data;
    }


    
    public function rewardRecordListAction(){
        $currId = $this->request->getIntParam('currId');
        $type = $this->request->getIntParam('type');
        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $reward_storage = new App_Model_Applet_MysqlAppletRewardRecordStorage($this->sid);
        $where = array();
        $where[] = array('name'=>'arr_s_id','oper'=>'=','value'=>$this->sid);
        $where[] = array('name'=>'arr_type','oper'=>'=','value'=>$type);
        $where[] = array('name'=>'arr_corr_id','oper'=>'=','value'=>$currId);
        $sort = array('arr_create_time'=>'DESC');
        $list = $reward_storage->fetchRewardMemberList($where,$index,$this->count,$sort);
        $count = $reward_storage->getCount($where);
        $info['data'] = array(
            'count' => $count
        );
        if($list){
            foreach ($list as $value){
                $info['data']['list'][] = array(
                    'mid'      => $value['m_id'],
                    'nickname' => $value['m_nickname'],
                    'avatar'   => $value['m_avatar'] ? $value['m_avatar'] : $this->dealImagePath('/public/wxapp/images/applet-avatar.png'),
                    'money'    => $value['arr_money'],
                    'time'     => date('Y-m-d H:i',$value['arr_create_time']),
                    'arrId'    => $value['arr_id']
                );
            }
        }else{
            $info['data']['list'] = [];
        }
        if($count>0){
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂无打赏');
        }
    }

}