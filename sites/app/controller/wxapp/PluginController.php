<?php

class App_Controller_Wxapp_PluginController extends App_Controller_Wxapp_InitController{

    public function __construct(){
        parent::__construct();
    }

    
    public function settingSmsAction(){
        $this->output['row']    = $this->shops[$this->curr_sid];
        $open   = $this->request->getStrParam('open', false);
        $this->buildBreadcrumbs(array(
            array('title' => '插件管理', 'link' => '#'),
            array('title' => '短信配置', 'link' => '#'),
        ));
        $sms_storage = new App_Model_Shop_MysqlShopSmsStorage($this->curr_sid);
        $sms = $sms_storage->findUpdateBySid();
        $this->output['sms'] = $sms;
        $sms_ucpaas = plum_parse_config('ucpaas','sms');
        $this->output['sms_tpl'] = $sms_ucpaas['notice_tpl'];
        $this->output['bridge_link']    = $this->composeLink('common', 'bridge', null, true, 'info');
        $this->smsAction($open);
        $this->output['applet'] = $this->wxapp_cfg;
        $this->displaySmarty('wxapp/sms/setting.tpl');
    }
    
    public function saveSmsSettingAction(){
        $strd = array('ddzfcg_s','ddwctz_s','sqtktz_s','mjfhtz_b','tytktz_b','jjtktz_b','xcxyytz_s','xcxsqrz_s','kfxxtz_s');
        $data = $this->getIntByField($strd,'ss_');
        $data['ss_update_time'] = time();
        $sms_storage = new App_Model_Shop_MysqlShopSmsStorage($this->curr_sid);
        $row = $sms_storage->findUpdateBySid();
        if(!empty($row)){
            $ret = $sms_storage->findUpdateBySid($data);
        }else{
            $data['ss_s_id'] = $this->curr_sid;
            $ret = $sms_storage->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("短信通知设置保存成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function smsAction($open) {
        $sms_cfg_storage    = new App_Model_Plugin_MysqlSmsCfgStorage($this->curr_sid);
        $cfg    = $sms_cfg_storage->fetchUpdateCfg();
        if (!$cfg && !$open) {
            $this->output['open']   = "/wxapp/plugin/settingSms/open/1";
            $this->displaySmarty('wxapp/sms/guide.tpl');
            die;
        }
        if (!$cfg && $open) {
            $indata     = array(
                'sc_s_id'       => $this->curr_sid,
                'sc_useable'    => 0,
                'sc_custom_sign'=> 0,
                'sc_create_time'=> time(),
            );
            $indata['sc_id'] = $sms_cfg_storage->insertValue($indata);
            $cfg    = $indata;#$sms_cfg_storage->fetchUpdateCfg();
        }
        $this->output['row'] = $cfg;
        $this->output['sms_verify'] = $cfg['sc_custom_sign'];

        $this->showTypeByKey('audit');
        $yunpian_cfg    = plum_parse_config('yunpian');
        $this->output['unit_price'] = $yunpian_cfg['unit_price'];
        
        $this->_send_sms_recode();
    }

    private function _send_sms_recode(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $sms_model  = new App_Model_Plugin_MysqlSmsRecordStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'sr_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort       = array('sr_send_time'=>'DESC');
        $total      = $sms_model->getCount($where);
        $pagecfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list       = array();
        if($total > $index){
            $list   = $sms_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list']       = $list;
        $this->output['paginator']  = $pagecfg->render();
    }

    public function templateAction(){
        $sms_cfg_storage    = new App_Model_Plugin_MysqlSmsCfgStorage($this->curr_sid);
        $cfg    = $sms_cfg_storage->fetchUpdateCfg();
        if($cfg['sc_custom_sign']){
            $sms_model = new App_Model_Plugin_MysqlSmsTplStorage($this->curr_sid);
            $this->output['list'] = $sms_model->getListBySid();
            $this->showTypeByKey('audit');

            $this->buildBreadcrumbs(array(
                array('title' => '短信配置', 'link' => '/wxapp/plugin/settingSms'),
                array('title' => '短信模版', 'link' => '#'),
            ));
            $this->displaySmarty('wxapp/sms/template.tpl');
        }else{
            plum_url_location('尚未开启自定义模版');
        }
    }

    
    public function smsRemindAction(){
        $remind_model = new App_Model_Plugin_MysqlSmsCfgStorage($this->curr_sid);
        $this->output['row'] = $remind_model->fetchUpdateCfg();
        $this->buildBreadcrumbs(array(
            array('title' => '短信配置', 'link' => '/wxapp/plugin/settingSms'),
            array('title' => '短信提醒设置', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/sms/remind.tpl');
    }

    
    public function saveRemindAction(){
        $data   = array();
        $open   = $this->request->getIntParam('open');
        $data['sc_warn_open']   = $open ? 1 : 0;
        $field = array('limit','phone','mail');
        foreach($field as $val){
            $temp  = $this->request->getStrParam($val);
            $data['sc_warn_'.$val]  = $temp;
        }
        $remind_model = new App_Model_Plugin_MysqlSmsCfgStorage($this->curr_sid);
        $row = $remind_model->fetchUpdateCfg();
        if(!empty($row)){
            $ret    = $remind_model->fetchUpdateCfg($data);

            if($ret){
                App_Helper_OperateLog::saveOperateLog("短信余额不足提醒配置保存成功");
            }

            $result = $this->showAjaxResult($ret,'保存',1);
        }else{
            $result = array(
                'ec' => 400,
                'em' => '请开通短信插件'
            );
        }
        $this->displayJson($result);
    }
    
    public function saveSmsAction(){
        $result = array(
            'ec' => 400,
            'em' => '签名格式错误'
        );
        $sign   = $this->request->getStrParam('sign');
        $id     = $this->request->getIntParam('id');
        if (plum_utf8_strlen($sign) >= 3 && plum_utf8_strlen($sign) <= 8) {
            $sms_model = new App_Model_Plugin_MysqlSmsTplStorage($this->curr_sid);
            $flag = 0 ;
            if($id){
                $row = $sms_model->getRowUpdateByIdSid($id,$this->curr_sid);
                if($row['st_status'] == 2){
                    $flag = 2 ;
                }
            }else{
                $flag = 1 ;
            }

            if($flag){
                $plugin = new App_Plugin_Sms_YunPianPlugin();
                $sms = $plugin->addCodeSmsTpl($sign);
                if($sms && is_array($sms)){
                    $data = array(
                        'st_s_id'       => $this->curr_sid,
                        'st_tpl_id'     => $sms['tpl_id'],
                        'st_tpl_content'=> $sms['tpl_content'],
                        'st_tpl_sign'   => $sign,
                        'st_status'     => $this->_get_sms_status($sms['check_status']),
                        'st_reason'     => $sms['reason'],
                        'st_create_time'=> time(),
                        'st_update_time'=> time()
                    );
                    if($id){
                        $ret = $sms_model->getRowUpdateByIdSid($id,$this->curr_sid,$data);
                    }else{
                        $ret = $sms_model->insertValue($data);
                    }
                    if($ret){
                        $result = array(
                            'ec' => 200,
                            'em' => '短信签名保存成功'
                        );
                        App_Helper_OperateLog::saveOperateLog("短信签名保存成功");
                    }else{
                        $result['em'] = '短信签名保存失败';
                    }
                }else{
                    $result['em'] = '短信签名修改失败';
                }
            }else{
                $result['em'] = '短信签名无法修改';
            }
        }
        $this->displayJson($result);
    }

    
    public function synSmsAction(){
        $result = array(
            'ec' => 400,
            'em' => '请求数据错误'
        );
        $id     = $this->request->getIntParam('id');
        $sms_model = new App_Model_Plugin_MysqlSmsTplStorage($this->curr_sid);
        $row = $sms_model->getRowUpdateByIdSid($id,$this->curr_sid);
        if($row && $row['st_status'] == 0){
            $plugin = new App_Plugin_Sms_YunPianPlugin();
            $sms = $plugin->getCodeSmsTpl($row['st_tpl_id']);
            if($sms && is_array($sms)) {
                $data = array(
                    'st_tpl_content' => $sms['tpl_content'],
                    'st_status' => $this->_get_sms_status($sms['check_status']),
                    'st_reason' => $sms['reason'],
                    'st_update_time' => time()
                );
                $ret = $sms_model->updateByTplId($data,$sms['tpl_id']);
                if($ret){
                    $result = array(
                        'ec' => 200,
                        'em' => '短信签名保存成功'
                    );
                    App_Helper_OperateLog::saveOperateLog("短信签名保存成功");
                }else{
                    $result['em'] = '短信签名保存失败';
                }
            }else{
                $result['em'] = '短信签名无法修改';
            }
        }
        $this->displayJson($result);
    }

    
    private function _get_sms_status($check){
        switch ($check) {
            case 'SUCCESS':
                $status = 1;
                break;
            case 'FAIL':
                $status = 2;
                break;
            default:
                $status = 0;
                break;

        }
        return $status;
    }

    public function wxAlipayChargeQrcodeSmsAction() {
        $allow_type = array('wxpay' => 'wx_pub_qr', 'alipay' => 'alipay_qr');
        $channel    = $this->request->getStrParam('channel');
        $money      = $this->request->getStrParam('money');
        $channel    = in_array($channel, array_keys($allow_type)) ? $allow_type[$channel] : current($allow_type);
        if(!$money){
            $money = 50;
        }
        $amount     = $money*100;
        if($channel=='wx_pub_qr'){
            $ret = $this->_wx_pay_sms($amount);
            if (is_array($ret)){
                $qrcode = $ret['code_url'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }else{
            $ret = $this->_alipay_pay_sms($amount);
            if (is_array($ret)){
                $qrcode = $ret['qr_code'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }
        Libs_Qrcode_QRCode::png($qrcode);
    }

    
    private function _wx_pay_sms($amount){
        $tid = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->uid);
        $body   = $this->curr_shop['s_name']."短信充值";
        $pay_storage = new App_Plugin_Weixin_SubPay(0);
        $notify_url = $this->response->responseHost().'/manage/notify/wxpayBuySmsNotify';//回调地址
        $attach = array(
            'suid' => $this->curr_shop['s_unique_id'],
            'mid'  => $this->manager['m_id'],
        );
        $other      = array(
            'attach'    => json_encode($attach),
        );
        return $pay_storage->agentPayRecharge(floatval($amount),$tid,$notify_url,$body,$other);
    }

    
    private function _alipay_pay_sms($amount){
        $out_trade_no = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->uid);
        $subject   = $this->curr_shop['s_name']."短信充值";
        $notify_url = $this->response->responseHost().'/manage/notify/alipayBuySmsNotify';//回调地址
        $amount = floatval($amount/100);
        $attach = array(
            'suid' => $this->curr_shop['s_unique_id'],
            'mid'  => $this->manager['m_id'],
        );
        $body = json_encode($attach);
        $ali_qrpay = new App_Plugin_Alipaysdk_NewClient(0);
        $result      = $ali_qrpay->agentPayRecharge($out_trade_no, $subject,$body, $amount,$notify_url);
        return $result;

    }
    public function vrOrderListAction(){
        $page         = $this->request->getIntParam('page');
        $index        = $page*$this->count;
        $where        = array();
        $where[]      = array('name'=>'avo_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort         = array('avo_create_time'=>'DESC');
        $vr_storage          = new   App_Model_Applet_MysqlAppletVrOrderStorage();
        $list         = $vr_storage->getVrOrderList($where,$index,$this->count,$sort);

        $this->output['list'] = $list;
        $status       = plum_parse_config('vr_order_status');
        $this->output['status']   = $status;
        $total      = $vr_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pageHtml']   = $pageCfg->render();
        $this->buildBreadcrumbs(array(
            array('title' => 'VR全景下单管理', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/plugin/vrorder-list.tpl');
    }

    
    public function wxAlipayChargeQrcodeAction() {
        $allow_type = array('wxpay' => 'wx_pub_qr', 'alipay' => 'alipay_qr');
        $channel    = $this->request->getStrParam('channel');
        $channel    = in_array($channel, array_keys($allow_type)) ? $allow_type[$channel] : current($allow_type);
        $buyssl_price   = plum_parse_config('shotvr', 'agent');
        if($channel=='wx_pub_qr'){
            $ret = $this->_wx_pay_cfg($buyssl_price*100);
            if (is_array($ret)){
                $qrcode = $ret['code_url'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }else{
            $ret = $this->_alipay_pay_cfg($buyssl_price*100);
            if (is_array($ret)){
                $qrcode = $ret['qr_code'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }
        Libs_Qrcode_QRCode::png($qrcode);
    }

    
    private function _wx_pay_cfg($amount){
        $tid = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->uid);
        $body   = $this->curr_shop['s_name']."VR拍摄下单";
        $pay_storage = new App_Plugin_Weixin_SubPay(0);
        $notify_url = $this->response->responseHost().'/manage/notify/wxpayBuyVrNotify';//回调地址
        $attach = array(
            'suid' => $this->curr_shop['s_unique_id'],
            'mid'  => $this->manager['m_id'],
        );
        $other      = array(
            'attach'    => json_encode($attach),
        );
        return $pay_storage->agentPayRecharge(floatval($amount),$tid,$notify_url,$body,$other);
    }

    
    private function _alipay_pay_cfg($amount){
        $out_trade_no = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->uid);
        $subject   = $this->curr_shop['s_name']."VR拍摄下单";
        $notify_url = $this->response->responseHost().'/manage/notify/alipayBuyVrNotify';//回调地址
        $amount = floatval($amount/100);
        $attach = array(
            'suid' => $this->curr_shop['s_unique_id'],
            'mid'  => $this->manager['m_id'],
        );
        $body = json_encode($attach);
        $ali_qrpay = new App_Plugin_Alipaysdk_NewClient(0);
        $result      = $ali_qrpay->agentPayRecharge($out_trade_no, $subject,$body, $amount,$notify_url);
        return $result;

    }

    
    public function updateVrOrderAction(){
        $strField = array('province','city','address','mobile','contact','scene_num','scene_type');
        $data     = $this->getStrByField($strField,'avo_');
        $tid = $this->request->getStrParam('vrtid');
        $ret = 0;
        if($tid){
            $vr_storage          = new   App_Model_Applet_MysqlAppletVrOrderStorage($this->curr_sid);
            $row = $vr_storage->findUpdateVrOrderByTid($tid);
            if($row && $row['ss_status']==0){
                $ret = $vr_storage->findUpdateVrOrderByTid($tid,$data);
            }
        }
        $this->showAjaxResult($ret);
    }

    private function _get_ald_cfg(){
        $aldwxCfg_model = new App_Model_Plugin_MysqlAldwxCfgStorage($this->curr_sid);
        $cfg = $aldwxCfg_model->fetchUpdateCfg();
        if($cfg){
            if($cfg['ac_expires_in'] > time()){
                $access_token = $cfg['ac_access_token'];
            }else{
                $aldwx_client = new App_Plugin_Aldwx_AldwxClient($this->curr_sid);
                $aldwx_client->getCode();
                sleep(1);
                $cfg = $aldwxCfg_model->fetchUpdateCfg();
                $access_token = $aldwx_client->getAccessToken($cfg['ac_code']);

            }
        }
        return array(
            'key' => $cfg['ac_app_key'],
            'token' => $access_token
        );

    }
    public function secondLink($type='setting'){
        $link = array(
            array(
                'label' => '配送设置',
                'link'  => '/wxapp/plugin/settingEle',
                'active'=> 'setting'
            ),
            array(
                'label' => '门店管理',
                'link'  => '/wxapp/plugin/editStore',
                'active'=> 'store'
            ),
        );

        $sinTitle = '蜂鸟配送';
        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = $sinTitle;

    }


    
    public function settingEleAction(){
        $this->checkToolUsable('anubis');
        $this->output['row']    = $this->shops[$this->curr_sid];
        $this->buildBreadcrumbs(array(
            array('title' => '插件管理', 'link' => '#'),
            array('title' => '蜂鸟配送', 'link' => '#'),
        ));

        $ele_cfg_storage    = new App_Model_Plugin_MysqlEleCfgStorage($this->curr_sid);
        $cfg    = $ele_cfg_storage->fetchUpdateCfg();

        if (!$cfg) {
            $indata     = array(
                'ec_s_id'       => $this->curr_sid,
                'ec_balance'    => 0,
                'ec_spend'      => 0,
                'ec_send_num'   => 0,
                'ec_create_time'=> time(),
            );
            $indata['ec_id'] = $ele_cfg_storage->insertValue($indata);
            $cfg    = $indata;
        }

        $statusNote = array('-1' => '已取消', '-2' => '已投诉', '0' => '待接单', '1' => '已接单', '20' => '已分配骑手', '80' => '已到店', '2' => '配送中', '3' => '已送达', '5' => '系统拒单/配送异常');
        $this->output['statusNote'] =$statusNote;

        $send_type    = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $sendType = $send_type->findUpdateBySid(null,0);

        $this->output['sendCfg'] = $sendType;
        $this->output['row'] = $cfg;

        $post_model = new App_Model_Plugin_MysqlElePostCfgStorage();
        $post = $post_model->findRowByCity($this->company['c_city']);

        $baseCfg = plum_parse_config('base', 'ele');
        $grade = $post['epc_grade']?$post['epc_grade']:$post['epc_type'];
        $baseFee = $baseCfg[$grade?$grade:'代理城市'];
        $this->output['baseFee'] = $baseFee;
        $this->output['company'] = $this->company['c_city'];

        $this->_send_ele_recode();
        $this->output['bridge_link']    = $this->composeLink('common', 'bridge', null, true, 'info');
        $this->displaySmarty('wxapp/ele/setting.tpl');
    }

    
    public function saveEleSettingAction(){
        if(!$this->checkToolUsableBool('anubis')){
            $this->displayJsonError('插件未开通');
        }
        $timeout = $this->request->getIntParam('timeout');
        $ele_cfg_storage    = new App_Model_Plugin_MysqlEleCfgStorage($this->curr_sid);
        $set = array('ec_send_timeout' => $timeout);
        $ret = $ele_cfg_storage->fetchUpdateCfg($set);

        $this->showAjaxResult($ret);
    }

    private function _send_ele_recode(){
        $page       = $this->request->getIntParam('page');
        $index      = $page * $this->count;
        $sms_model  = new App_Model_Plugin_MysqlEleRecordStorage($this->curr_sid);
        $where      = array();
        $where[]    = array('name'=>'er_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]    = array('name'=>'er_deleted','oper'=>'=','value'=>0);
        $sort       = array('er_update_time'=>'DESC');
        $total      = $sms_model->getCount($where);
        $pagecfg    = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
        $list       = array();
        if($total > $index){
            $list   = $sms_model->getList($where,$index,$this->count,$sort);
        }
        $this->output['list']       = $list;
        $this->output['paginator']  = $pagecfg->render();
    }

    
    public function wxAlipayChargeQrcodeEleAction() {
        $allow_type = array('wxpay' => 'wx_pub_qr', 'alipay' => 'alipay_qr');
        $channel    = $this->request->getStrParam('channel');
        $money      = $this->request->getStrParam('money');
        $channel    = in_array($channel, array_keys($allow_type)) ? $allow_type[$channel] : current($allow_type);
        if(!$money){
            $money = 50;
        }
        $amount     = $money*100;
        if($channel=='wx_pub_qr'){
            $ret = $this->_wx_pay_ele($amount);
            if (is_array($ret)){
                $qrcode = $ret['code_url'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }else{
            $ret = $this->_alipay_pay_ele($amount);
            if (is_array($ret)){
                $qrcode = $ret['qr_code'];
            }else{
                plum_redirect("/public/manage/images/qrcode-placeholder.png");
            }
        }
        Libs_Qrcode_QRCode::png($qrcode);
    }

    
    private function _wx_pay_ele($amount){
        $tid = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->uid);
        $body   = $this->curr_shop['s_name']."配送预存";
        $pay_storage = new App_Plugin_Weixin_SubPay(0);
        $notify_url = $this->response->responseHost().'/manage/notify/wxpayBuyEleNotify';//回调地址
        $attach = array(
            'suid' => $this->curr_shop['s_unique_id'],
            'mid'  => $this->manager['m_id'],
        );
        $other      = array(
            'attach'    => json_encode($attach),
        );
        if($this->curr_sid == 11){
            $amount = 1;
        }
        return $pay_storage->agentPayRecharge(floatval($amount),$tid,$notify_url,$body,$other);
    }

    
    private function _alipay_pay_ele($amount){
        $out_trade_no = App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->uid);
        $subject   = $this->curr_shop['s_name']."配送预存";
        $notify_url = $this->response->responseHost().'/manage/notify/alipayBuyEleNotify';//回调地址
        $amount = floatval($amount/100);
        $attach = array(
            'suid' => $this->curr_shop['s_unique_id'],
            'mid'  => $this->manager['m_id'],
        );
        $body = json_encode($attach);
        $ali_qrpay = new App_Plugin_Alipaysdk_NewClient(0);
        if($this->curr_sid == 11){
            $amount = 0.01;
        }
        $result      = $ali_qrpay->agentPayRecharge($out_trade_no, $subject,$body, $amount,$notify_url);
        return $result;

    }

    
    public function editStoreAction(){
        $this->secondLink('store');
        $ele_cfg_storage    = new App_Model_Plugin_MysqlEleCfgStorage($this->curr_sid);
        $cfg    = $ele_cfg_storage->fetchUpdateCfg();
        if($cfg && $cfg['ec_store']){
            $ele    = new App_Plugin_Food_AnubisEle();
            $storeRet = $ele->queryChainStore($cfg['ec_store']);
            if($storeRet && $storeRet['errcode'] == 0){
                $this->output['statusNote'] = array('未认证', '审核中', '审核通过', '认证失败', '判定失效');
                $this->output['store'] = $storeRet['result'][0];
            }
        }
        $this->buildBreadcrumbs(array(
            array('title' => '插件管理', 'link' => '#'),
            array('title' => '蜂鸟配送', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/ele/edit-store.tpl');
    }

    
    public function updateStoreAction(){
        if(!$this->checkToolUsableBool('anubis')){
            $this->displayJsonError('插件未开通');
        }
        $id               = $this->request->getIntParam('id');
        $chain_store_code = $this->request->getStrParam('chain_store_code');
        $chain_store_name = $this->request->getStrParam('chain_store_name');
        $contact_phone    = $this->request->getStrParam('contact_phone');
        $address          = $this->request->getStrParam('address');
        $longitude        = $this->request->getStrParam('longitude');
        $latitude         = $this->request->getStrParam('latitude');

        $ele    = new App_Plugin_Food_AnubisEle();
        if($chain_store_code){
            $ret    = $ele->updateChainStore($chain_store_code,$chain_store_name, $contact_phone, $address, $longitude,$latitude);
        }else{
            $chain_store_code = plum_random_code();
            $ret    = $ele->addChainStore($chain_store_code,$chain_store_name, $contact_phone, $address, $longitude,$latitude);
        }
        if($ret['errcode'] == 0){
            $store_model = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
            $store_model->updateById(array('os_ele_store_id' => $chain_store_code), $id);
            $this->showAjaxResult(1, '同步');
        }else{
            $this->displayJsonError($ret['errmsg']);
        }
    }
    public function cancelEleOrderAction(){
        $tid = $this->request->getStrParam('tid');
        $code = $this->request->getIntParam('code');
        $ele    = new App_Plugin_Food_AnubisEle();
        $ret    = $ele->cancelSendOrder($tid, $code);
        if($ret['errcode'] == 0){
            $trade_model = new App_Model_Trade_MysqlTradeStorage($this->curr_sid);
            $trade = $trade_model->findUpdateTradeByTid($tid);
            $ele_cfg_model = new App_Model_Plugin_MysqlEleCfgStorage($trade['t_s_id']);
            $ele_cfg_model->incrementMemberBalance($trade['t_post_fee']);
            $record_model = new App_Model_Plugin_MysqlEleRecordStorage($this->curr_sid);
            $set = array(
                't_need_express'    => 0,
                't_status'          => 3,
                't_ele_tid' => App_Plugin_Weixin_PayPlugin::makeMchOrderid($trade['t_s_id']),//为蜂鸟配送重新生成唯一性订单ID
            );
            $trade_model->findUpdateTradeByTid($trade['t_tid'],$set);
            $indata = array(
                'er_description' => '订单取消',
                'er_stauts' => -1,
                'er_update_time' => time()
            );
            $record_model->findRowByTid($tid, $indata);
            $this->showAjaxResult(1, '取消');
        }else{
            $this->displayJsonError($ret['errmsg']);
        }
    }
    public function complainEleOrderAction(){
        $tid = $this->request->getStrParam('tid');
        $code = $this->request->getIntParam('code');
        $ele    = new App_Plugin_Food_AnubisEle();
        $ret    = $ele->complaintSendOrder($tid, $code);
        if($ret['errcode'] == 0){
            $record_model = new App_Model_Plugin_MysqlEleRecordStorage($this->curr_sid);
            $indata = array(
                'er_description' => '已投诉',
                'er_stauts' => -2,
                'er_update_time' => time()
            );
            $record_model->findRowByTid($tid, $indata);
            $this->showAjaxResult(1, '投诉');
        }else{
            $this->displayJsonError($ret['errmsg']);
        }
    }

    
    public function changeEleSendAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $value   = $this->request->getStrParam('value');

        $status = $value == 'on' ? 1 : 0;

        

        $send_storage = new App_Model_Cake_MysqlCakeSendStorage($this->curr_sid);
        $sendCfg = $send_storage->findUpdateBySid();
        if($sendCfg){
            $data['acs_ele_delivery'] = $status;
            $ret = $send_storage->findUpdateBySid($data);
        }else{
            $data=array(
                'acs_s_id'=>$this->curr_sid,
                'acs_es_id' => 0,
                'acs_update_time' => time(),
                'acs_ele_delivery' => $status
            );
            $ret = $send_storage->insertValue($data);
        }

        if ($ret) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功'
            );
            App_Helper_OperateLog::saveOperateLog("配送方式修改成功");
        }
        $this->displayJson($result);
    }

    
    public function delEleOrderAction(){
        $id = $this->request->getIntParam('id');
        $set = array('er_deleted' => 1);
        $record_model = new App_Model_Plugin_MysqlEleRecordStorage($this->curr_sid);
        $row = $record_model->getRowById($id);
        $ret = $record_model->updateById($set, $id);

        if($ret){
            App_Helper_OperateLog::saveOperateLog("配送订单【{$row['er_tid']}】删除成功");
        }

        $this->showAjaxResult($ret, '删除');
    }


    
    public function otherLegworkCfgAction(){
        $showSecondLink = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6])){
            $showSecondLink = 1;
            $this->legworkSecondLink('index');
        }
        $this->output['showSecondLink'] = $showSecondLink;


        $cfg_model = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->curr_sid);
        $sendCfg = $cfg_model->findUpdateBySid();
        $this->output['sendCfg'] = $sendCfg;
        $section = [];
        if($sendCfg){
            $sectionArr = json_decode($sendCfg['aolc_price_section'],1);
            if(!empty($sectionArr) && is_array($sectionArr)){
                $section = $sectionArr;
            }
        }
        $bindName = '';
        if($sendCfg['aolc_appid']){
            $applet_model = new App_Model_Applet_MysqlCfgStorage();
            $where[] = ['name'=>'ac_appid','oper'=>'=','value'=>$sendCfg['aolc_appid']];
            $applet = $applet_model->getRow($where);
            $bindName = $applet['ac_name'];
        }
        $this->output['bindName'] = $bindName;
        $this->output['section'] = $section;

        $tpl_msg_model  = new App_Model_Applet_MysqlWeixinTplMsgStorage($this->curr_sid);
        $where = [];
        $where[] = array('name' => 'awt_s_id','oper' => '=', 'value' => $this->curr_sid);
        $where[] = array('name' => 'awt_deleted','oper' => '=', 'value' => 0);
        $tplList = $tpl_msg_model->getList($where,0,0);
        $setup_model = new App_Model_Applet_MysqlWeixinTplMsgSetupStorage($this->curr_sid);
        $row = $setup_model->findOneBySid();

        $this->output['tplList'] = $tplList;
        $this->output['row'] = $row;

        $this->buildBreadcrumbs(array(
            array('title' => '插件管理', 'link' => '#'),
            array('title' => '跑腿配送', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/legwork/other-legwork-cfg.tpl');
    }


    
    public function changeLegworkOpenAction()
    {
        $result = array(
            'ec' => 400,
            'em' => '修改失败'
        );
        $value   = $this->request->getStrParam('value');

        $status = $value == 'on' ? 1 : 0;

        $send_storage = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->curr_sid);
        $sendCfg = $send_storage->findUpdateBySid();
        if($sendCfg){
            $data['aolc_open'] = $status;
            $ret = $send_storage->findUpdateBySid($data);
        }else{
            $data=array(
                'aolc_s_id'=>$this->curr_sid,
                'aolc_es_id' => 0,
                'aolc_open' => $status,
                'aolc_update_time' => time(),
            );
            $ret = $send_storage->insertValue($data);
        }

        if ($ret) {
            $result = array(
                'ec' => 200,
                'em' => ' 修改成功'
            );
            $str = $status == 1 ? '开启' : '关闭';
            App_Helper_OperateLog::saveOperateLog("{$str}跑腿配送成功");
        }
        $this->displayJson($result);
    }

    
    private function _is_price_cross($min1 = '', $max1 = '', $min2 = '', $max2 = '') {
        $status = $min2 - $min1;
        if ($status > 0) {
            $diff = $min2 - $max1;
            if ($diff >= 0) {
                return false;
            } else {
                return true;
            }
        } else {
            $diff = $max2 - $min1;
            if ($diff > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function saveLegworkCfgAction(){



        $appid = $this->request->getStrParam('appid');
        $sectionArr = $this->request->getArrParam('sectionArr');
        $sectionValue = [];
        $cross = false;
        if(is_array($sectionArr) && !empty($sectionArr)){
            foreach ($sectionArr as $item){
                if($item['min'] >= 0 && $item['max'] > 0 && $item['value'] > 0){
                    if($item['min'] >= $item['max']){
                        $this->displayJsonError('运费最小值必须小于最大值');
                    }
                    $sectionValue[] = $item;
                }
            }
            if(!empty($sectionValue)){
                for($i=0;$i<count($sectionValue);$i++){
                    for($j=$i+1;$j<count($sectionValue);$j++){
                        $cross = $this->_is_price_cross($sectionValue[$i]['min'],$sectionValue[$i]['max'],$sectionValue[$j]['min'],$sectionValue[$j]['max']);
                        if($cross){
                            $this->displayJsonError('有重复区间');
                        }
                    }
                }
            }
        }
        $sectionValue = json_encode($sectionValue);

        $ret = false;
        $applet = [];
        if($appid){
            $applet_model = new App_Model_Applet_MysqlCfgStorage();
            $where = [];
            $where[] = ['name'=>'ac_appid','oper'=>'=','value'=>$appid];
            $where[] = ['name'=>'ac_type','oper'=>'=','value'=>34];
            $applet = $applet_model->getRow($where);
            if(!$applet){
                $this->displayJsonError('未找到小程序');
            }
        }
        $send_storage = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->curr_sid);
        $sendCfg = $send_storage->findUpdateBySid();
        if($sendCfg){
            $data['aolc_appid'] = $appid;
            $data['aolc_legwork_sid'] = $applet['ac_s_id'];
            $data['aolc_price_section'] = $sectionValue;
            $data['aolc_update_time'] = time();
            $ret = $send_storage->findUpdateBySid($data);
        }else{
            $data=array(
                'aolc_s_id'=>$this->curr_sid,
                'aolc_appid' => $appid,
                'aolc_legwork_sid' => $applet['ac_s_id'],
                'aolc_price_section' => $sectionValue,
                'aolc_update_time' => time(),
            );
            $ret = $send_storage->insertValue($data);
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("跑腿配送配置保存成功");
        }

        $this->showAjaxResult($ret,'保存');
    }

    
    public function blessingSetAction(){
        $this->buildBreadcrumbs(array(
            array('title' => '店铺祝福语设置', 'link' => '#'),
        ));
        $blessing_storage = new App_Model_Blessing_MysqlBlessingCfgStorage($this->curr_sid);
        $cfg = $blessing_storage->findUpdateBySid();
        if(!$cfg){
            $cfg['abc_blessing'] = plum_parse_config('defaultContent','system');
            $cfg['abc_blessing_title'] = plum_parse_config('defaultName','system');
        }
        $this->output['blessingCfg'] = $cfg;
        $this->displaySmarty('wxapp/blessing/set-blessing.tpl');
    }

    
    public function saveBlessingAction(){
        $blessingMusic = $this->request->getStrParam('blessingMusic');
        $blessingTitle = $this->request->getStrParam('blessingTitle');
        $blessingContent = $this->request->getStrParam('blessingContent');
        $blessing_storage = new App_Model_Blessing_MysqlBlessingCfgStorage($this->curr_sid);
        $cfg = $blessing_storage->findUpdateBySid();
        if($blessingTitle && $blessingContent){
            $data = array(
                'abc_s_id'           => $this->curr_sid,
                'abc_blessing_title' => $blessingTitle,
                'abc_blessing'       => $blessingContent,
                'abc_music'          => $blessingMusic,
                'abc_update_time'    => time(),
            );
            if($cfg){
                $ret = $blessing_storage->findUpdateBySid($data);
            }else{
                $data['abc_create_time'] = time();
                $ret = $blessing_storage->insertValue($data);
            }

            if($ret){
                App_Helper_OperateLog::saveOperateLog("祝福语配置保存成功");
            }

            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('请将信息填写完整');
        }
    }

    
    public function shopPostFeeAction(){
        $showSecondLink = 0;
        if(in_array($this->wxapp_cfg['ac_type'],[6])){
            $showSecondLink = 1;
            $this->legworkSecondLink('postFee');
        }
        $this->output['showSecondLink'] = $showSecondLink;

        $status = $this->request->getIntParam('status',0);
        $sid    = $this->curr_sid;
        $this->output['status'] = $status;
        $page         = $this->request->getIntParam('page');
        $this->output['esId'] = $this->request->getIntParam('esId',0);
        $index        = $page*$this->count;
        $list = [];
        $statInfo = [];
        $send_storage = new App_Model_Legwork_MysqlOtherLegworkCfgStorage($this->curr_sid);
        $sendCfg = $send_storage->findUpdateBySid();
        if($sendCfg && $sendCfg['aolc_appid']){
            if($sendCfg['aolc_legwork_sid'] <= 0){
                $applet_model = new App_Model_Applet_MysqlCfgStorage();
                $applet = [];
                $applet[] = ['name'=>'ac_appid','oper'=>'=','value'=>$sendCfg['aolc_appid']];
                $applet = $applet_model->getRow($applet);
                $sendCfg['aolc_legwork_sid'] = $applet['ac_s_id'];
                $send_storage->findUpdateBySid(['aolc_legwork_sid' => $applet['ac_s_id']]);
            }
            $sort = array('alsp_create_time' => 'DESC');
            $where[] = $where_total[] = $where_verify[] = array('name'=>'alsp_s_id','oper'=>'=','value'=>$sendCfg['aolc_legwork_sid']);
            $where[] = $where_total[] = $where_verify[] = array('name'=>'alsp_other_sid','oper'=>'=','value'=>$sid);
            if($this->output['esId'] > 0){
                $where[] = $where_total[] = $where_verify[] = array('name' => 'alsp_other_esid', 'oper' => '=', 'value' => $this->output['esId']);
            }elseif ($this->output['esId'] < 0){
                $where[] = $where_total[] = $where_verify[] = array('name' => 'alsp_other_esid', 'oper' => '=', 'value' => 0);
            }

            if($status){
                $where[] = array('name'=>'alsp_status','oper'=>'=','value'=>$status);
            }
            $deduct_model = new App_Model_Legwork_MysqlLegworkShopPostStorage($this->curr_sid);
            $total              = $deduct_model->getCount($where);
            $page_libs          = new Libs_Pagination_Paginator($total,$this->count,'jquery',true);
            $this->output['pageHtml'] =$page_libs->render();
            $list = $deduct_model->getList($where,$index,$this->count,$sort);
            $this->output['list'] = $list;

            $where_verify[] = array('name'=>'alsp_status','oper'=>'=','value'=>2);
            $totalMoney = $deduct_model->getSum($where_total);
            $verifyMoney = $deduct_model->getSum($where_verify);
            $noverifyMoney = floatval($totalMoney) - floatval($verifyMoney);
            $statInfo = [
                'total' => floatval($totalMoney),
                'verify' => floatval($verifyMoney),
                'noverify' => $noverifyMoney > 0 ? $noverifyMoney : 0
            ];
        }
        $this->_entershop_for_select(true);

        $this->output['list'] = $list;
        $this->output['statInfo'] = $statInfo;

        $bread = [
            array('title' => '跑腿配送', 'link' => '#'),
            array('title' => '配送费记录', 'link' => '#'),
        ];

        $this->buildBreadcrumbs(
            $bread
        );
        $this->displaySmarty('wxapp/plugin/shop-post-fee.tpl');
    }

    
    private function _entershop_for_select($all = false){
        $where[] = array('name'=>'es_s_id','oper'=>'=','value'=>$this->curr_sid);
        if(!$all){
            $where[] = array('name'=>'es_status','oper'=>'=','value'=>0);
        }


        $shop_model = new App_Model_Entershop_MysqlEnterShopStorage();
        $sort    = array('es_createtime' => 'DESC');
        $list    = $shop_model->getList($where,0,0,$sort);

        $data = array();
        $selectShop = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'   => $val['es_id'],
                    'name' => $val['es_name']
                );
                $selectShop[$val['es_id']] = $val['es_name'];
            }
        }
        $this->output['shoplist'] = json_encode($data);
        $this->output['selectShop'] = $selectShop;
    }

    

    public function legworkSecondLink($type='index',$returnInfo = false){
        $link = array(
            array(
                'label' => '跑腿配置',
                'link'  => '/wxapp/plugin/otherLegworkCfg',
                'active'=> 'index'
            ),
            array(
                'label' => '配送费记录',
                'link'  => '/wxapp/plugin/shopPostFee',
                'active'=> 'postFee'
            ),
        );
        $sinTitle = '跑腿配送';
        if($returnInfo){
            return array(
                'link' => $link,
                'linkType' => $type,
                'snTitle'  => $sinTitle
            );
        }else{
            $this->output['link']       = $link;
            $this->output['linkType']   = $type;
            $this->output['snTitle']    = $sinTitle;
        }
    }



}