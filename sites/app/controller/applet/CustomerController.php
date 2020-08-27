<?php


class App_Controller_Applet_CustomerController extends App_Controller_Applet_InitController
{

    public function __construct()
    {
        parent::__construct();

    }

    /*
     * 客服配置
     */
    public function kefuCfgAction(){
        $data = array(
            'customerService' => $this->applet_cfg['ac_kefu_open'],   //是否开启客服：0未开启，1开启
            'customerMobile'  => $this->applet_cfg['ac_kefu_mobile'],   //是否开启使用客服需授权手机号：0未开启，1开启
            'mobile'          => $this->member['m_mobile'] ? $this->member['m_mobile'] : '', //当前会员手机号
            'tips'            => $this->shop['s_auto_reply_tips'],
            'tipOpen'         => $this->shop['s_auto_reply_tips_open']
        );

        if($this->checkToolUsable('kf') && $this->applet_cfg['ac_kefu_mobile']){
            $record_model = new App_Model_Member_MysqlKefuUseStorage($this->sid);
            $record = $record_model->findUpdateByMid($this->member['m_id']);
            if(!$record){
                $data['mobile'] = '';
            }
        }
        //已经开过的不管了
//        else{
//            $data['customerMobile'] = 0;
//        }

        $info['data']= $data;
        $this->outputSuccess($info);
    }

    /*
     * 点击客服回调
     */
    public function kefuClickAction(){
        $uid = plum_app_user_islogin();
        $mid = $this->member['m_id'] ? $this->member['m_id'] : ($uid ? $uid : 0);
        if($this->checkToolUsable('kf') && $this->applet_cfg['ac_kefu_mobile'] && $mid){
            $record_model = new App_Model_Member_MysqlKefuUseStorage($this->sid);
            $record = $record_model->findUpdateByMid($this->member['m_id']);
            if($record){
                $set = array(
                    'kur_update_time' => time(),
                );
                if($record['kur_first_sms'] == 0){
                    $set['kur_first_sms'] = 1;
                    //发送首次使用短信
                    $sms_helper = new App_Helper_Sms($this->sid);
                    $sms_helper->sendNoticeSms(array(), 'kfxxtz',$this->applet_cfg['ac_name']);
                }
                $record_model->findUpdateByMid($this->member['m_id'],$set);
                $info['data'] = array(
                    'time' => time()
                );
                $this->outputSuccess($info);
            }
        }else{
            $this->outputError(time());
        }

    }
}