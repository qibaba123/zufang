<?php

class App_Controller_Wxapp_ChildController extends App_Controller_Wxapp_InitController {

    private $child_model;

    public function __construct()
    {
        parent::__construct();
        $this->child_model  = new App_Model_Applet_MysqlChildStorage($this->curr_sid);
    }

    public function indexAction() {
        $this->checkAgentClose('child');

        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '/wxapp/child/index'),
            array('title' => '小程序分身', 'link' => '#'),
        ));
        $where[]        = array('name' => 'ac_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $list           = $this->child_model->getList($where, 0, 0, array('ac_update_time' => 'DESC'));

        $func_scope = plum_parse_config('func_scope', 'applet');

        foreach ($list as &$item) {
            $has_func   = json_decode($item['ac_func_scope'], true);
            $span       = '<ul>';
            foreach ($func_scope as $key => $func) {
                $span   .= '<li>'.(in_array($key, $has_func) ? '<span class="green">已授权</span>' : '<span class="red">未授权</span>').$func['name'].'</li>';
            }
            $span   .= '</ul>';
            $item['scope_desc'] = $span;
        }
        $this->output['list']   = $list;
        $this->output['surplus']    = $this->wxapp_cfg['ac_insert_total']-$this->wxapp_cfg['ac_insert_use'];
        $this->displaySmarty('wxapp/child/index.tpl');
    }
    
    public function grantAuthAction() {
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '/wxapp/child/index'),
            array('title' => '子账号授权', 'link' => '#'),
        ));
        $appid      = $this->request->getStrParam('appid');
        $surplus    = $this->wxapp_cfg['ac_insert_total']-$this->wxapp_cfg['ac_insert_use'];
        if ($surplus > 0 || $appid) {
            $plat_type  = $this->fetchPlatformType();
            $plat_cfg   = plum_parse_config('platform', 'wxxcx');
            $auth_domain    = $plat_cfg[$plat_type]['auth_domain'];

            $this->output['authdomain'] = "http://".$auth_domain;
            if ($auth_domain == plum_get_server('http_host')) {
                $auth   = $this->fetchPreAuthCode('child');
                $this->output['auth_uri']   = $auth ? $auth : '#';

                $this->displaySmarty('wxapp/child/bangding.tpl');
            } else {
                $encode = array(
                    'm_id'      => $this->manager['m_id'],
                    'sid'       => $this->curr_sid,
                    'suid'      => $this->curr_shop['s_unique_id'],
                    'ac_id'     => $this->wxapp_cfg['ac_id'],
                    'ac_type'   => $this->wxapp_cfg['ac_type'],
                    'ac_insert_total'   => $this->wxapp_cfg['ac_insert_total'],
                    'ac_insert_use'   => $this->wxapp_cfg['ac_insert_use'],
                    'from'      => plum_get_base_host(),
                    'platform'  => $plat_type,
                    'domain'    => $auth_domain,
                );
                $encode = http_build_query($encode);
                $token  = plum_parse_config('encode_token', 'wxxcx');
                $code   = plum_authcode($encode, 'ENCODE', $token);
                $authcode = rawurlencode($code);
                $this->output['authcode'] = rawurlencode($code);
                plum_redirect("http://".$auth_domain.'/manage/user/childCenter?loginid='.$authcode);
            }
        } else {
            $url    = plum_get_server('HTTP_REFERER', '/wxapp/child/index');
            plum_redirect_with_msg('您目前可授权接入的分身小程序数量为0,请联系您的服务商已增加更多可授权分身小程序数量。', $url, 8);
        }
    }

    
    public function codeAction() {
        $appid      = $this->request->getStrParam('appid');
        $child      = $this->child_model->fetchUpdateWxcfgByAid($appid);

        if (!$child) {
            plum_redirect_with_msg('未找到对应的小程序子账号', '/wxapp/child/index');
        }

        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '/wxapp/child/index'),
            array('title' => '开发管理', 'link' => '#'),
        ));
        $wxapp_kind = plum_parse_config('category', 'applet');
        $wxapp_curr = $wxapp_kind[$this->wxapp_cfg['ac_type']];
        $has_func   = json_decode($child['ac_func_scope'], true);
        if (in_array(18, $has_func)) {
            $this->output['wxxcx_app']  = $wxapp_curr;
            $this->output['wxxcx_cfg']  = $child;
            $bottom     = $this->wxapp_cfg['ac_bottom_menu'];
            if ($bottom) {
                $menu   = json_decode($bottom, true);
                $bottom = $menu['list'];
            } else {
                $pages_model    = new App_Model_Applet_MysqlAppletPageStorage();
                $pages      = $pages_model->fetchDefaultAction($this->wxapp_cfg['ac_type']);
                $bottom     = array();
                foreach ($pages as $item) {
                    $bottom[]   = array(
                        'pagePath'      => $item['ap_path'],
                        'text'          => $item['ap_text'],
                        'iconPath'      => $item['ap_icon'].'.png',
                    );
                }
            }
            $this->output['bottom']     = $bottom;
            $this->output['wxxcx_first']= $this->wxapp_cfg;
            $this->displaySmarty('wxapp/child/code.tpl');
        } else {//未将开发管理权限授权给天店通
            $this->output['ac_name']    = $child['ac_name'];
            $this->output['ac_avatar']  = $child['ac_logo'];
            $auth   = $this->fetchPreAuthCode('child');
            $this->output['auth_uri']   = $auth ? $auth : '#';
            $this->displaySmarty('wxapp/setup/no-code.tpl');
        }
    }

    private function _check_applet() {
        $appid  = $this->request->getStrParam('appid');
        $child  = $this->child_model->fetchUpdateWxcfgByAid($appid);

        if (!$child || $child['ac_s_id'] != $this->curr_sid) {
            $this->displayJsonError('未查找到对应的小程序子账号');
        }
        return $child;
    }

    public function setupAction() {
        $this->buildBreadcrumbs(array(
            array('title' => '小程序分身', 'link' => '/wxapp/child/index'),
            array('title' => '开发设置', 'link' => '#'),
        ));
        $child      = $this->_check_applet();
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxChild($this->curr_sid, $child['ac_appid']);
        if (!$child['ac_wxacode']) {
            $filepath       = $wxxcx_client->fetchWxappCode();

            if ($filepath) {
                $this->child_model->updateById(array('ac_wxacode' => $filepath), $child['ac_id']);
                $child['ac_wxacode']  = $filepath;
            }
        }
        $has_func   = json_decode($child['ac_func_scope'], true);
        $func_scope = plum_parse_config('func_scope', 'applet');
        $span       = '<pre>';
        foreach ($func_scope as $key => $func) {
            $span   .= (in_array($key, $has_func) ? '<span class="green">已授权</span>' : '<span class="red">未授权</span>').":&#9;".$func['name'].'<br/>';
        }
        $span   .= '</pre>';
        $this->output['func_scope'] = $span;

        $help       = new App_Helper_ShopWeixin($this->curr_sid);
        $token_url  = $help->fetchWeixinTokenUrl('wxxcx');

        $this->output['plat_info']  = array(
            'cb_token'      => $token_url['token'],
            'cb_url'        => $token_url['url'],
            'cb_category'   => json_decode($child['ac_category'], true),
        );
        $this->output['row'] = $child;

        $server_domain  = plum_parse_config('server', 'wxxcx');
        $domain         = isset($server_domain[$this->wxapp_cfg['ac_type']]) ? $server_domain[$this->wxapp_cfg['ac_type']]['domain'] : plum_parse_config('domain', 'wxxcx');
        $this->output['domain'] = array(
            'req'   => join(';', $domain['req']),
            'wss'   => join(';', $domain['wss']),
            'upl'   => join(';', $domain['upl']),
            'dow'   => join(';', $domain['dow']),
        );

        $this->displaySmarty('wxapp/child/setup.tpl');
    }

    
    private function _fetch_jump_list(){
        $data = array();
        if($this->wxapp_cfg['ac_type']==21 || $this->wxapp_cfg['ac_type']==1){
            $data[] = 'wxeb490c6f9b154ef9';
        }
        if($this->wxapp_cfg['ac_type']==30){
            $game_model = new App_Model_Gamebox_MysqlGameboxGameStorage($this->curr_sid);
            $where[] = array('name'=>'agg_s_id','oper'=>'=','value'=>$this->curr_sid);
            $where[] = array('name'=>'agg_jump_type','oper'=>'=','value'=>1);
            $list = $game_model->getList($where,0,10);
            if($list){
                foreach ($list as $val){
                    if($val['agg_appid'] && count($data)<10){
                        $data[] = $val['agg_appid'];
                    }
                }
            }
        }else{
            $list = $this->_get_jump_list(true);
            if($list){
                foreach ($list as $val){
                    if($val['aj_appid'] && count($data)<10){
                        $data[] = $val['aj_appid'];
                    }
                }
            }
        }
        return $data;
    }

    
    private function _submit_code_outside(){
        $webcfg_storage = new App_Model_Applet_MysqlAppletWebcfgStorage($this->curr_sid);
        $cfg = $webcfg_storage->findUpdateBySid();
        $page_data = array();
        if($cfg && ($cfg["awc_web1"] || $cfg["awc_web2"] ||$cfg["awc_web3"] || $cfg["awc_web4"] || $cfg["awc_web5"])){
            for($i=1;$i<=5;$i++){
                if(isset($cfg["awc_web$i"]) && $cfg["awc_web$i"]){
                    $key = 'pages/webviewTab'.$i.'/webviewTab'.$i;
                    $page_data[$key] = $cfg["awc_web$i"];
                }
            }
        }
        return $page_data;
    }

    
    private function _submit_code_custom_page(){
        $webcfg_storage = new App_Model_Applet_MysqlAppletCustompageStorage($this->curr_sid);
        $cfg = $webcfg_storage->findUpdateBySid();
        $page_data = array();
        if($cfg && ($cfg["acpc_page1"] || $cfg["acpc_page2"] ||$cfg["acpc_page3"] || $cfg["acpc_page4"] || $cfg["acpc_page5"])){
            for($i=1;$i<=5;$i++){
                if(isset($cfg["acpc_page$i"]) && $cfg["acpc_page$i"]){
                    $key = 'pages/webviewTab'.$i.'/webviewTab'.$i;
                    $page_data[$key] = $cfg["acpc_page$i"];
                }
            }
        }
        return $page_data;
    }

    
    public function stopAuthAction() {
        $appid  = $this->request->getStrParam('appid');

        $where[]    = array('name' => 'ac_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $where[]    = array('name' => 'ac_appid', 'oper' => '=', 'value' => $appid);

        $ret    = $this->child_model->deleteValue($where);
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $update = array(
            'ac_insert_use'   => $this->wxapp_cfg['ac_insert_use'] - 1
        );
        $applet_model->findShopCfg($update);
        if ($ret) {
            $this->displayJsonSuccess();
        } else {
            $this->displayJsonError('停止授权失败,请重试!');
        }
    }

    public function payCfgAction() {
        $id = $this->request->getIntParam('id');
        $pay_model      = new App_Model_Applet_MysqlChildStorage($this->curr_sid);
        $appletPay         = $pay_model->getRowById($id);

        $this->output['appletPay'] = $appletPay;

        $this->buildBreadcrumbs(array(
            array('title' => '小程序分身', 'link' => '/wxapp/child/index'),
            array('title' => '分身支付配置', 'link' => '#'),
        ));
        $this->displaySmarty("wxapp/child/paycfg.tpl");
    }

    
    private function deal_save_pay($pre,$req_key){
        $id = $this->request->getIntParam('acid');
        $data = array();
        foreach($req_key as $val){
            $data[$pre.$val] = $this->request->getStrParam($val);
        }
        $data[$pre.'update_time'] = time();

        $pay_model     = new App_Model_Applet_MysqlChildStorage($this->curr_sid);
        $ret           = $pay_model->updateById($data, $id);
        if($ret){
            $result = array(
                'ec' => 200,
                'em' => '保存成功'
            );
        }else{
            $result = array(
                'ec' => 400,
                'em' => '保存失败'
            );
        }
        return $result;
    }

}