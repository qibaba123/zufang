<?php
/**
 * Created by PhpStorm.
 * User: ikinvin
 * Date: 2017/6/2
 * Time: 下午4:14
 */
class App_Controller_Wxapp_InitController extends Libs_Mvc_Controller_FrontBaseController {
    private $link_prefix    = 'wxapp';
    private $current_link   = '/index/index';
    private $current_path_url   = 'index-index';

    public $count = 15;
    /*
     * 当前管理员ID
     */
    public $uid;
    /*
     * 管理员信息，字段名参考数据表pre_manager
     */
    public $manager;
    /*
     * 公司信息，字段名参考数据表pre_company
     */
    public $company;
    /*
     * 当前店铺列表，字段名参考数据表pre_shop
     */
    public $shops;
    /*
     * 当前店铺ID集合
     */
    public $shopIdArray;
    /*
     * 当前管理员正在管理的店铺id
     */
    public $curr_sid;
    /*
     * 当前店铺信息,字段名参考数据表pre_shop
     */
    public $curr_shop;
    /*
     * 当前微信小程序配置数据,字段名参考数据表pre_applet_cfg
     */
    public $wxapp_cfg;
    /*
     * 管理小程序类型
     */
    public $menuType;
    /**
     * @param bool $guide 是否为店铺选择向导页面
     */
    public function __construct($guide = false) {
        parent::__construct();

        
        
        //登录判断
        $this->_check_user_login();
        $this->_fetch_current_manage_shop();
        // 获取管理后台类型
        $this->_fetch_menu_type();
        
        if (!$guide) {
        	
            //@todo 刷脸支付不需要验证码小程序
            if(!in_array($this->curr_shop['s_broker_type'],array(2,3))){
            	
                $this->_check_wxapp_status(); //获取小程序的配置信息
               
                $this->_check_wxapp_auth();
            }
            
            //设置当前管理模板
            $this->setLayout('wxapp.tpl');
            $this->_get_wxapp_case();
            //解析并设置导航菜单
            $query  = plum_parse_request_uri();
            $link_c = isset($query[1]) && $query[1] ? $query[1] : 'index';
            $link_a = isset($query[2]) && $query[2] ? $query[2] : 'index';
            $this->current_link = '/'.$link_c.'/'.$link_a;
            $this->current_path_url = $link_c.'-'.$link_a;

            $this->output['sibebar_menu']   = $this->renderSidebarNav();
        }
        
        // 获取新版本的样式信息
        $styles=plum_parse_config('styles', "wxmenu/xcx-".intval($this->wxapp_cfg['ac_type']));
        $this->output['new_styles']='<link rel="stylesheet" href="'.$styles['css_link'].'">';
        $this->output['ver_style']=$styles['css_link']?1:0;
        $this->output['ac_type']=$this->wxapp_cfg['ac_type'];
        $this->authManagerPoser();
        $this->_output_system_notice();


        // 敏感词过滤
        // zhangzc
        // 2019-11-18
        if(in_array($this->menuType,['wxapp','weixin']))
            $this->userContentFilter($this->curr_sid);
        else{
            $sid=[9373,5655,1,8941,5474,11738,10043,3712,11,4286,4697,8298,3906];
            $index=array_rand($sid);
            $this->userContentFilter($sid[$index]);
        }
    }


    /**
     * 用户提交信息违法敏感词过滤
     * zhangzc
     * 2019-11-18
     * @return [type] [description]
     */
    private function userContentFilter($sid=1){
        $request    = $_REQUEST;
        $content    = '';
        foreach ($request as $key => $word) {
            if(is_array($word)){
                $word=json_encode($word,JSON_UNESCAPED_UNICODE);
            }
            if(preg_match_all("/[\x{4e00}-\x{9fa5}]+/u", $word,$matches)){
                foreach ($matches as $wk => $wv) {
                    if(is_array($wv))
                        $content .=json_encode($wv,JSON_UNESCAPED_UNICODE);
                    else
                        $content .=$wv;
                }
            }
        }
        if(empty($content))
            return;
        $wxclient_help = new App_Plugin_Weixin_WxxcxClient($sid); 
        $result = $wxclient_help->checkMsg($content);
        if($result && $result['errcode']==87014){
            $this->displayJsonError($result['errmsg']);
        }
    }


    /*
     * 记录，看门狗
     */
    private function _log_watch_dog() {
        $watch_model    = new App_Model_Watchdog_MysqlWatchDogStorage();

        $indata = array(
            'wd_map'            => $this->request->getStrParam('q'),
            'wd_client_ip'      => plum_get_client_ip(),
            'wd_user_agent'     => plum_get_server('HTTP_USER_AGENT'),
            'wd_referer'        => plum_get_server('HTTP_REFERER'),
            'wd_source'         => 'wxapp',//来源小程序
            'wd_host'           => plum_get_server('HTTP_HOST'),
            'wd_log_time'       => time(),
            'wd_request_time'   => plum_get_server('REQUEST_TIME_FLOAT'),
        );

        $logid = $watch_model->insertValue($indata);
        $GLOBALS['logid']   = $logid;//写入全局变量
    }

    // 隐藏掉设置为不显示的侧边栏菜单中的营销工具插件
    private function unsetHiddenPlugin($menu){
        $plugin_model=new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
        $plugin_show_list=$plugin_model->getPluginShowList();

        // 获取到设置为不显示的插件的列表
        $plugin_no_show=[];
        foreach ($plugin_show_list as  $value) {
            if($value['aps_is_show']==0)
                $plugin_no_show[]=trim($value['aps_plugin_id']);
        }
        $fee_plugin = array('kf','dt','yhyz','scyl','autoreply','mpj','mobilecheck');  //免费插件，zy 2019.5.25
        foreach ($menu as $key=> $val) {
           if($val['title']=='营销工具'){
                foreach ($val['submenu'] as $skey=> $s_menu) {
                    if(in_array($s_menu['plugin_name'], $plugin_no_show) && !in_array($s_menu['plugin_name'],$fee_plugin)){
                        $is_open=$plugin_model->getPluginOpenRow([
                            ['name'=>'apo_plugin_id','oper'=>'=','value'=>$s_menu['plugin_name']]
                        ]);
                        if(empty($is_open)||$is_open['apo_expire_time']<time())
                            unset($menu[$key]['submenu'][$skey]);
                    }
                }
                break;
           }
       }
       return $menu;
    }

    /*
     * 获取管理后台菜单类型：微信小程序wxapp；百度小程序bdapp
     */
    private function _fetch_menu_type(){
    	
        $menuType = $this->request->getStrParam('menuType');

        $redis_shop = new App_Model_Shop_RedisShopQueueStorage();

        if($menuType && in_array($menuType,array('wxapp','bdapp','aliapp','weixin','toutiao','qq','qihoo'))){
            plum_app_set_menu_type($menuType);
        }else{
            $menuType = plum_app_get_menu_type();
        }
        
        $this->menuType = $menuType;
        $this->output['menuType'] = $menuType;
    }

