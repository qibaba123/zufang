<?php

class App_Controller_Wxapp_SetupController extends App_Controller_Wxapp_InitController{
    const PROMOTION_TOOL_KEY = 'gdb';

    public function __construct() {
        parent::__construct();
    }

    
    public function secondLink($type='cfg'){
        $link = array(
            array(
                'label' => '菜单导航',
                'link'  => '/wxapp/setup/bottomMenu',
                'active'=> 'cfg'
            ),
            array(
                'label' => '菜单列表',
                'link'  => '/wxapp/setup/bottomMenulist',
                'active'=> 'bottommenulist'
            ),
        );


        $this->output['link']       = $link;
        $this->output['linkType']   = $type;
        $this->output['snTitle']    = '菜单管理';
    }

    public function indexAction() {
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '开发设置', 'link' => '#'),
        ));
        $this->_auth_code_uri();

        $wechat_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $row            = $wechat_model->findShopCfg();

        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $this->output['overdue']    = $wxxcx_client->access_token ? 'no' : 'yes';
        if (!$row['ac_wxacode']) {
            if($this->wxapp_cfg['ac_type'] == 15 || $this->wxapp_cfg['ac_type'] == 31){
                $filepath       = $wxxcx_client->fetchWxappCode();
            }else{
                $filepath       = $wxxcx_client->fetchWxappCode('pages/singlePage/singlePage');
            }

            if ($filepath) {
                $wechat_model->updateById(array('ac_wxacode' => $filepath), $row['ac_id']);
                $row['ac_wxacode']  = $filepath;
            }
        }
        if (!$row['ac_open_appid']) {
            $result     = $wxxcx_client->getOpenAppid($this->wxapp_cfg['ac_appid']);
            
            if ($result['errcode'] == 0) {//获取成功
                $wechat_model->updateById(array('ac_open_appid' => $result['open_appid']), $row['ac_id']);
                $row['ac_open_appid']  = $result['open_appid'];
            }
        }
        $has_func   = json_decode($row['ac_func_scope'], true);
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
            'cb_category'   => json_decode($row['ac_category'], true),
        );
        $this->output['row'] = $row;

        $server_domain  = plum_parse_config('server', 'wxxcx');
        $domain         = isset($server_domain[$this->wxapp_cfg['ac_type']]) ? $server_domain[$this->wxapp_cfg['ac_type']]['domain'] : plum_parse_config('domain', 'wxxcx');
        $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);
        $qiniu       = $qiniu_model->findRowCfg();
        if($qiniu){
            $url  = plum_parse_config('url', 'qiniu');
            $domain['upl'][] = $url[$qiniu['aq_bucket_zone']];
        }
        $this->output['domain'] = array(
            'req'   => join(';', $domain['req']),
            'wss'   => join(';', $domain['wss']),
            'upl'   => join(';', $domain['upl']),
            'dow'   => join(';', $domain['dow']),
        );

        $this->displaySmarty('wxapp/setup/index.tpl');
    }
    
    private function _auth_code_uri(){
        $plat_type  = $this->fetchPlatformType();
        $plat_cfg   = plum_parse_config('platform', 'wxxcx');
        $auth_domain    = $plat_cfg[$plat_type]['auth_domain'];

        $this->output['authdomain'] = "http://".$auth_domain;
        if ($auth_domain == plum_get_server('http_host')) {
            $auth   = $this->fetchPreAuthCode();
            $this->output['authcode']   = $auth ? $auth : '#';
            $this->output['authtype']   = 'domain';
        } else {
            $encode = array(
                'm_id'      => $this->manager['m_id'],
                'sid'       => $this->curr_sid,
                'suid'      => $this->curr_shop['s_unique_id'],
                'ac_id'     => $this->wxapp_cfg['ac_id'],
                'ac_type'   => $this->wxapp_cfg['ac_type'],
                'from'      => plum_get_base_host(),
                'platform'  => $plat_type,
                'domain'    => $auth_domain,
            );
            $encode = http_build_query($encode);
            $token  = plum_parse_config('encode_token', 'wxxcx');
            $code   = plum_authcode($encode, 'ENCODE', $token);
            $this->output['authcode'] = rawurlencode($code);
            $this->output['authtype']   = 'redirect';
        }
    }
    
    public function codeAction() {
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '审核管理', 'link' => '#'),
        ));
        $has_func   = json_decode($this->wxapp_cfg['ac_func_scope'], true);
        if (in_array(18, $has_func)) {
            $wxapp_kind = plum_parse_config('category', 'applet');
            $wxapp_curr = $wxapp_kind[$this->wxapp_cfg['ac_type']];

            $this->output['wxxcx_app']  = $wxapp_curr;
            $this->output['wxxcx_cfg']  = $this->wxapp_cfg;
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

            $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
            $overdue        = 'no';
            if (!$wxxcx_client->access_token) {
                $overdue    = 'yes';
                $this->_auth_code_uri();
            }
            $this->output['overdue']    =  $overdue;
            $kind   = intval($this->wxapp_cfg['ac_type']);
            $extra  = plum_parse_config('extra', "wxmenu/xcx-".$kind);
            $this->output['had_menu']   = plum_check_array_key('bottom', $extra, true);

            $this->output['bottom']     = $bottom;
            $this->displaySmarty('wxapp/setup/code.tpl');
        } else {//未将开发管理权限授权给天店通
            $this->output['ac_name']    = $this->wxapp_cfg['ac_name'];
            $this->output['ac_avatar']  = $this->wxapp_cfg['ac_avatar'];
            $this->_auth_code_uri();
            $this->displaySmarty('wxapp/setup/no-code.tpl');
        }
    }
    
    public function editionCodeAction() {
        $wxapp_kind = plum_parse_config('category', 'applet');
        $wxapp_curr = $wxapp_kind[$this->wxapp_cfg['ac_type']];

        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $server_domain  = plum_parse_config('server', 'wxxcx');
        $domain         = isset($server_domain[$this->wxapp_cfg['ac_type']]) ? $server_domain[$this->wxapp_cfg['ac_type']]['domain'] : plum_parse_config('domain', 'wxxcx');
        $aldwxCfg_model = new App_Model_Plugin_MysqlAldwxCfgStorage($this->curr_sid);
        $aldCfg = $aldwxCfg_model->fetchUpdateCfg();
        if($aldCfg){
            $domain['req'][] = 'https://log.aldwx.com';
        }
        $isvip = false;
        $vipreurl = '';
        if($this->wxapp_cfg['ac_vip_grade']>0){
            if($this->wxapp_cfg['ac_vip_domain'] && isset($this->wxapp_cfg['ac_vip_domain'])){
                $domain['req'][] = $this->wxapp_cfg['ac_vip_domain'];
                $vipreurl = $this->wxapp_cfg['ac_vip_domain'];
            }else{
                $domain['req'][] = 'https://www.tdotapp.com';
                $vipreurl = 'https://www.tdotapp.com';
            }
            $isvip = true;
        }
        $wxxcx_client->coverCodeDomain($domain['req'], $domain['wss'], $domain['upl'], $domain['dow'], 'add');
        $navbar = $this->wxapp_cfg['ac_navigation_bar'];
        if($navbar){
            $window = json_decode($navbar,true);
        }else{
            $window = array(
                'navigationBarBackgroundColor'  => '#FFFFFF',
                'navigationBarTextStyle'        => 'black',
            );
        }
        $window['navigationBarTitleText']   = $this->wxapp_cfg['ac_name'];
        $window['backgroundColor']          = $window['navigationBarBackgroundColor'];
        $window['backgroundTextStyle']      = $window['navigationBarTextStyle'] == 'white' ? 'light' : 'dark';
        $extjson    = array(
            'extAppid'      => $this->wxapp_cfg['ac_appid'],
            'ext'           => array(
                'suid'      => $this->shops[$this->curr_sid]['s_unique_id'],
                'version'   => $wxapp_curr['version'],
                'base'      => $wxapp_curr['base'],
                'appid'     => $this->wxapp_cfg['ac_appid'],
                'navigationBarBackgroundColor'  => $navbar ? $window['navigationBarBackgroundColor'] : '',
                'navigationBarTextStyle'        => $navbar ? $window['navigationBarTextStyle'] : '',
                'isvip'     => $isvip,
                'vipreurl'  => $vipreurl
            ),
            'window'        => $window
        );
        if(isset($this->wxapp_cfg['ac_app_key']) && $this->wxapp_cfg['ac_app_key']){
            $extjson['ext']['app_key'] = $this->wxapp_cfg['ac_app_key'];
        }
        $aldwxCfg_model = new App_Model_Plugin_MysqlAldwxCfgStorage($this->curr_sid);
        $aldwxCfg = $aldwxCfg_model->fetchUpdateCfg();

        $extjson['ext']['ald_config'] = array(
            'app_key' => $aldwxCfg['ac_app_key']?$aldwxCfg['ac_app_key']:'',
            'getLocation' => false,
            'plugin' => $wxapp_curr['plugin']
        );
        $tabbar         = $this->wxapp_cfg['ac_bottom_menu'];
        if ($tabbar) {
            $tabbar     = json_decode($tabbar, true);
            $count      = count($tabbar['list']);
            if ($count > 1 && $count < 6) {
                $menu       = array();
                $webviewlink = array();
                $pageviewLink = array();
                $weblink = $this->_submit_code_outside();
                $pageLink = $this->_submit_code_custom_page();
                $prefix = 'images/icon';
                $cartIndex = '';
                foreach ($tabbar['list'] as $key => &$item) {
                    $menu[$item['pagePath']]    = $item['text'];
                    if($item['pagePath'] == "pages/mycartTab/mycartTab" || $item['pagePath'] == "pages/mycart/mycart"){
                        $cartIndex = $key;
                    }
                    if(isset($item['setIndex']) && $item['setIndex'] && $item['setIndex']==1){
                        $extjson['ext']['indexUrl'] = $item['pagePath'];
                    }
                    if(isset($weblink[$item['pagePath']]) && $weblink[$item['pagePath']]){
                        $webviewlink[$item['pagePath']] = $weblink[$item['pagePath']];
                    }
                    if(isset($pageLink[$item['pagePath']]) && $pageLink[$item['pagePath']]){
                        $pageviewLink[$item['pagePath']] = $pageLink[$item['pagePath']];
                    }
                    $item['iconPath']   = $prefix.$item['iconPath'];
                    $item['selectedIconPath']   = $prefix.$item['selectedIconPath'];
                }
                $extjson['tabBar']          = $tabbar;
                $extjson['ext']['menu']     = $menu;
                $extjson['ext']['cartIndex']    = $cartIndex;
                $extjson['ext']['webviewlink']  = $webviewlink;
                $extjson['ext']['pageviewlink'] = $pageviewLink;
                if(!$extjson['ext']['indexUrl']){
                    $extjson['ext']['indexUrl'] = $tabbar['list'][0]['pagePath'];
                }
            }
        }
        $jumpList = $this->_fetch_jump_list();
        if($jumpList && !empty($jumpList)){
            $extjson['navigateToMiniProgramAppIdList'] = $jumpList;
        }
        Libs_Log_Logger::outputLog($extjson,'test.log');
        $ret    = $wxxcx_client->commitTemplateCode($wxapp_curr['codeid'], json_encode($extjson), $wxapp_curr['version'], $wxapp_curr['desc']);
        Libs_Log_Logger::outputLog($ret,'test.log');
        if (!$ret['errcode']) {
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $updata = array(
                'ac_experience_base'     => $wxapp_curr['base'],
                'ac_experience_version'  => $wxapp_curr['version'],
            );
            $applet_model->findShopCfg($updata);//修改小程序代码为最新版
            $this->displayJsonSuccess(null, true);
        } else {
            $this->displayJson(array('ec' => 400, 'em' => $ret['errmsg'], 'err' => $ret['errcode']));
        }
    }
    
    public function submitCodeAction() {
        $title      = $this->request->getStrParam('wxapp_title');
        $tag        = $this->request->getStrParam('wxapp_tag');
        $auto       = $this->request->getIntParam('wxapp_auto', 1);//自动发布上线功能
        $wxapp_kind = plum_parse_config('category', 'applet');
        $wxapp_curr = $wxapp_kind[$this->wxapp_cfg['ac_type']];

        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $server_domain  = plum_parse_config('server', 'wxxcx');
        $domain         = isset($server_domain[$this->wxapp_cfg['ac_type']]) ? $server_domain[$this->wxapp_cfg['ac_type']]['domain'] : plum_parse_config('domain', 'wxxcx');
        $aldwxCfg_model = new App_Model_Plugin_MysqlAldwxCfgStorage($this->curr_sid);
        $aldCfg = $aldwxCfg_model->fetchUpdateCfg();
        if($aldCfg){
            $domain['req'][] = 'https://log.aldwx.com';
        }
        $isvip = false;
        $vipreurl = '';
        if($this->wxapp_cfg['ac_vip_grade']>0){
            if($this->wxapp_cfg['ac_vip_domain'] && isset($this->wxapp_cfg['ac_vip_domain'])){
                $domain['req'][] = $this->wxapp_cfg['ac_vip_domain'];
                $vipreurl = $this->wxapp_cfg['ac_vip_domain'];
            }else{
                $domain['req'][] = 'https://www.tdotapp.com';
                $vipreurl = 'https://www.tdotapp.com';
            }
            $isvip = true;
        }
        $domainret = $wxxcx_client->coverCodeDomain($domain['req'], $domain['wss'], $domain['upl'], $domain['dow'], 'add');
        $navbar = $this->wxapp_cfg['ac_navigation_bar'];
        if($navbar){
            $window = json_decode($navbar,true);
        }else{
            $window = array(
                'navigationBarBackgroundColor'  => '#FFFFFF',
                'navigationBarTextStyle'        => 'black',
            );
        }
        $window['navigationBarTitleText']   = $this->wxapp_cfg['ac_name'];
        $window['backgroundColor']          = $window['navigationBarBackgroundColor'];
        $window['backgroundTextStyle']      = $window['navigationBarTextStyle'] == 'white' ? 'light' : 'dark';
        $extjson    = array(
            'extAppid'      => $this->wxapp_cfg['ac_appid'],
            'ext'           => array(
                'suid'      => $this->shops[$this->curr_sid]['s_unique_id'],
                'version'   => $wxapp_curr['version'],
                'base'      => $wxapp_curr['base'],
                'appid'     => $this->wxapp_cfg['ac_appid'],
                'navigationBarBackgroundColor'  => $navbar ? $window['navigationBarBackgroundColor'] : '',
                'navigationBarTextStyle'        => $navbar ? $window['navigationBarTextStyle'] : '',
                'isvip'     => $isvip,
                'vipreurl'  => $vipreurl
            ),
            'window'        => $window
        );
        if(isset($this->wxapp_cfg['ac_app_key']) && $this->wxapp_cfg['ac_app_key']){
            $extjson['ext']['app_key'] = $this->wxapp_cfg['ac_app_key'];
        }
        $aldwxCfg_model = new App_Model_Plugin_MysqlAldwxCfgStorage($this->curr_sid);
        $aldwxCfg = $aldwxCfg_model->fetchUpdateCfg();

        $extjson['ext']['ald_config'] = array(
            'app_key' => $aldwxCfg['ac_app_key']?$aldwxCfg['ac_app_key']:'',
            'getLocation' => false,
            'plugin' => $wxapp_curr['plugin']
        );
        $address    = 'pages/index/index';
        $tabbar         = $this->wxapp_cfg['ac_bottom_menu'];
        if ($tabbar) {
            $tabbar     = json_decode($tabbar, true);
            $count      = count($tabbar['list']);
            if ($count > 1 && $count < 6) {
                $menu       = array();
                $webviewlink = array();
                $pageviewLink = array();
                $weblink = $this->_submit_code_outside();
                $pageLink = $this->_submit_code_custom_page();
                $prefix = 'images/icon';
                $cartIndex = '';
                foreach ($tabbar['list'] as $key=>&$item) {
                    $menu[$item['pagePath']]    = $item['text'];
                    if($item['pagePath'] == "pages/mycartTab/mycartTab" || $item['pagePath'] == "pages/mycart/mycart"){
                        $cartIndex = $key;
                    }
                    if(isset($weblink[$item['pagePath']]) && $weblink[$item['pagePath']]){
                        $webviewlink[$item['pagePath']] = $weblink[$item['pagePath']];
                    }
                    if(isset($pageLink[$item['pagePath']]) && $pageLink[$item['pagePath']]){
                        $pageviewLink[$item['pagePath']] = $pageLink[$item['pagePath']];
                    }
                    if(isset($item['setIndex']) && $item['setIndex'] && $item['setIndex']==1){
                        $extjson['ext']['indexUrl'] = $item['pagePath'];
                    }
                    $item['iconPath']   = $prefix.$item['iconPath'];
                    $item['selectedIconPath']   = $prefix.$item['selectedIconPath'];
                }
                $extjson['tabBar']          = $tabbar;
                $extjson['ext']['menu']     = $menu;
                $extjson['ext']['cartIndex']    = $cartIndex;
                if(!empty($webviewlink)){
                    $extjson['ext']['webviewlink']  = $webviewlink;
                }
                if(!empty($pageLink)){
                    $extjson['ext']['pageviewlink'] = $pageviewLink;
                }
                if(!$extjson['ext']['indexUrl']){
                    $extjson['ext']['indexUrl'] = $tabbar['list'][0]['pagePath'];
                }
            }
        }
        $jumpList = $this->_fetch_jump_list();
        if($jumpList && !empty($jumpList)){
            $extjson['navigateToMiniProgramAppIdList'] = $jumpList;
        }
        $ret    = $wxxcx_client->commitTemplateCode($wxapp_curr['codeid'], json_encode($extjson), $wxapp_curr['version'], $wxapp_curr['desc']);
        if (!$ret['errcode']) {
            $cat_ret    = $wxxcx_client->fetchWxappCategory();
            $cat_ret    = $cat_ret ? $cat_ret : json_decode($this->wxapp_cfg['ac_category'], true);
            if ($cat_ret) {
                $tag_arr    = preg_split('/\s+/', $tag);
                foreach ($tag_arr as &$each) {
                    $each   = mb_substr($each, 0, 10, 'UTF-8');
                }
                $tag    = implode(' ', $tag_arr);
                $item   = array(
                    array(
                        'address'   => $address,
                        'tag'       => $tag,
                        'title'     => $title,
                    ),
                );
                $item[0]    += $cat_ret[0];
                $sub_ret    = $wxxcx_client->submitCodeToAudit($item);
                if ($sub_ret['auditid'] != 0) {
                    $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
                    $updata = array(
                        'ac_audit_status'   => 1,
                        'ac_audit_id'       => $sub_ret['auditid'],
                        'ac_audit_time'     => time(),
                        'ac_audit_base'     => $wxapp_curr['base'],
                        'ac_audit_version'  => $wxapp_curr['version'],
                        'ac_experience_base'     => $wxapp_curr['base'],
                        'ac_experience_version'  => $wxapp_curr['version'],
                        'ac_audit_auto'     => $auto,
                        'ac_category'       => json_encode($cat_ret),//保存获取的类目
                    );
                    $applet_model->findShopCfg($updata);//修改审核状态为待审核中
                    App_Helper_OperateLog::saveOperateLog("小程序提交审核成功");
                    $this->displayJsonSuccess(null, true);
                } else {
                    $retData = array(
                        'ec' => 400,
                        'em' => $sub_ret['errmsg'],
                        'err' => $sub_ret['errcode']
                    );
                    $this->displayJson($retData,true);
                }
            }else{
                $this->displayJsonError('小程序的首要类目不存在, 请添加后尝试');
            }
        } else {
            $this->displayJson(array('ec' => 400, 'em' => $ret['errmsg'], 'err' => $ret['errcode']));
        }
    }

    
    private function _fetch_jump_list(){
        $data = array();
        $appletType = array(1,4,6,7,8,21);
        if(in_array($this->wxapp_cfg['ac_type'],$appletType)){
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

    
    public function undoCodeAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $ret    = $wxxcx_client->undoCodeAudit();

        if (!$ret['errcode']) {
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $updata = array(
                'ac_audit_status' => 0,
            );
            $applet_model->findShopCfg($updata);//无审核状态
            App_Helper_OperateLog::saveOperateLog("小程序撤销审核成功");
            $this->displayJsonSuccess();
        } else {
            $this->displayJsonError($ret['errmsg']);
        }
    }

    
    public function revertCodeReleaseAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $ret    = $wxxcx_client->revertCodeRelease();

        if (!$ret['errcode']) {
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $applet_cfg     = $applet_model->findShopCfg();
            $updata = array(
                'ac_base'   => $applet_cfg['ac_base']-1,
            );
            $applet_model->findShopCfg($updata);//无审核状态
            App_Helper_OperateLog::saveOperateLog("小程序版本回退成功");
            $this->displayJsonSuccess();
        } else {
            $this->displayJsonError($ret['errmsg']);
        }
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
    
    public function releaseCodeAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $ret    = $wxxcx_client->releaseTemplateCode();
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $applet_cfg     = $applet_model->findShopCfg();
        $updata = array(
            'ac_audit_status' => 0,
            'ac_base'   => $applet_cfg['ac_audit_base'],
            'ac_version'=> $applet_cfg['ac_audit_version'],
        );
        $applet_model->findShopCfg($updata);//无审核状态
        $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($this->curr_sid);
        $tpl_model->findUpdateBySid(26,array('asp_audit'=>0));
        $this->displayJsonSuccess();
    }
    
    public function updateStatusAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $ret    = $wxxcx_client->fetchLatestAudit();
        if ($ret['errcode'] == 0) {
            if ($ret['status'] == 2) {
                $this->displayJsonError('代码仍处于审核中, 请耐心等待!');
            } else {
                $updata = array(
                    'ac_audit_status' => $ret['status'] == 0 ? 2 : 3,
                    'ac_audit_reason' => $ret['status'] == 1 ? $ret['reason'] : '',
                );
                $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
                if ($ret['status'] == 0) {
                    $applet_cfg     = $applet_model->findShopCfg();
                    $wxxcx_client->releaseTemplateCode();//发布上线
                    $updata = array(
                        'ac_audit_status' => 0,
                        'ac_base'   => $applet_cfg['ac_audit_base'],
                        'ac_version'=> $applet_cfg['ac_audit_version'],
                    );
                    $ret['errmsg'] = '已审核通过并发布上线成功';
                }
                $applet_model->findShopCfg($updata);//审核状态
                $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($this->curr_sid);
                $tpl_model->findUpdateBySid(26,array('asp_audit'=>0));
                $this->displayJsonSuccess($ret['errmsg']);
            }
        } else {
            $this->displayJsonError($ret['errmsg']);
        }
    }
    
    public function fetchQrcodeAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $ret    = $wxxcx_client->fetchCodeQrcode();

        echo $ret;
    }
    
    public function syncCategoryAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $ret    = $wxxcx_client->fetchWxappCategory();
        if ($ret) {
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $updata = array(
                'ac_category'       => is_array($ret) ? json_encode($ret) : $ret,
            );
            $applet_model->findShopCfg($updata);
            $this->displayJsonSuccess(null, true);
        }else{
            $this->displayJsonError('同步失败,请在微信小程序后台添加或更换服务类目后重新授权');
        }
    }
    
    public function syncDomainAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $server_domain  = plum_parse_config('server', 'wxxcx');
        $domain         = isset($server_domain[$this->wxapp_cfg['ac_type']]) ? $server_domain[$this->wxapp_cfg['ac_type']]['domain'] : plum_parse_config('domain', 'wxxcx');
        $qiniu_model      = new App_Model_Applet_MysqlAppletQiniuStorage($this->curr_sid);
        $qiniu       = $qiniu_model->findRowCfg();
        if($qiniu){
            $url  = plum_parse_config('url', 'qiniu');
            $domain['upl'][] = $url[$qiniu['aq_bucket_zone']];
        }
        $domain['req'][] = 'https://log.aldwx.com';
        $ret    = $wxxcx_client->coverCodeDomain($domain['req'], $domain['wss'], $domain['upl'], $domain['dow']);
        if ($ret) {
            $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $updata = array(
                'ac_domain_time'       => time(),
            );
            $applet_model->findShopCfg($updata);
            $this->displayJsonSuccess(null, true);
        }else{
            $this->displayJsonError('同步失败,请在微信小程序后台修改服务器域名');
        }
    }

    public function fetchDomainAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $ret    = $wxxcx_client->fetchCodeDomain();

        if ($ret) {
            unset($ret['errcode']);
            unset($ret['errmsg']);
            $this->displayJsonSuccess($ret);
        }else{
            $this->displayJsonError('同步失败,请在微信小程序后台查看服务器域名');
        }
    }

    public function bindTesterAction() {
        $wechaid    = $this->request->getStrParam('wechatid');

        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        $ret        = $wxxcx_client->bindTester($wechaid);

        if ($ret['errcode'] == 0) {
            $this->displayJsonSuccess();
        } else {
            $this->displayJsonError($ret['errmsg']);
        }
    }
    
    public function modifyNameAction() {
        $name   = $this->request->getStrParam('name');

        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop_model->updateById(array('s_name' => $name), $this->curr_sid);

        $this->displayJsonSuccess();
    }

    
    public function downloadQrcodeAction() {
        $file       = PLUM_DIR_ROOT.$this->wxapp_cfg['ac_wxacode'];
        $filesize   = filesize($file);
        $filename   = $this->wxapp_cfg['ac_gh_id'].".jpg";

        plum_send_http_header("Content-type: application/octet-stream");
        plum_send_http_header("Accept-Ranges: bytes");
        plum_send_http_header("Accept-Length:".$filesize);
        plum_send_http_header("Content-Disposition: attachment; filename=".$filename);

        readfile($file);
    }
    
    public function resetWxacodeAction() {
        $wxxcx_model    = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $wxxcx_model->updateById(array('ac_wxacode' => ''), $this->wxapp_cfg['ac_id']);

        $this->displayJsonSuccess();
    }
    
    public function createOpenAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $ret = $wxxcx_client->createOpenAppid($this->wxapp_cfg['ac_appid']);
        if ($ret['errcode'] == 0) {
            $wxxcx_model    = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $wxxcx_model->updateById(array('ac_open_appid' => $ret['open_appid']), $this->wxapp_cfg['ac_id']);
            $this->displayJsonSuccess($ret['errmsg']);
        } else {
            $this->displayJsonError($ret['errmsg']);
        }
    }
    
    public function unbindOpenAction() {
        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $ret = $wxxcx_client->unbindOpenAppid($this->wxapp_cfg['ac_appid'], $this->wxapp_cfg['ac_open_appid']);
        if ($ret['errcode'] == 0) {
            $wxxcx_model    = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $wxxcx_model->updateById(array('ac_open_appid' => ''), $this->wxapp_cfg['ac_id']);
            $this->displayJsonSuccess($ret['errmsg']);
        } else {
            $this->displayJsonError($ret['errmsg']);
        }
    }

    
    public function bindOpenAction() {
        $appid  = $this->request->getStrParam('appid');
        $type   = $this->request->getIntParam('type');

        if (!$this->wxapp_cfg['ac_open_appid']) {
            $this->displayJsonError('请点击上方重新授权按钮, 将权限"开放平台帐号管理权限"授权给平台方可使用功能');
        }

        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);
        if ($type == 1) {
            $ret    = $wxxcx_client->bindOpenAppid($appid, $this->wxapp_cfg['ac_open_appid']);
        } else {
            $ret    = $wxxcx_client->unbindOpenAppid($appid, $this->wxapp_cfg['ac_open_appid']);
        }
        if ($ret['errcode'] == 0) {
            $open_model = new App_Model_Applet_MysqlAppletOpenStorage($this->curr_sid);
            if ($type == 1) {
                $indata = array(
                    'ao_s_id'       => $this->curr_sid,
                    'ao_acid'       => $this->wxapp_cfg['ac_id'],
                    'ao_appid'      => $appid,
                    'ao_add_time'   => time(),
                );
                $open_model->insertValue($indata);
            } else {
                $open_model->deleteRowByAppid($appid);
            }
            $this->displayJsonSuccess($ret['errmsg']);
        } else {
            $this->displayJsonError($ret['errmsg']);
        }
    }
    
    public function bindAppidAction() {
        $appid  = $this->request->getStrParam('appid');

        $wxxcx_client   = new App_Plugin_Weixin_WxxcxClient($this->curr_sid);

        $ret    = $wxxcx_client->bindOpenAppid($this->wxapp_cfg['ac_appid'], $appid);
        if ($ret['errcode'] == 0) {
            $wxxcx_model    = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
            $wxxcx_model->updateById(array('ac_open_appid' => $appid), $this->wxapp_cfg['ac_id']);
            $this->displayJsonSuccess($ret['errmsg']);
        } else {
            $this->displayJsonError($ret['errmsg']);
        }
    }

    
    public function bottomMenuAction(){
        $this->secondLink('cfg');
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '底部菜单', 'link' => '#'),
        ));
        $icon_storage               = new App_Model_Applet_MysqlAppletIconStorage();
        $icon_list = $icon_storage->getIconList(($this->wxapp_cfg['ac_type'] == 36 ? 32 : $this->wxapp_cfg['ac_type']));
        $this->output['icon_list'] = $icon_list;
        $page_storage = new App_Model_Applet_MysqlAppletPageStorage();
        $page_list = $page_storage->fetchAction($this->wxapp_cfg['ac_type']);
        $page_data = array();
        if($page_list){
            foreach ($page_list as $val){
                $page_data[] = array(
                    'path' => $val['ap_path'],
                    'name' => $val['ap_desc']." （".$val['ap_path']."）"
                );
            }
        }
        $list = array();
        if($this->wxapp_cfg['ac_bottom_menu']){
            $bottom_menu = json_decode($this->wxapp_cfg['ac_bottom_menu'],true);
            $list_data = $bottom_menu['list'];
            foreach ($list_data as $key=>$val){
                $list[] = array(
                    'index'            => $key,
                    'pagePath'         => $val['pagePath'],
                    'text'             => $val['text'],
                    'iconPath'         => '/public/wxapp/icon'.$val['iconPath'],
                    'selectedIconPath' => '/public/wxapp/icon'.$val['selectedIconPath'],
                    'setIndex'         => isset($val['setIndex']) && $val['setIndex'] ? $val['setIndex'] : 0
                );
            }

            if($this->menuType == 'weixin'){
                if($bottom_menu['borderStyle'] == 'black'){
                    $bottom_menu['borderStyle'] = '#000';
                }
                if($bottom_menu['borderStyle'] == 'white'){
                    $bottom_menu['borderStyle'] = '#fff';
                }
            }

        }else{
            $bottom_menu = array(
                'color'             => '#000',
                'selectedColor'     => '#FFCB5B',
                'backgroundColor'   => '#fff',
                'borderStyle'       => $this->menuType == 'weixin' ? '#000' : 'black',
            );
        }
        if($this->wxapp_cfg['ac_navigation_bar']){
            $topNav = json_decode($this->wxapp_cfg['ac_navigation_bar'],true);
            $topNavinfo = array(
                'color'   => $topNav['navigationBarTextStyle'],
                'bgColor' => $topNav['navigationBarBackgroundColor']
            );
        }else{
            $topNavinfo = array(
                'bgColor' =>'#ffffff',
                'color'   =>'black'
            );
        }
        $this->output['zdIcon'] = $this->wxapp_cfg['ac_suspension_menu_img'];
        $wxapp_kind = plum_parse_config('category', 'applet');
        $wxapp_curr = $wxapp_kind[$this->wxapp_cfg['ac_type']];
        $this->output['applet_type'] = $wxapp_curr['name'];
        $this->output['list'] = json_encode($list);
        $this->output['suspensionMenu'] = $this->wxapp_cfg['ac_suspension_menu'] ? $this->wxapp_cfg['ac_suspension_menu'] : json_encode(array());
        $this->output['suspensionMenuShow'] = $this->wxapp_cfg['ac_suspension_menu_show'] ? $this->wxapp_cfg['ac_suspension_menu_show'] : 0 ;
        $this->output['indexMenu'] = $this->wxapp_cfg['ac_index_menu'] ? $this->wxapp_cfg['ac_index_menu'] : json_encode(array());
        $this->output['indexMenuTitle'] = $this->wxapp_cfg['ac_index_menu_title'] ? $this->wxapp_cfg['ac_index_menu_title'] : '快捷导航';
        $this->output['indexMenuIsOn'] = $this->wxapp_cfg['ac_index_menu_open'] ? $this->wxapp_cfg['ac_index_menu_open'] : 0;
        $this->output['phoneIconIsOn'] = $this->wxapp_cfg['ac_phone_open'] ? $this->wxapp_cfg['ac_phone_open'] : 0;
        $this->output['bottom_menu'] = $bottom_menu;
        $this->output['topNavinfo'] = json_encode($topNavinfo);
        $page = $this->_fetch_shop_outside();

        $custom = array();
        $this->output['customPageLink'] = array();
        if($this->checkToolUsableBool('mbfz')){
            $custom = $this->_fetch_shop_custom_page();
        }
        $template_model = new App_Model_Applet_MysqlAppletCommonTemplateStorage();
        $where[] = array('name' => 'act_s_id', 'oper' => '=', 'value' => $this->curr_sid);
        $templateList = $template_model->getList($where, 0, 0, array('act_create_time' => 'ASC'));
        $myTemplate  = array();
        foreach ($templateList as $value){
            $myTemplate[] = array(
                'id'      => $value['act_id'],
                'name'    => $value['act_remark_name'],
            );
        }
        $this->output['templateList'] = json_encode($myTemplate);

        $this->_shop_company_info();
        $this->output['page_list'] = json_encode(array_merge($page,$page_data, $custom));
        $this->_get_list_for_select();
        $this->_shop_information();
        $this->_get_jump_list();
        $this->output['companyInfo'] = array(1,3,6,8,9,10,12,13,21,16,18);
        $this->output['companyInfoImg'] = array(1,21,50);//公司介绍入口显示为图片
        $this->output['phoneIcon'] = array(1,12,21,24,19,13,9,3,16,10,18);
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->output['siddd'] = $this->curr_sid;
        $this->output['templateSave'] = ($this->wxapp_cfg['ac_type']== 21 || $this->wxapp_cfg['ac_type']== 6 || $this->wxapp_cfg['ac_type']== 32 ) && $this->checkToolUsableBool('mbfz');
        if($this->wxapp_cfg['ac_type']==6 || $this->wxapp_cfg['ac_type']== 3 || $this->wxapp_cfg['ac_type']== 21 || $this->wxapp_cfg['ac_type']== 8){
            $this->displaySmarty('wxapp/setup/old-bottom-menu-new.tpl');
        }else{
            $this->displaySmarty('wxapp/setup/new-button-menu.tpl');
        }

    }

    
    public function bottomMenuListAction(){
        $this->secondLink('bottommenulist');
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '底部菜单列表', 'link' => '#'),
        ));
        $page = $this->request->getIntParam('page',0);
        $index= $page * $this->count;
        $page_data_cfg = plum_parse_config('link','system')[$this->wxapp_cfg['ac_type']];
        $page_storage = new App_Model_Applet_MysqlAppletPageStorage();
        $page_list = $page_storage->fetchAction($this->wxapp_cfg['ac_type']);
        $page_data = array();
        if($page_list){
            foreach ($page_list as $val){
                $page_data[] = array(
                    'path' => $val['ap_path'],
                    'name' => $val['ap_desc']
                );
            }
        }
        foreach($page_data_cfg as $item){
            if(in_array($item,$page_data)){
                continue;
            }else{
                $page_data[] = $item;
            }
        }
        $merge_list  = [];
        for($i=$index;$i<$index+$this->count;$i++){
            if($page_data[$i]){
                $merge_list[] = $page_data[$i];
            }
        }
        $this->output['page_list'] = $merge_list;
        $total = count($page_data);
        $page_plugin = new Libs_Pagination_Paginator($total,$this->count,'jquery',1);
        $this->output['pageHtml'] = $page_plugin->render();
        $this->displaySmarty('wxapp/setup/buttom-menu-list.tpl');
    }

    
    private function _shop_company_info(){
        $about_storage = new App_Model_Shop_MysqlShopAboutUsStorage($this->curr_sid);
        $row = $about_storage->findUpdateBySid();
        $contact = array(
            'isOn'     => $row['sa_ison'] && $row['sa_ison']==1 ? true : false,
            'link'     => isset($row['sa_link']) && $row['sa_link'] ? $row['sa_link'] : 0,
            'name'     => isset($row['sa_name']) && $row['sa_name'] ? $row['sa_name'] : $this->wxapp_cfg['ac_name'],
            'brief'    => isset($row['sa_brief']) && $row['sa_brief'] ? $row['sa_brief'] : $this->wxapp_cfg['ac_signature'],
            'mobile'   => isset($row['sa_mobile']) && $row['sa_mobile'] ? $row['sa_mobile'] : '',
            'address'  => isset($row['sa_address']) && $row['sa_address'] ? $row['sa_address'] : '',
            'logo'     => isset($row['sa_logo']) && $row['sa_logo'] ? $row['sa_logo'] : $this->wxapp_cfg['ac_avatar'],
            'lng'      => isset($row['sa_lng']) && $row['sa_lng'] ? $row['sa_lng'] : '',
            'lat'      => isset($row['sa_lat']) && $row['sa_lat'] ? $row['sa_lat'] : '',
        );
        $this->output['contact'] = json_encode($contact);
    }

    
    private function _get_list_for_select(){
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $enterpriseType = plum_parse_config('fold_menu','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $this->output['linkList'] = json_encode($link);
        
        $this->output['linkType'] = json_encode(array_merge($linkType,$enterpriseType));

    }
    
    private function _shop_information(){
        $where         = array();
        $where[]       = array('name'=>'ai_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]       = array('name'=>'ai_deleted','oper'=>'=','value'=>0);
        $information_storage = new App_Model_Applet_MysqlAppletInformationStorage();
        $sort          = array('ai_create_time' => 'DESC');
        $list          = $information_storage->getList($where,0,50,$sort);
        $data = array();
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id'      => $val['ai_id'],
                    'title'   => $val['ai_title'],
                    'brief'   => $val['ai_brief'],
                    'cover'   => $val['ai_cover']
                );
            }
        }
        $this->output['information'] = json_encode($data);
    }

    
    private function _fetch_shop_outside(){
        $webcfg_storage = new App_Model_Applet_MysqlAppletWebcfgStorage($this->curr_sid);
        $cfg = $webcfg_storage->findUpdateBySid();
        $data = array();
        $page_data = array();
        if($cfg && ($cfg["awc_web1"] || $cfg["awc_web2"] ||$cfg["awc_web3"] || $cfg["awc_web4"] || $cfg["awc_web5"])){
            for($i=1;$i<=5;$i++){
                if(isset($cfg["awc_web$i"]) && $cfg["awc_web$i"]){
                    $data[] = array(
                        'index' => $i,
                        'link'  => $cfg["awc_web$i"],
                        'title' => '链接地址'.$i,
                    );
                    $page_data[] = array(
                        'path' => 'pages/webviewTab'.$i.'/webviewTab'.$i,
                        'name' => '链接地址'.$i,
                    );
                }
            }
        }else{
            $data[] = array(
                'index' => 0,
                'link'  => '',
                'title' => '链接地址1',
            );
        }
        $this->output['outsideLink'] = json_encode($data);
        return $page_data;
    }

    
    private function _fetch_shop_custom_page(){
        $custompage_storage = new App_Model_Applet_MysqlAppletCustompageStorage($this->curr_sid);
        $cfg = $custompage_storage->findUpdateBySid();
        $data = array();
        $page_data = array();
        if($cfg && ($cfg["acpc_page1"] || $cfg["acpc_page2"] ||$cfg["acpc_page3"] || $cfg["acpc_page4"] || $cfg["acpc_page5"])){
            for($i=1;$i<=5;$i++){
                if(isset($cfg["acpc_page$i"]) && $cfg["acpc_page$i"]){
                    $data[] = array(
                        'index' => $i,
                        'link'  => $cfg["acpc_page$i"],
                        'title' => '自定义页面'.$i,
                    );
                    $page_data[] = array(
                        'path' => 'pages/webviewTab'.$i.'/webviewTab'.$i,
                        'name' => '自定义页面'.$i,
                    );
                }
            }
        }else{
            $data[] = array(
                'index' => 0,
                'link'  => '',
                'title' => '自定义页面1',
            );
        }
        $this->output['customPageLink'] = json_encode($data);
        return $page_data;
    }

    
    public function saveBottomMenuAction(){
        $list            = $this->request->getArrParam('list');
        $color           = $this->request->getStrParam('color');
        $selectedColor   = $this->request->getStrParam('selectedColor');
        $borderStyle     = $this->request->getStrParam('borderStyle');
        $backgroundColor = $this->request->getStrParam('backgroundColor');
        $navColor        = $this->request->getStrParam('navColor');
        $navBackground   = $this->request->getStrParam('navBackground');
        $suspensionMenu  = $this->request->getArrParam('suspensionMenu');
        $suspensionShow  = $this->request->getIntParam('suspensionShow');
        $indexMenu       = $this->request->getArrParam('indexMenu');
        $companyInfo     = $this->request->getArrParam('companyInfo');
        $indexMenuTitle  = $this->request->getStrParam('indexMenuTitle');
        $indexMenuIsOn   = $this->request->getStrParam('indexMenuIsOn');
        if($list && count($list)>=2 && count($list)<=5){
            $list_data = array();
            $page_list = array();
            $suspensionList = array();
            if($suspensionMenu && !empty($suspensionMenu)){
                foreach ($suspensionMenu as $item){
                    $suspensionList[] = $item['link'];
                }
            }
            $indexList = array();
            if($indexMenu && !empty($indexMenu)){
                foreach ($indexMenu as $item){
                    $indexList[] = $item['link'];
                }
            }
            foreach ($list as $val){
                $iconPath = explode('/',$val['iconPath']);
                $selectedIconPath = explode('/',$val['selectedIconPath']);
                $list_data[] = array(
                    'pagePath'         => $val['pagePath'],
                    'text'             => $val['text'],
                    'iconPath'         => $iconPath[6] && isset($iconPath[6]) ? '/'.$iconPath[4].'/'.$iconPath[5].'/'.$iconPath[6] : '/'.$iconPath[4].'/'.$iconPath[5],
                    'selectedIconPath' => $selectedIconPath[6] && isset($selectedIconPath[6]) ? '/'.$selectedIconPath[4].'/'.$selectedIconPath[5].'/'.$selectedIconPath[6] : '/'.$selectedIconPath[4].'/'.$selectedIconPath[5],
                    'setIndex'         => $val['setIndex']
                );
                $page_list[] = $val['pagePath'];
            }
            if(count($list_data) != count(array_unique($page_list))){
                $this->displayJsonError('底部导航链接有重复值，请检查后重新提交');
            }
            if(array_intersect($page_list,$suspensionList)){
                $this->displayJsonError('底部导航和折叠菜单有重复值，请检查后重新提交');
            }
            if(array_intersect($page_list,$indexList)){
                $this->displayJsonError('底部导航和首页菜单有重复值，请检查后重新提交');
            }
            $navData = array(
                'navigationBarBackgroundColor'  => $navBackground,
                'navigationBarTextStyle'        => $navColor,
            );
            $data = array(
                'color'             => $color,
                'selectedColor'     => $selectedColor,
                'backgroundColor'   => $backgroundColor,
                'borderStyle'       => $borderStyle,
                'list'              => $list_data,
            );
            $updata = array(
                'ac_bottom_menu'            =>json_encode($data),
                'ac_suspension_menu'        =>json_encode($suspensionMenu),
                'ac_suspension_menu_show'   =>$suspensionShow,
                'ac_index_menu'             =>json_encode($indexMenu),
                'ac_navigation_bar'         =>json_encode($navData),
                'ac_bottom_time'            =>time(),
                'ac_index_menu_title'       =>$indexMenuTitle,
                'ac_index_menu_open'        =>$indexMenuIsOn=='true' ? 1 : 0
            );
            $applet_model   = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
            $ret = $applet_model->findShopCfg($updata);
            if(!empty($companyInfo) && $companyInfo['name'] && $companyInfo['mobile'] && $companyInfo['address'] && $companyInfo['logo']){
                $result = $this->_save_company_info($companyInfo);
            }
            if($ret || $result){
                $ret = 1;
            }

            App_Helper_OperateLog::saveOperateLog("编辑底部菜单导航成功");

            $this->showAjaxResult($ret);
        }else{
            $this->displayJsonError('导航数量必须在2-5个之间');
        }
    }
    public function saveIndexMenuAction(){
        $indexMenu  = $this->request->getArrParam('indexMenu');
        $indexMenuTitle  = $this->request->getStrParam('indexMenuTitle');
        $indexMenuIsOn   = $this->request->getStrParam('indexMenuIsOn');
        $list            = $this->request->getArrParam('list');
        $page_list = array();
        $indexList = array();
        if($indexMenu && !empty($indexMenu)){
            foreach ($indexMenu as $item){
                $indexList[] = $item['link'];
            }
        }
        if($list && !empty($list)){
            foreach ($list as $val){
                $page_list[] = $val['pagePath'];
            }
        }
        if(array_intersect($page_list,$indexList)){
            $this->displayJsonError('底部导航和首页菜单有重复值，请检查后重新提交');
        }
        $updata = array(
            'ac_index_menu'        =>json_encode($indexMenu),
            'ac_index_menu_title'  =>$indexMenuTitle,
            'ac_index_menu_open'   =>$indexMenuIsOn=='true' ? 1 : 0
        );
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $ret = $applet_model->findShopCfg($updata);
        $this->showAjaxResult($ret);
    }
    public function saveSuspensionMenuAction(){
        $suspensionMenu  = $this->request->getArrParam('suspensionMenu');
        $suspensionShow  = $this->request->getIntParam('suspensionShow');
        $list            = $this->request->getArrParam('list');
        $zdIcon          = $this->request->getStrParam('zdIcon','');
        $page_list = array();
        $suspensionList = array();
        if($suspensionMenu && !empty($suspensionMenu)){
            foreach ($suspensionMenu as $item){
                $suspensionList[] = $item['link'];
            }
        }
        if($list && !empty($list)){
            foreach ($list as $val){
                $page_list[] = $val['pagePath'];
            }
        }
        if(array_intersect($page_list,$suspensionList)){
            $this->displayJsonError('底部导航和折叠菜单有重复值，请检查后重新提交');
        }
        $updata = array(
            'ac_suspension_menu'      =>json_encode($suspensionMenu),
            'ac_suspension_menu_show' =>$suspensionShow,
            'ac_suspension_menu_img'  => $zdIcon,
            'ac_update_time'          => time()
        );
        $applet_model   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $ret = $applet_model->findShopCfg($updata);
        $this->showAjaxResult($ret);
    }

    public function saveCompanyInfoAction(){
        $ret = 0;
        $companyInfo  = $this->request->getArrParam('companyInfo');
        if(!empty($companyInfo)){
            $ret = $this->_save_company_info($companyInfo);
        }
        $this->showAjaxResult($ret);
    }

    private function _save_company_info($companyInfo){
        $data = array(
            'sa_name'    => $companyInfo['name'],
            'sa_brief'   => plum_strip_html_tags($companyInfo['brief']),
            'sa_mobile'  => $companyInfo['mobile'],
            'sa_address' => plum_strip_html_tags($companyInfo['address']),
            'sa_logo'    => $companyInfo['logo'],
            'sa_lng'     => $companyInfo['lng'],
            'sa_lat'     => $companyInfo['lat'],
            'sa_ison'    => $companyInfo['isOn']=='true' ? 1 : 0,
            'sa_link'    => $companyInfo['link'],
        );
        $about_storage = new App_Model_Shop_MysqlShopAboutUsStorage($this->curr_sid);
        $row = $about_storage->findUpdateBySid();
        if($row){
            return $about_storage->findUpdateBySid($data);
        }else{
            $data['sa_s_id'] = $this->curr_sid;
            return $about_storage->insertValue($data);
        }
    }

    
    public function chargeQrcodeAction() {
        $watermark  = $this->request->getStrParam('watermark');
        $channel    = $this->request->getStrParam('channel');
        $unique     = $this->request->getStrParam('unique');
        $watermark_price   = plum_parse_config('watermark', 'agent');
        if (!$watermark) {
            plum_redirect("/public/manage/images/qrcode-placeholder.png");
        }
        $allow_type = array('wxpay' => 'wx_pub_qr', 'alipay' => 'alipay_qr');
        $channel    = in_array($channel, array_keys($allow_type)) ? $allow_type[$channel] : current($allow_type);

        $cfg        = plum_parse_config('pingpp');
        $pingpp     = new App_Plugin_Pingpp_Client();
        $params     = array(
            'order_no'  => App_Plugin_Weixin_PayPlugin::makeMchOrderid($this->curr_sid),
            'amount'    => 100*$watermark_price,//单位分
            'app'       => array('id' => $cfg['app_id']),
            'channel'   => $channel,
            'currency'  => 'cny',
            'client_ip' => $this->request->getRemoteIp(),
            'subject'   => mb_strlen($this->shops[$this->curr_sid]['s_name']."自定义水印：{$watermark}")>32 ? "自定义水印：{$watermark}" : $this->shops[$this->curr_sid]['s_name']."自定义水印：{$watermark}",
            'body'      => $this->shops[$this->curr_sid]['s_name']."自定义水印：{$watermark}",
            'metadata'  => array('suid' => $unique, 'type' => 'watermark', 'mid' => $this->manager['m_id'], 'watermark' => $watermark),
        );
        if ($channel == 'wx_pub_qr') {
            $params['extra'] = array('product_id' => 'shop_recharge');
        }
        Libs_Log_Logger::outputLog($params);
        $charge     = $pingpp->create($params);
        $qrcode     = $charge->credential[$channel];
        Libs_Qrcode_QRCode::png($qrcode);
    }

    public function addJumpAction(){
        $id = $this->request->getIntParam('id');
        $row = array();
        if($id){
            $jump_storage = new App_Model_Applet_MysqlAppletJumpStorage();
            $row = $jump_storage->getRowById($id);
        }
        $this->output['row'] = $row;
        $this->renderCropTool('/wxapp/index/uploadImg');
        $this->buildBreadcrumbs(array(
            array('title' => '跳转小程序', 'link' => '/wxapp/setup/jumpList'),
            array('title' => '添加跳转小程序', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/setup/add-jump.tpl');
    }

    
    public function jumpListAction(){
        $this->checkAgentClose('jump');

        $page = $this->request->getIntParam('page');
        $index = $page*$this->count;
        $where = array();
        $where[] = array('name'=>'aj_s_id','oper'=>'=','value'=>$this->curr_sid);
        $jump_storage = new App_Model_Applet_MysqlAppletJumpStorage();
        $total      = $jump_storage->getCount($where);
        $pageCfg    = new Libs_Pagination_Paginator($total,$this->count);
        $this->output['pageHtml']   = $pageCfg->render();
        $list = array();
        if($index<$total){
            $sort = array('aj_sort'=>'DESC','aj_create_time'=>'DESC');
            $list = $jump_storage->getList($where,$index,$this->count,$sort);
        }
        $this->output['list'] = $list;
        $this->buildBreadcrumbs(array(
            array('title' => '小程序管理', 'link' => '#'),
            array('title' => '跳转小程序', 'link' => '#'),
        ));
        $this->displaySmarty('wxapp/setup/jump-list.tpl');
    }

    
    public function deleteJumpAction(){
        $id   = $this->request->getIntParam('id');
        if($id){
            $where = array();
            $where[] = array('name'=>'aj_id','oper'=>'=','value'=>$id);
            $where[] = array('name'=>'aj_s_id','oper'=>'=','value'=>$this->curr_sid);
            $jump_storage = new App_Model_Applet_MysqlAppletJumpStorage();
            $jump = $jump_storage->getRow($where);
            App_Helper_OperateLog::saveOperateLog("跳转小程序【".$jump['aj_name']."】删除成功");
            $ret = $jump_storage->deleteValue($where);
        }
        $this->showAjaxResult($ret,' 删除');
    }

    public function saveOutsideLinkAction(){
        $outside = $this->request->getArrParam('outside');
        $data = array();
        if($outside){
            for($i=0;$i<5;$i++){
                $key = $i+1;
                if(isset($outside[$i]['link']) && $outside[$i]['link'] && plum_is_https_url($outside[$i]['link'])){
                    $data["awc_web$key"] = $outside[$i]['link'];
                }else{
                    $data["awc_web$key"] = '';
                }
            }
            $data['awc_update_time'] = time();
        }
        $webcfg_storage = new App_Model_Applet_MysqlAppletWebcfgStorage($this->curr_sid);
        $cfg = $webcfg_storage->findUpdateBySid();
        if($cfg && !empty($data)){
            $ret = $webcfg_storage->findUpdateBySid($data);
        }else{
            if(!empty($data)){
                $data['awc_s_id'] = $this->curr_sid;
                $data['awc_create_time'] = time();
                $ret = $webcfg_storage->insertValue($data);
            }
        }
        $this->showAjaxResult($ret);
    }

    
    public function saveCustomPageLinkAction(){
        $customPage = $this->request->getArrParam('customPage');
        $data = array();
        if($customPage){
            for($i=0;$i<5;$i++){
                $key = $i+1;
                if(isset($customPage[$i]['link']) && $customPage[$i]['link']){
                    $data["acpc_page$key"] = $customPage[$i]['link'];
                }else{
                    $data["acpc_page$key"] = '';
                }
            }
            $data['acpc_update_time'] = time();
        }
        $custompage_storage = new App_Model_Applet_MysqlAppletCustompageStorage($this->curr_sid);
        $cfg = $custompage_storage->findUpdateBySid();
        if($cfg && !empty($data)){
            $ret = $custompage_storage->findUpdateBySid($data);
        }else{
            if(!empty($data)){
                $data['acpc_s_id'] = $this->curr_sid;
                $data['acpc_create_time'] = time();
                $ret = $custompage_storage->insertValue($data);
            }
        }

        if($ret){
            App_Helper_OperateLog::saveOperateLog("自定义链接保存成功");
        }

        $this->showAjaxResult($ret);
    }

    
    public function auditVersionAction()
    {
        $tpl_id = $this->request->getIntParam('tpl', 26);
        $tpl_model = new App_Model_Shop_MysqlIndexTplStorage();
        $row = $tpl_model->getRowBySid($tpl_id, $this->curr_sid);
        $this->output['shop'] = $this->shops[$this->curr_sid];
        if ($row) {
            $this->showShopTpl($tpl_id);
            $this->_show_index_slide($tpl_id);
            $this->renderCropTool('/wxapp/index/uploadImg');
            $this->buildBreadcrumbs(array(
                array('title' => '小程序管理', 'link' => '#'),
                array('title' => '审核管理', 'link' => '/wxapp/setup/code'),
                array('title' => '过渡版配置', 'link' => '#'),
            ));
            $this->displaySmarty('wxapp/setup/auditVersion.tpl');
        } else {
            plum_url_location('模版不存在');
        }
    }
    
    private function showShopTpl($tpl_id=26){
        $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($this->curr_sid);
        $tpl = $tpl_model->findUpdateBySid($tpl_id);
        if(empty($tpl)){
            $tpl = array(
                'asp_tpl_id'        => 26,
                'asp_head_title'   => '这里设置顶部标题',
                'asp_name'         => '这里设置公司/店铺名称',
                'asp_mobile'       => '186XXXXXXXX',
                'asp_address'      => '河南省郑州市郑东新区CBD商务内环11号',
                'asp_lng'          => '113.5',
                'asp_lat'          => '34.5',
                'asp_content'      => '这里添加图文信息',
                'asp_audio_version'=> 2
            );
        }
        $this->output['tpl'] = $tpl;
    }

    
    private function _show_index_slide($tpl_id=26){
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        $slide = $slide_model->fetchSlideShowList($tpl_id);
        $json = array();
        foreach($slide as $key => $val){
            $json[] = array(
                'index'     => $key ,
                'imgsrc'    => $val['ss_path'],
                'link'      => $val['ss_link'],
                'articleId' => $val['ss_link'],
                'articleTitle' => $val['ss_article_title'],

            );
        }
        $this->output['slide'] = json_encode($json);
    }
    public function saveAuditVersionAction(){
        $tpl_id               = $this->request->getIntParam('tpl_id',26);

        $tpl['asp_head_title']= $this->request->getStrParam('title');
        $tpl['asp_name']      = $this->request->getStrParam('name');
        $tpl['asp_address']   = $this->request->getStrParam('address');
        $tpl['asp_mobile']    = $this->request->getStrParam('mobile');
        $tpl['asp_lng']       = $this->request->getStrParam('longitude');
        $tpl['asp_lat']       = $this->request->getStrParam('latitude');
        $tpl['asp_audit_web_url'] = $this->request->getStrParam('webUrl');
        $tpl['asp_content']   = $this->request->getParam('content');
        $tpl['asp_audio_version']   = $this->request->getIntParam('enabledVersion');
        $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($this->curr_sid);
        $tpl_row = $tpl_model->findUpdateBySid($tpl_id);
        if(!empty($tpl_row)){
            $ret = $tpl_model->findUpdateBySid($tpl_id,$tpl);
        }else{
            $tpl['asp_tpl_id']     = $tpl_id;
            $tpl['asp_s_id']       = $this->curr_sid;
            $tpl['asp_create_time']= time();
            $ret = $tpl_model->insertValue($tpl);
        }
        $result = $this->save_shop_slide($tpl_id);
        if($ret || $result){
            $result = array(
                'ec' => 200,
                'em' => '信息保存成功'
            );
        }else{
            $result = array(
                'ec' => 400,
                'em' => '信息保存失败'
            );
        }
        $this->displayJson($result);
    }
    public function changeAuditStatusAction(){
        $status = $this->request->getIntParam('status');
        $enabledVersion = $this->request->getIntParam('enabledVersion');
        $tpl_model = new App_Model_Applet_MysqlAppletSinglePageStorage($this->curr_sid);
        $tpl_row = $tpl_model->findUpdateBySid(26);
        if($tpl_row){
            $set = array('asp_audit'=>$status,'asp_audio_version'=>$enabledVersion);
            $ret = $tpl_model->findUpdateBySid(26,$set);
        }else{
            $data = array(
                'asp_tpl_id'       => 26,
                'asp_head_title'   => $this->curr_shop['s_name'],
                'asp_name'         => $this->curr_shop['s_name'],
                'asp_mobile'       => $this->curr_shop['s_phone'],
                'asp_address'      => $this->curr_shop['s_name'],
                'asp_lng'          => '113.5',
                'asp_lat'          => '34.5',
                'asp_content'      => $this->curr_shop['s_brief'],
                'asp_audit'        => $status,
                'asp_s_id'         => $this->curr_sid,
                'asp_create_time'  => time(),
                'asp_audio_version'=> $enabledVersion
            );
            $ret = $tpl_model->insertValue($data);
        }
        $this->showAjaxResult($ret);
    }

    
    public function savePhoneIconOpenAction(){
        $phoneIcon = $this->request->getIntParam('phoneIcon');
        $applet_model = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);

        if($phoneIcon){
            $set = array('ac_phone_open'=>0);
        }else{
            $set = array('ac_phone_open'=>1);
        }

        $res = $applet_model->findShopCfg($set);

        if($res){
            $str = $set['ac_phone_open'] == 1 ? '开启首页电话图标成功' : '关闭首页电话图标成功';
            App_Helper_OperateLog::saveOperateLog($str);
        }

        $this->showAjaxResult($res,'保存');
    }

    
    public function saveShopPhoneAction(){
        $result = array(
            'ec' => 400,
            'em' => '保存失败'
        );
        $phone = $this->request->getStrParam('shopPhone');
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        if($phone){
            $set = array('s_phone'=>$phone);
            $res = $shop_model->updateById($set,$this->curr_sid);
            if($res){
                $result = array(
                    'ec' => 200,
                    'em' => '保存成功'
                );
                App_Helper_OperateLog::saveOperateLog("商家电话保存成功");
            }
        }
        $this->displayJson($result);

    }

    
    public function saveFollowOpenAction(){
        $followOpen = $this->request->getIntParam('followOpen');
        $applet_model = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);

        $set = array('ac_follow_open'=>$followOpen);

        $res = $applet_model->findShopCfg($set);

        App_Helper_OperateLog::saveOperateLog("【关注公众号】".($followOpen==1?'启用成功':'关闭成功'));
        $this->showAjaxResult($res,'保存');
    }

    
    public function submitAuditAction(){
        $title      = $this->request->getStrParam('wxapp_title');
        $tag        = $this->request->getStrParam('wxapp_tag');
        $auto       = $this->request->getIntParam('wxapp_auto', 1);//自动发布上线功能
        $audit_storage = new App_Model_System_MysqlSubmitAuditStorage($this->curr_sid);
        $row = $audit_storage->getAuditStatus();
        if(!$row || ($row && $row['asa_audit_status']!=1)){
            $data = array(
                'asa_s_id'    => $this->curr_sid,
                'asa_ac_id'   => $this->wxapp_cfg['ac_id'],
                'asa_appid'   => $this->wxapp_cfg['ac_appid'],
                'asa_ac_type' => $this->wxapp_cfg['ac_type'],
                'asa_audit_status' => 1,
                'asa_title'   => $title,
                'asa_tag'     => $tag,
                'asa_auto'    => $auto,
                'asa_create_time' => time(),
            );
            $ret = $audit_storage->insertValue($data);
            $this->showAjaxResult($ret,'当前版本提交数量过多，请稍后重试');
        }else{
            $this->displayJsonError('当前版本提交数量过多，请稍后重试');
        }
    }

}