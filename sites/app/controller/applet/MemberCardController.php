<?php


class App_Controller_Applet_MemberCardController extends App_Controller_Applet_InitController
{
    //生成图片存储实际路径
    private $hold_dir;
    //生成图片访问路径
    private $access_path;

    public function __construct()
    {
        parent::__construct();
        $this->hold_dir     = PLUM_APP_BUILD.'/spread/';
        $this->access_path  = PLUM_PATH_PUBLIC.'/build/spread/';

    }
  
  
    	  /*
    * 微信下单
    */
    public function  payCardOrderAction() {
        $tid = $this->request->getStrParam('tid');
        $weixin_appid = $this->request->getStrParam('weixin_appid');
        $appletType = $this->request->getIntParam('appletType');
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType = $pay_type->findRowPay();
        if(!$payType || ($appletType==1 && $payType && $payType['pt_wxpay_applet']==0)){
            $this->outputError('该店铺暂未开启在线支付');
        }
        $order_storage  = new App_Model_Store_MysqlOrderStorage($this->sid);
        $order      = $order_storage->findUpdateOrderByTid($tid);
        if($order){
            $body   = $order['oo_title'];
            $amount = floatval($order['oo_amount']);
            $openid     = $order['oo_openid'];
            $pay_storage = new App_Plugin_Weixin_NewPay($this->sid);
            $notify_url = $this->response->responseHost().'/mobile/wxpay/appletCardNotify';//回调地址
            $attach = array(
                'suid'  => $this->shop['s_unique_id'],
                'mid'   => $this->member['m_id'],
                'esId'  => $order['oo_es_id'],
                'type'  => 'buycard',   // 购买会员卡
                'appletType' => 'toutiao'
            );
            $other      = array(
                'attach'    => json_encode($attach),
            );

            if($this->member['m_id']==5623429 || $this->member['m_id']==5754194){
                $amount = 0.01;
            }
            $amount = 0.01;
            if($weixin_appid &&  $appletType == 5){
                $pay_model      = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $appletPay         = $pay_model->findRowPay();
                $appletPay['weixin_appid'] = $weixin_appid;
                $has_wxpay  = App_Helper_Trade::checkHasWxpay($this->sid,1);
                if($has_wxpay){
                    $wx_pay     = new App_Plugin_Weixin_NewPay($this->shop['s_id']);
                    $ret        = $wx_pay->unifiedJsapiOrder($openid, $body, $tid, $amount, $notify_url, $other);
                }else{
                    $this->outputError("微信支付发起失败.");
                }
            }else if($appletType == 3){
                $attach['orderType'] = 'buycard';
                unset($attach['appletType']);

                $alipay_notify_url = $this->response->responseHost().'/alixcx/alipay/appletCardNotify';//回调地址
                $result = App_Helper_PayType::Alipay($this->sid,$tid,$amount,$body,$attach,$alipay_notify_url,$openid);

                if(is_array($result)){
                    $this->outputSuccessWithExit($result);
                }else{
                    $this->outputError($result);
                }
            }else if($appletType == 4){   // 抖音头条小程序支付
                $alipay_notify_url = $this->response->responseHost().'/alixcx/alipay/appletCardNotify';//回调地址
                // 获取超时关闭时间
                $over_time     = plum_parse_config('trade_overtime');
                $overTime = $this->shop['s_close_trade'] && $this->shop['s_close_trade'] > 0 ? $this->shop['s_close_trade']*60 : $over_time['close'];
                $pay_storage = new App_Plugin_Toutiao_Pay($this->sid);
                $result = $pay_storage->appletOrderPayRecharge($amount, $openid, $tid, $alipay_notify_url, $body, $order['oo_create_time'], $overTime, $attach);
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
                $appletPay_Model = new App_Model_Applet_MysqlAppletPayStorage($this->sid);
                $appcfg = $appletPay_Model->findRowPay();
                if($appcfg && $appcfg['ap_sub_pay']==1){   // 服务商模式下支付
                    Libs_Log_Logger::outputLog(111,'wxpay.log');
                    $subPay_storage = new App_Plugin_Weixin_AppletSubPay($this->sid);
                    $ret = $subPay_storage->unifiedJsapiOrder($this->applet_cfg['ac_appid'],$openid,$amount,$tid,$notify_url,$body,$other);
                }else{
                    Libs_Log_Logger::outputLog(222,'wxpay.log');
                    $ret = $pay_storage->appletOrderPayRecharge($amount,$openid,$tid,$notify_url,$body,$other);
                }
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
                $this->outputSuccess(array('data' => $params));
            } else{
                $this->outputError('支付错误，请稍后重试');
            }
        }else{
            $this->outputError('创建订单失败');
        }
    }
  
    
      /**
     * 会员卡详情
     */
    public function memberCardDetailsAction(){
        $cardid = $this->request->getIntParam('cardid');
        if($cardid){
            $color = plum_parse_config('offline_color','app');
            $cardType = plum_parse_config('offline_card_new','app');
            $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
            $row = $card_model->getRowByIdSid($cardid,$this->sid);
            if($row){
                $info['data'] = $this->_format_card_details($row,$cardType,$color);
                $this->outputSuccess($info);
            }else{
                $this->outputError('该卡券不存在或已删除');
            }
        }else{
            $this->outputError('获取信息失败');
        }
    }
  
