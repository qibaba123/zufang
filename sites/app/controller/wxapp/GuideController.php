<?php

class App_Controller_Wxapp_GuideController extends App_Controller_Wxapp_InitController {

    public function __construct() {
        parent::__construct(true);
        $this->setLayout('guide.tpl');
    }

    public function indexAction() {
        $applet_model       = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $wxapp_cfg          = $applet_model->findShopCfg();
        $applet_category    = plum_parse_config('category', 'applet');
        foreach ($applet_category as $key=>&$val){
            if(!$val['enable'] && $key!=28){
                unset($applet_category[$key]);
            }
        }
        $this->output['currinfo']   = array(
            'suid'      => $this->shops[$this->curr_sid]['s_unique_id'],
            'sname'     => $this->shops[$this->curr_sid]['s_name'],
            'open'      => date('Y-m-d H:i:s', $wxapp_cfg['ac_open_time']),
            'expire'    => $wxapp_cfg['ac_expire_time'] > time() ? date('Y-m-d H:i:s', $wxapp_cfg['ac_expire_time']) : '已到期',
            'tplname'   => $wxapp_cfg['ac_type'] == 0 ?  '未开通' : $applet_category[$wxapp_cfg['ac_type']]['name'],
            'desc'      => $wxapp_cfg['ac_type'] == 0 ? '请选择合适的行业模板开通。' : "您当前已开通{$applet_category[$wxapp_cfg['ac_type']]['name']}, 如果选择的行业模板和已开通模板不相同, 相当于新购一套行业模板。"
        );
        $this->output['category']   = $applet_category;
        $this->output['hideBrand'] = 1;

        $this->displaySmarty('wxapp/guide/index.tpl');
    }

    
    public function wxAlipayChargeQrcodeAction() {
        $xid        = $this->request->getStrParam('version');
        $channel    = $this->request->getStrParam('channel');
        $unique     = $this->request->getStrParam('unique');
        $price_vs   = plum_parse_config('category', 'applet');
        $version    = $price_vs[$xid];
        $amount     = abs(100*$version['saleprice']);
        if (!$amount) {
            plum_redirect("/public/manage/images/qrcode-placeholder.png");
        }
        $allow_type = array('wxpay' => 'wx_pub_qr', 'alipay' => 'alipay_qr');
        $channel    = in_array($channel, array_keys($allow_type)) ? $allow_type[$channel] : current($allow_type);
        if($channel=='wx_pub_qr'){
            $ret = $this->_wx_pay_qrcode($amount,$version,$xid);
            if (is_array($ret)){
                $qrcode = $ret['code_url'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }else{
            $ret = $this->_alipay_pay_qrcode($amount,$version,$xid);
            if (is_array($ret)){
                $qrcode = $ret['qr_code'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }
        Libs_Qrcode_QRCode::png($qrcode);
    }
    
    private function _wx_pay_qrcode($amount,$version,$xid){
        $tid = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);
        $body   = $this->curr_shop['s_name']."订购{$version['name']}小程序";
        $pay_storage = new App_Plugin_Weixin_SubPay(0);
        $notify_url = $this->response->responseHost().'/manage/notify/autonomyPayWxNotify';//回调地址
        $attach = array(
            'suid'    => $this->curr_shop['s_unique_id'],
            'mid'     => $this->uid,
            'version' => $xid
        );
        $other      = array(
            'attach'    => json_encode($attach),
        );
        return $pay_storage->agentPayRecharge(floatval($amount),$tid,$notify_url,$body,$other);
    }

    
    private function _alipay_pay_qrcode($amount,$version,$xid){
        $out_trade_no = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);
        $subject   = $this->curr_shop['s_name']."订购{$version['name']}小程序";
        $notify_url = $this->response->responseHost().'/manage/notify/autonomyPayAlipayNotify';//回调地址
        $amount = $amount/100;
        $attach = array(
            'suid'    => $this->curr_shop['s_unique_id'],
            'mid'     => $this->uid,
            'version' => $xid
        );
        $body = json_encode($attach);
        $ali_qrpay = new App_Plugin_Alipaysdk_NewClient(0);
        $result      = $ali_qrpay->agentPayRecharge($out_trade_no, $subject,$body, $amount,$notify_url);
        return $result;
    }
    
    public function grantAuthAction() {
        $auth   = $this->fetchPreAuthCode();
        $this->output['auth_uri']   = $auth ? $auth : '#';

        $this->displaySmarty('wxapp/setup/bangding.tpl');
    }

    
    private function _applet_is_auth(){
        $auth_storage = new App_Model_Applet_MysqlAppletAuthRecordStorage($this->curr_sid);
        return $auth_storage->findRecordBySid();
    }

    
    private function _save_applet_auth($appid,$name){
        $data = array(
            'aar_s_id'        => $this->curr_sid,
            'arr_appid'       => $appid,
            'arr_name'        => $name,
            'arr_create_time' => time()
        );
        $auth_storage = new App_Model_Applet_MysqlAppletAuthRecordStorage($this->curr_sid);
        return $auth_storage->insertValue($data);
    }

    
    public function editAuthAction() {
        $this->buildBreadcrumbs(array(
            array('title' => '授权管理', 'link' => '#'),
        ));
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $applet     = $applet_model->findShopCfg();
        $this->output['appletCfg'] = $applet;
        $this->renderCropTool('/wxapp/guide/uploadImg');
        $this->displaySmarty('wxapp/guide/edit-auth.tpl');
    }


    
    public function saveEditAuthAction(){
        $name = $this->request->getStrParam('name');
        $ghid = $this->request->getStrParam('ghid');
        $appid = $this->request->getStrParam('appid');
        $appsecret = $this->request->getStrParam('appsecret');
        $avatar = $this->request->getStrParam('avatar');
        $signature = $this->request->getStrParam('signature');
        $cfgid = $this->request->getIntParam('cfgid');
        if(!$name || ((strlen($name)+mb_strlen($name,"UTF8"))/2)>32 || ((strlen($name)+mb_strlen($name,"UTF8"))/2)<4){
            $this->displayJsonError('小程序名称不符合');
        }
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        if($cfgid){
            $row = $applet_model->getRowById($cfgid);
            if($row && $row['ac_appid'] && $row['ac_appid']!=$appid){
                $this->displayJsonError('小程序APPID不能更换');
            }
        }else{
            $row = $applet_model->findShopCfgByAppid($appid);
            if($row){
                $this->displayJsonError('小程序已授权到平台，请更换小程序后重试');
            }
        }
        if(!$ghid || mb_strcut($ghid,0,3)!='gh_' || mb_strlen($ghid)!=15){
            $this->displayJsonError('原始ID填写有误请重新填写');
        }
        $wxxcx_client   = new App_Plugin_Weixin_PublicClient();
        $result    = $wxxcx_client->authAppidAppSecretCorrect($appid,$appsecret);
        if(!$result){
            $this->displayJsonError('AppId和AppSecret不对应，请认真对照');
        }
        if($name && $ghid && $appid && $appsecret){
            $data = array(
                'ac_appid'     => $appid,
                'ac_appsecret' => $appsecret,
                'ac_gh_id'     => $ghid,
                'ac_name'      => $name,
                'ac_avatar'    => $avatar,
                'ac_signature' => $signature
            );
            $ret = $applet_model->findShopCfg($data);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("保存小程序信息成功");
            }

            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('信息填写不完整');
        }
    }

    
    private function _wx_pay_cfg($amount,$time){
        $tid = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);
        $body   = $this->curr_shop['s_name'].'订购服务'.($amount/100).'元';
        $pay_storage = new App_Plugin_Weixin_SubPay(0);
        $notify_url = $this->response->responseHost().'/manage/push/knowledgePayWxNotify';//回调地址
        $attach = array(
            'sid'    => $this->curr_sid,
            'time'   => $time
        );
        $other      = array(
            'attach'    => json_encode($attach),
        );
        return $pay_storage->agentPayRecharge(floatval($amount),$tid,$notify_url,$body,$other);
    }

    
    private function _alipay_pay_cfg($amount,$time){
        $out_trade_no = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid);
        $subject   = $this->curr_shop['s_name'].'订购服务'.($amount/100).'元';
        $notify_url = $this->response->responseHost().'/manage/push/knowledgePayAlipayNotify';//回调地址
        $amount = $amount/100;
        $attach = array(
            'sid'    => $this->curr_sid,
            'time'   => $time
        );
        $body = json_encode($attach);
        $ali_qrpay = new App_Plugin_Alipaysdk_NewClient(0);
        $result      = $ali_qrpay->agentPayRecharge($out_trade_no, $subject,$body, $amount,$notify_url);
        return $result;

    }



    
    public function uploadImgAction(){
        $width  = $this->request->getIntParam('w', 200);
        $height = $this->request->getIntParam('h', 200);
        $groupid = $this->request->getIntParam('groupid');

        $crop       = new Libs_Image_Crop_Cropper();
        $crop->crop($width, $height);

        $ret = array(
            'state'  => 200,
            'message' => $crop->getMsg(),
            'result' => $crop->getResult(),
            'filename' => $crop->getFileName()
        );
        if($ret['result']){
            $data = array(
                'sa_s_id'   => $this->curr_sid,
                'sa_g_id'   => $groupid,
                'sa_path'   => $ret['result'],
                'sa_name'   => date('YmdHis',time()),
                'sa_type'   => 1,
                'sa_real_name' => $ret['filename'],
                'sa_width'  => $width,
                'sa_height' => $height,
                'sa_create_time' => time()
            );
            $attachment_model = new App_Model_Shop_MysqlAttachmentStorage();
            $attachment_model->insert($data);
        }
        $this->displayJson($ret);
    }





}



