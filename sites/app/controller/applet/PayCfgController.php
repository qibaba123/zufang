<?php
/**
 * Created by PhpStorm.
 * User: zhaoyang
 * Date: 17/6/27
 * Time: 上午：11：30
 * 通用相关接口
 */

class App_Controller_Applet_PayCfgController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();

    }

    /*
     * 通用支付配置信息
     */
    public function payCfgAction(){
        // 获取店铺支付配置信息
        $pay_type    = new App_Model_Auth_MysqlPayTypeStorage($this->sid);
        $payType = $pay_type->findRowPay();
        $esId = $this->request->getIntParam('esId',0);
        if($payType && $payType['pt_pay_type_sort']){
            $paySort = json_decode($payType['pt_pay_type_sort'],true);
        }else{
            $paySort = array(
                'wxpay' => 1,
                'coin'  => 2,
                'cash'  => 3
            );
        }
        if($this->appletType == 4 && $esId){
            $es_pay_type_model = new App_Model_Entershop_MysqlEnterShopPayTypeStorage($this->sid);
            $es_pay_type = $es_pay_type_model->findUpdateBySidEsId($esId);
            if($es_pay_type){
                $payType['pt_toutiao_pay'] = $es_pay_type['espt_toutiao_pay'] == 1 ? $payType['pt_toutiao_pay'] : 0;
                $payType['pt_cash'] = $es_pay_type['espt_cash'] == 1 ? $payType['pt_cash'] : 0;
                $payType['pt_coin'] = $es_pay_type['espt_coin'] == 1 ? $payType['pt_coin'] : 0;
            }
        }


        $type['data'] = array();
        if($this->appletType==1 || $this->appletType == 5){  // 微信小程序 或微信公众号
            if($payType && $payType['pt_wxpay_applet']==1){
                $type['data'][$paySort['wxpay']] = array(
                    'type'     => 1,
                    'typeNote' => '在线支付',
                );
            }
        }elseif ($this->appletType==2){  //百度智能小程序支付
            if($payType && $payType['pt_baidu_pay']==1){
                $type['data'][] = array(
                    'type'     => 1,
                    'typeNote' => '在线支付',
                );
            }
        }elseif ($this->appletType==3){  //支付宝小程序支付
            if($payType && $payType['pt_alipay_applet']==1){
                $type['data'][] = array(
                    'type'     => 1,
                    'typeNote' => '在线支付',
                );
            }
        }elseif ($this->appletType==4){  //头条小程序支付
            if($payType && $payType['pt_toutiao_pay']==1){
                $type['data'][] = array(
                    'type'     => 1,
                    'typeNote' => '在线支付',
                );
            }
        }elseif ($this->appletType==6){  //QQ小程序支付
            //if($payType && $payType['pt_alipay_applet']==1){
            if(true){
                $type['data'][] = array(
                    'type'     => 1,
                    'typeNote' => '在线支付',
                );
            }
        }
        if($payType && $payType['pt_cash']==1){
            if($this->applet_cfg['ac_type'] == 4){
                $type['data'][$paySort['cash']] = array(
                    'type'     => 2,
                    'typeNote' => '现金支付',
                );
            }else{
                $type['data'][$paySort['cash']] = array(
                    'type'     => 2,
                    'typeNote' => '货到付款',
                );
            }
        }
        if($payType && $payType['pt_coin']==1 ){
            $shopBalance = 0;
            if($this->applet_cfg['ac_type'] == 28){
                $bind_model = new App_Model_Job_MysqlJobBindStorage($this->sid);
                $bind = $bind_model->verifyLogin($this->member['m_id']);
                $es_model    = new App_Model_Entershop_MysqlEnterShopStorage($this->sid);
                $enterShop   = $es_model->getRowById($bind['ajb_es_id']);
                $shopBalance = floatval($enterShop['es_balance']);
            }
            $type['data'][$paySort['coin']] = array(
                'type'      => 3,
                'typeNote'  => '余额支付',
                'balance'   => floatval($this->member['m_gold_coin']),
                'shopBalance' => $shopBalance
            );
        }
        //查询是否已经开通了微财猫会员卡
        $vcm_model = new App_Model_Wechat_MysqlVcmWxpayStorage($this->sid);
        $cfg = $vcm_model->findUpdateBySid();
        // 如果已经开通过微财猫会员卡功能
        if($cfg && $cfg['vw_device_id'] && $cfg['vw_pay_secret'] && $cfg['vw_isopen'] && $this->appletType==1){
            $client = new App_Plugin_Vcaimao_PayClient($this->sid);
            // 获取微财猫会员卡开卡信息
            $memberInfo = $client->getMemberInfo($this->member['m_union_id'],$this->member['m_openid']);
            Libs_Log_Logger::outputLog($this->member);
            Libs_Log_Logger::outputLog($memberInfo);
            if($memberInfo && !$memberInfo['errcode'] && $memberInfo['data']){
                $type['data'][] = array(
                    'type'      => 4,
                    'typeNote'  => '微信储值卡支付',
                    'opened'    => 1,  //是否开通过会员卡：1已开通，0未开通
                    'balance'   => round(($memberInfo['data']['balance']/100),2),
                    'extraData' => $memberInfo['data']['extraData'],
                );
            }else{  // 未开通微信会员卡
                //获取微信会员卡
                $memberCard = $client->getMemberCard();
                if($memberCard && !$memberCard['errcode'] && $memberCard['data']){
                    $type['data'][] = array(
                        'type'      => 4,
                        'typeNote'  => '微信储值卡支付',
                        'balance'   => 0,
                        'opened'    => 0,   //是否开通过会员卡：1已开通，0未开通
                        'extraData' => $memberCard['data']['extraData'],
                    );
                }
            }
            $type['data'][] = array(
                'type'      => 5,
                'typeNote'  => '微信支付',
            );
        }
        if(!empty($type['data'])){
            ksort($type['data']);
            $info = array();
            foreach ($type['data'] as $val){
                $info['data'][] = $val;
            }
            $this->outputSuccess($info);
        }else{
            $this->outputError('暂未开启支付');
        }
    }
}