   /**
     * 会员卡列表
     */
    public function cardListAction(){
        $type = $this->request->getIntParam('type', 1);
        $where      = array();
        $where[]    = array('name' => 'oc_type', 'oper' => '=', 'value' => $type);
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->sid);
        $where[]    = array('name' => 'oc_deleted','oper' => '=','value' =>0);
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
        $sort   = array('oc_weight' => 'DESC', 'oc_price' => 'ASC', 'oc_long_type' => 'ASC','oc_update_time' => 'DESC');
        $list   = $card_model->getListLevel($where,0,0,$sort);
        $info = array();
        if($list){
            $color = plum_parse_config('offline_color','app');
            //$cardType = plum_parse_config('offline_card','app');
            $cardType = plum_parse_config('offline_card_new','app');

            $om_model = new App_Model_Store_MysqlMemberStorage($this->sid);
            $where_card[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
            $where_card[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where_card[]    = array('name' => 'om_type', 'oper' => '=', 'value' => $type);
            $where_card[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
            $card_now    = $om_model->getList($where_card, 0, 1, array('om_update_time' => 'desc'))[0];
            $level_model = new App_Model_Member_MysqlLevelStorage();
            $level_now   = $level_model->getRowById($card_now['om_curr_id']);

            foreach ($list as $val){
                if($val['oc_hidden']!=1){
                    $info['data'][] = $this->_format_card_details($val,$cardType,$color,$card_now,$level_now);
                }
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    
    private function _format_card_details($val,$cardType,$color,$card_now = [],$level_now = []){
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $member_card    = $offline_member->getStoreMemberInfo($this->member['m_id'], 2);
        $data = array();
        if(!empty($val) && $val){
            $logo = $this->shop['s_logo']? $this->shop['s_logo']:'/public/manage/applet/temp2/images/sy_20.png';
            $data = array(
                'hadBuy'       => false,
                'id'           => $val['oc_id'],
                'name'         => $val['oc_name'],
                'shopLogo'     => $this->dealImagePath($logo),
                'shopName'     => $this->shop['s_name'],
                'nameSub'      => $val['oc_name_sub'],
                'bgType'       => $val['oc_bg_type'],
                'bgColor'      => $color[$val['oc_bg_type']]['color'],
                'backgroundColor' => $val['oc_background_color'] ? $val['oc_background_color'] : '',
                //'long'         => $val['oc_long'],
                //'longShow'     => '有效期'.$val['oc_long'].'天',
                'long'         => $cardType[$val['oc_long_type']]['long'],
                'longShow'     => '有效期'.$cardType[$val['oc_long_type']]['long'].'天',
                'longType'     => $val['oc_long_type'],
                'longTypeShow' => $cardType[$val['oc_long_type']]['name'],
                'price'        => $val['oc_price']>0 ? $val['oc_price'] : 0,
                'times'        => $val['oc_times'],
                'identity'     => $val['oc_identity'],
                'rights'       => str_replace("<br/>", "\n",$val['oc_rights']),
                'notice'       => str_replace("<br/>", "\n",$val['oc_notice']),
                'updateTime'   => date('Y-m-d',$val['oc_update_time']),
                'returnPrice'  => $val['oc_return_price'],
                'isIdentity'     => $val['oc_identity'] && $val['ml_id']>0 ? 1 : 0,
                'levelName'      => isset($val['ml_name']) && $val['ml_name'] ? $val['ml_name'] : '',
                'levelDesc'      => isset($val['ml_desc']) && $val['ml_desc'] ? $val['ml_desc'] : '',
                'levelDiscount'  => isset($val['ml_discount']) && $val['ml_discount'] ? $val['ml_discount'] : '',
                'levelDiscountShow'  => isset($val['ml_discount']) && $val['ml_discount'] ? '享'.$val['ml_discount'].'折' : '',
                'backgroundImg'  => $this->dealImagePath('/public/wxapp/images/memberCard1.png'),
                'levelCanBuy'    => true,

            );

            if($card_now && $val['oc_identity'] && $card_now['om_curr_id'] && $val['oc_id'] != $card_now['om_card_id']){
                if($level_now['ml_weight'] > $val['ml_weight']){
                    $data['levelCanBuy'] = false;
                }
            }


            $order_model = new App_Model_Store_MysqlOrderStorage($this->sid);
            $openNum = $order_model->getOpenNum($val['oc_id']);

            $data['buyNum'] = $openNum + $val['oc_add_open_num'];

            if(!$member_card){
                $data['type'] = 1;
            }
            if($member_card['om_card_id'] == $val['oc_id']){
                $data['hadBuy'] = true;
                $data['hadExpire'] = $member_card['om_expire_time']<time()?true:false;
                $data['expireTime'] = date('Y.m.d', $member_card['om_expire_time']);
                $data['cardNum'] = $member_card['om_card_num'];
                $data['type'] = 2;
            }

            if($member_card && $member_card['om_card_id'] != $val['oc_id']){
                $data['type'] = 3;
            }
        }
        return $data;
    }

    
    private function _format_store_details($row){
        $data = array();
        if(!empty($row) && $row){
            $data = array(
                'id'        => $row['os_id'],
                'name'      => $row['os_name'],
                'address'   => $row['os_addr'],
                'lat'       => $row['os_lat'],
                'lng'       => $row['os_lng'],
                'mobile'    => $row['os_contact'],
                'openTime'  => $row['os_open_time'],
                'closeTime' => $row['os_close_time'],
                'recommend' => $row['os_recommend'],
                'feature'   => $row['os_feature'],
                'distance'  => isset($row['distance']) ? ($row['distance']<1 ? floor(1000*$row['distance']).'m' : round($row['distance'],2).'km' ): 0,
            );
        }
        return $data;
    }

    
    private function _format_city_store_details($row){
        $data = array();
        if(!empty($row) && $row){
            $openTime = explode('-',$row['acs_open_time']);
            $data = array(
                'id'        => $row['acs_id'],
                'name'      => $row['acs_name'],
                'address'   => $row['acs_address'],
                'lat'       => $row['acs_lat'],
                'lng'       => $row['acs_lng'],
                'mobile'    => $row['acs_mobile'],
                'openTime'  => $openTime[0] ? $openTime[0] : '00:00',
                'closeTime' => $openTime[1] ? $openTime[1] : '23:59',
                'recommend' => '',
                'feature'   => $row['acs_brief'],
                'distance'  => isset($row['distance']) ? ($row['distance']<1 ? floor(1000*$row['distance']).'m' : round($row['distance'],2).'km' ): 0,
            );
        }
        return $data;
    }

    public function memberInfoAction(){
        $cardType = $this->request->getIntParam('type',2);
        //获取开通的会员信息
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $member_card    = $offline_member->getStoreMemberInfo($this->member['m_id']);

        //获取页面设置
        $config_model   = new App_Model_Store_MysqlStoreCfgStorage($this->sid);
        $offcfg     = $config_model->fetchUpdateCfg();
        //消费次数
        $verify_model   = new App_Model_Store_MysqlVerifyStorage($this->sid);
        $verify     = $verify_model->getCountByMid($this->member['m_id'],'card');

        //创建新订单
        $order_storage  = new App_Model_Store_MysqlOrderStorage($this->sid);
        $where[] = array('name' => 'oo_card_type', 'oper' => '=', 'value' => $cardType);
        $where[] = array('name' => 'oo_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $orderList = $order_storage->getList($where, 0,0, array('oo_create_time' => 'desc'));
        $order = $orderList[0];

        //获取等级类型
        $member_level = new App_Model_Member_MysqlLevelStorage();
        $levelList = $member_level->getListBySid($this->sid);

        $info = array();
        $info['data'] = array(
            'avatar'   => $this->dealImagePath($this->member['m_avatar']),
            'nickname' => $this->member['m_nickname'],
            'showId'   => $this->member['m_show_id'],
            'point'    => $this->member['m_points'],
            'verify'  => $verify,
            'background' => $this->dealImagePath($offcfg['oc_bg']),
            'name' => $order['oo_name'],
            'gender' => $order['oo_gender'],
            'birthday' => $order['oo_birthday'],
            'telphone' => $order['oo_telphone'],
            'company'  => $order['oo_company'] ? $order['oo_company'] : '',
            'position' => $order['oo_position'] ? $order['oo_position'] : '',
            'coin' => $this->member['m_gold_coin'],
            'left' => $member_card?$member_card['om_left_num']:0,
            'cardType' => 0,
            'cardName' => '',
            'cardColor' => '',
            'cardColorType' => 0,
            'cardDiscount' => '',
            'cardRights' => '',
            'cardNotice' => ''
        );
        $color = plum_parse_config('offline_color','app');
        if($member_card){
            $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
            $card_row = $card_model->getRowById($member_card['om_card_id']);
            $info['data']['cardRights'] = $card_row['oc_rights'];
            $info['data']['cardNotice'] = $card_row['oc_notice'];
            $info['data']['cardType'] = intval($card_row['oc_type']);
            $info['data']['cardName'] = $card_row['oc_name'];

            if($card_row['oc_type'] == 1){
                $info['data']['cardColor'] = $color[$card_row['oc_bg_type']]['color'];
            }else{
                $info['data']['cardColor'] = $card_row['oc_background_color'] ? $card_row['oc_background_color'] : '';
            }

            $info['data']['cardColorType'] = $card_row['oc_bg_type'];

            if($card_row['oc_identity'] > 0){
                $level_row = $levelList[$card_row['oc_identity']];
                if($level_row['ml_discount'] > 0){
                    $info['data']['cardDiscount'] = $level_row['ml_discount'].'折';
                }
            }
        }



        if($this->sid == 10380){
            if($member_card){
                $info['data']['cardId'] = intval($member_card['om_card_id']);
            }else{
                $where_card = [];
                $where_card[]    = array('name' => 'oc_type', 'oper' => '=', 'value' => 1);
                $where_card[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->sid);
                $where_card[]    = array('name' => 'oc_deleted','oper' => '=','value' =>0);
                $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
                $sort   = array('oc_weight' => 'DESC', 'oc_price' => 'ASC', 'oc_long_type' => 'ASC','oc_update_time' => 'DESC');
                $list   = $card_model->getListLevel($where_card,0,1,$sort);
                $first_card = $list[0];
                if($first_card){
                    $info['data']['cardId'] = intval($first_card['oc_id']);
                }else{
                    $info['data']['cardId'] = 0;
                }
            }
        }

        if($this->applet_cfg['ac_type'] == 28){ //招聘公司
            $bind_model = new App_Model_Job_MysqlJobBindStorage($this->sid);
            $bind = $bind_model->verifyLogin($this->member['m_id']);

            $es_model   = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
            $enterShop  = $es_model->getRowById($bind['ajb_es_id']);
            //判断会员余额是否足够支付
            $coin   = floatval($enterShop['es_balance']);
            $info['data']['coin'] = $coin;
        }

        if ($member_card && $member_card['om_expire_time'] > time()) {
            $info['data']['tip']         =  '续费';
            $info['data']['memberType']  =  isset($levelList[$member_card['om_curr_id']]['ml_name']) && $levelList[$member_card['om_curr_id']]['ml_name'] ? $levelList[$member_card['om_curr_id']]['ml_name'] : $member_card['om_curr_id'];
            $info['data']['expireTime']  = date("Y-m-d", $member_card['om_expire_time']);
            $info['data']['hadExpire']   = false;
            if($this->sid == 10380 && $member_card['om_curr_id'] == 0){
                $info['data']['memberType'] = '个人';
            }
        } else {
            $info['data']['tip']         =  '开通会员';
            $info['data']['memberType']  =  '未开通';
            $info['data']['expireTime']  = $member_card ? '已到期,请续费' : '未开通VIP';
            $info['data']['hadExpire']   = $member_card ? true : false;
        }
        $this->outputSuccess($info);
    }

    
    public function buyRenewCardAction(){
        $cardid = $this->request->getIntParam('cardid');    // 会员卡ID
        $stid   = $this->request->getIntParam('stid', 0);   // 门店ID
        $name   = $this->request->getStrParam('name');
        $gender = $this->request->getIntParam('gender');
        $birthday = $this->request->getStrParam('birthday');
        $telphone = $this->request->getStrParam('telphone');
        $company = $this->request->getStrParam('company');
        $position = $this->request->getStrParam('position');
        $invoice = $this->request->getIntParam('invoice',0);
        $companyName = $this->request->getStrParam('companyName');
        $companyCode = $this->request->getStrParam('companyCode');
        $type   = $this->request->getIntParam('type');
        $payType = $this->request->getIntParam('payType', 1);  //支付方式  1微信支付 2余额支付 3积分支付
        $remark = $this->request->getStrParam('remark');
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
        $card   = $card_model->getShopOneCard($cardid);
        //添加隐藏会员卡不在前台显示的判断
        //zhangzc
        //2019-10-07
        if($card && $card['oc_hidden']!=1){
            if($telphone && !plum_is_mobile_phone($telphone) && $this->sid!=7448){   // 马耳他智慧生活是国外使用，手机号不再做验证
                $this->outputError('请输入正确的手机号码');
            }

            //获得用户当前会员卡 防止降级购买
            $om_model = new App_Model_Store_MysqlMemberStorage($this->sid);
            $where[]    = array('name' => 'om_s_id', 'oper' => '=', 'value' => $this->sid);
            $where[]    = array('name' => 'om_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
            $where[]    = array('name' => 'om_type', 'oper' => '=', 'value' => $card['oc_type']);
            $where[]    = array('name' => 'om_expire_time', 'oper' => '>', 'value' => time());
            $card_now    = $om_model->getList($where, 0, 1, array('om_update_time' => 'desc'))[0];
            //当前存在未过期的会员卡并且存在等级且当前购买与现有不同
            if($card_now && $card['oc_identity'] && $card_now['om_curr_id'] && $card['oc_id'] != $card_now['om_card_id']){
                $level_model = new App_Model_Member_MysqlLevelStorage();
                $level_card = $level_model->getRowById($card['oc_identity']);
                $level_now = $level_model->getRowById($card_now['om_curr_id']);
                if($level_now['ml_weight'] > $level_card['ml_weight']){
                    $this->outputError('不能降级购买会员卡');
                }
            }

            if($this->applet_cfg['ac_type'] == 28){
                //招聘获取购买人公司店铺id
                $bind_model = new App_Model_Job_MysqlJobBindStorage($this->sid);
                $bind = $bind_model->verifyLogin($this->member['m_id']);
                if(!$bind){
                    $this->outputError('请先登录公司');
                }
            }
            $desc = '';
            if($type == 1){
                $desc = '开卡-'.$card['oc_name'];
            }
            if($type == 2){
                $desc = '续费-'.$card['oc_name'];
            }
            if($type == 3){
                $desc = '升级-'.$card['oc_name'];
            }
            if($payType == 3){
                $desc = '积分兑换-'.$card['oc_name'];
            }
            $tid    = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->sid);//生成唯一性订单ID
            $indata = array(
                'oo_s_id'       => $this->sid,
                'oo_es_id'      => $bind['ajb_es_id'],
                'oo_card_type'  => $card['oc_type'],
                'oo_m_id'       => $this->member['m_id'],
                'oo_cardid'     => $cardid,
                'oo_st_id'      => $stid,
                'oo_buyer_nick' => $this->member['m_nickname'],
                'oo_openid'     => $this->member['m_openid'],
                'oo_title'      => $card['oc_name'],
                'oo_tid'        => $tid,
                'oo_points'     => $card['oc_points'],
                'oo_amount'     => floatval($card['oc_price']),
                'oo_name'       => $name,
                'oo_gender'     => $gender,
                'oo_birthday'   => $birthday,
                'oo_telphone'   => $telphone,
                'oo_company'    => $company,
                'oo_position'    => $position,
                'oo_status'     => 0,
                'oo_pay_type'   => $payType,
                'oo_desc'       => $desc,
                'oo_remark'     => $remark,
                'oo_create_time'=> time(),
            );
            if(($this->sid == 4230 || $this->sid == 10380) && $invoice > 0){
                $tradeExtra['invoice'] = $invoice;
                $tradeExtra['companyName'] = $companyName;
                $tradeExtra['companyCode'] = $companyCode;
                $trade_extra = json_encode($tradeExtra,JSON_UNESCAPED_UNICODE);
                $indata['oo_trade_extra'] = $trade_extra;
            }

            //创建新订单
            $order_storage  = new App_Model_Store_MysqlOrderStorage($this->sid);
            $ret = $order_storage->insertValue($indata);
            if($ret){
                //设置订单分佣及通知信息
                if($payType != 3){
                    $copartner_cfg  = new App_Model_Three_MysqlCfgStorage($this->sid);
                    $tcRow         = $copartner_cfg->findShopCfg();
                    if($tcRow['tc_copartner_isopen'] == 1){
                        $this->_recharge_copartner_order_deduct($tid, floatval($card['oc_price']), intval($card['oc_type'] + 1));
                    }else{
                        // 预约服务小程序会员卡分销方式
                        // zhangzc
                        // 2019-08-19
                        if($this->applet_cfg['ac_type']==18){ 
                            // 查看此会员卡购买了多少次
                            // 此处的购买次数应该加1才算是当前总共购买的次数
                            $buy_times=$order_storage->getCount([
                                ['name'=>'oo_s_id','oper'=>'=','value'=>$this->sid],
                                ['name'=>'oo_cardid','oper'=>'=','value'=>$cardid],
                                ['name'=>'oo_status','oper'=>'=','value'=>2],
                                ['name'=>'oo_pay_type','oper'=>'!=','value'=>3],
                            ]);
                            // 会员卡分销开启则执行分销操作
                            $this->_recharge_order_deduct_yuyue($tid, floatval($card['oc_price']),$buy_times+1,$tcRow['tc_card_deduct']);

                        }else{

                           // $this->_recharge_order_deduct($tid, floatval($card['oc_price']), intval($card['oc_type'] + 1));
                        }
                       
                    }
                }
                if($payType == 1 && $card['oc_price']>0){   // 在线支付必须金额大于0才能支付
                    $logo = $this->shop['s_logo']? $this->shop['s_logo']:'/public/manage/applet/temp2/images/sy_20.png';
                    $info['data'] = array(
                        'status'  =>'dzf',
                        'tid'     => $tid,
                        'title'   => $card['oc_name'],
                        'amount'  => floatval($card['oc_price']),
                        'logo'    => $this->dealImagePath($logo),
                    );
                }elseif($payType == 3){  //积分兑换会员卡
                    //判断会员积分是否足够支付
                    $points = floatval($this->member['m_points']);
                    $fee    = floatval($card['oc_points']);//订单总积分
                    // 判断是否需要支付，0元之间设置会员等级
                    if ($fee > $points) {
                        $this->outputError("积分不足");
                    }

                    //扣除积分并记录支积分支出
                    $title  = "兑换余额";
                    $point_helper   = new App_Helper_Point($this->shop['s_id']);
                    $point_helper->memberPointRecord($this->member['m_id'], $fee, $title, App_Helper_Point::POINT_INOUT_OUTPUT, App_Helper_Point::POINT_SOURCE_EXCHANGE_CARD, '');

                    //修改订单状态
                    $updata = array(
                        'oo_status'     => 2,
                        'oo_outer_tid'  => '',
                        'oo_pay_time'   => time()
                    );
                    $order_storage->findUpdateOrderByTid($tid, $updata);
                    //订单活动后续处理 设置会员购买的VIP
                    App_Helper_MemberLevel::setMemberCard($this->member['m_id'], $cardid, $this->shop['s_id'],0,$tid);
                    $logo = $this->shop['s_logo']? $this->shop['s_logo']:'/public/manage/applet/temp2/images/sy_20.png';
                    //发送模板消息
                    plum_open_backend('templmsg', 'memberCardTempl', array('sid' => $this->sid, 'id' => $tid,'appletType' => $this->appletType));
                    $info['data'] = array(
                        'status'  =>'zfcg',
                        'tid'     => $tid,
                        'title'   => $card['oc_name'],
                        'amount'  => floatval($card['oc_points']),
                        'logo'    => $this->dealImagePath($logo),
                    );
                }elseif($this->applet_cfg['ac_type'] == 28){ //招聘公司
                    $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
                    $payCfg = $pay_type->findRowPay();
                    if(!$payCfg || ($payCfg && $payCfg['pt_coin']==0)){
                        $this->outputError('该店铺暂未开启余额支付');
                    }
                    $es_model   = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
                    $enterShop  = $es_model->getRowById($bind['ajb_es_id']);
                    //判断会员余额是否足够支付
                    $coin   = floatval($enterShop['es_balance']);
                    $fee    = floatval($card['oc_price']);    //支付总费用
                    if ($fee > $coin) {
                        $this->outputError("账户余额不足");
                    }
                    $updata = array(
                        'oo_status'     => 2,
                        'oo_outer_tid'  => $ret['transaction_id'],
                        'oo_pay_time'   => time()
                    );
                    $order_storage->findUpdateOrderByTid($tid, $updata);
                    //减少店铺余额
                    $es_model    = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
                    $set = array('es_balance' => ($enterShop['es_balance']-$fee));
                    $debit = $es_model->updateById($set, $enterShop['es_id']);
                    //增加积分
                    $point_storage = new App_Helper_Point($this->sid);
                    $point_storage->gainPointBySource($this->member['m_id'],App_Helper_Point::POINT_SOURCE_OPEN_MEMBER);
                    // 记录使用记录
                    App_Helper_MemberLevel::enterShopRechargeRecord($this->sid,$tid, $this->member['m_id'], $enterShop['es_id'],$fee, 2, 2, '购买会员卡');
                    if($debit){
                        //设置会员购买的VIP
                        App_Helper_MemberLevel::setMemberCard($this->member['m_id'], $cardid, $this->shop['s_id'], $enterShop['es_id'],$tid);
                        $logo = $this->shop['s_logo']? $this->shop['s_logo']:'/public/manage/applet/temp2/images/sy_20.png';
                        //发送模板消息
                        plum_open_backend('templmsg', 'memberCardTempl', array('sid' => $this->sid, 'id' => $tid));
                        $info['data'] = array(
                            'status'  =>'zfcg',
                            'tid'     => $tid,
                            'title'   => $card['oc_name'],
                            'amount'  => floatval($card['oc_price']),
                            'logo'    => $this->dealImagePath($logo),
                        );
                    }
                }else{
                    $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
                    $payCfg = $pay_type->findRowPay();
                    if(!$payCfg || ($payCfg && $payCfg['pt_coin']==0)){
                        $this->outputError('该店铺暂未开启余额支付');
                    }
                    //判断账户余额是否冻结
                    if($this->member['m_gold_freeze']){
                        $this->outputError('账户已被冻结，请联系管理员');
                    }
                    //判断会员余额是否足够支付
                    $coin   = floatval($this->member['m_gold_coin']);
                    $fee    = floatval($card['oc_price']);//订单总价格
                    $updata = array(
                        'oo_status'     => 2,
                        'oo_outer_tid'  => $ret['transaction_id'],
                        'oo_pay_time'   => time()
                    );
                    // 判断是否需要支付，0元之间设置会员等级
                    if($fee > 0){
                        if ($fee > $coin) {
                            $this->outputError("账户余额不足");
                        }
                        //减少会员金币
                        $debit = App_Helper_MemberLevel::goldCoinTrans($this->sid, $this->member['m_id'], -$fee);
                        if($debit){
                            // 记录使用记录
                            App_Helper_MemberLevel::rechargeRecord($this->sid,$tid, $this->member['m_id'], $fee);
                            $order_storage->findUpdateOrderByTid($tid, $updata);
                            //订单活动后续处理
                            //设置会员购买的VIP
                            App_Helper_MemberLevel::setMemberCard($this->member['m_id'], $cardid, $this->shop['s_id'],0,$tid);
                            //增加成交订单数量及金额
                            $member_model   = new App_Model_Member_MysqlMemberCoreStorage();
                            $member_model->incrementMemberTrade($this->member['m_id'], floatval($card['oc_price']), 1);
                            //是否开通分销功能
                            $order_deduct   = new App_Helper_OrderDeduct($this->shop['s_id']);
                            $order_deduct->completeOrderDeduct($tid, $this->member['m_id']);
                            $logo = $this->shop['s_logo']? $this->shop['s_logo']:'/public/manage/applet/temp2/images/sy_20.png';
                            //发送模板消息
                            plum_open_backend('templmsg', 'memberCardTempl', array('sid' => $this->sid, 'id' => $tid));
                            $info['data'] = array(
                                'status'  =>'zfcg',
                                'tid'     => $tid,
                                'title'   => $card['oc_name'],
                                'amount'  => floatval($card['oc_price']),
                                'logo'    => $this->dealImagePath($logo),
                            );
                        }
                    }else{
                        $order_storage->findUpdateOrderByTid($tid, $updata);
                        //订单活动后续处理
                        //设置会员购买的VIP
                        App_Helper_MemberLevel::setMemberCard($this->member['m_id'], $cardid, $this->shop['s_id'],0,$tid);
                        //增加积分
                        $point_storage = new App_Helper_Point($this->sid);
                        $point_storage->gainPointBySource($this->member['m_id'],App_Helper_Point::POINT_SOURCE_OPEN_MEMBER);

                        $logo = $this->shop['s_logo']? $this->shop['s_logo']:'/public/manage/applet/temp2/images/sy_20.png';
                        //发送模板消息
                        plum_open_backend('templmsg', 'memberCardTempl', array('sid' => $this->sid, 'id' => $tid,'appletType' => $this->appletType));
                        $info['data'] = array(
                            'status'  =>'zfcg',
                            'tid'     => $tid,
                            'title'   => $card['oc_name'],
                            'amount'  => floatval($card['oc_price']),
                            'logo'    => $this->dealImagePath($logo),
                        );

                    }
                }

                $extra_model = new App_Model_Member_MysqlMemberExtraStorage($this->sid);
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member_extra = $extra_model->findUpdateExtraByMid($this->member['m_id']);
                $update = [];
                $brith = '';
                if(!$this->member['m_mobile'] && $telphone){
                    $update['m_mobile'] = $telphone;
                }
                if(!$this->member['m_realname'] && $name){
                    $update['m_realname'] = $name;
                }
                if(!$member_extra['ame_birth'] && $birthday && $birthday != 'null'){
                    $brith = $birthday;
                }
                if(!empty($update)){
                    $member_model->updateById($update,$this->member['m_id']);
                }
                if($brith){
                    if($member_extra){
                        $extra_model->findUpdateExtraByMid($this->member['m_id'],['ame_birth' => $brith,'ame_update_time'=>time()]);
                    }else{
                        $extra_data = [
                            'ame_s_id' => $this->sid,
                            'ame_m_id' => $this->member['m_id'],
                            'ame_birth' => $birthday,
                            'ame_create_time' => time(),
                            'ame_update_time' => time(),
                        ];
                        $extra_model->insertValue($extra_data);
                    }

                }

                $this->outputSuccess($info);
                //$this->_pay_crad_order($tid);
            }else{
                $this->outputError('下单失败');
            }

        }else{
            $this->outputError('门店会员卡不存在');
        }
    }

    
    private function _recharge_copartner_order_deduct($tid, $total, $type) {

        $goods_deduct   = new App_Model_Goods_MysqlDeductStorage($this->sid);
        $order_deduct   = new App_Helper_OrderDeduct($this->sid);

        //使用店铺分佣设置
        $ratio  = $this->_deduct_copartner_translate();

        //设置商品分佣
        $order_deduct->createOrderDeduct($this->member['m_id'], $tid, $total, $ratio, 0, 3);
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

    
    private function _recharge_order_deduct($tid, $total, $type) {

        //获取店铺分成佣金设置
        $deduct_model   = new App_Model_Shop_MysqlDeductStorage();
        $deduct_list    = $deduct_model->fetchDeductListBySid($this->sid, 2);

        $goods_deduct   = new App_Model_Goods_MysqlDeductStorage($this->sid);
        $order_deduct   = new App_Helper_OrderDeduct($this->sid);

        //使用店铺分佣设置
        $ratio  = $this->_deduct_translate($deduct_list[$type]);
        //设置商品分佣
        $order_deduct->createOrderDeduct($this->member['m_id'], $tid, $total, $ratio, 0, 3);
    }

    
    private function _deduct_translate($deduct) {
        if(!$deduct){
            return array(0 => 0, 1  => 0, 2  => 0, 3  => 0);
        }else{
            return array(0 => $deduct['dc_0f_ratio'], 1  => $deduct['dc_1f_ratio'], 2  => $deduct['dc_2f_ratio'], 3  => $deduct['dc_3f_ratio']);
        }
    }
    
    private function _recharge_order_deduct_yuyue($tid, $total,$buy_times=1,$is_deduct=1){
        //获取店铺是设置的分佣等级
        //按照购买次数选用不同的分佣逻辑
        $deduct_model   = new App_Model_Shop_MysqlDeductStorage();
        $deduct_list    = $deduct_model->fetchDeductListBySid($this->sid);
        $ratio=[0 => 0, 1  => 0, 2  => 0, 3  => 0];
        if($deduct_list && $is_deduct){
            $range      = array_keys($deduct_list);
            sort($range, SORT_NUMERIC);//按数字来比较
            $index = 1;//提成字段索引
            foreach ($range as $val) {
                $val = intval($val);
                if ($buy_times < $val) {
                    break;
                }
                $index = $val;
            }
            $deduct = $deduct_list[$index];
            $ratio=[0 => $deduct['dc_0f_ratio'], 1  => $deduct['dc_1f_ratio'], 2  => $deduct['dc_2f_ratio'], 3  => $deduct['dc_3f_ratio']];
        }

        //使用店铺分佣设置
        //根据购买次数找出对应的分佣比例

        //设置商品分佣
        $order_deduct   = new App_Helper_OrderDeduct($this->sid);
        $order_deduct->createOrderDeduct($this->member['m_id'], $tid, $total, $ratio, 0, 3);
    }





    
    private function _get_member_card_qrcode($member_card){
        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        if(!$member_card['om_card_qrcode']){
            if (plum_setmod_dir($this->hold_dir)) {
                $filename = $this->member['m_id'].'-'.$member_card['om_card_num']. '.png';
                $text = $member_card['om_card_num'];
                Libs_Qrcode_QRCode::png($text, $this->hold_dir . $filename, 'Q', 6, 1);

                $member_card['om_card_qrcode'] =  $this->access_path.$filename;
                // 修改会员记录
                $set = array('om_card_qrcode'=>$this->access_path.$filename);
                $offline_member->findUpdateMemberByMid($this->member['m_id'],$set);
            }
        }
        return $member_card;
    }

    
    public function orderListAction(){
        $page = $this->request->getIntParam('page');
        $index = $page * $this->count;
        $order_storage  = new App_Model_Store_MysqlOrderStorage($this->sid);
        $where[] = array('name' => 'oo_m_id', 'oper' => '=', 'value' => $this->member['m_id']);
        $where[] = array('name' => 'oo_s_id', 'oper' => '=', 'value' => $this->sid);
        $where[] = array('name' => 'oo_status', 'oper' => '=', 'value' => 2);
        $where[] = array('name' => 'oo_card_type', 'oper' => '=', 'value' => 2);

        $sort = array('oo_pay_time' => 'desc');
        $list = $order_storage->getList($where, $index, $page, $sort);
        if($list){
            $info['data'] = array();
            foreach ($list as $val){
                $info['data'][] = array(
                    'desc' => $val['oo_desc'],
                    'time' => date('Y.m.d', $val['oo_pay_time']),
                    'price' => $val['oo_amount']
                );
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('数据加载完毕');
        }
    }

    
    public function getMemberCardAction(){
        //查询是否已经开通了微财猫会员卡
        $vcm_model = new App_Model_Wechat_MysqlVcmWxpayStorage($this->sid);
        $cfg = $vcm_model->findUpdateBySid();
        if($cfg && $cfg['vw_device_id'] && $cfg['vw_pay_secret'] && $cfg['vw_isopen']){
            //获取微信会员卡
            $client = new App_Plugin_Vcaimao_PayClient($this->sid);
            $memberCard = $client->getMemberCard();
            if($memberCard && !$memberCard['errcode'] && $memberCard['data']){
                $info['data'] = array(
                    'appId' => $this->applet_cfg['ac_appid'],
                    'extraData' => $memberCard['data']['extraData']
                );
                $this->outputSuccess($info);
            }else{
                $this->outputError('获取卡券失败');
            }
        }else{
            $this->outputError('暂未开通微信会员卡');
        }

    }
  
   /**
     * 会员卡数量
     */
    public function cardCountAction(){
        $card_model = new App_Model_Store_MysqlCardStorage($this->sid);
        $info = array();
        $where      = array();
        $where[]    = array('name' => 'oc_type', 'oper' => '=', 'value' => 1);
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->sid);
        $info['data']['card1Num'] = $card_model->getCount($where);
        $where      = array();
        $where[]    = array('name' => 'oc_type', 'oper' => '=', 'value' => 2);
        $where[]    = array('name' => 'oc_s_id','oper' => '=','value' =>$this->sid);
        $info['data']['card2Num'] = $card_model->getCount($where);

        if($this->applet_cfg['ac_type'] == 8 || $this->applet_cfg['ac_type'] == 6){
            // 这个客户非要用计次卡只给他开放
            // zhangzc
            // 2019-12-17
            if($this->sid != 10109)
                $info['data']['card1Num'] = 0;
        }

        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $member_card    = $offline_member->getStoreMemberInfo($this->member['m_id'], 1);
        $info['data']['card1Hadbuy'] = $member_card?date('Y-m-d H:i:s', $member_card['om_expire_time']):'';
        $info['data']['card1Info'] = '';
        if($member_card){
            $card_info = [
                'isExpire' => $member_card['om_expire_time'] > 0 && $member_card['om_expire_time'] < $_SERVER['REQUEST_TIME'] ? 1 : 0,
                'leftNum' => intval($member_card['om_left_num']),
                'cardNumber' => $member_card['om_card_num'],
                'discount' => ''
            ];
            $member_card = $this->_get_member_card_qrcode($member_card);
            $card_info['qrcode'] = $this->dealImagePath($member_card['om_card_qrcode']);
            $card1_row = $card_model->getRowById($member_card['om_card_id']);
            $card_info['cardName'] = $card1_row['oc_name'] ? $card1_row['oc_name'] : '';
            $info['data']['card1Info'] = $card_info;
        }

        $offline_member = new App_Model_Store_MysqlMemberStorage($this->sid);
        $member_card    = $offline_member->getStoreMemberInfo($this->member['m_id'], 2);
        $info['data']['card2Hadbuy'] = $member_card?date('Y-m-d H:i:s', $member_card['om_expire_time']):'';

        if($member_card){
            $card_info = [
                'isExpire' => $member_card['om_expire_time'] > 0 && $member_card['om_expire_time'] < $_SERVER['REQUEST_TIME'] ? 1 : 0,
                'leftNum' => 0,
                'qrcode' => '',
                'cardNumber' => $member_card['om_card_num']
            ];
            $member_card = $this->_get_member_card_qrcode($member_card);
            $card2_row = $card_model->getRowLevel($member_card['om_card_id']);
            $card_info['cardName'] = $card2_row['oc_name'] ? $card2_row['oc_name'] : '';
            $card_info['discount'] = '享受'.$card2_row['ml_discount'].'折优惠';
            $info['data']['card2Info'] = $card_info;
        }

        //查询是否已经开通了微财猫会员卡
        $vcm_model = new App_Model_Wechat_MysqlVcmWxpayStorage($this->sid);
        $cfg = $vcm_model->findUpdateBySid();
        if($cfg && $cfg['vw_device_id'] && $cfg['vw_pay_secret'] && $cfg['vw_isopen']){
            $client = new App_Plugin_Vcaimao_PayClient($this->sid);
            $memberCard = $client->getMemberCard();
            if($memberCard && !$memberCard['errcode'] && $memberCard['data']){
                $info['data']['vcmCard'] = array(
                    'appId'     => $this->applet_cfg['ac_appid'],
                    'extraData' => $memberCard['data']['extraData']
                );
                $info['data']['vcmCardOpen'] = 1;
            }
        }

        $this->outputSuccess($info);
    }
  


}