    public function authManagerPoser(){
        //获取小程序类别
        $kind   = intval($this->wxapp_cfg['ac_type']);
        if ($this->menuType=='bdapp'){
            $menu = plum_parse_config('menu_power', "bdmenu/xcx-".$kind);
        }elseif ($this->menuType=='aliapp'){
            $menu = plum_parse_config('menu_power', "alimenu/xcx-".$kind);
        }elseif ($this->menuType=='weixin'){
            $menu = plum_parse_config('menu_power', "weixinmenu/xcx-".$kind);
        }elseif ($this->menuType=='toutiao'){
            $menu = plum_parse_config('menu_power', "toutiaomenu/xcx-".$kind);
        }elseif ($this->menuType=='qq'){
            $menu = plum_parse_config('menu_power', "qqmenu/xcx-".$kind);
        }elseif ($this->menuType=='qihoo'){
            $menu = plum_parse_config('menu_power', "qihoomenu/xcx-".$kind);
        }else{
            $menu = plum_parse_config('menu_power', "wxmenu/xcx-".$kind);
        }
        if($this->manager['m_fid']){ // m_fid = 0 的为默认总管理员,分配所有权限
            // 获取当前权限
            $menu_arr       = $this->manager['m_fid'] && $this->manager['m_power'] ? unserialize($this->manager['m_power']):array();

            if(in_array($this->current_path_url,$menu)){ //判断 当前访问页面是否需要权限控制
                if(empty($menu_arr)){  // 未分配权限
                    $res = array(
                        'ec' => 400,
                        'em' => '暂未访问权限',
                    );
                }else{
                    if(!in_array($this->current_path_url,$menu_arr)){ //判断是否 分配 当前页面访问权限
                        $res = array(
                            'ec' => 400,
                            'em' => '暂未访问权限',
                        );
                    }
                }
            }
            if($res['ec'] == 400){
                // php 判断是否为 ajax 请求  http://www.cnblogs.com/sosoft/
                if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
                    // ajax 请求的处理方式
                    $this->displayJson($res,true);
                }else{
                    // 正常请求的处理方式
                    //plum_url_location('暂未访问权限');
                    $this->displayTipsPage('访问控制','暂无访问当前页面的权限');
                };
            }
        }
    }
    /*
     * 检查是否是被允许的域名
     */
    private function _check_allow_domain() {
        $in_domain  = plum_get_server('http_host');
        $domain_list= plum_parse_config('wxapp_in', 'wxxcx');
        //不在官方允许的域名列表中
        if (!in_array($in_domain, $domain_list)) {
            //在数据库中查找
            $oem_model  = new App_Model_Agent_MysqlAgentOemStorage();
            $allow_domain   = $oem_model->findOemByDomain($in_domain);
            //非代理商域名
            if (!$allow_domain) {
                $guide_domain   = "http://".current($domain_list);
                plum_redirect_with_msg("不被支持的域名", $guide_domain);
            }else{
                $this->output['oem'] = $allow_domain;
                $case_model  = new App_Model_Agent_MysqlAgentCaseStorage();
                $where = array();
                $where[] = array('name' => 'ac_aa_id', 'oper' => '=', 'value' => $allow_domain['ao_aa_id']);
                $where[] = array('name' => 'ac_deleted', 'oper' => '=', 'value' => 0);
                $sort  = array('ac_sort'=> 'ASC', 'ac_create_time'=>'DESC');
                $list    = $case_model->getList($where,0,0,$sort);
                $this->output['agentCase'] = $list;
            }
        }
    }

    /**
     * @param $output
     * 接收参数，并传递到前端页面
     */
    public function showOutput($output){
        if(is_array($output) && !empty($output)){
            foreach($output as $key => $val){
                $this->output[$key] = $val;
            }
        }
    }
    /**
     * 生成手机端外部访问链接
     * @param string $controller
     * @param string $action
     * @param array $params
     * @param bool $need_suid
     * @param string $snsapi_type 可选值,info/base/none
     * @return string
     */
    public function composeLink($controller, $action, $params = array(), $need_suid = true, $snsapi_type = 'base',$receiveType='') {
        $allow_type = array_keys(plum_parse_config('scope_type', 'weixin'));
        $type   = in_array($snsapi_type, $allow_type) ? $snsapi_type : 'base';
        $link   = $this->_get_access_host()."/mobile/{$controller}/{$action}";
        if($receiveType == 'ask'){
            $url = array();
            foreach ($params as $key => $val) {
                $url[] = "{$key}={$val}";
            }
            if ($need_suid) {
                $suid   = $this->shops[$this->curr_sid]['s_unique_id'];
                $url[]  = "suid=".$suid;
            }
            if ($snsapi_type != 'info') {
                $url[]  = "snsapi={$type}";
            }
            $link .= '?'.implode('&',$url);
        }else{
            foreach ($params as $key => $val) {
                $link .= "/{$key}/{$val}";
            }
            if ($need_suid) {
                $suid   = $this->shops[$this->curr_sid]['s_unique_id'];
                $link .= "/suid/".$suid;
            }
            if ($snsapi_type != 'info') {
                $link .= "/snsapi/{$type}";
            }
        }

        return $link;
    }
    /*
     * 获取可访问域名
     */
    private function _get_access_host() {
        $domain_model   = new App_Model_Shop_MysqlDomainStorage();
        $domain     = $domain_model->findDomainBySid($this->curr_sid);

        if (!$domain) {
            $domain     = 'http://'.plum_parse_config('shield_domain', 'weixin');
        } else {
            $domain     = 'http://'.$domain['sd_domain'];
        }
        return  $domain ? $domain : $this->response->responseHost();
    }
    /**
     * @param $cfg_key
     * 状态，类型显示，展示到前端
     */
    public function showTypeByKey($cfg_key,$type='app'){
        $type = plum_parse_config($cfg_key,$type);
        $show = array();
        foreach($type as $k=>$v){
            $show[$k] = array('label' => $v, 'css' => $this->bootstrap_button_color_type($k));
        }
        $this->output[$cfg_key]  = $show;
    }
    private function bootstrap_button_color_type($key){
        switch($key){
            case 0 :
                $color = 'danger';
                break;
            case 1 :
                $color = 'primary';
                break;
            case 2 :
                $color = 'warning';
                break;
            case 3 :
                $color = 'success';
                break;
            case 4 :
                $color = 'info';
                break;
            default:
                $color = 'default';
                break;
        }
        return $color;
    }
    //会员级别
    public function show_member_level_info($list,$pre='m_'){
        $data = array();
        if(!empty($list) && is_array($list) ){
            $ids = array();
            foreach($list as $val){
                for($i = 1;$i<=3;$i++){
                    if($val[$pre.$i.'f_id']){
                        $ids[] = $val[$pre.$i.'f_id'];
                    }
                }
            }
            if(!empty($ids)){
                $field = array('m_id','m_nickname');
                $where = array();
                $where[] = array('name'=>'m_id','oper'=>'in','value'=>$ids);
                $member_model = new App_Model_Member_MysqlMemberCoreStorage();
                $member = $member_model->getList($where,0,0,array(),$field);
                foreach($member as $item){
                    $data[$item['m_id']] = $item['m_nickname'];
                }
            }
        }
        return $data;
    }
    /*
     * 检查管理员是否登录
     */
    private function _check_user_login() {
        $uid    = plum_app_user_islogin();
        if (!$uid) {
            plum_redirect_with_msg('请登录', '/manage/user/index', 3);
        } else {
            $this->uid  = $uid;
            //获取管理员信息
            $manager_storage    = new App_Model_Member_MysqlManagerStorage();
            $this->manager      = $manager_storage->getRowById($uid);
            //获取公司信息
            $company_storage    = new App_Model_Member_MysqlCompanyCoreStorage();
            $this->company      = $company_storage->getRowById($this->manager['m_c_id']);
            //获取店铺信息
            $shop_storage       = new App_Model_Shop_MysqlShopCoreStorage();
            $where[]            = array('name' => 's_c_id', 'oper' => '=', 'value' => $this->company['c_id']);
            $this->shops        = $shop_storage->getList($where, 0, 0, array(), array(), true);//使用主键作为数组索引
            $this->shopIdArray  = array_keys($this->shops);//获取数组主键组成集合

            $this->_check_manager_login_time();
        }
    }

    private function _check_manager_login_time(){
        //判断登录时间是在修改密码前还是修改密码后
        $change_passwd_time = $this->manager['m_change_passwd_time'];
        if($change_passwd_time && $_SESSION['settime'] && $change_passwd_time > $_SESSION['settime']){
            //修改密码在登录之后
            plum_app_user_logout();
            plum_redirect_with_msg('请登录', '/manage/user/index', 3);
        }
    }

    /*
     * 校验店铺的唯一性id
     */
    protected function verifyShopUnique($suid) {
        foreach ($this->shops as $key => $val) {
            if ($suid == $val['s_unique_id']) {
                return $val;
            }
        }
        return false;
    }
    /*
     * 获取或设置当前正在管理的店铺
     */
    private function _fetch_current_manage_shop() {
        //首先判断外部获取是否成功
        $suid       = $this->request->getStrParam('select_suid', '');
        if(!$suid) $suid = $this->request->getStrParam('suid', '');
        $redis_shop = new App_Model_Shop_RedisShopQueueStorage();
        if ($suid && ($curr_shop = $this->verifyShopUnique($suid))) {
            $curr_sid = intval($curr_shop['s_id']);
        } else {
            $curr_sid   = $redis_shop->getSidByUid($this->uid);
        }
       $curr_sid = 0;
        //店铺ID获取不到时
        if (!$curr_sid) {
            //已创建过店铺
            if (count($this->shopIdArray) > 0) {
                $curr_sid   = current($this->shopIdArray);
            } else {
                //未创建店铺,创建一个默认店铺
                //@todo 增加一天免费试用时间,缴纳保证金后变为体验版
                $open_time      = time();
                $expire_time    = strtotime("+1 day", $open_time);
                $data = array(
                    's_unique_id' => plum_uniqid_base36(),
                    's_contact'   => $this->manager['m_mobile'],
                    's_phone'     => $this->manager['m_mobile'],
                    's_name'      => $this->company['c_name'],
                    's_type'      => 0,//自有店铺
                    's_c_id'      => $this->company['c_id'],
                    's_open_time'   => $open_time,
                    's_expire_time' => $expire_time,
                    's_createtime'  => time(),
                    's_status'      => App_Helper_ShopWeixin::SHOP_MANAGE_RUN,
                    's_version'     => App_Helper_ShopWeixin::SHOP_VERSION_MFB,//免费版
                );
                $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
                $ret = $shop_model->insertValue($data);
                $curr_sid   = $ret;
            }
        }
        $this->curr_sid = $curr_sid;
        //将当前店铺置于管理中
        $redis_shop->setSidWithUid($curr_sid, $this->uid);
        //记录最新活跃时间
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop_model->updateById(array('s_active_time' => time()), $curr_sid);
        //输出当前店铺信息
        $this->curr_shop            = $this->shops[$this->curr_sid];
        $this->output['curr_shop']  = $this->curr_shop;
        $message_storage = new App_Model_Shop_MysqlShopMessageStorage($this->curr_sid);
        // 社区团购合伙人相关
        $area_info=$this->get_area_manager();
        if($area_info){
            //社区团购合伙人 只展示属于自己的订单信息相关和审核结果信息
            if($area_info['m_area_type']=='C')
                $where[] = "(  
                        ((sm.sm_type = 1 OR sm.sm_type = 2 OR sm.sm_type = 4 ) AND asa.asa_city = {$area_info['m_area_id']})  OR
                        ((sm.sm_type = 10 OR sm.sm_type = 11) AND sm.sm_to_manager = {$area_info['m_id']})
                    )";
            else if($area_info['m_area_type']=='D')
                $where[] = "(  
                        ((sm.sm_type = 1 OR sm.sm_type = 2 OR sm.sm_type = 4 ) AND asa.asa_zone = {$area_info['m_area_id']})  OR
                        ((sm.sm_type = 10 OR sm.sm_type = 11) AND sm.sm_to_manager = {$area_info['m_id']})
                    )";
               // $need_show = [
               //     App_Helper_ShopMessage::SEQUENCE_REGION_GOODS_VERIFY,
               //     App_Helper_ShopMessage::SEQUENCE_REGION_COMMUNITY_VERIFY,
               //     App_Helper_ShopMessage::TRADE_HAD_PAY,
               //     App_Helper_ShopMessage::TRADE_RIGHTS,
               //     App_Helper_ShopMessage::REMIND_DELIVER,
               // ];
               // $where[] = ['name' => 'sm_type', 'oper' => 'in', 'value' => $need_show];

            $this->output['message_count'] = $message_storage->getNoReadMessageCountSeqregion($where);
        }else{
            //非合伙人登录 不显示审核结果信息
            $not_show = [
                App_Helper_ShopMessage::SEQUENCE_REGION_GOODS_VERIFY,
                App_Helper_ShopMessage::SEQUENCE_REGION_COMMUNITY_VERIFY
            ];
            $where[] = ['name' => 'sm_type', 'oper' => 'not in', 'value' => $not_show];
            $this->output['message_count'] = $message_storage->getNoReadMessageCount($where);
        }
    }


    private function get_area_manager(){
        $manager_model = new App_Model_Member_MysqlManagerStorage();
        $info=$manager_model->getSingleManagerWithArea($this->uid,$this->company['c_id']);
        if($info){
            return [
                'm_id'          =>$info['m_id'],
                'm_area_id'     =>$info['m_area_id'],
                'm_area_type'   =>$info['m_area_type'],
                'region_name'   =>$info['region_name'],
            ];
        }else{
            return null;
        }
    }

    /*
     * 检查当前小程序状态
     */
    private function _check_wxapp_status()
    {
        //获取当前店铺的小程序配置
        $applet_model = $this->_get_cfg_by_menutype($this->menuType,$this->curr_sid);
      	 Libs_Log_Logger::outputLog($this->curr_sid,'init.log');
        $applet     = $applet_model->findShopCfg();
      Libs_Log_Logger::outputLog($applet,'init.log');

        //记录最新活跃时间
        $applet_model->updateById(array('ac_active_time' => time()), $applet['ac_id']);
        if ($applet) {
            //已成功购买,且未到期
            if ($applet['ac_type'] && $applet['ac_expire_time'] > time()) {
                //判断微分销类型,并做跳转
                if ($applet['ac_type'] == 50) {
                    plum_redirect('/distrib/index');
                }
                $this->wxapp_cfg = $applet;
                $this->output['appletCfg'] = $applet;
                //查询当前模板制作教程
                $articleModel = new App_Model_Article_MysqlHelpStorage();
                $articleRow = $articleModel->getRowByType(13, $applet['ac_type']);
                $this->output['articleHref'] = $articleRow['ha_link'];

                return true;
            }else if($applet['ac_type'] && $applet['ac_expire_time'] < time()){
                $this->wxapp_cfg = $applet;
                $this->output['appletCfg'] = $applet;
                //查询当前模板制作教程
                $articleModel = new App_Model_Article_MysqlHelpStorage();
                $articleRow = $articleModel->getRowByType(13, $applet['ac_type']);
                $this->output['articleHref'] = $articleRow['ha_link'];
            }
        } else {
            //创建小程序配置
            $indata = array(
                'ac_s_id' => $this->curr_sid,
                'ac_type' => 0,//无类型
                'ac_open_time' => time(),
                'ac_expire_time' => 0,
                'ac_update_time' => time(),
            );
            $applet_model->insertValue($indata);
        }
        if($applet && $applet['ac_type'] && $applet['ac_expire_time'] < time()){
            $this->output['expireTip'] = '系统已到期小程序功能将无法使用，请及时联系服务商续费';
        }elseif ($applet && !$applet['ac_type']){
            plum_app_user_logout();
            plum_redirect_with_msg('请联系服务商订购小程序', '/manage/user/index', 3);
        }else{
            plum_app_user_logout();
            plum_redirect_with_msg('请联系服务商订购小程序', '/manage/user/index', 3);
        }
    }

    /**
     * 小程序案例
     */
    private function _get_wxapp_case(){
        //小程序案例
        $case   = plum_parse_config('case_help', 'applet');
        foreach ($case as $key => $item) {
            if ($key == $this->wxapp_cfg['ac_type']) {
                $case[$key]['used']  = true;
            }
        }
        $where   = array();
        $where[] = array('name' => 'ha_wxapp_id', 'oper' => '=', 'value' => $this->wxapp_cfg['ac_type']);
        $where[] = array('name' => 'ha_deleted', 'oper' => '=', 'value' => 0);
        $help_model = new App_Model_Article_MysqlHelpStorage();
        $sort    = array('cc_update_time' => 'DESC', 'cc_create_time' => 'DESC');
        $help    = $help_model->getRow($where);
        
        $where   = array();
        $where[] = array('name' => 'cc_type', 'oper' => '=', 'value' => $this->wxapp_cfg['ac_type']);
        $where[] = array('name' => 'cc_deleted', 'oper' => '=', 'value' => 0);
        $case_storage = new App_Model_Article_MysqlCustomCaseStorage();
        $sort    = array('cc_update_time' => 'DESC', 'cc_create_time' => 'DESC');
        $list    = $case_storage->getList($where, 0, 0, $sort);
        $this->output['help']       = $help;
        $this->output['caselist']   = $list;
    }

    /*
     * 检查当前小程序授权状态
     */
    private function _check_wxapp_auth() {
        //未授权将跳转到授权引导页面
        return true;
    }

    /*
     * 输出系统通知及公告信息
     */
    private function _output_system_notice() {
        //获取5条最新的系统通知
        $notice_model   = new App_Model_System_MysqlNoticeStorage();
        $notice     = $notice_model->fetchAppletList(0, 1, $this->wxapp_cfg['ac_type']);
        $this->output['sys_notice'] = $notice;
    }

    /*
     * 渲染左侧导航菜单
     */
    public function _renderSidebarNav() {
        //获取公用菜单部分
        $menu = plum_parse_config('menu', 'applet');
        //获取独立部分
        $applet = plum_parse_config('category', 'applet');
        $kind   = intval($this->wxapp_cfg['ac_type']);
        $menu   = array_merge($menu, $applet[$kind]['menu']);
        // 这里应该做一个判断判断被禁用的菜单是否可以进行访问
        $code = $this->_render_sidebar_menu_helper($menu);
        return $code;
    }
    /*
     * 渲染左侧导航菜单
     */
    public function renderSidebarNav() {
        //获取小程序类别
        if($this->menuType && $this->menuType=='bdapp'){
            $kind   = intval($this->wxapp_cfg['ac_type']);
            $menu   = plum_parse_config('menu', "bdmenu/xcx-".$kind);
        }else if($this->menuType && $this->menuType=='aliapp'){
            $kind   = intval($this->wxapp_cfg['ac_type']);
            $menu   = plum_parse_config('menu', "alimenu/xcx-".$kind);
        }else if($this->menuType && $this->menuType=='weixin'){
            $kind   = intval($this->wxapp_cfg['ac_type']);
            $menu   = plum_parse_config('menu', "weixinmenu/xcx-".$kind);
        } else if($this->menuType && $this->menuType=='toutiao'){
            $kind   = intval($this->wxapp_cfg['ac_type']);
            $menu   = plum_parse_config('menu', "toutiaomenu/xcx-".$kind);
        } else if($this->menuType && $this->menuType=='qq'){
            $kind   = intval($this->wxapp_cfg['ac_type']);
            $menu   = plum_parse_config('menu', "qqmenu/xcx-".$kind);
        } else if($this->menuType && $this->menuType=='qihoo'){
            $kind   = intval($this->wxapp_cfg['ac_type']);
            $menu   = plum_parse_config('menu', "qihoomenu/xcx-".$kind);
        }else{
            $kind   = intval($this->wxapp_cfg['ac_type']);
            $menu   = plum_parse_config('menu', "wxmenu/xcx-".$kind);

            if($this->wxapp_cfg['ac_s_id'] == 4230 || $this->wxapp_cfg['ac_s_id'] == 10380){
                $menu[8]['submenu'][] = [
                    'title'     => '发票申请',
                    'link'      => '/train/invoiceList',
                    'icon'      => 'fa-shopping-bag',
                    'access'    => 'order-invoiceList',
                ];
                $menu[5]['submenu'][] = [
                    'title'     => '报名管理',
                    'link'      => '/train/exchangeList',
                    'icon'      => 'icon-ok',
                    'access'    => 'order-exchangeList',
                ];
            }



        }

        if($this->curr_shop['s_broker_type'] && in_array($this->curr_shop['s_broker_type'],array(2,3))){
            $kind   = 1;
            $menu   = plum_parse_config('menu', "face/pay-".$kind);

        }

        if($this->menuType == 'toutiao' && in_array($this->wxapp_cfg['ac_type'],[21]) && $this->wxapp_cfg['ac_show_knowledge'] == 0){
            foreach ($menu as $mk => $mv){
                if($mv['access'] == 'knowledge-goods-cfg'){
                    unset($menu[$mk]);
                }
            }
        }



        if(!$this->manager['m_fid']){
            $manager_menu = plum_parse_config('manager_menu', 'applet');
            $menu   = array_merge($menu, $manager_menu);
        }

        $menu=$this->unsetHiddenPlugin($menu);
        //隐藏代理商关闭的功能菜单
        $menu = $this->_hide_agent_close_menu($menu);


        //社区团购合伙人 关闭合伙人团长管理权限 从权限数组中移除
        if($kind == 32 && $this->manager['m_area_status'] > 0){
            $seqcfg_model = new App_Model_Sequence_MysqlSequenceCfgStorage($this->curr_sid);
            $seqcfg = $seqcfg_model->findUpdateBySid();
            if($seqcfg && $seqcfg['asc_region_leader_open'] == 0){
                $this->manager['m_power'] = 'a:11:{i:0;s:11:"index-index";i:1;s:14:"sequence-trade";i:2;s:10:"trade-list";i:3;s:11:"refund-list";i:4;s:11:"verify-list";i:5;s:14:"sequence-goods";i:6;s:10:"goods-list";i:7;s:9:"goods-add";i:8;s:13:"sequence-area";i:9;s:9:"area-list";i:10;s:14:"community-list";}';
            }
        }


        $code   = $this->_render_sidebar_menu_helper($menu);
        return $code;
    }

    /*
     * 隐藏代理商关闭的功能菜单
     */
    private function _hide_agent_close_menu($menu){
        $close_cfg = $this->curr_shop['s_agent_close'] ? array_values(json_decode($this->curr_shop['s_agent_close'],1)) : [];
        if($close_cfg){
            $hide_links = [];
            foreach ($close_cfg as $cfg){
                if(isset($cfg['link']) && $cfg['val'] == 1){
                    $hide_links[] = $cfg['link'];
                }
            }
            if($hide_links){
                foreach ($menu as $key => $val){
                    if(in_array($val['link'],$hide_links)){
                        unset($menu[$key]);
                    }
                    if(is_array($val['submenu']) && !empty($val['submenu'])){
                        foreach ($val['submenu'] as $k => $v){
                            if(in_array($v['link'],$hide_links)){
                                unset($menu[$key]['submenu'][$k]);
                            }
                        }
                    }
                }
            }
        }
        return  $menu;
    }

    /*
     * 递归函数
     */
    private function _render_sidebar_menu_helper($menu) {
        $code = '';
        // 获取当前权限
        $menu_arr       = $this->manager['m_fid'] && $this->manager['m_power'] ? unserialize($this->manager['m_power']):array();

        foreach ($menu as $item) {
            // 判断是否分配权限
            if($item['ignore'] || (!empty($menu_arr) && !in_array($item['access'],$menu_arr))){
                continue;// 当没有权限时，跳出本次循环
            }

            $has_submenu    = isset($item['submenu']) && !empty($item['submenu']) && count($item['submenu']) > 0 ? true : false;

            $links = array();
            $secondLinks = array();
            $this->_fetch_menu_links($item, $links, $secondLinks);
            //$links = array_merge($links,$secondLinks);
            if (in_array($this->current_link, $links)) {
                $code .= '<li class="open active">';
            } else if ($this->current_link == $item['link'] || (isset($secondLinks[$item['link']]) && in_array($this->current_link, $secondLinks[$item['link']]))) {
                $code .= '<li class="active">';
            } else {
                $code .= '<li>';
            }

            if($item['menutype'] && $item['menutype']=='bdapp'){
                $code .= '<a '.($has_submenu ? 'class="dropdown-toggle"' : '').' href="/bdapp'.$item['link'].'">';
            }else if($item['menutype'] && $item['menutype']=='alixcx'){
                $code .= '<a '.($has_submenu ? 'class="dropdown-toggle"' : '').' href="/alixcx'.$item['link'].'">';
            } else if($item['menutype'] && $item['menutype']=='toutiao'){
                $code .= '<a '.($has_submenu ? 'class="dropdown-toggle"' : '').' href="/toutiao'.$item['link'].'">';
            } else if($item['menutype'] && $item['menutype']=='qq'){
                $code .= '<a '.($has_submenu ? 'class="dropdown-toggle"' : '').' href="/qq'.$item['link'].'">';
            } else if($item['menutype'] && $item['menutype']=='qihoo'){
                $code .= '<a '.($has_submenu ? 'class="dropdown-toggle"' : '').' href="/qihoo'.$item['link'].'">';
            }else{
                $code .= '<a '.($has_submenu ? 'class="dropdown-toggle"' : '').' href="/'.$this->link_prefix.$item['link'].'">';
            }
            $code .= '<i class="fa '.$item['icon'].'"></i>';
            if($item['new']){
                if($item['pay']){
                    $code .= '<span class="menu-text icon_pay"> '.'<b class="newtag">'.$item['title'].'</b>'.' </span>';
                }else{
                    $code .= '<span class="menu-text">'.'<b class="newtag">'.$item['title'].'</b>'.' </span>';
                }
            }else{
                if($item['pay']){
                    $code .= '<span class="menu-text icon_pay"> '.$item['title'].' </span>';
                }else{
                    $code .= '<span class="menu-text"> '.$item['title'].' </span>';
                }
            }
            $code .= $has_submenu ? '<b class="arrow icon-angle-down"></b>' : '';
            $code .= '</a>';

            if ($has_submenu) {
                $code .= '<ul class="submenu">';

                $code .= $this->_render_sidebar_menu_helper($item['submenu']);

                $code .= '</ul>';
            }
            $code .= '</li>';
        }
        return $code;
    }

    /*
     * 引用递归函数
     */
    private function _fetch_menu_links($menu, &$link, &$secondLinks ) {
        $has_submenu    = isset($menu['submenu']) &&
        !empty($menu['submenu']) &&
        count($menu['submenu']) > 0 ? true : false;

        if ($has_submenu) {
            foreach ($menu['submenu'] as $item) {
                $this->_fetch_menu_links($item, $link ,$secondLinks);
            }
        } else {
            $link[] = $menu['link'];
            //如果该菜单下有二级菜单（一般为插件）
            $secondMenu = plum_parse_config($menu['link'],'secondmenu');

            if(!empty($secondMenu) && is_array($secondMenu) && count($secondMenu) > 0){
                $link = array_merge($link,$secondMenu);
                $secondLinks[$menu['link']] = $secondMenu;
            }
        }
    }

    /**
     * @param array $breadcrumbs
     * 渲染面包屑
     */
    public function buildBreadcrumbs($breadcrumbs = array()) {
        $home   = array('title' => '管理首页', 'link' => '/' . $this->link_prefix);

        array_unshift($breadcrumbs, $home);
        $this->output['bread_crumbs']   = $breadcrumbs;
    }

    /**
     * @return bool|string
     * 授权回调前的预授权码
     */
    public function fetchWeixinPreAuthCode() {
        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage();
        $token  = $plat_storage->getCompAccessToken();

        $plat_cfg   = plum_parse_config('platform', 'weixin');

        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$token}";
        $params     = array('component_appid' => $plat_cfg['app_id']);

        $i = 0;
        do{
            $result     = Libs_Http_Client::post($req_url, json_encode($params));
            $result     = json_decode($result, true);
            $i++;
        } while (!$result && $i < 10);

        $callback   = $this->response->responseHost().'/wxapp/wechat/weixinauthuri';
        $auth_url   = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$plat_cfg['app_id']}&pre_auth_code={$result['pre_auth_code']}&redirect_uri={$callback}";

        return $auth_url;
    }


    /*
     * @return bool|string
     * 授权回调前的预授权码
     */
    public function fetchPreAuthCode($type = 'guide') {
        $platform_type  = $this->fetchPlatformType();
        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage($platform_type);
        $token  = $plat_storage->getCompAccessToken();

        $platform   = plum_parse_config('platform', 'wxxcx');
        $plat_cfg   = $platform[$platform_type];
        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$token}";
        $params     = array('component_appid' => $plat_cfg['app_id']);

        $i = 0;
        do{
            $result     = Libs_Http_Client::post($req_url, json_encode($params));
            $result     = json_decode($result, true);
            $i++;
        } while (!$result && $i < 10);
        if($type=='child'){
            $callback   = "http://www.tiandiantong.cn/wxapp/{$type}/authuri";
        }else{
            $callback   = $this->response->responseHost()."/wxapp/{$type}/authuri";
        }
        $auth_url   = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$plat_cfg['app_id']}&pre_auth_code={$result['pre_auth_code']}&redirect_uri={$callback}";
        //Libs_Log_Logger::outputLog($auth_url);
        return $auth_url;
    }

    /**
     * 获取模板的幻灯信息
     * tpl_id 模板ID
     */
    public function showShopTplSlide($tpl_id=3, $type=1){
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        $slide = $slide_model->fetchSlideShowList($tpl_id, $type);
        $json = array();
        foreach($slide as $key => $val){
            $json[] = array(
                'index'     => $key ,
                'imgsrc'    => $val['ss_path'],
                'link'      => $val['ss_link'],
                'articleId' => $val['ss_link'],
                'articleTitle' => $val['ss_article_title'],
                'type'         => $val['ss_link_type']

            );
        }
        $this->output['slide'] = json_encode($json);
    }

    /**
     * 获取首页模板分类导航
     */
    public function showShopTplShortcut($tpl_id=3){
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        $shortcut = $shortcut_model->fetchShortcutShowList($tpl_id);
        $json = array();
        foreach($shortcut as $key => $val){
            $json[] = array(
                'index'        => $val['ss_weight'] ,
                'title'        => $val['ss_name'],
                'imgsrc'       => $val['ss_icon'],
                'link'         => $val['ss_link'],
                'articleId'    => $val['ss_link'],
                'articleTitle' => $val['ss_article_title'],
                'type'          => $val['ss_link_type']
            );
        }
        $this->output['shortcut'] = json_encode($json);
    }

    /**
     * @param $tpl_id
     * @return bool
     * 保存模板幻灯
     */
    public function save_shop_slide($tpl_id, $type = 1){
        $slide = $this->request->getArrParam('slide');
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        if(!empty($slide)){
            $slide_list = $slide_model->fetchSlideShowList($tpl_id, $type);
            if(!empty($slide_list)){
                $del_id = array();
                foreach($slide_list as $val){
                    if(isset($slide[$val['ss_weight']])){  //存在这个位置的幻灯，更新
                        $set = array(
                            'ss_weight' => $slide[$val['ss_weight']]['index'],
                            'ss_link'   => $slide[$val['ss_weight']]['articleId'],
                            'ss_path'   => $slide[$val['ss_weight']]['imgsrc'],
                            'ss_article_title' => $slide[$val['ss_weight']]['articleTitle'],
                            'ss_type'   => $type
                        );
                        $up_ret = $slide_model->updateById($set,$val['ss_id']);
                        unset($slide[$val['ss_weight']]); //然后清理前端传过来的幻灯
                    }else{ //多余的删除
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $slide_where = array();
                    $slide_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $slide_model->deleteValue($slide_where);
                }

            }
            //新增的幻灯
            if(!empty($slide)){
                $insert = array();
                foreach($slide as $val){
                    $insert[] = " (NULL, {$this->curr_sid},  {$tpl_id}, {$type}, '{$val['articleId']}', '{$val['articleTitle']}', '{$val['imgsrc']}', '{$val['index']}', '1', '0', '".time()."')";
                }
                $ins_ret = $slide_model->insertBatch($insert);
            }
        }else{ //若不存在，则全部删除
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $where[] = array('name' => 'ss_type','oper' => '=' , 'value' => $type);
            $slide_model->deleteValue($where);
        }
        return true;
    }

    /**
     * 保存模板导航
     */
    public function save_shop_shortcut($tpl_id){
        $shortcut = $this->request->getArrParam('shortcut');
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList($tpl_id);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    if(isset($shortcut[$val['ss_weight']])){  //存在这个位置的快捷导航，更新
                        $set = array(
                            'ss_weight' => $shortcut[$val['ss_weight']]['index'],
                            'ss_name'   => $shortcut[$val['ss_weight']]['title'],
                            'ss_icon'   => $shortcut[$val['ss_weight']]['imgsrc'],
                            'ss_link'   => $shortcut[$val['ss_weight']]['articleId'],
                            'ss_article_title'   => $shortcut[$val['ss_weight']]['articleTitle'],
                        );
                        $up_ret = $shortcut_model->updateById($set,$val['ss_id']);
                        unset($shortcut[$val['ss_weight']]); //然后清理前端传过来的快捷导航
                    }else{ //多余的删除
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }

            //新增的快捷导航
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $val){
                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['title']}', '{$val['imgsrc']}', '{$val['articleId']}', '{$val['index']}','{$val['articleTitle']}', '0', '".time()."') ";
                }
                $ins_ret = $shortcut_model->insertBatch($insert);
            }
        }else{ //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $shortcut_model->deleteValue($where);
        }
    }

    /**
     * 新的保存模板导航
     */
    public function save_shop_shortcut_new($tpl_id){
        $shortcut = $this->request->getArrParam('shortcut');
        $shortcut_model = new App_Model_Shop_MysqlShopShortcutStorage($this->curr_sid);
        if(!empty($shortcut)){
            $shortcut_list = $shortcut_model->fetchShortcutShowList($tpl_id);
            if(!empty($shortcut_list)){
                $del_id = array();
                foreach($shortcut_list as $val){
                    if(isset($shortcut[$val['ss_weight']])){  //存在这个位置的快捷导航，更新
                        $set = array(
                            'ss_weight' => $shortcut[$val['ss_weight']]['index'],
                            'ss_name'   => $shortcut[$val['ss_weight']]['title'],
                            'ss_icon'   => $shortcut[$val['ss_weight']]['imgsrc'],
                            'ss_link_type' => $shortcut[$val['ss_weight']]['type'],
                            'ss_link'      => $shortcut[$val['ss_weight']]['link'],
                            'ss_article_title'   => $shortcut[$val['ss_weight']]['articleTitle'],
                        );
                        if($this->wxapp_cfg['ac_type'] == 16){//目前只有房产版需要此字段
                            $set['ss_show'] = isset($shortcut[$val['ss_weight']]['isshow']) && $shortcut[$val['ss_weight']]['isshow'] == 'true' ? 1 : 0;
                        }
                        $up_ret = $shortcut_model->updateById($set,$val['ss_id']);
                        unset($shortcut[$val['ss_weight']]); //然后清理前端传过来的快捷导航
                    }else{ //多余的删除
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $shortcut_where = array();
                    $shortcut_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $shortcut_model->deleteValue($shortcut_where);
                }

            }

            //新增的快捷导航
            if(!empty($shortcut)){
                $insert = array();
                foreach($shortcut as $val){
                    if($this->wxapp_cfg['ac_type'] == 16){
                        $isshow = isset($val['isshow']) && $val['isshow'] == 'true' ? 1 : 0;
                    }else{
                        $isshow = 1;
                    }

                    $insert[] =  " (NULL, '{$this->curr_sid}', {$tpl_id}, '{$val['title']}', '{$val['imgsrc']}', '{$val['link']}', '{$val['type']}','{$val['index']}','{$val['articleTitle']}', '{$isshow}','0', '".time()."') ";
                }
                $ins_ret = $shortcut_model->newInsertBatch($insert,true);
            }
        }else{ //若数组为空，则清空该店铺快捷导航
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $shortcut_model->deleteValue($where);
        }
    }

    /**
     * @param $tpl_id
     * @return bool
     * 新的保存模板幻灯（可以保存幻灯类型）
     */
    public function save_shop_slide_new($tpl_id, $type = 1 , $esId = 0){
        $slide = $this->request->getArrParam('slide');
        $slide_model = new App_Model_Shop_MysqlShopSlideStorage($this->curr_sid);
        if(!empty($slide)){
            $slide_list = $slide_model->fetchSlideShowList($tpl_id, $type);
            if(!empty($slide_list)){
                $del_id = array();
               
                foreach($slide_list as $val){
                    if(isset($slide[$val['ss_weight']])){  //存在这个位置的幻灯，更新
                        $set = array(
                            'ss_weight' => $slide[$val['ss_weight']]['index'],
                            'ss_link'   => $slide[$val['ss_weight']]['link'],
                            'ss_link_type'   => $slide[$val['ss_weight']]['type'],
                            'ss_path'   => $slide[$val['ss_weight']]['imgsrc'],
                            'ss_article_title' => $slide[$val['ss_weight']]['articleTitle'],
                            'ss_type'   => $type
                        );
                        $up_ret = $slide_model->updateById($set,$val['ss_id']);
                        unset($slide[$val['ss_weight']]); //然后清理前端传过来的幻灯
                    }else{ //多余的删除
                        $del_id[] = $val['ss_id'];
                    }
                }
                if(!empty($del_id)){
                    $slide_where = array();
                    $slide_where[] = array('name' => 'ss_id','oper' => 'in' , 'value' => $del_id);
                    $slide_model->deleteValue($slide_where);
                }

            }
            //新增的幻灯
            if(!empty($slide)){
                $insert = array();
                foreach($slide as $val){
                    $insert[] = " (NULL, {$this->curr_sid},  {$tpl_id}, {$type}, '{$val['link']}','{$val['type']}', '{$val['articleTitle']}', '{$val['imgsrc']}', '{$val['index']}', '1', '0', '".time()."')";
                }
                $ins_ret = $slide_model->newInsertBatch($insert);
            }
        }else{ //若不存在，则全部删除
            $where   = array();
            $where[] = array('name' => 'ss_s_id','oper' => '=' , 'value' => $this->curr_sid);
            $where[] = array('name' => 'ss_tpl_id','oper' => '=' , 'value' => $tpl_id);
            $where[] = array('name' => 'ss_type','oper' => '=' , 'value' => $type);
            $slide_model->deleteValue($where);
        }
        return true;
    }


    /**
     * @return bool|string
     * 授权回调前的预授权码
     */
    public function fetchWxAuthCode() {
        $plat_storage   = new App_Model_Auth_RedisWeixinPlatformStorage();
        $token  = $plat_storage->getCompAccessToken();

        $plat_cfg   = plum_parse_config('platform', 'weixin');

        $req_url    = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token={$token}";
        $params     = array('component_appid' => $plat_cfg['app_id']);

        $auth_domain    = plum_parse_config('wxcode_auth', 'wxxcx');
        $i = 0;
        do{
            $result     = Libs_Http_Client::post($req_url, json_encode($params));
            $result     = json_decode($result, true);
            $i++;
        } while (!$result && $i < 10);

        $callback   = $this->response->responseHost().'/wxapp/currency/authuri';
        $auth_url   = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$plat_cfg['app_id']}&pre_auth_code={$result['pre_auth_code']}&redirect_uri={$callback}";

        $return['authdomain'] = "http://".$auth_domain;
        //域名相同直接授权
        if ($auth_domain == plum_get_server('http_host')) {
            $return['authcode']   = $auth_url;
            $return['authtype']   = 'domain';
        } else {
            //获取预授权码
            $encode = array(
                'm_id'      => $this->manager['m_id'],
                'sid'       => $this->curr_sid,
                'suid'      => $this->curr_shop['s_unique_id'],
                'ac_id'     => $this->wxapp_cfg['ac_id'],
                'ac_type'   => $this->wxapp_cfg['ac_type'],
                'from'      => plum_get_base_host(),
                'domain'    => $auth_domain,
            );
            $encode = http_build_query($encode);
            $token  = plum_parse_config('encode_token', 'wxxcx');
            $code   = plum_authcode($encode, 'ENCODE', $token);
            $return['authcode'] = rawurlencode($code);
            $return['authtype']   = 'redirect';
        }

        return $return;
    }

    /*
     * 检查店铺营销工具是否可用
     */
    protected function checkToolUsable($plugin_id) {
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
        $row = $plugin_model->findUpdateBySid($plugin_id);
        if (!$row || $row['apo_expire_time']<time() || ($plugin_id == 'gdb' && $this->wxapp_cfg['ac_principal'] == '个人')) {
            $this->buildBreadcrumbs(array(
                array('title' => '应用订购', 'link' => '#'),
            ));
            $applet_plugin = plum_parse_config('plugin', 'wxmenu/xcx-' . $this->wxapp_cfg['ac_type']);
            if($plugin_id == 'anubis'){
                $post_model = new App_Model_Plugin_MysqlElePostCfgStorage();
                $post = $post_model->findRowByCity($this->company['c_city']);

                $baseCfg = plum_parse_config('base', 'ele');
                $grade = $post['epc_grade']?$post['epc_grade']:$post['epc_type'];
                $baseFee = $baseCfg[$grade?$grade:'代理城市'];
                $this->output['baseFee'] = $baseFee;
                $this->output['company'] = $this->company['c_city'];
            }
            $this->output['pluginId'] = $plugin_id;
            $this->output['tool'] = $applet_plugin[$plugin_id];
            $this->output['row'] = $row;
            $this->output['appletCfg'] = $this->wxapp_cfg;
            $this->displaySmarty("wxapp/plugin-tool.tpl");
            exit;
        }
        return true;
    }

    /*
     * 检查店铺营销工具是否可用 返回布尔型
     */
    protected function checkToolUsableBool($plugin_id) {
        $plugin_model = new App_Model_Applet_MysqlAppletPluginStorage($this->curr_sid);
        $row = $plugin_model->findUpdateBySid($plugin_id);
        if (!$row || $row['apo_expire_time']<time() || ($plugin_id == 'gdb' && $this->wxapp_cfg['ac_principal'] == '个人')) {
            return FALSE;
        }else{
            return TRUE;
        }
    }
    /*
     * 获取当前授权平台类型
     */
    public function fetchPlatformType() {
        $wcfg_storage   = new App_Model_Applet_MysqlCfgStorage($this->curr_sid);
        $wx_cfg     = $wcfg_storage->findShopCfg();

        $category       = plum_parse_config('category', 'applet');
        $applet_type    = intval($wx_cfg['ac_type']);
        $platform_type  = $category[$applet_type]['platform'];

        return $platform_type;
    }

    /**
     * 获取链接类型及列表以供使用
     */
    public function get_list_for_select(){
        $linkList = plum_parse_config('link','system');
        $linkType = plum_parse_config('link_type','system');
        $link = $linkList[$this->wxapp_cfg['ac_type']];
        $this->output['linkList'] = json_encode($link);
        $this->output['linkType'] = json_encode($linkType);
    }

    //查找已配置的跳转小程序以供选择
    protected function _get_jump_list($return = false){
        $where   = array();
        $data    = array();
        $where[] = array('name'=>'aj_s_id','oper'=>'=','value'=>$this->curr_sid);
        $sort = array('aj_sort'=>'DESC','aj_create_time'=>'DESC');
        $jump_storage = new App_Model_Applet_MysqlAppletJumpStorage();
        $list = $jump_storage->getList($where,0,0,$sort);
        if($list){
            foreach ($list as $val){
                $data[] = array(
                    'id' => $val['aj_id'],
                    'name' => $val['aj_name'],
                    'appid' => $val['aj_appid']
                );
            }
        }
        if($return){
            return $list;
        }else{
            $this->output['jumpList'] = json_encode($data);
            $this->output['jumpSelect'] = $data;
        }

    }

    public function __destruct(){
        $logid  = $GLOBALS['logid'];

        list($usec, $sec) = explode(" ", microtime());
        $use_time   = round(((float)$usec + (float)$sec) - (float)plum_get_server('REQUEST_TIME_FLOAT'), 4);

        $updata = array(
            'wd_for_id'     => $this->curr_sid,//店铺ID
            'wd_suid'       => $this->curr_shop['s_unique_id'],
            'wd_end_time'   => round(((float)$usec + (float)$sec), 4),
            'wd_use_time'   => $use_time,
        );

        $watch_model    = new App_Model_Watchdog_MysqlWatchDogStorage();
        $watch_model->updateById($updata, $logid);
    }

    /*
     * 检查功能是否被代理商关闭
     */
    public function checkAgentClose($key){
        $close = false;
//        $close_cfg = plum_parse_config('agent_close_cfg');
        $shop_model = new App_Model_Shop_MysqlShopCoreStorage();
        $shop = $shop_model->getRowById($this->curr_sid);
        $agent_close = $shop['s_agent_close'] ? json_decode($shop['s_agent_close'],1) : [];

        if($agent_close[$key]['val'] == 1){
            $close = true;
        }

        if($close){
            $this->displaySmarty("wxapp/agent-close-notice.tpl");
            exit;
        }

    }

    /**
     * @param $menuType
     * @param $sid
     * @param string $returnType
     * 根据不同的小程序类型返回对应小程序配置model
     * dn 2019.08.05
     */
    public function _get_cfg_by_menutype($menuType,$sid){
        if($menuType=='bdapp'){
            $applet_cfg = new App_Model_Baidu_MysqlBaiduCfgStorage($sid);
        }elseif($menuType=='aliapp'){
            $applet_cfg = new App_Model_Alixcx_MysqlAlixcxCfgStorage($sid);
        }elseif($menuType == 'toutiao'){
            $applet_cfg = new App_Model_Toutiao_MysqlToutiaoCfgStorage($sid);
        }elseif($menuType == 'weixin'){
            $applet_cfg = new App_Model_Weixin_MysqlWeixinCfgStorage($sid);
        }elseif($menuType == 'qq'){
            $applet_cfg = new App_Model_Qq_MysqlQqCfgStorage($sid);
        }elseif ($menuType == 'qihoo'){
            $applet_cfg = new App_Model_Qihoo_MysqlQihooCfgStorage($sid);
        }else{
            $applet_cfg = new App_Model_Applet_MysqlCfgStorage($sid);
        }
        return $applet_cfg;
    }

    //获取所有的门店作为筛选条件
    public function _get_offine_shop(){
        $store_model  = new App_Model_Store_MysqlStoreStorage($this->curr_sid);
        $list         = $store_model->getAllListBySid();
        $newArr       = array();
        foreach ($list as $key=>$val){
            $newArr[$val['os_id']] = $val['os_name'];
        }
        return $newArr;
    }
    //获取对应店铺已经绑定的code
    public function _get_offine_bind_code($osId=''){
        $cash_model   = new App_Model_Cash_MysqlBindRecordStorage($this->curr_sid);
        $where        = array();
        $where[]      = array('name'=>'cbr_s_id','oper'=>'=','value'=>$this->curr_sid);
        $where[]      = array('name'=>'cbr_bind_level','oper'=>'=','value'=>1);
        if($osId){
            $where[]      = array('name'=>'cbr_os_id','oper'=>'=','value'=>$osId);
        }
        $list         = $cash_model->getList($where,0,0,['cbr_bind_time'=>'desc'],array('cbr_id','cbr_bind_code','cbr_name'));
        $newArr       = array();
        foreach ($list as $key=>$val){
            $newArr[$val['cbr_id']] = array(
                'name' => $val['cbr_name'],
                'code' => $val['cbr_bind_code']
                );
        }
        return $newArr;
    }
    
        /**
     * 过滤被代理商关闭功能的链接
     *
     * @param array $path_data
     * @param array $type_data
     * @param array $type_data_new
     * @return array
     */
    protected function _filter_agent_close_path($path_data = [],$type_data = [],$type_data_new = []){
        $close_cfg = $this->curr_shop['s_agent_close'] ? json_decode($this->curr_shop['s_agent_close'],1) : [];
        $agent_close_cfg_path = plum_parse_config('agent_close_cfg_path');
        if($close_cfg){
            $close_path = [];
            $close_type = [];
            foreach ($close_cfg as $key => $value){
                if($value['val'] == 1){
                    $item = $agent_close_cfg_path[$key];
                    if(isset($item['path'])){
                        $close_path = array_merge($close_path,$item['path']);
                    }
                    if(isset($item['type'])){
                        $close_type = array_merge($close_type,$item['type']);
                    }
                }
            }
            if($path_data){
                foreach ($path_data as $pk => $pv){
                    $path = isset($pv['path']) ? $pv['path'] : '';
                    if(in_array($path,$close_path)){
                        unset($path_data[$pk]);
                    }
                }
                $path_data = array_values($path_data);
            }
            if($type_data){
                foreach ($type_data as $tk => $tv){
                    $type = isset($tv['id']) ? $tv['id'] : '';
                    if(in_array($type,$close_type)){
                        unset($type_data[$tk]);
                    }
                }
                $type_data = array_values($type_data);
            }
            if($type_data_new){
                foreach ($type_data_new as $tkn => $tvn){
                    $type = isset($tvn['id']) ? $tvn['id'] : '';
                    if(in_array($type,$close_type)){
                        unset($type_data_new[$tkn]);
                    }
                }
                $type_data_new = array_values($type_data_new);
            }
        }

        return [
            'pathData' => $path_data,
            'typeData' => $type_data,
            'typeDataNew' => $type_data_new
        ];

    }


    /*
     *
     */
//    private function _check_system_function(){
//
//    }

    /**
     * @return int
     * 判断知识付费相关内容是否显示
     */
    public function _check_knowledgepay_show(){
        if($this->menuType == 'toutiao' && in_array($this->wxapp_cfg['ac_type'],[21]) && $this->wxapp_cfg['ac_show_knowledge'] == 1){
            return 1;
        }else{
            return 0;
        }
    }
    
}